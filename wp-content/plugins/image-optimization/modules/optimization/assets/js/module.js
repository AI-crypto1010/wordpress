import '../css/control.css';
import ExtendViews from './classes/extend-views';
import OptimizationControl from './control';

class Module {
	constructor() {
		this.init();
	}

	init() {
		new ExtendViews();
		new OptimizationControl();
	}
}

document.addEventListener( 'DOMContentLoaded', () => new Module() );
