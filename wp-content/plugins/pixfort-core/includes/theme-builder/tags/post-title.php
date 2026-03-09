<?php

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('Post_Title')) {
	class Post_Title extends \Elementor\Core\DynamicTags\Tag {
		public function get_name() {
			return 'post-title';
		}

		public function get_title() {
			return esc_html__('Post Title', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-post'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
		}

		public function render() {
			echo wp_kses_post(get_the_title());
		}
	}
}
