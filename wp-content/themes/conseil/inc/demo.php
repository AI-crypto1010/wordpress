<?php

add_filter('pt-ocdi/import_files', 'pixfort_import_files');


function pixfort_import_files($dynamic=false) {

	if (isset($_GET['page']) && ($_GET['page'] === 'pixfort-options' || $_GET['page'] === 'pix-one-click-demo-import') || $dynamic || defined('DOING_AJAX')) {
	if (class_exists('PixfortHub')) {
		$status = PixfortHub::checkValidation();
		if ($status) {
			require_once('demo-content/popups.php');
			require_once('demo-content/demos.php');
			require_once('demo-content/misc.php');
			require_once('demo-content/forms.php');
			require_once('demo-content/headers.php');

			$data = array();

			$data = array_merge($data, pixfort_demo_sites());
			$data = array_merge($data, pixfort_demo_headers());
			$data = array_merge($data, pixfort_demo_elementor_popups());
			$data = array_merge($data, pixfort_demo_misc());
			$data = array_merge($data, pixfort_demo_forms());
			return $data;
		}
	}
	}
	return [];
}



function pixfort_demo_args($getArgs) {
	$key = get_option('envato_purchase_code_61457003');
	if (!$key) {
		return $getArgs;
	}
	return array(
		'timeout' => apply_filters('pt-ocdi/timeout_for_downloading_import_file', 20),
		'headers' => array(
			'pix_domain' => site_url(),
			'item' => 'conseil',
			'purchase_key' => $key
		)
	);
}
add_filter('pixfort_one_click_demo_args', 'pixfort_demo_args', 1);

function pixfort_after_import($selected_import, $import_files, $selected_index) {
	if (!empty($selected_import['content']) && $selected_import['content'] != '') {
		$import = $import_files[$selected_index];
		if (!empty($import['import_file_name'])) {
			$name = $import['import_file_name'];
			$front_page_id = false;
			$demo_names = [
				['name' => 'Consulting', 'size' => 1300],
				['name' => 'Partners', 'size' => 1300],
				['name' => 'Digital Agency', 'size' => 1300],
				['name' => 'Trust', 'size' => 1300],
				['name' => 'Advisory', 'size' => 1400],
				['name' => 'Vision', 'size' => 1300],
				['name' => 'Prime', 'size' => 1300],
				['name' => 'Growth', 'size' => 1300],
				['name' => 'RTL', 'size' => 1300],
				['name' => 'App', 'size' => 1300],
				['name' => 'SaaS', 'size' => 1300],
			];
			
			foreach ($demo_names as $demo) {
				if ($name === $demo['name']) {
					$front_page_id = pixfort_get_page_by_title($demo['name'] . ' Homepage');
					
					if (isset($demo['size']) && $demo['size'] !== false && class_exists('\Elementor\Plugin')) {
						pixfort_update_elementor_container_width_new($demo['size']);
						pixfort_update_elementor_container_width_legacy($demo['size']);
						
						$kit = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend();
						$kit->update_settings([
							'container_width' => array(
								'size' => $demo['size'],
							),
						]);
						if (class_exists('PixfortCore')) {
							if(\PixfortCore::instance()->adminCore){
								try {
									\PixfortCore::instance()->adminCore->coreOptions->update_elementor_container_width_new($demo['size']);
								} catch (\Exception $e) {
									
								}
							}
						}
					}
				}
			}

			if (class_exists('\Elementor\Plugin')) {
				\Elementor\Plugin::$instance->files_manager->clear_cache();
			}

			if ($front_page_id) {
				update_option('show_on_front', 'page');
				update_option('page_on_front', $front_page_id);
			}
		}
	}
	if (function_exists('pix_update_style_url')) {
		pix_update_style_url();
	}
	if (class_exists('PixfortCore')) {
		if (\PixfortCore::instance()->adminCore) {
			try {
				\PixfortCore::instance()->adminCore->coreOptions->pixfortCompileOptions();
			} catch (\Exception $e) {
			}
		}
	}
}
add_action('pt-ocdi/after_all_import_execution', 'pixfort_after_import', 10, 3);

function pixfort_get_page_by_title($page_title) {
	$args = array(
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'title'          => $page_title,
		'posts_per_page' => 1
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		$query->the_post();
		$postID = get_the_ID();
		wp_reset_postdata(); // Resets the post data to the original query
		return $postID;
	}

	return false;
}


/**
 * Update Elementor container width using the legacy method (older versions)
 * 
 * @param int $width Container width in pixels
 */
if (!function_exists('pixfort_update_elementor_container_width_legacy')) {
	function pixfort_update_elementor_container_width_legacy($width) {
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
}

/**
 * Update Elementor container width using the newer method (Elementor 3.0+)
 * 
 * @param int $width Container width in pixels
 */
if (!function_exists('pixfort_update_elementor_container_width_new')) {
	function pixfort_update_elementor_container_width_new($width) {
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

