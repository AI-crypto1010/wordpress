<?php

// Fancy box ----------------------------------------------
vc_map( array (
    'base' 			=> 'fancy_box',
    'name' 			=> __('Fancy box', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/fancy-box.jpg',
    'description' 	=> __('Add custom fancy box', 'pixfort-core'),
    'params' 		=> array_merge(
        array (

            array (
                'param_name' 	=> 'title',
                'type' 			=> 'textfield',
                'heading' 		=> __('Title', 'pixfort-core'),
                'admin_label'	=> true,
            ),
            array (
                'param_name' 	=> 'text',
                'type' 			=> 'textarea',
                'heading' 		=> __('Text', 'pixfort-core'),
                'admin_label'	=> true,
            ),

            array (
                'param_name' 	=> 'bg_img',
                'type' 			=> 'attach_image',
                'heading' 		=> __('Image', 'pixfort-core'),
                'admin_label'	=> false,
            ),
            ...( \PixfortCore::instance()->getThemeParam('dynamic_wpb_images') ? [
                array(
                    'param_name' 	=> 'dynamic_bg_img',
                    'type' 			=> 'pix_dynamic_image',
                    'heading' 		=> __('Dynamic image source', 'pixfort-core'),
                    'description' 	=> __('Select a dynamic image source (optional). If image is not available, the normal image will be used.', 'pixfort-core'),
                ),
            ] : [] ),

            array (
                'param_name' 	=> 'alt',
                'type' 			=> 'textfield',
                'heading' 		=> __('Image alternative text', 'pixfort-core'),
                'admin_label'	=> true,
            ),

            array (
                'param_name' 	=> 'position',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Text position', 'pixfort-core'),
                'admin_label'	=> false,
                'value'			=> array_flip(array(
                    'bottom'		=> 'Bottom',
                    'top'			=> 'Top',
                )),
            ),

            array (
                'param_name' 	=> 'link',
                'type' 			=> 'textfield',
                'heading' 		=> __('Box link', 'pixfort-core'),
                'admin_label'	=> true,
            ),

            array(
                "type" => "checkbox",
                "heading" => __( "Open in a new tab", "pixfort-core" ),
                "param_name" => "target",
                "value" => __( "Yes", "pixfort-core" ),
                "dependency" => array(
                    "element" => "link",
                    "not_empty" => true
                ),
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



            // Advanced
            array(
                "type" => "checkbox",
                "heading" => __( "Title format", "pixfort-core" ),
                "param_name" => "bold",
                "value" => array("Bold" => "font-weight-bold"),
                "std" => "font-weight-bold",
                "group"   => "Advanced",
            ),
            array(
                "type" => "checkbox",
                "param_name" => "italic",
                "value" => array("Italic" => "font-italic",),
                "group"   => "Advanced",
            ),
            array(
                "type" => "checkbox",
                "param_name" => "secondary_font",
                "value" => array("Secondary font" => "secondary-font",),
                "group"   => "Advanced",
            ),

            array (
                'param_name' 	=> 'title_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Title color', 'pixfort-core'),
                'admin_label'	=> false,
                'value' 		=> $colors,
                'std'			=> '',
                "group"   => "Advanced",
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
                "group"   => "Advanced",
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
                    __('Custom','pixfort-core')	    => 'custom',
                ),
                'std'   => 'h2',
                "group"   => "Advanced",
            ),

            array (
                'param_name' 	=> 'title_custom_size',
                'type' 			=> 'textfield',
                'heading' 		=> __('Title Size', 'pixfort-core'),
                'admin_label'	=> false,
                "dependency" => array(
                    "element" => "title_size",
                    "value" => "custom"
                ),
                "group"   => "Advanced",
            ),

            array(
                "type" => "checkbox",
                "heading" => __( "Content Bold", "pixfort-core" ),
                "param_name" => "content_bold",
                "value" => array("Yes" => "font-weight-bold"),
                "std" => "",
                "group"   => "Advanced",
            ),
            array (
                'param_name' 	=> 'content_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Content color', 'pixfort-core'),
                'admin_label'	=> false,
                'std'           => 'dark-opacity-5',
                'value' 		=> $colors,
                "group"   => "Advanced",
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
                "group"   => "Advanced",
            ),

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
                "group"   => "Advanced",
            ),



            array (
                'param_name' 	=> 'overlay_color',
                'type' 			=> 'dropdown',
                'heading' 		=> __('Hover overlay color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Advanced',
                'value' 		=> $colors,
                'std'			=> 'light-opacity-8',
            ),

            array (
                'param_name' 	=> 'overlay_custom_color',
                'type' 			=> 'colorpicker',
                'heading' 		=> __('Custom hover overlay color', 'pixfort-core'),
                'admin_label'	=> false,
                'group'         => 'Advanced',
                "dependency" => array(
                    "element" => "overlay_color",
                    "value" => "custom"
                ),
            ),

            array(
                "type" => "checkbox",
                "heading" => __( "Enable blur", "pixfort-core" ),
                "param_name" => "enable_blur",
                "value" => array("Yes" => "yes"),
                "group"   => "Advanced",
            ),


            array(
                'type' => 'css_editor',
                'heading' => __( 'Css', 'pixfort-core' ),
                'param_name' => 'css',
                'group' => __( 'Design options', 'pixfort-core' ),
            ),

        ),
        pix_add_params_group($effects_params, "Effects")
    )
));

?>
