<?php

namespace Elementor;

class Pix_Eor_Clients extends Widget_Base {

	public function __construct($data = [], $args = null) {

		// Link migration code
		if (!empty($data['settings'])) {
			if (!empty($data['settings']['clients'])) {
				foreach ($data['settings']['clients'] as $key => $value) {
					$is_external = true;
					if (array_key_exists('target', $data['settings']['clients'][$key])) {
						$is_external = false;
					}
					if (!empty($data['settings']['clients'][$key]['link']) && !is_array($data['settings']['clients'][$key]['link'])) {
						$data['settings']['clients'][$key]['link'] = [
							'url' => $data['settings']['clients'][$key]['link'],
							'is_external' => $is_external,
							'nofollow' => false,
						];
					}
				}
			}
		}

		parent::__construct($data, $args);

		wp_register_script('pix-clients-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/clients.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
		if(is_user_logged_in()) {
			wp_enqueue_style('pixfort-clients-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/clients.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		}
	}

	public function get_name() {
		return 'pix-clients';
	}

	public function get_title() {
		return 'Clients';
	}

	public function get_icon() {
		return 'eicon-logo pixfort-elementor-element pixfort-elementor-clients';
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
			'in_row',
			[
				'label' => __('Items in Row', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => array_flip(array(
					'1 Client'	            => '12',
					'2 Clients'				=> '6',
					'3 Clients'				=> '4',
					'4 Clients'				=> '3',
					'5 Clients'				=> '5',
					'6 Clients'				=> '2',
				)),
			]
		);


		$repeater = new \Elementor\Repeater();
		// $repeater->add_control(
		// 	'image',
		// 	[
		// 		'label' => __('Image', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::MEDIA,
		// 	]
		// );
		getElementorDynamicImageControls($repeater, 'image', 'image_dark');

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
			'link',
			[
				'label' => __('Link', 'pixfort-core'),
				'type' => Controls_Manager::URL,
				'placeholder' => __('Link', 'pixfort-core'),
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'clients',
			[
				'label' => __('Clients', 'pixfort-core'),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ title }}}',
				'fields' => $repeater->get_controls()
			]
		);

		$this->add_control(
			'in_row_mobile',
			[
				'label' => __('Items in Row in Mobile', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '12',
				'options' => array_flip(array(
					'1 (Default - Full width)'	=> '12',
					'2 Clients'					=> '6'
				)),
			]
		);

		$this->add_control(
			'add_hover_effect',
			[
				'label' => __('Hover Animation', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
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
				],
			]
		);
		$this->add_control(
			'style',
			[
				'label' => __('Additional hover effect', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'pix-box',
				'options' => [
					'pix-box'			=> 'Fade others + Box',
					'client'			=> 'Fade others',
					// 'nobox' 	=> 'Without boxes',
					// 'fly' 	    => 'Fly',
					'no-effect' 	    => 'No effect',
				],
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
			'delay_items',
			[
				'label' => __('Add delay between items', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''			=> 'No',
					'yes'			=> 'Yes',
				),
				'condition' => [
					'animation!' => '',
				],
			]
		);


		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if (!empty($settings)) {
			if (!empty($settings['clients'])) {
				foreach ($settings['clients'] as $key => $value) {
					if (!empty($settings['clients'][$key]['link']['is_external'])) {
						$settings['clients'][$key]['target'] = $settings['clients'][$key]['link']['is_external'];
					}
					if (!empty($settings['clients'][$key]['link']['custom_attributes'])) {
						$settings['clients'][$key]['link_atts'] = $settings['clients'][$key]['link']['custom_attributes'];
					}
					$settings['clients'][$key]['link'] = $settings['clients'][$key]['link']['url'];
				}
			}
		}
		echo \PixfortCore::instance()->elementsManager->renderElement('Clients', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-clients-handle'];
		return [];
	}
}
