<?php

namespace Elementor;

class Pix_Eor_Video extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-video';
	}

	public function get_title() {
		return 'Video';
	}

	public function get_icon() {
		return 'eicon-play pixfort-elementor-element pixfort-elementor-video';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	protected function register_controls() {
		
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
		$this->add_control(
			'embed_code',
			[
				'label' => __('Embed Code', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::CODE,
				'dynamic'     => array(
					'active'  => true
				),
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
			'image',
			[
				'label' => __('Placeholder', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_types' => ['image', 'video'],
				'dynamic'     => array(
					'active'  => true
				),
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
			'in_popup',
			[
				'label' => __('Open in a popup', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => '1',
				'default' => '',

			]
		);

		$this->add_control(
			'popup_aspect',
			[
				'label' => __('Popup Aspect ratio', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'default' => __('Default', 'pixfort-core'),
					'embed-responsive-21by9' => __('21:9 aspect ratio', 'pixfort-core'),
					'embed-responsive-16by9' => __('16:9 aspect ratio', 'pixfort-core'),
					'embed-responsive-4by3' => __('4:3 aspect ratio', 'pixfort-core'),
					'embed-responsive-1by1' => __('1:1 aspect ratio', 'pixfort-core'),	
					'embed-responsive-9by16' => __('9:16 aspect ratio', 'pixfort-core'),
				],
				'default' => 'default',
				'condition' => [
					'in_popup' => '1',
				],

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
					'rounded-inherit' => __('Inherit Border Radius', 'pixfort-core'),
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
				'description' => __('Input the Parallax value (without unit), for example: 120', 'pixfort-core'),
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
				'description' => __('Input the Parallax value (without unit), for example: 120', 'pixfort-core'),
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
				'default' => '',

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
				'options' => array_flip($infinite_animation),
			]
		);
		$this->add_control(
			'pix_infinite_speed',
			[
				'label' => __('Infinite Animation Speed', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip($animation_speeds),
			]
		);
	




		$this->add_control(
			'text_color',
			[
				'label' => __('Icon color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => false, 'transparent' => false, 'defaultValue' => false, 'custom' => false]),
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
				'label' => __('Overlay Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
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
				'label' => __('Overlay Opacity', 'pixfort-core'),
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
				'label' => __('Extra Classes', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'default' => '',
			]
		);

		$this->end_controls_section();



		pix_get_elementor_effects($this);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('Video', $settings);
	}


	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
