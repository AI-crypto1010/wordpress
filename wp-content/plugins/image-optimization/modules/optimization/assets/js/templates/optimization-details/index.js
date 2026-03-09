import { __, sprintf } from '@wordpress/i18n';
import { formatFileSize } from '../../utils';
import { getUpgradeLink } from '../../../../../../assets/dev/js/utils';

const header = () => {
	return `
		<div>
			<table class="wp-list-table widefat striped image-optimization-details-table">
				<thead>
					<tr>
						<th>${ __( 'Size Name', 'image-optimization' ) }</th>
						<th>${ __( 'Image Size', 'image-optimization' ) }</th>
						<th>${ __( 'Savings', 'image-optimization' ) }</th>
						<th></th>
					</tr>
				</thead>

				<tbody>
	`;
};

const footer = ( data ) => {
	const totalSize = sprintf(
		// Translators: %s - total file size
		__( 'Total: %s', 'image-optimization' ),
		formatFileSize( data?.total ),
	);

	return `
				</tbody>
			</table>

			<p>
				<b>
					${ totalSize }
				</b>
			</p>
		</div>
	`;
};

const rowStart = ( data ) => {
	return `
  	<tr>
  		<td class="image-optimization-details-table__size-name"><b>${ data.size_name }</b></td>
  		<td class="image-optimization-details-table__size">${ formatFileSize( data.file_size ) }</td>
  `;
};

const rowEnd = () => {
	return '</tr>';
};

const optimizedChunk = ( data ) => {
	const optimizationStats = sprintf(
		// Translators: %1$s: Optimization percentage, %2$ file size decrease
		__( 'Reduced by %1$s%% (%2$s)', 'image-optimization' ),
		data.saved.relative,
		formatFileSize( data.saved.absolute ),
	);

	const croppingStats = data.new_dimensions ? sprintf(
		// Translators: %1$s: Width, %2$ height
		__( 'Resized to %1$s(w) x %2$s(h)', 'image-optimization' ),
		data.new_dimensions.width,
		data.new_dimensions.height,
	) : '';

	return `
		<td class="image-optimization-details-table__status">
			<span class="image-optimization-details-table__property">
				${ optimizationStats }
			</span>

			<span class="image-optimization-details-table__property">
				${ croppingStats }
			</span>
		</td>

		<td class="image-optimization-details-table__action"></td>
	`;
};

const notOptimizedChunk = ( data ) => {
	return `
		<td class="image-optimization-details-table__status">
			<span class="image-optimization-details-table__property">
				${ __( 'Not optimized', 'image-optimization' ) }
			</span>
		</td>

		<td class="image-optimization-details-table__action">
				<button type="button"
								class="button button-primary image-optimization-details-table__optimization-button"
								data-image-id="${ data.imageId }">
					${ __( 'Optimize', 'image-optimization' ) }
				</button>
		</td>
	`;
};

const notFoundChunk = () => {
	return `
		<td class="image-optimization-details-table__status">
			<span class="image-optimization-details-table__property image-optimization-details-table__property--error">
				${ __( 'File is missing', 'image-optimization' ) }
			</span>
  	</td>

  	<td class="image-optimization-details-table__action"></td>
	`;
};

const tooLargeChunk = () => {
	const message = sprintf(
		// Translators: %s - max file size
		__( 'File is too large. Max size is %s', 'image-optimization' ),
		formatFileSize( window?.imageOptimizerUserData?.maxFileSize ),
	);

	const subscriptionId = window?.imageOptimizerUserData?.planData?.subscription_id;

	return `
		<td class="image-optimization-details-table__status">
			<span class="image-optimization-details-table__property">
				${ message }
			</span>
  	</td>

  	<td class="image-optimization-details-table__action">
  		<a class="button button-primary button-large"
				 href="${ getUpgradeLink( 'https://go.elementor.com/io-panel-upgrade/', subscriptionId ) }"
				 target="_blank" rel="noopener noreferrer">
				${ __( 'Upgrade', 'image-optimization' ) }
			</a>
		</td>
	`;
};

const error = ( data ) => {
	return `
		<span class="image-optimization-details-table__error">${ data.message }</span>
	`;
};

const optimizationDetailsTemplate = Object.freeze( {
	header,
	footer,
	rowStart,
	rowEnd,
	optimizedChunk,
	notOptimizedChunk,
	notFoundChunk,
	tooLargeChunk,
	error,
} );

export default optimizationDetailsTemplate;
