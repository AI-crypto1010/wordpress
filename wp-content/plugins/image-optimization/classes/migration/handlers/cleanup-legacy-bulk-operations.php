<?php

namespace ImageOptimization\Classes\Migration\Handlers;

use ImageOptimization\Classes\Async_Operation\{
	Async_Operation,
	Async_Operation_Hook,
	Queries\Image_Optimization_Operation_Query
};
use ImageOptimization\Classes\Logger;
use ImageOptimization\Classes\Migration\Migration;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Cleanup_Legacy_Bulk_Operations extends Migration {
	public static function get_name(): string {
		return 'cleanup_legacy_bulk_operations';
	}

	public static function run(): bool {
		self::cleanup_operations( Async_Operation_Hook::OPTIMIZE_BULK );
		self::cleanup_operations( Async_Operation_Hook::REOPTIMIZE_BULK );

		return true;
	}

	private static function cleanup_operations( string $hook ): void {
		$query = ( new Image_Optimization_Operation_Query() )
			->set_hook( $hook )
			->set_status( [
				Async_Operation::OPERATION_STATUS_PENDING,
				Async_Operation::OPERATION_STATUS_RUNNING,
			] )
			->set_limit( -1 );

		$operations = Async_Operation::get( $query );

		if ( empty( $operations ) ) {
			Logger::info( sprintf(
				'No legacy operations found for hook %s',
				$hook
			) );
			return;
		}

		$operation_ids = array_map(
			function( $operation ) {
				return $operation->get_id();
			},
			$operations
		);

		Async_Operation::remove( $operation_ids );

		Logger::info( sprintf(
			'Removed %d legacy operations for hook %s',
			count( $operation_ids ),
			$hook
		) );
	}
}
