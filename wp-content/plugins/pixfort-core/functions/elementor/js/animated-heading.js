jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        // piximations.init();
        if(window.init_animated_heading) window.init_animated_heading();
    };

    elementorFrontend.hooks.addAction(
        'frontend/element_ready/pix-animated-heading.default',
        addHandler
    );
});
