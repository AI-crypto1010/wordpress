jQuery(window).on('elementor/frontend/init', () => {
    if (!window.ElementorInlineEditor) return;
    elementorFrontend.hooks.addAction('frontend/element_ready/widget', function ($scope) { 
        if (typeof pix_animation === 'function') pix_animation($scope, false, true);
        // Only process within the newly-rendered widget. Running this on the full body
        // for every widget becomes extremely expensive during large template imports.
        pixGlobalpix_gradient_fix($scope);
        // if (typeof window.pix_init_gradient_fix === 'function') {
        //     window.pix_init_gradient_fix($scope);
        // }
    });
    // elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope) { 
    //     if($scope.find('.animate-in:not(.pix-waiting)').length > 0) {
            
    //         // Call directly instead of using setTimeout - it will execute immediately
    //         // requestAnimationFrame(() => {
    //             // if (typeof pix_animation === 'function') {
    //                 pixGlobalinitAnimations($scope);
    //             // }
    //         // });
    //     }
    //     // if (typeof window.pix_init_gradient_fix === 'function') {
    //     //     window.pix_init_gradient_fix($scope);
    //     // }
    //     pixGlobalpix_gradient_fix($scope);
    // });
    // pixGlobalinitAnimations();
    // pixGlobalpix_gradient_fix();


    // Add handler for responsive control changes in editor
    if (window.elementorFrontend.isEditMode()) {
        elementor.channels.editor.on('change', function(view, options) {
            try {
                // check if view.get is defined
                if (!view.get) {
                    return;
                }
                const widgetType = view.get('widgetType');
                const sliderWidgets = [
                    'pix-img-carousel',
                    'pix-slider',
                    'pix-blog-slider',
                    'pix-clients-carousel',
                    'pix-img-slider',
                    'pix-portfolio-slider',
                    'pix-products-carousel',
                    'pix-reviews-slider',
                    'pix-testimonials-slider',
                    'pix-video-slider'
                ];
                if (view.get('elType') === 'widget' && sliderWidgets.includes(widgetType)) {
                    const changedAttributes = Object.keys(options.changed);
                    const responsiveControls = ['slider_num', 'slider_num_tablet', 'slider_num_mobile'];
                    
                    // Check if any responsive slider_num control was changed
                    const hasResponsiveChange = changedAttributes.some(attr => 
                        responsiveControls.some(control => attr.includes(control))
                    );
                    
                    if (hasResponsiveChange) {
                        const $element = jQuery('#elementor-preview-iframe').contents().find('[data-id="' + view.get('id') + '"]');
                        if ($element.length) {
                            // setTimeout(function() {
                                updatePixfortSlider($element);
                            // }, 300);
                        }
                    }
                }
            } catch (error) {
                console.log(error);
            }
        });
    }


    // function pixGlobalinitAnimations(el = false) {
	
    //     if (!el) {
    //         el = $('body');
    //     }
    //     // List of animation effects
    //     const effects = [
    //         'fade-in-Img',
    //         'fade-in-down',
    //         'fade-in-left',
    //         'fade-in-up',
    //         'fade-in-up-big',
    //         'fade-in-right-big',
    //         'fade-in-left-big',
    //         'highlight-grow',
    //         'slide-in-up',
    //         'pix-3d-right-in-big',
    //         'pix-3d-left-in-big',
    //         'pix-3d-up-in-big',
    //         'pix-3d-down-in-big'
    //     ];
    
    //     // Iterate over elements to animate	
    //     el.find(`.animate-in`).each(function (i, elem) {
    //         const $elem = $(elem); // Cache the jQuery object
    //         const type = $elem.attr('data-anim-type');
    //         const delay = $elem.attr('data-anim-delay') || 0; // Fallback delay
    
    //         // Mark element as waiting
    //         $elem.addClass('pix-waiting');
    
    //         pixGlobalanimateElement($elem, type, delay, effects);
    //     });
    
    //     // Helper function for animation
    //     function pixGlobalanimateElement($elem, type, delay, effects) {
    //         if ($elem.hasClass('animate-in') && !$elem.hasClass('animating-init')) {
    //             $elem.addClass('animating-init');
                
    //             // Use RAF-based delay instead of setTimeout to avoid event loop queuing
    //             if (delay > 0) {
    //                 // RAF-based delay: more performant than setTimeout, no violations
    //                 const startTime = performance.now();
                    
    //                 function checkDelay(currentTime) {
    //                     const elapsed = currentTime - startTime;
                        
    //                     if (elapsed >= delay) {
    //                         $elem.addClass(`animating pix-animate ${type}`).removeClass('animate-in');
    //                     } else {
    //                         requestAnimationFrame(checkDelay);
    //                     }
    //                 }
                    
    //                 requestAnimationFrame(checkDelay);
    //             } else {
    //                 requestAnimationFrame(() => {
    //                     $elem.addClass(`animating pix-animate ${type}`).removeClass('animate-in');
    //                 });
    //             }
    
    //             // Handle specific sliding headline animations
    //             if ($elem.hasClass('pix-sliding-headline-2')) {
    //                 $elem.find('.pix-sliding-item').each(function (i, item) {
    //                     $(item).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend transitionend webkitTransitionEnd oTransitionEnd', function () {
    //                         // Use requestAnimationFrame instead of setTimeout for animation cleanup
    //                         requestAnimationFrame(() => {
    //                             requestAnimationFrame(() => {
    //                                 // Double RAF ensures animation has fully completed
    //                                 $(item).closest('.slide-in-container').addClass('animated');
    //                             });
    //                         });
    //                     });
    //                 });
    //             }
    
    //             // General animation end handling
    //             $elem.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend transitionend webkitTransitionEnd oTransitionEnd', function () {
    //                 // Use requestAnimationFrame instead of setTimeout for cleanup
    //                 requestAnimationFrame(() => {
    //                     requestAnimationFrame(() => {
    //                         // Double RAF ensures animation has fully completed (~32ms)
    //                         $elem.removeClass(`animating animating-init ${effects.join(' ')}`).addClass('animated');
    //                     });
    //                 });
    //             });
    //         }
    //     }
    // }


    function pixGlobalpix_gradient_fix(element = false) {	
        if (!element) {
            element = $('body');
        }
        element.find('.text-gradient-primary, .pix-levels .bg-gradient-primary, .pix-tabs-btn').each(function (i, elem) {
            if (
                !$(elem).closest('.pix-marquee').length &&
                !$(elem).closest('.pix-vertical-element').length
            ) {
                let left = $(elem).offset().left;
                let top = $(elem).offset().top;
                let size = window.innerWidth + 'px ' + window.innerHeight + 'px';
                let newL = -1 * left;
                let newT = -1 * top;
                if (!$(elem).hasClass('text-bg-img')) {
                    $(elem).css({
                        'background-size': size,
                        'background-position-x': newL,
                        'background-position-y': newT
                    });
                }
                $(elem).css({
                    'background-attachment': 'scroll'
                });
            }
        });
    }

    
});
