(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_chart = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_chart: render called.');
	    		window.InlineShortcodeView_chart.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				if(vc.frame_window.init_chart){
					vc.frame_window.init_chart(this.$el);
				}
				
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_chart: updated called.');
	    		window.InlineShortcodeView_chart.__super__.updated.call(this);
				if(vc.frame_window.init_chart){
					vc.frame_window.init_chart(this.$el);
				}
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_chart: parentChanged called.');
	    		window.InlineShortcodeView_chart.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );
