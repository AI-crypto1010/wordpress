<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (!class_exists('ACF_Image')) {
	class ACF_Image extends \Elementor\Core\DynamicTags\Data_Tag {

		public function get_name() {
			return 'acf-image';
		}

		public function get_title() {
			return esc_html__( 'ACF', 'pixfort-code' ) . ' ' . esc_html__( 'Image Field', 'pixfort-code' );
		}

		public function get_group() {
			return ACF_Module::ACF_GROUP;
		}

		public function get_categories() {
			return [ \Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY ];
		}

	public function get_panel_template_setting_key() {
		return 'key';
	}

	public function get_value( array $options = [] ) {
		$image_data = [
			'id' => null,
			'url' => '',
		];

		$field_data = ACF_Module::get_tag_value_field( $this );
		
		if ( empty( $field_data ) || ! is_array( $field_data ) || count( $field_data ) < 2 ) {
			return $image_data;
		}
		
		list( $field, $meta_key ) = $field_data;

		if ( $field && is_array( $field ) ) {
			$field['return_format'] = isset( $field['save_format'] ) ? $field['save_format'] : $field['return_format'];
			switch ( $field['return_format'] ) {
				case 'object':
				case 'array':
					$value = $field['value'];
					break;
				case 'url':
					$value = [
						'id' => 0,
						'url' => $field['value'],
					];
					break;
				case 'id':
					$src = wp_get_attachment_image_src( $field['value'], $field['preview_size'] );
					$value = [
						'id' => $field['value'],
						'url' => $src[0],
					];
					break;
			}
		}

		if ( ! isset( $value ) ) {
			// Field settings has been deleted or not available.
			$value = get_field( $meta_key );
		}

		if ( empty( $value ) && $this->get_settings( 'fallback' ) ) {
			$value = $this->get_settings( 'fallback' );
		}

		if ( ! empty( $value ) && is_array( $value ) ) {
			$image_data['id'] = $value['id'];
			$image_data['url'] = $value['url'];
		}

		return $image_data;
	}

	protected function register_controls() {
		ACF_Module::add_key_control( $this );

		$this->add_control(
			'fallback',
			[
				'label' => esc_html__( 'Fallback', 'pixfort-code' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);
	}

	public function get_supported_fields() {
		return [
			'image',
		];
	}
	}
}
