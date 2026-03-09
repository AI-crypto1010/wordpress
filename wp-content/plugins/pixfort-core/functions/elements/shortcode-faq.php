<?php

// FAQ -----------------------------
vc_map(array(
    'base'             => 'pix_faq',
    'name'             => __('FAQ', 'pixfort-core'),
    'category'         => __('pixfort', 'pixfort-core'),
    "weight"    => "1000",
    'class'         => 'pixfort_element',
    'icon'             => PIX_CORE_PLUGIN_URI . 'functions/images/elements/faq.png',
    'description'     => __('Add custom FAQ', 'pixfort-core'),
    'params'         => array(

        array(
            'param_name'     => 'title',
            'type'             => 'textfield',
            'heading'         => __('Title', 'pixfort-core'),
            'admin_label'    => true,
        ),

        array(
            "type" => "checkbox",
            "heading" => __("", "pixfort-core"),
            "param_name" => "title_bold",
            "value" => array(
                __('Bold', 'pixfort-core')     => 'font-weight-bold'
            ),
        ),
        array(
            "type" => "checkbox",
            "heading" => __("", "pixfort-core"),
            "param_name" => "title_secondary",
            "value" => array(
                __('Seconday font', 'pixfort-core')     => 'secondary-font',
            ),
        ),

        array(
            'param_name'     => 'title_color',
            'type'             => 'dropdown',
            'heading'         => __('Title color', 'pixfort-core'),
            'admin_label'    => false,
            'value'         => $colors,
            'std'              => 'heading-default',
        ),

        array(
            'param_name'     => 'title_custom_color',
            'type'             => 'colorpicker',
            'heading'         => __('Icon color', 'pixfort-core'),
            'admin_label'    => false,
            "dependency" => array(
                "element" => "title_color",
                "value" => "custom"
            ),
        ),

        array(
            'param_name'     => 'title_size',
            'type'             => 'dropdown',
            'heading'         => __('Title size', 'pixfort-core'),
            'admin_label'    => false,
            'value'         => array(
                __('H1', 'pixfort-core')     => 'h1',
                __('H2', 'pixfort-core')        => 'h2',
                __('H3', 'pixfort-core')        => 'h3',
                __('H4', 'pixfort-core')        => 'h4',
                __('H5', 'pixfort-core')        => 'h5',
                __('H6', 'pixfort-core')        => 'h6',
                __('Custom', 'pixfort-core')        => 'custom',
            ),
        ),

        array(
            'param_name'     => 'title_custom_size',
            'type'             => 'textfield',
            'heading'         => __('Title Size', 'pixfort-core'),
            'admin_label'    => false,
            "dependency" => array(
                "element" => "title_size",
                "value" => "custom"
            ),
        ),

        array(
            'type' => 'pixfort_icons_picker',
            'heading' => __('Icon', 'pixfort-core'),
            'param_name' => 'icon',
            'value' => 'pixicon-question-circle',
            'settings' => array(
                'emptyIcon' => true, // default true, display an "EMPTY" icon?
                'type' => 'pix-icons',
                'iconsPerPage' => 200, // default 100, how many icons per/page to display
            ),
            'description' => __('Select icon from library.', 'pixfort-core'),
        ),



        array(
            "type" => "checkbox",
            "heading" => __("Different color than title", "pixfort-core"),
            "param_name" => "icon_has_color",
            "value" => __("Yes", "pixfort-core"),
        ),

        array(
            'param_name'     => 'icon_color',
            'type'             => 'dropdown',
            'heading'         => __('Icon color', 'pixfort-core'),
            'admin_label'    => false,
            'std'    => 'heading-default',
            'value'         => $colors,
            "dependency" => array(
                "element" => "icon_has_color",
                'not_empty' => true,
            ),
        ),


        array(
            'param_name'     => 'icon_custom_color',
            'type'             => 'colorpicker',
            'heading'         => __('Icon custom color', 'pixfort-core'),
            'admin_label'    => false,
            "dependency" => array(
                "element" => "icon_color",
                "value" => "custom"
            ),
        ),


        array(
            'param_name'     => 'content',
            'type'             => 'textarea',
            'heading'         => __('Content', 'pixfort-core'),
            'admin_label'    => true,
            'value'         => __('Insert your content here', 'pixfort-core'),
        ),

        array(
            "type" => "checkbox",
            "heading" => __("", "pixfort-core"),
            "param_name" => "content_bold",
            "value" => array(
                __('Bold content', 'pixfort-core')     => 'font-weight-bold'
            ),
        ),
        array(
            "type" => "checkbox",
            "heading" => __("", "pixfort-core"),
            "param_name" => "content_secondary",
            "value" => array(
                __('Heading font content', 'pixfort-core')     => 'secondary-font',
            ),
        ),

        array(
            'param_name'     => 'content_size',
            'type'             => 'dropdown',
            'heading'         => __('Size', 'pixfort-core'),
            'description'     => __('Select the size of the text.', 'pixfort-core'),
            'admin_label'    => false,
            'value'            => array_flip(array(
                ''            => 'Default (16px)',
                'text-xs'        => '12px',
                'text-sm'        => '14px',
                'text-sm'        => '14px',
                'text-18'         => '18px',
                'text-20'         => '20px',
                'text-24'         => '24px',
            )),
        ),

        array(
            'param_name'     => 'content_color',
            'type'             => 'dropdown',
            'heading'         => __('Content color', 'pixfort-core'),
            'admin_label'    => false,
            'value'         => $colors,
        ),


        array(
            'param_name'     => 'content_custom_color',
            'type'             => 'colorpicker',
            'heading'         => __('Content custom color', 'pixfort-core'),
            'admin_label'    => false,
            "dependency" => array(
                "element" => "content_color",
                "value" => "custom"
            ),
        ),



        array(
            'param_name'     => 'animation',
            'type'             => 'dropdown',
            'heading'         => __('Title Animation', 'pixfort-core'),
            'description'     => __('Select the animation of the heading.', 'pixfort-core'),
            'admin_label'    => false,
            'value'            => pix_get_animations(),
        ),

        array(
            'param_name'     => 'delay',
            'type'             => 'textfield',
            'heading'         => __('Title Animation delay (in miliseconds)', 'pixfort-core'),
            'admin_label'    => true,
            "dependency" => array(
                "element" => "animation",
                "not_empty" => true
            ),
        ),

        array(
            'param_name'     => 'content_animation',
            'type'             => 'dropdown',
            'heading'         => __('Content Animation', 'pixfort-core'),
            'description'     => __('Select the animation of the heading.', 'pixfort-core'),
            'admin_label'    => false,
            'value'            => pix_get_animations(),
        ),

        array(
            'param_name'     => 'content_delay',
            'type'             => 'textfield',
            'heading'         => __('Content Animation delay (in miliseconds)', 'pixfort-core'),
            'admin_label'    => true,
            "dependency" => array(
                "element" => "content_animation",
                "not_empty" => true
            ),
        ),

        array(
            'type' => 'css_editor',
            'heading' => __('Css', 'pixfort-core'),
            'param_name' => 'css',
            'group' => __('Design options', 'pixfort-core'),
        ),

    )
));
