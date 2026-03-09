(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_marquee = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
				let params = this.model.get( 'params' );
				params = window.pixVerifyWPBakeryIcons(params, true, 'items', 'item_type');
				this.model.save( 'params', params );
				params = this.model.get( 'params' );
				

	    		window.InlineShortcodeView_pix_marquee.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				if(vc.frame_window.pix_marquee) vc.frame_window.pix_marquee(this.$el);	
	    		return this;
	    	},

	    	updated: function () {
	    		window.InlineShortcodeView_pix_marquee.__super__.updated.call(this);
				vc.frame_window.pix_marquee(this.$el);	
	            return this;
	    	},
	    	parentChanged: function () {
	    		window.InlineShortcodeView_pix_marquee.__super__.parentChanged.call(this);
				vc.frame_window.pix_marquee(this.$el);	
	    	}

	    });
	}

})( window.jQuery );
