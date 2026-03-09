<?php
/**
 * Post custom meta fields.
 */

function pix_post_meta_add(){

	global $pix_post_meta_box_3;

	// $header_posts = get_posts([
	// 	'post_type' => 'pixheader',
	// 	'post_status' => array('publish', 'private'),
	// 	'numberposts' => -1
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
	// ]);

	// $footers = array();
	// $footers['default'] = "Theme Default";
	// $footers['disable'] = "Disabled";
	// foreach ($footer_posts as $key => $value) {
	// 	$footers[$value->ID] = $value->post_title;
	// }

	$pix_post_meta_box_3 = array(
		'id' 			=> 'pix-meta-options',
		'title' 		=> __('pixfort Post Options','pixfort-core'),
		'page' 			=> 'post',
		'post_types'	=> array('post'),
		'context' 		=> 'normal',
		'priority' 		=> 'default',
		'fields'		=> array(
			array(
				'id'		=> 'pix-post-video',
				// 'type'		=> 'textarea',
				// 'title'		=> __('Post video', 'pixfort-core'),
				// 'desc'	=> __('Input the embed video if the post format is "Video", leave empty to use the first video in the page.', 'pixfort-core'),
			),
			array(
				'id'		=> 'pix-post-audio',
				// 'type'		=> 'textarea',
				// 'title'		=> __('Post audio', 'pixfort-core'),
				// 'desc'	=> __('Input the embed audio if the post format is "Audio", leave empty to use the first audio in the page.', 'pixfort-core'),
			),
			array(
				'id'		=> 'pix-post-link',
				// 'type'		=> 'text',
				// 'title'		=> __('Post link', 'pixfort-core'),
				// 'desc'	=> __('Input the link if the post format is "Link".', 'pixfort-core'),
			),
			array(
				'id'		=> 'pix-post-quote',
				// 'type'		=> 'textarea',
				// 'title'		=> __('Post Quote', 'pixfort-core'),
				// 'desc'	=> __('Input the quote if the post format is "Quote".', 'pixfort-core'),
			),
			array(
				'id'		=> 'pix-post-quote-citation',
				// 'type'		=> 'text',
				// 'title'		=> __('Post quote citation', 'pixfort-core'),
				// 'desc'	=> __('Input the citation of the quote.', 'pixfort-core'),
			),
			array(
				'id' 		=> 'pix-page-header',
				// 'type' 		=> 'select',
				// 'default' => 'default',
				// 'title' 	=> __('Custom Header', 'pixfort-core'),
				// 'options' 	=> $headers,
			),
			array(
				'id' 		=> 'pix-page-footer',
				// 'type' 		=> 'select',
				// 'title' 	=> __('Custom Footer', 'pixfort-core'),
				// 'options' 	=> $footers,
			),
			array(
				'id'		=> 'pix-custom-intro-bg',
				'type'		=> 'media',
				'title'		=> __('Page intro background image', 'pixfort-core'),
				'sub_desc'	=> __('Select an image to override the default intro background image.', 'pixfort-core'),
			),
		),
	);
	add_meta_box($pix_post_meta_box_3['id'], $pix_post_meta_box_3['title'], 'pix_post_show_box', $pix_post_meta_box_3['page'], $pix_post_meta_box_3['context'], $pix_post_meta_box_3['priority']);
}

 add_action('admin_menu', 'pix_post_meta_add');


 function pix_post_show_box() {
	global $pix_post_meta_box_3, $post;

	

	// Use nonce for verification
	echo '<div id="pix-wrapper" class="pix-header-options-area">';
		echo '<input type="hidden" name="pix_post_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		echo '<table class="form-table" style="margin-bottom:110px;">';
			echo '<tbody>';
	
			$pixfortBuilder = new PixfortOptions();
			$pixfortBuilder->initOptions(
				'meta',
				$post
			);

				$pixfortBuilder->addOption(
					'pix-post-video',
					[
						'type' => 'textarea',
						'label' => 'Post Video',
						'default' => '',
						'description' => __('Input the embed video if the post format is "Video", leave empty to use the first video in the page.', 'pixfort-core'),
					]
				);
				$pixfortBuilder->addOption(
					'pix-post-audio',
					[
						'type' => 'textarea',
						'label' => 'Post Audio',
						'description' => __('Input the embed audio if the post format is "Audio", leave empty to use the first audio in the page.', 'pixfort-core'),
						'default' => ''
					]
				);
				$pixfortBuilder->addOption(
					'pix-post-link',
					[
						'type' => 'text',
						'label' => 'Post link',
						'default' => '',
						'description' => __('Input the link if the post format is "Link".', 'pixfort-core'),
					]
				);
				
				$pixfortBuilder->addOption(
					'pix-post-quote',
					[
						'type' => 'textarea',
						'label' => 'Post Quote',
						'description' => __('Input the citation of the quote.', 'pixfort-core'),
						'default' => ''
					]
				);
				$pixfortBuilder->addOption(
					'pix-post-quote-citation',
					[
						'type' => 'text',
						'label' => 'Post quote citation',
						'default' => '',
						'description' => __('Input the citation of the quote.', 'pixfort-core'),
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
				$pixfortBuilder->addOption(
					'pix-custom-intro-bg',
					[
						'type' => 'image',
						'label' => 'Page intro background image',
						'default' => '',
						'local' => true,
						'description' => __('Select an image to override the default intro background image.', 'pixfort-core'),
					]
				);

			$pixfortBuilder->loadOptionsData();
			echo '<div id="fu3obnz"></div>';

			echo '</tbody>';
		echo '</table>';

	echo '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Save data when post is edited
/*-----------------------------------------------------------------------------------*/
function pix_post_save_data($post_id) {
	global $pix_post_meta_box_3;

	// verify nonce
	if( key_exists( 'pix_post_meta_nonce',$_POST ) ) {
		if ( ! wp_verify_nonce( $_POST['pix_post_meta_nonce'], basename(__FILE__) ) ) {
			return $post_id;
		}
	}

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if ( (key_exists('post_type', $_POST)) && ('page' == $_POST['post_type']) ) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}




	if(!empty($pix_post_meta_box_3)){
		foreach ( (array)$pix_post_meta_box_3['fields'] as $field ) {
			$old = get_post_meta($post_id, $field['id'], true);
			if( key_exists($field['id'], $_POST) ) {
				$new = $_POST[$field['id']];
			} else {
				$new = ""; // problem with "quick edit"
				//continue;
			}

			if($field['id'] === 'pix-custom-intro-bg'){
				$new = stripslashes($new);
				$new = json_decode($new);
			}

			if( isset($new) && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			}elseif('' == $new && $old) {
			    delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}
}
add_action('save_post', 'pix_post_save_data');







/*-----------------------------------------------------------------------------------*/
/*	Styles & scripts
/*-----------------------------------------------------------------------------------*/
function pix_post_admin_styles() {
	if (defined('WPB_VC_VERSION')) {
		wp_enqueue_style( 'pix-meta', PIX_CORE_PLUGIN_URI. 'functions/css/pixbuilder.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		wp_enqueue_style( 'pix-meta2', PIX_CORE_PLUGIN_URI. 'functions/pixbuilder.css', false, PIXFORT_PLUGIN_VERSION, 'all');
	}
}
add_action('admin_print_styles', 'pix_post_admin_styles');

function pix_post_admin_scripts() {
	// wp_enqueue_script( 'pix-admin-piximations', PIX_CORE_PLUGIN_URI . 'functions/js/piximations.js');
	// wp_enqueue_script( 'pix-admin-custom', PIX_CORE_PLUGIN_URI . 'functions/js/custom.js', array('jquery'));
	// wp_localize_script( 'pix-admin-custom', 'plugin_object', array(
	//     'PIX_CORE_PLUGIN_URI' => PIX_CORE_PLUGIN_URI,
	// ));
}
add_action('admin_print_scripts', 'pix_post_admin_scripts');
