jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        if(window.video_element) window.video_element();
        if(window.init_tilts){
            init_tilts($element);
        }  
        // $element.find('video').each(function (i, elem) {
        //     this.play();
        // });
    };

    elementorFrontend.hooks.addAction(
        'frontend/element_ready/pix-auto-video.default',
        addHandler
    );
});
