<?php

namespace Elementor;

class Pix_Eor_Video_Popup extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-video-popup';
	}

	public function get_title() {
		return 'Video Popup';
	}

	public function get_icon() {
		return 'eicon-video-playlist pixfort-elementor-element pixfort-elementor-video-popup';
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
			'embed_code',
			[
				'label' => __('Embed Code', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::CODE,
				'dynamic'     => array(
					'active'  => true
				),

			]
		);
		$this->add_control(
			'is_elementor',
			[
				'label' => __('View', 'plugin-domain'),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => 'true',
			]
		);


		$this->add_control(
			'aspect',
			[
				'label' => __('Aspect ratio', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array_flip(array(
					__('21:9 aspect ratio', 'pixfort-core') 	    => 'embed-responsive-21by9',
					__('16:9 aspect ratio', 'pixfort-core')	    => 'embed-responsive-16by9',
					__('4:3 aspect ratio', 'pixfort-core')	    => 'embed-responsive-4by3',
					__('1:1 aspect ratio', 'pixfort-core')	    => 'embed-responsive-1by1',
					__('9:16 aspect ratio', 'pixfort-core')	    => 'embed-responsive-9by16'
				)),
				'default' => 'embed-responsive-21by9',
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
			'text_color',
			[
				'label' => __('Icon color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['custom' => false]),
				'default' => 'primary',

			]
		);


		$this->add_control(
			'bg_color',
			[
				'label' => __('Background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
				'default' => 'white',

			]
		);
		$this->add_control(
			'custom_bg_color',
			[
				'label' => __('Text Icon color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'bg_color' => 'custom',
				],
			]
		);
		$this->add_control(
			'size',
			[
				'label' => __('Button size', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('100', 'pixfort-core'),
				'placeholder' => __('size in pixels (without writing the unit.)', 'pixfort-core'),
			]
		);

		$this->add_control(
			'icon_style',
			[
				'label' => __('Icon style', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array_flip(array(
					__('Filled', 'pixfort-core')	    => 'due',
					__('Outline', 'pixfort-core') 	    => 'line',
				)),
				'default' => 'due',

			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('VideoPopup', $settings);
	}


	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
