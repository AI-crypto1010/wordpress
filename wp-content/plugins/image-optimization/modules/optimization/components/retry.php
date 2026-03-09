<?php

namespace ImageOptimization\Modules\Optimization\Components;

use ImageOptimization\Classes\Async_Operation\{
	Async_Operation,
	Async_Operation_Hook,
	Async_Operation_Queue,
	Exceptions\Async_Operation_Exception,
	Queries\Image_Optimization_Operation_Query,
};
use ImageOptimization\Classes\Image\{
	Image_Meta,
	Image_Optimization_Error_Type,
	Image_Status,
};

use ImageOptimization\Classes\Logger;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Retry {
	const RETRY_LIMIT = 3;
	const ONE_MINUTE_IN_SECONDS = 60;

	public static function maybe_retry_optimization( int $image_id ) {
		$query = ( new Image_Optimization_Operation_Query() )
			->set_image_id( $image_id )
			->set_status( Async_Operation::OPERATION_STATUS_RUNNING )
			->set_limit( 1 );

		try {
			[ $action ] = Async_Operation::get( $query );

			if ( ! $action ) {
				Logger::info( 'Could not find an action to retry for ' . $image_id );

				( new Image_Meta( $image_id ) )
					->set_status( Image_Status::OPTIMIZATION_FAILED )
					->set_error_type( Image_Optimization_Error_Type::GENERIC )
					->save();

				return;
			}

			// Unlikely timeout to separate force retries from the real timeout issues
			do_action( 'action_scheduler_failed_action', $action->get_id(), 1337 );
		} catch ( Async_Operation_Exception $aoe ) {
			Logger::error( "Failed to retry an optimization operation for `$image_id`: " . $aoe->getMessage() );
		}
	}

	public function retry_failed_optimizations( $action_id ) {
		$action = Async_Operation::get_by_id( (int) $action_id );

		// Ensure it's the optimization action we want to reschedule
		if ( Async_Operation_Queue::OPTIMIZE !== $action->get_queue() ) {
			return;
		}

		// Skip bulk operations
		$hook = $action->get_hook();

		if ( in_array( $hook, [
			Async_Operation_Hook::OPTIMIZE_BULK,
			Async_Operation_Hook::REOPTIMIZE_BULK,
		], true ) ) {
			Logger::info( "Skipping retry for bulk operation {$action_id}" );
			return;
		}

		Logger::info( "Optimization {$action_id} failed" );

		$attachment_id = isset( $action->get_args()['attachment_id'] ) ? (int) $action->get_args()['attachment_id'] : null;

		if ( ! $attachment_id ) {
			Logger::info( "Missing image ID in failed action {$action_id}" );

			return;
		}

		$image_meta = new Image_Meta( $attachment_id );
		$retry_count = $image_meta->get_retry_count() ?? 0;

		if ( $retry_count < self::RETRY_LIMIT ) {
			$image_meta
				->set_retry_count( $retry_count + 1 )
				->save();

			try {
				Async_Operation::create(
					$action->get_hook(),
					$action->get_args(),
					$action->get_queue(),
					time() + ( $retry_count * self::ONE_MINUTE_IN_SECONDS ),
				);

				Logger::debug(
					"Rescheduled image optimization for image ID {$attachment_id}. Retry attempt: " . ( $retry_count + 1 )
				);
			} catch ( Async_Operation_Exception $aoe ) {
				Logger::debug(
					"Failed to reschedule optimization for image ID {$attachment_id}: " . $aoe->getMessage()
				);
			}
		} else {
			$image_meta
				->set_status( Image_Status::OPTIMIZATION_FAILED )
				->set_retry_count( null )
				->save();

			Logger::debug( "Image optimization for image ID {$attachment_id} exceeded retry limit." );
		}
	}

	public function __construct() {
		add_action( 'action_scheduler_failed_action', [ $this, 'retry_failed_optimizations' ], 10, 2 );
	}
}
