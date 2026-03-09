<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<?php
$pix_overlay = 'pix-overlay-2';
if (pix_get_option('search-style')) {
	$pix_overlay = 'pix-overlay-' . pix_get_option('search-style');
}
function pixfort_search_body_class($classes) {
	$classes[] = 'demo-6 render';
	return $classes;
}
add_filter('body_class', 'pixfort_search_body_class');

$place_bg = '';
$place_style = '';
if (pix_get_option('pix-sticky-footer')) {
	if (pix_get_option('pix-body-bg-color')) {
		if (pix_get_option('pix-body-bg-color') != 'custom') {
			$place_bg = ' bg-' . pix_get_option('pix-body-bg-color');
		} else {
			$place_style .= 'background: ' . pix_get_option('custom-body-bg-color') . ';';
		}
	}
}
?>
<body <?php body_class(); ?> pix-overlay="<?php echo esc_html($pix_overlay); ?>">
	<div id="page" class="site <?php echo esc_attr($place_bg); ?>" style="<?php echo esc_attr($place_style); ?>">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'conseil'); ?></a>

		<div id="content" class="site-content">
			<div class="container-fluid px-0 mx-0">
				<div class="row">

					<div class="col-12">
						<main id="main" class="site-main content-area">
							<?php
							the_post();
							the_content();
							?>
						</main>
					</div>
					<?php
					wp_footer();
					?>