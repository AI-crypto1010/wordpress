<?php

namespace ImageOptimization\Modules\Oauth\Rest;

use ImageOptimization\Modules\Oauth\{
	Classes\Route_Base,
	Components\Connect,
};

use Throwable;
use WP_REST_Request;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Activate extends Route_Base {
	const NONCE_NAME = 'image-optimization-activate-subscription';

	protected string $path = 'activate';

	public function get_name(): string {
		return 'activate';
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

		if ( ! Connect::is_connected() ) {
			return $this->respond_error_json( [
				'message' => esc_html__( 'Please connect first', 'image-optimization' ),
				'code' => 'forbidden',
			] );
		}

		if ( Connect::is_activated() ) {
			return $this->respond_error_json( [
				'message' => esc_html__( 'Already activated', 'image-optimization' ),
				'code' => 'bad_request',
			] );
		}

		if ( ! $request->get_param( 'license_key' ) ) {
			return $this->respond_error_json( [
				'message' => esc_html__( 'Missing license key', 'image-optimization' ),
				'code' => 'bad_request',
			] );
		}

		$license_key = $request->get_param( 'license_key' );

		try {
			Connect::activate( $license_key );

			return $this->respond_success_json();
		} catch ( Throwable $t ) {
			return $this->respond_error_json( [
				'message' => $t->getMessage(),
				'code' => 'internal_server_error',
			] );
		}
	}
}
