<?php

// Clients ----------------------------------------------
vc_map( array (
    'base' 			=> 'clients',
    'name' 			=> __('Clients', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/clients.png',
    'description' 	=> __('Display customized logos', 'pixfort-core'),
    'params' 		=> array (
        array (
            'param_name' 	=> 'in_row',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Items in Row', 'pixfort-core'),
            'description' 	=> __('Number of items in row. Recommended number: 3-6', 'pixfort-core'),
            'admin_label'	=> true,
            'value' 		=> array(
                '1 Client'	            => '12',
                '2 Clients'				=> '6',
                '3 Clients'				=> '4',
                '4 Clients'				=> '3',
                '5 Clients'				=> '5',
                '6 Clients'				=> '2',
            ),
            'std'               => '3',
        ),
        array(
            'type' => 'param_group',
            'value' => '',
            'param_name' => 'clients',
            'heading' 		=> __('Clients', 'pixfort-core'),
            'params' => array(
                array (
                    'param_name' 	=> 'image',
                    'type' 			=> 'attach_image',
                    'heading' 		=> __('Image', 'pixfort-core'),
                    'admin_label'	=> false,
                ),

                array (
                    'param_name' 	=> 'title',
                    'type' 			=> 'textfield',
                    'heading' 		=> __('Title', 'pixfort-core'),
                    'admin_label'	=> false,
                ),

                array (
                    'param_name' 	=> 'link',
                    'type' 			=> 'textfield',
                    'heading' 		=> __('Link', 'pixfort-core'),
                    'admin_label'	=> false,
                ),

                array(
                    "type" => "checkbox",
                    "heading" => __( "Open in a new tab", "pixfort-core" ),
                    "param_name" => "target",
                    "value" => __( "Yes", "pixfort-core" ),
                    "dependency" => array(
                        "element" => "link",
                        "not_empty" => true
                    ),
                ),
            )
        ),

        array (
            'param_name' 	=> 'in_row_mobile',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Items in Row in Mobile', 'pixfort-core'),
            'description' 	=> __('Number of items in row in Mobile devices.', 'pixfort-core'),
            'admin_label'	=> true,
            'value' 		=> array(
                '1 (Default - Full width)'	=> '12',
                '2 Clients'				    => '6',
            ),
            'std'               => '12',
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
            "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
        ),

        array (
            'param_name' 	=> 'style',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Additional hover effect', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> array_flip(array(
                'pix-box'			=> 'Fade others + Box',
                'client'			=> 'Fade others',
                'no-effect' 	    => 'No effect',
            )),
        ),


        array (
            'param_name' 	=> 'animation',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Animation', 'pixfort-core'),
            'description' 	=> __('Select the animation of the heading.', 'pixfort-core'),
            'admin_label'	=> false,
            'src'	=> 'fade-in-Img',
            'value'			=>  pix_get_animations(),
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
            'param_name' 	=> 'delay_items',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Add delay between items', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> array_flip(array(
                ''			=> 'No',
                'yes'			=> 'Yes',
            )),
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
