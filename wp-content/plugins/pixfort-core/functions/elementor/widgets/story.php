<?php

namespace Elementor;

class Pix_Eor_Story extends Widget_Base {

	public function __construct($data = [], $args = null) {
		// Link migration code
		$is_external = false;
		if (!empty($data['settings'])) {
			if (!empty($data['settings']['target']) && $data['settings']['target']) {
				$is_external = true;
			}
			if (!empty($data['settings']['link']) && !is_array($data['settings']['link'])) {
				$data['settings']['link'] = [
					'url' => $data['settings']['link'],
					'is_external' => $is_external,
					'nofollow' => false,
				];
			}
		}
		parent::__construct($data, $args);
		if (is_user_logged_in()) wp_enqueue_style('pixfort-story-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/story.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
	}

	public function get_name() {
		return 'pix-story';
	}

	public function get_title() {
		return 'Story';
	}

	public function get_icon() {
		return 'eicon-circle pixfort-elementor-element pixfort-elementor-story';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	protected function register_controls() {
		$infinite_animation = array_flip(array(
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

		));
		$animation_speeds = array_flip(array(
			"Fast" 			=> "pix-duration-fast",
			"Medium" 		=> "pix-duration-md",
			"Slow" 			=> "pix-duration-slow",
		));


		$this->start_controls_section(
			'section_title',
			[
				'label' => __('General', 'pixfort-core'),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __('Choose Image', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$this->add_control(
			'alt',
			[
				'label' => __('Image alternative text', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
				'default' => '',
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __('Story Title', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
				'default' => '',
			]
		);

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'img',
			[
				'label' => __('Image', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$this->add_control(
			'stories',
			[
				'label' => __('Items', 'pixfort-core'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls()
			]
		);


		$this->add_control(
			'align',
			[
				'label' => __('Image alignment', 'pixfort-core'),
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
			'width',
			[
				'label' => __('Size', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => '200',
				'placeholder' => __('Size of the story image in pixels (without the unit, for example: 200)', 'pixfort-core'),
			]
		);
		$this->add_control(
			'outer_border',
			[
				'label' => __('Enable color border', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Enable', 'pixfort-core'),
				'label_off' => __('Disable', 'pixfort-core'),
				'return_value' => true,
				'default' => true,
			]
		);
		$this->add_control(
			'color',
			[
				'label' => __('Color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'gradient-primary',
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
				'condition' => [
					'outer_border!' => '',
				],
			]
		);
		$this->add_control(
			'inner_border',
			[
				'label' => __('Remove inner white border', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Enable', 'pixfort-core'),
				'label_off' => __('Disable', 'pixfort-core'),
				'return_value' => 'no-border',
				'default' => '',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __('Link', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::URL,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'dynamic'     => array(
					'active'  => true
				),
				'placeholder' => __('', 'pixfort-core'),
			]
		);
		$this->add_control(
			'target',
			[
				'label' => __('Open in a new tab', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'Yes',
				// 'default' => '',
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









		$this->end_controls_section();


		$this->start_controls_section(
			'section_advanced',
			[
				'label' => __('Advanced', 'pixfort-core'),
			]
		);

		$this->add_control(
			'text_size',
			[
				'label' => __('Text size', 'pixfort-core'),
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
			'bold',
			[
				'label' => __('Bold', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'font-weight-bold',
				'default' => '',
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
			'content_color',
			[
				'label' => __('Content color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => '',
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
			'position',
			[
				'label' => __('Position', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'text-center'		=> 'Center',
					'text-left'			=> 'Left',
					'text-right' 		=> 'Right',
				),
				'default' => 'text-left',
			]
		);


		$this->end_controls_section();

		pix_get_elementor_effects($this);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if (!empty($settings['link']) && is_array($settings['link'])) {
			if (!empty($settings['link']['is_external'])) {
				$settings['target'] = $settings['link']['is_external'];
			}
			if (!empty($settings['link']['nofollow'])) {
				$settings['nofollow'] = $settings['link']['nofollow'];
			}
			if (!empty($settings['link']['custom_attributes'])) {
				$settings['link_atts'] = $settings['link']['custom_attributes'];
			}
			$settings['link'] = $settings['link']['url'];
		}
		echo \PixfortCore::instance()->elementsManager->renderElement('Story', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
