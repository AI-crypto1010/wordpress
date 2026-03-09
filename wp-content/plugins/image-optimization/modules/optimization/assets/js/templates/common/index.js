import { __ } from '@wordpress/i18n';
import { UPGRADE_LINK } from '../../constants';
import { getUpgradeLink } from '../../../../../../assets/dev/js/utils';

const getErrorButton = ( { errorType, imagesLeft, allowRetry } ) => {
	const isElementorOne = window?.imageOptimizerUserData?.isElementorOne || false;
	if ( 'auth-error' === errorType ) {
		const connectLink = window?.imageOptimizerControlSettings?.connectLink;

		return `
			<a class="button button-secondary button-large image-optimization-control__button"
				 href="${ connectLink }"
				 target="_blank" rel="noopener noreferrer">
 				${ __( 'Connect', 'image-optimization' ) }
			</a>
		`;
	} else if ( 'connection-error' === errorType ) {
		return `
			<button class="button button-secondary button-large button-link-delete image-optimization-control__button image-optimization-control__button--try-again"
							type="button">
				${ __( 'Try again', 'image-optimization' ) }
			</button>
		`;
	} else if ( typeof imagesLeft !== 'undefined' && 0 === imagesLeft ) {
		if ( isElementorOne ) {
			return '';
		}

		const subscriptionId = window?.imageOptimizerUserData?.planData?.subscription_id;
		return `
			<a class="button button-secondary button-large image-optimization-control__button"
				 href="${ getUpgradeLink( UPGRADE_LINK, subscriptionId ) }"
				 target="_blank" rel="noopener noreferrer">
 				${ __( 'Upgrade', 'image-optimization' ) }
			</a>
		`;
	} else if ( allowRetry ) {
		return `
			<button class="button button-secondary button-large button-link-delete image-optimization-control__button image-optimization-control__button--try-again"
							type="button">
				${ __( 'Try again', 'image-optimization' ) }
			</button>
		`;
	}
};

export {
	getErrorButton,
};
