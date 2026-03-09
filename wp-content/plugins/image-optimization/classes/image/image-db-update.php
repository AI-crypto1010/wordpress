<?php

namespace ImageOptimization\Classes\Image;

use WP_Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Image_DB_Update {
	public static function update_posts_table_urls( string $old_url, string $new_url ) {
		$query = new WP_Query( [
			'post_type' => 'any',
			'post_status' => 'any',
			's' => $old_url,
			'search_columns' => [ 'post_content' ],
		] );

		if ( ! $query->post_count ) {
			return;
		}

		foreach ( $query->posts as $post ) {
			$new_content = str_replace( $old_url, $new_url, $post->post_content );

			wp_update_post([
				'ID' => $post->ID,
				'post_content' => $new_content,
			]);
		}
	}
}
