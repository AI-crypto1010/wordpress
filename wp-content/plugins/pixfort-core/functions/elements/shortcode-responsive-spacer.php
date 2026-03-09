<?php

// Responsive sapcer -----------------------------
vc_map( array (
    'base' 			=> 'pix_responsive_spacer',
    'name' 			=> __('Responsive spacer', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/responsive-spacer.gif',
    'description' 	=> __('Add responsive space element', 'pixfort-core'),
    'params' 		=> array (

        array (
            'param_name' 	=> 'height',
            'type' 			=> 'textfield',
            'heading' 		=> __('Height', 'pixfort-core'),
            'description'   => __('Input element height value (with unit).', 'pixfort-core'),
            'admin_label'	=> true,
        ),

        array (
            'param_name' 	=> 'height_tablet',
            'type' 			=> 'textfield',
            'heading' 		=> __('Tablet Height (Optional)', 'pixfort-core'),
            'description'   => __('Input height value (with unit) to override desktop value, or leave empty to use desktop height.', 'pixfort-core'),
            'admin_label'	=> true,
        ),

        array (
            'param_name' 	=> 'height_mobile',
            'type' 			=> 'textfield',
            'heading' 		=> __('Mobile Height (Optional)', 'pixfort-core'),
            'description'   => __('Input height value (with unit) to override bigger device value, or leave empty to use bigger device height.', 'pixfort-core'),
            'admin_label'	=> true,
        ),


        array(
            'type' => 'el_id',
            'param_name' => 'element_id',
            'settings' => array(
                'auto_generate' => true,
            ),
            'heading' => esc_html__( 'Element ID', 'pixfort-core' ),
            'description' => sprintf( esc_html__( 'Enter element ID (Note: make sure it is unique and valid according to %sw3c specification%s).', 'pixfort-core' ), '<a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>' ),
            'group' => __( 'Advanced', 'pixfort-core' ),
        ),

        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "my-text-domain"),
            "param_name" => "el_class",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "my-text-domain"),
            'value'       => '',
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
