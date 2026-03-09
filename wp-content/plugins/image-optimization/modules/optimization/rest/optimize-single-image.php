<?php

namespace ImageOptimization\Modules\Optimization\Rest;

use ImageOptimization\Modules\Optimization\Classes\{
	Route_Base,
	Single_Optimization,
	Validate_Image,
};
use Throwable;
use WP_REST_Request;
use ImageOptimization\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Optimize_Single_Image extends Route_Base {
	const NONCE_NAME = 'image-optimization-optimize-image';
	const IMAGE_ID_PARAM = 'imageId';

	protected string $path = 'image';

	public function get_name(): string {
		return 'optimize-single-image';
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
		$image_id = (int) $request->get_param( self::IMAGE_ID_PARAM );

		if ( empty( $image_id ) ) {
			return $this->respond_error_json([
				'message' => esc_html__( 'Invalid image id', 'image-optimization' ),
				'code' => 'bad_request',
			]);
		}

		try {
			Validate_Image::is_valid( $image_id );

			Single_Optimization::schedule_single_optimization( $image_id, $is_reoptimize );

			return $this->respond_success_json();
		} catch ( Throwable $t ) {
			return $this->respond_error_json([
				'message' => $t->getMessage(),
				'code' => 'internal_server_error',
			]);
		}
	}
}
