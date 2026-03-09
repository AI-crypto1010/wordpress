<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (!class_exists('ACF_Color')) {
	class ACF_Color extends \Elementor\Core\DynamicTags\Data_Tag {

		public function get_name() {
			return 'acf-color';
		}

		public function get_title() {
			return esc_html__( 'ACF', 'pixfort-code' ) . ' ' . esc_html__( 'Color Picker Field', 'pixfort-code' );
		}

		public function get_group() {
			return ACF_Module::ACF_GROUP;
		}

		public function get_categories() {
			return [ \Elementor\Modules\DynamicTags\Module::COLOR_CATEGORY ];
		}

	public function get_panel_template_setting_key() {
		return 'key';
	}

	public function get_value( array $options = [] ) {
		$field_data = ACF_Module::get_tag_value_field( $this );
		
		if ( empty( $field_data ) || ! is_array( $field_data ) || count( $field_data ) < 2 ) {
			return '';
		}
		
		list( $field, $meta_key ) = $field_data;

		if ( $field ) {
			$value = $field['value'];
		} else {
			// Field settings has been deleted or not available.
			$value = get_field( $meta_key );
		}

		if ( empty( $value ) && $this->get_settings( 'fallback' ) ) {
			$value = $this->get_settings( 'fallback' );
		}

		return $value;
	}

	protected function register_controls() {
		ACF_Module::add_key_control( $this );
	}

	public function get_supported_fields() {
		return [
			'color_picker',
		];
	}
	}
}
