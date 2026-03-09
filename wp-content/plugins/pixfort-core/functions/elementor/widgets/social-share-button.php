<?php

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Pix_Eor_Social_Share_Button extends Widget_Base {

	public function get_name() {
		return 'pix-social-share-button';
	}

	public function get_title() {
		return 'Social Share Button';
	}

	public function get_icon() {
		return 'eicon-share pixfort-elementor-element pixfort-elementor-social-share-button';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_title',
			[
				'label' => __('Content', 'pixfort-core'),
			]
		);


		$this->add_control(
			'social_type',
			[
				'label' => __('Social Network', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'facebook'	=> 'Facebook',
					'x'			=> 'X (Twitter)',
					'linkedin'	=> 'LinkedIn',
					'pinterest'	=> 'Pinterest',
					'whatsapp'	=> 'WhatsApp',
					'email'		=> 'Email',
					// 'custom'	=> 'Custom',
				),
				'default' => 'facebook',
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __('Button text', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('Share on Facebook', 'pixfort-core'),
				'placeholder' => __('Share on...', 'pixfort-core'),
				'label_block' => true,
				'description' => __('Optional text to display next to the icon. Leave empty to show icon only.', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__('Icon', 'pixfort-core'),
				'type' => \Elementor\CustomControl\PixfortIconSelector_Control::PixfortIconSelector,
				'default' => 'Solid/pixfort-icon-facebook-1',
				// 'description' => __('Select icon from library. Leave empty to use default icon for the social network.', 'pixfort-core'),
			]
		);

		

		$this->add_control(
			'text_color',
			[
				'label' => __('Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'body-default',
				'selectors' => [
					'{{WRAPPER}} a' => 'color: var(--pix-{{VALUE}}) !important;',
				],
			]
		);

		$this->add_control(
			'text_custom_color',
			[
				'label' => __('Custom Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'text_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} a' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->add_control(
			'icon_color',
			[
				'label' => __('Icon Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')]]),
				'default' => '',
			]
		);

		$this->add_control(
			'icon_custom_color',
			[
				'label' => __('Custom IconColor', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} svg' => 'color: {{VALUE}};',
				],
			]
		);

		// $this->add_control(
		// 	'position',
		// 	[
		// 		'label' => __('Position', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::SELECT,
		// 		'options' => array(
		// 			'start'		=> 'Start',
		// 			'center'	=> 'Center',
		// 			'end' 		=> 'End',
		// 		),
		// 		'default' => 'center',
		// 	]
		// );

		$this->add_control(
			'animation',
			[
				'label' => __('Animation', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => pix_get_animations(true),
			]
		);

		$this->add_control(
			'delay',
			[
				'label' => __('Animation delay (in milliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('0', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					'animation!' => '',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab
		$this->start_controls_section(
			'section_style',
			[
				'label' => __('Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => __('Typography', 'pixfort-core'),
				'selector' => '{{WRAPPER}} .pix_post_social a, {{WRAPPER}} .pix_post_social a span',
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __('Icon Size', 'pixfort-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 0.5,
						'max' => 10,
						'step' => 0.1,
					],
					'rem' => [
						'min' => 0.5,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 24,
				],
				'selectors' => [
					'{{WRAPPER}} .pix_post_social a svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .pix_post_social a i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .pix_post_social a .pix-icon' => 'font-size: {{SIZE}}{{UNIT}} !important; width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label' => __('Background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')],'bg' => true, 'transparent' => true]),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pix_post_social a' => 'background: var(--pix-{{VALUE}}) !important;',
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'custom_bg_color',
			[
				'label' => __('Custom Background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'bg_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pix_post_social a' => 'background-color: {{VALUE}} !important;',
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);


		$this->add_control(
			'style',
			[
				'label' => __('Shadow Style', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					"" => "Default",
					"1"       => "Small shadow",
					"2"       => "Medium shadow",
					"3"       => "Large shadow",
					"4"       => "Inverse Small shadow",
					"5"       => "Inverse Medium shadow",
					"6"       => "Inverse Large shadow",
				),
				'default' => '',
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

		$this->add_responsive_control(
			'justify_content',
			[
				'label' => esc_html__('Justify Content', 'elementor'),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'start' => [
						'title' => esc_html__('Start', 'elementor'),
						'icon' => 'eicon-flex eicon-justify-start-h',
					],
					'center' => [
						'title' => esc_html__('Center', 'elementor'),
						'icon' => 'eicon-flex eicon-justify-center-h',
					],
					'end' => [
						'title' => esc_html__('End', 'elementor'),
						'icon' => 'eicon-flex eicon-justify-end-h',
					],
					'space-between' => [
						'title' => esc_html__('Space Between', 'elementor'),
						'icon' => 'eicon-flex eicon-justify-space-between-h',
					],
					'space-around' => [
						'title' => esc_html__('Space Around', 'elementor'),
						'icon' => 'eicon-flex eicon-justify-space-around-h',
					],
					'space-evenly' => [
						'title' => esc_html__('Space Evenly', 'elementor'),
						'icon' => 'eicon-flex eicon-justify-space-evenly-h',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pix_post_social a' => 'justify-content: {{VALUE}};',
				],
				// 'condition' => [
				// 	'direction' => 'row',
				// ],
			]
		);

		// $this->add_responsive_control(
		// 	'align_items',
		// 	[
		// 		'label' => __('Align Items', 'pixfort-core'),
		// 		'type' => Controls_Manager::CHOOSE,
		// 		'default' => '',
		// 		'options' => [
		// 			'start' => [
		// 				'title' => esc_html__('Start', 'elementor'),
		// 				'icon' => 'eicon-flex eicon-align-start-v',
		// 			],
		// 			'center' => [
		// 				'title' => esc_html__('Center', 'elementor'),
		// 				'icon' => 'eicon-flex eicon-align-center-v',
		// 			],
		// 			'end' => [
		// 				'title' => esc_html__('End', 'elementor'),
		// 				'icon' => 'eicon-flex eicon-align-end-v',
		// 			],
		// 			'stretch' => [
		// 				'title' => esc_html__('Stretch', 'elementor'),
		// 				'icon' => 'eicon-flex eicon-align-stretch-v',
		// 			],
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix_post_social a' => 'align-items: {{VALUE}};',
		// 		],
		// 		// 'condition' => [
		// 		// 	'direction' => 'column',
		// 		// ],
		// 	]
		// );

		$this->add_responsive_control(
			'gap',
			[
				'label' => __('Gap', 'pixfort-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				// 'default' => [
				// 	'size' => 20,
				// 	'unit' => 'px',
				// ],
				'selectors' => [
					'{{WRAPPER}} .pix_post_social a' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => __('Button Padding', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix_post_social a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .pix_post_social a',
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label' => __('Border Radius', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix_post_social a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$settings['isElementor'] = true;
		
		// For Elementor, gap is handled via responsive selectors, so we don't pass it to the render method
		// The gap parameter is managed through CSS selectors defined in the control
		
		echo \PixfortCore::instance()->elementsManager->renderElement('SocialShareButton', $settings);
	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}

