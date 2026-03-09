<?php

namespace ImageOptimization\Classes\Migration\Handlers;

use ImageOptimization\Classes\Image\{
	Image_Meta,
	Image_Query_Builder,
};

use ImageOptimization\Classes\Migration\Migration;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Fix_Optimized_Size_Keys extends Migration {
	public static function get_name(): string {
		return 'fix_optimized_size_keys';
	}

	public static function run(): bool {
		$query = ( new Image_Query_Builder() )
			->return_optimized_images()
			->execute();

		if ( ! $query->post_count ) {
			return true;
		}

		foreach ( $query->posts as $attachment_id ) {
			$meta = new Image_Meta( $attachment_id );
			$size_keys = array_unique( $meta->get_optimized_sizes() );

			$meta
				->set_optimized_size( $size_keys )
				->save();
		}

		return true;
	}
}
