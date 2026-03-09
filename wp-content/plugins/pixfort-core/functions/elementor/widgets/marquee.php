<?php

namespace Elementor;

class Pix_Eor_Marquee extends Widget_Base {

	public function __construct($data = [], $args = null) {
		$data = \PixfortCore::instance()->icons->verifyElementorData($data, true, 'items', 'item_type');
		parent::__construct($data, $args);
		if (is_user_logged_in()) wp_enqueue_style('pixfort-marquee-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/marquee.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		wp_register_script('pix-marquee-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/marquee.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
	}

	public function get_name() {
		return 'pix-marquee';
	}

	public function get_title() {
		return 'Marquee';
	}

	public function get_icon() {
		return 'eicon-code-highlight pixfort-elementor-element pixfort-elementor-marquee';
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

		// Build item type options - add Template option when PIX_DEV is defined
		$item_type_options = array(
			__("Text", 'pixfort-core')  => "text",
			__("Image", 'pixfort-core') => "image",
			__("Icon", 'pixfort-core') => "icon",
			// __("Duo tone icon", 'pixfort-core') => "duo_icon"
		);
		if (defined('PIX_DEV')) {
			$item_type_options[__("Template", 'pixfort-core')] = "template";
		}

		$repeater->add_control(
			'item_type',
			[
				'label' => __('Item type', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array_flip($item_type_options),
				'default' => 'text',
			]
		);

		// Template selector - only available when PIX_DEV is defined
		if (defined('PIX_DEV')) {
			$template_results = [];
			$template_results[] = esc_html__('Choose Template', 'pixfort-core');

			$template_posts = get_posts(array(
				'posts_per_page'	=> -1,
				'post_type'	=> 'elementor_library'
			));

			foreach ($template_posts as $post) {
				$document = \Elementor\plugin::instance()->documents->get($post->ID);
				if ($document) {
					$text = esc_html($post->post_title) . ' (' . $document->get_post_type_title() . ')';
					$template_results[$post->ID] = $text;
				}
			}

			$repeater->add_control(
				'pix_template_id',
				[
					'label' => esc_html__('Choose Template', 'pixfort-core'),
					'type' => \Elementor\CustomControl\Pix_Template_Control::PixTemplateSelector,
					'default' => '',
					'options' => $template_results,
					'condition' => [
						'item_type' => 'template',
					],
				]
			);
		}

		$repeater->add_control(
			'icon',
			[
				'label' => esc_html__('pixfort Icon', 'pixfort-core'),
				'type' => \Elementor\CustomControl\PixfortIconSelector_Control::PixfortIconSelector,
				'default' => '',
				'condition' => [
					'item_type' => 'icon',
				],
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
					'item_type' => 'text',
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
				'default' => '',
				'condition' => [
					'item_type' => 'text',
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
					'item_type' => 'text',
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
					'item_type' => 'text',
				],
			]
		);
		$repeater->add_control(
			'text_image',
			[
				'label' => __('Use image as text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic'     => array(
					'active'  => true
				),
				'condition' => [
					'item_type' => 'text',
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
		// 			'item_type' => 'image',
		// 		],
		// 	]
		// );
		getElementorDynamicImageControls($repeater, 'image', 'image_dark', [ 'item_type' => 'image' ]);

		$repeater->add_responsive_control(
			'image_size',
			[
				'label' => __('Image Size', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('The size of the image (in pixels), leave empty for full size.', 'pixfort-core'),
				'default' => '',
				'render_type' => 'template',
				'dynamic'     => array(
					'active'  => true
				),
				'condition' => [
					'item_type' => 'image',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} img' => 'width: {{VALUE}} !important;height: auto !important;',
				],
			]
		);
		$repeater->add_control(
			'rounded_img',
			[
				'label' => __('Rounded corners', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded-0',
				'options' => [
					'rounded-0' 		=> __('No', 'pixfort-core'),
					'rounded' 			=> __('Rounded', 'pixfort-core'),
					'rounded-lg' 		=> __('Rounded Large', 'pixfort-core'),
					'rounded-xl' 		=> __('Rounded 5px', 'pixfort-core'),
					'rounded-10' 		=> __('Rounded 10px', 'pixfort-core'),
					'rounded-circle'	=>	__('Circle', 'pixfort-core')
				],
				'condition' => [
					'item_type' => 'image',
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
					'item_type' => 'image',
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
					'item_type' => 'image',
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
					'item_type' => 'image',
				],
			]
		);
		$repeater->add_control(
			'link',
			[
				'label' => __('Link', 'pixfort-core'),
				'type' => Controls_Manager::URL,
				'placeholder' => __('', 'pixfort-core'),
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
				'title_field' => '{{{ text }}}',
				'fields' => $repeater->get_controls(),
				'default'	=> [
					[
						'item_type'	=>	'text',
						'text'		=>	'Marquee text!',
					],
					[
						'item_type'	=>	'text',
						'text'		=>	'Hello World',
					]
				]
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
				// 'selectors' => [
				// 	'{{WRAPPER}} .el-title_custom_color' => 'color: {{VALUE}};',
				// ],
			]
		);
		$this->add_control(
			'content_size',
			[
				'label' => __('Content size', 'pixfort-core'),
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
				'default' => 'h1',
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
					'content_size' => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6')
				],
			]
		);
		$this->add_control(
			'content_custom_size',
			[
				'label' => __('Content custom text Size', 'pixfort-core'),
				'label_block' => false,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter custom size', 'pixfort-core'),
				'default' => '',
				'condition' => [
					'content_size' => 'custom',
				],
			]
		);
		$this->add_control(
			'reversed',
			[
				'label' => __('Reverse direction', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'pix-reversed',
				'default' => ''
			]
		);
		$this->add_control(
			'pause_on_hover',
			[
				'label' => __('Pause on hover', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'pix-pause-hover',
				'default' => ''
			]
		);
		$this->add_control(
			'pix_gray_effect',
			[
				'label' => __('Enable Gray effect', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'pix-gray-effect',
				'default' => ''
			]
		);



		$this->add_control(
			'pix_colored_hover',
			[
				'label' => __('Show original colors on hover', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'pix-colored-hover',
				'default' => '',
				'condition' => [
					'pix_gray_effect' => 'pix-gray-effect',
				],
			]
		);

		// New Motion Library Options
		$this->add_control(
			'scroll_direction_change',
			[
				'label' => __('Change direction on scroll', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => '',
				'description' => __('Marquee direction will change based on scroll direction', 'pixfort-core'),
			]
		);

		// $this->add_control(
		// 	'load_animation',
		// 	[
		// 		'label' => __('Animate on load', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'label_on' => __('Yes', 'pixfort-core'),
		// 		'label_off' => __('No', 'pixfort-core'),
		// 		'return_value' => 'true',
		// 		'default' => '',
		// 		'description' => __('Fade in animation when element loads', 'pixfort-core'),
		// 	]
		// );

		if(\PixfortCore::instance()->getThemeParam('vertical_marquee')) {
			$this->add_control(
				'vertical_direction',
				[
					'label' => __('Vertical marquee', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __('Yes', 'pixfort-core'),
					'label_off' => __('No', 'pixfort-core'),
					'return_value' => 'true',
					'default' => '',
					'description' => __('Display marquee vertically instead of horizontally', 'pixfort-core'),
				]
			);
		}

		// Rotate items when vertical (responsive)
		// $this->add_responsive_control(
		// 	'vertical_items_rotate',
		// 	[
		// 		'label' => __('Rotate items (deg)', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::SLIDER,
		// 		'size_units' => [ 'deg' ],
		// 		'range' => [
		// 			'deg' => [ 'min' => -180, 'max' => 180, 'step' => 1 ],
		// 		],
		// 		'default' => [],
		// 		'condition' => [
		// 			'vertical_direction' => 'true',
		// 		],
		// 		'description' => __('Optionally rotate each marquee item when vertical. Leave empty for no rotation.', 'pixfort-core'),
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-marquee.pix-vertical .pix-marquee-item' => 'transform: rotate({{SIZE}}deg);',
		// 		],
		// 	]
		// );

		$this->add_control(
			'smooth_velocity',
			[
				'label' => __('Smooth velocity', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => '',
				'description' => __('Add smooth velocity changes based on scroll speed', 'pixfort-core'),
			]
		);

		$this->end_controls_section();




		$this->start_controls_section(
			'advanced_section',
			[
				'label' => __('Advanced', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'speed',
			[
				'label' => __('Speed (in seconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'description' => __('The number of seconds to complete one full rotation (leave empty to use default 10).', 'pixfort-core'),
				'selectors' => [
					'{{WRAPPER}} .pix-marquee' => '--marquee-speed: {{VALUE}}s;',
					'{{WRAPPER}} .marquee__inner:not(.pix-js-loaded)' => 'animation-duration: {{VALUE}}s !important;',
				],
			]
		);

		// $this->add_control(
		// 	'base_velocity',
		// 	[
		// 		'label' => __('Base velocity', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::NUMBER,
		// 		'default' => 100,
		// 		'min' => 1,
		// 		'max' => 1000,
		// 		'step' => 10,
		// 		'description' => __('Base movement speed for motion library (pixels per second)', 'pixfort-core'),
		// 	]
		// );

		$this->add_responsive_control(
			'marquee_height',
			[
				'label' => __('Marquee height', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [ 'min' => 100, 'max' => 1000, 'step' => 1 ],
				],
				'default' => [],
				'condition' => [
					'vertical_direction' => 'true',
				],
				'description' => __('Set the height of the marquee. Leave empty for auto height.', 'pixfort-core'),
				'selectors' => [
					'{{WRAPPER}} .pix-marquee.pix-vertical, {{WRAPPER}} .pix-marquee.pix-vertical .marquee__inner ' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'element_id',
			[
				'label' => __('Element ID', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
			]
		);
		$this->add_responsive_control(
			'items_padding',
			[
				'label' => __('Padding between items (with unit)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'description' => __('The padding for each Marquee item (leave empty to use default 4vw).<br>Tip: use relative unit for example "vw" to have responsive padding.', 'pixfort-core'),
				'selectors' => [
					'{{WRAPPER}} .pix-marquee' => '--marquee-item-padding: {{VALUE}};',
				],
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'marquee_typography',
				'selector' => '{{WRAPPER}} .pix-marquee-item, {{WRAPPER}} .body-font, {{WRAPPER}} .heading-font, {{WRAPPER}} .secondary-font',
				'exclude' => [
					'text_decoration',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'marquee_text_shadow',
				'selector' => '{{WRAPPER}}',
			]
		);

		// $this->add_responsive_control(
		// 	'pix_fade_mask',
		// 	[
		// 		'label' => __('Fade mask', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::SLIDER,
		// 		'default' => [],
		// 		'size_units' => [ 'px', '%' ],
		// 		'range' => [
		// 			'px' => [
		// 				'min' => 0,
		// 				'max' => 400,
		// 				'step' => 1,
		// 			],
		// 			'%' => [
		// 				'min' => 0,
		// 				'max' => 100,
		// 			],
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-marquee' => 'mask-image: linear-gradient(90deg,transparent 0,#fff {{SIZE}}{{UNIT}},#fff calc(100% - {{SIZE}}{{UNIT}}),transparent 100%)',
		// 		],
		// 	]
		// );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if (empty($settings['element_id'])) {
			$settings['element_id'] = 'el-' . $this->get_id();
		}
		echo \PixfortCore::instance()->elementsManager->renderElement('Marquee', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-marquee-handle'];
		return [];
	}
}
