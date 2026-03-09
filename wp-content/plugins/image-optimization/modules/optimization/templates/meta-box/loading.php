<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="image-optimization-control image-optimization-control--meta-box image-optimization-control--loading"
		data-image-optimization-context="meta-box"
		data-image-optimization-status="loading"
		data-image-optimization-action="<?php echo esc_attr( $args['action'] ); ?>"
		data-image-optimization-image-id="<?php echo esc_attr( $args['image_id'] ); ?>"
		data-image-optimization-can-be-restored="<?php echo esc_attr( $args['can_be_restored'] ); ?>">
	<p class="image-optimization-control__property">
		<?php esc_html_e( 'Status', 'image-optimization' ); ?>:

		<span class="image-optimization-control__property-value">
			<?php esc_html_e( 'In Progress', 'image-optimization' ); ?>
		</span>
	</p>

	<div class="image-optimization-control__action-spinner-wrapper">
		<span class="spinner is-active"></span>
	</div>
</div>
