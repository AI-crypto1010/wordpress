<?php

/*
 * Display the fields template
 */
function pix_customizer_custom_fields() {
	$sections = fields_list();
?>
	<div class="pix-menu-item-opts">
		<a target="_blank" href="https://wordpress.pixfort.com/docs/how-to-create-menus/" class="pix-menu-mega-badge">Mega Menu</a>
		<?php
		foreach ($sections as $skey => $sval) :
		?>
			<div class="<?php echo esc_attr($skey); ?>">
				<?php
				foreach ($sval as $_key => $field) :
					$key   = sprintf('menu-item-%s', $_key);
					$id    = sprintf('edit-%s', $key);
					$name  = sprintf('%s', $key);
					$value = '';
					$class = sprintf('field-%s', $_key);
					$element = $field['element'];
					$item = false;
					if ($element == 'checkbox') {
						pix_create_checkbox_field($id, $item, $key, $name, $value, $class, $field);
					}
					if ($element == 'select') {
						pix_create_select_field($id, $item, $key, $name, $value, $class, $field);
					}
					if ($element == 'text') {
						pix_create_text_field($id, $item, $key, $name, $value, $class, $field);
					}
					if ($element == 'media') {
						pix_create_media_field($id, $item, $key, $name, $value, $class, $field);
					}
					if ($element == 'advanced') {
						pix_create_advanced_field($id, $item, $key, $name, $value, $class, $field);
					}

				endforeach;
				?>
			</div>
		<?php
		endforeach;
		?>
	</div>

<?php
}
add_action('wp_nav_menu_item_custom_fields_customize_template', 'pix_customizer_custom_fields');

function pix_filter_nav_menu_item($item) {
	$sections = fields_list();
	$arr = array();
	foreach ($sections as $skey => $sval) {
		foreach ($sval as $_key => $field) {
			$key   = sprintf('menu-item-%s', $_key);
			$id    = sprintf('edit-%s', $key);
			$value = get_post_meta($item->ID, $key, true);
			$arr[$_key] = $value;
		}
	}
	$item->pix_menu_data = $arr;
	$item->pix_data_check = "check";
	return $item;
}
add_filter('wp_setup_nav_menu_item', 'pix_filter_nav_menu_item', 1);

// Enqueue script which extends nav menu item controls.
add_action(
	'customize_controls_enqueue_scripts',
	static function () {
		$sections = fields_list();
		wp_enqueue_script(
			'customize-nav-menu-roles',
			get_template_directory_uri() . '/js/customizer-nav-menu.js',
			['customize-nav-menus'],
			PIXFORT_THEME_VERSION,
			true
		);
		wp_localize_script('customize-nav-menu-roles', 'pix_customize_object', array(
			'PIX_NAV_SECTIONS' => $sections,
		));
	}
);

/**
 * Get sanitized posted value for a setting's variable.
 *
 * @param WP_Customize_Nav_Menu_Item_Setting $setting Setting.
 *
 * @return array|string|null Roles value or null if no posted value present.
 */
function get_sanitized_var_post_data(WP_Customize_Nav_Menu_Item_Setting $setting, $varName) {
	if (!$setting->post_value()) {
		return null;
	}
	$unsanitized_post_value = $setting->manager->unsanitized_post_values()[$setting->id];
	$value = '';
	if (isset($unsanitized_post_value[$varName])) {
		$value = $unsanitized_post_value[$varName];
	}
	return $value;
}

/**
 * Save changes to the nav menu item fields.
 *
 * Note the unimplemented to-do in the doc block for the setting's preview method.
 *
 * @see WP_Customize_Nav_Menu_Item_Setting::update()
 *
 * @param WP_Customize_Nav_Menu_Item_Setting $setting Setting.
 */
function save_nav_menu_setting_postmeta(WP_Customize_Nav_Menu_Item_Setting $setting) {
	$dataCheck = get_sanitized_var_post_data($setting, "pix_data_check");
	$sections = fields_list();
	if(!empty($dataCheck)&&$dataCheck){
		foreach ($sections as $skey => $fields) {
			foreach ($fields as $_key => $label) {
				$key = sprintf('menu-item-%s', $_key);
				// Sanitize.
				$itemValue = get_sanitized_var_post_data($setting, $key);
				if (!empty($itemValue)) {
					$value = $itemValue;
				} else {
					$value = null;
				}
				// Update.
				if (!is_null($value)) {
					update_post_meta($setting->post_id, $key, $value);
				} else {
					delete_post_meta($setting->post_id, $key);
				}
			}
		}
	}
}

// Set up saving.
add_action(
	'customize_save_after',
	function ($wp_customize) {
		foreach ($wp_customize->settings() as $setting) {
			if ($setting instanceof WP_Customize_Nav_Menu_Item_Setting && $setting->check_capabilities()) {
				save_nav_menu_setting_postmeta($setting);
			}
		}
	}
);
