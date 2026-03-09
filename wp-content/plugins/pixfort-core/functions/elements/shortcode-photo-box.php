<?php

// Photo Box -------------------------------------------
vc_map( array (
    'base' 			=> 'pix_photo_box',
    'name' 			=> __('Photo Box', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/photo-box.png',
    'description' 	=> __('Beautiful photo showcase', 'pixfort-core'),
    'params' 		=> array_merge(array (

        array (
            'param_name' 	=> 'title',
            'type' 			=> 'textfield',
            'heading' 		=> __('Title', 'pixfort-core'),
            'admin_label'	=> true,
        ),

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
                  "param_name" => "pix_color_effect",
                  "value" => array_flip(array(
                    "pix-hover-colored"       => "Hover color effect",
                )),
                "std"       => true
              ),
            array(
                  "type" => "checkbox",
                  "param_name" => "pix_title_effect",
                  "value" => array_flip(array(
                    "pix-hover-title"       => "Hover title fade in",
                )),
                "std"       => true
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
           'param_name' 	=> 'height',
           'type' 			=> 'textfield',
           'heading' 		=> __('Box minimum height', 'pixfort-core'),
           'admin_label'	=> true,
           'std'            => '400px'
       ),



       array(
             "type" => "checkbox",
             "heading" => __( "Title format", "pixfort-core" ),
             "param_name" => "bold",
             'group' => __( 'Advanced', 'pixfort-core' ),
             "value" => array("Bold" => "font-weight-bold"),
             "std" => "font-weight-bold"
         ),
       array(
             "type" => "checkbox",
             "param_name" => "italic",
             'group' => __( 'Advanced', 'pixfort-core' ),
             "value" => array("Italic" => "font-italic",),
         ),
       array(
             "type" => "checkbox",
             "param_name" => "secondary_font",
             'group' => __( 'Advanced', 'pixfort-core' ),
             "value" => array("Secondary font" => "secondary-font",),
         ),


       array (
           'param_name' 	=> 'title_color',
           'type' 			=> 'dropdown',
           'heading' 		=> __('Title color', 'pixfort-core'),
           'admin_label'	=> false,
           'group' => __( 'Advanced', 'pixfort-core' ),
           'value' 		=> $colors,
           'std'			=> 'heading-default',
       ),

       array (
           'param_name' 	=> 'title_custom_color',
           'type' 			=> 'colorpicker',
           'heading' 		=> __('Title color', 'pixfort-core'),
           'admin_label'	=> false,
           'group' => __( 'Advanced', 'pixfort-core' ),
           "dependency" => array(
                 "element" => "title_color",
                 "value" => "custom"
             ),
       ),

       array (
           'param_name' 	=> 'title_size',
           'type' 			=> 'dropdown',
           'heading' 		=> __('Title size', 'pixfort-core'),
           'admin_label'	=> false,
           'group' => __( 'Advanced', 'pixfort-core' ),
           'std' => 'h5',
           'value' 		=> array(
               __('H1','pixfort-core') 	=> 'h1',
               __('H2','pixfort-core')	    => 'h2',
               __('H3','pixfort-core')	    => 'h3',
               __('H4','pixfort-core')	    => 'h4',
               __('H5','pixfort-core')	    => 'h5',
               __('H6','pixfort-core')	    => 'h6',
               __('Custom','pixfort-core')	    => 'custom',
           ),
       ),

       array (
           'param_name' 	=> 'title_custom_size',
           'type' 			=> 'textfield',
           'heading' 		=> __('Title Size', 'pixfort-core'),
           'admin_label'	=> false,
           'group' => __( 'Advanced', 'pixfort-core' ),
           "dependency" => array(
                 "element" => "title_size",
                 "value" => "custom"
             ),
       ),

       array (
        'param_name' 	=> 'rounded_img',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Rounded corners', 'pixfort-core'),
        'admin_label'	=> false,
        'std'	=> 'rounded-lg',
        'group' => __( 'Advanced', 'pixfort-core' ),
        'value' 		=> array(
            __('No','pixfort-core') 	=> 'rounded-0',
            __('Rounded','pixfort-core')	    => 'rounded',
            __('Rounded Large','pixfort-core')	    => 'rounded-lg',
            __('Rounded 5px','pixfort-core')	    => 'rounded-xl',
            __('Rounded 10px','pixfort-core')	    => 'rounded-10',
        )
    ),


       array(
           'type' => 'css_editor',
           'heading' => __( 'Css', 'pixfort-core' ),
           'param_name' => 'css',
           'group' => __( 'Design options', 'pixfort-core' ),
       ),

    ),
    $effects_params
    )
));

 ?>
