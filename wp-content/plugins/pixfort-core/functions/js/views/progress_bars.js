(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    window.InlineShortcodeView_pix_progress_bars = window.InlineShortcodeView.extend({
	    	render: function () {
	    		window.InlineShortcodeView_pix_progress_bars.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            if(vc.frame_window.init_bars) vc.frame_window.init_bars();
	    		return this;
	    	},
	    	updated: function () {
	    		window.InlineShortcodeView_pix_progress_bars.__super__.updated.call(this);
	            if(vc.frame_window.init_bars) vc.frame_window.init_bars();
	            return this;
	    	},
	    	parentChanged: function () {
	    		window.InlineShortcodeView_pix_progress_bars.__super__.parentChanged.call(this);
	    	}
	    });
	}
})( window.jQuery );
