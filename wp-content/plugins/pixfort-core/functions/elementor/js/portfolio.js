jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        if (typeof init_portfolio === 'function') {
            init_portfolio($element);
        }
        if (typeof init_tilts === 'function') {
            init_tilts($element);
        }
    };
    elementorFrontend.hooks.addAction('frontend/element_ready/pix-portfolio.default', addHandler);
});
