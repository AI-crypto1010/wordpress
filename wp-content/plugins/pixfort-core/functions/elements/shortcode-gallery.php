<?php

// Gallery -------------------------------------------
vc_map( array (
    'base' 			=> 'pix_gallery',
    'name' 			=> __('Gallery', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/gallery.png',
    'description' 	=> __('Create custom Gallery element', 'pixfort-core'),
    'params' 		=> array (
        array(
              'type' => 'param_group',
              'value' => '',
              'param_name' => 'items',
              'heading' 		=> __('Images', 'pixfort-core'),
              'params' => array(

                  array (
                      'param_name' 	=> 'image',
                      'type' 			=> 'attach_image',
                      'heading' 		=> __('Image', 'pixfort-core'),
                      'admin_label'	=> false,
                  ),

                  array (
                      'param_name' 	=> 'title',
                      'type' 			=> 'textfield',
                      'heading' 		=> __('Title', 'pixfort-core'),
                      'admin_label'	=> true,
                  ),

                  array (
                      'param_name' 	=> 'desc',
                      'type' 			=> 'textarea',
                      'heading' 		=> __('Image Description', 'pixfort-core'),
                      'admin_label'	=> false,
                      'value' 		=> __('', 'pixfort-core'),
                  ),

                  array(
                        "type" => "checkbox",
                        "heading" => __( "Use link instead of Lightbox", "pixfort-core" ),
                        "param_name" => "enable_link",
                        "value" => __( "Yes", "pixfort-core" ),
                    ),

                  array (
                      'param_name' 	=> 'link',
                      'type' 			=> 'vc_link',
                      'heading' 		=> __('Link', 'pixfort-core'),
                      "dependency" => array(
                            "element" => "enable_link",
                            "not_empty" => true
                        ),
                  ),

                  // array(
                  //       "type" => "checkbox",
                  //       "heading" => __( "Open in a new tab", "pixfort-core" ),
                  //       "param_name" => "target",
                  //       "value" => __( "Yes", "pixfort-core" ),
                  //       "dependency" => array(
                  //             "element" => "link",
                  //             "not_empty" => true
                  //         ),
                  //   ),


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





                  array (
                      'param_name' 	=> 'grid_size',
                      'type' 			=> 'dropdown',
                      'heading' 		=> __('Item width', 'pixfort-core'),
                      'description' 	=> __('Select the size of the grid box.', 'pixfort-core'),
                      'admin_label'	=> false,
                      'value'			=> array_flip(array(
                          'grid-item'		=> 'Default',
                          'grid-item grid-item--width2'		=> 'Wide'
                      )),
                  ),

                  array (
                      'param_name' 	=> 'gallery_height',
                      'type' 			=> 'dropdown',
                      'heading' 		=> __('Item Height', 'pixfort-core'),
                      'description' 	=> __('Select the height of the image.', 'pixfort-core'),
                      'admin_label'	=> false,
                      'value'			=> array_flip(array(
                          'pix-gallery-sm'		=> 'Default',
                          'pix-gallery-lg'		=> 'Tall'
                      )),
                  ),



              )
        ),

        array (
            'param_name' 	=> 'pix_columns',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Grid columns', 'pixfort-core'),
            'description' 	=> __('The number of columns.', 'pixfort-core'),
            'admin_label'	=> false,
            'value'			=> array(
                '3 Columns'		=> 'pix-3-columns',
                '4 Columns'		=> 'pix-4-columns'
            ),
        ),
        array (
            'param_name' 	=> 'pix_style',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Grid style', 'pixfort-core'),
            // 'description' 	=> __('The number of columns.', 'pixfort-core'),
            'admin_label'	=> false,
            'value'			=> array(
                'Default (with paddings)'		=> '',
                'Without paddings'		=> 'gutter-0'
            ),
        ),
        array (
            'param_name' 	=> 'full_size_img',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Enable full size images', 'pixfort-core'),
            'description' 	=> __('The images will be displayed in full size instead of cropping (Item Height option will be disabled).', 'pixfort-core'),
            'admin_label'	=> false,
            'value'			=> array(
                'No'		=> 'no',
                'Yes'		=> 'Yes'
            ),
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

        array(
         "type" => "dropdown",
         "heading" => __("Shadow Style", "js_composer"),
         "param_name" => "style",
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
         'group' => __( 'Styling', 'pixfort-core' ),
         "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
        ),
        array(
        "type" => "dropdown",
        "heading" => __("Shadow Hover Style", "js_composer"),
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
        )),
        'save_always' => true,
        'group' => __( 'Styling', 'pixfort-core' ),
        "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
        ),
        array(
        "type" => "dropdown",
        "heading" => __("Hover Animation", "js_composer"),
        "param_name" => "add_hover_effect",
        "admin_label" => true,
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
        'group' => __( 'Styling', 'pixfort-core' ),
        "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
        ),




        array(
              "type" => "checkbox",
              "param_name" => "pix_tilt",
              "value" => array_flip(array(
                "tilt"       => "3D Hover",
            )),
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
              'std' => 'h6',
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
              'param_name' 	=> 'gallery_id',
              'type' 			=> 'textfield',
              'heading' 		=> __('Gallery ID', 'pixfort-core'),
              'std' 		=> "gallery",
              'admin_label'	=> false,
              'group' => __( 'Advanced', 'pixfort-core' ),
              "description" => __( "If you have multiple gallery elements in the page you can set a unique ID for each gallery to open the gallery items separately.", "pixfort-core")
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
