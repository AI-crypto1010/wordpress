<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Pixfort_WPBakery_Dynamic_Shortcode_UI')) {
	class Pixfort_WPBakery_Dynamic_Shortcode_UI {
		public static function init() {
			add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_admin_assets']);
			add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_frontend_assets']);
			add_action('wp_ajax_pix_wpbakery_internal_url_search', [__CLASS__, 'internal_url_search']);
		}

		private static function is_wpbakery_available() {
			return class_exists('Vc_Manager') || defined('WPB_VC_VERSION') || function_exists('vc_map');
		}

		private static function should_enqueue_admin($hook) {
			if (!self::is_wpbakery_available()) {
				return false;
			}

			if (!function_exists('get_current_screen')) {
				return false;
			}

			$screen = get_current_screen();
			if (!$screen) {
				return false;
			}

			if (!in_array($screen->base, ['post', 'post-new'], true)) {
				return false;
			}

			return true;
		}

		public static function enqueue_admin_assets($hook) {
			if (!self::should_enqueue_admin($hook)) {
				return;
			}

			self::enqueue_assets();
		}

		public static function enqueue_frontend_assets() {
			if (!self::is_wpbakery_available()) {
				return;
			}

			if (function_exists('vc_is_frontend_editor') && vc_is_frontend_editor()) {
				self::enqueue_assets();
			}
		}

		private static function enqueue_assets() {
			$base_url = PIX_CORE_PLUGIN_URI . 'includes/theme-builder/wpbakery/';

			wp_enqueue_style(
				'pixfort-wpbakery-dynamic-shortcode',
				$base_url . 'pix-dynamic-wpbakery.css',
				[],
				PIXFORT_PLUGIN_VERSION
			);

			wp_enqueue_script(
				'pixfort-wpbakery-dynamic-shortcode',
				$base_url . 'pix-dynamic-wpbakery.js',
				['wp-element'],
				PIXFORT_PLUGIN_VERSION,
				true
			);

			wp_localize_script(
				'pixfort-wpbakery-dynamic-shortcode',
				'pixDynamicConfig',
				[
					'shortcode' => 'pix_dynamic',
					'ajaxUrl' => admin_url('admin-ajax.php'),
					'internalUrlNonce' => wp_create_nonce('pix_wpbakery_internal_url_search'),
				]
			);
		}

		public static function internal_url_search() {
			if (!current_user_can('edit_posts')) {
				wp_send_json_error(['message' => 'Unauthorized'], 403);
			}

			$nonce = isset($_REQUEST['nonce']) ? sanitize_text_field($_REQUEST['nonce']) : '';
			if (!wp_verify_nonce($nonce, 'pix_wpbakery_internal_url_search')) {
				wp_send_json_error(['message' => 'Invalid nonce'], 403);
			}

			$term = isset($_REQUEST['term']) ? sanitize_text_field(wp_unslash($_REQUEST['term'])) : '';
			$type = isset($_REQUEST['type']) ? sanitize_key($_REQUEST['type']) : 'post';

			if (strlen($term) < 2) {
				wp_send_json_success([]);
			}

			$results = [];
			$limit = 20;

			if ('post' === $type) {
				$post_types = apply_filters('pixfort_dynamic_internal_url_post_types', ['post', 'page', 'product', 'portfolio']);
				$post_types = array_values(array_filter($post_types, 'post_type_exists'));

				if (!empty($post_types)) {
					$query = new WP_Query([
						'post_type' => $post_types,
						'posts_per_page' => $limit,
						'post_status' => 'publish',
						's' => $term,
						'no_found_rows' => true,
					]);

					foreach ($query->posts as $post) {
						$type_obj = get_post_type_object($post->post_type);
						$type_label = $type_obj && !empty($type_obj->labels->singular_name) ? $type_obj->labels->singular_name : ucfirst($post->post_type);
						$results[] = [
							'id' => $post->ID,
							'label' => sprintf('%s (%s #%d)', $post->post_title, $type_label, $post->ID),
						];
					}
					wp_reset_postdata();
				}
			} elseif ('taxonomy' === $type) {
				$taxonomies = get_taxonomies(['public' => true], 'objects');
				if (!empty($taxonomies['post_format'])) {
					unset($taxonomies['post_format']);
				}
				$taxonomy_names = array_keys($taxonomies);
				$terms = get_terms([
					'taxonomy' => $taxonomy_names,
					'search' => $term,
					'number' => $limit,
					'hide_empty' => false,
				]);

				if (!is_wp_error($terms)) {
					foreach ($terms as $term_obj) {
						$tax_obj = isset($taxonomies[$term_obj->taxonomy]) ? $taxonomies[$term_obj->taxonomy] : null;
						$tax_label = $tax_obj && !empty($tax_obj->labels->singular_name) ? $tax_obj->labels->singular_name : $term_obj->taxonomy;
						$results[] = [
							'id' => $term_obj->term_id,
							'label' => sprintf('%s (%s #%d)', $term_obj->name, $tax_label, $term_obj->term_id),
						];
					}
				}
			} elseif ('attachment' === $type) {
				$query = new WP_Query([
					'post_type' => 'attachment',
					'posts_per_page' => $limit,
					'post_status' => 'inherit',
					's' => $term,
					'no_found_rows' => true,
				]);

				foreach ($query->posts as $post) {
					$results[] = [
						'id' => $post->ID,
						'label' => sprintf('%s (Media #%d)', $post->post_title ?: __('(no title)', 'pixfort-core'), $post->ID),
					];
				}
				wp_reset_postdata();
			} elseif ('author' === $type) {
				$user_query = new WP_User_Query([
					'search' => '*' . $term . '*',
					'search_columns' => ['user_login', 'user_nicename', 'display_name'],
					'number' => $limit,
					'fields' => ['ID', 'display_name'],
				]);

				foreach ($user_query->get_results() as $user) {
					$results[] = [
						'id' => $user->ID,
						'label' => sprintf('%s (Author #%d)', $user->display_name, $user->ID),
					];
				}
			}

			wp_send_json_success($results);
		}
	}

	Pixfort_WPBakery_Dynamic_Shortcode_UI::init();
}
