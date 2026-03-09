<?php

namespace ImageOptimization\Modules\Optimization\Classes\Bulk_Optimization;

use ImageOptimization\Classes\Async_Operation\{
	Async_Operation,
	Async_Operation_Hook,
	Async_Operation_Queue,
	Exceptions\Async_Operation_Exception,
	Queries\Image_Optimization_Operation_Query
};
use ImageOptimization\Classes\Image\{
	Exceptions\Invalid_Image_Exception,
	Image,
	Image_Meta,
	Image_Optimization_Error_Type,
	Image_Query_Builder,
	Image_Status
};
use ImageOptimization\Classes\Exceptions\Quota_Exceeded_Error;
use ImageOptimization\Classes\Logger;
use ImageOptimization\Modules\Stats\Classes\Optimization_Stats;
use Throwable;

// @codeCoverageIgnoreStart
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
// @codeCoverageIgnoreEnd

final class Bulk_Optimization_Controller {
	/**
	 * Cancels pending bulk optimization operations.
	 *
	 * @return void
	 * @throws Async_Operation_Exception
	 */
	public static function delete_bulk_optimization(): void {
		$queue = new Bulk_Optimization_Queue( Bulk_Optimization_Queue_Type::OPTIMIZATION );

		if ( $queue->exists() ) {
			foreach ( $queue->get_image_ids() as $image_id ) {
				$meta = new Image_Meta( $image_id );
				$status = $meta->get_status();

				if ( Image_Status::OPTIMIZATION_IN_PROGRESS === $status ) {
					$meta->delete();
				}
			}

			$queue->delete();
		}

		$query = ( new Image_Optimization_Operation_Query() )
			->set_hook( Async_Operation_Hook::OPTIMIZE_BULK )
			->set_status( [ Async_Operation::OPERATION_STATUS_PENDING, Async_Operation::OPERATION_STATUS_RUNNING ] )
			->set_limit( 1 );

		$operation = Async_Operation::get( $query );

		if ( ! empty( $operation ) ) {
			Async_Operation::remove( [ $operation[0]->get_id() ] );
		}
	}

	/**
	 * Creates a queue for bulk optimization and schedules the processor.
	 *
	 * @return void
	 * @throws Quota_Exceeded_Error|Invalid_Image_Exception|Async_Operation_Exception
	 */
	public static function create_optimization_queue(): void {
		$images = Bulk_Optimization_Image_Query::find_images(
			( new Image_Query_Builder() )
				->return_not_optimized_images(),
			true
		);

		Logger::debug( 'Non-optimized images found: ' . $images['total_images_count'] );

		if ( ! $images['total_images_count'] ) {
			$not_fully_optimized_images = Bulk_Optimization_Image_Query::find_images(
				Bulk_Optimization_Image_Query::query_not_fully_optimized_images(),
				true
			);

			Logger::debug( 'Non fully optimized images found: ' . $images['total_images_count'] );

			if ( ! $not_fully_optimized_images['total_images_count'] ) {
				Logger::debug( 'Bulk optimization not started' );

				return;
			}

			$images = $not_fully_optimized_images;
		}

		$token_data = Bulk_Optimization_Token_Manager::obtain_token( $images['total_images_count'] );
		$queue = new Bulk_Optimization_Queue( Bulk_Optimization_Queue_Type::OPTIMIZATION );

		Logger::debug( "Bulk token obtained for {$token_data['batch_size']} images" );

		$queue
			->set_bulk_token(
				$token_data['token'],
				time() + HOUR_IN_SECONDS,
				$token_data['batch_size']
			)
			->set_status( Bulk_Optimization_Queue_Status::PROCESSING )
			->add_images( $images['attachments_in_quota'] )
			->save();

		Logger::info( "New queue {$queue->get_operation_id()} created" );

		Async_Operation::create(
			Async_Operation_Hook::OPTIMIZE_BULK,
			[ 'operation_id' => $queue->get_operation_id() ],
			Async_Operation_Queue::OPTIMIZE
		);

		Logger::debug( 'Async operation created' );

		foreach ( $images['attachments_in_quota'] as $image_id ) {
			( new Image_Meta( $image_id ) )
				->set_status( Image_Status::OPTIMIZATION_IN_PROGRESS )
				->set_retry_count( 0 )
				->set_error_type( null )
				->save();
		}
	}

	/**
	 * Creates a queue for bulk reoptimization and schedules the processor.
	 *
	 * @return void
	 * @throws Quota_Exceeded_Error|Invalid_Image_Exception|Async_Operation_Exception
	 */
	public static function create_reoptimization_queue(): void {
		$images = Bulk_Optimization_Image_Query::find_images(
			( new Image_Query_Builder() )
				->return_optimized_images()
		);

		if ( ! $images['total_images_count'] ) {
			return;
		}

		$token_data = Bulk_Optimization_Token_Manager::obtain_token( $images['total_images_count'] );
		$queue = new Bulk_Optimization_Queue( Bulk_Optimization_Queue_Type::REOPTIMIZATION );

		$queue
			->set_bulk_token(
				$token_data['token'],
				time() + HOUR_IN_SECONDS,
				$token_data['batch_size']
			)
			->set_status( Bulk_Optimization_Queue_Status::PROCESSING )
			->add_images( $images['attachments_in_quota'] )
			->save();

		Async_Operation::create(
			Async_Operation_Hook::REOPTIMIZE_BULK,
			[ 'operation_id' => $queue->get_operation_id() ],
			Async_Operation_Queue::OPTIMIZE
		);

		foreach ( $images['attachments_in_quota'] as $image_id ) {
			( new Image_Meta( $image_id ) )
				->set_status( Image_Status::REOPTIMIZING_IN_PROGRESS )
				->set_retry_count( 0 )
				->set_error_type( null )
				->save();
		}

		// Handle images out of quota
		foreach ( $images['attachments_out_of_quota'] as $image_id ) {
			( new Image_Meta( $image_id ) )
				->set_status( Image_Status::REOPTIMIZING_FAILED )
				->set_error_type( Image_Optimization_Error_Type::QUOTA_EXCEEDED )
				->save();
		}
	}

	/**
	 * Checks if there is a bulk optimization operation in progress.
	 * If there is at least a single active bulk optimization operation it returns true, otherwise false.
	 *
	 * @return bool
	 */
	public static function is_optimization_in_progress(): bool {
		$queue = new Bulk_Optimization_Queue( Bulk_Optimization_Queue_Type::OPTIMIZATION );

		return $queue->exists() && Bulk_Optimization_Queue_Status::PROCESSING === $queue->get_status();
	}

	/**
	 * Checks if there is a bulk re-optimization operation in progress.
	 * If there is at least a single active bulk re-optimization operation it returns true, otherwise false.
	 *
	 * @return bool
	 */
	public static function is_reoptimization_in_progress(): bool {
		$queue = new Bulk_Optimization_Queue( Bulk_Optimization_Queue_Type::REOPTIMIZATION );

		return $queue->exists() && Bulk_Optimization_Queue_Status::PROCESSING === $queue->get_status();
	}

	/**
	 * Retrieves the bulk optimization process status.
	 *
	 * @return array{status: string, stats: array}
	 */
	public static function get_status(): array {
		$stats = Optimization_Stats::get_image_stats();

		$percentage = 0;
		if ( $stats['total_image_count'] > 0 ) {
			$percentage = round( $stats['optimized_image_count'] / $stats['total_image_count'] * 100 );
		}

		$output = [
			'status' => 'not-started',
			'percentage' => $percentage,
		];

		$queue = new Bulk_Optimization_Queue( Bulk_Optimization_Queue_Type::OPTIMIZATION );

		if ( ! $queue->exists() ) {
			return $output;
		}

		$output['status'] = 'in-progress';

		return $output;
	}

	/**
	 * Returns latest operations for the bulk optimization screen.
	 *
	 * @return array
	 */
	public static function get_processed_images(): array {
		$output = [];
		$queue = new Bulk_Optimization_Queue( Bulk_Optimization_Queue_Type::OPTIMIZATION );

		if ( ! $queue->exists() ) {
			return $output;
		}

		$images = $queue->get_images();
		$images = array_slice( $images, 0, 50 );

		foreach ( $images as $queue_image ) {
			$image_id = $queue_image['id'];

			try {
				$image = new Image( $image_id );
				$stats = Optimization_Stats::get_image_stats( $image_id );
			} catch ( Throwable $t ) {
				continue;
			}

			$meta = new Image_Meta( $image_id );

			$output[] = [
				'id' => $image_id,
				'status' => $meta->get_status(),
				'image_name' => $image->get_attachment_object()->post_title,
				'image_id' => $image_id,
				'thumbnail_url' => $image->get_url( 'thumbnail' ),
				'original_file_size' => $stats['initial_image_size'],
				'current_file_size' => $stats['current_image_size'],
			];
		}

		return $output;
	}
}
