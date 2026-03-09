<?php

namespace ImageOptimization\Classes\Migration\Handlers;

use ImageOptimization\Classes\Image\{
	Image,
	Image_Meta,
	Image_Query_Builder,
	WP_Image_Meta
};

use ImageOptimization\Classes\Migration\Migration;
use ImageOptimization\Modules\Stats\Classes\Optimization_Stats;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Fix_Mime_Type extends Migration {
	public static function get_name(): string {
		return 'fix_mime_type';
	}

	public static function run(): bool {
		$query = ( new Image_Query_Builder() )
			->return_optimized_images()
			->execute();

		if ( ! $query->post_count ) {
			return true;
		}

		foreach ( $query->posts as $attachment_id ) {
			$stats = Optimization_Stats::get_image_stats( $attachment_id );
			$fully_optimized = ( $stats['initial_image_size'] - $stats['current_image_size'] ) <= 0;

			if ( $fully_optimized ) {
				$io_meta  = new Image_Meta( $attachment_id );
				$wp_meta  = new WP_Image_Meta( $attachment_id );
				$size_data = $wp_meta->get_size_data( Image::SIZE_FULL );

				if (
					( ! str_contains( $size_data['file'], '.webp' ) && 'image/webp' === $size_data['mime-type'] ) ||
					( ! str_contains( $size_data['file'], '.avif' ) && 'image/avif' === $size_data['mime-type'] ) ||
					( ! str_contains( $size_data['file'], '.avif' ) && 'application/octet-stream' === $size_data['mime-type'] )
				) {
					$original_mime_type = $io_meta->get_original_mime_type( Image::SIZE_FULL );

					foreach ( $wp_meta->get_size_keys() as $size ) {
						$wp_meta
							->set_mime_type( $size, $original_mime_type )
							->save();
					}
				}
			}
		}

		return true;
	}
}
