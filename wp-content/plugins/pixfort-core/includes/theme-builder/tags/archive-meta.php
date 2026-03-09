<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Archive_Meta')) {
	class Archive_Meta extends \Elementor\Core\DynamicTags\Tag {
		public function get_name() {
			return 'archive-meta';
		}

		public function get_title() {
			return esc_html__('Archive Meta', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-archive'];
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
					'description' => esc_html__('Enter the meta field key', 'pixfort-core'),
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
			$fallback = isset($settings['fallback']) ? $settings['fallback'] : '';
			
			if (empty($key)) {
				return;
			}

			$meta_value = '';

			// Check for Loop Grid taxonomy context
			global $wp_query;
			if (!empty($wp_query->loop_term) && $wp_query->loop_term instanceof \WP_Term) {
				$meta_value = get_term_meta($wp_query->loop_term->term_id, $key, true);
			} elseif (is_category() || is_tag() || is_tax()) {
				$term = get_queried_object();
				if ($term && isset($term->term_id)) {
					$meta_value = get_term_meta($term->term_id, $key, true);
				}
			} elseif (is_author()) {
				$author = get_queried_object();
				if ($author && isset($author->ID)) {
					$meta_value = get_user_meta($author->ID, $key, true);
				}
			}

			if (empty($meta_value) && !empty($fallback)) {
				$meta_value = $fallback;
			}

			if (!empty($meta_value)) {
				echo wp_kses_post($meta_value);
			}
		}
	}
}
