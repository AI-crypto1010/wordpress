<?php

namespace ImageOptimization\Modules\Oauth\Components;

use ImageOptimization\Classes\Utils;
use ImageOptimization\Modules\Oauth\Classes\Data;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Checkpoint
 */
class Checkpoint {

	const ON_CONNECT = 'image-optimizer-connect';
	const ON_DISCONNECT = 'image-optimizer-disconnect';
	const ON_ACTIVATE = 'image-optimizer-activate';
	const ON_DEACTIVATE = 'image-optimizer-deactivate';

	/**
	 * event
	 *
	 * @param array $event_data
	 */
	public static function event( array $event_data = [] ): void {
		$event_name = current_action();
		// only allow specific events
		if ( ! in_array( $event_name, self::get_checkpoints() ) ) {
			return;
		}

		$response = Utils::get_api_client()->make_request(
			'POST',
			'status/checkpoint',
			[
				'event_name' => $event_name,
				'event_data' => $event_data,
			]
		);
	}

	/**
	 * get_checkpoints
	 * @return string[]
	 */
	public static function get_checkpoints(): array {
		return [
			self::ON_DISCONNECT,
			self::ON_CONNECT,
			self::ON_ACTIVATE,
			self::ON_DEACTIVATE,
		];
	}
	public function __construct() {
		foreach ( self::get_checkpoints() as $checkpoint ) {
			add_action( $checkpoint, [ __CLASS__, 'event' ], 10, 0 );
		}
	}
}
