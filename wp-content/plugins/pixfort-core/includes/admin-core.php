<?php

if (!defined('ABSPATH')) {
    exit;
}

class PixfortAdminCore {

    public $coreOptions = null;
    public $params = [];
    public $optionsBack = null;

    function __construct() {
        add_action('admin_init',  [$this, 'adminFunctionInit']);
        add_action('admin_init',  [$this, 'loadAdminParams']);


        require_once PIXFORT_PLUGIN_DIR . 'includes/options/core-options.php';
        $this->coreOptions = new CoreOptions();
        require_once PIXFORT_PLUGIN_DIR . 'includes/import/one-click-demo-import.php';
        require_once PIXFORT_PLUGIN_DIR . 'includes/options/menus.php';
        require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/admin-interface-misc.php';
        new PixfortMenusOptions();
    }


    public function adminFunctionInit() {
        if (is_user_logged_in()) {
            require_once PIXFORT_PLUGIN_DIR . 'includes/options-back.php';
            $this->optionsBack = new OptionsBack();
            if (defined('PIXFORT_THEME_VERSION')) {
                $apiURL = 'https://hub.pixfort.com';
                if (function_exists('pix_theme_params')) {
                    $params = pix_theme_params();
                    if (isset($params['api_url'])) {
                        $apiURL = $params['api_url'];
                    }
                }
                require_once PIXFORT_PLUGIN_DIR . 'includes/updates/theme-updater.php';
                new PixfortThemeUpdater(
                    PIXFORT_THEME_SLUG,
                    PIXFORT_THEME_SLUG,
                    PIXFORT_THEME_VERSION,
                    $apiURL
                );
            }
        }
    }


    public function loadAdminParams() {
        $this->params = [
            'api_url' => 'https://pixfort.com',
        ];

        if (function_exists('pix_theme_params')) {
            $params = pix_theme_params();
            $this->params = array_replace($this->params, $params);
        }
    }

    public function getParam($param, $default = null) {
        return isset($this->params[$param]) ? $this->params[$param] : $default;
    }
}
