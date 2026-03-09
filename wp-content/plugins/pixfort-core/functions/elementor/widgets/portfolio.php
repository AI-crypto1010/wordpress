<?php

namespace Elementor;

class Pix_Eor_Portfolio extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_script('pix-portfolio-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/portfolio.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
	}

	public function get_name() {
		return 'pix-portfolio';
	}

	public function get_title() {
		return 'Portfolio';
	}

	public function get_icon() {
		return 'eicon-gallery-masonry pixfort-elementor-element pixfort-elementor-portfolio';
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
			'portfolio_style',
			[
				'label' => __('Style', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip(array(
					"Default" 	    => '',
					"Mini" 	        => 'mini',
					"Transparent" 	=> 'transparent',
					"3D"        	=> '3d',
				)),
			]
		);

		$this->add_control(
			'count',
			[
				'label' => __('Count', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Number of posts to show', 'pixfort-core'),
				'default' => '6',
			]
		);


		$this->add_control(
			'line_count',
			[
				'label' => __('Items per line', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					"6" 	    => "2 items",
					"4" 	    => "3 items",
					"3" 	    => "4 items",
					"2"        	=> "6 items",
				],
			]
		);
		$this->add_control(
			'category',
			[
				'label' => __('Category', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Portfolio Category slug', 'pixfort-core'),
				'default' => '',
			]
		);


		$this->add_control(
			'orderby',
			[
				'label' => __('Order by', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'			=> 'Date',
					'menu_order' 	=> 'Menu order',
					'title'			=> 'Title',
					'rand'			=> 'Random',
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
					'DESC' 	=> 'Descending',
					'ASC' 	=> 'Ascending',
				],
			]
		);

		$this->add_control(
			'filters',
			[
				'label' => __('Show Filters', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => 'true',

			]
		);
		$this->add_control(
			'filter_light',
			[
				'label' => __('Light filter buttons color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'is-dark',
				'default' => '',

			]
		);
		$this->add_control(
			'filters_align',
			[
				'label' => __('Filters Align', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'center'			=> 'Center',
					'left'			=> 'Start',
					'right'			=> 'End',
				],
			]
		);
		$this->add_control(
			'full_size_img',
			[
				'label' => __('Display full size images', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
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
			'pagination',
			[
				'label' => __('Show Pagination', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 1,
				'default' => 0,

			]
		);



		// Styling
		$this->add_control(
			'title_color',
			[
				'label' => __('Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'heading-default',
				'condition' => [
					'portfolio_style' => array('transparent', "3d")
				],
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
			]
		);


		$this->add_control(
			'overlay_color',
			[
				'label' => __('Overlay color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'black',
				'condition' => [
					'portfolio_style' => '3d',
				],
			]
		);
		$this->add_control(
			'custom_overlay_color',
			[
				'label' => __('content_custom_color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'overlay_color' => 'custom',
				],
			]
		);




		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('Portfolio', $settings);
	}


	public function get_script_depends() {

		if (is_user_logged_in()) return ['pix-global', 'pix-portfolio-handle'];
		return [];
	}
}
