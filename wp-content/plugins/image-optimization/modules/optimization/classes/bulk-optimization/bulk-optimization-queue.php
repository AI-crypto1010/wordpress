<?php

namespace ImageOptimization\Modules\Optimization\Classes\Bulk_Optimization;

use ImageOptimization\Classes\Async_Operation\{
	Async_Operation,
	Async_Operation_Hook,
	Exceptions\Async_Operation_Exception,
	Queries\Image_Optimization_Operation_Query,
};

use ImageOptimization\Classes\Image\{
	Image_Meta,
	Image_Optimization_Error_Type,
	Image_Status,
	WP_Image_Meta,
	Exceptions\Invalid_Image_Exception,
};

use ImageOptimization\Classes\Logger;
use TypeError;

// @codeCoverageIgnoreStart
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
// @codeCoverageIgnoreEnd

final class Bulk_Optimization_Queue {
	private const OPTION_PREFIX = 'image_optimizer_bulk_queue_';
	private const MAX_RETRIES = 3;

	private const INITIAL_QUEUE_VALUE = [
		'operation_id' => null,
		'type' => null,
		'bulk_token' => null,
		'token_expires_at' => null,
		'max_batch_size' => null, // Maximum batch size that successfully obtained a token
		'images_optimized_with_current_token' => 0, // Counter for current token usage
		'created_at' => null,
		'status' => Bulk_Optimization_Queue_Status::PENDING,
		'images' => [], // Array of ['id' => int, 'status' => 'pending'|'completed'|'failed']
		'stats' => [
			'total' => 0,
			'completed' => 0,
			'failed' => 0,
			'pending' => 0,
		],
		'current_image_id' => null,
	];

	private string $type;
	private array $queue_data;

	public function get_operation_id(): ?string {
		if ( $this->exists() && empty( $this->queue_data['operation_id'] ) ) {
			$this->queue_data['operation_id'] = wp_generate_password( 10, false );
			$this->save();
		}

		return $this->queue_data['operation_id'];
	}

	public function get_type(): string {
		return $this->type;
	}

	public function get_bulk_token(): ?string {
		return $this->queue_data['bulk_token'];
	}

	public function get_status(): string {
		return $this->queue_data['status'];
	}

	public function get_images(): array {
		return $this->queue_data['images'];
	}

	public function get_image_ids(): array {
		return array_column( $this->queue_data['images'], 'id' );
	}

	public function get_images_by_status( string $status ): array {
		if ( ! in_array( $status, Bulk_Optimization_Queue_Status::get_values(), true ) ) {
			Logger::error( "Status $status is not a part of Bulk_Optimization_Queue_Status values" );

			throw new TypeError( esc_html( "Status $status is not a part of Bulk_Optimization_Queue_Status values" ) );
		}

		return array_filter(
			$this->queue_data['images'],
			function ( $image ) use ( $status ) {
				return $image['status'] === $status;
			}
		);
	}

	public function get_stats(): array {
		return $this->queue_data['stats'];
	}

	public function get_current_image_id(): ?int {
		return $this->queue_data['current_image_id'];
	}

	public function set_operation_id( string $id ): self {
		$this->queue_data['operation_id'] = $id;

		return $this;
	}

	public function set_bulk_token( string $token, int $expires_at, int $batch_size = null ): self {
		$this->queue_data['bulk_token'] = $token;
		$this->queue_data['token_expires_at'] = $expires_at;

		// Update max batch size if provided and larger than current
		if ( null !== $batch_size ) {
			if ( null === $this->queue_data['max_batch_size'] || $batch_size > $this->queue_data['max_batch_size'] ) {
				$this->queue_data['max_batch_size'] = $batch_size;
			}
		}

		// Reset counter when new token is set
		$this->queue_data['images_optimized_with_current_token'] = 0;

		return $this;
	}

	public function get_max_batch_size(): ?int {
		return $this->queue_data['max_batch_size'];
	}

	public function increment_optimized_counter(): self {
		$this->queue_data['images_optimized_with_current_token']++;

		return $this;
	}

	public function should_refresh_token(): bool {
		if ( $this->is_token_expiring_soon() ) {
			return true;
		}

		// Check if we've exhausted the current batch quota
		$max_batch = $this->queue_data['max_batch_size'];
		$optimized_count = $this->queue_data['images_optimized_with_current_token'];

		if ( null !== $max_batch && $optimized_count >= $max_batch ) {
			return true;
		}

		// Check if we have enough quota for the next pending image
		if ( null !== $max_batch ) {
			$next_image_id = $this->get_next_image();

			if ( $next_image_id ) {
				try {
					$wp_meta = new WP_Image_Meta( $next_image_id );
					$sizes_count = count( $wp_meta->get_size_keys() );
					$remaining_quota = $max_batch - $optimized_count;

					if ( $sizes_count > $remaining_quota ) {
						return true;
					}
				} catch ( Invalid_Image_Exception $e ) {
					// If we can't get image meta, continue with current token
					return false;
				}
			}
		}

		return false;
	}

	public function set_status( string $status ): self {
		if ( ! in_array( $status, Bulk_Optimization_Queue_Status::get_values(), true ) ) {
			Logger::error( "Status $status is not a part of Bulk_Optimization_Queue_Status values" );

			throw new TypeError( esc_html( "Status $status is not a part of Bulk_Optimization_Queue_Status values" ) );
		}

		$this->queue_data['status'] = $status;

		return $this;
	}

	public function set_current_image_id( ?int $id ): self {
		$this->queue_data['current_image_id'] = $id;

		return $this;
	}

	public function add_images( array $image_ids ): self {
		$existing_ids = array_column( $this->queue_data['images'], 'id' );

		foreach ( $image_ids as $image_id ) {
			if ( in_array( $image_id, $existing_ids, true ) ) {
				continue;
			}

			$this->queue_data['images'][] = [
				'id' => $image_id,
				'status' => Bulk_Optimization_Queue_Status::PENDING,
			];

			$existing_ids[] = $image_id;
		}

		$this->update_stats();

		return $this;
	}

	public function get_next_image(): ?int {
		$pending_images = $this->get_images_by_status( Bulk_Optimization_Queue_Status::PENDING );

		if ( empty( $pending_images ) ) {
			return null;
		}

		$first_image = reset( $pending_images );

		return $first_image['id'];
	}

	public function mark_image_completed( int $image_id ): self {
		foreach ( $this->queue_data['images'] as &$image ) {
			if ( $image['id'] === $image_id ) {
				$image['status'] = Bulk_Optimization_Queue_Status::COMPLETED;
				break;
			}
		}

		unset( $image );

		( new Image_Meta( $image_id ) )
			->set_retry_count( null )
			->save();

		$this->update_stats();

		return $this;
	}

	public function mark_image_failed( int $image_id ): self {
		$meta = new Image_Meta( $image_id );
		$retry_count = $meta->get_retry_count() ?? 0;
		$retry_count++;

		$is_reoptimization = Bulk_Optimization_Queue_Type::REOPTIMIZATION === $this->type;

		// Update Image_Meta with failure and increment retry count
		$meta->set_status(
			$is_reoptimization
				? Image_Status::REOPTIMIZING_FAILED
				: Image_Status::OPTIMIZATION_FAILED
		)
		->set_retry_count( $retry_count )
		->save();

		// Check if we should retry or mark as permanently failed
		if ( $retry_count >= self::MAX_RETRIES ) {
			// Mark as permanently failed in queue
			foreach ( $this->queue_data['images'] as &$image ) {
				if ( $image['id'] === $image_id ) {
					$image['status'] = Bulk_Optimization_Queue_Status::FAILED;
					break;
				}
			}
			unset( $image ); // Break the reference

			$meta
				->set_error_type( Image_Optimization_Error_Type::GENERIC )
				->save();
		}

		$this->update_stats();

		return $this;
	}

	public function is_empty(): bool {
		return empty( $this->queue_data['images'] );
	}

	public function has_more_images(): bool {
		return ! empty( $this->get_images_by_status( Bulk_Optimization_Queue_Status::PENDING ) );
	}

	public function is_token_expired(): bool {
		if ( ! $this->queue_data['token_expires_at'] ) {
			return true;
		}

		return time() >= $this->queue_data['token_expires_at'];
	}

	public function is_token_expiring_soon(): bool {
		$buffer_seconds = 5 * MINUTE_IN_SECONDS;

		if ( ! $this->queue_data['token_expires_at'] ) {
			return true;
		}

		return time() >= ( $this->queue_data['token_expires_at'] - $buffer_seconds );
	}

	public function save(): self {
		update_option( $this->get_option_name(), $this->queue_data, false );

		return $this;
	}

	public function delete(): bool {
		$this->cancel_scheduled_actions();

		return delete_option( $this->get_option_name() );
	}

	/**
	 * Cancels any scheduled actions associated with this queue.
	 */
	private function cancel_scheduled_actions(): void {
		$operation_id = $this->get_operation_id();

		if ( empty( $operation_id ) ) {
			return;
		}

		$hook = Bulk_Optimization_Queue_Type::OPTIMIZATION === $this->type
			? Async_Operation_Hook::OPTIMIZE_BULK
			: Async_Operation_Hook::REOPTIMIZE_BULK;

		$query = ( new Image_Optimization_Operation_Query() )
			->set_hook( $hook )
			->set_bulk_operation_id( $operation_id )
			->return_ids()
			->set_limit( -1 );

		try {
			$operation_ids = Async_Operation::get( $query );
			Async_Operation::remove( $operation_ids );
		} catch ( Async_Operation_Exception $aee ) {
			Logger::error( "Error while removing redundant actions for the operation `{$operation_id}`" );
		}
	}

	public function exists(): bool {
		return false !== get_option( $this->get_option_name(), false );
	}

	public function __construct( string $type ) {
		if ( ! in_array( $type, Bulk_Optimization_Queue_Type::get_values(), true ) ) {
			Logger::error( "Type $type is not a part of Bulk_Optimization_Queue_Type values" );

			throw new TypeError( esc_html( "Type $type is not a part of Bulk_Optimization_Queue_Type values" ) );
		}

		$this->type = $type;
		$this->query_queue();
	}

	private function query_queue(): void {
		$queue = get_option( $this->get_option_name(), false );
		$this->queue_data = $queue
			? array_replace_recursive( self::INITIAL_QUEUE_VALUE, $queue )
			: self::INITIAL_QUEUE_VALUE;

		if ( ! $this->queue_data['type'] ) {
			$this->queue_data['type'] = $this->type;
		}

		if ( ! $this->queue_data['created_at'] ) {
			$this->queue_data['created_at'] = time();
		}
	}

	private function get_option_name(): string {
		return self::OPTION_PREFIX . $this->type;
	}

	private function update_stats(): void {
		$completed = 0;
		$failed = 0;
		$pending = 0;

		foreach ( $this->queue_data['images'] as $image ) {
			switch ( $image['status'] ) {
				case Bulk_Optimization_Queue_Status::COMPLETED:
					$completed++;
					break;
				case Bulk_Optimization_Queue_Status::FAILED:
					$failed++;
					break;
				case Bulk_Optimization_Queue_Status::PENDING:
					$pending++;
					break;
			}
		}

		$this->queue_data['stats']['total'] = count( $this->queue_data['images'] );
		$this->queue_data['stats']['completed'] = $completed;
		$this->queue_data['stats']['failed'] = $failed;
		$this->queue_data['stats']['pending'] = $pending;
	}
}
