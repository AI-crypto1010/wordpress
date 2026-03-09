<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Core Options.
 *
 * 
 *
 * @since 1.0.0
 */
class CoreOptions {
	/**
	 * Instance.
	 *
	 * Holds the options instance.
	 *
	 *
	 */
	public static $instance = null;

	public function __construct() {
		$this->load();
	}

	public function load() {
		add_action('admin_menu', array($this, 'pixfort_options_init'), 99);
		// AJAX actions for authenticated users only
		add_action('wp_ajax_pix_options_save', array($this, 'saveData'));
		add_action('wp_ajax_pix_options_getFonts', array($this, 'getFonts'));
		add_action('wp_ajax_pix_options_exportOptions', array($this, 'exportOptions'));
		add_action('wp_ajax_pix_options_importOptions', array($this, 'importOptions'));
		add_action('wp_ajax_pix_options_getOptions', array($this, 'getOptions'));
		add_action('wp_ajax_pix_core_getDemos', array($this, 'getDemos'));
		add_action('wp_ajax_pix_core_getElementorDemos', array($this, 'getElementorDemos'));
		add_action('wp_ajax_pix_core_getElementorTemplate', array($this, 'getElementorTemplate'));

		add_action('after_setup_theme', array($this, 'checkOptions'), 100);
	}

	/**
	 * Security validation helper method
	 * Checks user capabilities and nonce verification
	 * 
	 * @param string $capability Required capability (default: 'manage_options')
	 * @param bool $require_nonce Whether to require nonce verification (default: true)
	 * @return void Dies with error if validation fails
	 */
	private function validate_ajax_security($capability = 'manage_options', $require_nonce = true) {
		// Check if user is logged in
		if (!is_user_logged_in()) {
			wp_die('Unauthorized: User not logged in', 'Security Error', array('response' => 401));
		}

		// Check user capabilities
		if (!current_user_can($capability)) {
			wp_die('Unauthorized: Insufficient permissions', 'Security Error', array('response' => 403));
		}

		// Verify nonce if required
		if ($require_nonce) {
			$nonce = isset($_REQUEST['nonce']) ? $_REQUEST['nonce'] : '';
			if (!wp_verify_nonce($nonce, 'pixfort_ajax_nonce')) {
				wp_die('Unauthorized: Invalid security token', 'Security Error', array('response' => 403));
			}
		}
	}

	
	function pixfort_options_init() {
		add_submenu_page('pixfort-theme-dashboard', 'Theme Options', 'Theme Options', 'manage_options', 'pixfort-options', array($this, 'pixfort_options_page'), 1);
		add_submenu_page('pixfort-theme-dashboard', 'Demo Import', 'Demo Import', 'import', 'pixfort-options#/demo-import', 'pt-ocdi/plugin_page_setup', 2);
	}

	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	function checkOptions() {
		$pix_options = get_option("pix_options");
		if (!$pix_options) {
			require_once PIXFORT_PLUGIN_DIR . 'includes/options/options.php';
			$options = pixDisplayOptions(false)->getOptions();
			$pix_options = [];
			foreach ($options as $key => $value) {
				if (!empty($value['default'])) {
					$pix_options[$key] = $value['default'];
				}
			}
			update_option('pix_options', $pix_options, true);
			$this->pixfort_save_compiler_action($pix_options);
		}
	}

	function getFonts() {
		// Security validation - Function that accesses font configurations
		$this->validate_ajax_security('manage_options', true);
		
		$result = [];
		if (!empty($_REQUEST['data'])) {
			$data = $_REQUEST['data'];
			$data = stripslashes($data);
			$obj = json_decode(wp_specialchars_decode($data, TRUE));

			$defaultFonts = [
				"Arial, Helvetica, sans-serif",
				"'Arial Black', Gadget, sans-serif",
				"'Bookman Old Style', serif",
				"'Comic Sans MS', cursive",
				"Courier, monospace",
				"Garamond, serif",
				"Georgia, serif",
				"Impact, Charcoal, sans-serif",
				"'Lucida Console', Monaco, monospace",
				"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
				"'MS Sans Serif', Geneva, sans-serif",
				"'MS Serif', 'New York', sans-serif",
				"'Palatino Linotype', 'Book Antiqua', Palatino, serif",
				"Tahoma, Geneva, sans-serif",
				"'Times New Roman', Times, serif",
				"'Trebuchet MS', Helvetica, sans-serif",
				"Verdana, Geneva, sans-serif",
			];

			$pixFonts = [];
			if (!empty(pix_plugin_get_option('opt-external-font-1-name'))) {
				$pixFonts[pix_plugin_get_option('opt-external-font-1-name')] = 'pix-' . pix_plugin_get_option('opt-external-font-1-name');
			}
			if (!empty(pix_plugin_get_option('opt-external-font-2-name'))) {
				$pixFonts[pix_plugin_get_option('opt-external-font-2-name')] = 'pix-' . pix_plugin_get_option('opt-external-font-2-name');
			}

			$googleFonts = [];
			$googleFile = PIX_CORE_PLUGIN_DIR . '/includes/options/data/googlefonts.php';
			if (file_exists($googleFile)) {
				$googleFontsData = include $googleFile;
				foreach ($googleFontsData as $key => $value) {
					array_push($googleFonts, $key);
				}
			}
			$result = [
				'defaultFonts'  => $defaultFonts,
				'pixFonts'  => $pixFonts,
				'googleFonts'  => $googleFonts,
				'extras'  => get_option($obj->option)
			];
		}
		wp_send_json($result);
	}

	function getDemos() {
		// Security validation - Function that accesses demo import data
		$this->validate_ajax_security('manage_options', true);
		
		$result = [];
		if (!empty($_REQUEST['data'])) {
			$data = $_REQUEST['data'];
			$data = stripslashes($data);
			$obj = json_decode(wp_specialchars_decode($data, TRUE));
			$pixDemos = [];
			if(function_exists('pixfort_import_files')){
				$pixDemos = pixfort_import_files(true);
			}
			$wooActive = false;
			if (class_exists('WooCommerce')) {
				$wooActive = true;
			}
			$cf7Active = false;
			if (function_exists('wpcf7_plugin_path')) {
				$cf7Active = true;
			}
			$result = [
				'demos'  => $pixDemos,
				'ajax_nonce'       => wp_create_nonce('pixfort-ajax-verification'),
				'extras'  => get_option($obj->option),
				'wooActive'  => $wooActive,
				'cf7Active'  => $cf7Active
			];
		}
		wp_send_json($result);
	}
	function getElementorDemos() {
		// Security validation - Function that accesses Elementor demo data
		$this->validate_ajax_security('manage_options', true);
		
		$result = [];
		$pixDemos = [];
		if(function_exists('pixfort_elementor_library_data')){
			$pixDemos = pixfort_elementor_library_data();
		}
		$result = [
			'demos'  => $pixDemos
		];
		wp_send_json($result);
	}
	function getElementorTemplate() {
		// Security validation - Function that accesses Elementor template data
		$this->validate_ajax_security('manage_options', true);
		
		$result = [];
		if (!empty($_REQUEST['template_id']) && !empty($_REQUEST['editor_post_id'])) {
			$template_id = $_REQUEST['template_id'];
			$editor_post_id = $_REQUEST['editor_post_id'];
			require_once PIXFORT_PLUGIN_DIR . 'includes/import/elementor/source.php';
			$source = new \Elementor\TemplateLibrary\Source_Pixfort();
			$template = '';
			$template = $source->get_data([
				'template_id' => $template_id,
				'editor_post_id' => $editor_post_id,
			]);
			if(!empty($template) && is_object($template) && !empty($template->errors) && !empty($template->errors['template_data_error'])){
				wp_die($template->errors['template_data_error'][0], '', [
					'response'  => 401
				]);	
			}
			$result = [
				'data'  => $template
			];
		}
		wp_send_json($result);
	}

	function saveData() {
		// Security validation - Critical function that saves theme options
		$this->validate_ajax_security('manage_options', true);
		
		$pix_options = get_option("pix_options");
		$data = array(
			'result' => true
		);
		try {
			if (!empty($_REQUEST['data'])) {
				if (!is_array($pix_options)) {
					$pix_options = [];
				}
				$data = $_REQUEST['data'];
				$data = stripslashes($data);
				$obj = json_decode(wp_specialchars_decode($data, TRUE));
				foreach ($obj as $key => $fields) {
					if (!empty($fields->value)) {
						if ($fields->type === 'media' || $fields->type === 'typography') {
							if (gettype($fields->value) === 'string') {
								$pix_options[$key] = json_decode($fields->value, true);
							}
							if (gettype($fields->value) === 'object') {
								$mediaValue = (array) $fields->value;
								$pix_options[$key] = $mediaValue;
								if ($key === 'favicon-img' && !empty($fields->value) && !empty($fields->value->id)) {
									if (defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG == 'essentials') {
										update_option('site_icon', $fields->value->id);
									}
								}
							}
						} elseif ($fields->type === 'gradient') {
							if (gettype($fields->value) === 'object') {
								$objValue = (array) $fields->value;
								$pix_options[$key] = $objValue;
							}
						} elseif ($fields->type === 'checkbox') {
							$pix_options[$key] = '1';
						} else {
							if (property_exists($fields, 'value')) {
								$pix_options[$key] = $fields->value;
							}
						}
					} else {
						if (property_exists($fields, 'value')) {
							if ($fields->type === 'checkbox' && $fields->value === false) {
								$pix_options[$key] = '0';
							} else {
								$pix_options[$key] = $fields->value;
							}
						}
					}
				}
				update_option('pix_options', $pix_options);
				$this->pixfort_save_compiler_action($pix_options);

				// if(PixfortCore::instance()->dynamicColors) {
					if(\PixfortCore::instance()->styleFunctions) { 
						\PixfortCore::instance()->styleFunctions->generateStyling();
						\PixfortCore::instance()->styleFunctions->updateElementorGlobalColors();
					}
				// }
			}
		} catch (\Throwable $th) {
			wp_die('Error: ' . $th->getMessage(), 'The title', [
				'response'  => 401
			]);
		}
		wp_die();
	}

	function exportOptions() {
		// Security validation - Critical function that exports sensitive theme options
		$this->validate_ajax_security('manage_options', true);
		
		$result = [];
		$result = [
			'data'  => get_option('pix_options')
		];
		wp_send_json($result);
	}

	function getOptions() {
		// Security validation - Function that retrieves sensitive theme options
		$this->validate_ajax_security('manage_options', true);
		
		require_once PIXFORT_PLUGIN_DIR . 'includes/options/options.php';
		$newOption = pixDisplayOptions(false);
		if ($newOption) $newOption = $newOption->getOptions();
		$result = [
			'success'  => true,
			'options'  => $newOption,
		];
		wp_send_json($result);
	}
	function importOptions() {
		// Security validation - Critical function that imports and modifies theme options
		$this->validate_ajax_security('manage_options', true);
		
		$result = [];
		$success = false;
		if (!empty($_REQUEST['data'])) {
			$pix_options = get_option("pix_options");
			$data = $_REQUEST['data'];
			$data = stripslashes($data);
			$obj = json_decode(wp_specialchars_decode($data, true));
			if (!empty($obj->options)) {
				$options = json_decode(wp_specialchars_decode($obj->options, true));
				foreach ($options as $key => $value) {
					if (gettype($value) === 'object') {
						$formatValue = (array) $value;
						$pix_options[$key] = $formatValue;
					} else {
						$pix_options[$key] = $value;
					}
				}
				update_option('pix_options', $pix_options);
				$this->pixfort_save_compiler_action($pix_options);
				$success = true;
			}
		}
		if ($success) {
			require_once PIXFORT_PLUGIN_DIR . 'includes/options/options.php';
			$newOption = pixDisplayOptions(false);
			if ($newOption) $newOption = $newOption->getOptions();
			$result = [
				'success'  => $success,
				'options'  => $newOption,
			];
			wp_send_json($result);
		} else {
			wp_die('Error: unable to proccess the request', 'Unable to proccess the request!', [
				'response'  => 401
			]);
		}
	}

	function pixfort_options_page() {
		require_once PIXFORT_PLUGIN_DIR . 'includes/options/options.php';
		pixDisplayOptions();
	}

	function pixfortCompileOptions() {
		$options = get_option('pix_options');
		$this->pixfort_save_compiler_action($options);
	}

	function pixfort_save_compiler_action($options) {
		update_option('pixfort_theme_options_notice', '');
		if (function_exists('pix_update_style_url')) {
			pix_update_style_url();
		}
		$this->pix_set_element_width($options);
		$this->pixSetElementorColor();

		$default_fonts = array(
			"Arial, Helvetica, sans-serif",
			"'Arial Black', Gadget, sans-serif",
			"'Bookman Old Style', serif",
			"'Comic Sans MS', cursive",
			"Courier, monospace",
			"Garamond, serif",
			"Georgia, serif",
			"Impact, Charcoal, sans-serif",
			"'Lucida Console', Monaco, monospace",
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"'MS Sans Serif', Geneva, sans-serif",
			"'MS Serif', 'New York', sans-serif",
			"'Palatino Linotype', 'Book Antiqua', Palatino, serif",
			"Tahoma, Geneva, sans-serif",
			"'Times New Roman', Times, serif",
			"'Trebuchet MS', Helvetica, sans-serif",
			"Verdana, Geneva, sans-serif",
		);
		/*
        * Body font
        */
		$primaryGoogleFont = false;
		$secondaryGoogleFont = false;
		$bodyWeightsList = [];
		$headingWeightsList = [];
		if (!empty($options['opt-primary-font'])) {
			$gFile = PIX_CORE_PLUGIN_DIR . '/includes/options/data/googlefonts.php';
			if (file_exists($gFile)) {
				$fonts = include $gFile;
				if (!empty($options['opt-primary-font']['font-family'])) {
					$primaryFontFamily = $options['opt-primary-font']['font-family'];
					if (array_key_exists($primaryFontFamily, $fonts)) {
						$options['opt-primary-font']['notGoogleFont'] = false;
						if ($options['opt-primary-font']['google'] && strcmp($options['opt-primary-font']['google'], 'false') != 0) {
							if (empty($options['opt-external-font-1-name'])) $options['opt-external-font-1-name'] = '';
							if (empty($options['opt-external-font-2-name'])) $options['opt-external-font-2-name'] = '';
							if (
								$options['opt-primary-font']['font-family'] != $options['opt-external-font-1-name']
								&& $options['opt-primary-font']['font-family'] != $options['opt-external-font-2-name']
							) {
								if (!in_array($options['opt-primary-font']['font-family'], $default_fonts)) {

									if (!empty($options['opt-regular-font-weight'])) {
										array_push($bodyWeightsList, $options['opt-regular-font-weight']);
									} else {
										array_push($bodyWeightsList, "400");
									}
									if (!empty($options['opt-bold-font-weight'])) {
										array_push($bodyWeightsList, $options['opt-bold-font-weight']);
									} else {
										array_push($bodyWeightsList, "700");
									}
									$primaryGoogleFont = $options['opt-primary-font']['font-family'];
									array_push($default_fonts, $primaryGoogleFont);
								}
							}
						}
					} else {
						$options['opt-primary-font']['notGoogleFont'] = true;
					}
					update_option('pix_options', $options);
				}
			}
		}
		/*
        * Heading font
        */
		if (!empty($options['opt-secondary-font'])) {
			$gFile = PIX_CORE_PLUGIN_DIR . '/includes/options/data/googlefonts.php';
			if (file_exists($gFile)) {
				$fonts = include $gFile;
				if (!empty($options['opt-secondary-font']['font-family'])) {
					$secondaryFontFamily = $options['opt-secondary-font']['font-family'];
					if (array_key_exists($secondaryFontFamily, $fonts)) {
						$options['opt-secondary-font']['notGoogleFont'] = false;

						if (!empty($options['opt-heading-font-weight'])) {
							array_push($headingWeightsList, $options['opt-heading-font-weight']);
						} else {
							if (!empty($options['opt-regular-font-weight'])) {
								array_push($headingWeightsList, $options['opt-regular-font-weight']);
							} else {
								array_push($headingWeightsList, "400");
							}
						}
						if (!empty($options['opt-heading-bold-font-weight'])) {
							array_push($headingWeightsList, $options['opt-heading-bold-font-weight']);
						} else {
							if (!empty($options['opt-bold-font-weight'])) {
								array_push($headingWeightsList, $options['opt-bold-font-weight']);
							} else {
								array_push($headingWeightsList, "700");
							}
						}

						if (
							$options['opt-secondary-font']['google']
							&& strcmp($options['opt-secondary-font']['google'], 'false') != 0
							&& $options['opt-secondary-font']['google'] != false
						) {
							if (
								$options['opt-secondary-font']['font-family'] != $options['opt-external-font-1-name']
								&& $options['opt-secondary-font']['font-family'] != $options['opt-external-font-2-name']
							) {
								if (!in_array($options['opt-secondary-font']['font-family'], $default_fonts)) {
									$secondaryGoogleFont = $options['opt-secondary-font']['font-family'];
								} else {
									$bodyWeightsList = array_unique(array_merge($bodyWeightsList, $headingWeightsList));
								}
							}
						}
					} else {
						$options['opt-secondary-font']['notGoogleFont'] = true;
					}
					update_option('pix_options', $options, true);
				}
			}
		}
		// if (!empty($primaryGoogleFont) && $primaryGoogleFont) {
		// 	$bodyWeights = implode(',', $bodyWeightsList);
		// 	$googleFontURL_1 = esc_url_raw('https://fonts.googleapis.com/css?display=swap&family=' . $primaryGoogleFont . ':' . $bodyWeights);
		// 	update_option('pix_google_font_1', $googleFontURL_1);
		// } else {
		// 	update_option('pix_google_font_1', '');
		// }
		// if (!empty($secondaryGoogleFont) && $secondaryGoogleFont) {
		// 	$headingWeights = implode(',', $headingWeightsList);
		// 	$googleFontURL_2 = esc_url_raw('https://fonts.googleapis.com/css?display=swap&family=' . $secondaryGoogleFont . ':' . $headingWeights);
		// 	update_option('pix_google_font_2', $googleFontURL_2);
		// } else {
		// 	update_option('pix_google_font_2', '');
		// }

		// Optimized Google Fonts
		$fontApiBaseURL = 'https://fonts.googleapis.com/css?family=';
		$displaySwapParam = '&display=swap';

		if ( !empty( $primaryGoogleFont ) && !empty( $secondaryGoogleFont ) ) {
			// Both fonts are provided.
			if ( $primaryGoogleFont === $secondaryGoogleFont ) {
				// The two font settings are identical.
				// Merge the two weights arrays so the font is loaded only once.
				$bodyWeights   = implode( ',', $bodyWeightsList );
				$headingWeights = implode( ',', $headingWeightsList );
				
				// Break the strings into arrays, merge them, remove duplicates, then recombine.
				$bodyWeightsArray    = explode( ',', $bodyWeights );
				$headingWeightsArray = explode( ',', $headingWeights );
				$mergedWeightsArray  = array_unique( array_merge( $bodyWeightsArray, $headingWeightsArray ) );
				$mergedWeights       = implode( ',', $mergedWeightsArray );
				
				// Build the Google Fonts URL for the single font.
				$googleFontURL = esc_url_raw(
					$fontApiBaseURL .
					urlencode( $primaryGoogleFont ) . ':' . $mergedWeights .
					$displaySwapParam
				);
				
				// Update both options with the same URL.
				update_option( 'pix_google_font_1', $googleFontURL );
				update_option( 'pix_google_font_2', $googleFontURL );
			} else {
				// Two different fonts: build one URL that includes both.
				$bodyWeights    = implode( ',', $bodyWeightsList );
				$headingWeights = implode( ',', $headingWeightsList );
				
				// Note: Google Fonts API accepts multiple families separated by a pipe.
				$googleFontURL = esc_url_raw(
					$fontApiBaseURL .
					urlencode( $primaryGoogleFont ) . ':' . $bodyWeights .
					'|' .
					urlencode( $secondaryGoogleFont ) . ':' . $headingWeights .
					$displaySwapParam
				);
				
				// Update both options with the combined URL.
				update_option( 'pix_google_font_1', $googleFontURL );
				update_option( 'pix_google_font_2', '' );
			}
		} elseif ( !empty( $primaryGoogleFont ) ) {
			// Only the primary font is provided.
			$bodyWeights    = implode( ',', $bodyWeightsList );
			$googleFontURL = esc_url_raw(
				$fontApiBaseURL .
				urlencode( $primaryGoogleFont ) . ':' . $bodyWeights .
				$displaySwapParam
			);
			update_option( 'pix_google_font_1', $googleFontURL );
			update_option( 'pix_google_font_2', '' );
		} elseif ( !empty( $secondaryGoogleFont ) ) {
			// Only the secondary font is provided.
			$headingWeights = implode( ',', $headingWeightsList );
			$googleFontURL = esc_url_raw(
				$fontApiBaseURL .
				urlencode( $secondaryGoogleFont ) . ':' . $headingWeights .
				$displaySwapParam
			);
			update_option( 'pix_google_font_1', '' );
			update_option( 'pix_google_font_2', $googleFontURL );
		} else {
			// No font is provided: clear the saved options.
			update_option( 'pix_google_font_1', '' );
			update_option( 'pix_google_font_2', '' );
		}
		
	}

	function pixSetElementorColor() {
		// Ensure Elementor is active/loaded
		if (!did_action('elementor/loaded')) {
			return;
		}
		
		// Get the Kits Manager from Elementor 
		if (!defined('ELEMENTOR_VERSION') || !class_exists('\Elementor\Plugin') || !method_exists('\Elementor\Plugin', 'instance')) {
			return;
		}
		
		$elementor = \Elementor\Plugin::instance();
		if (!$elementor || !property_exists($elementor, 'kits_manager')) {
			return;
		}
		
		$kits_manager = $elementor->kits_manager;
		if (!$kits_manager) {
			return;
		}

		// Get the active Kit (Site Settings)
		$kit = $kits_manager->get_active_kit();
		if (!$kit) {
			return;
		}

		// Get existing global colors or default to an empty array
		$custom_colors = $kit->get_settings('custom_colors');
		if (!is_array($custom_colors)) {
			$custom_colors = [];
		}

		// Build array of colors to add/update
		$colors_to_process = [];
		$pix_options = get_option("pix_options");
		
		if (!empty($pix_options['opt-primary-color'])) {
			$primaryColor = $pix_options['opt-primary-color'];
			$colors_to_process['pixPrimaryColor'] = [
				'title' => 'Theme Primary Color',
				'color' => $primaryColor
			];
		}
		if (!empty($pix_options['opt-secondary-color'])) {
			$secondaryColor = $pix_options['opt-secondary-color'];
			$colors_to_process['pixSecondaryColor'] = [
				'title' => 'Theme Secondary Color',
				'color' => $secondaryColor
			];
		}

		// Process all color operations in one batch
		$updated_colors = $this->batchProcessElementorColors($custom_colors, $colors_to_process);
		
		// Only save if there were actual changes
		if ($updated_colors !== $custom_colors) {
			// Update the kit's settings
			$kit->set_settings('custom_colors', $updated_colors);

			// Save the updated settings - SINGLE SAVE OPERATION
			$updated_settings = $kit->get_settings();
			$kit->save([
				'settings' => $updated_settings
			], 'general');
		}
	}

	/**
	 * Batch process Elementor color operations efficiently
	 */
	private function batchProcessElementorColors($existing_colors, $colors_to_add) {
		$updated_colors = [];
		
		// First, copy existing colors and track duplicates
		$processed_ids = [];
		foreach ($existing_colors as $color_item) {
			$color_id = isset($color_item['_id']) ? $color_item['_id'] : null;
			
			// Skip duplicate IDs (keep only the first occurrence)
			if ($color_id && in_array($color_id, $processed_ids)) {
				continue;
			}
			
			if ($color_id) {
				$processed_ids[] = $color_id;
			}
			
			$updated_colors[] = $color_item;
		}
		
		// Then add/update colors from the colors_to_add array
		foreach ($colors_to_add as $color_id => $color_data) {
			$new_color_item = [
				'_id'   => $color_id,
				'title' => $color_data['title'],
				'color' => $color_data['color'],
			];
			
			// Check if this ID already exists in our updated array
			$found_index = null;
			foreach ($updated_colors as $index => $existing_color) {
				if (isset($existing_color['_id']) && $existing_color['_id'] === $color_id) {
					$found_index = $index;
					break;
				}
			}
			
			if ($found_index !== null) {
				// Check if the color actually changed before updating
				$existing_color = $updated_colors[$found_index];
				if (isset($existing_color['color']) && $existing_color['color'] === $color_data['color'] && 
					isset($existing_color['title']) && $existing_color['title'] === $color_data['title']) {
					// No change needed, skip this color
					continue;
				}
				
				// Update existing with new values
				$updated_colors[$found_index] = array_merge(
					$updated_colors[$found_index],
					[
						'title' => $color_data['title'],
						'color' => $color_data['color'],
					]
				);
			} else {
				// Add new
				$updated_colors[] = $new_color_item;
			}
		}
		
		return $updated_colors;
	}

	function pix_set_element_width($options) {
		if (!empty($options['pix-custom-container-width'])) {
			$site_custom_width = get_option('pixfort_custom_width');
			$new_width = (int)$options['pix-custom-container-width'];
			if($site_custom_width!=$new_width){
				// First try the old method (for older Elementor versions)
				$this->update_elementor_container_width_legacy($new_width);
				
				// Then try the newer method (for newer Elementor versions)
				$this->update_elementor_container_width_new($new_width);

				update_option('pixfort_custom_width', $new_width);
			}
		} else {
			// Reset to default 1140px if no custom width is set
			$site_custom_width = get_option('pixfort_custom_width');
			if ($site_custom_width && $site_custom_width != 1140) {
				
				
				// First try the old method (for older Elementor versions)
				$this->update_elementor_container_width_legacy(1140);
				
				// Then try the newer method (for newer Elementor versions)
				$this->update_elementor_container_width_new(1140);

				update_option('pixfort_custom_width', 1140);
			}
		}
	}
	
	/**
	 * Update Elementor container width using the legacy method (older versions)
	 * 
	 * @param int $width Container width in pixels
	 */
	private function update_elementor_container_width_legacy($width) {
		if (!defined('ELEMENTOR_VERSION')) {
			return;
		}
		
		// Try original way (Elementor < 3.0)
		if (class_exists('\Elementor\Plugin')) {
			try {
				if (method_exists('\Elementor\Plugin', 'instance')) {
					$instance = \Elementor\Plugin::instance();
					if ($instance && property_exists($instance, 'settings')) {
						if (method_exists($instance->settings, 'update_settings')) {
							$instance->settings->update_settings('container_width', $width);
						}
					}
				}
			} catch (Exception $e) {
				// Just continue if this fails
			}
		}
	}
	
	/**
	 * Update Elementor container width using the newer method (Elementor 3.0+)
	 * 
	 * @param int $width Container width in pixels
	 */
	public function update_elementor_container_width_new($width) {
		if (!defined('ELEMENTOR_VERSION')) {
			return;
		}
		
		// Direct database approach (works in most versions)
		$kit_id = get_option('elementor_active_kit');
		if ($kit_id) {
			// Get existing settings
			$settings = get_post_meta($kit_id, '_elementor_page_settings', true);
			
			// If settings exist, update the container width
			if (is_array($settings)) {
				$settings['container_width'] = [
					'size' => $width,
					'unit' => 'px'
				];
			} else {
				// Create new settings array if none exists
				$settings = [
					'container_width' => [
						'size' => $width,
						'unit' => 'px'
					]
				];
			}
			
			// Update the settings
			update_post_meta($kit_id, '_elementor_page_settings', $settings);
		}
		
		// Try with kits_manager method (Elementor 3.0+)
		if (class_exists('\Elementor\Plugin')) {
			try {
				if (method_exists('\Elementor\Plugin', 'instance')) {
					$instance = \Elementor\Plugin::instance();
					if ($instance && property_exists($instance, 'kits_manager')) {
						$kit = $instance->kits_manager->get_active_kit();
						if ($kit) {
							$kit->update_settings([
								'container_width' => [
									'size' => $width,
									'unit' => 'px'
								]
							]);
						}
					}
				}
				
				// Clear cache if possible
				if (method_exists('\Elementor\Plugin', 'instance')) {
					$instance = \Elementor\Plugin::instance();
					if ($instance) {
						// Different methods to clear cache depending on Elementor version
						if (property_exists($instance, 'files_manager') && method_exists($instance->files_manager, 'clear_cache')) {
							$instance->files_manager->clear_cache();
						} elseif (method_exists($instance, 'frontend') && method_exists($instance->frontend, 'get_builder_content_for_display')) {
							// Older versions cleanup
							\Elementor\Plugin::$instance->frontend->get_builder_content_for_display(true);
						}
					}
				}
			} catch (Exception $e) {
				// Just continue if this fails
			}
		}
	}

	

}
