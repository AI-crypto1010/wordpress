<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Author_Info')) {
	class Author_Info extends \Elementor\Core\DynamicTags\Tag {
		public function get_name() {
			return 'author-info';
		}

		public function get_title() {
			return esc_html__('Author Info', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-author'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
		}

		protected function register_controls() {
			$this->add_control(
				'type',
				[
					'label' => esc_html__('Type', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'display_name',
					'options' => [
						'display_name' => esc_html__('Display Name', 'pixfort-core'),
						'description' => esc_html__('Biographical Info', 'pixfort-core'),
						'email' => esc_html__('Email', 'pixfort-core'),
						'website' => esc_html__('Website', 'pixfort-core'),
						'posts_url' => esc_html__('Posts URL', 'pixfort-core'),
						'first_name' => esc_html__('First Name', 'pixfort-core'),
						'last_name' => esc_html__('Last Name', 'pixfort-core'),
						'nickname' => esc_html__('Nickname', 'pixfort-core'),
					],
				]
			);

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
					'condition' => [
						'type!' => ['posts_url', 'website'],
					],
				]
			);
		}

		public function render() {
			$settings = $this->get_settings_for_display();
			$type = $settings['type'];
			$link_to = $settings['link_to'];

			// Get author ID through multiple fallback methods
			$author_id = $this->get_author_id();

			if (!$author_id) {
				return;
			}

			$value = '';

			switch ($type) {
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
			}

			if (empty($value)) {
				return;
			}

			// Add link if specified
			if (!empty($link_to) && !in_array($type, ['posts_url', 'website'])) {
				$link_url = '';
				
				if ('posts_url' === $link_to) {
					$link_url = get_author_posts_url($author_id);
				} elseif ('website' === $link_to) {
					$link_url = get_the_author_meta('user_url', $author_id);
				}

				if (!empty($link_url)) {
					$value = sprintf('<a href="%s">%s</a>', esc_url($link_url), esc_html($value));
				}
			}

			if (in_array($type, ['posts_url', 'website'])) {
				// For URLs, don't escape HTML as they might be used in href attributes
				echo esc_url($value);
			} else {
				echo wp_kses_post($value);
			}
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
