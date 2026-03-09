<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Author_Profile_Picture')) {
	class Author_Profile_Picture extends \Elementor\Core\DynamicTags\Data_Tag {
		public function get_name() {
			return 'author-profile-picture';
		}

		public function get_title() {
			return esc_html__('Author Profile Picture', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-author'];
		}

		public function get_categories() {
			return [
				\Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY,
				\Elementor\Modules\DynamicTags\Module::MEDIA_CATEGORY,
			];
		}

		protected function register_controls() {
			$this->add_control(
				'size',
				[
					'label' => esc_html__('Size', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'default' => 96,
					'description' => esc_html__('Avatar size in pixels', 'pixfort-core'),
				]
			);

			$this->add_control(
				'fallback',
				[
					'label' => esc_html__('Fallback', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'description' => esc_html__('Image to use if author has no profile picture', 'pixfort-core'),
				]
			);
		}

		public function get_value(array $options = []) {
			$settings = $this->get_settings_for_display();
			$size = !empty($settings['size']) ? $settings['size'] : 96;

			// Get author ID through multiple fallback methods
			$author_id = $this->get_author_id();

			if (!$author_id) {
				return $this->get_fallback_image();
			}

			// Always return the avatar URL
			$avatar_url = get_avatar_url($author_id, ['size' => $size]);

			return [
				'id' => '',
				'url' => $avatar_url,
			];
		}

		/**
		 * Get author ID with multiple fallback methods
		 */
		private function get_author_id() {
			global $post, $authordata;
			
			$author_id = 0;

			// Method 1: If we're on an author archive page
			if (is_author()) {
				$author_obj = get_queried_object();
				if ($author_obj && isset($author_obj->ID)) {
					$author_id = $author_obj->ID;
				}
			}

			// Method 2: If we have a post context
			if (!$author_id && $post && isset($post->post_author)) {
				$author_id = $post->post_author;
			}
            
			// Method 3: Try to get from global authordata
			if (!$author_id && $authordata && isset($authordata->ID)) {
				$author_id = $authordata->ID;
			}

			// Method 4: Try get_the_author_meta with setup_postdata first
			if (!$author_id && $post) {
				global $wp_query;
				$old_post = $wp_query->post;
				$wp_query->post = $post;
				setup_postdata($post);
				$author_id = get_the_author_meta('ID');
				$wp_query->post = $old_post;
				wp_reset_postdata();
			}

			// Method 5: Direct query if we have a post ID from context
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

		private function get_fallback_image() {
			$fallback = $this->get_settings('fallback');
			
			if (!empty($fallback['id'])) {
				return [
					'id' => $fallback['id'],
					'url' => $fallback['url'],
				];
			}

			return [
				'id' => '',
				'url' => '',
			];
		}
	}
}
