<?php

$pix_overlay_color_array = array_merge(
    array("None" => ''),
    $bg_colors,
    array("Custom Gradient" => 'custom-gradient')
);

$pix_vc_column_params = array(


    array(
        "type" => "checkbox",
        "heading" => __("Enable dark mode (Deprecated)", "pixfort-core"),
        "param_name" => "pix_dark_mode",
        "std" => "",
        "value" => array_flip(array(
            "yes"             => "Yes"
        )),
    ),
    array(
        'param_name'     => 'content_align',
        'type'             => 'dropdown',
        'heading'         => __('Content align', 'pixfort-core'),
        // 'description' 	=> __('Select the position of the image.', 'pixfort-core'),
        'admin_label'    => false,
        'value'            => array_flip(array(
            'text-left'            => 'Start',
            'text-center'        => 'Center',
            'text-right'         => 'End',
        )),
    ),

    array(
        "type" => "checkbox",
        "heading" => __("Enable Particles", "pixfort-core"),
        "param_name" => "pix_particles_check",
        "group"    => "Particles",
        // "std" => "",
        "value" => array(
            "Yes" => "1"
        ),
        "description" => __("Enable animated images in the background.", "pixfort-core")
    ),
    array(
        'type' => 'param_group',
        'value' => '',
        'param_name' => 'pix_particles',
        "group"    => "Particles",
        'heading'         => __('Particles', 'pixfort-core'),
        // 'description' 	=> __('Add parallax floating images in the background of the section.', 'pixfort-core'),
        "dependency" => array(
            "element" => "pix_particles_check",
            "value" => "1"
        ),
        // Note params is mapped inside param-group:
        'params' => array(
            array(
                'param_name'     => 'image',
                'type'             => 'attach_image',
                'heading'         => __('Image', 'pixfort-core'),
                'admin_label'    => false,
            ),

            array(
                "type" => "dropdown",
                "heading" => __("Horizontal Position", "pixfort-core"),
                "param_name" => "h_position",
                "value" => array_flip(array(
                    "left"             => "Left",
                    "right"       => "Right"
                )),
                "description" => __("Please select the horizontal origin of the alignment.", "pixfort-core")
            ),
            array(
                'param_name'     => 'horizontal',
                'type'             => 'textfield',
                'heading'         => __('Horizontal value', 'pixfort-core'),
                "description" => __("Please input the value (with the unit: %, px,.. etc).", "pixfort-core"),
                'admin_label'    => false,
                'value'        => '0',
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Vertical Position", "pixfort-core"),
                "param_name" => "v_position",
                "value" => array_flip(array(
                    "top"             => "Top",
                    "bottom"       => "Bottom"
                )),
                "description" => __("Please select the horizontal origin of the alignment.", "pixfort-core")
            ),
            array(
                'param_name'     => 'vertical',
                'type'             => 'textfield',
                'heading'         => __('Vertical value', 'pixfort-core'),
                "description" => __("Please input the value (with the unit: %, px,.. etc).", "pixfort-core"),
                'admin_label'    => false,
                'value'        => '0',
            ),
            array(
                "type" => "checkbox",
                "heading" => __("Animation type", "pixfort-core"),
                "param_name" => "pix_particles_type",
                "std" => "",
                "value" => array_flip(array(
                    "scroll_parallax"       => "Scroll Parallax",
                    // "mouse_parallax" 			=> "Mouse Parallax"
                )),
            ),
            array(
                "type" => "checkbox",
                "std" => "",
                // "heading" => __( "Animation type", "pixfort-core" ),
                "param_name" => "pix_particles_type_2",
                "value" => array_flip(array(
                    // "scroll_parallax"       => "Scroll Parallax",
                    "mouse_parallax"             => "Mouse Parallax"
                )),
            ),
            array(
                "type" => "checkbox",
                "std" => "",
                "param_name" => "pix_particles_type_3",
                "value" => array_flip(array(
                    "scroll_rotate"             => "Scroll rotate"
                )),
            ),





            array(
                'param_name'     => 'depth',
                'type'             => 'textfield',
                'heading'         => __('Parallax Depth', 'pixfort-core'),
                'admin_label'    => false,
                'std'            => '0.2',
                "description" => __("Depth value is between 0 and 1.", "pixfort-core"),
                "dependency" => array(
                    "element" => "pix_particles_type_2",
                    "value" => "mouse_parallax"
                ),
            ),

            array(
                'param_name'     => 'xaxis',
                'type'             => 'textfield',
                'heading'         => __('Vertical Parallax', 'pixfort-core'),
                'admin_label'    => false,
                'value'            => '100',
                "dependency" => array(
                    "element" => "pix_particles_type",
                    "value" => "scroll_parallax"
                ),
            ),
            array(
                'param_name'     => 'yaxis',
                'type'             => 'textfield',
                'heading'         => __('Horizontal Parallax', 'pixfort-core'),
                'admin_label'    => false,
                'std'            => '0',
                "dependency" => array(
                    "element" => "pix_particles_type",
                    "value" => "scroll_parallax"
                ),
            ),

            array(
                'param_name'     => 'rotation_speed',
                'type'             => 'textfield',
                'heading'         => __('Roatation speed', 'pixfort-core'),
                'admin_label'    => false,
                'std'            => '300',
                "description" => __("A bigger number is a slower speed.", "pixfort-core"),
                "dependency" => array(
                    "element" => "pix_particles_type_3",
                    "value" => "scroll_rotate"
                ),
            ),

            array(
                "type" => "checkbox",
                "std" => "",
                "heading" => __("Inverse rotation direction", "pixfort-core"),
                "param_name" => "pix_inverse_rotation",
                "value" => array_flip(array(
                    "scroll_inverse"       => "Yes",
                )),
                "dependency" => array(
                    "element" => "pix_particles_type_3",
                    "value" => "scroll_rotate"
                ),
            ),


            array(
                'param_name'     => 'img_width',
                'type'             => 'textfield',
                'heading'         => __('Image width', 'pixfort-core'),
                'admin_label'    => false,
            ),



            array(
                'param_name'     => 'animation',
                'type'             => 'dropdown',
                'heading'         => __('Start Animation', 'pixfort-core'),
                // 'description' 	=> __('Select the animation of the heading.', 'pixfort-core'),
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
                "type" => "dropdown",
                "heading" => __("Infinite Animation type", "pixfort-core"),
                "param_name" => "pix_infinite_animation",
                "value" => $infinite_animation,
                'admin_label'    => false,
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Infinite Animation Speed", "pixfort-core"),
                "param_name" => "pix_infinite_speed",
                "value" => $animation_speeds,
                'admin_label'    => false,
                "dependency" => array(
                    "element" => "pix_infinite_animation",
                    "not_empty" => true
                ),
            ),


            array(
                "type" => "checkbox",
                "std" => "",
                "heading" => __("Hide on mobile", "pixfort-core"),
                "param_name" => "hide",
                "value" => __("1", "pixfort-core"),
                "description" => __("Hide the element on mobile devices.", "pixfort-core")
            ),

        )
    ),


    array(
        'param_name'     => 'pix_overlay_color',
        'type'             => 'dropdown',
        'heading'         => __('Overlay color', 'pixfort-core'),
        'admin_label'    => false,
        "group"    => esc_html__('Design Options', 'pixfort-core'),
        'value'         => $pix_overlay_color_array,
    ),
);



$pix_vc_column_params = array_merge(
    $pix_vc_column_params,
    array(
        array(
            'param_name'     => 'pix_custom_gradient',
            'type'             => 'pix_gradient_picker',
            'heading'         => __('Gradient custom picker', 'pixfort-core'),
            "dependency" => array(
                "element" => "pix_overlay_color",
                "value" => 'custom-gradient'
            ),
            "group"    => esc_html__('Design Options', 'pixfort-core'),
        ),
        array(
            "type" => "checkbox",
            "heading" => __("Display overlay over content", "pixfort-core"),
            "param_name" => "pix_overlay_over",
            "value" => false,
            "group"    => esc_html__('Design Options', 'pixfort-core'),
        ),
    )
);

$pix_vc_column_params = array_merge(
    $pix_vc_column_params,
    array(
        array(
            'type'        => 'colorpicker',
            'heading'     => esc_html__('Custom overlay color', 'pixfort-core'),
            'param_name'  => 'pix_overlay_custom_color',
            'value'       => '#ffffff',
            "dependency" => array(
                "element" => "pix_overlay_color",
                "value" => 'custom'
            ),
            "group"    => esc_html__('Design Options', 'pixfort-core'),
        ),
    
        array(
            'param_name'     => 'pix_overlay_opacity',
            'type'             => 'textfield',
            'heading'         => __('Overlay opacity', 'pixfort-core'),
            "description" => __("The opacity value should be between 0 and 1.", "pixfort-core"),
            'admin_label'    => false,
            "group"    => esc_html__('Design Options', 'pixfort-core'),
            "dependency" => array(
                "element" => "pix_overlay_color",
                "not_empty" => true
            ),
        ),
    
    
        array(
            'type' => 'pix_responsive_css',
            'heading' => __('Responsive options', 'pixfort-core'),
            'param_name' => 'responsive_css',
            'group' => __('Design Options', 'pixfort-core'),
            "description" => __("Input responsive values to override Desktop settings.<br />Note: Tablet landscape preview in WPBakery uses the Desktop values.", "pixfort-core"),
            'value'   => '{}'
        ),
    )
);

$pix_fade_mask_params = array();
if (defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG !== 'essentials') {
    $pix_fade_mask_params = array(
        array(
            "type" => "checkbox",
            "heading" => __("Fade mask", "pixfort-core"),
            "param_name" => "pix_fade_mask",
            "value" => array(
                "Yes" => "yes"
            ),
            "group"    => esc_html__('Design Options', 'pixfort-core'),
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Mask Sides", "pixfort-core"),
            "param_name" => "pix_fade_mask_sides",
            "std" => "0",
            "value" => array(
                __("Two Sides", "pixfort-core") => "0",
                __("One Side", "pixfort-core") => "1",
            ),
            "dependency" => array(
                "element" => "pix_fade_mask",
                "not_empty" => true
            ),
            "group"    => esc_html__('Design Options', 'pixfort-core'),
        ),
        array(
            'param_name'     => 'pix_fade_mask_value',
            'type'             => 'textfield',
            'heading'         => __('Fade value', 'pixfort-core'),
            'description'     => __('Input fade value with unit (for example: 20% or 40px).', 'pixfort-core'),
            'std'            => '20%',
            "dependency" => array(
                "element" => "pix_fade_mask",
                "not_empty" => true
            ),
            "group"    => esc_html__('Design Options', 'pixfort-core'),
        ),
        array(
            'param_name'     => 'pix_fade_mask_alpha',
            'type'             => 'textfield',
            'heading'         => __('Mask alpha', 'pixfort-core'),
            'description'     => __('Input a value between 0 and 1.', 'pixfort-core'),
            'std'            => '0',
            "dependency" => array(
                "element" => "pix_fade_mask",
                "not_empty" => true
            ),
            "group"    => esc_html__('Design Options', 'pixfort-core'),
        ),
        array(
            'param_name'     => 'pix_fade_mask_rotation',
            'type'             => 'textfield',
            'heading'         => __('Mask Rotation Degree', 'pixfort-core'),
            'description'     => __('Input rotation with unit (for example: 90deg).', 'pixfort-core'),
            'std'            => '90deg',
            "dependency" => array(
                "element" => "pix_fade_mask",
                "not_empty" => true
            ),
            "group"    => esc_html__('Design Options', 'pixfort-core'),
        ),
    );
    $pix_vc_column_params = array_merge($pix_vc_column_params, $pix_fade_mask_params);
}

vc_add_params('vc_column', $pix_vc_column_params);
if (!empty($pix_fade_mask_params)) {
    vc_add_params('vc_column_inner', $pix_fade_mask_params);
}
