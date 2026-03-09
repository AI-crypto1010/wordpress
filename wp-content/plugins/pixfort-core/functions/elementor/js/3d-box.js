jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        // pix_animation($element);
        if(window.init_tilts){
            init_tilts($element);
        }  
    };

    elementorFrontend.hooks.addAction(
        'frontend/element_ready/pix-3d-box.default',
        addHandler
    );
});
