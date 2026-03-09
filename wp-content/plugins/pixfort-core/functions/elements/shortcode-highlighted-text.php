<?php

$pix_highlighted_items_params = array(

    array(
        'param_name'     => 'text',
        'type'             => 'textfield',
        'heading'         => __('Text', 'pixfort-core'),
        'admin_label'    => true,
    ),
    array(
        "type" => "checkbox",
        "heading" => __("Highlighted", "pixfort-core"),
        "param_name" => "is_highlighted",
        "value" => __("Yes", "pixfort-core"),
    ),

    array(
        'param_name'     => 'highlight_color',
        'type'             => 'colorpicker',
        'heading'         => __('Highlight color', 'pixfort-core'),
        "std" => "#ffd900",
        "dependency" => array(
            "element" => "is_highlighted",
            "not_empty" => true
        ),
    ),
    array(
        'param_name'     => 'custom_height',
        'type'             => 'textfield',
        'heading'         => __('Custom height', 'pixfort-core'),
        'admin_label'    => true,
        'description'     => __('Input a number between 0 and 100 (default is 30).', 'pixfort-core'),
        "dependency" => array(
            "element" => "is_highlighted",
            "not_empty" => true
        ),
    ),

    array(
        "type" => "checkbox",
        "heading" => __("Title format", "pixfort-core"),
        "param_name" => "bold",
        "value" => array("Bold" => "font-weight-bold"),
        // "std" => "font-weight-bold"
    ),
    array(
        "type" => "checkbox",
        "param_name" => "italic",
        "value" => array("Italic" => "font-italic",),
    ),
    array(
        "type" => "checkbox",
        "param_name" => "heading_font",
        "std" => "heading-font",
        "value" => array("Heading font" => "heading-font",),
    ),

    array(
        "type" => "checkbox",
        "heading" => __("Add new line after this element", "pixfort-core"),
        "param_name" => "new_line",
        "value" => __("Yes", "pixfort-core"),
    ),
);

    $pix_highlighted_items_params = array(
        array(
            'param_name'     => 'is_highlighted',
            'type'             => 'dropdown',
            'heading'         => __('Type', 'pixfort-core'),
            'admin_label'    => false,
            'value'         => array(
                __('Normal text', 'pixfort-core')     => '',
                __('Highlighted text', 'pixfort-core')    => 'true',
                __('Image', 'pixfort-core')        => 'image',
            ),
        ),
        array(
            'param_name'     => 'text',
            'type'             => 'textfield',
            'heading'         => __('Text', 'pixfort-core'),
            'admin_label'    => true,
            "dependency" => array(
                "element" => "is_highlighted",
                "value" => array('', "true")
            ),
        ),
        // array(
        //     'param_name'     => 'highlighted_color_type',
        //     'type'             => 'dropdown',
        //     'heading'         => __('Color Type', 'pixfort-core'),
        //     'admin_label'    => false,
        //     "dependency" => array(
        //         "element" => "is_highlighted",
        //         "value" => array("true")
        //     ),
        //     'value'         => array(
        //         __('Custom Color', 'pixfort-core')     => 'simple',
        //         __('Custom Gradient', 'pixfort-core')    => 'gradient',
        //     ),
        // ),
        array(
            'param_name'     => 'highlight_color',
            'type'             => 'colorpicker',
            'heading'         => __('Highlight color', 'pixfort-core'),
            "std" => "#ffd900",
            "dependency" => array(
                "element" => "is_highlighted",
                "value" => array("true")
            ),
        ),



        // array(
        //     'param_name'     => 'highlight_gradient',
        //     'type'             => 'pix_gradient_picker',
        //     'heading'         => __('Gradient custom picker', 'pixfort-core'),
        //     "dependency" => array(
        //         "element" => "highlighted_color_type",
        //         "value" => "gradient"
        //     ),
        // ),
        array(
            'param_name'     => 'custom_height',
            'type'             => 'textfield',
            'heading'         => __('Custom height', 'pixfort-core'),
            'admin_label'    => true,
            'description'     => __('Input a number between 0 and 100 (default is 30).', 'pixfort-core'),
            "dependency" => array(
                "element" => "is_highlighted",
                "value" => "true"
            ),
        ),

        array(
            "type" => "checkbox",
            "heading" => __("Title format", "pixfort-core"),
            "param_name" => "bold",
            "value" => array("Bold" => "font-weight-bold"),
            "dependency" => array(
                "element" => "is_highlighted",
                "value" => array('', "true")
            ),
        ),
        array(
            "type" => "checkbox",
            "param_name" => "italic",
            "value" => array("Italic" => "font-italic",),
            "dependency" => array(
                "element" => "is_highlighted",
                "value" => array('', "true")
            ),
        ),
        array(
            "type" => "checkbox",
            "param_name" => "heading_font",
            "std" => "heading-font",
            "value" => array("Heading font" => "heading-font",),
            "dependency" => array(
                "element" => "is_highlighted",
                "value" => array('', "true")
            ),
        ),
        array(
            "param_name" => "has_color",
            "type" => "checkbox",
            "heading" => __("Different color", "pixfort-core"),
            "value" => __("Yes", "pixfort-core"),
            "dependency" => array(
                "element" => "is_highlighted",
                "value" => array('', "true")
            ),
        ),

        array(
            'param_name'     => 'item_color',
            'type'             => 'dropdown',
            'heading'         => __('Text Color', 'pixfort-core'),
            'admin_label'    => false,
            'value'         => array_merge(
                $colors,
                array("Custom Gradient" => 'custom-gradient')
            ),
            "dependency" => array(
                "element" => "has_color",
                'not_empty' => true,
            ),
        ),
        array(
            'param_name'     => 'item_custom_color',
            'type'             => 'colorpicker',
            'heading'         => __('Custom Text color', 'pixfort-core'),
            'admin_label'    => false,
            'value'       => '#333',
            "dependency" => array(
                "element" => "item_color",
                "value" => "custom"
            ),
        ),
        array(
            'param_name'     => 'item_custom_gradient_color',
            'type'             => 'pix_gradient_picker',
            'heading'         => __('Gradient custom picker', 'pixfort-core'),
            "dependency" => array(
                "element" => "item_color",
                "value" => "custom-gradient"
            ),
        ),


        array(
            'param_name'     => 'image',
            'type'             => 'attach_image',
            'heading'         => __('Image', 'pixfort-core'),
            'admin_label'    => false,
            "dependency" => array(
                "element" => "is_highlighted",
                "value" => "image"
            ),
        ),
        array(
            'param_name'     => 'image_size',
            'type'             => 'textfield',
            'heading'         => __('Image Size', 'pixfort-core'),
            'description' => __('The size of the image (in pixels), leave empty for full size.', 'pixfort-core'),
            'admin_label'    => false,
            "dependency" => array(
                "element" => "is_highlighted",
                "value" => "image"
            ),
        ),
        array(
            'param_name'     => 'rounded_img',
            'type'             => 'dropdown',
            'heading'         => __('Rounded image', 'pixfort-core'),
            'admin_label'    => false,
            'value'         => array(
                __('No', 'pixfort-core')                 => 'rounded-0',
                __('Rounded Small', 'pixfort-core')            => 'rounded',
                __('Rounded Large', 'pixfort-core')        => 'rounded-lg',
                __('Rounded 5px', 'pixfort-core')        => 'rounded-xl',
                __('Rounded 10px', 'pixfort-core')        => 'rounded-10',
                __('Circle', 'pixfort-core')                => 'rounded-circle',
            ),
            'save_always' => true,
            "dependency" => array(
                "element" => "is_highlighted",
                "value" => 'image'
            ),
        ),
        array(
            "param_name" => "style",
            "type" => "dropdown",
            "heading" => __("Shadow Style", "js_composer"),
            "admin_label" => false,
            "value" => array_flip(array(
                "" => "Default",
                "1"       => "Small shadow",
                "2"       => "Medium shadow",
                "3"       => "Large shadow",
                "4"       => "Inverse Small shadow",
                "5"       => "Inverse Medium shadow",
                "6"       => "Inverse Large shadow",
            )),
            'save_always' => true,
            "dependency" => array(
                "element" => "is_highlighted",
                "value" => 'image'
            ),
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Shadow Hover Style", "js_composer"),
            "param_name" => "hover_effect",
            "admin_label" => false,
            "value" => array_flip(array(
                ""       => "None",
                "1"       => "Small hover shadow",
                "2"       => "Medium hover shadow",
                "3"       => "Large hover shadow",
                "4"       => "Inverse Small hover shadow",
                "5"       => "Inverse Medium hover shadow",
                "6"       => "Inverse Large hover shadow",
            )),
            'save_always' => true,
            "dependency" => array(
                "element" => "is_highlighted",
                "value" => 'image'
            ),
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Hover Animation", "js_composer"),
            "param_name" => "add_hover_effect",
            "admin_label" => false,
            "value" => array_flip(array(
                ""       => "None",
                "1"       => "Fly Small",
                "2"       => "Fly Medium",
                "3"       => "Fly Large",
                "4"       => "Scale Small",
                "5"       => "Scale Medium",
                "6"       => "Scale Large",
                "7"       => "Scale Inverse Small",
                "8"       => "Scale Inverse Medium",
                "9"       => "Scale Inverse Large",
            )),
            'save_always' => true,
            "dependency" => array(
                "element" => "is_highlighted",
                "value" => 'image'
            ),
        ),
        array(
            'param_name'     => 'item_animation',
            'type'             => 'dropdown',
            'heading'         => __('Animation', 'pixfort-core'),
            'description'     => __('Select the animation of the heading.', 'pixfort-core'),
            'admin_label'    => false,
            'value'            => pix_get_animations(),
        ),
        array(
            'param_name'     => 'item_delay',
            'type'             => 'textfield',
            'heading'         => __('Animation delay (in miliseconds)', 'pixfort-core'),
            'admin_label'    => true,
            "dependency" => array(
                "element" => "item_animation",
                "not_empty" => true
            ),
        ),
        array(
            "type" => "checkbox",
            "heading" => __("Add new line after this element", "pixfort-core"),
            "param_name" => "new_line",
            "value" => __("Yes", "pixfort-core"),
        ),
    );

$pix_highlighted_text_params = array(
    array(
        'type' => 'param_group',
        'value' => '',
        'param_name' => 'items',
        'heading'         => __('Text', 'pixfort-core'),
        'description'     => __('Add each phrase in the desired order.', 'pixfort-core'),
        'params' => $pix_highlighted_items_params,
    ),
    array(
        'param_name'     => 'title_color',
        'type'             => 'dropdown',
        'heading'         => __('Text color', 'pixfort-core'),
        'admin_label'    => false,
        'value'         => $colors,
        'std'            => 'heading-default',
    ),

    array(
        'param_name'     => 'title_custom_color',
        'type'             => 'colorpicker',
        'heading'         => __('Text color', 'pixfort-core'),
        'admin_label'    => false,
        "dependency" => array(
            "element" => "title_color",
            "value" => "custom"
        ),
    ),

    array(
        'param_name'     => 'title_size',
        'type'             => 'dropdown',
        'heading'         => __('Text size', 'pixfort-core'),
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
        'param_name'     => 'display',
        'type'             => 'dropdown',
        'heading'         => __('Bigger Text', 'pixfort-core'),
        'description'     => __('Larger heading text size to stand out.', 'pixfort-core'),
        'admin_label'    => false,
        'value'            => array_flip(array(
            ''        => 'None',
            'display-1'        => 'Display 1',
            'display-2'        => 'Display 2',
            'display-3'        => 'Display 3',
            'display-4'        => 'Display 4',
        )),
        "dependency" => array(
            "element" => "title_size",
            "value" => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6')
        ),
    ),

    array(
        'param_name'     => 'title_custom_size',
        'type'             => 'textfield',
        'heading'         => __('Custom Text Size', 'pixfort-core'),
        'admin_label'    => false,
        "dependency" => array(
            "element" => "title_size",
            "value" => "custom"
        ),
    ),

    array(
        'param_name'     => 'position',
        'type'             => 'dropdown',
        'heading'         => __('Position', 'pixfort-core'),
        'description'     => __('Select the position of the text.', 'pixfort-core'),
        'admin_label'    => false,
        'value'            => array_flip(array(
            'text-center'        => 'Center',
            'text-left'            => 'Start',
            'text-right'         => 'End',
        )),
    ),

    array(
        'param_name'     => 'animation',
        'type'             => 'dropdown',
        'heading'         => __('Animation', 'pixfort-core'),
        'description'     => __('Select the animation of the text.', 'pixfort-core'),
        'admin_label'    => false,
        'value'            => pix_get_animations(),
    ),

    array(
        'param_name'     => 'delay',
        'type'             => 'textfield',
        'heading'         => __('Animation delay (in miliseconds)', 'pixfort-core'),
        'admin_label'    => true,
        "dependency" => array(
            "element" => "animation",
            "not_empty" => true
        ),
    ),


    array(
        'param_name'     => 'heading_id',
        'type'             => 'el_id',
        'heading'         => __('Element ID', 'pixfort-core'),
        'group'         => "Advanced",
        'settings' => array(
            'auto_generate' => true,
        ),
    ),

    array(
        'param_name'     => 'max_width',
        'type'             => 'textfield',
        'heading'         => __('Text max width (Optional)', 'pixfort-core'),
        'description'     => __('Input text width limit (with unit, for example 400px) instead of filling the width of the container.', 'pixfort-core'),
        'admin_label'    => true,
    ),


    array(
        'type' => 'css_editor',
        'heading' => __('Css', 'pixfort-core'),
        'param_name' => 'css',
        'group' => __('Design options', 'pixfort-core'),
    ),



);


$pix_highlighted_text_params = array_merge(
    $pix_highlighted_text_params,
    array(
        array(
            "param_name" => "disable_resp_img",
            "type" => "checkbox",
            "heading" => __("Disable responsive images size in mobile devices", "pixfort-core"),
            "value" => __("Yes", "pixfort-core"),
            'group'         => "Advanced",
        ),
    )
);

// Highlighted Text -----------------------------
vc_map(array(
    'base'             => 'pix_highlighted_text',
    'name'             => __('Highlighted Text', 'pixfort-core'),
    'category'         => __('pixfort', 'pixfort-core'),
    "weight"    => "1000",
    'class'         => 'pixfort_element',
    'icon'             => PIX_CORE_PLUGIN_URI . 'functions/images/elements/highlighted-text.png',
    'description'     => __('Add highlighted text element', 'pixfort-core'),
    'params'         => $pix_highlighted_text_params
));
