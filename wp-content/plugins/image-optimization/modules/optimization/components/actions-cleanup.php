<?php

namespace ImageOptimization\Modules\Optimization\Components;

use ImageOptimization\Classes\Async_Operation\{
	Async_Operation,
	Async_Operation_Hook,
	Async_Operation_Queue,
	Exceptions\Async_Operation_Exception,
	Queries\Image_Optimization_Operation_Query,
	Queries\Operation_Query
};

use ImageOptimization\Classes\Image\{
	Image_Meta,
	Image_Optimization_Error_Type,
	Image_Query_Builder,
	Image_Status,
};

use ImageOptimization\Classes\Logger;
use Throwable;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Actions_Cleanup {
	const FIVE_MINUTES_IN_SECONDS = 300;

	/**
	 * @async
	 * @return void
	 */
	public function cleanup_stuck_operations() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'actionscheduler_actions';
		$now = time();
		$threshold = $now - self::FIVE_MINUTES_IN_SECONDS;

		// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$results = $wpdb->get_col(
			$wpdb->prepare(
				"
				SELECT action_id
				FROM {$table_name}
				WHERE last_attempt_gmt IS NOT NULL
				  AND UNIX_TIMESTAMP(last_attempt_gmt) < %d
				",
				$threshold
			)
		);
		// phpcs:enable WordPress.DB.PreparedSQL.InterpolatedNotPrepared

		if ( empty( $results ) ) {
			Logger::debug( 'No stuck optimization operations found for cleanup.' );
			return;
		}

		foreach ( $results as $action_id ) {
			$action = Async_Operation::get_by_id( (int) $action_id );

			if (
				! $action ||
				Async_Operation_Queue::OPTIMIZE !== $action->get_queue() ||
				Async_Operation::OPERATION_STATUS_RUNNING !== $action->get_status()
			) {
				continue;
			}

			try {
				do_action(
					'action_scheduler_failed_action',
					$action_id,
					self::FIVE_MINUTES_IN_SECONDS
				);

				Logger::debug( "Triggered retry for stuck action ID {$action_id}." );
			} catch ( Throwable $t ) {
				Logger::warn( "Failed to handle stuck operation for action ID {$action_id}: " . $t->getMessage() );
			}
		}

		try {
			$this->cleanup_stuck_statuses();
		} catch ( Throwable $t ) {
			Logger::warn( 'Failed to run stuck statuses clearing job: ' . $t->getMessage() );
		}
	}

	/**
	 * The handler checks if there are any attachments that have the in-progress status, but no jobs are currently
	 * run or pending. Those attachment statuses will be updated to a generic error.
	 *
	 * @throws Async_Operation_Exception
	 */
	public function cleanup_stuck_statuses() {
		$operations_query = ( new Image_Optimization_Operation_Query() )
			->set_status( [ Async_Operation::OPERATION_STATUS_PENDING, Async_Operation::OPERATION_STATUS_RUNNING ] )
			->set_limit( 1 );

		$operations = Async_Operation::get( $operations_query );

		if ( ! empty( $operations ) ) {
			return;
		}

		$image_query = ( new Image_Query_Builder() )
			->return_optimization_in_progress_images()
			->set_paging_size( -1 )
			->execute();

		foreach ( $image_query->posts as $attachment_id ) {
			( new Image_Meta( $attachment_id ) )
				->set_status( Image_Status::OPTIMIZATION_FAILED )
				->set_error_type( Image_Optimization_Error_Type::GENERIC )
				->save();
		}
	}

	public function schedule_cleanup() {
		try {
			$cleanup_job_query = ( new Operation_Query() )
				->set_queue( Async_Operation_Queue::CLEANUP )
				->set_hook( Async_Operation_Hook::STUCK_OPERATION_CLEANUP )
				->set_status( [ Async_Operation::OPERATION_STATUS_PENDING, Async_Operation::OPERATION_STATUS_RUNNING ] )
				->set_limit( 1 );

			// Prevents job duplication. For some reason unique=true is not enough
			if ( ! empty( Async_Operation::get( $cleanup_job_query ) ) ) {
				return;
			}

			Async_Operation::create_recurring(
				time(),
				self::FIVE_MINUTES_IN_SECONDS,
				Async_Operation_Hook::STUCK_OPERATION_CLEANUP,
				[],
				Async_Operation_Queue::CLEANUP,
				10,
				true
			);
		} catch ( Async_Operation_Exception $aoe ) {
			Logger::warn( 'Failed to schedule recurring stuck operation cleanup: ' . $aoe->getMessage() );
		}
	}

	public function __construct() {
		add_action( 'action_scheduler_init', [ $this, 'schedule_cleanup' ] );
		add_action( Async_Operation_Hook::STUCK_OPERATION_CLEANUP, [ $this, 'cleanup_stuck_operations' ] );
	}
}
