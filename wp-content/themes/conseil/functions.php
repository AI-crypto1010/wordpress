<?php

/**
 * pixfort theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package pixfort theme
 */

define('PIXFORT_THEME_VERSION', '1.2.2');
define('PIXFORT_THEME_SLUG', 'conseil');
define('PIXFORT_CORE_PLUGIN_VERSION', '3.4.3');

if (!function_exists('pixfort_theme_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function pixfort_theme_setup() {
		/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		*/
		load_theme_textdomain('conseil', get_template_directory() . '/languages');

		/*
		* Add default posts and comments RSS feed links to head.
		*/
		add_theme_support('automatic-feed-links');

		/*
		* Add Support for additional post formats
		*/
		add_theme_support('post-formats', array('quote', 'video', 'audio', 'link'));

		/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
		add_theme_support('title-tag');

		/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'menu-1' => esc_attr__('Primary', 'conseil'),
		));

		/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		// Set up the WordPress core custom background feature.
		add_theme_support('custom-background', apply_filters('pixfort_theme_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		)));

		/**
		 * Add support for wide alignment.
		 *
		 * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#wide-alignment
		 */
		add_theme_support('align-wide');

		if (!defined('PIXFORT_PLUGIN_VERSION')) {
			/**
			 * Add support for Block Styles.
			 */
			add_theme_support('wp-block-styles');

			/**
			 * Add support for responsive embedded content.
			 */
			add_theme_support('responsive-embeds');

			/**
			 * Add support for custom logo.
			 */
			add_theme_support('custom-logo', array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			));

			/**
			 * Add support for custom header.
			 */
			add_theme_support('custom-header', apply_filters('pixfort_theme_custom_header_args', array(
				'default-image'      => '',
				'default-text-color' => '000000',
				'width'              => 1000,
				'height'             => 250,
				'flex-width'         => true,
				'flex-height'        => true,
			)));

			/**
			 * Add editor styles.
			 */
			add_editor_style('css/editor-style-block.css');
		}
	}
endif;
add_action('after_setup_theme', 'pixfort_theme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pixfort_theme_content_width() {
	// This variable is intended to be overruled from child theme.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters('pixfort_theme_content_width', 640);
}
add_action('after_setup_theme', 'pixfort_theme_content_width', 0);


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function pixfort_theme_widgets_init() {
	register_sidebar(array(
		'name'          => esc_attr__('Main Sidebar', 'conseil'),
		'id'            => 'sidebar-1',
		'description'   => esc_attr__('Add widgets here.', 'conseil'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="font-weight-bold text-heading-default pix-mb-10">',
		'after_title'   => '</h5>',
	));

	if (pix_get_option('pix_sidebars')) {
		if (!empty(pix_get_option('pix_sidebars'))) {
			$sidebars = pix_get_option('pix_sidebars');
			foreach ($sidebars as $key => $value) {
				if ($value != '') {
					$sideID = str_replace(' ', '', strtolower($value));
					$sideID = preg_replace('/[^A-Za-z0-9\-]/', '', $sideID);
					$sideID = sanitize_title($sideID);
					$sideID = 'sidebar-' . $sideID;
					register_sidebar(array(
						'name'          => $value,
						'id'            => $sideID,
						'description'   => esc_attr__('Add widgets here.', 'conseil'),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h5 class="font-weight-bold text-heading-default pix-mb-10">',
						'after_title'   => '</h5>',
					));
				}
			}
		}
	}
}
add_action('widgets_init', 'pixfort_theme_widgets_init');

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Functions which enhance the theme posts by hooking into WordPress.
 */
require get_template_directory() . '/inc/post-functions.php';

/**
 * Enqueue scripts and styles.
 */
function pixfort_theme_scripts() {



	$pagePostTypes = array('page', 'post', 'portfolio');
	$pagePostTypes = apply_filters('pixfort_page_options_post_types', $pagePostTypes);
	if (in_array(get_post_type(), $pagePostTypes)) {
		if (get_post_meta(get_the_ID(), 'pix-disable-wp-block-library', true) === 'yes') {
			wp_dequeue_style('wp-block-library');
			wp_dequeue_style('wp-block-library-theme');
			wp_dequeue_style('wc-block-style'); // Remove WooCommerce block CSS
		}
	}

	wp_enqueue_script('pixfort-main-script', get_template_directory_uri() . '/js/pixfort.min.js', ['jquery'], PIXFORT_THEME_VERSION, true);

	wp_dequeue_style('yith-wcwl-font-awesome');
	wp_deregister_style('yith-wcwl-font-awesome');

	if (function_exists('wpcf7_plugin_path')) {
		wp_dequeue_style('contact-form-7');
		wp_deregister_style('contact-form-7');
	}

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	if (!empty(pix_get_option('pix-custom-js-header'))) {
		wp_register_script('pixfort-options-script-header', false, false, PIXFORT_THEME_VERSION);
		wp_enqueue_script('pixfort-options-script-header');
		wp_add_inline_script('pixfort-options-script-header', pix_get_option('pix-custom-js-header'));
	}
	// Bootstrap
	wp_enqueue_style('pixfort-bootstrap', get_template_directory_uri() . '/inc/css/bootstrap.min.css', false, PIXFORT_THEME_VERSION, 'all');
	wp_register_style('pix-lightbox-css', get_template_directory_uri() . '/css/build/jquery.fancybox.min.css');
}
add_action('wp_enqueue_scripts', 'pixfort_theme_scripts', 10);


function pixfort_theme_add_styles() {
	if (!defined('PIXFORT_PLUGIN_VERSION')) {
		wp_enqueue_style('pixfort-default-style', get_template_directory_uri() . '/dist/styles/default-main.min.css');
	}
	if (is_user_logged_in()) wp_enqueue_style('pix-theme-admin-style', get_template_directory_uri() . '/css/pix-admin.css', false, PIXFORT_THEME_VERSION, 'all');
}

add_action('wp_enqueue_scripts', 'pixfort_theme_add_styles', 11);


function pix_theme_footer_extras() {
	if (defined('DOING_AJAX') && DOING_AJAX) {
		return false;
	}
	wp_enqueue_style('pixfort-base-style', get_template_directory_uri() . '/css/base.min.css', false, PIXFORT_THEME_VERSION, 'all');
}
add_action('wp_footer', 'pix_theme_footer_extras', 10);

if (!function_exists('pix_theme_params')) {
	function pix_theme_params() {
		$params = [
			'name'						=> 'Conseil',
			'slug'						=> 'conseil',
			'btn-border-radius-sm'			=> '10px',
			'btn-border-radius'				=> '10px',
			'btn-border-radius-md'			=> '10px',
			'btn-border-radius-lg'			=> '10px',
			'btn-border-radius-xl'			=> '10px',
		];
		require_once get_template_directory() . '/inc/config/admin-config.php';
		$params = pix_theme_extra_params($params);
		return $params;
	}
}


// Register Admin Script
function pix_theme_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_media();
	wp_enqueue_script('pix-admin-script', get_template_directory_uri() . '/js/pix-admin.min.js', array(), PIXFORT_THEME_VERSION, true);
	$icons_admin = pix_admin_icons();
	wp_localize_script('pix-admin-script', 'pix_admin_opts_object', [
		'PIX_ICONS_ADMIN' => $icons_admin,
	]);
}
add_action('admin_enqueue_scripts', 'pix_theme_admin_scripts');

function pixfort_admin_styles() {
	wp_enqueue_style('pix-theme-admin-style', get_template_directory_uri() . '/css/pix-admin.css', false, PIXFORT_THEME_VERSION);
}
add_action('admin_menu', 'pixfort_admin_styles');
if (is_multisite()) {
	add_action('network_admin_menu', 'pixfort_admin_styles');
}

require get_template_directory() . '/inc/config/hub-connect.php';

function pix_get_languages() {
	$languages = false;
	$languages = apply_filters('wpml_active_languages', NULL, array('skip_missing' => 0));
	return $languages;
}
add_action('wp', 'pix_get_languages');

function pix_add_cpt_support() {
	$cpt_support = get_option('elementor_cpt_support');
	if (!$cpt_support) {
		$cpt_support = ['page', 'post', 'pixfooter', 'pixpopup', 'portfolio', 'pixfort_template'];
		update_option('elementor_cpt_support', $cpt_support);
	} else {
		if (!in_array('pixfooter', $cpt_support)) {
			$cpt_support[] = 'pixfooter';
			update_option('elementor_cpt_support', $cpt_support);
		}
		if (!in_array('pixpopup', $cpt_support)) {
			$cpt_support[] = 'pixpopup';
			update_option('elementor_cpt_support', $cpt_support);
		}
		if (!in_array('portfolio', $cpt_support)) {
			$cpt_support[] = 'portfolio';
			update_option('elementor_cpt_support', $cpt_support);
		}
		if (!in_array('pixintro', $cpt_support)) {
			$cpt_support[] = 'pixintro';
			update_option('elementor_cpt_support', $cpt_support);
		}
		if (!in_array('pixfort_template', $cpt_support)) {
			$cpt_support[] = 'pixfort_template';
			update_option('elementor_cpt_support', $cpt_support);
		}
	}
}

add_action('after_switch_theme', 'pix_add_cpt_support');

add_action('init', function () {
	if (function_exists('pll_register_string')) {
		if (pix_get_option('banner-text')) {
			pll_register_string('pixfort-banner-text', pix_get_option('banner-text'));
		}
		if (pix_get_option('banner-btn-text')) {
			pll_register_string('pixfort-banner-btn-text', pix_get_option('banner-btn-text'));
		}
		if (pix_get_option('banner-btn-link')) {
			pll_register_string('pixfort-banner-btn-link', pix_get_option('banner-btn-link'));
		}
		if (pix_get_option('pix-cookies-text')) {
			pll_register_string('pixfort-cookies-text', pix_get_option('pix-cookies-text'));
		}
		if (pix_get_option('pix-cookies-btn')) {
			pll_register_string('pixfort-cookies-btn', pix_get_option('pix-cookies-btn'));
		}
	} elseif (function_exists('icl_register_string')) {
		if (pix_get_option('banner-text')) {
			icl_register_string('Theme', 'pixfort-banner-text', pix_get_option('banner-text'));
		}
		if (pix_get_option('banner-btn-text')) {
			icl_register_string('Theme', 'pixfort-banner-btn-text', pix_get_option('banner-btn-text'));
		}
		if (pix_get_option('banner-btn-link')) {
			icl_register_string('Theme', 'pixfort-banner-btn-link', pix_get_option('banner-btn-link'));
		}
		if (pix_get_option('pix-cookies-text')) {
			icl_register_string('Theme', 'pixfort-cookies-text', pix_get_option('pix-cookies-text'));
		}
		if (pix_get_option('pix-cookies-btn')) {
			icl_register_string('Theme', 'pixfort-cookies-btn', pix_get_option('pix-cookies-btn'));
		}
	}
});

/**
 * Enqueue supplemental block editor styles.
 */
function pix_block_editor_styles() {
	// Enqueue the editor styles.
	wp_enqueue_style('pixfort-block-editor-styles', get_theme_file_uri('/css/editor-style-block.css'), false, PIXFORT_THEME_VERSION, 'all');
}

add_action('enqueue_block_editor_assets', 'pix_block_editor_styles', 1, 1);

if (!function_exists('pix_pll__')) {
	function pix_pll__($string = '') {
		if (function_exists('pll__')) {
			return pll__($string);
		} else {
			return do_shortcode($string);
		}
	}
}


function pix_register_elementor_locations($elementor_theme_manager) {
	$elementor_theme_manager->register_location('header');
	$elementor_theme_manager->register_location('footer');
}
add_action('elementor/theme/register_locations', 'pix_register_elementor_locations');


add_action('elementor/editor/after_save', function ($post_id) {
	if (get_post_type($post_id) === 'pixfooter') {
		\Elementor\Plugin::instance()->files_manager->clear_cache();
	}
});


/**
 * Media
 */
require get_template_directory() . '/inc/media.php';

/**
 * Admin Functions
 */
if (is_admin()) {
	/**
	 * Dashboard
	 */
	require get_template_directory() . '/inc/dashboard.php';
	/**
	 * Implement the Custom Header feature.
	 */
	require get_template_directory() . '/inc/custom-header.php';
	require get_template_directory() . '/inc/customizer.php';
	require get_template_directory() . '/inc/menu-customizer.php';
	/**
	 * Load required plugins
	 */
	require get_template_directory() . '/inc/plugins.php';
	/**
	 * Load demo content
	 */
	require get_template_directory() . '/inc/demo.php';
	require get_template_directory() . '/inc/demo-content/elementor/loader.php';
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}



add_filter('widget_display_callback', 'pix_widget_display_callback', 10, 3);
/**
 * Function for `widget_display_callback` filter-hook.
 * 
 * @param array     $instance The current widget instance's settings.
 * @param WP_Widget $widget   The current widget instance.
 * @param array     $args     An array of default widget arguments.
 *
 * @return array
 */
function pix_widget_display_callback($instance, $widget, $args) {
	if (empty($widget->widget_id) || $widget->widget_id !== 'woocommerce_widget_cart') {
		wp_enqueue_style('pixfort-widgets-style', get_template_directory_uri() . '/css/elements/widgets.min.css', false, PIXFORT_THEME_VERSION);
	}
	return $instance;
}

add_action('after_switch_theme', 'pix_theme_activated');
function pix_theme_activated() {
	update_option('elementor_onboarded', true);
	delete_option('envato_purchase_code_27889640');
}


add_action('wp_dashboard_setup', 'pixfort_main_dashboard_widgets');

if (!function_exists('pixfort_main_dashboard_widgets')) {
	/**
	 * Add a widget to the dashboard.
	 *
	 * This function is hooked into the 'wp_dashboard_setup' action below.
	 */
	function pixfort_main_dashboard_widgets() {
		wp_add_dashboard_widget('pixfort_dashboard_widget', 'conseil', 'pixfort_dashboard_widget');
	}
}
if (!function_exists('pixfort_dashboard_widget')) {
	/**
	 * Create the function to output the contents of our Dashboard Widget.
	 */
	function pixfort_dashboard_widget() {
		echo '<h4><strong>Welcome to Conseil Theme!</strong></h4>';
		echo '<p>For theme knowledge base visit:</p><a target="_blank" class="button button-primary" href="https://wordpress.pixfort.com/docs/" target="_blank">Conseil knowledge base</a>';
		echo '<p>Need help? Contact us via the chat tool on:</p><a target="_blank" class="button button-primary" href="https://hub.pixfort.com/">pixfort hub</span></a>';
	}
}


add_action('wp', 'pixDefaultHeaderCheck');
function pixDefaultHeaderCheck() {
	if (!defined('PIXFORT_PLUGIN_VERSION')) {
		require_once get_template_directory() . '/template-parts/default-header.php';
	}
}
