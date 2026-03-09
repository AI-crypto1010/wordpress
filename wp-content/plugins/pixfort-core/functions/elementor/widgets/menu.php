<?php

namespace Elementor;

class Pix_Eor_Menu extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		if (is_user_logged_in()) {
			wp_enqueue_style(
				'pixfort-menu-style',
				PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/menu.min.css',
				false,
				PIXFORT_PLUGIN_VERSION,
				'all'
			);
		}
	}

	public function get_name() {
		return 'pix-menu';
	}

	public function get_title() {
		return 'Menu';
	}

	public function get_icon() {
		return 'eicon-nav-menu pixfort-elementor-element pixfort-elementor-menu';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_menu_content',
			[
				'label' => __('Content', 'pixfort-core'),
			]
		);

		$menus = wp_get_nav_menus();
		$menus_list = [];

		foreach ($menus as $menu) {
			$menus_list[$menu->term_id] = $menu->name;
		}

		if (empty($menus_list)) {
			$this->add_control(
				'no_menus_notice',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => __('No WordPress menus found. Please create one in Appearance > Menus.', 'pixfort-core'),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}

		$this->add_control(
			'menu',
			[
				'label' => __('Menu', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'options' => $menus_list,
				'default' => !empty($menus_list) ? (string) array_key_first($menus_list) : '',
			]
		);

		$this->add_control(
			'menu_layout',
			[
				'label' => __('Layout', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'vertical',
				'options' => [
					'vertical' => __('Vertical (Implemented)', 'pixfort-core'),
					'horizontal' => __('Horizontal (Coming Soon)', 'pixfort-core'),
				],
			]
		);

		$this->add_control(
			'menu_style',
			[
				'label' => __('Style', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __('Default', 'pixfort-core'),
					'line' => __('Line', 'pixfort-core'),
				],
			]
		);

		$this->add_control(
			'submenu_open_current',
			[
				'label' => __('Open Active Submenus', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menu_style',
			[
				'label' => __('Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __('Text color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray([
					'defaultValue' => ['' => __('Default', 'pixfort-core')],
					'gradients' => false,
				]),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pix-menu-widget' => '--pix-menu-color: var(--pix-{{VALUE}});',
				],
			]
		);

		$this->add_control(
			'text_custom_color',
			[
				'label' => __('Custom Text color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'text_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-menu-widget' => '--pix-menu-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'active_color',
			[
				'label' => __('Active link color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray([
					'defaultValue' => ['' => __('Default', 'pixfort-core')],
					'gradients' => false,
				]),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pix-menu-widget' => '--pix-menu-title-color: var(--pix-{{VALUE}});',
				],
			]
		);

		$this->add_control(
			'active_custom_color',
			[
				'label' => __('Custom Active link color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'active_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-menu-widget' => '--pix-menu-title-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_bg_color',
			[
				'label' => __('Hover background color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray([
					'bg' => true,
					'transparent' => true,
					'defaultValue' => ['' => __('Default', 'pixfort-core')],
					'gradients' => false,
				]),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pix-menu-widget' => '--pix-menu-widget-hover-background-color: var(--pix-{{VALUE}});',
				],
			]
		);

		$this->add_control(
			'hover_bg_custom_color',
			[
				'label' => __('Custom Hover background color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'hover_bg_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-menu-widget' => '--pix-menu-widget-hover-background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_first_level_items_style',
			[
				'label' => __('First Level Items', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'first_level_bold',
			[
				'label' => __('Bold', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => '700',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pix-menu-widget .pix-menu-depth-0 > .pix-menu-item-row > .pix-menu-link' => 'font-weight: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'first_level_heading_font',
			[
				'label' => __('Heading font', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pix-menu-widget .pix-menu-depth-0 > .pix-menu-item-row > .pix-menu-link' => 'font-family: var(--pix-heading-font);',
				],
			]
		);

		$this->add_control(
			'first_level_text_color',
			[
				'label' => __('Text color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray([
					'defaultValue' => ['' => __('Default', 'pixfort-core')],
					'gradients' => false,
				]),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pix-menu-widget .pix-menu-depth-0 > .pix-menu-item-row > .pix-menu-link' => 'color: var(--pix-{{VALUE}});',
					'{{WRAPPER}} .pix-menu-widget .pix-menu-depth-0 > .pix-menu-item-row > .pix-menu-submenu-toggle' => 'color: var(--pix-{{VALUE}});',
				],
			]
		);

		$this->add_control(
			'first_level_text_custom_color',
			[
				'label' => __('Custom Text color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'first_level_text_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-menu-widget .pix-menu-depth-0 > .pix-menu-item-row > .pix-menu-link' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pix-menu-widget .pix-menu-depth-0 > .pix-menu-item-row > .pix-menu-submenu-toggle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'first_level_typography',
				'label' => __('Typography', 'pixfort-core'),
				'selector' => '{{WRAPPER}} .pix-menu-widget .pix-menu-depth-0 > .pix-menu-item-row > .pix-menu-link',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_nested_items_style',
			[
				'label' => __('Nested Items', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'nested_items_bold',
			[
				'label' => __('Bold', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => '700',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pix-menu-widget .pix-menu-submenu .pix-menu-link' => 'font-weight: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nested_items_heading_font',
			[
				'label' => __('Heading font', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pix-menu-widget .pix-menu-submenu .pix-menu-link' => 'font-family: var(--pix-heading-font);',
				],
			]
		);

		$this->add_control(
			'nested_items_text_color',
			[
				'label' => __('Text color', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray([
					'defaultValue' => ['' => __('Default', 'pixfort-core')],
					'gradients' => false,
				]),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pix-menu-widget .pix-menu-submenu .pix-menu-link' => 'color: var(--pix-{{VALUE}});',
					'{{WRAPPER}} .pix-menu-widget .pix-menu-submenu .pix-menu-item-row > .pix-menu-submenu-toggle' => 'color: var(--pix-{{VALUE}});',
				],
			]
		);

		$this->add_control(
			'nested_items_text_custom_color',
			[
				'label' => __('Custom Text color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'nested_items_text_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pix-menu-widget .pix-menu-submenu .pix-menu-link' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pix-menu-widget .pix-menu-submenu .pix-menu-item-row > .pix-menu-submenu-toggle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'nested_items_typography',
				'label' => __('Typography', 'pixfort-core'),
				'selector' => '{{WRAPPER}} .pix-menu-widget .pix-menu-submenu .pix-menu-link',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('Menu', $settings);
	}

	public function get_script_depends() {
		if (is_user_logged_in()) {
			return ['pix-global'];
		}

		return [];
	}
}
