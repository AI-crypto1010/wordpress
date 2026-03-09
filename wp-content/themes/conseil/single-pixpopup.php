<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body class="render">
	<?php

	$size = 'col-12 col-sm-6';
	$width = '';
	if (!empty(get_post_meta(get_the_ID(), 'pix-popup-size', true))) {
		if (get_post_meta(get_the_ID(), 'pix-popup-size', true) == 'custom') {
			$size = '';
			$width = 'width:' . get_post_meta(get_the_ID(), 'pix-popup-width', true) . ';';
		} else {
			$size = get_post_meta(get_the_ID(), 'pix-popup-size', true);
		}
	}

	switch ($size) {
		case 'col-12 col-sm-4':
			$size .= ' offset-sm-4';
			break;
		case 'col-12 col-sm-6':
			$size .= ' offset-sm-3';
			break;
		case 'col-12 col-sm-8':
			$size .= ' offset-sm-2';
			break;
		case 'col-12 col-sm-10':
			$size .= ' offset-sm-1';
			break;
	}


	$built_with_elementor = false;
	$popup = get_the_ID();
	$popupClasses = '';
	$launcherClasses = '';
	$popupData = get_post_meta($popup, 'pix-popup-data', true);
	if (is_array($popupData)) {
		if (array_key_exists('popupClasses', $popupData)) $popupClasses = $popupData['popupClasses'];
		if (array_key_exists('launcherClasses', $popupData)) $launcherClasses = $popupData['launcherClasses'];
	}


	$closeIcon = 'duotone/pixfort-icon-cross-circle-1';
	if (get_post_meta($popup, 'pix-close-icon', true)) {
		$closeIcon = get_post_meta($popup, 'pix-close-icon', true);
	}
	$popupDisplayID = '1';
	if (get_post_meta($popup, 'pix-popup-id', true)) {
		$popupDisplayID = get_post_meta($popup, 'pix-popup-id', true);
	}

	$itemsOptions = [];
	$itemOptions = [];
	$popupData = get_post_meta( $popup, 'pix-popup-data', true );
	if(is_array($popupData)) {
		if(array_key_exists('popupOptions', $popupData)) $itemOptions = array_merge($itemOptions, $popupData['popupOptions']);
		if(array_key_exists('launcherOptions', $popupData)) $itemOptions = array_merge($itemOptions, $popupData['launcherOptions']);
	} 
	if(!empty($itemOptions)){
		$itemsOptions[$popup] = $itemOptions;
	}
	wp_localize_script( 'pix-main-pixfort', 'PIX_POPUPS_OPTIONS', $itemsOptions );
	if (defined('PIX_CORE_PLUGIN_DIR')) { 
	?>
	<div id="page" class="site pix-popup-editor">
		<div id="content" class="site-content bg-dark-opacity-6 h-100 w-100 d-inline-block" style="height:100% !important;">

			<?php 

			if (class_exists('PixfortCore')) {
				PixfortCore::instance()->popupType->print_editor_popup($popup);
			} else {
				?>
				<div class="container">
					<div class="row">
						<div class="<?php echo esc_attr($size); ?> p-0" style="<?php echo esc_html($width); ?>">
							<div id="pix-popup-builder-content" class="pix-my-200 bg-white rounded-lg d-inline-block w-100 position-relative pix-popup-edit">
								<?php
								the_post();
								the_content();
								?>
							</div>
						</div>


						<div class="modal fade" id="pixfortPopupBuilder" tabindex="-1" role="dialog" aria-labelledby="pixfortPopupBuilder" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content" style="position:relative">
									<div class="modal-body">

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
			wp_enqueue_script('pix-popup-editor', get_template_directory_uri() . '/js/popup-editor.js', array('jquery'), PIXFORT_THEME_VERSION, true);
			wp_enqueue_style('pix-popup-editor', get_template_directory_uri() . '/css/popup-editor.css', false, PIXFORT_THEME_VERSION, 'all');
			wp_footer();
			?>