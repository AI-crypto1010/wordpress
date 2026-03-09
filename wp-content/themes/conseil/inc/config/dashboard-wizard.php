<?php

if (!defined('ABSPATH')) {
    exit;
}

$pixfortHub = new PixfortHub();
$token = $pixfortHub->getCsrfToken();
$nonce = $pixfortHub->getVerifyNonce();
$verify_action = $pixfortHub->getverifyAction();
$verify_url = $pixfortHub->getVerifyUrl();
$dashboard_wizard = get_option('pixfort_dashboard_wizard');
$status = $pixfortHub->checkValidation();

$step = 1;
$data = array(
    'is-start' => true,
    'step'     => $step
);

$coreVersion = false;
$oldCoreVersion = false;
if(defined('PIXFORT_PLUGIN_VERSION')) {
    $coreVersion = PIXFORT_PLUGIN_VERSION;
    if (version_compare(PIXFORT_PLUGIN_VERSION, '3.2.5', '<=')) {
        $oldCoreVersion = true;
    }
}

$pixDebug = false;
if (!empty($_GET['pix_debug'])) {
    $pixDebug = true;
}

/*
* Links
*/
$wizard_links = array(
    'dashboard_link'   => admin_url('admin.php?page=pixfort-options#/dashboard'),
    'demo_import_link' => admin_url('admin.php?page=pixfort-options#/demo-import'),
    'theme_options_link' => admin_url('admin.php?page=pixfort-options#/'),
);

if ($dashboard_wizard) {
    $isStart = $dashboard_wizard['is-start'];
    $step = (int) $dashboard_wizard['step'];
} else {
    update_option('pixfort_dashboard_wizard', $data);
}

if(!$status) {
    // Not activated
    $step = 1;
} else {
    if($step===1||$step===2) {
        // Returned from pixfort hub
        $step = 2;
        $data = array(
            'is-start' => true,
            'step'     => 3
        );
        update_option('pixfort_dashboard_wizard', $data);
    } else {
        $step = 3;
        if(!$coreVersion) {
            // pixfort core not installed
            $step = 3;
        } 
        // else {
        //     if(!$oldCoreVersion) {
        //         wp_redirect(admin_url('admin.php?page=pixfort-options#/dashboard'));
        //     }
        // }
    }
}

if (!empty($_GET['pix_step'])) {
    $step = $_GET['pix_step'];
}


// update_option('pixfort_dashboard_wizard', $data);

/*
* Plugins
*/
if(class_exists('PixFort_Plugins_Setup')){
    $pluginsInstance = PixFort_Plugins_Setup::get_instance();
    $plugins = $pluginsInstance->_get_plugins_data();
}

if (!empty($_GET['pixinfo'])) {
    echo '<div class="bg-white p-3 rounded-lg shadow-sm m-4">';
    echo '<strong>Purchase code:</strong><div>' . get_option('envato_purchase_code_61457003') . '</div>';
    echo '<div><strong>pixfort key:</strong> ' . get_option('pixfort_key') . '</div>';
    echo '<div><strong>pixfort site URL:</strong> ' . get_option('pixfort_site_theme_url') . '</div>';
    echo '<div><strong>License update:</strong> ' . get_option('pix_license_update_fail') . '</div>';
    echo '<strong>site_url:</strong> '. site_url();
    echo '</div>';
}

echo '<div id="pixfort-theme-dashboard"></div>';
if (defined('PIXFORT_DEV')) {
    wp_enqueue_script('pixfort-theme-dashboard', get_template_directory_uri() . '/temp/dashboard/index.bundle.js', [], time(), true);
} else {
    wp_enqueue_script('pixfort-theme-dashboard', get_template_directory_uri() . '/dist/dashboard/index.bundle.js', [], time(), true);
}

wp_localize_script('pixfort-theme-dashboard', 'pix_obj', array(
    'domain' => site_url(),
    'theme_version' => esc_attr(PIXFORT_THEME_VERSION),
    'theme'         => esc_attr(PIXFORT_THEME_SLUG),
    'core_version' => $coreVersion,
    'old_core_version' => $oldCoreVersion,
    'pix_debug' => $pixDebug,
    'version'       => '2',
    'verify_action' => $verify_action,
    'verify_url'    => $verify_url,
    'return_url'    => admin_url('admin.php?page=pixfort-theme-dashboard'),
    'step'    => $step,
    'plugins_data'    => $plugins,
    'wizard_links'    => $wizard_links,
    'tgm_data'   => [
        'tgm_plugin_nonce' => [
            'update'  => wp_create_nonce('tgmpa-update'),
            'install' => wp_create_nonce('tgmpa-install'),
        ],
        'tgm_bulk_url'     => admin_url('themes.php?page=tgmpa-install-plugins'),
        'ajaxurl'          => admin_url('admin-ajax.php'),
        'wpnonce'          => wp_create_nonce('envato_setup_nonce'),
    ]
));




