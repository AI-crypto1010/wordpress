<?php

namespace Elementor;

class Pix_Eor_Product_Images extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-product-images';
	}

	public function get_title() {
		return 'Product Images';
	}

	public function get_icon() {
		return 'eicon-product-images pixfort-elementor-element pixfort-elementor-product-images';
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
			'section_content',
			[
				'label' => __('Settings', 'pixfort-core'),
			]
		);

		$this->add_control(
			'images_style',
			[
				'label' => __('Images Style', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					"simple" => "Simple",
					"gallery"       => "Gallery",
					// "default"       => "Default Theme Style",
				],
				'default' => 'simple',
			]
		);

		$this->add_responsive_control(
			'images_border_radius',
			[
				'label' => __('Images Border Radius', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} img, {{WRAPPER}} .woocommerce-product-gallery__image, {{WRAPPER}} .woocommerce-product-gallery .flex-control-nav.flex-control-thumbs li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				]
			]
		);

		$this->add_responsive_control(
			'images_gap',
			[
				'label' => __('Images Gap', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SLIDER,
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
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .pix-thumbnail-images' => 'gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pix-main-images' => 'gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pix-product-images-simple' => 'gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .flex-control-thumbs' => 'gap: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .woocommerce-product-gallery .flex-viewport' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);



		// $this->add_control(
		// 	'sale_flash',
		// 	[
		// 		'label' => __('Sale Badge', 'pixfort-core'),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_on' => __('Show', 'pixfort-core'),
		// 		'label_off' => __('Hide', 'pixfort-core'),
		// 		'return_value' => 'yes',
		// 		'default' => 'yes',
		// 	]
		// );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __('Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label' => __('Margin', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-product-images' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		$product = $this->get_product();

		if (!$product) {
			echo '<p>' . __('No product found to display.', 'pixfort-core') . '</p>';
			return;
		}

		// if (Plugin::$instance->editor->is_edit_mode()) {
		// 	// We need to enqueue these scripts manually on the Library preview.
		// 	$this->load_assets_dependencies();
		// }

		global $product;
		$original_product = $product;
		$product = $this->get_product();

		// echo '<div class="woocommerce pix-product-images">';

		// if ($settings['sale_flash'] === 'yes') {
		// 	wc_get_template('loop/sale-flash.php');
		// }

		if ($settings['images_style'] === 'gallery') {
			// add_theme_support( 'wc-product-gallery-slider' );
			wc_get_template('single-product/product-image.php');
			// wc_get_template('single-product/product-gallery.php');
		} else {
			$this->render_simple_images();
		}

		// echo '</div>';

		$product = $original_product;

		// On render widget from Editor - trigger the init manually.
		if (Plugin::$instance->editor->is_edit_mode()) {
?>
			<script>
				jQuery('.woocommerce-product-gallery').each(function() {
					jQuery(this).wc_product_gallery();
				});
			</script>
		<?php
		}
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

	private function load_assets_dependencies() {
		// if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) {
		// 	wp_enqueue_script( 'zoom' );
		// }
		// if ( current_theme_supports( 'wc-product-gallery-slider' ) ) {
		// 	wp_enqueue_script( 'flexslider' );
		// }
		// if ( current_theme_supports( 'wc-product-gallery-lightbox' ) ) {
		// 	wp_enqueue_script( 'photoswipe-ui-default' );
		// 	wp_enqueue_style( 'photoswipe-default-skin' );
		// 	add_action( 'wp_footer', 'woocommerce_photoswipe' );
		// }
		// wp_enqueue_script( 'wc-single-product' );

		// wp_enqueue_style( 'photoswipe' );
		// wp_enqueue_style( 'photoswipe-default-skin' );
		// wp_enqueue_style( 'woocommerce_prettyPhoto_css' );

	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['zoom', 'flexslider', 'photoswipe-ui-default', 'wc-single-product', 'photoswipe', 'photoswipe-default-skin', 'woocommerce_prettyPhoto_css'];
		return [];
	}

	// public function get_style_depends(): array {
	// 	return [ 'widget-woocommerce-product-images', 'pix-woo-2', 'pix-woo-style', 'pix-woo-blocks' ];
	// }

	private function render_simple_images() {
		global $product;
		$post_thumbnail_id = $product->get_image_id();
		$attachment_ids = $product->get_gallery_image_ids();

		if ($attachment_ids && $product->get_image_id()) {
		?>
			<div class="pix-product-images-simple d-flex">
				<div class="">
					<div class="pix-thumbnail-images d-flex flex-column sticky-top pix-sticky-top-adjust">
						<?php
						if (!empty($product->get_image_id())) {
							if (!$product->is_type('variable')) {
						?>
								<a class="d-block" href="#pix-product-img-featured-<?php echo esc_attr($product->get_image_id()); ?>">
									<?php
									echo wp_get_attachment_image($product->get_image_id(), 'pix-woocommerce-xs', false, array(
										'class' => 'pix-product-images-simple-img rounded-lg pix-fit-cover d-inline-block',
									));
									?>
								</a>
							<?php
							}
						}
						foreach ($attachment_ids as $attachment_id) {
							?>
							<a class="d-block" href="#pix-product-img-<?php echo esc_attr($attachment_id); ?>">
								<?php
								echo wp_get_attachment_image($attachment_id, 'pix-woocommerce-xs', false, array(
									'class' => 'pix-product-images-simple-img rounded-lg pix-fit-cover d-inline-block',
								));
								?>
							</a>
						<?php
						}
						?>
					</div>
				</div>
				<div class="pix-main-images d-flex flex-column">
					<?php
					if (!empty($product->get_image_id())) {
					?>
						<div id="pix-product-img-featured-<?php echo esc_attr($product->get_image_id()); ?>" class="rounded-lg pix-fit-cover overflow-hidden">
							<?php
							if ($post_thumbnail_id) {
								// $html = wc_get_gallery_image_html($post_thumbnail_id, true);
								$html = wp_get_attachment_image($post_thumbnail_id, 'full', false, array(
									'class' => 'rounded-lg pix-fit-cover w-100',
								));
							}
							// else {
							// 	$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
							// 	$html .= sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_html__('Awaiting product image', 'pixfort'));
							// 	$html .= '</div>';
							// }
							echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped


							?>
						</div>
					<?php
					}
					foreach ($attachment_ids as $attachment_id) {
					?>
						<div id="pix-product-img-<?php echo esc_attr($attachment_id); ?>">
							<?php
							echo wp_get_attachment_image($attachment_id, 'full', false, array(
								'class' => 'rounded-lg pix-fit-cover w-100',
							));
							?>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		<?php
		} else {
		?>
			<div class="d-flex">
				<div class="">
					<div class="sticky-top pix-sticky-top-adjust">
						<a href="#pix-product-img-<?php echo esc_attr($attachment_id); ?>">
							<?php
							echo wp_get_attachment_image($product->get_image_id(), 'pix-woocommerce-xs', false, array(
								'class' => 'rounded-lg pix-fit-cover d-inline-block',
								'style' => 'width:75px;height:75px;'
							));
							?>
						</a>

					</div>
				</div>
				<div class="">
					<div id="pix-product-img-<?php echo esc_attr($attachment_id); ?>">
						<?php
						echo wp_get_attachment_image($product->get_image_id(), 'full', false, array(
							'class' => 'rounded-lg pix-fit-cover',
						));
						?>
					</div>
				</div>

			</div>
<?php
		}
	}
}
