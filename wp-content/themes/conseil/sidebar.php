<?php

/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pixfort theme
 */

global $post;
global $woocommerce;
$sidebar_id = 'sidebar-1';

$pagetype = get_post_type($post);

$order = '';
if ($woocommerce && is_shop() || $woocommerce && is_product_category() || $woocommerce && is_product_tag()) {
	if (!empty(pix_get_option('shop-layout')) && pix_get_option('shop-layout') == 'left-sidebar') {
		$order = 'order-sm-1';
	}
}
$sticky_class = 'sticky-bottom';

$pagePostTypes = array('page');
$pagePostTypes = apply_filters('pixfort_page_options_post_types', $pagePostTypes);

if (pix_get_option('sidebar-page-sticky')) {
	$sticky_class = pix_get_option('sidebar-page-sticky');
}

// Get the appropriate page ID based on context
$page_id = get_queried_object_id();
if ($page_id === 0 && $woocommerce && is_shop()) {
    $page_id = wc_get_page_id('shop');
}

if (get_post_meta($page_id, 'pix-page-sidebar-sticky', true)) {
	if (get_post_meta($page_id, 'pix-page-sidebar-sticky', true) !== '' && get_post_meta($page_id, 'pix-page-sidebar-sticky', true) !== 'default') {
		$sticky_class = get_post_meta($page_id, 'pix-page-sidebar-sticky', true);
	}
}
if($sticky_class === 'sticky-top'){
	$sticky_class .= ' pix-sticky-top-adjust';
}

if (!function_exists('pix_sanitize_sidebar')) {
	function pix_sanitize_sidebar($id) {
		$id = str_replace(' ', '', strtolower($id));
		$id = preg_replace('/[^A-Za-z0-9\-]/', '', $id);
		$id = sanitize_title($id);
		return $id;
	}
}
?>
<div class="sidebar col-12 col-md-4 <?php echo esc_html($order); ?>">
	<div class="w-100 h-100 d-flex align-items-start">
		<aside id="secondary" class="widget-area d-flex flex-column <?php echo esc_attr($sticky_class); ?> pix-sticky-sidebar pix-boxed-widgets w-100 pix-pb-30 pix-sidebar-adjust">
			<?php
			if (function_exists('dynamic_sidebar')) {
				if ($woocommerce && is_shop() || $woocommerce && is_product_category() || $woocommerce && is_product_tag() || $woocommerce && is_product()) {
					if (get_post_meta($page_id, 'pix-page-sidebar', true) !== '' && get_post_meta($page_id, 'pix-page-sidebar', true) !== 'default') {
						$sidebar_id = get_post_meta($page_id, 'pix-page-sidebar', true);
					} else {
						if (pix_get_option('sidebar-shop')) {
							$sidebar_id = pix_get_option('sidebar-shop');
						}
					}
					$sidebar_id = pix_sanitize_sidebar($sidebar_id);
					dynamic_sidebar($sidebar_id);
				} elseif ((is_search() || (is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag()))) {
					if ($pagetype === 'post' || is_search()) {

						if (pix_get_option('sidebar-blog')) {
							$sidebar_id = pix_get_option('sidebar-blog');
						}
					} elseif ($pagetype === 'portfolio') {
						if (pix_get_option('sidebar-portfolio')) {
							$sidebar_id = pix_get_option('sidebar-portfolio');
						}
					} else {
						if (in_array($pagetype, $pagePostTypes)) {
							if (get_post_meta($page_id, 'pix-page-sidebar', true) !== '' && get_post_meta($page_id, 'pix-page-sidebar', true) !== 'default') {
								$sidebar_id = get_post_meta($page_id, 'pix-page-sidebar', true);
							} else {
								if (pix_get_option('sidebar-page')) {
									$sidebar_id = pix_get_option('sidebar-page');
								}
							}
						}
					}
					$sidebar_id = pix_sanitize_sidebar($sidebar_id);
					dynamic_sidebar($sidebar_id);
					
				} elseif (is_page_template(
					array(
						'templates/template-blog-right-sidebar.php',
						'templates/template-blog-left-sidebar.php'
					)
				)) {
					if (get_post_meta($page_id, 'pix-page-sidebar', true) !== '' && get_post_meta($page_id, 'pix-page-sidebar', true) !== 'default') {
						$sidebar_id = get_post_meta($page_id, 'pix-page-sidebar', true);
					} else {
						if (pix_get_option('sidebar-blog')) {
							$sidebar_id = pix_get_option('sidebar-blog');
						}
					}
					$sidebar_id = pix_sanitize_sidebar($sidebar_id);
					dynamic_sidebar($sidebar_id);
				} elseif (is_page_template(
					array(
						'templates/template-right-sidebar.php',
						'templates/template-left-sidebar.php'
					)
				)) {
					if (pix_get_option('sidebar-page')) {
						$sidebar_id = pix_get_option('sidebar-page');
					}
					if (get_post_type() == 'page' && get_post_meta($page_id, 'pix-page-sidebar', true) !== '' && get_post_meta($page_id, 'pix-page-sidebar', true) !== 'default') {
						$sidebar_id = get_post_meta($page_id, 'pix-page-sidebar', true);
					}
					$sidebar_id = pix_sanitize_sidebar($sidebar_id);
					dynamic_sidebar($sidebar_id);
				} elseif ($woocommerce && is_shop() || $woocommerce && is_product_category() || $woocommerce && is_product_tag() || $woocommerce && is_product()) {
					if (pix_get_option('sidebar-shop')) {
						$sidebar_id = pix_get_option('sidebar-shop');
					}
					$sidebar_id = pix_sanitize_sidebar($sidebar_id);
					dynamic_sidebar($sidebar_id);
				} else {
					dynamic_sidebar('sidebar-1');
				}
			}
			?>
		</aside>
	</div>
</div>