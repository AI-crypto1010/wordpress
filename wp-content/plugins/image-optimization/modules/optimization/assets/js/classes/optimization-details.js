/* global tb_show, tb_click, tb_remove */

import { __ } from '@wordpress/i18n';
import { SELECTORS } from '../constants';
import optimizationDetailsTemplate from '../templates/optimization-details';

const MODAL_WIDTH = 700;
const MODAL_HEIGHT = 500;

/**
 * @class
 *
 * Contains methods to work with the optimization details modal.
 * It fully relies on the ThickBox API.
 */
class OptimizationDetails {
	/**
	 * Checks if the modal template element exists on the page.
	 * @return {boolean} Returns true if the modal template element exists, returns false otherwise.
	 */
	static modalTemplateExists() {
		return !! document.getElementById( SELECTORS.optimizationDetailsModalId );
	}

	/**
	 * Creates a basic template element to render inside a modal.
	 */
	static initModal() {
		if ( OptimizationDetails.modalTemplateExists() ) {
			return;
		}

		const container = document.createElement( 'div' );

		container.id = SELECTORS.optimizationDetailsWrapperId;
		container.style = 'display:none;';
		container.innerHTML = `<div id="${ SELECTORS.optimizationDetailsModalId }"></div>`;

		document.body.appendChild( container );
	}

	/**
	 * Opens a modal and removes the template element.
	 */
	static openModal() {
		tb_show(
			__( 'Optimization Details', 'image-optimization' ),
			`#TB_inline?width=${ MODAL_WIDTH }&height=${ MODAL_HEIGHT }&inlineId=${ SELECTORS.optimizationDetailsWrapperId }`,
		);

		document
			.getElementById( SELECTORS.optimizationDetailsWrapperId )
			?.remove();
	}

	/**
	 * Closes the modal.
	 */
	static closeModal() {
		tb_remove();
	}

	/**
	 * Renders an error message.
	 *
	 * @param {string} message
	 *
	 * @return {boolean} Returns false if modal container not found.
	 */
	static renderError( message ) {
		const container = document.getElementById( SELECTORS.optimizationDetailsModalId );

		if ( ! container ) {
			return false;
		}

		const { error } = optimizationDetailsTemplate;

		container.innerHTML = error( { message } );

		return true;
	}

	/**
	 * Shows a default ThickBox loader.
	 */
	static renderLoading() {
		tb_click();
	}

	/**
	 * Renders the modal content.
	 *
	 * @param {number}                        imageId
	 * @param {{total: number, sizes: Array}} optimizationDetails
	 *
	 * @return {boolean} Returns false if modal container not found.
	 */
	static renderData( imageId, optimizationDetails ) {
		const container = document.getElementById( SELECTORS.optimizationDetailsModalId );

		if ( ! container ) {
			return false;
		}

		const {
			header,
			footer,
			rowStart,
			rowEnd,
			optimizedChunk,
			notOptimizedChunk,
			notFoundChunk,
			tooLargeChunk,
		} = optimizationDetailsTemplate;

		let html = header();

		optimizationDetails?.sizes.forEach( ( size ) => {
			html += rowStart( size );

			if ( 'optimized' === size.status ) {
				html += optimizedChunk( size );
			}

			if ( 'not-optimized' === size.status ) {
				html += notOptimizedChunk( { imageId } );
			}

			if ( 'file-not-found' === size.status ) {
				html += notFoundChunk();
			}

			if ( 'file-too-large' === size.status ) {
				html += tooLargeChunk();
			}

			html += rowEnd();
		} );

		html += footer( optimizationDetails );

		container.innerHTML = html;

		return true;
	}
}

export default OptimizationDetails;
