<?php
namespace ImageOptimization\Modules\Core;

use ImageOptimization\Modules\Optimization\{
	Classes\Validate_Image,
	Rest\Cancel_Bulk_Optimization,
	Rest\Optimize_Bulk,
};
use ImageOptimization\Modules\Settings\Classes\Settings;
use ImageOptimization\Modules\Backups\Rest\{
	Restore_All,
	Remove_Backups,
};
use ImageOptimization\Classes\{
	Async_Operation\Async_Operation,
	Async_Operation\Async_Operation_Queue,
	Async_Operation\Queries\Operation_Query,
	Image\Image_Meta,
	Image\Image_Optimization_Error_Type,
	Image\Image_Status,
	Migration\Migration_Manager,
	Module_Base,
	Utils,
};

use ImageOptimization\Modules\Connect\Module as Connect_Module;
use ImageOptimization\Modules\Connect\Classes\Config;

use ImageOptimization\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Module extends Module_Base {

	const ONE_MISMATCH_URL = '/wp-admin/admin.php?page=elementor-home#/home/url-mismatch';

	public function get_name(): string {
		return 'core';
	}

	public static function component_list(): array {
		return [
			'Pointers',
			'Migrations',
			'Conflicts',
			'User_Feedback',
			'Not_Connected',
			'Not_Connected_Modal',
			'Renewal_Notice',
		];
	}

	private function render_top_bar() {
		?>
		<div id="image-optimization-top-bar"></div>
		<?php
	}

	private function render_app() {
		?>
		<div class="clear"></div>
		<div id="image-optimization-app"></div>
		<?php
	}

	public function maybe_add_quota_reached_notice() {

		// @var ImageOptimizer/Modules/ConnectManager/Module
		$module = Plugin::instance()->modules_manager->get_modules( 'connect-manager' );
		$upgrade_link = Utils::get_upgrade_link( 'https://go.elementor.com/io-quota-upgrade/' );

		if ( ! $module->connect_instance->get_connect_status() || $module->connect_instance->images_left() > 0 ) {
			return;
		}

		?>
		<div class="notice notice-warning notice image-optimizer__notice image-optimizer__notice--warning">
			<p>
				<b>
					<?php esc_html_e(
						'You’ve reached your plan quota.',
						'image-optimization'
					); ?>
				</b>

				<span>
					<?php esc_html_e(
						'You have no images left to optimize in your current plan.',
						'image-optimization'
					); ?>

					<a href="<?php echo esc_url( $upgrade_link ); ?>">
						<?php esc_html_e(
							'Upgrade plan now',
							'image-optimization'
						); ?>
					</a>
				</span>
			</p>
		</div>
		<?php
	}

	public function maybe_add_80_quota_reached_notice() {
		// @var ImageOptimizer/Modules/ConnectManager/Module
		$module = Plugin::instance()->modules_manager->get_modules( 'connect-manager' );

		$connect_status = $module->connect_instance->get_connect_status();

		if ( ! isset( $connect_status->quota ) || ! isset( $connect_status->used_quota ) ) {
			return;
		}

		$usage = $connect_status->used_quota / $connect_status->quota * 100;

		if ( $usage < 80 || 100 === $usage ) {
			return;
		}

		$upgrade_link = Utils::get_upgrade_link( 'https://go.elementor.com/io-quota-upgrade/' );

		?>
		<div class="notice notice-warning notice image-optimizer__notice image-optimizer__notice--warning">
			<p>
				<b>
					<?php esc_html_e(
						'You’ve used 80% of your plan quota.',
						'image-optimization'
					); ?>
				</b>

				<span>
					<?php esc_html_e(
						'Upgrade now to avoid interruptions.',
						'image-optimization'
					); ?>

					<a href="<?php echo esc_url( $upgrade_link ); ?>">
						<?php esc_html_e(
							'Upgrade plan now',
							'image-optimization'
						); ?>
					</a>
				</span>
			</p>
		</div>
		<?php
	}

	public function maybe_add_url_mismatch_notice() {
		// @var ImageOptimizer/Modules/ConnectManager/Module
		$module = Plugin::instance()->modules_manager->get_modules( 'connect-manager' );

		if ( $module->connect_instance->is_valid_home_url() ) {
			return;
		}

		$onclick = self::is_elementor_one() ? 'window.location.href = "' . self::ONE_MISMATCH_URL . '";' : 'document.dispatchEvent( new Event( "image-optimizer/auth/url-mismatch-modal/open" ) );';

		?>
		<div class="notice notice-error notice image-optimizer__notice image-optimizer__notice--error">
			<p>
				<b>
					<?php esc_html_e(
						'Your license key does not match your current domain, causing a mismatch.',
						'image-optimization'
					); ?>
				</b>

				<span>
					<?php esc_html_e(
						'This is most likely due to a change in the domain URL of your site (including HTTP/SSL migration).',
						'image-optimization'
					); ?>

					<button type="button" onclick="<?php echo esc_js( $onclick ); ?>">
						<?php esc_html_e(
							'Fix mismatched URL',
							'image-optimization'
						); ?>
					</button>
				</span>
			</p>
		</div>
		<?php
	}

	public function add_plugin_links( $links, $plugin_file_name ): array {
		if ( ! str_ends_with( $plugin_file_name, '/image-optimization.php' ) ) {
			return (array) $links;
		}

		$custom_links = [
			'settings' => sprintf(
				'<a href="%s">%s</a>',
				admin_url( 'admin.php?page=' . \ImageOptimization\Modules\Settings\Module::SETTING_BASE_SLUG ),
				esc_html__( 'Settings', 'image-optimization' )
			),
		];
		// @var ImageOptimizer/Modules/ConnectManager/Module
		$module = Plugin::instance()->modules_manager->get_modules( 'connect-manager' );

		if ( $module->connect_instance->is_connected() && ! self::is_elementor_one() ) {
			$custom_links['upgrade'] = sprintf(
				'<a href="%s" style="color: #524cff; font-weight: 700;" target="_blank" rel="noopener noreferrer">%s</a>',
				Utils::get_upgrade_link( 'https://go.elementor.com/io-plugins-upgrade/' ),
				esc_html__( 'Upgrade', 'image-optimization' )
			);
		}
		if ( ! $module->connect_instance->is_connected() ) {
			$custom_links['connect'] = sprintf(
				'<a href="%s" style="color: #524cff; font-weight: 700;">%s</a>',
				admin_url( 'admin.php?page=' . \ImageOptimization\Modules\Settings\Module::SETTING_BASE_SLUG ),
				esc_html__( 'Connect', 'image-optimization' )
			);
		}

		return array_merge( $custom_links, $links );
	}

	public function enqueue_global_assets() {
		wp_enqueue_style(
			'image-optimization-admin-fonts',
			'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap',
			[],
			IMAGE_OPTIMIZATION_VERSION
		);

		wp_enqueue_style(
			'image-optimization-core-style-admin',
			$this->get_css_assets_url( 'style-admin', 'assets/build/' ),
			[],
			IMAGE_OPTIMIZATION_VERSION,
		);
	}

	/**
	 * Enqueue styles and scripts
	 */
	private function enqueue_scripts() {
		$asset_file = require IMAGE_OPTIMIZATION_ASSETS_PATH . 'build/admin.asset.php';

		foreach ( $asset_file['dependencies'] as $style ) {
			wp_enqueue_style( $style );
		}

		wp_enqueue_script(
			'image-optimization-admin',
			$this->get_js_assets_url( 'admin' ),
			array_merge( $asset_file['dependencies'], [ 'wp-util' ] ),
			$asset_file['version'],
			true
		);

		wp_localize_script(
			'image-optimization-admin',
			'imageOptimizerAppSettings',
			[
				'siteUrl' => wp_parse_url( get_site_url(), PHP_URL_HOST ),
				'thumbnailSizes' => wp_get_registered_image_subsizes(),
				'isDevelopment' => defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG,
				'isRTL' => is_rtl(),
				'version' => IMAGE_OPTIMIZATION_VERSION,
			]
		);

		/**
		 * @var ImageOptimizer\Modules\ConnectManager\Module $module
		 */
		$module = Plugin::instance()->modules_manager->get_modules( 'connect-manager' );
		$connect_email = $module->connect_instance->get_connect_data()['user']['email'] ?? null;
		$show_reset = ! $module->connect_instance->is_connected()
							&& ( $module->connect_instance->get_client_id() || $module->connect_instance->get_client_secret() );

		wp_localize_script(
			'image-optimization-admin',
			'imageOptimizerUserData',
			[
				'isConnectOnFly' => self::is_connect_on_fly(),
				'isConnected' => $module->connect_instance->is_connected(),
				'isElementorOne' => self::is_elementor_one(),
				'currentPage' => get_current_screen()->base,
				'isActivated' => $module->connect_instance->is_activated(),
				'isUrlMismatch' => ! $module->connect_instance->is_valid_home_url(),
				'planData' => $module->connect_instance->is_activated() ? $module->connect_instance->get_connect_status() : null,
				'licenseKey' => $module->connect_instance->is_activated() ? $module->connect_instance->get_activation_state() : null,
				'imagesLeft' => $module->connect_instance->is_activated() ? $module->connect_instance->images_left() : null,
				'isOwner' => $module->connect_instance->is_connected() ? $module->connect_instance->user_is_subscription_owner() : null,
				'subscriptionEmail' => $connect_email ? $connect_email : null,
				'showResetButton' => $show_reset,
				'maxFileSize' => Validate_Image::get_max_file_size(),
				'helpVideos' => Settings::get( Settings::HELP_VIDEOS ),

				'wpRestNonce' => wp_create_nonce( 'wp_rest' ),
				'disconnect' => wp_create_nonce( 'wp_rest' ),
				'authInitNonce' => wp_create_nonce( $module->connect_instance->connect_init_nonce() ),
				'authDisconnectNonce' => wp_create_nonce( $module->connect_instance->disconnect_nonce() ),
				'authDeactivateNonce' => wp_create_nonce( $module->connect_instance->deactivate_nonce() ),
				'authGetSubscriptionsNonce' => wp_create_nonce( $module->connect_instance->get_subscriptions_nonce() ),
				'authActivateNonce' => wp_create_nonce( $module->connect_instance->activate_nonce() ),
				'versionNonce' => wp_create_nonce( $module->connect_instance->version_nonce() ),
				'removeBackupsNonce' => wp_create_nonce( Remove_Backups::NONCE_NAME ),
				'restoreAllImagesNonce' => wp_create_nonce( Restore_All::NONCE_NAME ),
				'optimizeBulkNonce' => wp_create_nonce( Optimize_Bulk::NONCE_NAME ),
				'cancelBulkOptimizationNonce' => wp_create_nonce( Cancel_Bulk_Optimization::NONCE_NAME ),
			]
		);

		wp_set_script_translations( 'image-optimization-admin', 'image-optimization' );
	}

	private function should_render(): bool {
		return ( Utils::is_media_page() || Utils::is_plugin_page() ) && Utils::user_is_admin();
	}

	private static function is_connect_on_fly(): bool {
		/**
		 * @var ImageOptimizer\Modules\ConnectManager\Module $module
		 */
		$module = Plugin::instance()->modules_manager->get_modules( 'connect-manager' );
		return $module->connect_instance->get_is_connect_on_fly();
	}

	public static function is_elementor_one(): bool {

		if ( ! self::is_connect_on_fly() ) {
			return false;
		}

		$connect = Connect_Module::get_connect();

		if ( ! $connect ) {
			return false;
		}

		return Connect_Module::get_connect()->get_config( 'app_type' ) !== Config::APP_TYPE;
	}

	public static function on_deactivation(): void {
		$optimization_query = ( new Operation_Query() )
			->set_queue( Async_Operation_Queue::OPTIMIZE )
			->set_status( [ Async_Operation::OPERATION_STATUS_PENDING, Async_Operation::OPERATION_STATUS_RUNNING ] )
			->set_limit( -1 );

		$restoring_query = ( new Operation_Query() )
			->set_queue( Async_Operation_Queue::RESTORE )
			->set_status( [ Async_Operation::OPERATION_STATUS_PENDING, Async_Operation::OPERATION_STATUS_RUNNING ] )
			->set_limit( -1 );

		$optimization_operations = Async_Operation::get( $optimization_query );
		$restoring_operations = Async_Operation::get( $restoring_query );

		foreach ( $optimization_operations as $operation ) {
			$image_id = $operation->get_args()['attachment_id'];

			if ( ! $image_id ) {
				continue;
			}

			Async_Operation::remove( [ $operation->get_id() ] );

			$image_meta = new Image_Meta( $image_id );

			if ( empty( $image_meta->get_optimized_sizes() ) ) {
				$image_meta->delete();
			} else {
				$image_meta
					->set_status( Image_Status::OPTIMIZATION_FAILED )
					->set_error_type( Image_Optimization_Error_Type::PLUGIN_DEACTIVATION )
					->save();
			}
		}

		foreach ( $restoring_operations as $operation ) {
			$image_id = $operation->get_args()['attachment_id'];

			if ( ! $image_id ) {
				continue;
			}

			Async_Operation::remove( [ $operation->get_id() ] );

			$image_meta = new Image_Meta( $image_id );

			$image_meta
				->set_status( Image_Status::RESTORING_FAILED )
				->set_error_type( Image_Optimization_Error_Type::PLUGIN_DEACTIVATION )
				->save();
		}
	}

	/**
	 * Renders the Bulk Optimization link on the media pages.
	 *
	 * @return void
	 */
	public function add_bulk_optimization_links(): void {
		$page_url = add_query_arg(
			[
				'page' => 'image-optimization-settings',
				'tab' => 'image-optimization-bulk-optimization',
			],
			admin_url( 'admin.php' )
		);

		?>
		<script>
			document.addEventListener( 'DOMContentLoaded', function () {
				// Grid media is rendered by JS, so the timeout is required
				setTimeout( () => {
					const targetButton = document.querySelector( '.filter-items .actions input[type=submit]' ) ||
						document.querySelector( '.media-toolbar-secondary .select-mode-toggle-button' );

					if ( targetButton ) {
						const link = document.createElement('a');

						link.href = '<?php echo esc_js( $page_url ); ?>';
						link.innerText = '<?php echo esc_js( __( 'Bulk Optimization', 'image-optimization' ) ); ?>';
						link.className = 'button is-primary image-optimizer__button image-optimizer__button--pink';

						targetButton.insertAdjacentElement( 'afterend', link );
					}
				}, 100 )
			} );
		</script>
		<?php
	}

	/**
	 * Module constructor.
	 */
	public function __construct() {
		$this->register_components();

		add_action( 'action_scheduler_init', [ Migration_Manager::class, 'init' ] );

		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_global_assets' ] );
		add_filter( 'plugin_action_links', [ $this, 'add_plugin_links' ], 10, 2 );

		add_action('current_screen', function () {
			if ( ! $this->should_render() ) {
				return;
			}

			if ( ! self::is_elementor_one() ) {
				add_action( 'admin_notices', [ $this, 'maybe_add_quota_reached_notice' ] );
				add_action( 'admin_notices', [ $this, 'maybe_add_80_quota_reached_notice' ] );
			}

			add_action( 'admin_notices', [ $this, 'maybe_add_url_mismatch_notice' ] );

			if ( Utils::is_media_page() ) {

				add_action('all_admin_notices', function () {
					$this->render_app();
				});
			}

			if ( Utils::is_plugin_page() ) {
				add_action('in_admin_header', function () {
					$this->render_top_bar();
				});
			}

			add_action('admin_enqueue_scripts', function () {
				$this->enqueue_scripts();
			});

			if ( Utils::is_media_page() ) {
				add_action( 'admin_enqueue_scripts', [ $this, 'add_bulk_optimization_links' ] );
			}
		});
	}
}
