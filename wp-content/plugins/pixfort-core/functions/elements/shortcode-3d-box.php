<?php

// 3D box ----------------------------------------------
vc_map( array (
    'base' 			=> 'pix_3d_box',
    'name' 			=> __('3D box', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/3d-box.apng',
    'description' 	=> __('Create 3D effect box', 'pixfort-core'),
    'params' 		=> array_merge(
        array (

            array (
                'param_name' 	=> 'title',
                'type' 			=> 'textfield',
                'heading' 		=> __('Title', 'pixfort-core'),
                'admin_label'	=> true,
            ),
            array (
                'param_name' 	=> 'text',
                'type' 			=> 'textarea',
                'heading' 		=> __('Text', 'pixfort-core'),
                'admin_label'	=> true,
            ),

            array (
                'param_name' 	=> 'bg_img',
                'type' 			=> 'attach_image',
                'heading' 		=> __('Image', 'pixfort-core'),
                'admin_label'	=> false,
            ),
            ...( \PixfortCore::instance()->getThemeParam('dynamic_wpb_images') ? [
                array(
                    'param_name' 	=> 'dynamic_bg_img',
                    'type' 			=> 'pix_dynamic_image',
                    'heading' 		=> __('Dynamic image source', 'pixfort-core'),
                    'description' 	=> __('Select a dynamic image source (optional). If image is not available, the normal image will be used.', 'pixfort-core'),
                ),
            ] : [] ),




            // Advanced
            array(
                "type" => "checkbox",
                "heading" => __( "Title format", "pixfort-core" ),
                "param_name" => "bold",
                "value" => array("Bold" => "font-weight-bold"),
                "std" => "font-weight-bold",
                "group"   => "Advanced",
            ),
            array(
                "type" => "checkbox",
                "param_name" => "italic",
                "value" => array("Italic" => "font-italic",),
                "group"   => "Advanced",
            ),
            array(
                "type" => "checkbox",
                "param_name" => "secondary_font",
                "value" => array("Secondary font" => "secondary-font",),
                "group"   => "Advanced",
            ),

            array (
                'param_name' 	=> 'title_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Title color', 'pixfort-core'),
                'admin_label'	=> false,
                'value' 		=> $colors,
                'std'			=> '',
                "group"   => "Advanced",

            ),

            array (
                'param_name' 	=> 'title_custom_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Title color', 'pixfort-core'),
                'admin_label'	=> false,
                "dependency" => array(
                    "element" => "title_color",
                    "value" => "custom"
                ),
                "group"   => "Advanced",
            ),

            array (
                'param_name' 	=> 'title_size',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Title size', 'pixfort-core'),
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
                'std'   => 'h2',
                "group"   => "Advanced",
            ),

            array (
                'param_name' 	=> 'title_custom_size',
                'type' 			=> 'textfield',
                'heading' 		=> __('Custom Title Size', 'pixfort-core'),
                'admin_label'	=> false,
                "dependency" => array(
                    "element" => "title_size",
                    "value" => "custom"
                ),
                "group"   => "Advanced",
            ),


            array (
                'param_name' 	=> 'content_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Content color', 'pixfort-core'),
                'admin_label'	=> false,
                'std'           => 'light-opacity-5',
                'value' 		=> $colors,
                "group"   => "Advanced",
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
                "group"   => "Advanced",
            ),

            array (
                'param_name' 	=> 'content_size',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Size', 'pixfort-core'),
                'description' 	=> __('Select the size of the text.', 'pixfort-core'),
                'admin_label'	=> false,
                'value'			=> array_flip(array(
                    ''			=> 'Default (16px)',
                    'text-xs'		=> '12px',
                    'text-sm'		=> '14px',
                    'text-sm'		=> '14px',
                    'text-18' 		=> '18px',
                    'text-20' 		=> '20px',
                    'text-24' 		=> '24px',
                )),
                "group"   => "Advanced",
            ),


            array (
                'param_name' 	=> 'content_align',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Content align', 'pixfort-core'),
                'admin_label'	=> false,
                "group"   => "Advanced",
                'value'			=> array_flip(array(
                    'left'	=> 'Start',
                    'center'	=> 'Center',
                    'right'	=> 'End',
                )),
            ),


            array (
                'param_name' 	=> 'rounded_img',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Rounded corners', 'pixfort-core'),
                'admin_label'	=> false,
                "group"   => "Advanced",
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
                'heading' 		=> __('Overlay color', 'pixfort-core'),
                'admin_label'	=> false,
                'value' 		=> $bg_colors,
                'std'			=> 'black',
                "group"   => "Advanced",
            ),
            array (
                'param_name' 	=> 'custom_overlay_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Custom Overlay Color', 'pixfort-core'),
                'admin_label'	=> false,
                "group"   => "Advanced",
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
             "std"      => 'pix-opacity-3',
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
                 "std"      => 'pix-hover-opacity-7',
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
                'type' => 'css_editor',
                'heading' => __( 'Css', 'pixfort-core' ),
                'param_name' => 'item_css',
                'group' => __( 'Design options', 'pixfort-core' ),
            ),




        ),
        pix_add_params_group($button_params, "Button Options"),
        array(
            array(
                'type' => 'css_editor',
                'heading' => __( 'Css', 'pixfort-core' ),
                'param_name' => 'css',
                'group' => __( 'Button Design options', 'pixfort-core' ),
            ),
        )
    )
));

?>
