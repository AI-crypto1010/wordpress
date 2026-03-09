<?php

// Blog Slider -----------------------------
vc_map( array (
    'base' 			=> 'pix_blog_slider',
    'name' 			=> __('Blog Carousel', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/blog-carousel.png',
    'description' 	=> __('Add slick posts carousel', 'pixfort-core'),
    'params' 		=> array_merge(
        array (
            array (
                'param_name' 	=> 'count',
                'type' 			=> 'textfield',
                'heading' 		=> __('Posts count', 'pixfort-core'),
                'description' 	=> __('Number of posts to show', 'pixfort-core'),
                'admin_label'	=> false,
                'value'	        => 5,
            ),
            array (
                'param_name' 	=> 'category',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Category', 'pixfort-core'),
                'description' 	=> __('Select posts category.', 'pixfort-core'),
                'admin_label'	=> false,
                'value' 		=> pix_get_categories( 'category' ),
            ),
            array (
                'param_name' 	=> 'category_multi',
                'type' 			=> 'textfield',
                'heading' 		=> __('Multiple Categories', 'pixfort-core'),
                'description' 	=> __('Categories Slugs should be separated with <strong>coma</strong> (,)', 'pixfort-core'),
                'admin_label'	=> false,
            ),
            array (
                'param_name' 	=> 'offset',
                'type' 			=> 'textfield',
                'heading' 		=> __('Offset', 'pixfort-core'),
                'description' 	=> __('Number of posts to skip', 'pixfort-core'),
                'admin_label'	=> false,
                'value'	        => 0,
            ),



            array (
                'param_name' 	=> 'blog_style',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Style', 'pixfort-core'),
                'admin_label'	=> false,
                'value' 		=> array(
                    "Default (with dividers)" 	=> '',
                    "Default (with padding & dividers)" 	=> 'padding',
                    "Default (with post types)" 	=> 'default',
                    "Default (with padding & post types)" 	=> 'with-padding',
                    "Full image (with post types)" 	=> 'full-img',
                    "Left image (with post types)" 	=> 'left-img',
                    "Right image (with post types)" 	=> 'right-img',
                ),
            ),
            array (
                'param_name' 	=> 'blog_size',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Size', 'pixfort-core'),
                'admin_label'	=> false,
                'std'           => 'lg',
                'value' 		=> array(
                    "Default (Extended)" 	=> 'lg',
                    "Medium" 	=> 'md',
                    "Small" 	=> 'sm',
                ),
                'dependency' => array(
                    "element" => "blog_style",
                    "value" => array('', 'padding', 'default', 'with-padding')
                )
            ),


            array (
                'param_name' 	=> 'blog_style_box',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Add box style', 'pixfort-core'),
                'description' 		=> __('Add white box for each post.', 'pixfort-core'),
                'dependency' => array(
                    "element" => "blog_style",
                    "value" => array('', 'padding', 'default', 'with-padding')
                ),
                'admin_label'	=> false,
                'value' 		=> array(
                    'Yes' => true,
                    'No' => false
                )
            ),

            array (
                'param_name' 	=> 'blog_dark_mode',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Use dark mode', 'pixfort-core'),
                'description' 		=> __('Inverse colors.', 'pixfort-core'),
                'admin_label'	=> false,
                'dependency' => array(
                    "element" => "blog_style",
                    "value" => array('', 'padding', 'default', 'with-padding')
                ),
                'value' 		=> array(
                    'No' => '',
                    'Yes' => 'pix-dark'
                )
            ),


            array (
                'param_name' 	=> 'orderby',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Order by', 'pixfort-core'),
                'admin_label'	=> false,
                'std'	=> 'date',
                'value' 		=> array(
                    __('Date','pixfort-core') 	=> 'date',
                    __('Title','pixfort-core')	    => 'title',
                    __('Random','pixfort-core')	    => 'rand',
                    __('Number of comments','pixfort-core')	    => 'comment_count',
                    __('Last modified','pixfort-core')	    => 'modified',
                )
            ),
            array (
                'param_name' 	=> 'order',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Order by', 'pixfort-core'),
                'admin_label'	=> false,
                'std'	=> 'DESC',
                'value' 		=> array(
                    __('DESC','pixfort-core') 	=> 'DESC',
                    __('ASC','pixfort-core')	    => 'ASC',
                )
            ),



            array (
                'param_name' 	=> 'rounded_img',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Rounded corners', 'pixfort-core'),
                'admin_label'	=> false,
                'std'	=> 'rounded-lg',
                "group"	=> "Styling",
                'value' 		=> array(
                    __('No','pixfort-core') 	=> 'rounded-0',
                    __('Rounded','pixfort-core')	    => 'rounded',
                    __('Rounded Large','pixfort-core')	    => 'rounded-lg',
                    __('Rounded 5px','pixfort-core')	    => 'rounded-xl',
                    __('Rounded 10px','pixfort-core')	    => 'rounded-10',
                )
            ),
        ),

        pix_add_params_to_group( $effects_params, "Styling"),
        array(

            // ===========================================
            // Bottom Dividers
            // ===========================================
            array(
                'type'        => 'pix_param_section',
                'param_name'  => 'pix_param_section_notice',
                'pix_title'	=> 'Only availeable in styles with dividers',
                "group"	=> "Thumbnail Divider",
                'dependency' => array(
                    "element" => "blog_style",
                    "value" => array('with-padding', 'full-img', 'transparent', 'default')
                )
            ),
            array(
                'type'        => 'pix_img_select',
                'heading'  => 'Shapes Builder',
                'param_name'  => 'bottom_divider_select',
                "class" => "my_param_field",
                'value'       => '0',
                "group"	=> "Thumbnail Divider",
                'dependency' => array(
                    "element" => "blog_style",
                    "value" => array('', 'padding')
                )
            ),

            array(
                'type'        => 'pix_param_globals',
                'param_name'  => 'pix_param_globals',
            ),


            array (
                'type' => 'param_group',
                'value' => '',
                'param_name' => 'bottom_moving_divider_color',
                "group"	=> "Thumbnail Divider",
                'dependency' => array(
                    "element" => "blog_style",
                    "value" => array('', 'padding')
                ),
                'params' => array(
                    array(
                        "type" => "checkbox",
                        "heading" => __( "Use Gradient", "pixfort-core" ),
                        "param_name" => "d_gradient",
                        'save_always' => true,
                        "value" => array(
                            "Yes" => "1"
                        ),
                    ),
                    array(
                        'type'        => 'colorpicker',
                        'heading'     => esc_html__('Layer color', 'pixfort-core'),
                        'param_name'  => 'd_color_1',
                        'value'       => '#f8f9fa',
                    ),
                    array(
                        'type'        => 'colorpicker',
                        'heading'     => esc_html__('Layer color 2', 'pixfort-core'),
                        'param_name'  => 'd_color_2',
                        'value'       => '#f8f9fa',
                    ),

                ),
                "dependency" => array(
                    "element" => "bottom_divider_select",
                    "value" => array("dynamic")
                ),
            ),

            array(
                "type" => "dropdown",
                "heading" => __("The number of Layers", "pixfort-core"),
                "group"	=> "Thumbnail Divider",
                "param_name" => "bottom_layers",
                "class" => "pix_param_50",
                "std"		=> '3',
                "dependency" => array(
                    "element" => "bottom_divider_select",
                    "value" => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
                ),
                "value" => array_flip(array(
                    "1"       => "1 Layer",
                    "2"       => "2 Layer",
                    "3"       => "3 Layer",
                )),
            ),

            array(
                'type'        => 'pix_param_section',
                'param_name'  => 'pix_param_section_4',
                'pix_title'	=> 'Advanced Options',
                "group"	=> "Thumbnail Divider",
                'dependency' => array(
                    "element" => "blog_style",
                    "value" => array('', 'padding')
                )
            ),

            array(
                "type" => "checkbox",
                "heading" => __( "Flip the divider", "pixfort-core" ),
                "param_name" => "b_flip_h",
                "value" => false,
                "group"	=> "Thumbnail Divider",
                'dependency' => array(
                    "element" => "blog_style",
                    "value" => array('', 'padding')
                )
            ),

            array (
                'param_name' 	=> 'b_custom_height',
                'type' 			=> 'textfield',
                'heading' 		=> __('Divider custom height (Optional)', 'pixfort-core'),
                "description"	=> __( "Leave empty to use default height or add custom height (with unit, e.g: 200px).", "pixfort-core" ),
                'admin_label'	=> true,
                "group"	=> "Thumbnail Divider",
            ),

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
                'heading' 		=> __('Dots', 'pixfort-core'),
                'admin_label'	=> false,
                "group" => __( "Advanced", "pixfort-core" ),
                'value' 		=> array_flip(array(
                    ''			=> 'Default',
                    'light-dots' 	=> 'Light',
                )),
                "dependency" => array(
                    "element" => "pagedots",
                    "not_empty" => true
                ),
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
                    'p-0'			=> '0px',
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
)
);

?>
