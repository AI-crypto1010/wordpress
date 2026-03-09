<?php

namespace ImageOptimization\Modules\Optimization\Rest;

use ImageOptimization\Modules\Optimization\Classes\{
	Bulk_Optimization\Bulk_Optimization_Controller,
	Route_Base,
};

use Throwable;
use WP_REST_Request;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Get_Bulk_Optimization_Images extends Route_Base {
	protected string $path = 'bulk/images';

	public function get_name(): string {
		return 'bulk-optimization-images';
	}

	public function get_methods(): array {
		return [ 'GET' ];
	}

	public function GET() {
		try {
			$images = Bulk_Optimization_Controller::get_processed_images();

			return $this->respond_success_json([
				'images' => $images,
			]);
		} catch ( Throwable $t ) {
			return $this->respond_error_json([
				'message' => $t->getMessage(),
				'code' => 'internal_server_error',
			]);
		}
	}
}
