<?php

namespace ImageOptimization\Modules\Backups\Rest;

use ImageOptimization\Modules\Backups\Classes\{
	Route_Base,
	Remove_All_Backups,
};
use Throwable;
use WP_REST_Request;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Remove_Backups extends Route_Base {
	const NONCE_NAME = 'image-optimization-remove-backups';

	protected string $path = '';

	public function get_name(): string {
		return 'remove-backups';
	}

	public function get_methods(): array {
		return [ 'DELETE' ];
	}

	public function DELETE( WP_REST_Request $request ) {
		$error = $this->verify_nonce_and_capability(
			$request->get_param( self::NONCE_NAME ),
			self::NONCE_NAME
		);

		if ( $error ) {
			return $error;
		}

		try {
			Remove_All_Backups::find_and_schedule_removing();

			return $this->respond_success_json();
		} catch ( Throwable $t ) {
			return $this->respond_error_json([
				'message' => $t->getMessage(),
				'code' => 'internal_server_error',
			]);
		}
	}
}
