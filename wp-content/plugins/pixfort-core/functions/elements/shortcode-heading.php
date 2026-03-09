<?php

// Heading -----------------------------

$headingOptions = array (

    array (
        'param_name' 	=> 'title',
        'type' 			=> 'textfield',
        'heading' 		=> __('Title', 'pixfort-core'),
        'admin_label'	=> true,
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

    array (
        'param_name' 	=> 'title_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Title color', 'pixfort-core'),
        'admin_label'	=> false,
        'value' 		=> $colors,
        'std'			=> '',
    ),

    array (
        'param_name' 	=> 'title_custom_color',
        'type' 			=> 'colorpicker',
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
        'admin_label'	=> false,
        'value' 		=> array(
            __('H1','pixfort-core') 	=> 'h1',
            __('H2','pixfort-core')	    => 'h2',
            __('H3','pixfort-core')	    => 'h3',
            __('H4','pixfort-core')	    => 'h4',
            __('H5','pixfort-core')	    => 'h5',
            __('H6','pixfort-core')	    => 'h6',
            __('Custom (Div)','pixfort-core')	    => 'custom',
        ),
    ),

    array (
        'param_name' 	=> 'display',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Bigger Text', 'pixfort-core'),
        'description' 	=> __('Larger heading text size to stand out.', 'pixfort-core'),
        'admin_label'	=> false,
        'value'			=> array_flip(array(
            ''		=> 'None',
            'display-1'		=> 'Display 1',
            'display-2'		=> 'Display 2',
            'display-3'		=> 'Display 3',
            'display-4'		=> 'Display 4',
        )),
        "dependency" => array(
            "element" => "title_size",
            "value" => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6')
        ),
    ),

    array (
        'param_name' 	=> 'title_custom_size',
        'type' 			=> 'textfield',
        'heading' 		=> __('Custom Title font size', 'pixfort-core'),
        'admin_label'	=> false,
        'description' 	=> __('Input the custom font size (with unit), leave empty to display the default size.', 'pixfort-core'),
        // "dependency" => array(
        //     "element" => "title_size",
        //     "value" => "custom"
        // ),
    ),

    array (
        'param_name' 	=> 'position',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Position', 'pixfort-core'),
        'description' 	=> __('Select the position of the heading.', 'pixfort-core'),
        'admin_label'	=> false,
        'value'			=> array_flip(array(
            'text-center'		=> 'Center',
            'text-left'			=> 'Start',
            'text-right' 		=> 'End',
        )),
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


    array (
        'param_name' 	=> 'image',
        'type' 			=> 'attach_image',
        'heading' 		=> __('Use image as text color', 'pixfort-core'),
        'description' 	=> __('The image will be visible inside the text characters.', 'pixfort-core'),
        'admin_label'	=> false,
        'group'         => "Advanced",
    ),
    ...( \PixfortCore::instance()->getThemeParam('dynamic_wpb_images') ? [
        array(
            'param_name' 	=> 'dynamic_image',
            'type' 			=> 'pix_dynamic_image',
            'heading' 		=> __('Dynamic image source', 'pixfort-core'),
            'description' 	=> __('Select a dynamic image source (optional). If image is not available, the normal image will be used.', 'pixfort-core'),
            'group'         => "Advanced",
        ),
    ] : [] ),

    array (
        'param_name' 	=> 'heading_id',
        'type' 			=> 'textfield',
        'heading' 		=> __('Heading ID', 'pixfort-core'),
        'admin_label'	=> true,
        'group'         => "Advanced",
    ),

    array (
        'param_name' 	=> 'max_width',
        'type' 			=> 'textfield',
        'heading' 		=> __('Text max width (Optional)', 'pixfort-core'),
        'description' 	=> __('Input text width limit (with unit, for example 400px) instead of filling the width of the container.', 'pixfort-core'),
        'admin_label'	=> true,
    ),

    

    array(
        'type' => 'css_editor',
        'heading' => __( 'Css', 'pixfort-core' ),
        'param_name' => 'css',
        'group' => __( 'Design options', 'pixfort-core' ),
    ),
);
$headingOptions = array_merge(
    $headingOptions,
    array(
        array(
            "param_name" => "vertical_element",
            "type" => "checkbox",
            "heading" => __( "Vertical text", "pixfort-core" ),
            "value" => __( "Yes", "pixfort-core" ),
        ),
    )
);


vc_map( array (
    'base' 			=> 'heading',
    'name' 			=> __('Heading', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/heading.png',
    'description' 	=> __('Create custom heading element', 'pixfort-core'),
    'params' 		=> $headingOptions
));

?>
