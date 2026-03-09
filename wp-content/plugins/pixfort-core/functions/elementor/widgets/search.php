<?php

namespace Elementor;

class Pix_Eor_Search extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-search';
	}

	public function get_title() {
		return 'Search';
	}

	public function get_icon() {
		return 'eicon-search pixfort-elementor-element pixfort-elementor-search';
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
			'search_div',
			[
				'label' => __('Field inside a container', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' 		=> 'Disabled',
					'text-center' 		=> 'Center align',
					'text-left' 		=> 'Left align',
					'text-right' 		=> 'Right align',
				],
			]
		);


		$this->add_control(
			'max_width',
			[
				'label' => __('Field max width', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('Input the width with the unit (eg. 300px)', 'pixfort-core'),
			]
		);

		$this->end_controls_section();

		if (class_exists('\PixfortCore') && \PixfortCore::instance()->getThemeParam('new_border_options')) {
			$this->start_controls_section(
				'section_search_style',
				[
					'label' => __('Search Style', 'pixfort-core'),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'shadow_style',
				[
					'label' => __('Shadow Style', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						"none" => "None",
						"1"       => "Small shadow",
						"2"       => "Medium shadow",
						"3"       => "Large shadow",
						// "4"       => "Inverse Small shadow",
						// "5"       => "Inverse Medium shadow",
						// "6"       => "Inverse Large shadow",
					),
					'default' => '1', // Small shadow
				]
			);

			$this->add_control(
				'rounded_corners',
				[
					'label' => __('Rounded corners', 'pixfort-core'),
					'type' => Controls_Manager::SELECT,
					'default' => 'rounded-lg',
					'options' => [
						'rounded-0' => __('No', 'pixfort-core'),
						'rounded' => __('Rounded', 'pixfort-core'),
						'rounded-lg' => __('Rounded Large', 'pixfort-core'),
						'rounded-xl' => __('Rounded XL', 'pixfort-core'),
						'rounded-10' => __('Rounded 2XL', 'pixfort-core'),
						'custom' => __('Custom', 'pixfort-core'),
					],
				]
			);

			$this->add_responsive_control(
				'custom_border_radius',
				[
					'label' => esc_html__('Custom Border Radius', 'pixfort-core'),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors' => [
						'{{WRAPPER}} .pix-small-search' => '--pix-search-border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'rounded_corners' => 'custom',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'search_border',
					'label' => esc_html__('Border', 'pixfort-core'),
					'selector' => '{{WRAPPER}} .pix-small-search',
				]
			);

			$this->end_controls_section();
		}
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('Search', $settings);
	}


	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
