(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_icon = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
				let params = this.model.get( 'params' );

				params = window.pixVerifyWPBakeryIcons(params, false, null, null, 'pix-icon');
				this.model.save( 'params', params );
				params = this.model.get( 'params' );
				
	            // console && console.log('InlineShortcodeView_pix_icon: render called.');
	    		window.InlineShortcodeView_pix_icon.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				this.$el.find('.pix-icon.d-inline-block').closest('.vc_element.vc_pix_icon').css({'display':'inline-block'});
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_icon: updated called.');
	    		window.InlineShortcodeView_pix_icon.__super__.updated.call(this);
				this.$el.find('.pix-icon.d-inline-block').closest('.vc_element.vc_pix_icon').css({'display':'inline-block'});

	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_icon: parentChanged called.');
	    		window.InlineShortcodeView_pix_icon.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );
