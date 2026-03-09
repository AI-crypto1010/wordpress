<?php

// Promo Box -------------------------------------------
vc_map( array (
    'base' 			=> 'pix_promo_box',
    'name' 			=> __('Promo Box', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    'class'         => 'pixfort_element',
    "weight"	=> "1000",
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/promo-box.png',
    'description' 	=> __('Add beautiful promo box', 'pixfort-core'),
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
                'param_name' 	=> 'title',
                'type' 			=> 'textfield',
                'heading' 		=> __('Title', 'pixfort-core'),
                'admin_label'	=> true,
            ),

            array (
                'param_name' 	=> 'badge',
                'type' 			=> 'textfield',
                'heading' 		=> __('Badge', 'pixfort-core'),
                'admin_label'	=> true,
            ),

            array (
                'param_name' 	=> 'link_text',
                'type' 			=> 'textfield',
                'heading' 		=> __('Link Text', 'pixfort-core'),
                'admin_label'	=> true,
                'std'         => "Check it out"
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

           array (
               'param_name' 	=> 'height',
               'type' 			=> 'textfield',
               'heading' 		=> __('Box minimum height', 'pixfort-core'),
               'admin_label'	=> true,
               'std'            => '300px'
           ),



           array(
               'type' => 'css_editor',
               'heading' => __( 'Css', 'pixfort-core' ),
               'param_name' => 'css',
               'group' => __( 'Design options', 'pixfort-core' ),
           ),

       ),
       pix_get_text_format_params(array(
           'prefix' 		=> '',
           'name' 		=> 'Title',
           'bold' 		=> true,
           'bold_value' 		=> 'font-weight-bold',
           'italic' 		=> true,
           'italic_value' 		=> '',
           'secondary_font' 		=> true,
           'secondary_font_value' 		=> '',
           'color' 		=> true,
           'color_value' 		=> 'white',
           'text_group'            => "Advanced"
       )),
       array(
           array (
               'param_name' 	=> 'title_size',
               'type' 			=> 'dropdown',
               'heading' 		=> __('Title size', 'pixfort-core'),
               'admin_label'	=> false,
               'std'           => 'h5',
               'group'         => 'Advanced',
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
               'group'         => 'Advanced',
               "dependency" => array(
                     "element" => "title_size",
                     "value" => "custom"
                 ),
           ),
       ),
       pix_get_text_format_params(array(
           'prefix' 		=> 'link_',
           'name' 		=> 'Link',
           'bold' 		=> true,
           'bold_value' 		=> 'font-weight-bold',
           'italic' 		=> true,
           'italic_value' 		=> '',
           'secondary_font' 		=> true,
           'secondary_font_value' 		=> '',
           'text_group'            => "Advanced",
           'color' 		=> true,
           'color_value' 		=> 'light-opacity-6',
       )),
       array(
           array (
               'param_name' 	=> 'link_size',
               'type' 			=> 'dropdown',
               'heading' 		=> __('Link font Size', 'pixfort-core'),
               'description' 	=> __('Select the size of the text.', 'pixfort-core'),
               'admin_label'	=> false,
               'group'         => 'Advanced',
               'value'			=> array_flip(array(
                   ''			=> 'Default (16px)',
                   'text-xs'		=> '12px',
                   'text-sm'		=> '14px',
                   'text-sm'		=> '14px',
                   'text-18' 		=> '18px',
                   'text-20' 		=> '20px',
                   'text-24' 		=> '24px',
               )),
           ),

           array (
               'param_name' 	=> 'align',
               'type' 			=> 'dropdown',
               'heading' 		=> __('Content align', 'pixfort-core'),
               'description' 	=> __('Select the align of the content.', 'pixfort-core'),
               'admin_label'	=> false,
               'group'         => 'Advanced',
               'value'			=> array_flip(array(
                   'text-left'			=> 'Start',
                   'text-center'		=> 'Center',
                   'text-right' 		=> 'End',
               )),
           ),


           array (
               'param_name' 	=> 'rounded_img',
               'type' 			=> 'dropdown',
               'heading' 		=> __('Rounded corners', 'pixfort-core'),
               'admin_label'	=> false,
               'std'	=> 'rounded-lg',
               'group'         => 'Advanced',
               'value' 		=> array(
                   __('No','pixfort-core') 	=> 'rounded-0',
                   __('Rounded','pixfort-core')	    => 'rounded',
                   __('Rounded Large','pixfort-core')	    => 'rounded-lg',
                   __('Rounded 5px','pixfort-core')	    => 'rounded-xl',
                   __('Rounded 10px','pixfort-core')	    => 'rounded-10',
               )
           ),


           array (
               'param_name' 	=> 'overlay_color',
               'type' 			=> 'dropdown',
               'heading' 		=> __('Overlay Color', 'pixfort-core'),
               'admin_label'	=> false,
               'group'         => 'Advanced',
               'value' 		=> $colors,
               'std'			=> 'heading-default',
           ),

           array (
               'param_name' 	=> 'overlay_custom_color',
               'type' 			=> 'colorpicker',
               'heading' 		=> __('Custom hover overlay color', 'pixfort-core'),
               'admin_label'	=> false,
               'group'         => 'Advanced',
               "dependency" => array(
                     "element" => "overlay_color",
                     "value" => "custom"
                 ),
           ),

           array(
               'param_name'       => 'overlay_opacity',
               'type'     => 'dropdown',
               'heading'    => __('Overlay opacity', 'redux-framework-demo'),
               'group'         => 'Advanced',
               'std'  => 'pix-opacity-4',
               'value'  => array_flip(array(
                   'pix-opacity-10'   => "0%",
                   'pix-opacity-9'   => "10%",
                   'pix-opacity-8'   => "20%",
                   'pix-opacity-7'   => "30%",
                   'pix-opacity-6'   => "40%",
                   'pix-opacity-5'   => "50%",
                   'pix-opacity-4'   => "60%",
                   'pix-opacity-3'   => "70%",
                   'pix-opacity-2'   => "80%",
                   'pix-opacity-1'   => "90%",
               ))
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









           array(
                 "type" => "checkbox",
                 "heading" => __( "Badge format", "pixfort-core" ),
                 "param_name" => "badge_bold",
                 'group'         => 'Badge',
                 "value" => array("Bold" => "font-weight-bold",),
                 'std'      => 'font-weight-bold'
             ),
           array(
                 "type" => "checkbox",
                 "param_name" => "badge_italic",
                 'group'         => 'Badge',
                 "value" => array("Italic" => "font-italic",),
             ),
           array(
                 "type" => "checkbox",
                 "param_name" => "badge_secondary_font",
                 "value" => array("Secondary font" => "secondary-font",),
                 'group'         => 'Badge',
             ),


           array (
               'param_name' 	=> 'badge_text_color',
               'type' 			=> 'dropdown',
               'heading' 		=> __('Text color', 'pixfort-core'),
               'admin_label'	=> false,
               'value' 		=> $colors,
               'std'           => 'primary',
               'group'         => 'Badge',
           ),

           array (
               'param_name' 	=> 'badge_text_custom_color',
               'type' 			=> 'colorpicker',
               'heading' 		=> __('Text custom color', 'pixfort-core'),
               'admin_label'	=> false,
               "dependency" => array(
                     "element" => "badge_text_color",
                     "value" => "custom"
                 ),
                 'group'         => 'Badge',
           ),

           array (
               'param_name' 	=> 'badge_bg_color',
               'type' 			=> 'dropdown',
               'heading' 		=> __('Background color', 'pixfort-core'),
               'admin_label'	=> false,
               'value' 		=> $bg_colors,
               'std'			=> 'white',
                'group'         => 'Badge',
           ),
           array (
               'param_name' 	=> 'badge_custom_bg_color',
               'type' 			=> 'colorpicker',
               'heading' 		=> __('Custom Background Color', 'pixfort-core'),
               'admin_label'	=> false,
               "dependency" => array(
                     "element" => "badge_bg_color",
                     "value" => "custom"
                 ),
                 'group'         => 'Badge',
           ),


           array (
               'param_name' 	=> 'badge_text_custom_size',
               'type' 			=> 'textfield',
               'heading' 		=> __('Text Size', 'pixfort-core'),
               'admin_label'	=> false,
               'value'          => '12px',
                 'group'         => 'Badge',
           ),


               array(
               'type' => 'css_editor',
               'heading' => __( 'Css', 'pixfort-core' ),
               'param_name' => 'custom_css',
               'group' => __( 'Badge design options', 'pixfort-core' ),
               ),

       ),
       $effects_params
    )

));

 ?>
