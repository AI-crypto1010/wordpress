(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_portfolio = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_test_element: render called.');
	    		window.InlineShortcodeView_pix_portfolio.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
	    		return this;
	    	},
	    	pix_update: function () {
				if(window.vc.frame_window.init_portfolio) window.vc.frame_window.init_portfolio(this.$el);
				if(window.vc.frame_window.init_tilts) window.vc.frame_window.init_tilts(this.$el);
	    	},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_portfolio.__super__.updated.call(this);
	            this.pix_update();
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_portfolio.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );
