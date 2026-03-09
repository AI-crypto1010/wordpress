<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Site_Title')) {
	class Site_Title extends \Elementor\Core\DynamicTags\Tag {
		public function get_name() {
			return 'site-title';
		}

		public function get_title() {
			return esc_html__('Site Title', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-site'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
		}

		public function render() {
			echo wp_kses_post(get_bloginfo('name'));
		}
	}
}
