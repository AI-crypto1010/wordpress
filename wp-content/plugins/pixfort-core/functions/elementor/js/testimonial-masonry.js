jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        if (typeof window.update_masonry === 'function') {
            window.update_masonry($element);
        }
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/pix-testimonial-masonry.default', addHandler);
});
