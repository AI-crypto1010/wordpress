(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_accordion_tab = window.InlineShortcodeViewContainer.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
				let params = this.model.get( 'params' );
				params = window.pixVerifyWPBakeryIcons(params);
				this.model.save( 'params', params );
				params = this.model.get( 'params' );
	            // console && console.log('InlineShortcodeView_test_element: render called.');
	    		window.InlineShortcodeView_pix_accordion_tab.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
	    		return this;
	    	},
	    	pix_update: function () {
				var that = this;
	    	},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_accordion_tab.__super__.updated.call(this);
	            this.pix_update();
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_accordion_tab.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );
