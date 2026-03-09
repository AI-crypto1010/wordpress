<?php

namespace ImageOptimization\Modules\Optimization\Components;

use ImageOptimization\Classes\Async_Operation\{
	Async_Operation,
	Async_Operation_Hook,
	Async_Operation_Queue,
	Exceptions\Async_Operation_Exception,
};

use ImageOptimization\Modules\Optimization\Classes\Bulk_Optimization\{
	Bulk_Optimization_Queue,
	Bulk_Optimization_Queue_Type,
};

use ImageOptimization\Classes\Logger;
use Throwable;

// @codeCoverageIgnoreStart
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
// @codeCoverageIgnoreEnd

class Bulk_Operation_Recovery {
	/**
	 * Handle failed bulk operation and attempt to recover
	 *
	 * @param int $action_id The failed action ID
	 */
	public function handle_failed_bulk_operation( $action_id ) {
		try {
			$action = Async_Operation::get_by_id( (int) $action_id );
		} catch ( Async_Operation_Exception $aoe ) {
			Logger::error( "Failed to get bulk operation action {$action_id}: " . $aoe->getMessage() );
			return;
		}

		$hook = $action->get_hook();

		if ( ! in_array( $hook, [
			Async_Operation_Hook::OPTIMIZE_BULK,
			Async_Operation_Hook::REOPTIMIZE_BULK,
		], true ) ) {
			return;
		}

		$args = $action->get_args();
		$operation_id = $args['operation_id'] ?? null;

		if ( ! $operation_id ) {
			Logger::error( "Missing operation_id in failed bulk action {$action_id}" );
			return;
		}

		Logger::info( "Bulk operation {$action_id} failed for operation_id {$operation_id}" );

		$queue_type = Async_Operation_Hook::OPTIMIZE_BULK === $hook
			? Bulk_Optimization_Queue_Type::OPTIMIZATION
			: Bulk_Optimization_Queue_Type::REOPTIMIZATION;

		try {
			$queue = new Bulk_Optimization_Queue( $queue_type );

			if ( ! $queue->has_more_images() ) {
				Logger::info( "No more images to process for operation_id {$operation_id}, deleting queue" );

				$queue->delete();

				return;
			}

			Async_Operation::create(
				$hook,
				[ 'operation_id' => $operation_id ],
				Async_Operation_Queue::OPTIMIZE
			);

			Logger::info( "Recreated bulk operation for operation_id {$operation_id}" );

		} catch ( Throwable $t ) {
			Logger::error( "Failed to recover bulk operation {$operation_id}: " . $t->getMessage() );
		}
	}

	public function __construct() {
		add_action( 'action_scheduler_failed_action', [ $this, 'handle_failed_bulk_operation' ], 5, 2 );
	}
}
