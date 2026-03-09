<?php

namespace ImageOptimization\Classes\Async_Operation;

use ActionScheduler;
use ImageOptimization\Classes\Async_Operation\{
	Exceptions\Async_Operation_Exception,
	Interfaces\Operation_Query_Interface
};
use ImageOptimization\Classes\Logger;
use Throwable;
use TypeError;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Async_Operation {
	public const OPERATION_STATUS_NOT_STARTED = 'not-started';
	public const OPERATION_STATUS_COMPLETE = 'complete';
	public const OPERATION_STATUS_PENDING  = 'pending';
	public const OPERATION_STATUS_RUNNING  = 'in-progress';
	public const OPERATION_STATUS_FAILED   = 'failed';
	public const OPERATION_STATUS_CANCELED = 'canceled';

	/**
	 * @throws Async_Operation_Exception
	 */
	public static function create( string $hook, array $args, string $queue, int $priority = 10, $unique = false ): int {
		self::check_library_is_registered();

		if ( ! in_array( $hook, Async_Operation_Hook::get_values(), true ) ) {
			Logger::log( Logger::LEVEL_ERROR, "Hook $hook is not a part of Async_Operation_Hook values" );

			throw new TypeError( esc_html( "Hook $hook is not a part of Async_Operation_Hook values" ) );
		}

		if ( ! in_array( $queue, Async_Operation_Queue::get_values(), true ) ) {
			Logger::log( Logger::LEVEL_ERROR, "Queue $queue is not a part of Async_Operation_Queue values" );

			throw new TypeError( esc_html( "Queue $queue is not a part of Async_Operation_Queue values" ) );
		}

		return as_enqueue_async_action(
			$hook,
			$args,
			$queue,
			$unique,
			$priority
		);
	}

	public static function create_recurring( int $timestamp, int $interval_in_seconds, string $hook, array $args, string $queue, int $priority = 10, $unique = false ): int {
		self::check_library_is_registered();

		if ( ! in_array( $hook, Async_Operation_Hook::get_values(), true ) ) {
			Logger::log( Logger::LEVEL_ERROR, "Hook $hook is not a part of Async_Operation_Hook values" );

			throw new TypeError( esc_html( "Hook $hook is not a part of Async_Operation_Hook values" ) );
		}

		if ( ! in_array( $queue, Async_Operation_Queue::get_values(), true ) ) {
			Logger::log( Logger::LEVEL_ERROR, "Queue $queue is not a part of Async_Operation_Queue values" );

			throw new TypeError( esc_html( "Queue $queue is not a part of Async_Operation_Queue values" ) );
		}

		return as_schedule_recurring_action(
			$timestamp,
			$interval_in_seconds,
			$hook,
			$args,
			$queue,
			$unique,
			$priority
		);
	}

	/**
	 * @param Operation_Query_Interface $query
	 *
	 * @return Async_Operation_Item[]|int[]
	 * @throws Async_Operation_Exception
	 */
	public static function get( Operation_Query_Interface $query ): array {
		self::check_library_is_registered();

		$actions = [];

		$store = ActionScheduler::store();
		$logger = ActionScheduler::logger();

		$action_ids = $store->query_actions( $query->get_query() );

		if ( 'ids' === $query->get_return_type() ) {
			return $action_ids ?? [];
		}

		foreach ( $action_ids as $action_id ) {
			try {
				$action = $store->fetch_action( $action_id );
			} catch ( Throwable $t ) {
				Logger::log(
					Logger::LEVEL_ERROR,
					"Unable to fetch an action `$action_id`. Reason: " . $t->getMessage()
				);

				continue;
			}

			if ( is_a( $action, 'ActionScheduler_NullAction' ) ) {
				Logger::log(
					Logger::LEVEL_WARN,
					'ActionScheduler_NullAction found'
				);

				continue;
			}

			$item = new Async_Operation_Item();

			$actions[] = $item->set_id( $action_id )
				->set_hook( $action->get_hook() )
				->set_status( $store->get_status( $action_id ) )
				->set_args( $action->get_args() )
				->set_queue( $action->get_group() )
				->set_date( $store->get_date( $action_id ) )
				->set_logs( $logger->get_logs( $action_id ) );
		}

		return $actions;
	}

	public static function get_by_id( int $action_id ): ?Async_Operation_Item {
		self::check_library_is_registered();

		$store = ActionScheduler::store();
		$logger = ActionScheduler::logger();

		try {
			$action = $store->fetch_action( $action_id );
		} catch ( Throwable $t ) {
			Logger::log(
				Logger::LEVEL_ERROR,
				"Unable to fetch an action `$action_id`. Reason: " . $t->getMessage()
			);

			return null;
		}

		if ( is_a( $action, 'ActionScheduler_NullAction' ) ) {
			Logger::log(
				Logger::LEVEL_WARN,
				'ActionScheduler_NullAction found'
			);

			return null;
		}

		return ( new Async_Operation_Item() )
				->set_id( $action_id )
				->set_hook( $action->get_hook() )
				->set_status( $store->get_status( $action_id ) )
				->set_args( $action->get_args() )
				->set_queue( $action->get_group() )
				->set_date( $store->get_date( $action_id ) )
				->set_logs( $logger->get_logs( $action_id ) );
	}

	/**
	 * @throws Async_Operation_Exception
	 */
	public static function cancel( int $operation_id ): void {
		self::check_library_is_registered();

		$store = ActionScheduler::store();

		$store->cancel_action( $operation_id );
	}

	/**
	 * @throws Async_Operation_Exception
	 */
	public static function remove( array $operation_ids ): void {
		self::check_library_is_registered();

		$store = ActionScheduler::store();

		foreach ( $operation_ids as $operation_id ) {
			$store->delete_action( $operation_id );
		}
	}

	/**
	 * @throws Async_Operation_Exception
	 */
	private static function check_library_is_registered(): void {
		if ( ! ActionScheduler::is_initialized() ) {
			Logger::log(
				Logger::LEVEL_ERROR,
				'ActionScheduler is not initialised though its method was called'
			);

			throw new Async_Operation_Exception();
		}
	}
}
