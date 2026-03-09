<?php

namespace ImageOptimization\Modules\Core\Components;

use ImageOptimization\Classes\Image\Image_Query_Builder;
use ImageOptimization\Classes\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class User_Feedback {
	public const NOTICE_FEEDBACK_LINK = 'https://go.elementor.com/io-wp-dash-notice-review';
	public const FOOTER_FEEDBACK_LINK = 'https://go.elementor.com/io-wp-dash-footer-review';
	private const FIRST_IMAGE_OPTIMIZED_FEEDBACK_SLUG = 'image-optimizer-first-image-optimized-feedback';
	private const THIRD_OF_IMAGES_OPTIMIZED_FEEDBACK_SLUG = 'image-optimizer-third-images-optimized-feedback';

	/**
	 * Checks if the notice after the first optimization should be rendered.
	 *
	 * @param bool $check_location
	 *
	 * @return bool
	 */
	public function should_render_first_optimized_notice( bool $check_location = true ): bool {
		if ( Pointers::is_dismissed( self::FIRST_IMAGE_OPTIMIZED_FEEDBACK_SLUG ) ) {
			return false;
		}

		$is_wrong_page = ( ! Utils::is_media_page() && ! Utils::is_plugin_page() && ! Utils::is_single_attachment_page() ) ||
										 Utils::is_plugin_settings_page();

		if ( $check_location && $is_wrong_page ) {
			return false;
		}

		$optimized_image_query = ( new Image_Query_Builder() )
			->return_optimized_images()
			->set_paging_size( 1 )
			->execute();

		if ( ! $optimized_image_query->post_count ) {
			return false;
		}

		return true;
	}

	/**
	 * Checks if the notice should be rendered after the one third of images were optimized.
	 *
	 * @param bool $check_location
	 *
	 * @return bool
	 */
	public function should_render_third_optimized_notice( bool $check_location = true ): bool {
		if ( Pointers::is_dismissed( self::THIRD_OF_IMAGES_OPTIMIZED_FEEDBACK_SLUG ) ) {
			return false;
		}

		if ( $check_location && ! Utils::is_plugin_settings_page() ) {
			return false;
		}

		$images_query = ( new Image_Query_Builder() )
			->execute();

		$optimized_images_query = ( new Image_Query_Builder() )
			->return_optimized_images()
			->execute();

		if ( ! $optimized_images_query->post_count ) {
			return false;
		}

		$optimized_percentage = round( $optimized_images_query->post_count / $images_query->post_count * 100 );

		if ( $optimized_percentage < 33.33 ) {
			return false;
		}

		return true;
	}

	/**
	 * Renders the notice after the first optimization.
	 *
	 * @return void
	 */
	public function render_first_optimized_notice() {
		?>
		<div class="notice is-dismissible notice-success notice image-optimizer__notice image-optimizer__notice--success image-optimizer__notice--feedback"
				 data-notice-slug="<?php echo esc_attr( self::FIRST_IMAGE_OPTIMIZED_FEEDBACK_SLUG ); ?>">
			<p>
				<b>
					<?php esc_html_e(
						'Your image has been optimized!',
						'image-optimization'
					); ?>
				</b>

				<span>
					<?php echo wp_kses_post( sprintf(
						__(
							'If you enjoyed using Image Optimizer, consider leaving a <a href="%1$s" aria-label="%2$s" target="_blank"
				rel="noopener noreferrer">★★★★★</a> review to spread the word.',
							'image-optimization'
						),
						esc_url( self::NOTICE_FEEDBACK_LINK ),
						esc_attr__( 'Five stars', 'image-optimization' )
					) ); ?>
				</span>
			</p>
		</div>

		<script>
			const onClose = () => {
				const pointer = '<?php
					echo $this->should_render_third_optimized_notice( false ) ?
						esc_js( join( ',', [ static::FIRST_IMAGE_OPTIMIZED_FEEDBACK_SLUG, static::THIRD_OF_IMAGES_OPTIMIZED_FEEDBACK_SLUG ] ) ) :
						esc_js( static::FIRST_IMAGE_OPTIMIZED_FEEDBACK_SLUG )
				?>';

				return wp.ajax.post( 'image_optimizer_pointer_dismissed', {
					data: {
						pointer,
					},
					nonce: '<?php echo esc_js( wp_create_nonce( 'image-optimization-pointer-dismissed' ) ); ?>',
				} );
			}

			jQuery( document ).ready( function( $ ) {
				setTimeout(() => {
					const $closeButton = $( '[data-notice-slug="<?php echo esc_js( self::FIRST_IMAGE_OPTIMIZED_FEEDBACK_SLUG ); ?>"] .notice-dismiss' )

					$closeButton
						.first()
						.on( 'click', onClose )

					$( '[data-notice-slug="<?php echo esc_js( self::FIRST_IMAGE_OPTIMIZED_FEEDBACK_SLUG ); ?>"] a' )
						.first()
						.on( 'click', function ( e ) {
							e.preventDefault();

							onClose().promise().done(() => {
								window.open( $( this ).attr( 'href' ), '_blank' ).focus();

								$closeButton.click();
							});
						})
				}, 0);
			} );
		</script>
		<?php
	}

	/**
	 * Renders the notice after the one third of images were optimized.
	 *
	 * @return void
	 */
	public function render_third_optimized_notice() {
		?>
		<div class="notice is-dismissible notice-success notice image-optimizer__notice image-optimizer__notice--success image-optimizer__notice--feedback"
				 data-notice-slug="<?php echo esc_attr( self::THIRD_OF_IMAGES_OPTIMIZED_FEEDBACK_SLUG ); ?>">
			<p>
				<b>
					<?php esc_html_e(
						'Thanks for using Image Optimizer!',
						'image-optimization'
					); ?>
				</b>

				<span>
					<?php echo wp_kses_post( sprintf(
						__(
							'If you\'ve enjoyed it, consider leaving a <a href="%1$s" aria-label="%2$s" target="_blank"
				rel="noopener noreferrer">★★★★★</a> review to spread the word.',
							'image-optimization'
						),
						esc_url( self::NOTICE_FEEDBACK_LINK ),
						esc_attr__( 'Five stars', 'image-optimization' )
					) ); ?>
				</span>
			</p>
		</div>

		<script>
			const onClose = () => {
				const pointer = '<?php
					echo $this->should_render_first_optimized_notice( false ) ?
						esc_js( join( ',', [ static::FIRST_IMAGE_OPTIMIZED_FEEDBACK_SLUG, static::THIRD_OF_IMAGES_OPTIMIZED_FEEDBACK_SLUG ] ) ) :
						esc_js( static::THIRD_OF_IMAGES_OPTIMIZED_FEEDBACK_SLUG )
				?>';

				return wp.ajax.post( 'image_optimizer_pointer_dismissed', {
					data: {
						pointer,
					},
					nonce: '<?php echo esc_js( wp_create_nonce( 'image-optimization-pointer-dismissed' ) ); ?>',
				} );
			}

			jQuery( document ).ready( function( $ ) {
				setTimeout(() => {
					const $closeButton = $( '[data-notice-slug="<?php echo esc_js( self::THIRD_OF_IMAGES_OPTIMIZED_FEEDBACK_SLUG ); ?>"] .notice-dismiss' );

					$closeButton
						.first()
						.on( 'click', onClose)

					$( '[data-notice-slug="<?php echo esc_js( self::THIRD_OF_IMAGES_OPTIMIZED_FEEDBACK_SLUG ); ?>"] a' )
						.first()
						.on( 'click', function ( e ) {
							e.preventDefault();

							onClose().promise().done(() => {
								window.open( $( this ).attr( 'href' ), '_blank' ).focus();

								$closeButton.click();
							});
						})
				}, 0);
			} );
		</script>
		<?php
	}

	/**
	 * Renders the admin footer feedback notice.
	 *
	 * @return void
	 */
	public function add_leave_feedback_footer_text(): void {
		echo wp_kses_post( sprintf(
			__( '<b>Found Image Optimizer helpful?</b> Leave us a <a href="%1$s" aria-label="%2$s" target="_blank"
				rel="noopener noreferrer">★★★★★</a> rating!',
				'image-optimization'
			),
			esc_url( self::FOOTER_FEEDBACK_LINK ),
			esc_attr__( 'Five stars', 'image-optimization' )
		) );
	}

	public function __construct() {
		add_action('current_screen', function () {
			if ( ! Utils::user_is_admin() ) {
				return;
			}

			if ( $this->should_render_first_optimized_notice() ) {
				add_action( 'admin_notices', [ $this, 'render_first_optimized_notice' ] );
			}

			if ( $this->should_render_third_optimized_notice() ) {
				add_action( 'admin_notices', [ $this, 'render_third_optimized_notice' ] );
			}

			if ( Utils::is_media_page() || Utils::is_plugin_page() || Utils::is_single_attachment_page() ) {
				add_filter( 'admin_footer_text', [ $this, 'add_leave_feedback_footer_text' ] );
			}
		});
	}
}
