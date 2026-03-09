<?php
/*
* Get latest version
*/
if ( ! function_exists( 'collectchat_feedback_include_init' ) ) {
	function collectchat_feedback_include_init( $base ) {
		global $collectchat_options, $collectchat_active_plugin;
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		$wp_content_dir = defined( 'WP_CONTENT_DIR' ) ? WP_CONTENT_DIR : ABSPATH . 'wp-content';
		$wp_plugins_dir = defined( 'WP_PLUGIN_DIR' ) ? WP_PLUGIN_DIR : $wp_content_dir . '/plugins';

		$collectchat_dir                    = $wp_plugins_dir . '/' . dirname( $base ) . '/plugin.php';
		$collectchat_active_plugin[ $base ] = get_plugin_data( $wp_plugins_dir . '/' . $base , false, false );

		require_once( dirname( __FILE__ ) . '/feedback-form.php' );

		if ( ! function_exists( 'collectchat_admin_enqueue_scripts' ) ) {
			function collectchat_admin_enqueue_scripts() {
				global $hook_suffix;
				if ( 'plugins.php' === $hook_suffix ) {
					if ( ! defined( 'DOING_AJAX' ) ) {
						wp_enqueue_style( 'collectchat-modal-css', plugin_dir_url(__FILE__) .'css/modal.css' );
						collectchat_add_deactivation_feedback_dialog_box();
					}
				}
			}
		}
		add_action( 'admin_enqueue_scripts', 'collectchat_admin_enqueue_scripts' );
	}
}
