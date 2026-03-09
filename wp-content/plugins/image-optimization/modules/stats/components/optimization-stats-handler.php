<?php

namespace ImageOptimization\Modules\Stats\Components;

use ImageOptimization\Classes\Async_Operation\{
	Async_Operation,
	Async_Operation_Hook,
	Async_Operation_Queue,
	Exceptions\Async_Operation_Exception,
};
use ImageOptimization\Classes\Logger;
use ImageOptimization\Modules\Stats\Classes\Optimization_Stats;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Optimization_Stats_Handler {
	/**
	 * @async
	 *
	 * @param $page
	 * @param $pages_count
	 * @param $output
	 *
	 * @return void
	 */
	public function handle_stats_chunk( $page, $pages_count, $output ) {
		$chunk = Optimization_Stats::get_image_stats_chunk( $page );

		foreach ( array_keys( $chunk ) as $key ) {
			if ( isset( $output[ $key ] ) ) {
				$output[ $key ] += $chunk[ $key ];
				continue;
			}

			$output[ $key ] = $chunk[ $key ];
		}

		if ( $page < $pages_count ) {
			try {
				Async_Operation::create(
					Async_Operation_Hook::CALCULATE_OPTIMIZATION_STATS,
					[
						'page' => $page + 1,
						'pages_count' => $pages_count,
						'output' => $output,
					],
					Async_Operation_Queue::STATS
				);
			} catch ( Async_Operation_Exception $aoe ) {
				Logger::log( Logger::LEVEL_ERROR, 'Error while creating a stats calculation task: ' . $aoe->getMessage() );
			}
		} else {
			unset( $output['pages'] );

			Optimization_Stats::set_stored_stats( $output );
		}
	}

	public function __construct() {
		add_action( Async_Operation_Hook::CALCULATE_OPTIMIZATION_STATS, [ $this, 'handle_stats_chunk' ], 10, 3 );
	}
}
