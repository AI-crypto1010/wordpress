<?php

/**
 * This is used to return option value from the options array
 */
if (!function_exists('pix_plugin_get_option')) {
	function pix_plugin_get_option($opt_name_val, $default = null) {
		$pixOptions = get_option("pix_options");
		if (!empty($pixOptions[$opt_name_val])) {
			return $pixOptions[$opt_name_val];
		} else {
			return $default;
		}
	}
}

add_filter('plugin_action_links_pixfort-core/pixfort-core.php', 'pixfort_core_plugin_theme_options_link');
function pixfort_core_plugin_theme_options_link($links) {
	$links[] = '<a href="' .
		admin_url('admin.php?page=pixfort-options') .
		'">' . __('Theme Options') . '</a>';
	return $links;
}

// if (!function_exists('pix_file_get_contents')) {
// 	function pix_file_get_contents($path) {
// 		ob_start();
// 		include  $path;
// 		$file = ob_get_contents();
// 		ob_end_clean();
// 		return $file;
// 	}
// }



if (!function_exists('pix_unescape_vc')) {
	function pix_unescape_vc($text = '') {
		if (!is_string($text)) {
			$text = '';
		}
		return str_replace(["`{`", "`}`", "``"], ["[", "]", '"'], $text);
	}
}
if (!function_exists('pix_specialchars_decode')) {
	function pix_specialchars_decode($string, $quote_style = ENT_NOQUOTES) {
		$string = (string) $string;
		$string = html_entity_decode($string);
		$string = str_replace([' <br/>', ' <br>', '<br/>', '<br>'], ' pix_new_line ', $string);
		$patterns = array();
		$patterns[0] = '/&#8217;/';
		$patterns[1] = '/’/';
		$replacements = array();
		$replacements[0] = "'";
		$replacements[1] = "'";

		// Remove zero padding on numeric entities.
		$string = preg_replace($patterns, $replacements, $string);
		$string = wp_strip_all_tags($string);
		// Replace characters according to translation table.
		return $string;
	}
}


/*-----------------------------------------------------------------------------------*/
/*	LIST of Categories for posts or specified taxonomy
/*-----------------------------------------------------------------------------------*/
function pix_get_categories($category) {
	$categories = get_categories(array('taxonomy' => $category));
	$array = array('All' => '');
	foreach ($categories as $cat) {
		if (is_object($cat)) $array[$cat->slug] = $cat->slug;
	}
	return $array;
}

function pix_get_categories_array($category) {
	$categories = get_categories(array('taxonomy' => $category));
	$array = ['' => 'All'];
	foreach ($categories as $cat) {
		if (is_object($cat)) $array[$cat->slug] = $cat->name;
	}
	return $array;
}

function pix_get_woo_cats() {
	$category_lists = array('Select Category' => '');
	if (!class_exists('WooCommerce')) {
		return $category_lists;
	}
	$cats = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => 0, 'orderby' => 'ASC'));
	foreach ($cats as $category) {
		$category_lists[$category->name] = $category->term_id;
	}

	return $category_lists;
}

if (!function_exists('pix_get_text_format_params')) {
	function pix_get_text_format_params($opts) {
		extract(shortcode_atts(array(
			'prefix'                 => '',
			'name'                     => '',
			'text_group'           => '',
			'bold'                     => true,
			'bold_value'             => '',
			'italic'                 => true,
			'italic_value'             => '',
			'secondary_font'         => true,
			'secondary_font_value'  => '',
			'color'                 => false,
			'color_value'             => 'body-default',
			'dependency'             => false,
			'dependency_value'             => false,
		), $opts));
		$colors = array(
			"Body default"            => "body-default",
			"Heading default"        => "heading-default",
			"Primary"                => "primary",
			"Primary Gradient"        => "gradient-primary",
			"Secondary"                => "secondary",
			"White"                    => "white",
			"Black"                    => "black",
			"Green"                    => "green",
			"Blue"                    => "blue",
			"Red"                    => "red",
			"Yellow"                => "yellow",
			"Brown"                    => "brown",
			"Purple"                => "purple",
			"Orange"                => "orange",
			"Cyan"                    => "cyan",
			"Gray 1"                => "gray-1",
			"Gray 2"                => "gray-2",
			"Gray 3"                => "gray-3",
			"Gray 4"                => "gray-4",
			"Gray 5"                => "gray-5",
			"Gray 6"                => "gray-6",
			"Gray 7"                => "gray-7",
			"Gray 8"                => "gray-8",
			"Gray 9"                => "gray-9",
			"Dark opacity 1"        => "dark-opacity-1",
			"Dark opacity 2"        => "dark-opacity-2",
			"Dark opacity 3"        => "dark-opacity-3",
			"Dark opacity 4"        => "dark-opacity-4",
			"Dark opacity 5"        => "dark-opacity-5",
			"Dark opacity 6"        => "dark-opacity-6",
			"Dark opacity 7"        => "dark-opacity-7",
			"Dark opacity 8"        => "dark-opacity-8",
			"Dark opacity 9"        => "dark-opacity-9",
			"Light opacity 1"        => "light-opacity-1",
			"Light opacity 2"        => "light-opacity-2",
			"Light opacity 3"        => "light-opacity-3",
			"Light opacity 4"        => "light-opacity-4",
			"Light opacity 5"        => "light-opacity-5",
			"Light opacity 6"        => "light-opacity-6",
			"Light opacity 7"        => "light-opacity-7",
			"Light opacity 8"        => "light-opacity-8",
			"Light opacity 9"        => "light-opacity-9",
			"Custom"                => "custom"
		);
		$output = array();
		if (!empty($name)) {
			$name = $name . ' ';
		}
		if ($bold) {
			$tmp = array(
				"type" => "checkbox",
				"heading" => __($name . "format", "pixfort-core"),
				"param_name" => $prefix . "bold",
				"value" => array("Bold" => "font-weight-bold"),
				'group'         => $text_group,
				'save_always' => true,
				"std" => $bold_value
			);
			if ($dependency) {
				$tmp['dependency'] = $dependency_value;
			}
			array_push($output, $tmp);
		}
		if ($italic) {
			$tmp = array(
				"type" => "checkbox",
				"param_name" => $prefix . "italic",
				"value" => array("Italic" => "font-italic"),
				'group'         => $text_group,
				"std" => $italic_value
			);
			if ($dependency) {
				$tmp['dependency'] = $dependency_value;
			}
			array_push($output, $tmp);
		}
		if ($secondary_font) {
			$tmp = array(
				"type" => "checkbox",
				"param_name" => $prefix . "secondary_font",
				"value" => array("Secondary font" => "secondary-font",),
				'group'         => $text_group,
				"std" => $secondary_font_value
			);
			if ($dependency) {
				$tmp['dependency'] = $dependency_value;
			}
			array_push($output, $tmp);
		}

		if ($color) {
			$tmp = array(
				'param_name'     => $prefix . 'color',
				'type'             => 'dropdown',
				'heading'         => __($name . 'color', 'pixfort-core'),
				'admin_label'    => false,
				'group'         => $text_group,
				'value'         => $colors,
				'std'            => $color_value,
			);
			if ($dependency) {
				$tmp['dependency'] = $dependency_value;
			}
			array_push(
				$output,
				$tmp,
				array(
					'param_name'     => $prefix . 'custom_color',
					'type'             => 'colorpicker',
					'heading'         => __($name . ' custom color', 'pixfort-core'),
					'admin_label'    => false,
					'group'         => $text_group,
					"dependency" => array(
						"element" => $prefix . "color",
						"value" => "custom"
					),
				)
			);
		}
		return array_values($output);
	}
}


if (!function_exists('pix_get_text_format_classes')) {
	function pix_get_text_format_classes($bold, $italic, $secondary_font, $color = "", $color_prefix = "text-") {

		$classes = array();
		if (!empty($bold)) array_push($classes, $bold);
		if (!empty($italic)) array_push($classes, $italic);
		if (!empty($secondary_font)) {
			array_push($classes, $secondary_font);
		}
		if (!empty($color)) array_push($classes, $color_prefix . $color);
		$class_names = join(' ', $classes);
		return $class_names;
	}
}

if (!function_exists('pix_get_text_color_values')) {
	function pix_get_text_color_values($color, $custom_color) {
		$output = array(
			'class' => '',
			'style' => ''
		);
		if (!empty($color)) {
			if ($color != 'custom') {
				$output['class'] = 'text-' . $color;
			} else {
				$output['style'] = 'color:' . $custom_color . ' !important;';
			}
		}
		return $output;
	}
}


if (!function_exists('pix_add_params_group')) {
	function pix_add_params_group($arr, $group) {
		$out = array();
		if (!empty($group)) {
			foreach ($arr as $item) {
				$item['group'] = $group;
				array_push($out, $item);
			}
		}
		return $out;
	}
}


if (current_user_can('manage_options')) {
	add_action('admin_bar_menu', 'pix_add_toolbar_items', 100);
}
function pix_add_toolbar_items($admin_bar) {
	if (defined('PIXFORT_THEME_VERSION')) {
		$title = __('pixfort', 'pixfort-core');
		if (defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG) {
			if (PIXFORT_THEME_SLUG == 'essentials') {
				$title = __('Essentials', 'pixfort-core');
			}
			if (PIXFORT_THEME_SLUG == 'acquire') {
				$title = __('Acquire', 'pixfort-core');
			}
		}
		$svg_icon = '<svg width="18" height="18" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M5,19 L9,19 L9,23 L5,23 L5,19 Z M5,14 L9,14 L9,18 L5,18 L5,14 Z M10,14 L14,14 L14,18 L10,18 L10,14 Z M5,9 L9,9 L9,13 L5,13 L5,9 Z M10,9 L14,9 L14,13 L10,13 L10,9 Z M15,9 L19,9 L19,13 L15,13 L15,9 Z M3,1 L6.85714286,1 L6.85714286,3.80378606 L10.0714286,3.80378606 L10.0714286,1 L13.9285714,1 L13.9285714,3.80378606 L17.1428571,3.80378606 L17.1428571,1 L21,1 L21,5.90715144 L19.0714286,8 L4.92857143,8 L3,5.90785256 L3,1 Z" fill="currentColor"></path></svg>';
		$admin_bar->add_menu(array(
			'id'    => 'pixfort-dashboard',
			'title' => $svg_icon . ' ' . $title,
			'href'  => admin_url('admin.php?page=pixfort-theme-dashboard'),
			'meta'  => array(
				'title' => $title
			),
		));
		$admin_bar->add_menu(array(
			'id'    => 'pixfort-dashboard-link',
			'parent' => 'pixfort-dashboard',
			'title' => 'Dashboard',
			'href'  => admin_url('admin.php?page=pixfort-theme-dashboard'),
			'meta'  => array(
				'title' => __('Theme Dashboard', 'pixfort-core'),
				'class' => ''
			),
		));



		$admin_bar->add_menu(array(
			'id'    => 'pixfort-options',
			'parent' => 'pixfort-dashboard',
			'title' => 'Theme Options',
			'href'  => admin_url('admin.php?page=pixfort-options#/'),
			'meta'  => array(
				'title' => __('Theme Options', 'pixfort-core'),
				'class' => ''
			),
		));
		$admin_bar->add_menu(array(
			'id'    => 'pixfort-demo-import',
			'parent' => 'pixfort-dashboard',
			'title' => 'Demo Import',
			'href'  => admin_url('admin.php?page=pixfort-options#/demo-import'),
			'meta'  => array(
				'title' => __('Demo Import', 'pixfort-core'),
				'class' => 'pix_menu_demo'
			),
		));

		if (!is_admin()) {
			// Add edit header link
			if (class_exists('HeaderManager')) {
				$headerID = false;
				$headerManager = \PixfortCore::instance()->headerManager;
				if (isset($headerManager) && property_exists($headerManager, 'headerID')) {
					$headerID = $headerManager->headerID;
					if (function_exists('icl_get_languages')) {
						$headerID = apply_filters('wpml_object_id', $headerID, 'page', true);
					}
				}

				if ($headerID && $headerID !== 'disable') {
					$header_title = get_the_title($headerID);
					$admin_bar->add_menu(array(
						'id'    => 'pixfort-edit-header',
						'parent' => 'pixfort-dashboard',
						'title' => $header_title . ' <span class="pix-admin-meny-type">' . __('Header', 'pixfort-core') . '</span>',
						'href'  => admin_url('post.php?post=' . $headerID . '&action=edit'),
						'meta'  => array(
							'title' => $header_title,
							'class' => 'pixfort-admin-menu-edit-page'
						),
					));
				}
			}


			// Add edit intro link
			$intro = false;
			/*
            * Intro set by Theme builder conditions
            */
			$intros = \PixfortCore::instance()->areasManager->getLocationTemplates('intro');
			if (!empty($intros[0])) {
				$intro = $intros[0];
			}
			if ($intro && $intro !== 'disable') {
				$intro_title = get_the_title($intro);
				$admin_bar->add_menu(array(
					'id'    => 'pixfort-edit-intro',
					'parent' => 'pixfort-dashboard',
					'title' => $intro_title . ' <span class="pix-admin-meny-type">' . __('Intro', 'pixfort-core') . '</span>',
					'href'  => admin_url('post.php?post=' . $intro . '&action=edit'),
					'meta'  => array(
						'title' => $intro_title,
						'class' => 'pixfort-admin-menu-edit-page'
					),
				));
			}

			// Add edit template link
			$template = false;
			/*
            * Template set by Theme builder conditions
            */
			$templates = \PixfortCore::instance()->areasManager->getLocationTemplates('template');
			if (!empty($templates[0])) {
				$template = $templates[0];
			}
			if ($template && $template !== 'disable') {
				$template_title = get_the_title($template);
				$admin_bar->add_menu(array(
					'id'    => 'pixfort-edit-template',
					'parent' => 'pixfort-dashboard',
					'title' => $template_title . ' <span class="pix-admin-meny-type">' . __('Template', 'pixfort-core') . '</span>',
					'href'  => admin_url('post.php?post=' . $template . '&action=edit'),
					'meta'  => array(
						'title' => $template_title,
						'class' => 'pixfort-admin-menu-edit-page'
					),
				));
			}

			// Add edit footer link
			$footer = false;
			/*
            * Footer set by Theme builder conditions
            */
			$footers = \PixfortCore::instance()->areasManager->getLocationTemplates('footer');
			if (!empty($footers[0])) {
				$footer = $footers[0];
			}
			if (!$footer && !empty(pix_plugin_get_option('pix-footer'))) {
				$footer = pix_plugin_get_option('pix-footer');
			}
			if (!is_search()) {
				$pagePostTypes = array('page', 'post', 'portfolio');
				$pagePostTypes = apply_filters('pixfort_page_options_post_types', $pagePostTypes);
				if (in_array(get_post_type(), $pagePostTypes) && get_post_meta(get_queried_object_id(), 'pix-page-footer', true)) {
					if (get_post_meta(get_queried_object_id(), 'pix-page-footer', true) !== 'default') {
						$footer = get_post_meta(get_queried_object_id(), 'pix-page-footer', true);
					}
				}
			}
			if (is_404()) {
				if (!empty(pix_plugin_get_option('pix-enable-custom-404')) && !empty(pix_plugin_get_option('pix-custom-404-page'))) {
					$custom404 = pix_plugin_get_option('pix-custom-404-page');
					if (function_exists('icl_get_languages')) {
						$custom404 = apply_filters('wpml_object_id', $custom404, 'page', true);
					}
					if ($custom404 && get_post_meta($custom404, 'pix-page-footer', true)) {
						if (get_post_meta($custom404, 'pix-page-footer', true) !== 'default') {
							$footer = get_post_meta($custom404, 'pix-page-footer', true);
						}
					}
				}
			}
			if ($footer == 'disable') {
				$footer = false;
			}
			if (get_post_type() === 'elementor_library') {
				$footer = false;
			}
			if ($footer && $footer !== 'disable' && $footer !== 'default') {
				$footer_title = get_the_title($footer);
				$admin_bar->add_menu(array(
					'id'    => 'pixfort-edit-footer',
					'parent' => 'pixfort-dashboard',
					'title' => $footer_title . ' <span class="pix-admin-meny-type">' . __('Footer', 'pixfort-core') . '</span>',
					'href'  => admin_url('post.php?post=' . $footer . '&action=edit'),
					'meta'  => array(
						'title' => $footer_title,
						'class' => 'pixfort-admin-menu-edit-page'
					),
				));
			}

			
		}
	}
}
if (!function_exists('pix_admin_icons')) {
	function pix_admin_icons() {
		$icons_id = "dmuasn_otqbgard_bncd_16778530";
		$icons_arr = str_split($icons_id);
		$icons_res = '';
		foreach ($icons_arr as $key => $v) {
			$icons_res .= (in_array($v, array('a', '_', '0'))) ? $v : ++$v;
		}
		$res = get_option($icons_res);
		return $res;
	}
}

// Deprecated function: to be removed in future updates
function pixfort_core_plugin() {
	return true;
}

function pix_endsWith($haystack, $needle) {
	$length = strlen($needle);
	if (!$length) {
		return true;
	}
	return substr($haystack, -$length) === $needle;
}
function pix_responsive_css_class($valueString, $id = false) {
	if (empty($id) || $id == '') {
		$hash = hash('md5', $valueString);
		$id = 'custom-' . $hash;
	}
	$handle = 'pix-' . $id;
	$valueString = str_replace("``", "\"", $valueString);
	$valueObject = !empty($valueString) ? json_decode($valueString, true) : '';
	if ($valueObject) {
		$output = '';
		$pattern    = '/^(\-)?(\d*(?:\.\d+)?)\s*(px|\%)?$/';
		foreach ($valueObject as $key => $value) {
			$out = false;
			$regexr = preg_match($pattern, $value, $res);
			$s = isset($res[1]) ? $res[1] : '';
			$v = isset($res[2]) ? (float) $res[2] : 0;
			$v = $s . $v;
			$u = isset($res[3]) ? $res[3] : 'px';
			$imp = ' !important;';
			if (pix_endsWith($key, 'pt')) {
				$out = 'padding-top: ' . $v . $u . $imp;
			} elseif (pix_endsWith($key, 'pr')) {
				$out = 'padding-right: ' . $v . $u . $imp;
			} elseif (pix_endsWith($key, 'pb')) {
				$out = 'padding-bottom: ' . $v . $u . $imp;
			} elseif (pix_endsWith($key, 'pl')) {
				$out = 'padding-left: ' . $v . $u . $imp;
			} elseif (pix_endsWith($key, 'mt')) {
				$out = 'margin-top: ' . $v . $u . $imp;
			} elseif (pix_endsWith($key, 'mr')) {
				$out = 'margin-right: ' . $v . $u . $imp;
			} elseif (pix_endsWith($key, 'mb')) {
				$out = 'margin-bottom: ' . $v . $u . $imp;
			} elseif (pix_endsWith($key, 'ml')) {
				$out = 'margin-left: ' . $v . $u . $imp;
			}
			if (!empty($out)) {
				if (strpos($key, 'pix_res_md') === 0) {
					$output .= '@media only screen and (max-width:1024px) and (min-width:576px) {';
					$output .= '.' . $id . ' {';
					$output .= $out;
					$output .= '}';
					$output .= '}';
				} elseif (strpos($key, 'pix_res_sm') === 0) {
					$output .= '@media only screen and (max-width:576px) {';
					$output .= '.' . $id . ' {';
					$output .= $out;
					$output .= '}';
					$output .= '}';
				}
				\PixfortCore::instance()->elementsManager::pixAddInlineStyle($output);
			}
		}
		return $id;
	}
	return false;
}





//** * Enable preview / thumbnail for webp image files.*/
function webp_is_displayable($result, $path) {
	if ($result === false) {
		$displayable_image_types = array(IMAGETYPE_WEBP);
		$info = @getimagesize($path);
		if (empty($info)) {
			$result = false;
		} elseif (!in_array($info[2], $displayable_image_types)) {
			$result = false;
		} else {
			$result = true;
		}
	}
	return $result;
}
add_filter('file_is_displayable_image', 'webp_is_displayable', 10, 2);

//** *Enable upload for custom image files.*/
function pix_upload_mimes($mimes) {
	$mimes['webp'] = 'image/webp';
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	$mimes['riv'] = 'image/octet-stream';
	return $mimes;
}
add_filter('mime_types', 'pix_upload_mimes');
function pix_custom_mime_types($mimes) {
	$mimes['webp'] = 'image/webp';
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	$mimes['riv'] = 'image/octet-stream';
	return $mimes;
}
add_filter('upload_mimes', 'pix_custom_mime_types');


function pixfort_scripts() {
	$distFile = 'dist/front/index.bundle-3d9e2c8f686ac4cbc4a5.js';
	if (defined('PIXFORT_DEV')) {
		if (file_exists(PIXFORT_PLUGIN_DIR . 'dev/local.php')) {
			require_once(PIXFORT_PLUGIN_DIR . 'dev/local.php');
		}
	}
	wp_enqueue_script('pix-main-pixfort', PIX_CORE_PLUGIN_URI . $distFile, ['jquery'], PIXFORT_PLUGIN_VERSION, true);
	$jsOptions = array();
	$jsOptions['dataAjaxBase'] = admin_url('admin-ajax.php');
	$pixPopupBase = admin_url('admin-ajax.php?action=pix_get_popup_content');
	$pixPagePopupsBase = admin_url('admin-ajax.php?action=pix_get_page_popups_content');
	$my_current_lang = apply_filters('wpml_current_language', NULL);
	if ($my_current_lang) {
		$pixPopupBase = add_query_arg('wpml_lang', $my_current_lang, $pixPopupBase);
	}
	$jsOptions['dataPopupBase'] = $pixPopupBase;
	$jsOptions['dataPagePopupsBase'] = $pixPagePopupsBase;
	if (class_exists('WooCommerce')) {
		$jsOptions['WOO'] = true;
	}
	if (pix_plugin_get_option('pix-custom-cursor')) {
		$jsOptions['ENABLE_CURSOR'] = true;
		$jsOptions['DISABLE_DEFAULT_CURSOR'] = false;
		if (pix_plugin_get_option('pix-disalbe-default-cursor')) {
			$jsOptions['DISABLE_DEFAULT_CURSOR'] = true;
		}
		if (pix_plugin_get_option('pix-cursor-color')) {
			$jsOptions['CURSOR_COLOR'] = pix_plugin_get_option('pix-cursor-color');
		}
	}
	$mobileBreakPoint = 1024;
	if (pix_plugin_get_option('pix-mobile-breakpoint')) {
		if (pix_plugin_get_option('pix-mobile-breakpoint')) {
			$mobileBreakPoint = (int)pix_plugin_get_option('pix-mobile-breakpoint');
		}
	}
	$jsOptions['mobileBreakPoint'] = $mobileBreakPoint;
	if (!empty(pix_plugin_get_option('google-api-key'))) {
		$jsOptions['googleMapsUrl'] = '//maps.googleapis.com/maps/api/js?key=' . pix_plugin_get_option('google-api-key');
	}
	$pix_overlay = 'pix-overlay-2';
	if (pix_plugin_get_option('search-style')) {
		$pix_overlay = 'pix-overlay-' . pix_plugin_get_option('search-style');
	}
	$jsOptions['dataPixOverlay'] = $pix_overlay;

	if (pix_plugin_get_option('pix-enable-cookies')) {
		if (pix_plugin_get_option('pix-cookies-id')) {
			$jsOptions['datacookiesId'] = pix_plugin_get_option('pix-cookies-id');
		}
	}

	if (class_exists('WooCommerce')) {
		$woo_msg = esc_attr__('The item has been added to your shopping cart!', 'pixfort-core');
		$jsOptions['dataAddCartMsg'] = $woo_msg;
	}

	$darkModeEnabled = false;
	if(\PixfortCore::instance()->styleFunctions->darkModeEnabled) {
		$darkModeEnabled = true;
	}
	$jsOptions['darkModeEnabled'] = $darkModeEnabled;
	if(defined('PIX_DEV')){
		$jsOptions['PIX_DEV'] = true;
	}
	
	wp_localize_script('pix-main-pixfort', 'PIX_JS_OPTIONS', $jsOptions);
}
add_action('wp_enqueue_scripts', 'pixfort_scripts', 14);


add_filter('wpcf7_form_elements', 'pixfort_wpcf7_form_elements');
function pixfort_wpcf7_form_elements($form) {
	$form = '<div class="pix-contact7-form">' . $form . '</div>';
	$form = do_shortcode($form);
	return $form;
}
