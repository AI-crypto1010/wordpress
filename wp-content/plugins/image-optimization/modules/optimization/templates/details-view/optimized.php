<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use ImageOptimization\Classes\File_Utils;

?>

<div class="image-optimization-control image-optimization-control--details-view image-optimization-control--optimized"
		data-image-optimization-context="details-view"
		data-image-optimization-status="optimized"
		data-image-optimization-image-id="<?php echo esc_attr( $args['image_id'] ); ?>"
		data-image-optimization-can-be-restored="<?php echo esc_attr( $args['can_be_restored'] ); ?>">
	<span class="setting image-optimization-setting">
		<span class="name image-optimization-control__property">
			<?php esc_html_e( 'Status', 'image-optimization' ); ?>:
		</span>

		<span class="image-optimization-control__property-value">
			<?php esc_html_e( 'Optimized', 'image-optimization' ); ?>
		</span>
	</span>

	<span class="setting image-optimization-setting">
		<span class="name image-optimization-control__property">
			<?php esc_html_e( 'Image sizes optimized', 'image-optimization' ); ?>:
		</span>

		<span class="image-optimization-control__property-value">
			<?php printf(
				'%d/%d',
				esc_html( $args['sizes_optimized_count'] ),
				esc_html( $args['sizes_total'] )
			); ?>

			<button type="button"
							class="image-optimization-control__details-button"
							aria-label="<?php esc_html_e( 'Open optimization details', 'image-optimization' ); ?>">
				(+)
			</button>
		</span>
	</span>

	<span class="setting image-optimization-setting">
		<?php if ( 0 === $args['saved']['absolute'] ) { ?>
			<span class="name image-optimization-control__property"></span>

			<span class="name image-optimization-control__property-value" style="max-width: 50%;">
				<?php
				if ( $args['is_losseless_and_webp'] ) {
					esc_html_e( 'Requested WebP format is larger than the original file. Switch to Lossy in settings to convert this image in an optimized manner.', 'image-optimization' );
				} else {
					esc_html_e( 'Image is fully optimized', 'image-optimization' );
				}
				?>
			</span>
		<?php } else { ?>
			<span class="name image-optimization-control__property">
				<?php esc_html_e( 'Overall saving', 'image-optimization' ); ?>:
			</span>

			<span class="image-optimization-control__property-value">
				<?php
				printf(
					esc_html__( '%1$s%% (%2$s)', 'image-optimization' ),
					esc_html( $args['saved']['relative'] ),
					esc_html( File_Utils::format_file_size( $args['saved']['absolute'], 1 ) )
				);
				?>
			</span>
		<?php } ?>
	</span>

	<span class="setting image-optimization-setting">
		<span class="name image-optimization-control__property"></span>

		<span class="image-optimization-control__property-value image-optimization-control__property-value--button">
			<button class="button button-link image-optimization-control__button image-optimization-control__button--reoptimize"
							type="button">
				<?php esc_html_e( 'Reoptimize', 'image-optimization' ); ?>
			</button>
		</span>
	</span>

	<?php if ( $args['can_be_restored'] ) { ?>
		<span class="setting image-optimization-setting">
			<span class="name image-optimization-control__property"></span>

			<span class="image-optimization-control__property-value image-optimization-control__property-value--button">
				<button class="button button-link image-optimization-control__button image-optimization-control__button--restore-original"
								type="button">
					<?php esc_html_e( 'Restore original', 'image-optimization' ); ?>
				</button>
			</span>
		</span>
	<?php } ?>
</div>
