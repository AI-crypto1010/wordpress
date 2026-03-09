<?php

// Text -----------------------------
vc_map( array (
    'base' 			=> 'pix_testimonial_masonry',
    'name' 			=> __('Testimonial masonry', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/testimonials-masonry.png',
    'description' 	=> __('Create custom masonry testimonials', 'pixfort-core'),
    // "front_enqueue_js" => PIX_CORE_PLUGIN_URI . 'functions/js/views/testimonial-masonry.js',
    'params' 		=> array_merge(
        array(
            array(
                  'type' => 'param_group',
                  'value' => '',
                  'param_name' => 'items',
                  'heading' 		=> __('Items', 'pixfort-core'),
                  'description' 	=> __('Add each icon in the desired order.', 'pixfort-core'),
                  'params' => array_merge(
                      array(
                          array (
                              'param_name' 	=> 'grid_size',
                              'type' 			=> 'dropdown',
                              'heading' 		=> __('Testimonial Size', 'pixfort-core'),
                              'description' 	=> __('Select the size of the grid box.', 'pixfort-core'),
                              'admin_label'	=> false,
                              'value'			=> array_flip(array(
                                  'grid-item'		=> 'Default',
                                  'grid-item grid-item--width2'		=> 'Wide'
                              )),
                          ),
                      ),
                      array(

                          array (
                          'param_name' 	=> 'image',
                          'type' 			=> 'attach_image',
                          'heading' 		=> __('Image', 'pixfort-core'),
                          'admin_label'	=> false,
                          ),

                          array (
                              'param_name' 	=> 'img_style',
                              'type' 			=> 'dropdown',
                              'heading' 		=> __('Image style', 'pixfort-core'),
                              // 'description' 	=> __('Wrap name into H1 instead of H2', 'pixfort-core'),
                              'admin_label'	=> false,
                              'std'           => 'standard',
                              'value' 		=> array(
                                  __('Standard','pixfort-core')	    => 'standard',
                                  __('Circle Bottom','pixfort-core') 	=> 'circle_bottom',
                                  __('Circle Top','pixfort-core') 	=> 'circle_top',
                              ),
                          ),

                          array (
                          'param_name' 	=> 'width',
                          'type' 			=> 'textfield',
                          'heading' 		=> __('Max Width of the image (Optional)', 'pixfort-core'),
                          'description'    => 'Input the width of the image in pixels (without the unit, for example 200).',
                          'admin_label'	=> false,
                          "dependency" => array(
                             "element" => "image",
                             "not_empty" => true
                          ),
                          ),
                          array (
                          'param_name' 	=> 'height',
                          'type' 			=> 'textfield',
                          'heading' 		=> __('Max Height of the image (Optional)', 'pixfort-core'),
                          'description'    => 'Input the width of the image in pixels (without the unit, for example 200).',
                          'admin_label'	=> false,
                          "dependency" => array(
                             "element" => "image",
                             "not_empty" => true
                              ),
                          ),

                          array (
                          'param_name' 	=> 'name',
                          'type' 			=> 'textfield',
                          'heading' 		=> __('Name', 'pixfort-core'),
                          'admin_label'	=> false,
                          ),

                          array (
                              'param_name' 	=> 'title',
                              'type' 			=> 'textfield',
                              'heading' 		=> __('Title', 'pixfort-core'),
                              'admin_label'	=> true,
                              'value'          => 'Simply amazing!'
                          ),
                          array (
                              'param_name' 	=> 'text',
                              'type' 			=> 'textarea',
                              'heading' 		=> __('Content', 'pixfort-core'),
                              'admin_label'	=> false,
                              'value' 		=> __('"Some quick example text to build on the testimonial text and make up the bulk of the testimonial content."', 'pixfort-core'),
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
                                "value" => array("Yes" => "_blank",),
                            ),


                      )
                    )
            ),
        ),
        pix_get_text_format_params(array(
            'prefix' 		=> 'name_',
            'name' 		=> 'Name',
            'bold' 		=> true,
            'bold_value' 		=> 'font-weight-bold',
            'italic' 		=> true,
            'italic_value' 		=> '',
            'secondary_font' 		=> true,
            'secondary_font_value' 		=> '',
            'text_group'            => 'Advanced'
        )),
        array(

            array (
                'param_name' 	=> 'name_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Name color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Advanced',
                'value' 		=> $colors,
                'std'			=> 'dark-opacity-4',
            ),

            array (
                'param_name' 	=> 'name_custom_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Name custom color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Advanced',
                "dependency" => array(
                      "element" => "name_color",
                      "value" => "custom"
                  ),
            ),


            array (
                'param_name' 	=> 'name_size',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Name size', 'pixfort-core'),
                // 'description' 	=> __('Wrap name into H1 instead of H2', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Advanced',
                'std'           => 'h6',
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
                'param_name' 	=> 'name_custom_size',
                'type' 			=> 'textfield',
                'heading' 		=> __('Name Size', 'pixfort-core'),
                'group'         => 'Advanced',
                'admin_label'	=> false,
                "dependency" => array(
                      "element" => "name_size",
                      "value" => "custom"
                  ),
            ),




        ),
        pix_get_text_format_params(array(
            'prefix' 		=> 'title_',
            'name' 		=> 'Title',
            'bold' 		=> true,
            'bold_value' 		=> 'font-weight-bold',
            'italic' 		=> true,
            'italic_value' 		=> '',
            'secondary_font' 		=> true,
            'secondary_font_value' 		=> '',
            'text_group'            => 'Advanced'
        )),
        array(

            array (
                'param_name' 	=> 'title_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Title color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Advanced',
                'value' 		=> $colors,
                'std'			=> 'primary',
            ),

            array (
                'param_name' 	=> 'title_custom_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Title custom color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Advanced',
                "dependency" => array(
                      "element" => "title_color",
                      "value" => "custom"
                  ),
            ),


            array (
                'param_name' 	=> 'title_size',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Title font Size', 'pixfort-core'),
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



        ),
        pix_get_text_format_params(array(
            'prefix' 		=> 'text_',
            'name' 		=> 'Text',
            'bold' 		=> true,
            'bold_value' 		=> '',
            'italic' 		=> true,
            'italic_value' 		=> 'font-italic',
            'secondary_font' 		=> true,
            'secondary_font_value' 		=> '',
            'text_group'            => 'Advanced'
        )),
        array(

            array (
                'param_name' 	=> 'text_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Text color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Advanced',
                'value' 		=> $colors,
                'std'			=> 'body-default',
            ),

            array (
                'param_name' 	=> 'text_custom_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Text custom color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Advanced',
                "dependency" => array(
                      "element" => "text_color",
                      "value" => "custom"
                  ),
            ),

            array (
                'param_name' 	=> 'text_size',
                'type' 			=> 'dropdown',
                'heading' 		=> __('text font Size', 'pixfort-core'),
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
                'param_name' 	=> 'items_bg_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Background color', 'pixfort-core'),
                'admin_label'	=> false,
                'value' 		=> $bg_colors,
                'std'			=> 'light-opacity-5',
                "group"	      => "Advanced",
            ),
            array (
                'param_name' 	=> 'items_custom_bg_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Custom Background Color', 'pixfort-core'),
                'admin_label'	=> false,
                "group"	      => "Advanced",
                "dependency" => array(
                      "element" => "items_bg_color",
                      "value" => "custom"
                  ),
            ),
            array (
                'param_name' 	=> 'circle_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Circle Color', 'pixfort-core'),
                "group"	      => "Advanced",
                'description' 	=> __('Select the color of the circle.', 'pixfort-core'),
                'admin_label'	=> false,
                'std'	=> 'gradient-primary',
                'value'			=> array_merge(
                    array("None"    => 'pix-bg-custom'),
                    $bg_colors
                ),
            ),
            array (
                'param_name' 	=> 'circle_custom_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Custom Circle color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Advanced',
                "dependency" => array(
                      "element" => "circle_color",
                      "value" => "custom"
                  ),
            ),






         ),
         $effects_params,
         array(
             array (
                 'param_name' 	=> 'rounded_box',
                 'type' 			=> 'dropdown',
                 'std' 			=> 'rounded-lg',
                 "group"	      => "Advanced",
                 'heading' 		=> __('Rounded corners', 'pixfort-core'),
                 'admin_label'	=> false,
                 'value' 		=> array(
                     __('No','pixfort-core') 	=> 'rounded-0',
                     __('Rounded','pixfort-core')	    => 'rounded',
                     __('Rounded Large','pixfort-core')	    => 'rounded-lg',
                     __('Rounded 5px','pixfort-core')	    => 'rounded-xl',
                     __('Rounded 10px','pixfort-core')	    => 'rounded-10',
                 )
             ),
         ),
         $animation_params,

        array (

            // array (
            //     'param_name' 	=> 'content',
            //     'type' 			=> 'textarea',
            //     'heading' 		=> __('Content', 'pixfort-core'),
            //     'admin_label'	=> true,
            //     'value' 		=> __('Insert your content here', 'pixfort-core'),
            // ),








            array(
              'type' => 'css_editor',
              'heading' => __( 'Css', 'pixfort-core' ),
              'param_name' => 'css',
              'group' => __( 'Design options', 'pixfort-core' ),
              ),
        )



    )
));

 ?>
