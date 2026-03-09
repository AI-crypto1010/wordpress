<?php

/**
 * pixfort start page
 */

// Redirect to the dashboard after theme activation
if (is_admin() && isset($_GET['activated']) && $pagenow == "themes.php") {
	wp_redirect(admin_url('?page=pixfort-theme-dashboard'));
}

function pixfort_el_args($getArgs) {
	$key = get_option('envato_purchase_code_61457003');
	if (!$key) {
		return $getArgs;
	}
	$getArgs['headers'] = array(
		'pix_domain' => site_url(),
		'item' => PIXFORT_THEME_SLUG,
		'purchase_key' => $key
	);
	return $getArgs;
}
add_filter('pixfort_el_remote_get_args', 'pixfort_el_args', 1);

/**
 * Display notice to activate the theme
 */
function pixfort_activation_notice() {
?>
	<div class="notice pixfort-admin-notice notice-warning2 is-dismissible">
		<div class="notice-text"><strong><?php echo esc_html__('conseil Theme:', 'conseil'); ?></strong><?php echo esc_html__(' your copy of the theme is not verified yet! Verify it now from the theme dashboard to activate all the features and demo content.', 'conseil'); ?></div>
		<a href="<?php echo esc_url(admin_url('?page=pixfort-theme-dashboard')); ?>" class="button button-primary"><?php esc_html_e('Go to Theme Dashboard', 'conseil'); ?></a>
		<br />
	</div>
<?php
}

$status = PixfortHub::checkValidation();
if (!$status) {
	add_action('admin_notices', 'pixfort_activation_notice');
}


/**
 * Display notice to udapte pixfort-core plugin
 */
function pixfort_update_core_notice() {

	// if (!empty($_GET['page']) && $_GET['page'] !== 'pixfort-options') {
?>
	<div class="pixfort-admin-notice pixfort-danger-notice  notice  notice-danger  is-dismissible2">
		<div class="notice-grid">
			<div class="grid-box box-1">
				<div>
					<h2><img class="alert-icon" src="<?php echo esc_url(get_template_directory_uri() . '/inc/assets/icons/warning-icon-white.svg'); ?>" /><?php esc_html_e('Important notice!', 'conseil'); ?></h2>
					<p class="notice-text"><strong><?php esc_html_e('It seems that you updated Conseil theme, please make sure to update "pixfort core" too from Conseil → Dashboard → Install plugins.', 'conseil'); ?></strong></p>
					<?php if (empty($_GET['page']) || (!empty($_GET['page']) && $_GET['page'] !== 'pixfort-options')) { ?>
						<a href="<?php echo esc_url(admin_url('?page=pixfort-theme-dashboard')); ?>" class="button-danger"><?php esc_html_e('Go to Theme Dashboard', 'conseil'); ?></a>
					<?php } ?>
				</div>
			</div>
			<div class="grid-box box-2">
				<video width="320" height="240" autoplay muted loop>
					<source src="<?php echo version_compare(PIXFORT_PLUGIN_VERSION, '3.2.5', '<=') ? 'https://pixfort-space.sfo2.cdn.digitaloceanspaces.com/wordpress/themes/assets/pixfort-core-update-note-old-versions-video.mp4' : 'https://pixfort-space.sfo2.cdn.digitaloceanspaces.com/wordpress/themes/assets/pixfort-core-update-note-video.mp4'; ?>" type="video/mp4">
					Your browser does not support the video tag.
				</video>
			</div>
		</div>
	</div>
<?php
	// }
}

if (defined('PIXFORT_PLUGIN_VERSION')) {
	if (version_compare(PIXFORT_PLUGIN_VERSION, PIXFORT_CORE_PLUGIN_VERSION, '<')) {
		add_action('admin_notices', 'pixfort_update_core_notice');
	}
	if (is_user_logged_in()) {
		if (get_option('pix_essentials_style_url')) {
			$upURL = get_site_url();
			$styleURL = get_option('pix_essentials_style_url');
			if (!empty(wp_upload_dir()['baseurl'])) {
				$upURL = wp_upload_dir()['baseurl'];
			}
			if (pixStringStartWith(get_option('pix_essentials_style_url'), 'https://')) {
				$protocols = array("http://", "https://");
				$styleURL = str_replace($protocols, "", $styleURL);
				$upURL = str_replace($protocols, "", $upURL);
			}
			if (!pixStringStartWith($styleURL, $upURL)) {
				add_action('admin_notices', 'pixfort_url_change_options_notice');
			}
		}
		// else {
		//     add_action( 'admin_notices', 'pixfort_save_theme_options_notice' );
		// }
	}
}


add_action('admin_init', 'pix_dashboard_redirect_admin_page');

function pix_dashboard_redirect_admin_page() {
	if (isset($_GET['page']) && $_GET['page'] === 'pixfort-dashboard') {
		if (defined('PIXFORT_PLUGIN_VERSION')) {
			if (version_compare(PIXFORT_PLUGIN_VERSION, '3.2.5', '>=')) {
				$pixfortHub = new PixfortHub();
				$pixfortHub->checkLicenseUpdate();
				$redirect_url = admin_url('admin.php?page=pixfort-options#/dashboard');
				wp_redirect($redirect_url);
				exit;
			}
		}
	} else if (isset($_GET['page']) && $_GET['page'] === 'pixfort-theme-dashboard') {
		$pixfortHub = new PixfortHub();
		$dashboard_wizard = get_option('pixfort_dashboard_wizard');
		$status = $pixfortHub->checkValidation();
		$pixfortHub->checkLicenseUpdate();
		$coreVersion = false;
		$oldCoreVersion = false;
		if (defined('PIXFORT_PLUGIN_VERSION')) {
			$coreVersion = PIXFORT_PLUGIN_VERSION;
			if (version_compare(PIXFORT_PLUGIN_VERSION, '3.2.5', '<=')) {
				$oldCoreVersion = true;
			}
		}
		if ($dashboard_wizard) {
			$step = (int) $dashboard_wizard['step'];
		}
		if ($status) {
			if ($step !== 1) {
				if ($coreVersion) {
					if (!$oldCoreVersion) {
						wp_redirect(admin_url('admin.php?page=pixfort-options#/dashboard'));
					}
				}
			}
		}
	}
}

function pixStringStartWith($s1, $s2) {
	return (substr($s1, 0, strlen($s2)) === $s2);
}


function pixfort_url_change_options_notice() {
?>
	<div class="pixfort-admin-notice  notice  notice-warning  is-dismissible">
		<p class="notice-text"><strong><?php esc_html_e('Important Note: ', 'conseil'); ?></strong><?php esc_html_e('It seems that the website URL has been changed, please make sure to go to the Theme options and click on the Save button to refresh the options URLs.', 'conseil'); ?></p>
		<a href="<?php echo esc_url(admin_url('admin.php?page=pixfort-options')); ?>" class="button"><?php esc_html_e('Go to Theme options', 'conseil'); ?></a>
	</div>
<?php
}


add_action('admin_init', 'pix_woocommerce_plugin_status');


function pix_woocommerce_plugin_status() {
	if (class_exists('WooCommerce')) {
		$woo_status = get_option('pix_woocommerce_active');
		if (!$woo_status) {
			update_option('pix_woocommerce_active', 'true');
			if (function_exists('pix_update_style_url')) {
				pix_update_style_url();
			}
		}
	} else {
		update_option('pix_woocommerce_active', '');
	}
}

add_action('admin_init', 'pix_theme_style_check');
function pix_theme_style_check() {
	if (defined('PIXFORT_PLUGIN_VERSION')) {
		if (PIXFORT_PLUGIN_VERSION === PIXFORT_THEME_VERSION) {
			$site_style_version = get_option('pixfort_site_style_version');
			if (!$site_style_version) {
				if (function_exists('pix_update_style_url')) {
					update_option('pixfort_site_style_version', PIXFORT_THEME_VERSION);
					pix_update_style_url();
				}
			} else {
				if ($site_style_version !== PIXFORT_THEME_VERSION) {
					if (function_exists('pix_update_style_url')) {
						pix_update_style_url();
						update_option('pixfort_site_style_version', PIXFORT_THEME_VERSION);
					}
				}
			}
		}
	}
}

add_action('admin_menu', 'pix_admin_dashboard_menu');
if (is_admin()) require get_template_directory() . '/inc/config/plugins.php';

function pix_admin_dashboard_menu() {
	$theme_params = pix_theme_params();

	// OLD SVG ICON Loading
	// add_menu_page($theme_params['name'], $theme_params['name'], 'manage_options', 'pixfort-theme-dashboard', 'pixfort_theme_dashboard', get_template_directory_uri() . '/inc/config/img/pixfort-logo.svg', 1);

	add_menu_page($theme_params['name'], $theme_params['name'], 'manage_options', 'pixfort-theme-dashboard', 'pixfort_theme_dashboard', '', 1);
	add_submenu_page('pixfort-theme-dashboard', $theme_params['name'] . ' Dashboard', 'Dashboard', 'manage_options', 'pixfort-theme-dashboard', 'pixfort_theme_dashboard', 3);
}

function pixfort_theme_dashboard() {
	if (isset($_GET['page']) && $_GET['page'] === 'pixfort-theme-dashboard' && !isset($_GET['pixfortKey'])) {
		require_once get_template_directory() . '/inc/config/dashboard-wizard.php';
	}
}

add_action('admin_init', 'pixfortDashboardRequest');
function pixfortDashboardRequest() {
	// Returned from hub
	$validationResult = false;
	$redirectURL = '?page=pixfort-dashboard';
	$optionsKey = 'pixfort_dashboard_options';
	if (!empty($_GET['page'])) {
		if ($_GET['page'] === 'pixfort-theme-dashboard') {
			$redirectURL = 'admin.php?page=pixfort-theme-dashboard';
			$optionsKey = 'pixfort_dashboard_wizard';
		}
	}
	if (!empty($_GET['pixfortKey'])) {
		$pixfortHub = new PixfortHub();
		$status = $pixfortHub->checkValidation();
		if (!$status) {
			$validationResult = $pixfortHub->pix_theme_verify($_GET['pixfortKey']);
			if (!empty($validationResult) && !empty($validationResult['result'])) {
				if ($validationResult['result']) {
					// $data = array(
					// 	'is-start' => true,
					// 	'step'     => 2
					// );
					// $dashboard_options = get_option($optionsKey);
					// if ($dashboard_options) {
					// 	$data['is-start'] = $dashboard_options['is-start'];
					// }
					// update_option($optionsKey, $data);
					wp_redirect(admin_url($redirectURL));
				}
			}
		} else {
			wp_redirect(admin_url($redirectURL));
		}
	}
}


function pixSameDomains($domain1, $domain2) {
	if (substr($domain1, 0, 8) === "https://") {
		$domain1 = substr($domain1, 8);
	} elseif (substr($domain1, 0, 7) === "http://") {
		$domain1 = substr($domain1, 7);
	}
	if (substr($domain1, 0, 4) === "www.") {
		$domain1 = substr($domain1, 4);
	}

	if (substr($domain2, 0, 8) === "https://") {
		$domain2 = substr($domain2, 8);
	} elseif (substr($domain2, 0, 7) === "http://") {
		$domain2 = substr($domain2, 7);
	}
	if (substr($domain2, 0, 4) === "www.") {
		$domain2 = substr($domain2, 4);
	}

	if ($domain2 != $domain1) {
		return false;
	}
	return true;
}

/**
 * One click demo import plugin configuration
 */
function PIX_OCDI_page_setup($default_settings) {
	$default_settings['parent_slug'] = 'themes.php';
	$default_settings['page_title']  = esc_html__('One Click Demo Import', 'conseil');
	$default_settings['menu_title']  = esc_html__('Import Demo Data', 'conseil');
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'pix-one-click-demo-import';

	return $default_settings;
}
add_filter('pt-ocdi/plugin_page_setup', 'PIX_OCDI_page_setup');
