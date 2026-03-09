<?php



// Progress Bars -------------------------------------------
vc_map( array (
	'base' 			=> 'pix_progress_bars',
	'name' 			=> __('Progress Bars', 'pixfort-core'),
	'category' 		=> __('pixfort', 'pixfort-core'),
    'class'         => 'pixfort_element',
    "weight"	=> "1000",
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/progress-bar.gif',
    'description' 	=> __('Create custom progress bars', 'pixfort-core'),
    // "front_enqueue_js" => PIX_CORE_PLUGIN_URI . 'functions/js/views/progress_bars.js',
	'params' 		=> array (


        array(
              'type' => 'param_group',
              'value' => '',
              'param_name' => 'items',
              'heading' 		=> __('Progress Bars', 'pixfort-core'),
              'description' 	=> __('Add each progress bar in the desired order.', 'pixfort-core'),
              'params' => array(

                  array (
                      'param_name' 	=> 'title',
                      'type' 			=> 'textfield',
                      'heading' 		=> __('Title', 'pixfort-core'),
                      'admin_label'	=> true,
                      'value'       => '',
                  ),
                  array (
                      'param_name' 	=> 'value',
                      'type' 			=> 'textfield',
                      'heading' 		=> __('Value', 'pixfort-core'),
                      'admin_label'	=> true,
                      'value'       => '50',
                  ),

                  array (
                      'param_name' 	=> 'text_color',
                      'type' 			=> 'dropdown',
                      'heading' 		=> __('Text color', 'pixfort-core'),
                      'admin_label'	=> false,
                      'value' 		=> $colors,
                  ),

                  array (
                      'param_name' 	=> 'text_custom_color',
                      'type' 			=> 'colorpicker',
                      'heading' 		=> __('Text custom color', 'pixfort-core'),
                      'admin_label'	=> false,
                      'value'       => '#333',
                      "dependency" => array(
                            "element" => "text_color",
                            "value" => "custom"
                        ),
                  ),


                  array (
                      'param_name' 	=> 'item_color',
                      'type' 			=> 'dropdown',
                      'heading' 		=> __('Bar color', 'pixfort-core'),
                      'admin_label'	=> false,
                      'value' 		=> $bg_colors,
                  ),

                  array (
                      'param_name' 	=> 'item_custom_color',
                      'type' 			=> 'colorpicker',
                      'heading' 		=> __('Bar custom color', 'pixfort-core'),
                      'admin_label'	=> false,
                      'value'       => '#333',
                      "dependency" => array(
                            "element" => "item_color",
                            "value" => "custom"
                        ),
                  ),
                  array (
                      'param_name' 	=> 'bg_color',
                      'type' 			=> 'dropdown',
                      'heading' 		=> __('Background color', 'pixfort-core'),
                      'admin_label'	=> false,
					  'std'			=> 'dark-opacity-3',
                      'value' 		=> $bg_colors,
                  ),

                  array (
                      'param_name' 	=> 'bg_custom_color',
                      'type' 			=> 'colorpicker',
                      'heading' 		=> __('Background custom color', 'pixfort-core'),
                      'admin_label'	=> false,
                      'value'       => '#333',
                      "dependency" => array(
                            "element" => "bg_color",
                            "value" => "custom"
                        ),
                  ),


              )
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

        array(
          'type' => 'css_editor',
          'heading' => __( 'Css', 'pixfort-core' ),
          'param_name' => 'css',
          'group' => __( 'Design options', 'pixfort-core' ),
          ),


	)
));

 ?>
