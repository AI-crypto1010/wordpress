jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
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

            if (typeof window.pixLoadSwiper === 'function') {
                // Function is available, initialize and stop checking
                window.pixLoadSwiper($element);
            }
            
            // Try to initialize swiper with polling retry mechanism
            // let retryCount = 0;
            // const maxRetries = 20; // Try for up to ~2 seconds (20 * 100ms)
            
            // // Use setInterval for continuous checking (doesn't wait for main thread)
            // const checkInterval = setInterval(() => {
            //     retryCount++;
            //     if (typeof window.pixLoadSwiper === 'function') {
            //         // Function is available, initialize and stop checking
            //         clearInterval(checkInterval);
            //         window.pixLoadSwiper($element);
            //     } else if (retryCount >= maxRetries) {
            //         // Give up after max retries
            //         clearInterval(checkInterval);
            //         console.log('[img-carousel] pixLoadSwiper not available after', maxRetries * 100, 'ms');
            //     }
            //     // Otherwise, keep checking every 100ms
            // }, 100);
        }
    }
    
    elementorFrontend.hooks.addAction('frontend/element_ready/pix-img-carousel.default', addHandler);
});
