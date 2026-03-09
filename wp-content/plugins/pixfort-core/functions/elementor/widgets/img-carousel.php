<?php

namespace Elementor;

class Pix_Eor_Img_Carousel extends Widget_Base {

	public function __construct($data = [], $args = null) {
		if (!empty($data['settings'])) {
			if (!empty($data['settings']['items'])) {
				foreach ($data['settings']['items'] as $key => $value) {
					$is_external = true;
					if (array_key_exists('target', $data['settings']['items'][$key])) {
						$is_external = false;
					}
					if (!empty($data['settings']['items'][$key]['link']) && !is_array($data['settings']['items'][$key]['link'])) {
						$data['settings']['items'][$key]['link'] = [
							'url' => $data['settings']['items'][$key]['link'],
							'is_external' => $is_external,
							'nofollow' => false,
						];
					}
				}
			}
			if(!empty($data['settings']['dots_style'])) {
				if($data['settings']['dots_style'] === 'light-dots') {
					if(empty($data['settings']['navigation_color'])) {
						$data['settings']['navigation_color'] = 'light-opacity-3';
					}
					$data['settings']['dots_style'] = '';
				}
			}
		}
		parent::__construct($data, $args);

		wp_register_script('pix-img-carousel-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/img-carousel.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
		wp_register_style('pixfort-slider-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/slider.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
	}

	public function get_name() {
		return 'pix-img-carousel';
	}

	public function get_title() {
		return 'Image Carousel';
	}

	public function get_icon() {
		return 'eicon-slider-album pixfort-elementor-element pixfort-elementor-image-carousel';
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

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'image',
			[
				'label' => __('Image', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$repeater->add_control(
			'alt',
			[
				'label' => __('Image alternative text', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'label_block' => true,
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$repeater->add_control(
			'link',
			[
				'label' => __('Link', 'pixfort-core'),
				'type' => Controls_Manager::URL,
				'placeholder' => __('Link', 'pixfort-core'),
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'items',
			[
				'label' => __('Items', 'pixfort-core'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls()
			]
		);

		$this->add_control(
			'rounded_img',
			[
				'label' => __('Rounded corners', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded-0',
				'options' => [
					'rounded-0' => __('No', 'pixfort-core'),
					'rounded' => __('Rounded', 'pixfort-core'),
					'rounded-lg' => __('Rounded Large', 'pixfort-core'),
					'rounded-xl' => __('Rounded 5px', 'pixfort-core'),
					'rounded-10' => __('Rounded 10px', 'pixfort-core'),
				],
			]
		);


		$this->add_control(
			'pix_scroll_parallax',
			[
				'label' => __('Scroll Parallax', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Enable', 'pixfort-core'),
				'label_off' => __('Disable', 'pixfort-core'),
				'return_value' => 'scroll_parallax',
				'default' => 'no',
			]
		);

		$this->add_control(
			'xaxis',
			[
				'label' => __('Vertical Parallax', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('0', 'pixfort-core'),
				'placeholder' => __('Type your title here', 'pixfort-core'),
				'condition' => [
					'pix_scroll_parallax' => 'scroll_parallax',
				],
			]
		);
		$this->add_control(
			'yaxis',
			[
				'label' => __('Horizontal Parallax', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('0', 'pixfort-core'),
				'placeholder' => __('Type your title here', 'pixfort-core'),
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
				'label_on' => __('Enable', 'pixfort-core'),
				'label_off' => __('Disable', 'pixfort-core'),
				'return_value' => 'tilt',
				'default' => 'no',

			]
		);

		$this->add_control(
			'pix_tilt_size',
			[
				'label' => __('3d hover size', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'tilt',
				'options' => [
					'tilt' => __('Default', 'pixfort-core'),
					'tilt_big' => __('Big', 'pixfort-core'),
					'tilt_small' => __('Small', 'pixfort-core'),
				],
				'condition' => [
					'pix_tilt' => 'tilt',
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




		$this->end_controls_section();




		pix_get_elementor_effects($this);



		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __('Advanced', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		if (defined('PIXFORT_SLIDER_SWIPER')) {
			$this->add_responsive_control(
				'slider_num',
				[
					'label' => __('Slides per page', 'pixfort-core'),
					'type' => Controls_Manager::SELECT,
					'default' => 3,
					'options' => [
						1 	=> "1",
						2 	=> "2",
						3 	=> "3",
						4 	=> "4",
						5 	=> "5",
						6 	=> "6",
					],
					'devices' => ['desktop', 'tablet', 'mobile'],
					'desktop_default' => 3,
					// 'tablet_default' => 2,
					'mobile_default' => 1,
				]
			);
		} else {
			$this->add_control(
				'slider_num',
				[
					'label' => __('Slides per page', 'pixfort-core'),
					'type' => Controls_Manager::SELECT,
					'default' => 3,
					'options' => [
						1 	=> "1",
						2 	=> "2",
						3 	=> "3",
						4 	=> "4",
						5 	=> "5",
						6 	=> "6",
					],
				]
			);
		}
		$this->add_control(
			'slider_style',
			[
				'label' => __('Slides style', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'pix-style-standard',
				'options' => [
					'pix-style-standard'        => __('Standard', 'pixfort-core'),
					'pix-one-active'         	=> __('One active item', 'pixfort-core'),
					'pix-opacity-slider'        => __('Faded items', 'pixfort-core'),
				],
			]
		);
		$this->add_control(
			'slider_effect',
			[
				'label' => __('Slides effect', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'pix-effect-standard',
				'options' => array_flip(
					array(
						__('Standard', 'pixfort-core') 	                => 'pix-effect-standard',
						__('Circular effect', 'pixfort-core') 	        => 'pix-circular-slider',
						__('Circular Start Only', 'pixfort-core') 	        => 'pix-circular-left',
						__('Circular End Only', 'pixfort-core') 	    => 'pix-circular-right',
						__('Fade out', 'pixfort-core') 	                => 'pix-fade-out-effect',
					)
				),
			]
		);
		if (defined('PIXFORT_SLIDER_SWIPER')) {
			$this->add_control(
				'drag_scale',
				[
					'label' => __('Drag Scale Animation', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __('Yes', 'pixfort-core'),
					'label_off' => __('No', 'pixfort-core'),
					'return_value' => 'true',
					'default' => false,
				]
			);
		}

		$this->add_control(
			'prevnextbuttons',
			[
				'label' => __('Show navigation buttons', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => 'true',

			]
		);
		$this->add_control(
			'pagedots',
			[
				'label' => __('Dots', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => 'true',

			]
		);
		$this->add_control(
			'dots_style',
			[
				'label' => __('Dots style', 'pixfort-core'),
				'type' => Controls_Manager::HIDDEN,
				'default' => '',
				'options' => [
					''			=> 'Default',
					'light-dots' 	=> 'Light',
				],
				'condition' => [
					'pagedots' => 'true',
				],
			]
		);
		$this->add_control(
			'dots_align',
			[
				'label' => __('Dots style', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''			=> 'Center',
					'pix-dots-left' 	=> 'Left',
					'pix-dots-right' 	=> 'Right',
				],
				'condition' => [
					'pagedots' => 'true',
				],
			]
		);
		$this->add_control(
			'freescroll',
			[
				'label' => __('Free Scroll', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => '',

			]
		);
		$this->add_control(
			'cellalign',
			[
				'label' => __('Main cell Align', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'center'			=> 'Center',
					'left' 	=> 'Start',
					'right' 	=> 'End',
				],
			]
		);
		$this->add_control(
			'slider_scale',
			[
				'label' => __('Scale main item', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'pix-slider-scale',
				'default' => '',
			]
		);
		$this->add_responsive_control(
			'spaceBetween',
			[
				'label' => __('Gap between items (in px)', 'pixfort-core'),
				'type' => Controls_Manager::NUMBER,
				'range' => [
					'min' => 0,
					'max' => 100,
				],
				'desktop_default' => 0,
				'render_type' => 'template',
				'devices' => ['desktop', 'tablet', 'mobile'],
			]
		);
		$this->add_control(
			'cellpadding',
			[
				'label' => __('Cells padding', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'pix-p-10',
				'options' => [
					'p-0'				=> '0px',
					'pix-p-5'			=> '5px',
					'pix-p-10'			=> '10px',
					'pix-p-15'			=> '15px',
					'pix-p-20'			=> '20px',
					'pix-p-25'			=> '25px',
					'pix-p-30'			=> '30px',
					'pix-p-35'			=> '35px',
					'pix-p-40'			=> '40px',
					'pix-p-45'			=> '45px',
					'pix-p-50'			=> '50px',
				],
			]
		);
		$this->add_control(
			'autoplay',
			[
				'label' => __('Autoplay', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => '',
			]
		);
		$this->add_control(
			'autoplay_time',
			[
				'label' => __('Autoplay time', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('1500', 'pixfort-core'),
				'placeholder' => __('Type your title here', 'pixfort-core'),
			]
		);
		$this->add_control(
			'adaptiveheight',
			[
				'label' => __('Adaptive height', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => '',
			]
		);
		$this->add_control(
			'righttoleft',
			[
				'label' => __('Right to Left', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => '',
			]
		);
		$this->add_control(
			'slider_wrap',
			[
				'label' => __('Wrap slides', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
		$this->add_control(
			'visible_y',
			[
				'label' => __('Increase vertical view', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'pix-overflow-y-visible',
				'default' => '',
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

		if (defined('PIXFORT_SLIDER_SWIPER')) {

			$this->start_controls_section(
				'section_navigation_style',
				[
					'label' => __('Navigation Buttons', 'pixfort-core'),
					'tab' => Controls_Manager::TAB_STYLE,
					'condition' => [
						'prevnextbuttons' => 'true',
					],
				]
			);

			$this->add_responsive_control(
				'navigation_spacing',
				[
					'label' => __('Navigation Spacing', 'pixfort-core'),
					'type' => Controls_Manager::SLIDER,
					'size_units' => ['px', '%'],
					'range' => [
						'px' => [
							'min' => -200,
							'max' => 200,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 80,
					],
					'selectors' => [
						'{{WRAPPER}} .pixfort-button-prev, {{WRAPPER}} .pixfort-button-next' => '--pix-slider-nav-spacing: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'navigation_color',
				[
					'label' => __('Navigation color', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
					'default' => 'dark-opacity-3',
					'selectors' => [
						'{{WRAPPER}} .pixfort-button-prev, {{WRAPPER}} .pixfort-button-next' => '--pix-slider-nav-color: var(--pix-{{VALUE}}) !important;',
					],
				]
			);
	
		$this->add_responsive_control(
			'custom_navigation_color',
			[
				'label' => __('Custom Navigation Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'navigation_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pixfort-button-prev, {{WRAPPER}} .pixfort-button-next' => '--pix-slider-nav-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'navigation_bg_color',
			[
				'label' => __('background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')], 'mainLight' => true, 'gradients' => false, 'gradients' => false]),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pixfort-button-prev, {{WRAPPER}} .pixfort-button-next' => '--pix-slider-nav-bg-color: var(--pix-{{VALUE}}) !important;',
				],
			]
		);

		$this->add_responsive_control(
			'custom_navigation_bg_color',
			[
				'label' => __('Custom Background Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'navigation_bg_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pixfort-button-prev, {{WRAPPER}} .pixfort-button-next' => '--pix-slider-nav-bg-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'navigation_border_color',
			[
				'label' => __('Border color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')], 'mainLight' => true, 'gradients' => false]),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pixfort-button-prev, {{WRAPPER}} .pixfort-button-next' => '--pix-slider-nav-border-color: var(--pix-{{VALUE}}) !important;',
				],
			]
		);

		$this->add_responsive_control(
			'custom_navigation_border_color',
			[
				'label' => __('Custom Border Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'navigation_border_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pixfort-button-prev, {{WRAPPER}} .pixfort-button-next' => '--pix-slider-nav-border-color: {{VALUE}} !important;',
				],
			]
		);


		$this->add_responsive_control(
			'navigation_size',
				[
					'label' => __('Button Size', 'pixfort-core'),
					'type' => Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range' => [
						'px' => [
							'min' => 20,
							'max' => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .pixfort-button-prev, {{WRAPPER}} .pixfort-button-next' => '--pix-slider-nav-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'navigation_icon_size',
				[
					'label' => __('Icon Size', 'pixfort-core'),
					'type' => Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range' => [
						'px' => [
							'min' => 10,
							'max' => 60,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .pixfort-button-prev, {{WRAPPER}} .pixfort-button-next' => '--pix-slider-nav-svg-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'navigation_border_size',
				[
					'label' => __('Border Size', 'pixfort-core'),
					'type' => Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 10,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .pixfort-button-prev, {{WRAPPER}} .pixfort-button-next' => '--pix-slider-nav-border-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'navigation_border_radius',
				[
					'label' => __('Border Radius', 'pixfort-core'),
					'type' => Controls_Manager::SLIDER,
					'size_units' => ['px', '%'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .pixfort-button-prev, {{WRAPPER}} .pixfort-button-next' => '--pix-slider-nav-border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'navigation_shadow_style',
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
				]
			);
			$this->add_control(
				'navigation_hover_effect',
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
			// $this->add_control(
			// 	'navigation_add_hover_effect',
			// 	[
			// 		'label' => __('Hover Animation', 'pixfort-core'),
			// 		'type' => \Elementor\Controls_Manager::SELECT,
			// 		'options' => array(
			// 			""       => "None",
			// 			"1"       => "Fly Small",
			// 			"2"       => "Fly Medium",
			// 			"3"       => "Fly Large",
			// 			"4"       => "Scale Small",
			// 			"5"       => "Scale Medium",
			// 			"6"       => "Scale Large",
			// 			"7"       => "Scale Inverse Small",
			// 			"8"       => "Scale Inverse Medium",
			// 			"9"       => "Scale Inverse Large",
			// 		),
			// 		'default' => '',
			// 	]
			// );

			$this->end_controls_section();

			// $this->start_controls_section(
			// 	'section_pagination_style',
			// 	[
			// 		'label' => __('Pagination', 'pixfort-core'),
			// 		'tab' => Controls_Manager::TAB_STYLE,
			// 		'condition' => [
			// 			'pagedots' => 'true',
			// 		],
			// 	]
			// );

			// $this->add_responsive_control(
			// 	'pagination_spacing',
			// 	[
			// 		'label' => __('Pagination Spacing', 'pixfort-core'),
			// 		'type' => Controls_Manager::SLIDER,
			// 		'size_units' => ['px', 'em', 'rem'],
			// 		'range' => [
			// 			'px' => [
			// 				'min' => -200,
			// 				'max' => 200,
			// 				'step' => 1,
			// 			],
			// 			'em' => [
			// 				'min' => -20,
			// 				'max' => 20,
			// 				'step' => 0.1,
			// 			],
			// 			'rem' => [
			// 				'min' => -20,
			// 				'max' => 20,
			// 				'step' => 0.1,
			// 			],
			// 		],
			// 		'default' => [
			// 			'size' => 20,
			// 			'unit' => 'px',
			// 		],
			// 		'selectors' => [
			// 			'{{WRAPPER}} .pixfort-slider-pagination-container' => '--pix-slider-pagination-spacing: {{SIZE}}{{UNIT}};',
			// 		],
			// 	]
			// );

			// $this->end_controls_section();

		}
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if (!empty($settings)) {
			if (!empty($settings['items'])) {
				foreach ($settings['items'] as $key => $value) {
					if (!empty($settings['items'][$key]['link']['is_external'])) {
						$settings['items'][$key]['target'] = $settings['items'][$key]['link']['is_external'];
					}
					if (!empty($settings['items'][$key]['link']['custom_attributes'])) {
						$settings['items'][$key]['link_atts'] = $settings['items'][$key]['link']['custom_attributes'];
					}
					$settings['items'][$key]['link'] = $settings['items'][$key]['link']['url'];
				}
			}
		}
		echo \PixfortCore::instance()->elementsManager->renderElement('ImgCarousel', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-img-carousel-handle'];
		return [];
	}
	public function get_style_depends() {
		if (is_user_logged_in()) return ['pixfort-slider-style'];
		return [];
	}
}
