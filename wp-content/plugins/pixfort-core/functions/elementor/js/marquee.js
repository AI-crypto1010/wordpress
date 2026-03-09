jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {        
        if(window.pix_marquee) {
            window.pix_marquee($element);
        }
    };
    elementorFrontend.hooks.addAction('frontend/element_ready/pix-marquee.default', addHandler);
});
