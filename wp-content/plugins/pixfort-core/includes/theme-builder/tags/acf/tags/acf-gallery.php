<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (!class_exists('ACF_Gallery')) {
	class ACF_Gallery extends \Elementor\Core\DynamicTags\Data_Tag {

		public function get_name() {
			return 'acf-gallery';
		}

		public function get_title() {
			return esc_html__( 'ACF', 'pixfort-code' ) . ' ' . esc_html__( 'Gallery Field', 'pixfort-code' );
		}

		public function get_categories() {
			return [ \Elementor\Modules\DynamicTags\Module::GALLERY_CATEGORY ];
		}

		public function get_group() {
			return ACF_Module::ACF_GROUP;
		}

	public function get_panel_template_setting_key() {
		return 'key';
	}

	public function get_value( array $options = [] ) {
		$images = [];

		$field_data = ACF_Module::get_tag_value_field( $this );
		
		if ( empty( $field_data ) || ! is_array( $field_data ) || count( $field_data ) < 2 ) {
			return $images;
		}
		
		list( $field, $meta_key ) = $field_data;

		if ( $field ) {
			$value = $field['value'];
		} else {
			// Field settings has been deleted or not available.
			$value = get_field( $meta_key );
		}

		if ( is_array( $value ) && ! empty( $value ) ) {
			foreach ( $value as $image ) {
				$images[] = [
					'id' => $image['ID'],
				];
			}
		}

		return $images;
	}

	protected function register_controls() {
		ACF_Module::add_key_control( $this );
	}

	public function get_supported_fields() {
		return [
			'gallery',
		];
	}
	}
}
