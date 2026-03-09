<?php

namespace ImageOptimization\Modules\Oauth;

use ImageOptimization\Classes\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Module
 */
class Module extends Module_Base {
	/**
	 * Get module name.
	 * Retrieve the module name.
	 * @access public
	 * @return string Module name.
	 */
	public function get_name(): string {
		return 'oauth';
	}

	public static function routes_list(): array {
		return [
			'Connect_Init',
			'Disconnect',
			'Get_Subscriptions',
			'Activate',
			'Deactivate',
			'Version',
		];
	}

	public static function component_list(): array {
		return [
			'Connect',
			'Checkpoint',
			'Connect_Pointer',
		];
	}

	public static function is_active(): bool {
		return ! empty( get_option( 'image_optimizer_client_data' ) );
	}

	public function __construct() {

		$this->register_components();
		$this->register_routes();
	}
}
