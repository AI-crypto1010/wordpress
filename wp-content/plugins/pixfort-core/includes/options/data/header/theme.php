<?php

if (!function_exists('pix_get_header_options_data_theme')) {
    function pix_get_header_options_data_theme($header_dynamic, $header_assets, $enable_dynamic_colors = false) {
        return array(
            'theme' => array(
                'title' => __('Theme Switcher', 'pixfort-core'),
                'icon' => 'theme',
                'hideInBuilder' => true,
                'options' => array(
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
