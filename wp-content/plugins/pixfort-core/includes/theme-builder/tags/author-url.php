<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Author_URL')) {
	class Author_URL extends \Elementor\Core\DynamicTags\Data_Tag {
		public function get_name() {
			return 'author-url';
		}

		public function get_title() {
			return esc_html__('Author URL', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-author'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::URL_CATEGORY];
		}

		protected function register_controls() {
			$this->add_control(
				'type',
				[
					'label' => esc_html__('Type', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'posts',
					'options' => [
						'posts' => esc_html__('Author Posts Archive', 'pixfort-core'),
						'website' => esc_html__('Author Website', 'pixfort-core'),
					],
				]
			);
		}

		public function get_value(array $options = []) {
			$settings = $this->get_settings_for_display();
			$type = $settings['type'];

			// Get author ID through multiple fallback methods
			$author_id = $this->get_author_id();

			if (!$author_id) {
				return '';
			}

			$url = '';

			if ('website' === $type) {
				$url = get_the_author_meta('user_url', $author_id);
			} else {
				$url = get_author_posts_url($author_id);
			}

			return $url;
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

			// Method 3: Direct query if we have a post ID from context
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
}
