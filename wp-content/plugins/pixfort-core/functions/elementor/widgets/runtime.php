<?php

namespace Elementor;

class Pix_Eor_Runtime extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		wp_register_script('pix-runtime-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/runtime.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
	}

	public function get_name() {
		return 'pix-runtime';
	}

	public function get_title() {
		return 'Runtime';
	}

	public function get_icon() {
		return 'eicon-search pixfort-elementor-element pixfort-elementor-runtime';
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
				'label' => __('General', 'pixfort-core'),
			]
		);

		$this->add_control(
			'runtime_file',
			[
				'label' => __('Choose runtime file', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_types' => ['application/octet-stream'],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		// $this->add_responsive_control(
		// 	'dimensions',
		// 	[
		// 		'label' => __( 'Canvas dimensions', 'pixfort-core' ),
		// 		'type' => \Elementor\Controls_Manager::IMAGE_DIMENSIONS,
		// 		// 'default' => __( '0', 'pixfort-core' ),
		// 		// 'placeholder' => __( '', 'pixfort-core' ),
		// 		// 'condition' => [
		// 		// 	'animation!' => '',
		// 		// ],
		// 	]
		// );

		$this->add_control(
			'runtime_state',
			[
				'label' => __('runtime state', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				// 'placeholder' => __( 'Input the width in pixels without the unit', 'pixfort-core' ),
			]
		);
		$this->add_control(
			'runtime_file_url',
			[
				'label' => __('runtime file URL', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				// 'placeholder' => __( 'Input the width in pixels without the unit', 'pixfort-core' ),
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

		$this->add_responsive_control(
			'aria_label',
			[
				'label' => __('Aria Label', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('Input the aria-label', 'pixfort-core')
			]
		);
		$this->add_responsive_control(
			'width',
			[
				'label' => __('Width', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('Input the width in pixels without the unit', 'pixfort-core'),
				'selectors' => [
					'{{WRAPPER}} .pix-runtime-canvas' => 'width: {{VALUE}} !important;',
				],
			]
		);
		$this->add_responsive_control(
			'height',
			[
				'label' => __('Height', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('Input the height in pixels without the unit', 'pixfort-core'),
				'selectors' => [
					'{{WRAPPER}} .pix-runtime-canvas' => 'height: auto !important;',
				],
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
					]
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('Runtime', $settings);
	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-runtime-handle'];
		return [];
	}
}
