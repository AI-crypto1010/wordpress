<?php

namespace Elementor;

class Pix_Eor_Template_Archive_Posts extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_script('pix-blog-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/blog.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
	}

	public function get_name() {
		return 'pix-template-archive-posts';
	}

	public function get_title() {
		return 'Archive Posts';
	}

	public function get_icon() {
		return 'eicon-archive-posts pixfort-elementor-element pixfort-elementor-archive-posts';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function show_in_panel() {
		// Only show this widget when editing a pixfort_template with archive or search type
		return $this->is_archive_template_context();
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	/**
	 * Check if we're in the context of editing a pixfort_template with "archive" or "search" taxonomy
	 */
	private function is_archive_template_context() {
		// Check if we're in Elementor editor
		if (!\Elementor\Plugin::$instance->editor->is_edit_mode()) {
			return false;
		}

		// Get current post ID from Elementor
		$post_id = \Elementor\Plugin::$instance->editor->get_post_id();

		if (!$post_id) {
			return false;
		}

		// Check if post type is pixfort_template
		if (get_post_type($post_id) !== 'pixfort_template') {
			return false;
		}

		// Check if template type is "archive", "search", or "template"
		$terms = get_the_terms($post_id, 'pixfort_template_type');
		if ($terms && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				if (in_array($term->slug, ['archive', 'search', 'template'])) {
					return true;
				}
			}
		}

		return false;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_general',
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
			]
		);

		// $this->add_control(
		// 	'posts_per_page',
		// 	[
		// 		'label' => __('Posts per page', 'pixfort-core'),
		// 		'type' => Controls_Manager::NUMBER,
		// 		'default' => get_option('posts_per_page', 10),
		// 		'min' => 1,
		// 		'max' => 100,
		// 		'description' => __('Number of posts to show per page (uses WordPress setting by default).', 'pixfort-core'),
		// 	]
		// );

		$this->add_control(
			'pagination',
			[
				'label' => __('Show pagination', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => 'true',
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

		// Style section
		$this->start_controls_section(
			'section_style',
			[
				'label' => __('Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'rounded_img',
			[
				'label' => __('Rounded corners', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded-lg',
				'options' => [
					'' 					=> __('No', 'pixfort-core'),
					'rounded' 			=> __('Rounded', 'pixfort-core'),
					'rounded-lg' 		=> __('Rounded Large', 'pixfort-core'),
					'rounded-xl' 		=> __('Rounded 5px', 'pixfort-core'),
					'rounded-10' 		=> __('Rounded 10px', 'pixfort-core'),
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
				'label' => __('Animation delay (in milliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('0', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					'animation!' => '',
				],
			]
		);

		$this->end_controls_section();

		// Colors section
		$this->start_controls_section(
			'section_colors',
			[
				'label' => __('Colors', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
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
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')], 'gradients' => false, 'custom' => false]),
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
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')], 'gradients' => false, 'custom' => false]),
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

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		// Get the current query
		global $wp_query;

		// If in editor mode, show placeholder
		if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
			$this->render_placeholder_posts($settings);
			return;
		}

		// Use the main query for archive/search results (override posts_per_page if set in widget)
		$query = $wp_query;
		// $ppp = isset($settings['posts_per_page']) ? intval($settings['posts_per_page']) : 0;
		// if ($ppp > 0 && intval($wp_query->get('posts_per_page')) !== $ppp) {
		// 	$args = $wp_query->query_vars;
		// 	$args['posts_per_page'] = $ppp;
		// 	$args['paged'] = max(1, get_query_var('paged'), get_query_var('page'));
		// 	// Ensure pagination totals are calculated
		// 	$args['no_found_rows'] = false;
		// 	$query = new \WP_Query($args);
		// }

		// If there are no posts, show a message
		if (!$query->have_posts()) {
			echo '<div class="pix-no-posts">';
			echo '<p>' . __('No posts found.', 'pixfort-core') . '</p>';
			echo '</div>';
			return;
		}

		// Generate divider HTML
		$divider_out = '';
		if (!empty($settings['bottom_divider_select']) && $settings['bottom_divider_select'] != '' && $settings['bottom_divider_select'] != '0') {

			// Set default values for divider parameters
			$b_1_color = isset($settings['b_1_color']) ? $settings['b_1_color'] : '#fff';
			$b_2_color = isset($settings['b_2_color']) ? $settings['b_2_color'] : 'rgba(255,255,255,0.8)';
			$b_2_animation = isset($settings['b_2_animation']) ? $settings['b_2_animation'] : 'fade-in-up';
			$b_2_delay = isset($settings['b_2_delay']) ? $settings['b_2_delay'] : '300';
			$b_3_animation = isset($settings['b_3_animation']) ? $settings['b_3_animation'] : 'fade-in-up';
			$b_3_delay = isset($settings['b_3_delay']) ? $settings['b_3_delay'] : '400';
			$b_divider_in_front = isset($settings['b_divider_in_front']) ? $settings['b_divider_in_front'] : 'true';
			$b_flip_h = isset($settings['b_flip_h']) ? $settings['b_flip_h'] : '';
			$b_custom_height = isset($settings['b_custom_height']) ? $settings['b_custom_height'] : '50px';
			$bottom_layers = isset($settings['bottom_layers']) ? $settings['bottom_layers'] : '3';
			$bottom_moving_divider_color = isset($settings['bottom_moving_divider_color']) ? $settings['bottom_moving_divider_color'] : '';

			if ($settings['bottom_divider_select'] !== 'dynamic') {
				$b_divider_opts = array(
					'd_divider_select'			=> $settings['bottom_divider_select'],
					'd_layers'					=> $bottom_layers,
					'd_1_is_gradient'			=> '',
					'd_1_color'					=> $b_1_color,
					'd_2_is_gradient'			=> '',
					'd_2_color'					=> $b_2_color,
					'd_2_animation'				=> $b_2_animation,
					'd_2_delay'					=> $b_2_delay,
					'd_3_is_gradient'			=> '',
					'd_3_color'					=> '',
					'd_3_color_2'				=> '',
					'd_3_animation'				=> $b_3_animation,
					'd_3_delay'					=> $b_3_delay,
					'd_high_index'				=> $b_divider_in_front,
					'd_flip_h'					=> $b_flip_h,
				);
				$divider_out .= pix_get_divider($settings['bottom_divider_select'], '#fff', 'bottom', false, $bottom_moving_divider_color, $b_divider_opts, $b_custom_height);
			} else {
				// Dynamic divider
				$b_divider_opts = array(
					'd_divider_select'			=> $settings['bottom_divider_select'],
					'd_high_index'				=> $b_divider_in_front,
					'd_flip_h'					=> $b_flip_h,
				);
				$divider_out .= pix_get_divider($settings['bottom_divider_select'], '#fff', 'bottom', false, $bottom_moving_divider_color, $b_divider_opts, $b_custom_height);
			}
		}

		// Prepare attributes for blog item rendering
		$attr = array(
			'blog_style' => $settings['blog_style'],
			'blog_size' => $settings['blog_size'],
			'blog_style_box' => $settings['blog_style_box'] === 'true',
			'rounded_img' => $settings['rounded_img'],
			'style' => $settings['style'],
			'hover_effect' => $settings['hover_effect'],
			'add_hover_effect' => $settings['add_hover_effect'],
			'animation' => $settings['animation'],
			'delay' => $settings['delay'],
			'title_color' => isset($settings['title_color']) ? $settings['title_color'] : '',
			'title_custom_color' => isset($settings['title_custom_color']) ? $settings['title_custom_color'] : '',
			'text_color' => isset($settings['text_color']) ? $settings['text_color'] : '',
			'text_custom_color' => isset($settings['text_custom_color']) ? $settings['text_custom_color'] : '',
			'bg_color' => isset($settings['bg_color']) ? $settings['bg_color'] : '',
			'custom_bg_color' => isset($settings['custom_bg_color']) ? $settings['custom_bg_color'] : '',
			'meta_bg_color' => isset($settings['meta_bg_color']) ? $settings['meta_bg_color'] : '',
			'meta_custom_bg_color' => isset($settings['meta_custom_bg_color']) ? $settings['meta_custom_bg_color'] : '',
			// Include divider parameters for the blog item function
			'bottom_divider_select' => $settings['bottom_divider_select'],
			'bottom_moving_divider_color' => isset($settings['bottom_moving_divider_color']) ? $settings['bottom_moving_divider_color'] : '',
			'bottom_layers' => isset($settings['bottom_layers']) ? $settings['bottom_layers'] : '3',
			'b_1_color' => isset($settings['b_1_color']) ? $settings['b_1_color'] : '#fff',
			'b_2_color' => isset($settings['b_2_color']) ? $settings['b_2_color'] : 'rgba(255,255,255,0.8)',
			'b_2_animation' => isset($settings['b_2_animation']) ? $settings['b_2_animation'] : 'fade-in-up',
			'b_2_delay' => isset($settings['b_2_delay']) ? $settings['b_2_delay'] : '300',
			'b_3_animation' => isset($settings['b_3_animation']) ? $settings['b_3_animation'] : 'fade-in-up',
			'b_3_delay' => isset($settings['b_3_delay']) ? $settings['b_3_delay'] : '400',
			'b_divider_in_front' => isset($settings['b_divider_in_front']) ? $settings['b_divider_in_front'] : 'true',
			'b_flip_h' => isset($settings['b_flip_h']) ? $settings['b_flip_h'] : '',
		);

		$col = 12 / $settings['items_count'];

		echo '<div class="row pix-archive-posts-wrapper">';

		include_once(PIXFORT_PLUGIN_DIR . 'includes/elements/extras/blog-functions.php');
		while ($query->have_posts()) {
			echo '<div class="col-xs-12 col-md-' . $col . ' pix-mb-40">';
			echo pix_blog_item($query, $attr, $divider_out);
			echo '</div>';
		}

		echo '</div>';

		// Pagination
		if ($settings['pagination'] === 'true') {
			$this->render_pagination($query);
		}

		wp_reset_postdata();
	}

	private function render_placeholder_posts($settings) {
		// Create a sample query for editor preview
		$args = array(
			'post_type' => 'post',
			// 'posts_per_page' => (!empty($settings['posts_per_page']) ? intval($settings['posts_per_page']) : 3),
			'orderby' => 'date',
			'order' => 'DESC',
		);

		$query = new \WP_Query($args);

		if (!$query->have_posts()) {
			echo '<div class="pix-no-posts">';
			echo '<p>' . __('No posts available for preview. Create some posts to see the archive layout.', 'pixfort-core') . '</p>';
			echo '</div>';
			return;
		}

		// Generate divider HTML for placeholder as well
		$divider_out = '';
		if (!empty($settings['bottom_divider_select']) && $settings['bottom_divider_select'] != '' && $settings['bottom_divider_select'] != '0') {

			// Set default values for divider parameters
			$b_1_color = isset($settings['b_1_color']) ? $settings['b_1_color'] : '#fff';
			$b_2_color = isset($settings['b_2_color']) ? $settings['b_2_color'] : 'rgba(255,255,255,0.8)';
			$b_2_animation = isset($settings['b_2_animation']) ? $settings['b_2_animation'] : 'fade-in-up';
			$b_2_delay = isset($settings['b_2_delay']) ? $settings['b_2_delay'] : '300';
			$b_3_animation = isset($settings['b_3_animation']) ? $settings['b_3_animation'] : 'fade-in-up';
			$b_3_delay = isset($settings['b_3_delay']) ? $settings['b_3_delay'] : '400';
			$b_divider_in_front = isset($settings['b_divider_in_front']) ? $settings['b_divider_in_front'] : 'true';
			$b_flip_h = isset($settings['b_flip_h']) ? $settings['b_flip_h'] : '';
			$b_custom_height = isset($settings['b_custom_height']) ? $settings['b_custom_height'] : '50px';
			$bottom_layers = isset($settings['bottom_layers']) ? $settings['bottom_layers'] : '3';
			$bottom_moving_divider_color = isset($settings['bottom_moving_divider_color']) ? $settings['bottom_moving_divider_color'] : '';

			if ($settings['bottom_divider_select'] !== 'dynamic') {
				$b_divider_opts = array(
					'd_divider_select'			=> $settings['bottom_divider_select'],
					'd_layers'					=> $bottom_layers,
					'd_1_is_gradient'			=> '',
					'd_1_color'					=> $b_1_color,
					'd_2_is_gradient'			=> '',
					'd_2_color'					=> $b_2_color,
					'd_2_animation'				=> $b_2_animation,
					'd_2_delay'					=> $b_2_delay,
					'd_3_is_gradient'			=> '',
					'd_3_color'					=> '',
					'd_3_color_2'				=> '',
					'd_3_animation'				=> $b_3_animation,
					'd_3_delay'					=> $b_3_delay,
					'd_high_index'				=> $b_divider_in_front,
					'd_flip_h'					=> $b_flip_h,
				);
				$divider_out .= pix_get_divider($settings['bottom_divider_select'], '#fff', 'bottom', false, $bottom_moving_divider_color, $b_divider_opts, $b_custom_height);
			} else {
				// Dynamic divider
				$b_divider_opts = array(
					'd_divider_select'			=> $settings['bottom_divider_select'],
					'd_high_index'				=> $b_divider_in_front,
					'd_flip_h'					=> $b_flip_h,
				);
				$divider_out .= pix_get_divider($settings['bottom_divider_select'], '#fff', 'bottom', false, $bottom_moving_divider_color, $b_divider_opts, $b_custom_height);
			}
		}

		// Prepare attributes for blog item rendering
		$attr = array(
			'blog_style' => $settings['blog_style'],
			'blog_size' => $settings['blog_size'],
			'blog_style_box' => $settings['blog_style_box'] === 'true',
			'rounded_img' => $settings['rounded_img'],
			'style' => $settings['style'],
			'hover_effect' => $settings['hover_effect'],
			'add_hover_effect' => $settings['add_hover_effect'],
			'animation' => $settings['animation'],
			'delay' => $settings['delay'],
			'title_color' => $settings['title_color'],
			'title_custom_color' => isset($settings['title_custom_color']) ? $settings['title_custom_color'] : '',
			'text_color' => $settings['text_color'],
			'text_custom_color' => isset($settings['text_custom_color']) ? $settings['text_custom_color'] : '',
			'bg_color' => $settings['bg_color'],
			'custom_bg_color' => isset($settings['custom_bg_color']) ? $settings['custom_bg_color'] : '',
			'meta_bg_color' => $settings['meta_bg_color'],
			'meta_custom_bg_color' => isset($settings['meta_custom_bg_color']) ? $settings['meta_custom_bg_color'] : '',
			// Include divider parameters for the blog item function
			'bottom_divider_select' => $settings['bottom_divider_select'],
			'bottom_moving_divider_color' => isset($settings['bottom_moving_divider_color']) ? $settings['bottom_moving_divider_color'] : '',
			'bottom_layers' => isset($settings['bottom_layers']) ? $settings['bottom_layers'] : '3',
			'b_1_color' => isset($settings['b_1_color']) ? $settings['b_1_color'] : '#fff',
			'b_2_color' => isset($settings['b_2_color']) ? $settings['b_2_color'] : 'rgba(255,255,255,0.8)',
			'b_2_animation' => isset($settings['b_2_animation']) ? $settings['b_2_animation'] : 'fade-in-up',
			'b_2_delay' => isset($settings['b_2_delay']) ? $settings['b_2_delay'] : '300',
			'b_3_animation' => isset($settings['b_3_animation']) ? $settings['b_3_animation'] : 'fade-in-up',
			'b_3_delay' => isset($settings['b_3_delay']) ? $settings['b_3_delay'] : '400',
			'b_divider_in_front' => isset($settings['b_divider_in_front']) ? $settings['b_divider_in_front'] : 'true',
			'b_flip_h' => isset($settings['b_flip_h']) ? $settings['b_flip_h'] : '',
		);

		$col = 12 / $settings['items_count'];

		echo '<div class="row pix-archive-posts-wrapper">';
		include_once(PIXFORT_PLUGIN_DIR . 'includes/elements/extras/blog-functions.php');
		while ($query->have_posts()) {
			echo '<div class="col-xs-12 col-md-' . $col . ' pix-mb-40">';
			echo pix_blog_item($query, $attr, $divider_out);
			echo '</div>';
		}

		echo '</div>';

		wp_reset_postdata();
	}

	private function render_pagination($query) {
		$prevIcon = 'Line/pixfort-icon-arrow-left-2';
		$nextIcon = 'Line/pixfort-icon-arrow-right-2';
		if (is_rtl()) {
			$prevIcon = 'Line/pixfort-icon-arrow-right-2';
			$nextIcon = 'Line/pixfort-icon-arrow-left-2';
		}

		echo '<div class="pix-pagination d-sm-flex pix-mt-20 w-100 justify-content-center align-items-center">';
		echo paginate_links(array(
			'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
			'total' => $query->max_num_pages,
			'current' => max(1, get_query_var('paged'), get_query_var('page')),
			'format' => '?paged=%#%',
			'show_all' => false,
			'type' => 'plain',
			'end_size' => 2,
			'mid_size' => 1,
			'prev_next' => true,
			'prev_text' => '<span class="d-sm-flex justify-content-center align-items-center">' . \PixfortCore::instance()->icons->getIcon($prevIcon) . '</span>',
			'next_text' => '<span class="d-sm-flex justify-content-center align-items-center">' . \PixfortCore::instance()->icons->getIcon($nextIcon) . '</span>',
			'add_args' => false,
			'add_fragment' => '',
		));
		echo '</div>';
	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-blog-handle'];
		return [];
	}
}
