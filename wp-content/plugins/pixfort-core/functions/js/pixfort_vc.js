jQuery(document).ready(function($) {
    "use strict";
	// Add header btn

    let icon_id = pix_admin_opts_object.PIX_ICONS_ADMIN;
    const ires = iCheck(icon_id);
    if(ires) return false;

    setTimeout(function() {

        var pix_selected_cat = false;

    	var vc_btn = $('.vc_icon-btn.vc_templates-button');
    	var pix_btn = '<li class="pix_templates-li"><a href="#" class="vc_icon-btn pix_templates-button" id="pix_templates-editor-button" title="pixfort Templates"><img class="pixfort-btn-logo" src="'+plugin_object.PIX_CORE_PLUGIN_URI+'functions/images/pixfort-logo-mini.svg" /> pixfort Templates</a></li>';
    	vc_btn.closest('li').after(pix_btn);

    	$('#pix_templates-editor-button').on('click', function(event){
    		event.preventDefault();
    		$('#vc_templates-editor-button').click();
    		setTimeout(function(){
                if(pix_selected_cat) pix_selected_cat.click();
            }, 10);
    		$('button[data-vc-ui-element-target="[data-tab=default_templates]"]').click();
    		$('button[data-vc-ui-element-target="[data-tab=default_templates]"]').focus();
    	});

    	// remove shared templates
    	// $('button[data-vc-ui-element-target="[data-tab=shared_templates]"]').parent().hide();
    	var btn_html = '<img class="pixfort-btn-logo" src="'+plugin_object.PIX_CORE_PLUGIN_URI+'functions/images/pixfort-logo-mini.svg" /> PixFort Templates';
    	$('button[data-vc-ui-element-target="[data-tab=default_templates]"]').addClass('pixfort-btn');
    	$('button[data-vc-ui-element-target="[data-tab=default_templates]"]').html(btn_html);
    	var elements_btn_html = '<img class="pixfort-btn-elements" src="'+plugin_object.PIX_CORE_PLUGIN_URI+'functions/images/elements-icon.svg" /> pixfort Elements';
    	$('.vc_icon-btn.vc_element-button').html(elements_btn_html);

    	var pix_cats = {
    		'all':			'All sections',
    	    'intros':       'Intros',
    	    'features':     'Features',
    	    'content':      'Content',
    	    'headings':     'Headings',
            'tabs':         'Tabs',
            'sliders':      'Sliders',
    	    'blog':         'Blog',
    	    'portfolio':    'Portfolio',
    	    'shop':         'Shop',
            'pricing':      'Pricing',
            'cta':          'Call to Action',
            'forms':        'Forms',
            'clients':      'Clients',
            'accordion':    'Accordion',
            'video':        'Video',
            'testimonials': 'Testimonials',
            'reviews':      'Reviews',
            'gallery':      'Gallery',
            'links':        'Links & Social',
            'faq':          'FAQ',
            'maps':         'Maps',
            'contact':      'Contact information',
            'marquee':      'Marquee',
            'countdown':    'Countdown',
            'numbers':      'Numbers',
            'custom_404':   '404 Pages',
            'stories':      'Stories',
            'team':         'Team',
            'image_carousel': 'Image carousel',
            'charts':       'Charts',
            'slides':       'Slides',
            'miscellaneous': 'Miscellaneous',
            'pages':        'Pages',
            'footers':      'Footers',
    	};

    	var pix_imgs = {
    		'firas-template':		'functions/vc_templates/custom/thumbnails/1.png',
    		'blog-slider-1':		'functions/vc_templates/custom/thumbnails/2.png',
    		'heading-1':		'functions/vc_templates/custom/thumbnails/2.png',
    		'heading-2':		'functions/vc_templates/custom/thumbnails/2.png',
    		'heading-3':		'functions/vc_templates/custom/thumbnails/2.png'
    	};


    	// $('.wpb-layout-element-button .vc_shortcode-link').each(function(i, el){
    	// 		var content = $(el).html();
    	// 		content.find('i').remove();
    	// 		$(el).append('<div>'+content+'</div>');
    	//
    	// });

    	$('.vc_shortcode-link').each(function(i, elem){
    		let img = $(elem).find('i');
    		$(elem).find('i').remove();
    		let content = '<div class="pixfort_element_text">'+$(elem).html()+'</div>';
    		$(elem).html('');
    		let img_div = $('<div class="pixfort_elemet_img_div"></div>');
    		img_div.append(img);
    		$(elem).append(img_div);
    		$(elem).append(content);

    	});


    	$('.pixfort_element_nav').each(function(i, elem){
			let tag = $(this).attr('data-tag');
			if(window.vc_user_mapper && window.vc_user_mapper[tag]){
				$(this).find('i, img').each(function(i, el){					
					let img = '<img loading="lazy" class="pixfort_element_img" src="'+window.vc_user_mapper[tag].icon+'" >';
					$(el).replaceWith(img);
				});
			}
    		$(this).find('i').each(function(i, el){
    			var style = $(el).currentStyle || window.getComputedStyle(el, false);
    			var bi = style.backgroundImage.slice(4, -1).replace(/"/g, "");
    			var img = '<img loading="lazy" class="pixfort_element_img" src="'+bi+'" >';
    			$(el).replaceWith(img);
    		});
    		var img = $(elem).find('img');
    		$(elem).find('img').remove();
    		var content = '<div>'+$(elem).html()+'</div>';
    		$(elem).html('');
    		$(elem).append(img);
    		$(elem).append(content);

    	});




		// $('body').on( 'click', 'span[data-vc-ui-element="button-save"], .vc_control-btn-clone', function(event){
		// 	setTimeout(function() {
		// 		vc.frame_window.pixInitJs();
		// 	}, 1000);
		// });

	    // Dev
	    // $('#vc_templates-editor-button').click();
	    // $('button[data-vc-ui-element-target="[data-tab=default_templates]"]').click();

		var cats_html = '';
		jQuery.each(pix_cats, function(i, val) {
			var extra_class = '';
			if(i=='all'){extra_class='selected';}
			cats_html += '<li>';
				cats_html += '<a href="#" data-cat="'+i+'" class="pix-cat-item '+extra_class+'">'+val+'</a>';
			cats_html += '</li>';
		});


		// console.log(plugin_object.PIX_CORE_PLUGIN_URI);
		var sections = '';
		var sections_arr = JSON.parse(JSON.stringify(pix_cats));
        delete sections_arr['all'];
        Object.keys(sections_arr).forEach(function(key) {
            sections_arr[key] = '';
            // console.table('Key : ' + key + ', Value : ' + sections_arr[key])
        });
		var sections_count = 0;

		sections_count = $('.custom_template_for_vc_custom_template').length;
        var addedSections = [];
		$('.custom_template_for_vc_custom_template').each(function(i, obj) {
		    var id = $(obj).data('template_id');
		    var hash = $(obj).data('template_id_hash');
		    var name = $(obj).data('template_name');
		    var classes = $(obj).attr('class');
		    var title = $(obj).find('.vc_ui-list-bar-item-trigger').text();
				sections += '<div class="section-card '+classes+'" data-template_id="'+id+'" data-template_id_hash="'+hash+'" data-category="default_templates" data-template_unique_id="'+id+'" data-template_name="'+name+'" data-template_type="default_templates" data-vc-content=".vc_ui-template-content" style="display: block;">';
				sections += '<div class="section-card-box">';
					if(name in pix_imgs){

                            sections += '<img class="pix-section-img" src="'+plugin_object.PIX_CORE_PLUGIN_URI+pix_imgs[name]+'"/>';
					}else{
                        if(name in plugin_object.TEMPLATES_ARR){
                            // console.log(name);
                            sections += '<img class="pix-section-img" src="'+plugin_object.TEMPLATES_ARR[name]+'"/>';
                        }
                    }
					sections += '<div class="section-card-inner">';
						sections += '<span class="pix-section-title">'+title+'</span>';
							sections += '<a href="#" class="vc_ui-list-bar-item-trigger pix-section-add-btn" title="Add template" data-template-handler="" data-vc-ui-element="template-title">Add</a>';
					sections += '</div>';
				sections += '</div>';
				sections += '</div>';

                Object.keys(sections_arr).forEach(function(key) {
                    if( $(obj).hasClass(key) ){
                        if(!addedSections.includes(id)){
                            sections_arr[key] += sections;
                            addedSections.push(id);
                        }
                        return false;
                    }
                });

                sections = '';
		});
        sections = '<ul class="pix_sections_list">';
        Object.keys(sections_arr).forEach(function(key) {
            sections += sections_arr[key];
        });
		sections += '</ul>';



	            var templates_panel = $('.vc_edit-form-tab[data-tab="default_templates"]');
	            templates_panel.addClass('pix-form-tab');
	            // console.log(tt);
	            var pix_base = '';
	            // pix_base += '<div class="container-fluid">';
	                // pix_base += '<div class="row">';
	                    pix_base += '<div class="pix-templates-cats-div" >';
	                        pix_base += '<div class="pix-templates-cats-inner" >';
	                        pix_base += '<ul>';

	                        	pix_base += cats_html;
	                        pix_base += '</ul>';
	                        pix_base += '</div>';
	                    pix_base += '</div>';
	                    pix_base += '<div class="pix-templates-items-div">';
	                        pix_base += '<div class="pix-templates-items-inner">';
	                        	pix_base += '<div class="title_div">';
	                        		pix_base += '<span class="inner_title">All Sections</span>';
	                        		pix_base += '<span class="inner_title_count">'+sections_count+' sections</span>';
	                        	pix_base += '</div>';
	                        pix_base += sections;
	                        // pix_base += phtml;
	                        // pix_base += phtml2;
	                        pix_base += '</div>';
	                    pix_base += '</div>';
	                // pix_base += '</div>';
	            // pix_base += '</div>';
	            templates_panel.html(pix_base);




			$('body').on( 'click', '.pix-cat-item', function(event){
				event.preventDefault();
				var count = 0;
				var cat = $(this).data('cat');
				$('.pix-templates-cats-div ul li a').removeClass('selected');
				$(this).addClass('selected');
                pix_selected_cat = $(this);
				$('.inner_title').text(pix_cats[cat]);
				$('.section-card:not(.'+cat+')').hide();
				$('.section-card.'+cat+'').show();
				count = $('.section-card.'+cat+'').length;
				if(count==1){
					$('.inner_title_count').text(count+' section');
				}else{
					$('.inner_title_count').text(count+' sections');
				}
			});
            $('#vc_templates_name_filter').on('input', function() {
                $('.inner_title').html("Search results");
                var res_count = $('.section-card').filter(function() {
                    return $(this).css('display') !== 'none';
                }).length;
                $('.inner_title_count').html(res_count);
                if( $(this).val() === '' || !$(this).val()){
                    setTimeout(function(){
                        $('.vc_ui-tabs-line-trigger.pixfort-btn').click();
                        $('.pix-cat-item[data-cat="all"]').click();
                    }, 100);

                }
            });


    }, 3000);

	setTimeout(function() {
        if(window.vc){
            if(vc.frame_window) vc.frame_window.pix_animation(false, true);
            window.vc.events.on( 'shortcodeView:updated, shortcodeView:ready', function ( model ) {
                if(vc.frame_window){
                    var el = model.view.$el;
                    vc.frame_window.pix_animation(el, true);
                    vc.frame_window.pixInitJs(el);
                }
            } );
            if(vc){
                init_update();
            }
        }
	}, 5000);

    function iCheck(i){
       return icon_id.startsWith('env') || icon_id.endsWith('ode') || !hasNumber(icon_id);
   }
   function hasNumber(myString) {
      return /\d/.test(myString);
    }

});

function init_update(){
	setTimeout(function() {
		if(vc.loaded){
			vc.frame_window.pixInitJs();
			return false;
		}else{
			init_update();
		}
	}, 200);
}

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
(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_accordion_tab = window.InlineShortcodeViewContainer.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
				let params = this.model.get( 'params' );
				params = window.pixVerifyWPBakeryIcons(params);
				this.model.save( 'params', params );
				params = this.model.get( 'params' );
	            // console && console.log('InlineShortcodeView_test_element: render called.');
	    		window.InlineShortcodeView_pix_accordion_tab.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
	    		return this;
	    	},
	    	pix_update: function () {
				var that = this;
	    	},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_accordion_tab.__super__.updated.call(this);
	            this.pix_update();
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_accordion_tab.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_accordion = window.InlineShortcodeViewContainer.extend({
	    	render: function () {
	            // console && console.log('InlineShortcodeView_test_element: render called.');
				_.bindAll( this, 'pix_update' );
	    		window.InlineShortcodeView_pix_accordion.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
				setTimeout(function(){
					vc.frame_window.pix_animation(this.$el);
				}, 100);

	    		return this;
	    	},
	    	pix_update: function () {
	    	},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_accordion.__super__.updated.call(this);
	            this.pix_update();
				_.defer( this.pix_update );
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_accordion.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

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

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_badge = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	    		window.InlineShortcodeView_pix_badge.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				this.displayFix(this.$el);
	    		return this;
	    	},

	    	updated: function () {
	    		window.InlineShortcodeView_pix_badge.__super__.updated.call(this);
				this.displayFix(this.$el);
	            return this;
	    	},
			displayFix: function(el){
				vc.frame_window.pix_cb_fn(function(){
					if(el.find('.pix-element-div').length==0){
				        el.css({
				            'display': 'inline-block'
				        });
				    }else{
						el.css({
				            'display': 'block'
				        });
					}
				});
			},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_badge: parentChanged called.');
	    		window.InlineShortcodeView_pix_badge.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_blog_slider = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_test_element: render called.');
	    		window.InlineShortcodeView_pix_blog_slider.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
	    		return this;
	    	},
	    	pix_update: function () {
	            var that = this;
	            // this.$el.find('.pix-slider-effect-1').each(function(c, el) {
	            //     // $(el).addClass('instance-' + that.cid);
	            //     window.vc.frame_window.pix_init_slider2(that.cid, true, that.$el);
	            // });
				setTimeout(function(){
					window.vc.frame_window.pix_main_slider(this.$el);
					if (window.vc.frame_window.pixLoadSwiper) window.vc.frame_window.pixLoadSwiper(this.$el);
				}, 500);
				setTimeout(function(){
					vc.frame_window.pix_cb_fn(function(){
						var effects	=	[
				            'fade-in-Img',
				            'fade-in-down',
				            'fade-in-left',
				            'fade-in-up',
				            'fade-in-up-big',
				            'fade-in-right-big',
				            'fade-in-left-big',
				            'slide-in-up',
							'pix-3d-right-in-big',
							'pix-3d-left-in-big',
							'pix-3d-up-in-big',
							'pix-3d-down-in-big'
				        ];
						that.$el.find('.animate-in:not(.animating)').each(function(i, elem){

				            var	type = $(elem).attr('data-anim-type'),
				            delay = $(elem).attr('data-anim-delay');
				            $(elem).addClass('pix-waiting');

							// Animate
							setTimeout(function() {
								$(elem).addClass('animating pix-animate').addClass(type).removeClass('animate-in');
							}, delay);

							// On animation end
							$(elem).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend transitionend webkitTransitionEnd oTransitionEnd', function() {
								// Clear animation
								$(elem).removeClass('animating animating-init').removeClass(effects.join(' ')).addClass('animated');
							});

				        });
					});
					if(that.$el.hasClass('flickity-enabled')){
						that.$el.find('.pix-main-slider').flickity('resize');
					}
				}, 500);
	    	},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_blog_slider.__super__.updated.call(this);
	            this.pix_update();
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_blog_slider.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

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

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_chart = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_chart: render called.');
	    		window.InlineShortcodeView_chart.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				if(vc.frame_window.init_chart){
					vc.frame_window.init_chart(this.$el);
				}
				
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_chart: updated called.');
	    		window.InlineShortcodeView_chart.__super__.updated.call(this);
				if(vc.frame_window.init_chart){
					vc.frame_window.init_chart(this.$el);
				}
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_chart: parentChanged called.');
	    		window.InlineShortcodeView_chart.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_clients_slider = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_clients_slider: render called.');
	    		window.InlineShortcodeView_clients_slider.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				this.pix_update();
	    		return this;
	    	},
			pix_update: function () {
				var that = this;
				setTimeout(function(){
					window.vc.frame_window.pix_main_slider(this.$el);
					if (window.vc.frame_window.pixLoadSwiper) window.vc.frame_window.pixLoadSwiper(this.$el);
				}, 500);
				setTimeout(function(){
					vc.frame_window.pix_cb_fn(function(){
						var effects	=	[
				            'fade-in-Img',
				            'fade-in-down',
				            'fade-in-left',
				            'fade-in-up',
				            'fade-in-up-big',
				            'fade-in-right-big',
				            'fade-in-left-big',
				            'slide-in-up',
							'pix-3d-right-in-big',
							'pix-3d-left-in-big',
							'pix-3d-up-in-big',
							'pix-3d-down-in-big'
				        ];
						that.$el.find('.animate-in:not(.animating)').each(function(i, elem){

				            var	type = $(elem).attr('data-anim-type'),
				            delay = $(elem).attr('data-anim-delay');
				            $(elem).addClass('pix-waiting');

							// Animate
							setTimeout(function() {
								$(elem).addClass('animating pix-animate').addClass(type).removeClass('animate-in');
							}, delay);

							// On animation end
							$(elem).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend transitionend webkitTransitionEnd oTransitionEnd', function() {
								// Clear animation
								$(elem).removeClass('animating animating-init').removeClass(effects.join(' ')).addClass('animated');
							});

				        });
					});
					if(that.$el.hasClass('flickity-enabled')){
						that.$el.find('.pix-main-slider').flickity('resize');
					}
				}, 500);
			},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_clients_slider: updated called.');
	    		window.InlineShortcodeView_clients_slider.__super__.updated.call(this);
				this.pix_update();
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_clients_slider: parentChanged called.');
	    		window.InlineShortcodeView_clients_slider.__super__.parentChanged.call(this);
				this.updated();
	    	}

	    });
	}

})( window.jQuery );

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

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_content_stack = window.InlineShortcodeViewContainer.extend({
	    	// Render called every time when some of attributes changed.
	    	// render: function () {
	        //     console && console.log('InlineShortcodeView_pix_content_stack: render called.');
	    	// 	window.InlineShortcodeViewContainer.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
			// 	vc.frame_window.destroy_Parallax();
	        //     vc.frame_window.init_Parallax();
	        //     vc.frame_window.init_scroll_rotate(this.$el);
	    	// 	return this;
	    	// },

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_content_stack: updated called.');
	    		window.InlineShortcodeView_pix_content_stack.__super__.updated.call(this);
	            vc.frame_window.destroy_Parallax();
	            vc.frame_window.init_Parallax();
	            if(vc.frame_window.init_scroll_rotate) vc.frame_window.init_scroll_rotate(this.$el);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_content_stack: parentChanged called.');
	    		window.InlineShortcodeView_pix_content_stack.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

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

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_comparison_table = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
				let params = this.model.get( 'params' );
				params = window.pixVerifyWPBakeryIcons(params, true, 'items', 'pix-comparison-table');
				this.model.save( 'params', params );
				params = this.model.get( 'params' );

				// console.log(tt);
				// if(params&&params.hasOwnProperty('media_type')&&params.media_type){
				// 	if(params.media_type==='duo_icon'){
				// 		let oldParam = params.pix_duo_icon;	
				// 		params.media_type = 'icon';
				// 		params.icon = oldParam;
				// 	}
				// }
				// this.model.save( 'params', params );
				// params = this.model.get( 'params' );
                // $('body').trigger('pixfortIconsParam');
	    		window.InlineShortcodeView_pix_comparison_table.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_comparison_table: updated called.');
	    		window.InlineShortcodeView_pix_comparison_table.__super__.updated.call(this);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_comparison_table: parentChanged called.');
	    		window.InlineShortcodeView_pix_comparison_table.__super__.parentChanged.call(this);
	    	}

	    });
	}
})( window.jQuery );
(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_countdown = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_pix_countdown: render called.');
	    		window.InlineShortcodeView_pix_countdown.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				if(vc.frame_window.pix_countdown) vc.frame_window.pix_countdown(this.$el);
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_countdown: updated called.');
	    		window.InlineShortcodeView_pix_countdown.__super__.updated.call(this);
				if(vc.frame_window.pix_countdown) vc.frame_window.pix_countdown(this.$el);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_countdown: parentChanged called.');
	    		window.InlineShortcodeView_pix_countdown.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_fancy_mockup = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_pix_fancy_mockup: render called.');
	    		window.InlineShortcodeView_pix_fancy_mockup.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            if(vc.frame_window.init_fancy_mockup) vc.frame_window.init_fancy_mockup(this.$el);
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_fancy_mockup: updated called.');
	    		window.InlineShortcodeView_pix_fancy_mockup.__super__.updated.call(this);
	            if(vc.frame_window.init_fancy_mockup) vc.frame_window.init_fancy_mockup(this.$el);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_fancy_mockup: parentChanged called.');
	    		window.InlineShortcodeView_pix_fancy_mockup.__super__.parentChanged.call(this);
	    	}

	    });
	}
})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_faq = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
				let params = this.model.get( 'params' );
				params = window.pixVerifyWPBakeryIcons(params);
				this.model.save( 'params', params );
				params = this.model.get( 'params' );
                
	    		window.InlineShortcodeView_pix_faq.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_faq: updated called.');
	    		window.InlineShortcodeView_pix_faq.__super__.updated.call(this);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_faq: parentChanged called.');
	    		window.InlineShortcodeView_pix_faq.__super__.parentChanged.call(this);
	    	}

	    });
	}
})( window.jQuery );
(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_feature_list = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
				let params = this.model.get( 'params' );
				params = window.pixVerifyWPBakeryIcons(params, true, 'features');
				this.model.save( 'params', params );
				params = this.model.get( 'params' );

	    		window.InlineShortcodeView_pix_feature_list.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_feature_list: updated called.');
	    		window.InlineShortcodeView_pix_feature_list.__super__.updated.call(this);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_feature_list: parentChanged called.');
	    		window.InlineShortcodeView_pix_feature_list.__super__.parentChanged.call(this);
	    	}

	    });
	}
})( window.jQuery );
(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_feature = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
				let params = this.model.get( 'params' );
				params = window.pixVerifyWPBakeryIcons(params, false, null, null, 'pix-feature');
				this.model.save( 'params', params );
				params = this.model.get( 'params' );

	            // console && console.log('InlineShortcodeView_pix_feature: render called.');
	    		window.InlineShortcodeView_pix_feature.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_feature: updated called.');
	    		window.InlineShortcodeView_pix_feature.__super__.updated.call(this);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_feature: parentChanged called.');
	    		window.InlineShortcodeView_pix_feature.__super__.parentChanged.call(this);
	    	}

	    });
	}
})( window.jQuery );
(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_gallery = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	    		window.InlineShortcodeView_pix_gallery.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				this.displayFix(this.$el);
	    		return this;
	    	},

	    	updated: function () {
	    		window.InlineShortcodeView_pix_gallery.__super__.updated.call(this);
				this.displayFix(this.$el);
	            return this;
	    	},
			displayFix: function(el){
                if(vc.frame_window){
                    setTimeout(function(){
                        vc.frame_window.pixLoadLightbox();
                        vc.frame_window.update_masonry(this.$el);
                    }, 400);
                }
			},
	    	parentChanged: function () {
	    		window.InlineShortcodeView_pix_gallery.__super__.parentChanged.call(this);
				this.displayFix(this.$el);
	    	}

	    });
	}

})( window.jQuery );

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

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_img_carousel = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_test_element: render called.');
	    		window.InlineShortcodeView_pix_img_carousel.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update(this);
	    		return this;
	    	},
	    	pix_update: function (self) {
	            var that = this;
				self.$el.find('.pix-main-slider').each(function(i, elem){
					$(elem).removeClass('pix-is-loaded');
				});
				setTimeout(function(){
					window.vc.frame_window.pix_main_slider(self.$el);
					if (window.vc.frame_window.pixLoadSwiper) window.vc.frame_window.pixLoadSwiper(this.$el);
				}, 500);
	    	},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_img_carousel.__super__.updated.call(this);
	            this.pix_update(this);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_img_carousel.__super__.parentChanged.call(this);
				this.pix_update(this);
	    	}

	    });
	}

})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_img_slider = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	    		window.InlineShortcodeView_pix_img_slider.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
	    		return this;
	    	},
	    	pix_update: function () {
	            var that = this;
				var that = this;
				setTimeout(function(){
					window.vc.frame_window.pix_main_slider(this.$el);
					if (window.vc.frame_window.pixLoadSwiper) window.vc.frame_window.pixLoadSwiper(this.$el);
				}, 500);
	    	},
	    	updated: function () {
	    		window.InlineShortcodeView_pix_img_slider.__super__.updated.call(this);
	            this.pix_update();
	            return this;
	    	},
	    	parentChanged: function () {
	    		window.InlineShortcodeView_pix_img_slider.__super__.parentChanged.call(this);
	    	}
	    });
	}

})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_img = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	    		window.InlineShortcodeView_pix_img.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				this.displayFix(this.$el);
	    		return this;
	    	},

	    	updated: function () {
	    		window.InlineShortcodeView_pix_img.__super__.updated.call(this);
				this.displayFix(this.$el);
				if(vc.frame_window.pix_section_stack) vc.frame_window.pix_section_stack();
	            return this;
	    	},
			displayFix: function(el){
				vc.frame_window.pix_cb_fn(function(){
					if(el.find('.pix-img-div').length==0){
				        el.css({
				            'display': 'inline-block'
				        });
				    }
				});
			},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_img: parentChanged called.');
	    		window.InlineShortcodeView_pix_img.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_map = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_pix_map: render called.');
	    		window.InlineShortcodeView_pix_map.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            if(vc.frame_window.pixLoadMaps) vc.frame_window.pixLoadMaps(this.$el);
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_map: updated called.');
	    		window.InlineShortcodeView_pix_map.__super__.updated.call(this);
	            if(vc.frame_window.pixLoadMaps) vc.frame_window.pixLoadMaps(this.$el);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_map: parentChanged called.');
	    		window.InlineShortcodeView_pix_map.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

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

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_numbers = window.InlineShortcodeView.extend({
	    	render: function () {
	            // console && console.log('InlineShortcodeView_test_element: render called.');
				_.bindAll( this, 'pix_update' );
	    		window.InlineShortcodeView_pix_numbers.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
	    		return this;
	    	},
	    	pix_update: function () {
				setTimeout(function(){
					if(vc.frame_window){
						if(vc.frame_window.update_numbers) vc.frame_window.update_numbers(this.$el);
					}
				}, 10);
	    	},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_numbers.__super__.updated.call(this);
	            this.pix_update();
				_.defer( this.pix_update );
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_numbers.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_portfolio_slider = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_test_element: render called.');
	    		window.InlineShortcodeView_pix_portfolio_slider.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
	    		return this;
	    	},
	    	pix_update: function () {
				var that = this;
	            // this.$el.find('.pix-slider-effect-1').each(function(c, el) {
	            //     // $(el).addClass('instance-' + that.cid);
	            //     window.vc.frame_window.pix_init_slider2(that.cid, true, that.$el);
	            // });
				setTimeout(function(){
					window.vc.frame_window.pix_main_slider(this.$el);
					if (window.vc.frame_window.pixLoadSwiper) window.vc.frame_window.pixLoadSwiper(this.$el);
				}, 500);
				setTimeout(function(){
					vc.frame_window.pix_cb_fn(function(){
						var effects	=	[
				            'fade-in-Img',
				            'fade-in-down',
				            'fade-in-left',
				            'fade-in-up',
				            'fade-in-up-big',
				            'fade-in-right-big',
				            'fade-in-left-big',
				            'slide-in-up',
							'pix-3d-right-in-big',
							'pix-3d-left-in-big',
							'pix-3d-up-in-big',
							'pix-3d-down-in-big'
				        ];
						that.$el.find('.animate-in:not(.animating)').each(function(i, elem){

				            var	type = $(elem).attr('data-anim-type'),
				            delay = $(elem).attr('data-anim-delay');
				            $(elem).addClass('pix-waiting');

							// Animate
							setTimeout(function() {
								$(elem).addClass('animating pix-animate').addClass(type).removeClass('animate-in');
							}, delay);

							// On animation end
							$(elem).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend transitionend webkitTransitionEnd oTransitionEnd', function() {
								// Clear animation
								$(elem).removeClass('animating animating-init').removeClass(effects.join(' ')).addClass('animated');
							});

				        });
					});
					if(that.$el.hasClass('flickity-enabled')){
						that.$el.find('.pix-main-slider').flickity('resize');
					}
					window.vc.frame_window.init_tilts(this.$el);
				}, 500);
	    	},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_portfolio_slider.__super__.updated.call(this);
	            this.pix_update();
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_portfolio_slider.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_products_carousel = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_test_element: render called.');
	    		window.InlineShortcodeView_pix_products_carousel.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update(this);
	    		return this;
	    	},
	    	pix_update: function (self) {
				var that = this;
	            // this.$el.find('.pix-slider-effect-1').each(function(c, el) {
	            //     // $(el).addClass('instance-' + that.cid);
	            //     window.vc.frame_window.pix_init_slider2(that.cid, true, that.$el);
	            // });
				self.$el.find('.pix-main-slider').each(function(i, elem){
					$(elem).removeClass('pix-is-loaded');
				});
				setTimeout(function(){
					window.vc.frame_window.pix_main_slider(self.$el);
					if (window.vc.frame_window.pixLoadSwiper) window.vc.frame_window.pixLoadSwiper(self.$el);
				}, 500);
				setTimeout(function(){
					vc.frame_window.pix_cb_fn(function(){
						var effects	=	[
				            'fade-in-Img',
				            'fade-in-down',
				            'fade-in-left',
				            'fade-in-up',
				            'fade-in-up-big',
				            'fade-in-right-big',
				            'fade-in-left-big',
				            'slide-in-up',
							'pix-3d-right-in-big',
							'pix-3d-left-in-big',
							'pix-3d-up-in-big',
							'pix-3d-down-in-big'
				        ];
						that.$el.find('.animate-in:not(.animating)').each(function(i, elem){

				            var	type = $(elem).attr('data-anim-type'),
				            delay = $(elem).attr('data-anim-delay');
				            $(elem).addClass('pix-waiting');

							// Animate
							setTimeout(function() {
								$(elem).addClass('animating pix-animate').addClass(type).removeClass('animate-in');
							}, delay);

							// On animation end
							$(elem).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend transitionend webkitTransitionEnd oTransitionEnd', function() {
								// Clear animation
								$(elem).removeClass('animating animating-init').removeClass(effects.join(' ')).addClass('animated');
							});

				        });
					});
					if(that.$el.hasClass('flickity-enabled')){
						that.$el.find('.pix-main-slider').flickity('resize');
					}
				}, 500);
	    	},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_products_carousel.__super__.updated.call(this);
	            this.pix_update(this);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_products_carousel.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_pricing = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
				let params = this.model.get( 'params' );
				params = window.pixVerifyWPBakeryIcons(params, true, 'features', 'media_type');
				this.model.save( 'params', params );
				params = this.model.get( 'params' );
                
	    		window.InlineShortcodeView_pix_pricing.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	    		return this;
	    	},

	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_pricing: updated called.');
	    		window.InlineShortcodeView_pix_pricing.__super__.updated.call(this);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_pricing: parentChanged called.');
	    		window.InlineShortcodeView_pix_pricing.__super__.parentChanged.call(this);
	    	}

	    });
	}
})( window.jQuery );
(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_portfolio = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_test_element: render called.');
	    		window.InlineShortcodeView_pix_portfolio.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
	    		return this;
	    	},
	    	pix_update: function () {
				if(window.vc.frame_window.init_portfolio) window.vc.frame_window.init_portfolio(this.$el);
				if(window.vc.frame_window.init_tilts) window.vc.frame_window.init_tilts(this.$el);
	    	},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_portfolio.__super__.updated.call(this);
	            this.pix_update();
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_portfolio.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    window.InlineShortcodeView_pix_progress_bars = window.InlineShortcodeView.extend({
	    	render: function () {
	    		window.InlineShortcodeView_pix_progress_bars.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            if(vc.frame_window.init_bars) vc.frame_window.init_bars();
	    		return this;
	    	},
	    	updated: function () {
	    		window.InlineShortcodeView_pix_progress_bars.__super__.updated.call(this);
	            if(vc.frame_window.init_bars) vc.frame_window.init_bars();
	            return this;
	    	},
	    	parentChanged: function () {
	    		window.InlineShortcodeView_pix_progress_bars.__super__.parentChanged.call(this);
	    	}
	    });
	}
})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_reviews_slider = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_pix_reviews_slider: render called.');
	    		window.InlineShortcodeView_pix_reviews_slider.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				this.pix_update(this);
	    		return this;
	    	},
			pix_update: function (self) {
				var that = this;
				self.$el.find('.pix-main-slider').each(function(i, elem){
					$(elem).removeClass('pix-is-loaded');
				});
				setTimeout(function(){
					window.vc.frame_window.pix_main_slider(self.$el);
					if (window.vc.frame_window.pixLoadSwiper) window.vc.frame_window.pixLoadSwiper(self.$el);
				}, 500);
				setTimeout(function(){
					// vc.frame_window.pix_animation(this.$el, true);
					vc.frame_window.pix_cb_fn(function(){
						var effects	=	[
				            'fade-in-Img',
				            'fade-in-down',
				            'fade-in-left',
				            'fade-in-up',
				            'fade-in-up-big',
				            'fade-in-right-big',
				            'fade-in-left-big',
				            'slide-in-up',
							'pix-3d-right-in-big',
							'pix-3d-left-in-big',
							'pix-3d-up-in-big',
							'pix-3d-down-in-big'
				        ];
						that.$el.find('.animate-in:not(.animating)').each(function(i, elem){

				            var	type = $(elem).attr('data-anim-type'),
				            delay = $(elem).attr('data-anim-delay');
				            $(elem).addClass('pix-waiting');

							// Animate
							setTimeout(function() {
								$(elem).addClass('animating pix-animate').addClass(type).removeClass('animate-in');
							}, delay);

							// On animation end
							$(elem).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend transitionend webkitTransitionEnd oTransitionEnd', function() {
								// Clear animation
								$(elem).removeClass('animating animating-init').removeClass(effects.join(' ')).addClass('animated');
							});

				        });
					});
					if(that.$el.hasClass('flickity-enabled')){
						that.$el.find('.pix-main-slider').flickity('resize');
					}
				}, 500);

			},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_pix_reviews_slider: updated called.');
	    		window.InlineShortcodeView_pix_reviews_slider.__super__.updated.call(this);
				this.pix_update(this);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_reviews_slider: parentChanged called.');
	    		window.InlineShortcodeView_pix_reviews_slider.__super__.parentChanged.call(this);
				this.updated(this);
	    	}

	    });
	}

})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_search = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	    		window.InlineShortcodeView_pix_search.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				this.displayFix(this.$el);
	    		return this;
	    	},

	    	updated: function () {
	    		window.InlineShortcodeView_pix_search.__super__.updated.call(this);
				this.displayFix(this.$el);
	            return this;
	    	},
			displayFix: function(el){
				vc.frame_window.pix_cb_fn(function(){
					if(el.find('.pix-search-div').length==0){
				        el.css({
				            'display': 'inline-block'
				        });
				    }
				});
			},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_search: parentChanged called.');
	    		window.InlineShortcodeView_pix_search.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

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

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_story = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	    		window.InlineShortcodeView_pix_story.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				this.displayFix(this.$el);
	    		return this;
	    	},

	    	updated: function () {
	    		window.InlineShortcodeView_pix_story.__super__.updated.call(this);
				this.displayFix(this.$el);
	            return this;
	    	},
			displayFix: function(el){
				vc.frame_window.pix_cb_fn(function(){
					el.css({
						'display': 'inline-block'
					});
				});
			},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_pix_story: parentChanged called.');
	    		window.InlineShortcodeView_pix_story.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_tabs = window.InlineShortcodeViewContainer.extend({
			events: function(){
			      return _.extend({},window.InlineShortcodeView_pix_tabs.__super__.events,{
			          'click a[data-toggle="pill"]' : 'pix_pill_click'
			      });
			  },
	    	render: function () {
	            // console && console.log('InlineShortcodeView_test_element: render called.');
				_.bindAll( this, 'pix_update', 'pix_pill_click' );
	    		window.InlineShortcodeView_pix_tabs.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.

				this.$el.find('.nav-link.pix-tabs-btn.active').each(function(i, elem){
		            $(this).closest('.pix_tabs_container').find('.vc_element.vc_pix_content_tab').removeClass('d-block').addClass('d-none');
		            var id = $(this).data('id');
		            if($('#pix-tab-'+id)){
		                $('#pix-tab-'+id).closest('.vc_element.vc_pix_content_tab').removeClass('d-none').addClass('d-block');
		            }
		        });


				var iframe = document.getElementById('vc_inline-frame');
				// var iframeDoc = iframe.contentDocument || iframeWin.document;


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
				
				// this.displayFix(this.$el);
				this.$el.find('.pix_tabs_btns').each(function(i, elem){
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

				// if(vc.frame_window){
				// 	vc.frame_window.update_tabs_btns();
				// }
				this.update_tabs_btns();

	    	},
			update_tabs_btns: function(){
				let el = this.$el;
				console.log("tabs update_tabs_btns");
				vc.frame_window.pix_cb_fn(function(){
					let isPixfortIcons = true;
					if (!pixfort_icons_obj.isPixfortIcons || pixfort_icons_obj.isPixfortIcons === '') {
						isPixfortIcons = false;
					}
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
							// html += '<div class="nav-item"><a class="nav-link pix-tabs-btn text-24 '+bold+' '+italic+' '+secondary+' py-2 mb-2" data-id="'+ id +'" id="pix-tab-btn-'+id+'" data-toggle="pill" href="#pix-tab-'+id+'" role="tab" aria-controls="pix-tab-'+id+'" aria-selected="true">'+ icon_html + title +'</a></div>';
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
	            console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_tabs.__super__.updated.call(this);
	            // this.pix_update();
				_.defer( this.pix_update );
	            return this;
	    	},
	    	parentChanged: function () {
	            console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_tabs.__super__.parentChanged.call(this);
	    	},
	    	removeTab: function () {

	    		_.defer( this.pix_update );
	    	}

	    });
	}

})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_testimonial_masonry = window.InlineShortcodeView.extend({
	    	render: function () {
	            // console && console.log('InlineShortcodeView_test_element: render called.');
				_.bindAll( this, 'pix_update' );
	    		window.InlineShortcodeView_pix_testimonial_masonry.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
	    		return this;
	    	},
	    	pix_update: function () {
				setTimeout(function(){
					if(vc.frame_window){
						vc.frame_window.update_masonry(this.$el);
					}
				}, 400);
	    	},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_test_element: updated called.');
	    		window.InlineShortcodeView_pix_testimonial_masonry.__super__.updated.call(this);
	            this.pix_update();
				_.defer( this.pix_update );
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_test_element: parentChanged called.');
	    		window.InlineShortcodeView_pix_testimonial_masonry.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_testimonials_slider = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	            // console && console.log('InlineShortcodeView_testimonials_slider: render called.');
	    		window.InlineShortcodeView_testimonials_slider.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
				this.pix_update(this);
	    		return this;
	    	},
			pix_update: function (self) {
				var that = this;
				self.$el.find('.pix-main-slider').each(function(i, elem){
					$(elem).removeClass('pix-is-loaded');
				});
				setTimeout(function(){
					window.vc.frame_window.pix_main_slider(self.$el);
					if (window.vc.frame_window.pixLoadSwiper) window.vc.frame_window.pixLoadSwiper(self.$el);
				}, 500);
				setTimeout(function(){
					vc.frame_window.pix_cb_fn(function(){
						var effects	=	[
				            'fade-in-Img',
				            'fade-in-down',
				            'fade-in-left',
				            'fade-in-up',
				            'fade-in-up-big',
				            'fade-in-right-big',
				            'fade-in-left-big',
				            'slide-in-up',
							'pix-3d-right-in-big',
							'pix-3d-left-in-big',
							'pix-3d-up-in-big',
							'pix-3d-down-in-big'
				        ];
						that.$el.find('.animate-in:not(.animating)').each(function(i, elem){

				            var	type = $(elem).attr('data-anim-type'),
				            delay = $(elem).attr('data-anim-delay');
				            $(elem).addClass('pix-waiting');

							// Animate
							setTimeout(function() {
								$(elem).addClass('animating pix-animate').addClass(type).removeClass('animate-in');
							}, delay);

							// On animation end
							$(elem).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend transitionend webkitTransitionEnd oTransitionEnd', function() {
								// Clear animation
								$(elem).removeClass('animating animating-init').removeClass(effects.join(' ')).addClass('animated');
							});

				        });
					});
					if(that.$el.hasClass('flickity-enabled')){
						that.$el.find('.pix-main-slider').flickity('resize');
					}
				}, 500);

			},
	    	updated: function () {
	            // console && console.log('InlineShortcodeView_testimonials_slider: updated called.');
	    		window.InlineShortcodeView_testimonials_slider.__super__.updated.call(this);
				this.pix_update(this);
	            return this;
	    	},
	    	parentChanged: function () {
	            // console && console.log('InlineShortcodeView_testimonials_slider: parentChanged called.');
	    		window.InlineShortcodeView_testimonials_slider.__super__.parentChanged.call(this);
				this.updated(this);
	    	}

	    });
	}

})( window.jQuery );

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

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_video_slider = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	    		window.InlineShortcodeView_pix_video_slider.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
	    		return this;
	    	},
	    	pix_update: function () {
	            var that = this;
				setTimeout(function(){
					window.vc.frame_window.pix_main_slider(this.$el);
					if (window.vc.frame_window.pixLoadSwiper) window.vc.frame_window.pixLoadSwiper(this.$el);
				}, 500);
				setTimeout(function(){
					vc.frame_window.pix_cb_fn(function(){
						var effects	=	[
				            'fade-in-Img',
				            'fade-in-down',
				            'fade-in-left',
				            'fade-in-up',
				            'fade-in-up-big',
				            'fade-in-right-big',
				            'fade-in-left-big',
				            'slide-in-up',
							'pix-3d-right-in-big',
							'pix-3d-left-in-big',
							'pix-3d-up-in-big',
							'pix-3d-down-in-big'
				        ];
						that.$el.find('.animate-in:not(.animating)').each(function(i, elem){

				            var	type = $(elem).attr('data-anim-type'),
				            delay = $(elem).attr('data-anim-delay');
				            $(elem).addClass('pix-waiting');

							// Animate
							setTimeout(function() {
								$(elem).addClass('animating pix-animate').addClass(type).removeClass('animate-in');
							}, delay);

							// On animation end
							$(elem).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend transitionend webkitTransitionEnd oTransitionEnd', function() {
								// Clear animation
								$(elem).removeClass('animating animating-init').removeClass(effects.join(' ')).addClass('animated');
							});

				        });
					});
					if(that.$el.hasClass('flickity-enabled')){
						that.$el.find('.pix-main-slider').flickity('resize');
					}
				}, 500);
	    	},
	    	updated: function () {
	    		window.InlineShortcodeView_pix_video_slider.__super__.updated.call(this);
	            this.pix_update();
	            return this;
	    	},
	    	parentChanged: function () {
	    		window.InlineShortcodeView_pix_video_slider.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );

// (function ( $ ) {
// 	'use strict';
// 	window.InlineShortcodeView_vc_section = window.InlineShortcodeViewContainer.extend( {
// 		controls_selector: '#vc_controls-template-container',
// 		initialize: function () {
// 			_.bindAll( this, 'checkSectionWidth' );
// 			window.InlineShortcodeView_vc_section.__super__.initialize.call( this );
// 			vc.frame_window.jQuery( vc.frame_window.document ).off( 'vc-full-width-row-single', this.checkSectionWidth );
// 			vc.frame_window.jQuery( vc.frame_window.document ).on( 'vc-full-width-row-single', this.checkSectionWidth );
// 		},
// 		checkSectionWidth: function ( e, data ) {
// 			if ( data.el.hasClass( 'vc_section' ) && data.el.attr( 'data-vc-stretch-content' ) ) {
// 				data.el.siblings( '.vc_controls' ).find( '.vc_controls-out-tl' ).css( { left: data.offset - 17 } );
// 			}
// 		},
// 		render: function () {
// 			var $content = this.content();
// 			if ( $content && $content.hasClass( 'vc_row-has-fill' ) ) {
// 				$content.removeClass( 'vc_row-has-fill' );
// 				this.$el.addClass( 'vc_row-has-fill' );
// 			}
//
//
//
//
// 			return window.InlineShortcodeView_vc_section.__super__.render.call( this );
// 		}
// 	} );
// })( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeViewContainer){
		window.InlineShortcodeView_vc_section = window.InlineShortcodeViewContainer.extend( {
			controls_selector: '#vc_controls-template-container',
			initialize: function () {
				_.bindAll( this, 'checkSectionWidth' );
				window.InlineShortcodeView_vc_section.__super__.initialize.call( this );
				vc.frame_window.jQuery( vc.frame_window.document ).off( 'vc-full-width-row-single', this.checkSectionWidth );
				vc.frame_window.jQuery( vc.frame_window.document ).on( 'vc-full-width-row-single', this.checkSectionWidth );
			},
			checkSectionWidth: function ( e, data ) {
				if ( data.el.hasClass( 'vc_section' ) && data.el.attr( 'data-vc-stretch-content' ) ) {
					data.el.siblings( '.vc_controls' ).find( '.vc_controls-out-tl' ).css( { left: data.offset - 17 } );
				}
			},
			render: function () {
				var $content = this.content();
				if ( $content && $content.hasClass( 'vc_row-has-fill' ) ) {
					$content.removeClass( 'vc_row-has-fill' );
					this.$el.addClass( 'vc_row-has-fill' );
				}

				vc.frame_window.pix_cb_fn(function(){
					$content.find('> .pix-divider.pix-loaded').remove();
	            	$content.find('> .pix-divider').addClass('pix-loaded');

					$content.find('> .pix_element_overlay.pix-loaded').remove();
	            	$content.find('> .pix_element_overlay').addClass('pix-loaded');

					$content.find('> .fullpage-container.pix-loaded').remove();
	            	$content.find('> .fullpage-container').addClass('pix-loaded');

					$content.find('.pix_element_overlay').each(function(i, el){
						$(el).css({
							'border-radius': $(el).parent().css('border-radius')
						});
					});

				});

				return window.InlineShortcodeView_vc_section.__super__.render.call( this );
			}
		} );
	}
})( window.jQuery );
(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
		window.InlineShortcodeView_vc_row = window.InlineShortcodeView.extend( {
			column_tag: 'vc_column',
			events: {
				'mouseenter': 'removeHoldActive'
			},
			layout: 1,
			addControls: function () {
				this.$controls = $( '<div class="no-controls"></div>' );
				this.$controls.appendTo( this.$el );

				return this;
			},
			render: function () {
				var $content = this.content();
				if ( $content && $content.hasClass( 'vc_row-has-fill' ) ) {
					$content.removeClass( 'vc_row-has-fill' );
					this.$el.addClass( 'vc_row-has-fill' );
				}
				window.InlineShortcodeView_vc_row.__super__.render.call( this );


				// pixfort code
				var self = this;
				vc.frame_window.pix_cb_fn(function(){
					self.$el.find('.pix_element_overlay.pix-loaded').remove();
					self.$el.find('.pix_element_overlay').addClass('pix-loaded');

					self.$el.find('.fullpage-container.pix-loaded').remove();
					self.$el.find('.fullpage-container').addClass('pix-loaded');

					self.$el.find("div[id^='jarallax-container'].pix-loaded").remove();
					self.$el.find("div[id^='jarallax-container']").addClass('pix-loaded');

					$content.find('> .pix-divider.pix-loaded').remove();
	            	$content.find('> .pix-divider').addClass('pix-loaded');

					$content.find('> .pix-scene.pix-scene-loaded').remove();
	            	$content.find('> .pix-scene').addClass('pix-scene-loaded');

					$content.find('> .particles-container.pix-loaded').remove();
	            	$content.find('> .particles-container').addClass('pix-loaded');
				});
				setTimeout(function(){
					if(window.vc.frame_window.pix_sliders) window.vc.frame_window.pix_sliders();
					window.vc.frame_window.destroy_Parallax();
					window.vc.frame_window.init_Parallax();
					vc.frame_window.pix_cb_fn(function(){
						$content.find('.pix_element_overlay').each(function(i, el){
							$(el).css({
								'border-radius': $(el).parent().css('border-radius')
							});
						});
					});
				}, 1000);
				// ====================================


				return this;
			},
			removeHoldActive: function () {
				vc.unsetHoldActive();
			},
			addColumn: function () {
				vc.builder.create( {
					shortcode: this.column_tag,
					parent_id: this.model.get( 'id' )
				} ).render();
			},
			addElement: function ( e ) {
				if ( e && e.preventDefault ) {
					e.preventDefault();
				}
				this.addColumn();
			},
			changeLayout: function ( e ) {
				if ( e && e.preventDefault ) {
					e.preventDefault();
				}
				this.layoutEditor().render( this.model ).show();
			},
			layoutEditor: function () {
				if ( _.isUndefined( vc.row_layout_editor ) ) {
					vc.row_layout_editor = new vc.RowLayoutUIPanelFrontendEditor( { el: $( '#vc_ui-panel-row-layout' ) } );
				}

				return vc.row_layout_editor;
			},
			convertToWidthsArray: function ( string ) {
				return _.map( string.split( /_/ ), function ( c ) {
					var w = c.split( '' );
					w.splice( Math.floor( c.length / 2 ), 0, '/' );
					return w.join( '' );
				} );
			},
			changed: function () {
				window.InlineShortcodeView_vc_row.__super__.changed.call( this );
				this.addLayoutClass();
			},
			content: function () {
				if ( false === this.$content ) {
					this.$content = this.$el.find( '.vc_container-anchor:first' ).parent();
				}
				this.$el.find( '.vc_container-anchor:first' ).remove();

				return this.$content;
			},
			addLayoutClass: function () {
				this.$el.removeClass( 'vc_layout_' + this.layout );
				this.layout = _.reject( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ), function ( model ) {
					return model.get( 'deleted' );
				} ).length;
				this.$el.addClass( 'vc_layout_' + this.layout );
			},
			convertRowColumns: function ( layout, builder ) {
				if ( !layout ) {
					return false;
				}
				var column_params, new_model, columns_contents, columns;
				columns_contents = [];
				columns = this.convertToWidthsArray( layout );
				vc.layout_change_shortcodes = [];
				vc.layout_old_columns = vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } );
				_.each( vc.layout_old_columns, function ( column ) {
					column.set( 'deleted', true );
					columns_contents.push( {
						shortcodes: vc.shortcodes.where( { parent_id: column.get( 'id' ) } ),
						params: column.get( 'params' )
					} );
				} );
				_.each( columns, function ( column ) {
					var prev_settings = columns_contents.shift();
					if ( _.isObject( prev_settings ) ) {
						new_model = builder.create( {
							shortcode: this.column_tag,
							parent_id: this.model.get( 'id' ),
							order: vc.shortcodes.nextOrder(),
							params: _.extend( {}, prev_settings.params, { width: column } )
						} ).last();
						_.each( prev_settings.shortcodes, function ( shortcode ) {
							shortcode.save( {
									parent_id: new_model.get( 'id' ),
									order: vc.shortcodes.nextOrder()
								},
								{ silent: true } );
							vc.layout_change_shortcodes.push( shortcode );
						}, this );
					} else {
						column_params = { width: column };

						new_model = builder.create( {
							shortcode: this.column_tag,
							parent_id: this.model.get( 'id' ),
							order: vc.shortcodes.nextOrder(),
							params: column_params
						} ).last();
					}
				}, this );
				_.each( columns_contents, function ( column ) {
					_.each( column.shortcodes, function ( shortcode ) {
						shortcode.save( {
								parent_id: new_model.get( 'id' ),
								order: vc.shortcodes.nextOrder()
							},
							{ silent: true } );
						vc.layout_change_shortcodes.push( shortcode );
						if ( shortcode.view.rowsColumnsConverted ) {
							shortcode.view.rowsColumnsConverted();
						}
					}, this );
				}, this );
				builder.render( function () {
					_.each( vc.layout_change_shortcodes, function ( shortcode ) {
						shortcode.trigger( 'change:parent_id' );
						if ( shortcode.view.rowsColumnsConverted ) {
							shortcode.view.rowsColumnsConverted();
						}
					} );
					_.each( vc.layout_old_columns, function ( column ) {
						column.destroy();
					} );
					vc.layout_old_columns = [];
					vc.layout_change_shortcodes = [];
				} );

				return columns;
			},
			allowAddControl: function () {
				return 'edit' !== vc_user_access().getState( 'shortcodes' );
			},
			allowAddControlOnEmpty: function () {
				return 'edit' !== vc_user_access().getState( 'shortcodes' );
			}
		} );
	}
})( window.jQuery );

(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
		window.InlineShortcodeView_vc_column = window.InlineShortcodeViewContainerWithParent.extend( {
			controls_selector: '#vc_controls-template-vc_column',
			resizeDomainName: 'columnSize',
			_x: 0,
			css_width: 12,
			prepend: false,
			initialize: function ( params ) {
				window.InlineShortcodeView_vc_column.__super__.initialize.call( this, params );
				_.bindAll( this, 'startChangeSize', 'stopChangeSize', 'resize' );
			},
			render: function () {
				var width;
				var $content = this.content();
				window.InlineShortcodeView_vc_column.__super__.render.call( this );
				this.prepend = false;
				// Here goes width logic
				$( '<div class="vc_resize-bar"></div>' )
					.appendTo( this.$el )
					.mousedown( this.startChangeSize );
				this.setColumnClasses();
				this.customCssClassReplace();


	            // pixfort code
				setTimeout(function(){
					vc.frame_window.pix_cb_fn(function(){
						$content.find('.pix_element_overlay').each(function(i, el){
							$(el).css({
								'border-radius': $(el).parent().css('border-radius')
							});
						});
					});
				}, 1000);
				// ====================================


				return this;
			},
			destroy: function ( e ) {
				var parent_id = this.model.get( 'parent_id' );
				window.InlineShortcodeView_vc_column.__super__.destroy.call( this, e );
				if ( !vc.shortcodes.where( { parent_id: parent_id } ).length ) {
					vc.shortcodes.get( parent_id ).destroy();
				}
			},
			customCssClassReplace: function () {
				var css_classes, css_regex, class_match;

				css_classes = this.$el.find( '.wpb_column' ).attr( 'class' );
				css_regex = /.*(vc_custom_\d+).*/;
				class_match = css_classes && css_classes.match ? css_classes.match( css_regex ) : false;
				if ( class_match && class_match[ 1 ] ) {
					this.$el.addClass( class_match[ 1 ] );
					this.$el.find( '.wpb_column' ).attr( 'class', css_classes.replace( class_match[ 1 ], '' ).trim() );
				}
			},
			setColumnClasses: function () {
				var offset, width, $content;
				offset = this.getParam( 'offset' ) || '';
				width = this.getParam( 'width' ) || '1/1';
				$content = this.$el.find( '> .wpb_column' );
				this.css_class_width = this.convertSize( width );
				if ( this.css_class_width !== width ) {
					this.css_class_width = this.css_class_width.replace( /[^\d]/g, '' );
				}
				$content.removeClass( 'vc_col-sm-' + this.css_class_width );
				if ( !offset.match( /vc_col\-sm\-\d+/ ) ) {
					this.$el.addClass( 'vc_col-sm-' + this.css_class_width );
				}
				if ( vc.responsive_disabled ) {
					offset = offset.replace( /vc_col\-(lg|md|xs)[^\s]*/g, '' );
				}
				if ( !_.isEmpty( offset ) ) {
					$content.removeClass( offset );
					this.$el.addClass( offset );
				}
			},
			startChangeSize: function ( e ) {
				var width = this.getParam( width ) || 12;
				this._grid_step = this.parent_view.$el.width() / width;
				vc.frame_window.jQuery( 'body' ).addClass( 'vc_column-dragging' ).disableSelection();
				this._x = parseInt( e.pageX, 10 );
				vc.$page.bind( 'mousemove.' + this.resizeDomainName, this.resize );
				$( vc.frame_window.document ).on( 'mouseup', this.stopChangeSize );
			},
			stopChangeSize: function () {
				this._x = 0;
				vc.frame_window.jQuery( 'body' ).removeClass( 'vc_column-dragging' ).enableSelection();
				vc.$page.unbind( 'mousemove.' + this.resizeDomainName );
			},
			resize: function ( e ) {
				var width, old_width, diff, params = this.model.get( 'params' );
				diff = e.pageX - this._x;
				if ( Math.abs( diff ) < this._grid_step ) {
					return;
				}
				this._x = parseInt( e.pageX, 10 );
				old_width = '' + this.css_class_width;
				if ( 0 < diff ) {
					this.css_class_width += 1;
				} else if ( 0 > diff ) {
					this.css_class_width -= 1;
				}
				if ( 12 < this.css_class_width ) {
					this.css_class_width = 12;
				}
				if ( 1 > this.css_class_width ) {
					this.css_class_width = 1;
				}
				params.width = vc.getColumnSize( this.css_class_width );
				this.model.save( { params: params }, { silent: true } );
				this.$el.removeClass( 'vc_col-sm-' + old_width ).addClass( 'vc_col-sm-' + this.css_class_width );
			},
			convertSize: function ( width ) {
				var prefix, numbers, range, num, dev;
				prefix = 'vc_col-sm-';
				numbers = width ? width.split( '/' ) : [
					1,
					1
				];
				range = _.range( 1, 13 );
				num = !_.isUndefined( numbers[ 0 ] ) && 0 <= _.indexOf( range,
					parseInt( numbers[ 0 ], 10 ) ) ? parseInt( numbers[ 0 ], 10 ) : false;
				dev = !_.isUndefined( numbers[ 1 ] ) && 0 <= _.indexOf( range,
					parseInt( numbers[ 1 ], 10 ) ) ? parseInt( numbers[ 1 ], 10 ) : false;
				// Custom fix for 5 columns grid
				if ( '5' === numbers[ 1 ] ) {
					return width;
				}
				if ( false !== num && false !== dev ) {
					return prefix + (12 * num / dev);
				}
				return prefix + '12';
			},
			allowAddControl: function () {
				return vc_user_access().shortcodeAll( 'vc_column' );
			}
		} );
	}
})( window.jQuery );

(function ($) {
	'use strict';
    function pixUpdateShortcodeParams(data) {
        let model = data.model;
        try {
            if(model.attributes){
                let shortcode = model.attributes.shortcode;
                let id = model.attributes.id;
                let params = model.attributes.params;
                let elements = ['pix_accordion_tab', 'alertblock', 'pix_faq'];
                if (elements.includes(shortcode)) {
                    params = window.pixVerifyWPBakeryIcons(params);
                }
                if(shortcode === 'pix_comparison_table'){
                    params = window.pixVerifyWPBakeryIcons(params, true, 'items', 'pix-comparison-table');
                }
                if(shortcode === 'pix_feature'){
                    params = window.pixVerifyWPBakeryIcons(params, false, null, null, 'pix-feature');
                }
                if(shortcode === 'pix_feature_list'){
                    params = window.pixVerifyWPBakeryIcons(params, true, 'features');
                }
                if(shortcode === 'pix_icon'){
                    params = window.pixVerifyWPBakeryIcons(params, false, null, null, 'pix-icon');
                }
                if(shortcode === 'pix_marquee'){
                    params = window.pixVerifyWPBakeryIcons(params, true, 'items', 'item_type');
                }
                if(shortcode === 'pix_pricing'){
                    params = window.pixVerifyWPBakeryIcons(params, true, 'features', 'media_type');
                }
                vc.shortcodes.get(id).set('params', params);
            }
            
        } catch (error) {
            console.log(error);
        }
    }

    if(window.vc){
        window.vc.events.on( 'shortcodeView:updated, shortcodeView:ready', function ( model ) {
            if(!window.vc.frame){
                pixUpdateShortcodeParams(model);
            }
        });
    }
    

	

})(window.jQuery);
