<?php

if (!function_exists('pix_get_header_options_data_social')) {
    function pix_get_header_options_data_social($header_dynamic, $header_assets, $enable_dynamic_colors = false) {
        $docs_how_to_add_social_icons = '';
        if (class_exists('PixfortCore') && \PixfortCore::instance()->adminCore) {
            $docs_how_to_add_social_icons = \PixfortCore::instance()->adminCore->getParam('docs_how_to_add_social_icons');
        }
        return array(
            'social' => array(
                'title' => __('Social', 'pixfort-core'),
                'icon' => 'twitter',
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
                        'type' => 'alert',
                        'name' => 'height',
                        'title' => __('Note', 'pixfort-core'),
                        'description' => __('Please note that you can manage the Social links from <b>Theme options > Layout > Social icons</b>, for more information about adding social icons please check <a href="' . $docs_how_to_add_social_icons . '" target="_blank"><b>this article</b></a> from our knowledge base.', 'pixfort-core'),
                        'val' => ''
                    )
                )
            )
        );
    }
}
