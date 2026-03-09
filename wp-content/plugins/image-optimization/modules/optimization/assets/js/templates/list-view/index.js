import { __ } from '@wordpress/i18n';
import { escapeHTML } from '@wordpress/escape-html';
import { formatFileSize } from '../../utils';
import { getErrorButton } from '../common';

const notOptimizedTemplate = () => {
	return `
		<button type="button"
					class="button button-primary image-optimization-control__button image-optimization-control__button--optimize">
			${ __( 'Optimize now', 'image-optimization' ) }
		</button>
	`;
};

const loadingTemplate = ( action ) => {
	let buttonText;

	switch ( action ) {
		case 'restore':
			buttonText = __( 'Restoring…', 'image-optimization' );
			break;

		case 'optimize':
			buttonText = __( 'Optimizing…', 'image-optimization' );
			break;

		case 'reoptimize':
			buttonText = __( 'Reoptimizing…', 'image-optimization' );
			break;

		default:
			buttonText = __( 'Loading…', 'image-optimization' );
	}

	return `
		<button class="button button-secondary image-optimization-control__button image-optimization-control__button--optimize"
						disabled="">
			<span class="spinner is-active"></span> ${ buttonText }
		</button>
	`;
};

const errorTemplate = ( { message, imagesLeft, errorType, allowRetry } ) => {
	return `
		<span class="image-optimization-control__error-message">${ escapeHTML( message ) }</span>

		${ getErrorButton( { imagesLeft, errorType, allowRetry } ) }
	`;
};

const optimizedTemplate = ( data ) => {
	const absoluteValue = formatFileSize( data?.saved?.absolute, 1 );

	return `
		<p class="image-optimization-control__property">
			${ __( 'Image sizes optimized', 'image-optimization' ) }:

			<span>
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
		? `${ __( 'Overall saving', 'image-optimization' ) }: <span>${ data?.saved?.relative }% (${ absoluteValue })</span>`
		: `<span>${ __( 'Image is fully optimized', 'image-optimization' ) }</span>` }
		</p>

		<div class="image-optimization-control__buttons-wrapper">
			${ data?.canBeRestored ? `
				<button type="button"
					class="button button-secondary image-optimization-control__button image-optimization-control__button--restore-original">
					${ __( 'Restore original', 'image-optimization' ) }
				</button>
			` : '' }

			<button type="button"
				class="button button-secondary image-optimization-control__button image-optimization-control__button--reoptimize">
				${ __( 'Reoptimize', 'image-optimization' ) }
			</button>
		</div>
	`;
};

const listViewTemplates = Object.freeze( {
	notOptimizedTemplate,
	loadingTemplate,
	errorTemplate,
	optimizedTemplate,
} );

export default listViewTemplates;
