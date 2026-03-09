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

class Version extends Route_Base {
	const NONCE_NAME = 'image-optimization-version';

	protected string $path = 'version';

	public function get_name(): string {
		return 'version';
	}

	public function get_methods(): array {
		return [ 'GET' ];
	}

	public function GET( WP_REST_Request $request ) {
		return $this->respond_success_json( [
			'version' => 1,
		] );
	}
}
