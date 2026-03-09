class ExtendViews {
	constructor() {
		this.init();
	}

	init() {
		this.extendAttachmentDetails();
		this.extendAttachmentDetailsTwoColumn();
	}

	// #tmpl-attachment-details
	extendAttachmentDetails() {
		if ( ! wp?.media?.view?.Attachment?.Details ) {
			return;
		}

		wp.media.view.Attachment.Details = wp.media.view.Attachment.Details.extend( {
			template( view ) {
				const html = wp.media.template( 'attachment-details' )( view );

				if ( this.model.attributes.type !== 'image' ) {
					return html;
				}

				const content = document.createElement( 'div' );
				content.innerHTML = html;

				const optimizationControl = this.getOptimizationControlHTML( view.compat.item );

				if ( ! optimizationControl ) {
					return content.innerHTML;
				}

				content.innerHTML += optimizationControl;

				return content.innerHTML;
			},
			getOptimizationControlHTML( compatData ) {
				const tempElement = document.createElement( 'div' );
				tempElement.innerHTML = compatData;

				return tempElement.querySelector( 'input[name*="[image_optimization_modal]"]' )?.value;
			},
		} );
	}

	// #tmpl-attachment-details-two-column
	extendAttachmentDetailsTwoColumn() {
		if ( ! wp?.media?.view?.Attachment?.Details?.TwoColumn ) {
			return;
		}

		wp.media.view.Attachment.Details.TwoColumn = wp.media.view.Attachment.Details.TwoColumn.extend( {
			template( view ) {
				const html = wp.media.template( 'attachment-details-two-column' )( view );

				if ( this.model.attributes.type !== 'image' ) {
					return html;
				}

				const content = document.createElement( 'div' );
				content.innerHTML = html;

				const optimizationControl = this.getOptimizationControlHTML( view.compat.item );

				if ( ! optimizationControl ) {
					return content.innerHTML;
				}

				const settings = content.querySelector( '.settings' );
				settings.innerHTML += optimizationControl;

				return content.innerHTML;
			},
			getOptimizationControlHTML( compatData ) {
				const tempElement = document.createElement( 'div' );
				tempElement.innerHTML = compatData;

				return tempElement.querySelector( 'input[name*="[image_optimization_modal]"]' )?.value;
			},
		} );
	}
}

export default ExtendViews;
