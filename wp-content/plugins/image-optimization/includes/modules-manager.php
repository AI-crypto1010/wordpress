<?php

namespace ImageOptimization;

use ImageOptimization\Classes\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Manager {
	/**
	 * @var Module_Base[]
	 */
	private array $modules = [];

	public static function get_module_list(): array {
		return [
			'core',
			'connect',
			'Oauth',
			'connect-manager',
			'settings',
			'stats',
			'optimization',
			'backups',
			'Deactivation',
			'reviews',
		];
	}

	/**
	 * @codeCoverageIgnore
	 */
	public function __construct() {
		$modules = self::get_module_list();

		foreach ( $modules as $module_name ) {
			$class_name = str_replace( '-', ' ', $module_name );
			$class_name = str_replace( ' ', '', ucwords( $class_name ) );
			$class_name = __NAMESPACE__ . '\\Modules\\' . $class_name . '\Module';

			/** @var Module_Base $class_name */
			if ( $class_name::is_active() ) {
				$this->modules[ $module_name ] = $class_name::instance();
			}
		}

		// Action Scheduler  needs to be registered before `plugins_loaded` hook priority 0
		add_action( 'plugins_loaded', [ $this, 'include_external_libraries' ], -10 );
	}

	/**
	 * @param string $module_name
	 *
	 * @return Module_Base|Module_Base[]
	 */
	public function get_modules( $module_name ) {
		if ( $module_name ) {
			if ( isset( $this->modules[ $module_name ] ) ) {
				return $this->modules[ $module_name ];
			}

			return null;
		}

		return $this->modules;
	}

	public function include_external_libraries() {
		require_once IMAGE_OPTIMIZATION_PATH . 'vendor/woocommerce/action-scheduler/action-scheduler.php';
	}
}
