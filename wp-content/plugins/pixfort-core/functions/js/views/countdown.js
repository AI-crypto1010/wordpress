(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_countdown = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_pix_countdown: render called.');
	    		window.InlineShortcodeView_pix_countdown.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				if(vc.frame_window.pix_countdown) vc.frame_window.pix_countdown(this.$el);
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_countdown: updated called.');
	    		window.InlineShortcodeView_pix_countdown.__super__.updated.call(this);
				if(vc.frame_window.pix_countdown) vc.frame_window.pix_countdown(this.$el);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_countdown: parentChanged called.');
	    		window.InlineShortcodeView_pix_countdown.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );
