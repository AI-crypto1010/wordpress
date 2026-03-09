<?php

namespace Elementor;

class Pix_Eor_Feature extends Widget_Base {

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
			// Align content migration
			if(!empty($data['settings']['content_align'])) {
				if($data['settings']['content_align'] == 'left' || $data['settings']['content_align'] == 'right') {
					if(is_rtl()) {
						if($data['settings']['content_align'] == 'left') {
							$data['settings']['content_align'] = 'end';
						} elseif($data['settings']['content_align'] == 'right') {
							$data['settings']['content_align'] = 'start';
						}
					} else {
						if($data['settings']['content_align'] == 'left') {
							$data['settings']['content_align'] = 'start';
						} elseif($data['settings']['content_align'] == 'right') {
							$data['settings']['content_align'] = 'end';
						}
					}
				}
			}
			
			// Icon size migration - convert from text to slider format
			if(!empty($data['settings']['icon_size'])) {
				$old_value = $data['settings']['icon_size'];
				if(!is_array($old_value)&&!empty($old_value)) {
					// Function to convert old format to new
					$convert_to_slider_format = function($value) {
						if(is_array($value) && isset($value['size']) && isset($value['unit'])) {
							// Already in new format
							return $value;
						}
						
						// String value like "10px" or "10"
						if(is_string($value) || is_numeric($value)) {
							$value = (string)$value; // Ensure it's a string for regex
							// Strip "px" if it exists and determine unit
							$size = preg_replace('/px$/', '', $value);
							
							// Convert to number
							$size = (int) $size;
							
							return [
								'size' => $size,
								'unit' => 'px'
							];
						}
						
						// Default value if something unexpected
						return [
							'size' => 30,
							'unit' => 'px'
						];
					};
				
					// Convert main size
					$data['settings']['icon_size'] = $convert_to_slider_format($old_value);
				}
			}
		}
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-feature';
	}

	public function get_title() {
		return 'Feature';
	}

	public function get_icon() {
		return 'eicon-icon-box pixfort-elementor-element pixfort-elementor-feature';
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
		$this->add_control(
			'title',
			[
				'label' => __('Title', 'pixfort-core'),
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
			'content',
			[
				'label' => __('Content', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Content text', 'pixfort-core'),
				'default' => 'Insert your content here',
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
				'dynamic'     => array(
					'active'  => true
				),
				'condition' => [
					'media_type' => 'image',
				],
			]
		);

		$this->add_control(
			'media_type',
			[
				'label' => __('Use image or icon', 'pixfort-core'),
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
			]
		);
		$this->add_control(
			'icon_position',
			[
				'label' => __('Icon Position', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'top'	=> 'Top',
					'left'	=> 'Side',
				),
				'default' => 'heading-default',
				'condition' => [
					'media_type' => array("icon", "image", "char", "duo_icon")
				],
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
				'label' => __('Title format', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
				'default' => 'h5',
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
				'selectors' => [
					'{{WRAPPER}} .pix-feature-title' => 'color: {{VALUE}} !important;',
				],
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
			'title_secondary',
			[
				'label' => __('Secondary font', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'secondary-font',
				'default' => '',
			]
		);
		$this->add_responsive_control(
			'padding_title',
			[
				'label' => __('Padding before title', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('20px', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'selectors' => [
					'{{WRAPPER}} .pix-feature-title' => 'padding-top: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'title_html_tag',
			[
				'label' => esc_html__('Title HTML Tag', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__('Default', 'pixfort-core'),
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					// 'span' => 'span',
					'p' => 'p',
				],
				'default' => 'default',
			]
		);
		$this->end_controls_section();


		$this->start_controls_section(
			'content_section',
			[
				'label' => __('Content format', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' => __('Content color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'text-gray',
			]
		);
		$this->add_control(
			'content_custom_color',
			[
				'label' => __('content_custom_color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'content_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-feature-content' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_control(
			'content_size',
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
			'content_bold',
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
			'content_italic',
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
			'content_secondary_font',
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
			'justify',
			[
				'label' => __('Justify Content', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => '1',
				'default' => '',
			]
		);
		$this->add_responsive_control(
			'padding_content',
			[
				'label' => __('Padding before content', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('20px', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'selectors' => [
					'{{WRAPPER}} .pix-feature-content' => 'padding-top: {{VALUE}} !important;',
				],
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

		$this->add_control(
			'custom_icon_color',
			[
				'label' => __('Custom Icon Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pixfort-icon' => 'color: {{VALUE}} !important;',
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
					// 'has_icon_bg!' => []
					'has_icon_bg' => 'yes',
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
					'has_icon_bg' => 'yes',
					'icon_bg_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-feature-bg' => 'background: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __('Icon Size', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 300,
						'step' => 1,
					],
					// 'em' => [
					// 	'min' => 0.1,
					// 	'max' => 20,
					// 	'step' => 0.1,
					// ],
					// 'rem' => [
					// 	'min' => 0.1,
					// 	'max' => 20,
					// 	'step' => 0.1,
					// ],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'condition' => [
					'media_type' => array("icon", "char", "duo_icon")
				],
				'selectors' => [
					'{{WRAPPER}} .pix-feature-icon' => 'font-size: {{SIZE}}{{UNIT}} !important;width: {{SIZE}}{{UNIT}} !important;height: {{SIZE}}{{UNIT}} !important;line-height: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .rounded-circle' => 'width: calc({{SIZE}}{{UNIT}} * 1.8) !important;',
				],
			]
		);

		$this->add_responsive_control(
			'icon_vertical_gap',
			[
				'label' => __('Icon Gap', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 16,
				],
				'condition' => [
					'media_type' => array("icon", "image", "char", "duo_icon"),
					'icon_position' => 'left'
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .pix-feature-icon-outer' => 'margin-right: {{SIZE}}{{UNIT}} !important;',
					'body.rtl {{WRAPPER}} .pix-feature-icon-outer' => 'margin-left: {{SIZE}}{{UNIT}} !important;',
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

		$this->start_controls_section(
			'section_element_style',
			[
				'label' => __('Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// $this->add_responsive_control(
		// 	'content_align',
		// 	[
		// 		'label' => __('Content align', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::SELECT,
		// 		'options' => array(
		// 			'left'	=> 'Start',
		// 			'center'	=> 'Center',
		// 			'right'	=> 'End',
		// 		),
		// 		'default' => 'left',
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-feature-el' => 'text-align: {{value}} !important;',
		// 		],
		// 	]
		// );

		$startIcon = 'eicon-text-align-left';
		$endIcon = 'eicon-text-align-right';
		if(is_rtl()) {
			$startIcon = 'eicon-text-align-right';
			$endIcon = 'eicon-text-align-left';
		}
		$this->add_responsive_control(
			'content_align',
			[
				'label' => __('Alignment', 'pixfort-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __('Start', 'pixfort-core'),
						'icon' => $startIcon,
					],
					'center' => [
						'title' => __('Center', 'pixfort-core'),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => __('End', 'pixfort-core'),
						'icon' => $endIcon,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .pix-feature-el' => 'text-align: {{value}} !important;',
					'{{WRAPPER}} .pix-feature-el:not(.media)' => 'display: flex;flex-direction: column;align-items: {{value}};justify-content: normal;',
					'{{WRAPPER}} .pix-feature-el.media .media-body' => 'display: flex;flex-direction: column;align-items: {{value}};justify-content: normal;',
					// '{{WRAPPER}} .pix-feature-content' => 'text-align: {{value}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __('Title Typography', 'pixfort-core'),
				'selector' => '{{WRAPPER}} .pix-feature-title, {{WRAPPER}} .pix-feature-title.body-font, {{WRAPPER}} .pix-feature-title.secondary-font',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'label' => __('Title text shadow', 'pixfort-core'),
				'selector' => '{{WRAPPER}} .pix-feature-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __('Content Typography', 'pixfort-core'),
				'selector' => '{{WRAPPER}} .pix-feature-content',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$settings['content_align'] = 'custom';
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
		$settings['element_id'] = $this->get_id();
		echo \PixfortCore::instance()->elementsManager->renderElement('Feature', $settings, $settings['content']);
	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
