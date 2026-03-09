<?php

namespace ImageOptimization\Modules\Settings\Components;

use ImageOptimization\Modules\Core\Components\Pointers;
use ImageOptimization\Modules\Settings\Module;
use ImageOptimization\Modules\Core\Module as Core_Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Settings_Pointer {
	const CURRENT_POINTER_SLUG = 'image-optimizer-settings';

	public function admin_print_script() {
		if ( Core_Module::is_elementor_one() ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( $this->is_dismissed() ) {
			return;
		}

		wp_enqueue_script( 'wp-pointer' );
		wp_enqueue_style( 'wp-pointer' );

		$pointer_content = '<h3>' . esc_html__( 'Image Optimizer', 'image-optimization' ) . '</h3>';
		$pointer_content .= '<p>' . esc_html__( 'Head over to the Image Optimization Settings to fine-tune how your media uploads are managed.', 'image-optimization' ) . '</p>';

		$pointer_content .= sprintf(
			'<p><a class="button button-primary image-optimization-pointer-settings-link" href="%s">%s</a></p>',
			admin_url( 'admin.php?page=' . Module::SETTING_BASE_SLUG ),
			esc_html__( 'Take me there', 'image-optimization' )
		);
		$allowed_tags = [
			'h3' => [],
			'p' => [],
			'a' => [
				'class' => [],
				'href' => [],
			],
		];
		?>
		<script>
				const onClose = () => {
					return jQuery.ajax( {
						url: ajaxurl,
						method: 'POST',
						data: {
							action: 'image_optimizer_pointer_dismissed',
							data: {
								pointer: '<?php echo esc_attr( static::CURRENT_POINTER_SLUG ); ?>'
							},
							nonce: '<?php echo esc_attr( wp_create_nonce( 'image-optimization-pointer-dismissed' ) ); ?>'
						}
					} );
				}

				jQuery( document ).ready( function( $ ) {

						const target = $('#toplevel_page_elementor-home').hasClass('wp-not-current-submenu') ? $('#toplevel_page_elementor-home') : $( '.image-optimizer-menu' );

						target.pointer( {
							content: '<?php echo wp_kses( $pointer_content, $allowed_tags ); ?>',
							pointerClass: 'image-optimizer-settings-pointer',
							position: {
								edge: 'top',
								align: 'left',
								at: 'left+20 bottom',
								my: 'left top'
							},
							close: onClose
						} ).pointer( 'open' );

					$( '.image-optimization-pointer-settings-link' ).first().on( 'click', function( e ) {
						e.preventDefault();

						$(this).attr( 'disabled', true );

						onClose().promise().done(() => {
							location = $(this).attr( 'href' );
						});
					})
				} );
		</script>
		<style>
			.image-optimizer-settings-pointer .wp-pointer-content h3::before {
				content: '';
				background: transparent;
				border-radius: 0;
				background-image: url('data:image/svg+xml,%3Csvg%20width%3D%2232%22%20height%3D%2232%22%20viewBox%3D%220%200%2032%2032%22%20fill%3D%22none%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Crect%20x%3D%221.375%22%20y%3D%222.625%22%20width%3D%2229.375%22%20height%3D%2229.375%22%20rx%3D%225%22%20fill%3D%22%23FAE4FA%22%2F%3E%3Crect%20x%3D%229.875%22%20y%3D%2213.125%22%20width%3D%2212.5%22%20height%3D%2212.5%22%20rx%3D%222.5%22%20stroke%3D%22%23ED01EE%22%20stroke-width%3D%220.625%22%2F%3E%3Cpath%20d%3D%22M10.5%2025L13.8596%2020.8005C14.0752%2020.531%2014.4685%2020.4873%2014.738%2020.7029L16.887%2022.4221C17.1565%2022.6377%2017.5498%2022.594%2017.7654%2022.3245L22.375%2016.5625%22%20stroke%3D%22%23ED01EE%22%20stroke-width%3D%220.625%22%2F%3E%3Ccircle%20cx%3D%2213%22%20cy%3D%2216.25%22%20r%3D%221.25%22%20stroke%3D%22%23ED01EE%22%20stroke-width%3D%220.5%22%2F%3E%3Crect%20x%3D%2219.5%22%20width%3D%2212.5%22%20height%3D%2212.5%22%20rx%3D%226.25%22%20fill%3D%22%23ED01EE%22%2F%3E%3Ccircle%20cx%3D%2225.75%22%20cy%3D%226.25%22%20r%3D%225.625%22%20fill%3D%22white%22%2F%3E%3Cpath%20d%3D%22M25.75%200.625C22.6439%200.625%2020.125%203.14387%2020.125%206.25C20.125%209.35612%2022.6439%2011.875%2025.75%2011.875C28.8561%2011.875%2031.375%209.35612%2031.375%206.25C31.375%203.14387%2028.8561%200.625%2025.75%200.625ZM24.0625%209.0625H22.9375V3.4375H24.0625V9.0625ZM28.5625%209.0625H25.1875V7.9375H28.5625V9.0625ZM28.5625%206.8125H25.1875V5.6875H28.5625V6.8125ZM28.5625%204.5625H25.1875V3.4375H28.5625V4.5625Z%22%20fill%3D%22%23ED01EE%22%2F%3E%3C%2Fsvg%3E');
			}
		</style>
		<?php
	}

	public function is_dismissed(): bool {
		$meta = (array) get_user_meta( get_current_user_id(), Pointers::DISMISSED_POINTERS_META_KEY, true );

		return key_exists( static::CURRENT_POINTER_SLUG, $meta );
	}

	public function __construct() {
		add_action( 'in_admin_header', [ $this, 'admin_print_script' ] );
	}
}
