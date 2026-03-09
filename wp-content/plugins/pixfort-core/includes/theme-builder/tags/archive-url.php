<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Archive_URL')) {
	class Archive_URL extends \Elementor\Core\DynamicTags\Data_Tag {
		public function get_name() {
			return 'archive-url';
		}

		public function get_title() {
			return esc_html__('Archive URL', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-archive'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::URL_CATEGORY];
		}

		public function get_value(array $options = []) {
			$url = '';

			// Check for Loop Grid taxonomy context
			global $wp_query;
			if (!empty($wp_query->loop_term) && $wp_query->loop_term instanceof \WP_Term) {
				$url = get_term_link($wp_query->loop_term);
				if (!is_wp_error($url)) {
					return $url;
				}
			}

			if (is_category() || is_tag() || is_tax()) {
				$term = get_queried_object();
				if ($term) {
					$url = get_term_link($term);
				}
			} elseif (is_author()) {
				$author = get_queried_object();
				if ($author) {
					$url = get_author_posts_url($author->ID);
				}
			} elseif (is_post_type_archive()) {
				$post_type = get_post_type();
				$url = get_post_type_archive_link($post_type);
			} elseif (is_date()) {
				$url = get_pagenum_link();
			}

			// Fallback to current URL if specific archive URL not found
			if (empty($url) || is_wp_error($url)) {
				global $wp;
				$url = home_url($wp->request);
			}

			return $url;
		}
        
	}
}
