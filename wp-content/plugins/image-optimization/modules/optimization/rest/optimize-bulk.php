<?php

namespace ImageOptimization\Modules\Optimization\Rest;

use ImageOptimization\Classes\Async_Operation\Exceptions\Async_Operation_Exception;
use ImageOptimization\Modules\Optimization\Classes\{
	Bulk_Optimization\Bulk_Optimization_Controller,
	Route_Base,
};
use ImageOptimization\Classes\Image\Exceptions\Invalid_Image_Exception;
use ImageOptimization\Classes\Exceptions\Quota_Exceeded_Error;
use Throwable;
use WP_REST_Request;
use ImageOptimization\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Optimize_Bulk extends Route_Base {
	const NONCE_NAME = 'image-optimization-optimize-bulk';

	protected string $path = 'bulk';

	public function get_name(): string {
		return 'optimize-bulk';
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

		$is_reoptimize = (bool) $request->get_param( 'reoptimize' );

		try {
			if ( $is_reoptimize ) {
				return $this->handle_bulk_reoptimization();
			} else {
				return $this->handle_bulk_optimization();
			}
		} catch ( Throwable $t ) {
			return $this->respond_error_json([
				'message' => $t->getMessage(),
				'code' => 'internal_server_error',
			]);
		}
	}

	/**
	 * @return \WP_Error|\WP_REST_Response
	 * @throws Async_Operation_Exception|Invalid_Image_Exception|Quota_Exceeded_Error
	 */
	private function handle_bulk_optimization() {
		$is_in_progress = Bulk_Optimization_Controller::is_optimization_in_progress();

		if ( $is_in_progress ) {
			return $this->respond_error_json( [
				'message' => esc_html__( 'Bulk optimization is already in progress', 'image-optimization' ),
				'code'    => 'forbidden',
			] );
		}

		Bulk_Optimization_Controller::create_optimization_queue();

		return $this->respond_success_json();
	}

	/**
	 * @throws Async_Operation_Exception|Quota_Exceeded_Error
	 */
	private function handle_bulk_reoptimization() {
		$is_in_progress = Bulk_Optimization_Controller::is_reoptimization_in_progress();

		if ( $is_in_progress ) {
			return $this->respond_error_json( [
				'message' => esc_html__( 'Bulk re-optimization is already in progress', 'image-optimization' ),
				'code'    => 'forbidden',
			] );
		}

		Bulk_Optimization_Controller::create_reoptimization_queue();

		return $this->respond_success_json();
	}
}
