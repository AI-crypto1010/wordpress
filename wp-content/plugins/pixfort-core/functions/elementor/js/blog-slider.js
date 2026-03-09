// function pixGlobalFunctionCaller($element){
//     pix_main_slider($element);
// }
jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        // $element.find('.pix-main-slider').removeClass('pix-slider-loaded flickity-enabled is-draggable');
        // pixGlobalFunctionCaller();
        // pix_main_slider($element);
        if(window.init_tilts){
            init_tilts($element);
        }  
        updatePixfortSlider($element);
    };
    function updatePixfortSlider($element) {
        // Initialize Swiper sliders
        if ($element.find('.pixfort-swiper .swiper').length) {
            // Remove swiper-initialized class and destroy existing instances
            $element.find('.pixfort-swiper .swiper').each(function(i, elem) {
                $(elem).removeClass('swiper-initialized');
                // Destroy existing Swiper instance if it exists
                if (elem.swiper && typeof elem.swiper.destroy === 'function') {
                    elem.swiper.destroy(true, true);
                }
            });
            
            // Use setInterval for continuous checking
            let retryCount = 0;
            const maxRetries = 20;
            
            const checkInterval = setInterval(() => {
                retryCount++;
                
                if (typeof window.pixLoadSwiper === 'function') {
                    clearInterval(checkInterval);
                    window.pixLoadSwiper($element);
                } else if (retryCount >= maxRetries) {
                    clearInterval(checkInterval);
                    console.log('[blog-slider] pixLoadSwiper not available after', maxRetries * 100, 'ms');
                }
            }, 100);
        }
    }
    elementorFrontend.hooks.addAction(
        'frontend/element_ready/pix-blog-slider.default',
        addHandler
    );
});
