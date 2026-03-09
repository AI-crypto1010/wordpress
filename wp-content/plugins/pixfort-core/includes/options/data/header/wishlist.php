<?php

if (!function_exists('pix_get_header_options_data_wishlist')) {
    function pix_get_header_options_data_wishlist($header_dynamic, $header_assets, $enable_dynamic_colors = false) {
        return array(
            'wishlist' => array(
                'title' => __('Wishlist', 'pixfort-core'),
                'icon' => 'wishlist',
                'options' => array(
                    array(
                        'type' => 'select',
                        'name' => 'animation',
                        'title' => __('Animation', 'pixfort-core'),
                        'val' => 'disabled',
                        'options' => array(
                            array(
                                'name' => __('Disabled', 'pixfort-core'),
                                'value' => 'disabled'
                            ),
                            array(
                                'name' => __('Fade in', 'pixfort-core'),
                                'value' => 'fade-in'
                            ),
                            array(
                                'name' => __('Fade in Down', 'pixfort-core'),
                                'value' => 'fade-in-down'
                            ),
                            array(
                                'name' => __('Fade in Left', 'pixfort-core'),
                                'value' => 'fade-in-left'
                            ),
                            array(
                                'name' => __('Fade in Right', 'pixfort-core'),
                                'value' => 'fade-in-right'
                            ),
                            array(
                                'name' => __('Fade in Up', 'pixfort-core'),
                                'value' => 'fade-in-up'
                            )
                        )
                    ),
                    array(
                        'type' => 'alert',
                        'style' => 'clean',
                        'name' => 'height',
                        'title' => __('Note', 'pixfort-core'),
                        'description' => __('To use the WooCommerce wishlist functionality, please make sure that WooCommerce plugin is installed in addition to the free plugin <a href="https://wordpress.org/plugins/yith-woocommerce-wishlist/" target="_blank"><b>YITH WooCommerce Wishlist</b></a>.', 'pixfort-core'),
                        'val' => ''
                    )
                )
            )
        );
    }
}
