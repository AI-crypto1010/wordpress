<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Post_Date')) {
	class Post_Date extends \Elementor\Core\DynamicTags\Tag {
		public function get_name() {
			return 'post-date';
		}

		public function get_title() {
			return esc_html__('Post Date', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-post'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
		}

		protected function register_controls() {
			$this->add_control(
				'date_format',
				[
					'label' => esc_html__('Date Format', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default' => esc_html__('Default', 'pixfort-core'),
						'F j, Y' => date('F j, Y'),
						'Y-m-d' => date('Y-m-d'),
						'j M Y' => date('j M Y'),
						'm/d/Y' => date('m/d/Y'),
						'd/m/Y' => date('d/m/Y'),
						'custom' => esc_html__('Custom', 'pixfort-core'),
					],
				]
			);

			$this->add_control(
				'custom_format',
				[
					'label' => esc_html__('Custom Format', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => 'F j, Y',
					'condition' => [
						'date_format' => 'custom',
					],
					'description' => sprintf(
						/* translators: %s: Link to WordPress date formatting documentation */
						esc_html__('Use the format characters from the %s', 'pixfort-core'),
						'<a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank">' . esc_html__('WordPress date formatting documentation', 'pixfort-core') . '</a>'
					),
				]
			);

			$this->add_control(
				'date_type',
				[
					'label' => esc_html__('Type', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'publish',
					'options' => [
						'publish' => esc_html__('Publish Date', 'pixfort-core'),
						'modified' => esc_html__('Modified Date', 'pixfort-core'),
					],
				]
			);
		}

		public function render() {
			$settings = $this->get_settings_for_display();
			$date_format = $settings['date_format'];
			$date_type = $settings['date_type'];

			if ('default' === $date_format) {
				$date_format = get_option('date_format');
			} elseif ('custom' === $date_format) {
				$date_format = $settings['custom_format'];
			}

			if ('modified' === $date_type) {
				$date = get_the_modified_date($date_format);
			} else {
				$date = get_the_date($date_format);
			}

			echo esc_html($date);
		}
	}
}
