<?php

namespace Elementor;

class Pix_Eor_Table_Of_Contents extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		if (is_user_logged_in()) {
			wp_register_script(
				'pix-table-of-contents-editor',
				PIX_CORE_PLUGIN_URI . 'functions/elementor/js/table-of-contents.js',
				['jquery', 'elementor-frontend'],
				PIXFORT_PLUGIN_VERSION,
				true
			);
			wp_enqueue_style('pixfort-table-of-contents-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/table-of-contents.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		}
	}

	public function get_name() {
		return 'pix-table-of-contents';
	}

	public function get_title() {
		return 'Table of Contents';
	}

	public function get_icon() {
		return 'eicon-editor-list-ul pixfort-elementor-element pixfort-elementor-table-of-contents';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_toc_content',
			[
				'label' => __('Table of Contents', 'pixfort-core'),
			]
		);



		$this->add_control(
			'include_mode',
			[
				'label' => __('Mode', 'pixfort-core'),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'include',
				'options' => [
					'include' => [
						'title' => __('Include', 'pixfort-core'),
						'icon' => 'eicon-plus-circle-o',
					],
					'exclude' => [
						'title' => __('Exclude', 'pixfort-core'),
						'icon' => 'eicon-minus-circle-o',
					],
				],
				'toggle' => false,
			]
		);

		$this->add_control(
			'include_tags',
			[
				'label' => __('Anchors By Tags', 'pixfort-core'),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'default' => ['h2', 'h3', 'h4', 'h5', 'h6'],
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'label_block' => true,
				'condition' => [
					'include_mode' => 'include',
				],
			]
		);

	$this->add_control(
		'exclude_selectors',
		[
			'label' => __('Anchors By Selector', 'pixfort-core'),
			'type' => Controls_Manager::TEXT,
			'default' => '',
			'label_block' => true,
			'description' => __('CSS selectors, in a comma-separated list', 'pixfort-core'),
			'placeholder' => __('.exclude-class, #exclude-id, .another-selector', 'pixfort-core'),
			'condition' => [
				'include_mode' => 'exclude',
			],
		]
	);

		$this->add_control(
			'container',
			[
				'label' => __('Container', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
				'description' => __('Confine headings to a specific container CSS selector.', 'pixfort-core'),
				'placeholder' => __('.entry-content', 'pixfort-core'),
			]
		);

		$this->add_control(
			'marker_view',
			[
				'label' => __('Marker View', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'line',
				'options' => [
					'none' => __('None', 'pixfort-core'),
					'line' => __('Line', 'pixfort-core'),
					'numbers' => __('Numbers', 'pixfort-core'),
					'bullets' => __('Bullets', 'pixfort-core'),
				],
			]
		);

		$this->add_control(
			'no_headings_message',
			[
				'label' => __('No Headings Found Message', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('No headings were found on this page.', 'pixfort-core'),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toc_title',
			[
				'label' => __('Title', 'pixfort-core'),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __('Title', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('In this page', 'pixfort-core'),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

	$this->add_control(
		'html_tag',
		[
			'label' => __('HTML Tag', 'pixfort-core'),
			'type' => Controls_Manager::SELECT,
			'default' => 'h6',
			'options' => [
				'h1' => 'H1',
				'h2' => 'H2',
				'h3' => 'H3',
				'h4' => 'H4',
				'h5' => 'H5',
				'h6' => 'H6',
				'div' => 'div',
				'span' => 'span',
			],
		]
	);

	$this->add_control(
		'show_title_icon',
		[
			'label' => __('Show Title Icon', 'pixfort-core'),
			'type' => Controls_Manager::SWITCHER,
			'label_on' => __('Yes', 'pixfort-core'),
			'label_off' => __('No', 'pixfort-core'),
			'return_value' => 'yes',
			'default' => 'yes',
		]
	);

	$this->add_control(
		'title_icon',
		[
			'label' => __('Title Icon', 'pixfort-core'),
			'type' => \Elementor\CustomControl\PixfortIconSelector_Control::PixfortIconSelector,
			'default' => 'Line/pixfort-icon-menu-2',
			'condition' => [
				'show_title_icon' => 'yes',
			],
		]
	);

	$this->end_controls_section();

		$this->start_controls_section(
			'section_toc_additional',
			[
				'label' => __('Additional Options', 'pixfort-core'),
			]
		);

		$this->add_control(
			'hierarchical_view',
			[
				'label' => __('Hierarchical View', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'collapse_subitems',
			[
				'label' => __('Collapse Subitems', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'hierarchical_view' => 'yes',
				],
				'description' => __('Use collapse only when the Table of Contents is sticky (collapsed items are shown while scrolling).', 'pixfort-core'),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toc_title_style',
			[
				'label' => __('Title Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'toc_title_typography',
				'label' => __('Title Typography', 'pixfort-core'),
				'selector' => '{{WRAPPER}} .pix-toc-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')]]),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pix-toc-title' => 'color: var(--pix-{{VALUE}}) !important;',
				],
			]
		);

		$this->add_control(
			'title_custom_color',
			[
				'label' => __('Title Custom Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-toc-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'title_color' => 'custom',
				],
			]
		);




		$this->end_controls_section();


		$this->start_controls_section(
			'section_toc_links_style',
			[
				'label' => __('Links Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);



		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'toc_links_typography',
				'label' => __('Links Typography', 'pixfort-core'),
				'selector' => '{{WRAPPER}} .pix-toc-link',
			]
		);

		$this->add_control(
			'links_color',
			[
				'label' => __('Links Color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')]]),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pix-toc-element' => '--pix-toc-link-color: var(--pix-{{VALUE}});',
				],
			]
		);
		$this->add_control(
			'links_custom_color',
			[
				'label' => __('Links Custom Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-toc-element' => '--pix-toc-link-color: {{VALUE}};',
				],
				'condition' => [
					'links_color' => 'custom',
				],
			]
		);

		$this->add_control(
			'nested_links_color',
			[
				'label' => __('Nested Links Color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')]]),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pix-toc-element' => '--pix-toc-nested-links-color: var(--pix-{{VALUE}});',
				],
			]
		);
		$this->add_control(
			'nested_links_custom_color',
			[
				'label' => __('Nested Links Custom Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-toc-element' => '--pix-toc-nested-links-color: {{VALUE}};',
				],
				'condition' => [
					'nested_links_color' => 'custom',
				],
			]
		);

		$this->add_control(
			'links_active_color',
			[
				'label' => __('Links Active Color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')]]),
				'default' => 'primary',
				'selectors' => [
					'{{WRAPPER}} .pix-toc-element' => '--pix-toc-link-active-color: var(--pix-{{VALUE}});',
				],
			]
		);
		$this->add_control(
			'links_custom_active_color',
			[
				'label' => __('Links Custom Active Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-toc-element' => '--pix-toc-link-active-color: {{VALUE}};',
				],
				'condition' => [
					'links_active_color' => 'custom',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_toc_line_style',
			[
				'label' => __('Line Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'line_color',
			[
				'label' => __('Line Color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')]]),
				'selectors' => [
					'{{WRAPPER}} .pix-toc-element' => '--pix-toc-line-color: var(--pix-{{VALUE}});',
				],
				'default' => '',
			]
		);
		$this->add_control(
			'line_custom_color',
			[
				'label' => __('Line Custom Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-toc-element' => '--pix-toc-line-color: {{VALUE}};',
				],
				'condition' => [
					'line_color' => 'custom',
				],
			]
		);

		$this->add_control(
			'line_active_color',
			[
				'label' => __('Line Active Color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')]]),
				'default' => 'primary',
				'selectors' => [
					'{{WRAPPER}} .pix-toc-element' => '--pix-toc-line-active-color: var(--pix-{{VALUE}});',
				],
			]
		);
		$this->add_control(
			'line_active_custom_color',
			[
				'label' => __('Line Active Custom Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-toc-element' => '--pix-toc-line-active-color: {{VALUE}};',
				],
				'condition' => [
					'line_active_color' => 'custom',
				],
			]

		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('TableOfContents', $settings);
	}

	public function get_script_depends() {
		if (is_user_logged_in()) {
			return ['pix-global', 'pix-table-of-contents-editor'];
		}
		return [];
	}
}
