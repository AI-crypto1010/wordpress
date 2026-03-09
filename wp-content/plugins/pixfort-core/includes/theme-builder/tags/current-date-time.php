<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Current_Date_Time')) {
	class Current_Date_Time extends \Elementor\Core\DynamicTags\Tag {
		public function get_name() {
			return 'current-date-time';
		}

		public function get_title() {
			return esc_html__('Current Date Time', 'pixfort-core');
		}

		public function get_group() {
			return ['pixfort-site'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
		}

		protected function register_controls() {
			$this->add_control(
				'date_format',
				[
					'label' => esc_html__('Format', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default' => esc_html__('Default', 'pixfort-core'),
						'F j, Y' => date('F j, Y'),
						'Y-m-d' => date('Y-m-d'),
						'j M Y' => date('j M Y'),
						'm/d/Y' => date('m/d/Y'),
						'd/m/Y' => date('d/m/Y'),
						'F j, Y g:i a' => date('F j, Y g:i a'),
						'Y-m-d H:i:s' => date('Y-m-d H:i:s'),
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
						/* translators: %s: Link to PHP date formatting documentation */
						esc_html__('Use the format characters from the %s', 'pixfort-core'),
						'<a href="https://php.net/manual/en/function.date.php" target="_blank">' . esc_html__('PHP date formatting documentation', 'pixfort-core') . '</a>'
					),
				]
			);
		}

		public function render() {
			$settings = $this->get_settings_for_display();
			$date_format = $settings['date_format'];

			if ('default' === $date_format) {
				$date_format = get_option('date_format') . ' ' . get_option('time_format');
			} elseif ('custom' === $date_format) {
				$date_format = $settings['custom_format'];
			}

			$date = wp_date($date_format);
			echo esc_html($date);
		}
	}
}
