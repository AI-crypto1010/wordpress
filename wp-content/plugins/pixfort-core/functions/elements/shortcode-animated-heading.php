<?php

// Animated Heading
vc_map( array (
    'base' 			=> 'animated-heading',
    'name' 			=> __('Animated Heading', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/animated-heading.gif',
    'description' 	=> __('Add awesome animated heading', 'pixfort-core'),
    'params' 		=> array (

        array (
            'param_name' 	=> 'title',
            'type' 			=> 'textfield',
            'heading' 		=> __('Text before', 'pixfort-core'),
            'admin_label'	=> true,
        ),


        array(
            'type' => 'param_group',
            'value' => '',
            'param_name' => 'words',
            'heading' 		=> __('Scrolling words', 'pixfort-core'),
            'description' 	=> __('Add each word in the desired order.', 'pixfort-core'),
            // Note params is mapped inside param-group:
            'params' => array(
                array (
                    'param_name' 	=> 'word',
                    'type' 			=> 'textfield',
                    'heading' 		=> __('Word', 'pixfort-core'),
                    'admin_label'	=> true,
                ),

                array(
                    "type" => "checkbox",
                    "heading" => __( "Different color", "pixfort-core" ),
                    "param_name" => "has_color",
                    "value" => __( "Yes", "pixfort-core" ),
                ),

                array (
                    'param_name' 	=> 'word_color',
                    'type' 			=> 'dropdown',
                    'heading' 		=> __('Color', 'pixfort-core'),
                    'admin_label'	=> false,
                    'value' 		=> $colors,
                    "dependency" => array(
                        "element" => "has_color",
                        'not_empty' => true,
                    ),
                ),

                array (
                    'param_name' 	=> 'word_custom_color',
                    'type' 			=> 'colorpicker',
                    'heading' 		=> __('Custom color', 'pixfort-core'),
                    'admin_label'	=> false,
                    'value'       => '#333',
                    "dependency" => array(
                        "element" => "word_color",
                        "value" => "custom"
                    ),
                ),


            )
        ),

        array (
            'param_name' 	=> 'text_after',
            'type' 			=> 'textfield',
            'heading' 		=> __('Text after', 'pixfort-core'),
            'admin_label'	=> false,
        ),


        array(
            "type" => "checkbox",
            "heading" => __( "Title format", "pixfort-core" ),
            "param_name" => "title_bold",
            'group' => __( 'Advanced', 'pixfort-core' ),
            "value" => array("Bold" => "font-weight-bold"),
            "std" => "font-weight-bold"
        ),
        array(
            "type" => "checkbox",
            "param_name" => "title_italic",
            'group' => __( 'Advanced', 'pixfort-core' ),
            "value" => array("Italic" => "font-italic",),
        ),
        array(
            "type" => "checkbox",
            "param_name" => "title_secondary_font",
            'group' => __( 'Advanced', 'pixfort-core' ),
            "value" => array("Secondary font" => "secondary-font",),
        ),
        array(
            "type" => "checkbox",
            "param_name" => "space_after",
            'group' => __( 'Advanced', 'pixfort-core' ),
            "value" => array("Add space after the animated text" => "space_after",),
        ),
        array(
            "type" => "checkbox",
            "param_name" => "br_after",
            'group' => __( 'Advanced', 'pixfort-core' ),
            "value" => array("Add break line after the animated text" => "space_after",),
        ),

        array (
            'param_name' 	=> 'size',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Font size', 'pixfort-core'),
            'description' 	=> __('Select the size of the font.', 'pixfort-core'),
            'admin_label'	=> false,
            'group' => __( 'Advanced', 'pixfort-core' ),
            'value'			=> array_flip(array(
                'h1'		=> 'H1',
                'h2'		=> 'H2',
                'h3' 		=> 'H3',
                'h4' 		=> 'H4',
                'h5' 		=> 'H5',
                'h6' 		=> 'H6',
                'p' 		=> 'p',
            )),
        ),

        array (
            'param_name' 	=> 'display',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Bigger Text', 'pixfort-core'),
            'description' 	=> __('Larger heading text size to stand out.', 'pixfort-core'),
            'admin_label'	=> false,
            'group' => __( 'Advanced', 'pixfort-core' ),
            'value'			=> array_flip(array(
                ''		=> 'None',
                'display-1'		=> 'Display 1',
                'display-2'		=> 'Display 2',
                'display-3'		=> 'Display 3',
                'display-4'		=> 'Display 4',
            )),
        ),

        array (
            'param_name' 	=> 'title_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Title color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $colors,
            'group' => __( 'Advanced', 'pixfort-core' ),
            'std'           => 'heading-default'
        ),

        array (
            'param_name' 	=> 'title_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Custom text color', 'pixfort-core'),
            'admin_label'	=> false,
            'value'       => '#333',
            'group' => __( 'Advanced', 'pixfort-core' ),
            "dependency" => array(
                "element" => "title_color",
                "value" => "custom"
            ),
        ),



        array (
            'param_name' 	=> 'slogan',
            'type' 			=> 'textfield',
            'heading' 		=> __('Slogan', 'pixfort-core'),
            'description' 	=> __('Line Style only', 'pixfort-core'),
            'admin_label'	=> true,
        ),



        array(
            "type" => "checkbox",
            "heading" => __( "Slogan format", "pixfort-core" ),
            "param_name" => "slogan_bold",
            'group' => __( 'Advanced', 'pixfort-core' ),
            "value" => array("Bold" => "font-weight-bold"),
            "std" => "font-weight-bold"
        ),
        array(
            "type" => "checkbox",
            "param_name" => "slogan_italic",
            'group' => __( 'Advanced', 'pixfort-core' ),
            "value" => array("Italic" => "font-italic",),
        ),
        array(
            "type" => "checkbox",
            "param_name" => "slogan_font",
            'group' => __( 'Advanced', 'pixfort-core' ),
            "value" => array("Secondary font" => "secondary-font",),
        ),


        array (
            'param_name' 	=> 'slogan_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Slogan color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $colors,
            'group' => __( 'Advanced', 'pixfort-core' ),
            'std'           => 'primary'
        ),

        array (
            'param_name' 	=> 'slogan_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Custom text color', 'pixfort-core'),
            'admin_label'	=> false,
            'value'       => '#333',
            'group' => __( 'Advanced', 'pixfort-core' ),
            "dependency" => array(
                "element" => "slogan_color",
                "value" => "custom"
            ),
        ),
        array (
            'param_name' 	=> 'style',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Animation Style', 'pixfort-core'),
            'admin_label'	=> true,
            'std'              => "slide-inverse",
            'value'			=> array_flip(array(
                'slide-inverse' 		 => 'Slide Up',
                'pixfade' 		         => 'Fade',
                'loading-bar'			 => 'Loading bar',
                'slide' 		         => 'Slide Down',
                'zoom' 		             => 'Zoom',
                'push' 		             => 'Push',
                'rotate-1'			     => 'Rotate',
            )),
        ),

        array (
            'param_name' 	=> 'position',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Position', 'pixfort-core'),
            'description' 	=> __('Select the position of the heading.', 'pixfort-core'),
            'admin_label'	=> false,
            "std"           => "center",
            'value'			=> array_flip(array(
                'left'			=> 'Start',
                'center'		=> 'Center',
                'right' 		=> 'End',
            )),
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
            'param_name' => 'css',
            'group' => __( 'Design options', 'pixfort-core' ),
        ),

    )
));

?>
