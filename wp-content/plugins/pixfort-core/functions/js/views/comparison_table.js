(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_comparison_table = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
				let params = this.model.get( 'params' );
				params = window.pixVerifyWPBakeryIcons(params, true, 'items', 'pix-comparison-table');
				this.model.save( 'params', params );
				params = this.model.get( 'params' );

				// console.log(tt);
				// if(params&&params.hasOwnProperty('media_type')&&params.media_type){
				// 	if(params.media_type==='duo_icon'){
				// 		let oldParam = params.pix_duo_icon;	
				// 		params.media_type = 'icon';
				// 		params.icon = oldParam;
				// 	}
				// }
				// this.model.save( 'params', params );
				// params = this.model.get( 'params' );
                // $('body').trigger('pixfortIconsParam');
	    		window.InlineShortcodeView_pix_comparison_table.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_comparison_table: updated called.');
	    		window.InlineShortcodeView_pix_comparison_table.__super__.updated.call(this);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_comparison_table: parentChanged called.');
	    		window.InlineShortcodeView_pix_comparison_table.__super__.parentChanged.call(this);
	    	}

	    });
	}
})( window.jQuery );