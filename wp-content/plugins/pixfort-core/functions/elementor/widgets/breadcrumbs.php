<?php

namespace Elementor;

class Pix_Eor_Breadcrumbs extends Widget_Base {

	public function __construct($data = [], $args = null) {
		$data = \PixfortCore::instance()->icons->verifyElementorData($data);
		parent::__construct($data, $args);
		if (is_user_logged_in()) wp_enqueue_style('pixfort-alert-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/alert.min.css', false, PIXFORT_PLUGIN_VERSION);
	}

	public function get_name() {
		return 'pix-breadcrumbs';
	}

	public function get_title() {
		return 'Breadcrumbs';
	}

	public function get_icon() {
		return 'eicon-alert pixfort-elementor-element pixfort-elementor-breadcrumbs';
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

		$this->add_responsive_control(
			'align',
			[
				'label' => __('Alignment', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .breadcrumb' => 'justify-content: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'left' => 'flex-start',
					'center' => 'center',
					'right' => 'flex-end',
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
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_breadcrumbs_style',
			[
				'label' => __('Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'breadcrumbs_typography',
				'label' => __('Typography', 'pixfort-core'),
				'selector' => '{{WRAPPER}} .breadcrumb-item, {{WRAPPER}} .breadcrumb-item a',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('Breadcrumbs', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
