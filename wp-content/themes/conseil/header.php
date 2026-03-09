<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<?php wp_head(); ?>
</head>
<?php
$body_style = '';
if (pix_get_option('pix-body-bg-color')) {
	if (pix_get_option('pix-body-bg-color') == 'custom') {
		$body_style .= 'background: ' . pix_get_option('custom-body-bg-color') . ';';
	}
}
$pageTransitionLoading = true;
if (!empty(pix_get_option('site-disable-loading-icon'))) {
	if (pix_get_option('site-disable-loading-icon')) {
		$pageTransitionLoading = false;
	}
}
$bodyClasses = '';
if (!empty(pix_get_option('enable-view-transition'))) {
	if (pix_get_option('enable-view-transition')) {
		$bodyClasses = 'pixfort-page-transition';
	}
}
if(defined('PIX_DEV')){
	if (pix_get_option('enable-live-customizer')) {
		$bodyClasses .= ' pix-live-customizer';
	}
}

?>
<body <?php body_class($bodyClasses); ?> style="<?php echo esc_attr($body_style); ?>">
	<?php wp_body_open(); ?>
	<?php if (pix_get_option('site-page-transition')!=='disable-page-transition') {?>
	<div class="pix-page-loading-bg"></div>
	<?php } ?>
	<?php
	if ($pageTransitionLoading) {
		get_template_part('template-parts/loading');
	}
	if (pix_get_option('show-banner')) {
		if (pix_show_banner()) {
			get_template_part('template-parts/banner');
		}
	}
	$pageClasses = 'site';
	$pageClasses = apply_filters('pixfort_page_classes', $pageClasses);
	?>
	<div id="page" class="<?php echo esc_attr($pageClasses); ?>">
		<?php
		if (get_post_type() !== 'elementor_library') {
			if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('header')) {
				elementor_theme_do_location('header');
			} else {
				do_action( 'pixfort_location_header' );
			}
		}
