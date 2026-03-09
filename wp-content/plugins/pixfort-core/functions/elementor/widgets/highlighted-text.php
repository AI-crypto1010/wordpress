<?php

namespace Elementor;

class Pix_Eor_Highlighted_Text extends Widget_Base {

	public function __construct($data = [], $args = null) {
		// image_size migration code
		if (!empty($data['settings'])) {
			if (!empty($data['settings']['items'])) {
				foreach ($data['settings']['items'] as $key => $value) {
					if (!empty($data['settings']['items'][$key]['image_size']) && !is_array($data['settings']['items'][$key]['image_size'])) {
						$image_size = (int) filter_var($data['settings']['items'][$key]['image_size'], FILTER_SANITIZE_NUMBER_INT);
						$tabletImgSize = $image_size * 0.8;
						$mobileImgSize = $image_size * 0.6;
						$data['settings']['items'][$key]['image_size'] = [
							'unit' => 'px',
							'size' => $image_size,
						];
						$data['settings']['items'][$key]['image_size_tablet'] = [
							'unit' => 'px',
							'size' => $tabletImgSize
						];
						$data['settings']['items'][$key]['image_size_mobile'] = [
							'unit' => 'px',
							'size' => $mobileImgSize
						];
					}
				}
			}
		}
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-highlighted-text';
	}

	public function get_title() {
		return 'Highlighted text';
	}

	public function get_icon() {
		return 'eicon-code-highlight pixfort-elementor-element pixfort-elementor-highlighted-text';
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



		$repeater = new \Elementor\Repeater();


		$repeater->add_control(
			'is_highlighted',
			[
				'label' => __('Highlighted', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip(array(
					__('Normal text', 'pixfort-core')     => '',
					__('Highlighted text', 'pixfort-core')    => 'yes',
					__('Image', 'pixfort-core')        => 'image',
				)),
			]
		);
		$repeater->add_control(
			'text',
			[
				'label' => __('Text', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter the text', 'pixfort-core'),
				'default' => '',
				'dynamic'     => array(
					'active'  => true
				),
				'condition' => [
					'is_highlighted!' => 'image',
				],
			]
		);
		$repeater->add_control(
			'highlight_color',
			[
				'label' => __('Highlight color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffd900',
				'selectors' => [
					// '{{WRAPPER}} {{CURRENT_ITEM}}.pix-highlight-bg' => 'background-image: linear-gradient( {{VALUE}} , {{VALUE}} ) !important;',
					'{{WRAPPER}} {{CURRENT_ITEM}}.pix-highlight-bg' => '--pix-highlight-bg: {{VALUE}} !important;',
				],
				'dynamic'     => array(
					'active'  => true
				),
				'condition' => [
					'is_highlighted' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'custom_height',
			[
				'label' => __('Custom height (default is 30)', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Input number between 0 and 100', 'pixfort-core'),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.animated:not(:hover), {{WRAPPER}} {{CURRENT_ITEM}}.highlight-grow' => 'background-size: 100% {{VALUE}}% !important;',
				],
				'dynamic'     => array(
					'active'  => true
				),
				'condition' => [
					'is_highlighted' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'bold',
			[
				'label' => __('Bold', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-weight-bold',
				'default' => false,
				'condition' => [
					'is_highlighted' => ['', 'yes'],
				],
			]
		);
		$repeater->add_control(
			'italic',
			[
				'label' => __('Italic', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-italic',
				'default' => '',
				'condition' => [
					'is_highlighted' => ['', 'yes'],
				],
			]
		);
		$repeater->add_control(
			'heading_font',
			[
				'label' => __('Heading font', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'heading-font',
				'default' => 'heading-font',
				'condition' => [
					'is_highlighted' => ['', 'yes'],
				],
			]
		);
		$repeater->add_control(
			'has_color',
			[
				'label' => __('Different color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'is_highlighted!' => 'image',
				],
			]
		);
		$repeater->add_control(
			'item_color',
			[
				'label' => __('Text Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['advancedValues' => ['custom-gradient' => __('Custom Gradient', 'pixfort-core')]]),
				'default' => '',
				'condition' => [
					'is_highlighted!' => 'image',
					'has_color' => ['yes'],
				],
			]
		);
		$repeater->add_control(
			'item_custom_color',
			[
				'label' => __('Custom Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#333',
				'condition' => [
					'is_highlighted!' => 'image',
					'item_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .el-title_custom_color' => 'color: {{VALUE}};',
				],
			]
		);
		$repeater->add_responsive_control(
			'item_custom_gradient_color',
			[
				'label' => esc_html__('Gradient custom picker', 'pixfort-core'),
				'type' => \Elementor\CustomControl\CustomGradient_Control::CustomGradient,
				'default' => '',
				// 'class' => '',
				'condition' => [
					'item_color' => 'custom-gradient',
					'has_color' => 'yes',
				],
				'selectors' => [
					// '{{WRAPPER}}:before' => 'border-radius: inherit;background: {{VALUE}} !important; content: \' \';position: absolute;width: 100%;height: 100%;top: 0;left: 0;pointer-events: none;z-index: 0;',
					'{{WRAPPER}} {{CURRENT_ITEM}} .text-custom-gradient' => 'background-image: {{VALUE}} !important;',
					'{{WRAPPER}} .elementor-background-video-container' => 'z-index: -1;'
				],

			]
		);
		// $repeater->add_control(
		// 	'image',
		// 	[
		// 		'label' => __('Image', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::MEDIA,
		// 		'dynamic'     => array(
		// 			'active'  => true
		// 		),
		// 		'condition' => [
		// 			'is_highlighted' => 'image',
		// 		],
		// 	]
		// );
		getElementorDynamicImageControls($repeater, 'image', 'image_dark');

		// $repeater->add_responsive_control(
		// 	'image_size',
		// 	[
		// 		'label' => __( 'Image Size', 'pixfort-core' ),
		// 		'type' => \Elementor\Controls_Manager::TEXT,
		// 		'default' => __( '', 'pixfort-core' ),
		// 		'placeholder' => __( 'Leave empty for full size.', 'pixfort-core' ),
		// 		'condition' => [
		// 			'is_highlighted' => 'image',
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} {{CURRENT_ITEM}} img' => 'width: {{VALUE}} !important;height: {{VALUE}} !important;',
		// 			// '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'width: {{VALUE}}px !important;height: {{VALUE}}px !important;',
		// 		],
		// 	]
		// );
		$repeater->add_responsive_control(
			'image_size',
			[
				'label' => __('Image Size', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => '',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 400,
						'step' => 1,
					]
				],
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'placeholder' => __('Leave empty for full size.', 'pixfort-core'),
				'condition' => [
					'is_highlighted' => 'image',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} img' => 'width: {{SIZE}}{{UNIT}} !important;height: auto !important;',
					// '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'width: {{VALUE}}px !important;height: {{VALUE}}px !important;',
				],
			]
		);
		$repeater->add_control(
			'rounded_img',
			[
				'label' => __('Rounded corners', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded-lg',
				'options' => [
					'rounded-0' => __('No', 'pixfort-core'),
					'rounded' => __('Rounded Small', 'pixfort-core'),
					'rounded-lg' => __('Rounded Large', 'pixfort-core'),
					'rounded-xl' => __('Rounded 5px', 'pixfort-core'),
					'rounded-10' => __('Rounded 10px', 'pixfort-core'),
					'rounded-circle' => 	__('Circle', 'pixfort-core')
				],
				'condition' => [
					'is_highlighted' => 'image',
				],
			]
		);
		$repeater->add_control(
			'style',
			[
				'label' => __('Shadow Style', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					"" => "Default",
					"1"       => "Small shadow",
					"2"       => "Medium shadow",
					"3"       => "Large shadow",
					"4"       => "Inverse Small shadow",
					"5"       => "Inverse Medium shadow",
					"6"       => "Inverse Large shadow",
				),
				'default' => '',
				'condition' => [
					'is_highlighted' => 'image',
				],
			]
		);
		$repeater->add_control(
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
				'condition' => [
					'is_highlighted' => 'image',
				],
			]
		);
		$repeater->add_control(
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
				'condition' => [
					'is_highlighted' => 'image',
				],
			]
		);
		$repeater->add_control(
			'item_animation',
			[
				'label' => __('Animation', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => pix_get_animations(true),
				// 'condition' => [
				// 	'is_highlighted' => 'image',
				// ],
			]
		);
		$repeater->add_control(
			'item_delay',
			[
				'label' => __('Animation delay (in miliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('0', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					'item_animation!' => '',
				],
			]
		);




		$repeater->add_control(
			'new_line',
			[
				'label' => __('Add new line after text', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'items',
			[
				'label' => __('Text', 'pixfort-core'),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ text }}}',
				'fields' => $repeater->get_controls()
			]
		);



		//
		// $this->add_control(
		// 	'title',
		// 	[
		// 		'label' => __( 'Title', 'pixfort-core' ),
		// 		'label_block' => true,
		// 		'type' => Controls_Manager::TEXT,
		// 		'placeholder' => __( '', 'pixfort-core' ),
		// 		'default' => '',
		// 		'dynamic'     => array(
		//             'active'  => true
		//         ),
		// 	]
		// );

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
			'title_section',
			[
				'label' => __('Text format', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		// $this->add_control(
		// 	'bold',
		// 	[
		// 		'label' => __( 'Bold', 'pixfort-core' ),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'label_on' => __( 'Yes', 'pixfort-core' ),
		// 		'label_off' => __( 'No', 'pixfort-core' ),
		// 		'return_value' => 'font-weight-bold',
		// 		'default' => 'font-weight-bold',
		// 	]
		// );
		// $this->add_control(
		// 	'italic',
		// 	[
		// 		'label' => __( 'Italic', 'pixfort-core' ),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'label_on' => __( 'Yes', 'pixfort-core' ),
		// 		'label_off' => __( 'No', 'pixfort-core' ),
		// 		'return_value' => 'font-italic',
		// 		'default' => '',
		// 	]
		// );
		// $this->add_control(
		// 	'secondary_font',
		// 	[
		// 		'label' => __( 'Secondary font', 'pixfort-core' ),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'label_on' => __( 'Yes', 'pixfort-core' ),
		// 		'label_off' => __( 'No', 'pixfort-core' ),
		// 		'return_value' => 'secondary-font',
		// 		'default' => '',
		// 	]
		// );
		$this->add_control(
			'title_color',
			[
				'label' => __('Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => '',
			]
		);
		$this->add_control(
			'title_custom_color',
			[
				'label' => __('Custom Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'title_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .text-custom' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_size',
			[
				'label' => __('Text size', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array_flip(array(
					__('H1', 'pixfort-core') 	=> 'h1',
					__('H2', 'pixfort-core')	    => 'h2',
					__('H3', 'pixfort-core')	    => 'h3',
					__('H4', 'pixfort-core')	    => 'h4',
					__('H5', 'pixfort-core')	    => 'h5',
					__('H6', 'pixfort-core')	    => 'h6',
					__('Div', 'pixfort-core')	    => 'custom',
				)),
				'default' => 'h1',
			]
		);
		$this->add_responsive_control(
			'title_custom_size',
			[
				'label' => __('Custom Text size', 'pixfort-core'),
				'label_block' => false,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter custom title size', 'pixfort-core'),
				'default' => '',
				'condition' => [
					'title_size' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-highlighted-items' => 'font-size: {{VALUE}} !important;'
				],
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


		$this->add_responsive_control(
			'max_width',
			[
				'label' => __('Field max width', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('Input the width with the unit (eg. 300px)', 'pixfort-core'),
				'selectors' => [
					'{{WRAPPER}} .pix-highlighted-items' => 'max-width: {{VALUE}} !important;display: inline-block;',
				],
			]
		);

		// $this->add_control(
		// 	'disable_resp_img',
		// 	[
		// 		'label' => __('Disable responsive images size in mobile devices', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'label_on' => __('Yes', 'pixfort-core'),
		// 		'label_off' => __('No', 'pixfort-core'),
		// 		'return_value' => 'yes',
		// 		// 'default' => false,
		// 	]
		// );

		$this->end_controls_section();


		$this->start_controls_section(
			'section_element_style',
			[
				'label' => __('Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// $this->add_responsive_control(
		// 	'position',
		// 	[
		// 		'label' => __('Position', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::SELECT,
		// 		'options' => array(
		// 			'text-center'		=> 'Center',
		// 			'text-left'			=> 'Start',
		// 			'text-right' 		=> 'End',
		// 		),
		// 		'default' => 'text-center',
		// 		'selectors_dictionary' => [
		// 			'text-center' 		=> 'text-align: center !important;',
		// 			'text-left' 		=> 'text-align: left !important;',
		// 			'text-right' 		=> 'text-align: right !important;'
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-highlighted-element' => '{{VALUE}}'
		// 		],
		// 	]
		// );
		
		$left = 'left';
		$right = 'right';
		$startIcon = 'eicon-text-align-left';
		$endIcon = 'eicon-text-align-right';
		if(is_rtl()){
			$left = 'right';
			$right = 'left';
			$startIcon = 'eicon-text-align-right';
			$endIcon = 'eicon-text-align-left';
		}
		$this->add_responsive_control(
			'position',
			[
				'label' => __('Position', 'pixfort-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'text-left' => [
						'title' => __('Start', 'pixfort-core'),
						'icon' => $startIcon,
					],
					'text-center' => [
						'title' => __('Center', 'pixfort-core'),
						'icon' => 'eicon-text-align-center',
					],
					'text-right' => [
						'title' => __('End', 'pixfort-core'),
						'icon' => $endIcon,
					]
				],
				'default' => 'text-center',
				'selectors_dictionary' => [
					'text-center' 		=> 'text-align: center !important;',
					'text-left' 		=> 'text-align: '.$left.' !important;',
					'text-right' 		=> 'text-align: '.$right.' !important;'
				],
				'selectors' => [
					'{{WRAPPER}} .pix-highlighted-element' => '{{VALUE}}'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'bar_inner_typography',
				'selector' => '{{WRAPPER}} .pix-highlighted-items, {{WRAPPER}} .pix-highlight-item.heading-font, {{WRAPPER}} .pix-highlight-item.font-weight-normal',
				'fields_options' => [
					'font_family' => [
						'selectors' => [
							'{{WRAPPER}} .pix-highlighted-items, {{WRAPPER}} .pix-highlight-item.heading-font, {{WRAPPER}} .pix-highlight-item.body-font' => 'font-family: {{value}} !important;',
						],
					],
					'font_weight' => [
						'selectors' => [
							'{{WRAPPER}} .pix-highlighted-items, {{WRAPPER}} .pix-highlight-item.heading-font, {{WRAPPER}} .pix-highlight-item.font-weight-normal' => 'font-weight: {{value}} !important;',
						],
					],
				],
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
		$settings['heading_id'] = 'el-' . $this->get_id();
		echo \PixfortCore::instance()->elementsManager->renderElement('HighlightedText', $settings);
	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
