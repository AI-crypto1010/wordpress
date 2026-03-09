<?php

namespace Elementor;

use Elementor\Controls_Manager;

class Pix_Eor_Button extends Widget_Base {

	public function __construct($data = [], $args = null) {
		// Link migration code
		$is_external = false;
		if (!empty($data['settings'])) {
			if (!empty($data['settings']['btn_link']) && !is_array($data['settings']['btn_link'])) {
				if (!empty($data['settings']['btn_target']) && $data['settings']['btn_target']) {
					$is_external = true;
				}
				$data['settings']['btn_link'] = [
					'url' => $data['settings']['btn_link'],
					'is_external' => $is_external,
					'nofollow' => false,
				];
				$data['settings']['btn_target'] = false;
			}
		}
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-button';
	}

	public function get_title() {
		return 'Button';
	}

	public function get_icon() {
		return 'eicon-button pixfort-elementor-element pixfort-elementor-button';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	protected function register_controls() {
		pix_get_elementor_btn($this, true);

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
				'selector' => '{{WRAPPER}} .btn, {{WRAPPER}} .btn span, {{WRAPPER}} .btn  .font-weight-bold',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .btn',
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label' => __('Inner Padding', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if (!empty($settings['btn_link']) && is_array($settings['btn_link'])) {
			if (!empty($settings['btn_link']['is_external'])) {
				$settings['btn_target'] = $settings['btn_link']['is_external'];
			} else {
				$settings['btn_target'] = false;
			}
			// if(!empty($settings['btn_link']['custom_attributes'])){
			// 	$settings['link_atts'] = $settings['btn_link']['custom_attributes'];
			// }
			$settings['btn_link'] = $settings['btn_link']['url'];
		}
		echo \PixfortCore::instance()->elementsManager->renderElement('Button', $settings);
	}



	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global'];
		return [];
	}
}
