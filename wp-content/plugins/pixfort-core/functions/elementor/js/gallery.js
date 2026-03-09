jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        window.update_masonry();
        setTimeout(function () {
            pixLoadLightbox();
            window.update_masonry();
        }, 1400);
    };
    elementorFrontend.hooks.addAction('frontend/element_ready/pix-gallery.default', addHandler);
});
