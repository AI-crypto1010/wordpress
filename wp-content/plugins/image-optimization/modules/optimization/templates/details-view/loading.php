<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="image-optimization-control image-optimization-control--details-view image-optimization-control--loading"
		data-image-optimization-context="details-view"
		data-image-optimization-status="loading"
		data-image-optimization-action="<?php echo esc_attr( $args['action'] ); ?>"
		data-image-optimization-image-id="<?php echo esc_attr( $args['image_id'] ); ?>"
		data-image-optimization-can-be-restored="<?php echo esc_attr( $args['can_be_restored'] ); ?>">
	<span class="setting image-optimization-setting">
		<span class="name image-optimization-control__property">
			<?php esc_html_e( 'Status', 'image-optimization' ); ?>:
		</span>

		<span class="image-optimization-control__property-value">
			<?php esc_html_e( 'In Progress', 'image-optimization' ); ?>
		</span>
	</span>

	<span class="setting image-optimization-setting">
		<span class="name image-optimization-control__property"></span>

		<span class="image-optimization-control__property-value image-optimization-control__property-value--spinner">
			<span class="spinner is-active"></span>
		</span>
	</span>
</div>
