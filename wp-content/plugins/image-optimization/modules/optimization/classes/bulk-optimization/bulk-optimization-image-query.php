<?php

namespace ImageOptimization\Modules\Optimization\Classes\Bulk_Optimization;

use ImageOptimization\Classes\Image\{
	Image_Meta,
	Image_Query_Builder,
	Exceptions\Invalid_Image_Exception,
	WP_Image_Meta,
};

use ImageOptimization\Classes\Exceptions\Quota_Exceeded_Error;
use ImageOptimization\Modules\Core\Module as Core_Module;
use ImageOptimization\Modules\Optimization\Classes\{
	Validate_Image,
	Exceptions\Image_Validation_Error
};
use ImageOptimization\Modules\Settings\Classes\Settings;
use ImageOptimization\Plugin;

// @codeCoverageIgnoreStart
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
// @codeCoverageIgnoreEnd

final class Bulk_Optimization_Image_Query {
	/**
	 * Looks for images for bulk optimization operations based on a query passed and the quota left.
	 *
	 * @param Image_Query_Builder $query Image query to execute.
	 * @param bool $limit_to_quota If true, it limits image query to the quota left.
	 * @return array{total_images_count: int, attachments_in_quota: array, attachments_out_of_quota: array}
	 *
	 * @throws Invalid_Image_Exception
	 * @throws Quota_Exceeded_Error
	 */
	public static function find_images( Image_Query_Builder $query, bool $limit_to_quota = false ): array {
		$output = [
			'total_images_count' => 0,
			'attachments_in_quota' => [],
			'attachments_out_of_quota' => [],
		];

		if ( ! Core_Module::is_elementor_one() ) {
			$images_left = Plugin::instance()->modules_manager->get_modules( 'connect-manager' )->connect_instance->images_left();

			if ( ! $images_left ) {
				throw new Quota_Exceeded_Error( esc_html__( 'Images quota exceeded', 'image-optimization' ) );
			}

			if ( $limit_to_quota ) {
				$query->set_paging_size( $images_left );
			}
		}

		$wp_query = $query->execute();

		if ( ! $wp_query->post_count ) {
			return $output;
		}

		foreach ( $wp_query->posts as $attachment_id ) {
			try {
				Validate_Image::is_valid( $attachment_id );
				$wp_meta = new WP_Image_Meta( $attachment_id );
			} catch ( Invalid_Image_Exception | Image_Validation_Error $ie ) {
				continue;
			}

			$sizes_count = count( $wp_meta->get_size_keys() );

			if ( ! Core_Module::is_elementor_one() ) {
				if ( $output['total_images_count'] + $sizes_count <= $images_left ) {
					$output['total_images_count'] += $sizes_count;

					$output['attachments_in_quota'][] = $attachment_id;
				} else {
					break;
				}
			} else {
				$output['total_images_count'] += $sizes_count;
				$output['attachments_in_quota'][] = $attachment_id;
			}
		}

		$output['attachments_out_of_quota'] = array_diff( $wp_query->posts, $output['attachments_in_quota'] );

		return $output;
	}

	/**
	 * Looks for images that were optimized, but not all their sizes were processed.
	 *
	 * @return Image_Query_Builder
	 */
	public static function query_not_fully_optimized_images(): Image_Query_Builder {
		$result = [];
		$sizes_enabled = Settings::get( Settings::CUSTOM_SIZES_OPTION_NAME );
		$optimized_images = ( new Image_Query_Builder() )
			->return_optimized_images()
			->execute();

		foreach ( $optimized_images->posts as $attachment_id ) {
			try {
				$image_meta = new Image_Meta( $attachment_id );
				$wp_meta = new WP_Image_Meta( $attachment_id );
			} catch ( Invalid_Image_Exception $iie ) {
				continue;
			}

			$registered_sizes = $wp_meta->get_size_keys();
			$optimized_sizes = $image_meta->get_optimized_sizes();

			if ( 'all' !== $sizes_enabled ) {
				$registered_sizes = array_filter( $registered_sizes, function( $size ) use ( $sizes_enabled ) {
					return in_array( $size, $sizes_enabled, true );
				} );

				$optimized_sizes = array_filter( $optimized_sizes, function( $size ) use ( $sizes_enabled ) {
					return in_array( $size, $sizes_enabled, true );
				} );
			}

			if ( count( $optimized_sizes ) < count( $registered_sizes ) ) {
				$result[] = $attachment_id;
			}
		}

		return ( new Image_Query_Builder() )
			->set_image_ids( $result );
	}
}
