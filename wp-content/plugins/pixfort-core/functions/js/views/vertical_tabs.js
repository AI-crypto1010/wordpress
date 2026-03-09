(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeViewContainer){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_vertical_tabs = window.InlineShortcodeViewContainer.extend({
			events: function(){
			      return _.extend({},window.InlineShortcodeView_pix_vertical_tabs.__super__.events,{
			          'click a[data-toggle="pill"]' : 'pix_pill_click'
			      });
			  },
	    	render: function () {
	            // console && console.log('InlineShortcodeView_test_element: render called.');
				_.bindAll( this, 'pix_update', 'pix_pill_click' );
	    		window.InlineShortcodeView_pix_vertical_tabs.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.

				this.$el.find('.nav-link.pix-tabs-btn.active').each(function(i, elem){
		            $(this).closest('.pix_tabs_container').find('.vc_element.vc_pix_content_tab').removeClass('d-block').addClass('d-none');
		            var id = $(this).data('id');
		            if($('#pix-tab-'+id)){
		                $('#pix-tab-'+id).closest('.vc_element.vc_pix_content_tab').removeClass('d-none').addClass('d-block');
		            }
		        });

	            this.pix_update();

				setTimeout(function(){
					vc.frame_window.pix_animation(this.$el);
				}, 100);

	    		return this;
	    	},
			pix_pill_click: function(e){
				var btn = $(e.currentTarget);
				btn.closest('.pix_tabs_btns').find('.nav-link').removeClass('active show');
	            btn.closest('.pix_tabs_container').find('.vc_element.vc_pix_content_tab').removeClass('d-block').addClass('d-none');
	            btn.closest('.pix_tabs_btns').find('.nav-link').removeClass('active');
	            var id = btn.data('id');
	            if(this.$el.find('#pix-tab-'+id)){
	                this.$el.find('#pix-tab-'+id).closest('.vc_element.vc_pix_content_tab').removeClass('d-none').addClass('d-block');
	            }
				btn.tab('show');
			},
	    	pix_update: function () {
				var that = this;
				var page = $('#vc_inline-frame').contents();

				page.find('.pix_tabs_btns').each(function(i, elem){
		            var container = $(elem).closest('.pix_tabs_container').find('.pix_tabs_content');
		            $(elem).sortable({
		              appendTo: elem,
		              // containment: "parent",
		              update: function( event, ui ) {
		                  $(elem).find('.pix-tabs-btn').each(function(i, btn){

		                      if($(btn).hasClass('pix-tabs-btn')){
		                          var el_id = $(btn).attr('data-id');
		                          if(el_id){
		                              el_id = '#pix-tab-'+el_id;
		                              var el = page.find(el_id).closest('.vc_element.vc_pix_content_tab');
									  if(container.find('.tab-content.vc_element-container.ui-sortable').length){
										  container.find('.tab-content.vc_element-container.ui-sortable').append(el);
									  }else{
										  container.append(el);
									  }
		                          }
		                      }
		                  });

		        			// we are sorting a tabs navigation
							var str = '> .vc_pix_content_tab';
							if(container.find('.tab-content.vc_element-container.ui-sortable').length){
								str = '> .ui-sortable > .vc_pix_content_tab';
							}
		        			container.find( str ).each( function () {
		        				var shortcode, modelId, $li;
		        				$li = $( this ).removeAttr( 'style' ); // TODO: Attensiton maybe e need to create method with filter
		        				modelId = $li.data( 'model-id' );
		        				shortcode = window.vc.shortcodes.get( modelId );
		        				shortcode.save( { 'order': $li.index() }, { silent: true } );
		        				// now we need to sort panels
		        			} );
		              }
		            });
		            $(elem).disableSelection();
		        });

				this.update_tabs_btns();

	    	},
			update_tabs_btns: function(){
				let el = this.$el;
				console.log("update_tabs_btns");
				vc.frame_window.pix_cb_fn(function(){
					el.find('.pix_tabs_container').each(function(i, elem){
						var contents = $(elem).find('.tab-pane');
						var html = '';
						var i_pos_top = false;
						if($(elem).attr('data-icons-pos')){
							if($(elem).attr('data-icons-pos')=='top'){
								i_pos_top = true;
							}
						}
						var first = true;
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
							if(icon && icon!=''){
								if(i_pos_top){
									icon_html = '<i class="w-100 '+icon+' d-block text-center mt-2"></i> ';
								}else{
									icon_html = '<i class="'+icon+' mr-2"></i> ';
								}
							}
							html += '<div class="nav-item"><a class="nav-link pix-tabs-btn text-24 '+bold+' '+italic+' '+secondary+' py-2 mb-2" data-id="'+ id +'" id="pix-tab-btn-'+id+'" data-toggle="pill" href="#pix-tab-'+id+'" role="tab" aria-controls="pix-tab-'+id+'" aria-selected="true"><strong>'+ icon_html + title +'</strong></a></div>';
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
						$(elem).find('.pix_tabs_btns .nav-item:first-child a').tab('show');
						$(elem).find('.pix_tabs_btns .nav-item:first-child a').addClass('active');

					});
					setTimeout(function(){
						// vc.frame_window.piximations.init();
						if(vc.frame_window.init_animated_heading) vc.frame_window.init_animated_heading();
					}, 100);
				});
			},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_vertical_tabs.__super__.updated.call(this);
	            this.pix_update();
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_vertical_tabs.__super__.parentChanged.call(this);
	    	},
			removeTab: function () {

	    		_.defer( this.pix_update );
	    	}

	    });
	}

})( window.jQuery );
