<?php

$pix_alert_params = array(
    array(
        'param_name'     => 'title',
        'type'             => 'textfield',
        'heading'         => __('Title', 'pixfort-core'),
        'admin_label'    => true,
    ),

    array(
        "type" => "checkbox",
        "heading" => __("Title format", "pixfort-core"),
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
        'param_name'     => 'alert_type_1',
        'type'             => 'dropdown',
        'heading'         => __('Alert Type', 'pixfort-core'),
        'admin_label'    => true,
        'value'            => array_flip(array(
            'success'        => 'Success',
            'secondary'        => 'Secondary',
            'primary'         => 'Primary',
            'danger'         => 'Danger',
            'warning'         => 'Warning',
            'info'             => 'Info',
            'light'         => 'Light',
            'dark'             => 'Dark',
        )),
    ),
    // array(
    //     "type" => "checkbox",
    //     "class" => "",
    //     "heading" => __("Show shadow", "pixfort-core"),
    //     "param_name" => "shadow",
    //     "value" => __("1", "pixfort-core"),
    //     "description" => __("Add shadow to the alert element.", "pixfort-core")
    // ),



    // New options
    array(
        'param_name'     => 'rounded_img',
        'type'             => 'dropdown',
        'heading'         => __('Rounded corners', 'pixfort-core'),
        'admin_label'    => false,
        'std'   => 'rounded',
        'value'         => array(
            __('No', 'pixfort-core')     => 'rounded-0',
            __('Rounded', 'pixfort-core')        => 'rounded',
            __('Rounded Large', 'pixfort-core')        => 'rounded-lg',
            __('Rounded 5px', 'pixfort-core')        => 'rounded-xl',
            __('Rounded 10px', 'pixfort-core')        => 'rounded-10',
        )
    ),
    
    array(
        "param_name" => "shadow",
        "type" => "dropdown",
        "heading" => __("Shadow Style", "js_composer"),
        "admin_label" => true,
        "value" => array_flip(array(
            "none" => "Default",
            "1"       => "Small shadow",
            "2"       => "Medium shadow",
            "3"       => "Large shadow",
            "4"       => "Inverse Small shadow",
            "5"       => "Inverse Medium shadow",
            "6"       => "Inverse Large shadow",
        )),
        'save_always' => true,
        'group' => __('Advanced', 'pixfort-core'),
        "description" => __("Please select the style you wish for the box to display in.", "js_composer")
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
        'group' => __('Advanced', 'pixfort-core'),
        "description" => __("Please select the style you wish for the box to display in.", "js_composer")
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
        'group' => __('Advanced', 'pixfort-core'),
        "description" => __("Please select the style you wish for the box to display in.", "js_composer")
    ),

    array(
        "param_name" => "hide_close",
        "type" => "checkbox",
        "heading" => __("Hide Close button", "pixfort-core"),
        "value" => __("Yes", "pixfort-core"),
        'group' => __('Advanced', 'pixfort-core'),
    ),


    array (
        'param_name' 	=> 'link_text',
        'type' 			=> 'textfield',
        'heading' 		=> __('Link Text', 'pixfort-core'),
        'admin_label'	=> true,
        'std'         => "",
        'group' => __('Link', 'pixfort-core'),
    ),
    array(
        'param_name'     => 'link',
        'type'             => 'textfield',
        'heading'         => __('Link', 'pixfort-core'),
        'admin_label'    => true,
        'group' => __('Link', 'pixfort-core'),
    ),
    array(
        "type" => "checkbox",
        "heading" => __("Open in a new tab", "pixfort-core"),
        "param_name" => "target",
        "value" => __("Yes", "pixfort-core"),
        "dependency" => array(
            "element" => "link",
            "not_empty" => true
        ),
        'group' => __('Link', 'pixfort-core'),
    ),

    array (
        'param_name' 	=> 'link_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Link text color', 'pixfort-core'),
        'admin_label'	=> false,
        'group' => __('Link', 'pixfort-core'),
        'value' 		=> array_merge(
            array(
                "Default"   => 'alert-default'
            ),
            $colors
        ) ,
        'std'           => 'alert-default',
        "dependency" => array(
            "element" => "link_text",
            "not_empty" => true
        ),
    ),

    array (
        'param_name' 	=> 'text_custom_color',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Link custom text color', 'pixfort-core'),
        'admin_label'	=> false,
        'group' => __('Link', 'pixfort-core'),
        "dependency" => array(
            "element" => "link_color",
            "value" => "custom"
        ),
    ),



    array(
        "param_name" => "media_type",
        "type" => "dropdown",
        "heading" => __( "Use image or icon", "pixfort-core" ),
        "value" => array(
            "None" => "none",
            "Image" => "image",
            "Icon" => "icon",
            // "Duo tone icon" => "duo_icon",
            "Character" => "char"
        ),
        "group"	      => "Image / Icon",
    ),

    array(
        'param_name'  => 'pix_duo_icon',
        'type'        => 'pix_icons_select',
        'heading'  => 'Duo tone icons',
        "class" => "my_param_field",
        'value'       => '0',
        "group"	      => "Image / Icon",
        "dependency" => array(
            "element" => "media_type",
            "value" => "duo_icon"
        ),
    ),
    array (
        'param_name' 	=> 'char',
        'type' 			=> 'textfield',
        'heading' 		=> __('Character', 'pixfort-core'),
        "std"           => "1",
        'description' => __( 'Please input only one character.', 'pixfort-core' ),
        'admin_label'	=> false,
        "dependency" => array(
            "element" => "media_type",
            "value" => "char"
        ),
        "group"	      => "Image / Icon",
    ),

    array (
        'param_name' => 'icon',
        'type' => 'pixfort_icons_picker',
        'heading' => __( 'Icon', 'pixfort-core' ),
        // 'settings' => array(
        //     'emptyIcon' => true, // default true, display an "EMPTY" icon?
        //     'type' => 'pix-icons',
        //     'iconsPerPage' => 200, // default 100, how many icons per/page to display
        // ),
        "group"	      => "Image / Icon",
        'description' => __( 'Select icon from library.', 'pixfort-core' ),
        "dependency" => array(
            "element" => "media_type",
            "value" => "icon"
        ),
    ),
    array (
        'param_name' 	=> 'icon_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Icon color', 'pixfort-core'),
        'admin_label'	=> false,
        'value' 		=> $colors,
        'std'			=> 'primary',
        "group"	      => "Image / Icon",
        "dependency" => array(
            "element" => "media_type",
            "value" => array("icon", "char", "duo_icon")
        ),
    ),
    array (
        'param_name' 	=> 'icon_size',
        'type' 			=> 'textfield',
        'heading' 		=> __('Icon Size', 'pixfort-core'),
        "std"           => "30",
        'description' => __( 'The size of the icon in pixels (without writing the unit).', 'pixfort-core' ),
        'admin_label'	=> false,
        "group"	      => "Image / Icon",
        "dependency" => array(
            "element" => "media_type",
            "value" => array("icon", "char", "duo_icon")
        ),
    ),


    array (
        'param_name' 	=> 'image',
        'type' 			=> 'attach_image',
        'heading' 		=> __('Image', 'pixfort-core'),
        'admin_label'	=> false,
        "group"	      => "Image / Icon",
        "dependency" => array(
            "element" => "media_type",
            "value" => "image"
        ),
    ),

    ...( \PixfortCore::instance()->getThemeParam('dynamic_wpb_images') ? [
        array (
            'param_name' 	=> 'dynamic_image',
            'type' 			=> 'pix_dynamic_image',
            'heading' 		=> __('Dynamic Image', 'pixfort-core'),
            'description' 	=> __('Select a dynamic image source (optional). If image is not available, the normal image will be used.', 'pixfort-core'),
            'admin_label'	=> false,
            "group"	      => "Image / Icon",
            "dependency" => array(
                "element" => "media_type",
                "value" => "image"
            ),
        )
    ] : [] ),

    array (
        'param_name' 	=> 'image_size',
        'type' 			=> 'textfield',
        'heading' 		=> __('Image Size', 'pixfort-core'),
        'description' => __( 'The size of the image (with the unit), leave empty for full size.', 'pixfort-core' ),
        'admin_label'	=> false,
        "group"	      => "Image / Icon",
        "dependency" => array(
            "element" => "media_type",
            "value" => "image"
        ),
    ),

    array(
        "param_name" => "circle",
        "type" => "checkbox",
        "heading" => __( "Circle image", "pixfort-core" ),
        "value" => __( "Yes", "pixfort-core" ),
        "group"	      => "Image / Icon",
        "dependency" => array(
            "element" => "media_type",
            "value" => 'image'
        ),
    ),



    array (
        'param_name' 	=> 'custom_icon_color',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Icon Color', 'pixfort-core'),
        'admin_label'	=> false,
        "group"	      => "Image / Icon",
        "dependency" => array(
            "element" => "icon_color",
            "value" => "custom"
        ),

    ),

    array(
        'param_name'     => 'animation',
        'type'             => 'dropdown',
        'heading'         => __('Animation', 'pixfort-core'),
        'description'     => __('Select the animation of the heading.', 'pixfort-core'),
        'admin_label'    => false,
        'value'            => pix_get_animations(),
    ),
    array(
        'param_name'     => 'delay',
        'type'             => 'textfield',
        'heading'         => __('Animation delay (in miliseconds)', 'pixfort-core'),
        'admin_label'    => true,
        "dependency" => array(
            "element" => "animation",
            "not_empty" => true
        ),
    ),


    array(
        'type' => 'css_editor',
        'heading' => __('Css', 'pixfort-core'),
        'param_name' => 'css',
        'group' => __('Design options', 'pixfort-core'),
    ),

);

// Alert -----------------------------
vc_map(array(
    'base'             => 'alertblock',
    'name'             => __('Alert', 'pixfort-core'),
    'category'         => __('pixfort', 'pixfort-core'),
    'class'         => 'pixfort_element',
    "weight"    => "1000",
    'icon'             => PIX_CORE_PLUGIN_URI . 'functions/images/elements/alert.png',
    'description'     => __('Add clean alert box', 'pixfort-core'),
    'params'         => $pix_alert_params
));
