<?php


$pix_overlay_color_array = array_merge(
    array("None" => ''),
    $bg_colors,
    array("Custom Gradient" => 'custom-gradient')
);

$content_box_params = array(
    array (
        'param_name' 	=> 'rounded_box',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Rounded corners', 'pixfort-core'),
        'admin_label'	=> false,
        'std'	=> 'rounded-lg',
        'value' 		=> array(
            __('No','pixfort-core') 	=> 'rounded-0',
            __('Rounded Small','pixfort-core')	    => 'rounded',
            __('Rounded Large','pixfort-core')	    => 'rounded-lg',
            __('Rounded 5px','pixfort-core')	    => 'rounded-xl',
            __('Rounded 10px','pixfort-core')	    => 'rounded-10',
            __('Custom (from Design options tab)','pixfort-core')	    => 'rounded-custom',
        )
    ),
);
$content_box_params_2 = array(


    array(
        "type" => "checkbox",
        "heading" => __( "Gradient Background on hover", "pixfort-core" ),
        "param_name" => "pix_bg_gradient_hover",
        "value" => array(
            "Yes" => "1"
        ),
    ),


    array(
        "type" => "checkbox",
        "heading" => __( "Enable Particles", "pixfort-core" ),
        "param_name" => "pix_particles_check",
        "group"	=> "Particles",
        "value" => array(
            "Yes" => "1"
        ),
        "description" => __( "Enable animated images in the background.", "pixfort-core" )
    ),
    array(
        'type' => 'param_group',
        'value' => '',
        'param_name' => 'pix_particles',
        "group"	=> "Particles",
        'heading' 		=> __('Particles', 'pixfort-core'),
        "dependency" => array(
            "element" => "pix_particles_check",
            "value" => "1"
        ),
        'params' => array(
            array (
                'param_name' 	=> 'image',
                'type' 			=> 'attach_image',
                'heading' 		=> __('Image', 'pixfort-core'),
                'admin_label'	=> false,
            ),

            array(
                "type" => "dropdown",
                "heading" => __("Horizontal Position", "pixfort-core"),
                "param_name" => "h_position",
                "value" => array_flip(array(
                    "left" 			=> "Left",
                    "right"       => "Right"
                )),
                "description" => __( "Please select the horizontal origin of the alignment.", "pixfort-core")
            ),
            array (
                'param_name' 	=> 'horizontal',
                'type' 			=> 'textfield',
                'heading' 		=> __('Horizontal value', 'pixfort-core'),
                "description" => __( "Please input the value (with the unit: %, px,.. etc).", "pixfort-core"),
                'admin_label'	=> false,
                'save_always' => true,
                'value'           => '0',
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Vertical Position", "pixfort-core"),
                "param_name" => "v_position",
                "value" => array_flip(array(
                    "top" 			=> "Top",
                    "bottom"       => "Bottom"
                )),
                "description" => __( "Please select the horizontal origin of the alignment.", "pixfort-core")
            ),
            array (
                'param_name' 	=> 'vertical',
                'type' 			=> 'textfield',
                'heading' 		=> __('Vertical value', 'pixfort-core'),
                'value'           => '0',
                'save_always' => true,
                "description" => __( "Please input the value (with the unit: %, px,.. etc).", "pixfort-core"),
                'admin_label'	=> false,
            ),
            array(
                "type" => "checkbox",
                "heading" => __( "Animation type", "pixfort-core" ),
                "param_name" => "pix_particles_type",
                "value" => array_flip(array(
                    "scroll_parallax"       => "Scroll Parallax",
                )),
            ),
            array(
                "type" => "checkbox",
                "param_name" => "pix_particles_type_2",
                "value" => array_flip(array(
                    "mouse_parallax" 			=> "Mouse Parallax"
                )),
            ),
            array(
                "type" => "checkbox",
                "param_name" => "pix_particles_type_3",
                "value" => array_flip(array(
                    "scroll_rotate" 			=> "Scroll rotate"
                )),
            ),


            array (
                'param_name' 	=> 'depth',
                'type' 			=> 'textfield',
                'heading' 		=> __('Parallax Depth', 'pixfort-core'),
                'admin_label'	=> false,
                'std'			=> '0.2',
                "description" => __( "Depth value is between 0 and 1.", "pixfort-core" ),
                "dependency" => array(
                    "element" => "pix_particles_type_2",
                    "value" => "mouse_parallax"
                ),
            ),

            array (
                'param_name' 	=> 'xaxis',
                'type' 			=> 'textfield',
                'heading' 		=> __('Vertical Parallax', 'pixfort-core'),
                'admin_label'	=> false,
                'value'			=> '100',
                "dependency" => array(
                    "element" => "pix_particles_type",
                    "value" => "scroll_parallax"
                ),
            ),
            array (
                'param_name' 	=> 'yaxis',
                'type' 			=> 'textfield',
                'heading' 		=> __('Horizontal Parallax', 'pixfort-core'),
                'admin_label'	=> false,
                'std'			=> '0',
                "dependency" => array(
                    "element" => "pix_particles_type",
                    "value" => "scroll_parallax"
                ),
            ),


            array (
                'param_name' 	=> 'rotation_speed',
                'type' 			=> 'textfield',
                'heading' 		=> __('Roatation speed', 'pixfort-core'),
                'admin_label'	=> false,
                'std'			=> '300',
                "description" => __( "A bigger number is a slower speed.", "pixfort-core" ),
                "dependency" => array(
                    "element" => "pix_particles_type_3",
                    "value" => "scroll_rotate"
                ),
            ),

            array(
                "type" => "checkbox",
                "heading" => __( "Inverse rotation direction", "pixfort-core" ),
                "param_name" => "pix_inverse_rotation",
                "value" => array_flip(array(
                    "scroll_inverse"       => "Yes",
                )),
                "dependency" => array(
                    "element" => "pix_particles_type_3",
                    "value" => "scroll_rotate"
                ),
            ),

            array (
                'param_name' 	=> 'img_width',
                'type' 			=> 'textfield',
                'heading' 		=> __('Image width', 'pixfort-core'),
                'description' 	=> __('Please add the unit (for example: px or %).', 'pixfort-core'),
                'admin_label'	=> false,
            ),

            array (
                'param_name' 	=> 'animation',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Start Animation', 'pixfort-core'),
                'admin_label'	=> false,
                'value'			=> pix_get_animations(),
            ),
            array (
                'param_name' 	=> 'delay',
                'type' 			=> 'textfield',
                'heading' 		=> __('Animation delay (in miliseconds)', 'pixfort-core'),
                'admin_label'	=> true,
                "dependency" => array(
                    "element" => "animation",
                    "not_empty" => true
                ),
            ),

            array(
                "type" => "dropdown",
                "heading" => __( "Infinite Animation type", "pixfort-core" ),
                "param_name" => "pix_infinite_animation",
                "value" => $infinite_animation,
                'admin_label'	=> false,
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Infinite Animation Speed", "pixfort-core" ),
                "param_name" => "pix_infinite_speed",
                "value" => $animation_speeds,
                'admin_label'	=> false,
                "dependency" => array(
                    "element" => "pix_infinite_animation",
                    "not_empty" => true
                ),
            ),
            array(
                "type" => "checkbox",
                "heading" => __( "Hide on mobile", "pixfort-core" ),
                "param_name" => "hide",
                "value" => __( "1", "pixfort-core" ),
                "description" => __( "Hide the element on mobile devices.", "pixfort-core" )
            ),

        )
    ),

    array(
        "type" => "checkbox",
        "group"	=> "Particles",
        "heading" => __( "Show Particles on top of the content", "pixfort-core" ),
        "param_name" => "particles_top_index",
        "value" => array("Yes" => "overflow-hidden",),
        "dependency" => array(
            "element" => "pix_particles_check",
            "value" => "1"
        ),
    ),

    array(
        "type" => "checkbox",
        "heading" => __( "Hide content outside the box", "pixfort-core" ),
        "param_name" => "overflow",
        "value" => array("Yes" => "overflow-hidden")
    ),
    array(
        "type" => "checkbox",
        "heading" => __( "Full height box", "pixfort-core" ),
        "param_name" => "full_height",
        "value" => array("Yes" => "full-height")
    ),
    array(
        "param_name" => "sticky_top",
        "type" => "checkbox",
        "heading" => __( "Stick box on the top", "pixfort-core" ),
        "value" => array("Yes" => "sticky-top"),
        "description" => __("The parent row should enable equal columns option.", "pixfort-core"),
    ),

    array (
        'param_name' 	        => 'content_align',
        'type' 			    => 'dropdown',
        'heading' 		    => __('Content align', 'pixfort-core'),
        'admin_label'	        => false,
        'value'			    => array_flip(array(
            ''			    => 'Default',
            'text-left'		=> 'Left',
            'text-center'		=> 'Center',
            'text-right' 		=> 'Right',
        ))
    ),

    array(
        "type" => "checkbox",
        "heading" => __( "Inline box size", "pixfort-core" ),
        "param_name" => "content_inline",
        "value" => array("Yes" => "1"),
        "description" => __("Make the box match content size (not full width).", "pixfort-core"),
    ),

    array (
        'param_name' 	=> 'pix_scale_in',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Scroll effect', 'pixfort-core'),
        "description" => __( "Scale the element down to the default size when scrolling.", "pixfort-core"),
        'admin_label'	=> false,
        'group' => __('Effects', 'pixfort-core'),
        'value'			=> array_flip(array(
            '' 		=> 'Disabled',
            'pix-scale-in-sm' 		=> 'Small scale',
            'pix-scale-in' 		=> 'Normal scale',
            'pix-scale-in-lg' 		=> 'Large scale',
            // 'pix-advanced-transform' 	=> 'Advanced Transform',
        )),
    ),

    // Advanced Transform Start Controls
    array(
        'type' => 'pix_param_section',
        'heading' => __('Start Transform', 'pixfort-core'),
        'param_name' => 'advanced_transform_start_heading',
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('Start Opacity', 'pixfort-core'),
        'param_name' => 'pix_transform_start_opacity',
        'value' => '1',
        'description' => __('Value from 0 to 1 (e.g., 0.5 for 50% opacity)', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('Start Scale', 'pixfort-core'),
        'param_name' => 'pix_transform_start_scale',
        'value' => '1',
        'description' => __('Value from 0 to 2 (e.g., 1.5 for 150% scale)', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    array(
        'type' => 'dropdown',
        'heading' => __('Start Rotate Type', 'pixfort-core'),
        'param_name' => 'pix_transform_start_rotate_type',
        'value' => array(
            __('2D', 'pixfort-core') => '2d',
            __('3D', 'pixfort-core') => '3d',
        ),
        'std' => '2d',
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('Start Rotate (2D)', 'pixfort-core'),
        'param_name' => 'pix_transform_start_rotate_2d',
        'value' => '0',
        'description' => __('Rotation in degrees (e.g., 45, -90)', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_transform_start_rotate_type',
            'value' => '2d'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('Start Rotate X (3D)', 'pixfort-core'),
        'param_name' => 'pix_transform_start_rotate_3d_x',
        'value' => '0',
        'description' => __('X-axis rotation in degrees', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_transform_start_rotate_type',
            'value' => '3d'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('Start Rotate Y (3D)', 'pixfort-core'),
        'param_name' => 'pix_transform_start_rotate_3d_y',
        'value' => '0',
        'description' => __('Y-axis rotation in degrees', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_transform_start_rotate_type',
            'value' => '3d'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('Start Rotate Z (3D)', 'pixfort-core'),
        'param_name' => 'pix_transform_start_rotate_3d_z',
        'value' => '0',
        'description' => __('Z-axis rotation in degrees', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_transform_start_rotate_type',
            'value' => '3d'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('Start Skew X', 'pixfort-core'),
        'param_name' => 'pix_transform_start_skew_x',
        'value' => '0',
        'description' => __('Skew on X-axis in degrees', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('Start Skew Y', 'pixfort-core'),
        'param_name' => 'pix_transform_start_skew_y',
        'value' => '0',
        'description' => __('Skew on Y-axis in degrees', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('Start Offset X', 'pixfort-core'),
        'param_name' => 'pix_transform_start_offset_x',
        'value' => '0',
        'description' => __('Horizontal offset in pixels', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('Start Offset Y', 'pixfort-core'),
        'param_name' => 'pix_transform_start_offset_y',
        'value' => '0',
        'description' => __('Vertical offset in pixels', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    // Advanced Transform End Controls
    array(
        'type' => 'pix_param_section',
        'heading' => __('End Transform', 'pixfort-core'),
        'param_name' => 'advanced_transform_end_heading',
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('End Opacity', 'pixfort-core'),
        'param_name' => 'pix_transform_end_opacity',
        'value' => '1',
        'description' => __('Value from 0 to 1 (e.g., 0.5 for 50% opacity)', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('End Scale', 'pixfort-core'),
        'param_name' => 'pix_transform_end_scale',
        'value' => '1',
        'description' => __('Value from 0 to 2 (e.g., 1.5 for 150% scale)', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    array(
        'type' => 'dropdown',
        'heading' => __('End Rotate Type', 'pixfort-core'),
        'param_name' => 'pix_transform_end_rotate_type',
        'value' => array(
            __('2D', 'pixfort-core') => '2d',
            __('3D', 'pixfort-core') => '3d',
        ),
        'std' => '2d',
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('End Rotate (2D)', 'pixfort-core'),
        'param_name' => 'pix_transform_end_rotate_2d',
        'value' => '0',
        'description' => __('Rotation in degrees (e.g., 45, -90)', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_transform_end_rotate_type',
            'value' => '2d'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('End Rotate X (3D)', 'pixfort-core'),
        'param_name' => 'pix_transform_end_rotate_3d_x',
        'value' => '0',
        'description' => __('X-axis rotation in degrees', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_transform_end_rotate_type',
            'value' => '3d'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('End Rotate Y (3D)', 'pixfort-core'),
        'param_name' => 'pix_transform_end_rotate_3d_y',
        'value' => '0',
        'description' => __('Y-axis rotation in degrees', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_transform_end_rotate_type',
            'value' => '3d'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('End Rotate Z (3D)', 'pixfort-core'),
        'param_name' => 'pix_transform_end_rotate_3d_z',
        'value' => '0',
        'description' => __('Z-axis rotation in degrees', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_transform_end_rotate_type',
            'value' => '3d'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('End Skew X', 'pixfort-core'),
        'param_name' => 'pix_transform_end_skew_x',
        'value' => '0',
        'description' => __('Skew on X-axis in degrees', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('End Skew Y', 'pixfort-core'),
        'param_name' => 'pix_transform_end_skew_y',
        'value' => '0',
        'description' => __('Skew on Y-axis in degrees', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('End Offset X', 'pixfort-core'),
        'param_name' => 'pix_transform_end_offset_x',
        'value' => '0',
        'description' => __('Horizontal offset in pixels', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    array(
        'type' => 'textfield',
        'heading' => __('End Offset Y', 'pixfort-core'),
        'param_name' => 'pix_transform_end_offset_y',
        'value' => '0',
        'description' => __('Vertical offset in pixels', 'pixfort-core'),
        'group' => __('Effects', 'pixfort-core'),
        'dependency' => array(
            'element' => 'pix_scale_in',
            'value' => 'pix-advanced-transform'
        ),
    ),

    array(
        "type" => "textfield",
        "heading" => __("Extra class name", "pixfort-core"),
        "param_name" => "el_class",
        "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "pixfort-core"),
        'value'       => 'mb-2',
    ),

    array(
        'type' => 'css_editor',
        'heading' => __( 'Css', 'pixfort-core' ),
        'param_name' => 'css',
        'group' => __( 'Design options', 'pixfort-core' ),
    ),
    array(
      'type' => 'pix_responsive_css',
      'heading' => __( 'Responsive options', 'pixfort-core' ),
      'param_name' => 'responsive_css',
      'group' => __( 'Design options', 'pixfort-core' ),
      "description" => __( "Input responsive values to override Desktop settings.<br />Note: Tablet landscape preview in WPBakery uses the Desktop values.", "pixfort-core" ),
      'value'   => '{}'
      ),



    array (
        'param_name' 	=> 'pix_overlay_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Overlay color', 'pixfort-core'),
        'admin_label'	=> false,
        "group"	=> "Design options",
        'value' 		=> $pix_overlay_color_array,
    ),

    
);


$content_box_params_2 = array_merge(
    $content_box_params_2,
    array(
        array(
            'param_name'     => 'pix_custom_gradient',
            'type'             => 'pix_gradient_picker',
            'heading'         => __('Gradient custom picker', 'pixfort-core'),
            "dependency" => array(
                "element" => "pix_overlay_color",
                "value" => 'custom-gradient'
            ),
            "group"    => esc_html__('Design options', 'pixfort-core'),
        ),
        array(
            "type" => "checkbox",
            "heading" => __("Display overlay over content", "pixfort-core"),
            "param_name" => "pix_overlay_over",
            "value" => false,
            "group"    => esc_html__('Design options', 'pixfort-core'),
        ),
    )
);

$content_box_params_2 = array_merge(
    $content_box_params_2,
    array(
        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Custom overlay color', 'pixfort-core'),
            'param_name'  => 'pix_overlay_custom_color',
            'value'       => '#ffffff',
            "dependency" => array(
                "element" => "pix_overlay_color",
                "value" => 'custom'
            ),
            "group"	=> "Design options",
        ),
    
        array (
            'param_name' 	=> 'pix_overlay_opacity',
            'type' 			=> 'textfield',
            'heading' 		=> __('Overlay opacity', 'pixfort-core'),
            "description" => __( "The opacity value should be between 0 and 1.", "pixfort-core" ),
            'admin_label'	=> false,
            "group"	=> "Design options",
            "dependency" => array(
                "element" => "pix_overlay_color",
                "not_empty" => true
            ),
        ),
    )
);


vc_map( array(
    "name" => __("Content Box", "js_composer"),
    "base" => "content_box",
    "as_parent" => array('except' => 'content_box'),
    "content_element" => true,
    "show_settings_on_create" => false,
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/content-box.png',
    'description' 	=> __('A container for a group of elements', 'pixfort-core'),
    "is_container" => true,
    "params" => array_merge(
        $effects_params,
        $content_box_params,
        $animation_params,
        $content_box_params_2
        ),
        "js_view" => 'VcColumnView'
    )
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_content_box extends WPBakeryShortCodesContainer {
    }
}
?>
