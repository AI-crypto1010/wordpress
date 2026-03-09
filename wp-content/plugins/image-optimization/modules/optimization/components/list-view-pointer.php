<?php

namespace ImageOptimization\Modules\Optimization\Components;

use ImageOptimization\Modules\Core\Components\Pointers;
use ImageOptimization\Modules\Core\Module as Core_Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class List_View_Pointer {
	const CURRENT_POINTER_SLUG = 'image-optimizer-list-view';

	public function admin_print_script() {
		if ( Core_Module::is_elementor_one() ) {
			return;
		}

		if ( $this->is_dismissed() ) {
			return;
		}

		wp_enqueue_script( 'wp-pointer' );
		wp_enqueue_style( 'wp-pointer' );

		$pointer_content = '<h3>' . esc_html__( 'Switch to list view', 'image-optimization' ) . '</h3>';
		$pointer_content .= '<p>' . esc_html__( 'Get the most out of your optimizing options. Use the List view to quickly optimize your uploaded images with Image Optimizer.', 'image-optimization' ) . '</p>';

		$allowed_tags = [
			'h3' => [],
			'p' => [],
		];
		?>
		<script>
			jQuery( document ).ready( function( $ ) {
				setTimeout(() => {
					$( '#wp-media-grid div.media-toolbar.wp-filter' ).first().pointer( {
						content: '<?php echo wp_kses( $pointer_content, $allowed_tags ); ?>',
						pointerClass: 'image-optimization-list-view-pointer',
						position: {
							edge: 'top',
							align: '<?php echo is_rtl() ? 'right' : 'left'; ?>',
						},
						close() {
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
					} ).pointer( 'open' );
				}, 0)
			} );
		</script>

		<style>
			.image-optimization-list-view-pointer .wp-pointer-arrow {
				inset-inline-start: 15px;
			}
		</style>
		<?php
	}

	private function is_dismissed(): bool {
		$meta = (array) get_user_meta( get_current_user_id(), Pointers::DISMISSED_POINTERS_META_KEY, true );

		return key_exists( static::CURRENT_POINTER_SLUG, $meta );
	}

	public function __construct() {
		add_action( 'in_admin_header', [ $this, 'admin_print_script' ] );
	}
}
