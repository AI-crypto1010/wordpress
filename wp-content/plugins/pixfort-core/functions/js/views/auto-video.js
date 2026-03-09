(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    window.InlineShortcodeView_pix_auto_video = window.InlineShortcodeView.extend({
	    	render: function () {
	    		window.InlineShortcodeView_pix_auto_video.__super__.render.call(this);
				this.pix_update(this.$el);
	    		return this;
	    	},
	    	updated: function () {
	    		window.InlineShortcodeView_pix_auto_video.__super__.updated.call(this);

				this.pix_update(this.$el);

	            return this;
	    	},
			pix_update: function(el){
				if(vc.frame_window.pix_section_stack) vc.frame_window.pix_section_stack();
				vc.frame_window.pix_cb_fn(function(){
					if(el.find('.pix-img-div').length==0){
				        el.css({
				            'display': 'inline-block'
				        });
				    }
					if(el.find('video').length!=0){
						if(el.find('video').attr('width')){
							el.css({
					            'width': el.find('video').attr('width')
					        });
						}
						if(el.find('video').attr('height')){
							el.css({
					            'height': el.find('video').attr('height')
					        });
						}

				    }
				});
				if(vc.frame_window.video_element) vc.frame_window.video_element(el);
				if(vc.frame_window.init_tilts) vc.frame_window.init_tilts(el);
				if(vc.frame_window.pix_section_stack) vc.frame_window.pix_section_stack(el);
			}
	    });
	}
})( window.jQuery );
