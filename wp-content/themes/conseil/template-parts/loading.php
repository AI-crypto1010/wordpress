<?php
if(function_exists('pix_plugin_get_option')){
    if (!empty(pix_plugin_get_option('site-loading-style'))) {
        if (pix_plugin_get_option('site-loading-style') === 'style-5') {
    ?>
            <div class="pix-loading-circ-path">
                <svg class="loading-circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="6" stroke-miterlimit="10" />
                </svg>
            </div>
        <?php
        } elseif (
            pix_plugin_get_option('site-loading-style') === 'style-6'
            || pix_plugin_get_option('site-loading-style') === 'style-7'
        ) {
        ?>
            <div class="pix-loading-circ-path">
                <div class="pix-loading__line"></div>
                <div class="pix-loading__line"></div>
                <div class="pix-loading__line"></div>
                <div class="pix-loading__line"></div>
                <div class="pix-loading__line"></div>
                <div class="pix-loading__line"></div>
            </div>
        <?php
        } elseif (pix_plugin_get_option('site-loading-style') === 'style-8') {
        ?>
            <div class="pix-loading-circ-path pix-preserve"><?php
            if(!empty(pix_plugin_get_option('site-loading-img'))){
                if(!empty(pix_plugin_get_option('site-loading-img')['id'])){
                    echo wp_get_attachment_image(pix_plugin_get_option('site-loading-img')['id'], 'full');
                }
            }
            ?></div>
        <?php
        } else {
        ?>
            <div class="pix-loading-circ-path"></div>
        <?php
        }
    } else {
        ?>
        <div class="pix-loading-circ-path"></div>
    <?php
    }    
}
