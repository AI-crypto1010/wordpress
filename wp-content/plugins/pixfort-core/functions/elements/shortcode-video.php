<?php
$pix_video_params = array_merge(
    array(
        array(
            'param_name'     => 'image',
            'type'             => 'attach_image',
            'heading'         => __('Placeholder Image', 'pixfort-core'),
            'admin_label'    => false,
        ),
        ...( \PixfortCore::instance()->getThemeParam('dynamic_wpb_images') ? [
            array(
                'param_name' 	=> 'dynamic_image',
                'type' 			=> 'pix_dynamic_image',
                'heading' 		=> __('Dynamic image source', 'pixfort-core'),
                'description' 	=> __('Select a dynamic image source (optional). If image is not available, the normal image will be used.', 'pixfort-core'),
            ),
        ] : [] ),
        array(
            'param_name'     => 'embed_code',
            'type'             => 'textarea_raw_html',
            'heading'         => __('Embed Code', 'pixfort-core'),
            'admin_label'    => false,
        ),
        array(
            'param_name'     => 'aspect',
            'type'             => 'dropdown',
            'heading'         => __('Aspect ratio', 'pixfort-core'),
            'admin_label'    => false,
            'value'         => array(
                __('21:9 aspect ratio', 'pixfort-core')         => 'embed-responsive-21by9',
                __('16:9 aspect ratio', 'pixfort-core')        => 'embed-responsive-16by9',
                __('4:3 aspect ratio', 'pixfort-core')        => 'embed-responsive-4by3',
                __('1:1 aspect ratio', 'pixfort-core')        => 'embed-responsive-1by1',
                __('9:16 aspect ratio', 'pixfort-core')        => 'embed-responsive-9by16'
            )
        ),
        array(
            "type" => "checkbox",
            "heading" => __("Open in a popup", "pixfort-core"),
            "param_name" => "in_popup",
            "value" => array_flip(array(
                '1'       => "Yes",
            )),
        ),
        array(
            'param_name'     => 'popup_aspect',
            'type'             => 'dropdown',
            'heading'         => __('Popup Aspect ratio', 'pixfort-core'),
            'admin_label'    => false,
            'value'         => array(
                __('Default', 'pixfort-core')     => 'default',
                __('21:9 aspect ratio', 'pixfort-core')         => 'embed-responsive-21by9',
                __('16:9 aspect ratio', 'pixfort-core')        => 'embed-responsive-16by9',
                __('4:3 aspect ratio', 'pixfort-core')        => 'embed-responsive-4by3',
                __('1:1 aspect ratio', 'pixfort-core')        => 'embed-responsive-1by1',
                __('9:16 aspect ratio', 'pixfort-core')        => 'embed-responsive-9by16',
            ),
            "dependency" => array(
                "element" => "in_popup",
                "not_empty" => true
            ),
        ),
        array(
            'param_name'     => 'rounded_img',
            'type'             => 'dropdown',
            'heading'         => __('Rounded corners', 'pixfort-core'),
            'admin_label'    => false,
            'value'         => array(
                __('No', 'pixfort-core')     => 'rounded-0',
                __('Rounded', 'pixfort-core')        => 'rounded',
                __('Rounded Large', 'pixfort-core')        => 'rounded-lg',
                __('Rounded 5px', 'pixfort-core')        => 'rounded-xl',
                __('Rounded 10px', 'pixfort-core')        => 'rounded-10',
            )
        ),
        array(
            "type" => "checkbox",
            "heading" => __("Animation type", "pixfort-core"),
            "param_name" => "pix_scroll_parallax",
            "value" => array_flip(array(
                "scroll_parallax"       => "Scroll Parallax",
            )),
        ),
        array(
            "type" => "checkbox",
            "param_name" => "pix_tilt",
            "value" => array_flip(array(
                "tilt"       => "3D Hover",
            )),
        ),
        array(
            'param_name'     => 'xaxis',
            'type'             => 'textfield',
            'heading'         => __('Vertical Parallax', 'pixfort-core'),
            'admin_label'    => false,
            'std'            => '100',
            "dependency" => array(
                "element" => "pix_scroll_parallax",
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
                "element" => "pix_scroll_parallax",
                "value" => "scroll_parallax"
            ),
        ),
        array(
            'param_name'     => 'pix_tilt_size',
            'type'             => 'dropdown',
            'heading'         => __('3d hover size', 'pixfort-core'),
            'admin_label'    => false,
            'value'            => array_flip(array(
                'tilt'            => 'Default',
                'tilt_big'        => 'Big',
                'tilt_small'         => 'Small',
            )),
            "dependency" => array(
                "element" => "pix_tilt",
                "not_empty" => true
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
            'param_name'     => 'text_color',
            'type'             => 'dropdown',
            'heading'         => __('Icon color', 'pixfort-core'),
            'admin_label'    => false,
            'group' => __('Advanced', 'pixfort-core'),
            'value'         => $colors_no_custom,
            'std'           => 'primary'
        ),
        array(
            'param_name'     => 'bg_color',
            'type'             => 'dropdown',
            'heading'         => __('Background color', 'pixfort-core'),
            'admin_label'    => false,
            'value'         => $bg_colors,
            'std'            => 'white',
            'group' => __('Advanced', 'pixfort-core'),
        ),
        array(
            'param_name'     => 'custom_bg_color',
            'type'             => 'colorpicker',
            'heading'         => __('Custom Background Color', 'pixfort-core'),
            'admin_label'    => false,
            'group' => __('Advanced', 'pixfort-core'),
            "dependency" => array(
                "element" => "bg_color",
                "value" => "custom"
            ),
        ),
        array(
            'param_name'     => 'size',
            'type'             => 'textfield',
            'heading'         => __('Button size', 'pixfort-core'),
            'description'         => __('Input the size in pixels (without writing the unit.)', 'pixfort-core'),
            'admin_label'    => true,
            'std'           => '100',
            'group' => __('Advanced', 'pixfort-core'),
        ),
        array(
            'param_name'     => 'icon_style',
            'type'             => 'dropdown',
            'heading'         => __('Icon style', 'pixfort-core'),
            'admin_label'    => false,
            'group' => __('Advanced', 'pixfort-core'),
            'value'         => array(
                __('Filled', 'pixfort-core')        => 'due',
                __('Outline', 'pixfort-core')         => 'line',
            )
        ),
        array(
            'param_name'     => 'overlay_color',
            'type'             => 'dropdown',
            'heading'         => __('Hover overlay color', 'pixfort-core'),
            'admin_label'    => false,
            'group'         => 'Advanced',
            'value'         => $colors,
            'std'            => 'black',
        ),
        array(
            'param_name'     => 'overlay_custom_color',
            'type'             => 'colorpicker',
            'heading'         => __('Custom hover overlay color', 'pixfort-core'),
            'admin_label'    => false,
            'group'         => 'Advanced',
            "dependency" => array(
                "element" => "overlay_color",
                "value" => "custom"
            ),
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Overlay opacity", "pixfort-core"),
            "param_name" => "overlay_opacity",
            'group'         => 'Advanced',
            "std"      => 'pix-opacity-8',
            "value" => array_flip(array(
                "pix-opacity-10"             => "0%",
                "pix-opacity-9"             => "10%",
                "pix-opacity-8"             => "20%",
                "pix-opacity-7"             => "30%",
                "pix-opacity-6"             => "40%",
                "pix-opacity-5"             => "50%",
                "pix-opacity-4"             => "60%",
                "pix-opacity-3"             => "70%",
                "pix-opacity-2"             => "80%",
                "pix-opacity-1"             => "90%",

            )),
        ),
        
        array(
            'type' => 'css_editor',
            'heading' => __('Css', 'pixfort-core'),
            'param_name' => 'css',
            'group' => __('Design options', 'pixfort-core'),
        ),
    ),
    $effects_params
);

$pix_video_params = array_merge(
    array(
        array(
            'param_name'     => 'video_placeholder_type',
            'type'             => 'dropdown',
            'heading'         => __('Video Placeholder type', 'pixfort-core'),
            'admin_label'    => false,
            'value'            => array_flip(array(
                'image'            => 'Default (image)',
                'video'        => 'MP4 Video'
            )),

        ),
        array(
            'param_name'     => 'image',
            'type'             => 'attach_image',
            'heading'         => __('Placeholder Image', 'pixfort-core'),
            'admin_label'    => false,
            "dependency" => array(
                "element" => "video_placeholder_type",
                "value" => 'image'
            ),
        ),
        ...( \PixfortCore::instance()->getThemeParam('dynamic_wpb_images') ? [
            array(
                'param_name' 	=> 'dynamic_image',
                'type' 			=> 'pix_dynamic_image',
                'heading' 		=> __('Dynamic image source', 'pixfort-core'),
                'description' 	=> __('Select a dynamic image source (optional). If image is not available, the normal image will be used.', 'pixfort-core'),
                "dependency" => array(
                    "element" => "video_placeholder_type",
                    "value" => 'image'
                ),
            ),
        ] : [] ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Placeholder MP4 Video URL', 'pixfort-core'),
            'param_name' => 'placeholder_video',
            'value' => '',
            'admin_label' => true,
            'description' => 'You can upload the video via the media area in admin dashboard, or add an external video URL.',
            "dependency" => array(
                "element" => "video_placeholder_type",
                "value" => 'video'
            ),
        ),
        array(
            'param_name'     => 'embed_code',
            'type'             => 'textarea_raw_html',
            'heading'         => __('Embed Code', 'pixfort-core'),
            'admin_label'    => false,
        ),
        array(
            'param_name'     => 'aspect',
            'type'             => 'dropdown',
            'heading'         => __('Aspect ratio', 'pixfort-core'),
            'admin_label'    => false,
            'value'         => array(
                __('21:9 aspect ratio', 'pixfort-core')         => 'embed-responsive-21by9',
                __('16:9 aspect ratio', 'pixfort-core')        => 'embed-responsive-16by9',
                __('4:3 aspect ratio', 'pixfort-core')        => 'embed-responsive-4by3',
                __('1:1 aspect ratio', 'pixfort-core')        => 'embed-responsive-1by1',
                __('9:16 aspect ratio', 'pixfort-core')        => 'embed-responsive-9by16'
            )
        ),
        array(
            "type" => "checkbox",
            "heading" => __("Open in a popup", "pixfort-core"),
            "param_name" => "in_popup",
            "value" => array_flip(array(
                '1'       => "Yes",
            )),
        ),
        array(
            'param_name'     => 'popup_aspect',
            'type'             => 'dropdown',
            'heading'         => __('Popup Aspect ratio', 'pixfort-core'),
            'admin_label'    => false,
            'value'         => array(
                __('Default', 'pixfort-core')     => 'default',
                __('21:9 aspect ratio', 'pixfort-core')         => 'embed-responsive-21by9',
                __('16:9 aspect ratio', 'pixfort-core')        => 'embed-responsive-16by9',
                __('4:3 aspect ratio', 'pixfort-core')        => 'embed-responsive-4by3',
                __('1:1 aspect ratio', 'pixfort-core')        => 'embed-responsive-1by1',
                __('9:16 aspect ratio', 'pixfort-core')        => 'embed-responsive-9by16',
            ),
            "dependency" => array(
                "element" => "in_popup",
                "not_empty" => true
            ),
        ),
        array(
            'param_name'     => 'rounded_img',
            'type'             => 'dropdown',
            'heading'         => __('Rounded corners', 'pixfort-core'),
            'admin_label'    => false,
            'value'         => array(
                __('No', 'pixfort-core')     => 'rounded-0',
                __('Rounded', 'pixfort-core')        => 'rounded',
                __('Rounded Large', 'pixfort-core')        => 'rounded-lg',
                __('Rounded 5px', 'pixfort-core')        => 'rounded-xl',
                __('Rounded 10px', 'pixfort-core')        => 'rounded-10',
            )
        ),
        array(
            "type" => "checkbox",
            "heading" => __("Animation type", "pixfort-core"),
            "param_name" => "pix_scroll_parallax",
            "value" => array_flip(array(
                "scroll_parallax"       => "Scroll Parallax",
            )),
        ),
        array(
            "type" => "checkbox",
            "param_name" => "pix_tilt",
            "value" => array_flip(array(
                "tilt"       => "3D Hover",
            )),
        ),
        array(
            'param_name'     => 'xaxis',
            'type'             => 'textfield',
            'heading'         => __('Vertical Parallax', 'pixfort-core'),
            'admin_label'    => false,
            'std'            => '100',
            "dependency" => array(
                "element" => "pix_scroll_parallax",
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
                "element" => "pix_scroll_parallax",
                "value" => "scroll_parallax"
            ),
        ),
        array(
            'param_name'     => 'pix_tilt_size',
            'type'             => 'dropdown',
            'heading'         => __('3d hover size', 'pixfort-core'),
            'admin_label'    => false,
            'value'            => array_flip(array(
                'tilt'            => 'Default',
                'tilt_big'        => 'Big',
                'tilt_small'         => 'Small',
            )),
            "dependency" => array(
                "element" => "pix_tilt",
                "not_empty" => true
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
            'param_name'     => 'text_color',
            'type'             => 'dropdown',
            'heading'         => __('Icon color', 'pixfort-core'),
            'admin_label'    => false,
            'group' => __('Advanced', 'pixfort-core'),
            'value'         => $colors_no_custom,
            'std'           => 'primary'
        ),
        array(
            'param_name'     => 'bg_color',
            'type'             => 'dropdown',
            'heading'         => __('Background color', 'pixfort-core'),
            'admin_label'    => false,
            'value'         => $bg_colors,
            'std'            => 'white',
            'group' => __('Advanced', 'pixfort-core'),
        ),
        array(
            'param_name'     => 'custom_bg_color',
            'type'             => 'colorpicker',
            'heading'         => __('Custom Background Color', 'pixfort-core'),
            'admin_label'    => false,
            'group' => __('Advanced', 'pixfort-core'),
            "dependency" => array(
                "element" => "bg_color",
                "value" => "custom"
            ),
        ),
        array(
            'param_name'     => 'size',
            'type'             => 'textfield',
            'heading'         => __('Button size', 'pixfort-core'),
            'description'         => __('Input the size in pixels (without writing the unit.)', 'pixfort-core'),
            'admin_label'    => true,
            'std'           => '100',
            'group' => __('Advanced', 'pixfort-core'),
        ),
        array(
            'param_name'     => 'icon_style',
            'type'             => 'dropdown',
            'heading'         => __('Icon style', 'pixfort-core'),
            'admin_label'    => false,
            'group' => __('Advanced', 'pixfort-core'),
            'value'         => array(
                __('Filled', 'pixfort-core')        => 'due',
                __('Outline', 'pixfort-core')         => 'line',
            )
        ),
        array(
            'param_name'     => 'overlay_color',
            'type'             => 'dropdown',
            'heading'         => __('Hover overlay color', 'pixfort-core'),
            'admin_label'    => false,
            'group'         => 'Advanced',
            'value'         => $colors,
            'std'            => 'black',
        ),
        array(
            'param_name'     => 'overlay_custom_color',
            'type'             => 'colorpicker',
            'heading'         => __('Custom hover overlay color', 'pixfort-core'),
            'admin_label'    => false,
            'group'         => 'Advanced',
            "dependency" => array(
                "element" => "overlay_color",
                "value" => "custom"
            ),
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Overlay opacity", "pixfort-core"),
            "param_name" => "overlay_opacity",
            'group'         => 'Advanced',
            "std"      => 'pix-opacity-8',
            "value" => array_flip(array(
                "pix-opacity-10"             => "0%",
                "pix-opacity-9"             => "10%",
                "pix-opacity-8"             => "20%",
                "pix-opacity-7"             => "30%",
                "pix-opacity-6"             => "40%",
                "pix-opacity-5"             => "50%",
                "pix-opacity-4"             => "60%",
                "pix-opacity-3"             => "70%",
                "pix-opacity-2"             => "80%",
                "pix-opacity-1"             => "90%",

            )),
        ),
        
        array(
            'type' => 'css_editor',
            'heading' => __('Css', 'pixfort-core'),
            'param_name' => 'css',
            'group' => __('Design options', 'pixfort-core'),
        ),
    ),
    $effects_params
);

// Video -----------------------------
vc_map(array(
    'base'             => 'pix_video',
    'name'             => __('Pix Video', 'pixfort-core'),
    'category'         => __('pixfort', 'pixfort-core'),
    'class'         => 'pixfort_element',
    "weight"    => "1000",
    'icon'             => PIX_CORE_PLUGIN_URI . 'functions/images/elements/video.png',
    'description'     => __('Display video element', 'pixfort-core'),
    'params'         => $pix_video_params
));
