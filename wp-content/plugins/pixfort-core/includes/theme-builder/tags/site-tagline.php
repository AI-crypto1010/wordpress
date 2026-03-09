<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Site_Tagline')) {
	class Site_Tagline extends \Elementor\Core\DynamicTags\Tag {
		public function get_name() {
			return 'site-tagline';
		}

		public function get_title() {
			return esc_html__('Site Tagline', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-site'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
		}

		public function render() {
			echo wp_kses_post(get_bloginfo('description'));
		}
	}
}
