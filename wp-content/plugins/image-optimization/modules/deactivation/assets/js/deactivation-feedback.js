import '../css/style.css';

const REASON_FIELDS = {
	unclear_how_to_use: [ 'io_text_field_unclear', 'io_unclear_details' ],
	switched_solution: [ 'io_text_field_switched', 'io_switched_details' ],
	other: [ 'io_text_field_other', 'io_other_details' ],
};

class ImageOptimizationDeactivationHandler {
	constructor() {
		this.deactivationLink = document.querySelector(
			'[id*="deactivate-image-optimizer"], [id*="deactivate-image-optimization"]',
		);

		if ( ! this.deactivationLink ) {
			return;
		}

		this.originalDeactivationLink = this.deactivationLink.getAttribute( 'href' );

		this.init();
	}

	modal( title, url, cssClass ) {
		window.tb_show?.( title, url );
		setTimeout(
			() => document.getElementById( 'TB_window' )?.classList.add( cssClass ),
			5,
		);
	}

	hideFields() {
		document
			.querySelectorAll( '.image-optimization-feedback-text-field' )
			.forEach( ( f ) => ( f.classList.add( 'text-field-hidden' ) ) );
	}

	toggleField( reason ) {
		this.hideFields();
		const fieldId = REASON_FIELDS[ reason ]?.[ 0 ];
		if ( fieldId ) {
			document.getElementById( fieldId ).classList.remove( 'text-field-hidden' );
		}
	}

	sendRequest( data, done ) {
		fetch( window?.imageOptimizationDeactivationFeedback?.ajaxurl || '', {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: new URLSearchParams( data ),
		} ).finally( done );
	}

	handleSubmit() {
		const reason = document.querySelector(
			'input[name="image_optimization_deactivation_reason"]:checked',
		)?.value;
		const detailsId = REASON_FIELDS[ reason ]?.[ 1 ];
		const extra = detailsId
			? document.getElementById( detailsId )?.value || ''
			: '';

		if ( ! reason ) {
			this.deactivate();
			return;
		}

		this.sendRequest(
			{
				action: 'image_optimization_deactivation_feedback',
				reason,
				additional_data: extra,
				nonce: window?.imageOptimizationDeactivationFeedback?.nonce || '',
			},
			() => this.deactivate(),
		);
	}

	deactivate() {
		window.tb_remove?.();
		window.location.href = this.originalDeactivationLink;
	}

	init() {
		this.deactivationLink.addEventListener( 'click', ( e ) => {
			e.preventDefault();
			this.hideFields();
			this.modal(
				'QUICK FEEDBACK',
				'#TB_inline?width=550&height=auto&inlineId=image-optimization-deactivation-modal',
				'image-optimization-feedback-thickbox',
			);
		} );

		document.addEventListener( 'change', ( e ) => {
			if ( e.target?.name === 'image_optimization_deactivation_reason' ) {
				this.toggleField( e.target.value );
			}
		} );

		document.addEventListener( 'click', ( e ) => {
			if ( e.target?.id === 'image-optimization-submit-deactivate' ) {
				e.preventDefault();
				this.handleSubmit();
			}
			if ( e.target?.id === 'image-optimization-skip-deactivate' ) {
				e.preventDefault();
				this.deactivate();
			}
		} );
	}
}

document.addEventListener(
	'DOMContentLoaded',
	() => new ImageOptimizationDeactivationHandler(),
);
