<?php

namespace Elementor;

class Pix_Eor_Animated_Heading extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_style('pixfort-animated-heading-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/animated-heading.min.css', false, PIXFORT_PLUGIN_VERSION);
		wp_register_script('pix-animated-heading-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/animated-heading.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
	}

	public function get_name() {
		return 'pix-animated-heading';
	}

	public function get_title() {
		return 'Animated Heading';
	}

	public function get_icon() {
		return 'eicon-animated-headline pixfort-elementor-element pixfort-elementor-animated-heading';
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
			'title',
			[
				'label' => __('Title', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter your title', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
				'default' => '',
			]
		);

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'word',
			[
				'label' => __('Word', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter the word', 'pixfort-core'),
				'default' => '',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$repeater->add_control(
			'has_color',
			[
				'label' => __('Different color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => true,
				'default' => false,
			]
		);
		$repeater->add_control(
			'word_color',
			[
				'label' => __('Different Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')]]),
				'default' => '',
				// 'condition' => [
				// 	'has_color' => true,
				// ],
			]
		);
		$repeater->add_control(
			'word_custom_color',
			[
				'label' => __('Custom Different color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				// 'condition' => [
				// 	'word_color' => 'custom',
				// ],
			]
		);

		$this->add_control(
			'words',
			[
				'label' => __('Scrolling words', 'pixfort-core'),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ word }}}',
				'fields' => $repeater->get_controls()
			]
		);

		$this->add_control(
			'text_after',
			[
				'label' => __('Text after', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter Text after', 'pixfort-core'),
				'default' => '',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'slogan',
			[
				'label' => __('Slogan', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter Text after', 'pixfort-core'),
				'default' => '',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __('Animation Style', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'slide-inverse' 		 => 'Slide Up',
					'pixfade' 		         => 'Fade',
					'loading-bar'			 => 'Loading bar',
					'slide' 		         => 'Slide Down',
					'zoom' 		             => 'Zoom',
					'push' 		             => 'Push',
					'rotate-1'			     => 'Rotate',
				),
				'default' => 'slide-inverse',
			]
		);
		$this->add_control(
			'position',
			[
				'label' => __('Position', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'left'			=> __('Start', 'pixfort-core'),
					'center'		=> __('Center', 'pixfort-core'),
					'right' 		=> __('End', 'pixfort-core'),
				],
				'default' => 'center',
			]
		);




		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_format',
			[
				'label' => __('Text format', 'pixfort-core'),
			]
		);

		$this->add_control(
			'title_bold',
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
			'title_italic',
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
			'title_secondary_font',
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
			'space_after',
			[
				'label' => __('Add space after the animated text', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'space_after',
				'default' => '',
			]
		);
		$this->add_control(
			'br_after',
			[
				'label' => __('Add break line after the animated text', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => true,
				'default' => '',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __('Font size', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'h1',
				'options' => array(
					'h1'		=> 'H1',
					'h2'		=> 'H2',
					'h3' 		=> 'H3',
					'h4' 		=> 'H4',
					'h5' 		=> 'H5',
					'h6' 		=> 'H6',
					'p' 		=> 'p',
				),
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
			'title_color',
			[
				'label' => __('Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'heading-default',
			]
		);
		$this->add_control(
			'title_custom_color',
			[
				'label' => __('Custom Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'title_color' => 'custom',
				],
			]
		);




		$this->end_controls_section();






		$this->start_controls_section(
			'section_slogan',
			[
				'label' => __('Slogan format', 'pixfort-core'),
			]
		);

		$this->add_control(
			'slogan_bold',
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
			'slogan_italic',
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
			'slogan_font',
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
			'slogan_color',
			[
				'label' => __('Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'primary',
			]
		);
		$this->add_control(
			'slogan_custom_color',
			[
				'label' => __('Custom Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'slogan_color' => 'custom',
				],
			]
		);




		$this->end_controls_section();


		$this->start_controls_section(
			'section_advanced',
			[
				'label' => __('Advanced', 'pixfort-core'),
			]
		);



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
				'label' => __('Animation delay (in miliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('0', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					'animation!' => '',
				],
			]
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'section_element_style_slogan',
			[
				'label' => __('Slogan Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'slogan_align',
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
					'{{WRAPPER}} .pix-slogan-text' => 'text-align: {{VALUE}} !important;',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'slogan_inner_typography',
				'selector' => '{{WRAPPER}} .pix-slogan-text h6',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'slogan_text_shadow',
				'selector' => '{{WRAPPER}} .pix-slogan-text',
			]
		);

		$this->end_controls_section();





		$this->start_controls_section(
			'section_element_style',
			[
				'label' => __('Heading Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_responsive_control(
			'align',
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
					'{{WRAPPER}} .pix-headline' => 'text-align: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_inner_typography',
				'selector' => '{{WRAPPER}} .pix-headline',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .pix-headline',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('AnimatedHeading', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-animated-heading-handle'];
		return [];
	}
	public function get_style_depends() {
		return ['pixfort-animated-heading-style'];
	}
}
