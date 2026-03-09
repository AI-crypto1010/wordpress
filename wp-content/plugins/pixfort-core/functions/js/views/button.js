(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_button = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_pix_button: render called.');
	    		window.InlineShortcodeView_pix_button.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				// vc.frame_window.builder_btn_block(this.$el);
				this.builder_btn_block();
	    		return this;
	    	},
			builder_btn_block: function(){
				let el = this.$el;
				vc.frame_window.pix_cb_fn(function(){
					el.find('.btn.d-block, .pix-btn-div').closest('.vc_element.vc_pix_button').css({'display':'block'});
	    			el.find('.btn:not(.d-block, .pix-btn-div)').closest('.vc_element.vc_pix_button').css({'display':'inline-block'});
				});
			},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_button: updated called.');
	    		window.InlineShortcodeView_pix_button.__super__.updated.call(this);
				// vc.frame_window.builder_btn_block(this.$el);
				this.builder_btn_block();
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_button: parentChanged called.');
	    		window.InlineShortcodeView_pix_button.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );
