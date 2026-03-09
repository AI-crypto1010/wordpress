<?php

namespace ImageOptimization\Modules\Optimization\Components;

use ImageOptimization\Classes\Image\Image_Meta;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Admin_Filter {
	public function add_filter( string $post_type ) {
		if ( 'attachment' !== $post_type ) {
			return;
		}

		$options = [
			'' => __( 'All Media Files', 'image-optimization' ),
			'optimized' => __( 'Optimized', 'image-optimization' ),
			'not-optimized' => __( 'Unoptimized', 'image-optimization' ),
			'in-progress' => __( 'In progress', 'image-optimization' ),
			'failed' => __( 'Errors', 'image-optimization' ),
		];

		$current_value = $this->get_current_filter();
		?>
		<label class="screen-reader-text" for="image-optimization-filter">
			<?php esc_html_e( 'Filter by optimization status', 'image-optimization' ); ?>
		</label>

		<select class="image-optimization-filter" id="image-optimization-filter" name="image-optimization-filter">
			<?php
			foreach ( $options as $value => $title ) {
				printf(
					'<option value="%s" %s>%s</option>',
					esc_attr( $value ),
					selected( $value, $current_value, false ),
					esc_html( $title )
				);
			}
			?>
		</select>
		<?php
	}

	public function handle_filter( $query ) {
		global $pagenow;

		if ( 'upload.php' !== $pagenow ) {
			return;
		}

		$current_value = $this->get_current_filter();

		if ( empty( $current_value ) ) {
			return;
		}

		$meta_query = empty( $query->get( 'meta_query' ) ) ? [] : $query->get( 'meta_query' );

		$meta_query[] = [
			[
				'key' => '_wp_attachment_metadata', // Images without this field considered invalid
				'compare' => 'EXISTS',
			],
		];

		switch ( $current_value ) {
			case 'not-optimized':
				$meta_query[] = [
					'key' => Image_Meta::IMAGE_OPTIMIZER_METADATA_KEY,
					'compare' => 'NOT EXISTS',
				];

				break;

			case 'optimized':
				$meta_query[] = [
					'compare' => 'LIKE',
					'value' => '"status";s:9:"optimized"',
					'key' => Image_Meta::IMAGE_OPTIMIZER_METADATA_KEY,
				];

				break;

			case 'in-progress':
				$meta_query[] = [
					'compare' => 'LIKE',
					'value' => '-in-progress"', // Covers both optimization and restoring
					'key' => Image_Meta::IMAGE_OPTIMIZER_METADATA_KEY,
				];

				break;

			case 'failed':
				$meta_query[] = [
					'compare' => 'LIKE',
					'value' => '-failed"', // Covers both optimization and restoring
					'key' => Image_Meta::IMAGE_OPTIMIZER_METADATA_KEY,
				];

				break;
		}

		$query->set( 'meta_query', $meta_query );
	}

	private function get_current_filter(): string {
		return sanitize_text_field( wp_unslash( $_GET['image-optimization-filter'] ?? '' ) );
	}

	public function __construct() {
		add_filter( 'restrict_manage_posts', [ $this, 'add_filter' ] );
		add_filter( 'parse_query', [ $this, 'handle_filter' ] );
	}
}
