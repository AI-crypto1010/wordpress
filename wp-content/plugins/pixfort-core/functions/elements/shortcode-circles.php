<?php

// Circles ----------------------------------------------
vc_map( array (
    'base' 			=> 'circles',
    'name' 			=> __('Circles', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/circles.png',
    'description' 	=> __('Add circle images with effect and button', 'pixfort-core'),
    'params' 		=> array_merge(
        array (

            array(
                'type' => 'param_group',
                'value' => '',
                'param_name' => 'circles',
                'heading' 		=> __('Circles', 'pixfort-core'),
                'description' 	=> __('Add each circle in the desired order.', 'pixfort-core'),
                'params' => array(
                    array (
                        'param_name' 	=> 'title',
                        'type' 			=> 'textfield',
                        'heading' 		=> __('Title', 'pixfort-core'),
                        'admin_label'	=> true,
                    ),
                    array (
                        'param_name' 	=> 'img',
                        'type' 			=> 'attach_image',
                        'heading' 		=> __('Image', 'pixfort-core'),
                        'admin_label'	=> false,
                    ),
                    array (
                        'param_name' 	=> 'link',
                        'type' 			=> 'textfield',
                        'heading' 		=> __('Link', 'pixfort-core'),
                        'admin_label'	=> true,
                    ),
                    array (
                        'param_name' 	=> 'color',
                        'type' 			=> 'dropdown',
                        'heading' 		=> __('Color', 'pixfort-core'),
                        'description' 	=> __('Select the color of the circle.', 'pixfort-core'),
                        'admin_label'	=> false,
                        'value'			=> array_flip(array(
                            ''			=> 'Primary Gradient',
                            'pix-bg-custom'		=> 'None',
                        )),
                    ),


                )

            ),

            array(
                "type" => "dropdown",
                "heading" => __("Circles Effect", "js_composer"),
                "param_name" => "effect",
                "admin_label" => true,
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
                "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Circles Hover effect", "js_composer"),
                "param_name" => "hover_effect",
                "admin_label" => true,
                "value" => array_flip(array(
                    ""       => "None",
                    "1"       => "Small hover shadow",
                    "2"       => "Medium hover shadow",
                    "3"       => "Large hover shadow",
                    "4"       => "Inverse Small hover shadow",
                    "5"       => "Inverse Medium hover shadow",
                    "6"       => "Inverse Large hover shadow",
                ))
            ),

            array(
                "type" => "dropdown",
                "heading" => __("Circles Size", "js_composer"),
                "param_name" => "circles_size",
                "admin_label" => true,
                "value" => array_flip(array(
                    "pix-sm-circles"       => "Small (Default)",
                    "pix-md-circles"       => "Medium",
                    "pix-lg-circles"       => "Large",
                ))
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Circles Align", "js_composer"),
                "param_name" => "circles_align",
                "admin_label" => true,
                "value" => array_flip(array(
                    "justify-content-start"       => "Start (Default)",
                    "justify-content-center"       => "Center",
                    "justify-content-end"       => "End",
                ))
            ),

            array(
                "param_name" => "circles_align_mobile",
                "heading" => __("Mobile Circles Align", "js_composer"),
                "type" => "dropdown",
                "admin_label" => true,
                "std" => "center",
                "value" => array_flip(array(
                    "default"       => "Default (Same as Desktop)",
                    "left"       => "Start",
                    "center"       => "Center",
                    "right"       => "End",
                ))
            ),

            array (
                'param_name' 	=> 'animation',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Animation', 'pixfort-core'),
                'description' 	=> __('Select the animation of the heading.', 'pixfort-core'),
                'admin_label'	=> false,
                'std'	=> 'fade-in-left',
                'value'			=> pix_get_animations(),
            ),
            array (
                'param_name' 	=> 'delay',
                'type' 			=> 'textfield',
                'heading' 		=> __('Animation delay (in miliseconds)', 'pixfort-core'),
                'admin_label'	=> true,
                'std'	=> '1000',
                "dependency" => array(
                    "element" => "animation",
                    "not_empty" => true
                ),
            ),


            array(
                'type' => 'css_editor',
                'heading' => __( 'Css', 'pixfort-core' ),
                'param_name' => 'c_css',
                'group' => __( 'Design options', 'pixfort-core' ),
            ),

            array(
                'type' => 'css_editor',
                'heading' => __( 'Css', 'pixfort-core' ),
                'param_name' => 'css',
                'group' => __( 'Button Design options', 'pixfort-core' ),
            )
        ),

        pix_add_params_to_group($button_params,"Button settings")

    )
));

?>
