<?php

namespace ImageOptimization\Classes\Migration;

use ImageOptimization\Classes\Async_Operation\{
	Async_Operation,
	Async_Operation_Hook,
	Async_Operation_Queue,
	Exceptions\Async_Operation_Exception,
};

use ImageOptimization\Classes\Logger;
use ImageOptimization\Classes\Migration\Handlers\{
	Cleanup_Legacy_Bulk_Operations,
	Fix_Avif_With_Zero_Dimensions,
	Fix_Mime_Type,
	Fix_Optimized_Size_Keys,
};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Migration_Manager {
	public static function get_migrations(): array {
		return [
			Fix_Optimized_Size_Keys::class,
			Fix_Mime_Type::class,
			Fix_Avif_With_Zero_Dimensions::class,
			Cleanup_Legacy_Bulk_Operations::class,
		];
	}

	/**
	 * @param $migration_name
	 *
	 * @return \class-string|null
	 */
	public static function get_migration( $migration_name ): ?string {
		foreach ( self::get_migrations() as $migration ) {
			if ( $migration::get_name() === $migration_name ) {
				return $migration;
			}
		}

		return null;
	}

	public static function init() {
		$migrations_passed = ( new Migration_Meta() )->get_migrations_passed();

		foreach ( self::get_migrations() as $migration ) {
			if ( in_array( $migration::get_name(), $migrations_passed, true ) ) {
				continue;
			}

			try {
				Async_Operation::create(
					Async_Operation_Hook::DB_MIGRATION,
					[ 'name' => $migration::get_name() ],
					Async_Operation_Queue::MIGRATION,
					0,
					true
				);
			} catch ( Async_Operation_Exception $aoe ) {
				$name = $migration::get_name();

				Logger::log(
					Logger::LEVEL_ERROR,
					"Error while running migration `$name`: " . $aoe->getMessage()
				);
			}
		}
	}
}
