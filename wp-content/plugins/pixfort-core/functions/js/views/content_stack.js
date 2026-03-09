(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_content_stack = window.InlineShortcodeViewContainer.extend({
	    	// Render called every time when some of attributes changed.
	    	// render: function () {
	        //     console && console.log('InlineShortcodeView_pix_content_stack: render called.');
	    	// 	window.InlineShortcodeViewContainer.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
			// 	vc.frame_window.destroy_Parallax();
	        //     vc.frame_window.init_Parallax();
	        //     vc.frame_window.init_scroll_rotate(this.$el);
	    	// 	return this;
	    	// },

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_content_stack: updated called.');
	    		window.InlineShortcodeView_pix_content_stack.__super__.updated.call(this);
	            vc.frame_window.destroy_Parallax();
	            vc.frame_window.init_Parallax();
	            if(vc.frame_window.init_scroll_rotate) vc.frame_window.init_scroll_rotate(this.$el);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_content_stack: parentChanged called.');
	    		window.InlineShortcodeView_pix_content_stack.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );
