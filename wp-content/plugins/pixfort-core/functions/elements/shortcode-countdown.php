<?php
// Countdown ----------------------------------------------
vc_map( array (
    'base' 			=> 'pix_countdown',
    'name' 			=> __('Countdown', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/countdown.png',
    'description' 	=> __('Add countdown to a specific date', 'pixfort-core'),
    'params' 		=> array (

        array (
            'param_name' 	=> 'date',
            'type' 			=> 'textfield',
            'heading' 		=> __('Launch Date', 'pixfort-core'),
            'desc' 			=> __('Format: 12/30/2022 12:00:00 month/day/year hour:minute:second', 'pixfort-core'),
            'admin_label'	=> true,
            'value'			=> '12/30/2022 12:00:00',
            'save_always' => true,
        ),

        array (
            'param_name' 	=> 'link',
            'type' 			=> 'textfield',
            'heading' 		=> __('Link', 'pixfort-core'),
            'admin_label'	=> true,
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
            "type" => "checkbox",
            "heading" => __( "Numbers format", "pixfort-core" ),
            "param_name" => "bold",
            "value" => array("Bold" => "font-weight-bold"),
            "std" => "font-weight-bold",
            'save_always' => true,
            'group' => __( 'Advanced', 'pixfort-core' ),
        ),
        array(
            "type" => "checkbox",
            "param_name" => "italic",
            "value" => array("Italic" => "font-italic",),
            'group' => __( 'Advanced', 'pixfort-core' ),
        ),
        array(
            "type" => "checkbox",
            "param_name" => "secondary_font",
            "value" => array("Secondary font" => "secondary-font",),
            "std" => "secondary-font",
            'save_always' => true,
            'group' => __( 'Advanced', 'pixfort-core' ),
        ),


        array (
            'param_name' 	=> 'numbers_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Numbers color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $colors,
            'std'			=> 'primary',
            'group' => __( 'Advanced', 'pixfort-core' ),
        ),

        array (
            'param_name' 	=> 'numbers_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Numbers custom color', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                "element" => "numbers_color",
                "value" => "custom"
            ),
        ),


        array (
            'param_name' 	=> 'numbers_size',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Numbers size', 'pixfort-core'),
            'admin_label'	=> false,
            'std'	=> 'h1',
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
            'param_name' 	=> 'display',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Bigger Text', 'pixfort-core'),
            'description' 	=> __('Larger numbers text size to stand out.', 'pixfort-core'),
            'admin_label'	=> false,
            'std'	=> 'display-4',
            'value'			=> array_flip(array(
                ''		=> 'None',
                'display-1'		=> 'Display 1',
                'display-2'		=> 'Display 2',
                'display-3'		=> 'Display 3',
                'display-4'		=> 'Display 4',
            )),
            "dependency" => array(
                "element" => "numbers_size",
                "value" => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6')
            ),
        ),

        array (
            'param_name' 	=> 'numbers_custom_size',
            'type' 			=> 'textfield',
            'heading' 		=> __('Numbers Size', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                "element" => "numbers_size",
                "value" => "custom"
            ),
        ),

        array (
            'param_name' 	=> 'content_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Text color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $colors,
            'std'			=> 'text-dark-opacity-2',
            'group' => __( 'Advanced', 'pixfort-core' ),
        ),

        array (
            'param_name' 	=> 'content_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Content text color', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                "element" => "content_color",
                "value" => "custom"
            ),
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
