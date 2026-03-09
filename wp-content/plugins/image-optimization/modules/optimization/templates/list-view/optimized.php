<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use ImageOptimization\Classes\File_Utils;

?>

<div class="image-optimization-control image-optimization-control--list-view image-optimization-control--optimized"
		data-image-optimization-context="list-view"
		data-image-optimization-status="optimized"
		data-image-optimization-image-id="<?php echo esc_attr( $args['image_id'] ); ?>"
		data-image-optimization-can-be-restored="<?php echo esc_attr( $args['can_be_restored'] ); ?>">
	<p class="image-optimization-control__property">
		<?php esc_html_e( 'Image sizes optimized', 'image-optimization' ); ?>:
		<span>
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
			<span>
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

			<span>
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

	<div class="image-optimization-control__buttons-wrapper">
		<?php if ( $args['can_be_restored'] ) { ?>
			<button type="button"
							class="button button-secondary image-optimization-control__button image-optimization-control__button--restore-original">
				<?php esc_html_e( 'Restore original', 'image-optimization' ); ?>
			</button>
		<?php } ?>

		<button type="button"
						class="button button-secondary image-optimization-control__button image-optimization-control__button--reoptimize">
			<?php esc_html_e( 'Reoptimize', 'image-optimization' ); ?>
		</button>
	</div>
</div>
