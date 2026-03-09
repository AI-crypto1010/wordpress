jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        if (typeof pix_animation === 'function') {
            pix_animation($element);
        }
    };
    elementorFrontend.hooks.addAction('frontend/element_ready/pix-horizontal-tabs.default', addHandler);
    elementorFrontend.hooks.addAction('frontend/element_ready/pix-vertical-tabs.default', addHandler);
});
