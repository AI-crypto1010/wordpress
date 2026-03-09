<?php

// Text -----------------------------
vc_map( array (
    'base' 			=> 'pix_text',
    'name' 			=> __('Pix Text', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/text.jpg',
    'description' 	=> __('Add custom text element', 'pixfort-core'),
    'params' 		=> array (

        array (
            'param_name' 	=> 'content',
            'type' 			=> 'textarea',
            'heading' 		=> __('Content', 'pixfort-core'),
            'admin_label'	=> true,
            'value' 		=> __('Insert your content here', 'pixfort-core'),
        ),

        array (
            'param_name' 	=> 'size',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Size', 'pixfort-core'),
            'description' 	=> __('Select the size of the text.', 'pixfort-core'),
            'admin_label'	=> false,
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

        array(
              "type" => "checkbox",
              "heading" => __( "Text format", "pixfort-core" ),
              "param_name" => "bold",
              "value" => array("Bold" => "font-weight-bold"),
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
                'text-left'			=> 'Start',
                'text-center'		=> 'Center',
                'text-right' 		=> 'End',
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
          'type' => 'css_editor',
          'heading' => __( 'Css', 'pixfort-core' ),
          'param_name' => 'css',
          'group' => __( 'Design options', 'pixfort-core' ),
          ),




    )
));

 ?>
