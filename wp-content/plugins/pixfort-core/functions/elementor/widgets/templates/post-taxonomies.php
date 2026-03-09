<?php

namespace Elementor;

class Pix_Eor_Template_Post_Taxonomies extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-template-post-taxonomies';
	}

	public function get_title() {
		return 'Post Categories & Tags';
	}

	public function get_icon() {
		return 'eicon-tags pixfort-elementor-element pixfort-elementor-post-taxonomies';
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

		// Check if template type is "post", "page", "product", or "template"
		$terms = get_the_terms($post_id, 'pixfort_template_type');
		if ($terms && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				if ($term->slug === 'post' || $term->slug === 'page' || $term->slug === 'product' || $term->slug === 'template') {
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

		// Get all available public taxonomies
		$taxonomies = get_taxonomies([
			'public' => true,
			'show_ui' => true,
		], 'objects');

		$taxonomy_options = [];
		$excluded_taxonomies = ['pixfort_template_type', 'pixintro-types', 'pixfooter-types', 'pixpopup-types'];
		foreach ($taxonomies as $taxonomy) {
			// Exclude pixfort internal taxonomies
			if (in_array($taxonomy->name, $excluded_taxonomies)) {
				continue;
			}
			$taxonomy_options[$taxonomy->name] = $taxonomy->label;
		}

		$this->add_control(
			'taxonomy_type',
			[
				'label' => __('Taxonomy Type', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'options' => $taxonomy_options,
				'default' => 'category',
				'description' => __('Select which taxonomy to display.', 'pixfort-core'),
			]
		);

		$this->add_control(
			'max_taxonomies',
			[
				'label' => __('Max Taxonomies', 'pixfort-core'),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
				'max' => 20,
				'description' => __('Maximum number of taxonomies to display (0 for all).', 'pixfort-core'),
			]
		);

		$this->add_responsive_control(
			'gap',
			[
				'label' => __('Gap Between Items', 'pixfort-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
					'em' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
					'rem' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 4,
				],
				'selectors' => [
					'{{WRAPPER}} .pix-post-taxonomies-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Badge Style section
		$this->start_controls_section(
			'section_badge_style',
			[
				'label' => __('Badge Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
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
				'default' => 'font-weight-bold',
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

		// $this->add_control(
		// 	'rounded',
		// 	[
		// 		'label' => __('Rounded corners', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'label_on' => __('Yes', 'pixfort-core'),
		// 		'label_off' => __('No', 'pixfort-core'),
		// 		'return_value' => 'badge-pill',
		// 		'default' => '',
		// 	]
		// );

		$this->add_control(
			'text_color',
			[
				'label' => __('Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'primary',
			]
		);

		$this->add_control(
			'text_custom_color',
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
			'bg_color',
			[
				'label' => __('Background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
				'default' => 'primary-light',
			]
		);

		$this->add_control(
			'custom_bg_color',
			[
				'label' => __('Custom Background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'bg_color' => 'custom',
				],
			]
		);

		$this->add_control(
			'text_size',
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
				'default' => 'h6',
			]
		);

		$this->add_responsive_control(
			'text_custom_size',
			[
				'label' => __('Custom Text size', 'pixfort-core'),
				'label_block' => false,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter custom title size', 'pixfort-core'),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .badge' => 'font-size: {{value}} !important;',
				],
				'condition' => [
					'text_size' => 'custom',
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

		$this->end_controls_section();

		// Effects section
		$this->start_controls_section(
			'section_effects',
			[
				'label' => __('Effects', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
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

		// Advanced Style section
		$this->start_controls_section(
			'section_element_adv_style',
			[
				'label' => __('Advanced Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __('Alignment', 'pixfort-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'pixfort-core'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'pixfort-core'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'pixfort-core'),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __('Justified', 'pixfort-core'),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_inner_typography',
				'selector' => '{{WRAPPER}} .badge',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .badge',
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label' => __('Inner Padding', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'items_border',
				'selector' => '{{WRAPPER}} .badge',
			]
		);

		$this->add_responsive_control(
			'items_border_radius',
			[
				'label' => __('Items Border Radius', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		// Get the post taxonomies
		$post = get_post();
		if (!$post) {
			// Show placeholder in editor
			if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
				$this->render_placeholder_taxonomies($settings);
			}
			return;
		}

		// Get the selected taxonomy type, default to 'category'
		$taxonomy_type = !empty($settings['taxonomy_type']) ? $settings['taxonomy_type'] : 'category';
		$taxonomies = get_the_terms($post->ID, $taxonomy_type);

		if (empty($taxonomies) || is_wp_error($taxonomies)) {
			// Show placeholder in editor if no taxonomies
			if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
				$this->render_placeholder_taxonomies($settings);
			}
			return;
		}

		// Limit taxonomies if max_taxonomies is set
		$max_taxonomies = !empty($settings['max_taxonomies']) ? intval($settings['max_taxonomies']) : 0;
		if ($max_taxonomies > 0 && count($taxonomies) > $max_taxonomies) {
			$taxonomies = array_slice($taxonomies, 0, $max_taxonomies);
		}

		// Render taxonomies as badges
		echo '<div class="pix-post-taxonomies-wrapper d-flex flex-wrap">';

		foreach ($taxonomies as $taxonomy) {
			// Build badge attributes
			$badge_attrs = array(
				'text' => $taxonomy->name,
				'text_color' => $settings['text_color'],
				'text_custom_color' => !empty($settings['text_custom_color']) ? $settings['text_custom_color'] : '',
				'text_size' => $settings['text_size'],
				'text_custom_size' => !empty($settings['text_custom_size']) ? $settings['text_custom_size'] : '',
				'bold' => $settings['bold'],
				'italic' => $settings['italic'],
				'secondary_font' => $settings['secondary_font'],
				// 'rounded' => $settings['rounded'],
				'bg_color' => $settings['bg_color'],
				'custom_bg_color' => !empty($settings['custom_bg_color']) ? $settings['custom_bg_color'] : '',
				'style' => $settings['style'],
				'hover_effect' => $settings['hover_effect'],
				'add_hover_effect' => $settings['add_hover_effect'],
				'animation' => $settings['animation'],
				'delay' => !empty($settings['delay']) ? $settings['delay'] : '0',
				'link' => get_term_link($taxonomy->term_id),
				'target' => '_self',
			);

			// Render the badge
			echo \PixfortCore::instance()->elementsManager->renderElement('Badge', $badge_attrs);
		}

		echo '</div>';
	}

	private function render_placeholder_taxonomies($settings) {
		// Placeholder taxonomies for editor preview
		$placeholder_taxonomies = array(
			array('name' => 'Technology', 'link' => '#'),
			array('name' => 'Design', 'link' => '#'),
			array('name' => 'Tutorial', 'link' => '#'),
		);

		echo '<div class="pix-post-taxonomies-wrapper d-flex flex-wrap">';

		foreach ($placeholder_taxonomies as $taxonomy) {
			// Build badge attributes
			$badge_attrs = array(
				'text' => $taxonomy['name'],
				'text_color' => $settings['text_color'],
				'text_custom_color' => !empty($settings['text_custom_color']) ? $settings['text_custom_color'] : '',
				'text_size' => $settings['text_size'],
				'text_custom_size' => !empty($settings['text_custom_size']) ? $settings['text_custom_size'] : '',
				'bold' => $settings['bold'],
				'italic' => $settings['italic'],
				'secondary_font' => $settings['secondary_font'],
				// 'rounded' => $settings['rounded'],
				'bg_color' => $settings['bg_color'],
				'custom_bg_color' => !empty($settings['custom_bg_color']) ? $settings['custom_bg_color'] : '',
				'style' => $settings['style'],
				'hover_effect' => $settings['hover_effect'],
				'add_hover_effect' => $settings['add_hover_effect'],
				'animation' => $settings['animation'],
				'delay' => !empty($settings['delay']) ? $settings['delay'] : '0',
				'link' => $taxonomy['link'],
				'target' => '_self',
			);

			// Render the badge
			echo \PixfortCore::instance()->elementsManager->renderElement('Badge', $badge_attrs);
		}

		echo '</div>';
	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
