<?php

namespace Elementor;

class Pix_Eor_Product_Data_Tabs extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-product-data-tabs';
	}

	public function get_title() {
		return 'Product Data Tabs';
	}

	public function get_icon() {
		return 'eicon-product-tabs pixfort-elementor-element pixfort-elementor-product-data-tabs';
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

		$this->start_controls_section(
			'section_tabs_style',
			[
				'label' => __('Tabs Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tab_text_color',
			[
				'label' => __('Tab Text Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-product-tabs .woocommerce-tabs ul.tabs li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_active_color',
			[
				'label' => __('Tab Active Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-product-tabs .woocommerce-tabs ul.tabs li.active a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_bg_color',
			[
				'label' => __('Tab Background', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-product-tabs .woocommerce-tabs ul.tabs li' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_active_bg_color',
			[
				'label' => __('Tab Active Background', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-product-tabs .woocommerce-tabs ul.tabs li.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tab_typography',
				'label' => __('Tab Typography', 'pixfort-core'),
				'selector' => '{{WRAPPER}} .pix-product-tabs .woocommerce-tabs ul.tabs li a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __('Content Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_text_color',
			[
				'label' => __('Content Text Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-product-tabs .woocommerce-tabs .panel' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __('Content Typography', 'pixfort-core'),
				'selector' => '{{WRAPPER}} .pix-product-tabs .woocommerce-tabs .panel',
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label' => __('Margin', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-product-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if (!class_exists('WooCommerce')) {
			echo '<p>' . __('WooCommerce is not installed.', 'pixfort-core') . '</p>';
			return;
		}

		$product = $this->get_product();

		if (!$product) {
			echo '<p>' . __('No product found to display.', 'pixfort-core') . '</p>';
			return;
		}

		global $product;
		$original_product = $product;
		$product = $this->get_product();

		echo '<div class="woocommerce pix-product-tabs">';
		woocommerce_output_product_data_tabs();
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

