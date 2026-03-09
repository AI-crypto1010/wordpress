<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!function_exists('pixfort_dynamic_is_truthy')) {
	function pixfort_dynamic_is_truthy($value) {
		if (is_bool($value)) {
			return $value;
		}

		$value = strtolower(trim((string) $value));

		return in_array($value, ['1', 'true', 'yes', 'y', 'on'], true);
	}
}

if (!function_exists('pixfort_dynamic_trim_words')) {
	function pixfort_dynamic_trim_words($text, $max_length) {
		if ($max_length <= 0) {
			return $text;
		}

		$words = explode(' ', $text);
		if (count($words) <= $max_length) {
			return $text;
		}

		$trimmed = array_slice($words, 0, $max_length);

		return implode(' ', $trimmed) . '...';
	}
}

if (!function_exists('pixfort_dynamic_get_author_id')) {
	function pixfort_dynamic_get_author_id() {
		global $post, $authordata;

		$author_id = 0;

		if (is_author()) {
			$author_obj = get_queried_object();
			if ($author_obj && isset($author_obj->ID)) {
				$author_id = $author_obj->ID;
			}
		}

		if (!$author_id && $post && isset($post->post_author)) {
			$author_id = $post->post_author;
		}

		if (!$author_id && $authordata && isset($authordata->ID)) {
			$author_id = $authordata->ID;
		}

		if (!$author_id) {
			$post_id = get_the_ID();
			if ($post_id) {
				$post_obj = get_post($post_id);
				if ($post_obj && isset($post_obj->post_author)) {
					$author_id = $post_obj->post_author;
				}
			}
		}

		return (int) $author_id;
	}
}

if (!function_exists('pixfort_dynamic_get_page_title')) {
	function pixfort_dynamic_get_page_title($include_context = false) {
		$title = '';

		if (is_singular()) {
			$title = get_the_title();
		} elseif (is_archive()) {
			if (function_exists('is_shop') && is_shop()) {
				if (is_cart() || is_checkout()) {
					$title = get_the_title();
				} else {
					$title = woocommerce_page_title(false);
				}
			} else {
				$title = get_the_archive_title();
				if ($include_context) {
					return $title;
				}

				$title = preg_replace('/^[^:]+:\s*/', '', $title);
			}
		} elseif (is_search()) {
			$title = sprintf(esc_html__('Search Results for: %s', 'pixfort-core'), get_search_query());
		} elseif (is_404()) {
			$title = esc_html__('Page not found', 'pixfort-core');
		} elseif (is_home()) {
			if (is_front_page()) {
				$title = get_bloginfo('name');
			} else {
				$posts_page = get_option('page_for_posts');
				if ($posts_page) {
					$title = get_the_title($posts_page);
				} else {
					$title = esc_html__('Blog', 'pixfort-core');
				}
			}
		} else {
			$title = get_the_title();
		}

		return $title;
	}
}

if (!function_exists('pixfort_dynamic_get_fallback_url')) {
	function pixfort_dynamic_get_fallback_url($fallback_id, $fallback_url) {
		$fallback_id = (int) $fallback_id;

		if ($fallback_id) {
			$url = wp_get_attachment_url($fallback_id);
			if (!empty($url)) {
				return $url;
			}
		}

		return $fallback_url ? $fallback_url : '';
	}
}
