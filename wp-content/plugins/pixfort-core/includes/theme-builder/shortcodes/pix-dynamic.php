<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Pixfort_Dynamic_Shortcode')) {
	class Pixfort_Dynamic_Shortcode {
		private static $instance;

		public static function instance() {
			if (!self::$instance) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public static function register() {
			add_shortcode('pix_dynamic', [self::instance(), 'handle']);
		}

		public function handle($atts = []) {
			$atts = shortcode_atts($this->get_default_atts(), $atts);

			$key = $this->normalize_key($atts['key']);
			if (empty($key)) {
				return '';
			}

			$method = $this->get_key_method($key);
			if ($method && method_exists($this, $method)) {
				return $this->$method($atts);
			}

			return $this->render_fallback($atts);
		}

		public function render_dynamic_image($data) {
			if (empty($data)) {
				return '';
			}

			$payload = null;
			if (is_array($data)) {
				$payload = $data;
			} elseif (is_string($data)) {
				$raw = $data;
				if (function_exists('pix_unescape_vc')) {
					$raw = pix_unescape_vc($raw);
				}
				$raw = wp_unslash($raw);
				$payload = json_decode($raw, true);

				if (!is_array($payload) || empty($payload['key'])) {
					if (strpos($raw, '[pix_dynamic') !== false) {
						return do_shortcode($raw);
					}
					return '';
				}
			}

			if (!is_array($payload) || empty($payload['key'])) {
				return '';
			}

			$atts = [];
			if (!empty($payload['options']) && is_array($payload['options'])) {
				$atts = $payload['options'];
			}
			$atts['key'] = $payload['key'];

			return $this->handle($atts);
		}

		private function get_default_atts() {
			return [
				'key' => '',
				'fallback' => '',
				'fallback_id' => '',
				'fallback_url' => '',
				'max_length' => '',
				'apply_to_post_content' => 'no',
				'date_format' => 'default',
				'custom_format' => 'F j, Y',
				'date_type' => 'publish',
				'format_no_comments' => esc_html__('No Comments', 'pixfort-core'),
				'format_one_comment' => esc_html__('One Comment', 'pixfort-core'),
				'format_multiple_comments' => esc_html__('% Comments', 'pixfort-core'),
				'link_to_comments' => '',
				'include_context' => '',
				'show_home_title' => '',
				'type' => '',
				'post_id' => '',
				'taxonomy_id' => '',
				'attachment_id' => '',
				'author_id' => '',
				'meta_key' => '',
				'link_to' => '',
				'size' => 96,
				'field_key' => '',
				'acf_key' => '',
			];
		}

		private function normalize_key($key) {
			$key = strtolower(trim((string) $key));
			$key = str_replace('-', '_', $key);

			return $key;
		}

		private function get_key_method($key) {
			$map = [
				'post_title' => 'render_post_title',
				'post_url' => 'render_post_url',
				'post_featured_image' => 'render_post_featured_image',
				'post_excerpt' => 'render_post_excerpt',
				'post_date' => 'render_post_date',
				'comments_number' => 'render_comments_number',
				'comments_url' => 'render_comments_url',
				'page_title' => 'render_page_title',
				'site_title' => 'render_site_title',
				'site_url' => 'render_site_url',
				'site_tagline' => 'render_site_tagline',
				'internal_url' => 'render_internal_url',
				'archive_description' => 'render_archive_description',
				'archive_meta' => 'render_archive_meta',
				'archive_title' => 'render_archive_title',
				'archive_url' => 'render_archive_url',
				'category_image' => 'render_category_image',
				'author_info' => 'render_author_info',
				'author_meta' => 'render_author_meta',
				'author_name' => 'render_author_name',
				'author_profile_picture' => 'render_author_profile_picture',
				'author_url' => 'render_author_url',
				'acf_text' => 'render_acf_text',
				'acf_image' => 'render_acf_image',
				'acf_url' => 'render_acf_url',
				'acf_gallery' => 'render_acf_gallery',
				'acf_file' => 'render_acf_file',
				'acf_number' => 'render_acf_number',
				'acf_color' => 'render_acf_color',
				'acf_date_time' => 'render_acf_date_time',
			];

			return $map[$key] ?? null;
		}

		private function render_fallback($atts) {
			return !empty($atts['fallback']) ? wp_kses_post($atts['fallback']) : '';
		}

		private function get_fallback_url($atts) {
			return pixfort_dynamic_get_fallback_url(
				$atts['fallback_id'],
				$atts['fallback_url'] ? $atts['fallback_url'] : $atts['fallback']
			);
		}

		private function get_acf_field_key($atts) {
			$field_key = $atts['field_key'];
			if (empty($field_key)) {
				$field_key = $atts['acf_key'];
			}

			return $field_key;
		}

		private function render_post_title($atts) {
			return wp_kses_post(get_the_title());
		}

		private function render_post_url($atts) {
			$post_url = get_permalink();
			return $post_url ? esc_url($post_url) : '';
		}

		private function render_post_featured_image($atts) {
			$thumbnail_id = get_post_thumbnail_id();

			if (is_category() || (class_exists('WooCommerce') && is_product_category())) {
				$term = get_queried_object();
				if ($term && isset($term->term_id)) {
					$thumbnail_id = get_term_meta($term->term_id, 'category_intro_img', true);
				}
			} elseif (is_author()) {
				$thumbnail_id = false;
			}

			if ($thumbnail_id) {
				$image = wp_get_attachment_image_src($thumbnail_id, 'full');
				if ($image && isset($image[0])) {
					return esc_url($image[0]);
				}
			}

			$fallback_url = $this->get_fallback_url($atts);

			return $fallback_url ? esc_url($fallback_url) : '';
		}

		private function render_post_excerpt($atts) {
			$post = get_post();
			if (!$post) {
				return '';
			}

			$apply_to_post_content = pixfort_dynamic_is_truthy($atts['apply_to_post_content']);
			$post_excerpt = $post->post_excerpt ?? '';

			if (empty($post_excerpt) && !$apply_to_post_content) {
				return '';
			}

			if (empty($post_excerpt) && empty($post->post_content) && $apply_to_post_content) {
				return '';
			}

			if (empty($post_excerpt) && empty($post->post_content)) {
				return '';
			}

			if (empty($post_excerpt) && !empty($post->post_content) && $apply_to_post_content) {
				$post_excerpt = apply_filters('the_excerpt', get_the_excerpt($post));
			}

			$max_length = (int) $atts['max_length'];
			if ($max_length > 0) {
				$post_excerpt = pixfort_dynamic_trim_words($post_excerpt, $max_length);
			}

			return wp_kses_post($post_excerpt);
		}

		private function render_post_date($atts) {
			$date_format = $atts['date_format'];

			if ('default' === $date_format) {
				$date_format = get_option('date_format');
			} elseif ('custom' === $date_format) {
				$date_format = $atts['custom_format'];
			}

			if ('modified' === $atts['date_type']) {
				$date = get_the_modified_date($date_format);
			} else {
				$date = get_the_date($date_format);
			}

			return esc_html($date);
		}

		private function render_comments_number($atts) {
			$post_id = get_the_ID();
			if (!$post_id) {
				return '';
			}

			$comments_number = get_comments_number($post_id);
			$link_to_comments = pixfort_dynamic_is_truthy($atts['link_to_comments']);

			if ($comments_number == 0) {
				$comments_text = $atts['format_no_comments'];
			} elseif ($comments_number == 1) {
				$comments_text = $atts['format_one_comment'];
			} else {
				$comments_text = str_replace('%', $comments_number, $atts['format_multiple_comments']);
			}

			if ($link_to_comments && $comments_number > 0) {
				$comments_link = get_comments_link($post_id);
				return sprintf('<a href="%s">%s</a>', esc_url($comments_link), esc_html($comments_text));
			}

			return esc_html($comments_text);
		}

		private function render_comments_url($atts) {
			$post_id = get_the_ID();
			if (!$post_id) {
				return '';
			}

			$url = get_comments_link($post_id);
			return $url ? esc_url($url) : '';
		}

		private function render_page_title($atts) {
			if (is_home() && !pixfort_dynamic_is_truthy($atts['show_home_title'])) {
				return '';
			}

			$include_context = pixfort_dynamic_is_truthy($atts['include_context']);
			$title = pixfort_dynamic_get_page_title($include_context);

			return wp_kses_post($title);
		}

		private function render_site_title($atts) {
			return wp_kses_post(get_bloginfo('name'));
		}

		private function render_site_url($atts) {
			return esc_url(home_url());
		}

		private function render_site_tagline($atts) {
			return wp_kses_post(get_bloginfo('description'));
		}

		private function render_internal_url($atts) {
			$type = $atts['type'];
			$url = '';

			if ('post' === $type && !empty($atts['post_id'])) {
				$url = get_permalink((int) $atts['post_id']);
			} elseif ('taxonomy' === $type && !empty($atts['taxonomy_id'])) {
				$url = get_term_link((int) $atts['taxonomy_id']);
			} elseif ('attachment' === $type && !empty($atts['attachment_id'])) {
				$url = get_attachment_link((int) $atts['attachment_id']);
			} elseif ('author' === $type && !empty($atts['author_id'])) {
				$url = get_author_posts_url((int) $atts['author_id']);
			} elseif (!empty($atts['post_id'])) {
				$url = get_permalink((int) $atts['post_id']);
			}

			if (is_wp_error($url)) {
				return '';
			}

			return $url ? esc_url($url) : '';
		}

		private function render_archive_description($atts) {
			$description = '';

			global $wp_query;
			if (!empty($wp_query->loop_term) && $wp_query->loop_term instanceof WP_Term) {
				$description = $wp_query->loop_term->description;
				return !empty($description) ? wp_kses_post($description) : '';
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

			return !empty($description) ? wp_kses_post($description) : '';
		}

		private function render_archive_meta($atts) {
			$meta_key = $atts['meta_key'];
			if (empty($meta_key)) {
				return '';
			}

			$meta_value = '';

			global $wp_query;
			if (!empty($wp_query->loop_term) && $wp_query->loop_term instanceof WP_Term) {
				$meta_value = get_term_meta($wp_query->loop_term->term_id, $meta_key, true);
			} elseif (is_category() || is_tag() || is_tax()) {
				$term = get_queried_object();
				if ($term && isset($term->term_id)) {
					$meta_value = get_term_meta($term->term_id, $meta_key, true);
				}
			} elseif (is_author()) {
				$author = get_queried_object();
				if ($author && isset($author->ID)) {
					$meta_value = get_user_meta($author->ID, $meta_key, true);
				}
			}

			return !empty($meta_value) ? wp_kses_post($meta_value) : '';
		}

		private function render_archive_title($atts) {
			$include_context = pixfort_dynamic_is_truthy($atts['include_context']);
			$title = '';

			global $wp_query;
			if (!empty($wp_query->loop_term) && $wp_query->loop_term instanceof WP_Term) {
				$term = $wp_query->loop_term;
				if ($include_context) {
					$taxonomy = get_taxonomy($term->taxonomy);
					$prefix = $taxonomy ? $taxonomy->labels->singular_name . ': ' : '';
					$title = $prefix . $term->name;
				} else {
					$title = $term->name;
				}

				return wp_kses_post($title);
			}

			if (!is_archive()) {
				return '';
			}

			if (is_category() || is_tag() || is_tax()) {
				$title = $include_context ? get_the_archive_title() : single_term_title('', false);
			} elseif (is_author()) {
				$title = $include_context ? get_the_archive_title() : get_the_author();
			} elseif (is_post_type_archive()) {
				$title = $include_context ? get_the_archive_title() : post_type_archive_title('', false);
			} elseif (is_date()) {
				$title = get_the_archive_title();
				if (!$include_context) {
					$title = preg_replace('/^[^:]+:\s*/', '', $title);
				}
			} else {
				$title = get_the_archive_title();
				if (!$include_context) {
					$title = preg_replace('/^[^:]+:\s*/', '', $title);
				}
			}

			return wp_kses_post($title);
		}

		private function render_archive_url($atts) {
			$url = '';

			global $wp_query;
			if (!empty($wp_query->loop_term) && $wp_query->loop_term instanceof WP_Term) {
				$url = get_term_link($wp_query->loop_term);
				if (!is_wp_error($url)) {
					return esc_url($url);
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

			if (empty($url) || is_wp_error($url)) {
				global $wp;
				$url = home_url($wp->request);
			}

			return $url ? esc_url($url) : '';
		}

		private function render_category_image($atts) {
			$term_id = null;

			global $wp_query;
			if (!empty($wp_query->loop_term) && $wp_query->loop_term instanceof WP_Term) {
				$term_id = $wp_query->loop_term->term_id;
			} elseif (is_category()) {
				$term = get_queried_object();
				if ($term && isset($term->term_id)) {
					$term_id = $term->term_id;
				}
			} elseif (class_exists('WooCommerce') && is_product_category()) {
				$term = get_queried_object();
				if ($term && isset($term->term_id)) {
					$term_id = $term->term_id;
				}
			} elseif (is_tax()) {
				$term = get_queried_object();
				if ($term && isset($term->term_id)) {
					$term_id = $term->term_id;
				}
			} elseif (is_single() && get_the_category()) {
				$categories = get_the_category();
				if (!empty($categories) && isset($categories[0]->term_id)) {
					$term_id = $categories[0]->term_id;
				}
			} elseif (class_exists('WooCommerce') && is_product()) {
				$product_categories = get_the_terms(get_the_ID(), 'product_cat');
				if (!empty($product_categories) && !is_wp_error($product_categories)) {
					$term_id = $product_categories[0]->term_id;
				}
			}

			if ($term_id) {
				$thumbnail_id = get_term_meta($term_id, 'category_intro_img', true);
				if ($thumbnail_id) {
					$image_url = wp_get_attachment_image_src($thumbnail_id, 'full');
					if ($image_url && isset($image_url[0])) {
						return esc_url($image_url[0]);
					}
				}
			}

			$fallback_url = $this->get_fallback_url($atts);

			return $fallback_url ? esc_url($fallback_url) : '';
		}

		private function render_author_info($atts) {
			$author_id = pixfort_dynamic_get_author_id();
			if (!$author_id) {
				return '';
			}

			$value = '';

			switch ($atts['type']) {
				case 'display_name':
					$value = get_the_author_meta('display_name', $author_id);
					break;
				case 'description':
					$value = get_the_author_meta('description', $author_id);
					break;
				case 'email':
					$value = get_the_author_meta('user_email', $author_id);
					break;
				case 'website':
					$value = get_the_author_meta('user_url', $author_id);
					break;
				case 'posts_url':
					$value = get_author_posts_url($author_id);
					break;
				case 'first_name':
					$value = get_the_author_meta('first_name', $author_id);
					break;
				case 'last_name':
					$value = get_the_author_meta('last_name', $author_id);
					break;
				case 'nickname':
					$value = get_the_author_meta('nickname', $author_id);
					break;
				default:
					$value = get_the_author_meta('display_name', $author_id);
					break;
			}

			if (empty($value)) {
				return '';
			}

			if (!empty($atts['link_to']) && !in_array($atts['type'], ['posts_url', 'website'], true)) {
				$link_url = '';

				if ('posts_url' === $atts['link_to']) {
					$link_url = get_author_posts_url($author_id);
				} elseif ('website' === $atts['link_to']) {
					$link_url = get_the_author_meta('user_url', $author_id);
				}

				if (!empty($link_url)) {
					return sprintf('<a href="%s">%s</a>', esc_url($link_url), esc_html($value));
				}
			}

			if (in_array($atts['type'], ['posts_url', 'website'], true)) {
				return esc_url($value);
			}

			return wp_kses_post($value);
		}

		private function render_author_meta($atts) {
			if (empty($atts['meta_key'])) {
				return '';
			}

			if (is_author()) {
				$author_id = get_queried_object_id();
			} else {
				$author_id = get_the_author_meta('ID');
			}

			if (!$author_id) {
				return '';
			}

			$meta_value = get_user_meta($author_id, $atts['meta_key'], true);

			return !empty($meta_value) ? wp_kses_post($meta_value) : '';
		}

		private function render_author_name($atts) {
			$author_id = pixfort_dynamic_get_author_id();
			if (!$author_id) {
				return '';
			}

			$author_name = get_the_author_meta('display_name', $author_id);
			if (empty($author_name)) {
				return '';
			}

			if (!empty($atts['link_to'])) {
				$link_url = '';

				if ('posts_url' === $atts['link_to']) {
					$link_url = get_author_posts_url($author_id);
				} elseif ('website' === $atts['link_to']) {
					$link_url = get_the_author_meta('user_url', $author_id);
				}

				if (!empty($link_url)) {
					return sprintf('<a href="%s">%s</a>', esc_url($link_url), esc_html($author_name));
				}
			}

			return esc_html($author_name);
		}

		private function render_author_profile_picture($atts) {
			$author_id = pixfort_dynamic_get_author_id();
			if (!$author_id) {
				$fallback_url = $this->get_fallback_url($atts);
				return $fallback_url ? esc_url($fallback_url) : '';
			}

			$size = !empty($atts['size']) ? (int) $atts['size'] : 96;
			$avatar_url = get_avatar_url($author_id, ['size' => $size]);

			return $avatar_url ? esc_url($avatar_url) : '';
		}

		private function render_author_url($atts) {
			$author_id = pixfort_dynamic_get_author_id();
			if (!$author_id) {
				return '';
			}

			if ('website' === $atts['type']) {
				$url = get_the_author_meta('user_url', $author_id);
			} else {
				$url = get_author_posts_url($author_id);
			}

			return $url ? esc_url($url) : '';
		}

		private function render_acf_text($atts) {
			if (!class_exists('ACF') || !function_exists('pixfort_dynamic_acf_text_shortcode')) {
				return '';
			}

			$field_key = $this->get_acf_field_key($atts);
			if (empty($field_key)) {
				return '';
			}

			return pixfort_dynamic_acf_text_shortcode(['key' => $field_key]);
		}

		private function render_acf_image($atts) {
			if (!class_exists('ACF') || !function_exists('pixfort_dynamic_acf_image_shortcode')) {
				return '';
			}

			$field_key = $this->get_acf_field_key($atts);
			if (empty($field_key)) {
				return '';
			}

			return pixfort_dynamic_acf_image_shortcode([
				'key' => $field_key,
				'fallback' => $atts['fallback'],
				'fallback_id' => $atts['fallback_id'],
				'fallback_url' => $atts['fallback_url'],
			]);
		}

		private function render_acf_url($atts) {
			if (!class_exists('ACF') || !function_exists('pixfort_dynamic_acf_url_shortcode')) {
				return '';
			}

			$field_key = $this->get_acf_field_key($atts);
			if (empty($field_key)) {
				return '';
			}

			return pixfort_dynamic_acf_url_shortcode([
				'key' => $field_key,
				'fallback' => $atts['fallback'],
			]);
		}

		private function render_acf_gallery($atts) {
			if (!class_exists('ACF') || !function_exists('pixfort_dynamic_acf_gallery_shortcode')) {
				return '';
			}

			$field_key = $this->get_acf_field_key($atts);
			if (empty($field_key)) {
				return '';
			}

			return pixfort_dynamic_acf_gallery_shortcode(['key' => $field_key]);
		}

		private function render_acf_file($atts) {
			if (!class_exists('ACF') || !function_exists('pixfort_dynamic_acf_file_shortcode')) {
				return '';
			}

			$field_key = $this->get_acf_field_key($atts);
			if (empty($field_key)) {
				return '';
			}

			return pixfort_dynamic_acf_file_shortcode([
				'key' => $field_key,
				'fallback' => $atts['fallback'],
				'fallback_id' => $atts['fallback_id'],
				'fallback_url' => $atts['fallback_url'],
			]);
		}

		private function render_acf_number($atts) {
			if (!class_exists('ACF') || !function_exists('pixfort_dynamic_acf_number_shortcode')) {
				return '';
			}

			$field_key = $this->get_acf_field_key($atts);
			if (empty($field_key)) {
				return '';
			}

			return pixfort_dynamic_acf_number_shortcode(['key' => $field_key]);
		}

		private function render_acf_color($atts) {
			if (!class_exists('ACF') || !function_exists('pixfort_dynamic_acf_color_shortcode')) {
				return '';
			}

			$field_key = $this->get_acf_field_key($atts);
			if (empty($field_key)) {
				return '';
			}

			return pixfort_dynamic_acf_color_shortcode([
				'key' => $field_key,
				'fallback' => $atts['fallback'],
			]);
		}

		private function render_acf_date_time($atts) {
			if (!class_exists('ACF') || !function_exists('pixfort_dynamic_acf_date_time_shortcode')) {
				return '';
			}

			$field_key = $this->get_acf_field_key($atts);
			if (empty($field_key)) {
				return '';
			}

			return pixfort_dynamic_acf_date_time_shortcode([
				'key' => $field_key,
				'fallback' => $atts['fallback'],
			]);
		}
	}

	Pixfort_Dynamic_Shortcode::register();
}
