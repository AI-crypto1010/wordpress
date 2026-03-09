<?php

namespace Elementor;

class Pix_Eor_3d_Box extends Widget_Base {

	public function __construct($data = [], $args = null) {
		// Link migration code
		$is_external = false;
		if (!empty($data['settings'])) {
			if (!empty($data['settings']['btn_link']) && !is_array($data['settings']['btn_link'])) {
				if (!empty($data['settings']['btn_target']) && $data['settings']['btn_target']) {
					$is_external = true;
				}
				$data['settings']['btn_link'] = [
					'url' => $data['settings']['btn_link'],
					'is_external' => $is_external,
					'nofollow' => false,
				];
			}
		}
		parent::__construct($data, $args);

		wp_register_script('pix-3d-box-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/3d-box.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
	}

	public function get_name() {
		return 'pix-3d-box';
	}

	public function get_title() {
		return '3D Box';
	}

	public function get_icon() {
		return 'eicon-lightbox pixfort-elementor-element pixfort-elementor-3d-box';
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
				'default' => '3d Box Title',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'text',
			[
				'label' => __('Text', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __('Enter your text', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		// $this->add_control(
		// 	'bg_img',
		// 	[
		// 		'label' => __('Choose Image', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::MEDIA,
		// 		'dynamic'     => array(
		// 			'active'  => true
		// 		),
		// 	]
		// );

		getElementorDynamicImageControls($this, 'bg_img', 'bg_img_dark');


		$this->add_control(
			'content_align',
			[
				'label' => __('Content align', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'left' => __('Start', 'pixfort-core'),
					'center' => __('Center', 'pixfort-core'),
					'right' => __('End', 'pixfort-core'),
				],
				'default' => 'left',
			]
		);

		$this->add_control(
			'rounded_img',
			[
				'label' => __('Rounded corners', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded-0',
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
			'overlay_color',
			[
				'label' => __('Overlay Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'black',
			]
		);
		$this->add_control(
			'custom_overlay_color',
			[
				'label' => __('Custom overlay color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'overlay_color' => 'custom',
				],
			]
		);
		$this->add_control(
			'overlay_opacity',
			[
				'label' => __('Overlay opacity', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'pix-opacity-10'   => "0%",
					'pix-opacity-9'   => "10%",
					'pix-opacity-8'   => "20%",
					'pix-opacity-7'   => "30%",
					'pix-opacity-6'   => "40%",
					'pix-opacity-5'   => "50%",
					'pix-opacity-4'   => "60%",
					'pix-opacity-3'   => "70%",
					'pix-opacity-2'   => "80%",
					'pix-opacity-1'   => "90%",
				),
				'default' => 'pix-opacity-3',
			]
		);
		$this->add_control(
			'hover_overlay_opacity',
			[
				'label' => __('Hover overlay opacity', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					"pix-hover-opacity-0" 			=> "100%",
					"pix-hover-opacity-2" 			=> "80%",
					"pix-hover-opacity-4" 			=> "60%",
					"pix-hover-opacity-6" 			=> "40%",
					"pix-hover-opacity-7" 			=> "30%",
					"pix-hover-opacity-8" 			=> "20%",
					"pix-hover-opacity-9" 			=> "10%",
					"pix-hover-opacity-10" 			=> "Disable",

				),
				'default' => 'pix-hover-opacity-7',
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
			'section_advanced',
			[
				'label' => __('Content Style', 'pixfort-core'),
			]
		);
		$this->add_control(
			'bold',
			[
				'label' => __('Bold', 'pixfort-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'font-weight-bold' => [
						'title' => __('Yes', 'pixfort-core'),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __('No', 'pixfort-core'),
						'icon' => 'fa fa-times',
					]
				],
				'default' => 'font-weight-bold',
			]
		);
		$this->add_control(
			'italic',
			[
				'label' => __('Italic', 'pixfort-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'font-italic' => [
						'title' => __('Yes', 'pixfort-core'),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __('No', 'pixfort-core'),
						'icon' => 'fa fa-times',
					]
				],
				'default' => '0',
			]
		);
		$this->add_control(
			'secondary_font',
			[
				'label' => __('Secondary font', 'pixfort-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'secondary-font' => [
						'title' => __('Yes', 'pixfort-core'),
						'icon' => 'fa fa-check',
					],
					'0' => [
						'title' => __('No', 'pixfort-core'),
						'icon' => 'fa fa-times',
					]
				],
				'default' => '0',
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
				'default' => 'h2',
			]
		);
		$this->add_control(
			'title_custom_size',
			[
				'label' => __('Custom title size', 'pixfort-core'),
				'label_block' => false,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter custom title size', 'pixfort-core'),
				'default' => '',
				'condition' => [
					'title_size' => 'custom',
				],
			]
		);


		$this->add_control(
			'content_color',
			[
				'label' => __('Content color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'light-opacity-5',
			]
		);
		$this->add_control(
			'content_custom_color',
			[
				'label' => __('content_custom_color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'content_color' => 'custom',
				],
			]
		);
		$this->add_control(
			'content_size',
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


		$this->start_controls_section(
			'section_element_style',
			[
				'label' => __('Advanced Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'element_padding',
			[
				'label' => esc_html__('Box Padding', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .card-img-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __('Title Typography', 'pixfort-core'),
				'selector' => '{{WRAPPER}} .card-title',
			]
		);



		$this->end_controls_section();



		pix_get_elementor_btn($this, true);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if (!empty($settings)) {
			if (!empty($settings['btn_link']) && is_array($settings['btn_link'])) {
				if (!empty($settings['btn_link']['is_external'])) {
					$settings['btn_target'] = $settings['btn_link']['is_external'];
				}
				$settings['btn_link'] = $settings['btn_link']['url'];
			}
		}
		echo \PixfortCore::instance()->elementsManager->renderElement('3dbox', $settings);
	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-3d-box-handle'];
		return [];
	}
}
