<?php
$map_params = array(
    array (
        'param_name' 	=> 'address',
        'type' 			=> 'textfield',
        'heading' 		=> __('Map text (Address)', 'pixfort-core'),
        'admin_label'	=> true,
        'value'         => '',
    ),
    array (
        'param_name' 	=> 'latitude',
        'type' 			=> 'textfield',
        'heading' 		=> __('Latitude', 'pixfort-core'),
        'admin_label'	=> true,
        'value'         => '48.892506',
    ),
    array (
        'param_name' 	=> 'longitude',
        'type' 			=> 'textfield',
        'heading' 		=> __('Longitude', 'pixfort-core'),
        'admin_label'	=> true,
        'value'         => '2.236413'
    ),
    array (
        'param_name' 	=> 'map_zoom',
        'type' 			=> 'textfield',
        'heading' 		=> __('Map zoom', 'pixfort-core'),
        'admin_label'	=> true,
        'value'         => '14'
    ),
    array (
        'param_name' 	=> 'map_style',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Map style', 'pixfort-core'),
        'admin_label'	=> true,
        'value'			=> array(
            'Silver'		=> 'silver',
            'Standard'		=> 'standard',
            'Retro' 		=> 'retro',
            'Dark' 		    => 'dark',
            'Night' 		=> 'night',
            'Aubergine'     => 'aubergine',
            'Custom' 		=> 'custom'
        ),
    ),
    array (
        'param_name' 	=> 'custom_color',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Custom color', 'pixfort-core'),
        'admin_label'	=> true,
        'value'         => '#1274E7',
        'dependency' => array(
            "element" => "map_style",
            "value" => array("custom")
        )
    ),
    array (
        'param_name' 	=> 'custom_saturation',
        'type' 			=> 'textfield',
        'heading' 		=> __('Custom saturation', 'pixfort-core'),
        'admin_label'	=> true,
        'value'         => '-20',
        'dependency' => array(
            "element" => "map_style",
            "value" => array("custom")
        )
    ),
    array (
        'param_name' 	=> 'custom_brightness',
        'type' 			=> 'textfield',
        'heading' 		=> __('Custom brightness', 'pixfort-core'),
        'admin_label'	=> true,
        'value'         => '5',
        'dependency' => array(
            "element" => "map_style",
            "value" => array("custom")
        )
    ),



    array (
        'param_name' 	=> 'marker',
        'type' 			=> 'attach_image',
        'heading' 		=> __('Marker Image', 'pixfort-core'),
        "description" => __( "Upload custom marker image if you want to replace the default one.", "pixfort-core" ),
        'admin_label'	=> false,
    ),
    ...( \PixfortCore::instance()->getThemeParam('dynamic_wpb_images') ? [
        array(
            'param_name' 	=> 'dynamic_marker',
            'type' 			=> 'pix_dynamic_image',
            'heading' 		=> __('Dynamic image source', 'pixfort-core'),
            'description' 	=> __('Select a dynamic image source (optional). If image is not available, the normal image will be used.', 'pixfort-core'),
        ),
    ] : [] ),


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
     "type" => "dropdown",
     "heading" => __("Shadow Style", "js_composer"),
     "param_name" => "style",
     "admin_label" => true,
     "value" => array_flip(array(
        "" => "Default",
        "1"       => "Small shadow",
        "2"       => "Medium shadow",
        "3"       => "Large shadow",
        "4"       => "Inverse Small shadow",
        "5"       => "Inverse Medium shadow",
        "6"       => "Inverse Large shadow",
    )),
     'save_always' => true,
     'group' => __( 'Advanced', 'pixfort-core' ),
     "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
    ),
    array(
    "type" => "dropdown",
    "heading" => __("Shadow Hover Style", "js_composer"),
    "param_name" => "hover_effect",
    "admin_label" => true,
    "value" => array_flip(array(
      ""       => "None",
      "1"       => "Small hover shadow",
      "2"       => "Medium hover shadow",
      "3"       => "Large hover shadow",
      "4"       => "Inverse Small hover shadow",
      "5"       => "Inverse Medium hover shadow",
      "6"       => "Inverse Large hover shadow",
    )),
    'save_always' => true,
    'group' => __( 'Advanced', 'pixfort-core' ),
    "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
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
    'group' => __( 'Advanced', 'pixfort-core' ),
    "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
    ),


    array(
     "type" => "dropdown",
     "heading" => __("Map height", "js_composer"),
     "param_name" => "map_height",
     "admin_label" => true,
     "std" => '',
     "description" => 'To use full height you should enable the "Equal height" option in the containg section/row.',
     "value" => array_flip(array(
         ""  => "Big",
         "map-md" => "Medium",
         "map-sm" => "Small",
        "full-height"       => "Full height",
    )),
     'save_always' => true,
     'group' => __( 'Advanced', 'pixfort-core' ),
    ),


    array(
      'type' => 'css_editor',
      'heading' => __( 'Css', 'pixfort-core' ),
      'param_name' => 'css',
      'group' => __( 'Design options', 'pixfort-core' ),
      ),
);
if(empty(pix_plugin_get_option('google-api-key'))){
$map_params = array_merge(array(
    array(
        'type'        => 'pix_param_section_notice',
        'pix_title'  => 'Google Maps API key is not configured in theme options, for more information check <a target="_blank" href="'.\PixfortCore::instance()->adminCore->getParam('docs_google_maps').'">this article</a> from our knowledge base.',
        'param_name'	=> 'pix_maps_notice',
    )
), $map_params);
}
// Map -----------------------------
vc_map( array (
    'base' 			=> 'pix_map',
    'name' 			=> __('pixfort Google Maps', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/maps.png',
    'description' 	=> __('Add awesome Google Maps with premium skins', 'pixfort-core'),
    'params' 		=> $map_params
));

 ?>
