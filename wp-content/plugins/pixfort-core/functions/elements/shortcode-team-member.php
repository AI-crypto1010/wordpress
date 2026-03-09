<?php

// Team member -----------------------------
vc_map( array (
    'base' 			=> 'pix_team_member',
    'name' 			=> __('Team member Box', 'pixfort-core'),
    "weight"	=> "1000",
    'category' 		=> __('pixfort', 'pixfort-core'),
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/team-member-box.png',
    'description' 	=> __('Add team member element', 'pixfort-core'),
    'params' 		=>
    array_merge(
    array (


        array (
            'param_name' 	=> 'image',
            'type' 			=> 'attach_image',
            'heading' 		=> __('Image', 'pixfort-core'),
            'admin_label'	=> false,
        ),
        ...( \PixfortCore::instance()->getThemeParam('dynamic_wpb_images') ? [
            array(
                'param_name' 	=> 'dynamic_image',
                'type' 			=> 'pix_dynamic_image',
                'heading' 		=> __('Dynamic image source', 'pixfort-core'),
                'description' 	=> __('Select a dynamic image source (optional). If image is not available, the normal image will be used.', 'pixfort-core'),
            ),
        ] : [] ),


        array (
            'param_name' 	=> 'name',
            'type' 			=> 'textfield',
            'heading' 		=> __('Name', 'pixfort-core'),
            'admin_label'	=> true,
        ),

    ),

    pix_get_text_format_params(array(
        'prefix' 		=> 'name_',
        'name' 		=> 'Name',
        'bold' 		=> true,
        'bold_value' 		=> 'font-weight-bold',
        'italic' 		=> true,
        'italic_value' 		=> '',
        'secondary_font' 		=> true,
        'secondary_font_value' 		=> '',
        'color'     => false,
        'color_group'   => "Advanced"
    )),

    array(



        array (
            'param_name' 	=> 'name_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Name color', 'pixfort-core'),
            'admin_label'	=> false,
            'group'         => 'Advanced',
            'value' 		=> $colors,
            'std'			=> 'white',
        ),

        array (
            'param_name' 	=> 'name_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Name color', 'pixfort-core'),
            'admin_label'	=> false,
            'group'         => 'Advanced',
            "dependency" => array(
                  "element" => "name_color",
                  "value" => "custom"
              ),
        ),

        array (
            'param_name' 	=> 'name_size',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Name size', 'pixfort-core'),
            // 'description' 	=> __('Wrap name into H1 instead of H2', 'pixfort-core'),
            'admin_label'	=> false,
            'group'         => 'Advanced',
            'std'           => 'h4',
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
            'param_name' 	=> 'name_custom_size',
            'type' 			=> 'textfield',
            'heading' 		=> __('Name Size', 'pixfort-core'),
            'group'         => 'Advanced',
            'admin_label'	=> false,
            "dependency" => array(
                  "element" => "name_size",
                  "value" => "custom"
              ),
        ),




        array (
            'param_name' 	=> 'title',
            'type' 			=> 'textfield',
            'heading' 		=> __('Title', 'pixfort-core'),
            'admin_label'	=> true,
        ),

    ),
    pix_get_text_format_params(array(
        'prefix' 		=> '',
        'name' 		=> 'Title',
        'bold' 		=> true,
        'bold_value' 		=> '',
        'italic' 		=> true,
        'italic_value' 		=> '',
        'secondary_font' 		=> true,
        'secondary_font_value' 		=> '',
    )),
    array(

        array (
            'param_name' 	=> 'title_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Title color', 'pixfort-core'),
            'admin_label'	=> false,
            'group'         => 'Advanced',
            'value' 		=> $colors,
            'std'			=> 'light-opacity-6',
        ),

        array (
            'param_name' 	=> 'title_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Title color', 'pixfort-core'),
            'group'         => 'Advanced',
            'admin_label'	=> false,
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
            'std'           => 'h5',
            'group'         => 'Advanced',
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
            'group'         => 'Advanced',
            "dependency" => array(
                  "element" => "title_size",
                  "value" => "custom"
              ),
        ),


        array (
            'param_name' 	=> 'description',
            'type' 			=> 'textarea',
            'heading' 		=> __('Description', 'pixfort-core'),
            'admin_label'	=> true,
            'value' 		=> __('', 'pixfort-core'),
        ),

        array (
            'param_name' 	=> 'description_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Description color', 'pixfort-core'),
            'admin_label'	=> false,
            'std'           => 'body-default',
            'group'         => 'Advanced',
            'value' 		=> $colors,
            "dependency" => array(
                  "element" => "description",
                  "not_empty" => true
              ),
        ),


        array (
            'param_name' 	=> 'description_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Description custom color', 'pixfort-core'),
            'admin_label'	=> false,
            'group'         => 'Advanced',
            "dependency" => array(
                  "element" => "description_color",
                  "value" => "custom"
              ),
        ),

        array (
            'param_name' 	=> 'description_size',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Description font Size', 'pixfort-core'),
            'description' 	=> __('Select the size of the text.', 'pixfort-core'),
            'admin_label'	=> false,
            'group'         => 'Advanced',
            'value'			=> array_flip(array(
                ''			=> 'Default (16px)',
                'text-xs'		=> '12px',
                'text-sm'		=> '14px',
                'text-sm'		=> '14px',
                'text-18' 		=> '18px',
                'text-20' 		=> '20px',
                'text-24' 		=> '24px',
            )),
            "dependency" => array(
                  "element" => "description",
                  "not_empty" => true
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
            'param_name'     => 'rounded_img',
            'type'             => 'dropdown',
            'heading'         => __('Card rounded corners', 'pixfort-core'),
            'admin_label'    => false,
            'std'   => 'rounded-lg',
            'group'         => 'Advanced',
            'value'         => array(
                __('No', 'pixfort-core')     => 'rounded-0',
                __('Rounded', 'pixfort-core')        => 'rounded',
                __('Rounded Large', 'pixfort-core')        => 'rounded-lg',
                __('Rounded 5px', 'pixfort-core')        => 'rounded-xl',
                __('Rounded 10px', 'pixfort-core')        => 'rounded-10',
            )
        ),
        array (
            'param_name' 	=> 'position',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Position', 'pixfort-core'),
            'description' 	=> __('Select the position of the text.', 'pixfort-core'),
            'admin_label'	=> false,
            'group'         => 'Advanced',
            'value'			=> array_flip(array(
                'text-left'			=> 'Start',
                'text-center'		=> 'Center',
                'text-right' 		=> 'End',
            )),
        ),

        array (
            'param_name' 	=> 'overlay_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Overlay color', 'pixfort-core'),
            'admin_label'	=> false,
            'group'         => 'Advanced',
            'value' 		=> $colors_with_transparent,
            'std'			=> 'gradient-primary',
        ),

        array (
            'param_name' 	=> 'overlay_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Custom overlay color', 'pixfort-core'),
            'admin_label'	=> false,
            'group'         => 'Advanced',
            "dependency" => array(
                  "element" => "overlay_color",
                  "value" => "custom"
              ),
        ),

        array(
	     "type" => "dropdown",
	     "heading" => __("Overlay opacity", "pixfort-core"),
	     "param_name" => "overlay_opacity",
         'group'         => 'Advanced',
         "std"      => 'pix-opacity-7',
	     "value" => array_flip(array(
	        "pix-opacity-10" 			=> "0%",
	        "pix-opacity-9" 			=> "10%",
	        "pix-opacity-8" 			=> "20%",
	        "pix-opacity-7" 			=> "30%",
	        "pix-opacity-6" 			=> "40%",
	        "pix-opacity-5" 			=> "50%",
	        "pix-opacity-4" 			=> "60%",
	        "pix-opacity-3" 			=> "70%",
	        "pix-opacity-2" 			=> "80%",
	        "pix-opacity-1" 			=> "90%",

	    )),
        ),


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

        array(
          'type' => 'css_editor',
          'heading' => __( 'Css', 'pixfort-core' ),
          'param_name' => 'css',
          'group' => __( 'Design options', 'pixfort-core' ),
          ),



    ),
    $effects_params
    )
));

 ?>
