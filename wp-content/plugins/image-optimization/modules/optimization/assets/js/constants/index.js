export const UPGRADE_LINK = 'https://go.elementor.com/io-panel-upgrade/';

export const SELECTORS = Object.freeze( {
	optimizeButtonSelector: '.image-optimization-control__button--optimize',
	reoptimizeButtonSelector: '.image-optimization-control__button--reoptimize',
	tryAgainOptimizeButtonSelector: '[data-image-optimization-action="optimize"] .image-optimization-control__button--try-again',
	tryAgainReoptimizeButtonSelector: '[data-image-optimization-action="reoptimize"] .image-optimization-control__button--try-again',
	tryAgainRestoreButtonSelector: '[data-image-optimization-action="restore"] .image-optimization-control__button--try-again',
	controlWrapperSelector: '.image-optimization-control',
	controlNotOptimizedClassName: 'image-optimization-control image-optimization-control--not-optimized',
	controlLoadingClassName: 'image-optimization-control image-optimization-control--loading',
	controlOptimizedClassName: 'image-optimization-control image-optimization-control--optimized',
	controlErrorClassName: 'image-optimization-control image-optimization-control--error',
	controlWrapper: {
		'list-view': 'image-optimization-control--list-view',
		'meta-box': 'image-optimization-control--meta-box',
		'details-view': 'image-optimization-control--details-view',
	},
	restoreButtonSelector: '.image-optimization-control__button--restore-original',
	loadingControlsSelector: '[data-image-optimization-status="loading"]',
	optimizationDetailsButtonSelector: '.image-optimization-control__details-button',
	optimizationDetailsOptimizeButtonSelector: '.image-optimization-details-table__optimization-button',
	optimizationDetailsWrapperId: 'image-optimization-optimization-details-wrapper',
	optimizationDetailsModalId: 'image-optimization-optimization-details-modal',
} );
