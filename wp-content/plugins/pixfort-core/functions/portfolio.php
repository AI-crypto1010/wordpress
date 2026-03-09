<?php

/**
 * Portfolio custom meta fields.
 */

/* ---------------------------------------------------------------------------
 * Create new post type
 * --------------------------------------------------------------------------- */
function pix_portfolio_post_type() {
	$portfolio_item_slug = "portfolio-item";
	if (function_exists('pix_plugin_get_option')) {
		if (!empty(pix_plugin_get_option('portfolio-slug'))) {
			$portfolio_item_slug = pix_plugin_get_option('portfolio-slug');
		}
	}
	$labels = array(
		'name' 					=> __('Portfolio', 'pixfort-core'),
		'singular_name' 		=> __('Portfolio item', 'pixfort-core'),
		'add_new' 				=> __('Add New', 'pixfort-core'),
		'add_new_item' 			=> __('Add New Portfolio item', 'pixfort-core'),
		'edit_item' 			=> __('Edit Portfolio item', 'pixfort-core'),
		'new_item' 				=> __('New Portfolio item', 'pixfort-core'),
		'view_item' 			=> __('View Portfolio item', 'pixfort-core'),
		'search_items' 			=> __('Search Portfolio items', 'pixfort-core'),
		'not_found' 			=> __('No portfolio items found', 'pixfort-core'),
		'not_found_in_trash' 	=> __('No portfolio items found in Trash', 'pixfort-core'),
		'parent_item_colon' 	=> ''
	);

	$args = array(
		'labels' 				=> $labels,
		'menu_icon'				=> 'dashicons-images-alt2',
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'can_export' 				=> true,
		'has_archive' 			=> true,
		'query_var' 			=> true,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'show_in_menu' 			=> true,
		'show_in_rest' 			=> true,
		'rewrite' 				=> array('slug' => $portfolio_item_slug, 'with_front' => true),
		'supports' 				=> array('title', 'editor', 'author', 'excerpt', 'thumbnail', 'revisions', 'page-attributes'),
	);

	register_post_type('portfolio', $args);

	register_taxonomy('portfolio-types', 'portfolio', array(
		'hierarchical' 			=> true,
		'label' 				=>  __('Portfolio categories', 'pixfort-core'),
		'singular_label' 		=>  __('Portfolio category', 'pixfort-core'),
		'rewrite'				=> true,
		// 'rewrite' => array('slug' => 'projects', 'with_front' => true),
		// 'rewrite' => array('slug' => ''),
		'query_var' 			=> true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest' => true,
	));
}
add_action('init', 'pix_portfolio_post_type');


/* ---------------------------------------------------------------------------
 * Edit columns
 * --------------------------------------------------------------------------- */
function pix_portfolio_edit_columns($columns) {
	$newcolumns = array(
		"cb" 					=> "<input type=\"checkbox\" />",
		"portfolio_thumbnail" 	=> __('Thumbnail', 'pixfort-core'),
		"title" 				=> 'Title',
		"portfolio_types" 		=> __('Categories', 'pixfort-core'),
		"portfolio_order" 		=> __('Order', 'pixfort-core'),
	);
	$columns = array_merge($newcolumns, $columns);

	return $columns;
}
add_filter("manage_edit-portfolio_columns", "pix_portfolio_edit_columns");


/* ---------------------------------------------------------------------------
 * Custom columns
 * --------------------------------------------------------------------------- */
function pix_portfolio_custom_columns($column) {
	global $post;
	switch ($column) {
		case "portfolio_thumbnail":
			if (has_post_thumbnail()) {
				the_post_thumbnail('thumbnail');
			}
			break;
		case "portfolio_types":
			echo get_the_term_list($post->ID, 'portfolio-types', '', ', ', '');
			break;
		case "portfolio_order":
			echo $post->menu_order;
			break;
	}
}
add_action("manage_posts_custom_column",  "pix_portfolio_custom_columns");

function pix_portfolio_meta_add() {
	global $pix_page_meta_box;


	// Layouts ----------------------------------
	$layouts = array(
		0 => '-- Theme Options --',
		'default'        => 'Default',
		'sidebar'        => 'With Sidebar',
		'sidebar-full'        => 'With Sidebar (Full width)',
		'box'        => 'Intro box'
	);

	// Custom menu ------------------------------
	$aMenus = array(0 => '-- Default --');
	$oMenus = get_terms('nav_menu', array('hide_empty' => false));

	if (is_array($oMenus)) {
		foreach ($oMenus as $menu) {
			$aMenus[$menu->term_id] = $menu->name;
		}
	}


	// $header_posts = get_posts([
	// 	'post_type' => 'pixheader',
	// 	'post_status' => array('publish', 'private'),
	// 	'numberposts' => -1
	// 	// 'order'    => 'ASC'
	// ]);

	// $headers = array();

	// $headers[''] = "Theme Default";
	// $headers['disable'] = "Disable";
	// foreach ($header_posts as $key => $value) {
	// 	$headers[$value->ID] = $value->post_title;
	// }

	// $footer_posts = get_posts([
	// 	'post_type' => 'pixfooter',
	// 	'post_status' => array('publish', 'private'),
	// 	'numberposts' => -1
	// 	// 'order'    => 'ASC'
	// ]);

	// $footers = array();
	// $footers['default'] = "Theme Default";
	// $footers['disable'] = "Disabled";
	// foreach ($footer_posts as $key => $value) {
	// 	$footers[$value->ID] = $value->post_title;
	// }

	$pix_page_meta_box = array(
		'id' 		=> 'pix-meta-options',
		'title' 	=> __('pixfort Portfolio Options', 'pixfort-core'),
		'page' 		=> 'portfolio',
		'post_types'	=> array('portfolio'),
		'context' 	=> 'normal',
		'priority' 	=> 'high',
		'fields'	=> array(
			array(
				'id'               => 'portfolio-text',
				'type'             => 'tinymce',
				'title'            => __('Portfolio Text', 'redux-framework-demo'),
				'default'          => 'Theme by pixfort.',
				'rows'          => 12,
			),
			array(
				'id'		=> 'pix-post-hide-content',
				'type'		=> 'switch',
				'title'		=> __('Hide The Content', 'pixfort-core'),
				'sub_desc'	=> __('Hide the content of Portfolio Text.', 'pixfort-core'),
				'desc'		=> __('<strong>Turn it ON if you build content using Content Builder</strong>. Use the Content item if you want to display the Content from editor within the Content Builder.', 'pixfort-core'),
				'options'	=> array('1' => 'On', '0' => 'Off'),
				'std'		=> '0'
			),
			array(
				'id'		=> 'pix-custom-intro-bg',
				'type'		=> 'media',
				'title'		=> __('Page intro background image', 'pixfort-core'),
				'sub_desc'	=> __('Select an image to override the default intro background image.', 'pixfort-core'),
			),
			array(
				'id'		=> 'pix-highlights',
				'type'		=> 'multifields',
				'title'		=> __('Highlights', 'pixfort-core'),
			),
			array(
				'id' 		=> 'pix-post-custom-layout',
				'type' 		=> 'select',
				'title' 	=> __('Custom Layout', 'pixfort-core'),
				'desc' 		=> __('Custom Layout overwrites Theme Options', 'pixfort-core'),
				'options' 	=> $layouts,
			),
			array(
				'id'		=> 'pix-hide-top-padding',
				'type'		=> 'select',
				'title'		=> __('Hide Top Padding', 'pixfort-core'),
				'sub_desc'	=> __('Hide the padding before page content (under the header).', 'pixfort-core'),
				'options'	=> array('1' => 'Yes', '0' => 'No'),
				'std'		=> '0'
			),
			array(
				'id' 		=> 'pix-page-header',
				// 'type' 		=> 'select',
				// 'title' 	=> __('Custom Header', 'pixfort-core'),
				// 'options' 	=> $headers,
			),
			array(
				'id' 		=> 'pix-page-footer',
				// 'type' 		=> 'select',
				// 'default' => 'default',
				// 'title' 	=> __('Custom Footer', 'pixfort-core'),
				// 'options' 	=> $footers,
			),
		),
	);

	add_meta_box($pix_page_meta_box['id'], $pix_page_meta_box['title'], 'pix_portfolio_show_box', $pix_page_meta_box['page'], $pix_page_meta_box['context'], $pix_page_meta_box['priority']);
}
add_action('admin_menu', 'pix_portfolio_meta_add');



function pix_portfolio_show_box() {
	global $post;
	// Layouts ----------------------------------
	$layouts = array(
		0 => '-- Theme Options --',
		'default'        => 'Default',
		'sidebar'        => 'With Sidebar',
		'sidebar-full'        => 'With Sidebar (Full width)',
		'box'        => 'Intro box'
	);

	// Custom menu ------------------------------
	$aMenus = array(0 => '-- Default --');
	$oMenus = get_terms('nav_menu', array('hide_empty' => false));

	if (is_array($oMenus)) {
		foreach ($oMenus as $menu) {
			$aMenus[$menu->term_id] = $menu->name;
		}
	}


	$header_posts = get_posts([
		'post_type' => 'pixheader',
		'post_status' => array('publish', 'private'),
		'numberposts' => -1
		// 'order'    => 'ASC'
	]);

	$headers = array();

	$headers['default'] = "Theme Default";
	$headers['disable'] = "Disable";
	foreach ($header_posts as $key => $value) {
		$headers[$value->ID] = $value->post_title;
	}

	$footer_posts = get_posts([
		'post_type' => 'pixfooter',
		'post_status' => array('publish', 'private'),
		'numberposts' => -1
		// 'order'    => 'ASC'
	]);

	$footers = array();
	$footers['default'] = "Theme Default";
	$footers['disable'] = "Disabled";
	foreach ($footer_posts as $key => $value) {
		$footers[$value->ID] = $value->post_title;
	}
	// Use nonce for verification
	echo '<div id="pix-wrapper" class="pix-header-options-area">';
	echo '<input type="hidden" name="pix_page_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';



	echo '<table class="form-table" style="margin-bottom:110px;">';
	echo '<tbody>';
	$pixfortBuilder = new PixfortOptions();
	$pixfortBuilder->initOptions(
		'meta',
		$post
	);


	$pixfortBuilder->addOption(
		'portfolio-text',
		[
			'type' 			=> 'tinymce',
			'label' 		=> 'Portfolio Text',
			'default' 		=> '',
		]
	);
	$pixfortBuilder->addOption(
		'pix-post-hide-content',
		[
			'type' 			=> 'checkbox',
			'label' 		=> 'Hide The Content',
			'default' 		=> '0',
			'options'		=> array('1' => 'On', '0' => 'Off'),
			'description'		=> __('Turn it ON if you build content using Content Builder. Use the Content item if you want to display the Content from editor within the Content Builder.', 'pixfort-core'),
		]
	);
	$pixfortBuilder->addOption(
		'pix-custom-intro-bg',
		[
			'type' 			=> 'image',
			'label' 		=> 'Page intro background image',
			'default' 		=> '',
			'local' 		=> true,
			'description' 	=> __('Select an image to override the default intro background image.', 'pixfort-core'),
		]
	);
	$pixfortBuilder->addOption(
		'pix-highlights',
		[
			'type' 			=> 'multifields',
			'label' 		=> 'Highlights',
			'default' 		=> ''
		]
	);
	$pixfortBuilder->addOption(
		'pix-post-custom-layout',
		[
			'type' => 'select',
			'label' => 'Custom Layout',
			'default' => '',
			'options' => $layouts,
			'description' 	=> __('Custom Layout overwrites Theme Options', 'pixfort-core'),
		]
	);
	$pixfortBuilder->addOption(
		'pix-hide-top-padding',
		[
			'type' 			=> 'select',
			'label' 		=> 'Hide Top Padding',
			'default' 		=> '0',
			'options'		=> array('1' => 'Yes', '0' => 'No'),
			'description' 	=> __('Hide the padding before page content (under the header).', 'pixfort-core'),
		]
	);

	$displayLegacyHeaderSelector = false;
	$headerValue = get_post_meta($post->ID, 'pix-page-header', true);
	if(!empty($headerValue) && $headerValue !== 'default' && $headerValue !== 'disable' && $headerValue !== 'disable'){	
		if(ctype_digit($headerValue)){
			$displayLegacyHeaderSelector = true;
		}
	}
	if($displayLegacyHeaderSelector) {
		$headers = [];
		$header_posts = get_posts([
			'post_type' => 'pixheader',
			'post_status' => array('publish', 'private'),
			'numberposts' => -1
		]);
		$headers['default'] = "Theme Default";
		$headers['disable'] = "Disable";
		foreach ($header_posts as $key => $value) {
			$headers[$value->ID] = $value->post_title;
		}
		$pixfortBuilder->addOption(
			'pix-page-header',
			[
				'type' => 'select',
				'label' => 'Custom Header',
				'default' 		=> 'default',
				'options' => $headers
			]
		);
	} else {
		$pixfortBuilder->addOption(
			'pix-page-header',
			[
				'type' => 'select',
				'label' => 'Page Header',
				'default' => 'default',
				'description' => 'You can set custom headers with specific display conditions from each header settings.',
				'tooltipText' => 'Global Site Header can be set from Theme Options → Layout → Header.</br>You can set custom headers with specific display conditions from each header settings.',
				'options' => [
					'default' => "Default",
					'disable' => "Disable"
				]
			]
		);
	}

	$displayLegacyFooterSelector = false;
	$footerValue = get_post_meta($post->ID, 'pix-page-footer', true);
	if(!empty($footerValue) && $footerValue !== 'default' && $footerValue !== 'disable' && $footerValue !== 'disable'){	
		if(ctype_digit($footerValue)){
			$displayLegacyFooterSelector = true;
		}
	}
	if($displayLegacyFooterSelector) {
		$footer_posts = get_posts([
			'post_type' => 'pixfooter',
			'post_status' => array('publish', 'private'),
			'numberposts' => -1
		]);
	
		$footers = [];
		$footers['default'] = "Theme Default";
		$footers['disable'] = "Disabled";
		
		foreach ($footer_posts as $key => $value) {
			$footers[$value->ID] = $value->post_title;
		}
		$pixfortBuilder->addOption(
			'pix-page-footer',
			[
				'type' => 'select',
				'label' => 'Custom Footer',
				'default' => 'default',
				'options' => $footers
			]
		);
	} else {
		$pixfortBuilder->addOption(
			'pix-page-footer',
			[
				'type' => 'select',
				'label' => 'Page Footer',
				'default' => 'default',
				'description' => 'You can set custom footers with specific display conditions from each footer settings.',
				'tooltipText' => 'Global Site Footer can be set from Theme Options → Layout → Footer.</br>You can set custom footers with specific display conditions from each footer settings.',
				'options' => [
					'default' => "Default",
					'disable' => "Disable"
				]
			]
		);
	}


	$pixfortBuilder->loadOptionsData();

	echo '<div id="fu3obnz"></div>';

	echo '</tbody>';
	echo '</table>';

	echo '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Save data when page is edited
/*-----------------------------------------------------------------------------------*/
function pix_portfolio_save_data($post_id) {
	global $pix_page_meta_box;

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

	// check and save fields ( $pix_page_meta_box['fields'] )
	if (!empty($pix_page_meta_box)) {
		foreach ((array)$pix_page_meta_box['fields'] as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			if (key_exists($field['id'], $_POST)) {
				$new = $_POST[$field['id']];
			} else {
				// $new = ""; // problem with "quick edit"
				if (!empty($field['type']) && $field['type'] == 'switch') {
					delete_post_meta($post_id, $field['id'], $old);
				} else {
					continue;
				}
				continue;
			}

			if($field['id'] === 'pix-custom-intro-bg'){
				$new = stripslashes($new);
				$new = json_decode($new);
			}
			
			if (isset($new) && $new !== $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}
}
add_action('save_post_portfolio', 'pix_portfolio_save_data');


/*-----------------------------------------------------------------------------------*/
/*	Styles & scripts
/*-----------------------------------------------------------------------------------*/
function pix_portfolio_admin_styles() {
	if (defined('WPB_VC_VERSION')) {
		wp_enqueue_style('pix-meta', PIX_CORE_PLUGIN_URI . '/functions/css/pixbuilder.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		wp_enqueue_style('pix-meta2', PIX_CORE_PLUGIN_URI . '/functions/pixbuilder.css', false, PIXFORT_PLUGIN_VERSION, 'all');
	}
}
add_action('admin_print_styles', 'pix_portfolio_admin_styles');
