<?php


// Testimonials Carousel ----------------------------------------------
vc_map( array (
    'base' 			=> 'testimonials_slider',
    'name' 			=> __('Testimonials Carousel', 'pixfort-core'),
    'description' 	=> __('Add custom testimonials carousel', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/testimonials-carousel.png',
    'params' 		=> array_merge(
        array (



            // array (
            //     'param_name' 	=> 'style',
            //     'type' 			=> 'dropdown',
            //     'heading' 		=> __('Style', 'pixfort-core'),
            //     'admin_label'	=> false,
            //     'value' 		=> array_flip(array(
            //         ''			=> 'Default',
            //         'nobox' 	=> 'Without boxes',
            //     )),
            // ),

            // array (
            //     'param_name' 	=> 'dots_style',
            //     'type' 			=> 'dropdown',
            //     'heading' 		=> __('Dots', 'pixfort-core'),
            //     'admin_label'	=> false,
            //     'value' 		=> array_flip(array(
            //         ''			=> 'Default',
            //         'light-dots' 	=> 'Light',
            //         'no-dots' 	=> 'Hide dots',
            //     )),
            // ),

            array(
        		  'type' => 'param_group',
        		  'value' => '',
        		  'param_name' => 'testimonials',
        		  'heading' 		=> __('Testimonials', 'pixfort-core'),
        		  'params' => array(

                      array (
                          'param_name' 	=> 'text',
                          'type' 			=> 'textarea',
                          'heading' 		=> __('Content', 'pixfort-core'),
                          'admin_label'	=> true,
                          'value' 		=> __('Insert your content here', 'pixfort-core'),
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
                         'admin_label'	=> false,
                     ),

        			  array (
        				  'param_name' 	=> 'image',
        				  'type' 			=> 'attach_image',
        				  'heading' 		=> __('Image', 'pixfort-core'),
        				  'admin_label'	=> false,
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
        	),


            // Styling
            array (
                'param_name' 	=> 'img_style',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Image style', 'pixfort-core'),
                // 'description' 	=> __('Wrap name into H1 instead of H2', 'pixfort-core'),
                'admin_label'	=> false,
                'std'           => 'circle_bottom',
                'save_always' => true,
                "group" => __( "Styling", "pixfort-core" ),
                'value' 		=> array(
                    __('Standard','pixfort-core')	    => 'standard',
                    __('Circle Bottom','pixfort-core') 	=> 'circle_bottom',
                    __('Circle Top','pixfort-core') 	=> 'circle_top',
                ),
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
            'text_group'            => 'Styling'
        )),
        array(

            array (
                'param_name' 	=> 'name_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Name color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Styling',
                'value' 		=> $colors,
                'std'			=> 'dark-opacity-4',
            ),

            array (
                'param_name' 	=> 'name_custom_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Name custom color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Styling',
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
                'group'         => 'Styling',
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
                'group'         => 'Styling',
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
            'text_group'            => 'Styling'
        )),
        array(

            array (
                'param_name' 	=> 'title_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Title color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Styling',
                'value' 		=> $colors,
                'std'			=> 'primary',
            ),

            array (
                'param_name' 	=> 'title_custom_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Title custom color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Styling',
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
                'group'         => 'Styling',
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
            'text_group'            => 'Styling'
        )),
        array(

            array (
                'param_name' 	=> 'text_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Text color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Styling',
                'value' 		=> $colors,
                'std'			=> 'body-default',
            ),

            array (
                'param_name' 	=> 'text_custom_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Text custom color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Styling',
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
                'group'         => 'Styling',
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
                "group"	      => "Styling",
            ),
            array (
                'param_name' 	=> 'items_custom_bg_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Custom Background Color', 'pixfort-core'),
                'admin_label'	=> false,
                "group"	      => "Styling",
                "dependency" => array(
                      "element" => "items_bg_color",
                      "value" => "custom"
                  ),
            ),
            array (
                'param_name' 	=> 'circle_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Circle Color', 'pixfort-core'),
                "group"	      => "Styling",
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
                "group"	      => "Styling",
                "dependency" => array(
                      "element" => "circle_color",
                      "value" => "custom"
                  ),
            ),

            array (
                'param_name' 	=> 'rounded_box',
                'type' 			=> 'dropdown',
                "group"	      => "Styling",
                'heading' 		=> __('Rounded corners', 'pixfort-core'),
                'admin_label'	=> false,
                'std'	=> 'rounded-lg',
                'value' 		=> array(
                    __('No','pixfort-core') 	=> 'rounded-0',
                    __('Rounded','pixfort-core')	    => 'rounded',
                    __('Rounded Large','pixfort-core')	    => 'rounded-lg',
                    __('Rounded 5px','pixfort-core')	    => 'rounded-xl',
                    __('Rounded 10px','pixfort-core')	    => 'rounded-10',
                )
            ),


            array (
                'param_name' 	=> 'animation',
                'type' 			=> 'dropdown',
                "group"	      => "Styling",
                'heading' 		=> __('Animation', 'pixfort-core'),
                'description' 	=> __('Select the animation of the heading.', 'pixfort-core'),
                'admin_label'	=> false,
                'value'			=> pix_get_animations(),
            ),
            array (
                'param_name' 	=> 'delay',
                'type' 			=> 'textfield',
                "group"	      => "Styling",
                'heading' 		=> __('Animation delay (in miliseconds)', 'pixfort-core'),
                'admin_label'	=> true,
                "dependency" => array(
                      "element" => "animation",
                      "not_empty" => true
                  ),
            ),



        ),
        $effects_params,
        array(









            // Advanced

            array (
                'param_name' 	=> 'slider_num',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Slides per page', 'pixfort-core'),
                'admin_label'	=> false,
                'value' 		=> array(
                    "1" 	=> 1,
                    "2" 	=> 2,
                    "3" 	=> 3,
                    "4" 	=> 4,
                    "5" 	=> 5,
                    "6" 	=> 6,
                ),
                "std"   => 3,
                 "group" => __( "Advanced", "pixfort-core" ),
            ),
            // array (
            //     'param_name' 	=> 'slider_num_mobile',
            //     'type' 			=> 'dropdown',
            //     'heading' 		=> __('Slides per page (Mobile)', 'pixfort-core'),
            //     'admin_label'	=> false,
            //     'value' 		=> array(
            //         "Default" 	=> '',
            //         "1" 	=> 1,
            //         "2" 	=> 2,
            //         "3" 	=> 3,
            //         "4" 	=> 4,
            //         "5" 	=> 5,
            //         "6" 	=> 6,
            //     ),
            //     "std"   => '',
            //      "group" => __( "Advanced", "pixfort-core" ),
            // ),
        ),
        defined('PIXFORT_SLIDER_SWIPER') ? array(
            array (
                'param_name' 	=> 'slider_num_mobile',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Slides per page (Mobile)', 'pixfort-core'),
                'admin_label'	=> false,
                'value' 		=> array(
                    "1" 	=> 1,
                    "2" 	=> 2,
                    "3" 	=> 3,
                    "4" 	=> 4,
                    "5" 	=> 5,
                    "6" 	=> 6,
                ),
                "std"   => 1,
                "group" => __( "Advanced", "pixfort-core" ),
            ),
        ) : array(),
        array(
            array (
                'param_name' 	=> 'slider_style',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Slides style', 'pixfort-core'),
                'admin_label'	=> false,
                'std'	=> 'pix-standard',
                'value' 		=> array(
                    __('Standard','pixfort-core')         	        => 'pix-style-standard',
                    __('One active item','pixfort-core')         	=> 'pix-one-active',
                    __('Faded items','pixfort-core') 	            => 'pix-opacity-slider',
                ),
                "group" => __( "Advanced", "pixfort-core" ),
            ),
            array (
                'param_name' 	=> 'slider_effect',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Slides effect', 'pixfort-core'),
                'admin_label'	=> false,
                'std'	=> 'pix-opacity-slider',
                'value' 		=> array(
                    __('Standard','pixfort-core') 	                => 'pix-effect-standard',
                    __('Circular effect','pixfort-core') 	        => 'pix-circular-slider',
                    __('Circular Start Only','pixfort-core') 	        => 'pix-circular-left',
                    __('Circular End Only','pixfort-core') 	    => 'pix-circular-right',
           __('Fade out','pixfort-core') 	                => 'pix-fade-out-effect',
                ),
                 "group" => __( "Advanced", "pixfort-core" ),
            ),

            array(
                "type" => "checkbox",
                "heading" => __( "Drag Scale Animation", "pixfort-core" ),
                "param_name" => "drag_scale",
                "value" => array('Yes' => 'true'),
                'save_always' => true,
                'std' => false,
                "group" => __( "Advanced", "pixfort-core" ),
            ),
            array(
                  "type" => "checkbox",
                  "heading" => __( "Show navigation buttons", "pixfort-core" ),
                  "param_name" => "prevnextbuttons",
                  "value" => array('Yes' => true),
                  'save_always' => true,
                  'std' => true,
                  "group" => __( "Advanced", "pixfort-core" ),
              ),
            array(
                  "type" => "checkbox",
                  "heading" => __( "Dots", "pixfort-core" ),
                  "param_name" => "pagedots",
                  "value" => array('Yes' => true),
                  'std' => true,
                  'save_always' => true,
                  "group" => __( "Advanced", "pixfort-core" ),
              ),
              array (
                  'param_name' 	=> 'dots_style',
                  'type' 			=> 'dropdown',
                  'heading' 		=> __('Dots & Navigation style', 'pixfort-core'),
                  'admin_label'	=> false,
                  // 'save_always' => true,
                  "group" => __( "Advanced", "pixfort-core" ),
                  'value' 		=> array_flip(array(
                      ''			=> 'Default',
                      'light-dots' 	=> 'Light',
                      // 'no-dots' 	=> 'Hide dots',
                  )),
                  // "dependency" => array(
                  //       "element" => "pagedots",
                  //       "not_empty" => true
                  //   ),
              ),
              array (
                  'param_name' 	=> 'dots_align',
                  'type' 			=> 'dropdown',
                  'heading' 		=> __('Dots', 'pixfort-core'),
                  'admin_label'	=> false,
                  "group" => __( "Advanced", "pixfort-core" ),
                  'value' 		=> array_flip(array(
                      ''			=> 'Center',
                      'pix-dots-left' 	=> 'Left',
                      'pix-dots-right' 	=> 'Right',
                  )),
                  "dependency" => array(
                        "element" => "pagedots",
                        "not_empty" => true
                    ),
              ),
            array(
                  "type" => "checkbox",
                  "heading" => __( "Free Scroll", "pixfort-core" ),
                  "param_name" => "freescroll",
                  "value" => array('Yes' => true),
                  'save_always' => true,
                  "group" => __( "Advanced", "pixfort-core" ),
              ),
              array (
                  'param_name' 	=> 'cellalign',
                  'type' 			=> 'dropdown',
                  'heading' 		=> __('Main cell Align', 'pixfort-core'),
                  'admin_label'	=> false,
                  'group'	=> 'Advanced',
                  'value' 		=> array_flip(array(
                      'center'			=> 'Center',
                      'left' 	=> 'Start',
                      'right' 	=> 'End',
                  )),
              ),
              array(
                    "type" => "checkbox",
                    "heading" => __( "Scale main item", "pixfort-core" ),
                    "param_name" => "slider_scale",
                    "value" => array('Yes' => 'pix-slider-scale'),
                    'save_always' => true,
                    "group" => __( "Advanced", "pixfort-core" ),
                ),
              array (
                  'param_name' 	=> 'cellpadding',
                  'type' 			=> 'dropdown',
                  'heading' 		=> __('Cells padding', 'pixfort-core'),
                  'admin_label'	=> false,
                  'group'	=> 'Advanced',
                  'std'	=> 'pix-p-10',
                  'value' 		=> array_flip(array(
                      'p-0'			       => '0px',
                      'pix-p-5'			=> '5px',
                      'pix-p-10'			=> '10px',
                      'pix-p-15'			=> '15px',
                      'pix-p-20'			=> '20px',
                      'pix-p-25'			=> '25px',
                      'pix-p-30'			=> '30px',
                      'pix-p-35'			=> '35px',
                      'pix-p-40'			=> '40px',
                      'pix-p-45'			=> '45px',
                      'pix-p-50'			=> '50px',
                  )),
              ),
              array(
                    "type" => "checkbox",
                    "heading" => __( "Autoplay", "pixfort-core" ),
                    "param_name" => "autoplay",
                    "value" => array('Yes' => true),
                    'save_always' => true,
                    "group" => __( "Advanced", "pixfort-core" ),
                ),
                array (
                    'param_name' 	=> 'autoplay_time',
                    'type' 			=> 'textfield',
                    'heading' 		=> __('Autoplay time', 'pixfort-core'),
                    'description' 		=> __('The time between auto slides in milliseconds.', 'pixfort-core'),
                    'admin_label'	=> false,
                    'std'			=> '1500',
                    'group'			=> 'Advanced',
                    "dependency" => array(
                          "element" => "autoplay",
                          "not_empty" => true
                      ),
                ),
            array(
                  "type" => "checkbox",
                  "heading" => __( "Adaptive height", "pixfort-core" ),
                  "param_name" => "adaptiveheight",
                  "value" => true,
                  'save_always' => true,
                  'std' => true,
                  "group" => __( "Advanced", "pixfort-core" ),
              ),
            array(
                  "type" => "checkbox",
                  "heading" => __( "Right to Left", "pixfort-core" ),
                  "param_name" => "righttoleft",
                  "value" => true,
                  'save_always' => true,
                  "group" => __( "Advanced", "pixfort-core" ),
              ),
            array(
                  "type" => "checkbox",
                  "heading" => __( "Wrap slides", "pixfort-core" ),
                  "param_name" => "slider_wrap",
                  "value" => true,
                  "std" => true,
                  'save_always' => true,
                  "group" => __( "Advanced", "pixfort-core" ),
              ),
            array(
                  "type" => "checkbox",
                  "heading" => __( "Increase vertical view", "pixfort-core" ),
                  "param_name" => "visible_y",
                  "value" => array("Yes" => 'pix-overflow-y-visible'),
                  'save_always' => true,
                  "group" => __( "Advanced", "pixfort-core" ),
              ),
            array(
                  "type" => "checkbox",
                  "heading" => __( "Visible overflow", "pixfort-core" ),
                  "description" => "slides outside the slider view box will be visible.",
                  "param_name" => "visible_overflow",
                  "value" => array("Yes" => 'pix-overflow-all-visible'),
                  'save_always' => true,
                  "group" => __( "Advanced", "pixfort-core" ),
              ),



            array(
              'type' => 'css_editor',
              'heading' => __( 'Css', 'pixfort-core' ),
              'param_name' => 'css',
              'group' => __( 'Design options', 'pixfort-core' ),
              ),





        ),
        pix_get_wpb_carousel_navigation_params($colors, $colors_with_transparent)
    )
));

 ?>
