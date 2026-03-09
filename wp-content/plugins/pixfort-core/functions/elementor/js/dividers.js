jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        if(window.init_dividerShapes) window.init_dividerShapes(jQuery('body'));
    };

    elementorFrontend.hooks.addAction(
        'frontend/element_ready/pix-dividers.default',
        addHandler
    );
});
