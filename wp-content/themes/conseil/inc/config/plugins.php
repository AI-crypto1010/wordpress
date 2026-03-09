<?php
if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('PixFort_Plugins_Setup')) {
	/**
	 * Envato_Theme_Setup_Wizard class
	 */
	class PixFort_Plugins_Setup {

		private static $instance = null;

		/**
		 * The class version number.
		 *
		 * @since 1.1.1
		 * @access private
		 *
		 * @var string
		 */
		protected $version = '1.0';

		/** @var string Current theme name, used as namespace in actions. */
		protected $theme_name = 'conseil';

		/**
		 * TGMPA instance storage
		 *
		 * @var object
		 */
		protected $tgmpa_instance;

		/**
		 * TGMPA Menu slug
		 *
		 * @var string
		 */
		protected $tgmpa_menu_slug = 'tgmpa-install-plugins';

		/**
		 * TGMPA Menu url
		 *
		 * @var string
		 */
		protected $tgmpa_url = 'themes.php?page=tgmpa-install-plugins';
		/**
		 * Relative plugin path
		 *
		 * @since 1.1.2
		 *
		 * @var string
		 */
		protected $plugin_path = '';

		/**
		 * Relative plugin url for this plugin folder, used when enquing scripts
		 *
		 * @since 1.1.2
		 *
		 * @var string
		 */
		protected $plugin_url = '';



		public static function get_instance() {
			if (!self::$instance) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		public function __construct() {

			$this->init_globals();
			$this->init_actions();
		}


		public function init_globals() {

			//set relative plugin path url
			$this->plugin_path = trailingslashit($this->cleanFilePath(dirname(__FILE__)));
			$relative_url      = str_replace($this->cleanFilePath(get_template_directory()), '', $this->plugin_path);
			$this->plugin_url  = trailingslashit(get_template_directory_uri() . $relative_url);
		}

		public function init_actions() {
			if (current_user_can('manage_options')) {
				if (class_exists('TGM_Plugin_Activation') && isset($GLOBALS['tgmpa'])) {
					add_action('init', array($this, 'get_tgmpa_instanse'), 30);
					add_action('init', array($this, 'set_tgmpa_url'), 40);
				}
				add_filter('tgmpa_load', array($this, 'tgmpa_load'), 10, 1);
				add_action('wp_ajax_envato_setup_plugins', array($this, 'ajax_plugins'));
			}
		}


		public function tgmpa_load($status) {
			return is_admin() || current_user_can('install_themes');
		}

		/**
		 * Get configured TGMPA instance
		 *
		 * @access public
		 * @since 1.1.2
		 */
		public function get_tgmpa_instanse() {
			$this->tgmpa_instance = call_user_func(array(get_class($GLOBALS['tgmpa']), 'get_instance'));
		}

		/**
		 * Update $tgmpa_menu_slug and $tgmpa_parent_slug from TGMPA instance
		 *
		 * @access public
		 * @since 1.1.2
		 */
		public function set_tgmpa_url() {

			$this->tgmpa_menu_slug = (property_exists($this->tgmpa_instance, 'menu')) ? $this->tgmpa_instance->menu : $this->tgmpa_menu_slug;
			$this->tgmpa_menu_slug = apply_filters($this->theme_name . '_theme_setup_wizard_tgmpa_menu_slug', $this->tgmpa_menu_slug);

			$tgmpa_parent_slug = (property_exists($this->tgmpa_instance, 'parent_slug') && $this->tgmpa_instance->parent_slug !== 'themes.php') ? 'admin.php' : 'themes.php';

			$this->tgmpa_url = apply_filters($this->theme_name . '_theme_setup_wizard_tgmpa_url', $tgmpa_parent_slug . '?page=' . $this->tgmpa_menu_slug);
		}

		private function pix_check_plugin_is_active($slug) {
			switch ($slug) {
				case 'pixfort-core':
					if (defined('PIXFORT_PLUGIN_VERSION')) return true;
					break;
				case 'js_composer':
					if (function_exists('vc_set_as_theme')) return true;
					break;
				case 'revslider':
					if (class_exists('RevSliderFront')) return true;
					break;
				case 'masterslider':
					if (function_exists('masterslider')) return true;
					break;
				case 'pixfort-likes':
					if (class_exists('PixFortLikes')) return true;
					break;
				case 'elementor':
					if (class_exists('\Elementor\Plugin')) return true;
					break;
				case 'contact-form-7':
					if (function_exists('wpcf7_plugin_path')) return true;
					break;
				case 'woocommerce':
					if (class_exists('WooCommerce')) return true;
					break;
			}
			return false;
		}

		private function _get_plugins() {
			$instance = call_user_func(array(get_class($GLOBALS['tgmpa']), 'get_instance'));
			$plugins  = array(
				'all'      => array(), // Meaning: all plugins which still have open actions.
				'install'  => array(),
				'update'   => array(),
				'activate' => array(),
			);

			foreach ($instance->plugins as $slug => $plugin) {
				if ($this->pix_check_plugin_is_active($slug) && false === $instance->does_plugin_have_update($slug)) {
					// No need to display plugins if they are installed, up-to-date and active.
					continue;
				} else {
					$plugins['all'][$slug] = $plugin;

					if (!$instance->is_plugin_installed($slug)) {
						$plugins['install'][$slug] = $plugin;
					} else {


						if (false !== $instance->does_plugin_have_update($slug)) {
							$plugins['update'][$slug] = $plugin;
						}

						if ($instance->can_plugin_activate($slug)) {
							$plugins['activate'][$slug] = $plugin;
						}
					}
				}
			}


			return $plugins;
		}

		public function _get_plugins_data($extras = false) {
			$instance = call_user_func(array(get_class($GLOBALS['tgmpa']), 'get_instance'));
			$plugins  = array(
				'all'      => array(), // Meaning: all plugins which still have open actions.
				'install'  => array(),
				'update'   => array(),
				'activate' => array(),
			);
			$data = [];
			$extraPlugins = ['masterslider', 'revslider'];
			$coreActive = false;
			if ($instance->is_plugin_installed('pixfort-core') && $this->pix_check_plugin_is_active('pixfort-core')) {
				$coreActive = true;
			}
			foreach ($instance->plugins as $slug => $plugin) {
				if (!$extras && in_array($slug, $extraPlugins)) continue;
				$plugin['version'] = $instance->does_plugin_have_update($slug);
				if (empty($plugin['version'])) {
					$plugin['version'] = $instance->get_installed_version($slug);
				}
				$data[$slug] = $plugin;
				// $data[$slug] = '';

				if (!$coreActive) {
					$data[$slug]['checked'] = true;
					if (in_array($slug, ['woocommerce', 'js_composer'])) {
						$data[$slug]['checked'] = false;
						// var_dump($this->pix_check_plugin_is_active($slug));
					}
				}
				if ($this->pix_check_plugin_is_active($slug)) {
					$data[$slug]['active'] = true;
				} else {
					$data[$slug]['active'] = false;
				}
				if ($this->pix_check_plugin_is_active($slug) && false === $instance->does_plugin_have_update($slug)) {
					// Plugin is ready! they are installed, up-to-date and active.
					$data[$slug]['status'] = 'ready';
				} else {
					if (!$instance->is_plugin_installed($slug)) {
						$data[$slug]['status'] = 'not_installed';
					} else {
						if (!$this->pix_check_plugin_is_active($slug) && $instance->can_plugin_activate($slug)) {
							$data[$slug]['status'] = 'not_active';
						} elseif (false !== $instance->does_plugin_have_update($slug)) {
							if ($coreActive) {
								$data[$slug]['checked'] = true;
							}
							$data[$slug]['status'] = 'not_updated';
						} else {
							$data[$slug]['status'] = '';
						}
					}
				}
			}


			return $data;
		}

		public function ajax_plugins() {
			if (!check_ajax_referer('envato_setup_nonce', 'wpnonce') || empty($_POST['slug'])) {
				wp_send_json_error(array('error' => 1, 'message' => esc_attr__('No Slug Found', 'conseil')));
			}
			$json = array();
			// send back some json we use to hit up TGM
			$plugins = $this->_get_plugins();
			// what are we doing with this plugin?
			foreach ($plugins['activate'] as $slug => $plugin) {
				if ($_POST['slug'] == $slug) {
					$json = array(
						'url'           => admin_url($this->tgmpa_url),
						'plugin'        => array($slug),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce('bulk-plugins'),
						'action'        => 'tgmpa-bulk-activate',
						'action2'       => -1,
						'message'       => esc_attr__('Activating Plugin', 'conseil'),
					);
					break;
				}
			}
			foreach ($plugins['update'] as $slug => $plugin) {
				if ($_POST['slug'] == $slug) {
					$json = array(
						'url'           => admin_url($this->tgmpa_url),
						'plugin'        => array($slug),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce('bulk-plugins'),
						'action'        => 'tgmpa-bulk-update',
						'action2'       => -1,
						'message'       => esc_attr__('Updating Plugin', 'conseil'),
					);
					break;
				}
			}
			foreach ($plugins['install'] as $slug => $plugin) {
				if ($_POST['slug'] == $slug) {
					$json = array(
						'url'           => admin_url($this->tgmpa_url),
						'plugin'        => array($slug),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce('bulk-plugins'),
						'action'        => 'tgmpa-bulk-install',
						'action2'       => -1,
						'message'       => esc_attr__('Installing Plugin', 'conseil'),
					);
					break;
				}
			}

			if ($json) {
				$json['hash'] = md5(serialize($json)); // used for checking if duplicates happen, move to next plugin
				wp_send_json($json);
			} else {
				wp_send_json(array('done' => 1, 'message' => esc_attr__('Success', 'conseil')));
			}
			exit;
		}




		public static function cleanFilePath($path) {
			$path = str_replace('', '', str_replace(array('\\', '\\\\', '//'), '/', $path));
			if ($path[strlen($path) - 1] === '/') {
				$path = rtrim($path, '/');
			}

			return $path;
		}
	}
}

add_action('after_setup_theme', 'pixfort_plugins_setup_wizard', 10);
if (!function_exists('pixfort_plugins_setup_wizard')) :
	function pixfort_plugins_setup_wizard() {
		PixFort_Plugins_Setup::get_instance();
	}
endif;
