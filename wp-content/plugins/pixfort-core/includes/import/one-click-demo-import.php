<?php

// Block direct access to the main plugin file.
defined('ABSPATH') or die('-1');

if (!defined('PIXFORT_CORE_DEMO_VERSION')) {
	define('PIXFORT_CORE_DEMO_VERSION', true);
}

function demoImportPluginCheck() {
	if (is_user_logged_in()) {
		// Check if the plugin you want to deactivate is active
		if (function_exists('is_plugin_active')&&is_plugin_active('one-click-demo-import-plugin/one-click-demo-import.php')) {
			// Deactivate the plugin
			deactivate_plugins('one-click-demo-import-plugin/one-click-demo-import.php');
		}
		if (function_exists('is_plugin_active_for_network')&&is_plugin_active_for_network('one-click-demo-import-plugin/one-click-demo-import.php')) {
			// Deactivate the plugin
			deactivate_plugins('one-click-demo-import-plugin/one-click-demo-import.php');
		}
	}
}
// Hook this function to an action where you want the deactivation to take place
add_action('admin_init', 'demoImportPluginCheck');

if (!class_exists('PIX_OCDI')) {
	/**
	 * Main plugin class with initialization tasks.
	 */
	class PIX_OCDI {
		/**
		 * Constructor for this class.
		 */
		public function __construct() {
			// Set plugin constants.
			$this->set_plugin_constants();

			// Composer autoloader.
			require_once PT_OCDI_PATH . 'vendor/autoload.php';

			// Instantiate the main plugin class *Singleton*.
			$pt_one_click_demo_import = OCDI\OneClickDemoImport::get_instance();
			
		}


		/**
		 * Set plugin constants.
		 *
		 * Path/URL to root of this plugin, with trailing slash and plugin version.
		 */
		private function set_plugin_constants() {
			// Path/URL to root of this plugin, with trailing slash.
			if (!defined('PT_OCDI_PATH')) {
				define('PT_OCDI_PATH', plugin_dir_path(__FILE__));
			}
			if (!defined('PT_OCDI_URL')) {
				define('PT_OCDI_URL', plugin_dir_url(__FILE__));
			}

			// Action hook to set the plugin version constant.
			add_action('admin_init', array($this, 'set_plugin_version_constant'));
		}


		/**
		 * Set plugin version constant -> PT_OCDI_VERSION.
		 */
		public function set_plugin_version_constant() {
			if (!defined('PT_OCDI_VERSION')) {
				$plugin_data = get_plugin_data(__FILE__);
				define('PT_OCDI_VERSION', $plugin_data['Version']);
			}
		}
	}

	// Instantiate the plugin class.
	$PIX_OCDI = new PIX_OCDI();	
	
}

