(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_img_slider = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	    		window.InlineShortcodeView_pix_img_slider.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
	    		return this;
	    	},
	    	pix_update: function () {
	            var that = this;
				var that = this;
				setTimeout(function(){
					window.vc.frame_window.pix_main_slider(this.$el);
					if (window.vc.frame_window.pixLoadSwiper) window.vc.frame_window.pixLoadSwiper(this.$el);
				}, 500);
	    	},
	    	updated: function () {
	    		window.InlineShortcodeView_pix_img_slider.__super__.updated.call(this);
	            this.pix_update();
	            return this;
	    	},
	    	parentChanged: function () {
	    		window.InlineShortcodeView_pix_img_slider.__super__.parentChanged.call(this);
	    	}
	    });
	}

})( window.jQuery );
