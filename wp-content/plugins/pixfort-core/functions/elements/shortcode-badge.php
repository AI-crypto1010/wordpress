<?php

// Badge -----------------------------
vc_map( array (
    'base' 			=> 'pix_badge',
    'name' 			=> __('Badge', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    'class'         => 'pixfort_element',
    "weight"	=> "1000",
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/badge.png',
    'description' 	=> __('Add nice badge box', 'pixfort-core'),
    'params' 		=> array (

        array (
            'param_name' 	=> 'text',
            'type' 			=> 'textfield',
            'heading' 		=> __('Text', 'pixfort-core'),
            'admin_label'	=> true,
        ),

        array(
            "type" => "checkbox",
            "heading" => __( "Title format", "pixfort-core" ),
            "param_name" => "bold",
            "value" => array("Bold" => "font-weight-bold"),
            "std" => "font-weight-bold",
            'save_always' => true,
        ),
        array(
            "type" => "checkbox",
            "param_name" => "italic",
            "value" => array("Italic" => "font-italic",),
        ),
        array(
            "type" => "checkbox",
            "param_name" => "secondary_font",
            "value" => array("Secondary font" => "secondary-font",),
            "std" => "secondary-font",
            'save_always' => true,
        ),

        array(
            "type" => "checkbox",
            "heading" => __( "Rounded corners", "pixfort-core" ),
            "param_name" => "rounded",
            "value" => array("Yes" => "badge-pill",),
        ),



        array (
            'param_name' 	=> 'text_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Text color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $colors,
            'std'           => 'primary'
        ),

        array (
            'param_name' 	=> 'text_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Text custom color', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                "element" => "text_color",
                "value" => "custom"
            ),
        ),

        array (
            'param_name' 	=> 'bg_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Background color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $bg_colors,
            'std'			=> 'primary-light',
            "dependency" => array(
                "element" => "media_type",
                "value" => array("icon", "char")
            ),
        ),
        array (
            'param_name' 	=> 'custom_bg_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Custom Background Color', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                "element" => "bg_color",
                "value" => "custom"
            ),
        ),

        array (
            'param_name' 	=> 'text_size',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Text size', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> array(
                __('H1','pixfort-core') 	=> 'h1',
                __('H2','pixfort-core')	    => 'h2',
                __('H3','pixfort-core')	    => 'h3',
                __('H4','pixfort-core')	    => 'h4',
                __('H5','pixfort-core')	    => 'h5',
                __('H6','pixfort-core')	    => 'h6',
                __('Custom','pixfort-core')	    => 'custom',
            ),
            'std' => 'h6',
        ),

        array (
            'param_name' 	=> 'text_custom_size',
            'type' 			=> 'textfield',
            'heading' 		=> __('Text Size', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                "element" => "text_size",
                "value" => "custom"
            ),
        ),

        array(
            "type" => "dropdown",
            "heading" => __("Shadow Style", "js_composer"),
            "param_name" => "style",
            "admin_label" => true,
            "value" => array_flip(array(
                "" => "Default",
                "1"       => "Small shadow",
                "2"       => "Medium shadow",
                "3"       => "Large shadow",
                "4"       => "Inverse Small shadow",
                "5"       => "Inverse Medium shadow",
                "6"       => "Inverse Large shadow",
            )),
            'save_always' => true,
            'group' => __( 'Advanced', 'pixfort-core' ),
            "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Shadow Hover Style", "js_composer"),
            "param_name" => "hover_effect",
            "admin_label" => true,
            "value" => array_flip(array(
                ""       => "None",
                "1"       => "Small hover shadow",
                "2"       => "Medium hover shadow",
                "3"       => "Large hover shadow",
                "4"       => "Inverse Small hover shadow",
                "5"       => "Inverse Medium hover shadow",
                "6"       => "Inverse Large hover shadow",
            )),
            'save_always' => true,
            'group' => __( 'Advanced', 'pixfort-core' ),
            "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Hover Animation", "js_composer"),
            "param_name" => "add_hover_effect",
            "admin_label" => true,
            "value" => array_flip(array(
                ""       => "None",
                "1"       => "Fly Small",
                "2"       => "Fly Medium",
                "3"       => "Fly Large",
                "4"       => "Scale Small",
                "5"       => "Scale Medium",
                "6"       => "Scale Large",
                "7"       => "Scale Inverse Small",
                "8"       => "Scale Inverse Medium",
                "9"       => "Scale Inverse Large",
            )),
            'save_always' => true,
            'group' => __( 'Advanced', 'pixfort-core' ),
            "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
        ),


        array (
            'param_name' 	=> 'animation',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Animation', 'pixfort-core'),
            'description' 	=> __('Select the animation of the heading.', 'pixfort-core'),
            'admin_label'	=> false,
            'group' => __( 'Advanced', 'pixfort-core' ),
            'value'			=> pix_get_animations(),
        ),

        array (
            'param_name' 	=> 'delay',
            'type' 			=> 'textfield',
            'heading' 		=> __('Animation delay (in miliseconds)', 'pixfort-core'),
            'admin_label'	=> true,
            'group' => __( 'Advanced', 'pixfort-core' ),
            "dependency" => array(
                "element" => "animation",
                "not_empty" => true
            ),
        ),


        array (
            'param_name' 	=> 'element_div',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Badge inside a container', 'pixfort-core'),
            "description" => __( "if enabled, other elements won't show on the same line.", "js_composer"),
            'admin_label'	=> false,
            'value'			=> array_flip(array(
                '' 		=> 'Disabled',
                'text-center' 		=> 'Center',
                'text-left' 		=> 'Start',
                'text-right' 		=> 'End',
            )),
        ),

        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'pixfort-core' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'pixfort-core' ),
        ),
        array(
            'type' => '',
            'param_name' => 'padding',
            'std' => '5px',
        ),



    )
));

?>
