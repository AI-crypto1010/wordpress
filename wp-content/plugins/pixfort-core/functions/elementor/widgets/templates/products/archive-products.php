<?php

namespace Elementor;

class Pix_Eor_Archive_Products extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-archive-products';
	}

	public function get_title() {
		return 'Archive Products';
	}

	public function get_icon() {
		return 'eicon-products pixfort-elementor-element pixfort-elementor-archive-products';
	}

	public function get_categories() {
		return ['pixfort-products'];
	}

	public function show_in_panel() {
		return $this->is_product_archive_template_context();
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	private function is_product_archive_template_context() {
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
				if ($term->slug === 'product-archive' || $term->slug === 'template') {
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

		$this->add_control(
			'layout_info',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => __('The editor preview might look different from the live site. The actual products will be displayed on the frontend based on the archive being viewed. Please make sure to check the frontend.', 'pixfort-core'),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);


		$this->add_control(
			'allow_order',
			[
				'label' => __('Allow Order', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// $this->add_control(
		// 	'order_info',
		// 	[
		// 		'type' => Controls_Manager::RAW_HTML,
		// 		'raw' => __('Ordering is not available if this widget is placed in your front page. Visible on frontend only.', 'pixfort-core'),
		// 		'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
		// 	]
		// );

		$this->add_control(
			'show_result_count',
			[
				'label' => __('Show Result Count', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'item_style',
			[
				'label' => __('Product Item Style', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __('Default (Use Theme Option)', 'pixfort-core'),
					'default' => __('Default', 'pixfort-core'),
					'default-no-padding' => __('Default No Padding', 'pixfort-core'),
					'top-img' => __('Top Image', 'pixfort-core'),
					'top-img-no-padding' => __('Top No Padding', 'pixfort-core'),
					'full-img' => __('Full Image', 'pixfort-core'),
				],
				'description' => __('Override the default product item style from theme options.', 'pixfort-core'),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_advanced',
			[
				'label' => __('Advanced', 'pixfort-core'),
			]
		);

		$this->add_control(
			'nothing_found_message',
			[
				'label' => __('Nothing Found Message', 'pixfort-core'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __('It seems we can\'t find what you\'re looking for.', 'pixfort-core'),
				'placeholder' => __('Enter your custom message here', 'pixfort-core'),
				'dynamic' => [
					'active' => true,
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

		$settings = $this->get_settings_for_display();

		// If in editor mode, show placeholder
		if (Plugin::$instance->editor->is_edit_mode()) {
			$this->render_editor_preview($settings);
			return;
		}

		// Get the current query
		global $wp_query;

		// Check if there are products
		if (!$wp_query->have_posts()) {
			$this->render_nothing_found($settings);
			return;
		}

		echo '<div class="woocommerce pix-archive-products">';

		// Show result count if enabled
		if ($settings['show_result_count'] === 'yes') {
			woocommerce_result_count();
		}

		// Show ordering if enabled and not on front page
		if ($settings['allow_order'] === 'yes' && !is_front_page()) {
			woocommerce_catalog_ordering();
		}

		// Output the products loop
		woocommerce_product_loop_start();

		// Get product item style option - use widget setting if set, otherwise use theme option
		$item_style = !empty($settings['item_style']) ? $settings['item_style'] : pix_plugin_get_option('shop-item-style', 'default');

		if (wc_get_loop_prop('total')) {
			while ($wp_query->have_posts()) {
				$wp_query->the_post();

				/**
				 * Hook: woocommerce_shop_loop.
				 */
				do_action('woocommerce_shop_loop');

				if($item_style=='default-no-padding'){
					get_template_part( 'woocommerce/pixfort/product-default-no-padding' );
				}elseif($item_style=='top-img'){
					get_template_part( 'woocommerce/pixfort/product-top-img' );
				}elseif($item_style=='top-img-no-padding'){
					get_template_part( 'woocommerce/pixfort/product-top-img-no-padding' );
				}elseif($item_style=='full-img'){
					get_template_part( 'woocommerce/pixfort/product-full-img' );
				}else{
					get_template_part( 'woocommerce/pixfort/product-default' );
				}
			}
		}

		woocommerce_product_loop_end();

		// Pagination
		woocommerce_pagination();

		echo '</div>';

		wp_reset_postdata();
	}

	private function render_editor_preview($settings) {
		echo '<div class="woocommerce pix-archive-products pix-editor-preview">';

		// Show result count preview if enabled
		if ($settings['show_result_count'] === 'yes') {
			echo '<p class="woocommerce-result-count">' . __('Showing 1–12 of 24 results', 'pixfort-core') . '</p>';
		}

		// Show ordering preview if enabled
		if ($settings['allow_order'] === 'yes') {
			echo '<form class="woocommerce-ordering" method="get">';
			echo '<select name="orderby" class="orderby" aria-label="' . esc_attr__('Shop order', 'pixfort-core') . '">';
			echo '<option value="menu_order">' . __('Default sorting', 'pixfort-core') . '</option>';
			echo '<option value="popularity">' . __('Sort by popularity', 'pixfort-core') . '</option>';
			echo '<option value="rating">' . __('Sort by average rating', 'pixfort-core') . '</option>';
			echo '<option value="date">' . __('Sort by latest', 'pixfort-core') . '</option>';
			echo '<option value="price">' . __('Sort by price: low to high', 'pixfort-core') . '</option>';
			echo '<option value="price-desc">' . __('Sort by price: high to low', 'pixfort-core') . '</option>';
			echo '</select>';
			echo '</form>';
		}

		// Get sample products for preview
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => 6,
			'post_status' => 'publish',
		);
		$products = get_posts($args);

		// Get product item style option - use widget setting if set, otherwise use theme option
		$item_style = !empty($settings['item_style']) ? $settings['item_style'] : pix_plugin_get_option('shop-item-style', 'default');

		if (!empty($products)) {
			woocommerce_product_loop_start();

			foreach ($products as $post) {
				global $product;
				$product = wc_get_product($post->ID);
				setup_postdata($post);

				if($item_style=='default-no-padding'){
					get_template_part( 'woocommerce/pixfort/product-default-no-padding' );
				}elseif($item_style=='top-img'){
					get_template_part( 'woocommerce/pixfort/product-top-img' );
				}elseif($item_style=='top-img-no-padding'){
					get_template_part( 'woocommerce/pixfort/product-top-img-no-padding' );
				}elseif($item_style=='full-img'){
					get_template_part( 'woocommerce/pixfort/product-full-img' );
				}else{
					get_template_part( 'woocommerce/pixfort/product-default' );
				}
			}

			woocommerce_product_loop_end();
			wp_reset_postdata();
		} else {
			echo '<p>' . __('No products found for preview. Please create some products first.', 'pixfort-core') . '</p>';
		}

		echo '</div>';
	}

	private function render_nothing_found($settings) {
		echo '<div class="woocommerce pix-archive-products pix-no-products">';
		
		$message = !empty($settings['nothing_found_message']) 
			? $settings['nothing_found_message'] 
			: __('It seems we can\'t find what you\'re looking for.', 'pixfort-core');
		
		echo '<div class="woocommerce-info">';
		echo '<p>' . esc_html($message) . '</p>';
		echo '</div>';
		
		echo '</div>';
	}
}

