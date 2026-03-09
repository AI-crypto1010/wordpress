<?php

namespace Elementor;

class Pix_Eor_Text extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-text';
	}

	public function get_title() {
		return 'Text';
	}

	public function get_icon() {
		return 'eicon-text pixfort-elementor-element pixfort-elementor-text';
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
			'content_type',
			[
				'label' => __('Text type', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'simple',
				'options' => [
					'simple' => __('Simple', 'pixfort-core'),
					'advanced' => __('Advanced', 'pixfort-core'),
				],
			]
		);

		$this->add_control(
			'content',
			[
				'label' => __('Content', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __('', 'pixfort-core'),
				'default' => 'Insert your content here',
				'dynamic'     => array(
					'active'  => true
				),
				'condition' => [
					'content_type' => 'simple',
				],
			]
		);
		$this->add_control(
			'content_wysiwyg',
			[
				'label' => esc_html__('Content editor', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__('Insert your content here', 'pixfort-core'),
				'placeholder' => esc_html__('Insert your content here', 'pixfort-core'),
				'condition' => [
					'content_type' => 'advanced',
				],
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __('Size', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''			=> 'Default',
					'text-xs'		=> '12px',
					'text-sm'		=> '14px',
					'text-sm'		=> '14px',
					'text-18' 		=> '18px',
					'text-20' 		=> '20px',
					'text-24' 		=> '24px',
				),
				'default' => '',
				'condition' => [
					'content_type' => 'simple',
				],
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
				'condition' => [
					'content_type' => 'simple',
				],
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
				'condition' => [
					'content_type' => 'simple',
				],
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
				'condition' => [
					'content_type' => 'simple',
				],
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' => __('Content color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => '',
				'condition' => [
					'content_type' => 'simple',
				],
			]
		);


		$this->add_control(
			'content_custom_color',
			[
				'label' => __('Custom Content color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .el-content_custom_color' => 'color: {{VALUE}};',
				],
				'condition' => [
					'content_color' => 'custom',
				],
			]
		);
		$this->add_control(
			'advanced_content_color',
			[
				'label' => __('Content color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['gradients' => false]),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'color: var(--pix-{{VALUE}});',
					'{{WRAPPER}} p' => 'color: var(--pix-{{VALUE}});',
				],
				'condition' => [
					'content_type' => 'advanced',
				],
			]
		);
		$this->add_control(
			'advanced_content_custom_color',
			[
				'label' => __('Custom Content color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .el-content_custom_color' => 'color: {{VALUE}};',
					'{{WRAPPER}} ' => 'color: {{VALUE}};',
					'{{WRAPPER}} p' => 'color: {{VALUE}} !important;',
				],
				'condition' => [
					'advanced_content_color' => 'custom',
				],
			]
		);


		$this->add_control(
			'position',
			[
				'label' => __('Position', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'text-center'		=> 'Center',
					'text-left'			=> 'Start',
					'text-right' 		=> 'End',
				),
				'default' => 'text-left',
			]
		);
		$this->add_control(
			'max_width',
			[
				'label' => __('Text max width (Optional)', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('For example 400px', 'pixfort-core'),
				'default' => '',
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

		$this->add_responsive_control(
			'remove_pb_padding',
			[
				'label' => __('Remove margin under paragraphs', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'm-0',
				'default' => '',
				'selectors_dictionary' => [
					'' => 'auto',
					'm-0' => 'margin-bottom: 0;'
				],
				'selectors' => [
					'{{WRAPPER}} p' => '{{VALUE}}',
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
					'{{WRAPPER}} .pix-el-text, {{WRAPPER}} .pix-el-text p' => 'text-align: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'bar_inner_typography',
				'selector' => '{{WRAPPER}} .pix-el-text, {{WRAPPER}} .pix-el-text p, {{WRAPPER}} .pix-el-text span',
				// 'exclude' => [
				// 	'line_height',
				// ],
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
		$settings['remove_pb_padding'] = 'resp-option';
		echo \PixfortCore::instance()->elementsManager->renderElement('Text', $settings, $settings['content']);
	}


	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
