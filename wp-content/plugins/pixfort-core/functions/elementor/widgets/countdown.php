<?php

namespace Elementor;

class Pix_Eor_Countdown extends Widget_Base {

	public function __construct($data = [], $args = null) {
		// Link migration code
		if (!empty($data['settings'])) {
			if (!empty($data['settings']['link']) && !is_array($data['settings']['link'])) {
				$data['settings']['link'] = [
					'url' => $data['settings']['link'],
					'is_external' => false,
					'nofollow' => false,
				];
			}
		}
		parent::__construct($data, $args);

		wp_register_script('pix-countdown-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/countdown.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
	}

	public function get_name() {
		return 'pix-countdown';
	}

	public function get_title() {
		return 'Countdown';
	}

	public function get_icon() {
		return 'eicon-countdown pixfort-elementor-element pixfort-elementor-countdown';
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
			'date',
			[
				'label' => __('Launch Date', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active'  => true
				),
				'placeholder' => __('Format: 12/30/2025 12:00:00 month/day/year hour:minute:second', 'pixfort-core'),
				'default' => '12/30/2025 12:00:00',
			]
		);
		$this->add_control(
			'link',
			[
				'label' => __('Link', 'pixfort-core'),
				// 'label_block' => true,
				// 'type' => Controls_Manager::TEXT,
				'type' => Controls_Manager::URL,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
				'dynamic'     => array(
					'active'  => true
				),
				'placeholder' => __('Link', 'pixfort-core'),
				// 'default' => '',
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
			'format_section',
			[
				'label' => __('Format', 'pixfort-core'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
		$this->add_control(
			'numbers_color',
			[
				'label' => __('Numbers color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'heading-default',
			]
		);
		$this->add_control(
			'numbers_custom_color',
			[
				'label' => __('Custom Title color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'numbers_color' => 'custom',
				],
			]
		);
		$this->add_control(
			'numbers_size',
			[
				'label' => __('Numbers size', 'pixfort-core'),
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
				'default' => 'h1',
			]
		);
		$this->add_control(
			'numbers_custom_size',
			[
				'label' => __('Custom Numbers size', 'pixfort-core'),
				'label_block' => false,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Enter custom Numbers size', 'pixfort-core'),
				'default' => '',
				'condition' => [
					'numbers_size' => 'custom',
				],
			]
		);
		$this->add_control(
			'display',
			[
				'label' => __('Bigger Text', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''		=> 'None',
					'display-1'		=> 'Display 1',
					'display-2'		=> 'Display 2',
					'display-3'		=> 'Display 3',
					'display-4'		=> 'Display 4',
				),
				'default' => 'display-4',
				'condition' => [
					'numbers_size' => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6')
				],
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __('Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'heading-default',
			]
		);
		$this->add_control(
			'content_custom_color',
			[
				'label' => __('Custom Text color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'content_color' => 'custom',
				],
			]
		);


		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if (!empty($settings['link']) && is_array($settings['link'])) {
			// if(!empty($settings['link']['nofollow'])){
			// 	$settings['nofollow'] = $settings['link']['nofollow'];
			// }
			// if(!empty($settings['link']['custom_attributes'])){
			// 	$settings['link_atts'] = $settings['link']['custom_attributes'];
			// }
			$settings['link'] = $settings['link']['url'];
		}
		echo \PixfortCore::instance()->elementsManager->renderElement('Countdown', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-countdown-handle'];
		return [];
	}
}
