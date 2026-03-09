<?php

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('Post_URL')) {
	class Post_URL extends \Elementor\Core\DynamicTags\Data_Tag {

		public function get_name() {
			return 'post-url';
		}

		public function get_title() {
			return esc_html__('Post URL', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-post'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY, \Elementor\Modules\DynamicTags\Module::URL_CATEGORY];
		}

		public function get_value(array $options = []) {
			return get_permalink();
		}
	}
}
