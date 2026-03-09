<?php

namespace ImageOptimization\Modules\Optimization\Rest;

use ImageOptimization\Modules\Optimization\Classes\Optimization_Status as Optimization_Status_Controller;
use ImageOptimization\Modules\Optimization\Classes\Route_Base;
use Throwable;
use WP_REST_Request;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Optimization_Status extends Route_Base {
	protected string $path = 'status';

	public function get_name(): string {
		return 'optimization-status';
	}

	public function get_methods(): array {
		// There might be a huge amount of ids in some cases, so decided to keep it as POST
		return [ 'POST' ];
	}

	public function POST( WP_REST_Request $request ) {
		try {
			$body = json_decode( $request->get_body() );
			$image_ids = $body->image_ids ?? null;

			if ( empty( $image_ids ) ) {
				return $this->respond_success_json([
					'status' => [],
				]);
			}

			return $this->respond_success_json([
				'status' => Optimization_Status_Controller::get_images_optimization_statuses( $image_ids ),
			]);
		} catch ( Throwable $t ) {
			return $this->respond_error_json([
				'message' => $t->getMessage(),
				'code' => 'internal_server_error',
			]);
		}
	}
}
