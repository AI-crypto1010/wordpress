<?php

// Chart ----------------------------------------------
vc_map( array (
    'base' 			=> 'chart',
    'name' 			=> __('Chart', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/chart.jpg',
    'description' 	=> __('Display awesome animated charts', 'pixfort-core'),
    'params' 		=> array (

        array (
            'param_name' 	=> 'percent',
            'type' 			=> 'textfield',
            'heading' 		=> __('Percent', 'pixfort-core'),
            'desc' 			=> __('Number between 0-100', 'pixfort-core'),
            'value'         => '50',
            'admin_label'	=> true,
        ),

        array (
            'param_name' 	=> 'title',
            'type' 			=> 'textfield',
            'heading' 		=> __('Title', 'pixfort-core'),
            'admin_label'	=> true,
        ),
        array (
            'param_name' 	=> 'text',
            'type' 			=> 'textarea',
            'heading' 		=> __('Chart text', 'pixfort-core'),
            'admin_label'	=> true,
        ),
        array (
            'param_name' 	=> 'color1',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Chart color', 'pixfort-core'),
            'admin_label'	=> false,
        ),
        array (
            'param_name' 	=> 'color2',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Second Chart color', 'pixfort-core'),
            'desc' 			=> __('Optional: Use it to enable gradiant', 'pixfort-core'),
            'admin_label'	=> false,
        ),
        array (
            'param_name' 	=> 'color3',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Third Chart color', 'pixfort-core'),
            'desc' 			=> __('Optional: Use it to enable gradiant', 'pixfort-core'),
            'admin_label'	=> false,
        ),
        array (
            'param_name' 	=> 'track_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Track background color', 'pixfort-core'),
            // 'desc' 			=> __('Optional: Use it to enable gradiant', 'pixfort-core'),
            'admin_label'	=> false,
        ),








        array(
            "type" => "checkbox",
            "heading" => __( "Percent format", "pixfort-core" ),
            "param_name" => "p_bold",
            "value" => array("Bold" => "font-weight-bold"),
            'group' => __( 'Percent', 'pixfort-core' ),
            "std" => "font-weight-bold"
        ),
        array(
            "type" => "checkbox",
            "param_name" => "p_italic",
            'group' => __( 'Percent', 'pixfort-core' ),
            "value" => array("Italic" => "font-italic",),
        ),
        array(
            "type" => "checkbox",
            "param_name" => "p_secondary_font",
            'group' => __( 'Percent', 'pixfort-core' ),
            "value" => array("Secondary font" => "secondary-font",),
        ),

        array (
            'param_name' 	=> 'p_color',
            'type' 			=> 'dropdown',
            'group' => __( 'Percent', 'pixfort-core' ),
            'heading' 		=> __('Percent color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $colors,
            'std'			=> 'heading-default',
        ),

        array (
            'param_name' 	=> 'p_custom_color',
            'type' 			=> 'colorpicker',
            'group' => __( 'Percent', 'pixfort-core' ),
            'heading' 		=> __('Percent color', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                "element" => "p_color",
                "value" => "custom"
            ),
        ),

        array (
            'param_name' 	=> 'p_size',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Percent size', 'pixfort-core'),
            'group' => __( 'Percent', 'pixfort-core' ),
            'admin_label'	=> false,
            'std'	=> 'h4',
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
            'param_name' 	=> 'p_custom_size',
            'type' 			=> 'textfield',
            'heading' 		=> __('Percent Size', 'pixfort-core'),
            'group' => __( 'Percent', 'pixfort-core' ),
            'admin_label'	=> false,
            "dependency" => array(
                "element" => "p_size",
                "value" => "custom"
            ),
        ),




        array(
            "type" => "checkbox",
            "heading" => __( "Title format", "pixfort-core" ),
            "param_name" => "bold",
            "value" => array("Bold" => "font-weight-bold"),
            'group' => __( 'Title', 'pixfort-core' ),
            "std" => "font-weight-bold"
        ),
        array(
            "type" => "checkbox",
            "param_name" => "italic",
            'group' => __( 'Title', 'pixfort-core' ),
            "value" => array("Italic" => "font-italic",),
        ),
        array(
            "type" => "checkbox",
            "param_name" => "secondary_font",
            'group' => __( 'Title', 'pixfort-core' ),
            "value" => array("Secondary font" => "secondary-font",),
        ),

        array (
            'param_name' 	=> 'title_color',
            'type' 			=> 'dropdown',
            'group' => __( 'Title', 'pixfort-core' ),
            'heading' 		=> __('Title color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $colors,
            'std'			=> 'heading-default',
        ),

        array (
            'param_name' 	=> 'title_custom_color',
            'type' 			=> 'colorpicker',
            'group' => __( 'Title', 'pixfort-core' ),
            'heading' 		=> __('Title color', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                "element" => "title_color",
                "value" => "custom"
            ),
        ),

        array (
            'param_name' 	=> 'title_size',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Title size', 'pixfort-core'),
            'group' => __( 'Title', 'pixfort-core' ),
            'admin_label'	=> false,
            'std'	=> 'h5',
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
            'group' => __( 'Title', 'pixfort-core' ),
            'admin_label'	=> false,
            "dependency" => array(
                "element" => "title_size",
                "value" => "custom"
            ),
        ),

        array (
            'param_name' 	=> 'content_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Content color', 'pixfort-core'),
            'admin_label'	=> false,
            'group' => __( 'Content', 'pixfort-core' ),
            'std'           => 'body-default',
            'value' 		=> $colors,
        ),


        array (
            'param_name' 	=> 'content_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Content custom color', 'pixfort-core'),
            'admin_label'	=> false,
            'group' => __( 'Content', 'pixfort-core' ),
            "dependency" => array(
                "element" => "content_color",
                "value" => "custom"
            ),
        ),

        array (
            'param_name' 	=> 'content_size',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Size', 'pixfort-core'),
            'description' 	=> __('Select the size of the text.', 'pixfort-core'),
            'admin_label'	=> false,
            'group' => __( 'Content', 'pixfort-core' ),
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
            'param_name' 	=> 'content_align',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Content align', 'pixfort-core'),
            'admin_label'	=> false,
            'std'	=> '',
            'value' 		=> array(
                __('Center (Default)','pixfort-core') 	=> '',
                __('Start','pixfort-core')	    => 'left',
                __('End','pixfort-core')	    => 'right',
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
            'type' => 'css_editor',
            'heading' => __( 'Css', 'pixfort-core' ),
            'param_name' => 'chart_css',
            'group' => __( 'Design options', 'pixfort-core' ),
        ),


    )
));

?>
