<?php

namespace Elementor;

class Pix_Eor_Template_Author_Box extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-template-author-box';
	}

	public function get_title() {
		return 'Author Box';
	}

	public function get_icon() {
		return 'eicon-person pixfort-elementor-element pixfort-elementor-author-box';
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

		// Check if template type is "post", "page", or "template"
		$terms = get_the_terms($post_id, 'pixfort_template_type');
		if ($terms && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				if ($term->slug === 'post' || $term->slug === 'page' || $term->slug === 'template') {
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
			'show_avatar',
			[
				'label' => __('Show Avatar', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'avatar_size',
			[
				'label' => __('Avatar Size', 'pixfort-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 200,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'condition' => [
					'show_avatar' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_name',
			[
				'label' => __('Show Name', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'link_to_author',
			[
				'label' => __('Link to Author Page', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'show_name' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_biography',
			[
				'label' => __('Show Biography', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'biography_length',
			[
				'label' => __('Biography Length', 'pixfort-core'),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
				'max' => 300,
				'description' => __('Number of words to show. Set to 0 for full biography.', 'pixfort-core'),
				'condition' => [
					'show_biography' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_job',
			[
				'label' => __('Show Job Title', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_url',
			[
				'label' => __('Show Website URL', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		// Container Style section
		$this->start_controls_section(
			'section_container_style',
			[
				'label' => __('Container', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __('Background Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-author-box' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'shadow',
			[
				'label' => __('Shadow Style', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					"0" => "Default",
					"1"       => "Small shadow",
					"2"       => "Medium shadow",
					"3"       => "Large shadow",
					"4"       => "Inverse Small shadow",
					"5"       => "Inverse Medium shadow",
					"6"       => "Inverse Large shadow",
				),
				'default' => '1',
			]
		);
		$this->add_control(
			'hover_effect',
			[
				'label' => __('Shadow Hover Style', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					""       => "None",
					"1"       => "Small hover shadow",
					"2"       => "Medium hover shadow",
					"3"       => "Large hover shadow",
					"4"       => "Inverse Small hover shadow",
					"5"       => "Inverse Medium hover shadow",
					"6"       => "Inverse Large hover shadow",
				),
				'default' => '',
			]
		);
		$this->add_control(
			'add_hover_effect',
			[
				'label' => __('Hover Animation', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					""       => "None",
					"1"       => "Fly Small",
					"2"       => "Fly Medium",
					"3"       => "Fly Large",
					"4"       => "Scale Small",
					"5"       => "Scale Medium",
					"6"       => "Scale Large",
					"7"       => "Scale Inverse Small",
					"8"       => "Scale Inverse Medium",
					"9"       => "Scale Inverse Large",
				),
				'default' => '',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'container_border',
				'selector' => '{{WRAPPER}} .pix-author-box',
			]
		);

		$this->add_responsive_control(
			'container_border_radius',
			[
				'label' => __('Border Radius', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-author-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label' => __('Padding', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-author-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// $this->add_responsive_control(
		// 	'container_margin',
		// 	[
		// 		'label' => __('Margin', 'pixfort-core'),
		// 		'type' => Controls_Manager::DIMENSIONS,
		// 		'size_units' => ['px', 'em', '%'],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-author-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 		],
		// 	]
		// );

		// $this->add_responsive_control(
		// 	'alignment',
		// 	[
		// 		'label' => __('Alignment', 'pixfort-core'),
		// 		'type' => Controls_Manager::CHOOSE,
		// 		'options' => [
		// 			'left' => [
		// 				'title' => __('Left', 'pixfort-core'),
		// 				'icon' => 'eicon-text-align-left',
		// 			],
		// 			'center' => [
		// 				'title' => __('Center', 'pixfort-core'),
		// 				'icon' => 'eicon-text-align-center',
		// 			],
		// 			'right' => [
		// 				'title' => __('Right', 'pixfort-core'),
		// 				'icon' => 'eicon-text-align-right',
		// 			],
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-author-box' => 'text-align: {{VALUE}};',
		// 		],
		// 	]
		// );

		$this->end_controls_section();

		// Avatar Style section
		$this->start_controls_section(
			'section_avatar_style',
			[
				'label' => __('Avatar', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_avatar' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'avatar_border',
				'selector' => '{{WRAPPER}} .pix-author-avatar',
			]
		);

		$this->add_responsive_control(
			'avatar_border_radius',
			[
				'label' => __('Border Radius', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-author-avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_margin',
			[
				'label' => __('Margin', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-author-avatar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'avatar_shadow',
			[
				'label' => __('Shadow Style', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					"0" => "Default",
					"1"       => "Small shadow",
					"2"       => "Medium shadow",
					"3"       => "Large shadow",
					"4"       => "Inverse Small shadow",
					"5"       => "Inverse Medium shadow",
					"6"       => "Inverse Large shadow",
				),
				'default' => '1',
			]
		);

		$this->end_controls_section();

		// Name Style section
		$this->start_controls_section(
			'section_name_style',
			[
				'label' => __('Name', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_name' => 'yes',
				],
			]
		);

		$this->add_control(
			'name_color',
			[
				'label' => __('Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-author-name' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .pix-author-name a' => 'color: {{VALUE}} !important;',
				],
			]
		);

		// $this->add_control(
		// 	'name_hover_color',
		// 	[
		// 		'label' => __('Hover Color', 'pixfort-core'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-author-name a:hover' => 'color: {{VALUE}};',
		// 		],
		// 		'condition' => [
		// 			'link_to_author' => 'yes',
		// 		],
		// 	]
		// );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'selector' => '{{WRAPPER}} .pix-author-name',
			]
		);

		$this->add_responsive_control(
			'name_margin',
			[
				'label' => __('Margin', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-author-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Biography Style section
		$this->start_controls_section(
			'section_biography_style',
			[
				'label' => __('Biography', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_biography' => 'yes',
				],
			]
		);

		$this->add_control(
			'biography_color',
			[
				'label' => __('Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-author-biography' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'biography_typography',
				'selector' => '{{WRAPPER}} .pix-author-biography',
			]
		);

		$this->add_responsive_control(
			'biography_margin',
			[
				'label' => __('Margin', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-author-biography' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Job Style section
		$this->start_controls_section(
			'section_job_style',
			[
				'label' => __('Job Title', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_job' => 'yes',
				],
			]
		);

		$this->add_control(
			'job_color',
			[
				'label' => __('Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-author-job' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'job_typography',
				'selector' => '{{WRAPPER}} .pix-author-job',
			]
		);

		$this->add_responsive_control(
			'job_margin',
			[
				'label' => __('Margin', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-author-job' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// URL Style section
		$this->start_controls_section(
			'section_url_style',
			[
				'label' => __('Website URL', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_url' => 'yes',
				],
			]
		);

		// $this->add_control(
		// 	'url_color',
		// 	[
		// 		'label' => __('Color', 'pixfort-core'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-author-url' => 'color: {{VALUE}};',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'url_hover_color',
		// 	[
		// 		'label' => __('Hover Color', 'pixfort-core'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-author-url a:hover' => 'color: {{VALUE}};',
		// 		],
		// 	]
		// );

		// $this->add_group_control(
		// 	Group_Control_Typography::get_type(),
		// 	[
		// 		'name' => 'url_typography',
		// 		'selector' => '{{WRAPPER}} .pix-author-url a',
		// 	]
		// );

		$this->add_responsive_control(
			'url_margin',
			[
				'label' => __('Margin', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-author-url' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$post = get_post();
		if (!$post) {
			return;
		}

		$author_id = $post->post_author;

		// Build settings array for pixAuthorBox function
		$author_box_settings = array(
			'show_avatar' => ($settings['show_avatar'] === 'yes'),
			'shadow' => $settings['shadow'],
			'hover_effect' => $settings['hover_effect'],
			'add_hover_effect' => $settings['add_hover_effect'],
			'avatar_size' => !empty($settings['avatar_size']['size']) ? $settings['avatar_size']['size'] : 60,
			'avatar_shadow' => $settings['avatar_shadow'],
			'show_name' => ($settings['show_name'] === 'yes'),
			'link_to_author' => ($settings['link_to_author'] === 'yes'),
			'show_description' => ($settings['show_biography'] === 'yes'),
			'description_length' => !empty($settings['biography_length']) ? $settings['biography_length'] : 0,
			'show_job' => ($settings['show_job'] === 'yes'),
			'show_url' => ($settings['show_url'] === 'yes'),
			'use_default_styling' => true, // Use Elementor custom styling
		);

		// Render the author box using the pixAuthorBox function
		pixAuthorBox($author_id, $author_box_settings);
	}
}
