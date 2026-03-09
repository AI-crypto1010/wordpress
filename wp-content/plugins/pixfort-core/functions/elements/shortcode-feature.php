<?php

// Feature -------------------------------------------
vc_map( array (
    'base' 			=> 'pix_feature',
    'name' 			=> __('Feature', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/feature.png',
    'description' 	=> __('Create custom Feature element', 'pixfort-core'),
    'params' 		=> array (

        array (
            'param_name' 	=> 'title',
            'type' 			=> 'textfield',
            'heading' 		=> __('Title', 'pixfort-core'),
            'admin_label'	=> true,
        ),


        array(
            "type" => "dropdown",
            "heading" => __( "Use image or icon", "pixfort-core" ),
            "param_name" => "media_type",
            "value" => array(
                "None" => "none",
                "Image" => "image",
                "Icon" => "icon",
                // "Duo tone icon" => "duo_icon",
                "Character" => "char"
            ),
            "group"	      => "Image / Icon",
        ),



        array (
            'param_name' 	=> 'title_size',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Title size', 'pixfort-core'),
            'admin_label'	=> false,
            'group'         => 'Advanced',
            'std'			=> 'h5',
            'value' 		=> array(
                __('H1','pixfort-core') 	=> 'h1',
                __('H2','pixfort-core')	    => 'h2',
                __('H3','pixfort-core')	    => 'h3',
                __('H4','pixfort-core')	    => 'h4',
                __('H5','pixfort-core')	    => 'h5',
                __('H6','pixfort-core')	    => 'h6',
                __('Custom','pixfort-core')	    => 'custom',
            ),
        ),

        array (
            'param_name' 	=> 'title_custom_size',
            'type' 			=> 'textfield',
            'group'         => 'Advanced',
            'heading' 		=> __('Custom Title Size', 'pixfort-core'),
            'admin_label'	=> false,
            "description" => __( "Please input the value with the unit, for example 18px.", "pixfort-core"),
            "dependency" => array(
                "element" => "title_size",
                "value" => "custom"
            ),
        ),


        array (
            'param_name' 	=> 'title_color',
            'type' 			=> 'dropdown',
            'group'         => 'Advanced',
            'heading' 		=> __('Title color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $colors,
            'std'			=> 'heading-default',
        ),
        array (
            'param_name' 	=> 'title_custom_color',
            'type' 			=> 'colorpicker',
            'group'         => 'Advanced',
            'heading' 		=> __('Title custom color', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                "element" => "title_color",
                "value" => "custom"
            ),
        ),

        array(
            "type" => "checkbox",
            "heading" => __( "Title format", "pixfort-core" ),
            "param_name" => "title_bold",
            "value" => array("Bold" => "font-weight-bold",),
            'group'         => 'Advanced',

        ),
        array(
            "type" => "checkbox",
            "param_name" => "title_italic",
            "value" => array("Italic" => "font-italic",),
            'group'         => 'Advanced',
        ),
        array(
            "type" => "checkbox",
            "param_name" => "title_secondary_font",
            "value" => array("Secondary font" => "secondary-font",),
            'group'         => 'Advanced',
        ),


        array (
            'param_name' 	=> 'content',
            'type' 			=> 'textarea',
            'heading' 		=> __('Content', 'pixfort-core'),
            'admin_label'	=> true,
            'value' 		=> __('', 'pixfort-core'),
        ),
        array (
            'param_name' 	=> 'content_size',
            'type' 			=> 'dropdown',
            'group'         => 'Advanced',
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
            'group'         => 'Advanced',
            'heading' 		=> __('Content color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $colors,
            'std'			=> 'text-gray',
            "dependency" => array(
                "element" => "content",
                "not_empty" => true
            ),
        ),
        array (
            'param_name' 	=> 'content_custom_color',
            'type' 			=> 'colorpicker',
            'group'         => 'Advanced',
            'heading' 		=> __('Content custom color', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                "element" => "content_color",
                "value" => "custom"
            ),
        ),
        array(
            "type" => "checkbox",
            "heading" => __( "Content format", "pixfort-core" ),
            "param_name" => "content_bold",
            'group'         => 'Advanced',
            "value" => array("Bold" => "font-weight-bold",),
            "dependency" => array(
                "element" => "content",
                "not_empty" => true
            ),
        ),
        array(
            "type" => "checkbox",
            "param_name" => "content_italic",
            'group'         => 'Advanced',
            "value" => array("Italic" => "font-italic",),
            "dependency" => array(
                "element" => "content",
                "not_empty" => true
            ),
        ),
        array(
            "type" => "checkbox",
            'group'         => 'Advanced',
            "param_name" => "content_secondary_font",
            "value" => array("Secondary font" => "secondary-font",),
        ),


        array(
            "type" => "checkbox",
            "heading" => __( "Justify Content", "pixfort-core" ),
            "param_name" => "justify",
            'group'         => 'Advanced',
            "value" => __( "1", "pixfort-core" ),
            "dependency" => array(
                "element" => "content",
                "not_empty" => true
            ),
        ),



        array(
            'type'        => 'pix_icons_select',
            'heading'  => 'Duo tone icons',
            'param_name'  => 'pix_duo_icon',
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
            'type' => 'pixfort_icons_picker',
            'heading' => __( 'Icon', 'pixfort-core' ),
            'param_name' => 'icon',
            'settings' => array(
                'emptyIcon' => true, // default true, display an "EMPTY" icon?
                'type' => 'pix-icons',
                'iconsPerPage' => 200, // default 100, how many icons per/page to display
            ),
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
            "type" => "checkbox",
            "heading" => __( "Background circle", "pixfort-core" ),
            "param_name" => "has_icon_bg",
            "group"	      => "Image / Icon",
            "value" => __( "Yes", "pixfort-core" ),
            "dependency" => array(
                "element" => "media_type",
                "value" => array("icon", "char", "duo_icon")
            ),
        ),


        array (
            'param_name' 	=> 'icon_bg_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Icon Background color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $bg_colors,
            'std'			=> 'primary-light',
            "group"	      => "Image / Icon",
            "dependency" => array(
                "element" => "has_icon_bg",
                // "value" => array("icon", "char", "duo_icon")
                "not_empty" => true
            ),
        ),
        array (
            'param_name' 	=> 'icon_custom_bg_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Custom Icon Background Color', 'pixfort-core'),
            'admin_label'	=> false,
            "group"	      => "Image / Icon",
            "dependency" => array(
                "element" => "icon_bg_color",
                "value" => "custom"
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
            'param_name' 	=> 'padding_title',
            'group'         => 'Advanced',
            'type' 			=> 'textfield',
            'heading' 		=> __('Padding before title', 'pixfort-core'),
            "std"           => "20px",
            'admin_label'	=> false,
        ),
        array (
            'param_name' 	=> 'padding_content',
            'group'         => 'Advanced',
            'type' 			=> 'textfield',
            'heading' 		=> __('Padding before content', 'pixfort-core'),
            "std"           => "20px",
            'admin_label'	=> false,
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
            "type" => "checkbox",
            "heading" => __( "Circle image", "pixfort-core" ),
            "param_name" => "circle",
            "value" => __( "Yes", "pixfort-core" ),
            "group"	      => "Image / Icon",
            "dependency" => array(
                "element" => "media_type",
                "value" => 'image'
            ),
        ),

        array (
            'param_name' 	=> 'icon_position',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Icon Position', 'pixfort-core'),
            "group"	      => "Image / Icon",
            'admin_label'	=> false,
            'value'			=> array_flip(array(
                'top'	=> 'Top',
                'left'	=> 'Left',
            )),
            "dependency" => array(
                "element" => "media_type",
                "value" => array("icon", "image", "char", "duo_icon")
            ),
        ),

        array (
            'param_name' 	=> 'content_align',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Content align', 'pixfort-core'),
            'admin_label'	=> false,
            'value'			=> array_flip(array(
                'left'	=> 'Left',
                'center'	=> 'Center',
                'right'	=> 'Right',
            )),
            // "dependency" => array(
            //     "element" => "icon_position",
            //     "value" => "top"
            // ),
        ),





        array (
            'param_name' 	=> 'link',
            'type' 			=> 'textfield',
            'heading' 		=> __('Link', 'pixfort-core'),
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

        array (
            'param_name' 	=> 'class',
            'type' 			=> 'textfield',
            'group'         => 'Advanced',
            'heading' 		=> __('Custom CSS classes for link', 'pixfort-core'),
            'description' 	=> __('This option is useful when you want to use PrettyPhoto (prettyphoto) or Scroll (scroll).', 'pixfort-core'),
            'admin_label'	=> true,
        ),
        array(
            'type' => 'el_id',
            'param_name' => 'element_id',
            'settings' => array(
                'auto_generate' => true,
            ),
            'heading' => esc_html__( 'Element ID', 'pixfort-core' ),
            'description' => sprintf( esc_html__( 'Enter element ID (Note: make sure it is unique and valid according to %sw3c specification%s).', 'pixfort-core' ), '<a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>' ),
        ),

        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'pixfort-core' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'pixfort-core' ),
        ),

    )
));


?>
