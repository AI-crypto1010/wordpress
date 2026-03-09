import listViewTemplates from '../../templates/list-view';
import metaBoxTemplates from '../../templates/meta-box';
import detailsViewTemplates from '../../templates/details-view';
import { SELECTORS } from '../../constants';
import ControlMeta from './control-meta';

class ControlStates {
	constructor( controlWrapper ) {
		this.controlWrapper = controlWrapper;
		this.context = new ControlMeta( controlWrapper ).getContext();
		this.action = new ControlMeta( controlWrapper ).getAction();
		this.canBeRestored = new ControlMeta( controlWrapper ).canBeRestored();
		this.templates = {
			'list-view': listViewTemplates,
			'meta-box': metaBoxTemplates,
			'details-view': detailsViewTemplates,
		};
	}

	renderNotOptimized( data ) {
		this.controlWrapper.className = this.mixControlContextClass( SELECTORS.controlNotOptimizedClassName );
		this.controlWrapper.innerHTML = this.getTemplates().notOptimizedTemplate( data );

		this.controlWrapper.dataset.imageOptimizationStatus = 'not-optimized';
	}

	renderOptimized( data ) {
		const canBeRestored = this.canBeRestored && data?.saved?.absolute !== 0;

		this.controlWrapper.className = this.mixControlContextClass( SELECTORS.controlOptimizedClassName );
		this.controlWrapper.innerHTML = this.getTemplates().optimizedTemplate( { ...data, canBeRestored } );

		this.controlWrapper.dataset.imageOptimizationStatus = 'optimized';
	}

	renderError( { message, errorType, imagesLeft, allowRetry, action } ) {
		this.controlWrapper.className = this.mixControlContextClass( SELECTORS.controlErrorClassName );
		this.controlWrapper.innerHTML = this.getTemplates().errorTemplate( { message, errorType, imagesLeft, allowRetry } );

		this.controlWrapper.dataset.imageOptimizationAction = action;
		this.controlWrapper.dataset.imageOptimizationStatus = 'error';
	}

	renderLoading( action ) {
		this.controlWrapper.className = this.mixControlContextClass( SELECTORS.controlLoadingClassName );
		this.controlWrapper.innerHTML = this.getTemplates().loadingTemplate( action );

		this.controlWrapper.dataset.imageOptimizationStatus = 'loading';
	}

	getTemplates() {
		const template = this.templates[ this.context ];

		if ( ! template ) {
			throw new Error( `No templates found for the context ${ this.context }` );
		}

		return template;
	}

	mixControlContextClass( className ) {
		const contextClassName = SELECTORS.controlWrapper[ this.context ];

		if ( ! contextClassName ) {
			throw new Error( `No context className found for the context ${ this.context }` );
		}

		return `${ className } ${ contextClassName }`;
	}
}

export default ControlStates;
