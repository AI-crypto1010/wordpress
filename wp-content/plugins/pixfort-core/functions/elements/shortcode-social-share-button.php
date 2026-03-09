<?php

// Social Share Button -----------------------------

vc_map(array(
    'base'             => 'pix-social-share-button',
    'name'             => __('Social Share Button', 'pixfort-core'),
    'category'         => __('pixfort', 'pixfort-core'),
    "weight"    => "1000",
    'class'         => 'pixfort_element',
    'icon'             => PIX_CORE_PLUGIN_URI . 'functions/images/elements/social-share-button.webp',
    'description'     => __('Add social media share button', 'pixfort-core'),
    'params'         => array(

        array(
            "type" => "dropdown",
            "heading" => __("Social Network", "pixfort-core"),
            "param_name" => "social_type",
            "value" => array(
                __('Facebook', 'pixfort-core') => 'facebook',
                __('X (Twitter)', 'pixfort-core') => 'x',
                __('LinkedIn', 'pixfort-core') => 'linkedin',
                __('Pinterest', 'pixfort-core') => 'pinterest',
                __('WhatsApp', 'pixfort-core') => 'whatsapp',
                __('Email', 'pixfort-core') => 'email',
                // __('Custom', 'pixfort-core') => 'custom',
            ),
            'std' => 'facebook',
            "description" => __("Select the social network type.", "pixfort-core"),
        ),

        array(
            "type" => "textfield",
            "heading" => __("Button text", "pixfort-core"),
            "param_name" => "text",
            "value" => __('Share on Facebook', 'pixfort-core'),
            "description" => __("Optional text to display next to the icon. Leave empty to show icon only.", "pixfort-core"),
        ),

        array(
            'type' => 'pixfort_icons_picker',
            'heading' => __('Icon', 'pixfort-core'),
            'param_name' => 'icon',
            'settings' => array(
                'emptyIcon' => true,
                'type' => 'pix-icons',
                'iconsPerPage' => 200,
            ),
            'std' => 'Solid/pixfort-icon-facebook-1',
            // 'description' => __( 'Select icon from library. Leave empty to use default icon for the social network.', 'pixfort-core' ),
        ),

        array(
            "type" => "dropdown",
            "heading" => __("Text Color", "pixfort-core"),
            "param_name" => "text_color",
            "value" => array_flip(array(
                "body-default" => __("Body default", "pixfort-core"),
                "heading-default" => __("Heading default", "pixfort-core"),
                "primary" => __("Primary", "pixfort-core"),
                "secondary" => __("Secondary", "pixfort-core"),
                "white" => __("White", "pixfort-core"),
                "black" => __("Black", "pixfort-core"),
                "green" => __("Green", "pixfort-core"),
                "blue" => __("Blue", "pixfort-core"),
                "red" => __("Red", "pixfort-core"),
                "yellow" => __("Yellow", "pixfort-core"),
                "brown" => __("Brown", "pixfort-core"),
                "purple" => __("Purple", "pixfort-core"),
                "orange" => __("Orange", "pixfort-core"),
                "cyan" => __("Cyan", "pixfort-core"),
                "custom" => __("Custom", "pixfort-core"),
            )),
            'std' => 'body-default',
            "description" => __("Select the color of the button text.", "pixfort-core"),
        ),

        array(
            "type" => "colorpicker",
            "heading" => __("Custom text color", "pixfort-core"),
            "param_name" => "text_custom_color",
            "value" => "",
            'dependency' => array(
                'element' => 'text_color',
                'value' => array('custom'),
            ),
        ),

        array(
            "type" => "dropdown",
            "heading" => __("Icon Color", "pixfort-core"),
            "param_name" => "icon_color",
            "value" => array_flip(array(
                "" => __("Default", "pixfort-core"),
                "body-default" => __("Body default", "pixfort-core"),
                "heading-default" => __("Heading default", "pixfort-core"),
                "primary" => __("Primary", "pixfort-core"),
                "secondary" => __("Secondary", "pixfort-core"),
                "white" => __("White", "pixfort-core"),
                "black" => __("Black", "pixfort-core"),
                "green" => __("Green", "pixfort-core"),
                "blue" => __("Blue", "pixfort-core"),
                "red" => __("Red", "pixfort-core"),
                "yellow" => __("Yellow", "pixfort-core"),
                "brown" => __("Brown", "pixfort-core"),
                "purple" => __("Purple", "pixfort-core"),
                "orange" => __("Orange", "pixfort-core"),
                "cyan" => __("Cyan", "pixfort-core"),
                "custom" => __("Custom", "pixfort-core"),
            )),
            'std' => '',
            "description" => __("Select the color of the icon.", "pixfort-core"),
        ),

        array(
            "type" => "colorpicker",
            "heading" => __("Custom icon color", "pixfort-core"),
            "param_name" => "icon_custom_color",
            "value" => "",
            'dependency' => array(
                'element' => 'icon_color',
                'value' => array('custom'),
            ),
        ),

        // array(
        //     "type" => "dropdown",
        //     "heading" => __("Position", "pixfort-core"),
        //     "param_name" => "position",
        //     "value" => array(
        //         __('Start', 'pixfort-core') => 'start',
        //         __('Center', 'pixfort-core') => 'center',
        //         __('End', 'pixfort-core') => 'end',
        //     ),
        //     'std' => 'center',
        //     "description" => __("Select the alignment of the button.", "pixfort-core"),
        // ),

        array(
            "type" => "dropdown",
            "heading" => __("Animation", "pixfort-core"),
            "param_name" => "animation",
            "value" => pix_get_animations(),
            "description" => __("Select the animation of the element.", "pixfort-core"),
        ),

        array(
            "type" => "textfield",
            "heading" => __("Animation delay", "pixfort-core"),
            "param_name" => "delay",
            "value" => "0",
            "description" => __("Enter animation delay in milliseconds.", "pixfort-core"),
            'dependency' => array(
                'element' => 'animation',
                'not_empty' => true,
            ),
        ),

        // Icon Size Control
        array(
            "type" => "textfield",
            "heading" => __("Icon Size", "pixfort-core"),
            "param_name" => "icon_size",
            "value" => "24",
            'group' => __('Style', 'pixfort-core'),
            "description" => __("Enter icon size in pixels (default: 24).", "pixfort-core"),
        ),

        // Background Color Controls
        array(
            "type" => "dropdown",
            "heading" => __("Background Color", "pixfort-core"),
            "param_name" => "bg_color",
            'value' 		=> $bg_colors,
            'group' => __('Style', 'pixfort-core'),
            "description" => __("Select the background color of the button.", "pixfort-core"),
        ),

        array(
            "type" => "colorpicker",
            "heading" => __("Custom Background Color", "pixfort-core"),
            "param_name" => "custom_bg_color",
            "value" => "",
            'group' => __('Style', 'pixfort-core'),
            'dependency' => array(
                'element' => 'bg_color',
                'value' => array('custom'),
            ),
        ),

        // Shadow Controls
        array(
            "type" => "dropdown",
            "heading" => __("Shadow Style", "pixfort-core"),
            "param_name" => "style",
            "value" => array(
                __('Default', 'pixfort-core') => "",
                __('Small shadow', 'pixfort-core') => "1",
                __('Medium shadow', 'pixfort-core') => "2",
                __('Large shadow', 'pixfort-core') => "3",
                __('Inverse Small shadow', 'pixfort-core') => "4",
                __('Inverse Medium shadow', 'pixfort-core') => "5",
                __('Inverse Large shadow', 'pixfort-core') => "6",
            ),
            'group' => __('Style', 'pixfort-core'),
            "description" => __("Select the shadow style for the button.", "pixfort-core"),
        ),

        array(
            "type" => "dropdown",
            "heading" => __("Shadow Hover Style", "pixfort-core"),
            "param_name" => "hover_effect",
            "value" => array(
                __('None', 'pixfort-core') => "",
                __('Small hover shadow', 'pixfort-core') => "1",
                __('Medium hover shadow', 'pixfort-core') => "2",
                __('Large hover shadow', 'pixfort-core') => "3",
                __('Inverse Small hover shadow', 'pixfort-core') => "4",
                __('Inverse Medium hover shadow', 'pixfort-core') => "5",
                __('Inverse Large hover shadow', 'pixfort-core') => "6",
            ),
            'group' => __('Style', 'pixfort-core'),
            "description" => __("Select the shadow style for hover state.", "pixfort-core"),
        ),

        array(
            "type" => "dropdown",
            "heading" => __("Hover Animation", "pixfort-core"),
            "param_name" => "add_hover_effect",
            "value" => array(
                __('None', 'pixfort-core') => "",
                __('Fly Small', 'pixfort-core') => "1",
                __('Fly Medium', 'pixfort-core') => "2",
                __('Fly Large', 'pixfort-core') => "3",
                __('Scale Small', 'pixfort-core') => "4",
                __('Scale Medium', 'pixfort-core') => "5",
                __('Scale Large', 'pixfort-core') => "6",
                __('Scale Inverse Small', 'pixfort-core') => "7",
                __('Scale Inverse Medium', 'pixfort-core') => "8",
                __('Scale Inverse Large', 'pixfort-core') => "9",
            ),
            'group' => __('Style', 'pixfort-core'),
            "description" => __("Select the hover animation for the button.", "pixfort-core"),
        ),

        // Layout Controls
        array(
            "type" => "dropdown",
            "heading" => __("Justify Content", "pixfort-core"),
            "param_name" => "justify_content",
            "value" => array(
                __('Start', 'pixfort-core') => 'start',
                __('Center', 'pixfort-core') => 'center',
                __('End', 'pixfort-core') => 'end',
                __('Space Between', 'pixfort-core') => 'between',
                __('Space Around', 'pixfort-core') => 'around',
                // __('Space Evenly', 'pixfort-core') => 'space-evenly',
            ),
            'std' => 'center',
            'group' => __('Layout', 'pixfort-core'),
            "description" => __("Select how to justify content within the button.", "pixfort-core"),
        ),

        array(
            "type" => "textfield",
            "heading" => __("Gap", "pixfort-core"),
            "param_name" => "gap",
            "value" => "",
            'group' => __('Layout', 'pixfort-core'),
            "description" => __("Enter gap between elements in pixels (e.g., 10).", "pixfort-core"),
        ),

        array(
            "type" => "textfield",
            "heading" => __("Button Padding", "pixfort-core"),
            "param_name" => "button_padding",
            "value" => "",
            'group' => __('Layout', 'pixfort-core'),
            "description" => __("Enter button padding (e.g., 10px 15px 10px 15px).", "pixfort-core"),
        ),

        array(
            'type' => 'css_editor',
            'heading' => __('Css', 'pixfort-core'),
            'param_name' => 'css',
            'group' => __('Design options', 'pixfort-core'),
        )

    )

));
