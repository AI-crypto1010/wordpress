<?php

use ImageOptimization\Classes\Image\Image_Optimization_Error_Type;
use ImageOptimization\Classes\Utils;
use ImageOptimization\Modules\Settings\Module as Settings_Module;
use ImageOptimization\Modules\Core\Module as Core_Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="image-optimization-control image-optimization-control--list-view image-optimization-control--error"
		data-image-optimization-context="list-view"
		data-image-optimization-status="error"
		data-image-optimization-allow-retry="<?php echo esc_attr( $args['allow_retry'] ); ?>"
		data-image-optimization-action="<?php echo esc_attr( $args['action'] ); ?>"
		data-image-optimization-image-id="<?php echo esc_attr( $args['image_id'] ); ?>"
		data-image-optimization-can-be-restored="<?php echo esc_attr( $args['can_be_restored'] ); ?>">

	<?php
	$error_type = isset( $args['optimization_error_type'] ) ? $args['optimization_error_type'] : '';
	$message = esc_html( $args['message'] );

	if ( false === $args['allow_retry'] ) {
		$message_chunks = explode( '. ', $message, 2 );

		$message = "<span class='image-optimization-control__error-title'>{$message_chunks[0]}</span>";

		if ( isset( $message_chunks[1] ) ) {
			$message .= "<span class='image-optimization-control__error-subtitle'>{$message_chunks[1]}</span>";
		}
	}
	?>

	<span class='image-optimization-control__error-message'>
		<?php echo wp_kses_post( $message ); ?>
	</span>

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
</div>
