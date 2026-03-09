(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_accordion = window.InlineShortcodeViewContainer.extend({
	    	render: function () {
	            // console && console.log('InlineShortcodeView_test_element: render called.');
				_.bindAll( this, 'pix_update' );
	    		window.InlineShortcodeView_pix_accordion.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
				setTimeout(function(){
					vc.frame_window.pix_animation(this.$el);
				}, 100);

	    		return this;
	    	},
	    	pix_update: function () {
	    	},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_accordion.__super__.updated.call(this);
	            this.pix_update();
				_.defer( this.pix_update );
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_accordion.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );
