<?php

namespace Elementor;

class Pix_Eor_Accordion extends Widget_Base {

	public function __construct($data = [], $args = null) {
		$data = \PixfortCore::instance()->icons->verifyElementorData($data, true, 'items');
		parent::__construct($data, $args);

		// wp_register_script( 'pix-accordion-handle', PIX_CORE_PLUGIN_URI.'functions/elementor/js/accordion.js', [ 'elementor-frontend' ], PIXFORT_PLUGIN_VERSION, true );
	}

	public function get_name() {
		return 'pix-accordion';
	}

	public function get_title() {
		return 'Accordion';
	}

	public function get_icon() {
		return 'eicon-accordion pixfort-elementor-element pixfort-elementor-accordion';
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
				'label' => __('Enable Icon', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					"" => "No",
					"icon" => "Yes"
				],
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
			'is_open',
			[
				'label' => __('Open by default', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
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
			'transition',
			[
				'label' => __('Transition', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''			=> 'None',
					'fade'			=> 'Fade',
					'fade-left'			=> 'Fade Left',
					'fade-right'		=> 'Fade Right',
					'fade-up' 		=> 'Fade Up',
					'fade-down' 		=> 'Fade Down',
				),
				'default' => '',
			]
		);



		// Title format
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
				'label' => __('Custom Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'title_color' => 'custom',
				],
			]
		);


		$this->add_control(
			'icon_color',
			[
				'label' => __('Icon color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'primary',
			]
		);
		$this->add_control(
			'custom_icon_color',
			[
				'label' => __('Icon Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom',
				],
			]
		);


		$this->add_control(
			'bg_color',
			[
				'label' => __('Background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
				'default' => 'white',
			]
		);
		$this->add_control(
			'custom_bg_color',
			[
				'label' => __('Custom Background Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'bg_color' => 'custom',
				],
			]
		);



		$this->end_controls_section();



		$this->start_controls_section(
			'section_element_text_style',
			[
				'label' => __('Text Style', 'pixfort-core'),
			]
		);

		$this->add_responsive_control(
			'text_color',
			[
				'label' => __('Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'body-default',
				'selectors' => [
					'{{WRAPPER}} .card-body > *' => 'color: var(--pix-{{VALUE}});',
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'text_custom_color',
			[
				'label' => __('Custom Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .card-body > *' => 'color: {{VALUE}};',
				],
				'dynamic'     => array(
					'active'  => true
				),
				'condition' => [
					'text_color' => 'custom',
				],
			]
		);


		$this->end_controls_section();



		$this->start_controls_section(
			'section_element_title_style',
			[
				'label' => __('Title Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __('Title Alignment', 'pixfort-core'),
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
					'{{WRAPPER}} .card-header button' => 'text-align: {{VALUE}} !important;justify-content: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_inner_typography',
				'selector' => '{{WRAPPER}} .card-header button, {{WRAPPER}} .card-header button svg',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .card-header button',
			]
		);

		$this->add_responsive_control(
			'items_gap',
			[
				'label' => esc_html__('Gap Between Items', 'pixfort-core'),
				'type' => Controls_Manager::SLIDER,
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
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .accordion-card' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'shadow',
			[
				'label' => __('Shadow Style', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					"0" => "None",
					"1"       => "Small shadow",
					"2"       => "Medium shadow",
					"3"       => "Large shadow"
				),
				'default' => '1',
			]
		);

		if (class_exists('\PixfortCore') && \PixfortCore::instance()->getThemeParam('new_border_options')) {
			$this->add_control(
				'rounded_corners',
				[
					'label' => __('Rounded corners', 'pixfort-core'),
					'type' => Controls_Manager::SELECT,
					'default' => 'rounded-lg',
					'options' => [
						'rounded-0' => __('No', 'pixfort-core'),
						'rounded' => __('Rounded', 'pixfort-core'),
						'rounded-lg' => __('Rounded Large', 'pixfort-core'),
						'rounded-xl' => __('Rounded XL', 'pixfort-core'),
						'rounded-10' => __('Rounded 2XL', 'pixfort-core'),
						'custom' => __('Custom', 'pixfort-core'),
					],
				]
			);

			$this->add_responsive_control(
				'custom_border_radius',
				[
					'label' => esc_html__('Custom Border Radius', 'pixfort-core'),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors' => [
						'{{WRAPPER}} .card-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					],
					'condition' => [
						'rounded_corners' => 'custom',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'title_border',
					'label' => esc_html__('Border', 'pixfort-core'),
					'selector' => '{{WRAPPER}} .card-header',
				]
			);
		}

		$this->end_controls_section();

		$this->start_controls_section(
			'section_element_content_style',
			[
				'label' => __('Content Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __('Paragraph text Typography', 'pixfort-core'),
				'name' => 'content_inner_typography',
				'selector' => '{{WRAPPER}} .card-body p',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$settings['element_id'] = $this->get_id();
		echo \PixfortCore::instance()->elementsManager->renderElement('AccordionText', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
