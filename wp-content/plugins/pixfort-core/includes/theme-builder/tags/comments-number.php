<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Comments_Number')) {
	class Comments_Number extends \Elementor\Core\DynamicTags\Tag {
		public function get_name() {
			return 'comments-number';
		}

		public function get_title() {
			return esc_html__('Comments Number', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-post'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
		}

		protected function register_controls() {
			$this->add_control(
				'format_no_comments',
				[
					'label' => esc_html__('No Comments Format', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__('No Comments', 'pixfort-core'),
				]
			);

			$this->add_control(
				'format_one_comment',
				[
					'label' => esc_html__('One Comment Format', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__('One Comment', 'pixfort-core'),
				]
			);

			$this->add_control(
				'format_multiple_comments',
				[
					'label' => esc_html__('Multiple Comments Format', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__('% Comments', 'pixfort-core'),
					'description' => esc_html__('Use % as placeholder for the number', 'pixfort-core'),
				]
			);

			$this->add_control(
				'link_to_comments',
				[
					'label' => esc_html__('Link to Comments', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'default' => '',
				]
			);
		}

		public function render() {
			$settings = $this->get_settings_for_display();
			$post_id = get_the_ID();

			if (!$post_id) {
				return;
			}

			$comments_number = get_comments_number($post_id);
			$format_no_comments = $settings['format_no_comments'];
			$format_one_comment = $settings['format_one_comment'];
			$format_multiple_comments = $settings['format_multiple_comments'];
			$link_to_comments = 'yes' === $settings['link_to_comments'];

			if ($comments_number == 0) {
				$comments_text = $format_no_comments;
			} elseif ($comments_number == 1) {
				$comments_text = $format_one_comment;
			} else {
				$comments_text = str_replace('%', $comments_number, $format_multiple_comments);
			}

			if ($link_to_comments && $comments_number > 0) {
				$comments_link = get_comments_link($post_id);
				printf('<a href="%s">%s</a>', esc_url($comments_link), esc_html($comments_text));
			} else {
				echo esc_html($comments_text);
			}
		}
	}
}
