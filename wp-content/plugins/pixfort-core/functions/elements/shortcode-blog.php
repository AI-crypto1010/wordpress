<?php

// Blog -----------------------------
vc_map( array (
    'base' 			=> 'pix_blog',
    'name' 			=> __('Blog', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/blog.png',
    'description' 	=> __('Display blog posts', 'pixfort-core'),
    "weight"	=> "1000",
    'params' 		=> array_merge(
        array (
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
                'admin_label'	=> false,
                'value' 		=> array(
                    'Yes' => true,
                    'No' => ''
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
                'param_name' 	=> 'count',
                'type' 			=> 'textfield',
                'heading' 		=> __('Posts count', 'pixfort-core'),
                'description' 	=> __('Number of posts to show', 'pixfort-core'),
                'admin_label'	=> false,
                'value'	        => 9,
            ),

            array (
                'param_name' 	=> 'items_count',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Items per Line', 'pixfort-core'),
                'description' 	=> __('The number of items to show at the same line', 'pixfort-core'),
                'admin_label'	=> false,
                'std'           => 3,
                'value' 		=> array(
                    "1" 	=> 1,
                    "2" 	=> 2,
                    "3" 	=> 3,
                    "4" 	=> 4,
                    "6" 	=> 6,
                ),
            ),

            array (
                'param_name' 	=> 'category',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Category', 'pixfort-core'),
                'description' 	=> __('Select posts category.', 'pixfort-core'),
                'admin_label'	=> false,
                'save_always' => true,
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
                'heading' 		=> __('Order', 'pixfort-core'),
                'admin_label'	=> false,
                'std'	=> 'DESC',
                'value' 		=> array(
                    __('DESC','pixfort-core') 	=> 'DESC',
                    __('ASC','pixfort-core')	    => 'ASC',
                )
            ),

            array (
                'param_name' 	=> 'offset',
                'type' 			=> 'textfield',
                'heading' 		=> __('Offset', 'pixfort-core'),
                'description' 	=> __('Number of posts to skip', 'pixfort-core'),
                'admin_label'	=> false,
                'value'	        => '',
            ),

            array (
                'param_name' 	=> 'pagination',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Show Pagination', 'pixfort-core'),
                'description' 	=> __('<strong>Notice:</strong> Pagination will <strong>not</strong> work if you put item on Homepage of WordPress Multilangual Site.', 'pixfort-core'),
                'admin_label'	=> false,
                'save_always' => true,
                'std' => false,
                'value' 		=> array(
                    'No' => false,
                    'Yes' => true

                ),
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

            array (
                'param_name' 	=> 'animation',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Animation', 'pixfort-core'),
                'description' 	=> __('Select the animation of the Blog items.', 'pixfort-core'),
                'admin_label'	=> false,
                "group"	=> "Styling",
                'save_always' => true,
                'value'			=> pix_get_animations(),
            ),
            array (
                'param_name' 	=> 'delay',
                'type' 			=> 'textfield',
                'heading' 		=> __('Animation delay (in miliseconds)', 'pixfort-core'),
                'admin_label'	=> true,
                "group"	=> "Styling",
                'save_always' => true,
                "dependency" => array(
                    "element" => "animation",
                    "not_empty" => true
                ),
            ),

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
                'dependency' => array(
                    "element" => "blog_style",
                    "value" => array('', 'padding')
                )
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

            array(
                'type' => 'css_editor',
                'heading' => __( 'Css', 'pixfort-core' ),
                'param_name' => 'css',
                'group' => __( 'Design options', 'pixfort-core' ),
            ),

        )
    )
)
);


?>
