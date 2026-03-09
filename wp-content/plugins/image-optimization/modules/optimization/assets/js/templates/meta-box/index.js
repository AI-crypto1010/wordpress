import { __ } from '@wordpress/i18n';
import { escapeHTML } from '@wordpress/escape-html';
import { formatFileSize } from '../../utils';
import { getErrorButton } from '../common';

const notOptimizedTemplate = () => {
	return `
		<p class="image-optimization-control__property">
			${ __( 'Status', 'image-optimization' ) }:

			<span class="image-optimization-control__property-value">
				${ __( 'Not optimized', 'image-optimization' ) }
			</span>
		</p>

		<div class="image-optimization-control__action-button-wrapper">
			<button type="button"
							class="button button-primary image-optimization-control__button image-optimization-control__button--optimize">
				${ __( 'Optimize now', 'image-optimization' ) }
			</button>
		</div>
	`;
};

const loadingTemplate = () => {
	return `
		<p class="image-optimization-control__property">
			${ __( 'Status', 'image-optimization' ) }:

			<span class="image-optimization-control__property-value">
				${ __( 'In Progress', 'image-optimization' ) }
			</span>
		</p>

		<div class="image-optimization-control__action-spinner-wrapper">
			<span class="spinner is-active"></span>
		</div>
	`;
};

const errorTemplate = ( { message, imagesLeft, errorType, allowRetry } ) => {
	return `
		<p class="image-optimization-control__property">
			${ __( 'Status', 'image-optimization' ) }:

			<span class="image-optimization-control__property-value">
				${ __( 'Error', 'image-optimization' ) }
			</span>
		</p>

		<p class="image-optimization-control__property">
			${ __( 'Reason', 'image-optimization' ) }:

			<span class="image-optimization-control__property-value">
				${ escapeHTML( message ) }
			</span>
		</p>

		<div class="image-optimization-control__action-button-wrapper">
			${ getErrorButton( { imagesLeft, errorType, allowRetry } ) }
		</div>
	`;
};

const optimizedTemplate = ( data ) => {
	const absoluteValue = formatFileSize( data?.saved?.absolute, 1 );

	return `
		<p class="image-optimization-control__property">
			${ __( 'Status', 'image-optimization' ) }:

			<span class="image-optimization-control__property-value">
				${ __( 'Optimized', 'image-optimization' ) }
			</span>
		</p>

		<p class="image-optimization-control__property">
			${ __( 'Image sizes optimized', 'image-optimization' ) }:

			<span class="image-optimization-control__property-value">
				${ data?.sizesOptimized }/${ data?.sizesTotal }

				<button type="button"
								class="image-optimization-control__details-button"
								aria-label="${ __( 'Open optimization details', 'image-optimization' ) }">
					(+)
				</button>
			</span>
		</p>

		<p class="image-optimization-control__property">
			${ data?.saved?.absolute !== 0
		? `
				<span class="image-optimization-control__property-value">
					${ __( 'Overall saving', 'image-optimization' ) }: ${ data?.saved?.relative }% (${ absoluteValue })
				</span>
			` : `
				<span class="image-optimization-control__property-value">
					${ __( 'Image is fully optimized', 'image-optimization' ) }
				</span>
			` }
		</p>

		<div class="image-optimization-control__action-button-wrapper">
			${ data?.canBeRestored ? `
				<button class="button button-link image-optimization-control__button image-optimization-control__button--restore-original"
								type="button">
					${ __( 'Restore original', 'image-optimization' ) }
				</button>
			` : '' }

			<button class="button button-link image-optimization-control__button image-optimization-control__button--reoptimize"
							type="button">
				${ __( 'Reoptimize', 'image-optimization' ) }
			</button>
		</div>
	`;
};

const metaBoxTemplates = Object.freeze( {
	notOptimizedTemplate,
	loadingTemplate,
	errorTemplate,
	optimizedTemplate,
} );

export default metaBoxTemplates;
