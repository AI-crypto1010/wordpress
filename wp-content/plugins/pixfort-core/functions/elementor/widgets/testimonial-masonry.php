<?php

namespace Elementor;

class Pix_Eor_Testimonial_Masonry extends Widget_Base {

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
		}
		parent::__construct($data, $args);

		wp_register_script('pix-testimonial-masonry-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/testimonial-masonry.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
	}

	public function get_name() {
		return 'pix-testimonial-masonry';
	}

	public function get_title() {
		return 'Testimonial masonry';
	}

	public function get_icon() {
		return 'eicon-posts-masonry pixfort-elementor-element pixfort-elementor-testimonials-masonry';
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


		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'grid_size',
			[
				'label' => __('Testimonial Size', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'grid-item'		=> 'Default',
					'grid-item grid-item--width2'		=> 'Wide'
				],
				'default' => 'grid-item',
			]
		);
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
			'img_style',
			[
				'label' => __('Image style', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array_flip(array(
					__('Standard', 'pixfort-core')	    => 'standard',
					__('Circle Bottom', 'pixfort-core') 	=> 'circle_bottom',
					__('Circle Top', 'pixfort-core') 	=> 'circle_top',
				)),
				'default' => 'standard',
			]
		);
		$repeater->add_control(
			'width',
			[
				'label' => __('Max Width of the image (Optional)', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('For example 200', 'pixfort-core'),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'height',
			[
				'label' => __('Max height of the image (Optional)', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('For example 200', 'pixfort-core'),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'name',
			[
				'label' => __('Name', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
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
				'default' => 'Simply amazing!',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$repeater->add_control(
			'text',
			[
				'label' => __('textarea', 'pixfort-core'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '"Some quick example text to build on the testimonial text and make up the bulk of the testimonial content."',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$repeater->add_control(
			'link',
			[
				'label' => __('Link', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::URL,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
				'dynamic'     => array(
					'active'  => true
				),
				'placeholder' => __('Link', 'pixfort-core')
			]
		);

		$this->add_control(
			'items',
			[
				'label' => __('Items', 'pixfort-core'),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ name }}}',
				'fields' => $repeater->get_controls()
			]
		);







		$this->add_control(
			'items_bg_color',
			[
				'label' => __('Background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'light-opacity-5',

			]
		);
		$this->add_control(
			'items_custom_bg_color',
			[
				'label' => __('Custom Background Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'items_bg_color' => 'custom',
				],
			]
		);

		$this->add_control(
			'circle_color',
			[
				'label' => __('Circle color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray([
					'bg' => true,
					'transparent' => true,
					'defaultValue' => ['pix-bg-custom' => __('None', 'pixfort-core')],
					'custom' => false
				]),
				'default' => 'gradient-primary',

			]
		);


		$this->add_control(
			'rounded_box',
			[
				'label' => __('Rounded corners', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded-lg',
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
			'pix_section_name',
			[
				'label' => __('Name format', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'name_bold',
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
			'name_italic',
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
			'name_secondary_font',
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
			'name_color',
			[
				'label' => __('Name color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'dark-opacity-4',
			]
		);
		$this->add_control(
			'name_custom_color',
			[
				'label' => __('Custom Name color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'name_color' => 'custom',
				],
			]
		);
		$this->add_control(
			'name_size',
			[
				'label' => __('Name size', 'pixfort-core'),
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
			'name_custom_size',
			[
				'label' => __('Custom Name size', 'pixfort-core'),
				'label_block' => false,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter custom Name size', 'pixfort-core'),
				'default' => '',
				'condition' => [
					'name_size' => 'custom',
				],
			]
		);

		$this->end_controls_section();






		$this->start_controls_section(
			'pix_section_title',
			[
				'label' => __('Title format', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'title_bold',
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
			'title_italic',
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
			'title_secondary_font',
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
				'default' => 'primary',
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
			'pix_section_text',
			[
				'label' => __('Text format', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				// 'condition' => [
				// 	'description!' => '',
				// ],
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
				'label' => __('Text Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'text_color' => 'custom',
				],
			]
		);
		$this->add_control(
			'text_size',
			[
				'label' => __('Text font size', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					''			=> 'Default (16px)',
					'text-xs'		=> '12px',
					'text-sm'		=> '14px',
					'text-sm'		=> '14px',
					'text-18' 		=> '18px',
					'text-20' 		=> '20px',
					'text-24' 		=> '24px',
				],
				'default' => '',
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
		echo \PixfortCore::instance()->elementsManager->renderElement('TestimonialMasonry', $settings);
	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-testimonial-masonry-handle'];
		return [];
	}
}
