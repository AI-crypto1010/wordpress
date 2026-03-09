(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_gallery = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	    		window.InlineShortcodeView_pix_gallery.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				this.displayFix(this.$el);
	    		return this;
	    	},

	    	updated: function () {
	    		window.InlineShortcodeView_pix_gallery.__super__.updated.call(this);
				this.displayFix(this.$el);
	            return this;
	    	},
			displayFix: function(el){
                if(vc.frame_window){
                    setTimeout(function(){
                        vc.frame_window.pixLoadLightbox();
                        vc.frame_window.update_masonry(this.$el);
                    }, 400);
                }
			},
	    	parentChanged: function () {
	    		window.InlineShortcodeView_pix_gallery.__super__.parentChanged.call(this);
				this.displayFix(this.$el);
	    	}

	    });
	}

})( window.jQuery );
