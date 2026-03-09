<?php

namespace ImageOptimization\Modules\Backups\Rest;

use ImageOptimization\Modules\Backups\Classes\{
	Restore_Images,
	Route_Base,
};
use Throwable;
use WP_REST_Request;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Restore_All extends Route_Base {
	const NONCE_NAME = 'image-optimization-restore-all';

	protected string $path = 'restore';

	public function get_name(): string {
		return 'restore-all';
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
			Restore_Images::find_and_schedule_restoring();

			return $this->respond_success_json();
		} catch ( Throwable $t ) {
			return $this->respond_error_json([
				'message' => $t->getMessage(),
				'code' => 'internal_server_error',
			]);
		}
	}
}
