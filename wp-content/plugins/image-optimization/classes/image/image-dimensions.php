<?php

namespace ImageOptimization\Classes\Image;

use ImageOptimization\Classes\Logger;

use Imagick;
use stdClass;
use Throwable;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Image_Dimensions {
	/**
	 * @param string $file_path
	 *
	 * @return stdClass{width: int, height: int}
	 */
	public static function get_by_path( string $file_path ): stdClass {
		$dimensions = wp_getimagesize( $file_path );
		$output = new stdClass();

		$output->width = 0;
		$output->height = 0;

		if ( $dimensions ) {
			$output->width = $dimensions[0];
			$output->height = $dimensions[1];

			return $output;
		}

		if ( class_exists( 'Imagick' ) ) {
			try {
				$im = new Imagick( $file_path );
				$image_geometry = $im->getImageGeometry();
				$im->clear();

				$output->width = $image_geometry['width'];
				$output->height = $image_geometry['height'];
			} catch ( Throwable $t ) {
				Logger::log(
					Logger::LEVEL_ERROR,
					'AVIF image dimensions calculation error: ' . $t->getMessage()
				);
			}
		}

		return $output;
	}
}
