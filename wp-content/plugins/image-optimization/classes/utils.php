<?php

namespace ImageOptimization\Classes;

use ImageOptimization\Classes\Client\Client;
use ImageOptimization\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Utils {
	/**
	 * get_elementor
	 * @param $instance
	 *
	 * @return \Elementor\Plugin|false|mixed|null
	 */
	public static function get_elementor( $instance = false ) {
		static $_instance = null;
		if ( false !== $instance ) {
			$_instance = $instance;

			return $instance;
		}
		if ( null !== $_instance ) {
			return $_instance;
		}
		if ( class_exists( 'Elementor\Plugin' ) ) {
			return \Elementor\Plugin::instance(); // @codeCoverageIgnore
		}

		return false;
	}

	public static function get_api_client(): ?Client {
		return Client::get_instance();
	}

	public static function get_module( $module_name = '' ) {
		return Plugin::instance()->modules_manager->get_modules( $module_name );
	}

	public static function get_module_component( $module_name, $component ) {
		$module = self::get_module( $module_name );
		if ( $module ) {
			return $module->get_component( $component );
		}
		return null;
	}

	/**
	 * is_elementor_installed
	 * @return bool
	 */
	public static function is_elementor_installed(): bool {
		$plugins = get_plugins();
		return isset( $plugins['elementor/elementor.php'] );
	}

	/**
	 * is_elementor_installed_and_active
	 * should be used only after `plugins_loaded` action
	 * @return bool
	 */
	public static function is_elementor_installed_and_active(): bool {
		return did_action( 'elementor/loaded' );
	}

	public static function is_media_page(): bool {
		$current_screen = get_current_screen();

		if ( ! $current_screen ) {
			return false;
		}

		return 'upload' === $current_screen->id && 'attachment' === $current_screen->post_type;
	}

	public static function is_media_upload_page(): bool {
		$current_screen = get_current_screen();

		if ( ! $current_screen ) {
			return false;
		}

		return 'media' === $current_screen->id && 'add' === $current_screen->action;
	}

	public static function is_single_attachment_page(): bool {
		$current_screen = get_current_screen();

		if ( ! $current_screen ) {
			return false;
		}

		return 'attachment' === $current_screen->id && 'post' === $current_screen->base;
	}

	public static function is_plugin_page(): bool {
		$current_screen = get_current_screen();

		return str_contains( $current_screen->id, 'image-optimization-' );
	}

	public static function is_plugin_settings_page(): bool {
		$current_screen = get_current_screen();

		return str_contains( $current_screen->id, 'image-optimization-settings' );
	}

	public static function is_bulk_optimization_page(): bool {
		$current_screen = get_current_screen();

		return str_contains( $current_screen->id, 'image-optimization-bulk-optimization' );
	}

	public static function user_is_admin(): bool {
		return current_user_can( 'manage_options' );
	}

	public static function is_wp_dashboard_page(): bool {
		$current_screen = get_current_screen();

		return str_contains( $current_screen->id, 'dashboard' );
	}

	public static function is_wp_updates_page(): bool {
		$current_screen = get_current_screen();

		return str_contains( $current_screen->id, 'update' );
	}

	public static function get_upgrade_link( $link ): string {
		$subscription_id = get_option( 'image_optimizer_subscription_id' );

		if ( ! $subscription_id ) {
			return $link;
		}

		return add_query_arg( 'subscription_id', $subscription_id, $link );
	}
}
