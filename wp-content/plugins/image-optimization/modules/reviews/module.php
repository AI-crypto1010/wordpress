<?php

namespace ImageOptimization\Modules\Reviews;

use ImageOptimization\Classes\Module_Base;
use ImageOptimization\Modules\Settings\Module as SettingsModule;
use ImageOptimization\Classes\Image\Image_Query_Builder;
use ImageOptimization\Plugin;
use Throwable;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Module
 */
class Module extends Module_Base {
	const REVIEW_DATA_OPTION = SettingsModule::SETTING_PREFIX . 'review_data';

	/**
	 * Get module name.
	 * Retrieve the module name.
	 *
	 * @access public
	 * @return string Module name.
	 */
	public function get_name(): string {
		return 'reviews';
	}

	public static function routes_list(): array {
		return [
			'Feedback',
		];
	}

	public function render_app(): void {
		echo '<div id="reviews-app" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;"></div>';
	}

	/**
	 * Enqueue Scripts and Styles
	 */
	public function enqueue_scripts( $hook ): void {

		if ( 'media_page_image-optimization-settings' !== $hook ) {
			return;
		}

		// @var ImageOptimizer/Modules/ConnectManager/Module
		$module = Plugin::instance()->modules_manager->get_modules( 'connect-manager' );

		if ( ! $module->connect_instance->is_connected() ) {
			// Don't show the review popup if the user is not connected.
			return;
		}

		if ( ! $this->maybe_show_review_popup() ) {
			return;
		}

		$asset_file = require IMAGE_OPTIMIZATION_ASSETS_PATH . 'build/reviews.asset.php';

		foreach ( $asset_file['dependencies'] as $style ) {
			wp_enqueue_style( $style );
		}

		wp_enqueue_style(
			'image-optimization-reviews',
			$this->get_css_assets_url( 'style-reviews' ),
			[],
			IMAGE_OPTIMIZATION_VERSION,
		);

		wp_enqueue_script(
			'image-optimization-reviews',
			$this->get_js_assets_url( 'reviews' ),
			array_merge( $asset_file['dependencies'], [ 'wp-util' ] ),
			$asset_file['version'],
			true
		);

		wp_localize_script(
			'image-optimization-reviews',
			'imageOptimizerReviewData',
			[
				'wpRestNonce' => wp_create_nonce( 'wp_rest' ),
				'reviewData' => $this->get_review_data(),
				'isRTL' => is_rtl(),
			]
		);
	}

	public function register_base_data(): void {

		if ( get_option( self::REVIEW_DATA_OPTION ) ) {
			return;
		}

		$data = [
			'dismissals' => 0,
			'hide_for_days' => 0,
			'last_dismiss' => null,
			'rating' => null,
			'feedback' => null,
			'added_on' => gmdate( 'Y-m-d H:i:s' ),
			'submitted' => false,
			'repo_review_clicked' => false,
		];

		update_option( self::REVIEW_DATA_OPTION, $data, false );
	}

	/**
	 * Register settings.
	 *
	 * Register settings for the plugin.
	 *
	 * @return void
	 * @throws Throwable
	 */
	public function register_settings(): void {
		$settings = [
			'review_data' => [
				'type' => 'object',
				'show_in_rest' => [
					'schema' => [
						'type' => 'object',
						'additionalProperties' => true,
					],
				],
			],
		];

		foreach ( $settings as $setting => $args ) {
			if ( ! isset( $args['show_in_rest'] ) ) {
				$args['show_in_rest'] = true;
			}
			register_setting( 'options', SettingsModule::SETTING_PREFIX . $setting, $args );
		}
	}

	public function get_review_data(): array {
		return get_option( self::REVIEW_DATA_OPTION );
	}

	public function get_optimized_images_count() {

		$optimized_image_query = ( new Image_Query_Builder() )
			->return_optimized_images()
			->set_paging_size( 150 )
			->execute();

		if ( ! $optimized_image_query->post_count ) {
			return false;
		}

		if ( $optimized_image_query->post_count >= 100 ) {
			return true;
		}
	}

	public function maybe_show_review_popup() {
		if ( $this->get_optimized_images_count() ) {

			$review_data = $this->get_review_data();

			// Don't show if user has already submitted feedback when rating is less than 4.
			if ( isset( $review_data['rating'] ) && (int) $review_data['rating'] < 4 ) {
				return false;
			}

			// Hide if rating is submitted but repo review is not clicked.
			if ( (int) $review_data['rating'] > 3 && $review_data['repo_review_clicked'] ) {
				return false;
			}

			// Don't show if user has dismissed the popup 3 times.
			if ( 3 === (int) $review_data['dismissals'] ) {
				return false;
			}

			if ( $review_data['hide_for_days'] > 0 && isset( $review_data['hide_for_days'] ) ) {
				$hide_for_days = $review_data['hide_for_days'];
				$last_dismiss = strtotime( $review_data['last_dismiss'] );
				$days_since_dismiss = floor( ( time() - $last_dismiss ) / DAY_IN_SECONDS );

				if ( $days_since_dismiss < $hide_for_days ) {
					return false;
				}
			}

			return true;
		}

		return false;
	}

	/**
	 * Add review link to plugin row meta
	 *
	 * @param array $links
	 * @param string $file
	 * @return array
	 *
	 */
	public function add_plugin_row_meta( $links, $file ) {

		if ( ! defined( 'IMAGE_OPTIMIZATION_PLUGIN_FILE' ) || IMAGE_OPTIMIZATION_PLUGIN_FILE !== $file ) {
			return $links;
		}

		$links[] = '<a class="image-optimization-review"
						href="https://wordpress.org/support/plugin/image-optimization/reviews/#new-post"
						target="_blank" rel="noopener noreferrer"
						title="' . esc_attr__( 'Rate our plugin', 'image-optimization' )
					. '">
							<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
					</a>';

		echo '<style>
				.image-optimization-review{ display: inline-flex;flex-direction: row-reverse;}
				.image-optimization-review span{ color:#888}
				.image-optimization-review span:hover{color:#ffa400}
				.image-optimization-review span:hover~span{color:#ffa400}
			</style>';

		return $links;
	}

	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'admin_init', [ $this, 'register_base_data' ] );
		add_action( 'rest_api_init', [ $this, 'register_settings' ] );
		add_action( 'all_admin_notices', [ $this, 'render_app' ] );
		add_filter( 'plugin_row_meta', array( $this, 'add_plugin_row_meta' ), 10, 2 );

		$this->register_routes();
	}
}
