<?php

namespace ImageOptimization\Modules\Optimization\Components;

use ImageOptimization\Classes\Async_Operation\{
	Async_Operation,
	Async_Operation_Hook,
	Async_Operation_Queue,
};

use ImageOptimization\Classes\Image\{
	Image_Meta,
	Image_Status
};

use ImageOptimization\Modules\Optimization\{
	Classes\Exceptions\Bulk_Token_Expired_Error,
	Classes\Optimize_Image,
	Classes\Bulk_Optimization\Bulk_Optimization_Queue,
	Classes\Bulk_Optimization\Bulk_Optimization_Queue_Status,
	Classes\Bulk_Optimization\Bulk_Optimization_Queue_Type,
	Classes\Bulk_Optimization\Bulk_Optimization_Token_Manager,
};

use ImageOptimization\Classes\Logger;
use ImageOptimization\Classes\Utils;
use ImageOptimization\Classes\Exceptions\Quota_Exceeded_Error;
use Throwable;

// @codeCoverageIgnoreStart
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
// @codeCoverageIgnoreEnd

class Bulk_Optimization {
	/** @async */
	public function optimize_bulk() {
		$queue = new Bulk_Optimization_Queue( Bulk_Optimization_Queue_Type::OPTIMIZATION );

		if ( ! $queue->exists() ) {
			Logger::debug( 'Bulk optimization queue did not found' );

			return;
		}

		if ( ! $queue->has_more_images() ) {
			Logger::debug( 'No more pending images, deleting queue' );
			$queue->delete();

			return;
		}

		if ( $queue->should_refresh_token() ) {
			Logger::debug( 'Refreshing bulk token' );

			try {
				$token_data = Bulk_Optimization_Token_Manager::obtain_token(
					$queue->get_stats()[ Bulk_Optimization_Queue_Status::PENDING ],
					$queue->get_max_batch_size()
				);

				$queue
					->set_bulk_token(
						$token_data['token'],
						time() + HOUR_IN_SECONDS,
						$token_data['batch_size']
					)
					->save();
			} catch ( Throwable $t ) {
				Logger::info( 'Failed to obtain a bulk token: ' . $t->getMessage() );

				foreach ( $queue->get_images_by_status( Bulk_Optimization_Queue_Status::PENDING ) as $image ) {
					( new Image_Meta( $image['id'] ) )
						->set_status( Image_Status::NOT_OPTIMIZED )
						->save();
				}

				$queue->delete();

				return;
			}
		}

		$image_id = $queue->get_next_image();

		Logger::debug( 'Processing image: ' . $image_id );

		if ( ! $image_id ) {
			Logger::debug( 'No image to process, deleting queue' );
			$queue->delete();

			return;
		}

		$queue
			->set_current_image_id( $image_id )
			->save();

		try {
			$oi = new Optimize_Image(
				$image_id,
				'bulk',
				$queue->get_bulk_token()
			);

			$oi->optimize();

			$queue
				->mark_image_completed( $image_id )
				->increment_optimized_counter()
				->save();

		} catch ( Bulk_Token_Expired_Error $btee ) {
			$queue->mark_image_failed( $image_id )->save();

			Logger::info( "Token expired while optimizing image {$image_id}" );
		} catch ( Quota_Exceeded_Error $qee ) {
			$queue->mark_image_failed( $image_id )->save();

			Logger::info( "Quota exceeded while optimizing image {$image_id}" );
		} catch ( Throwable $e ) {
			$queue->mark_image_failed( $image_id )->save();

			Logger::info( "Failed to optimize image {$image_id}: " . $e->getMessage() );
		}

		$queue
			->set_current_image_id( null )
			->save();

		try {
			if ( $queue->has_more_images() ) {
				Async_Operation::create(
					Async_Operation_Hook::OPTIMIZE_BULK,
					[ 'operation_id' => $queue->get_operation_id() ],
					Async_Operation_Queue::OPTIMIZE
				);

				Logger::debug( 'Async operation created' );
			} else {
				Logger::debug( 'All images were optimized, deleting queue' );

				$queue->delete();
			}
		} catch ( Throwable $t ) {
			Logger::error( 'Failed to create next async operation or delete queue: ' . $t->getMessage() );
		}
	}

	/** @async */
	public function reoptimize_bulk() {
		$queue = new Bulk_Optimization_Queue( Bulk_Optimization_Queue_Type::REOPTIMIZATION );

		if ( ! $queue->exists() ) {
			return;
		}

		if ( ! $queue->has_more_images() ) {
			$queue->delete();

			return;
		}

		if ( $queue->should_refresh_token() ) {
			try {
				$token_data = Bulk_Optimization_Token_Manager::obtain_token(
					$queue->get_stats()[ Bulk_Optimization_Queue_Status::PENDING ],
					$queue->get_max_batch_size()
				);

				$queue
					->set_bulk_token(
						$token_data['token'],
						time() + HOUR_IN_SECONDS,
						$token_data['batch_size']
					)
					->save();
			} catch ( Throwable $t ) {
				Logger::info( 'Failed to obtain bulk token: ' . $t->getMessage() );

				foreach ( $queue->get_images_by_status( Bulk_Optimization_Queue_Status::PENDING ) as $image ) {
					( new Image_Meta( $image['id'] ) )
						->set_status( Image_Status::OPTIMIZATION_FAILED )
						->save();
				}

				$queue->delete();

				return;
			}
		}

		$image_id = $queue->get_next_image();

		if ( ! $image_id ) {
			$queue
				->set_status( Bulk_Optimization_Queue_Status::COMPLETED )
				->save();

			return;
		}

		$queue
			->set_current_image_id( $image_id )
			->save();

		try {
			$oi = new Optimize_Image(
				$image_id,
				'bulk-reoptimize',
				$queue->get_bulk_token(),
				true
			);

			$oi->optimize();

			$queue
				->mark_image_completed( $image_id )
				->increment_optimized_counter()
				->save();

		} catch ( Bulk_Token_Expired_Error $btee ) {
			$queue->mark_image_failed( $image_id )->save();

			Logger::info( "Token expired while reoptimizing image {$image_id}" );
		} catch ( Quota_Exceeded_Error $qee ) {
			$queue->mark_image_failed( $image_id )->save();

			foreach ( $queue->get_images_by_status( Bulk_Optimization_Queue_Status::PENDING ) as $image ) {
				( new Image_Meta( $image['id'] ) )
					->set_status( Image_Status::OPTIMIZATION_FAILED )
					->save();
			}

			$queue->delete();

			Logger::info( "Quota exceeded while reoptimizing image {$image_id}" );

			return;
		} catch ( Throwable $e ) {
			$queue->mark_image_failed( $image_id )->save();

			Logger::info( "Failed to reoptimize image {$image_id}: " . $e->getMessage() );
		}

		$queue
			->set_current_image_id( null )
			->save();

		try {
			if ( $queue->has_more_images() ) {
				Async_Operation::create(
					Async_Operation_Hook::REOPTIMIZE_BULK,
					[ 'operation_id' => $queue->get_operation_id() ],
					Async_Operation_Queue::OPTIMIZE
				);
			} else {
				$queue->delete();
			}
		} catch ( Throwable $t ) {
			Logger::error( 'Failed to create next async operation or delete queue: ' . $t->getMessage() );
		}
	}

	/**
	 * Renders the bulk optimization notice
	 *
	 * @return void
	 */
	public function render_bulk_optimization_notice() {
		$queue = new Bulk_Optimization_Queue( Bulk_Optimization_Queue_Type::OPTIMIZATION );
		$is_in_progress = $queue->exists();
		?>
		<div class="notice notice-info notice image-optimizer__notice image-optimizer__notice--info image-optimizer__notice--bulk-tip"
				style="display: <?php echo $is_in_progress ? 'block' : 'none'; ?>">
			<p>
				<b>
					<?php esc_html_e(
						'Heads up!',
						'image-optimization'
					); ?>
				</b>

				<span>
					<?php esc_html_e(
						'Bulk optimizing may take a lot of processing and server time, depending on the number of images. Your site will still work smoothly until the processing is all done, without any downtime.',
						'image-optimization'
					); ?>
				</span>
			</p>
		</div>
		<?php
	}

	public function __construct() {
		add_action( Async_Operation_Hook::OPTIMIZE_BULK, [ $this, 'optimize_bulk' ] );
		add_action( Async_Operation_Hook::REOPTIMIZE_BULK, [ $this, 'reoptimize_bulk' ] );

		add_action( 'current_screen', function () {
			if ( Utils::is_bulk_optimization_page() ) {
				add_filter( 'admin_footer_text', [ $this, 'render_bulk_optimization_notice' ] );
			}
		} );
	}
}
