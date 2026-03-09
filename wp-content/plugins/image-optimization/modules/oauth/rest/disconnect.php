<?php

namespace ImageOptimization\Modules\Oauth\Rest;

use ImageOptimization\Modules\Oauth\{
	Classes\Data,
	Classes\Route_Base,
	Components\Connect
};
use Throwable;
use WP_REST_Request;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Disconnect extends Route_Base {
	const NONCE_NAME = 'image-optimization-disconnect';

	protected string $path = 'disconnect';

	public function get_name(): string {
		return 'disconnect';
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

		try {
			Connect::disconnect();
		} catch ( Throwable $t ) {
			Data::reset();
			return $this->respond_error_json( [
				'message' => $t->getMessage(),
				'code' => 'internal_server_error',
			] );
		}

		return $this->respond_success_json();
	}
}
