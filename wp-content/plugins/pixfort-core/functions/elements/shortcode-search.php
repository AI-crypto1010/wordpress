<?php


// Search -----------------------------
vc_map( array (
    'base' 			=> 'pix_search',
    'name' 			=> __('Search', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    'class'         => 'pixfort_element',
    "weight"	=> "1000",
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/search.png',
    'description' 	=> __('Add custom Search element', 'pixfort-core'),
    // "front_enqueue_js" => PIX_CORE_PLUGIN_URI . 'functions/js/views/search.js',
    'params' 		=> array (



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

      array (
          'param_name' 	=> 'search_div',
          'type' 			=> 'dropdown',
          'heading' 		=> __('Field inside a container', 'pixfort-core'),
          "description" => __( "if enabled, other elements won't show on the same line.", "js_composer"),
          'admin_label'	=> false,
          'value'			=> array_flip(array(
              '' 		=> 'Disabled',
              'text-center' 		=> 'Center align',
              'text-left' 		=> 'Left align',
              'text-right' 		=> 'Right align',
          )),
      ),

      array (
          'param_name' 	=> 'max_width',
          'type' 			=> 'textfield',
          'heading' 		=> __('Field max width', 'pixfort-core'),
          'description'     => "Input the width with the unit (eg. 300px)"
      ),
      ...(class_exists('\PixfortCore') && \PixfortCore::instance()->getThemeParam('new_border_options') ? array(
          array(
              "type" => "dropdown",
              "heading" => __("Shadow Style", "pixfort-core"),
              "param_name" => "shadow_style",
              "admin_label" => false,
              "std" => "1",
              "value" => array_flip(array(
                  "none" => "None",
                  "1" => "Small shadow",
                  "2" => "Medium shadow",
                  "3" => "Large shadow",
              )),
              "group" => __( "Search Style", "pixfort-core" ),
          ),
          array (
              'param_name' 	=> 'rounded_corners',
              'type' 			=> 'dropdown',
              'heading' 		=> __('Rounded corners', 'pixfort-core'),
              'admin_label'	=> false,
              'std' 			=> 'rounded-lg',
              'value' 		=> array(
                  __('No','pixfort-core') 			=> 'rounded-0',
                  __('Rounded','pixfort-core') 		=> 'rounded',
                  __('Rounded Large','pixfort-core')	=> 'rounded-lg',
                  __('Rounded 5px','pixfort-core') 	=> 'rounded-xl',
                  __('Rounded 10px','pixfort-core') 	=> 'rounded-10',
                  __('Custom','pixfort-core') 		=> 'custom',
              ),
              "group" => __( "Search Style", "pixfort-core" ),
          ),
          array (
              'param_name' 	=> 'custom_border_radius',
              'type' 			=> 'textfield',
              'heading' 		=> __('Custom Border Radius', 'pixfort-core'),
              'description' 	=> __('Input CSS border-radius value (e.g. 12px 12px 12px 12px or 16px).', 'pixfort-core'),
              'admin_label'	=> false,
              "group" => __( "Search Style", "pixfort-core" ),
              "dependency" => array(
                  "element" => "rounded_corners",
                  "value" => "custom"
              ),
          ),
      ) : array()),


        array(
          'type' => 'css_editor',
          'heading' => __( 'Css', 'pixfort-core' ),
          'param_name' => 'css',
          'group' => __( 'Design options', 'pixfort-core' ),
          ),

    )
));

 ?>
