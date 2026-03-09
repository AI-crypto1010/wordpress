<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Author_Meta')) {
	class Author_Meta extends \Elementor\Core\DynamicTags\Tag {
		public function get_name() {
			return 'author-meta';
		}

		public function get_title() {
			return esc_html__('Author Meta', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-author'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
		}

		protected function register_controls() {
			$this->add_control(
				'key',
				[
					'label' => esc_html__('Meta Key', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => esc_html__('Enter the user meta field key', 'pixfort-core'),
				]
			);

			// $this->add_control(
			// 	'fallback',
			// 	[
			// 		'label' => esc_html__('Fallback', 'pixfort-core'),
			// 		'type' => \Elementor\Controls_Manager::TEXT,
			// 		'description' => esc_html__('Text to display if meta field is empty', 'pixfort-core'),
			// 	]
			// );
		}

		public function render() {
			$settings = $this->get_settings_for_display();
			$key = $settings['key'];
			$fallback = $settings['fallback'];
			
			if (empty($key)) {
				return;
			}

			// Get author from current context
			if (is_author()) {
				$author_id = get_queried_object_id();
			} else {
				$author_id = get_the_author_meta('ID');
			}

			if (!$author_id) {
				return;
			}

			$meta_value = get_user_meta($author_id, $key, true);

			if (empty($meta_value) && !empty($fallback)) {
				$meta_value = $fallback;
			}

			if (!empty($meta_value)) {
				echo wp_kses_post($meta_value);
			}
		}
	}
}
