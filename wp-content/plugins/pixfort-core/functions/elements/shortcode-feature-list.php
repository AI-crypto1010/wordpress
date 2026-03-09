<?php


$features_list_params = array(
    array (
        'param_name' 	=> 'content_size',
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


    array (
        'param_name' 	=> 'content_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Content color', 'pixfort-core'),
        'admin_label'	=> false,
        'value' 		=> $colors,
        'std'			=> 'primary',
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
        'param_name' 	=> 'icon_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Icon color', 'pixfort-core'),
        'admin_label'	=> false,
        'value' 		=> $colors,
        'std'			=> 'primary',
    ),
    array (
        'param_name' 	=> 'custom_icon_color',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Icon Color', 'pixfort-core'),
        'admin_label'	=> false,
        "dependency" => array(
            "element" => "icon_color",
            "value" => "custom"
        ),

    ),


    array(
        'type' => 'param_group',
        'value' => '',
        'param_name' => 'features',
        'heading' 		=> __('Features', 'pixfort-core'),
        'description' 	=> __('Add each feature in the desired order.', 'pixfort-core'),
        'params' => array(
            array (
                'param_name' 	=> 'text',
                'type' 			=> 'textfield',
                'heading' 		=> __('Text', 'pixfort-core'),
                'admin_label'	=> true,
            ),

            array (
                'param_name' 	=> 'link',
                'type' 			=> 'vc_link',
                'heading' 		=> __('Link (Optional)', 'pixfort-core'),
                "dependency" => array(
                      "element" => "enable_link",
                      "not_empty" => true
                  ),
            ),

            array (
                'type' => 'pixfort_icons_picker',
                'heading' => __( 'Line Icon', 'pixfort-core' ),
                'param_name' => 'icon',
                'settings' => array(
                    'emptyIcon' => true, // default true, display an "EMPTY" icon?
                    'type' => 'pix-icons',
                    'iconsPerPage' => 200, // default 100, how many icons per/page to display
                ),
                "dependency" => array(
                    "element" => "media_type",
                    "value" => "icon"
                ),
                'description' => __( 'Select icon from library.', 'pixfort-core' ),
            ),

        )
    ),

    array(
        "type" => "checkbox",
        "heading" => __( "Text format", "pixfort-core" ),
        "param_name" => "flist_bold",
        "value" => array("Bold" => "font-weight-bold"),
        "std" => "font-weight-bold",
        'save_always' => true,
    ),
    array(
        "type" => "checkbox",
        "param_name" => "flist_italic",
        "value" => array("Italic" => "font-italic",),
    ),
    array(
        "type" => "checkbox",
        "param_name" => "flist_secondary_font",
        "value" => array("Secondary font" => "secondary-font",),
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
);
// Feature List --------------------------------------
vc_map( array (
    'base' 			=> 'pix_feature_list',
    'name' 			=> __('Feature List', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/features-list.jpg',
    'description' 	=> __('Create custom features list element', 'pixfort-core'),
    'params' 		=> array_merge($features_list_params, array (

        array (
            'param_name' 	=> 'features_content_align',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Content align', 'pixfort-core'),
            'admin_label'	=> false,
            'value'			=> array_flip(array(
                ''			=> 'Default',
                'justify-content-start'			=> 'Left',
                'justify-content-center'		=> 'Center',
                'justify-content-end' 		=> 'Right',
            )),
        ),

        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'pixfort-core' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'pixfort-core' ),
        ),

    )

)
));

?>
