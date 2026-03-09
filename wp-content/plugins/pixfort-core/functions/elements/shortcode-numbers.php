<?php

// Numbers -------------------------------------------
vc_map( array (
    'base' 			=> 'pix_numbers',
    'name' 			=> __('Numbers', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/numbers.gif',
    'description' 	=> __('Display stunning animated numbers', 'pixfort-core'),
    'params' 		=> array (

        array (
            'param_name' 	=> 'numbers_style',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Style', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> array(
                'Inline' => 'numbers-inline',
                'Stack' => 'numbers-stack',
            )
        ),

        array (
            'param_name' 	=> 'text_before',
            'type' 			=> 'textfield',
            'heading' 		=> __('Text Before', 'pixfort-core'),
            'admin_label'	=> false,
        ),

        array(
              "type" => "checkbox",
              "heading" => __( "Text Before format", "pixfort-core" ),
              "param_name" => "before_bold",
              "value" => array("Bold" => "font-weight-bold"),
              "std" => "font-weight-bold"
          ),
        array(
              "type" => "checkbox",
              "param_name" => "before_italic",
              "value" => array("Italic" => "font-italic",),
          ),
        array(
              "type" => "checkbox",
              "param_name" => "before_secondary_font",
              "value" => array("Secondary font" => "secondary-font",),
          ),
          array(
            "type" => "checkbox",
            "param_name" => "before_space_after",
            "value" => array("Add space after the Before text" => "space_after",),
        ),

        array (
            'param_name' 	=> 'number',
            'type' 			=> 'textfield',
            'heading' 		=> __('Number', 'pixfort-core'),
            'admin_label'	=> true,
        ),
        array(
              "type" => "checkbox",
              "heading" => __( "Number format", "pixfort-core" ),
              "param_name" => "number_bold",
              "value" => array("Bold" => "font-weight-bold"),
              "std" => "font-weight-bold"
          ),
        array(
              "type" => "checkbox",
              "param_name" => "number_italic",
              "value" => array("Italic" => "font-italic",),
          ),
        array(
              "type" => "checkbox",
              "param_name" => "number_secondary_font",
              "value" => array("Secondary font" => "secondary-font",),
          ),
          

        array (
            'param_name' 	=> 'duration',
            'type' 			=> 'textfield',
            'heading' 		=> __('Duration', 'pixfort-core'),
            'admin_label'	=> true,
            'value'         => '3000',
            'description'       => 'The duration in miliseconds.'
        ),

        array (
            'param_name' 	=> 'text_after',
            'type' 			=> 'textfield',
            'heading' 		=> __('Text After', 'pixfort-core'),
            'admin_label'	=> false,
        ),

        array(
              "type" => "checkbox",
              "heading" => __( "Text After format", "pixfort-core" ),
              "param_name" => "after_bold",
              "std" => "font-weight-bold",
              "value" => array("Bold" => "font-weight-bold",)
          ),
        array(
              "type" => "checkbox",
              "param_name" => "after_italic",
              "value" => array("Italic" => "font-italic",),
          ),
        array(
              "type" => "checkbox",
              "param_name" => "after_secondary_font",
              "value" => array("Secondary font" => "secondary-font",),
          ),

          array(
            "type" => "checkbox",
            "param_name" => "after_space_before",
            "value" => array("Add space before the text" => "space_before",),
        ),

        array (
            'param_name' 	=> 'content',
            'type' 			=> 'textarea',
            'heading' 		=> __('Content', 'pixfort-core'),
            'admin_label'	=> false,
        ),

        array(
              "type" => "checkbox",
              "heading" => __( "Content format", "pixfort-core" ),
              "param_name" => "content_bold",
              "value" => array("Bold" => "font-weight-bold",),
              "std" => "font-weight-bold"
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
              'param_name' 	=> 'title_color',
              'type' 			=> 'dropdown',
              'group' => __( 'Advanced', 'pixfort-core' ),
              'heading' 		=> __('Title color', 'pixfort-core'),
              'admin_label'	=> false,
              'value' 		=> $colors,
              'std'			=> '',
          ),

          array (
              'param_name' 	=> 'title_custom_color',
              'type' 			=> 'colorpicker',
              'group' => __( 'Advanced', 'pixfort-core' ),
              'heading' 		=> __('Title color', 'pixfort-core'),
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
              'group' => __( 'Advanced', 'pixfort-core' ),
              'admin_label'	=> false,
              'std'	=> 'h3',
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
              'group' => __( 'Advanced', 'pixfort-core' ),
              'admin_label'	=> false,
              "dependency" => array(
                    "element" => "title_size",
                    "value" => "custom"
                ),
          ),

          array (
              'param_name' 	=> 'title_display',
              'type' 			=> 'dropdown',
              'heading' 		=> __('Bigger Title Text', 'pixfort-core'),
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
              'param_name' 	=> 'content_color',
              'type' 			=> 'dropdown',
              'heading' 		=> __('Content color', 'pixfort-core'),
              'admin_label'	=> false,
              'group' => __( 'Advanced', 'pixfort-core' ),
              'std'           => 'dark-opacity-5',
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
              'heading' 		=> __('Content size', 'pixfort-core'),
              'group' => __( 'Advanced', 'pixfort-core' ),
              'admin_label'	=> false,
              'std'	=> 'h6',
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
              'param_name' 	=> 'content_custom_size',
              'type' 			=> 'textfield',
              'heading' 		=> __('Content Size', 'pixfort-core'),
              'group' => __( 'Advanced', 'pixfort-core' ),
              'admin_label'	=> false,
              "dependency" => array(
                    "element" => "content_size",
                    "value" => "custom"
                ),
          ),
          array (
              'param_name' 	=> 'content_position',
              'type' 			=> 'dropdown',
              'heading' 		=> __('Content position', 'pixfort-core'),
              'group' => __( 'Advanced', 'pixfort-core' ),
              'admin_label'	=> false,
              'std'	=> 'text-left',
              'value' 		=> array(
                  __('Start','pixfort-core') 	=> 'text-left',
                  __('Center','pixfort-core') 	=> 'text-center',
                  __('End','pixfort-core') 	=> 'text-right',
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
