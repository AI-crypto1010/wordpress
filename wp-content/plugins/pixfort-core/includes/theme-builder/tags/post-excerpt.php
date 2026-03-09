<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Post_Excerpt')) {
	class Post_Excerpt extends \Elementor\Core\DynamicTags\Tag {
		public function get_name() {
			return 'post-excerpt';
		}

		public function get_title() {
			return esc_html__('Post Excerpt', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-post'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
		}

		protected function register_controls() {
			$this->add_control(
				'max_length',
				[
					'label' => esc_html__('Excerpt Length', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'description' => esc_html__('Leave empty for full excerpt', 'pixfort-core'),
				]
			);

			$this->add_control(
				'apply_to_post_content',
				[
					'label' => esc_html__('Apply to post content', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__('Yes', 'pixfort-core'),
					'label_off' => esc_html__('No', 'pixfort-core'),
					'default' => 'no',
				]
			);
		}

		public function render() {
			$post = get_post();
			$settings = $this->get_settings_for_display();

			if (!$this->is_post_excerpt_valid($settings, $post)) {
				return;
			}

			$max_length = (int) $settings['max_length'];
			$excerpt = $this->get_post_excerpt($settings, $post);

			if ($max_length > 0) {
				$excerpt = $this->trim_words($excerpt, $max_length);
			}

			echo wp_kses_post($excerpt);
		}

		private function should_get_excerpt_from_post_content($settings) {
			return 'yes' === $settings['apply_to_post_content'];
		}

		private function is_post_excerpt_valid($settings, $post) {
			if (!$post) {
				return false;
			}

			if (empty($post->post_excerpt) && !$this->should_get_excerpt_from_post_content($settings)) {
				return false;
			}

			if (empty($post->post_excerpt) && empty($post->post_content) && $this->should_get_excerpt_from_post_content($settings)) {
				return false;
			}

			if (empty($post->post_excerpt) && empty($post->post_content)) {
				return false;
			}

			return true;
		}

		private function get_post_excerpt($settings, $post) {
			$post_excerpt = $post->post_excerpt ?? '';

			if (empty($post_excerpt) && !empty($post->post_content) && $this->should_get_excerpt_from_post_content($settings)) {
				$post_excerpt = apply_filters('the_excerpt', get_the_excerpt($post));
			}

			return $post_excerpt;
		}

		/**
		 * Trim words to specified length
		 * Simplified version without Elementor Pro dependencies
		 */
		private function trim_words($text, $max_length) {
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
}
