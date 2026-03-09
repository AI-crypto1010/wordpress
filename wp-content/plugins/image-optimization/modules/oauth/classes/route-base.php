<?php

namespace ImageOptimization\Modules\Oauth\Classes;

use ImageOptimization\Classes\Route;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Route_Base extends Route {
	const SITE_URL = 'https://my.elementor.com/connect/v1/';

	protected $auth = true;
	protected string $path = '';
	public function get_methods(): array {
		return [];
	}

	public function get_endpoint(): string {
		return 'connect/' . $this->get_path();
	}

	public function get_path(): string {
		return $this->path;
	}

	public function get_name(): string {
		return '';
	}

	public function get_permission_callback( \WP_REST_Request $request ): bool {
		$valid = $this->permission_callback( $request );

		return $valid && user_can( $this->current_user_id, 'manage_options' );
	}
}
