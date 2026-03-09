<?php

namespace ImageOptimization\Modules\Core\Components;

use ImageOptimization\Classes\Image\Image_Query_Builder;
use ImageOptimization\Classes\Utils;
use ImageOptimization\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Not_Connected {
	const NOT_CONNECTED_NOTICE_SLUG = 'image-optimizer-not-connected';

	public function render_not_connected_notice() {
		if ( Pointers::is_dismissed( self::NOT_CONNECTED_NOTICE_SLUG ) ) {
			return;
		}

		?>
		<div class="notice notice-info notice is-dismissible image-optimizer__notice image-optimizer__notice--pink"
			 data-notice-slug="<?php echo esc_attr( self::NOT_CONNECTED_NOTICE_SLUG ); ?>">
			<div class="image-optimizer__icon-block">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12 0C5.37 0 0 5.37 0 12C0 18.63 5.37 24 12 24C18.63 24 24 18.63 24 12C24 5.37 18.63 0 12 0ZM8.4 18H6V6H8.4V18ZM18 18H10.8V15.6H18V18ZM18 13.2H10.8V10.8H18V13.2ZM18 8.4H10.8V6H18V8.4Z" fill="#ED01EE"/>
				</svg>
			</div>

			<p>
				<b>
					<?php esc_html_e(
						'Image Optimizer is not connected right now. To start optimizing your images, please connect your account.',
						'image-optimization'
					); ?>
				</b>

				<span>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=' . \ImageOptimization\Modules\Settings\Module::SETTING_BASE_SLUG . '&action=connect' ) ); ?>">
						<?php esc_html_e(
							'Connect now',
							'image-optimization'
						); ?>
					</a>
				</span>
			</p>
		</div>

		<script>
			const onNotConnectedNoticeClose = () => {
				const pointer = '<?php echo esc_js( self::NOT_CONNECTED_NOTICE_SLUG ); ?>';

				return wp.ajax.post( 'image_optimizer_pointer_dismissed', {
					data: {
						pointer,
					},
					nonce: '<?php echo esc_js( wp_create_nonce( 'image-optimization-pointer-dismissed' ) ); ?>',
				} );
			}

			jQuery( document ).ready( function( $ ) {
				setTimeout(() => {
					const $closeButton = $( '[data-notice-slug="<?php echo esc_js( self::NOT_CONNECTED_NOTICE_SLUG ); ?>"] .notice-dismiss' )

					$closeButton
						.first()
						.on( 'click', onNotConnectedNoticeClose )

					$( '[data-notice-slug="<?php echo esc_js( self::NOT_CONNECTED_NOTICE_SLUG ); ?>"] a' )
						.first()
						.on( 'click', function ( e ) {
							e.preventDefault();

							onNotConnectedNoticeClose().promise().done(() => {
								window.open( $( this ).attr( 'href' ), '_self' ).focus();

								$closeButton.click();
							});
						})
				}, 0);
			} );
		</script>
		<?php
	}

	public function add_media_menu_badge( $parent_file ) {
		global $menu;

		foreach ( $menu as &$item ) {
			if ( 'upload.php' === $item[2] ) {
				$item[0] .= ' <span class="update-plugins count-1"><span class="plugin-count">1</span></span>';
				break;
			}
		}

		return $parent_file;
	}


	public function __construct() {
		add_action('current_screen', function () {
			if ( ! Utils::user_is_admin() ) {
				return;
			}

			// @var ImageOptimizer/Modules/ConnectManager/Module
			$module = Plugin::instance()->modules_manager->get_modules( 'connect-manager' );

			if ( $module->connect_instance->is_connected() || ! $module->connect_instance->is_valid_home_url() ) {
				return;
			}

			add_filter( 'parent_file', [ $this, 'add_media_menu_badge' ] );

			if (
				Utils::is_media_page() ||
				 Utils::is_plugin_page() ||
				 Utils::is_single_attachment_page() ||
				 Utils::is_media_upload_page() ||
				 Utils::is_wp_dashboard_page() ||
				 Utils::is_wp_updates_page()
			) {
				add_action( 'admin_notices', [ $this, 'render_not_connected_notice' ] );
			}
		});
	}
}
