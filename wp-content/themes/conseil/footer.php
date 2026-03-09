<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pixfort theme
 */
wp_reset_postdata();
wp_reset_query();
$pix_sticky = '';
$pix_sticky_bg = '';
$pix_sticky_color = '';
$place_bg = '';
$place_style = '';
$post_type = get_post_type();
$bg_color = '';
if($post_type == 'post') {
	$bg_color = 'bg-' . pix_get_option('blog-bg-color');
} elseif($post_type == 'page') {
	$bg_color = 'bg-' . pix_get_option('pages-bg-color');
} elseif($post_type == 'portfolio') {
	$bg_color = 'bg-' . pix_get_option('portfolio-bg-color');
}

if (pix_get_option('pix-sticky-footer')) {
	$pix_sticky = 'pix-sticky-footer';
	if (pix_get_option('sticky-footer-bg-color')) {
		$pix_sticky_bg = pix_get_option('sticky-footer-bg-color');
		if (pix_get_option('sticky-footer-bg-color') == 'custom' && pix_get_option('custom-sticky-footer-bg-color')) {
			$pix_sticky_color = pix_get_option('custom-sticky-footer-bg-color');
		}
	}
	if (pix_get_option('pix-body-bg-color')) {
		if (pix_get_option('pix-body-bg-color') != 'custom') {
			$place_bg = ' bg-' . pix_get_option('pix-body-bg-color');
		} else {
			$place_style .= 'background: ' . pix_get_option('custom-body-bg-color') . ';';
		}
	}
?>
<div class="pix-footer-sticky-placeholder <?php echo esc_attr($place_bg); ?> w-100 d-block" style="<?php echo esc_attr($place_style); ?>"></div>
<?php
}
$footer = false;

/*
 * Footer set by Theme builder conditions
 */
if (class_exists('PixfortCore')) {
	$footers = \PixfortCore::instance()->areasManager->getLocationTemplates('footer');
	if (!empty($footers[0])) {
		$footer = $footers[0];
	}
}

if (!$footer && !empty(pix_get_option('pix-footer'))) {
	$footer = pix_get_option('pix-footer');
}

if (!is_search()) {
	$pagePostTypes = array('page', 'post', 'portfolio');
	$pagePostTypes = apply_filters('pixfort_page_options_post_types', $pagePostTypes);
	if (in_array($post_type, $pagePostTypes) && get_post_meta(get_queried_object_id(), 'pix-page-footer', true)) {
		if (get_post_meta(get_queried_object_id(), 'pix-page-footer', true) !== 'default') {
			if(get_post_meta(get_queried_object_id(), 'pix-page-footer', true) == 'disable') {
				$footer = 'disable';
			} else {
				$footer = get_post_meta(get_queried_object_id(), 'pix-page-footer', true);
			}
		}
	}
}
if (is_404()) {
	if (!empty(pix_get_option('pix-enable-custom-404')) && !empty(pix_get_option('pix-custom-404-page'))) {
		$custom404 = pix_get_option('pix-custom-404-page');
		if (function_exists('icl_get_languages')) {
			$custom404 = apply_filters('wpml_object_id', $custom404, 'page', true);
		}
		if ($custom404 && get_post_meta($custom404, 'pix-page-footer', true)) {
			$footer = get_post_meta($custom404, 'pix-page-footer', true);
		}
	}
}
if ($footer == 'disable') {
	$footer = false;
}
if (get_post_type() === 'elementor_library') {
	$footer = false;
}



if ($footer) {
	if (class_exists('\Elementor\Plugin')) {
		// Hide footer if Elementor maintenance mode is active
		$elementor_maintenance_mode = get_option('elementor_maintenance_mode_mode');
		if (!is_user_logged_in() && !empty($elementor_maintenance_mode) && $elementor_maintenance_mode !== 'disabled') {
			$footer = false;
		} else {
			$footerID = $footer;
			if (function_exists('icl_get_languages')) {
				$footerID = apply_filters('wpml_object_id', $footer, 'page', true);
			}
		}		
	}
}
?>
<footer id="pix-page-footer" class="site-footer2 <?php echo esc_attr($pix_sticky); ?> my-0 py-0 <?php echo esc_attr($bg_color); ?>" data-sticky-bg="<?php echo esc_attr($pix_sticky_bg); ?>" data-sticky-color="<?php echo esc_attr($pix_sticky_color); ?>">
	<?php 
	if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('footer')) {
		elementor_theme_do_location('footer');
		$footer = false;
	}
	if ($footer) {
		if (function_exists('icl_get_languages')) {
			$correct_id = apply_filters('wpml_object_id', $footer, 'page', true);
			$footer = $correct_id;
			$post = get_post($correct_id);
		} else {
			$post = get_post($footer);
		}

		// Elementor
		if (get_post_status($footer)) {
			if (get_post_type($footer) === 'pixfooter') {
				setup_postdata($footer);
				if (!empty(pix_get_option('pix-enable-elementor-loader')) && pix_get_option('pix-enable-elementor-loader')) {
					if (class_exists('\Elementor\Plugin')) {
						echo \Elementor\plugin::instance()->frontend->get_builder_content($footer, true);
					}
				} else {
					the_content();
				}
			}
		}
		wp_reset_postdata();
	}
	?>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>