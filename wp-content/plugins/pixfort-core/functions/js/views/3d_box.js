(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    window.InlineShortcodeView_pix_3d_box = window.InlineShortcodeView.extend({
	    	render: function () {
	    		window.InlineShortcodeView_pix_3d_box.__super__.render.call(this);
	            if(vc.frame_window.init_tilts) vc.frame_window.init_tilts(this.$el);
	    		return this;
	    	},
	    	updated: function () {
	    		window.InlineShortcodeView_pix_3d_box.__super__.updated.call(this);
	            if(vc.frame_window.init_tilts) vc.frame_window.init_tilts(this.$el);
	            return this;
	    	},
	    	parentChanged: function () {
	    		window.InlineShortcodeView_pix_3d_box.__super__.parentChanged.call(this);
	    	}
	    });
	}
})( window.jQuery );
