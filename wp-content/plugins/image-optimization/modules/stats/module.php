<?php
namespace ImageOptimization\Modules\Stats;

use ImageOptimization\Classes\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Module extends Module_Base {
	public function get_name(): string {
		return 'stats';
	}

	public static function component_list(): array {
		return [
			'Optimization_Stats_Handler',
		];
	}
	public static function routes_list(): array {
		return [
			'Get_Stats',
			'Get_Optimization_Details',
		];
	}

	/**
	 * Module constructor.
	 */
	public function __construct() {
		$this->register_routes();
		$this->register_components();
	}
}
