(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_content_box = window.InlineShortcodeViewContainer.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_content_box: render called.');
	    		window.InlineShortcodeView_content_box.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				// _.bindAll( this);
				vc.frame_window.destroy_Parallax();
	            if(vc.frame_window.init_Parallax) vc.frame_window.init_Parallax();
	            if(vc.frame_window.init_scroll_rotate) vc.frame_window.init_scroll_rotate(this.$el);
				this.builder_content_box_block();
	    		return this;
	    	},
			builder_content_box_block: function(){
				let el = this.$el;
				vc.frame_window.pix_cb_fn(function(){
	    			el.find('.pix-content-box.d-sm-inline-flex, .pix-content-box.d-inline-flex').closest('.vc_element.vc_content_box').css({'display':'inline-block'});
				});
			},
	    	updated: function () {
	    		window.InlineShortcodeView_content_box.__super__.updated.call(this);
	            vc.frame_window.destroy_Parallax();
	            vc.frame_window.init_Parallax();
	            if(vc.frame_window.init_scroll_rotate) vc.frame_window.init_scroll_rotate(this.$el);
				if(vc.frame_window.pix_section_stack) vc.frame_window.pix_section_stack(this.$el);
	            return this;
	    	},
	    	parentChanged: function () {
	    		window.InlineShortcodeView_content_box.__super__.parentChanged.call(this);
	    	}
	    });
	}

})( window.jQuery );
