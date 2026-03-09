<?php


$event_params = array(
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
        'heading' 		=> __('Events', 'pixfort-core'),
        'description' 	=> __('Add each feature in the desired order.', 'pixfort-core'),
        'params' => array(
            array (
                'param_name' 	=> 'time',
                'type' 			=> 'textfield',
                'heading' 		=> __('Time', 'pixfort-core'),
                'admin_label'	=> true,
            ),
            array (
                'param_name' 	=> 'title',
                'type' 			=> 'textfield',
                'heading' 		=> __('Title', 'pixfort-core'),
                'admin_label'	=> true,
            ),
            array (
                'param_name' 	=> 'text',
                'type' 			=> 'textarea',
                'heading' 		=> __('Description', 'pixfort-core'),
                'admin_label'	=> false,
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
);
// Event --------------------------------------
vc_map( array (
    'base' 			=> 'pix_event',
    'name' 			=> __('Event', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/event.png',
    'description' 	=> __('Create custom event schedule', 'pixfort-core'),
    'params' 		=> array_merge($event_params, array (




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
