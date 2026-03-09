<?php

if (!function_exists('pix_get_header_options_data_logo')) {
    function pix_get_header_options_data_logo($header_dynamic, $header_assets, $enable_dynamic_colors = false) {
        return array(
            'logo' => array(
                'title' => __('Logo', 'pixfort-core'),
                'icon' => 'logoMini',
                'options' => array(
                    array(
                        'type' => 'text',
                        'name' => 'height',
                        'title' => __('Logo height', 'pixfort-core'),
                        'description' => __('Input custom height in pixels, for example: 30px', 'pixfort-core'),
                        'val' => ''
                    ),
                    array(
                        'type' => 'image',
                        'name' => 'logo_img',
                        'title' => __('Logo image (Optional)', 'pixfort-core'),
                        'description' => __('Choose a different logo from the main website logo.', 'pixfort-core'),
                        'dynamic' => $enable_dynamic_colors,
                        'val' => ''
                    ),
                    array(
                        'type' => 'image',
                        'name' => 'logo_scroll_img',
                        'title' => __('Logo scroll image (Optional)', 'pixfort-core'),
                        'description' => __('Choose a different scoll logo from the main website scroll logo.', 'pixfort-core'),
                        'dynamic' => $enable_dynamic_colors,
                        'val' => ''
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'animation',
                        'title' => __('Animation', 'pixfort-core'),
                        'val' => 'slide-in-up',
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
                            ),
                            array(
                                'name' => __('Slide in Up', 'pixfort-core'),
                                'value' => 'slide-in-up'
                            )
                        )
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'custom_url',
                        'title' => __('Link (Optional)', 'pixfort-core'),
                        'description' => __('Choose logo link or leave empty to use website homepage link.', 'pixfort-core'),
                        'val' => ''
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'target',
                        'title' => __('Open in a new tab', 'pixfort-core'),
                        'val' => 'off'
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'width',
                        'title' => __('Logo width (optional)', 'pixfort-core'),
                        'description' => __('Input custom width', 'pixfort-core'),
                        'val' => ''
                    ),
                    array(
                        'type' => 'pixid',
                        'name' => 'element_id',
                        'val' => ''
                    )
                )
            )
        );
    }
}
