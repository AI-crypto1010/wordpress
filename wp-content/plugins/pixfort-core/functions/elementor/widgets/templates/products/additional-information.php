<?php

namespace Elementor;

class Pix_Eor_Product_Additional_Information extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-product-additional-information';
	}

	public function get_title() {
		return 'Additional Information';
	}

	public function get_icon() {
		return 'eicon-product-info pixfort-elementor-element pixfort-elementor-additional-information';
	}

	public function get_categories() {
		return ['pixfort-products'];
	}

	public function show_in_panel() {
		return $this->is_product_template_context();
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	private function is_product_template_context() {
		if (!Plugin::$instance->editor->is_edit_mode()) {
			return false;
		}

		$post_id = Plugin::$instance->editor->get_post_id();
		if (!$post_id) {
			return false;
		}

		if (get_post_type($post_id) !== 'pixfort_template') {
			return false;
		}

		$terms = get_the_terms($post_id, 'pixfort_template_type');
		if ($terms && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				if ($term->slug === 'product' || $term->slug === 'template') {
					return true;
				}
			}
		}

		return false;
	}

	protected function register_controls() {

		// $this->start_controls_section(
		// 	'section_content',
		// 	[
		// 		'label' => __('Settings', 'pixfort-core'),
		// 	]
		// );

		// $this->add_control(
		// 	'show_heading',
		// 	[
		// 		'label' => __('Show Heading', 'pixfort-core'),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_on' => __('Show', 'pixfort-core'),
		// 		'label_off' => __('Hide', 'pixfort-core'),
		// 		'return_value' => 'yes',
		// 		'default' => 'yes',
		// 	]
		// );

		// $this->end_controls_section();

		// $this->start_controls_section(
		// 	'section_style',
		// 	[
		// 		'label' => __('Style', 'pixfort-core'),
		// 		'tab' => Controls_Manager::TAB_STYLE,
		// 	]
		// );

		// $this->add_control(
		// 	'heading_color',
		// 	[
		// 		'label' => __('Heading Color', 'pixfort-core'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-product-additional-information h2' => 'color: {{VALUE}};',
		// 		],
		// 		'condition' => [
		// 			'show_heading' => 'yes',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'text_color',
		// 	[
		// 		'label' => __('Text Color', 'pixfort-core'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-product-additional-information table' => 'color: {{VALUE}};',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'border_color',
		// 	[
		// 		'label' => __('Border Color', 'pixfort-core'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-product-additional-information table, {{WRAPPER}} .pix-product-additional-information table th, {{WRAPPER}} .pix-product-additional-information table td' => 'border-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		// $this->add_group_control(
		// 	Group_Control_Typography::get_type(),
		// 	[
		// 		'name' => 'typography',
		// 		'selector' => '{{WRAPPER}} .pix-product-additional-information table',
		// 	]
		// );

		// $this->add_responsive_control(
		// 	'margin',
		// 	[
		// 		'label' => __('Margin', 'pixfort-core'),
		// 		'type' => Controls_Manager::DIMENSIONS,
		// 		'size_units' => ['px', 'em', '%'],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-product-additional-information' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		// 		],
		// 	]
		// );

		// $this->end_controls_section();
	}

	protected function render() {
		if (!class_exists('WooCommerce')) {
			echo '<p>' . __('WooCommerce is not installed.', 'pixfort-core') . '</p>';
			return;
		}

		$settings = $this->get_settings_for_display();
		$product = $this->get_product();

		if (!$product) {
			echo '<p>' . __('No product found to display.', 'pixfort-core') . '</p>';
			return;
		}

		global $product;
		$original_product = $product;
		$product = $this->get_product();

		echo '<div class="woocommerce pix-product-additional-information">';
		
		do_action('woocommerce_product_additional_information', $product);
		
		echo '</div>';

		$product = $original_product;
	}

	private function get_product() {
		global $product;

		if (Plugin::$instance->editor->is_edit_mode()) {
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => 1,
				'post_status' => 'publish',
			);
			$products = get_posts($args);
			if (!empty($products)) {
				return wc_get_product($products[0]->ID);
			}
			return null;
		}

		if (is_a($product, 'WC_Product')) {
			return $product;
		}

		$post_id = get_the_ID();
		if ($post_id) {
			return wc_get_product($post_id);
		}

		return null;
	}
}

