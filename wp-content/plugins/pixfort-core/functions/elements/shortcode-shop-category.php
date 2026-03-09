<?php



// Shop category -------------------------------------------
vc_map( array (
    'base' 			=> 'pix_shop_category',
    'name' 			=> __('Shop category', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    'icon' 			=> 'pix-icon-vc-image-box',
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/shop-categories.png',
    'description' 	=> __('Add shop category box', 'pixfort-core'),
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
                'param_name' 	=> 'cat',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Category', 'pixfort-core'),
                'admin_label'	=> false,
                'value' 		=> pix_get_woo_cats()
            ),
            array (
                'param_name' 	=> 'rounded_img',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Rounded corners', 'pixfort-core'),
                'admin_label'	=> false,
                'value' 		=> array(
                    __('No','pixfort-core') 	=> 'rounded-0',
                    __('Rounded Small','pixfort-core')	    => 'rounded',
                    __('Rounded Large','pixfort-core')	    => 'rounded-lg',
                    __('Rounded 5px','pixfort-core')	    => 'rounded-xl',
                    __('Rounded 10px','pixfort-core')	    => 'rounded-10',
                ),
                "std" => 'rounded-lg'
            ),

            array (
                'param_name' 	=> 'alt',
                'type' 			=> 'textfield',
                'heading' 		=> __('Image alternative text', 'pixfort-core'),
                'admin_label'	=> true,
            ),


            array (
                'param_name' 	=> 'title',
                'type' 			=> 'textfield',
                'heading' 		=> __('Title', 'pixfort-core'),
                'admin_label'	=> true,
            ),

            array (
                'param_name' 	=> 'link_text',
                'type' 			=> 'textfield',
                'heading' 		=> __('Link Text', 'pixfort-core'),
                'admin_label'	=> true,
                'std'         => "Check it out"
            ),

            // array (
            //     'param_name' 	=> 'content',
            //     'type' 			=> 'textarea',
            //     'heading' 		=> __('Content', 'pixfort-core'),
            //     'admin_label'	=> false,
            // ),

            array (
                'param_name' 	=> 'link',
                'type' 			=> 'textfield',
                'heading' 		=> __('Link', 'pixfort-core'),
                'description'   => 'Leave empty to link to the categroy default page.',
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
                    // 'description' 	=> __('Select the position of the image.', 'pixfort-core'),
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

           array(
               'type' => 'css_editor',
               'heading' => __( 'Css', 'pixfort-core' ),
               'param_name' => 'css',
               'group' => __( 'Design options', 'pixfort-core' ),
           ),

        ),
        pix_get_text_format_params(array(
            'prefix' 		=> 'count_',
            'name' 		=> 'Count badge',
            'bold' 		=> true,
            'bold_value' 		=> 'font-weight-bold',
            'italic' 		=> true,
            'italic_value' 		=> '',
            'secondary_font' 		=> true,
            'secondary_font_value' 		=> '',
            'color' 		=> true,
            'color_value' 		=> 'white',
            'text_group'            => 'Advanced'
        )),
        pix_get_text_format_params(array(
            'prefix' 		=> 'title_',
            'name' 		=> 'Title',
            'bold' 		=> true,
            'bold_value' 		=> 'font-weight-bold',
            'italic' 		=> true,
            'italic_value' 		=> '',
            'secondary_font' 		=> true,
            'secondary_font_value' 		=> '',
            'color' 		=> true,
            'color_value' 		=> 'white',
            'text_group'            => 'Advanced'
        )),
        pix_get_text_format_params(array(
            'prefix' 		=> 'link_',
            'name' 		=> 'Link',
            'bold' 		=> true,
            'bold_value' 		=> 'font-weight-bold',
            'italic' 		=> true,
            'italic_value' 		=> '',
            'secondary_font' 		=> true,
            'secondary_font_value' 		=> '',
            'color' 		=> true,
            'text_group'            => 'Advanced',
            'color_value' 		=> 'light-opacity-6',
        )),
        array(
            array (
                'param_name' 	=> 'overlay_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Overlay color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Advanced',
                'value' 		=> $colors,
                'std'			=> 'heading-default',
            ),

            array (
                'param_name' 	=> 'overlay_custom_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Custom overlay color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Advanced',
                "dependency" => array(
                      "element" => "overlay_color",
                      "value" => "custom"
                  ),
            ),

            array(
    	     "type" => "dropdown",
    	     "heading" => __("Overlay opacity", "pixfort-core"),
    	     "param_name" => "overlay_opacity",
             'group'         => 'Advanced',
             "std"      => 'pix-opacity-4',
    	     "value" => array_flip(array(
    	        "pix-opacity-10" 			=> "0%",
    	        "pix-opacity-9" 			=> "10%",
    	        "pix-opacity-8" 			=> "20%",
    	        "pix-opacity-7" 			=> "30%",
    	        "pix-opacity-6" 			=> "40%",
    	        "pix-opacity-5" 			=> "50%",
    	        "pix-opacity-4" 			=> "60%",
    	        "pix-opacity-3" 			=> "70%",
    	        "pix-opacity-2" 			=> "80%",
    	        "pix-opacity-1" 			=> "90%",

    	    )),
            ),

            array(
              "type" => "dropdown",
              "heading" => __("Hover overlay opacity", "pixfort-core"),
              "param_name" => "hover_overlay_opacity",
                 'group'         => 'Advanced',
                 "std"      => 'pix-hover-opacity-6',
              "value" => array_flip(array(
                  "pix-hover-opacity-0" 			=> "100%",
                  "pix-hover-opacity-2" 			=> "80%",
                  "pix-hover-opacity-4" 			=> "60%",
                  "pix-hover-opacity-6" 			=> "40%",
                  "pix-hover-opacity-7" 			=> "30%",
                  "pix-hover-opacity-8" 			=> "20%",
                  "pix-hover-opacity-9" 			=> "10%",
                  "pix-hover-opacity-10" 			=> "Disable",

             )),
            ),
        ),
        $effects_params
    )
));
 ?>
