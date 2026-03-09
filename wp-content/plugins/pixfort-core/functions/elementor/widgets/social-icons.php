<?php

namespace Elementor;

class Pix_Eor_Social_Icons extends Widget_Base {

	public function __construct($data = [], $args = null) {
		if (!empty($data['settings'])) {
			if (!empty($data['settings']['items'])) {
				foreach ($data['settings']['items'] as $key => $value) {
					$is_external = true;
					if (array_key_exists('target', $data['settings']['items'][$key])) {
						$is_external = false;
					}
					if (!empty($data['settings']['items'][$key]['item_link']) && !is_array($data['settings']['items'][$key]['item_link'])) {
						$data['settings']['items'][$key]['item_link'] = [
							'url' => $data['settings']['items'][$key]['item_link'],
							'is_external' => $is_external,
							'nofollow' => false,
						];
					}
				}
			}
		}
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-social-icons';
	}

	public function get_title() {
		return 'Social icons';
	}

	public function get_icon() {
		return 'eicon-social-icons pixfort-elementor-element pixfort-elementor-social-icons';
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
			'icon',
			[
				'label' => esc_html__('pixfort Icon', 'pixfort-core'),
				'type' => \Elementor\CustomControl\PixfortIconSelector_Control::PixfortIconSelector,
				'default' => '',
			]
		);
		
		$repeater->add_control(
			'item_link',
			[
				'label' => __('Icon Link', 'pixfort-core'),
				'type' => Controls_Manager::URL,
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
		// $repeater->add_control(
		// 	'target',
		// 	[
		// 		'label' => __( 'Open in a new tab', 'pixfort-core' ),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'label_on' => __( 'Yes', 'pixfort-core' ),
		// 		'label_off' => __( 'No', 'pixfort-core' ),
		// 		'return_value' => 'Yes',
		// 		'condition' => [
		// 			'item_link!' => '',
		// 		],
		// 	]
		// );
		$repeater->add_control(
			'has_color',
			[
				'label' => __('Different color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
			]
		);
		$repeater->add_control(
			'item_color',
			[
				'label' => __('Icon color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => '',
				'condition' => [
					'has_color' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'item_custom_color',
			[
				'label' => __('Custom Icon Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'item_color' => 'custom',
				],
			]
		);
		$repeater->add_control(
			'aria_label',
			[
				'label' => __('Area label', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'label_block' => true,
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'items',
			[
				'label' => __('Icons', 'pixfort-core'),
				'type' => Controls_Manager::REPEATER,
				'title_field' => '{{{ icon }}}',
				'fields' => $repeater->get_controls()
			]
		);


		$this->add_control(
			'item_size',
			[
				'label' => __('Size', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''			=> 'Default (16px)',
					'text-xs'		=> '12px',
					'text-sm'		=> '14px',
					'text-sm'		=> '14px',
					'text-18' 		=> '18px',
					'text-20' 		=> '20px',
					'text-24' 		=> '24px',
					'custom' 		=> 'Custom',
				],
			]
		);
		$this->add_control(
			'item_custom_size',
			[
				'label' => __('Custom Icon Size', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('Please input the value (with the unit: px,.. etc).', 'pixfort-core'),
				'condition' => [
					'item_size' => 'custom',
				],
			]
		);


		$this->add_control(
			'items_color',
			[
				'label' => __('Icons color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
				'default' => 'body-default',
			]
		);
		$this->add_control(
			'items_custom_color',
			[
				'label' => __('Custom Icons Color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom',
				],
			]
		);
		$this->add_control(
			'items_style',
			[
				'label' => __('Hover Animation', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					""       => "None",
					"fly-sm"       => "Fly Small",
					"fly"       => "Fly Medium",
					"fly-lg"       => "Fly Large",
					"scale-sm"       => "Scale Small",
					"scale"       => "Scale Medium",
					"scale-lg"       => "Scale Large",
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
					'text-left'			=> 'Start',
					'text-center'		=> 'Center',
					'text-right' 		=> 'End',
				),
				'default' => 'text-left',
			]
		);
		$this->add_control(
			'item_padding',
			[
				'label' => __('Padding', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'px-2'			=> 'Default (small)',
					'px-1'		=> 'Extra small',
					'px-3'		=> 'Medium',
					'px-4'		=> 'Large',
					'px-5'		=> 'Extra Large',
					'none'		=> 'None',
					'custom'		=> 'Custom',
				),
				'default' => 'px-2',
			]
		);
		$this->add_control(
			'item_custom_padding',
			[
				'label' => __('Custom Icons padding', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('Please input the value (with the unit: px,.. etc).', 'pixfort-core'),
				'condition' => [
					'item_padding' => 'custom',
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

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if (!empty($settings)) {
			if (!empty($settings['items'])) {
				foreach ($settings['items'] as $key => $value) {
					if (!empty($settings['items'][$key]['item_link']['is_external'])) {
						$settings['items'][$key]['target'] = $settings['items'][$key]['item_link']['is_external'];
					}
					if (!empty($settings['items'][$key]['item_link']['custom_attributes'])) {
						$settings['items'][$key]['link_atts'] = $settings['items'][$key]['item_link']['custom_attributes'];
					}
					$settings['items'][$key]['item_link'] = $settings['items'][$key]['item_link']['url'];
				}
			}
		}
		echo \PixfortCore::instance()->elementsManager->renderElement('SocialIcons', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
