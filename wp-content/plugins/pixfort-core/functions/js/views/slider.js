(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_slider = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_test_element: render called.');
	    		window.InlineShortcodeView_pix_slider.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
	    		return this;
	    	},
	    	pix_update: function () {
	    		// var $i = this.model.settings; // shortcode settings from VC_MAP! also available in global variable "vc_mapper"
	    		// var str = '';
	    		// _.each($i, function (settings, key) {
	    		// 	var obj = {};
	    		// 	obj[key] = settings;
	    		// 	str += JSON.stringify(obj) + '<br>';
	    		// }, this);
	    		// jQuery('<div>Green background will be visible only in fronteditor mode and css is stored in assets/front_enqueue_iframe_css.css <br/><br/> This json styled info was created "on the fly" from available settings: <br/>' + str + '</div>').appendTo(this.$el);
	            var that = this;

				if(window.vc.frame_window.pix_sliders) window.vc.frame_window.pix_sliders();


	    	},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_slider.__super__.updated.call(this);
	            this.pix_update();
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_slider.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );
