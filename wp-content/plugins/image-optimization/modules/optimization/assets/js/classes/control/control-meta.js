class ControlMeta {
	constructor( controlNode ) {
		this.controlNode = controlNode;
	}

	getImageId() {
		return this.controlNode.dataset?.imageOptimizationImageId
			? parseInt( this.controlNode.dataset?.imageOptimizationImageId, 10 )
			: null;
	}

	getAction() {
		return this.controlNode.dataset?.imageOptimizationAction || null;
	}

	getContext() {
		return this.controlNode.dataset?.imageOptimizationContext || null;
	}

	getStatus() {
		return this.controlNode.dataset?.imageOptimizationStatus || null;
	}

	getErrorType() {
		return this.controlNode.dataset?.imageOptimizationErrorType || null;
	}

	canBeRestored() {
		const value = this.controlNode.dataset?.imageOptimizationCanBeRestored;

		if ( ! value ) {
			return null;
		}

		return '1' === value;
	}

	allowRetry() {
		return '1' === this.controlNode.dataset?.imageOptimizationAllowRetry;
	}
}

export default ControlMeta;
