<?php

// Photo Stack -------------------------------------------
vc_map(array(
    'base'             => 'pix_photo_stack',
    'name'             => __('Photo Stack', 'pixfort-core'),
    'category'         => __('pixfort', 'pixfort-core'),
    'class'         => 'pixfort_element',
    "weight"    => "1000",
    'icon'             => PIX_CORE_PLUGIN_URI . 'functions/images/elements/photo-stack.png',
    'description'     => __('Add beautiful stacked photos', 'pixfort-core'),
    'params'         => array_merge(
        array(

            array(
                'type' => 'param_group',
                'value' => '',
                'param_name' => 'images',
                'heading'         => __('Images', 'pixfort-core'),
                'description'         => __('Add up tp 4 images.', 'pixfort-core'),
                'params' => array(
                    array(
                        'param_name'     => 'image',
                        'type'             => 'attach_image',
                        'heading'         => __('Image', 'pixfort-core'),
                        'admin_label'    => false,
                    ),
                    array(
                        'param_name'     => 'alt',
                        'type'             => 'textfield',
                        'heading'         => __('Alternative text', 'pixfort-core'),
                        'admin_label'    => true,
                        'save_always' => true,
                    ),
                )
            ),


            array(
                "type" => "checkbox",
                "heading" => __("Animation type", "pixfort-core"),
                "param_name" => "pix_tilt",
                "value" => array_flip(array(
                    "tilt"       => "3D Hover",
                )),
            ),

            array(
                'param_name'     => 'pix_tilt_size',
                'type'             => 'dropdown',
                'heading'         => __('3d hover size', 'pixfort-core'),
                'admin_label'    => false,
                'value'            => array_flip(array(
                    'tilt'            => 'Default',
                    'tilt_big'        => 'Big',
                    'tilt_small'         => 'Small',
                )),
                "dependency" => array(
                    "element" => "pix_tilt",
                    "not_empty" => true
                ),
            ),

            array(
                'param_name'     => 'animation',
                'type'             => 'dropdown',
                'heading'         => __('Animation', 'pixfort-core'),
                'description'     => __('Select the animation of the heading.', 'pixfort-core'),
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
                "type" => "dropdown",
                "heading" => __("Infinite Animation type", "pixfort-core"),
                "param_name" => "pix_infinite_animation",
                "value" => $infinite_animation,
                'admin_label'    => false,
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Infinite Animation Speed", "pixfort-core"),
                "param_name" => "pix_infinite_speed",
                "value" => $animation_speeds,
                'admin_label'    => false,
                "dependency" => array(
                    "element" => "pix_infinite_animation",
                    "not_empty" => true
                ),
            ),

            array(
                'param_name'     => 'rounded_img',
                'type'             => 'dropdown',
                'heading'         => __('Rounded corners', 'pixfort-core'),
                'admin_label'    => false,
                'std'   => 'rounded-lg',
                'value'         => array(
                    __('No', 'pixfort-core')     => 'rounded-0',
                    __('Rounded', 'pixfort-core')        => 'rounded',
                    __('Rounded Large', 'pixfort-core')        => 'rounded-lg',
                    __('Rounded 5px', 'pixfort-core')        => 'rounded-xl',
                    __('Rounded 10px', 'pixfort-core')        => 'rounded-10',
                )
            ),

            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'pixfort-core'),
                'param_name' => 'css',
                'group' => __('Design options', 'pixfort-core'),
            ),

        ),
        $effects_params
    )

));
