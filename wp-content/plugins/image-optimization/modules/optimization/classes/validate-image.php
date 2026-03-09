<?php

namespace ImageOptimization\Modules\Optimization\Classes;

use ImageOptimization\Classes\Image\{
	Exceptions\Invalid_Image_Exception,
	Image,
	Image_Meta,
	WP_Image_Meta,
};
use ImageOptimization\Classes\File_System\Exceptions\File_System_Operation_Error;
use ImageOptimization\Classes\File_System\File_System;
use ImageOptimization\Classes\File_Utils;
use ImageOptimization\Modules\Optimization\Classes\Exceptions\Image_Validation_Error;
use ImageOptimization\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Validate_Image {
	public const MAX_FILE_SIZE = 10 * 1024 * 1024;
	public const MAX_BIG_FILE_SIZE = 25 * 1024 * 1024;

	/**
	 * Returns true if $image_id provided associated with an image that can be optimized.
	 *
	 * @param int $image_id Attachment id.
	 *
	 * @return true
	 * @throws Image_Validation_Error
	 * @throws Invalid_Image_Exception
	 */
	public static function is_valid( int $image_id ): bool {
		$attachment_object = get_post( $image_id );

		if ( ! $attachment_object ) {
			throw new Image_Validation_Error(
				esc_html__( 'Can\'t optimize this file. If the issue persists, Contact Support', 'image-optimization' )
			);
		}

		if ( ! wp_attachment_is_image( $attachment_object ) ||
			! in_array( $attachment_object->post_mime_type, Image::get_supported_mime_types(), true ) ||
			(
				in_array( $attachment_object->post_mime_type, Image::get_mime_types_cannot_be_optimized(), true ) &&
				! get_post_meta( $image_id, Image_Meta::IMAGE_OPTIMIZER_METADATA_KEY, true )
			)
		) {
			throw new Image_Validation_Error( esc_html( self::prepare_supported_formats_list_error() ) );
		}

		if ( ! file_exists( get_attached_file( $image_id ) ) ) {
			throw new Image_Validation_Error(
				esc_html__( 'File is missing. Verify the upload', 'image-optimization' )
			);
		}

		self::validate_file_size( $image_id );

		return true;
	}

	/**
	 * Prepares the error message for the unsupported file formats.
	 *
	 * @return string The error message.
	 */
	private static function prepare_supported_formats_list_error(): string {
		$formats = Image::get_supported_formats();
		$formats = array_filter(
			$formats,
			fn ( $format ) => ! in_array( $format, Image::get_formats_cannot_be_optimized(), true )
		);
		$last_item = strtoupper( array_pop( $formats ) );

		$formats_list = join( ', ', array_map( 'strtoupper', $formats ) );

		return sprintf(
			__( 'Unsupported file format. Only %1$s, or %2$s are supported', 'image-optimization' ),
			$formats_list,
			$last_item
		);
	}

	/**
	 * @throws Invalid_Image_Exception
	 * @throws Image_Validation_Error
	 */
	public static function validate_file_size( int $image_id, string $image_size = Image::SIZE_FULL ) {
		try {
			$wp_meta = new WP_Image_Meta( $image_id );
			$image_size = $wp_meta->get_file_size( $image_size )
						  ?? File_System::size( ( new Image( $image_id ) )->get_file_path( $image_size ) );
		} catch ( File_System_Operation_Error $e ) {
			throw new Image_Validation_Error(
				esc_html__( 'File is missing. Verify the upload', 'image-optimization' )
			);
		}

		if ( $image_size > self::MAX_FILE_SIZE ) {
			if ( ! self::are_big_files_supported() ) {
				throw new Image_Validation_Error(
					esc_html(
						sprintf(
							__( 'File is too large. Max size is %s', 'image-optimization' ),
							File_Utils::format_file_size( self::MAX_FILE_SIZE, 0 ),
						)
					)
				);
			}

			if ( $image_size > self::MAX_BIG_FILE_SIZE ) {
				throw new Image_Validation_Error(
					esc_html(
						sprintf(
							__( 'File is too large. Max size is %s', 'image-optimization' ),
							File_Utils::format_file_size( self::MAX_BIG_FILE_SIZE, 0 ),
						)
					)
				);
			}
		}
	}

	/**
	 * Returns the max file size allowed by the current plan.
	 *
	 * @return int File size in bytes.
	 */
	public static function get_max_file_size(): int {
		return self::are_big_files_supported() ? self::MAX_BIG_FILE_SIZE : self::MAX_FILE_SIZE;
	}

	public static function are_big_files_supported(): bool {
		static $is_allowed = null;
		$connect_manager = Plugin::instance()->modules_manager->get_modules( 'connect-manager' );

		if ( null === $is_allowed ) {
			if ( ! $connect_manager->connect_instance->is_connected() ) {
				$is_allowed = false;
				return $is_allowed;
			}

			$plan_data = $connect_manager->connect_instance->get_connect_status();

			if ( ! isset( $plan_data->subscription_plan->features->large_upload_allowed ) ) {
				$is_allowed = false;
			} else {
				$is_allowed = (bool) $plan_data->subscription_plan->features->large_upload_allowed;
			}
		}

		return $is_allowed;
	}
}
