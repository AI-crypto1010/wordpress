(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_testimonial_masonry = window.InlineShortcodeView.extend({
	    	render: function () {
	            // console && console.log('InlineShortcodeView_test_element: render called.');
				_.bindAll( this, 'pix_update' );
	    		window.InlineShortcodeView_pix_testimonial_masonry.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
	    		return this;
	    	},
	    	pix_update: function () {
				setTimeout(function(){
					if(vc.frame_window){
						vc.frame_window.update_masonry(this.$el);
					}
				}, 400);
	    	},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_testimonial_masonry.__super__.updated.call(this);
	            this.pix_update();
				_.defer( this.pix_update );
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_testimonial_masonry.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );
