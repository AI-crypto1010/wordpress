<?php

// Advanced Text -----------------------------
vc_map( array (
    'base' 			=> 'pix_advanced_text',
    'name' 			=> __('Advanced Text', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'wrapper_class' => 'clearfix',
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/advanced-text.png',
    'description' 	=> __('Add advanced text element', 'pixfort-core'),
    'params' 		=> array (

        array (
            'param_name' 	=> 'content',
            'holder' => 'div',
            'type' 			=> 'textarea_html',
            'heading' 		=> __('Content', 'pixfort-core'),
            'admin_label'	=> true,
            'value' 		=> __('Insert your content here', 'pixfort-core'),
        ),

        array (
            'param_name' 	=> 'size',
            'type' 			=> 'textfield',
            'heading' 		=> __('Custom Font size (Optional, default 16px)', 'pixfort-core'),
            'description' 	=> __('Input the size of the text.', 'pixfort-core'),
            'std'           => ''
        ),
        
        array(
            "param_name" => "secondary_font",
              "heading" => __( "Text format", "pixfort-core" ),
              "type" => "checkbox",
              "value" => array("Secondary font" => "secondary-font",),
          ),

        array (
            'param_name' 	=> 'content_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Content color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $colors,
            'std'			=> '',

        ),


        array (
            'param_name' 	=> 'content_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Content custom color', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                  "element" => "content_color",
                  "value" => "custom"
              ),
        ),

        array (
            'param_name' 	=> 'position',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Position', 'pixfort-core'),
            'description' 	=> __('Select the position of the text.', 'pixfort-core'),
            'admin_label'	=> false,
            'value'			=> array_flip(array(
                ''			=> 'Default',
                'text-left'			=> 'Left',
                'text-center'		=> 'Center',
                'text-right' 		=> 'Right',
            )),
        ),

        array (
            'param_name' 	=> 'max_width',
            'type' 			=> 'textfield',
            'heading' 		=> __('Text max width (Optional)', 'pixfort-core'),
            'description' 	=> __('Input text width limit (with unit, for example 400px) instead of filling the width of the container.', 'pixfort-core'),
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
              "heading" => __( "Remove margin under the paragraph", "pixfort-core" ),
              "param_name" => "remove_pb_padding",
              "value" => array("Yes" => "m-0"),
          ),

          array(
            'type' => 'el_id',
            'param_name' => 'element_id',
            'settings' => array(
                'auto_generate' => true,
            ),
            'group' => __( 'Advanced', 'pixfort-core' ),
            'heading' => esc_html__( 'Element ID', 'pixfort-core' ),
            'description' => sprintf( esc_html__( 'Enter element ID (Note: make sure it is unique and valid according to %sw3c specification%s).', 'pixfort-core' ), '<a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>' ),
        ),


        array(
          'type' => 'css_editor',
          'heading' => __( 'Css', 'pixfort-core' ),
          'param_name' => 'css',
          'group' => __( 'Design options', 'pixfort-core' ),
          ),




    )
));
