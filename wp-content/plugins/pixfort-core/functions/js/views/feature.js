(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_feature = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
				let params = this.model.get( 'params' );
				params = window.pixVerifyWPBakeryIcons(params, false, null, null, 'pix-feature');
				this.model.save( 'params', params );
				params = this.model.get( 'params' );

	            // console && console.log('InlineShortcodeView_pix_feature: render called.');
	    		window.InlineShortcodeView_pix_feature.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_feature: updated called.');
	    		window.InlineShortcodeView_pix_feature.__super__.updated.call(this);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_feature: parentChanged called.');
	    		window.InlineShortcodeView_pix_feature.__super__.parentChanged.call(this);
	    	}

	    });
	}
})( window.jQuery );