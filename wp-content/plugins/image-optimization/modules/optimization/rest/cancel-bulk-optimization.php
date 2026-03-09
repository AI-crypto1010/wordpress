<?php

namespace ImageOptimization\Modules\Optimization\Rest;

use ImageOptimization\Modules\Optimization\Classes\{
	Bulk_Optimization\Bulk_Optimization_Controller,
	Route_Base,
};
use Throwable;
use WP_REST_Request;
use ImageOptimization\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Cancel_Bulk_Optimization extends Route_Base {
	const NONCE_NAME = 'image-optimization-cancel-bulk-optimization';

	protected string $path = 'bulk/cancel';

	public function get_name(): string {
		return 'cancel-bulk-optimization';
	}

	public function get_methods(): array {
		return [ 'POST' ];
	}

	public function POST( WP_REST_Request $request ) {
		$error = $this->verify_nonce_and_capability(
			$request->get_param( self::NONCE_NAME ),
			self::NONCE_NAME
		);

		if ( $error ) {
			return $error;
		}

		if ( ! Plugin::instance()->modules_manager->get_modules( 'connect-manager' )->connect_instance->is_activated() ) {
			return $this->respond_error_json([
				'message' => esc_html__( 'Invalid activation', 'image-optimization' ),
				'code' => 'unauthorized',
			]);
		}

		try {
			$is_in_progress = Bulk_Optimization_Controller::is_optimization_in_progress();

			if ( ! $is_in_progress ) {
				return $this->respond_error_json([
					'message' => esc_html__( 'Bulk optimization is not in progress', 'image-optimization' ),
					'code' => 'forbidden',
				]);
			}

			Bulk_Optimization_Controller::delete_bulk_optimization();

			return $this->respond_success_json();
		} catch ( Throwable $t ) {
			return $this->respond_error_json([
				'message' => $t->getMessage(),
				'code' => 'internal_server_error',
			]);
		}
	}
}
