<?php

// Call to Action -------------------------------------------
vc_map( array (
    'base' 			=> 'pix_cta',
    'name' 			=> __('Call to Action', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/cta.jpg',
    'description' 	=> __('Increase conversion with a CTA', 'pixfort-core'),
    'params' 		=> array_merge(

        array (

            array (
                'param_name' 	=> 'title',
                'type' 			=> 'textfield',
                'heading' 		=> __('Title', 'pixfort-core'),
                'admin_label'	=> true,
            ),

            array(
                "type" => "checkbox",
                "heading" => __( "Title format", "pixfort-core" ),
                "param_name" => "bold",
                "value" => array("Bold" => "font-weight-bold"),
                "std" => "font-weight-bold"
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
            ),

            array (
                'param_name' 	=> 'content',
                'type' 			=> 'textarea',
                'heading' 		=> __('Content', 'pixfort-core'),
                'admin_label'	=> true,
                'value' 		=> __('Insert your content here', 'pixfort-core'),
            ),

            array(
                "type" => "checkbox",
                "heading" => __( "Content format", "pixfort-core" ),
                "param_name" => "content_bold",
                "value" => array("Bold" => "font-weight-bold"),
                "std" => ""
            ),
            array(
                "type" => "checkbox",
                "param_name" => "content_italic",
                "value" => array("Italic" => "font-italic",),
            ),
            array(
                "type" => "checkbox",
                "param_name" => "content_secondary_font",
                "value" => array("Secondary font" => "secondary-font",),
            ),

            array (
                'param_name' 	=> 'cta_style',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Style', 'pixfort-core'),
                'admin_label'	=> false,
                'std' => '',
                'value' 		=> array(
                    __('Default (Full width)','pixfort-core') 	=> 'default',
                    __('Small','pixfort-core')	    => 'small',
                ),
            ),

            array (
                'param_name' 	=> 'title_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Title color', 'pixfort-core'),
                'admin_label'	=> false,
                'group' => __( 'Advanced', 'pixfort-core' ),
                'value' 		=> $colors,
                'std'			=> 'heading-default',
            ),

            array (
                'param_name' 	=> 'title_custom_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Title color', 'pixfort-core'),
                'admin_label'	=> false,
                'group' => __( 'Advanced', 'pixfort-core' ),
                "dependency" => array(
                    "element" => "title_color",
                    "value" => "custom"
                ),
            ),

            array (
                'param_name' 	=> 'title_size',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Title size', 'pixfort-core'),
                'admin_label'	=> false,
                'group' => __( 'Advanced', 'pixfort-core' ),
                'std' => 'h4',
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
                'admin_label'	=> false,
                'group' => __( 'Advanced', 'pixfort-core' ),
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
                'group' => __( 'Advanced', 'pixfort-core' ),
                'std'           => 'body-default',
                'value' 		=> $colors,
            ),


            array (
                'param_name' 	=> 'content_custom_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Content custom color', 'pixfort-core'),
                'admin_label'	=> false,
                'group' => __( 'Advanced', 'pixfort-core' ),
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
                'group' => __( 'Advanced', 'pixfort-core' ),
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

        ),
        pix_add_params_to_group($button_params, "Button Settings"),
        $effects_params

    )
));

?>
