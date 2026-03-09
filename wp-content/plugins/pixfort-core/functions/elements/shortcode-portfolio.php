<?php

// Portfolio -------------------------------------------
vc_map( array (
    'base' 			=> 'pix_portfolio',
    'name' 			=> __('Portfolio', 'pixfort-core'),
    'description' 	=> __('Recommended column size: 1/1', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/portfolio.png',
    'description' 	=> __('Showcase your portfolio items', 'pixfort-core'),
    'params' 		=> array (

        array (
            'param_name' 	=> 'portfolio_style',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Style', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> array(
                "Default" 	    => '',
                "Mini" 	        => 'mini',
                "Transparent" 	=> 'transparent',
                "3D"        	=> '3d',
            ),
        ),


        array (
            'param_name' 	=> 'count',
            'type' 			=> 'textfield',
            'heading' 		=> __('Count', 'pixfort-core'),
            'admin_label'	=> true,
            'value'			=> 6,
        ),

        array (
            'param_name' 	=> 'line_count',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Items per line', 'pixfort-core'),
            'admin_label'	=> false,
            'std'           => '4',
            'value' 		=> array_flip(array(
                "6" 	    => "2 items",
                "4" 	    => "3 items",
                "3" 	    => "4 items",
                "2"        	=> "6 items",

            )),
        ),

        array (
            'param_name' 	=> 'category',
            'type' 			=> 'textfield',
            'heading' 		=> __('Category', 'pixfort-core'),
            'description' 	=> __('Portfolio Category slug', 'pixfort-core'),
            'admin_label'	=> true,
        ),
        

        // array (
        //     'param_name' 	=> 'style',
        //     'type' 			=> 'dropdown',
        //     'heading' 		=> __('Style', 'pixfort-core'),
        //     'admin_label'	=> true,
        //     'value' 		=> array_flip(array(
        //         'normal'			=> 'Normal',
        //         'flat'			=> 'Flat',
        //         'flatbox'			=> 'FlatBox',
        //         'masonry-normal'		=> 'Masonry Normal',
        //         'masonry-flat'	=> 'Masonry Flat',
        //         'masonry-flatbox'	=> 'Masonry FlatBox',
        //     )),
        // ),

        array (
            'param_name' 	=> 'orderby',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Order by', 'pixfort-core'),
            'description' 	=> __('Portfolio items order by column.', 'pixfort-core'),
            'admin_label'	=> true,
            'value' 		=> array_flip(array(
                'date'			=> 'Date',
                'menu_order' 	=> 'Menu order',
                'title'			=> 'Title',
                'rand'			=> 'Random',
            )),
        ),

        array (
            'param_name' 	=> 'order',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Order', 'pixfort-core'),
            'description' 	=> __('Portfolio items order.', 'pixfort-core'),
            'admin_label'	=> true,
            'value' 		=> array_flip(array(
                'DESC' 	=> 'Descending',
                'ASC' 	=> 'Ascending',
            )),
        ),

        array (
            'param_name' 	=> 'filters',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Show Filters', 'pixfort-core'),
            'description' 	=> __('This option works in <b>Category: All</b>', 'pixfort-core'),
            'admin_label'	=> false,
            'std'	        => 1,
            'value' 		=> array(
                __('No','pixfort-core') 	=> 0,
                __('Yes','pixfort-core')	=> 1,
            ),
        ),

        array (
            'param_name' 	=> 'filters_align',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Filters Align', 'pixfort-core'),
            'admin_label'	=> true,
            'value' 		=> array_flip(array(
                'center'			=> 'Center',
                'left'			=> 'Left',
                'right'			=> 'Right',
            )),
        ),

        array(
              "type" => "checkbox",
              "heading" => __( "Light filter buttons color", "pixfort-core" ),
              "param_name" => "filter_light",
              "value" => array("Yes" => "is-dark"),
              'std'      => '',
          ),

          array(
                "type" => "checkbox",
                "heading" => __( "Display full size images", "pixfort-core" ),
                "param_name" => "full_size_img",
                "value" => array("Yes" => "yes"),
                'std'      => '',
                "dependency" => array(
                      "element" => "portfolio_style",
                      "value" => array('mini', 'transparent', "")
                  ),
            ),


        array (
            'param_name' 	=> 'rounded_img',
            'type' 			=> 'dropdown',
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
            'param_name' 	=> 'pagination',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Show | Pagination', 'pixfort-core'),
            'description' 	=> __('<strong>Notice:</strong> Pagination will <strong>not</strong> work if you put item on Homepage of WordPress Multilangual Site.', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> array_flip(array(
                '' 	=> 'No',
                1 	=> 'Yes',
            )),
        ),

        // Styling
        array (
            'param_name' 	=> 'title_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Titles color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $colors,
            'std'			=> 'heading-default',
            "group"   => "Styling",
            "dependency" => array(
                  "element" => "portfolio_style",
                  "value" => array('transparent', "3d")
              ),
        ),

        array (
            'param_name' 	=> 'title_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Custom titles color', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                  "element" => "title_color",
                  "value" => "custom"
              ),
              "group"   => "Styling",
        ),




        array (
            'param_name' 	=> 'overlay_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Overlay color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $bg_colors,
            'std'			=> 'black',
            "group"   => "Styling",
            "dependency" => array(
                "element" => "portfolio_style",
                "value" => "3d"
            ),
        ),
        array (
            'param_name' 	=> 'custom_overlay_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Custom Overlay Color', 'pixfort-core'),
            'admin_label'	=> false,
            "group"   => "Styling",
            "dependency" => array(
                "element" => "overlay_color",
                "value" => "custom"
            ),
        ),

        array (
            'param_name' 	=> 'post_type',
            'type' 			=> 'posttypes',
            'heading' 		=> __('Use different post type', 'pixfort-core'),
            'description' 	=> __('Select a differnet post type(s) to replace the default "Portfolio" items (for example you can load custom post type into the element)', 'pixfort-core'),
            'std'	=> 'portfolio',
            'admin_label'	=> true,
            'group' => __( 'Advanced', 'pixfort-core' ),
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
