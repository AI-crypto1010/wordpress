<?php

if (!defined('ABSPATH')) die;

define('PIX_CORE_PLUGIN_URI', plugin_dir_url(__FILE__));
define('PIX_CORE_PLUGIN_DIR', dirname(__FILE__));
define('PLUGIN_VERSION', PIXFORT_PLUGIN_VERSION);

define('PIXFORT_SLIDER_SWIPER', true);
// define('PIXFORT_SLIDER_OLD', true);

function pixfort_core_setup_hook() {
    load_plugin_textdomain('pixfort-core', false, dirname(plugin_basename(__FILE__)) . '/languages/');

    // Load functions meta
    require_once dirname(__FILE__) . '/functions/meta-functions.php';
    // Load Global functions
    require_once dirname(__FILE__) . '/functions/global-functions.php';
    // Load Page meta
    require_once dirname(__FILE__) . '/functions/meta-page.php';
    // Load Post meta
    require_once dirname(__FILE__) . '/functions/meta-post.php';
    // Load Portfolio meta
    require_once dirname(__FILE__) . '/functions/portfolio.php';
    if (is_user_logged_in()) {
        require_once dirname(__FILE__) . '/includes/options/main.php';
        // Load Header meta
        require_once dirname(__FILE__) . '/functions/header.php';
        // Load Post category meta
        require_once dirname(__FILE__) . '/functions/categories.php';
    }
    // Load custom theme css
    require_once dirname(__FILE__) . '/functions/style/pix-css.php';
    // Widgets
    require_once dirname(__FILE__) . '/functions/widgets.php';
    if (class_exists('WooCommerce')) {
        // product
        require_once dirname(__FILE__) . '/functions/product.php';
    }
}
add_action('after_setup_theme', 'pixfort_core_setup_hook');

add_action('init', 'pixfort_admin_only');
function pixfort_admin_only() {

    if (defined('WPB_VC_VERSION')) {
        require_once dirname(__FILE__) . '/includes/theme-builder/wpbakery/shortcode-dynamic-images.php';

        if (defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG == 'essentials') {
            // Load wpbakery shortcodes
            require_once dirname(__FILE__) . '/functions/visual-composer.php';
            if (is_user_logged_in()) {
                require_once dirname(__FILE__) . '/functions/params.php';
            }
        }
    }
    if (is_user_logged_in()) {
        require_once dirname(__FILE__) . '/functions/visual-composer-icons.php';
    }
}

add_action('plugins_loaded', 'pix_after_plugin_loaded');
function pix_after_plugin_loaded() {
    // Elementor
    if (class_exists('\Elementor\Plugin')) {
        if (file_exists(dirname(__FILE__) . '/functions/elementor/init.php')) {
            $code = get_option('envato_purchase_code_27889640');
            $code_2 = get_option('pixfort_purchase_code_1');
            $code_3 = get_option('envato_purchase_code_61457003');
            if ($code || $code_2 || $code_3) {
                require_once dirname(__FILE__) . '/functions/elementor/init.php';
            }
        }
    }
}

function pixAdminSiteIconCheck() {
    if (defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG == 'essentials') {
        $pix_options = get_option("pix_options");
        if ($pix_options && !empty($pix_options['favicon-img'])) {
            if (!empty($pix_options['favicon-img']['id'])) {
                if (function_exists('has_site_icon')) {
                    $imgID = (int) $pix_options['favicon-img']['id'];
                    $imgAttachment = wp_get_attachment_image($imgID);
                    if (!empty($imgAttachment)) {
                        update_option('site_icon', $imgID);
                        unset($pix_options['favicon-img']);
                        update_option('pix_options', $pix_options);
                    }
                }
            }
        }
    }
}
add_action('admin_init', 'pixAdminSiteIconCheck');

/**
 * Add Font Group
 */
add_filter('elementor/fonts/groups', function ($font_groups) {
    $font_groups['theme_fonts'] = __('pixfort Fonts');
    return $font_groups;
});
/**
 * Add Group Fonts
 */
add_filter('elementor/fonts/additional_fonts', function ($additional_fonts) {
    $body_font = pix_plugin_get_option('opt-primary-font');
    $heading_font = pix_plugin_get_option('opt-secondary-font');
    $disable = false;
    if (pix_plugin_get_option('pix-disable-elementor-theme-fonts')) {
        $disable = true;
    }
    if (!$disable) {
        if ($body_font) {
            if (!empty($body_font['font-family'])) {
                $additional_fonts[$body_font['font-family']] = 'theme_fonts';
            }
        }
        if ($heading_font) {
            if (!empty($heading_font['font-family'])) {
                $additional_fonts[$heading_font['font-family']] = 'theme_fonts';
            }
        }
    }
    return $additional_fonts;
});

function pix_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        if ($scripts->registered['jquery']->deps) {
            $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'pix_remove_jquery_migrate');
