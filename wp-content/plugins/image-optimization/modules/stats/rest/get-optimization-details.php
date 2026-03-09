<?php

namespace ImageOptimization\Modules\Stats\Rest;

use ImageOptimization\Modules\Stats\Classes\{
	Optimization_Stats,
	Route_Base,
};
use Throwable;
use WP_REST_Request;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Get_Optimization_Details extends Route_Base {
	protected string $path = 'optimization-details';

	public function get_name(): string {
		return 'get-optimization-details';
	}

	public function get_methods(): array {
		return [ 'GET' ];
	}

	public function GET( WP_REST_Request $request ) {
		try {
			$image_id = $request->get_param( 'image_id' );

			if ( empty( $image_id ) ) {
				return $this->respond_error_json([
					'message' => 'Image ID is required',
					'code' => 'bad_request',
				]);
			}

			return $this->respond_success_json( Optimization_Stats::get_optimization_details( $image_id ) );
		} catch ( Throwable $t ) {
			return $this->respond_error_json([
				'message' => $t->getMessage(),
				'code' => 'internal_server_error',
			]);
		}
	}
}
