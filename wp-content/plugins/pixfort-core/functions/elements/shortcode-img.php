<?php

// Image -----------------------------
vc_map( array (
    'base' 			=> 'pix_img',
    'name' 			=> __('Image', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/image.jpg',
    'description' 	=> __('Add image with advanced pixfort styling', 'pixfort-core'),
    'params' 		=> array_merge(
        array (

            array (
                'param_name' 	=> 'image',
                'type' 			=> 'attach_image',
                'heading' 		=> __('Image', 'pixfort-core'),
                'admin_label'	=> false,
            ),
            ...( \PixfortCore::instance()->getThemeParam('dynamic_wpb_images') ? [
                array(
                    'param_name' 	=> 'dynamic_image',
                    'type' 			=> 'pix_dynamic_image',
                    'heading' 		=> __('Dynamic image source', 'pixfort-core'),
                    'description' 	=> __('Select a dynamic image source (optional). If image is not available, the normal image will be used.', 'pixfort-core'),
                ),
            ] : [] ),


            array (
                'param_name' 	=> 'rounded_img',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Rounded corners', 'pixfort-core'),
                'admin_label'	=> false,
                'value' 		=> array(
                    __('No','pixfort-core') 	=> 'rounded-0',
                    __('Rounded','pixfort-core')	    => 'rounded',
                    __('Rounded Large','pixfort-core')	    => 'rounded-lg',
                    __('Rounded 5px','pixfort-core')	    => 'rounded-xl',
                    __('Rounded 10px','pixfort-core')	    => 'rounded-10',
                    __('Circle','pixfort-core')	    => 'rounded-circle',
                )
            ),

            array (
                'param_name' 	=> 'alt',
                'type' 			=> 'textfield',
                'heading' 		=> __('Image alternative text', 'pixfort-core'),
                'admin_label'	=> true,
            ),

            array (
                'param_name' 	=> 'align',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Image alignment', 'pixfort-core'),
                'description' 	=> __('Select the position of the image.', 'pixfort-core'),
                'admin_label'	=> false,
                'value'			=> array_flip(array(
                    'text-left'			=> 'Left',
                    'text-center'		=> 'Center',
                    'text-right' 		=> 'Right',
                )),
            ),

            array (
                'param_name' 	=> 'width',
                'type' 			=> 'textfield',
                'heading' 		=> __('Width (Optional)', 'pixfort-core'),
                "description" => __( "Please input the value (with the unit: %, px,.. etc).", "pixfort-core"),
                'admin_label'	=> false,
            ),
            array (
                'param_name' 	=> 'height',
                'type' 			=> 'textfield',
                'heading' 		=> __('Height (Optional)', 'pixfort-core'),
                "description" => __( "Please input the value (with the unit: %, px,.. etc).", "pixfort-core"),
                'admin_label'	=> false,
            ),

            array (
                'param_name' 	=> 'link',
                'type' 			=> 'textfield',
                'heading' 		=> __('Link', 'pixfort-core'),
                'admin_label'	=> true,
            ),
            array(
                  "type" => "checkbox",
                  "heading" => __( "Open in a new tab", "pixfort-core" ),
                  "param_name" => "target",
                  "value" => __( "Yes", "pixfort-core" ),
                  "dependency" => array(
        		        "element" => "link",
        		        "not_empty" => true
        		    ),
              ),

              array(
                    "type" => "checkbox",
                    "heading" => __( "Animation type", "pixfort-core" ),
                    "param_name" => "pix_scroll_parallax",
                    "value" => array_flip(array(
                      "scroll_parallax"       => "Scroll Parallax",
                  )),
                ),
                array(
                      "type" => "checkbox",
                      "param_name" => "pix_tilt",
                      "value" => array_flip(array(
                        "tilt"       => "3D Hover",
                    )),
                  ),
                array (
                    'param_name' 	=> 'xaxis',
                    'type' 			=> 'textfield',
                    'heading' 		=> __('Vertical Parallax', 'pixfort-core'),
                    'admin_label'	=> false,
                    'std'			=> '0',
                    "dependency" => array(
                          "element" => "pix_scroll_parallax",
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
                          "element" => "pix_scroll_parallax",
                          "value" => "scroll_parallax"
                      ),
                ),
                array (
                    'param_name' 	=> 'pix_tilt_size',
                    'type' 			=> 'dropdown',
                    'heading' 		=> __('3d hover size', 'pixfort-core'),
                    'admin_label'	=> false,
                    'value'			=> array_flip(array(
                        'tilt'			=> 'Default',
                        'tilt_big'		=> 'Big',
                        'tilt_small' 		=> 'Small',
                    )),
                    "dependency" => array(
                          "element" => "pix_tilt",
                          "not_empty" => true
                      ),
                ),

            array (
                'param_name' 	=> 'animation',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Animation', 'pixfort-core'),
                'description' 	=> __('Select the animation of the heading.', 'pixfort-core'),
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

           array (
               'param_name' 	=> 'img_div',
               'type' 			=> 'dropdown',
               'heading' 		=> __('Image inside a container', 'pixfort-core'),
               "description" => __( "if enabled, other elements won't show on the same line.", "js_composer"),
               'admin_label'	=> false,
               'value'			=> array_flip(array(
                   '' 		=> 'Disabled',
                   'text-center' 		=> 'Center align',
                   'text-left' 		=> 'Left align',
                   'text-right' 		=> 'Right align',
               )),
           ),
           array (
               'param_name' 	=> 'pix_scale_in',
               'type' 			=> 'dropdown',
               'heading' 		=> __('Scroll effect', 'pixfort-core'),
               "description" => __( "Apply effects to the image when scrolling.", "pixfort-core"),
               'admin_label'	=> false,
               'group' => __('Effects', 'pixfort-core'),
               'value'			=> array_flip(array(
                   '' 		=> 'Disabled',
                   'pix-scale-in-xs' 		=> 'Extra Small scale',
                   'pix-scale-in-sm' 		=> 'Small scale',
                   'pix-scale-in' 		=> 'Normal scale',
                   'pix-scale-in-lg' 		=> 'Large scale',
                //    'pix-advanced-transform' 	=> 'Advanced Transform',
               )),
           ),


           // Advanced Transform Start Controls
           array(
            'type'        => 'pix_param_section',
            'param_name'  => 'advanced_transform_start_heading',
            'pix_title'	=> 'Start Transform',
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
            'type'        => 'pix_param_section',
            'param_name'  => 'advanced_transform_end_heading',
            'pix_title'	=> 'End Transform',
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
               "heading" => __("Extra class names", "my-text-domain"),
               "param_name" => "el_class",
               "description" => __("Add additional custom classes to the image.", "my-text-domain"),
               'value'       => '',
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
        ),
        $effects_params
    )
));

 ?>
