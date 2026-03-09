<?php


$comparison_params = array(
    array (
        'param_name' 	=> 'cols_count',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Columns count', 'pixfort-core'),
        'description' 	=> __('Select how many comparison columns.', 'pixfort-core'),
        'admin_label'	=> false,
        'std'	=> '3',
        'value'			=> array_flip(array(
            '1'			=> '1',
            '2'			=> '2',
            '3'			=> '3',
        )),
    ),


    array (
        'param_name' 	=> 'table_title',
        'type' 			=> 'textfield',
        'heading' 		=> __('Table Title', 'pixfort-core'),
        'admin_label'	=> true,
    ),

    array(
        'type' => 'param_group',
        'value' => '',
        'param_name' => 'items',
        'heading' 		=> __('Lines', 'pixfort-core'),
        'description' 	=> __('Add each feature in the desired order.', 'pixfort-core'),
        'params' => array(
            array (
                'param_name' 	=> 'title',
                'type' 			=> 'textfield',
                'heading' 		=> __('Title', 'pixfort-core'),
                'admin_label'	=> true,
            ),

            array (
                'param_name' 	=> 'title_tooltip',
                'type' 			=> 'textfield',
                'heading' 		=> __('Tooltip', 'pixfort-core'),
                'admin_label'	=> false,
            ),

            array (
                'param_name' 	=> 'text',
                'type' 			=> 'textarea',
                'heading' 		=> __('Description', 'pixfort-core'),
                'admin_label'	=> false,
            ),


            array (
                'param_name' 	=> 'col_1_text',
                'type' 			=> 'textfield',
                'heading' 		=> __('Column 1 Text', 'pixfort-core'),
                'admin_label'	=> false,
            ),
            array (
                'param_name' 	=> 'col_1_tooltip',
                'type' 			=> 'textfield',
                'heading' 		=> __('Col 1 Tooltip', 'pixfort-core'),
                'admin_label'	=> false,
            ),

            array(
                "type" => "dropdown",
                "heading" => __( "Column 1 Icon", "pixfort-core" ),
                "param_name" => "col_1_media_type",
                "std" => "icon",
                "value" => array(
                    "None" => "none",
                    "Icon" => "icon",
                    // "Duo tone icon" => "duo_icon",
                ),
            ),

            array(
                'type'        => 'pix_icons_select',
                'heading'  => 'Duo tone icon',
                'param_name'  => 'col_1_pix_duo_icon',
                "class" => "my_param_field",
                'value'       => '0',
                "dependency" => array(
                    "element" => "col_1_media_type",
                    "value" => "duo_icon"
                ),
            ),

            array (
                'type' => 'pixfort_icons_picker',
                'heading' => __( 'Line Icon', 'pixfort-core' ),
                'param_name' => 'col_1_icon',
                'settings' => array(
                    'emptyIcon' => true, // default true, display an "EMPTY" icon?
                    'type' => 'pix-icons',
                    'iconsPerPage' => 200, // default 100, how many icons per/page to display
                ),
                "dependency" => array(
                    "element" => "col_1_media_type",
                    "value" => "icon"
                ),
                'description' => __( 'Select icon from library.', 'pixfort-core' ),
            ),

            // Col 2
            array (
                'param_name' 	=> 'col_2_text',
                'type' 			=> 'textfield',
                'heading' 		=> __('Column 2 Text', 'pixfort-core'),
                'admin_label'	=> false,
            ),
            array (
                'param_name' 	=> 'col_2_tooltip',
                'type' 			=> 'textfield',
                'heading' 		=> __('Col 2 Tooltip', 'pixfort-core'),
                'admin_label'	=> false,
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Column 2 Icon", "pixfort-core" ),
                "param_name" => "col_2_media_type",
                "std" => "icon",
                "value" => array(
                    "None" => "none",
                    "Icon" => "icon",
                    // "Duo tone icon" => "duo_icon",
                ),
            ),

            array(
                'type'        => 'pix_icons_select',
                'heading'  => 'Duo tone icon',
                'param_name'  => 'col_2_pix_duo_icon',
                "class" => "my_param_field",
                'value'       => '0',
                "dependency" => array(
                    "element" => "col_2_media_type",
                    "value" => "duo_icon"
                ),
            ),

            array (
                'type' => 'pixfort_icons_picker',
                'heading' => __( 'Line Icon', 'pixfort-core' ),
                'param_name' => 'col_2_icon',
                'settings' => array(
                    'emptyIcon' => true, // default true, display an "EMPTY" icon?
                    'type' => 'pix-icons',
                    'iconsPerPage' => 200, // default 100, how many icons per/page to display
                ),
                "dependency" => array(
                    "element" => "col_2_media_type",
                    "value" => "icon"
                ),
                'description' => __( 'Select icon from library.', 'pixfort-core' ),
            ),




            // Col 3
            array (
                'param_name' 	=> 'col_3_text',
                'type' 			=> 'textfield',
                'heading' 		=> __('Column 3 Text', 'pixfort-core'),
                'admin_label'	=> false,
            ),
            array (
                'param_name' 	=> 'col_3_tooltip',
                'type' 			=> 'textfield',
                'heading' 		=> __('Col 3 Tooltip', 'pixfort-core'),
                'admin_label'	=> false,
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Column 3 Icon", "pixfort-core" ),
                "param_name" => "col_3_media_type",
                "std" => "icon",
                "value" => array(
                    "None" => "none",
                    "Icon" => "icon",
                    "Duo tone icon" => "duo_icon",
                ),
            ),

            array(
                'type'        => 'pix_icons_select',
                'heading'  => 'Duo tone icon',
                'param_name'  => 'col_3_pix_duo_icon',
                "class" => "my_param_field",
                'value'       => '0',
                "dependency" => array(
                    "element" => "col_3_media_type",
                    "value" => "duo_icon"
                ),
            ),

            array (
                'type' => 'pixfort_icons_picker',
                'heading' => __( 'Line Icon', 'pixfort-core' ),
                'param_name' => 'col_3_icon',
                'settings' => array(
                    'emptyIcon' => true, // default true, display an "EMPTY" icon?
                    'type' => 'pix-icons',
                    'iconsPerPage' => 200, // default 100, how many icons per/page to display
                ),
                "dependency" => array(
                    "element" => "col_3_media_type",
                    "value" => "icon"
                ),
                'description' => __( 'Select icon from library.', 'pixfort-core' ),
            ),

        )
    ),





    // Table Head

    array(
        "type" => "checkbox",
        "heading" => __( "Title format", "pixfort-core" ),
        "param_name" => "bold",
        "value" => array("Bold" => "font-weight-bold"),
        "std" => "font-weight-bold",
        'group' => __( 'Table Head', 'pixfort-core' ),
        'save_always' => true,
    ),
    array(
        "type" => "checkbox",
        "param_name" => "italic",
        "value" => array("Italic" => "font-italic",),
        'group' => __( 'Table Head', 'pixfort-core' ),
    ),

    array(
        "type" => "checkbox",
        "param_name" => "secondary_font",
        "value" => array("Heading font" => "secondary-font",),
        'group'         => 'Table Head',
        'description' 	=> __('The heading font is applied by default when the size is Heading (not custom size).', 'pixfort-core'),
    ),

    array (
        'param_name' 	=> 'title_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Title color', 'pixfort-core'),
        'admin_label'	=> false,
        'value' 		=> $colors,
        'std'			=> 'heading-default',
        'group' => __( 'Table Head', 'pixfort-core' ),
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
        'group' => __( 'Table Head', 'pixfort-core' ),
    ),

    array (
        'param_name' 	=> 'title_size',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Title size', 'pixfort-core'),
        'admin_label'	=> false,
        'std'	=> 'h3',
        'value' 		=> array(
            __('H1','pixfort-core') 	=> 'h1',
            __('H2','pixfort-core')	    => 'h2',
            __('H3','pixfort-core')	    => 'h3',
            __('H4','pixfort-core')	    => 'h4',
            __('H5','pixfort-core')	    => 'h5',
            __('H6','pixfort-core')	    => 'h6',
            __('Custom','pixfort-core')	    => 'custom',
        ),
        'group' => __( 'Table Head', 'pixfort-core' ),
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
        'group' => __( 'Table Head', 'pixfort-core' ),
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
        'group' => __( 'Table Head', 'pixfort-core' ),
    ),





    array(
        "type" => "checkbox",
        "heading" => __( "Columns format", "pixfort-core" ),
        "param_name" => "cols_bold",
        "value" => array("Bold" => "font-weight-bold"),
        "std" => "font-weight-bold",
        'group' => __( 'Table Head', 'pixfort-core' ),
        'save_always' => true,
    ),
    array(
        "type" => "checkbox",
        "param_name" => "cols_italic",
        "value" => array("Italic" => "font-italic",),
        'group' => __( 'Table Head', 'pixfort-core' ),
    ),

    array(
        "type" => "checkbox",
        "param_name" => "cols_secondary_font",
        "value" => array("Heading font" => "secondary-font",),
        'group'         => 'Table Head',
        'description' 	=> __('The heading font is applied by default when the size is Heading (not custom size).', 'pixfort-core'),
    ),
    array (
        'param_name' 	=> 'cols_titles_size',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Columns Titles size', 'pixfort-core'),
        'admin_label'	=> false,
        'std'	=> 'h4',
        'value' 		=> array(
            __('H1','pixfort-core') 	=> 'h1',
            __('H2','pixfort-core')	    => 'h2',
            __('H3','pixfort-core')	    => 'h3',
            __('H4','pixfort-core')	    => 'h4',
            __('H5','pixfort-core')	    => 'h5',
            __('H6','pixfort-core')	    => 'h6',
            __('Custom','pixfort-core')	    => 'custom',
        ),
        'group' => __( 'Table Head', 'pixfort-core' ),
    ),
    array (
        'param_name' 	=> 'cols_titles_custom_size',
        'type' 			=> 'textfield',
        'heading' 		=> __('Columns Titles custom Size', 'pixfort-core'),
        'admin_label'	=> false,
        "dependency" => array(
            "element" => "cols_titles_size",
            "value" => "custom"
        ),
        'group' => __( 'Table Head', 'pixfort-core' ),
    ),



        array(
         "type" => "dropdown",
         "heading" => __("Head Style", "js_composer"),
         "param_name" => "head_style",
         "admin_label" => true,
         "value" => array_flip(array(
            "" => "Default",
            "1"       => "Small shadow",
            "2"       => "Medium shadow",
            "3"       => "Large shadow",
            "7"       => "Bottom Line",
        )),
         'save_always' => true,
         'group' => __( 'Table Head', 'pixfort-core' ),
         "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
        ),


        array (
            'param_name' 	=> 'head_line_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Line color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $colors,
            'std'			=> 'dark-opacity-1',
            "dependency" => array(
                "element" => "head_style",
                "value" => "7"
            ),
            'group' => __( 'Table Head', 'pixfort-core' ),
        ),

        array (
            'param_name' 	=> 'head_line_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Custom Lines color', 'pixfort-core'),
            'admin_label'	=> false,
            "dependency" => array(
                "element" => "head_line_color",
                "value" => "custom"
            ),
            'group' => __( 'Table Head', 'pixfort-core' ),
        ),



        array (
            'param_name' 	=> 'head_bg_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Head Background color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $bg_colors,
            'std'			=> 'white',
            'group' => __( 'Table Head', 'pixfort-core' ),
        ),
        array (
            'param_name' 	=> 'head_custom_bg_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Custom Head Background Color', 'pixfort-core'),
            'admin_label'	=> false,
            'group' => __( 'Table Head', 'pixfort-core' ),
            "dependency" => array(
                  "element" => "head_bg_color",
                  "value" => "custom"
              ),
        ),


    // Lines

    array(
        "type" => "checkbox",
        "heading" => __( "Title format", "pixfort-core" ),
        "param_name" => "descriptions_title_bold",
        "value" => array("Bold" => "font-weight-bold"),
        "std" => "font-weight-bold",
        'group' => __( 'Lines', 'pixfort-core' ),
    ),
    array(
        "type" => "checkbox",
        "param_name" => "descriptions_title_italic",
        "value" => array("Italic" => "font-italic",),
        'group' => __( 'Lines', 'pixfort-core' ),
    ),
    array(
        "type" => "checkbox",
        "param_name" => "descriptions_secondary_font",
        "value" => array("Heading font" => "secondary-font",),
        'group'         => 'Lines',
    ),


    array (
        'param_name' 	=> 'descriptions_title_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Title color', 'pixfort-core'),
        'admin_label'	=> false,
        'value' 		=> $colors,
        'std'			=> '',
        'group' => __( 'Lines', 'pixfort-core' ),
    ),

    array (
        'param_name' 	=> 'descriptions_title_custom_color',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Title color', 'pixfort-core'),
        'admin_label'	=> false,
        "dependency" => array(
            "element" => "title_color",
            "value" => "custom"
        ),
        'group' => __( 'Lines', 'pixfort-core' ),
    ),

    array (
        'param_name' 	=> 'descriptions_title_size',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Title size', 'pixfort-core'),
        'admin_label'	=> false,
        'std'	=> 'h6',
        'value' 		=> array(
            __('H1','pixfort-core') 	=> 'h1',
            __('H2','pixfort-core')	    => 'h2',
            __('H3','pixfort-core')	    => 'h3',
            __('H4','pixfort-core')	    => 'h4',
            __('H5','pixfort-core')	    => 'h5',
            __('H6','pixfort-core')	    => 'h6',
            __('Custom','pixfort-core')	    => 'custom',
        ),
        'group' => __( 'Lines', 'pixfort-core' ),
    ),

    array (
        'param_name' 	=> 'descriptions_title_display',
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
            "element" => "descriptions_title_size",
            "value" => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6')
        ),
        'group' => __( 'Lines', 'pixfort-core' ),
    ),

    array (
        'param_name' 	=> 'descriptions_title_custom_size',
        'type' 			=> 'textfield',
        'heading' 		=> __('Title Size', 'pixfort-core'),
        'admin_label'	=> false,
        "dependency" => array(
            "element" => "title_size",
            "value" => "custom"
        ),
        'group' => __( 'Lines', 'pixfort-core' ),
    ),

    array (
        'param_name' 	=> 'content_size',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Content Size', 'pixfort-core'),
        'description' 	=> __('Select the size of the text.', 'pixfort-core'),
        'admin_label'	=> false,
        'group' => __( 'Lines', 'pixfort-core' ),
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

    array(
          "type" => "checkbox",
          "heading" => __( "Text format", "pixfort-core" ),
          "param_name" => "content_bold",
          "value" => array("Bold" => "font-weight-bold"),
          'group' => __( 'Lines', 'pixfort-core' ),
      ),
    array(
          "type" => "checkbox",
          "param_name" => "content_italic",
          "value" => array("Italic" => "font-italic",),
          'group' => __( 'Lines', 'pixfort-core' ),
      ),
      array(
          "type" => "checkbox",
          "param_name" => "content_secondary_font",
          "value" => array("Heading font" => "secondary-font",),
          'group'         => 'Lines',
      ),


    array (
        'param_name' 	=> 'content_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Content color', 'pixfort-core'),
        'admin_label'	=> false,
        'value' 		=> $colors,
        'std'			=> 'body-default',
        'group' => __( 'Lines', 'pixfort-core' ),
    ),
    array (
        'param_name' 	=> 'content_custom_color',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Content custom color', 'pixfort-core'),
        'admin_label'	=> false,
        'group' => __( 'Lines', 'pixfort-core' ),
        "dependency" => array(
            "element" => "content_color",
            "value" => "custom"
        ),
    ),




    array(
     "type" => "dropdown",
     "heading" => __("Item Style", "js_composer"),
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
        "7"       => "Bottom Line",
    )),
     'save_always' => true,
     'group' => __( 'Lines', 'pixfort-core' ),
     "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
    ),

    array (
        'param_name' 	=> 'items_line_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Line color', 'pixfort-core'),
        'admin_label'	=> false,
        'value' 		=> $colors,
        'std'			=> 'dark-opacity-1',
        "dependency" => array(
            "element" => "style",
            "value" => "7"
        ),
        'group' => __( 'Lines', 'pixfort-core' ),
    ),

    array (
        'param_name' 	=> 'items_line_custom_color',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Custom Lines color', 'pixfort-core'),
        'admin_label'	=> false,
        "dependency" => array(
            "element" => "items_line_color",
            "value" => "custom"
        ),
        'group' => __( 'Lines', 'pixfort-core' ),
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
    'group' => __( 'Lines', 'pixfort-core' ),
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
    'group' => __( 'Lines', 'pixfort-core' ),
    "description" => __( "Please select the style you wish for the box to display in.", "js_composer")
    ),

    array(
          "type" => "checkbox",
          "heading" => __( "Columns format", "pixfort-core" ),
          "param_name" => "columns_bold",
          "value" => array("Bold" => "font-weight-bold"),
          'group' => __( 'Lines', 'pixfort-core' ),
      ),
    array(
          "type" => "checkbox",
          "param_name" => "columns_italic",
          "value" => array("Italic" => "font-italic",),
          'group' => __( 'Lines', 'pixfort-core' ),
      ),
      array(
          "type" => "checkbox",
          "param_name" => "columns_secondary_font",
          "value" => array("Heading font" => "secondary-font",),
          'group'         => 'Lines',
      ),

    array (
        'param_name' 	=> 'columns_size',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Columns Text Size', 'pixfort-core'),
        'description' 	=> __('Select the size of the text.', 'pixfort-core'),
        'admin_label'	=> false,
        'group' => __( 'Lines', 'pixfort-core' ),
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





    // Column 1

    array (
        'param_name' 	=> 'col_1_title',
        'type' 			=> 'textfield',
        'heading' 		=> __('Column 1 Title', 'pixfort-core'),
        'admin_label'	=> true,
        'group' => __( 'Col 1', 'pixfort-core' ),
    ),

    array (
        'param_name' 	=> 'col_1_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Col 1 color', 'pixfort-core'),
        'admin_label'	=> false,
        'value' 		=> $colors,
        'std'			=> 'heading-default',
        'group' => __( 'Col 1', 'pixfort-core' ),
    ),

    array (
        'param_name' 	=> 'col_1_custom_color',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Col 1 custom color', 'pixfort-core'),
        'admin_label'	=> false,
        "dependency" => array(
            "element" => "col_1_color",
            "value" => "custom"
        ),
        'group' => __( 'Col 1', 'pixfort-core' ),
    ),
    // Column 2

    array (
        'param_name' 	=> 'col_2_title',
        'type' 			=> 'textfield',
        'heading' 		=> __('Column 2 Title', 'pixfort-core'),
        'admin_label'	=> true,
        'group' => __( 'Col 2', 'pixfort-core' ),
    ),

    array (
        'param_name' 	=> 'col_2_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Col 2 color', 'pixfort-core'),
        'admin_label'	=> false,
        'value' 		=> $colors,
        'std'			=> 'heading-default',
        'group' => __( 'Col 2', 'pixfort-core' ),
        "dependency" => array(
            "element" => "cols_count",
            "value" => array("2", "3")
        ),
    ),

    array (
        'param_name' 	=> 'col_2_custom_color',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Col 2 custom color', 'pixfort-core'),
        'admin_label'	=> false,
        "dependency" => array(
            "element" => "col_2_color",
            "value" => "custom"
        ),
        'group' => __( 'Col 2', 'pixfort-core' ),
    ),


    // Column 3
    array (
        'param_name' 	=> 'col_3_title',
        'type' 			=> 'textfield',
        'heading' 		=> __('Column 3 Title', 'pixfort-core'),
        'admin_label'	=> true,
        'group' => __( 'Col 3', 'pixfort-core' ),
    ),
    array (
        'param_name' 	=> 'col_3_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Col 3 color', 'pixfort-core'),
        'admin_label'	=> false,
        'value' 		=> $colors,
        'std'			=> 'heading-default',
        'group' => __( 'Col 3', 'pixfort-core' ),
        "dependency" => array(
            "element" => "cols_count",
            "value" => array("3")
        ),
    ),

    array (
        'param_name' 	=> 'col_3_custom_color',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Col 3 custom color', 'pixfort-core'),
        'admin_label'	=> false,
        "dependency" => array(
            "element" => "col_3_color",
            "value" => "custom"
        ),
        'group' => __( 'Col 3', 'pixfort-core' ),
    ),

    // Buttons


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

    // array(
    //     'type' => 'css_editor',
    //     'heading' => __( 'Css', 'pixfort-core' ),
    //     'param_name' => 'css',
    //     'group' => __( 'Design options', 'pixfort-core' ),
    // ),

);
// Comparison Table --------------------------------------
vc_map( array (
    'base' 			=> 'pix_comparison_table',
    'name' 			=> __('Comparison Table', 'pixfort-core'),
    'category' 		=> __('pixfort', 'pixfort-core'),
    "weight"	=> "1000",
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/comparison-table.png',
    'description' 	=> __('Create custom comparison table', 'pixfort-core'),
    'params' 		=> array_merge($comparison_params, array (
        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'pixfort-core' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'pixfort-core' ),
        ),

    )

)
));

?>
