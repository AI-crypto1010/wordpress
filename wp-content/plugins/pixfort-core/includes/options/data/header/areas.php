<?php

if (!function_exists('pix_get_header_options_data_areas')) {
    function pix_get_header_options_data_areas($header_dynamic, $header_assets, $enable_dynamic_colors = false) {
        return array(
            'topbar_area' => array(
                'options' => array(
                    array(
                        'type' => 'select',
                        'name' => 'background',
                        'title' => __('Background', 'pixfort-core'),
                        'val' => 'gray-1',
                        'hasScroll' => true,
                        'options' => $header_dynamic['bg_colors_groups'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_background',
                        'title' => __('Custom background Color', 'pixfort-core'),
                        'val' => '#333',
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'background',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_background',
                        'title' => __('Background', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['bg_colors_groups'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_background',
                        'title' => __('Custom background Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_background',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'hasScroll' => true,
                        'val' => 'body-default',
                        'options' => $header_dynamic['text_colors_groups_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_color',
                        'hasScroll' => true,
                        'title' => __('Custom Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'dependency' => array(
                            'field' => 'color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['text_colors_groups_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_color',
                        'title' => __('Custom Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'bold',
                        'title' => __('Use Bold Text', 'pixfort-core'),
                        'val' => 'on'
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'style',
                        'title' => __('Border Style', 'pixfort-core'),
                        'val' => 'none',
                        'options' => array(
                            array(
                                'name' => __('None', 'pixfort-core'),
                                'value' => 'none'
                            ),
                            array(
                                'name' => __('Line', 'pixfort-core'),
                                'value' => 'border-bottom'
                            ),
                            array(
                                'name' => __('Line wide', 'pixfort-core'),
                                'value' => 'border-bottom-wide'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'line_color',
                        'title' => __('Line Color', 'pixfort-core'),
                        'val' => 'gray-1',
                        'options' => $header_dynamic['border_colors_groups'],
                        'groups' => true,
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'style',
                            'val' => 'border-bottom border-bottom-wide'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_line_color',
                        'title' => __('Custom Line Color', 'pixfort-core'),
                        'val' => '#333',
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'line_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_line_color',
                        'title' => __('Line Color', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['border_colors_groups_with_default'],
                        'groups' => true,
                        'dependency' => array(
                            'field' => 'style',
                            'val' => 'border-bottom border-bottom-wide'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_line_color',
                        'title' => __('Custom Line Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_line_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'radio',
                        'name' => 'header_shadow',
                        'title' => __('Shadow', 'pixfort-core'),
                        'direction' => 'horizontal',
                        'default' => 'none',
                        'hasScroll' => true,
                        'disableCheck' => true,
                        'options' => array(
                            array(
                                'name' => __('None', 'pixfort-core'),
                                'image' => $header_assets['AREA_SHADOW_NONE'],
                                'value' => 'none'
                            ),
                            array(
                                'name' => __('Small', 'pixfort-core'),
                                'image' => $header_assets['AREA_SHADOW_SMALL'],
                                'value' => 'shadow-sm'
                            ),
                            array(
                                'name' => __('Medium', 'pixfort-core'),
                                'image' => $header_assets['AREA_SHADOW_MEDIUM'],
                                'value' => 'shadow'
                            ),
                            array(
                                'name' => __('Large', 'pixfort-core'),
                                'image' => $header_assets['AREA_SHADOW_LARGE'],
                                'value' => 'shadow-lg'
                            )
                        )
                    ),
                    array(
                        'type' => 'radio',
                        'name' => 'scroll_shadow',
                        'title' => __('Shadow', 'pixfort-core'),
                        'direction' => 'horizontal',
                        'val' => '',
                        'default' => '',
                        'isScroll' => true,
                        'disableCheck' => true,
                        'options' => array(
                            array(
                                'name' => __('None', 'pixfort-core'),
                                'image' => $header_assets['AREA_SHADOW_NONE'],
                                'value' => 'none'
                            ),
                            array(
                                'name' => __('Small', 'pixfort-core'),
                                'image' => $header_assets['AREA_SHADOW_SMALL'],
                                'value' => 'shadow-sm'
                            ),
                            array(
                                'name' => __('Medium', 'pixfort-core'),
                                'image' => $header_assets['AREA_SHADOW_MEDIUM'],
                                'value' => 'shadow'
                            ),
                            array(
                                'name' => __('Large', 'pixfort-core'),
                                'image' => $header_assets['AREA_SHADOW_LARGE'],
                                'value' => 'shadow-lg'
                            )
                        )
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'border_radius',
                        'title' => __('Border Radius', 'pixfort-core'),
                        'hasScroll' => true,
                        'val' => ''
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'scroll_border_radius',
                        'title' => __('Border Radius', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'sticky',
                        'title' => __('Sticky Area', 'pixfort-core'),
                        'val' => 'static-area',
                        'options' => array(
                            array(
                                'name' => __('No', 'pixfort-core'),
                                'value' => 'static-area'
                            ),
                            array(
                                'name' => __('Sticky', 'pixfort-core'),
                                'value' => 'is-sticky'
                            ),
                            array(
                                'name' => __('Smart sticky', 'pixfort-core'),
                                'value' => 'is-smart-sticky'
                            )
                        )
                    )
                )
            ),
            'header_area' => array(
                'options' => array(
                    array(
                        'type' => 'select',
                        'name' => 'background',
                        'title' => __('Background', 'pixfort-core'),
                        'val' => 'white',
                        'hasScroll' => true,
                        'options' => $header_dynamic['bg_colors_groups'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_background',
                        'title' => __('Custom background Color', 'pixfort-core'),
                        'val' => '#333',
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'background',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_background',
                        'title' => __('Background', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['bg_colors_groups'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_background',
                        'title' => __('Custom background Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_background',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'val' => 'dark-opacity-4',
                        'hasScroll' => true,
                        'options' => $header_dynamic['text_colors_groups_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_color',
                        'title' => __('Custom Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['text_colors_groups'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'bold',
                        'title' => __('Use Bold Text', 'pixfort-core'),
                        'val' => 'on'
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'style',
                        'title' => __('Border Style', 'pixfort-core'),
                        'val' => 'none',
                        'options' => array(
                            array(
                                'name' => 'None',
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'Line',
                                'value' => 'border-bottom'
                            ),
                            array(
                                'name' => 'Line wide',
                                'value' => 'border-bottom-wide'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'line_color',
                        'title' => __('Line Color', 'pixfort-core'),
                        'val' => 'gray-1',
                        'hasScroll' => true,
                        'options' => $header_dynamic['border_colors_groups'],
                        'groups' => true,
                        'dependency' => array(
                            'field' => 'style',
                            'val' => 'border-bottom border-bottom-wide'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_line_color',
                        'title' => __('Custom Line Color', 'pixfort-core'),
                        'val' => '#333',
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'line_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_line_color',
                        'title' => __('Line Color', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['border_colors_groups_with_default'],
                        'groups' => true,
                        'dependency' => array(
                            'field' => 'style',
                            'val' => 'border-bottom border-bottom-wide'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_line_color',
                        'title' => __('Custom Line Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_line_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'radio',
                        'name' => 'header_shadow',
                        'title' => __('Shadow', 'pixfort-core'),
                        'direction' => 'horizontal',
                        'val' => '',
                        'hasScroll' => true,
                        'disableCheck' => true,
                        'options' => array(
                            array(
                                'name' => 'None',
                                'image' => $header_assets['AREA_SHADOW_NONE'],
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'Small',
                                'image' => $header_assets['AREA_SHADOW_SMALL'],
                                'value' => 'shadow-sm'
                            ),
                            array(
                                'name' => 'Medium',
                                'image' => $header_assets['AREA_SHADOW_MEDIUM'],
                                'value' => 'shadow'
                            ),
                            array(
                                'name' => 'Large',
                                'image' => $header_assets['AREA_SHADOW_LARGE'],
                                'value' => 'shadow-lg'
                            )
                        )
                    ),
                    array(
                        'type' => 'radio',
                        'name' => 'scroll_shadow',
                        'title' => __('Shadow', 'pixfort-core'),
                        'direction' => 'horizontal',
                        'val' => '',
                        'default' => 'shadow-lg',
                        'isScroll' => true,
                        'disableCheck' => true,
                        'options' => array(
                            array(
                                'name' => 'None',
                                'image' => $header_assets['AREA_SHADOW_NONE'],
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'Small',
                                'image' => $header_assets['AREA_SHADOW_SMALL'],
                                'value' => 'shadow-sm'
                            ),
                            array(
                                'name' => 'Medium',
                                'image' => $header_assets['AREA_SHADOW_MEDIUM'],
                                'value' => 'shadow'
                            ),
                            array(
                                'name' => 'Large',
                                'image' => $header_assets['AREA_SHADOW_LARGE'],
                                'value' => 'shadow-lg'
                            )
                        )
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'border_radius',
                        'title' => __('Border Radius', 'pixfort-core'),
                        'hasScroll' => true,
                        'val' => ''
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'scroll_border_radius',
                        'title' => __('Border Radius', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'sticky',
                        'title' => __('Sticky Area', 'pixfort-core'),
                        'val' => 'is-sticky',
                        'options' => array(
                            array(
                                'name' => 'No',
                                'value' => 'static-area'
                            ),
                            array(
                                'name' => 'Sticky',
                                'value' => 'is-sticky'
                            ),
                            array(
                                'name' => 'Smart sticky',
                                'value' => 'is-smart-sticky'
                            )
                        )
                    )
                )
            ),
            'stack_area' => array(
                'options' => array(
                    array(
                        'type' => 'select',
                        'name' => 'background',
                        'title' => __('Background', 'pixfort-core'),
                        'val' => 'gray-1',
                        'hasScroll' => true,
                        'options' => $header_dynamic['bg_colors_groups'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_background',
                        'title' => __('Custom background Color', 'pixfort-core'),
                        'val' => '#333',
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'background',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_background',
                        'title' => __('Background', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['bg_colors_groups'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_background',
                        'title' => __('Custom background Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_background',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'hasScroll' => true,
                        'val' => 'body-default',
                        'options' => $header_dynamic['text_colors_groups_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_color',
                        'title' => __('Custom Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['text_colors_groups_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_color',
                        'title' => __('Custom Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'bold',
                        'title' => __('Use Bold Text', 'pixfort-core'),
                        'val' => 'on'
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'style',
                        'title' => __('Border Style', 'pixfort-core'),
                        'val' => 'none',
                        'options' => array(
                            array(
                                'name' => 'None',
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'Top Line',
                                'value' => 'border-top'
                            ),
                            array(
                                'name' => 'Top Line wide',
                                'value' => 'border-top-wide'
                            ),
                            array(
                                'name' => 'Bottom Line',
                                'value' => 'border-bottom'
                            ),
                            array(
                                'name' => 'Bottom Line wide',
                                'value' => 'border-bottom-wide'
                            ),
                            array(
                                'name' => 'Top & Bottom Lines',
                                'value' => 'border-both'
                            ),
                            array(
                                'name' => 'Top & Bottom Lines wide',
                                'value' => 'border-both-wide'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'line_color',
                        'title' => __('Line Color', 'pixfort-core'),
                        'val' => 'gray-1',
                        'hasScroll' => true,
                        'options' => $header_dynamic['border_colors_groups'],
                        'groups' => true,
                        'dependency' => array(
                            'field' => 'style',
                            'val' => 'border-top border-top-wide border-bottom border-bottom-wide border-both border-both-wide'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_line_color',
                        'title' => __('Custom Line Color', 'pixfort-core'),
                        'val' => '#333',
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'line_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_line_color',
                        'title' => __('Line Color', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['border_colors_groups_with_default'],
                        'groups' => true,
                        'dependency' => array(
                            'field' => 'style',
                            'val' => 'border-top border-top-wide border-bottom border-bottom-wide border-both border-both-wide'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_line_color',
                        'title' => __('Custom Line Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_line_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'radio',
                        'name' => 'header_shadow',
                        'title' => __('Shadow', 'pixfort-core'),
                        'direction' => 'horizontal',
                        'default' => 'none',
                        'hasScroll' => true,
                        'disableCheck' => true,
                        'options' => array(
                            array(
                                'name' => 'None',
                                'image' => $header_assets['AREA_SHADOW_NONE'],
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'Small',
                                'image' => $header_assets['AREA_SHADOW_SMALL'],
                                'value' => 'shadow-sm'
                            ),
                            array(
                                'name' => 'Medium',
                                'image' => $header_assets['AREA_SHADOW_MEDIUM'],
                                'value' => 'shadow'
                            ),
                            array(
                                'name' => 'Large',
                                'image' => $header_assets['AREA_SHADOW_LARGE'],
                                'value' => 'shadow-lg'
                            )
                        )
                    ),
                    array(
                        'type' => 'radio',
                        'name' => 'scroll_shadow',
                        'title' => __('Shadow', 'pixfort-core'),
                        'direction' => 'horizontal',
                        'val' => '',
                        'default' => '',
                        'isScroll' => true,
                        'disableCheck' => true,
                        'options' => array(
                            array(
                                'name' => 'None',
                                'image' => $header_assets['AREA_SHADOW_NONE'],
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'Small',
                                'image' => $header_assets['AREA_SHADOW_SMALL'],
                                'value' => 'shadow-sm'
                            ),
                            array(
                                'name' => 'Medium',
                                'image' => $header_assets['AREA_SHADOW_MEDIUM'],
                                'value' => 'shadow'
                            ),
                            array(
                                'name' => 'Large',
                                'image' => $header_assets['AREA_SHADOW_LARGE'],
                                'value' => 'shadow-lg'
                            )
                        )
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'border_radius',
                        'title' => __('Border Radius', 'pixfort-core'),
                        'hasScroll' => true,
                        'val' => ''
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'scroll_border_radius',
                        'title' => __('Border Radius', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'sticky',
                        'title' => __('Sticky Area', 'pixfort-core'),
                        'val' => 'static-area',
                        'options' => array(
                            array(
                                'name' => 'No',
                                'value' => 'static-area'
                            ),
                            array(
                                'name' => 'Sticky',
                                'value' => 'is-sticky'
                            ),
                            array(
                                'name' => 'Smart sticky',
                                'value' => 'is-smart-sticky'
                            )
                        )
                    )
                )
            ),
            'col_area' => array(
                'options' => array(
                    array(
                        'type' => 'radio',
                        'name' => 'align',
                        'title' => __('Elements Align', 'pixfort-core'),
                        'description' => 'The elements align of the column',
                        'direction' => 'horizontal',
                        'val' => '',
                        'disableCheck' => true,
                        'options' => array(
                            array(
                                'name' => 'Default',
                                'image' => $header_assets['ELEMENTS_ALIGN_DEFAULT'],
                                'value' => ''
                            ),
                            array(
                                'name' => 'Start',
                                'image' => $header_assets['ELEMENTS_ALIGN_START'],
                                'value' => 'text-left'
                            ),
                            array(
                                'name' => 'Center',
                                'image' => $header_assets['ELEMENTS_ALIGN_CENTER'],
                                'value' => 'text-center'
                            ),
                            array(
                                'name' => 'End',
                                'image' => $header_assets['ELEMENTS_ALIGN_END'],
                                'value' => 'text-right'
                            ),
                            array(
                                'name' => 'Between',
                                'image' => $header_assets['ELEMENTS_ALIGN_BETWEEN'],
                                'value' => 'd-flex'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'background',
                        'title' => __('Background', 'pixfort-core'),
                        'val' => '',
                        'hasScroll' => true,
                        'options' => $header_dynamic['bg_colors_groups_with_default'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_background',
                        'title' => __('Background', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['bg_colors_groups_with_default'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'text_color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'val' => '',
                        'hasScroll' => true,
                        'options' => $header_dynamic['text_colors_groups_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_text_color',
                        'title' => __('Custom Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'text_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_text_color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['text_colors_groups_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_text_color',
                        'title' => __('Custom Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_text_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'padding',
                        'title' => __('Padding', 'pixfort-core'),
                        'hasScroll' => true,
                        'val' => ''
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'scroll_padding',
                        'title' => __('Padding', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'margin',
                        'title' => __('Margin', 'pixfort-core'),
                        'hasScroll' => true,
                        'val' => ''
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'scroll_margin',
                        'title' => __('Margin', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'border_radius',
                        'title' => __('Border Radius', 'pixfort-core'),
                        'hasScroll' => true,
                        'val' => ''
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'scroll_border_radius',
                        'title' => __('Border Radius', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true
                    ),
                    array(
                        'type' => 'radio',
                        'name' => 'size',
                        'title' => __('Size', 'pixfort-core'),
                        'description' => 'Size of the column',
                        'direction' => 'horizontal',
                        'val' => '',
                        'default' => 'flex-1',
                        'disableCheck' => true,
                        'options' => array(
                            array(
                                'name' => 'Default',
                                'image' => $header_assets['ELEMENTS_ALIGN_DEFAULT'],
                                'value' => 'flex-1'
                            ),
                            array(
                                'name' => 'None',
                                'image' => $header_assets['COLUMN_SIZE_NONE'],
                                'value' => 'flex-none'
                            ),
                            array(
                                'name' => 'Grow',
                                'image' => $header_assets['COLUMN_SIZE_GROW'],
                                'value' => 'flex-fill'
                            ),
                            array(
                                'name' => 'Shrink',
                                'image' => $header_assets['COLUMN_SIZE_SHRINK'],
                                'value' => 'flex-shrink-1'
                            ),
                            array(
                                'name' => 'Custom',
                                'image' => $header_assets['COLUMN_SIZE_CUSTOM'],
                                'value' => 'flex-custom'
                            )
                        )
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'custom_size',
                        'title' => __('Custom Size', 'pixfort-core'),
                        'description' => __('Choose a custom width (with the unit: px, %,.. etc).', 'pixfort-core'),
                        'val' => '',
                        'dependency' => array(
                            'field' => 'size',
                            'val' => 'flex-custom'
                        )
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'custom_classes',
                        'title' => __('CSS Classes', 'pixfort-core'),
                        'tab' => 'advanced',
                        'val' => ''
                    )
                )
            ),
            'm_topbar_area' => array(
                'options' => array(
                    array(
                        'type' => 'select',
                        'name' => 'background',
                        'title' => __('Background', 'pixfort-core'),
                        'val' => 'gray-1',
                        'options' => $header_dynamic['bg_colors_groups'],
                        'hasScroll' => true,
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_background',
                        'title' => __('Custom Color', 'pixfort-core'),
                        'val' => '#333',
                        'dependency' => array(
                            'field' => 'background',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_background',
                        'title' => __('Background', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['bg_colors_groups_with_default'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_background',
                        'title' => __('Custom background Color', 'pixfort-core'),
                        'val' => '#fff',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_background',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'val' => 'body-default',
                        'hasScroll' => true,
                        'options' => $header_dynamic['text_colors_groups_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_color',
                        'title' => __('Custom Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['text_colors_groups_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_color',
                        'title' => __('Custom Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'bold',
                        'title' => __('Use Bold Text', 'pixfort-core'),
                        'val' => 'on'
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'style',
                        'title' => __('Border Style', 'pixfort-core'),
                        'val' => 'none',
                        'options' => array(
                            array(
                                'name' => 'None',
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'Line',
                                'value' => 'border-bottom'
                            ),
                            array(
                                'name' => 'Line wide',
                                'value' => 'border-bottom-wide'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'line_color',
                        'title' => __('Line Color', 'pixfort-core'),
                        'val' => 'gray-1',
                        'hasScroll' => true,
                        'options' => $header_dynamic['border_colors_groups'],
                        'groups' => true,
                        'dependency' => array(
                            'field' => 'style',
                            'val' => 'border-bottom border-bottom-wide'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_line_color',
                        'title' => __('Custom Line Color', 'pixfort-core'),
                        'val' => '#333',
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'line_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_line_color',
                        'title' => __('Line Color', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['border_colors_groups_with_default'],
                        'groups' => true,
                        'dependency' => array(
                            'field' => 'style',
                            'val' => 'border-bottom border-bottom-wide'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_line_color',
                        'title' => __('Custom Line Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_line_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'radio',
                        'name' => 'header_shadow',
                        'title' => __('Shadow', 'pixfort-core'),
                        'direction' => 'horizontal',
                        'default' => 'none',
                        'hasScroll' => true,
                        'disableCheck' => true,
                        'options' => array(
                            array(
                                'name' => 'None',
                                'image' => $header_assets['AREA_SHADOW_NONE'],
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'Small',
                                'image' => $header_assets['AREA_SHADOW_SMALL'],
                                'value' => 'shadow-sm'
                            ),
                            array(
                                'name' => 'Medium',
                                'image' => $header_assets['AREA_SHADOW_MEDIUM'],
                                'value' => 'shadow'
                            ),
                            array(
                                'name' => 'Large',
                                'image' => $header_assets['AREA_SHADOW_LARGE'],
                                'value' => 'shadow-lg'
                            )
                        )
                    ),
                    array(
                        'type' => 'radio',
                        'name' => 'scroll_shadow',
                        'title' => __('Shadow', 'pixfort-core'),
                        'direction' => 'horizontal',
                        'val' => '',
                        'default' => '',
                        'isScroll' => true,
                        'disableCheck' => true,
                        'options' => array(
                            array(
                                'name' => 'None',
                                'image' => $header_assets['AREA_SHADOW_NONE'],
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'Small',
                                'image' => $header_assets['AREA_SHADOW_SMALL'],
                                'value' => 'shadow-sm'
                            ),
                            array(
                                'name' => 'Medium',
                                'image' => $header_assets['AREA_SHADOW_MEDIUM'],
                                'value' => 'shadow'
                            ),
                            array(
                                'name' => 'Large',
                                'image' => $header_assets['AREA_SHADOW_LARGE'],
                                'value' => 'shadow-lg'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'sticky',
                        'title' => __('Sticky Area', 'pixfort-core'),
                        'val' => 'static-area',
                        'options' => array(
                            array(
                                'name' => 'No',
                                'value' => 'static-area'
                            ),
                            array(
                                'name' => 'Sticky',
                                'value' => 'is-sticky'
                            ),
                            array(
                                'name' => 'Smart sticky',
                                'value' => 'is-smart-sticky'
                            )
                        )
                    )
                )
            ),
            'm_header_area' => array(
                'options' => array(
                    array(
                        'type' => 'select',
                        'name' => 'background',
                        'title' => __('Background', 'pixfort-core'),
                        'val' => 'white',
                        'hasScroll' => true,
                        'options' => $header_dynamic['bg_colors_groups'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_background',
                        'title' => __('Custom background Color', 'pixfort-core'),
                        'val' => '#333',
                        'dependency' => array(
                            'field' => 'background',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_background',
                        'title' => __('Background', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['bg_colors_groups_with_default'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_background',
                        'title' => __('Custom background Color', 'pixfort-core'),
                        'val' => '#fff',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_background',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'val' => 'body-default',
                        'hasScroll' => true,
                        'options' => $header_dynamic['text_colors_groups_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_color',
                        'title' => __('Custom Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'dependency' => array(
                            'field' => 'color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['text_colors_groups_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_color',
                        'title' => __('Custom Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'bold',
                        'title' => __('Use Bold Text', 'pixfort-core'),
                        'val' => 'on'
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'style',
                        'title' => __('Border Style', 'pixfort-core'),
                        'val' => 'none',
                        'options' => array(
                            array(
                                'name' => 'None',
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'Line',
                                'value' => 'border-bottom'
                            ),
                            array(
                                'name' => 'Line wide',
                                'value' => 'border-bottom-wide'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'line_color',
                        'title' => __('Line Color', 'pixfort-core'),
                        'val' => 'gray-1',
                        'hasScroll' => true,
                        'options' => $header_dynamic['border_colors_groups'],
                        'groups' => true,
                        'dependency' => array(
                            'field' => 'style',
                            'val' => 'border-bottom border-bottom-wide'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_line_color',
                        'title' => __('Custom Line Color', 'pixfort-core'),
                        'val' => '#333',
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'line_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_line_color',
                        'title' => __('Line Color', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['border_colors_groups_with_default'],
                        'groups' => true,
                        'dependency' => array(
                            'field' => 'style',
                            'val' => 'border-bottom border-bottom-wide'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_line_color',
                        'title' => __('Custom Line Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_line_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'radio',
                        'name' => 'header_shadow',
                        'title' => __('Shadow', 'pixfort-core'),
                        'direction' => 'horizontal',
                        'default' => 'none',
                        'hasScroll' => true,
                        'disableCheck' => true,
                        'options' => array(
                            array(
                                'name' => 'None',
                                'image' => $header_assets['AREA_SHADOW_NONE'],
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'Small',
                                'image' => $header_assets['AREA_SHADOW_SMALL'],
                                'value' => 'shadow-sm'
                            ),
                            array(
                                'name' => 'Medium',
                                'image' => $header_assets['AREA_SHADOW_MEDIUM'],
                                'value' => 'shadow'
                            ),
                            array(
                                'name' => 'Large',
                                'image' => $header_assets['AREA_SHADOW_LARGE'],
                                'value' => 'shadow-lg'
                            )
                        )
                    ),
                    array(
                        'type' => 'radio',
                        'name' => 'scroll_shadow',
                        'title' => __('Shadow', 'pixfort-core'),
                        'direction' => 'horizontal',
                        'val' => '',
                        'default' => '',
                        'isScroll' => true,
                        'disableCheck' => true,
                        'options' => array(
                            array(
                                'name' => 'None',
                                'image' => $header_assets['AREA_SHADOW_NONE'],
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'Small',
                                'image' => $header_assets['AREA_SHADOW_SMALL'],
                                'value' => 'shadow-sm'
                            ),
                            array(
                                'name' => 'Medium',
                                'image' => $header_assets['AREA_SHADOW_MEDIUM'],
                                'value' => 'shadow'
                            ),
                            array(
                                'name' => 'Large',
                                'image' => $header_assets['AREA_SHADOW_LARGE'],
                                'value' => 'shadow-lg'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'sticky',
                        'title' => __('Sticky Area', 'pixfort-core'),
                        'val' => 'static-area',
                        'options' => array(
                            array(
                                'name' => 'No',
                                'value' => 'static-area'
                            ),
                            array(
                                'name' => 'Sticky',
                                'value' => 'is-sticky'
                            ),
                            array(
                                'name' => 'Smart sticky',
                                'value' => 'is-smart-sticky'
                            )
                        )
                    )
                )
            ),
            'm_stack_area' => array(
                'options' => array(
                    array(
                        'type' => 'select',
                        'name' => 'background',
                        'title' => __('Background', 'pixfort-core'),
                        'val' => 'white',
                        'options' => $header_dynamic['bg_colors_groups'],
                        'hasScroll' => true,
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_background',
                        'title' => __('Custom Background Color', 'pixfort-core'),
                        'val' => '#333',
                        'dependency' => array(
                            'field' => 'background',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_background',
                        'title' => __('Background', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['bg_colors_groups_with_default'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_background',
                        'title' => __('Custom background Color', 'pixfort-core'),
                        'val' => '#fff',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_background',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'val' => 'body-default',
                        'hasScroll' => true,
                        'options' => $header_dynamic['text_colors_groups_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_color',
                        'title' => __('Custom Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['text_colors_groups_custom'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_color',
                        'title' => __('Custom Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'bold',
                        'title' => __('Use Bold Text', 'pixfort-core'),
                        'val' => 'on'
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'style',
                        'title' => __('Border Style', 'pixfort-core'),
                        'val' => 'none',
                        'options' => array(
                            array(
                                'name' => 'None',
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'Top Line',
                                'value' => 'border-top'
                            ),
                            array(
                                'name' => 'Top Line wide',
                                'value' => 'border-top-wide'
                            ),
                            array(
                                'name' => 'Bottom Line',
                                'value' => 'border-bottom'
                            ),
                            array(
                                'name' => 'Bottom Line wide',
                                'value' => 'border-bottom-wide'
                            ),
                            array(
                                'name' => 'Top & Bottom Lines',
                                'value' => 'border-both'
                            ),
                            array(
                                'name' => 'Top & Bottom Lines wide',
                                'value' => 'border-both-wide'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'line_color',
                        'title' => __('Line Color', 'pixfort-core'),
                        'val' => 'gray-1',
                        'hasScroll' => true,
                        'options' => $header_dynamic['border_colors_groups'],
                        'groups' => true,
                        'dependency' => array(
                            'field' => 'style',
                            'val' => 'border-top border-top-wide border-bottom border-bottom-wide border-both border-both-wide'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_line_color',
                        'title' => __('Custom Line Color', 'pixfort-core'),
                        'val' => '#333',
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'line_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_line_color',
                        'title' => __('Line Color', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['border_colors_groups_with_default'],
                        'groups' => true,
                        'dependency' => array(
                            'field' => 'style',
                            'val' => 'border-top border-top-wide border-bottom border-bottom-wide border-both border-both-wide'
                        )
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_line_color',
                        'title' => __('Custom Line Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_line_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'radio',
                        'name' => 'header_shadow',
                        'title' => __('Shadow', 'pixfort-core'),
                        'direction' => 'horizontal',
                        'default' => 'none',
                        'hasScroll' => true,
                        'disableCheck' => true,
                        'options' => array(
                            array(
                                'name' => 'None',
                                'image' => $header_assets['AREA_SHADOW_NONE'],
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'Small',
                                'image' => $header_assets['AREA_SHADOW_SMALL'],
                                'value' => 'shadow-sm'
                            ),
                            array(
                                'name' => 'Medium',
                                'image' => $header_assets['AREA_SHADOW_MEDIUM'],
                                'value' => 'shadow'
                            ),
                            array(
                                'name' => 'Large',
                                'image' => $header_assets['AREA_SHADOW_LARGE'],
                                'value' => 'shadow-lg'
                            )
                        )
                    ),
                    array(
                        'type' => 'radio',
                        'name' => 'scroll_shadow',
                        'title' => __('Shadow', 'pixfort-core'),
                        'direction' => 'horizontal',
                        'val' => '',
                        'default' => '',
                        'isScroll' => true,
                        'disableCheck' => true,
                        'options' => array(
                            array(
                                'name' => 'None',
                                'image' => $header_assets['AREA_SHADOW_NONE'],
                                'value' => 'none'
                            ),
                            array(
                                'name' => 'Small',
                                'image' => $header_assets['AREA_SHADOW_SMALL'],
                                'value' => 'shadow-sm'
                            ),
                            array(
                                'name' => 'Medium',
                                'image' => $header_assets['AREA_SHADOW_MEDIUM'],
                                'value' => 'shadow'
                            ),
                            array(
                                'name' => 'Large',
                                'image' => $header_assets['AREA_SHADOW_LARGE'],
                                'value' => 'shadow-lg'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'sticky',
                        'title' => __('Sticky Area', 'pixfort-core'),
                        'val' => 'static-area',
                        'options' => array(
                            array(
                                'name' => 'No',
                                'value' => 'static-area'
                            ),
                            array(
                                'name' => 'Sticky',
                                'value' => 'is-sticky'
                            ),
                            array(
                                'name' => 'Smart sticky',
                                'value' => 'is-smart-sticky'
                            )
                        )
                    )
                )
            ),
            'm_col_area' => array(
                'options' => array(
                    array(
                        'type' => 'select',
                        'name' => 'align',
                        'title' => __('Elements Align', 'pixfort-core'),
                        'val' => 'text-center',
                        'options' => array(
                            array(
                                'name' => 'Left',
                                'value' => 'text-left'
                            ),
                            array(
                                'name' => 'Center',
                                'value' => 'text-center'
                            ),
                            array(
                                'name' => 'Right',
                                'value' => 'text-right'
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'text_color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'val' => '',
                        'hasScroll' => true,
                        'options' => $header_dynamic['text_colors_groups'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'custom_text_color',
                        'title' => __('Custom Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'hasScroll' => true,
                        'dependency' => array(
                            'field' => 'text_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'scroll_text_color',
                        'title' => __('Text Color', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true,
                        'options' => $header_dynamic['text_colors_groups'],
                        'groups' => true
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'scroll_custom_text_color',
                        'title' => __('Custom Text Color', 'pixfort-core'),
                        'val' => '#333',
                        'isScroll' => true,
                        'dependency' => array(
                            'field' => 'scroll_text_color',
                            'val' => 'custom'
                        )
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'padding',
                        'title' => __('Padding', 'pixfort-core'),
                        'hasScroll' => true,
                        'val' => ''
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'scroll_padding',
                        'title' => __('Padding', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'margin',
                        'title' => __('Margin', 'pixfort-core'),
                        'hasScroll' => true,
                        'val' => ''
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'scroll_margin',
                        'title' => __('Margin', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'border_radius',
                        'title' => __('Border Radius', 'pixfort-core'),
                        'hasScroll' => true,
                        'val' => ''
                    ),
                    array(
                        'type' => 'dimensions',
                        'name' => 'scroll_border_radius',
                        'title' => __('Border Radius', 'pixfort-core'),
                        'val' => '',
                        'isScroll' => true
                    )
                )
            )
        );
    }
}
