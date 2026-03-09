<?php

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('Post_Featured_Image')) {
	class Post_Featured_Image extends \Elementor\Core\DynamicTags\Data_Tag {

		public function get_name() {
			return 'post-featured-image';
		}

		public function get_group() {
			return ['pixfort-post'];
		}

		public function get_categories() {
			return [
				\Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY,
				\Elementor\Modules\DynamicTags\Module::MEDIA_CATEGORY,
			];
		}

		public function get_title() {
			return esc_html__('Featured Image', 'pixfort-core');
		}

		public function get_value(array $options = []) {
			$thumbnail_id = get_post_thumbnail_id();

			if (is_category() || (class_exists('WooCommerce') && is_product_category())) {
				$term_id = get_queried_object()->term_id;
				$thumbnail_id = get_term_meta($term_id, 'category_intro_img', true);
			} else if (is_author()) {
				$thumbnail_id = false;
			}

			if ($thumbnail_id) {
				$image_data = [
					'id' => $thumbnail_id,
					'url' => wp_get_attachment_image_src($thumbnail_id, 'full')[0],
				];
			} else {
				$image_data = $this->get_settings('fallback');
			}

			return $image_data;
		}

		protected function register_controls() {
			$this->add_control(
				'fallback',
				[
					'label' => esc_html__('Fallback', 'elementor-pro'),
					'type' => \Elementor\Controls_Manager::MEDIA,
				]
			);
		}
	}
}
