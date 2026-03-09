<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Archive_Title')) {
	class Archive_Title extends \Elementor\Core\DynamicTags\Tag {
		public function get_name() {
			return 'archive-title';
		}

		public function get_title() {
			return esc_html__('Archive Title', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-archive'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
		}

		protected function register_controls() {
			$this->add_control(
				'include_context',
				[
					'label' => esc_html__('Include Context', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'description' => esc_html__('Include prefixes like "Category:", "Tag:", etc.', 'pixfort-core'),
				]
			);
		}

		public function render() {
			$include_context = 'yes' === $this->get_settings('include_context');
			$title = '';

			// Check for Loop Grid taxonomy context
			global $wp_query;
			if (!empty($wp_query->loop_term) && $wp_query->loop_term instanceof \WP_Term) {
				$term = $wp_query->loop_term;
				if ($include_context) {
					$taxonomy = get_taxonomy($term->taxonomy);
					$prefix = $taxonomy ? $taxonomy->labels->singular_name . ': ' : '';
					$title = $prefix . $term->name;
				} else {
					$title = $term->name;
				}
				echo wp_kses_post($title);
				return;
			}

			// Check if we're on an archive page
			if (!is_archive()) {
				return;
			}

			if (is_category() || is_tag() || is_tax()) {
				if ($include_context) {
					$title = get_the_archive_title();
				} else {
					$title = single_term_title('', false);
				}
			} elseif (is_author()) {
				if ($include_context) {
					$title = get_the_archive_title();
				} else {
					$title = get_the_author();
				}
			} elseif (is_post_type_archive()) {
				if ($include_context) {
					$title = get_the_archive_title();
				} else {
					$title = post_type_archive_title('', false);
				}
			} elseif (is_date()) {
				$title = get_the_archive_title();
				if (!$include_context) {
					// Remove context prefixes for date archives
					$title = preg_replace('/^[^:]+:\s*/', '', $title);
				}
			} else {
				$title = get_the_archive_title();
				if (!$include_context) {
					$title = preg_replace('/^[^:]+:\s*/', '', $title);
				}
			}

			echo wp_kses_post($title);
		}
	}
}
