<?php

// Portfolio -------------------------------------------
vc_map( array (
    'base' 			=> 'pix_portfolio_slider',
    'name' 			=> __('Portfolio Carousel', 'pixfort-core'),
    'description' 	=> __('Recommended column size: 1/1', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/portfolio-carousel.png',
    'description' 	=> __('Add carousel for portfolio items', 'pixfort-core'),
    'params' 		=> array (

        array (
            'param_name' 	=> 'count',
            'type' 			=> 'textfield',
            'heading' 		=> __('Count', 'pixfort-core'),
            'admin_label'	=> true,
            'value'			=> 6,
        ),

        array (
            'param_name' 	=> 'category',
            'type' 			=> 'textfield',
            'heading' 		=> __('Category', 'pixfort-core'),
            'description' 	=> __('Portfolio Category slug', 'pixfort-core'),
            'admin_label'	=> true,
        ),

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
           'heading' 		=> __('Titles color', 'pixfort-core'),
           'admin_label'	=> false,
           "dependency" => array(
                 "element" => "title_color",
                 "value" => "custom"
             ),
             "group"   => "Styling",
       ),

       array(
        "type" => "checkbox",
        "heading" => __( "Display full size images", "pixfort-core" ),
        "param_name" => "full_size_img",
        "value" => array("Yes" => "yes"),
        'std'      => '',
        "group"   => "Styling",
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
             "group"   => "Styling",
             "std"   => "rounded-lg",
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
    //    array (
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
             "group" => __( "Advanced", "pixfort-core" ),
             'value' 		=> array_flip(array(
                 ''			=> 'Default',
                 'light-dots' 	=> 'Light',
             )),
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
));

 ?>
