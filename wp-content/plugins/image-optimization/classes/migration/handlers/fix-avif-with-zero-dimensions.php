<?php

namespace ImageOptimization\Classes\Migration\Handlers;

use ImageOptimization\Classes\Image\{
	Image,
	Image_Dimensions,
	Image_Query_Builder,
	WP_Image_Meta,
};

use ImageOptimization\Classes\Migration\Migration;
use Throwable;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Fix_Avif_With_Zero_Dimensions extends Migration {
	public static function get_name(): string {
		return 'fix_avif_with_zero_dimensions';
	}

	public static function run(): bool {
		$query = ( new Image_Query_Builder() )
			->set_mime_types( [ 'image/avif', 'application/octet-stream' ] )
			->return_images_with_non_empty_meta()
			->execute();

		if ( ! $query->post_count ) {
			return true;
		}

		foreach ( $query->posts as $attachment_id ) {
			try {
				$wp_meta = new WP_Image_Meta( $attachment_id );
				$image = new Image( $attachment_id );

				foreach ( $wp_meta->get_size_keys() as $size_key ) {
					if ( 0 === $wp_meta->get_width( $size_key ) || 0 === $wp_meta->get_height( $size_key ) ) {
						$dimensions = Image_Dimensions::get_by_path( $image->get_file_path( $size_key ) );

						$wp_meta
							->set_width( $size_key, $dimensions->width )
							->set_height( $size_key, $dimensions->height )
							->save();
					}
				}
			} catch ( Throwable $t ) {
				continue;
			}
		}

		return true;
	}
}
