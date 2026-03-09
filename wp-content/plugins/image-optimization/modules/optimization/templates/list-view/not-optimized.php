<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="image-optimization-control image-optimization-control--list-view image-optimization-control--not-optimized"
		data-image-optimization-context="list-view"
		data-image-optimization-status="not-optimized"
		data-image-optimization-image-id="<?php echo esc_attr( $args['image_id'] ); ?>"
		data-image-optimization-can-be-restored="<?php echo esc_attr( $args['can_be_restored'] ); ?>">
	<button type="button"
					class="button button-primary image-optimization-control__button image-optimization-control__button--optimize">
		<?php esc_html_e( 'Optimize now', 'image-optimization' ); ?>
	</button>
</div>
