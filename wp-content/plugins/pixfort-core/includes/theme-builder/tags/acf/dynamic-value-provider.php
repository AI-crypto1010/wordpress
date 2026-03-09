<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (!class_exists('ACF_Dynamic_Value_Provider')) {
	class ACF_Dynamic_Value_Provider {

		public function get_value( $key ) {
			if ( empty( $key ) ) {
				return [];
			}

			[ $field_key, $meta_key ] = explode( ':', $key );

			if ( 'options' === $field_key ) {
				$field = $this->get_field_object( $meta_key, $field_key );
			} else {
				$field = $this->get_field_object( $field_key, get_queried_object() );
			}

			return [ $field, $meta_key ];
		}

		/**
		 * Retrieve the custom field value from `ACF` plugin.
		 *
		 * @param $selector
		 * @param $post_id
		 *
		 * @return array|false
		 */
		protected function get_field_object( $selector, $post_id ) {
			return get_field_object( $selector, $post_id );
		}
	}
}
