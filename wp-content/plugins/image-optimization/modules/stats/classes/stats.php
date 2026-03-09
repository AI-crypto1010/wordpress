<?php

namespace ImageOptimization\Modules\Stats\Classes;

use ImageOptimization\Classes\Async_Operation\{
	Async_Operation,
	Async_Operation_Hook,
	Queries\Operation_Query,
};
use ImageOptimization\Classes\Image\Image_Query_Builder;
use ImageOptimization\Modules\Optimization\Classes\Bulk_Optimization\{
	Bulk_Optimization_Queue,
	Bulk_Optimization_Queue_Status,
	Bulk_Optimization_Queue_Type
};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Stats {
	public static function calculate_global_stats(): array {
		$bulk_optimization_operation_status = self::get_bulk_optimization_status();

		return [
			'optimization_stats' => Optimization_Stats::get_image_stats(),
			'bulk_optimization_status' => $bulk_optimization_operation_status,
			'bulk_restoring_status' => self::get_bulk_restoring_status(),
			'bulk_backup_removing_status' => self::get_bulk_backup_removing_status(),
			'backups_exist' => self::backups_exist(),
		];
	}

	private static function get_bulk_optimization_status(): string {
		$queue = new Bulk_Optimization_Queue( Bulk_Optimization_Queue_Type::OPTIMIZATION );

		if ( ! $queue->exists() ) {
			return Async_Operation::OPERATION_STATUS_NOT_STARTED;
		}

		$queue_status = $queue->get_status();

		switch ( $queue_status ) {
			case Bulk_Optimization_Queue_Status::PROCESSING:
			case Bulk_Optimization_Queue_Status::PENDING:
				return Async_Operation::OPERATION_STATUS_RUNNING;

			case Bulk_Optimization_Queue_Status::CANCELLED:
				return Async_Operation::OPERATION_STATUS_CANCELED;

			case Bulk_Optimization_Queue_Status::COMPLETED:
			case Bulk_Optimization_Queue_Status::FAILED:
			default:
				return Async_Operation::OPERATION_STATUS_NOT_STARTED;
		}
	}

	private static function get_bulk_restoring_status(): string {
		$active_query = ( new Operation_Query() )
			->set_hook( Async_Operation_Hook::RESTORE_MANY_IMAGES )
			->set_status( [
				Async_Operation::OPERATION_STATUS_PENDING,
				Async_Operation::OPERATION_STATUS_RUNNING,
			] )
			->set_limit( 1 );

		$active_operations = Async_Operation::get( $active_query );

		return ! empty( $active_operations )
			? Async_Operation::OPERATION_STATUS_RUNNING
			: Async_Operation::OPERATION_STATUS_NOT_STARTED;
	}

	private static function get_bulk_backup_removing_status(): string {
		$active_query = ( new Operation_Query() )
			->set_hook( Async_Operation_Hook::REMOVE_MANY_BACKUPS )
			->set_status( [
				Async_Operation::OPERATION_STATUS_PENDING,
				Async_Operation::OPERATION_STATUS_RUNNING,
			] )
			->set_limit( 1 );

		$active_operations = Async_Operation::get( $active_query );

		return ! empty( $active_operations )
			? Async_Operation::OPERATION_STATUS_RUNNING
			: Async_Operation::OPERATION_STATUS_NOT_STARTED;
	}

	private static function backups_exist(): bool {
		$query = ( new Image_Query_Builder() )
			->set_paging_size( 1 )
			->return_images_only_with_backups()
			->execute();

		return $query->post_count > 0;
	}
}
