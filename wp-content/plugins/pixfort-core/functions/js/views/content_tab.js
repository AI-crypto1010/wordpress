(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    window.InlineShortcodeView_pix_content_tab = window.InlineShortcodeViewContainer.extend({
	    	render: function () {
	    		window.InlineShortcodeView_pix_content_tab.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
	    		return this;
	    	},
	    	pix_update: function () {
				var that = this;
				this.update_tabs_btns();
	    	},
			update_tabs_btns: function(){
				let el = this.$el;
				vc.frame_window.pix_cb_fn(function(){
					let isPixfortIcons = true;
					if (!pixfort_icons_obj.isPixfortIcons || pixfort_icons_obj.isPixfortIcons === '') {
						isPixfortIcons = false;
					}
					let elem = el.closest('.pix_tabs_container');
						var contents = $(elem).find('.tab-pane');
						var i_pos_top = false;
						if($(elem).attr('data-icons-pos')){
							if($(elem).attr('data-icons-pos')=='top'){
								i_pos_top = true;
							}
						}
						var html = '';
						let first = true;
						contents.each(function(i, tab){
							var id = $(tab).data('id');
							var icon = $(tab).data('icon');
							var title = $(tab).data('title');
							var bold = $(tab).data('bold');
							var italic = $(tab).data('italic');
							var secondary = $(tab).data('secondary');
							var icon_html = '';
							if(!title&& !icon){
								title = id;
							}
							if (isPixfortIcons) {
								icon = window.pixverifyIconNameWPBakery(icon);
								if(icon && icon!=''){
									if(i_pos_top){
										icon_html = window.pixGetIconWPBakery(icon, 'w-100 d-block text-center mt-2');
									}else{
										icon_html = window.pixGetIconWPBakery(icon, 'mr-2');
									}
								}
							} else {	
								icon = window.pixverifyIconNameWPBakery(icon);
								if(icon && icon!=''){
									if(i_pos_top){
										icon_html = '<i class="w-100 '+icon+' d-block text-center mt-2"></i> ';
									}else{
										icon_html = '<i class="'+icon+' mr-2"></i> ';
									}
								}
							}
							if(i_pos_top){
								html += '<div class="nav-item"><a class="nav-link pix-tabs-btn pix-px-25 text-24 '+bold+' '+italic+' '+secondary+' py-2 mb-2" data-id="'+ id +'" id="pix-tab-btn-'+id+'" data-toggle="pill" href="#pix-tab-'+id+'" role="tab" aria-controls="pix-tab-'+id+'" aria-selected="true">'+ icon_html + title +'</a></div>';
							} else {
								html += '<div class="nav-item"><a class="nav-link pix-tabs-btn pix-px-25 text-24 '+bold+' '+italic+' '+secondary+' py-2 mb-2" data-id="'+ id +'" id="pix-tab-btn-'+id+'" data-toggle="pill" href="#pix-tab-'+id+'" role="tab" aria-controls="pix-tab-'+id+'" aria-selected="true"><span class="d-inline-flex align-items-center">'+ icon_html + title +'</span></a></div>';
							}
							if(first){
								$(tab).addClass('active');
								$(tab).parent().addClass('d-block').removeClass('d-none');
							}else{
								$(tab).removeClass('active');
								$(tab).parent().removeClass('d-block').addClass('d-none');
							}
							first = false;

						});
						$(elem).find('.pix_tabs_btns').html(html);
						$(elem).find('.pix_tabs_btns .nav-item:first-child a').addClass('active').tab('show');


					setTimeout(function(){
						// vc.frame_window.piximations.init();
						if(vc.frame_window.init_animated_heading) vc.frame_window.init_animated_heading();
					}, 100);
				});
			},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_content_tab.__super__.updated.call(this);
	            this.pix_update();
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_content_tab.__super__.parentChanged.call(this);
	    	},
			remove: function () {
				window.InlineShortcodeView_pix_content_tab.__super__.remove.call( this );
				this.pix_update();
			},
			removeView: function ( model ) {
				window.InlineShortcodeView_pix_content_tab.__super__.removeView.call( this, model );
				if ( this.parent_view && this.parent_view.removeTab ) {
					this.parent_view.removeTab( model );
				}
			},

	    });
	}

})( window.jQuery );
