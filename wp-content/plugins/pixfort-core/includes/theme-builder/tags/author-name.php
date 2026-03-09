<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Author_Name')) {
	class Author_Name extends \Elementor\Core\DynamicTags\Tag {
		public function get_name() {
			return 'author-name';
		}

		public function get_title() {
			return esc_html__('Author Name', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-author'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
		}

		protected function register_controls() {
			$this->add_control(
				'link_to',
				[
					'label' => esc_html__('Link', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => esc_html__('None', 'pixfort-core'),
						'posts_url' => esc_html__('Author Posts', 'pixfort-core'),
						'website' => esc_html__('Author Website', 'pixfort-core'),
					],
				]
			);
		}

		public function render() {
			$settings = $this->get_settings_for_display();
			$link_to = $settings['link_to'];

			// Get author ID through multiple fallback methods
			$author_id = $this->get_author_id();

			if (!$author_id) {
				return;
			}

			$author_name = get_the_author_meta('display_name', $author_id);

			if (empty($author_name)) {
				return;
			}

			// Add link if specified
			if (!empty($link_to)) {
				$link_url = '';
				
				if ('posts_url' === $link_to) {
					$link_url = get_author_posts_url($author_id);
				} elseif ('website' === $link_to) {
					$link_url = get_the_author_meta('user_url', $author_id);
				}

				if (!empty($link_url)) {
					printf('<a href="%s">%s</a>', esc_url($link_url), esc_html($author_name));
				} else {
					echo esc_html($author_name);
				}
			} else {
				echo esc_html($author_name);
			}
		}

		/**
		 * Get author ID with multiple fallback methods
		 */
		private function get_author_id() {
			global $post;
			
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
