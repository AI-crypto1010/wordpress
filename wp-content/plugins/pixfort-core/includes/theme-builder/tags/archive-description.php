<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Archive_Description')) {
	class Archive_Description extends \Elementor\Core\DynamicTags\Tag {
		public function get_name() {
			return 'archive-description';
		}

		public function get_title() {
			return esc_html__('Archive Description', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-archive'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
		}

		public function render() {
			$description = '';

			// Check for Loop Grid taxonomy context
			global $wp_query;
			if (!empty($wp_query->loop_term) && $wp_query->loop_term instanceof \WP_Term) {
				$description = $wp_query->loop_term->description;
				if (!empty($description)) {
					echo wp_kses_post($description);
				}
				return;
			}

			if (is_category() || is_tag() || is_tax()) {
				$description = term_description();
			} elseif (is_author()) {
				$description = get_the_author_meta('description');
			} elseif (is_post_type_archive()) {
				$post_type = get_post_type();
				$post_type_object = get_post_type_object($post_type);
				if ($post_type_object && !empty($post_type_object->description)) {
					$description = $post_type_object->description;
				}
			} elseif (is_date()) {
				if (is_day()) {
					$description = sprintf(esc_html__('Daily Archives: %s', 'pixfort-core'), get_the_date());
				} elseif (is_month()) {
					$description = sprintf(esc_html__('Monthly Archives: %s', 'pixfort-core'), get_the_date('F Y'));
				} elseif (is_year()) {
					$description = sprintf(esc_html__('Yearly Archives: %s', 'pixfort-core'), get_the_date('Y'));
				}
			}

			if (!empty($description)) {
				echo wp_kses_post($description);
			}
		}
	}
}
