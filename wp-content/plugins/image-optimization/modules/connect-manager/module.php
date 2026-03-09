<?php

namespace ImageOptimization\Modules\ConnectManager;

use ImageOptimization;
use ImageOptimization\Classes\Module_Base;

use ImageOptimization\Modules\ConnectManager\{
	Classes\Connect_Runner,
	Components\Legacy_Connect,
	Components\Connect,
};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class Module
 */
class Module extends Module_Base {

	/**
	 * Connect instance
	 */
	public $connect_instance;

	/**
	 * Get module name.
	 * Retrieve the module name.
	 * @access public
	 * @return string Module name.
	 */
	public function get_name() {
		return 'connect-manager';
	}

	/**
	 * component_list
	 * @return string[]
	 */
	public static function component_list(): array {
		return [
			'Legacy_Connect',
			'Connect',
		];
	}

	public function __construct() {
		// Register components.
		$this->register_components();
		// Load Connect Manager.
		add_action( 'plugins_loaded', [ $this, 'load_connect_manager' ] );
	}

	/**
	 * Load Connect Manager
	 *
	 * Load the correct version of Connect Manager based on whether
	 * the user is already connected using legacy version or not.
	 *
	 * @return void
	 */
	public function load_connect_manager() {
		if ( ImageOptimization\Modules\Connect\Module::is_active() ) {
			$this->connect_instance = new Connect_Runner( new Connect() );
		} else {
			$this->connect_instance = new Connect_Runner( new Legacy_Connect() );
		}
	}
}
