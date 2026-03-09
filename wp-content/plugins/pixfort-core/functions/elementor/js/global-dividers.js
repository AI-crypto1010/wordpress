jQuery(window).on('elementor/frontend/init', () => {
    const addSectionHandler = ( $element ) => {
        let attr = $element.attr('data-pix-dividers');
        if (typeof attr !== 'undefined' && attr !== false) {
            let isCol = $element.hasClass('elementor-column');
            if(isCol){
                $element.find('> .elementor-column-wrap, > .elementor-widget-wrap').addClass('pix-elementor-section-dividers')
                $element.find('> .elementor-column-wrap, > .elementor-widget-wrap').prepend($element.attr('data-pix-dividers'));
            }else{
                $element.addClass('pix-elementor-section-dividers')
                $element.prepend(attr);
            }
            // $element.attr('data-pix-dividers', '');
            if(window.pix_animation) window.pix_animation($element, true);
            if(window.init_dividerShapes) window.init_dividerShapes($element);
                    // $element
                    //     .find('.pix-shape-dividers')
                    //     .each(function () {
                    //         if (!jQuery(this).hasClass('loaded')) {
                    //             let divider = new dividerShapes(this);
                    //             divider.initPoints();
                    //             jQuery(this).addClass('loaded');
                    //         }
                    //     });
        }
        // $e.commands.getAll();
        // 
    };
 
    elementorFrontend.hooks.addAction( 'frontend/element_ready/section', addSectionHandler );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/column', addSectionHandler );
    elementorFrontend.hooks.addAction( 'frontend/element_ready/container', addSectionHandler );
});