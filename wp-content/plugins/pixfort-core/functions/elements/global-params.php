<?php

$animation_params = array(
    array(
        "type" => "dropdown",
        "heading" => __("Animation", "js_composer"),
        "param_name" => "animation",
        "admin_label" => true,
        "value" => pix_get_animations(),
        'save_always' => true,
        "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
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
    )
);
$effects_params = array (
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
        "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
    ),
);


$infinite_animation = array(
    "None"                  => "",
    "Rotating"              => "pix-rotating",
    "Rotating inversed"     => "pix-rotating-inverse",
    "Fade"                  => "pix-fade",
    "Bounce Small"          => "pix-bounce-sm",
    "Bounce Medium" 		=> "pix-bounce-md",
    "Bounce Large" 			=> "pix-bounce-lg",
    "Scale Small"           => "pix-scale-sm",
    "Scale Medium"           => "pix-scale-md",
    "Scale Large"           => "pix-scale-lg",

);
$animation_speeds = array(
    "Fast" 			=> "pix-duration-fast",
    "Medium" 		=> "pix-duration-md",
    "Slow" 			=> "pix-duration-slow",
);

?>
