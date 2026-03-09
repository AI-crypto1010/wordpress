<?php

namespace Elementor;

class Pix_Eor_Card_Wide extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_script('pix-card-wide-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/card-wide.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
	}

	public function get_name() {
		return 'pix-card-wide';
	}

	public function get_title() {
		return 'Card wide';
	}

	public function get_icon() {
		return 'eicon-thumbnails-half pixfort-elementor-element pixfort-elementor-card-wide';
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
			'layout',
			[
				'label' => __('Layout', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array_flip(array(
					__('Wide card (right image)', 'pixfort-core') 			=> 'wide_card_right',
					__('Wide card (left image)', 'pixfort-core')		=> 'wide_card_left',
				)),
				'default' => 'wide_card_right',
			]
		);
		$this->add_control(
			'title',
			[
				'label' => __('Title', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'default' => '',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'text',
			[
				'label' => __('Card text', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Badge text', 'pixfort-core'),
				'default' => 'Badge text',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		getElementorDynamicImageControls($this, 'image', 'image_dark');
		getElementorDynamicImageControls($this, 'feature_image', 'feature_image_dark');

		$this->add_control(
			'feature_image_width',
			[
				'label' => __('Max Width of the featured image (Optional)', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
			]
		);

		$this->add_control(
			'rounded_img',
			[
				'label' => __('Rounded corners', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded-lg',
				'options' => [
					'rounded-0' => __('No', 'pixfort-core'),
					'rounded' => __('Rounded', 'pixfort-core'),
					'rounded-lg' => __('Rounded Large', 'pixfort-core'),
					'rounded-xl' => __('Rounded 5px', 'pixfort-core'),
					'rounded-10' => __('Rounded 10px', 'pixfort-core'),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __('Link', 'pixfort-core'),
				'type' => Controls_Manager::URL,
				'placeholder' => __('Link', 'pixfort-core'),
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		// effects_params
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
			'bg_color',
			[
				'label' => __('Background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .card' => 'background: var(--pix-{{VALUE}});',
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$this->add_responsive_control(
			'custom_bg_color',
			[
				'label' => __('Custom Background Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'bg_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .card' => 'background-color: {{VALUE}};',
				],
				'dynamic'     => array(
					'active'  => true
				),
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
		$this->add_control(
			'extra_classes',
			[
				'label' => __('Extra Classes', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'default' => '',
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
			'color',
			[
				'label' => __('Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'heading-default',
			]
		);
		$this->add_control(
			'custom_color',
			[
				'label' => __('Custom Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'text_color' => 'custom',
				],
			]
		);
		$this->add_control(
			'title_size',
			[
				'label' => __('Title size', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array_flip(array(
					__('H1', 'pixfort-core') 	=> 'h1',
					__('H2', 'pixfort-core')	    => 'h2',
					__('H3', 'pixfort-core')	    => 'h3',
					__('H4', 'pixfort-core')	    => 'h4',
					__('H5', 'pixfort-core')	    => 'h5',
					__('H6', 'pixfort-core')	    => 'h6',
					__('Custom', 'pixfort-core')	    => 'custom',
				)),
				'default' => 'h5',
			]
		);
		$this->add_control(
			'title_custom_size',
			[
				'label' => __('Custom Title size', 'pixfort-core'),
				'label_block' => false,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter custom title size', 'pixfort-core'),
				'default' => '',
				'condition' => [
					'text_size' => 'custom',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'text_section',
			[
				'label' => __('Text format', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'text_bold',
			[
				'label' => __('Bold Text', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-weight-bold',
				'default' => 'font-weight-bold',
			]
		);
		$this->add_control(
			'text_italic',
			[
				'label' => __('Italic Text', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-italic',
				'default' => '',
			]
		);
		$this->add_control(
			'text_secondary_font',
			[
				'label' => __('Secondary font Text', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'secondary-font',
				'default' => '',
			]
		);
		$this->add_control(
			'text_color',
			[
				'label' => __('Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'body-default',
			]
		);
		$this->add_control(
			'text_custom_color',
			[
				'label' => __('Custom Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'text_color' => 'custom',
				],
			]
		);

		$this->add_control(
			'text_size',
			[
				'label' => __('Text size', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''			=> 'Default (16px)',
					'text-xs'		=> '12px',
					'text-sm'		=> '14px',
					'text-sm'		=> '14px',
					'text-18' 		=> '18px',
					'text-20' 		=> '20px',
					'text-24' 		=> '24px',
				),
				'default' => '',
			]
		);


		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('CardWide', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-card-wide-handle'];
		return [];
	}
}
