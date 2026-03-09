(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_alertblock = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
				let params = this.model.get( 'params' );
				params = window.pixVerifyWPBakeryIcons(params);
				this.model.save( 'params', params );
				params = this.model.get( 'params' );

				// this.updated();
                $('body').trigger('pixfortIconsParam');
	    		window.InlineShortcodeView_alertblock.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_alertblock: updated called.');
	    		window.InlineShortcodeView_alertblock.__super__.updated.call(this);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_alertblock: parentChanged called.');
	    		window.InlineShortcodeView_alertblock.__super__.parentChanged.call(this);
	    	}

	    });
	}
})( window.jQuery );