import { __ } from '@wordpress/i18n';
import { escapeHTML } from '@wordpress/escape-html';
import { formatFileSize } from '../../utils';
import { getErrorButton } from '../common';

const notOptimizedTemplate = () => {
	return `
		<span class="setting image-optimization-setting">
			<span class="name image-optimization-control__property">
				${ __( 'Status', 'image-optimization' ) }:
			</span>

			<span class="image-optimization-control__property-value">
				${ __( 'Not optimized', 'image-optimization' ) }
			</span>
		</span>

		<span class="setting image-optimization-setting">
			<span class="name image-optimization-control__property"></span>

			<span class="image-optimization-control__property-value image-optimization-control__property-value--button">
				<button type="button"
							class="button button-primary image-optimization-control__button image-optimization-control__button--optimize">
					${ __( 'Optimize now', 'image-optimization' ) }
				</button>
			</span>
		</span>
	`;
};

const loadingTemplate = () => {
	return `
		<span class="setting image-optimization-setting">
			<span class="name image-optimization-control__property">
				${ __( 'Status', 'image-optimization' ) }:
			</span>

			<span class="image-optimization-control__property-value">
				${ __( 'In Progress', 'image-optimization' ) }
			</span>
		</span>

		<span class="setting image-optimization-setting">
			<span class="name image-optimization-control__property"></span>

			<span class="image-optimization-control__property-value image-optimization-control__property-value--spinner">
				<span class="spinner is-active"></span>
			</span>
		</span>
	`;
};

const errorTemplate = ( { message, imagesLeft, errorType, allowRetry } ) => {
	return `
		<span class="setting image-optimization-setting">
			<span class="name image-optimization-control__property">
				${ __( 'Status', 'image-optimization' ) }:
			</span>

			<span class="image-optimization-control__property-value">
				${ __( 'Error', 'image-optimization' ) }
			</span>
		</span>

		<span class="setting image-optimization-setting">
			<span class="name image-optimization-control__property">
				${ __( 'Reason', 'image-optimization' ) }:
			</span>

			<span class="image-optimization-control__property-value">
				${ escapeHTML( message ) }
			</span>
		</span>

		<span class="setting image-optimization-setting">
			<span class="name image-optimization-control__property"></span>

			<span class="image-optimization-control__property-value image-optimization-control__property-value--button">
				${ getErrorButton( { imagesLeft, errorType, allowRetry } ) }
			</span>
		</span>
	`;
};

const optimizedTemplate = ( data ) => {
	const absoluteValue = formatFileSize( data?.saved?.absolute, 1 );

	return `
		<span class="setting image-optimization-setting">
			<span class="name image-optimization-control__property">
				${ __( 'Status', 'image-optimization' ) }:
			</span>

			<span class="image-optimization-control__property-value">
				${ __( 'Optimized', 'image-optimization' ) }
			</span>
		</span>

		<span class="setting image-optimization-setting">
			<span class="name image-optimization-control__property">
				${ __( 'Image sizes optimized', 'image-optimization' ) }:
			</span>

			<span class="image-optimization-control__property-value">
				${ data?.sizesOptimized }/${ data?.sizesTotal }

				<button type="button"
								class="image-optimization-control__details-button"
								aria-label="${ __( 'Open optimization details', 'image-optimization' ) }">
					(+)
				</button>
			</span>
		</span>

		<span class="setting image-optimization-setting">
			${ data?.saved?.absolute !== 0
		? `<span class="name image-optimization-control__property">
				${ __( 'Overall saving', 'image-optimization' ) }:
			 </span>

			 <span class="image-optimization-control__property-value">
				${ data?.saved?.relative }% (${ absoluteValue })
			 </span>`
		: `<span class="name image-optimization-control__property"></span>

			 <span class="image-optimization-control__property-value">
				${ __( 'Image is fully optimized', 'image-optimization' ) }
			 </span>` }
		</span>

		<span class="setting image-optimization-setting">
			<span class="name image-optimization-control__property"></span>

			<span class="image-optimization-control__property-value image-optimization-control__property-value--button">
				<button class="button button-link image-optimization-control__button image-optimization-control__button--reoptimize"
								type="button">
					${ __( 'Reoptimize', 'image-optimization' ) }
				</button>
			</span>
		</span>

		${ data?.canBeRestored ? `
			<span class="setting image-optimization-setting">
				<span class="name image-optimization-control__property"></span>

				<span class="image-optimization-control__property-value image-optimization-control__property-value--button">
					<button class="button button-link image-optimization-control__button image-optimization-control__button--restore-original"
									type="button">
						${ __( 'Restore original', 'image-optimization' ) }
					</button>
				</span>
			</span>
	` : '' }
	`;
};

const detailsViewTemplates = Object.freeze( {
	notOptimizedTemplate,
	loadingTemplate,
	errorTemplate,
	optimizedTemplate,
} );

export default detailsViewTemplates;
