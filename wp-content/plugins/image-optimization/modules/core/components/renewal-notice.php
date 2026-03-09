<?php

namespace ImageOptimization\Modules\Core\Components;

use DateTime;
use ImageOptimization\Classes\Client\Client;
use ImageOptimization\Classes\Utils;
use ImageOptimization\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Renewal_Notice {
	const RENEWAL_NOTICE_SLUG = 'image-optimizer-renewal-notice';

	public ?int $days_diff = null;

	public function date_diff_from_current( $date ) {
		$current_date = new DateTime(); // Current date
		$given_date = new DateTime( $date );

		$interval = $current_date->diff( $given_date );

		$this->days_diff = $interval->invert ? -$interval->days : $interval->days;

		return $this->days_diff;
	}

	public function get_renewal_text(): array {
		if ( $this->days_diff <= 30 && $this->days_diff > 0 ) {
			return [
				'title' => esc_html__( 'Image Optimizer Expires Soon!', 'image-optimization' ),
				'description' => esc_html__( 'Renew your subscription to maintain optimized images, faster website load times, and high performance.', 'image-optimization' ),
				'btn' => esc_html__( 'Turn Auto Renew On', 'image-optimization' ),
				'link' => esc_url( 'https://go.elementor.com/io-renew-30/' ),
			];
		}
		if ( $this->days_diff <= 0 && $this->days_diff > -7 ) {
			return [
				'title' => esc_html__( 'Image Optimizer Has Expired!', 'image-optimization' ),
				'description' => esc_html__( 'Renew your license today to continue enjoying premium image optimization and fast load times.', 'image-optimization' ),
				'btn' => esc_html__( 'Renew Now', 'image-optimization' ),
				'link' => esc_url( 'https://go.elementor.com/io-renew-expire/' ),
			];
		}
		return [
			'title' => esc_html__( 'It’s Not Too Late! Renew Image Optimizer', 'image-optimization' ),
			'description' => esc_html__( 'Reactivate your license to get back to top image performance.', 'image-optimization' ),
			'btn' => esc_html__( 'Renew and Optimize', 'image-optimization' ),
			'link' => esc_url( 'https://go.elementor.com/io-renew-post-expire/' ),
		];
	}

	public function render_renewal_notice() {
		$text = $this->get_renewal_text();
		?>
		<div class="notice notice-info is-dismissible image-optimizer__notice image-optimizer__notice--error image-optimizer__renewal-notice"
			 data-notice-slug="<?php echo esc_attr( self::RENEWAL_NOTICE_SLUG ); ?>" style="display:none;">
			<div class="image-optimizer__content-block">
				<svg width="32" height="32" fill="none" role="presentation">
					<rect width="32" height="32" fill="#232629" rx="16"/>
					<path fill="#fff" d="M10.508 4.135a.125.125 0 0 0-.236 0l-1.183 3.42a.125.125 0 0 1-.078.078L5.553 8.8a.125.125 0 0 0 0 .237l3.458 1.166a.125.125 0 0 1 .078.078l1.183 3.42a.125.125 0 0 0 .236 0l1.182-3.42a.125.125 0 0 1 .078-.078l3.458-1.166a.125.125 0 0 0 0-.237l-3.458-1.167a.125.125 0 0 1-.078-.077l-1.182-3.421ZM17.425 12.738v3.683l-4.073 4.582L26.495 9.598a.125.125 0 0 1 .207.094v14.851a.125.125 0 0 1-.125.125H5.874a.125.125 0 0 1-.09-.212l11.427-11.805a.125.125 0 0 1 .214.087Z"/>
				</svg>
				<p>
					<b>
						<?php echo esc_html( $text['title'] ); ?>
					</b>
					<span>
						<?php echo esc_html( $text['description'] ); ?>
					</span>
				</p>
			</div>
			<a href="<?php echo esc_url( $text['link'] ); ?>" target="_blank" rel="noopener noreferrer">
				<?php echo esc_html( $text['btn'] ); ?>
			</a>
		</div>

		<script>
			jQuery( document ).ready( function( $ ) {
				setTimeout(() => {
					const $msInOneDay = 24 * 60 * 60 * 1000;
					const $time_dismissed = localStorage.getItem('<?php echo esc_js( self::RENEWAL_NOTICE_SLUG ); ?>');
					const $show_notice = !$time_dismissed || Date.now() - $time_dismissed >= $msInOneDay;

					const $notice = $( '[data-notice-slug="<?php echo esc_js( self::RENEWAL_NOTICE_SLUG ); ?>"]' );
					const $closeButton = $( '[data-notice-slug="<?php echo esc_js( self::RENEWAL_NOTICE_SLUG ); ?>"] .notice-dismiss' );

					if ($show_notice) {
						$notice.css('display', 'flex');
						$closeButton.on( 'click', function () {
							localStorage.setItem('<?php echo esc_js( self::RENEWAL_NOTICE_SLUG ); ?>', Date.now().toString());
						} );
					} else {
						$notice.remove();
					}
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
			// @var ImageOptimizer/Modules/ConnectManager/Module
			$module = Plugin::instance()->modules_manager->get_modules( 'connect-manager' );

			if ( ! $module->connect_instance->is_connected() || ! Utils::user_is_admin() ) {
				return;
			}

			$info = Client::get_subscription_info();

			if ( empty( $info ) || $info->auto_renew || $this->date_diff_from_current( ( $info->date_next_payment ?? $info->date_end ) ) > 30 ) {
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
				add_action( 'admin_notices', [ $this, 'render_renewal_notice' ] );
			}
		});
	}
}
