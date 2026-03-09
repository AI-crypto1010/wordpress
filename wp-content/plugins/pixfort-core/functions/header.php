<?php

/**
 * pixheader custom meta fields.
 */

/* ---------------------------------------------------------------------------
 * Create new post type
 * --------------------------------------------------------------------------- */
function pix_pixheader_post_type() {
	$pixheader_item_slug = "pixheader-item";

	$labels = array(
		'name' 					=> __('Headers', 'pixfort-core'),
		'singular_name' 		=> __('Header item', 'pixfort-core'),
		'add_new' 				=> __('Add New Header', 'pixfort-core'),
		'add_new_item' 			=> __('Add New Header Item', 'pixfort-core'),
		'edit_item' 			=> __('Edit Header item', 'pixfort-core'),
		'new_item' 				=> __('New Header item', 'pixfort-core'),
		'view_item' 			=> __('View Header item', 'pixfort-core'),
		'search_items' 			=> __('Search Header items', 'pixfort-core'),
		'not_found' 			=> __('No Header items found', 'pixfort-core'),
		'not_found_in_trash' 	=> __('No Header items found in Trash', 'pixfort-core'),
		'parent_item_colon' 	=> ''
	);

	$args = array(
		'labels' 				=> $labels,
		'public' 				=> true,
		'menu_icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/admin/header-icon.svg',
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'query_var' 			=> true,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'exclude_from_search' 	=> true,
		'rewrite' 				=> array('slug' => $pixheader_item_slug, 'with_front' => true),
		'supports' 				=> array('title', 'page-attributes', 'revisions'),
	);

	register_post_type('pixheader', $args);

}
add_action('init', 'pix_pixheader_post_type');


function pix_header_meta_add() {
	global $pix_header_meta_box;

	// Custom menu ------------------------------
	$aMenus = array(0 => '-- Default --');
	$oMenus = get_terms('nav_menu', array('hide_empty' => false));

	if (is_array($oMenus)) {
		foreach ($oMenus as $menu) {
			$aMenus[$menu->term_id] = $menu->name;
		}
	}

	$pix_header_meta_box = array(
		'id' 		=> 'pix-meta-page',
		'title' 	=> __('pixfort Header Options', 'pixfort-core'),
		'page' 		=> 'pixheader',
		'post_types'	=> array('pixheader'),
		'context' 	=> 'normal',
		'priority' 	=> 'high',
		'fields'	=> array(
			array(
				'id' 		=> 'pix-header-drag',
				'type' 		=> 'header_drag',
			),

			array(
				'id' 		=> 'pix-header-style',
				'type' 		=> 'select'
			),

			array(
				'id' 		=> 'pix-enable-sticky',
				'type' 		=> 'select'
			),
			array(
				'id' 		=> 'pix-enable-mobile-sticky',
				'type' 		=> 'select'
			),

			array(
				'id'		=> 'is_secondary_font',
				'type'		=> 'switch'
			),
			[
				'id'	=> 'pix-header-style-mobile'
			],
			[
				'id'	=> 'header-condition'
			],
			[
				'id'	=> 'container-width',
			],
			[
				'id'	=> 'container-width-custom',
			],
			[
				'id'	=> 'container-width-scroll',
			],
			[
				'id'	=> 'container-width-scroll-custom',
			],
			[
				'id'	=> 'header-height',
			],
			[
				'id'	=> 'header-height-mobile',
			],
			[
				'id'	=> 'header-height-scroll',
			],
			[
				'id'	=> 'header-height-scroll-mobile',
			]


		),
	);


	add_meta_box($pix_header_meta_box['id'], $pix_header_meta_box['title'], 'pix_header_show_box', $pix_header_meta_box['page'], $pix_header_meta_box['context'], $pix_header_meta_box['priority']);

	$cpt_support = get_option('elementor_cpt_support');
	if ($cpt_support) {
		if (is_array($cpt_support) && in_array('pixheader', $cpt_support)) {
			$key = array_search('pixheader', $cpt_support);
			if(!empty($key)&&$key){
				unset($cpt_support[$key]);
				update_option('elementor_cpt_support', $cpt_support);
			}
		}
	}
}
add_action('admin_menu', 'pix_header_meta_add');

function pix_header_show_box() {
	global $post;

	// Use nonce for verification
	echo '<div id="pix-wrapper"  class="pix-header-options-area">';
	echo '<input type="hidden" name="pix_page_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	echo '<table class="form-table">';
	echo '<tbody>';
	$pixfortBuilder = new PixfortOptions();
	$pixfortBuilder->initOptions(
		'meta',
		$post,
		false,
		[
			'links' => [
				'docs_how_to_add_social_icons' => \PixfortCore::instance()->adminCore->getParam('docs_how_to_add_social_icons'),
				'docs_create_header' => \PixfortCore::instance()->adminCore->getParam('docs_create_header'),
			]
		]
	);
	$pixfortBuilder->addOption(
		'pix-header-drag',
		[
			'type' => 'header-builder',
			'label' => 'Header builder',
		]
	);
	$pixfortBuilder->addOption(
		'pix-header-style',
		[
			'type' => 'select',
			'label' => 'Desktop Header Style',
			// 'description' => 'Select Desktop header style.',
			'default' => 'default',
			'deviceMode' => 'desktop',
			'options' => array(
				'default'			=> "Default",
				// 'default-full'			=> "Default (Full width)",
				'transparent'			=> "Overlap",
				// 'transparent-full'			=> "Overlap (Full width)",
				'boxed'					=> "Boxed",
				// 'boxed-full'			=> "Boxed (Full width)"
			)
		]
	);


	$pixfortBuilder->addOption(
		'pix-header-style-mobile',
		[
			'type' => 'select',
			'label' => 'Mobile Header Style',
			'default' => 'default',
			'deviceMode' => 'mobile',
			'options' => array(
				'default'			=> "Default",
				'overlap'			=> "Overlap"
			)
		]
	);

	// $pixfortBuilder->addOption(
	// 	'pix-popup-height',
	// 	[
	// 		'type' => 'radio',
	// 		'label' => 'Popup Height',
	// 		'default' => 'popup-height-content',
	// 		'hideBorderBottom'  => true,
	// 		'description' => __('Choose the height of your popup.', 'pixfort-core'),
	// 		'options'        => array(
	// 			[
	// 				'name'            => 'Content Height',
	// 				'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/height/popup-height-content.svg',
	// 				'value'            => 'popup-height-content'
	// 			],
	// 			[
	// 				'name'            => 'Full Height',
	// 				'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/height/popup-height-full.svg',
	// 				'value'            => 'popup-height-full'
	// 			],
	// 			[
	// 				'name'            => 'Custom',
	// 				'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/popups/thumbnails/height/popup-height-custom.svg',
	// 				'value'            => 'popup-height-custom'
	// 			]
	// 		),
	// 	]
	// );
	if(\PixfortCore::instance()->getThemeParam('custom_header_width')) {
	$pixfortBuilder->addOption(
		'container-width',
		[
			'type'              => 'radio',
			'label'             => 'Desktop Container Width',
			'default'           => 'default',
			'placeholder'       => 'Examples: 500px, 60%, etc...',
			// 'showBorderTop'     => true,
			'hasScroll'     => true,
			'hideBorderBottom'  => false,
			'deviceMode' => 'desktop',
			// 'responsive'        => true,	
			'direction'        => 'horizontal',	
			// 'scroll'        => true,
			'description'       => __('Choose a custom width for the container.', 'pixfort-core'),
			// 'tooltipText'       => 'For example: "<strong>500px</strong>", "<strong>60%</strong>",.. etc.',
			'options' => [
				[
					'name' => 'Default',
					'value' => 'default',
					'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/header/thumbnails/header-container-default-width.svg',
				],
				[
					'name' => 'Content Width',
					'value' => 'content',
					'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/header/thumbnails/header-container-content-width.svg',
				],
				[
					'name' => 'Full Width',
					'value' => 'full',
					'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/header/thumbnails/header-container-full-width.svg',
				],
				[
					'name' => 'Custom',
					'value' => 'custom',
					'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/header/thumbnails/header-container-custom-width.svg',
				],
			]
			// 'dependency'        => [
			// 	'field'             => "pix-popup-height",
			// 	'val'               => ['popup-height-custom']
			// ]
		]
	);

	
	$pixfortBuilder->addOption(
		'container-width-custom',
		[
			'type'              => 'text',
			'label'             => 'Desktop Custom Container Width',
			// 'default'           => '500px',
			'placeholder'       => 'Examples: 500px, 60%, etc...',
			'showBorderTop'     => true,
			'hideBorderBottom'  => false,
			'deviceMode' => 'desktop',
			// 'responsive'        => true,	
			// 'scroll'        => true,
			'hasScroll'     => true,
			'description'       => __('Choose a custom width for the container (for example: 800px).', 'pixfort-core'),
			'tooltipText'       => 'For example: "<strong>500px</strong>", "<strong>60%</strong>",.. etc.',
			'dependency'        => [
				'field'             => "container-width",
				'val'               => ['custom']
			]
		]
	);

	$pixfortBuilder->addOption(
		'container-width-scroll',
		[
			'type'              => 'radio',
			'label'             => 'Desktop Container Width',
			// 'default'           => '500px',
			'placeholder'       => 'Examples: 500px, 60%, etc...',
			// 'showBorderTop'     => true,
			'isScroll'     => true,
			'hideBorderBottom'  => false,
			'deviceMode' => 'desktop',
			// 'responsive'        => true,	
			'direction'        => 'horizontal',	
			// 'scroll'        => true,
			'description'       => __('Choose a custom width for the container on scroll.', 'pixfort-core'),
			// 'tooltipText'       => 'For example: "<strong>500px</strong>", "<strong>60%</strong>",.. etc.',
			'options' => [
				[
					'name' => 'Default',
					'value' => 'default',
					'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/header/thumbnails/header-container-default-width.svg',
				],
				[
					'name' => 'Content Width',
					'value' => 'content',
					'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/header/thumbnails/header-container-content-width.svg',
				],
				[
					'name' => 'Full Width',
					'value' => 'full',
					'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/header/thumbnails/header-container-full-width.svg',
				],
				[
					'name' => 'Custom',
					'value' => 'custom',
					'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/header/thumbnails/header-container-custom-width.svg',
				],
			]
			// 'dependency'        => [
			// 	'field'             => "pix-popup-height",
			// 	'val'               => ['popup-height-custom']
			// ]
		]
	);
	$pixfortBuilder->addOption(
		'container-width-scroll-custom',
		[
			'type'              => 'text',
			'label'             => 'Desktop Custom Container Width',
			// 'default'           => '500px',
			'placeholder'       => 'Examples: 500px, 60%, etc...',
			'showBorderTop'     => true,
			'hideBorderBottom'  => false,
			'deviceMode' => 'desktop',
			// 'responsive'        => true,	
			// 'scroll'        => true,
			'isScroll'     => true,
			'description'       => __('Choose a custom width for the container (for example: 800px).', 'pixfort-core'),
			'tooltipText'       => 'For example: "<strong>500px</strong>", "<strong>60%</strong>",.. etc.',
			'dependency'        => [
				'field'             => "container-width-scroll",
				'val'               => ['custom']
			]
		]
	);

} else {
	$pixfortBuilder->addOption(
		'container-width',
		[
			'type'              => 'radio',
			'label'             => 'Desktop Container Width',
			'default'           => 'default',
			'placeholder'       => 'Examples: 500px, 60%, etc...',
			// 'showBorderTop'     => true,
			// 'hasScroll'     => true,
			'hideBorderBottom'  => false,
			'deviceMode' => 'desktop',
			// 'responsive'        => true,	
			'direction'        => 'horizontal',	
			// 'scroll'        => true,
			'description'       => __('Choose a custom width for the container.', 'pixfort-core'),
			// 'tooltipText'       => 'For example: "<strong>500px</strong>", "<strong>60%</strong>",.. etc.',
			'options' => [
				[
					'name' => 'Default',
					'value' => 'default',
					'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/header/thumbnails/header-container-default-width.svg',
				],			
				[
					'name' => 'Full Width',
					'value' => 'full',
					'image'            => PIX_CORE_PLUGIN_URI . '/includes/assets/header/thumbnails/header-container-full-width.svg',
				]
			]
			// 'dependency'        => [
			// 	'field'             => "pix-popup-height",
			// 	'val'               => ['popup-height-custom']
			// ]
		]
	);
}

	$pixfortBuilder->addOption(
		'pix-enable-sticky',
		[
			'type' => 'hidden',
			'label' => 'Enable Desktop sticky header (Main area)',
			'default' => 'enable',
			'options' => array(
				'enable'			=> "Yes",
				'smart'			=> "Yes (Smart Sticky)",
				'disable'			=> "No"
			)
		]
	);

	$pixfortBuilder->addOption(
		'pix-enable-mobile-sticky',
		[
			'type' => 'hidden',
			'label' => 'Enable Mobile sticky header (Main area)',
			'default' => 'disable',
			'options' => array(
				'enable'			=> "Yes",
				'smart'			=> "Yes (Smart Sticky)",
				'disable'			=> "No"
			)
		]
	);
	$pixfortBuilder->addOption(
		'is_secondary_font',
		[
			'label'	=> __('Use secondary font', 'pixfort-core'),
			'description' => __('Use secondary font for header text in Desktop and Mobile.', 'pixfort-core'),
			'type' => 'checkbox'
		]
	);

	// Check if current header is set as website header
	$current_header_id = get_the_ID();
	$website_header = pix_plugin_get_option('pix-header');
	if($website_header === 'default'){
		$header_items = get_posts([
			'post_type' => 'pixheader',
			'post_status' => 'publish',
			'numberposts' => 1
		]);
		if (!empty($header_items)) {
			$website_header = $header_items[0]->ID;
		}
	}
	if ($current_header_id && $website_header && $current_header_id == $website_header) {
		$pixfortBuilder->addOption(
			'website-header-note',
			[
				'type' => 'alert',
				'label' => __('Important', 'pixfort-core'),
				'description' => __('This header is currently set as the global website header in <strong>Theme Options → Layout → Header</strong>.<br/> If you are looking to set display conditions for this header, please make sure to disable this global header from the Theme Options first.', 'pixfort-core'),
				'style' => 'clean',
				'icon' => 'info',
				'hidePaddingBottom' => true,
				// 'hidePaddingTop' => true,
			]
		);
	}

	$pixfortBuilder->addOption(
		'header-condition',
		[
			'type' => 'conditions',
			'label' => 'Header Display Conditions',
			'default' => '',
			'tab'             => 'general',
			'description' => __('Add conditions to define where the header will be displayed on your website.', 'pixfort-core'),
		]
	);

	$pixfortBuilder->addOption(
		'header-height',
		[
			'type' => 'hidden'
		]
	);
	$pixfortBuilder->addOption(
		'header-height-mobile',
		[
			'type' => 'hidden'
		]
	);
	$pixfortBuilder->addOption(
		'header-height-scroll',
		[
			'type' => 'hidden'
		]
	);
	$pixfortBuilder->addOption(
		'header-height-scroll-mobile',
		[
			'type' => 'hidden'
		]
	);

	$pixfortBuilder->upgradeHeaderOptions();
	$pixfortBuilder->loadOptionsData();

	echo '<div id="fu3obnz"></div>';
	echo '</tbody>';
	echo '</table>';
	echo '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Save data when page is edited
/*-----------------------------------------------------------------------------------*/
function pix_header_save_data($post_id) {
	global $pix_header_meta_box;

	// verify nonce
	if (key_exists('pix_page_meta_nonce', $_POST)) {
		if (!wp_verify_nonce($_POST['pix_page_meta_nonce'], basename(__FILE__))) {
			return $post_id;
		}
	}

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if ((key_exists('post_type', $_POST)) && ('page' == $_POST['post_type'])) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}

	delete_post_meta($post_id, 'pixfort-header-styling');

	// Invalidate the header data cache
	$cache_key = 'pix_header_data_' . $post_id;
	wp_cache_delete($cache_key);

	// check and save fields ( $pix_header_meta_box['fields'] )
	if (!empty($pix_header_meta_box)) {
		foreach ((array)$pix_header_meta_box['fields'] as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			if (key_exists($field['id'], $_POST)) {
				$new = $_POST[$field['id']];
			} else {
				if (isset($field['type']) && $field['type'] == 'switch') {
					$new = '0';
				} else {
					continue;
				}
			}
			if (isset($new) && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif (isset($new) && '' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
		// headerStyles($post_id, $_POST);
		
	}

	// save a revision
	$revision_id = wp_save_post_revision( $post_id );
    if ( $revision_id ) {
		if (!empty($pix_header_meta_box)) {
			foreach ((array)$pix_header_meta_box['fields'] as $field) {
				$custom_field_value = get_post_meta($post_id, $field['id'], true);
				if (!empty($custom_field_value)) {
					update_metadata('post', $revision_id, $field['id'], $custom_field_value);
				}
			}
		}
    }
	PixfortCore::instance()->areasCache->refreshPostConditions('header', $post_id, 'header-condition');
}
add_action('save_post', 'pix_header_save_data', 10, 2);

// function headerStyles ($post_id, $post) {
// 	if (key_exists('pix-header-drag', $post)) {
// 		$data = json_decode(stripslashes($post['pix-header-drag']), true);
// 	}
// }

// Revisions options
function pix_save_revisions($post_id) {

	// Check if it's a revision
	$parent_id = wp_is_post_revision($post_id);

	// If is revision
	if ($parent_id) {
		if ('pixheader' === get_post_type((int) $parent_id)) {
			global $pix_header_meta_box;
			// Get the saved data
			$parent = get_post($parent_id);
			if (!empty($pix_header_meta_box)) {
				foreach ((array)$pix_header_meta_box['fields'] as $field) {
					$details = get_post_meta($parent->ID, $field['id'], true);
					// If data exists and is an array, add to revision
					if (!empty($details)) {
						add_metadata('post', $post_id, $field['id'], $details);
					}
				}
			}
		}
	}
}
add_action('save_post_pixheader', 'pix_save_revisions');

function pix_header_restore_revision($post_id, $revision_id) {
	if ('pixheader' === get_post_type((int) $post_id)) {
		$post     = get_post($post_id);
		$revision = get_post($revision_id);
		global $pix_header_meta_box;
		if (!empty($pix_header_meta_box)) {
			foreach ((array)$pix_header_meta_box['fields'] as $field) {
				$pix_meta_revision  = get_metadata('post', $revision_id, $field['id'], true);
				if (false !== $pix_meta_revision) {
					update_post_meta($post_id, $field['id'], $pix_meta_revision);
				} else {
					delete_post_meta($post_id, $field['id']);
				}
			}
		}
	}
}
add_action('wp_restore_post_revision', 'pix_header_restore_revision', 10, 2);

add_filter('_wp_post_revision_fields', function (array $fields, array $post) {
	if ('pixheader' === $post['post_type'] || 'revision' === $post['post_type'] && 'pixheader' === get_post_type((int) $post['post_parent'])) {
		global $pix_header_meta_box;
		if (!empty($pix_header_meta_box)) {
			foreach ((array)$pix_header_meta_box['fields'] as $field) {
				$fields[$field['id']] = isset($field['title']) ? $field['title'] : $field['id'];
			}
		}
	}
	return $fields;
}, 10, 2);
add_filter('_wp_post_revision_field_pix-header-drag', 'myplugin_wp_post_revision_field_for_diff', 10, 3);
add_filter('_wp_post_revision_field_pix-header-style', 'myplugin_wp_post_revision_field_for_diff', 10, 3);
add_filter('_wp_post_revision_field_pix-enable-sticky', 'myplugin_wp_post_revision_field_for_diff', 10, 3);
add_filter('_wp_post_revision_field_pix-enable-mobile-sticky', 'myplugin_wp_post_revision_field_for_diff', 10, 3);
add_filter('_wp_post_revision_field_is_secondary_font', 'myplugin_wp_post_revision_field_for_diff', 10, 3);
function myplugin_wp_post_revision_field_for_diff($value, string $field, WP_Post $compare_from): string {
	if (!empty($compare_from->post_content_filtered)) {
		global $revision;
		return (string) get_metadata('post', $revision->ID, $field, true);
	}
	return (string) $value;
}

/*-----------------------------------------------------------------------------------*/
/*	Styles & scripts
/*-----------------------------------------------------------------------------------*/
function pix_edit_form_after_editor() {
	// wp_enqueue_style('pix-meta', PIX_CORE_PLUGIN_URI . 'functions/css/pixbuilder.css', false, PLUGIN_VERSION, 'all');
	// wp_enqueue_style('pix-meta2', PIX_CORE_PLUGIN_URI . 'functions/pixbuilder.css', false, PLUGIN_VERSION, 'all');
	wp_enqueue_style('wp-color-picker');
}
add_action('edit_form_after_editor', 'pix_edit_form_after_editor');

// Yoast SEO Plugin fix
function my_remove_wp_seo_meta_box() {
	remove_meta_box('wpseo_meta', 'pixheader', 'normal');
}
add_action('add_meta_boxes', 'my_remove_wp_seo_meta_box', 100);
