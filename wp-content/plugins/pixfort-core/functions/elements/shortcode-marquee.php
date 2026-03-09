<?php

// Marquee ----------------------------------------------
vc_map( array (
    'base' 			=> 'pix_marquee',
    'name' 			=> __('Marquee', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	    => "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/marquee.gif',
    'description' 	=> __('Create Marquee text effect', 'pixfort-core'),
    'params' 		=> array (
        array(
            'type' => 'param_group',
            'value' => '',
            'param_name' => 'items',
            'heading' 		=> __('Text', 'pixfort-core'),
            'description' 	=> __('Add each phrase in the desired order.', 'pixfort-core'),
            'params' => array(
                array(
                    "param_name" => "item_type",
                    "type" => "dropdown",
                    "heading" => __( "Item type", "pixfort-core" ),
                    'admin_label'	=> true,
                    "value" => array(
                        __("Text", 'pixfort-core')  => "text",
                        __("Image", 'pixfort-core') => "image",
                        __("Icon", 'pixfort-core') => "icon",
                        // __("Duo tone icon", 'pixfort-core') => "duo_icon"
                    ),
                ),
                array (
                    'param_name' 	=> 'text',
                    'type' 			=> 'textfield',
                    'heading' 		=> __('Text', 'pixfort-core'),
                    'admin_label'	=> true,
                    "dependency" => array(
                        "element" => "item_type",
                        "value" => "text"
                    ),
                ),
                array(
                    "param_name" => "bold",
                    "type" => "checkbox",
                    "heading" => __( "Title format", "pixfort-core" ),
                    "value" => array("Bold" => "font-weight-bold"),
                    // "std" => "font-weight-bold"
                    "dependency" => array(
                        "element" => "item_type",
                        "value" => "text"
                    ),
                ),
                array(
                    "type" => "checkbox",
                    "param_name" => "italic",
                    "value" => array("Italic" => "font-italic",),
                    "dependency" => array(
                        "element" => "item_type",
                        "value" => "text"
                    ),
                ),
                array(
                    "type" => "checkbox",
                    "param_name" => "heading_font",
                    "std" => "heading-font",
                    "value" => array("Heading font" => "heading-font",),
                    'save_always' => true,
                    "dependency" => array(
                        "element" => "item_type",
                        "value" => "text"
                    ),
                ),
                array(
                    'param_name' 	=> 'text_image',
                    'type' 			=> 'attach_image',
                    'heading' 		=> __('Use image as text color', 'pixfort-core'),
                    'description' 	=> __('The image will be visible inside the text characters.', 'pixfort-core'),
                    'admin_label'	=> false,
                    "dependency" => array(
                        "element" => "item_type",
                        "value" => 'text'
                    ),
                ),


                array(
                    'param_name'  => 'pix_duo_icon',
                    'type'        => 'pix_icons_select',
                    'heading'  => 'Duo tone icons',
                    "class" => "my_param_field",
                    'value'       => '',
                    'admin_label'	=> true,
                    "dependency" => array(
                        "element" => "item_type",
                        "value" => "duo_icon"
                    ),
                ),
                array (
                    'param_name' => 'icon',
                    'type' => 'pixfort_icons_picker',
                    'heading' => __( 'Icon', 'pixfort-core' ),
                    'admin_label'	=> true,
                    'settings' => array(
                        'emptyIcon' => true, // default true, display an "EMPTY" icon?
                        'type' => 'pix-icons',
                        'iconsPerPage' => 200, // default 100, how many icons per/page to display
                    ),
                    'description' => __( 'Select icon from library.', 'pixfort-core' ),
                    "dependency" => array(
                        "element" => "item_type",
                        "value" => "icon"
                    ),
                ),
                array (
                    'param_name' 	=> 'image',
                    'type' 			=> 'attach_image',
                    'heading' 		=> __('Image', 'pixfort-core'),
                    'admin_label'	=> true,
                    "dependency" => array(
                        "element" => "item_type",
                        "value" => "image"
                    ),
                ),

                array (
                    'param_name' 	=> 'image_size',
                    'type' 			=> 'textfield',
                    'heading' 		=> __('Image Size', 'pixfort-core'),
                    'description' => __( 'The size of the image (in pixels), leave empty for full size.', 'pixfort-core' ),
                    'admin_label'	=> false,
                    "dependency" => array(
                        "element" => "item_type",
                        "value" => "image"
                    ),
                ),
        
                // array(
                //     "type" => "checkbox",
                //     "heading" => __( "Circle image", "pixfort-core" ),
                //     "param_name" => "circle",
                //     "value" => __( "Yes", "pixfort-core" ),
                //     "dependency" => array(
                //         "element" => "item_type",
                //         "value" => 'image'
                //     ),
                // ),

                array (
                    'param_name' 	=> 'rounded_img',
                    'type' 			=> 'dropdown',
                    'heading' 		=> __('Rounded image', 'pixfort-core'),
                    'admin_label'	=> false,
                    'value' 		=> array(
                        __('No','pixfort-core') 	            => 'rounded-0',
                        __('Rounded Small','pixfort-core')	        => 'rounded',
                        __('Rounded Large','pixfort-core')	    => 'rounded-lg',
                        __('Rounded 5px','pixfort-core')	    => 'rounded-xl',
                        __('Rounded 10px','pixfort-core')	    => 'rounded-10',
                        __('Circle','pixfort-core')	            => 'rounded-circle',
                    ),
                    "dependency" => array(
                        "element" => "item_type",
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
                        "element" => "item_type",
                        "value" => 'image'
                    ),
                ),
                array(
                    "param_name" => "hover_effect",
                    "type" => "dropdown",
                    "heading" => __("Shadow Hover Style", "js_composer"),
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
                        "element" => "item_type",
                        "value" => 'image'
                    ),
                ),
                array(
                    "param_name" => "add_hover_effect",
                    "type" => "dropdown",
                    "heading" => __("Hover Animation", "js_composer"),
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
                        "element" => "item_type",
                        "value" => 'image'
                    ),
                ),

                array (
                    'param_name' 	=> 'link',
                    'type' 			=> 'textfield',
                    'heading' 		=> __('Link', 'pixfort-core'),
                    'admin_label'	=> false,
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


            )
        ),

        
        array (
            'param_name' 	=> 'content_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Content color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $colors,
            'std'			=> '',

        ),


        array (
            'param_name' 	=> 'content_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Content custom color', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                  "element" => "content_color",
                  "value" => "custom"
              ),
        ),

        array (
            'param_name' 	=> 'content_size',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Content size', 'pixfort-core'),
            'admin_label'	=> false,
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
            'param_name' 	=> 'display',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Bigger Text', 'pixfort-core'),
            'description' 	=> __('Larger text size to stand out.', 'pixfort-core'),
            'admin_label'	=> false,
            'value'			=> array_flip(array(
                ''		        => 'None',
                'display-1'		=> 'Display 1',
                'display-2'		=> 'Display 2',
                'display-3'		=> 'Display 3',
                'display-4'		=> 'Display 4',
            )),
            "dependency" => array(
                "element" => "content_size",
                "value" => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6')
            ),
        ),

        array (
            'param_name' 	=> 'content_custom_size',
            'type' 			=> 'textfield',
            'heading' 		=> __('Content custom text Size', 'pixfort-core'),
            'admin_label'	=> false,
        ),

        
        array(
            "param_name" => "reversed",
            "type" => "checkbox",
            "heading" => __( "Reverse direction", "pixfort-core" ),
            "value" => array("Yes" => "pix-reversed"),
        ),
        array(
            "param_name" => "pause_on_hover",
            "type" => "checkbox",
            "heading" => __( "Pause on hover", "pixfort-core" ),
            "value" => array("Yes" => "pix-pause-hover"),
        ),

        array(
            "param_name" => "pix_gray_effect",
            "type" => "checkbox",
            "heading" => __( "Enable Gray effect", "pixfort-core" ),
            "value" => array("Yes" => "pix-gray-effect"),
        ),
        array(
            "param_name" => "pix_colored_hover",
            "type" => "checkbox",
            "heading" => __( "Show original colors on hover", "pixfort-core" ),
            "value" => array("Yes" => "pix-colored-hover"),
            "dependency" => array(
                "element" => "pix_gray_effect",
                "value" => array('pix-gray-effect')
            ),
        ),

        // New Motion Library Options
        array(
            "param_name" => "scroll_direction_change",
            "type" => "checkbox",
            "heading" => __( "Change direction on scroll", "pixfort-core" ),
            "description" => __( "Marquee direction will change based on scroll direction", "pixfort-core" ),
            "value" => array("Yes" => "true"),
        ),
        // array(
        //     "param_name" => "load_animation",
        //     "type" => "checkbox",
        //     "heading" => __( "Animate on load", "pixfort-core" ),
        //     "description" => __( "Fade in animation when element loads", "pixfort-core" ),
        //     "value" => array("Yes" => "true"),
        // ),
        // array(
        //     "param_name" => "vertical_direction",
        //     "type" => "checkbox",
        //     "heading" => __( "Vertical marquee", "pixfort-core" ),
        //     "description" => __( "Display marquee vertically instead of horizontally", "pixfort-core" ),
        //     "value" => array("Yes" => "true"),
        // ),
        // array (
        //     'param_name' 	=> 'vertical_height',
        //     'type' 			=> 'textfield',
        //     'heading' 		=> __('Vertical height', 'pixfort-core'),
        //     'description' 	=> __('Height for vertical marquee (e.g. 300px, 50vh). Only applies when vertical direction is enabled.', 'pixfort-core'),
        //     'admin_label'	=> false,
        //     "dependency" => array(
        //         "element" => "vertical_direction",
        //         "value" => array("true")
        //     ),
        // ),
        array(
            "param_name" => "smooth_velocity",
            "type" => "checkbox",
            "heading" => __( "Smooth velocity", "pixfort-core" ),
            "description" => __( "Add smooth velocity changes based on scroll speed", "pixfort-core" ),
            "value" => array("Yes" => "true"),
        ),

        array (
            'param_name' 	=> 'speed',
            'type' 			=> 'textfield',
            'heading' 		=> __('Speed (in seconds)', 'pixfort-core'),
            'description' 	=> __('The number of seconds to complete one full rotation (leave empty to use default 10).', 'pixfort-core'),
            'admin_label'	=> true,
        ),

        // array (
        //     'param_name' 	=> 'base_velocity',
        //     'type' 			=> 'textfield',
        //     'heading' 		=> __('Base velocity', 'pixfort-core'),
        //     'description' 	=> __('Base movement speed for motion library (pixels per second, default 100).', 'pixfort-core'),
        //     'admin_label'	=> true,
        //     'std'           => '100',
        // ),

        array (
            'param_name' 	=> 'element_id',
            'type' 			=> 'textfield',
            'heading' 		=> __('Element ID', 'pixfort-core'),
            'admin_label'	=> true,
            'settings' => array(
                'auto_generate' => true,
            ),
            'group'         => "Advanced",
        ),

        array (
            'param_name' 	=> 'items_padding',
            'type' 			=> 'textfield',
            'heading' 		=> __('Padding between items (with unit)', 'pixfort-core'),
            'description' 	=> __('The padding for each Marquee item (leave empty to use default 4vw).<br>Tip: use relative unit for example "vw" to have responsive padding.', 'pixfort-core'),
            'admin_label'	=> true,
        ),

        array(
          'type' => 'css_editor',
          'heading' => __( 'Css', 'pixfort-core' ),
          'param_name' => 'css',
          'group' => __( 'Design options', 'pixfort-core' ),
          ),




    )
));

?>
