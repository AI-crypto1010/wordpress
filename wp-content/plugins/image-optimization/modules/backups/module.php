<?php

namespace ImageOptimization\Modules\Backups;

use ImageOptimization\Classes\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Module extends Module_Base {
	public function get_name(): string {
		return 'backups';
	}

	public static function routes_list(): array {
		return [
			'Remove_Backups',
			'Restore_Single',
			'Restore_All',
		];
	}

	public static function component_list(): array {
		return [
			'Handle_Backups_Removing',
			'Restore_Images',
		];
	}

	/**
	 * Module constructor.
	 */
	public function __construct() {
		$this->register_components();
		$this->register_routes();
	}
}
