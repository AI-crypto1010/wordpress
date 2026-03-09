jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        pix_main_slider($element);
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
            
            // Initialize swiper with element scope
            setTimeout(function () {
                if (typeof window.pixLoadSwiper === 'function') {
                    window.pixLoadSwiper($element);
                } else {
                    // If pixLoadSwiper is not available yet, try again
                    setTimeout(function () {
                        updatePixfortSlider($element);
                    }, 1500);
                }
            }, 100);
        }
    }

    elementorFrontend.hooks.addAction('frontend/element_ready/pix-reviews-slider.default', addHandler);
});
