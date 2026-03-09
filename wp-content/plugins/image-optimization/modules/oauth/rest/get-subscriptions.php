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

class Get_Subscriptions extends Route_Base {
	const NONCE_NAME = 'image-optimization-get-subscription';

	protected string $path = 'get-subscriptions';

	public function get_name(): string {
		return 'get_subscriptions';
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

		try {
			$subscriptions = Connect::get_subscriptions();

			return $this->respond_success_json( $subscriptions );
		} catch ( Throwable $t ) {
			return $this->respond_error_json( [
				'message' => $t->getMessage(),
				'code' => 'internal_server_error',
			] );
		}
	}
}
