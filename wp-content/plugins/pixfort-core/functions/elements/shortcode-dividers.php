<?php

// Moving Divder ----------------------------------------------
vc_map( array (
    'base' 			=> 'pix_dividers',
    'name' 			=> __('Dividers', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/dynamic-divider.gif',
    'description' 	=> __('Create custom divider shapes', 'pixfort-core'),
    'params' 		=> array (


        // ===========================================
        // Bottom Dividers
        // ===========================================
        array(
            'type'        => 'pix_img_select',
            'heading'  => 'Shapes Builder',
            'param_name'  => 'bottom_divider_select',
            "class" => "my_param_field",
            'value'       => '0',
            "group"	=> "Bottom Dividers",
        ),

        array(
            'type'        => 'pix_param_globals',
            'param_name'  => 'pix_param_globals',
        ),


        array (
            'type' => 'param_group',
            'value' => '',
            'param_name' => 'bottom_moving_divider_color',
            "group"	=> "Bottom Dividers",
            'params' => array(
                array(
                    "type" => "checkbox",
                    "heading" => __( "Use Gradient", "pixfort-core" ),
                    "param_name" => "d_gradient",
                    "std" => "",
                    "value" => array(
                        "Yes" => "1"
                    ),
                ),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => esc_html__('Layer color', 'pixfort-core'),
                    'param_name'  => 'd_color_1',
                    'value'       => '#f8f9fa',
                ),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => esc_html__('Layer color 2', 'pixfort-core'),
                    'param_name'  => 'd_color_2',
                    'value'       => '#f8f9fa',
                    "dependency" => array(
                        "element" => "d_gradient",
                        "value" => array("1")
                    ),
                ),

            ),
            "dependency" => array(
                "element" => "bottom_divider_select",
                "value" => array("dynamic")
            ),
        ),

        array(
            "type" => "dropdown",
            "heading" => __("The number of Layers", "pixfort-core"),
            "group"	=> "Bottom Dividers",
            "param_name" => "bottom_layers",
            "class" => "pix_param_50",
            "std"		=> '3',
            "dependency" => array(
                "element" => "bottom_divider_select",
                "value" => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
            ),
            "value" => array_flip(array(
                "1"       => "1 Layer",
                "2"       => "2 Layer",
                "3"       => "3 Layer",
            )),
        ),


        array(
            "type" => "checkbox",
            "heading" => __( "Enable animations for layers", "pixfort-core" ),
            "param_name" => "b_has_animation",
            "value" => false,
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "bottom_layers",
                "not_empty" => true
            ),
        ),


        array(
            'type'        => 'pix_param_section',
            'param_name'  => 'pix_param_section_1',
            'pix_title'	=> 'First Layer',
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "bottom_layers",
                "not_empty" => true
            ),
        ),

        array(
            "type" => "checkbox",
            "heading" => __( "Use gradient for the first layer", "pixfort-core" ),
            "param_name" => "b_1_is_gradient",
            "class" => "pix_param_50",
            "value" => false,
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "bottom_layers",
                "not_empty" => true
            ),
        ),

        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Layer 1 color', 'pixfort-core'),
            'param_name'  => 'b_1_color',
            'value'       => '#ffffff',
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "bottom_layers",
                "not_empty" => true
            ),
        ),

        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Layer 1 second gradient color', 'pixfort-core'),
            'param_name'  => 'b_1_color_2',
            'value'       => '#ffffff',
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "b_1_is_gradient",
                "not_empty" => true
            ),
        ),

        array (
            'param_name' 	=> 'b_1_animation',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Animation', 'pixfort-core'),
            'description' 	=> __('Select the animation of the layer.', 'pixfort-core'),
            'admin_label'	=> false,
            'value'			=> pix_get_animations(),
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "b_has_animation",
                "not_empty" => true
            ),
        ),

        array (
            'param_name' 	=> 'b_1_delay',
            'type' 			=> 'textfield',
            'heading' 		=> __('Animation delay (in miliseconds)', 'pixfort-core'),
            'admin_label'	=> true,
            "dependency" => array(
                "element" => "b_1_animation",
                "not_empty" => true
            ),
            "group"	=> "Bottom Dividers",
        ),


        array(
            'type'        => 'pix_param_section',
            'param_name'  => 'pix_param_section_2',
            'pix_title'	=> 'Second Layer',
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "bottom_layers",
                "value" => array("2", "3")
            ),
        ),
        array(
            "type" => "checkbox",
            "heading" => __( "Use gradient for the second layer", "pixfort-core" ),
            "param_name" => "b_2_is_gradient",
            "value" => false,
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "bottom_layers",
                "value" => array("2", "3")
            ),
        ),
        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Layer 2 color', 'pixfort-core'),
            'param_name'  => 'b_2_color',
            'value'       => 'rgba(255,255,255,0.6)',
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "bottom_layers",
                "value" => array("2", "3")
            ),
        ),

        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Layer 2 second gradient color', 'pixfort-core'),
            'param_name'  => 'b_2_color_2',
            'value'       => '#ffffff',
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "b_2_is_gradient",
                "not_empty" => true
            ),
        ),


        array (
            'param_name' 	=> 'b_2_animation',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Animation', 'pixfort-core'),
            'description' 	=> __('Select the animation of the layer.', 'pixfort-core'),
            'admin_label'	=> false,
            'value'			=> pix_get_animations(),
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "b_has_animation",
                "not_empty" => true
            ),
        ),

        array (
            'param_name' 	=> 'b_2_delay',
            'type' 			=> 'textfield',
            'heading' 		=> __('Animation delay (in miliseconds)', 'pixfort-core'),
            'admin_label'	=> true,
            "dependency" => array(
                "element" => "b_2_animation",
                "not_empty" => true
            ),
            "group"	=> "Bottom Dividers",
        ),


        array(
            'type'        => 'pix_param_section',
            'param_name'  => 'pix_param_section_3',
            'pix_title'	=> 'Third Layer',
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "bottom_layers",
                "value" => array("3")
            ),
        ),
        array(
            "type" => "checkbox",
            "heading" => __( "Use gradient for the third layer", "pixfort-core" ),
            "param_name" => "b_3_is_gradient",
            "value" => false,
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "bottom_layers",
                "value" => array("3")
            ),
        ),
        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Layer 3 color', 'pixfort-core'),
            'param_name'  => 'b_3_color',
            'value'       => 'rgba(255,255,255,0.3)',
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "bottom_layers",
                "value" => array("3")
            ),
        ),

        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Layer 3 second gradient color', 'pixfort-core'),
            'param_name'  => 'b_3_color_2',
            'value'       => '#ffffff',
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "b_3_is_gradient",
                "not_empty" => true
            ),
        ),

        array (
            'param_name' 	=> 'b_3_animation',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Animation', 'pixfort-core'),
            'description' 	=> __('Select the animation of the layer.', 'pixfort-core'),
            'admin_label'	=> false,
            'value'			=> pix_get_animations(),
            "group"	=> "Bottom Dividers",
            "dependency" => array(
                "element" => "b_has_animation",
                "not_empty" => true
            ),
        ),

        array (
            'param_name' 	=> 'b_3_delay',
            'type' 			=> 'textfield',
            'heading' 		=> __('Animation delay (in miliseconds)', 'pixfort-core'),
            'admin_label'	=> true,
            "dependency" => array(
                "element" => "b_3_animation",
                "not_empty" => true
            ),
            "group"	=> "Bottom Dividers",
        ),

        array(
            'type'        => 'pix_param_section',
            'param_name'  => 'pix_param_section_4',
            'pix_title'	=> 'Advanced Options',
            "group"	=> "Bottom Dividers",
        ),
        array(
            "type" => "checkbox",
            "heading" => __( "Bring the divider in front of the content", "pixfort-core" ),
            "description"	=> __( "The divider will cover the row elements below it.", "pixfort-core" ),
            "param_name" => "b_divider_in_front",
            "value" => false,
            "group"	=> "Bottom Dividers",
        ),
        array(
            "type" => "checkbox",
            "heading" => __( "Flip the divider", "pixfort-core" ),
            "param_name" => "b_flip_h",
            "value" => false,
            "group"	=> "Bottom Dividers",
        ),

        array (
            'param_name' 	=> 'b_custom_height',
            'type' 			=> 'textfield',
            'heading' 		=> __('Divider custom height (Optional)', 'pixfort-core'),
            "description"	=> __( "Leave empty to use default height or add custom height (with unit, e.g: 200px).", "pixfort-core" ),
            'admin_label'	=> true,
            "group"	=> "Bottom Dividers",
        ),



        // ===========================================
        // Top Dividers
        // ===========================================
        array(
            'type'        => 'pix_img_select',
            'heading'  => 'Shapes Builder',
            'param_name'  => 'top_divider_select',
            "class" => "pix_dividers_top_select",
            'value'       => '0',
            "group"	=> "Top Dividers",
        ),

        array(
            'type'        => 'pix_param_globals',
            'param_name'  => 'pix_param_globals',
        ),


        array (
            'type' => 'param_group',
            'value' => '',
            'param_name' => 'top_moving_divider_color',
            "group"	=> "Top Dividers",
            'params' => array(
                array(
                    "type" => "checkbox",
                    "heading" => __( "Use Gradient", "pixfort-core" ),
                    "param_name" => "d_gradient",
                    "std" => "",
                    "value" => array(
                        "Yes" => "1"
                    ),
                ),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => esc_html__('Layer color', 'pixfort-core'),
                    'param_name'  => 'd_color_1',
                    'value'       => '#f8f9fa',
                ),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => esc_html__('Layer color 2', 'pixfort-core'),
                    'param_name'  => 'd_color_2',
                    'value'       => '#f8f9fa',
                    "dependency" => array(
                        "element" => "d_gradient",
                        "value" => array("1")
                    ),
                ),

            ),
            "dependency" => array(
                "element" => "top_divider_select",
                "value" => array("dynamic")
            ),
        ),

        array(
            "type" => "dropdown",
            "heading" => __("The number of Layers", "pixfort-core"),
            "group"	=> "Top Dividers",
            "param_name" => "top_layers",
            "class" => "pix_param_50",
            "std"		=> '3',
            "dependency" => array(
                "element" => "top_divider_select",
                "value" => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
            ),
            "value" => array_flip(array(
                "1"       => "1 Layer",
                "2"       => "2 Layer",
                "3"       => "3 Layer",
            )),
        ),


        array(
            "type" => "checkbox",
            "heading" => __( "Enable animations for layers", "pixfort-core" ),
            "param_name" => "t_has_animation",
            "value" => false,
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "top_layers",
                "not_empty" => true
            ),
        ),


        array(
            'type'        => 'pix_param_section',
            'param_name'  => 'pix_top_section_1',
            'pix_title'	=> 'First Layer',
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "top_layers",
                "not_empty" => true
            ),
        ),

        array(
            "type" => "checkbox",
            "heading" => __( "Use gradient for the first layer", "pixfort-core" ),
            "param_name" => "t_1_is_gradient",
            "class" => "pix_param_50",
            "value" => false,
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "top_layers",
                "not_empty" => true
            ),
        ),

        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Layer 1 color', 'pixfort-core'),
            'param_name'  => 't_1_color',
            'value'       => '#ffffff',
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "top_layers",
                "not_empty" => true
            ),
        ),

        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Layer 1 second gradient color', 'pixfort-core'),
            'param_name'  => 't_1_color_2',
            'value'       => '#ffffff',
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "t_1_is_gradient",
                "not_empty" => true
            ),
        ),

        array (
            'param_name' 	=> 't_1_animation',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Animation', 'pixfort-core'),
            'description' 	=> __('Select the animation of the layer.', 'pixfort-core'),
            'admin_label'	=> false,
            'value'			=> pix_get_animations(),
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "t_has_animation",
                "not_empty" => true
            ),
        ),

        array (
            'param_name' 	=> 't_1_delay',
            'type' 			=> 'textfield',
            'heading' 		=> __('Animation delay (in miliseconds)', 'pixfort-core'),
            'admin_label'	=> true,
            "dependency" => array(
                "element" => "t_1_animation",
                "not_empty" => true
            ),
            "group"	=> "Top Dividers",
        ),


        array(
            'type'        => 'pix_param_section',
            'param_name'  => 'pix_top_section_2',
            'pix_title'	=> 'Second Layer',
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "top_layers",
                "value" => array("2", "3")
            ),
        ),
        array(
            "type" => "checkbox",
            "heading" => __( "Use gradient for the second layer", "pixfort-core" ),
            "param_name" => "t_2_is_gradient",
            "value" => false,
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "top_layers",
                "value" => array("2", "3")
            ),
        ),
        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Layer 2 color', 'pixfort-core'),
            'param_name'  => 't_2_color',
            'value'       => 'rgba(255,255,255,0.6)',
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "top_layers",
                "value" => array("2", "3")
            ),
        ),

        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Layer 2 second gradient color', 'pixfort-core'),
            'param_name'  => 't_2_color_2',
            'value'       => '#ffffff',
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "t_2_is_gradient",
                "not_empty" => true
            ),
        ),


        array (
            'param_name' 	=> 't_2_animation',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Animation', 'pixfort-core'),
            'description' 	=> __('Select the animation of the layer.', 'pixfort-core'),
            'admin_label'	=> false,
            'value'			=> pix_get_animations(),
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "t_has_animation",
                "not_empty" => true
            ),
        ),

        array (
            'param_name' 	=> 't_2_delay',
            'type' 			=> 'textfield',
            'heading' 		=> __('Animation delay (in miliseconds)', 'pixfort-core'),
            'admin_label'	=> true,
            "dependency" => array(
                "element" => "t_2_animation",
                "not_empty" => true
            ),
            "group"	=> "Top Dividers",
        ),


        array(
            'type'        => 'pix_param_section',
            'param_name'  => 'pix_top_section_3',
            'pix_title'	=> 'Third Layer',
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "top_layers",
                "value" => array("3")
            ),
        ),
        array(
            "type" => "checkbox",
            "heading" => __( "Use gradient for the third layer", "pixfort-core" ),
            "param_name" => "t_3_is_gradient",
            "value" => false,
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "top_layers",
                "value" => array("3")
            ),
        ),
        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Layer 3 color', 'pixfort-core'),
            'param_name'  => 't_3_color',
            'value'       => 'rgba(255,255,255,0.3)',
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "top_layers",
                "value" => array("3")
            ),
        ),

        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Layer 3 second gradient color', 'pixfort-core'),
            'param_name'  => 't_3_color_2',
            'value'       => '#ffffff',
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "t_3_is_gradient",
                "not_empty" => true
            ),
        ),

        array (
            'param_name' 	=> 't_3_animation',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Animation', 'pixfort-core'),
            'description' 	=> __('Select the animation of the layer.', 'pixfort-core'),
            'admin_label'	=> false,
            'value'			=> pix_get_animations(),
            "group"	=> "Top Dividers",
            "dependency" => array(
                "element" => "t_has_animation",
                "not_empty" => true
            ),
        ),

        array (
            'param_name' 	=> 't_3_delay',
            'type' 			=> 'textfield',
            'heading' 		=> __('Animation delay (in miliseconds)', 'pixfort-core'),
            'admin_label'	=> true,
            "dependency" => array(
                "element" => "t_3_animation",
                "not_empty" => true
            ),
            "group"	=> "Top Dividers",
        ),

        array(
            'type'        => 'pix_param_section',
            'param_name'  => 'pix_top_section_4',
            'pix_title'	=> 'Advanced Options',
            "group"	=> "Top Dividers",
        ),
        array(
            "type" => "checkbox",
            "heading" => __( "Bring the divider in front of the content", "pixfort-core" ),
            "description"	=> __( "The divider will cover the row elements below it.", "pixfort-core" ),
            "param_name" => "t_divider_in_front",
            "value" => false,
            "group"	=> "Top Dividers",
        ),
        array(
            "type" => "checkbox",
            "heading" => __( "Flip the divider", "pixfort-core" ),
            "param_name" => "t_flip_h",
            "value" => false,
            "group"	=> "Top Dividers",
        ),

        array (
            'param_name' 	=> 't_custom_height',
            'type' 			=> 'textfield',
            'heading' 		=> __('Divider custom height (Optional)', 'pixfort-core'),
            "description"	=> __( "Leave empty to use default height or add custom height (with unit, e.g: 200px).", "pixfort-core" ),
            'admin_label'	=> true,
            "group"	=> "Top Dividers",
        ),

    )
));

 ?>
