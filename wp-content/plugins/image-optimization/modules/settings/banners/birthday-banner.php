<?php

namespace ImageOptimization\Modules\Settings\Banners;

use ImageOptimization\Modules\Core\Components\Pointers;
use Throwable;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Sale_Banner
 */
class Birthday_Banner {
	const BANNER_POINTER_NAME = 'image_optimizer_birthday_2025_banner';
	const POINTER_ACTION = 'image_optimizer_pointer_dismissed';
	const POINTER_NONCE_KEY = 'image-optimization-pointer-dismissed';

	public static function is_sale_time(): bool {
		$sale_start_time = gmmktime( 16, 0, 0, 6, 10, 2025 );
		$sale_end_time = gmmktime( 23, 59, 0, 6, 17, 2025 );

		$now_time = gmdate( 'U' );

		return $now_time >= $sale_start_time && $now_time <= $sale_end_time;
	}

	public static function user_viewed_banner(): bool {
		return Pointers::is_dismissed( self::BANNER_POINTER_NAME );
	}

	/**
	 * Get banner markup
	 * @throws Throwable
	 */
	public static function get_banner( string $link ) {
		if ( ! self::is_sale_time() || self::user_viewed_banner() ) {
			return;
		}
		$img = plugins_url( '/images/birthday-banner-io-2025.png', __FILE__ );
		$url = admin_url( 'admin-ajax.php' );
		$nonce = wp_create_nonce( self::POINTER_NONCE_KEY );

		?>
			<div class="io-birthday-banner">
				<div class="io-birthday-banner-container">
					<img src="<?php echo esc_url( $img ); ?>" alt="Image Optimizer birthday banner image">
					<a href="<?php echo esc_url( $link ); ?>" target="_blank">
						Get Discount
					</a>
				</div>
				<button>
					<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M13.2803 1.28033C13.5732 0.987437 13.5732 0.512563 13.2803 0.21967C12.9874 -0.0732233 12.5126 -0.0732233 12.2197 0.21967L6.75 5.68934L1.28033 0.21967C0.987437 -0.0732233 0.512563 -0.0732233 0.21967 0.21967C-0.0732233 0.512563 -0.0732233 0.987437 0.21967 1.28033L5.68934 6.75L0.21967 12.2197C-0.0732233 12.5126 -0.0732233 12.9874 0.21967 13.2803C0.512563 13.5732 0.987437 13.5732 1.28033 13.2803L6.75 7.81066L12.2197 13.2803C12.5126 13.5732 12.9874 13.5732 13.2803 13.2803C13.5732 12.9874 13.5732 12.5126 13.2803 12.2197L7.81066 6.75L13.2803 1.28033Z" fill="white"/>
					</svg>
				</button>
			</div>
			<style>
				.io-birthday-banner {
					overflow: hidden;
					margin-inline-start: -20px;
					background: #ff7be5;

					display: flex;
					flex-direction: row;
				}

				.rtl .io-birthday-banner {
					flex-direction: row-reverse;
				}
				.io-birthday-banner-container {
					position: relative;
					width: 100%;
					max-width: 1200px;
					margin: 0 auto;
					display: flex;
					justify-content: end;
					align-items: center;
					direction: ltr;
					height: 80px;
				}
				.io-birthday-banner img {
					position: absolute;
					left: 0;
					top: 50%;
					transform: translateY(-50%);
					width: 100%;
				}
				.io-birthday-banner a {
					position: relative;
					display: inline-block;
					padding: 12px 24px;
					font-size: 18px;
					color: #fff;
					background-color: #000;
					text-decoration: none;
					z-index: 2;
				}
				.io-birthday-banner button {
					position: relative;
					border: none;
					background: none;
					padding: 12px;
					margin: 0 24px;
					cursor: pointer;
					z-index: 2;
				}
				@media (max-width: 768px) {
					.io-birthday-banner a {
						padding: 6px 12px;
						font-size: 14px;
					}
					.io-birthday-banner button {
						margin: 0 12px;
					}
				}
			</style>
			<script>
				document.addEventListener('DOMContentLoaded', function () {
					const banner = document.querySelector('.io-birthday-banner');
					const button = document.querySelector('.io-birthday-banner button');

					const requestData = {
						action: "<?php echo esc_js( self::POINTER_ACTION ); ?>",
						nonce: "<?php echo esc_js( $nonce ); ?>",
						data: {
							pointer: "<?php echo esc_js( self::BANNER_POINTER_NAME ); ?>",
						}
					};

					if (button) {
						button.addEventListener('click', function () {
							jQuery.ajax(
								{
									url: '<?php echo esc_js( $url ); ?>',
									method: 'POST',
									data: requestData,
									success: () => banner.remove(),
									error: (error) => console.error('Error:', error),
								}
							);
						});
					}
				});

			</script>
		<?php
	}
}
