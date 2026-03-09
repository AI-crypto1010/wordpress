<?php

// Breadcrumbs element for WPBakery

vc_map(array(
    "name" => __("Breadcrumbs", "pixfort-core"),
    "base" => "pix_breadcrumbs",
    'category' => __('pixfort', 'pixfort-core'),
    "weight"    => "1000",
    'class'         => 'pixfort_element',
    'icon' => PIX_CORE_PLUGIN_URI . 'functions/images/elements/breadcrumbs.png',
    'description' => __('Add breadcrumb navigation', 'pixfort-core'),
    "params" => array(
        array(
            "type" => "dropdown",
            "heading" => __("Text color", "pixfort-core"),
            "param_name" => "text_color",
            "admin_label" => true,
            'value'         => $colors_no_custom,
            'std' => 'body-default',
        ),
        array(
            'param_name' => 'text_custom_color',
            'type' => 'colorpicker',
            'heading' => __('Custom Text color', 'pixfort-core'),
            'admin_label' => false,
            "dependency" => array(
                "element" => "text_color",
                "value" => "custom"
            ),
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Alignment", "pixfort-core"),
            "param_name" => "align",
            "admin_label" => true,
            "value" => array_flip(array(
                'justify-content-start' => 'Left',
                'justify-content-center' => 'Center',
                'justify-content-end' => 'Right',
            )),
            'std' => 'justify-content-start',
        ),
        array(
            'type' => 'css_editor',
            'heading' => __('Css', 'pixfort-core'),
            'param_name' => 'css',
            'group' => __('Design options', 'pixfort-core'),
        )
    )
));
