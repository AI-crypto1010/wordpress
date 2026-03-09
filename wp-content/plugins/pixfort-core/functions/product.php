<?php

/**
 * Add product page layouts into product settings
 */
function pix_add_custom_product_layout() {

	woocommerce_wp_text_input(array(
		'id'                => 'pix_sale_text',
		'value'             => get_post_meta(get_the_ID(), 'pix_sale_text', true),
		'label'             => 'Sale badge text (optional)',
		'description'       => 'replace the default <strong>Sale!</strong> text with custom text, leave empty to use default.'
	));

	$args = array(
		'id' => 'pix_single_product_layout', // required. The meta_key ID for the stored value
		'wrapper_class' => '', // a custom wrapper class if needed
		'desc_tip' => true, // makes your description show up with a "?" symbol and as a tooltip
		'description' => __('Override theme product layout for this product.', 'your_text_domain'),
		'label' => __('Product page layout', 'your_text_domain'),
		'options' => array(
			''		=> 'Use global theme layout',
			'default'		=> 'Gallery',
			'pix-boxed-2'		=> 'Gallery - Boxed description',
			'layout-2'			=> 'Full',
			'layout-3'			=> 'Full - Boxed description',
		)
	);
	woocommerce_wp_select($args);
}
add_action('woocommerce_product_options_advanced', 'pix_add_custom_product_layout');

/**
 * Save custom product page layout settings
 */
function pix_save_custom_product_layout($post_id) {
	// grab the custom SKU from $_POST
	$custom_sku = isset($_POST['pix_single_product_layout']) ? sanitize_text_field($_POST['pix_single_product_layout']) : '';
	$pix_sale_text = isset($_POST['pix_sale_text']) ? sanitize_text_field($_POST['pix_sale_text']) : '';

	// grab the product
	$product = wc_get_product($post_id);

	// save the custom SKU using WooCommerce built-in functions
	$product->update_meta_data('pix_single_product_layout', $custom_sku);
	$product->update_meta_data('pix_sale_text', $pix_sale_text);
	$product->save();
}
add_action('woocommerce_process_product_meta', 'pix_save_custom_product_layout');
