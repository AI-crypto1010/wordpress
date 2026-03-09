<?php

namespace Elementor;

class Pix_Eor_Sliding_Text extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-sliding-text';
	}

	public function get_title() {
		return 'Sliding Text';
	}

	public function get_icon() {
		return 'eicon-arrow-up pixfort-elementor-element pixfort-elementor-sliding-text';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	protected function register_controls() {
	
		$this->start_controls_section(
			'section_title',
			[
				'label' => __('Content', 'pixfort-core'),
			]
		);

		$this->add_control(
			'content',
			[
				'label' => __('Text', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __('', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
				'default' => '',
			]
		);

		$this->add_control(
			'position',
			[
				'label' => __('Position', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'center' => __('Center', 'pixfort-core'),
					'left' => __('Start', 'pixfort-core'),
					'right' => __('End', 'pixfort-core'),
				],
				'default' => 'center',
			]
		);
		$this->add_responsive_control(
			'max_width',
			[
				'label' => __('Field max width', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('Input the width with the unit (eg. 300px)', 'pixfort-core'),
				'selectors' => [
					'{{WRAPPER}} .d-inline-block, {{WRAPPER}} .pix-sliding-headline-2' => 'max-width: {{VALUE}} !important;display: inline-block;',
				],
			]
		);








		$this->end_controls_section();
		$this->start_controls_section(
			'title_section',
			[
				'label' => __('Title format', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'bold',
			[
				'label' => __('Bold', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-weight-bold',
				'default' => 'font-weight-bold',
			]
		);
		$this->add_control(
			'italic',
			[
				'label' => __('Italic', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-italic',
				'default' => '',
			]
		);

		$this->add_control(
			'secondary_font',
			[
				'label' => __('Secondary font', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'secondary-font',
				'default' => '',
			]
		);
		$this->add_control(
			'size',
			[
				'label' => __('Font size', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'h1'		=> 'H1',
					'h2'		=> 'H2',
					'h3' 		=> 'H3',
					'h4' 		=> 'H4',
					'h5' 		=> 'H5',
					'h6' 		=> 'H6',
					'p' 		=> 'p',
				],
				'default' => 'h1',
			]
		);
		$this->add_control(
			'display',
			[
				'label' => __('Bigger Text', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''		=> 'None',
					'display-1'		=> 'Display 1',
					'display-2'		=> 'Display 2',
					'display-3'		=> 'Display 3',
					'display-4'		=> 'Display 4',
				),
				'default' => '',
				'condition' => [
					'size' => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6')
				],
			]
		);
		$this->add_control(
			'text_color',
			[
				'label' => __('Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'heading-default',
			]
		);
		$this->add_control(
			'text_custom_color',
			[
				'label' => __('Custom Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'text_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-sliding-headline-2, {{WRAPPER}} .pix-sliding-headline-2 span' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'animation',
			[
				'label' => __('Animation', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'delay',
			[
				'label' => __('Animation delay (in miliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
			]
		);
		$this->add_control(
			'words_delay',
			[
				'label' => __('Delay between words (in miliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('150', 'pixfort-core'),
				'placeholder' => __('Default value is 150', 'pixfort-core'),
			]
		);
		$this->add_control(
			'pix_animation_duration',
			[
				'label' => __('Word animation duration (in miliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				// 'placeholder' => __('Default value is 150', 'pixfort-core'),
			]
		);
		$this->add_control(
			'sliding_letters',
			[
				'label' => __('Enabled Sliding letters animation', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
			]
		);
		$this->add_control(
			'letters_delay',
			[
				'label' => __('Delay between letters (in miliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __('Leave empty for automatic delay', 'pixfort-core'),
				'condition' => [
					'sliding_letters' => 'yes',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_element_style',
			[
				'label' => __('Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'bar_inner_typography',
				'selector' => '{{WRAPPER}} .pix-sliding-headline-2, {{WRAPPER}} .pix-sliding-headline-2 span, {{WRAPPER}} .body-font, {{WRAPPER}} .heading-font',
				'exclude' => [
					// 'font_family',
					'text_decoration',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}}',
			]
		);

		$this->end_controls_section();
		
		if(defined('PIX_DEV') || (defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG !== 'essentials')) {
			$this->start_controls_section(
				'section_element_animation',
				[
					'label' => __('Advanced Animations', 'pixfort-core'),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_responsive_control(
				'pix_translate_y',

				[
					'label' => __('Vertical offset', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'default' => [
						'unit' => 'px',
						'size' => '',
					],
					'range' => [
						'px' => [
							'min' => -100,
							'max' => 100,
							'step' => 1,
						]
					],
					'render_type' => 'template',
					'size_units' => ['px', 'em', 'rem', 'custom'],
					'selectors' => [
						'{{WRAPPER}}' => '--pix-translate-y: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'pix_translate_x',

				[
					'label' => __('Horizontal offset', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'default' => [
						'unit' => 'px',
						'size' => '',
					],
					'range' => [
						'px' => [
							'min' => -100,
							'max' => 100,
							'step' => 1,
						]
					],
					'render_type' => 'template',
					'size_units' => ['px', 'em', 'rem', 'custom'],
					'selectors' => [
						'{{WRAPPER}}' => '--pix-translate-x: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'pix_blur',

				[
					'label' => __('Blur', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'default' => [
						'unit' => 'px',
						'size' => '',
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 20,
							'step' => 1,
						]
					],
					'render_type' => 'template',
					'size_units' => ['px'],
					// 'placeholder' => __( 'Leave empty for full size.', 'pixfort-core' ),
					'selectors' => [
						'{{WRAPPER}}' => '--pix-sliding-blur: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'pix-overflow',
				[
					'label' => __('Mask items inside box', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'hidden' => __('Yes', 'pixfort-core'),
						'visible' => __('No', 'pixfort-core'),
					],
					'default' => 'hidden',
					'render_type' => 'template',
					'selectors' => [
						'{{WRAPPER}}' => '--pix-sliding-overflow: {{VALUE}};',
					],
				]

			);

			$this->end_controls_section();
		}
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if (empty($settings['el_id'])) {
			$settings['el_id'] = 'el-' . $this->get_id();
		}
		echo \PixfortCore::instance()->elementsManager->renderElement('SlidingText', $settings, $settings['content']);
	}


	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-sliding-text-handle'];
		return [];
	}
}
