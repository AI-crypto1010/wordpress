<?php


// Review ----------------------------------------------
vc_map( array (
    'base' 			=> 'pix_review',
    'name' 			=> __('Review', 'pixfort-core'),
    "weight"	=> "1000",
    'description' 	=> __('Add clean review element', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/review-element.png',

    'params' 		=> array_merge(array (




          array (
              'param_name' 	=> 'content',
              'type' 			=> 'textarea',
              'heading' 		=> __('Content', 'pixfort-core'),
              'admin_label'	=> false,
              'value' 		=> __('Insert your content here', 'pixfort-core'),
          ),

          array (
             'param_name' 	=> 'name',
             'type' 			=> 'textfield',
             'heading' 		=> __('Name', 'pixfort-core'),
             'admin_label'	=> true,
         ),

         array (
             'param_name' 	=> 'title',
             'type' 			=> 'textfield',
             'heading' 		=> __('Title', 'pixfort-core'),
             'admin_label'	=> false,
         ),

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
              'param_name' 	=> 'rating',
              'type' 			=> 'dropdown',
              'heading' 		=> __('Rating', 'pixfort-core'),
              'admin_label'	=> false,
              'value' 		=> array_flip(array(
                  ''			=> 'None',
                  '1' 	=> '1',
                  '2' 	=> '2',
                  '3' 	=> '3',
                  '4' 	=> '4',
                  '5' 	=> '5',
              )),
          ),


          array (
				  'param_name' 	=> 'link',
				  'type' 			=> 'textfield',
				  'heading' 		=> __('Link', 'pixfort-core'),
				  'admin_label'	=> false,
			  ),





        array (
            'param_name' 	=> 'animation',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Animation', 'pixfort-core'),
            'description' 	=> __('Select the animation of the heading.', 'pixfort-core'),
            'admin_label'	=> false,
            'value'			=> pix_get_animations(),
            'std'           => 'fade-in-up'
        ),

        array (
            'param_name' 	=> 'delay',
            'type' 			=> 'textfield',
            'heading' 		=> __('Animation delay (in miliseconds)', 'pixfort-core'),
            'admin_label'	=> true,
            'std'           => '500',
            "dependency" => array(
                  "element" => "animation",
                  "not_empty" => true
              ),
        ),




        // Styling
        array(
              "type" => "checkbox",
              "heading" => __( "Name format", "pixfort-core" ),
              "param_name" => "bold",
              "value" => array("Bold" => "font-weight-bold"),
              "std" => "font-weight-bold",
              "group"   => "Styling",
          ),
        array(
              "type" => "checkbox",
              "param_name" => "italic",
              "value" => array("Italic" => "font-italic",),
              "group"   => "Styling",
          ),
        array(
              "type" => "checkbox",
              "param_name" => "secondary_font",
              "value" => array("Secondary font" => "secondary-font",),
              "group"   => "Styling",
          ),

        array (
            'param_name' 	=> 'name_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Name color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $colors,
            'std'           => 'dark-opacity-8',
            "group"   => "Styling",
        ),

        array (
            'param_name' 	=> 'name_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Title color', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                  "element" => "name_color",
                  "value" => "custom"
              ),
              "group"   => "Styling",
        ),


        array (
            'param_name' 	=> 'title_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Title color', 'pixfort-core'),
            'admin_label'	=> false,
            'std'           => 'dark-opacity-6',
            'value' 		=> $colors,
            "group"   => "Styling",
        ),


        array (
            'param_name' 	=> 'title_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Content title color', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                  "element" => "title_color",
                  "value" => "custom"
              ),
              "group"   => "Styling",
        ),

        array (
            'param_name' 	=> 'title_size',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Size', 'pixfort-core'),
            'description' 	=> __('Select the size of the text.', 'pixfort-core'),
            'admin_label'	=> false,
            'std'           => '',
            'value'			=> array_flip(array(
                ''			=> 'Default (16px)',
                'text-xs'		=> '12px',
                'text-sm'		=> '14px',
                'text-sm'		=> '14px',
                'text-18' 		=> '18px',
                'text-20' 		=> '20px',
                'text-24' 		=> '24px',
            )),
            "group"   => "Styling",
        ),








        array(
              "type" => "checkbox",
              "heading" => __( "Content format", "pixfort-core" ),
              "param_name" => "content_bold",
              "value" => array("Bold" => "font-weight-bold"),
              "group"   => "Styling",
          ),
        array(
              "type" => "checkbox",
              "param_name" => "content_italic",
              "value" => array("Italic" => "font-italic",),
              "group"   => "Styling",
          ),
        array(
              "type" => "checkbox",
              "param_name" => "content_secondary_font",
              "value" => array("Secondary font" => "secondary-font",),
              "group"   => "Styling",
          ),


        array (
            'param_name' 	=> 'content_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Content color', 'pixfort-core'),
            'admin_label'	=> false,
            'std'           => 'dark-opacity-5',
            'value' 		=> $colors,
            "group"   => "Styling",
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
              "group"   => "Styling",
        ),

        array (
            'param_name' 	=> 'content_size',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Size', 'pixfort-core'),
            'description' 	=> __('Select the size of the text.', 'pixfort-core'),
            'admin_label'	=> false,
            'std'           => 'text-20',
            'value'			=> array_flip(array(
                ''			=> 'Default (16px)',
                'text-xs'		=> '12px',
                'text-sm'		=> '14px',
                'text-sm'		=> '14px',
                'text-18' 		=> '18px',
                'text-20' 		=> '20px',
                'text-24' 		=> '24px',
            )),
            "group"   => "Styling",
        ),



    ),
    pix_add_params_to_group($effects_params, "Styling"),
    array(

        array (
            'param_name' 	=> 'bg_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Background color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $bg_colors,
            'std'			=> 'transparent',
            "group"	      => "Styling",
        ),
        array (
            'param_name' 	=> 'custom_bg_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Custom Background Color', 'pixfort-core'),
            'admin_label'	=> false,
            "group"	      => "Styling",
            "dependency" => array(
                  "element" => "bg_color",
                  "value" => "custom"
              ),
        ),

        array (
            'param_name' 	=> 'rounded_box',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Rounded corners', 'pixfort-core'),
            'admin_label'	=> false,
            "group"	      => "Styling",
            'value' 		=> array(
                __('No','pixfort-core') 	=> 'rounded-0',
                __('Rounded','pixfort-core')	    => 'rounded',
                __('Rounded Large','pixfort-core')	    => 'rounded-lg',
                __('Rounded 5px','pixfort-core')	    => 'rounded-xl',
                __('Rounded 10px','pixfort-core')	    => 'rounded-10',
            )
        ),









        array(
          'type' => 'css_editor',
          'heading' => __( 'Css', 'pixfort-core' ),
          'param_name' => 'css',
          'group' => __( 'Design options', 'pixfort-core' ),
          ),



    ))
));

 ?>
