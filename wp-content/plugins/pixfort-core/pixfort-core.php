<?php
/*
   Plugin Name: pixfort Core
   Plugin URI: https://pixfort.com
   description: pixfort Core Plugin.
   Version: 3.4.3
   Author: pixfort
   Author URI: https://pixfort.com
   License: Proprietary License
   Text Domain: pixfort-core
   Domain Path: /languages
   Terms of Use: https://pixfort.com/terms   
*/

// don't load directly
if (!defined('ABSPATH')) {
   die('-1');
}
define('PIXFORT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('PIXFORT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PIXFORT_PLUGIN_VERSION', '3.4.3');

// Load pixfort core
require PIXFORT_PLUGIN_DIR . 'includes/core.php';
require PIXFORT_PLUGIN_DIR . 'admin-init.php';
