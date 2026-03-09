<?php

namespace Elementor;

class Pix_Eor_Progress_Bars extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_script('pix-progress-bars-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/progress-bars.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
	}

	public function get_name() {
		return 'pix-progress-bars';
	}

	public function get_title() {
		return 'Progress bars';
	}

	public function get_icon() {
		return 'eicon-skill-bar pixfort-elementor-element pixfort-elementor-progress-bar';
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
			'value',
			[
				'label' => __('Value', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('50', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$repeater->add_control(
			'text_color',
			[
				'label' => __('Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'primary',
			]
		);
		$repeater->add_control(
			'text_custom_color',
			[
				'label' => __('Text custom color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'text_color' => 'custom',
				],
			]
		);
		$repeater->add_control(
			'item_color',
			[
				'label' => __('Bar color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
				'default' => 'primary',
			]
		);
		$repeater->add_control(
			'item_custom_color',
			[
				'label' => __('Bar custom color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'item_color' => 'custom',
				],
			]
		);
		$repeater->add_control(
			'bg_color',
			[
				'label' => __('Background color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
				'default' => 'dark-opacity-3',
			]
		);
		$repeater->add_control(
			'bg_custom_color',
			[
				'label' => __('Background custom color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'bg_color' => 'custom',
				],
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




		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('ProgressBars', $settings);
	}


	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-progress-bars-handle'];
		return [];
	}
}
