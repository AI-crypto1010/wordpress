<?php

use ImageOptimization\Classes\Image\Image_Optimization_Error_Type;
use ImageOptimization\Classes\Utils;
use ImageOptimization\Modules\Settings\Module as Settings_Module;
use ImageOptimization\Modules\Core\Module as Core_Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$error_type = isset( $args['optimization_error_type'] ) ? $args['optimization_error_type'] : '';
?>
<div class="image-optimization-control image-optimization-control--details-view image-optimization-control--error"
		data-image-optimization-context="details-view"
		data-image-optimization-status="error"
		data-image-optimization-allow-retry="<?php echo esc_attr( $args['allow_retry'] ); ?>"
		data-image-optimization-action="<?php echo esc_attr( $args['action'] ); ?>"
		data-image-optimization-image-id="<?php echo esc_attr( $args['image_id'] ); ?>"
		data-image-optimization-can-be-restored="<?php echo esc_attr( $args['can_be_restored'] ); ?>">
	<span class="setting image-optimization-setting">
		<span class="name image-optimization-control__property">
			<?php esc_html_e( 'Status', 'image-optimization' ); ?>:
		</span>

		<span class="image-optimization-control__property-value">
			<?php esc_html_e( 'Error', 'image-optimization' ); ?>
		</span>
	</span>

	<span class="setting image-optimization-setting">
		<span class="name image-optimization-control__property">
			<?php esc_html_e( 'Reason', 'image-optimization' ); ?>:
		</span>

		<span class="image-optimization-control__property-value">
			<?php echo esc_html( $args['message'] ); ?>
		</span>
	</span>

	<span class="setting image-optimization-setting">
		<span class="name image-optimization-control__property"></span>

		<span class="image-optimization-control__property-value image-optimization-control__property-value--button">
			<?php
			if ( Image_Optimization_Error_Type::AUTH_ERROR === $error_type ) {
				?>
				<a class="button button-secondary button-large image-optimization-control__button"
					 href="<?php echo esc_url( admin_url( 'admin.php?page=' . Settings_Module::SETTING_BASE_SLUG . '&action=connect' ) ); ?>"
					 target="_blank" rel="noopener noreferrer">
				   <?php esc_html_e( 'Connect', 'image-optimization' ); ?>
				</a>
				<?php
			} if ( Image_Optimization_Error_Type::CONNECTION_ERROR === $error_type ) {
				?>
				<button class="button button-secondary button-large button-link-delete image-optimization-control__button image-optimization-control__button--try-again"
								type="button">
					<?php esc_html_e( 'Try again', 'image-optimization' ); ?>
				</button>
				<?php
			} elseif ( isset( $args['images_left'] ) && 0 === $args['images_left'] ) {
				if ( Core_Module::is_elementor_one() ) {
					return;
				}
				?>
				<a class="button button-secondary button-large image-optimization-control__button"
					 href="<?php echo esc_url( Utils::get_upgrade_link( 'https://go.elementor.com/io-panel-upgrade/' ) ); ?>"
					 target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Upgrade', 'image-optimization' ); ?>
				</a>
				<?php
			} elseif ( $args['allow_retry'] ) {
				?>
				<button class="button button-secondary button-large button-link-delete image-optimization-control__button image-optimization-control__button--try-again"
								type="button">
					<?php esc_html_e( 'Try again', 'image-optimization' ); ?>
				</button>
				<?php
			}
			?>
		</span>
	</span>
</div>
