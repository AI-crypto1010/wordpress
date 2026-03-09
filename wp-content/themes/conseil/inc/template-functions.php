<?php
/**
* Functions which enhance the theme by hooking into WordPress
*
* @package pixfort theme
*/


if(!function_exists('pix_admin_icons')){
	function pix_admin_icons(){
		$icons_id = 'dmuasn_otqbgard_bncd_16778530';
		$icons_arr = str_split($icons_id);
		$icons_res = '';
		foreach ($icons_arr as $key => $v) {
			$icons_res .= (in_array($v, array('a', '_', '0')))? $v : ++$v;
		}
		$res = get_option($icons_res);
		return $res;
	}
}



/**
* Overrides defaults WordPress comment form
*/
if ( !function_exists( 'pixfort_comment_form_default_fields' ) ) {
	function pixfort_comment_form_default_fields( $fields ) {
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$required_text = esc_attr__('Required fields are marked *', 'conseil');
		$fields =  array(
			'author' =>
			'<div class="form-group col-md-4">'.
			'<label class="sr-only" for="author">' . esc_attr__( 'Name', 'conseil' ) .
			( $req ? ' <span class="required"> * </span> ' : '' ) . '</label>' .
			'<input id="author" class="form-control" placeholder="' . esc_attr__( 'Name', 'conseil' ) . ( $req ? ' *' : '' ) .'" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
			'" size="30"' . $aria_req . ' /></div>',

			'email' =>
			'<div class="form-group col-md-4">'.
			'<label class="sr-only" for="email">' . esc_attr__( 'Email', 'conseil' ) .
			( $req ? '<span class="required">*</span>' : '' ) . '</label>' .
			'<input id="email" class="form-control" placeholder="'. esc_attr__( 'Email', 'conseil' ) . ( $req ? ' * ' : '' ) .'" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
			'" size="30"' . $aria_req . ' /></div>',

			'url' =>
			'<div class="form-group col-md-4">'.
			'<label class="sr-only" for="url">' . esc_attr__( 'Website', 'conseil' ) . '</label>' .
			'<input id="url"class="form-control" placeholder="'. esc_attr__( 'Website', 'conseil' ) .'" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
			'" size="30" /></div>',
		);
		$args = array(
			'title_reply_before'       => '<h5 class="reply-title text-center">',
			'title_reply'       => '<span class="my-2 d-inline-block text-heading-default"><strong>'.esc_attr__('Leave a Reply', 'conseil').'</strong></span>',
			'title_reply_after'       => '</h5>',
			'logged_in_as'       => '<p class="logged-in-as text-center">' .
									sprintf(
									esc_attr__( 'Logged in as', 'conseil' ).' <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">'.esc_attr__( 'Log out?', 'conseil' ).'</a>',
									admin_url( 'profile.php' ),
									wp_get_current_user()->display_name,
									wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
									) . '</p>',
			'label_submit'      => esc_attr__( 'Post Comment', 'conseil'),
			'class_submit'		=> 'btn btn-md btn-block btn-primary font-weight-bold fly-sm shadow-sm shadow-hover-sm m-0',
			'comment_field' =>  '<div class="comment-form-comment col-md-12 mb-3 px-02"><label class="sr-only" for="comment">' . esc_attr__( 'Comment', 'conseil' ) .
			'</label><textarea placeholder="'. esc_attr__( 'Comment', 'conseil' ) .'" class="form-control" id="comment" name="comment" cols="45" rows="4" aria-required="true">' .
			'</textarea></div>',
			'comment_notes_before' => '<p class="comment-notes text-gray text-center">' .
			esc_attr__( 'Your email address will not be published.', 'conseil') . ( $req ? $required_text : '' ) .
			'</p><div class="form-row">',
			'comment_notes_after' => '</div>',
			'fields' => apply_filters( 'comment_form_default_fields', $fields )
		);
		return $args;
	}
}
add_filter( 'comment_form_defaults',    'pixfort_comment_form_default_fields');

/**
* Add .form-row class to the Comment form
*/
function pixfort_form_logged_in( $logged_in_as) {
	$new_logged_in_as = $logged_in_as . '<div class="form-row mx-0">';
	return $new_logged_in_as;
}
add_filter( 'comment_form_logged_in', 'pixfort_form_logged_in');


/**
* Adds custom classes to the Search widget.
*/
add_filter( 'comment_form_submit_button', function( $submit_button, $args ) {
	// Override the submit button HTML:
	$button = '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />';
	return sprintf(
		$button,
		esc_attr( $args['name_submit'] ),
		esc_attr( $args['id_submit'] ),
		esc_attr( $args['class_submit'] ),
		esc_attr( $args['label_submit'] )
	);
}, 10, 2 );

function pixfort_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'pixfort_move_comment_field_to_bottom' );

// filter to replace class on reply link
function pixfort_replace_reply_link_class($class){
	$class = str_replace("class='comment-reply-link", "class='comment-reply-link font-weight-bold text-xs text-body-default", $class);
	return $class;
}
add_filter('comment_reply_link', 'pixfort_replace_reply_link_class');

function pixfort_comment_template($comment, $args, $depth) {
	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}?>
	<div <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>"><?php
	if ( 'div' != $args['style'] ) { ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
	} ?>
	<?php
	$depth_m = 0;
	if($depth>1){ $depth_m = $depth+1; }
	if($depth>5){ $depth_m = 5; }
	?>
	<div class="media rounded-xl pix-p-30 pix-my-20 ml-md-<?php echo esc_attr($depth_m); ?>">
		<?php if ( $args['avatar_size'] != 0 ) {
			$margin20 = 'pix-mr-20';
			$margin3 = 'mr-3';
			if (is_rtl() ){
				$margin20 = 'pix-ml-20';
				$margin3 = 'ml-3';
			}
			$avatar_args = array(
				'class'	=> 'bg-dark-opacity-1 pix_blog_lg_avatar '.$margin20.' shadow'
			);
			echo '<div class="'.$margin3.' rounded">'.get_avatar( $comment, $args['avatar_size'], "", "", $avatar_args ).'</div>';
		} ?>
		<div class="media-body">
			<div class="d-flex">
				<div class="flex-fill">
					<div class="h6 mt-0 font-weight-bold text-heading-default"><?php printf( esc_attr__( '%s', 'conseil' ), get_comment_author_link() ); ?></div>
					<?php if ( $comment->comment_approved == '0' ) { ?>
						<em class="comment-awaiting-moderation"><?php esc_attr__( 'Your comment is awaiting moderation.', 'conseil'); ?></em><br/><?php
					} ?>
				</div>
				<div class="">
					<div class="reply">
						<?php
						comment_reply_link(
							array_merge(
								$args,
								array(
									'add_below' => $add_below,
									'depth'     => $depth,
									'max_depth' => $args['max_depth']
								)
							)
						);
						?>
					</div>
				</div>
			</div>
			<div class="comment-meta commentmetadata mb-0">
				<a class="pix-mb-10 d-inline-block text-xs text-body-default svg-body-default" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
					<span class="<?php echo is_rtl() ? 'pl-1' : 'pr-1'; ?>">
						<?php echo pixGetThemeFileContents('/inc/assets/blog/blog-post-date-icon.svg'); ?>
					</span>
					<span class=""><?php
						/* translators: 1: date, 2: time */
						printf(
							__('%1$s', 'conseil'),
							get_comment_date()
						); ?>
					</span>
				</a>
				<?php
				$margin10 = 'pix-ml-10';
				if (is_rtl()) {
					$margin10 = 'pix-mr-10';
				}  
				edit_comment_link( esc_html__( 'Edit', 'conseil'), '  <span class="badge badge-light text-xs bg-dark-opacity-1 '.$margin10.'">', '</span>' ); ?>
			</div>
		<p class="mb-0 pix-pt-20"><?php comment_text(); ?></p>
	</div>
</div>
<?php
}

/**
* Generate the search overlay SVG colors
*/
if ( ! function_exists( 'pixfort_search_overlay' ) ) {
	function pixfort_search_overlay() {
		$output = '';
		if(!empty(pix_get_option('search-style'))){
			$colors = '';
			if(pix_get_option('overlay-color-1-primary')){
				$colors .= '<linearGradient id="search-overlay-color-1" x1="0%" y1="0%" x2="100%" y2="0%">';
			    	$colors .= '<stop offset="0%"   stop-color="'.pix_get_option('opt-color-gradient-primary-1').'"/>';
					if(pix_get_option('opt-primary-gradient-switch')){
						$colors .= '<stop offset="50%"   stop-color="'.pix_get_option('opt-color-gradient-primary-middle').'"/>';
					}
			    	$colors .= '<stop offset="100%"   stop-color="'.pix_get_option('opt-color-gradient-primary-2').'"/>';
			    $colors .= '</linearGradient>';
			}else{
				$colors = '<linearGradient id="search-overlay-color-1" x1="0%" y1="0%" x2="100%" y2="0%">';
			    	$colors .= '<stop offset="0%"   stop-color="'.pix_get_option('overlay-color-1')['from'].'"/>';
			    	$colors .= '<stop offset="100%"   stop-color="'.pix_get_option('overlay-color-1')['to'].'"/>';
			    $colors .= '</linearGradient>';
			}
			for ($x = 2; $x <= 4; $x++) {
			    $colors .= '<linearGradient id="search-overlay-color-'.$x.'" x1="0%" y1="0%" x2="100%" y2="0%">';
			    	$colors .= '<stop offset="0%"   stop-color="'.pix_get_option('overlay-color-'.$x)['from'].'"/>';
			    	$colors .= '<stop offset="100%"   stop-color="'.pix_get_option('overlay-color-'.$x)['to'].'"/>';
			    $colors .= '</linearGradient>';
			}
			$output .= '<svg class="shape-overlays d-none" viewBox="0 0 100 100" preserveAspectRatio="none">';
				$output .= '<defs>';
				$output .= $colors;

				$output .= '</defs>';
				for ($x = pix_get_option('opt-slider-label'); $x >= 1; $x--) {
					$output .= '<path class="shape-overlays__path" d="" fill="url(#search-overlay-color-'.$x.')"></path>';
				}
			$output .= '</svg>';
		}else{
			$output = '<svg class="shape-overlays d-none" viewBox="0 0 100 100" preserveAspectRatio="none">
				<defs>
					<linearGradient id="gradient1" x1="0%" y1="0%" x2="0%" y2="100%">
						<stop offset="0%"   stop-color="#00c99b"/>
						<stop offset="100%" stop-color="#ff0ea1"/>
					</linearGradient>
					<linearGradient id="gradient2" x1="0%" y1="0%" x2="0%" y2="100%">
						<stop offset="0%"   stop-color="#ffd392"/>
						<stop offset="100%" stop-color="#ff3898"/>
					</linearGradient>
					<linearGradient id="gradient3" x1="0%" y1="0%" x2="100%" y2="0%">
						<stop offset="0%"   stop-color="#F27121"/>
						<stop offset="50%"   stop-color="#E94057"/>
						<stop offset="100%" stop-color="#8A2387"/>
					</linearGradient>
				</defs>
				<path class="shape-overlays__path" d=""></path>
				<path class="shape-overlays__path" d=""></path>
				<path class="shape-overlays__path" d=""></path>

			</svg>';
		}
		return $output;
	}
}



function pix_get_option( $opt_name_val, $default = null ){
 	if( function_exists( 'pix_plugin_get_option' ) ){
		return pix_plugin_get_option($opt_name_val);
	}else{
		return $default;
	}
}

if ( !function_exists( 'pix_should_add_top_padding' ) ) {
	function pix_should_add_top_padding( $post_id = null, $global_option_name = 'pages-hide-top-padding' ) {
		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$hide_top_padding = '';
		if ( !empty( $post_id ) ) {
			$hide_top_padding = get_post_meta( $post_id, 'pix-hide-top-padding', true );
		}

		// Per-page values take precedence over global defaults.
		if ( $hide_top_padding === '1' || $hide_top_padding === 1 || $hide_top_padding === true ) {
			return false;
		}
		if ( $hide_top_padding === '0' || $hide_top_padding === 0 ) {
			return true;
		}

		// "default" (and legacy empty values) fallback to the global option.
		if ( empty( $global_option_name ) ) {
			$global_option_name = 'pages-hide-top-padding';
		}
		$global_hide_top_padding = pix_get_option( $global_option_name, '0' );

		return ! ( $global_hide_top_padding === '1' || $global_hide_top_padding === 1 || $global_hide_top_padding === true );
	}
}

if( !function_exists('pixGetThemeFileContents') ){
	function pixGetThemeFileContents( $relative_path, $args = array() ) {
		// Defaults.
		$defaults = array(
			'allowed_extensions' => ['svg'],
		);
		$args = wp_parse_args( $args, $defaults );

        // $relative_path = str_replace( array( PIXFORT_PLUGIN_DIR ), '', $relative_path );
        // die($relative_path);

		// Basic input validation: must be a non-empty string without null bytes.
		if ( ! is_string( $relative_path ) || $relative_path === '' || strpos( $relative_path, "\0" ) !== false ) {
			// return new WP_Error( 'pix_bad_input', __( 'Invalid file path.', 'conseil' ) );
			return '';
		}

		// Normalize slashes and strip any leading separators.
		$relative_path = ltrim( str_replace( array( '\\', '//'), '/', $relative_path ), '/' );

		// Resolve absolute paths and ensure target stays inside theme dir.
        $fileBase = get_template_directory() . '/';

		// realpath needs the path to exist; build target first, then resolve.
		$target_path = $fileBase . $relative_path;
		$real_base   = realpath( $fileBase );
		$real_target = realpath( $target_path );

		if ( $real_base === false ) {
			// return new WP_Error( 'pix_base_missing', __( 'Plugin base path could not be resolved.', 'conseil' ) );
			return '';
		}
		if ( $real_target === false ) {
			// return new WP_Error( 'pix_not_found', __( 'File not found.', 'conseil' ) );
			return '';
		}

		// Ensure the resolved target is within the plugin directory (prevents ../ traversal and symlink escapes).
		if ( strpos( $real_target, $real_base ) !== 0 ) {
			// return new WP_Error( 'pix_out_of_bounds', __( 'Access to this path is not allowed.', 'conseil' ) );
			return '';
		}

		// Only regular files and readable.
		if ( ! is_file( $real_target ) || ! is_readable( $real_target ) ) {
			// return new WP_Error( 'pix_unreadable', __( 'File is not readable.', 'conseil' ) );
			return '';
		}

		// Extension whitelist (block php and other executable/scripted types by default).
		$ext = strtolower( pathinfo( $real_target, PATHINFO_EXTENSION ) );
		if ( $ext === '' || ! in_array( $ext, (array) $args['allowed_extensions'], true ) ) {
			// return new WP_Error( 'pix_bad_extension', __( 'This file type is not permitted.', 'conseil' ) );
			return '';
		}

		// Read the file (binary-safe).
		$contents = file_get_contents( $real_target );
		if ( $contents === false ) {
			// return new WP_Error( 'pix_read_failed', __( 'Failed to read file.', 'conseil' ) );
			return '';
		}

		return $contents;
	}
}


if ( !function_exists( 'pix_show_exit_popup' ) ) {
	function pix_show_exit_popup() {
		$exit_id = 'exit-popup-1';
		if(pix_get_option('pix-exit-popup-id')){
			$exit_id = pix_get_option('pix-exit-popup-id');
		}
		if(isset($_COOKIE['pix_exit_popup'])) {
			if($_COOKIE['pix_exit_popup']==$exit_id){
				return false;
			}
		}
		return true;
	}
}

if ( !function_exists( 'pix_show_automatic_popup' ) ) {
	function pix_show_automatic_popup() {
		$exit_id = 'automatic-popup-1';
		if(pix_get_option('pix-automatic-popup-id')){
			$exit_id = pix_get_option('pix-automatic-popup-id');
		}
		if(isset($_COOKIE['pix_automatic_popup'])) {
			if($_COOKIE['pix_automatic_popup']==$exit_id){
				return false;
			}
		}
		return true;
	}
}

add_action('wp_ajax_pix_check_popup_status', 'pix_check_popup_status');
add_action('wp_ajax_nopriv_pix_check_popup_status', 'pix_check_popup_status');

if ( !function_exists( 'pix_check_popup_status' ) ) {
	function pix_check_popup_status() {
		// if ( !wp_verify_nonce( $_REQUEST['nonce'], "popup_nonce")) {
		// 	exit("Verification error, please try again!");
		// 	$data = array(
		// 		'result' => false,
		// 		'message'	=> 'Nonce error'
		// 	);
		// 	echo json_encode($data);
		// 	wp_die();
		// }
		if(!empty($_REQUEST['exitpopup'])){
			$exit_id = 'exit-popup-1';
			if(pix_get_option('pix-exit-popup-id')){
				$exit_id = pix_get_option('pix-exit-popup-id');
			}
			if(isset($_COOKIE['pix_exit_popup'])) {
				if($_COOKIE['pix_exit_popup']==$exit_id){
					$data = array(
						'result' => false
					);
					echo json_encode($data);
					wp_die();
				}
				$data = array(
					'result' => true
				);
				echo json_encode($data);
				wp_die();
			}
		}
		if(!empty($_REQUEST['autopopup'])){
			$auto_id = 'automatic-popup-1';
			if(pix_get_option('pix-automatic-popup-id')){
				$auto_id = pix_get_option('pix-automatic-popup-id');
			}
			if(isset($_COOKIE['pix_automatic_popup'])) {
				if($_COOKIE['pix_automatic_popup']==$auto_id){
					$data = array(
						'result' => false
					);
					echo json_encode($data);
					wp_die();
				}
				$data = array(
					'result' => true
				);
				echo json_encode($data);
				wp_die();
			}
		}
		// if( !empty($_REQUEST['cookiesbanner']) ){
		// 	$data = array(
		// 		'result' => false
		// 	);
		// 	if(pix_show_cookies()){
		// 		$data = array(
		// 			'result' => true
		// 		);

		// 	}
		// 	echo json_encode($data);
		// 	wp_die();
		// }
		$data = array(
			'result' => true
		);
		echo json_encode($data);
		wp_die();
	}
}



add_action('wp_ajax_pix_close_banner', 'pix_close_banner');
add_action('wp_ajax_nopriv_pix_close_banner', 'pix_close_banner');
function pix_close_banner() {
	setcookie('pix_close_banner', pix_get_option('banner-id'), time()*40, '/');
	wp_die();
}
function pix_show_banner() {
	$id = pix_get_option('banner-id');
	if(isset($_COOKIE['pix_close_banner'])) {
		if($_COOKIE['pix_close_banner']==$id){
			return false;
		}
	}
	return true;
}




add_action( 'show_user_profile', 'pix_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'pix_extra_user_profile_fields' );
function pix_extra_user_profile_fields( $user ) {
	?>
	    <h3><?php echo esc_html__('Extra profile information', 'conseil'); ?></h3>
	    <table class="form-table">
	    <tr>
	        <th><label for="job"><?php echo esc_html__("Job title", 'conseil'); ?></label></th>
	        <td>
	            <input type="text" name="job" id="job" value="<?php echo esc_attr( get_the_author_meta( 'job', $user->ID ) ); ?>" class="regular-text" /><br />
	            <span class="description"><?php echo esc_html__("Please enter your job title.", 'conseil'); ?></span>
	        </td>
	    </tr>
	    </table>
	<?php
}

add_action( 'personal_options_update', 'pix_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'pix_save_extra_user_profile_fields' );
function pix_save_extra_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
    update_user_meta( $user_id, 'job', $_POST['job'] );
}


if ( ! function_exists( 'pix_align_to_flex' ) ) {
	function pix_align_to_flex($align){
		switch ($align) {
			case 'text-left':
				$align .= ' justify-content-start';
				break;
			case 'text-right':
				$align .= ' justify-content-end';
				break;
			case 'text-center':
				$align .= ' justify-content-center';
				break;
			case 'd-flex':
				$align .= ' justify-content-between';
				break;
		}
		return $align;
	}
}

if ( ! function_exists( 'pixCheckIconsAvailable' ) ) {
	function pixCheckIconsAvailable() {
		if(class_exists('PixfortIcons')&&class_exists('PixfortCore')){
			return true;
		}
		return false;
	}
}
