<?php

namespace Elementor;

class Pix_Eor_Template_Post_Excerpt extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-template-post-excerpt';
	}

	public function get_title() {
		return 'Post Excerpt';
	}

	public function get_icon() {
		return 'eicon-post-excerpt pixfort-elementor-element pixfort-elementor-post-excerpt';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function show_in_panel() {
		// Only show this widget when editing a pixfort_template with post type
		return $this->is_post_template_context();
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	/**
	 * Check if we're in the context of editing a pixfort_template with "post" taxonomy
	 */
	private function is_post_template_context() {
		// Check if we're in Elementor editor
		if (!Plugin::$instance->editor->is_edit_mode()) {
			return false;
		}

		// Get current post ID from Elementor
		$post_id = Plugin::$instance->editor->get_post_id();

		if (!$post_id) {
			return false;
		}

		// Check if post type is pixfort_template
		if (get_post_type($post_id) !== 'pixfort_template') {
			return false;
		}

		// Check if template type is "post" or "template"
		$terms = get_the_terms($post_id, 'pixfort_template_type');
		if ($terms && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				if ($term->slug === 'post' || $term->slug === 'template') {
					return true;
				}
			}
		}

		return false;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __('Content', 'pixfort-core'),
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label' => __('Excerpt Length', 'pixfort-core'),
				'type' => Controls_Manager::NUMBER,
				'default' => 55,
				'min' => 1,
				'max' => 300,
				'step' => 1,
				'description' => __('Number of words to show in the excerpt.', 'pixfort-core'),
			]
		);

		// $this->add_control(
		// 	'more_text',
		// 	[
		// 		'label' => __('More Text', 'pixfort-core'),
		// 		'type' => Controls_Manager::TEXT,
		// 		'default' => __('Read More', 'pixfort-core'),
		// 		'description' => __('Text to append after the excerpt.', 'pixfort-core'),
		// 	]
		// );

		// $this->add_control(
		// 	'show_more_link',
		// 	[
		// 		'label' => __('Show More Link', 'pixfort-core'),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_on' => __('Yes', 'pixfort-core'),
		// 		'label_off' => __('No', 'pixfort-core'),
		// 		'return_value' => 'yes',
		// 		'default' => 'yes',
		// 	]
		// );

		$this->add_control(
			'html_tag',
			[
				'label' => __('HTML Tag', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'div',
				'options' => [
					'div' => 'div',
					'p' => 'p',
					'span' => 'span',
				],
			]
		);

		$this->end_controls_section();

		// Style section
		$this->start_controls_section(
			'section_style',
			[
				'label' => __('Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __('Text Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-post-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .pix-post-excerpt',
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => __('Alignment', 'pixfort-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'pixfort-core'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'pixfort-core'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'pixfort-core'),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __('Justified', 'pixfort-core'),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label' => __('Margin', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// More Link Style section
		// $this->start_controls_section(
		// 	'section_more_link_style',
		// 	[
		// 		'label' => __('More Link Style', 'pixfort-core'),
		// 		'tab' => Controls_Manager::TAB_STYLE,
		// 		'condition' => [
		// 			'show_more_link' => 'yes',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'more_link_color',
		// 	[
		// 		'label' => __('Link Color', 'pixfort-core'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-post-excerpt .more-link' => 'color: {{VALUE}};',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'more_link_hover_color',
		// 	[
		// 		'label' => __('Link Hover Color', 'pixfort-core'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-post-excerpt .more-link:hover' => 'color: {{VALUE}};',
		// 		],
		// 	]
		// );

		// $this->add_group_control(
		// 	Group_Control_Typography::get_type(),
		// 	[
		// 		'name' => 'more_link_typography',
		// 		'selector' => '{{WRAPPER}} .pix-post-excerpt .more-link',
		// 	]
		// );

		// $this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$tag = $settings['html_tag'];

		// Get the post excerpt
		$excerpt = '';
		if (Plugin::$instance->editor->is_edit_mode()) {
			// In editor mode, show placeholder
			$excerpt = __('This is a sample post excerpt that will be replaced with the actual post excerpt when viewing the post. You can customize the appearance and length of the excerpt using the widget settings.', 'pixfort-core');
		} else {
			// Get actual excerpt
			$post = get_post();
			if ($post) {
				if (has_excerpt($post)) {
					$excerpt = get_the_excerpt($post);
				} else {
					$excerpt = wp_trim_words($post->post_content, $settings['excerpt_length'], '...');
				}
			}
		}

		// Trim excerpt to specified length
		if (!empty($settings['excerpt_length']) && $settings['excerpt_length'] > 0) {
			$excerpt = wp_trim_words($excerpt, $settings['excerpt_length'], '...');
		}

		// Add more link if enabled
		// $more_link = '';
		// if ($settings['show_more_link'] === 'yes' && !empty($settings['more_text'])) {
		// 	$permalink = Plugin::$instance->editor->is_edit_mode() ? '#' : get_permalink();
		// 	$more_link = ' <a href="' . esc_url($permalink) . '" class="more-link">' . esc_html($settings['more_text']) . '</a>';
		// }

		// Render the excerpt
		// echo "<{$tag} class=\"pix-post-excerpt\">" . wp_kses_post($excerpt) . $more_link . "</{$tag}>";
		echo "<{$tag} class=\"pix-post-excerpt\">" . wp_kses_post($excerpt) . "</{$tag}>";
	}
}
