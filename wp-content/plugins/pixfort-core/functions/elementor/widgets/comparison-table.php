<?php

namespace Elementor;

class Pix_Eor_Comparison_Table extends Widget_Base {

	public function __construct($data = [], $args = null) {
		$data = \PixfortCore::instance()->icons->verifyElementorData($data, true, 'items', 'pix-comparison-table');
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-comparison-table';
	}

	public function get_title() {
		return 'Comparison Table';
	}

	public function get_icon() {
		return 'eicon-table pixfort-elementor-element pixfort-elementor-comparison-table';
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
			'cols_count',
			[
				'label' => __('Columns count', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => array_flip(array(
					'1'			=> '1',
					'2'			=> '2',
					'3'			=> '3',
				)),
			]
		);

		$this->add_control(
			'table_title',
			[
				'label' => __('Table Title', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'default' => '',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);


		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'title',
			[
				'label' => __('Title', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'label_block' => true,
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$repeater->add_control(
			'title_tooltip',
			[
				'label' => __('Tooltip', 'pixfort-core'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __('', 'pixfort-core'),
				'label_block' => true,
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$repeater->add_control(
			'text',
			[
				'label' => __('Description', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		// Col 1
		$repeater->add_control(
			'col_1_text',
			[
				'label' => __('Column 1 Text', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$repeater->add_control(
			'col_1_tooltip',
			[
				'label' => __('Col 1 Tooltip', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$repeater->add_control(
			'col_1_media_type',
			[
				'label' => __('Column 1 Icon', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => array_flip(array(
					"None" => "none",
					"Icon" => "icon"
				)),
			]
		);
		$repeater->add_control(
			'col_1_icon',
			[
				'label' => esc_html__('pixfort Icon', 'pixfort-core'),
				'type' => \Elementor\CustomControl\PixfortIconSelector_Control::PixfortIconSelector,
				'default' => '',
				'condition' => [
					'col_1_media_type' => 'icon',
				],
			]
		);
		


		// Col 2
		$repeater->add_control(
			'col_2_text',
			[
				'label' => __('Column 2 Text', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$repeater->add_control(
			'col_2_tooltip',
			[
				'label' => __('Col 2 Tooltip', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$repeater->add_control(
			'col_2_media_type',
			[
				'label' => __('Column 2 Icon', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => array_flip(array(
					"None" => "none",
					"Icon" => "icon"
				)),
			]
		);
		$repeater->add_control(
			'col_2_icon',
			[
				'label' => esc_html__('pixfort Icon', 'pixfort-core'),
				'type' => \Elementor\CustomControl\PixfortIconSelector_Control::PixfortIconSelector,
				'default' => '',
				'condition' => [
					'col_2_media_type' => 'icon',
				],
			]
		);
		

		// Col 3
		$repeater->add_control(
			'col_3_text',
			[
				'label' => __('Column 3 Text', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$repeater->add_control(
			'col_3_tooltip',
			[
				'label' => __('Col 3 Tooltip', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$repeater->add_control(
			'col_3_media_type',
			[
				'label' => __('Column 3 Icon', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => array_flip(array(
					"None" => "none",
					"Icon" => "icon"
				)),
			]
		);
		$repeater->add_control(
			'col_3_icon',
			[
				'label' => esc_html__('pixfort Icon', 'pixfort-core'),
				'type' => \Elementor\CustomControl\PixfortIconSelector_Control::PixfortIconSelector,
				'default' => '',
				'condition' => [
					'col_3_media_type' => 'icon',
				],
			]
		);


		$this->add_control(
			'items',
			[
				'label' => __('Lines', 'pixfort-core'),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ title }}}',
				'fields' => $repeater->get_controls()
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
			'section_table_head',
			[
				'label' => __('Table Head', 'pixfort-core'),
				// 'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'bold',
			[
				'label' => __('Title Bold', 'pixfort-core'),
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
				'label' => __('Title Italic', 'pixfort-core'),
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
				'label' => __('Title Secondary font', 'pixfort-core'),
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
				'default' => 'h3',
			]
		);
		$this->add_control(
			'display',
			[
				'label' => __('Bigger Text', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''		=> 'None',
					'display-1'		=> 'Display 1',
					'display-2'		=> 'Display 2',
					'display-3'		=> 'Display 3',
					'display-4'		=> 'Display 4',
				),
				'default' => '',
				'condition' => [
					'title_size' => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6')
				],
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


		$this->add_control(
			'cols_bold',
			[
				'label' => __('Columns Bold', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-weight-bold',
				'default' => 'font-weight-bold',
			]
		);
		$this->add_control(
			'cols_italic',
			[
				'label' => __('Columns Italic', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-italic',
				'default' => '',
			]
		);
		$this->add_control(
			'cols_secondary_font',
			[
				'label' => __('Columns Secondary font', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'secondary-font',
				'default' => '',
			]
		);

		$this->add_control(
			'cols_titles_size',
			[
				'label' => __('Columns Titles size', 'pixfort-core'),
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
				'default' => 'h3',
			]
		);
		$this->add_control(
			'cols_titles_custom_size',
			[
				'label' => __('Columns Titles custom Size', 'pixfort-core'),
				'label_block' => false,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter custom columns title size', 'pixfort-core'),
				'default' => '',
				'condition' => [
					'cols_titles_size' => 'custom',
				],
			]
		);
		$this->add_control(
			'head_style',
			[
				'label' => __('Head Style', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					"" => "Default",
					"1"       => "Small shadow",
					"2"       => "Medium shadow",
					"3"       => "Large shadow",
					"7"       => "Bottom Line",
				),
			]
		);

		$this->add_responsive_control(
			'head_line_color',
			[
				'label' => __('Line color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'dark-opacity-1',
				'condition' => [
					'head_style' => '7',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-comparison-head.pix-bottom-line' => 'border-color: var(--pix-{{value}}) !important;',
				],
			]
		);
		$this->add_responsive_control(
			'head_line_custom_color',
			[
				'label' => __('Custom Lines color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'head_line_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-comparison-head.pix-bottom-line' => 'border-color: {{value}} !important;',
				],
			]
		);

		$this->add_control(
			'head_bg_color',
			[
				'label' => __('Head Background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
				'default' => 'white'
			]
		);
		$this->add_control(
			'head_custom_bg_color',
			[
				'label' => __('Custom Head Background Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'head_bg_color' => 'custom',
				],
			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'section_lines',
			[
				'label' => __('Lines', 'pixfort-core')
			]
		);


		$this->add_control(
			'descriptions_title_bold',
			[
				'label' => __('Title Bold', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-weight-bold',
				'default' => 'font-weight-bold',
			]
		);
		$this->add_control(
			'descriptions_title_italic',
			[
				'label' => __('Title Italic', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-italic',
				'default' => '',
			]
		);
		$this->add_control(
			'descriptions_title_secondary_font',
			[
				'label' => __('Title Secondary font', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'secondary-font',
				'default' => '',
			]
		);

		$this->add_control(
			'descriptions_title_color',
			[
				'label' => __('Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'heading-default',
			]
		);
		$this->add_control(
			'descriptions_title_custom_color',
			[
				'label' => __('Custom Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'descriptions_title_color' => 'custom',
				],
			]
		);

		$this->add_control(
			'descriptions_title_size',
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
				'default' => 'h6',
			]
		);

		$this->add_control(
			'descriptions_title_display',
			[
				'label' => __('Bigger Text', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''		=> 'None',
					'display-1'		=> 'Display 1',
					'display-2'		=> 'Display 2',
					'display-3'		=> 'Display 3',
					'display-4'		=> 'Display 4',
				),
				'default' => '',
				'condition' => [
					'descriptions_title_size' => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6')
				],
			]
		);


		$this->add_control(
			'descriptions_title_custom_size',
			[
				'label' => __('Custom Title size', 'pixfort-core'),
				'label_block' => false,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter custom title size', 'pixfort-core'),
				'default' => '',
				'condition' => [
					'descriptions_title_size' => 'custom',
				],
			]
		);
		$this->add_control(
			'content_size',
			[
				'label' => __('Content Size', 'pixfort-core'),
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




		$this->add_control(
			'content_bold',
			[
				'label' => __('Content Bold', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-weight-bold',
				'default' => '',
			]
		);
		$this->add_control(
			'content_italic',
			[
				'label' => __('Content Italic', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-italic',
				'default' => '',
			]
		);
		$this->add_control(
			'content_secondary_font',
			[
				'label' => __('Content Secondary font', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'secondary-font',
				'default' => '',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __('Content color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'body-default',
			]
		);
		$this->add_control(
			'content_custom_color',
			[
				'label' => __('Custom Content color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'content_color' => 'custom',
				],
			]
		);



		$this->add_control(
			'style',
			[
				'label' => __('Item Style', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					"" => "Default",
					"1"       => "Small shadow",
					"2"       => "Medium shadow",
					"3"       => "Large shadow",
					"4"       => "Inverse Small shadow",
					"5"       => "Inverse Medium shadow",
					"6"       => "Inverse Large shadow",
					"7"       => "Bottom Line",
				),
				'default' => '',
			]
		);

		$this->add_responsive_control(
			'items_line_color',
			[
				'label' => __('Line color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'dark-opacity-1',
				'condition' => [
					'style' => '7',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-bottom-line' => 'border-color: var(--pix-{{value}}) !important;',
				],
			]
		);
		$this->add_responsive_control(
			'items_line_custom_color',
			[
				'label' => __('Custom Lines color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'items_line_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-bottom-line' => 'border-color: {{value}} !important;',
				],
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
			'columns_bold',
			[
				'label' => __('Columns Bold', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-weight-bold',
				'default' => 'font-weight-bold',
			]
		);
		$this->add_control(
			'columns_italic',
			[
				'label' => __('Columns Italic', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-italic',
				'default' => '',
			]
		);
		$this->add_control(
			'columns_secondary_font',
			[
				'label' => __('Columns Secondary font', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'secondary-font',
				'default' => '',
			]
		);


		$this->add_control(
			'columns_size',
			[
				'label' => __('Columns Size', 'pixfort-core'),
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
			'section_column_1',
			[
				'label' => __('Column 1', 'pixfort-core')
			]
		);

		$this->add_control(
			'col_1_title',
			[
				'label' => __('Column 1 Title', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'default' => '',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);


		$this->add_control(
			'col_1_color',
			[
				'label' => __('Col 1 color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'heading-default',
			]
		);
		$this->add_control(
			'col_1_custom_color',
			[
				'label' => __('Custom Col 1 color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'col_1_color' => 'custom',
				],
			]
		);


		$this->end_controls_section();



		$this->start_controls_section(
			'section_column_2',
			[
				'label' => __('Column 2', 'pixfort-core')
			]
		);

		$this->add_control(
			'col_2_title',
			[
				'label' => __('Column 2 Title', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'default' => '',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$this->add_control(
			'col_2_color',
			[
				'label' => __('Col 2 color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'heading-default',
			]
		);
		$this->add_control(
			'col_2_custom_color',
			[
				'label' => __('Custom Col 2 color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'col_2_color' => 'custom',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_column_3',
			[
				'label' => __('Column 3', 'pixfort-core')
			]
		);

		$this->add_control(
			'col_3_title',
			[
				'label' => __('Column 3 Title', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'default' => '',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$this->add_control(
			'col_3_color',
			[
				'label' => __('Col 3 color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'heading-default',
			]
		);
		$this->add_control(
			'col_3_custom_color',
			[
				'label' => __('Custom Col 3 color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'col_3_color' => 'custom',
				],
			]
		);


		$this->end_controls_section();



		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __('Advanced', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);



		$this->add_control(
			'visible_overflow',
			[
				'label' => __('Visible overflow', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'pix-overflow-all-visible',
				'default' => '',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if (!empty($settings['items']) && is_array($settings['items'])) {
			foreach ($settings['items'] as $k => $value) {
				if (!empty($settings['items'][$k]['link']) && is_array($settings['items'][$k]['link'])) {
					if (!empty($settings['items'][$k]['link']['is_external'])) {
						$settings['items'][$k]['target'] = $settings['items'][$k]['link']['is_external'];
					}
					if (!empty($settings['items'][$k]['link']['custom_attributes'])) {
						$settings['items'][$k]['link_atts'] = $settings['items'][$k]['link']['custom_attributes'];
					}
					$settings['items'][$k]['link'] = $settings['items'][$k]['link']['url'];
				}
			}
		}
		if (empty($settings['element_id'])) {
			$settings['element_id'] = 'el-' . $this->get_id();
		}
		echo \PixfortCore::instance()->elementsManager->renderElement('ComparisonTable', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
