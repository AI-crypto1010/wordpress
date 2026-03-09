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

class Connect_Init extends Route_Base {
	const NONCE_NAME = 'image-optimization-connect';

	protected string $path = 'init';

	public function get_name(): string {
		return 'connect-init';
	}

	public function get_methods(): array {
		return [ 'GET' ];
	}

	public function get( WP_REST_Request $request ) {
		$error = $this->verify_nonce_and_capability(
			$request->get_param( self::NONCE_NAME ),
			self::NONCE_NAME
		);

		if ( $error ) {
			return $error;
		}

		if ( Connect::is_connected() ) {
			return $this->respond_error_json( [
				'message' => esc_html__( 'You are already connected', 'image-optimization' ),
				'code' => 'forbidden',
			] );
		}

		try {
			$connect_url = Connect::initialize_connect();

			return $this->respond_success_json( $connect_url );
		} catch ( Throwable $t ) {
			return $this->respond_error_json( [
				'message' => $t->getMessage(),
				'code' => 'internal_server_error',
			] );
		}
	}
}
