<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Pixfort_Category_Image')) {
	class Pixfort_Category_Image extends \Elementor\Core\DynamicTags\Data_Tag {
		public function get_name() {
			return 'pixfort-category-image';
		}

		public function get_title() {
			return esc_html__('Category Image', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-archive'];
		}

		public function get_categories() {
			return [
				\Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY,
				\Elementor\Modules\DynamicTags\Module::MEDIA_CATEGORY,
			];
		}

		protected function register_controls() {
			$this->add_control(
				'fallback',
				[
					'label' => esc_html__('Fallback', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'description' => esc_html__('Image to use if category has no image', 'pixfort-core'),
				]
			);
		}

		public function get_value(array $options = []) {
			$term_id = null;
			$thumbnail_id = null;

			// Check for Loop Grid taxonomy context first
			global $wp_query;
			if (!empty($wp_query->loop_term) && $wp_query->loop_term instanceof \WP_Term) {
				$term_id = $wp_query->loop_term->term_id;
			} elseif (is_category()) {
				// Get category term ID from current context
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
				// On single post, get the first category of the post
				$categories = get_the_category();
				if (!empty($categories) && isset($categories[0]->term_id)) {
					$term_id = $categories[0]->term_id;
				}
			} elseif (class_exists('WooCommerce') && is_product()) {
				// On single product, get product categories
				$product_categories = get_the_terms(get_the_ID(), 'product_cat');
				if (!empty($product_categories) && !is_wp_error($product_categories)) {
					$term_id = $product_categories[0]->term_id;
				}
			}

			// Get the image from term meta
			if ($term_id) {
				$thumbnail_id = get_term_meta($term_id, 'category_intro_img', true);
			}
			
			

			// Return image data if found
			if ($thumbnail_id) {
				$image_url = wp_get_attachment_image_src($thumbnail_id, 'full');
				if ($image_url && isset($image_url[0])) {
					return [
						'id' => $thumbnail_id,
						'url' => $image_url[0],
					];
				}
			}

			// Return fallback if set
			$fallback = $this->get_settings('fallback');
			if (!empty($fallback['id'])) {
				return [
					'id' => $fallback['id'],
					'url' => $fallback['url'],
				];
			}

			// Return empty array if no image found
			return [
				'id' => '',
				'url' => '',
			];
		}
	}
}

