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
