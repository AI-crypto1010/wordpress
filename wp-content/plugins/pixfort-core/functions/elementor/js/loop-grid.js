/**
 * Loop Grid Elementor Widget JS
 */
(function($) {
    'use strict';

    // Elementor editor support
    $(window).on('elementor/frontend/init', function() {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction('frontend/element_ready/pix-loop-grid.default', function($scope) {
                // Re-initialize any necessary functionality
            });
        }
    });

})(jQuery);
