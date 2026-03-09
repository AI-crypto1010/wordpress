<?php

namespace Elementor;

class Pix_Eor_Template_Post_Navigation extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-template-post-navigation';
	}

	public function get_title() {
		return 'Post Navigation';
	}

	public function get_icon() {
		return 'eicon-post-navigation pixfort-elementor-element pixfort-elementor-post-navigation';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function show_in_panel() {
		// Only show this widget when editing a pixfort_template with post type
		return $this->is_post_template_context();
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	/**
	 * Check if we're in the context of editing a pixfort_template with "post" taxonomy
	 */
	private function is_post_template_context() {
		// Check if we're in Elementor editor
		if (!Plugin::$instance->editor->is_edit_mode()) {
			return false;
		}

		// Get current post ID from Elementor
		$post_id = Plugin::$instance->editor->get_post_id();

		if (!$post_id) {
			return false;
		}

		// Check if post type is pixfort_template
		if (get_post_type($post_id) !== 'pixfort_template') {
			return false;
		}

		// Check if template type is "post", "page", or "template"
		$terms = get_the_terms($post_id, 'pixfort_template_type');
		if ($terms && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				if ($term->slug === 'post' || $term->slug === 'page' || $term->slug === 'template') {
					return true;
				}
			}
		}

		return false;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __('Content', 'pixfort-core'),
			]
		);

		$this->add_control(
			'show_previous',
			[
				'label' => __('Show Previous Post', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_next',
			[
				'label' => __('Show Next Post', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'previous_text',
			[
				'label' => __('Previous Label', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('Previous Post', 'pixfort-core'),
				'placeholder' => __('Enter previous label...', 'pixfort-core'),
				'condition' => [
					'show_previous' => 'yes',
				],
			]
		);

		$this->add_control(
			'next_text',
			[
				'label' => __('Next Label', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('Next Post', 'pixfort-core'),
				'placeholder' => __('Enter next label...', 'pixfort-core'),
				'condition' => [
					'show_next' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __('Show Post Title', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_image',
			[
				'label' => __('Show Featured Image', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'in_same_term',
			[
				'label' => __('In Same Category', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
				'description' => __('Navigate only within the same category.', 'pixfort-core'),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout',
			[
				'label' => __('Layout', 'pixfort-core'),
			]
		);

		$this->add_responsive_control(
			'direction',
			[
				'label' => __('Layout', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'row',
				'options' => [
					'row' => __('Horizontal', 'pixfort-core'),
					'column' => __('Vertical', 'pixfort-core'),
				],
				'selectors' => [
					'{{WRAPPER}} .pix-post-navigation' => 'flex-direction: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'justify_content',
			[
				'label' => esc_html__('Justify Content', 'elementor'),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'space-between',
				'options' => [
					'start' => [
						'title' => esc_html__('Start', 'elementor'),
						'icon' => 'eicon-flex eicon-justify-start-h',
					],
					'center' => [
						'title' => esc_html__('Center', 'elementor'),
						'icon' => 'eicon-flex eicon-justify-center-h',
					],
					'end' => [
						'title' => esc_html__('End', 'elementor'),
						'icon' => 'eicon-flex eicon-justify-end-h',
					],
					'space-between' => [
						'title' => esc_html__('Space Between', 'elementor'),
						'icon' => 'eicon-flex eicon-justify-space-between-h',
					],
					'space-around' => [
						'title' => esc_html__('Space Around', 'elementor'),
						'icon' => 'eicon-flex eicon-justify-space-around-h',
					],
					'space-evenly' => [
						'title' => esc_html__('Space Evenly', 'elementor'),
						'icon' => 'eicon-flex eicon-justify-space-evenly-h',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pix-post-navigation' => 'justify-content: {{VALUE}};',
				],
				// 'condition' => [
				// 	'direction' => 'row',
				// ],
			]
		);

		$this->add_responsive_control(
			'align_items',
			[
				'label' => __('Align Items', 'pixfort-core'),
				'type' => Controls_Manager::CHOOSE,
				'default' => '',
				'options' => [
					'start' => [
						'title' => esc_html__('Start', 'elementor'),
						'icon' => 'eicon-flex eicon-align-start-v',
					],
					'center' => [
						'title' => esc_html__('Center', 'elementor'),
						'icon' => 'eicon-flex eicon-align-center-v',
					],
					'end' => [
						'title' => esc_html__('End', 'elementor'),
						'icon' => 'eicon-flex eicon-align-end-v',
					],
					'stretch' => [
						'title' => esc_html__('Stretch', 'elementor'),
						'icon' => 'eicon-flex eicon-align-stretch-v',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pix-post-navigation' => 'align-items: {{VALUE}};',
				],
				// 'condition' => [
				// 	'direction' => 'column',
				// ],
			]
		);

		$this->add_responsive_control(
			'gap',
			[
				'label' => __('Gap', 'pixfort-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'default' => [
					'size' => 20,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-post-navigation' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Container Style section
		// $this->start_controls_section(
		// 	'section_container_style',
		// 	[
		// 		'label' => __('Container', 'pixfort-core'),
		// 		'tab' => Controls_Manager::TAB_STYLE,
		// 	]
		// );

		// $this->add_control(
		// 	'background_color',
		// 	[
		// 		'label' => __('Background Color', 'pixfort-core'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-post-navigation .card' => 'background-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		// $this->add_group_control(
		// 	Group_Control_Border::get_type(),
		// 	[
		// 		'name' => 'container_border',
		// 		'selector' => '{{WRAPPER}} .pix-post-navigation .card',
		// 	]
		// );

		// $this->add_responsive_control(
		// 	'container_border_radius',
		// 	[
		// 		'label' => __('Border Radius', 'pixfort-core'),
		// 		'type' => Controls_Manager::DIMENSIONS,
		// 		'size_units' => ['px', '%'],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-post-navigation .card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 		],
		// 	]
		// );

		// $this->add_responsive_control(
		// 	'container_padding',
		// 	[
		// 		'label' => __('Padding', 'pixfort-core'),
		// 		'type' => Controls_Manager::DIMENSIONS,
		// 		'size_units' => ['px', 'em', '%'],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-post-navigation .card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 		],
		// 	]
		// );

		// $this->add_responsive_control(
		// 	'container_margin',
		// 	[
		// 		'label' => __('Margin', 'pixfort-core'),
		// 		'type' => Controls_Manager::DIMENSIONS,
		// 		'size_units' => ['px', 'em', '%'],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-post-navigation .card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 		],
		// 	]
		// );

		// $this->add_responsive_control(
		// 	'alignment',
		// 	[
		// 		'label' => __('Alignment', 'pixfort-core'),
		// 		'type' => Controls_Manager::CHOOSE,
		// 		'options' => [
		// 			'left' => [
		// 				'title' => __('Left', 'pixfort-core'),
		// 				'icon' => 'eicon-text-align-left',
		// 			],
		// 			'center' => [
		// 				'title' => __('Center', 'pixfort-core'),
		// 				'icon' => 'eicon-text-align-center',
		// 			],
		// 			'right' => [
		// 				'title' => __('Right', 'pixfort-core'),
		// 				'icon' => 'eicon-text-align-right',
		// 			],
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-post-navigation' => 'text-align: {{VALUE}};',
		// 		],
		// 	]
		// );

		// $this->end_controls_section();

		// Navigation Item Style section
		$this->start_controls_section(
			'section_nav_item_style',
			[
				'label' => __('Navigation Items', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'bg_color',
			[
				'label' => __('Background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .card' => 'background: var(--pix-{{VALUE}}) !important;',
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$this->add_responsive_control(
			'custom_bg_color',
			[
				'label' => __('Custom Background Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'bg_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-card-content' => 'background-color: {{VALUE}} !important;',
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		// $this->add_control(
		// 	'rounded_img',
		// 	[
		// 		'label' => __('Rounded corners', 'pixfort-core'),
		// 		'type' => Controls_Manager::SELECT,
		// 		'default' => 'rounded-xl',
		// 		'options' => [
		// 			'rounded-0' => __('No', 'pixfort-core'),
		// 			'rounded' => __('Rounded', 'pixfort-core'),
		// 			'rounded-lg' => __('Rounded Large', 'pixfort-core'),
		// 			'rounded-xl' => __('Rounded 5px', 'pixfort-core'),
		// 			'rounded-10' => __('Rounded 10px', 'pixfort-core'),
		// 		],
		// 	]
		// );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'items_border',
				'selector' => '{{WRAPPER}} .card',
			]
		);

		$this->add_responsive_control(
			'items_border_radius',
			[
				'label' => __('Items Border Radius', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
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
				'default' => '1',
			]
		);
		$this->add_control(
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
				'default' => '1',
			]
		);
		$this->add_control(
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
			]
		);

		// $this->add_control(
		// 	'nav_item_background',
		// 	[
		// 		'label' => __('Item Background', 'pixfort-core'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-post-navigation .card' => 'background-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'nav_item_hover_background',
		// 	[
		// 		'label' => __('Item Hover Background', 'pixfort-core'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-post-navigation .card:hover' => 'background-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		// $this->add_group_control(
		// 	Group_Control_Border::get_type(),
		// 	[
		// 		'name' => 'nav_item_border',
		// 		'selector' => '{{WRAPPER}} .pix-post-navigation .card',
		// 	]
		// );

		// $this->add_responsive_control(
		// 	'nav_item_border_radius',
		// 	[
		// 		'label' => __('Border Radius', 'pixfort-core'),
		// 		'type' => Controls_Manager::DIMENSIONS,
		// 		'size_units' => ['px', '%'],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-post-navigation .card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 		],
		// 	]
		// );

		$this->add_responsive_control(
			'items_padding',
			[
				'label' => __('Items Padding', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		// $this->add_responsive_control(
		// 	'nav_item_margin',
		// 	[
		// 		'label' => __('Item Margin', 'pixfort-core'),
		// 		'type' => Controls_Manager::DIMENSIONS,
		// 		'size_units' => ['px', 'em', '%'],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-post-navigation .card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 		],
		// 	]
		// );

		$this->end_controls_section();

		// Label Style section
		$this->start_controls_section(
			'section_label_style',
			[
				'label' => __('Labels', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => __('Label color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')], 'mainLight' => true]),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pix-post-navigation .text-body-default' => 'color: var(--pix-{{VALUE}}) !important;',
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'label_custom_color',
			[
				'label' => __('Custom Label color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'label_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-post-navigation .text-body-default' => 'color: {{VALUE}} !important;',
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'selector' => '{{WRAPPER}} .pix-post-navigation .text-body-default',
			]
		);

		$this->end_controls_section();

		// Title Style section
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __('Titles', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')], 'mainLight' => true]),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pix-post-navigation .card-title' => 'color: var(--pix-{{VALUE}}) !important;',
				],
				'dynamic'     => array(
					'active'  => true
				),
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
					'{{WRAPPER}} .pix-post-navigation .card-title' => 'color: {{VALUE}} !important;',
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		// $this->add_control(
		// 	'title_color',
		// 	[
		// 		'label' => __('Title Color', 'pixfort-core'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-post-navigation .card-title' => 'color: {{VALUE}};',
		// 			'{{WRAPPER}} .pix-post-navigation .card-title a' => 'color: {{VALUE}};',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'title_hover_color',
		// 	[
		// 		'label' => __('Title Hover Color', 'pixfort-core'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-post-navigation .card:hover .card-title a' => 'color: {{VALUE}};',
		// 		],
		// 	]
		// );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .pix-post-navigation .card-title',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if (Plugin::$instance->editor->is_edit_mode()) {
			// In editor mode, show placeholder navigation
			$this->render_placeholder_navigation($settings);
		} else {
			// Get actual post navigation
			$this->render_actual_navigation($settings);
		}
	}

	private function render_placeholder_navigation($settings) {

		// Get real posts from the site to display as placeholders
		$sample_posts = get_posts(array(
			'post_type' => 'post',
			'posts_per_page' => 3,
			'orderby' => 'date',
			'order' => 'DESC',
			'post_status' => 'publish'
		));

		// Use second and third post if available
		$previous_sample_post = isset($sample_posts[1]) ? $sample_posts[1] : null;
		$next_sample_post = isset($sample_posts[2]) ? $sample_posts[2] : (isset($sample_posts[0]) ? $sample_posts[0] : null);

		// Define icons and styling similar to example code
		$iconPrev = 'Line/pixfort-icon-arrow-left-2';
		$iconPrevMargin = 'mr-2';
		$iconPrevHover = 'pix-hover-left';
		$thumbPrevMargin = 'pix-ml-10';
		$iconNext = 'Line/pixfort-icon-arrow-right-2';
		$iconNextMargin = 'ml-2';
		$iconNextHover = 'pix-hover-right';
		$thumbNextMargin = 'pix-mr-10';

		if (is_rtl()) {
			$iconPrev = 'Line/pixfort-icon-arrow-right-2';
			$iconPrevMargin = 'ml-2';
			$iconPrevHover = 'pix-hover-right';
			$thumbPrevMargin = 'pix-mr-10';
			$iconNext = 'Line/pixfort-icon-arrow-left-2';
			$iconNextMargin = 'mr-2';
			$thumbNextMargin = 'pix-ml-10';
		}

		$prevIcon = '';
		$nextIcon = '';

		if (pixCheckIconsAvailable()) {
			$prevIcon = \PixfortCore::instance()->icons->getIcon($iconPrev, 24, 'text-body-default ' . $iconPrevMargin . ' ' . $iconPrevHover);
			$nextIcon = \PixfortCore::instance()->icons->getIcon($iconNext, 24, 'text-body-default ' . $iconNextMargin . ' ' . $iconNextHover);
		}

		$textTruncate = 'truncate-200';
		if (!empty($settings['direction']) && $settings['direction'] === 'column') {
			$textTruncate = '';
		}

		$el_classes = \PixfortCore::instance()->coreFunctions->getEffectsClasses($settings['style'], $settings['hover_effect'], $settings['add_hover_effect']);
		// if (!empty($settings['rounded_img'])) {
		// 	$el_classes .= ' ' . $settings['rounded_img'];
		// }

		echo '<div class="pix-post-navigation d-flex">';

		// Previous post placeholder with real post data
		if ($settings['show_previous'] === 'yes' && $previous_sample_post) {
			$previous_thumb = '';
			if ($settings['show_image'] === 'yes') {
				$image_html = get_the_post_thumbnail($previous_sample_post->ID, [40, 40], array('class' => 'rounded-lg ' . $thumbPrevMargin));
				if ($image_html) {
					$previous_thumb = $image_html;
				}
			}

			$prev = '<a href="' . esc_url(get_permalink($previous_sample_post)) . '" rel="prev">
						<div class="card rounded-10 ' . $el_classes . ' d-block pix-base-background pix-hover-item h-100 align-content-center">
						  <div class="card-body pix-p-10">
							  <div class="d-flex justify-content-between align-items-center">
								' . $prevIcon . '
								<div class="card-btn-content d-flex flex-column">
								<div class="text-body-default text-xs line-height-1">' . esc_html($settings['previous_text']) . '</div>';
			if ($settings['show_title'] === 'yes') {
				$prev .= '<span class="card-title mb-0 text-heading-default font-weight-bold line-height-1 ' . $textTruncate . '">%title</span>';
			}
			$prev .= '</div>
								<div>' . $previous_thumb . '</div>
							</div>
						  </div>
						</div>
					</a>';

			echo str_replace('%title', esc_html(get_the_title($previous_sample_post)), $prev);
		}

		// Next post placeholder with real post data
		if ($settings['show_next'] === 'yes' && $next_sample_post) {
			$next_thumb = '';
			if ($settings['show_image'] === 'yes') {
				$image_html = get_the_post_thumbnail($next_sample_post->ID, [40, 40], array('class' => 'rounded-lg ' . $thumbNextMargin));
				if ($image_html) {
					$next_thumb = $image_html;
				}
			}

			$next = '<a href="' . esc_url(get_permalink($next_sample_post)) . '" rel="next">
						<div class="card rounded-10 ' . $el_classes . ' d-block pix-base-background pix-hover-item h-100 align-content-center">
						  <div class="card-body pix-p-10">
							  <div class="d-flex justify-content-between align-items-center">
								<div>' . $next_thumb . '</div>
								<div class="card-btn-content d-flex flex-column align-items-end">
								<div class="text-body-default text-xs line-height-1">' . esc_html($settings['next_text']) . '</div>';
			if ($settings['show_title'] === 'yes') {
				$next .= '<span class="card-title mb-0 text-heading-default font-weight-bold line-height-1 text-left ' . $textTruncate . '">%title</span>';
			}
			$next .= '</div>
								' . $nextIcon . '
							</div>
						  </div>
						</div>
					</a>';

			echo str_replace('%title', esc_html(get_the_title($next_sample_post)), $next);
		}

		echo '</div>';
	}

	private function render_actual_navigation($settings) {
		global $post;


		// Store original post to restore later
		$original_post = $post;

		// Get the actual post being displayed (might be different in Elementor template context)
		$current_post_id = get_queried_object_id();
		if ($current_post_id) {
			$post = get_post($current_post_id);
			setup_postdata($post);
		} else {
			$post = get_post();
			if (!$post) {
				return;
			}
			setup_postdata($post);
		}

		$in_same_term = $settings['in_same_term'] === 'yes';
		$taxonomy = $in_same_term ? 'category' : 'category';

		$previous_post = get_previous_post($in_same_term, '', $taxonomy);
		$next_post = get_next_post($in_same_term, '', $taxonomy);

		// Don't show navigation if no posts found
		if (!$previous_post && !$next_post) {
			wp_reset_postdata();
			$post = $original_post;
			return;
		}

		// Don't show if only one direction is enabled and that post doesn't exist
		if (($settings['show_previous'] === 'yes' && !$previous_post && $settings['show_next'] !== 'yes') ||
			($settings['show_next'] === 'yes' && !$next_post && $settings['show_previous'] !== 'yes')
		) {
			wp_reset_postdata();
			$post = $original_post;
			return;
		}

		// Define icons and styling similar to example code
		$iconPrev = 'Line/pixfort-icon-arrow-left-2';
		$iconPrevMargin = 'mr-2';
		$iconPrevHover = 'pix-hover-left';
		$thumbPrevMargin = 'pix-ml-10';
		$iconNext = 'Line/pixfort-icon-arrow-right-2';
		$iconNextMargin = 'ml-2';
		$iconNextHover = 'pix-hover-right';
		$thumbNextMargin = 'pix-mr-10';

		if (is_rtl()) {
			$iconPrev = 'Line/pixfort-icon-arrow-right-2';
			$iconPrevMargin = 'ml-2';
			$iconPrevHover = 'pix-hover-right';
			$thumbPrevMargin = 'pix-mr-10';
			$iconNext = 'Line/pixfort-icon-arrow-left-2';
			$iconNextMargin = 'mr-2';
			$thumbNextMargin = 'pix-ml-10';
		}

		$prevIcon = '';
		$nextIcon = '';

		if (pixCheckIconsAvailable()) {
			$prevIcon = \PixfortCore::instance()->icons->getIcon($iconPrev, 24, 'text-body-default ' . $iconPrevMargin . ' ' . $iconPrevHover);
			$nextIcon = \PixfortCore::instance()->icons->getIcon($iconNext, 24, 'text-body-default ' . $iconNextMargin . ' ' . $iconNextHover);
		}

		$textTruncate = 'truncate-200';
		if (!empty($settings['direction']) && $settings['direction'] === 'column') {
			$textTruncate = '';
		}

		$el_classes = \PixfortCore::instance()->coreFunctions->getEffectsClasses($settings['style'], $settings['hover_effect'], $settings['add_hover_effect']);
		// if (!empty($settings['rounded_img'])) {
		// 	$el_classes .= ' ' . $settings['rounded_img'];
		// }

		echo '<div class="pix-post-navigation d-flex">';

		if ($settings['show_previous'] === 'yes' && $previous_post) {
			$previous_thumb = '';
			if ($settings['show_image'] === 'yes') {
				$image_html = get_the_post_thumbnail($previous_post->ID, [40, 40], array('class' => 'rounded-lg ' . $thumbPrevMargin));
				if ($image_html) {
					$previous_thumb = '<div>' . $image_html . '</div>';
				}
			}

			$prev = '<a href="' . esc_url(get_permalink($previous_post)) . '" rel="prev">
						<div class="card rounded-10 ' . $el_classes . ' d-block pix-base-background pix-hover-item h-100 align-content-center">
						  <div class="card-body pix-p-10">
							  <div class="d-flex justify-content-between align-items-center">
								' . $prevIcon . '
								<div class="card-btn-content d-flex flex-column">
								<div class="text-body-default text-xs line-height-1">' . esc_html($settings['previous_text']) . '</div>';
			if ($settings['show_title'] === 'yes') {
				$prev .= '<span class="card-title mb-0 text-heading-default font-weight-bold line-height-1 ' . $textTruncate . '">%title</span>';
			}
			$prev .= '</div>
								' . $previous_thumb . '
							</div>
						  </div>
						</div>
					</a>';

			echo str_replace('%title', esc_html(get_the_title($previous_post)), $prev);
		}

		if ($settings['show_next'] === 'yes' && $next_post) {
			$next_thumb = '';
			if ($settings['show_image'] === 'yes') {
				$image_html = get_the_post_thumbnail($next_post->ID, [40, 40], array('class' => 'rounded-lg ' . $thumbNextMargin));
				if ($image_html) {
					$next_thumb = '<div>' . $image_html . '</div>';
				}
			}



			$next = '<a href="' . esc_url(get_permalink($next_post)) . '" rel="next">
						<div class="card rounded-10 ' . $el_classes . ' d-block pix-base-background pix-hover-item h-100 align-content-center">
						  <div class="card-body pix-p-10">
							  <div class="d-flex justify-content-between align-items-center">
								' . $next_thumb . '
								<div class="card-btn-content d-flex flex-column align-items-end">
								<div class="text-body-default text-xs line-height-1">' . esc_html($settings['next_text']) . '</div>';
			if ($settings['show_title'] === 'yes') {
				$next .= '<span class="card-title mb-0 text-heading-default font-weight-bold line-height-1 text-left ' . $textTruncate . '">%title</span>';
			}
			$next .= '</div>
								' . $nextIcon . '
							</div>
						  </div>
						</div>
					</a>';

			echo str_replace('%title', esc_html(get_the_title($next_post)), $next);
		}

		echo '</div>';
		wp_reset_postdata();
		$post = $original_post;
	}
}
