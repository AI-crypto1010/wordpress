<?php

namespace Elementor;

class Pix_Eor_Photo_Box extends Widget_Base {

	public function __construct($data = [], $args = null) {
		// Link migration code
		$is_external = false;
		if (!empty($data['settings'])) {
			if (!empty($data['settings']['target']) && $data['settings']['target']) {
				$is_external = true;
			}
			if (!empty($data['settings']['link']) && !is_array($data['settings']['link'])) {
				$data['settings']['link'] = [
					'url' => $data['settings']['link'],
					'is_external' => $is_external,
					'nofollow' => false,
				];
			}
		}
		parent::__construct($data, $args);

		wp_register_script('pix-photo-box-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/photo-box.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
	}

	public function get_name() {
		return 'pix-photo-box';
	}

	public function get_title() {
		return 'Photo Box';
	}

	public function get_icon() {
		return 'eicon-image-bold pixfort-elementor-element pixfort-elementor-photo-box';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	protected function register_controls() {

		$infinite_animation = array_flip(array(
			"None"                  => "",
			"Rotating"              => "pix-rotating",
			"Rotating inversed"     => "pix-rotating-inverse",
			"Fade"                  => "pix-fade",
			"Bounce Small"          => "pix-bounce-sm",
			"Bounce Medium" 		=> "pix-bounce-md",
			"Bounce Large" 			=> "pix-bounce-lg",
			"Scale Small"           => "pix-scale-sm",
			"Scale Medium"           => "pix-scale-md",
			"Scale Large"           => "pix-scale-lg",

		));
		$animation_speeds = [
			'pix-duration-fast'		=> __('Fast', 'pixfort-core'),
			'pix-duration-md'		=> __('Medium', 'pixfort-core'),
			'pix-duration-slow'		=> __('Slow', 'pixfort-core')
		];


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
				'dynamic'     => array(
					'active'  => true
				),
				'placeholder' => __('Enter your title', 'pixfort-core'),
				'default' => '',
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
			]
		);
		$this->add_control(
			'link',
			[
				'label' => __('Link', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::URL,
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
			'pix_scroll_parallax',
			[
				'label' => __('Scroll Parallax', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'scroll_parallax',
			]
		);
		$this->add_control(
			'pix_color_effect',
			[
				'label' => __('Hover color effect', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'pix-hover-colored',
				'default' => 'pix-hover-colored',
			]
		);
		$this->add_control(
			'pix_title_effect',
			[
				'label' => __('Hover title fade in', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'pix-hover-title',
				'default' => 'pix-hover-title',
			]
		);
		$this->add_control(
			'xaxis',
			[
				'label' => __('Vertical Parallax', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'default'	=> '0',
				'description' => __('Input the Parallax value (without unit), for example: 120', 'pixfort-core'),
				'condition' => [
					'pix_scroll_parallax' => 'scroll_parallax',
				],
			]
		);
		$this->add_control(
			'yaxis',
			[
				'label' => __('Horizontal Parallax', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'default'	=> '0',
				'description' => __('Input the Parallax value (without unit), for example: 120', 'pixfort-core'),
				'condition' => [
					'pix_scroll_parallax' => 'scroll_parallax',
				],
			]
		);
		$this->add_control(
			'pix_tilt',
			[
				'label' => __('3D Hover', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'tilt',
			]
		);
		$this->add_control(
			'pix_tilt_size',
			[
				'label' => __('3d hover size', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'tilt',
				'options' => [
					'tilt'			=> 'Default',
					'tilt_big'		=> 'Big',
					'tilt_small' 		=> 'Small',
				],
				'condition' => [
					'pix_tilt!' => '',
				],
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
			'pix_infinite_animation',
			[
				'label' => __('Infinite Animation type', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => $infinite_animation,
			]
		);
		$this->add_control(
			'pix_infinite_speed',
			[
				'label' => __('Infinite Animation Speed', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => $animation_speeds,
				'condition' => [
					'pix_infinite_animation!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => __('Box minimum height', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'default' => '400px',
				'selectors' => [
					'{{WRAPPER}} .pix-img-overlay' => 'min-height: {{VALUE}} !important',
				],
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
			'title_color',
			[
				'label' => __('Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'white',
			]
		);
		$this->add_control(
			'title_custom_color',
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
					'title_size' => 'custom',
				],
			]
		);

		$this->end_controls_section();


		pix_get_elementor_effects($this);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if (!empty($settings['link']) && is_array($settings['link'])) {
			if (!empty($settings['link']['is_external'])) {
				$settings['target'] = $settings['link']['is_external'];
			} else {
				$settings['target'] = '';
			}
			if (!empty($settings['link']['nofollow'])) {
				$settings['nofollow'] = $settings['link']['nofollow'];
			}
			if (!empty($settings['link']['custom_attributes'])) {
				$settings['link_atts'] = $settings['link']['custom_attributes'];
			}
			$settings['link'] = $settings['link']['url'];
		}
		echo \PixfortCore::instance()->elementsManager->renderElement('PhotoBox', $settings);
	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-photo-box-handle'];
		return [];
	}
}
