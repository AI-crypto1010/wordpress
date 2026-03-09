jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        if(window.pix_runtime) window.pix_runtime();
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/pix-runtime.default', addHandler);
});
