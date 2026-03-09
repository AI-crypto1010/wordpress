<?php

namespace Elementor;

class Pix_Eor_Icon extends Widget_Base {

	public function __construct($data = [], $args = null) {
		$data = \PixfortCore::instance()->icons->verifyElementorData($data);
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
	}

	public function get_name() {
		return 'pix-icon';
	}

	public function get_title() {
		return 'Icon';
	}

	public function get_icon() {
		return 'eicon-star-o pixfort-elementor-element pixfort-elementor-icon';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	protected function register_controls() {

		$popup_posts = get_posts([
			'post_type' => 'pixpopup',
			'post_status' => 'publish',
			'numberposts' => -1
			// 'order'    => 'ASC'
		]);

		$popups = array();
		$popups[''] = "Disabled";
		foreach ($popup_posts as $key => $value) {
			$popups[$value->ID] = $value->post_title;
		}


		$this->start_controls_section(
			'section_title',
			[
				'label' => __('Content', 'pixfort-core'),
			]
		);


		$this->add_control(
			'media_type',
			[
				'label' => __('Icon type', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array_flip(array(
					"None" => "none",
					"Image" => "image",
					"Icon" => "icon",
					// "Duo tone icon" => "duo_icon",
					"Character" => "char"
				)),
				'default' => 'none',
			]
		);
		$this->add_control(
			'icon',
			[
				'label' => esc_html__('pixfort Icon', 'pixfort-core'),
				'type' => \Elementor\CustomControl\PixfortIconSelector_Control::PixfortIconSelector,
				'default' => '',
				'condition' => [
					'media_type' => 'icon',
				],
			]
		);
		


		$this->add_control(
			'char',
			[
				'label' => __('Character', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('1', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					'media_type' => 'char',
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);





		$this->add_control(
			'image',
			[
				'label' => __('Image', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'condition' => [
					'media_type' => 'image',
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'link_type',
			[
				'label' => __('Link type', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'link'	=> 'Link',
					'popup'	=> 'Popup',
					'video'	=> 'Video',
					'embed'	=> 'Embed code',
				),
				'default' => 'link',
			]
		);
		$this->add_control(
			'link',
			[
				'label' => __('Link', 'pixfort-core'),
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
				'condition' => [
					'link_type' => 'link',
				],
			]
		);
		$this->add_control(
			'icon_popup_id',
			[
				'label' => __('Open Popup instead of link', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $popups,
				'default' => '',
				'condition' => [
					'link_type' => 'popup'
				],
			]
		);

		$this->add_control(
			'embed_code',
			[
				'label' => __('Embed Code', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::CODE,
				'condition' => [
					'link_type' => array('video', 'embed')
				],
			]
		);
		// $this->add_control(
		// 	'embed_code',
		// 	[
		// 		'label' => __( 'Embed Code', 'pixfort-core' ),
		// 		'type' => \Elementor\Controls_Manager::RAW_HTML,
		// 		'raw' => __( 'A very important message to show in the panel.', 'pixfort-core' ),
		// 		'content_classes' => 'your-class',
		// 		'condition' => [
		// 			'link_type' => array('video', 'embed')
		// 		],
		// 	]
		// );
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
				'condition' => [
					'link_type' => array('video', 'embed')
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
			'content_align',
			[
				'label' => __('Content align', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'left'	=> 'Left',
					'center'	=> 'Center',
					'right'	=> 'Right',
					'inline'	=> 'inline',
				),
				'default' => 'left',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'icon_section',
			[
				'label' => __('Icon format', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);



		$this->add_control(
			'icon_color',
			[
				'label' => __('Icon color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'heading-default',
			]
		);

		$this->add_responsive_control(
			'custom_icon_color',
			[
				'label' => __('Custom Icon Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} svg path, {{WRAPPER}} svg rect, {{WRAPPER}} svg circle, {{WRAPPER}} svg polygon' => 'fill: {{VALUE}} !important;',
					'{{WRAPPER}}, {{WRAPPER}} i, {{WRAPPER}} span' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'has_icon_bg',
			[
				'label' => __('Background circle', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'media_type' => array("icon", "char", "duo_icon")
				],
			]
		);
		$this->add_control(
			'icon_bg_color',
			[
				'label' => __('Icon Background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
				'default' => 'heading-default',
				'condition' => [
					'has_icon_bg!' => []
				],
			]
		);

		$this->add_control(
			'icon_custom_bg_color',
			[
				'label' => __('Custom Icon Background Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_bg_color' => 'custom',
				],
			]
		);
		$this->add_control(
			'icon_size',
			[
				'label' => __('Icon Size (without unit)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('30', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					'media_type' => array("icon", "char", "duo_icon")
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'image_section',
			[
				'label' => __('Image format', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'media_type' => array("image")
				],
			]
		);
		$this->add_control(
			'image_size',
			[
				'label' => __('Image Size (with unit)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('Leave empty for full size.', 'pixfort-core'),

			]
		);
		$this->add_control(
			'circle',
			[
				'label' => __('Circle image', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
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
		echo \PixfortCore::instance()->elementsManager->renderElement('Icon', $settings);
	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
