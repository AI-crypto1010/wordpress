<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Comments_URL')) {
	class Comments_URL extends \Elementor\Core\DynamicTags\Data_Tag {
		public function get_name() {
			return 'comments-url';
		}

		public function get_title() {
			return esc_html__('Comments URL', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-post'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::URL_CATEGORY];
		}

		public function get_value(array $options = []) {
			$post_id = get_the_ID();

			if (!$post_id) {
				return '';
			}

			return get_comments_link($post_id);
		}
	}
}
