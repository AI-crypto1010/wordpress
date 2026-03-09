<?php

// Social icons -----------------------------


vc_map( array (
    'base' 			=> 'pix-social-icons',
    'name' 			=> __('Social Icons', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/social-icons.png',
    'description' 	=> __('Add custom social icons', 'pixfort-core'),
    'params' 		=> array (


        array(
              'type' => 'param_group',
              'value' => '',
              'param_name' => 'items',
              'heading' 		=> __('Icons', 'pixfort-core'),
              'description' 	=> __('Add each icon in the desired order.', 'pixfort-core'),
              'params' => array(
                  array (
                      'type' => 'pixfort_icons_picker',
                      'heading' => __( 'Icon', 'pixfort-core' ),
                      'param_name' => 'icon',
                      'settings' => array(
                          'emptyIcon' => true, // default true, display an "EMPTY" icon?
                          'type' => 'pix-icons',
                          'iconsPerPage' => 200, // default 100, how many icons per/page to display
                      ),
                      'description' => __( 'Select icon from library.', 'pixfort-core' ),
                  ),

                  array (
                      'param_name' 	=> 'item_link',
                      'type' 			=> 'textfield',
                      'heading' 		=> __('Icon Link', 'pixfort-core'),
                      'admin_label'	=> false,
                  ),


                  array(
                      "type" => "checkbox",
                      "heading" => __( "Open in a new tab", "pixfort-core" ),
                      "param_name" => "target",
                      "value" => __( "Yes", "pixfort-core" ),
                      "dependency" => array(
                          "element" => "item_link",
                          "not_empty" => true
                      ),
                  ),

                  array(
    					  "type" => "checkbox",
    					  "heading" => __( "Different color", "pixfort-core" ),
    					  "param_name" => "has_color",
    					  "value" => __( "Yes", "pixfort-core" ),
    				  ),

                  array (
                      'param_name' 	=> 'item_color',
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
                      'param_name' 	=> 'item_custom_color',
                      'type' 			=> 'colorpicker',
                      'heading' 		=> __('Custom color', 'pixfort-core'),
                      'admin_label'	=> false,
                      'value'       => '#333',
                      "dependency" => array(
                            "element" => "item_color",
                            "value" => "custom"
                        ),
                  ),
                  array (
                      'param_name' 	=> 'aria_label',
                      'type' 			=> 'textfield',
                      'heading' 		=> __('Area label', 'pixfort-core'),
                      'description' => __( 'Add alternative text for better accessibility.', 'pixfort-core' ),
                      'admin_label'	=> false,
                  ),


              )
        ),


        array (
            'param_name' 	=> 'item_size',
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
                'custom' 		=> 'Custom',
            )),
        ),

        array (
            'param_name' 	=> 'item_custom_size',
            'type' 			=> 'textfield',
            'heading' 		=> __('Custom Icon Size', 'pixfort-core'),
            "description" => __( "Please input the value (with the unit: px,.. etc).", "pixfort-core"),
            'admin_label'	=> false,
            "dependency" => array(
                  "element" => "item_size",
                  "value" => "custom"
              ),
        ),


        array (
            'param_name' 	=> 'items_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Icons color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $colors,
        ),

        array (
            'param_name' 	=> 'items_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Custom icons color', 'pixfort-core'),
            'admin_label'	=> false,
            'value'       => '#333',
            "dependency" => array(
                  "element" => "items_color",
                  "value" => "custom"
              ),
        ),


        array(
         "type" => "dropdown",
         "heading" => __("Icons Hover Animation", "js_composer"),
         "param_name" => "items_style",
         "admin_label" => true,
         "value" => array_flip(array(
            ""       => "None",
            "fly-sm"       => "Fly Small",
            "fly"       => "Fly Medium",
            "fly-lg"       => "Fly Large",
            "scale-sm"       => "Scale Small",
            "scale"       => "Scale Medium",
            "scale-lg"       => "Scale Large",
        )),
         'save_always' => true,
         "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
        ),


        array (
            'param_name' 	=> 'position',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Position', 'pixfort-core'),
            'description' 	=> __('Select the position of the icons.', 'pixfort-core'),
            'admin_label'	=> false,
            "std"           => "center",
            'value'			=> array_flip(array(
                'text-left'			=> 'Start',
                'text-center'		=> 'Center',
                'text-right' 		=> 'End',
            )),
        ),

        array (
            'param_name' 	=> 'item_padding',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Padding', 'pixfort-core'),
            'description' 	=> __('Select the padding between the icons.', 'pixfort-core'),
            'admin_label'	=> false,
            "std"           => "center",
            'value'			=> array_flip(array(
                'px-2'			=> 'Default (small)',
                'px-1'		=> 'Extra small',
                'px-3'		=> 'Medium',
                'px-4'		=> 'Large',
                'px-5'		=> 'Extra Large',
                'none'		=> 'None',
                'custom'		=> 'Custom',
            )),
        ),
        array (
            'param_name' 	=> 'item_custom_padding',
            'type' 			=> 'textfield',
            'heading' 		=> __('Custom Icons padding', 'pixfort-core'),
            "description" => __( "Please input the value (with the unit: px,.. etc).", "pixfort-core"),
            'admin_label'	=> false,
            "dependency" => array(
                  "element" => "padding",
                  "value" => "custom"
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
          'param_name' => 'css',
          'group' => __( 'Design options', 'pixfort-core' ),
          ),



    )
));

 ?>
