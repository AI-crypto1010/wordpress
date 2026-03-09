<?php

namespace Elementor;

class Pix_Eor_Slider extends Widget_Base {

	public function __construct($data = [], $args = null) {
		if (!empty($data['settings'])) {
			if (!empty($data['settings']['items'])) {
				foreach ($data['settings']['items'] as $key => $value) {
					if (!empty($data['settings']['items'][$key]['link']) && !is_array($data['settings']['items'][$key]['link'])) {
						if (array_key_exists('target', $data['settings']['items'][$key]) && $data['settings']['items'][$key]['target'] === 'yes') {
							$data['settings']['items'][$key]['link'] = [
								'url' => $data['settings']['items'][$key]['link'],
								'is_external' => true,
								'nofollow' => false,
							];
						} else {
							$data['settings']['items'][$key]['link'] = [
								'url' => $data['settings']['items'][$key]['link'],
								'nofollow' => false,
							];
						}
					}
					$data['settings']['items'][$key]['target'] = false;
				}
			}
		}
		parent::__construct($data, $args);

		if (is_user_logged_in()) wp_register_script('pix-slider-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/slider.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
		if (is_user_logged_in()) wp_enqueue_style('pixfort-carousel-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/carousel-2.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
	}

	public function get_name() {
		return 'pix-slider';
	}

	public function get_title() {
		return 'Slider';
	}

	public function get_icon() {
		return 'eicon-slides pixfort-elementor-element pixfort-elementor-slider';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	protected function register_controls() {
		$colors = array(
			"Body default"			=> "body-default",
			"Heading default"		=> "heading-default",
			"Primary"				=> "primary",
			"Primary Gradient"		=> "gradient-primary",
			"Secondary"				=> "secondary",
			"White"					=> "white",
			"Black"					=> "black",
			"Green"					=> "green",
			"Blue"					=> "blue",
			"Red"					=> "red",
			"Yellow"				=> "yellow",
			"Brown"					=> "brown",
			"Purple"				=> "purple",
			"Orange"				=> "orange",
			"Cyan"					=> "cyan",
			"Gray 1"				=> "gray-1",
			"Gray 2"				=> "gray-2",
			"Gray 3"				=> "gray-3",
			"Gray 4"				=> "gray-4",
			"Gray 5"				=> "gray-5",
			"Gray 6"				=> "gray-6",
			"Gray 7"				=> "gray-7",
			"Gray 8"				=> "gray-8",
			"Gray 9"				=> "gray-9",
			"Dark opacity 1"		=> "dark-opacity-1",
			"Dark opacity 2"		=> "dark-opacity-2",
			"Dark opacity 3"		=> "dark-opacity-3",
			"Dark opacity 4"		=> "dark-opacity-4",
			"Dark opacity 5"		=> "dark-opacity-5",
			"Dark opacity 6"		=> "dark-opacity-6",
			"Dark opacity 7"		=> "dark-opacity-7",
			"Dark opacity 8"		=> "dark-opacity-8",
			"Dark opacity 9"		=> "dark-opacity-9",
			"Light opacity 1"		=> "light-opacity-1",
			"Light opacity 2"		=> "light-opacity-2",
			"Light opacity 3"		=> "light-opacity-3",
			"Light opacity 4"		=> "light-opacity-4",
			"Light opacity 5"		=> "light-opacity-5",
			"Light opacity 6"		=> "light-opacity-6",
			"Light opacity 7"		=> "light-opacity-7",
			"Light opacity 8"		=> "light-opacity-8",
			"Light opacity 9"		=> "light-opacity-9",
			"Custom"				=> "custom"
		);
		
		$this->start_controls_section(
			'section_title',
			[
				'label' => __('General', 'pixfort-core'),
			]
		);
		$popup_posts = get_posts([
			'post_type' => 'pixpopup',
			'post_status' => 'publish',
			'numberposts' => -1
		]);

		$popups = array();
		$popups[''] = "Disabled";
		foreach ($popup_posts as $key => $value) {
			$popups[$value->ID] = $value->post_title;
		}


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
			'text',
			[
				'label' => __('Text', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'label_block' => true,
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$repeater->add_control(
			'btn_text',
			[
				'label' => __('Button Text', 'pixfort-core'),
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
		// $repeater->add_control(
		// 	'target',
		// 	[
		// 		'label' => __('Open in a new tab', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'label_on' => __('Yes', 'pixfort-core'),
		// 		'label_off' => __('No', 'pixfort-core'),
		// 		'return_value' => 'yes',
		// 		'default' => 'yes',
		// 	]
		// );
		$repeater->add_control(
			'btn_popup_id',
			[
				'label' => __('Open Popup instead of link', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $popups,
				'default' => '',
			]
		);
		$this->add_control(
			'items',
			[
				'label' => __('Items', 'pixfort-core'),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ title }}}',
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
			'align',
			[
				'label' => __('Content alignment', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'text-left',
				'options' => [
					'text-left'			=> 'Start',
					'text-center'		=> 'Center',
					'text-right' 		=> 'End',
				],
			]
		);
		$this->add_control(
			'nav_style',
			[
				'label' => __('Navigation style', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'			=> 'Default',
					'circles'		    => 'Circles',
					'disable'		    => 'Disable',
				],
			]
		);
		$this->add_control(
			'nav_align',
			[
				'label' => __('Circles align', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'center'		=> 'Center',
					'left'			=> 'Start',
					'right' 		=> 'End',
				],
				'condition' => [
					'nav_style' => 'circles',
				],
			]
		);
		$this->add_control(
			'circles_color',
			[
				'label' => __('Circles color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'gradient-primary',
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
				'condition' => [
					'nav_style' => 'circles',
				],
			]
		);


		$this->add_control(
			'overlay_color',
			[
				'label' => __('Overlay color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'black',
			]
		);
		$this->add_control(
			'overlay_custom_color',
			[
				'label' => __('Custom overlay color', 'pixfort-core'),
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
				'label' => __('Overlay opacity', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					"pix-opacity-0" 			=> "100%",
					"pix-opacity-1" 			=> "90%",
					"pix-opacity-2" 			=> "80%",
					"pix-opacity-3" 			=> "70%",
					"pix-opacity-4" 			=> "60%",
					"pix-opacity-5" 			=> "50%",
					"pix-opacity-6" 			=> "40%",
					"pix-opacity-7" 			=> "30%",
					"pix-opacity-8" 			=> "20%",
					"pix-opacity-9" 			=> "10%",
					"pix-opacity-10" 			=> "Disable",
				),
				'default' => 'pix-opacity-7',
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
				'default' => __('2500', 'pixfort-core'),
				'placeholder' => __('Type your title here', 'pixfort-core'),
				// 'condition' => [
				// 	'autoplay' => true,
				// ],
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
			'top_placholder',
			[
				'label' => __('Extra top padding (with transparent header)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => '',
			]
		);

		// custom_min_height

		$this->add_responsive_control(
			'custom_min_height',
			[
				'label' => __('Custom minimum height', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'description' => __("Choose a custom minimum height for the slider. Input the value with unit, for example: 600px, or 100vh (for full screen height).<br>For final result please check the live page.", 'pixfort-core'),
				'selectors' => [
					'{{WRAPPER}} .slider-content-row' => 'min-height: {{VALUE}} !important;display:flex;align-items:center!important;padding-top:initial  !important;padding-bottom:initial !important;',
					'{{WRAPPER}} .flickity-slider .flickity-viewport, {{WRAPPER}} .flickity-slider' => 'min-height: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();






		$this->start_controls_section(
			'title_section',
			[
				'label' => __('Title format', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
					'text_color' => 'custom',
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
				'default' => 'h2',
			]
		);
		$this->add_responsive_control(
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
				'selectors' => [
					'{{WRAPPER}} .pix-sliding-headline-2' => 'font-size: {{VALUE}} !important;',
				],
			]
		);



		$this->end_controls_section();




		$this->start_controls_section(
			'content_section',
			[
				'label' => __('Content format', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
				'label' => __('Content Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'content_color' => 'custom',
				],
			]
		);

		$this->add_control(
			'content_size',
			[
				'label' => __('Content size', 'pixfort-core'),
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
				'default' => 'text-24',
			]
		);
		$this->end_controls_section();










		$this->start_controls_section(
			'section_button',
			[
				'label' => __('Button Settings', 'pixfort-core'),
			]
		);



		$this->add_control(
			'btn_title_bold',
			[
				'label' => __('Bold', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-weight-bold',
				'default' => 'font-weight-bold',
			]
		);
		$this->add_control(
			'btn_italic',
			[
				'label' => __('Italic', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-italic',
				'default' => '',
			]
		);
		$this->add_control(
			'btn_secondary_font',
			[
				'label' => __('Secondary font', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'secondary-font',
				'default' => '',
			]
		);
		$this->add_control(
			'btn_style',
			[
				'label' => __('Button Style', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					""            => "Default",
					"flat"        => "Flat",
					"line"        => "Line",
					"outline"     => "Outline",
					"underline"     => "Underline",
					"link"        => "Link",
					"blink"     => "Blink"
				),
				'default' => '',
			]
		);
		$this->add_control(
			'btn_color',
			[
				'label' => __('Button Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'primary' 		=> 'Primary',
					'primary-light' 		=> 'Primary Light',
					// 'success'		=> 'Success',
					'secondary'		=> 'Secondary',
					'gray-1' 		=> 'Light',
					'gray-5' 		    => 'Dark',
					'black' 		=> 'Black',
					// 'link' 		    => 'Link',
					'white' 		=> 'White',
					'blue' 		    => 'Blue',
					'red' 		    => 'Red',
					'cyan' 		    => 'Cyan',
					'orange' 		    => 'Orange',
					'green' 		    => 'Green',
					'purple' 		    => 'Purple',
					'brown' 		    => 'Brown',
					'yellow' 		    => 'Yellow',
					'gradient-primary' 		    => 'Primary gradient',
					"gray-1" => 'Gray 1',
					"gray-2" => 'Gray 2',
					"gray-3" => 'Gray 3',
					"gray-4" => 'Gray 4',
					"gray-5" => 'Gray 5',
					"gray-6" => 'Gray 6',
					"gray-7" => 'Gray 7',
					"gray-8" => 'Gray 8',
					"gray-9" => 'Gray 9',
					"dark-opacity-1" => 'Dark opacity 1',
					"dark-opacity-2" => 'Dark opacity 2',
					"dark-opacity-3" => 'Dark opacity 3',
					"dark-opacity-4" => 'Dark opacity 4',
					"dark-opacity-5" => 'Dark opacity 5',
					"dark-opacity-6" => 'Dark opacity 6',
					"dark-opacity-7" => 'Dark opacity 7',
					"dark-opacity-8" => 'Dark opacity 8',
					"dark-opacity-9" => 'Dark opacity 9',
					"light-opacity-1" => 'Light opacity 1',
					"light-opacity-2" => 'Light opacity 2',
					"light-opacity-3" => 'Light opacity 3',
					"light-opacity-4" => 'Light opacity 4',
					"light-opacity-5" => 'Light opacity 5',
					"light-opacity-6" => 'Light opacity 6',
					"light-opacity-7" => 'Light opacity 7',
					"light-opacity-8" => 'Light opacity 8',
					"light-opacity-9" => 'Light opacity 9'

				),
				'default' => 'primary',
			]
		);

		$this->add_control(
			'btn_remove_padding',
			[
				'label' => __('Remove padding', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'no-padding',
				'default' => '',
				'condition' => [
					'btn_style' => array("link", "underline")
				],
			]
		);
		$this->add_control(
			'btn_text_color',
			[
				'label' => __('Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array_flip(array_merge(array("Default" => "",), $colors)),
				'default' => '',
			]
		);
		$this->add_control(
			'btn_text_custom_color',
			[
				'label' => __('Text custom color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'btn_text_color' => 'custom',
				],
			]
		);
		$this->add_control(
			'btn_size',
			[
				'label' => __('Button Size', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					"sm"       => "Small",
					"normal"       => "Normal",
					"md"       => "Medium",
					"lg"       => "Large",
					"xl"       => "XLarge "
				),
				'default' => 'md',
			]
		);
		$this->add_control(
			'btn_rounded',
			[
				'label' => __('Rounded corners button', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'btn-rounded',
				'default' => '',
			]
		);
		$this->add_control(
			'btn_effect',
			[
				'label' => __('Button Size', 'pixfort-core'),
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
			'btn_hover_effect',
			[
				'label' => __('Button Shadow Hover Style', 'pixfort-core'),
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
			'btn_add_hover_effect',
			[
				'label' => __('Button Hover Animation', 'pixfort-core'),
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
			'btn_icon',
			[
				'label' => esc_html__('pixfort Icon', 'pixfort-core'),
				'type' => \Elementor\CustomControl\PixfortIconSelector_Control::PixfortIconSelector,
				'default' => '',
			]
		);
		


		$this->add_control(
			'btn_icon_position',
			[
				'label' => __('Icon position', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					""            => "Before text",
					"after"        => "After text"
				),
				'default' => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'btn_icon',
							'operator' => '!=',
							'value' => ''
						]
					]
				],
			]
		);
		$this->add_control(
			'btn_icon_animation',
			[
				'label' => __('Icon animation', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'btn_icon',
							'operator' => '!=',
							'value' => ''
						]
					]
				],
			]
		);
		$this->add_control(
			'btn_full',
			[
				'label' => __('Full width Button', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
			]
		);
		$this->add_control(
			'btn_text_align',
			[
				'label' => __('Button Text Align', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'text-center' 		=> 'Center',
					'text-left' 		=> 'Start',
					'text-right' 		=> 'End',
				),
				'default' => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'btn_full',
							'operator' => '!=',
							'value' => ''
						]
					]
				],
			]
		);
		$this->add_control(
			'btn_div',
			[
				'label' => __('Button inside a container', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'' 		=> 'Disabled',
					'text-center' 		=> 'Center align',
					'text-left' 		=> 'Start align',
					'text-right' 		=> 'End align',
				),
				'default' => '',
			]
		);


		$this->add_control(
			'btn_animation',
			[
				'label' => __('Animation', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => pix_get_animations(true),
			]
		);
		$this->add_control(
			'btn_anim_delay',
			[
				'label' => __('Animation delay (in miliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('0', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					'btn_animation!' => '',
				],
			]
		);


		$this->end_controls_section();


		pix_get_elementor_effects($this);
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
		echo \PixfortCore::instance()->elementsManager->renderElement('Slider', $settings);
	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-slider-handle'];
		return [];
	}
}
