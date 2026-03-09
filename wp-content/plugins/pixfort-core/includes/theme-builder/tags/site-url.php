<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Site_URL')) {
	class Site_URL extends \Elementor\Core\DynamicTags\Data_Tag {
		public function get_name() {
			return 'site-url';
		}

		public function get_title() {
			return esc_html__('Site URL', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-site'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::URL_CATEGORY];
		}

		public function get_value(array $options = []) {
			return home_url();
		}
	}
}
