<?php

namespace Elementor;

class Pix_Eor_Video_Slider extends Widget_Base {

	public function __construct($data = [], $args = null) {
		if (!empty($data['settings'])) {
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

		wp_register_script('pix-video-slider-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/video-slider.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
		if (is_user_logged_in()) wp_enqueue_style('pixfort-carousel-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/carousel-2.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		if (is_user_logged_in()) wp_enqueue_style('pixfort-video-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/video.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
	}

	public function get_name() {
		return 'pix-video-slider';
	}

	public function get_title() {
		return 'Video slider';
	}

	public function get_icon() {
		return 'eicon-slider-video pixfort-elementor-element pixfort-elementor-video-carousel';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	protected function register_controls() {

		// $colors_no_custom = array(
		// 	"Body default"			=> "body-default",
		// 	"Heading default"		=> "heading-default",
		// 	"Primary"				=> "primary",
		// 	"Primary Gradient"		=> "gradient-primary",
		// 	"Secondary"				=> "secondary",
		// 	"White"					=> "white",
		// 	"Black"					=> "black",
		// 	"Green"					=> "green",
		// 	"Blue"					=> "blue",
		// 	"Red"					=> "red",
		// 	"Yellow"				=> "yellow",
		// 	"Brown"					=> "brown",
		// 	"Purple"				=> "purple",
		// 	"Orange"				=> "orange",
		// 	"Cyan"					=> "cyan",
		// 	// "Transparent"					=> "transparent",
		// 	"Gray 1"				=> "gray-1",
		// 	"Gray 2"				=> "gray-2",
		// 	"Gray 3"				=> "gray-3",
		// 	"Gray 4"				=> "gray-4",
		// 	"Gray 5"				=> "gray-5",
		// 	"Gray 6"				=> "gray-6",
		// 	"Gray 7"				=> "gray-7",
		// 	"Gray 8"				=> "gray-8",
		// 	"Gray 9"				=> "gray-9",
		// 	"Dark opacity 1"		=> "dark-opacity-1",
		// 	"Dark opacity 2"		=> "dark-opacity-2",
		// 	"Dark opacity 3"		=> "dark-opacity-3",
		// 	"Dark opacity 4"		=> "dark-opacity-4",
		// 	"Dark opacity 5"		=> "dark-opacity-5",
		// 	"Dark opacity 6"		=> "dark-opacity-6",
		// 	"Dark opacity 7"		=> "dark-opacity-7",
		// 	"Dark opacity 8"		=> "dark-opacity-8",
		// 	"Dark opacity 9"		=> "dark-opacity-9",
		// 	"Light opacity 1"		=> "light-opacity-1",
		// 	"Light opacity 2"		=> "light-opacity-2",
		// 	"Light opacity 3"		=> "light-opacity-3",
		// 	"Light opacity 4"		=> "light-opacity-4",
		// 	"Light opacity 5"		=> "light-opacity-5",
		// 	"Light opacity 6"		=> "light-opacity-6",
		// 	"Light opacity 7"		=> "light-opacity-7",
		// 	"Light opacity 8"		=> "light-opacity-8",
		// 	"Light opacity 9"		=> "light-opacity-9",
		// );
		
		$infinite_animation = array(
			"None"                  => "",
			"Rotating"              => "pix-rotating",
			"Rotating inversed"     => "pix-rotating-inverse",
			"Fade"                  => "pix-fade",
			"Bounce Small"          => "pix-bounce-sm",
			"Bounce Medium" 		=> "pix-bounce-md",
			"Bounce Large" 			=> "pix-bounce-lg",
			"Scale Small"           => "pix-scale-sm",
			"Scale Medium"           => "pix-scale-md",
			"Scale Large"           => "pix-scale-lg",

		);
		$animation_speeds = array(
			"Fast" 			=> "pix-duration-fast",
			"Medium" 		=> "pix-duration-md",
			"Slow" 			=> "pix-duration-slow",
		);
		$this->start_controls_section(
			'section_title',
			[
				'label' => __('Content', 'pixfort-core'),
			]
		);

		// $colors = array(
		// 	"Body default"			=> "body-default",
		// 	"Heading default"		=> "heading-default",
		// 	"Primary"				=> "primary",
		// 	"Primary Gradient"		=> "gradient-primary",
		// 	"Secondary"				=> "secondary",
		// 	"White"					=> "white",
		// 	"Black"					=> "black",
		// 	"Green"					=> "green",
		// 	"Blue"					=> "blue",
		// 	"Red"					=> "red",
		// 	"Yellow"				=> "yellow",
		// 	"Brown"					=> "brown",
		// 	"Purple"				=> "purple",
		// 	"Orange"				=> "orange",
		// 	"Cyan"					=> "cyan",
		// 	// "Transparent"					=> "transparent",
		// 	"Gray 1"				=> "gray-1",
		// 	"Gray 2"				=> "gray-2",
		// 	"Gray 3"				=> "gray-3",
		// 	"Gray 4"				=> "gray-4",
		// 	"Gray 5"				=> "gray-5",
		// 	"Gray 6"				=> "gray-6",
		// 	"Gray 7"				=> "gray-7",
		// 	"Gray 8"				=> "gray-8",
		// 	"Gray 9"				=> "gray-9",
		// 	"Dark opacity 1"		=> "dark-opacity-1",
		// 	"Dark opacity 2"		=> "dark-opacity-2",
		// 	"Dark opacity 3"		=> "dark-opacity-3",
		// 	"Dark opacity 4"		=> "dark-opacity-4",
		// 	"Dark opacity 5"		=> "dark-opacity-5",
		// 	"Dark opacity 6"		=> "dark-opacity-6",
		// 	"Dark opacity 7"		=> "dark-opacity-7",
		// 	"Dark opacity 8"		=> "dark-opacity-8",
		// 	"Dark opacity 9"		=> "dark-opacity-9",
		// 	"Light opacity 1"		=> "light-opacity-1",
		// 	"Light opacity 2"		=> "light-opacity-2",
		// 	"Light opacity 3"		=> "light-opacity-3",
		// 	"Light opacity 4"		=> "light-opacity-4",
		// 	"Light opacity 5"		=> "light-opacity-5",
		// 	"Light opacity 6"		=> "light-opacity-6",
		// 	"Light opacity 7"		=> "light-opacity-7",
		// 	"Light opacity 8"		=> "light-opacity-8",
		// 	"Light opacity 9"		=> "light-opacity-9",
		// 	"Custom"				=> "custom"
		// );

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'embed_code',
			[
				'label' => __('Embed Code', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$repeater->add_control(
			'image',
			[
				'label' => __('Placeholder Image', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'items',
			[
				'label' => __('Videos', 'pixfort-core'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls()
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
			'rounded_img',
			[
				'label' => __('Rounded corners', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
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
		$this->add_control(
			'pix_infinite_animation',
			[
				'label' => __('Infinite Animation type', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => $infinite_animation,
			]
		);
		$this->add_control(
			'pix_infinite_speed',
			[
				'label' => __('Infinite Animation Speed', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => $animation_speeds,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __('Icon color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				// 'options' => array_flip($colors_no_custom),
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


		$this->add_control(
			'overlay_color',
			[
				'label' => __('Hover overlay color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				// 'options' => array_flip($colors),
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'black',
			]
		);
		$this->add_control(
			'overlay_custom_color',
			[
				'label' => __('content_custom_color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'overlay_color' => 'custom',
				],
			]
		);
		$this->add_control(
			'overlay_opacity',
			[
				'label' => __('Hover overlay opacity', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					"pix-opacity-10" 			=> "0%",
					"pix-opacity-9" 			=> "10%",
					"pix-opacity-8" 			=> "20%",
					"pix-opacity-7" 			=> "30%",
					"pix-opacity-6" 			=> "40%",
					"pix-opacity-5" 			=> "50%",
					"pix-opacity-4" 			=> "60%",
					"pix-opacity-3" 			=> "70%",
					"pix-opacity-2" 			=> "80%",
					"pix-opacity-1" 			=> "90%",

				),
				'default' => 'pix-opacity-8',
			]
		);

		$this->add_control(
			'extra_classes',
			[
				'label' => __('Extra Classes (on items)', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'default' => '',
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
				'type' => Controls_Manager::SELECT,
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
				// 'condition' => [
				// 	'autoplay' => true,
				// ],
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
				'default' => 'true',
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

		pix_get_elementor_effects($this);

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
					],
					'default' => [
						'size' => 80,
						'unit' => 'px',
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
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')], 'mainLight' => true, 'gradients' => false]),
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
		echo \PixfortCore::instance()->elementsManager->renderElement('VideoSlider', $settings);
	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-video-slider-handle'];
		return [];
	}
}
