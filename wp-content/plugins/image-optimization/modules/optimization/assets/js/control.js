import { __ } from '@wordpress/i18n';
import { speak } from '@wordpress/a11y';
import { SELECTORS } from './constants';
import API from './classes/api';
import ControlSync from './classes/control/control-sync';
import ControlStates from './classes/control/control-states';
import ControlMeta from './classes/control/control-meta';
import OptimizationDetails from './classes/optimization-details';

class OptimizationControl {
	constructor() {
		this.controlSyncRequestInProgress = false;

		this.init();

		this.controlSync = new ControlSync();
	}

	init() {
		this.initEventListeners();

		setInterval( () => this.runStatusCheckLoop(), 5000 );
	}

	async runStatusCheckLoop() {
		if ( this.controlSyncRequestInProgress ) {
			return;
		}

		this.controlSyncRequestInProgress = true;

		await this.controlSync.run();

		this.controlSyncRequestInProgress = false;
	}

	initEventListeners() {
		document.addEventListener( 'click', ( e ) => this.handleOptimizeButtonClick( e ) );
		document.addEventListener( 'click', ( e ) => this.handleReoptimizeButtonClick( e ) );
		document.addEventListener( 'click', ( e ) => this.handleRestoreButtonClick( e ) );
		document.addEventListener( 'click', ( e ) => this.handleOptimizationDetailsOpen( e ) );
		document.addEventListener( 'click', ( e ) => this.handleOptimizationDetailsClick( e ) );
	}

	async handleOptimizeButtonClick( e ) {
		if ( ! e.target.closest( `${ SELECTORS.optimizeButtonSelector }, ${ SELECTORS.tryAgainOptimizeButtonSelector }` ) ) {
			return;
		}

		speak( __( 'Optimization is in progress', 'image-optimization' ), 'assertive' );

		const controlWrapper = e.target.closest( SELECTORS.controlWrapperSelector );
		const states = new ControlStates( controlWrapper );

		states.renderLoading( 'optimize' );

		try {
			controlWrapper.dataset.isFrozen = true;

			await API.optimizeSingleImage( {
				imageId: new ControlMeta( controlWrapper ).getImageId(),
				reoptimize: false,
			} );
		} catch ( error ) {
			states.renderError( error );
		}
	}

	async handleReoptimizeButtonClick( e ) {
		if ( ! e.target.closest( `${ SELECTORS.reoptimizeButtonSelector }, ${ SELECTORS.tryAgainReoptimizeButtonSelector }` ) ) {
			return;
		}

		speak( __( 'Reoptimizing is in progress', 'image-optimization' ), 'assertive' );

		const controlWrapper = e.target.closest( SELECTORS.controlWrapperSelector );
		const states = new ControlStates( controlWrapper );

		states.renderLoading( 'reoptimize' );

		try {
			controlWrapper.dataset.isFrozen = true;

			await API.optimizeSingleImage( {
				imageId: new ControlMeta( controlWrapper ).getImageId(),
				reoptimize: true,
			} );
		} catch ( error ) {
			states.renderError( error );
		}
	}

	async handleRestoreButtonClick( e ) {
		if ( ! e.target.closest( `${ SELECTORS.restoreButtonSelector }, ${ SELECTORS.tryAgainRestoreButtonSelector }` ) ) {
			return;
		}

		speak( __( 'Image restoring is in progress', 'image-optimization' ), 'assertive' );

		const controlWrapper = e.target.closest( SELECTORS.controlWrapperSelector );
		const states = new ControlStates( controlWrapper );

		states.renderLoading( 'restore' );

		try {
			controlWrapper.dataset.isFrozen = true;

			await API.restoreSingleImage( new ControlMeta( controlWrapper ).getImageId() );
		} catch ( error ) {
			states.renderError( error );
		}
	}

	async handleOptimizationDetailsOpen( e ) {
		if ( ! e.target.closest( `${ SELECTORS.optimizationDetailsButtonSelector }` ) ) {
			return;
		}

		const controlWrapper = e.target.closest( SELECTORS.controlWrapperSelector );
		const imageId = new ControlMeta( controlWrapper ).getImageId();

		try {
			OptimizationDetails.initModal();
			OptimizationDetails.renderLoading();

			const details = await API.getOptimizationDetails( imageId );

			OptimizationDetails.openModal();
			OptimizationDetails.renderData( imageId, details );
		} catch ( error ) {
			OptimizationDetails.openModal();
			OptimizationDetails.renderError( error.message );
		}
	}

	async handleOptimizationDetailsClick( e ) {
		if ( ! e.target.closest( `${ SELECTORS.optimizationDetailsOptimizeButtonSelector }` ) ) {
			return;
		}

		const imageId = parseInt( e.target.dataset?.imageId, 10 );

		await API.optimizeSingleImage( { imageId } );

		const controlWrapper = document.querySelector( `.image-optimization-control[data-image-optimization-image-id="${ imageId }"]` );

		if ( controlWrapper ) {
			new ControlStates( controlWrapper ).renderLoading( 'optimize' );
		}

		OptimizationDetails.closeModal();
	}
}

export default OptimizationControl;
