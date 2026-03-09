<?php


// Button -----------------------------
$popup_posts = get_posts([
    'post_type' => 'pixpopup',
    'post_status' => 'publish',
    'numberposts' => -1
]);

$popups = array();
$popups[''] = "Disabled";
foreach ($popup_posts as $key => $value) {
    $popups[$value->ID] = $value->post_title;
}



$button_params = array (
    array (
        'param_name' 	=> 'btn_text',
        'type' 			=> 'textfield',
        'heading' 		=> __('Button Text', 'pixfort-core'),
        'value'         => "Click here",
        'admin_label'	=> true,
        'save_always' => true,
    ),
    array (
        'param_name' 	=> 'btn_link',
        'type' 			=> 'textfield',
        'heading' 		=> __('Button Link', 'pixfort-core'),
        'admin_label'	=> false,
    ),
    array(
        "type" => "checkbox",
        "heading" => __( "Open in a new tab", "pixfort-core" ),
        "param_name" => "btn_target",
        "value" => __( "Yes", "pixfort-core" ),
        "dependency" => array(
            "element" => "btn_link",
            "not_empty" => true
        ),
    ),

    array(
        "type" => "dropdown",
        "heading" => __("Open Popup instead of link", "js_composer"),
        "param_name" => "btn_popup_id",
        "admin_label" => true,
        "value" => array_flip($popups),
    ),

    array(
        "type" => "checkbox",
        "heading" => __( "Button format", "pixfort-core" ),
        "param_name" => "btn_title_bold",
        "value" => array("Bold" => "font-weight-bold",),
        'std'			=> 'font-weight-bold',
    ),
    array(
        "type" => "checkbox",
        "param_name" => "btn_italic",
        "value" => array("Italic" => "font-italic",),
    ),
    array(
        "type" => "checkbox",
        "param_name" => "btn_secondary_font",
        "value" => array("Secondary font" => "secondary-font",),
    ),

    array(
        "type" => "dropdown",
        "heading" => __("Button Style", "js_composer"),
        "param_name" => "btn_style",
        "admin_label" => true,
        "value" => array_flip(array(
            ""            => "Default",
            "flat"        => "Flat",
            "line"        => "Line",
            "outline"     => "Outline",
            "underline"     => "Underline",
            "link"        => "Link",
            "blink"     => "Blink"
        )),
    ),

    array (
        'param_name' 	=> 'btn_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Button Color', 'pixfort-core'),
        'admin_label'	=> true,
        'value'			=> array_flip(array(
            'primary' 		=> 'Primary',
            'primary-light' 		=> 'Primary Light',
            'secondary'		=> 'Secondary',
            'secondary-light'		=> 'Secondary Light',
            'gray-1' 		=> 'Light',
            'gray-5' 		    => 'Dark',
            'black' 		=> 'Black',
            'white' 		=> 'White',
            'blue' 		    => 'Blue',
            'red' 		    => 'Red',
            'cyan' 		    => 'Cyan',
            'orange' 		    => 'Orange',
            'green' 		    => 'Green',
            'purple' 		    => 'Purple',
            'brown' 		    => 'Brown',
            'yellow' 		    => 'Yellow',
            'gradient-primary' 		    => 'Primary gradient',
            "gray-1" => 'Gray 1',
            "gray-2" => 'Gray 2',
            "gray-3" => 'Gray 3',
            "gray-4" => 'Gray 4',
            "gray-5" => 'Gray 5',
            "gray-6" => 'Gray 6',
            "gray-7" => 'Gray 7',
            "gray-8" => 'Gray 8',
            "gray-9" => 'Gray 9',
            "dark-opacity-1" => 'Dark opacity 1',
            "dark-opacity-2" => 'Dark opacity 2',
            "dark-opacity-3" => 'Dark opacity 3',
            "dark-opacity-4" => 'Dark opacity 4',
            "dark-opacity-5" => 'Dark opacity 5',
            "dark-opacity-6" => 'Dark opacity 6',
            "dark-opacity-7" => 'Dark opacity 7',
            "dark-opacity-8" => 'Dark opacity 8',
            "dark-opacity-9" => 'Dark opacity 9',
            "light-opacity-1" => 'Light opacity 1',
            "light-opacity-2" => 'Light opacity 2',
            "light-opacity-3" => 'Light opacity 3',
            "light-opacity-4" => 'Light opacity 4',
            "light-opacity-5" => 'Light opacity 5',
            "light-opacity-6" => 'Light opacity 6',
            "light-opacity-7" => 'Light opacity 7',
            "light-opacity-8" => 'Light opacity 8',
            "light-opacity-9" => 'Light opacity 9'
        )),
    ),

    array(
        "type" => "checkbox",
        "heading" => __( "Remove padding", "pixfort-core" ),
        "param_name" => "btn_remove_padding",
        "value" => array("Yes" => "no-padding"),
        "dependency" => array(
            "element" => "btn_style",
            "value" => array("link", "underline")
        ),
    ),

    array (
        'param_name' 	=> 'btn_text_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Text color', 'pixfort-core'),
        'admin_label'	=> false,
        'value' 		=> array_merge(array("Default" => "",), $colors),
    ),

    array (
        'param_name' 	=> 'btn_text_custom_color',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Text custom color', 'pixfort-core'),
        'admin_label'	=> false,
        "dependency" => array(
            "element" => "btn_text_color",
            "value" => "custom"
        ),
    ),


    array(
        "type" => "dropdown",
        "heading" => __("Button Size", "js_composer"),
        "param_name" => "btn_size",
        "admin_label" => true,
        "value" => array_flip(array(
            "sm"       => "Small",
            "normal"       => "Normal",
            "md"       => "Medium",
            "lg"       => "Large",
            "xl"       => "XLarge "
        )),
        'std'   => "md",
        'save_always' => true,
        "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
    ),



    array(
        "type" => "checkbox",
        "heading" => __( "Rounded corners button", "pixfort-core" ),
        "param_name" => "btn_rounded",
        "value" => array("Yes" => "btn-rounded",),
        'std'			=> '',
    ),

    array(
        "type" => "dropdown",
        "heading" => __("Button Shadow Style", "js_composer"),
        "param_name" => "btn_effect",
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
        "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
    ),
    array(
        "type" => "dropdown",
        "heading" => __("Button Shadow Hover Style", "js_composer"),
        "param_name" => "btn_hover_effect",
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
        "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
    ),
    array(
        "type" => "dropdown",
        "heading" => __("Button Hover Animation", "js_composer"),
        "param_name" => "btn_add_hover_effect",
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
        "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
    ),

    array (
        'type' => 'pixfort_icons_picker',
        'heading' => __( 'Button Icon', 'pixfort-core' ),
        'param_name' => 'btn_icon',
        'settings' => array(
            'emptyIcon' => true, // default true, display an "EMPTY" icon?
            'type' => 'pix-icons',
            'iconsPerPage' => 200, // default 100, how many icons per/page to display
        ),
        'description' => __( 'Select icon from library.', 'pixfort-core' ),
    ),

    array(
        "type" => "dropdown",
        "heading" => __("Icon position", "js_composer"),
        "param_name" => "btn_icon_position",
        "admin_label" => false,
        "value" => array_flip(array(
            ""            => "Before text",
            "after"        => "After text"
        )),
        "dependency" => array(
            "element" => "btn_icon",
            "not_empty" => true
        ),
    ),

    array(
        "type" => "dropdown",
        "heading" => __("Icon animation", "js_composer"),
        "param_name" => "btn_icon_animation",
        "admin_label" => false,
        "value" => array_flip(array(
            ""            => "No",
            "yes"        => "Yes"
        )),
        "dependency" => array(
            "element" => "btn_icon",
            "not_empty" => true
        ),
    ),

    array(
        "type" => "checkbox",
        "heading" => __( "Full width Button", "pixfort-core" ),
        "param_name" => "btn_full",
        "value" => __( "Yes", "pixfort-core" ),
    ),


    array (
        'param_name' 	=> 'btn_text_align',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Button Text Align', 'pixfort-core'),
        'admin_label'	=> false,
        'value'			=> array_flip(array(
            'text-center' 		=> 'Center',
            'text-left' 		=> 'Start',
            'text-right' 		=> 'End',
        )),
        "dependency" => array(
            "element" => "btn_full",
            "not_empty" => true
        ),
    ),

    array (
        'param_name' 	=> 'btn_div',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Button inside a container', 'pixfort-core'),
        "description" => __( "if enabled, other elements won't show on the same line.", "js_composer"),
        'admin_label'	=> false,
        'value'			=> array_flip(array(
            '' 		=> 'Disabled',
            'text-center' 		=> 'Center align',
            'text-left' 		=> 'Start',
            'text-right' 		=> 'End',
        )),
    ),


    array (
        'param_name' 	=> 'btn_animation',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Animation', 'pixfort-core'),
        'description' 	=> __('Select the animation of the heading.', 'pixfort-core'),
        'admin_label'	=> false,
        'value'			=> pix_get_animations(),
    ),

    array (
        'param_name' 	=> 'btn_anim_delay',
        'type' 			=> 'textfield',
        'heading' 		=> __('Animation delay (in miliseconds)', 'pixfort-core'),
        'admin_label'	=> true,
        "dependency" => array(
            "element" => "btn_animation",
            "not_empty" => true
        ),
    ),

    array (
        'param_name' 	=> 'btn_id',
        'type' 			=> 'textfield',
        'heading' 		=> __('Button ID', 'pixfort-core'),
        'group'         => "Advanced",
        'settings' => array(
            'auto_generate' => true,
        ),
    ),
    array (
        'param_name' 	=> 'btn_class',
        'type' 			=> 'textfield',
        'heading' 		=> __('Button Extra Classes', 'pixfort-core'),
        'group'         => "Advanced",
    ),

);


vc_map( array (
    'base' 			=> 'pix_button',
    'name' 			=> __('Button', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/button.png',
    'description' 	=> __('Add customized button', 'pixfort-core'),
    'params' 		=> array_merge(
        $button_params,
        array(
            array(
                'type' => 'css_editor',
                'heading' => __( 'Css', 'pixfort-core' ),
                'param_name' => 'css',
                'group' => __( 'Design options', 'pixfort-core' ),
            )
        )

    )

));

?>
