<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (!class_exists('ACF_File')) {
	class ACF_File extends ACF_Image {

		public function get_name() {
			return 'acf-file';
		}

		public function get_title() {
			return esc_html__( 'ACF', 'pixfort-code' ) . ' ' . esc_html__( 'File Field', 'pixfort-code' );
		}

		public function get_categories() {
			return [
				\Elementor\Modules\DynamicTags\Module::MEDIA_CATEGORY,
			];
		}

	public function get_supported_fields() {
		return [
			'file',
		];
	}
	}
}
