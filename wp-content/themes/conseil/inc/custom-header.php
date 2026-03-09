<?php

// Create fields
// Show columns
// Save/Update fields
// Update the Walker nav
function fields_list() {
	$fields = array(
		'pix_megamenu_section' => array(
			'pix_is_megamenu'		=> array(
				'label' => esc_attr__('Enable Megamenu ', 'conseil'),
				'element' => 'checkbox',
				'classes'	=> 'pix-mega-opt'
			),
		),
		'pix_column_section'		=> array(
			'pix_is_column_item'		=> array(
				'label' => esc_attr__('Convert to column item ', 'conseil'),
				'element' => 'checkbox',
				'classes'	=> 'pix-dropdown-opt pix-column-opt'
			),
			'pix_hide_column_label'		=> array(
				'label' => esc_attr__('Hide the label ', 'conseil'),
				'element' => 'checkbox',
				'classes'	=> 'pix-dropdown-opt pix-column-opt'
			),
			// 'pix_is_column_padding'		=> array(
			// 		'label' => esc_attr__( 'Use padding style ', 'conseil' ),
			// 		'element' => 'checkbox',
			// 		'classes'	=> 'pix-dropdown-opt pix-column-opt'
			// ),
			'pix_is_column_padding'		=> array(
				'label' => esc_attr__('Use padding style ', 'conseil'),
				'element' => 'select',
				'options' => array(
					'0' => esc_attr__('No', 'conseil'),
					'1' => esc_attr__('Normal', 'conseil'),
					'2' => esc_attr__('Small', 'conseil'),
				),
				'classes'	=> 'pix-dropdown-opt pix-column-opt'
			),
			'pix_columns_number'		=> array(
				'label' => esc_attr__('Width', 'conseil'),
				'element' => 'select',
				'options' => array(
					'2' => esc_attr__('2 Columns (~16% of Mega menu)', 'conseil'),
					'3' => esc_attr__('3 Columns (25% of Mega menu)', 'conseil'),
					'4' => esc_attr__('4 Columns (~33% of Mega menu)', 'conseil'),
					'6' => esc_attr__('6 Columns (50% of Mega menu)', 'conseil'),
					'12' => esc_attr__('12 Columns (100% of Mega menu)', 'conseil'),
				),
				'classes'	=> 'pix-dropdown-opt pix-column-opt'
			),
			'pix_columns_line'		=> array(
				'label' => esc_attr__('Add column line ', 'conseil'),
				'element' => 'select',
				'options' => array(
					'none' => esc_attr__('Disabled', 'conseil'),
					'pix-menu-line-right' => esc_attr__('Right', 'conseil'),
					'pix-menu-line-top' => esc_attr__('Top', 'conseil'),
					'pix-menu-line-right-top' => esc_attr__('Right & Top', 'conseil'),
				),
				'classes'	=> 'pix-dropdown-opt pix-column-opt'
			),
		),
		'pix_box_section'		=> array(
			'pix_is_image_item'		=> array(
				'label' => esc_attr__('Convert to Box item ', 'conseil'),
				'element' => 'checkbox',
				'classes'	=> 'pix-dropdown-opt pix-box-opt'
			),
			'pix_box_title'		=> array(
				'label' => esc_attr__('Title', 'conseil'),
				'element' => 'text',
				'classes'	=> 'pix-dropdown-opt pix-box-opt'
			),
			'pix_box_text'		=> array(
				'label' => esc_attr__('Text', 'conseil'),
				'element' => 'text',
				'classes'	=> 'pix-dropdown-opt pix-box-opt'
			),
			'pix_bg_image'		=> array(
				'label' => esc_attr__('Background image ', 'conseil'),
				'element' => 'media',
				'classes'	=> 'pix-dropdown-opt pix-box-opt upload_image_button'
			),
			'pix_box_style'		=> array(
				'label' => esc_attr__('Box style ', 'conseil'),
				'element' => 'select',
				'options' => array(
					'default' => esc_attr__('Default', 'conseil'),
					'padding' => esc_attr__('With padding', 'conseil'),
					'padding-no-top' => esc_attr__('With padding (No padding top)', 'conseil'),
				),
				'classes'	=> 'pix-dropdown-opt pix-box-opt'
			),
			'pix_is_full_height'		=> array(
				'label' => esc_attr__('Make the box full column height ', 'conseil'),
				'element' => 'checkbox',
				'classes'	=> 'pix-dropdown-opt pix-box-opt'
			),
			'pix_is_box_dark'		=> array(
				'label' => esc_attr__('Use light text colors ', 'conseil'),
				'element' => 'checkbox',
				'classes'	=> 'pix-dropdown-opt pix-box-opt'
			),
		),
		// pix_beta
		// 'pix_menu_advanced' => array(
		// 	'pix_menu_opts'		=> array(
		// 			'label' => esc_attr__( 'Advanced ', 'conseil' ),
		// 			'element' => 'advanced',
		// 			'classes'	=> 'pix-test'
		// 	),
		// ),
	);
	$fields['pix_menu_advanced'] = array(
		'pix_menu_opts'		=> array(
			'label' => esc_attr__('Advanced ', 'conseil'),
			'element' => 'advanced',
			'classes'	=> 'pix-test'
		)
	);
	return $fields;
}


function pix_create_checkbox_field($id, $item, $key, $name, $value, $class, $field) {
	$classes = '';
	if (!empty($field['classes'])) {
		$classes = $field['classes'];
	}
	$classes .= ' ' . $class;
	?>
	<p class="description description-wide <?php echo esc_attr($classes); ?>">
		<label for="<?php esc_attr($id); ?>">
			<?php if ($value == 1) { ?>
				<input type="checkbox" id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($name); ?>" value="1" checked="checked" /><?php echo esc_html($field['label']); ?>
			<?php } else { ?>
				<input type="checkbox" id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($name); ?>" value="1" /><?php echo esc_html($field['label']); ?>
			<?php } ?>
		</label>
	</p>
<?php
}
function pix_create_text_field($id, $item, $key, $name, $value, $class, $field) {
	$classes = '';
	if (!empty($field['classes'])) {
		$classes = $field['classes'];
	}
	$classes .= ' ' . $class;
?>
	<p class="description description-wide <?php echo esc_attr($classes); ?>">
		<label for="<?php echo esc_attr($id); ?>">
			<?php echo esc_html($field['label']); ?>
			<input class="pix-menu-input-field" type="text" id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($value); ?>" />
		</label>
	</p>
<?php
}
function pix_create_media_field($id, $item, $key, $name, $value, $class, $field) {
	$classes = '';
	if (!empty($field['classes'])) {
		$classes = $field['classes'];
	}
	$classes .= ' ' . $class;
?>
	<p class="description description-wide <?php echo esc_attr($classes); ?>">
		<label for="<?php echo esc_attr($id); ?>">
			<?php echo esc_html($field['label']); ?>
			<input class="widefat" id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name); ?>" type="text" value="<?php echo esc_attr($value); ?>" />
			<button class="upload_image_button button button-primary">Upload Image</button>
		</label>
	</p>
<?php
}
function pix_create_select_field($id, $item, $key, $name, $value, $class, $field) {
	$classes = '';
	if (!empty($field['classes'])) {
		$classes = $field['classes'];
	}
	$classes .= ' ' . $class;
?>
	<p class="description description-wide <?php esc_attr($classes); ?>">
		<label for="<?php echo esc_attr($id); ?>">
			<?php echo esc_html($field['label']); ?>
			<select id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name); ?>">
				<?php foreach ($field['options'] as $k => $n) {
					if ($value == $k) { ?>
						<option selected="selected" value="<?php echo esc_attr($k); ?>"><?php echo esc_html($n); ?></option>
					<?php } else { ?>
						<option value="<?php echo esc_attr($k); ?>"><?php echo esc_html($n); ?></option>
				<?php }
				} ?>
			</select>
		</label>
	</p>
<?php
}

function pix_create_advanced_field($id, $item, $key, $name, $value, $class, $field) {
	$classes = '';
	if (!empty($field['classes'])) {
		$classes = $field['classes'];
	}
	$classes .= ' ' . $class;
?>
	<p class="description description-wide <?php echo esc_attr($classes); ?>">
		<label for="<?php echo esc_attr($id); ?>">
			<input class="pix-menu-item-res-data" id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name); ?>" type="hidden" value="<?php echo esc_attr($value); ?>" />
			<?php if(pixCheckIconsAvailable()){
				?>
				<button class="pixfort_menu_item_btn button button-primary"><?php echo esc_html__('Advanced menu item Options', 'conseil'); ?></button>
				<?php
			} 
			?>
		</label>
	</p>
<?php
}

// Setup fields
function pix_megamenu_fields($id, $item, $depth, $args) {
	$sections = fields_list();
	if(function_exists('pix_migrate_box_to_advanced')){
		pix_migrate_box_to_advanced($item);
	}
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
					$id    = sprintf('edit-%s-%s', $key, $item->ID);
					$name  = sprintf('%s[%s]', $key, $item->ID);
					$value = get_post_meta($item->ID, $key, true);
					$class = sprintf('field-%s', $_key);
					$element = $field['element'];

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
add_action('wp_nav_menu_item_custom_fields', 'pix_megamenu_fields', 10, 4);
// Create Columns
function pix_megamenu_columns($columns) {
	$sections = fields_list();
	foreach ($sections as $key => $fields) {
		$columns = array_merge($columns, $fields);
	}
	return $columns;
}
// add_filter( 'manage_nav-menus_columns', 'pix_megamenu_columns', 99 );
// Save fields
function pix_megamenu_save($menu_id, $menu_item_db_id, $menu_item_args) {
	if (defined('DOING_AJAX') && DOING_AJAX) {
		return;
	}
	// check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );
	$sections = fields_list();
	foreach ($sections as $skey => $fields) {
		foreach ($fields as $_key => $label) {
			$key = sprintf('menu-item-%s', $_key);
			// Sanitize.
			if (!empty($_POST[$key][$menu_item_db_id])) {
				// Do some checks here...
				$value = $_POST[$key][$menu_item_db_id];
			} else {
				if (!empty($_REQUEST[$key][$menu_item_db_id])) {
					// Do some checks here...
					$value = $_REQUEST[$key][$menu_item_db_id];
				} else {
					$value = null;
				}
			}

			// Update.
			if (!is_null($value)) {
				update_post_meta($menu_item_db_id, $key, $value);
			} else {
				// update_post_meta( $menu_item_db_id, $key, $value );
				delete_post_meta($menu_item_db_id, $key);
			}
		}
	}
}
add_action('wp_update_nav_menu_item', 'pix_megamenu_save', 10, 3);
function pix_megamenu_filter_walker($walker) {
	$walker = 'MegaMenu_Walker_Edit';
	if (!class_exists($walker)) {
		require_once dirname(__FILE__) . '/walker-nav-menu-edit.php';
	}
	return $walker;
}
add_filter('wp_edit_nav_menu_walker', 'pix_megamenu_filter_walker', 99);
