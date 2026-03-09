<?php

namespace ImageOptimization\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class File_Utils {
	public static function get_extension( string $path ): string {
		$locale = new Locale();
		$locale->set_utf_locale();

		$extension = pathinfo( $path, PATHINFO_EXTENSION );

		$locale->reset_to_original();

		return $extension;
	}

	public static function get_basename( string $path ): string {
		$locale = new Locale();
		$locale->set_utf_locale();

		$basename = pathinfo( $path, PATHINFO_BASENAME );

		$locale->reset_to_original();

		return $basename;
	}

	public static function replace_extension( string $path, string $new_extension, bool $unique_filename = false ): string {
		$locale = new Locale();
		$locale->set_utf_locale();

		$path = pathinfo( $path );
		$basename = sprintf( '%s.%s', $path['filename'], $new_extension );

		if ( $unique_filename ) {
			$basename = wp_unique_filename( $path['dirname'], $basename );
		}

		$locale->reset_to_original();

		return sprintf( '%s/%s', $path['dirname'], $basename );
	}

	public static function get_unique_path( string $path ): string {
		$locale = new Locale();
		$locale->set_utf_locale();

		$path = pathinfo( $path );
		$basename = sprintf( '%s.%s', $path['filename'], $path['extension'] );

		$locale->reset_to_original();

		return sprintf( '%s/%s', $path['dirname'], wp_unique_filename( $path['dirname'], $basename ) );
	}

	public static function get_relative_upload_path( string $path ): string {
		$locale = new Locale();
		$locale->set_utf_locale();

		$path = _wp_relative_upload_path( $path );

		$locale->reset_to_original();

		return $path;
	}

	public static function get_url_from_path( string $full_path ): string {
		$locale = new Locale();
		$locale->set_utf_locale();

		$upload_info = wp_upload_dir();
		$url_base = $upload_info['baseurl'];

		$parts = preg_split(
			'/\/wp-content\/uploads/',
			$full_path
		);

		$locale->reset_to_original();

		return $url_base . $parts[1];
	}

	public static function format_file_size( int $file_size_in_bytes, $decimals = 2 ): string {
		$sizes = [
			__( '%s Bytes', 'image-optimization' ),
			__( '%s Kb', 'image-optimization' ),
			__( '%s Mb', 'image-optimization' ),
			__( '%s Gb', 'image-optimization' ),
		];

		if ( ! $file_size_in_bytes ) {
			return sprintf( $sizes[0], 0 );
		}

		$current_scale = floor( log( $file_size_in_bytes ) / log( 1024 ) );
		$formatted_value = number_format( $file_size_in_bytes / pow( 1024, $current_scale ), $decimals );

		return sprintf( $sizes[ $current_scale ], $formatted_value );
	}
}
