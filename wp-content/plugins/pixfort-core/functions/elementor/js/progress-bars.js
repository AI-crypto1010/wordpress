jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        if (window.init_bars) window.init_bars();
    };
    elementorFrontend.hooks.addAction('frontend/element_ready/pix-progress-bars.default', addHandler);
});
