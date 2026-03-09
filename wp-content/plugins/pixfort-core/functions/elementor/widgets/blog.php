<?php

namespace Elementor;

class Pix_Eor_Blog extends Widget_Base {

	public function __construct($data = [], $args = null) {
		// Blog old dark option migration
		if (!empty($data['settings'])) {
			if (!empty($data['settings']['blog_dark_mode'])) {
				if($data['settings']['blog_dark_mode'] === 'pix-dark'){
					if (!empty($data['settings']['blog_style']) && in_array($data['settings']['blog_style'], array('', 'padding', 'default', 'with-padding'))) {
						$data['settings']['blog_dark_mode'] = '';
						$data['settings']['title_color'] = pix_plugin_get_option('opt-dark-heading-color');
						$data['settings']['title_custom_color'] = pix_plugin_get_option('opt-custom-dark-heading-color');
						$data['settings']['text_color'] = pix_plugin_get_option('opt-dark-body-color');
						$data['settings']['text_custom_color'] = pix_plugin_get_option('opt-custom-dark-body-color');
						$data['settings']['bg_color'] = 'black';
						$data['settings']['meta_bg_color'] = 'gray-9';
					} 
				} 
			}
		}
		parent::__construct($data, $args);

		wp_register_script('pix-blog-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/blog.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
	}

	public function get_name() {
		return 'pix-blog';
	}

	public function get_title() {
		return 'Blog';
	}

	public function get_icon() {
		return 'eicon-posts-grid pixfort-elementor-element pixfort-elementor-blog';
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
		$this->add_control(
			'blog_style',
			[
				'label' => __('Style', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip(array(
					"Default (with dividers)" 	=> '',
					"Default (with padding & dividers)" 	=> 'padding',
					"Default (with post types)" 	=> 'default',
					"Default (with padding & post types)" 	=> 'with-padding',
					"Full image (with post types)" 	=> 'full-img',
					"Left image (with post types)" 	=> 'left-img',
					"Right image (with post types)" 	=> 'right-img',
				)),
			]
		);

		$this->add_control(
			'blog_size',
			[
				'label' => __('Size', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'lg',
				'options' => array_flip(array(
					"Default (Extended)" 	=> 'lg',
					"Medium" 	=> 'md',
					"Small" 	=> 'sm',
				)),
				'condition' => [
					'blog_style' => array('', 'padding', 'default', 'with-padding'),
				],
			]
		);
		$this->add_control(
			'blog_style_box',
			[
				'label' => __('Add box style', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => '',
				// 'condition' => [
				// 	'blog_style' => array('', 'padding', 'default', 'with-padding'),
				// ],
			]
		);
		$this->add_control(
			'blog_dark_mode',
			[
				'label' => __('Use dark mode', 'pixfort-core'),
				// 'type' => \Elementor\Controls_Manager::SWITCHER,
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'pix-dark',
				'default' => '',
				'condition' => [
					'blog_style' => array('', 'padding', 'default', 'with-padding'),
				],
			]
		);



		


		$this->add_control(
			'pagination',
			[
				'label' => __('Show Pagination', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => '',
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
				'default' => '',
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
			'section_content',
			[
				'label' => __('Content', 'pixfort-core'),
			]
		);

		$this->add_control(
			'count',
			[
				'label' => __('Posts count', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Number of posts to show', 'pixfort-core'),
				'default' => '9',
			]
		);
		
		$this->add_control(
			'items_count',
			[
				'label' => __('Items per Line', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 3,
				'options' => [
					"1" 	=> 1,
					"2" 	=> 2,
					"3" 	=> 3,
					"4" 	=> 4,
					"6" 	=> 6,
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'source',
			[
				'label' => __('Source', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __('Default (Posts)', 'pixfort-core'),
					'related' => __('Related', 'pixfort-core'),
				]
			]
		);

	


		$this->add_control(
			'category',
			[
				'label' => __('Category', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => pix_get_categories_array('category'),
				'condition' => [
					'source' => '',
				],
			]
		);
		$this->add_control(
			'category_multi',
			[
				'label' => __('Multiple Categories', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Categories Slugs separated with coma', 'pixfort-core'),
				'default' => '',
				'condition' => [
					'source' => '',
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __('Order by', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array_flip(array(
					__('Date', 'pixfort-core') 	=> 'date',
					__('Title', 'pixfort-core')	    => 'title',
					__('Random', 'pixfort-core')	    => 'rand',
					__('Number of comments', 'pixfort-core')	    => 'comment_count',
					__('Last modified', 'pixfort-core')	    => 'modified',
				)),
				'condition' => [
					'source' => '',
				],
			]
		);
		$this->add_control(
			'order',
			[
				'label' => __('Order', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => array_flip(array(
					__('DESC', 'pixfort-core') 	=> 'DESC',
					__('ASC', 'pixfort-core')	    => 'ASC',
				)),
				'condition' => [
					'source' => '',
				],
			]
		);
		$this->add_control(
			'offset',
			[
				'label' => __('Offset', 'pixfort-core'),
				'type' => Controls_Manager::NUMBER,
				'placeholder' => __('Number of posts to skip', 'pixfort-core'),
				'default' => 0,
				'min' => 0,
				'condition' => [
					'source' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'divider_section',
			[
				'label' => __('Divider', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'blog_style' => array('', 'padding'),
				],
			]
		);
		$this->add_control(
			'bottom_divider_select',
			[
				'label' => __('Divider Style', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => array_flip(array(
					"Disabled" 	=> '0',
					"Dynamic" 	=> 'dynamic',
					"Style 2" 	=> '2',
					"Style 3" 	=> '3',
					"Style 4" 	=> '4',
					"Style 5" 	=> '5',
					"Style 6" 	=> '6',
					"Style 7" 	=> '7',
					"Style 8" 	=> '8',
					"Style 9" 	=> '9',
					"Style 10" 	=> '10',
					"Style 11" 	=> '11',
					"Style 12" 	=> '12',
					"Style 13" 	=> '13',
					"Style 14" 	=> '14',
					"Style 15" 	=> '15',
					"Style 16" 	=> '16',
					"Style 17" 	=> '17',
					"Style 18" 	=> '18',
					"Style 19" 	=> '19',
					"Style 20" 	=> '20',
					"Style 21" 	=> '21',
					"Style 22" 	=> '22',
					"Style 23" 	=> '23',
				)),
			]
		);


		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'd_gradient',
			[
				'label' => __('Use Gradient', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => '1',
				'default' => ''
			]
		);
		$repeater->add_control(
			'd_color_1',
			[
				'label' => __('Layer color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#f8f9fa',
			]
		);
		$repeater->add_control(
			'd_color_2',
			[
				'label' => __('Layer color 2', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#f8f9fa'
			]
		);

		$this->add_control(
			'bottom_moving_divider_color',
			[
				'label' => __('Items', 'pixfort-core'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'condition' => [
					'bottom_divider_select' => array('dynamic')
				]
			]

		);

		$this->add_control(
			'bottom_layers',
			[
				'label' => __('The number of Layers', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					"1"       => "1 Layer",
					"2"       => "2 Layer",
					"3"       => "3 Layer",
				],
				'condition' => [
					'bottom_divider_select' => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
				],
			]
		);
		$this->add_control(
			'b_flip_h',
			[
				'label' => __('Flip the divider', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => '',
				'condition' => [
					'blog_style' => array('', 'padding')
				],
			]
		);
		$this->add_control(
			'b_custom_height',
			[
				'label' => __('Divider custom height (Optional)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('Add custom height (with unit, e.g: 200px)', 'pixfort-core'),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
				'label' => __('Style', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Title Color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')], 'gradients' => false]),
				'selectors' => [
					'{{WRAPPER}} .card-title, {{WRAPPER}} .pix-blog-post-title, {{WRAPPER}} .entry-title a, {{WRAPPER}} .pix-post-format-a:hover svg' => 'color: var(--pix-{{VALUE}}) !important',
				],
			]
		);

		$this->add_control(
			'title_custom_color',
			[
				'label' => __('Custom Title Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'title_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .card-title, {{WRAPPER}} .pix-blog-post-title, {{WRAPPER}} .entry-title a, {{WRAPPER}} .pix-post-format-a:hover svg' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __('Text Color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')], 'gradients' => false]),
				'selectors' => [
					'{{WRAPPER}} .pix-blog-post-text, {{WRAPPER}} .pixfort-likes-small' => 'color: var(--pix-{{VALUE}}) !important',
				],
			]
		);

		$this->add_control(
			'text_custom_color',
			[
				'label' => __('Custom Text Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'text_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-blog-post-text, {{WRAPPER}} .pixfort-likes-small' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label' => __('Background Color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')],'gradients' => false, 'custom' => false]),
				'selectors' => [
					'{{WRAPPER}} .pix-content-box, {{WRAPPER}} .pix-post-format-a, {{WRAPPER}} .pix-post-format-a:hover, {{WRAPPER}} .pix-post-meta-comments > .pix-blog-badge-box' => 'background-color: var(--pix-{{VALUE}});--pix-bg-color: var(--pix-{{VALUE}});',
				],
				'condition' => [
					'blog_style' => array('', 'padding', 'default', 'with-padding', 'left-img', 'right-img'),
				],
			]
		);

		// $this->add_control(
		// 	'bg_custom_color',
		// 	[
		// 		'label' => __('Custom Background Color', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::COLOR,
		// 		'condition' => [
		// 			'bg_color' => 'custom',
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-content-box' => 'background-color: {{VALUE}};--pix-bg-color: {{VALUE}}',
		// 		],
		// 	]
		// );

		$this->add_control(
			'meta_bg_color',
			[
				'label' => __('Meta Data Background Color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')],'gradients' => false, 'custom' => false]),
				'selectors' => [
					'{{WRAPPER}} .blog-card-meta-area' => 'background-color: var(--pix-{{VALUE}});--pix-bg-color: var(--pix-{{VALUE}});',
				],
				'condition' => [
					'blog_style' => array('', 'padding', 'default', 'with-padding', 'left-img', 'right-img'),
				],
			]
		);

		// $this->add_control(
		// 	'footer_bg_custom_color',
		// 	[
		// 		'label' => __('Custom Footer Background Color', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::COLOR,
		// 		'condition' => [
		// 			'footer_bg_color' => 'custom',
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .blog-card-meta-area' => 'background-color: {{VALUE}};--pix-bg-color: {{VALUE}}',
		// 		],
		// 	]
		// );


		$this->add_control(
			'categories_bg_color',
			[
				'label' => __('Categories Background Color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')],'gradients' => false, 'custom' => false]),
				'selectors' => [
					'{{WRAPPER}} .pix-post-meta-categories .badge' => '--pix-bg-color: var(--pix-{{VALUE}});',
				],
			]
		);

		$this->add_control(
			'categories_text_color',
			[
				'label' => __('Categories Text Color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')], 'gradients' => false, 'custom' => false]),
				'selectors' => [
					'{{WRAPPER}} .pix-post-meta-categories .badge span' => 'color: var(--pix-{{VALUE}}) !important',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('Blog', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-blog-handle'];
		return [];
	}
}
