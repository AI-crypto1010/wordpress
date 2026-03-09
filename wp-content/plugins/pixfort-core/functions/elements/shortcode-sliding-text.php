<?php

// Sliding text -----------------------------
$sliding_text_params = array(

    array(
        'param_name'     => 'content',
        'type'             => 'textarea',
        'heading'         => __('Text', 'pixfort-core'),
        'admin_label'    => true,
        'value'         => __('This is Sliding Text', 'pixfort-core'),
        'save_always' => true,
    ),

    array(
        "type" => "checkbox",
        "heading" => __("Title format", "pixfort-core"),
        "param_name" => "bold",
        "value" => array("Bold" => "font-weight-bold"),
        "std" => "font-weight-bold",
        'save_always' => true,
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
        "std" => "secondary-font",
        'save_always' => true,
    ),


    array(
        'param_name'     => 'position',
        'type'             => 'dropdown',
        'heading'         => __('Position', 'pixfort-core'),
        'description'     => __('Select the position of the heading.', 'pixfort-core'),
        'admin_label'    => false,
        'value'            => array_flip(array(
            'left'            => 'Start',
            'center'        => 'Center',
            'right'         => 'End',
        )),
    ),

    array(
        'param_name'     => 'size',
        'type'             => 'dropdown',
        'heading'         => __('Font size', 'pixfort-core'),
        'description'     => __('Select the size of the font.', 'pixfort-core'),
        'admin_label'    => false,
        'value'            => array_flip(array(
            'h1'        => 'H1',
            'h2'        => 'H2',
            'h3'         => 'H3',
            'h4'         => 'H4',
            'h5'         => 'H5',
            'h6'         => 'H6',
            'p'         => 'p',
        )),
    ),

    array(
        'param_name'     => 'display',
        'type'             => 'dropdown',
        'heading'         => __('Bigger Text', 'pixfort-core'),
        'description'     => __('Larger heading text size to stand out.', 'pixfort-core'),
        'admin_label'    => false,
        'value'            => array_flip(array(
            ''        => 'None',
            'display-1'        => 'Display 1',
            'display-2'        => 'Display 2',
            'display-3'        => 'Display 3',
            'display-4'        => 'Display 4',
        )),
    ),

    array(
        'param_name'     => 'custom_font_size',
        'type'             => 'textfield',
        'heading'         => __('Custom font size (Optional)', 'pixfort-core'),
        'description'     => __('Input custom font size value (with unit, for example: 20px)', 'pixfort-core'),
        'admin_label'    => false,
    ),

    array(
        'param_name'     => 'text_color',
        'type'             => 'dropdown',
        'heading'         => __('Title color', 'pixfort-core'),
        'admin_label'    => false,
        'value'         => $colors,
        'save_always' => true,
        'std' => 'heading-default',
    ),

    array(
        'param_name'     => 'text_custom_color',
        'type'             => 'colorpicker',
        'heading'         => __('Custom text color', 'pixfort-core'),
        'admin_label'    => false,
        'value'       => '#333',
        "dependency" => array(
            "element" => "text_color",
            "value" => "custom"
        ),
    ),
    array(
        'param_name'     => 'max_width',
        'type'             => 'textfield',
        'heading'         => __('Text max width (Optional)', 'pixfort-core'),
        'description'     => __('Input text width limit (with unit, for example 400px) instead of filling the width of the container.', 'pixfort-core'),
        'admin_label'    => true,
    ),

    array(
        "type" => "checkbox",
        "heading" => __("Remove margin under the paragraph", "pixfort-core"),
        "param_name" => "remove_mb",
        "value" => array("Yes" => true),
    ),

    array(
        'param_name'     => 'el_id',
        'type'             => 'el_id',
        'heading'         => __('Element ID', 'pixfort-core'),
        'group' => __('Advanced', 'pixfort-core'),
        'settings' => array(
            'auto_generate' => true,
        ),
    ),

    array(
        'type' => 'css_editor',
        'heading' => __('Css', 'pixfort-core'),
        'param_name' => 'css',
        'group' => __('Design options', 'pixfort-core'),
    ),
);

$sliding_text_params = array_merge(
    $sliding_text_params,
    array(
        array (
            'param_name' 	=> 'delay',
            'type' 			=> 'textfield',
            'heading' 		=> __('Animation delay (in miliseconds)', 'pixfort-core'),
            'admin_label'	=> true,
        ),
        array (
            'param_name' 	=> 'words_delay',
            'type' 			=> 'textfield',
            'heading' 		=> __('Delay between words animation (in miliseconds)', 'pixfort-core'),
            'value'	=> '150',
            'admin_label'	=> true,
            'group' => __('Advanced', 'pixfort-core'),
        ),
        array (
            'param_name' 	=> 'pix_animation_duration',
            'type' 			=> 'textfield',
            'heading' 		=> __('Word animation duration (in miliseconds)', 'pixfort-core'),
            // 'description'     => __('Select the position of the heading.', 'pixfort-core'),
            'group' => __('Advanced', 'pixfort-core'),
            'admin_label'	=> true,
        ),
        array(
            "type" => "checkbox",
            "heading" => __("Enabled Sliding letters animation", "pixfort-core"),
            "param_name" => "sliding_letters",
            "value" => array("Yes" => true),
            'description'     => __('Please note that enabling letters animation with Gradient text color will display the gradient on each letter instead of the full text.', 'pixfort-core'),
            'group' => __('Advanced', 'pixfort-core'),
        ),
        
        array (
            'param_name' 	=> 'letters_delay',
            'type' 			=> 'textfield',
            'heading' 		=> __('Delay between letters animation (in miliseconds)', 'pixfort-core'),
            'admin_label'	=> true,
            'group' => __('Advanced', 'pixfort-core'),
            'description'     => __('Leave empty to automatically set the delay depending on the word length.', 'pixfort-core'),
            "dependency" => array(
                    "element" => "sliding_letters",
                    "not_empty" => true
                ),
        ),

    )
);

if (defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG !== 'essentials') {
    $sliding_text_params = array_merge(
        $sliding_text_params,
        array(
            array(
                'param_name'   => 'wpb_pix_translate_y',
                'type'         => 'textfield',
                'heading'      => __('Vertical offset', 'pixfort-core'),
                'description'  => __('Input vertical offset with unit (for example: 1.4em or 20px).', 'pixfort-core'),
                'group'        => __('Advanced Animations', 'pixfort-core'),
            ),
            array(
                'param_name'   => 'wpb_pix_translate_x',
                'type'         => 'textfield',
                'heading'      => __('Horizontal offset', 'pixfort-core'),
                'description'  => __('Input horizontal offset with unit (for example: 20px).', 'pixfort-core'),
                'group'        => __('Advanced Animations', 'pixfort-core'),
            ),
            array(
                'param_name'   => 'wpb_pix_blur',
                'type'         => 'textfield',
                'heading'      => __('Blur', 'pixfort-core'),
                'description'  => __('Input blur amount with unit (for example: 4px).', 'pixfort-core'),
                'group'        => __('Advanced Animations', 'pixfort-core'),
            ),
            array(
                'param_name'   => 'wpb_pix_overflow',
                'type'         => 'dropdown',
                'heading'      => __('Mask items inside box', 'pixfort-core'),
                'value'        => array_flip(array(
                    'hidden' => __('Yes', 'pixfort-core'),
                    'visible' => __('No', 'pixfort-core'),
                )),
                'std'          => 'hidden',
                'group'        => __('Advanced Animations', 'pixfort-core'),
                'save_always'  => true,
            ),
        )
    );
}

vc_map(array(
    'base'             => 'sliding-text',
    'name'             => __('Sliding Text', 'pixfort-core'),
    'category'         => __('pixfort', 'pixfort-core'),
    "weight"    => "1000",
    'class'         => 'pixfort_element',
    'icon'             => PIX_CORE_PLUGIN_URI . 'functions/images/elements/sliding-text.gif',
    'description'     => __('Add cool sliding text', 'pixfort-core'),
    'params'         => $sliding_text_params
));
