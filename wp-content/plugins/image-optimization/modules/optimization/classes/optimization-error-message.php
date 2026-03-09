<?php

namespace ImageOptimization\Modules\Optimization\Classes;

use ImageOptimization\Classes\Image\Image_Optimization_Error_Type;

use TypeError;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Optimization_Error_Message {
	public static function get_reoptimization_error_message( string $error_type ) {
		if ( Image_Optimization_Error_Type::GENERIC === $error_type ) {
			return esc_html__( 'Image reoptimizing failed', 'image-optimization' );
		}

		return self::get_optimization_error_message( $error_type );
	}

	public static function get_optimization_error_message( string $error_type ) {
		if ( ! in_array( $error_type, Image_Optimization_Error_Type::get_values(), true ) ) {
			throw new TypeError( esc_html( "Error type $error_type is not a part of Image_Optimization_Error_Type values" ) );
		}

		$messages = [
			Image_Optimization_Error_Type::FILE_ALREADY_EXISTS => esc_html__( 'File with this name already exists', 'image-optimization' ),
			Image_Optimization_Error_Type::QUOTA_EXCEEDED => esc_html__( 'Plan quota reached', 'image-optimization' ),
			Image_Optimization_Error_Type::GENERIC => esc_html__( 'Optimization error', 'image-optimization' ),
			Image_Optimization_Error_Type::CONNECTION_ERROR => esc_html__( 'Connection error', 'image-optimization' ),
		];

		if ( isset( $messages[ $error_type ] ) ) {
			return $messages[ $error_type ];
		}

		return $messages[ Image_Optimization_Error_Type::GENERIC ];
	}
}
