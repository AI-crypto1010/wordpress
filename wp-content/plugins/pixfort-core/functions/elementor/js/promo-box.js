jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        if (window.init_tilts) {
            init_tilts($element);
        }
    };
    elementorFrontend.hooks.addAction('frontend/element_ready/promo-box.default', addHandler);
});
