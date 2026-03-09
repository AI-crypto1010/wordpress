<?php

if (!function_exists('pix_get_header_options_data_divider')) {
    function pix_get_header_options_data_divider($header_dynamic, $header_assets, $enable_dynamic_colors = false) {
        return array(
            'divider' => array(
                'title' => __('Divider', 'pixfort-core'),
                'icon' => 'divider',
                'options' => array(
                    array(
                        'type' => 'select',
                        'name' => 'divider_size',
                        'title' => __('Spacing', 'pixfort-core'),
                        'val' => 'mx-2',
                        'options' => array(
                            array(
                                'name' => __('None', 'pixfort-core'),
                                'value' => 'mx-0'
                            ),
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
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'divider_color',
                        'title' => __('Color', 'pixfort-core'),
                        'val' => 'body-default',
                        'options' => $header_dynamic['pix_divider_colors_groups'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'divider_color_scroll',
                        'title' => __('Scroll Color', 'pixfort-core'),
                        'val' => 'default',
                        'options' => $header_dynamic['pix_divider_colors_groups_with_default'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'divider_height',
                        'title' => __('Height', 'pixfort-core'),
                        'val' => 'full',
                        'options' => array(
                            array(
                                'name' => __('Full height', 'pixfort-core'),
                                'value' => ''
                            ),
                            array(
                                'name' => __('Small', 'pixfort-core'),
                                'value' => 'pix-sm'
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
