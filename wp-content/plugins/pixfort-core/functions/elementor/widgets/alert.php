<?php

namespace Elementor;

class Pix_Eor_Alert extends Widget_Base {

	public function __construct($data = [], $args = null) {
		$data = \PixfortCore::instance()->icons->verifyElementorData($data);
		parent::__construct($data, $args);
		if (is_user_logged_in()) wp_enqueue_style('pixfort-alert-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/alert.min.css', false, PIXFORT_PLUGIN_VERSION);
	}

	public function get_name() {
		return 'pix-alert';
	}

	public function get_title() {
		return 'Alert';
	}

	public function get_icon() {
		return 'eicon-alert pixfort-elementor-element pixfort-elementor-alert';
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
				'default' => 'Alert title',
				'dynamic'     => array(
					'active'  => true
				),
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
			'alert_type_1',
			[
				'label' => __('Alert Type', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::SELECT,
				'options' => [
					'success'		=> 'Success',
					'secondary'		=> 'Secondary',
					'primary' 		=> 'Primary',
					'danger' 		=> 'Danger',
					'warning' 		=> 'Warning',
					'info' 		    => 'Info',
					'light' 		=> 'Light',
					'dark' 		    => 'Dark'
				],
				'default' => 'success',
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
				'default' => '2',
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

		$this->add_control(
			'hide_close',
			[
				'label' => __('Hide Close button', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => ''
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
			'section_element_link',
			[
				'label' => __('Link', 'pixfort-core'),
			]
		);
		$this->add_control(
			'link_text',
			[
				'label' => __('Link Text', 'pixfort-core'),
				'label_block' => false,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'default' => '',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'link',
			[
				'label' => __('Link', 'pixfort-core'),
				'type' => Controls_Manager::URL,
				'placeholder' => __('', 'pixfort-core'),
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

		$this->add_control(
			'link_color',
			[
				'label' => __('Link text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['alert-default' => __('Default', 'pixfort-core')]]),
				'default' => '',
				'condition' => [
					'link_text!' => '',
				],
			]
		);
		$this->add_control(
			'text_custom_color',
			[
				'label' => __('Link custom text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'link_color' => 'custom',
				],
			]
		);
		$this->end_controls_section();


		$this->start_controls_section(
			'section_element_image',
			[
				'label' => __('Image / Icon', 'pixfort-core'),
			]
		);

		$this->add_control(
			'media_type',
			[
				'label' => __('Use image or icon', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					"none"       => "None",
					"image"       => "Image",
					"icon"       => "Icon",
					"char"       => "Character",
				),
				'default' => 'none',
			]
		);
		$this->add_control(
			'icon',
			[
				'label' => esc_html__('pixfort Icon', 'pixfort-core'),
				'type' => \Elementor\CustomControl\PixfortIconSelector_Control::PixfortIconSelector,
				'default' => '',
				'condition' => [
					'media_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'char',
			[
				'label' => __('Character', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('1', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					'media_type' => 'char',
				],
			]
		);


		$this->add_control(
			'icon_color',
			[
				'label' => __('Icon color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['alert-default' => __('Default', 'pixfort-core')]]),
				'default' => 'primary',
			]
		);
		$this->add_control(
			'custom_icon_color',
			[
				'label' => __('Custom Icon Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom',
				],
			]
		);
		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __('Icon Size (without unit)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'desktop_default' => '30',
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					'media_type' => array("icon", "char", "duo_icon")
				],
				'selectors' => [
					'{{WRAPPER}} .pix-alert-icon > div' => 'font-size: {{value}}px !important;',
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __('Image', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic'     => array(
					'active'  => true
				),
				'condition' => [
					'media_type' => 'image',
				],
			]
		);
		$this->add_responsive_control(
			'image_size',
			[
				'label' => __('Image Size (with unit)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('Leave empty for full size.', 'pixfort-core'),
				'condition' => [
					'media_type' => 'image',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-alert-icon .feature_img' => 'width: {{value}} !important;',
					'{{WRAPPER}} .pix-alert-icon .feature_img img' => 'width: {{value}} !important;',
				],
			]
		);
		$this->add_control(
			'circle',
			[
				'label' => __('Circle image', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'media_type' => 'image',
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
				'name' => 'alert_inner_typography',
				'selector' => '{{WRAPPER}}, {{WRAPPER}} .heading-text span, {{WRAPPER}} .body-font, {{WRAPPER}} .secondary-font',
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
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('Alert', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
