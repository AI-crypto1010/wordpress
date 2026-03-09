<?php

/**
 *
 * @package pixfort-core
 * @author pixfort
 * @link https://pixfort.com
 */


// Prevent WP from adding <p> tags on all post types
function disable_wp_auto_p($content) {
	$mainTypes = array('post', 'page');
	if (in_array(get_post_type(), $mainTypes)) {
		$removeAutop = true;
		if (get_post_type() === 'post') {
			if (!empty(pix_plugin_get_option('pix-enable-blog-line-breaks')) && pix_plugin_get_option('pix-enable-blog-line-breaks')) {
				$removeAutop = false;
			}
		} else if (get_post_type() === 'page') {
			if (!empty(pix_plugin_get_option('pix-enable-page-line-breaks')) && pix_plugin_get_option('pix-enable-page-line-breaks')) {
				$removeAutop = false;
			}
		}
		if ($removeAutop) {
			remove_filter('the_content', 'wpautop');
			remove_filter('the_excerpt', 'wpautop');
		}
	}
	return $content;
}
add_filter('the_content', 'disable_wp_auto_p', 0);

if (!function_exists('pix_add_params_to_group')) {
	function pix_add_params_to_group($params, $group) {
		if (!empty($group)) {
			$res = array();
			foreach ($params as $key => $value) {
				$value['group'] = $group;
				array_push($res, $value);
			}
			return $res;
		}
		return $params;
	}
}

if (!function_exists('pix_get_wpb_carousel_navigation_params')) {
	function pix_get_wpb_carousel_navigation_params($colors = array(), $colors_with_transparent = array()) {
		if (
			!defined('PIXFORT_SLIDER_SWIPER') ||
			!class_exists('\PixfortCore') ||
			!\PixfortCore::instance()->getThemeParam('carousel_navigation_buttons_options')
		) {
			return array();
		}

		if (!is_array($colors)) {
			$colors = array();
		}
		if (!is_array($colors_with_transparent)) {
			$colors_with_transparent = array();
		}

		return array(
			array(
				'param_name' 	=> 'navigation_spacing',
				'type' 			=> 'textfield',
				'heading' 		=> __('Navigation Spacing (Desktop)', 'pixfort-core'),
				'description' 	=> __('Distance from slider edge (e.g. 80 or 5%).', 'pixfort-core'),
				'admin_label'	=> false,
				'group' 		=> __('Navigation Buttons', 'pixfort-core'),
				"dependency" 	=> array(
					"element" => "prevnextbuttons",
					"not_empty" => true
				),
			),
			array(
				'param_name' 	=> 'navigation_spacing_mobile',
				'type' 			=> 'textfield',
				'heading' 		=> __('Navigation Spacing (Mobile)', 'pixfort-core'),
				'description' 	=> __('Optional mobile value (e.g. 40 or 8%).', 'pixfort-core'),
				'admin_label'	=> false,
				'group' 		=> __('Navigation Buttons', 'pixfort-core'),
				"dependency" 	=> array(
					"element" => "prevnextbuttons",
					"not_empty" => true
				),
			),
			array(
				'param_name' 	=> 'navigation_color',
				'type' 			=> 'dropdown',
				'heading' 		=> __('Navigation color', 'pixfort-core'),
				'admin_label'	=> false,
				'value' 		=> array_merge(
					array(__('Default', 'pixfort-core') => ''),
					$colors
				),
				'group' 		=> __('Navigation Buttons', 'pixfort-core'),
				"dependency" 	=> array(
					"element" => "prevnextbuttons",
					"not_empty" => true
				),
			),
			array(
				'param_name' 	=> 'custom_navigation_color',
				'type' 			=> 'colorpicker',
				'heading' 		=> __('Custom Navigation Color', 'pixfort-core'),
				'admin_label'	=> false,
				'group' 		=> __('Navigation Buttons', 'pixfort-core'),
				"dependency" 	=> array(
					"element" => "navigation_color",
					"value" => "custom"
				),
			),
			array(
				'param_name' 	=> 'navigation_bg_color',
				'type' 			=> 'dropdown',
				'heading' 		=> __('Background color', 'pixfort-core'),
				'admin_label'	=> false,
				'value' 		=> array_merge(
					array(__('Default', 'pixfort-core') => ''),
					$colors_with_transparent
				),
				'group' 		=> __('Navigation Buttons', 'pixfort-core'),
				"dependency" 	=> array(
					"element" => "prevnextbuttons",
					"not_empty" => true
				),
			),
			array(
				'param_name' 	=> 'custom_navigation_bg_color',
				'type' 			=> 'colorpicker',
				'heading' 		=> __('Custom Background Color', 'pixfort-core'),
				'admin_label'	=> false,
				'group' 		=> __('Navigation Buttons', 'pixfort-core'),
				"dependency" 	=> array(
					"element" => "navigation_bg_color",
					"value" => "custom"
				),
			),
			array(
				'param_name' 	=> 'navigation_border_color',
				'type' 			=> 'dropdown',
				'heading' 		=> __('Border color', 'pixfort-core'),
				'admin_label'	=> false,
				'value' 		=> array_merge(
					array(__('Default', 'pixfort-core') => ''),
					$colors_with_transparent
				),
				'group' 		=> __('Navigation Buttons', 'pixfort-core'),
				"dependency" 	=> array(
					"element" => "prevnextbuttons",
					"not_empty" => true
				),
			),
			array(
				'param_name' 	=> 'custom_navigation_border_color',
				'type' 			=> 'colorpicker',
				'heading' 		=> __('Custom Border Color', 'pixfort-core'),
				'admin_label'	=> false,
				'group' 		=> __('Navigation Buttons', 'pixfort-core'),
				"dependency" 	=> array(
					"element" => "navigation_border_color",
					"value" => "custom"
				),
			),
			array(
				'param_name' 	=> 'navigation_size',
				'type' 			=> 'textfield',
				'heading' 		=> __('Button Size', 'pixfort-core'),
				'description' 	=> __('Set button size in px (e.g. 48).', 'pixfort-core'),
				'admin_label'	=> false,
				'group' 		=> __('Navigation Buttons', 'pixfort-core'),
				"dependency" 	=> array(
					"element" => "prevnextbuttons",
					"not_empty" => true
				),
			),
			array(
				'param_name' 	=> 'navigation_icon_size',
				'type' 			=> 'textfield',
				'heading' 		=> __('Icon Size', 'pixfort-core'),
				'description' 	=> __('Set icon size in px (e.g. 26).', 'pixfort-core'),
				'admin_label'	=> false,
				'group' 		=> __('Navigation Buttons', 'pixfort-core'),
				"dependency" 	=> array(
					"element" => "prevnextbuttons",
					"not_empty" => true
				),
			),
			array(
				'param_name' 	=> 'navigation_border_size',
				'type' 			=> 'textfield',
				'heading' 		=> __('Border Size', 'pixfort-core'),
				'description' 	=> __('Set border width in px (e.g. 2).', 'pixfort-core'),
				'admin_label'	=> false,
				'group' 		=> __('Navigation Buttons', 'pixfort-core'),
				"dependency" 	=> array(
					"element" => "prevnextbuttons",
					"not_empty" => true
				),
			),
			array(
				'param_name' 	=> 'navigation_border_radius',
				'type' 			=> 'textfield',
				'heading' 		=> __('Border Radius', 'pixfort-core'),
				'description' 	=> __('Set radius (e.g. 50% or 24).', 'pixfort-core'),
				'admin_label'	=> false,
				'group' 		=> __('Navigation Buttons', 'pixfort-core'),
				"dependency" 	=> array(
					"element" => "prevnextbuttons",
					"not_empty" => true
				),
			),
			array(
				"type" => "dropdown",
				"heading" => __("Shadow Style", "pixfort-core"),
				"param_name" => "navigation_shadow_style",
				"admin_label" => false,
				"value" => array_flip(array(
					"" => "Default",
					"1" => "Small shadow",
					"2" => "Medium shadow",
					"3" => "Large shadow",
					"4" => "Inverse Small shadow",
					"5" => "Inverse Medium shadow",
					"6" => "Inverse Large shadow",
				)),
				'group' => __('Navigation Buttons', 'pixfort-core'),
				"dependency" 	=> array(
					"element" => "prevnextbuttons",
					"not_empty" => true
				),
			),
			array(
				"type" => "dropdown",
				"heading" => __("Shadow Hover Style", "pixfort-core"),
				"param_name" => "navigation_hover_effect",
				"admin_label" => false,
				"value" => array_flip(array(
					"" => "None",
					"1" => "Small hover shadow",
					"2" => "Medium hover shadow",
					"3" => "Large hover shadow",
					"4" => "Inverse Small hover shadow",
					"5" => "Inverse Medium hover shadow",
					"6" => "Inverse Large hover shadow",
				)),
				'group' => __('Navigation Buttons', 'pixfort-core'),
				"dependency" 	=> array(
					"element" => "prevnextbuttons",
					"not_empty" => true
				),
			),
		);
	}
}


/* ---------------------------------------------------------------------------
* Shortcodes | Visual Composer Map:
* --------------------------------------------------------------------------- */
// if (is_user_logged_in()) {
// 	require_once('vc_templates/custom/main.php');
// }

if (class_exists('PixfortHub')) {
	$status = PixfortHub::checkValidation();
	if ($status) {
		add_action('vc_before_init_vc', 'pix_vc_integration');
	}
}

if (!function_exists('pix_vc_integration')) {
	function pix_vc_integration() {
		$parent_tag = vc_post_param('parent_tag', '');
		$include_icon_params = (('vc_tta_pageable' !== $parent_tag) && 'tabs22' !== $parent_tag);

		if ($include_icon_params) {
			require_once vc_path_dir('CONFIG_DIR', 'content/vc-icon-element.php');
		}

		$colors = array(
			"Body default"			=> "body-default",
			"Heading default"		=> "heading-default",
			"Primary"				=> "primary",
			"Primary Gradient"		=> "gradient-primary",
			"Secondary"				=> "secondary",
			"White"					=> "white",
			"Black"					=> "black",
			"Green"					=> "green",
			"Blue"					=> "blue",
			"Red"					=> "red",
			"Yellow"				=> "yellow",
			"Brown"					=> "brown",
			"Purple"				=> "purple",
			"Orange"				=> "orange",
			"Cyan"					=> "cyan",
			"Gray 1"				=> "gray-1",
			"Gray 2"				=> "gray-2",
			"Gray 3"				=> "gray-3",
			"Gray 4"				=> "gray-4",
			"Gray 5"				=> "gray-5",
			"Gray 6"				=> "gray-6",
			"Gray 7"				=> "gray-7",
			"Gray 8"				=> "gray-8",
			"Gray 9"				=> "gray-9",
			"Dark opacity 1"		=> "dark-opacity-1",
			"Dark opacity 2"		=> "dark-opacity-2",
			"Dark opacity 3"		=> "dark-opacity-3",
			"Dark opacity 4"		=> "dark-opacity-4",
			"Dark opacity 5"		=> "dark-opacity-5",
			"Dark opacity 6"		=> "dark-opacity-6",
			"Dark opacity 7"		=> "dark-opacity-7",
			"Dark opacity 8"		=> "dark-opacity-8",
			"Dark opacity 9"		=> "dark-opacity-9",
			"Light opacity 1"		=> "light-opacity-1",
			"Light opacity 2"		=> "light-opacity-2",
			"Light opacity 3"		=> "light-opacity-3",
			"Light opacity 4"		=> "light-opacity-4",
			"Light opacity 5"		=> "light-opacity-5",
			"Light opacity 6"		=> "light-opacity-6",
			"Light opacity 7"		=> "light-opacity-7",
			"Light opacity 8"		=> "light-opacity-8",
			"Light opacity 9"		=> "light-opacity-9",
			"Custom"				=> "custom"
		);

		$colors_with_transparent = $colors = array(
			"Body default"			=> "body-default",
			"Heading default"		=> "heading-default",
			"Primary"				=> "primary",
			"Primary Gradient"		=> "gradient-primary",
			"Secondary"				=> "secondary",
			"White"					=> "white",
			"Black"					=> "black",
			"Green"					=> "green",
			"Blue"					=> "blue",
			"Red"					=> "red",
			"Yellow"				=> "yellow",
			"Brown"					=> "brown",
			"Purple"				=> "purple",
			"Orange"				=> "orange",
			"Cyan"					=> "cyan",
			"Transparent"					=> "transparent",
			"Gray 1"				=> "gray-1",
			"Gray 2"				=> "gray-2",
			"Gray 3"				=> "gray-3",
			"Gray 4"				=> "gray-4",
			"Gray 5"				=> "gray-5",
			"Gray 6"				=> "gray-6",
			"Gray 7"				=> "gray-7",
			"Gray 8"				=> "gray-8",
			"Gray 9"				=> "gray-9",
			"Dark opacity 1"		=> "dark-opacity-1",
			"Dark opacity 2"		=> "dark-opacity-2",
			"Dark opacity 3"		=> "dark-opacity-3",
			"Dark opacity 4"		=> "dark-opacity-4",
			"Dark opacity 5"		=> "dark-opacity-5",
			"Dark opacity 6"		=> "dark-opacity-6",
			"Dark opacity 7"		=> "dark-opacity-7",
			"Dark opacity 8"		=> "dark-opacity-8",
			"Dark opacity 9"		=> "dark-opacity-9",
			"Light opacity 1"		=> "light-opacity-1",
			"Light opacity 2"		=> "light-opacity-2",
			"Light opacity 3"		=> "light-opacity-3",
			"Light opacity 4"		=> "light-opacity-4",
			"Light opacity 5"		=> "light-opacity-5",
			"Light opacity 6"		=> "light-opacity-6",
			"Light opacity 7"		=> "light-opacity-7",
			"Light opacity 8"		=> "light-opacity-8",
			"Light opacity 9"		=> "light-opacity-9",
			"Custom"				=> "custom"
		);

		$colors_no_custom = $colors;
		unset($colors_no_custom['Custom']);

		$bg_colors = array(
			"Primary"				=> "primary",
			"Primary Light"			=> "primary-light",
			"Primary Gradient"		=> "gradient-primary",
			"Primary Gradient Light"		=> "gradient-primary-light",
			"Secondary"				=> "secondary",
			"Secondary Light"		=> "secondary-light",
			"Heading default"		=> "heading-default",
			"Body default"		=> "body-default",
			"White"					=> "white",
			"Black"					=> "black",
			"Green"					=> "green",
			"Green Light"			=> "green-light",
			"Blue"					=> "blue",
			"Blue Light"			=> "blue-light",
			"Red"					=> "red",
			"Red Light"				=> "red-light",
			"Yellow"				=> "yellow",
			"Yellow Light"			=> "yellow-light",
			"Brown"					=> "brown",
			"Brown Light"			=> "brown-light",
			"Purple"				=> "purple",
			"Purple Light"			=> "purple-light",
			"Orange"				=> "orange",
			"Orange Light"			=> "orange-light",
			"Cyan"					=> "cyan",
			"Cyan Light"			=> "cyan-light",
			"Transparent"			=> "transparent",
			"Gray 1"				=> "gray-1",
			"Gray 2"				=> "gray-2",
			"Gray 3"				=> "gray-3",
			"Gray 4"				=> "gray-4",
			"Gray 5"				=> "gray-5",
			"Gray 6"				=> "gray-6",
			"Gray 7"				=> "gray-7",
			"Gray 8"				=> "gray-8",
			"Gray 9"				=> "gray-9",
			"Dark opacity 1"		=> "dark-opacity-1",
			"Dark opacity 2"		=> "dark-opacity-2",
			"Dark opacity 3"		=> "dark-opacity-3",
			"Dark opacity 4"		=> "dark-opacity-4",
			"Dark opacity 5"		=> "dark-opacity-5",
			"Dark opacity 6"		=> "dark-opacity-6",
			"Dark opacity 7"		=> "dark-opacity-7",
			"Dark opacity 8"		=> "dark-opacity-8",
			"Dark opacity 9"		=> "dark-opacity-9",
			"Light opacity 1"		=> "light-opacity-1",
			"Light opacity 2"		=> "light-opacity-2",
			"Light opacity 3"		=> "light-opacity-3",
			"Light opacity 4"		=> "light-opacity-4",
			"Light opacity 5"		=> "light-opacity-5",
			"Light opacity 6"		=> "light-opacity-6",
			"Light opacity 7"		=> "light-opacity-7",
			"Light opacity 8"		=> "light-opacity-8",
			"Light opacity 9"		=> "light-opacity-9",
			"Custom"				=> "custom"
		);

		require_once('elements/global-params.php');
		if (is_user_logged_in()) {
			require_once('elements/shortcode-accordion.php');
			require_once('elements/shortcode-animated-heading.php');
			require_once('elements/shortcode-alert.php');
			require_once('elements/shortcode-auto-video.php');
			require_once('elements/shortcode-badge.php');
			require_once('elements/shortcode-button.php');
			require_once('elements/shortcode-blog.php');
			require_once('elements/shortcode-blog-slider.php');
			require_once('elements/shortcode-breadcrumbs.php');
			require_once('elements/shortcode-card.php');
			// require_once( 'elements/shortcode-card-group.php' );
			require_once('elements/shortcode-card-wide.php');
			require_once('elements/shortcode-circles.php');
			require_once('elements/shortcode-comparison-table.php');
			require_once('elements/shortcode-content-box.php');
			require_once('elements/shortcode-content-stack.php');
			require_once('elements/shortcode-content-tabs.php');
			require_once('elements/shortcode-countdown.php');
			require_once('elements/shortcode-chart.php');
			require_once('elements/shortcode-clients.php');
			require_once('elements/shortcode-clients-slider.php');
			require_once('elements/shortcode-cta.php');
			require_once('elements/shortcode-event.php');
			require_once('elements/shortcode-3d-box.php');
			require_once('elements/shortcode-fancybox.php');
			require_once('elements/shortcode-fancy-mockup.php');
			require_once('elements/shortcode-faq.php');
			require_once('elements/shortcode-feature.php');
			require_once('elements/shortcode-feature-list.php');
			require_once('elements/shortcode-gallery.php');
			require_once('elements/shortcode-heading.php');
			require_once('elements/shortcode-highlight-box.php');
			require_once('elements/shortcode-highlighted-text.php');
			require_once('elements/shortcode-icon.php');
			require_once('elements/shortcode-img.php');
			require_once('elements/shortcode-img-carousel.php');
			require_once('elements/shortcode-img-box.php');
			require_once('elements/shortcode-img-slider.php');
			require_once('elements/shortcode-levels.php');
			require_once('elements/shortcode-map.php');
			require_once('elements/shortcode-marquee.php');
			require_once('elements/shortcode-dividers.php');
			require_once('elements/shortcode-numbers.php');
			require_once('elements/shortcode-testimonial.php');
			require_once('elements/shortcode-testimonial-masonry.php');
			require_once('elements/shortcode-testimonials-slider.php');
			require_once('elements/shortcode-promo-box.php');
			require_once('elements/shortcode-photo-box.php');
			require_once('elements/shortcode-photo-stack.php');
			require_once('elements/shortcode-pricing.php');
			require_once('elements/shortcode-pricing-group.php');
			require_once('elements/shortcode-products-carousel.php');
			if (class_exists('\PixfortCore') && PixfortCore::instance()->getThemeParam('template_carousel')) {
				require_once('elements/shortcode-template-carousel.php');
			}
			if (defined('PIX_DEV')) {
				require_once('elements/shortcode-global-template.php');
			}
			require_once('elements/shortcode-progress-bars.php');
			require_once('elements/shortcode-portfolio.php');
			require_once('elements/shortcode-portfolio-slider.php');
			require_once('elements/shortcode-review.php');
			require_once('elements/shortcode-reviews-slider.php');
			require_once('elements/shortcode-search.php');
			require_once('elements/shortcode-shop-category.php');
			require_once('elements/shortcode-slider.php');
			require_once('elements/shortcode-sliding-text.php');
			require_once('elements/shortcode-social-icons.php');
			require_once('elements/shortcode-social-share-button.php');
			require_once('elements/shortcode-story.php');
			require_once('elements/shortcode-team-member.php');
			require_once('elements/shortcode-team-member-circle.php');
			require_once('elements/shortcode-text.php');
			require_once('elements/shortcode-advanced-text.php');
			require_once('elements/shortcode-video.php');
			require_once('elements/shortcode-video-popup.php');
			require_once('elements/shortcode-video-slider.php');
			require_once('elements/shortcode-responsive-spacer.php');
			vc_add_params('vc_column_inner', array(
				array(
					'param_name' 	=> 'content_align',
					'type' 			=> 'dropdown',
					'heading' 		=> __('Content align', 'pixfort-core'),
					'admin_label'	=> false,
					'value'			=> array_flip(array(
						'text-left'			=> 'Start',
						'text-center'		=> 'Center',
						'text-right' 		=> 'End',
					)),
				),
			));
		}

		require_once('elements/vc_row.php');
		require_once('elements/vc_section.php');
		require_once('elements/vc_column.php');

		vc_remove_param("vc_separator", "css_animation");
		vc_add_params(
			'vc_separator',
			array(
				array(
					'param_name' 	=> 'animation',
					'type' 			=> 'dropdown',
					'heading' 		=> __('Animation', 'pixfort-core'),
					'description' 	=> __('Select the animation style.', 'pixfort-core'),
					'admin_label'	=> false,
					'value'			=> pix_get_animations(),
				),
				array(
					'param_name' 	=> 'delay',
					'type' 			=> 'textfield',
					'heading' 		=> __('Animation delay (in miliseconds)', 'pixfort-core'),
					'admin_label'	=> true,
					"dependency" => array(
						"element" => "animation",
						"not_empty" => true
					),
				),
			)
		);
		vc_map_update('icon', 'pix-icons');
	}
}

function pix_vc_scripts_front() {
	$isPixfortIcons = true;
	$customIcons = [];
	$customIcons = apply_filters('pixfort_custom_font_icons', $customIcons);
	wp_enqueue_script('pixfort-admin-vc-icons', PIX_CORE_PLUGIN_URI . 'dist/main/wpbakery/wpbakery-icons-selector.js', ['jquery'], PIXFORT_PLUGIN_VERSION, true);
	wp_localize_script('pixfort-admin-vc-icons', 'pixfort_icons_obj', array(
		'ADMIN_LINK' => add_query_arg(array(
			'action' => 'pix_icons_data',
			'nonce' => wp_create_nonce('pix_icons_data')
		), admin_url('admin-ajax.php')),
		'isPixfortIcons' => $isPixfortIcons,
		'CUSTOM_ICONS' => $customIcons
	));
	wp_enqueue_script('pixfort-admin-custom2', PIX_CORE_PLUGIN_URI . 'functions/js/pixfort_vc.min.js', array('jquery'), PLUGIN_VERSION, true);
	wp_enqueue_script('spectrum-picker', PIX_CORE_PLUGIN_URI . 'functions/js/params/spectrum.min.js', array('jquery'), PLUGIN_VERSION, true);
	wp_enqueue_script('pixfort-gradien-picker', PIX_CORE_PLUGIN_URI . 'functions/js/params/grapick.min.js', array('jquery'), PLUGIN_VERSION, true);
	wp_enqueue_style('spectrum-picker', PIX_CORE_PLUGIN_URI . '/functions/js/params/spectrum.min.css', false, PLUGIN_VERSION, 'all');
	wp_enqueue_style('pix-gradient-picker', PIX_CORE_PLUGIN_URI . '/functions/js/params/grapick.min.css', false, PLUGIN_VERSION, 'all');
	$icons_admin = pix_admin_icons();
	$templates = [];
	if (function_exists('pix_get_templates_wpb_thumbs')) {
		$templates = pix_get_templates_wpb_thumbs();
	}
	$translation_array = array(
		'PIX_CORE_PLUGIN_URI' => PIX_CORE_PLUGIN_URI,
		'PIX_ICONS_ADMIN' => $icons_admin,
		'TEMPLATES_ARR'	=> $templates
	);
	//after wp_enqueue_script
	wp_localize_script('pixfort-admin-custom2', 'plugin_object', $translation_array);
	wp_deregister_script('pix-meta');
	wp_deregister_script('pix-meta2');
	wp_deregister_script('pix-options-builder');
}
add_action('vc_frontend_editor_render', 'pix_vc_scripts_front');

function pix_vc_scripts_back() {
	$isPixfortIcons = true;
	$customIcons = [];
	$customIcons = apply_filters('pixfort_custom_font_icons', $customIcons);
	wp_enqueue_script('pixfort-admin-vc-icons', PIX_CORE_PLUGIN_URI . 'dist/main/wpbakery/wpbakery-icons-selector.js', ['jquery'], PIXFORT_PLUGIN_VERSION, true);
	wp_localize_script('pixfort-admin-vc-icons', 'pixfort_icons_obj', array(
		'ADMIN_LINK' => add_query_arg(array(
			'action' => 'pix_icons_data',
			'nonce' => wp_create_nonce('pix_icons_data')
		), admin_url('admin-ajax.php')),
		'isPixfortIcons' => $isPixfortIcons,
		'CUSTOM_ICONS' => $customIcons
	));

	wp_enqueue_script('pixfort-admin-custom2', PIX_CORE_PLUGIN_URI . 'functions/js/pixfort_vc.min.js', ['jquery'], PLUGIN_VERSION, true);
	wp_enqueue_script('spectrum-picker', PIX_CORE_PLUGIN_URI . 'functions/js/params/spectrum.min.js', ['jquery'], PLUGIN_VERSION, true);
	wp_enqueue_script('pixfort-gradien-picker', PIX_CORE_PLUGIN_URI . 'functions/js/params/grapick.min.js', ['jquery'], PLUGIN_VERSION, true);
	wp_enqueue_style('spectrum-picker', PIX_CORE_PLUGIN_URI . '/functions/js/params/spectrum.min.css', false, PLUGIN_VERSION, 'all');
	wp_enqueue_style('pix-gradient-picker', PIX_CORE_PLUGIN_URI . '/functions/js/params/grapick.min.css', false, PLUGIN_VERSION, 'all');
	$icons_admin = pix_admin_icons();
	$templates = [];
	if (function_exists('pix_get_templates_wpb_thumbs')) {
		$templates = pix_get_templates_wpb_thumbs();
	}
	$translation_array = array(
		'PIX_CORE_PLUGIN_URI' => PIX_CORE_PLUGIN_URI,
		'PIX_ICONS_ADMIN' => $icons_admin,
		'TEMPLATES_ARR'	=> $templates
	);
	//after wp_enqueue_script
	wp_localize_script('pixfort-admin-custom2', 'plugin_object', $translation_array);
}
add_action('vc_backend_editor_render', 'pix_vc_scripts_back');
