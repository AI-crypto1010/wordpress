<?php

// Video Popup -----------------------------
vc_map( array (
    'base' 			=> 'pix_video_popup',
    'name' 			=> __('Pix Video Popup', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    'class'         => 'pixfort_element',
    "weight"	=> "1000",
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/video-popup.png',
    'description' 	=> __('Add button for video popup', 'pixfort-core'),
    'params' 		=>
        array (

            array (
                'param_name' 	=> 'embed_code',
                'type' 			=> 'textarea_raw_html',
                'heading' 		=> __('Embed Code', 'pixfort-core'),
                'admin_label'	=> false,
            ),


            array (
                'param_name' 	=> 'aspect',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Aspect ratio', 'pixfort-core'),
                'admin_label'	=> false,
                'value' 		=> array(
                    __('21:9 aspect ratio','pixfort-core') 	    => 'embed-responsive-21by9',
                    __('16:9 aspect ratio','pixfort-core')	    => 'embed-responsive-16by9',
                    __('4:3 aspect ratio','pixfort-core')	    => 'embed-responsive-4by3',
                    __('1:1 aspect ratio','pixfort-core')	    => 'embed-responsive-1by1',
                    __('9:16 aspect ratio','pixfort-core')	    => 'embed-responsive-9by16'
                )
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


            array (
                'param_name' 	=> 'text_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Icon color', 'pixfort-core'),
                'admin_label'	=> false,
                'group' => __( 'Advanced', 'pixfort-core' ),
                'value' 		=> $colors_no_custom,
                'std'           => 'primary'
            ),


            array (
                'param_name' 	=> 'bg_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Background color', 'pixfort-core'),
                'admin_label'	=> false,
                'value' 		=> $bg_colors,
                'std'			=> 'white',
                'group' => __( 'Advanced', 'pixfort-core' ),
            ),
            array (
                'param_name' 	=> 'custom_bg_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Custom Background Color', 'pixfort-core'),
                'admin_label'	=> false,
                'group' => __( 'Advanced', 'pixfort-core' ),
                "dependency" => array(
                    "element" => "bg_color",
                    "value" => "custom"
                ),
            ),

            array (
                'param_name' 	=> 'size',
                'type' 			=> 'textfield',
                'heading' 		=> __('Button size', 'pixfort-core'),
                'description' 		=> __('Input the size in pixels (without writing the unit.)', 'pixfort-core'),
                'admin_label'	=> true,
                'std'           => '100',
                'group' => __( 'Advanced', 'pixfort-core' ),
            ),

            array (
                'param_name' 	=> 'icon_style',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Icon style', 'pixfort-core'),
                'admin_label'	=> false,
                'group' => __( 'Advanced', 'pixfort-core' ),
                'value' 		=> array(
                    __('Filled','pixfort-core')	    => 'due',
                    __('Outline','pixfort-core') 	    => 'line',
                )
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
