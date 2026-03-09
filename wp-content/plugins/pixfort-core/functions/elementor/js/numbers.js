jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        if (typeof update_numbers === 'function') {
            update_numbers($element);
        }
    };
    elementorFrontend.hooks.addAction('frontend/element_ready/pix-numbers.default', addHandler);
});
