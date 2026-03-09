<?php

/**
 * Main media sizes
 */
if (! function_exists('pix_add_image_sizes')) {
	function pix_add_image_sizes() {
		add_image_size('pix-blog-small', 622, 400, true);
		add_image_size('pix-portfolio-small', 600, 450, true);
		add_image_size('pix-big', 600, 450, true);
		add_image_size('pix-woocommerce-xs', 75, 75, true);
		add_image_size('pix-woocommerce-md', 460, 460, true);
	}
}
add_action('after_setup_theme', 'pix_add_image_sizes');
add_action('after_switch_theme', 'pix_add_image_sizes');
