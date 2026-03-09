(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_fancy_mockup = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_pix_fancy_mockup: render called.');
	    		window.InlineShortcodeView_pix_fancy_mockup.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            if(vc.frame_window.init_fancy_mockup) vc.frame_window.init_fancy_mockup(this.$el);
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_fancy_mockup: updated called.');
	    		window.InlineShortcodeView_pix_fancy_mockup.__super__.updated.call(this);
	            if(vc.frame_window.init_fancy_mockup) vc.frame_window.init_fancy_mockup(this.$el);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_fancy_mockup: parentChanged called.');
	    		window.InlineShortcodeView_pix_fancy_mockup.__super__.parentChanged.call(this);
	    	}

	    });
	}
})( window.jQuery );
