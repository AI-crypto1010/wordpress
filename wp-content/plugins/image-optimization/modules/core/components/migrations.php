<?php

namespace ImageOptimization\Modules\Core\Components;

use ImageOptimization\Classes\Async_Operation\Async_Operation_Hook;
use ImageOptimization\Classes\Logger;
use ImageOptimization\Classes\Migration\{
	Migration_Manager,
	Migration_Meta,
};

use Throwable;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Migrations {
	/**
	 * @async
	 * @param string $migration_name
	 *
	 * @return bool
	 */
	public function run_migration( string $migration_name ): bool {
		$migration_class = Migration_Manager::get_migration( $migration_name );

		if ( ! $migration_class ) {
			Logger::log(
				Logger::LEVEL_ERROR,
				"Migration class for `$migration_name` does not exist."
			);

			return false;
		}

		if ( ! method_exists( $migration_class, 'run' ) || ! is_callable( [ $migration_class, 'run' ] ) ) {
			Logger::log(
				Logger::LEVEL_ERROR,
				"The run method does not exist or is not static in the class `$migration_class`."
			);

			return false;
		}

		try {
			$migration_class::run();

			( new Migration_Meta() )
				->add_migration_passed( $migration_name )
				->save();

			Logger::log(
				Logger::LEVEL_INFO,
				"The migration `$migration_name` successfully executed."
			);
		} catch ( Throwable $t ) {
			Logger::log(
				Logger::LEVEL_ERROR,
				"Error while running the migration `$migration_name`: " . $t->getMessage()
			);

			return false;
		}

		return true;
	}

	public function __construct() {
		add_action( Async_Operation_Hook::DB_MIGRATION, [ $this, 'run_migration' ] );
	}
}
