<?php

if (!function_exists('pix_get_header_options_data_search')) {
    function pix_get_header_options_data_search($header_dynamic, $header_assets, $enable_dynamic_colors = false) {
        return array(
            'search' => array(
                'title' => __('Search', 'pixfort-core'),
                'icon' => 'zoom',
                'hideInBuilder' => true,
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
                        'type' => 'select',
                        'name' => 'search_style',
                        'title' => __('Style', 'pixfort-core'),
                        'val' => '',
                        'options' => array(
                            array(
                                'name' => __('Default', 'pixfort-core'),
                                'value' => ''
                            ),
                            array(
                                'name' => __('Small Floating Bar', 'pixfort-core'),
                                'value' => 'floating-sm'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'search_bar_direction',
                        'title' => __('Open direction', 'pixfort-core'),
                        'val' => '',
                        'options' => array(
                            array(
                                'name' => __('Right', 'pixfort-core'),
                                'value' => ''
                            ),
                            array(
                                'name' => __('Left', 'pixfort-core'),
                                'value' => 'open-bar-left'
                            )
                        ),
                        'dependency' => array(
                            'field' => 'search_style',
                            'val' => 'floating-sm'
                        )
                    )
                )
            )
        );
    }
}
