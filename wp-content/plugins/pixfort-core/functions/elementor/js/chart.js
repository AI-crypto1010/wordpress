jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        if (typeof init_chart === 'function') {
            init_chart($element);
        }
    };

    elementorFrontend.hooks.addAction(
        'frontend/element_ready/pix-chart.default',
        addHandler
    );
});
