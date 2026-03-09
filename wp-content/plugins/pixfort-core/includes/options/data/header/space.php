<?php

if (!function_exists('pix_get_header_options_data_space')) {
    function pix_get_header_options_data_space($header_dynamic, $header_assets, $enable_dynamic_colors = false) {
        return array(
            'space' => array(
                'title' => __('Space', 'pixfort-core'),
                'icon' => 'space',
                'options' => array(
                    array(
                        'type' => 'select',
                        'name' => 'size',
                        'title' => __('Spacing', 'pixfort-core'),
                        'val' => 'mx-2',
                        'options' => array(
                            array(
                                'name' => __('Small', 'pixfort-core'),
                                'value' => 'mx-1'
                            ),
                            array(
                                'name' => __('Default', 'pixfort-core'),
                                'value' => 'mx-2'
                            ),
                            array(
                                'name' => __('Big', 'pixfort-core'),
                                'value' => 'mx-3'
                            ),
                            array(
                                'name' => __('Extra Big', 'pixfort-core'),
                                'value' => 'mx-4'
                            ),
                            array(
                                'name' => __('Fill all space', 'pixfort-core'),
                                'value' => 'flex-grow-1'
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
