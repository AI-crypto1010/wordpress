<?php

namespace Elementor;

class Pix_Eor_Vertical_Tabs extends Widget_Base {

	public function __construct($data = [], $args = null) {
		$data = \PixfortCore::instance()->icons->verifyElementorData($data, true, 'items');
		parent::__construct($data, $args);

		wp_register_script('pix-text-tabs-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/tabs.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
	}

	public function get_name() {
		return 'pix-vertical-tabs';
	}

	public function get_title() {
		return 'Vertical Tabs';
	}

	public function get_icon() {
		return 'eicon-thumbnails-right pixfort-elementor-element pixfort-elementor-tabs-vertical';
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
			'badge_text',
			[
				'label' => __('Badge text', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Badge text', 'pixfort-core'),
				'default' => '',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'title',
			[
				'label' => __('Title', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Title text', 'pixfort-core'),
				'default' => '',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$this->add_control(
			'text_content',
			[
				'label' => __('Content', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __('', 'pixfort-core'),
				'default' => '',
				'dynamic'     => array(
					'active'  => true
				),
			]
		);


		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'title',
			[
				'label' => __('Title', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'label_block' => true,
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$repeater->add_control(
			'media_type',
			[
				'label' => __('Use Icon', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'icon',
				'default' => '',
			]
		);
		$repeater->add_control(
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



		$repeater->add_control(
			'content_type',
			[
				'label' => __('Content type', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''			=> 'Default (Text editor)',
					'template'			=> 'Elementor Template'
				),
			]
		);
		$results = [];

		$results[] = esc_html__('Choose Template', 'pixfort-core');

		$posts = get_posts(array(
			'posts_per_page'	=> -1,
			'post_type'	=> 'elementor_library'
		));

		foreach ($posts as $post) {
			$document = \Elementor\plugin::instance()->documents->get($post->ID);
			if ($document) {
				$text = esc_html($post->post_title) . ' (' . $document->get_post_type_title() . ')';
				$results[$post->ID] = $text;
				$resultsURLs[$post->ID] = $document->get_edit_url();
			}
		}

		$repeater->add_control(
			'pix_template_id',
			[
				'label' => esc_html__('Choose Template', 'pixfort-core'),
				'type' => \Elementor\CustomControl\Pix_Template_Control::PixTemplateSelector,
				'default' => '',
				'options' => $results,
				'condition' => [
					'content_type' => 'template',
				],
				'separator' => 'after',
			]
		);
		$repeater->add_control(
			'content',
			[
				'label' => __('Content', 'pixfort-core'),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __('', 'pixfort-core'),
				'condition' => [
					'content_type!' => 'template',
				],
			]
		);





		$repeater->add_control(
			'transition',
			[
				'label' => __('Transition', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''			=> 'None',
					'fade'			=> 'Fade',
					'fade-left'			=> 'Fade Left',
					'fade-right'		=> 'Fade Right',
					'fade-up' 		=> 'Fade Up',
					'fade-down' 		=> 'Fade Down',
				),
			]
		);
		$this->add_control(
			'items',
			[
				'label' => __('Items', 'pixfort-core'),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ title }}}',
				'fields' => $repeater->get_controls()
			]
		);

		$this->add_control(
			'is_sticky',
			[
				'label' => __('Sticky content', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'sticky-top',
				'default' => '',
			]
		);
		$this->add_control(
			'menu_position',
			[
				'label' => __('Menu Position', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array_flip(array(
					__('Start', 'pixfort-core') 	=> 'left',
					__('End', 'pixfort-core')	    => 'right'
				)),
				'default' => 'left',
			]
		);





		$this->add_control(
			'tabs_style',
			[
				'label' => __('Style', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'pix-pills-1'		=> 'Default (Gradient)',
					'pix-pills-solid'			=> 'Solid',
					'pix-pills-light'			=> 'Light',
					'pix-pills-outline'			=> 'Outline',
					'pix-pills-line'			=> 'Line',
					'pix-pills-round'			=> 'Round',
					'pix-pills-lines'			=> 'Lines',
				),
				'default' => 'pix-pills-1',
			]
		);
		$this->add_control(
			'padding_menu',
			[
				'label' => __('Padding before menu', 'pixfort-core'),
				'label_block' => false,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Please input the value (with the unit: px,.. etc).', 'pixfort-core'),
				'default' => '',
			]
		);

		$this->add_control(
			'tabs_content_align',
			[
				'label' => __('Content align', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''		=> 'Default (inherit from parent element)',
					'text-left'			=> 'Start',
					'text-center'			=> 'Center',
					'text-right'			=> 'End',
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

		$this->add_control(
			'el_class',
			[
				'label' => __('Extra class names', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'default' => '',
			]
		);



		$this->end_controls_section();





		$this->start_controls_section(
			'section_badge',
			[
				'label' => __('Badge Style', 'pixfort-core'),
			]
		);


		$this->add_control(
			'badge_bold',
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
			'badge_italic',
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
			'badge_secondary_font',
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
			'badge_text_color',
			[
				'label' => __('Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'primary',
			]
		);
		$this->add_control(
			'badge_text_custom_color',
			[
				'label' => __('Custom Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'text_color' => 'custom',
				],
			]
		);
		$this->add_control(
			'badge_bg_color',
			[
				'label' => __('Background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
				'default' => 'primary-light',
			]
		);
		$this->add_control(
			'badge_custom_bg_color',
			[
				'label' => __('Custom Background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'badge_bg_color' => 'custom',
				],
			]
		);
		$this->add_control(
			'badge_text_size',
			[
				'label' => __('Text size', 'pixfort-core'),
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
			'badge_text_custom_size',
			[
				'label' => __('Custom Text size', 'pixfort-core'),
				'label_block' => false,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter custom title size', 'pixfort-core'),
				'default' => '',
				'condition' => [
					'badge_text_size' => 'custom',
				],
			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'section_tabs_title_text',
			[
				'label' => __('Title Style', 'pixfort-core'),
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
				'label' => __('Custom Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'title_color' => 'custom',
				],
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
				'default' => 'h4',
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
			'padding_title',
			[
				'label' => __('Padding before title', 'pixfort-core'),
				'label_block' => false,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Please input the value (with the unit: px,.. etc).', 'pixfort-core'),
				'default' => '',
			]
		);


		$this->end_controls_section();




		$this->start_controls_section(
			'section_tabs_content_text',
			[
				'label' => __('Content Style', 'pixfort-core'),
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __('Content color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'body-default',
				'selectors' => [
					'{{WRAPPER}} .tab-pane, {{WRAPPER}} .tab-pane p' => 'color: var(--pix-{{VALUE}})',
				],
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
				'selectors' => [
					'{{WRAPPER}} .tab-pane, {{WRAPPER}} .tab-pane p' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'content_size',
			[
				'label' => __('Content size', 'pixfort-core'),
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
			'position',
			[
				'label' => __('Position', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'text-left'			=> 'Left',
					'text-center'		=> 'Center',
					'text-right' 		=> 'Right',
				),
				'default' => 'text-left',
			]
		);

		$this->add_control(
			'padding_content',
			[
				'label' => __('Padding before Content', 'pixfort-core'),
				'label_block' => false,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Please input the value (with the unit: px,.. etc).', 'pixfort-core'),
				'default' => '',
			]
		);


		$this->end_controls_section();




		$this->start_controls_section(
			'section_tabs_title',
			[
				'label' => __('Tabs Title', 'pixfort-core'),
			]
		);

		// Title format
		$this->add_control(
			'tabs_bold',
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
			'tabs_italic',
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
			'tabs_secondary_font',
			[
				'label' => __('Secondary font', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'secondary-font',
				'default' => '',
			]
		);




		$this->end_controls_section();





		$this->start_controls_section(
			'section_element_style',
			[
				'label' => __('Inactive Items Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tabs_text_typography',
				'selector' => '{{WRAPPER}} .nav-item a:not(.active)',
			]
		);

		$this->add_responsive_control(
			'tabs_custom_colors',
			[
				'label' => __('Custom Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-item a:not(.active)' => 'color: {{VALUE}};',
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'tabs_text_shadow',
				'selector' => '{{WRAPPER}} .nav-item a:not(.active)',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_element_active_style',
			[
				'label' => __('Active Item Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tabs_active_typography',
				'selector' => '{{WRAPPER}} .nav-item a.active',
			]
		);

		$this->add_responsive_control(
			'tabs_active_custom_colors',
			[
				'label' => __('Custom Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-item a.active' => 'color: {{VALUE}};',
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'tabs_active_shadow',
				'selector' => '{{WRAPPER}} .nav-item a.active',
			]
		);

		$this->add_responsive_control(
			'tabs_active_custom_bg',
			[
				'label' => __('Custom Background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .nav-item a.active' => 'background: {{VALUE}};',
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);


		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$settings['el_id'] = $this->get_id();
		echo \PixfortCore::instance()->elementsManager->renderElement('TabsVText', $settings);
	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-text-tabs-handle'];
		return [];
	}
}
