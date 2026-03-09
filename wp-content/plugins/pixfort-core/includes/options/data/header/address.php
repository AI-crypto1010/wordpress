<?php

if (!function_exists('pix_get_header_options_data_address')) {
    function pix_get_header_options_data_address($header_dynamic, $header_assets, $enable_dynamic_colors = false) {
        return array(
            'address' => array(
                'title' => __('Address', 'pixfort-core'),
                'icon' => 'address',
                'options' => array(
                    array(
                        'type' => 'text',
                        'name' => 'text',
                        'title' => __('Text', 'pixfort-core'),
                        'val' => 'La Défense, Paris'
                    ),
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
                        'type' => 'select',
                        'name' => 'permissions',
                        'title' => __('Permissions', 'pixfort-core'),
                        'val' => 'all',
                        'options' => array(
                            array(
                                'name' => __('Default (All)', 'pixfort-core'),
                                'value' => 'all'
                            ),
                            array(
                                'name' => __('Logged In Users Only', 'pixfort-core'),
                                'value' => 'logged-in'
                            ),
                            array(
                                'name' => __('Logged Out Users Only', 'pixfort-core'),
                                'value' => 'logged-out'
                            )
                        )
                    )
                )
            )
        );
    }
}
