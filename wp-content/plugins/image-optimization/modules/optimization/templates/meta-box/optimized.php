<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use ImageOptimization\Classes\File_Utils;

?>

<div class="image-optimization-control image-optimization-control--meta-box image-optimization-control--optimized"
		data-image-optimization-context="meta-box"
		data-image-optimization-status="optimized"
		data-image-optimization-image-id="<?php echo esc_attr( $args['image_id'] ); ?>"
		data-image-optimization-can-be-restored="<?php echo esc_attr( $args['can_be_restored'] ); ?>">
	<p class="image-optimization-control__property">
		<?php esc_html_e( 'Status', 'image-optimization' ); ?>:

		<span class="image-optimization-control__property-value">
			<?php esc_html_e( 'Optimized', 'image-optimization' ); ?>
		</span>
	</p>

	<p class="image-optimization-control__property">
		<?php esc_html_e( 'Image sizes optimized', 'image-optimization' ); ?>:

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
	</p>

	<p class="image-optimization-control__property">
		<?php if ( 0 === $args['saved']['absolute'] ) { ?>
			<span class="image-optimization-control__property-value">
				<?php
				if ( $args['is_losseless_and_webp'] ) {
					esc_html_e( 'Requested WebP format is larger than the original file. Switch to Lossy in settings to convert this image in an optimized manner.', 'image-optimization' );
				} else {
					esc_html_e( 'Image is fully optimized', 'image-optimization' );
				}
				?>
			</span>
		<?php } else { ?>
			<?php esc_html_e( 'Overall saving', 'image-optimization' ); ?>:

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
	</p>

	<div class="image-optimization-control__action-button-wrapper">
		<?php if ( $args['can_be_restored'] ) { ?>
			<button class="button button-link image-optimization-control__button image-optimization-control__button--restore-original"
						type="button">
				<?php esc_html_e( 'Restore original', 'image-optimization' ); ?>
			</button>
		<?php } ?>

		<button class="button button-link image-optimization-control__button image-optimization-control__button--reoptimize"
						type="button">
			<?php esc_html_e( 'Reoptimize', 'image-optimization' ); ?>
		</button>
	</div>
</div>
