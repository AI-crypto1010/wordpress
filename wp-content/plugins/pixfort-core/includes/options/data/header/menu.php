<?php

if (!function_exists('pix_get_header_options_data_menu')) {
    function pix_get_header_options_data_menu($header_dynamic, $header_assets, $enable_dynamic_colors = false) {
        return array(
            'menu' => array(
                'title' => __('Menu', 'pixfort-core'),
                'icon' => 'barsMenu',
                'enableTabs' => true,
                'options' => array(
                    array(
                        'type' => 'select',
                        'name' => 'menu',
                        'title' => __('Menu', 'pixfort-core'),
                        'val' => '',
                        'options' => $header_dynamic['pix_menus']
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'disable_bold',
                        'title' => __('Disable Bold text', 'pixfort-core'),
                        'val' => false
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'is_right_float',
                        'title' => __('Menu align', 'pixfort-core'),
                        'val' => '',
                        'options' => array(
                            array(
                                'name' => __('Start', 'pixfort-core'),
                                'value' => 'start'
                            ),
                            array(
                                'name' => __('Center', 'pixfort-core'),
                                'value' => 'center'
                            ),
                            array(
                                'name' => __('End', 'pixfort-core'),
                                'value' => 'end'
                            )
                        )
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'is_right_drop',
                        'title' => __('Right align dropdown menu', 'pixfort-core'),
                        'val' => 'off'
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'drop_bg',
                        'title' => __('Dropdown Background Color', 'pixfort-core'),
                        'val' => 'white',
                        'options' => $header_dynamic['bg_colors_groups_no_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'hidden',
                        'name' => 'dark_mode',
                        'title' => __('Light dropdown text colors', 'pixfort-core'),
                        'val' => 'off'
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'drop_title_color',
                        'title' => __('Dropdown Titles Color', 'pixfort-core'),
                        'val' => 'heading-default',
                        'options' => $header_dynamic['text_colors_groups_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'drop_title_custom_color',
                        'title' => __('Custom Dropdown Titles Color', 'pixfort-core'),
                        'val' => '#333',
                        'dependency' => array(
                            'field' => 'drop_title_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'drop_text_color',
                        'title' => __('Dropdown Text Color', 'pixfort-core'),
                        'val' => 'body-default',
                        'options' => $header_dynamic['text_colors_groups_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'drop_text_custom_color',
                        'title' => __('Custom Dropdown Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'dependency' => array(
                            'field' => 'drop_text_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'nav_line_color',
                        'title' => __('Menu underline color (Only in desktop mode)', 'pixfort-core'),
                        'val' => 'pix-default-nav-line',
                        'options' => array(
                            array(
                                'name' => __('Default (Gradient)', 'pixfort-core'),
                                'value' => 'pix-default-nav-line'
                            ),
                            array(
                                'name' => __('Primary', 'pixfort-core'),
                                'value' => 'pix-primary-nav-line'
                            ),
                            array(
                                'name' => __('Secondary', 'pixfort-core'),
                                'value' => 'pix-secondary-nav-line'
                            ),
                            array(
                                'name' => __('Dark', 'pixfort-core'),
                                'value' => 'pix-dark-nav-line'
                            ),
                            array(
                                'name' => __('Light', 'pixfort-core'),
                                'value' => 'pix-light-nav-line'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'nav_scroll_line_color',
                        'title' => __('Menu underline scroll color (Only in desktop mode)', 'pixfort-core'),
                        'val' => 'default',
                        'options' => array(
                            array(
                                'name' => __('Default', 'pixfort-core'),
                                'value' => 'default'
                            ),
                            array(
                                'name' => __('Gradient', 'pixfort-core'),
                                'value' => 'pix-gradient-scroll-nav-line'
                            ),
                            array(
                                'name' => __('Primary', 'pixfort-core'),
                                'value' => 'pix-primary-scroll-nav-line'
                            ),
                            array(
                                'name' => __('Secondary', 'pixfort-core'),
                                'value' => 'pix-secondary-scroll-nav-line'
                            ),
                            array(
                                'name' => __('Dark', 'pixfort-core'),
                                'value' => 'pix-dark-scroll-nav-line'
                            ),
                            array(
                                'name' => __('Light', 'pixfort-core'),
                                'value' => 'pix-light-scroll-nav-line'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'active_line',
                        'title' => __('Enable underline for active items', 'pixfort-core'),
                        'val' => 'pix-nav-disabled-line',
                        'options' => array(
                            array(
                                'name' => __('Disabled', 'pixfort-core'),
                                'value' => 'pix-nav-disabled-line'
                            ),
                            array(
                                'name' => __('Yes, only for exact active item', 'pixfort-core'),
                                'value' => 'pix-nav-active-line'
                            ),
                            array(
                                'name' => __('Yes, for active item or if it has an active sub item', 'pixfort-core'),
                                'value' => 'pix-nav-global-active-line'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'menu_style',
                        'title' => __('Menu Style', 'pixfort-core'),
                        'description' => __('This option is available in Desktop Only', 'pixfort-core'),
                        'val' => 'default',
                        'options' => array(
                            array(
                                'name' => __('Default', 'pixfort-core'),
                                'value' => 'default'
                            ),
                            array(
                                'name' => __('Hidden', 'pixfort-core'),
                                'value' => 'hidden'
                            )
                        )
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'hidden_state',
                        'title' => __('Remember if user opened the Hidden Menu', 'pixfort-core'),
                        'val' => false,
                        'dependency' => array(
                            'field' => 'menu_style',
                            'val' => 'hidden'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'dropdown_angle',
                        'title' => __('Dispaly angle icon for dropdown items', 'pixfort-core'),
                        'val' => 'no',
                        'options' => array(
                            array(
                                'name' => __('No (Default)', 'pixfort-core'),
                                'value' => 'no'
                            ),
                            array(
                                'name' => __('Yes', 'pixfort-core'),
                                'value' => 'yes'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'disable_mega',
                        'title' => __('Force Disable Megamenus', 'pixfort-core'),
                        'val' => 'no',
                        'tab' => 'advanced',
                        'options' => array(
                            array(
                                'name' => __('No (Use menu defaults)', 'pixfort-core'),
                                'value' => 'no'
                            ),
                            array(
                                'name' => __('Yes (disable all mega menus)', 'pixfort-core'),
                                'value' => 'disable'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'animation',
                        'title' => __('Animation', 'pixfort-core'),
                        'val' => 'fade-in',
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
                    ),
                    array(
                        'type' => 'pixid',
                        'name' => 'nav_id',
                        'val' => ''
                    )
                )
            )
        );
    }
}
