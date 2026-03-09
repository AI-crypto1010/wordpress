<?php

if (!function_exists('pix_get_header_options_data_btn')) {
    function pix_get_header_options_data_btn($header_dynamic, $header_assets, $enable_dynamic_colors = false) {
        return array(
            'btn' => array(
                'title' => __('Button', 'pixfort-core'),
                'icon' => 'btn',
                'enableTabs' => true,
                'options' => array(
                    array(
                        'type' => 'text',
                        'name' => 'text',
                        'title' => __('Text', 'pixfort-core'),
                        'val' => 'Default Text'
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'url',
                        'title' => __('Link', 'pixfort-core'),
                        'val' => ''
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'btn_popup_id',
                        'title' => __('Open a popup instead of link', 'pixfort-core'),
                        'val' => '',
                        'options' => $header_dynamic['pix_popups']
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'bold',
                        'title' => __('Use Bold Text', 'pixfort-core'),
                        'val' => 'on'
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'secondary',
                        'title' => __('Button Font', 'pixfort-core'),
                        'val' => '',
                        'options' => array(
                            array(
                                'name' => __('Default (Same as Header)', 'pixfort-core'),
                                'value' => ''
                            ),
                            array(
                                'name' => __('Body Font', 'pixfort-core'),
                                'value' => 'body-font'
                            ),
                            array(
                                'name' => __('Heading Font (Secondary font)', 'pixfort-core'),
                                'value' => 'secondary-font'
                            )
                        )
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'target',
                        'title' => __('Open in a new tab', 'pixfort-core'),
                        'val' => 'off'
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'btn_style',
                        'title' => __('Button style', 'pixfort-core'),
                        'val' => '',
                        'options' => $header_dynamic['pix_btn_style']
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'btn_color',
                        'title' => __('Button color', 'pixfort-core'),
                        'val' => 'primary',
                        'options' => $header_dynamic['pix_btn_colors_groups'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_btn_color',
                        'title' => __('Custom button background color', 'pixfort-core'),
                        'val' => '#333',
                        'dependency' => array(
                            'field' => 'btn_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'btn_text_color',
                        'title' => __('Text color', 'pixfort-core'),
                        'val' => '',
                        'options' => $header_dynamic['pix_btn_text_colors_groups'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_btn_text_color',
                        'title' => __('Custom button text color', 'pixfort-core'),
                        'val' => '#fff',
                        'dependency' => array(
                            'field' => 'btn_text_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'btn_rounded',
                        'title' => __('Rounded', 'pixfort-core'),
                        'val' => 'off'
                    ),
                    array(
                        'type' => 'icon',
                        'name' => 'btn_icon',
                        'title' => __('Icon', 'pixfort-core'),
                        'val' => ''
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'btn_icon_position',
                        'title' => __('Icon position', 'pixfort-core'),
                        'val' => '',
                        'options' => array(
                            array(
                                'name' => __('Before text (left)', 'pixfort-core'),
                                'value' => ''
                            ),
                            array(
                                'name' => __('After text (right)', 'pixfort-core'),
                                'value' => 'after'
                            )
                        )
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
                        'tab' => 'advanced',
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
