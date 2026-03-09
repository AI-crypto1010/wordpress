<?php

namespace ImageOptimization\Modules\Stats\Rest;

use ImageOptimization\Modules\Stats\Classes\{
	Route_Base,
	Stats
};
use Throwable;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Get_Stats extends Route_Base {
	protected string $path = '';

	public function get_name(): string {
		return 'get-stats';
	}

	public function get_methods(): array {
		return [ 'GET' ];
	}

	public function GET() {
		try {
			return $this->respond_success_json( Stats::calculate_global_stats() );
		} catch ( Throwable $t ) {
			return $this->respond_error_json([
				'message' => $t->getMessage(),
				'code' => 'internal_server_error',
			]);
		}
	}
}
