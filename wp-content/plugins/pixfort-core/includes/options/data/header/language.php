<?php

if (!function_exists('pix_get_header_options_data_language')) {
    function pix_get_header_options_data_language($header_dynamic, $header_assets, $enable_dynamic_colors = false) {
        return array(
            'language' => array(
                'title' => __('Language', 'pixfort-core'),
                'icon' => 'language',
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
                    ),
                    array(
                        'type' => 'alert',
                        'name' => 'height',
                        'title' => __('Note', 'pixfort-core'),
                        'description' => __('Please note that you need to have WPML or Polylang plugin installed on your site in order for the Language switcher to display.', 'pixfort-core'),
                        'val' => ''
                    )
                )
            )
        );
    }
}
