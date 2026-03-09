(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_img_carousel = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_test_element: render called.');
	    		window.InlineShortcodeView_pix_img_carousel.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update(this);
	    		return this;
	    	},
	    	pix_update: function (self) {
	            var that = this;
				self.$el.find('.pix-main-slider').each(function(i, elem){
					$(elem).removeClass('pix-is-loaded');
				});
				setTimeout(function(){
					window.vc.frame_window.pix_main_slider(self.$el);
					if (window.vc.frame_window.pixLoadSwiper) window.vc.frame_window.pixLoadSwiper(this.$el);
				}, 500);
	    	},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_img_carousel.__super__.updated.call(this);
	            this.pix_update(this);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_img_carousel.__super__.parentChanged.call(this);
				this.pix_update(this);
	    	}

	    });
	}

})( window.jQuery );
