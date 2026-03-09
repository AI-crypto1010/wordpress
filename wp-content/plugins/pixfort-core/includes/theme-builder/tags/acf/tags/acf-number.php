<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (!class_exists('ACF_Number')) {
	class ACF_Number extends \Elementor\Core\DynamicTags\Tag {

		public function get_name() {
			return 'acf-number';
		}

		public function get_title() {
			return esc_html__( 'ACF', 'pixfort-code' ) . ' ' . esc_html__( 'Number', 'pixfort-code' ) . ' ' . esc_html__( 'Field', 'pixfort-code' );
		}

		public function get_group() {
			return ACF_Module::ACF_GROUP;
		}

		public function get_categories() {
			return [
				\Elementor\Modules\DynamicTags\Module::NUMBER_CATEGORY,
				\Elementor\Modules\DynamicTags\Module::POST_META_CATEGORY,
			];
		}

	public function render() {
		$field_data = ACF_Module::get_tag_value_field( $this );
		
		if ( empty( $field_data ) || ! is_array( $field_data ) || count( $field_data ) < 2 ) {
			return;
		}
		
		list( $field, $meta_key ) = $field_data;

		if ( $field && ! empty( $field['type'] ) ) {
			$value = $field['value'];
		} else {
			// Field settings has been deleted or not available.
			$value = get_field( $meta_key );
		} // End if().

		echo wp_kses_post( $value );
	}

	public function get_panel_template_setting_key() {
		return 'key';
	}

	protected function register_controls() {
		ACF_Module::add_key_control( $this );
	}

	public function get_supported_fields() {
		return [
			'number',
		];
	}
	}
}
