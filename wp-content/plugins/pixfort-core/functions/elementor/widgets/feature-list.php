<?php

namespace Elementor;

class Pix_Eor_Feature_List extends Widget_Base {

	public function __construct($data = [], $args = null) {
		$data = \PixfortCore::instance()->icons->verifyElementorData($data, true, 'features');
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-feature-list';
	}

	public function get_title() {
		return 'Feature List';
	}

	public function get_icon() {
		return 'eicon-post-list pixfort-elementor-element pixfort-elementor-features-list';
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
				'label' => __('Custom Icon Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom',
				],
			]
		);



		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'text',
			[
				'label' => __('Text', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'label_block' => true,
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$repeater->add_control(
			'link',
			[
				'label' => __('Link (Optional)', 'pixfort-core'),
				'type' => Controls_Manager::URL,
				'placeholder' => __('Link', 'pixfort-core'),
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
				'placeholder'   => 'http://your-link.com',
				'dynamic'     => array(
					'active'  => true
				)
			]
		);

		$repeater->add_control(
			'icon',
			[
				'label' => esc_html__('pixfort Icon', 'pixfort-core'),
				'type' => \Elementor\CustomControl\PixfortIconSelector_Control::PixfortIconSelector,
				'default' => '',
			]
		);
		


		$this->add_control(
			'features',
			[
				'label' => __('Events', 'pixfort-core'),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ text }}}',
				'fields' => $repeater->get_controls()
			]
		);



		$this->add_control(
			'features_content_align',
			[
				'label' => __('Content align', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''			=> 'Default',
					'text-left'			=> 'Left',
					'text-center'		=> 'Center',
					'text-right' 		=> 'Right',
				),
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
			'title_section',
			[
				'label' => __('Text format', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'content_size',
			[
				'label' => __('Text size', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''			=> 'Default',
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
			'content_color',
			[
				'label' => __('Content color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'dark-opacity-5',
			]
		);
		$this->add_control(
			'content_custom_color',
			[
				'label' => __('content_custom_color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'content_color' => 'custom',
				],
			]
		);


		$this->add_control(
			'flist_bold',
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
			'flist_italic',
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
			'flist_secondary_font',
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
				'label' => __('Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => __('Text Typography', 'pixfort-core'),
				'selector' => '{{WRAPPER}} .pix-feature-list',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('FeatureList', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
