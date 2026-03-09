<?php

namespace ImageOptimization\Modules\Settings;

use ImageOptimization\Classes\Image\Image_Conversion_Option;
use ImageOptimization\Classes\Module_Base;
use ImageOptimization\Modules\Settings\{
	Banners\One_Million_Installs_Banner,
	Banners\Sale_Banner,
	Banners\Birthday_Banner,
	Classes\Settings,
};
use ImageOptimization\Modules\Stats\Classes\Optimization_Stats;
use ImageOptimization\Classes\Client\Client;
use ImageOptimization\Modules\ConnectManager\Components\Connect as Connect_Manager_Connect;
use ImageOptimization\Modules\Connect\Classes\Config;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Module extends Module_Base {
	const SETTING_PREFIX = 'image_optimizer_';
	const SETTING_GROUP = 'image_optimizer_settings';
	const SETTING_BASE_SLUG = 'image-optimization-settings';
	const SETTING_CAPABILITY = 'manage_options';

	public function get_name(): string {
		return 'settings';
	}

	public static function component_list(): array {
		return [
			'Settings_Pointer',
		];
	}

	public static function get_options(): array {
		return [
			'compression_level' => [ 'default' => 'lossy' ],
			'optimize_on_upload' => [
				'type' => 'boolean',
				'default' => true,
			],
			'resize_larger_images' => [
				'type' => 'boolean',
				'default' => true,
			],
			'resize_larger_images_size' => [
				'type' => 'integer',
				'default' => 1920,
			],
			'exif_metadata' => [
				'type' => 'boolean',
				'default' => true,
			],
			'original_images' => [
				'type' => 'boolean',
				'default' => true,
			],
			'convert_to_format' => [
				'type' => 'string',
				'default' => Image_Conversion_Option::WEBP,
			],
			'custom_sizes' => [
				'type' => 'string',
				'default' => 'all',
			],
			'help_videos' => [
				'type' => 'object',
				'show_in_rest' => [
					'schema' => [
						'type' => 'object',
						'additionalProperties' => true,
					],
				],
			],
		];
	}

	public function register_options() {
		$options = $this->get_options();

		foreach ( $options as $key => &$args ) {
			$args['type'] = $args['type'] ?? 'string';
			$args['show_in_rest'] = $args['show_in_rest'] ?? true;
			$args['default'] = $args['default'] ?? '';

			register_setting(
				self::SETTING_GROUP,
				self::SETTING_PREFIX . $key,
				$args
			);

			// Set defaults
			add_option( self::SETTING_PREFIX . $key, $args['default'] );
		}
	}

	public function render_app() {
		?>
		<?php Sale_Banner::get_banner( 'https://go.elementor.com/IO-BF-sale' ); ?>
		<?php One_Million_Installs_Banner::get_banner( 'https://go.elementor.com/io-1m-banner-upgrade/' ); ?>
		<?php Birthday_Banner::get_banner( 'https://go.elementor.com/io-b-day-banner' ); ?>

		<!-- The hack required to wrap WP notifications -->
		<div class="wrap">
			<h1 style="display: none;" role="presentation"></h1>
		</div>

		<div id="image-optimization-app"></div>
		<?php
	}

	public function register_page() {
		add_submenu_page(
			'elementor-home',
			__( 'Image Optimization', 'image-optimization' ),
			__( 'Image Optimization', 'image-optimization' ),
			self::SETTING_CAPABILITY,
			self::SETTING_BASE_SLUG,
			[ $this, 'render_app' ],
			50
		);

		$this->add_menu_item_class( 'elementor-home', self::SETTING_BASE_SLUG, 'image-optimizer-menu' );
	}

	private function add_menu_item_class( string $parent_slug, string $menu_slug, string $class ) {
		global $submenu;

		if ( ! isset( $submenu[ $parent_slug ] ) ) {
			return;
		}

		foreach ( $submenu[ $parent_slug ] as &$item ) {
			if ( $item[2] === $menu_slug ) {
				$item[4] = isset( $item[4] ) ? $item[4] . ' ' . $class : $class;
				break;
			}
		}
	}

	/**
	 * The handler converts an old CONVERT_TO_WEBP option to the new CONVERT_TO_FORMAT option.
	 * TODO: [Stability] Remove this fallback after all users updated
	 *
	 * @return void
	 */
	public function maybe_migrate_legacy_conversion_option() {
		$legacy_convert_to_webp = get_option( Settings::CONVERT_TO_WEBP_OPTION_NAME, null );

		if ( is_null( $legacy_convert_to_webp ) ) {
			return;
		}

		if ( '1' === $legacy_convert_to_webp ) {
			update_option( Settings::CONVERT_TO_FORMAT_OPTION_NAME, Image_Conversion_Option::WEBP, false );
		}

		if ( '0' === $legacy_convert_to_webp ) {
			update_option( Settings::CONVERT_TO_FORMAT_OPTION_NAME, Image_Conversion_Option::ORIGINAL, false );
		}

		delete_option( Settings::CONVERT_TO_WEBP_OPTION_NAME );
	}

	/**
	 * The handler triggers stats recalculation on custom sizes update.
	 *
	 * @param $result
	 * @param $name
	 *
	 * @return void
	 */
	public function recalculate_stats_on_custom_sizes_update( $result, $name ) {
		if ( Settings::CUSTOM_SIZES_OPTION_NAME === $name ) {
			Optimization_Stats::get_image_stats( null, true );
		}
	}

	public function cleanup_data() {
		delete_transient( Client::SITE_INFO_TRANSIENT );
		delete_transient( Connect_Manager_Connect::STATUS_CHECK_TRANSIENT );
	}

	/**
	 * Register or update site data for One connect
	 * @throws Exception
	 */
	public function on_migration_run() {
		$old_options = [
			'image_optimizer_client_id',
			'image_optimizer_client_secret',
			'image_optimizer_home_url',
			'image_optimizer_access_token',
			'image_optimizer_token_id',
			'image_optimizer_refresh_token',
			'image_optimizer_user_access_token',
			'image_optimizer_owner_user_id',
			'image_optimizer_subscription_id',
			Settings::SUBSCRIPTION_ID,
		];

		$this->cleanup_data();

		foreach ( $old_options as $option ) {
			delete_option( $option );
		}
	}

	public function __construct() {
		$this->register_components();

		add_action( 'admin_init', [ $this, 'register_options' ] );
		add_action( 'rest_api_init', [ $this, 'register_options' ] );
		add_action( 'admin_init', [ $this, 'maybe_migrate_legacy_conversion_option' ] );
		add_action( 'admin_menu', [ $this, 'register_page' ], 99 );
		add_action( 'rest_pre_update_setting', [ $this, 'recalculate_stats_on_custom_sizes_update' ], 10, 2 );

		add_action( 'elementor_one/' . Config::APP_PREFIX . '_connected', [ $this, 'cleanup_data' ] );
		add_action( 'elementor_one/' . Config::APP_PREFIX . '_disconnected', [ $this, 'cleanup_data' ] );
		add_action( 'elementor_one/' . Config::APP_PREFIX . '_migration_run', [ $this, 'on_migration_run' ] );

		// Add action on switch domain for update access token
		add_action( 'elementor_one/' . Config::APP_PREFIX . '_switched_domain', function( $facade ) {
			$facade->service()->renew_access_token();
		} );
		add_action( 'elementor_one/switched_domain', function( $facade ) {
			$facade->service()->renew_access_token();
		} );
	}
}
