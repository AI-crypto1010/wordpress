<?php

namespace Elementor;

class Pix_Eor_Map extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_script('pix-map-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/map.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
		if (is_user_logged_in()) wp_enqueue_style('pixfort-map-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/map.min.css', false, PIXFORT_PLUGIN_VERSION);
	}

	public function get_name() {
		return 'pix-map';
	}

	public function get_title() {
		return 'Map';
	}

	public function get_icon() {
		return 'eicon-google-maps pixfort-elementor-element pixfort-elementor-maps';
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
			'address',
			[
				'label' => __('Map text (Address)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'latitude',
			[
				'label' => __('Latitude', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('48.892506', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'longitude',
			[
				'label' => __('Longitude', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('2.236413', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'map_zoom',
			[
				'label' => __('Map zoom', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('14', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'map_style',
			[
				'label' => __('Map style', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'silver',
				'options' => array_flip(array(
					'Silver'		=> 'silver',
					'Standard'		=> 'standard',
					'Retro' 		=> 'retro',
					'Dark' 		    => 'dark',
					'Night' 		=> 'night',
					'Aubergine'     => 'aubergine',
					'Custom' 		=> 'custom'
				)),
			]
		);

		$this->add_control(
			'custom_color',
			[
				'label' => __('Custom color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#1274E7',
				'condition' => [
					'map_style' => 'custom',
				],
			]
		);
		$this->add_control(
			'custom_saturation',
			[
				'label' => __('Custom saturation', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '-20',
				'condition' => [
					'map_style' => 'custom',
				],
			]
		);
		$this->add_control(
			'custom_brightness',
			[
				'label' => __('Custom brightness', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '5',
				'condition' => [
					'map_style' => 'custom',
				],
			]
		);
		$this->add_control(
			'marker',
			[
				'label' => __('Marker Image', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'map_height',
			[
				'label' => __('Map height', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					""  => "Big",
					"map-md" => "Medium",
					"map-sm" => "Small",
					"full-height"       => "Full height",
				),
			]
		);



		$this->end_controls_section();

		$this->start_controls_section(
			'advanced_section',
			[
				'label' => __('Advanced', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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

		pix_get_elementor_effects($this);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('Map', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-map-handle'];
		return [''];
	}
}
