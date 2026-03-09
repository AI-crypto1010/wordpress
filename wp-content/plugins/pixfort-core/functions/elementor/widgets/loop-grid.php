<?php

namespace Elementor;

class Pix_Eor_Loop_Grid extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_script('pix-loop-grid-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/loop-grid.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
        if (is_user_logged_in()) wp_enqueue_style('pixfort-loop-grid-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/loop-grid.min.css', false, PIXFORT_PLUGIN_VERSION);
	}

	public function get_name() {
		return 'pix-loop-grid';
	}

	public function get_title() {
		return 'Loop Grid';
	}

	public function get_icon() {
		return 'eicon-loop-builder pixfort-elementor-element pixfort-elementor-loop-grid';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	/**
	 * Get available post types for the widget
	 */
	// private function get_post_types() {
	// 	$post_types = get_post_types(['public' => true], 'objects');
	// 	$options = [];
		
	// 	$excluded = ['elementor_library', 'attachment'];
		
	// 	foreach ($post_types as $post_type) {
	// 		if (in_array($post_type->name, $excluded)) {
	// 			continue;
	// 		}
	// 		$options[$post_type->name] = $post_type->label;
	// 	}
		
	// 	return $options;
	// }

	/**
	 * Get template type options
	 */
	private function get_template_types() {
		$options = [
			'post' => __('Posts', 'pixfort-core'),
			'post_taxonomy' => __('Post Taxonomy', 'pixfort-core'),
		];
		
		// Add WooCommerce options if available
		if (class_exists('WooCommerce')) {
			$options['product'] = __('Products', 'pixfort-core');
			$options['product_taxonomy'] = __('Product Taxonomy', 'pixfort-core');
		}
		
		return $options;
	}

	/**
	 * Get source options for Posts template type
	 */
	private function get_post_source_options() {
		$post_types = get_post_types(['public' => true], 'objects');
		$options = [];
		
		$excluded = ['elementor_library', 'e-floating-buttons', 'attachment', 'product', 'pixfort_template', 'pixfooter', 'pixheader', 'pixpopup', 'pixintro'];
		
		foreach ($post_types as $post_type) {
			if (in_array($post_type->name, $excluded)) {
				continue;
			}
			$options[$post_type->name] = $post_type->label;
		}
		
		// Add special query options
		$options['manual_selection'] = __('Manual Selection', 'pixfort-core');
		$options['current_query'] = __('Current Query', 'pixfort-core');
		$options['related'] = __('Related', 'pixfort-core');
		
		return $options;
	}

	/**
	 * Get source options for Products template type
	 */
	private function get_product_source_options() {
		$options = [
			'current_query' => __('Current Query', 'pixfort-core'),
			'latest' => __('Latest Products', 'pixfort-core'),
			'sale' => __('Sale', 'pixfort-core'),
			'featured' => __('Featured', 'pixfort-core'),
			'manual_selection' => __('Manual Selection', 'pixfort-core'),
			'related' => __('Related Products', 'pixfort-core'),
			'upsells' => __('Upsells', 'pixfort-core'),
			'cross_sells' => __('Cross-Sells', 'pixfort-core'),
		];
		
		return $options;
	}

	/**
	 * Get source options for Post Taxonomy template type
	 */
	private function get_post_taxonomy_options() {
		$taxonomies = get_taxonomies(['public' => true, 'show_ui' => true], 'objects');
		$options = [];
		
		// Exclude WooCommerce product taxonomies
		$excluded = ['product_cat', 'product_tag', 'pa_', 'pixpopup-types', 'pixfooter-types', 'pixheader-types', 'pixintro-types', 'pixfort_template_type'];
		
		foreach ($taxonomies as $taxonomy) {
			$is_excluded = false;
			foreach ($excluded as $exclude) {
				if (strpos($taxonomy->name, $exclude) === 0 || $taxonomy->name === $exclude) {
					$is_excluded = true;
					break;
				}
			}
			if (!$is_excluded) {
				$options[$taxonomy->name] = $taxonomy->label;
			}
		}
		
		return $options;
	}

	/**
	 * Get source options for Product Taxonomy template type
	 */
	private function get_product_taxonomy_options() {
		$options = [];
		
		if (class_exists('WooCommerce')) {
			$options['product_cat'] = __('Product categories', 'pixfort-core');
			$options['product_tag'] = __('Product tags', 'pixfort-core');
			
			// Get additional product taxonomies (like Brands)
			$taxonomies = get_object_taxonomies('product', 'objects');
			foreach ($taxonomies as $taxonomy) {
				if (!in_array($taxonomy->name, ['product_cat', 'product_tag', 'product_type', 'product_visibility', 'product_shipping_class']) 
					&& $taxonomy->public && $taxonomy->show_ui) {
					$options[$taxonomy->name] = $taxonomy->label;
				}
			}
		}
		
		return $options;
	}

	private function get_loop_templates_groups() {
        $results = [];
		$pixfortResults = [];
        $elementorResults = [];
		

		$posts = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'elementor_library',
			'meta_query' => [
				[
					'key' => '_elementor_template_type',
					'value' => 'loop-item',
					'compare' => '='
				]
			]
		));

		// If no loop templates found, get all templates
		if (empty($posts)) {
			$posts = get_posts(array(
				'posts_per_page' => -1,
				'post_type' => 'elementor_library'
			));
		}

		foreach ($posts as $post) {
			$document = \Elementor\Plugin::instance()->documents->get($post->ID);
			if ($document) {
				$text = esc_html($post->post_title) . ' (' . $document->get_post_type_title() . ')';
				$elementorResults[$post->ID] = $text;
			}
		}
		
		// Get pixfort_template templates with 'template' type
		$pixfort_templates = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'pixfort_template',
			'tax_query' => array(
				array(
					'taxonomy' => 'pixfort_template_type',
					'field' => 'slug',
					'terms' => 'template',
				),
			),
		));
		
		foreach ($pixfort_templates as $post) {
			$document = \Elementor\Plugin::instance()->documents->get($post->ID);
			if ($document) {
				$text = esc_html($post->post_title) . ' (' . __('pixfort Template', 'pixfort-core') . ')';
				$pixfortResults[$post->ID] = $text;
			}
		}

        $results['pixfort_templates'] = [
            'label' => __('pixfort Templates', 'pixfort-core'),
            'options' => $pixfortResults
        ];
        $results['elementor_templates'] = [
            'label' => __('Elementor Templates', 'pixfort-core'),
            'options' => $elementorResults
        ];

		return $results;
    }

	protected function register_controls() {

		// Layout Section
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __('Layout', 'pixfort-core'),
			]
		);

	


		$this->add_control(
			'template_id',
			[
				'label' => __('Choose a template', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'type' => \Elementor\CustomControl\Pix_Template_Control::PixTemplateSelector,
				'groups' => $this->get_loop_templates_groups(),
				'default' => '',
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __('Columns', 'pixfort-core'),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 12,
				'default' => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'selectors' => [
					'{{WRAPPER}} .pix-loop-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);--pix-loop-grid-columns: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __('Items Per Page', 'pixfort-core'),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'default' => 8,
			]
		);

		// $this->add_control(
		// 	'masonry',
		// 	[
		// 		'label' => __('Masonry', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'label_on' => __('On', 'pixfort-core'),
		// 		'label_off' => __('Off', 'pixfort-core'),
		// 		'return_value' => 'yes',
		// 		'default' => '',
		// 	]
		// );

		$this->add_control(
			'equal_height',
			[
				'label' => __('Equal height', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('On', 'pixfort-core'),
				'label_off' => __('Off', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
				// 'condition' => [
				// 	'masonry!' => 'yes',
				// ],
				'selectors' => [
					'{{WRAPPER}} .pix-loop-grid-item' => 'height: 100%;',
					'{{WRAPPER}} .pix-loop-grid-item > .elementor' => 'height: 100%;',
					'{{WRAPPER}} .pix-loop-grid-item > .elementor > .elementor-inner' => 'height: 100%;',
					'{{WRAPPER}} .pix-loop-grid-item > .elementor > .elementor-element' => 'height: 100%;',
					'{{WRAPPER}} .pix-loop-grid-item > .elementor > .elementor-inner > .elementor-section-wrap' => 'height: 100%;',
				],
			]
		);

		// $this->add_control(
		// 	'alternate_template',
		// 	[
		// 		'label' => __('Apply an alternate template', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'label_on' => __('On', 'pixfort-core'),
		// 		'label_off' => __('Off', 'pixfort-core'),
		// 		'return_value' => 'yes',
		// 		'default' => '',
		// 	]
		// );

		// $this->add_control(
		// 	'alternate_template_id',
		// 	[
		// 		'label' => esc_html__('Choose alternate template', 'pixfort-core'),
		// 		'type' => \Elementor\CustomControl\Pix_Template_Control::PixTemplateSelector,
		// 		'default' => '',
		// 		'options' => $this->get_loop_templates(),
		// 		'condition' => [
		// 			'alternate_template' => 'yes',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'alternate_position',
		// 	[
		// 		'label' => __('Alternate template position', 'pixfort-core'),
		// 		'type' => Controls_Manager::NUMBER,
		// 		'min' => 1,
		// 		'max' => 100,
		// 		'default' => 1,
		// 		'description' => __('Position of the alternate template in the grid (1 = first item)', 'pixfort-core'),
		// 		'condition' => [
		// 			'alternate_template' => 'yes',
		// 		],
		// 	]
		// );

		$this->add_control(
			'animation',
			[
				'label' => __('Items Animation', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => pix_get_animations(true),
			]
		);

		$this->add_control(
			'animation_delay',
			[
				'label' => __('Items Animation Delay (in milliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('100', 'pixfort-core'),
				'placeholder' => __('Delay between each item animation', 'pixfort-core'),
				'condition' => [
					'animation!' => '',
				],
			]
		);

		$this->end_controls_section();

		// Query Section
		$this->start_controls_section(
			'section_query',
			[
				'label' => __('Query', 'pixfort-core'),
			]
		);

		$this->add_control(
			'template_type',
			[
				'label' => __('Choose template type', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => $this->get_template_types(),
			]
		);

		// Source for Posts template type
		$this->add_control(
			'source',
			[
				'label' => __('Source', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => $this->get_post_source_options(),
				'condition' => [
					'template_type' => 'post',
				],
			]
		);

		// Source for Products template type
		$this->add_control(
			'source_product',
			[
				'label' => __('Source', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'latest',
				'options' => $this->get_product_source_options(),
				'condition' => [
					'template_type' => 'product',
				],
			]
		);

		// Source for Post Taxonomy template type
		$this->add_control(
			'source_post_taxonomy',
			[
				'label' => __('Source', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'category',
				'options' => $this->get_post_taxonomy_options(),
				'condition' => [
					'template_type' => 'post_taxonomy',
				],
			]
		);

		// Source for Product Taxonomy template type
		$this->add_control(
			'source_product_taxonomy',
			[
				'label' => __('Source', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'product_cat',
				'options' => $this->get_product_taxonomy_options(),
				'condition' => [
					'template_type' => 'product_taxonomy',
				],
			]
		);

		// Manual selection control for posts
		$this->add_control(
			'manual_selection_post_ids',
			[
				'label' => __('Search & Select', 'pixfort-core'),
				'type' => \Elementor\CustomControl\Pix_Query_Search_Control::PixQuerySearch,
				'object_type' => 'post',
				'label_block' => true,
				'multiple' => true,
				'condition' => [
					'template_type' => 'post',
					'source' => 'manual_selection',
				],
			]
		);

		// Manual selection control for products
		$this->add_control(
			'manual_selection_product_ids',
			[
				'label' => __('Search & Select', 'pixfort-core'),
				'type' => \Elementor\CustomControl\Pix_Query_Search_Control::PixQuerySearch,
				'object_type' => 'product',
				'label_block' => true,
				'multiple' => true,
				'condition' => [
					'template_type' => 'product',
					'source_product' => 'manual_selection',
				],
			]
		);

		// Filter by option for post taxonomy
		$this->add_control(
			'taxonomy_filter_by',
			[
				'label' => __('Filter By', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __('Show All', 'pixfort-core'),
					'manual' => __('Manual Selection', 'pixfort-core'),
					'by_parent' => __('By Parent', 'pixfort-core'),
				],
				'condition' => [
					'template_type' => ['post_taxonomy', 'product_taxonomy'],
				],
			]
		);

		// Manual selection for post taxonomy terms
		$this->add_control(
			'taxonomy_term_ids',
			[
				'label' => __('Terms', 'pixfort-core'),
				'type' => \Elementor\CustomControl\Pix_Query_Search_Control::PixQuerySearch,
				'object_type' => 'taxonomy',
				'label_block' => true,
				'multiple' => true,
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'template_type',
							'operator' => 'in',
							'value' => ['post_taxonomy', 'product_taxonomy'],
						],
						[
							'name' => 'taxonomy_filter_by',
							'operator' => '===',
							'value' => 'manual',
						],
					],
				],
			]
		);

		// Parent term selection
		$this->add_control(
			'taxonomy_parent_term_id',
			[
				'label' => __('Parent', 'pixfort-core'),
				'type' => \Elementor\CustomControl\Pix_Query_Search_Control::PixQuerySearch,
				'object_type' => 'taxonomy',
				'label_block' => true,
				'multiple' => false,
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'template_type',
							'operator' => 'in',
							'value' => ['post_taxonomy', 'product_taxonomy'],
						],
						[
							'name' => 'taxonomy_filter_by',
							'operator' => '===',
							'value' => 'by_parent',
						],
					],
				],
			]
		);

		// Taxonomy orderby
		$this->add_control(
			'taxonomy_orderby',
			[
				'label' => __('Order By', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'name',
				'options' => [
					'name' => __('Name', 'pixfort-core'),
					'slug' => __('Slug', 'pixfort-core'),
					'term_id' => __('Term ID', 'pixfort-core'),
					'count' => __('Count', 'pixfort-core'),
					'menu_order' => __('Menu Order', 'pixfort-core'),
				],
				'condition' => [
					'template_type' => ['post_taxonomy', 'product_taxonomy'],
				],
			]
		);

		// Taxonomy order
		$this->add_control(
			'taxonomy_order',
			[
				'label' => __('Order', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => __('DESC', 'pixfort-core'),
					'ASC' => __('ASC', 'pixfort-core'),
				],
				'condition' => [
					'template_type' => ['post_taxonomy', 'product_taxonomy'],
				],
			]
		);

		// Hide empty terms
		$this->add_control(
			'taxonomy_hide_empty',
			[
				'label' => __('Hide Empty', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'template_type' => ['post_taxonomy', 'product_taxonomy'],
				],
			]
		);

		$this->start_controls_tabs(
			'query_tabs',
			[
				'condition' => [
					'template_type' => ['post', 'product'],
				],
			]
		);

		// Include Tab
		$this->start_controls_tab(
			'tab_include',
			[
				'label' => __('Include', 'pixfort-core'),
			]
		);

		$this->add_control(
			'include_by',
			[
				'label' => __('Include By', 'pixfort-core'),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => [
					'terms' => __('Term', 'pixfort-core'),
					'authors' => __('Author', 'pixfort-core'),
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'include_term_ids',
			[
				'label' => __('Terms', 'pixfort-core'),
				'type' => \Elementor\CustomControl\Pix_Query_Search_Control::PixQuerySearch,
				'object_type' => 'taxonomy',
				'label_block' => true,
				'multiple' => true,
				'condition' => [
					'include_by' => 'terms',
				],
			]
		);

		$this->add_control(
			'include_author_ids',
			[
				'label' => __('Authors', 'pixfort-core'),
				'type' => \Elementor\CustomControl\Pix_Query_Search_Control::PixQuerySearch,
				'object_type' => 'author',
				'label_block' => true,
				'multiple' => true,
				'condition' => [
					'include_by' => 'authors',
				],
			]
		);

		$this->end_controls_tab();

		// Exclude Tab
		$this->start_controls_tab(
			'tab_exclude',
			[
				'label' => __('Exclude', 'pixfort-core'),
			]
		);

		$this->add_control(
			'exclude_by',
			[
				'label' => __('Exclude By', 'pixfort-core'),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => [
					'current_post' => __('Current Post', 'pixfort-core'),
					'terms' => __('Term', 'pixfort-core'),
					'authors' => __('Author', 'pixfort-core'),
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'exclude_term_ids',
			[
				'label' => __('Terms', 'pixfort-core'),
				'type' => \Elementor\CustomControl\Pix_Query_Search_Control::PixQuerySearch,
				'object_type' => 'taxonomy',
				'label_block' => true,
				'multiple' => true,
				'condition' => [
					'exclude_by' => 'terms',
				],
			]
		);

		$this->add_control(
			'exclude_author_ids',
			[
				'label' => __('Authors', 'pixfort-core'),
				'type' => \Elementor\CustomControl\Pix_Query_Search_Control::PixQuerySearch,
				'object_type' => 'author',
				'label_block' => true,
				'multiple' => true,
				'condition' => [
					'exclude_by' => 'authors',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'query_separator',
			[
				'type' => Controls_Manager::DIVIDER,
				'condition' => [
					'template_type' => ['post', 'product'],
				],
			]
		);

		$this->add_control(
			'date_filter',
			[
				'label' => __('Date', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __('All', 'pixfort-core'),
					'past_day' => __('Past Day', 'pixfort-core'),
					'past_week' => __('Past Week', 'pixfort-core'),
					'past_month' => __('Past Month', 'pixfort-core'),
					'past_quarter' => __('Past Quarter', 'pixfort-core'),
					'past_year' => __('Past Year', 'pixfort-core'),
					'custom' => __('Custom', 'pixfort-core'),
				],
				'condition' => [
					'template_type' => ['post', 'product'],
				],
			]
		);

		$this->add_control(
			'date_before',
			[
				'label' => __('Before', 'pixfort-core'),
				'type' => Controls_Manager::DATE_TIME,
                'description' => __('Setting a ‘Before’ date will show all the posts published until the chosen date (inclusive).', 'pixfort-core'),
				'label_block' => false,
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'template_type',
							'operator' => 'in',
							'value' => ['post', 'product'],
						],
						[
							'name' => 'date_filter',
							'operator' => '===',
							'value' => 'custom',
						],
					],
				],
			]
		);

		$this->add_control(
			'date_after',
			[
				'label' => __('After', 'pixfort-core'),
				'type' => Controls_Manager::DATE_TIME,
                'description' => __('Setting an ‘After’ date will show all the posts published since the chosen date (inclusive).', 'pixfort-core'),
				'label_block' => false,
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'template_type',
							'operator' => 'in',
							'value' => ['post', 'product'],
						],
						[
							'name' => 'date_filter',
							'operator' => '===',
							'value' => 'custom',
						],
					],
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __('Order By', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => __('Date', 'pixfort-core'),
					'title' => __('Title', 'pixfort-core'),
					'menu_order' => __('Menu Order', 'pixfort-core'),
					'rand' => __('Random', 'pixfort-core'),
					'comment_count' => __('Comment Count', 'pixfort-core'),
					'modified' => __('Last Modified', 'pixfort-core'),
				],
				'condition' => [
					'template_type' => ['post', 'product'],
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __('Order', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => __('DESC', 'pixfort-core'),
					'ASC' => __('ASC', 'pixfort-core'),
				],
				'condition' => [
					'template_type' => ['post', 'product'],
				],
			]
		);

		$this->add_control(
			'ignore_sticky_posts',
			[
				'label' => __('Ignore Sticky Posts', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
				'description' => __('Sticky-posts ordering is visible on frontend only', 'pixfort-core'),
				'condition' => [
					'template_type' => 'post',
				],
			]
		);

		$this->add_control(
			'offset',
			[
				'label' => __('Offset', 'pixfort-core'),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'default' => 0,
				'description' => __('Number of posts to skip', 'pixfort-core'),
				'condition' => [
					'template_type' => ['post', 'product'],
				],
			]
		);

		$this->add_control(
			'query_id',
			[
				'label' => __('Query ID', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => __('Give your Query a custom unique id to allow server side filtering', 'pixfort-core'),
			]
		);

		$this->end_controls_section();

		// Pagination Section
		$this->start_controls_section(
			'section_pagination',
			[
				'label' => __('Pagination', 'pixfort-core'),
			]
		);

		$this->add_control(
			'pagination_type',
			[
				'label' => __('Pagination', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __('None', 'pixfort-core'),
					'numbers' => __('Numbers', 'pixfort-core'),
					// 'prev_next' => __('Previous/Next', 'pixfort-core'),
					'numbers_and_prev_next' => __('Numbers + Previous/Next', 'pixfort-core'),
					'load_more' => __('Load More', 'pixfort-core'),
					'infinite_scroll' => __('Infinite Scroll', 'pixfort-core'),
				],
			]
		);

		$this->add_control(
			'load_more_text',
			[
				'label' => __('Load More Text', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('Load More', 'pixfort-core'),
				'condition' => [
					'pagination_type' => 'load_more',
				],
			]
		);

		$this->end_controls_section();

		// Additional Options Section
		$this->start_controls_section(
			'section_additional',
			[
				'label' => __('Additional Options', 'pixfort-core'),
			]
		);

		// $this->add_control(
		// 	'nothing_found_message',
		// 	[
		// 		'label' => __('Nothing Found Message', 'pixfort-core'),
		// 		'type' => Controls_Manager::TEXT,
		// 		'default' => __('No posts found.', 'pixfort-core'),
		// 		'label_block' => true,
		// 	]
		// );

		$this->add_control(
			'nothing_found_message',
			[
				'label' => esc_html__('Nothing Found Message', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__('No posts found', 'pixfort-core'),
				'placeholder' => esc_html__('No posts found', 'pixfort-core'),
			]
		);

		$this->end_controls_section();

		// Style Tab - Layout Section
		$this->start_controls_section(
			'section_style_layout',
			[
				'label' => __('Layout', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => __('Gap between columns', 'pixfort-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
					'rem' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 22,
				],
				'selectors' => [
					'{{WRAPPER}} .pix-loop-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label' => __('Gap between rows', 'pixfort-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
					'rem' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .pix-loop-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab - Pagination Section
		$this->start_controls_section(
			'section_style_pagination',
			[
				'label' => __('Pagination', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pagination_type!' => '',
				],
			]
		);

		$this->add_control(
			'pagination_align',
			[
				'label' => __('Alignment', 'pixfort-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __('Start', 'pixfort-core'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'pixfort-core'),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __('End', 'pixfort-core'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .pix-loop-grid-pagination' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_spacing',
			[
				'label' => __('Spacing', 'pixfort-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .pix-loop-grid-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab - Load More Button Section
		$this->start_controls_section(
			'section_style_load_more',
			[
				'label' => __('Load More Button', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pagination_type' => 'load_more',
				],
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
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultColors' => false, 'mainLight' => true, 'custom' => false]),
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
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => ['' => __('Default', 'pixfort-core')], 'mainLight' => true]),
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
				'label' => __('Button shadow', 'pixfort-core'),
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
				'label' => esc_html__('Button Icon', 'pixfort-core'),
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
					'text-center'         => 'Center',
					'text-left'         => 'Left',
					'text-right'         => 'Right',
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
				'label' => __('Button align', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'text-center'         => 'Center',
					'text-left'         => 'Left',
					'text-right'         => 'Right',
				),
				'default' => 'text-center',
				'condition' => [
					'btn_full!' => 'yes',
				],
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
	
		$this->add_control(
			'btn_extra_classes',
			[
				'label' => __('Extra Classes', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'default' => '',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('LoopGrid', $settings);
	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-loop-grid-handle'];
		return [];
	}
}
