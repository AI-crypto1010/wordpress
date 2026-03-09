<?php

namespace ImageOptimization\Modules\Backups\Rest;

use ImageOptimization\Modules\Optimization\Classes\Validate_Image;
use ImageOptimization\Modules\Backups\Classes\{
	Restore_Images,
	Route_Base,
};
use Throwable;
use WP_REST_Request;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Restore_Single extends Route_Base {
	const NONCE_NAME = 'image-optimization-restore-single';

	protected string $path = 'restore/(?P<image_id>\d+)';

	public function get_name(): string {
		return 'restore-single';
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

		$image_id = (int) $request->get_param( 'image_id' );

		if ( empty( $image_id ) ) {
			return $this->respond_error_json( [
				'message' => esc_html__( 'Invalid image id', 'image-optimization' ),
				'code' => 'internal_server_error',
			] );
		}

		try {
			Validate_Image::is_valid( $image_id );

			Restore_Images::schedule_single_restoring( $image_id );

			return $this->respond_success_json();
		} catch ( Throwable $t ) {
			return $this->respond_error_json([
				'message' => $t->getMessage(),
				'code' => 'internal_server_error',
			]);
		}
	}
}
