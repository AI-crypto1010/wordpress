<?php


// Accordion
vc_map( array(
    "name" => __("pixfort Accordion", "js_composer"),
    "base" => "pix_accordion",
    "content_element" => true,
    "show_settings_on_create" => false,
    'class'         => 'pixfort_element',
    "weight"	=> "1000",
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/accordion.gif',
    'description' 	=> __('Add accordion to organize content', 'pixfort-core'),
    "is_container" => true,
    "group"		=> "test",
    'category' 		=> __('pixfort', 'pixfort-core'),
    'as_parent' => array(
        'only' => 'pix_accordion_tab',
    ),
    "params" => array(
        array(
            'type' => 'el_id',
            'param_name' => 'accordion_id',
            'settings' => array(
                'auto_generate' => true,
            ),
            'heading' => esc_html__( 'Accordion ID', 'pixfort-core' ),
            'description' => sprintf( esc_html__( 'Enter accordion ID (Note: make sure it is unique and valid according to %sw3c specification%s).', 'pixfort-core' ), '<a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>' ),
        ),
        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'pixfort-core' ),
            'param_name' => 'css',
            'group' => __( 'Design options', 'pixfort-core' ),
        ),

        ),
        'js_view' => 'VcBackendTtaTabsViewPixfort',
        'admin_enqueue_js' => array(
      		 PIX_CORE_PLUGIN_URI.'functions/js/views/tabs-back.js',
      	),
        'custom_markup' => '
      <div class="vc_tta-container" data-vc-action="collapse">
      	<div class="vc_general vc_tta vc_tta-tabs vc_tta-color-backend-tabs-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-spacing-1 vc_tta-tabs-position-top vc_tta-controls-align-left">
      		<div class="vc_tta-tabs-container">' . '<ul class="vc_tta-tabs-list pix-tabs-list">' . '<li class="vc_tta-tab" data-vc-tab data-vc-target-model-id="{{ model_id }}" data-element_type="pix_content_tab"><a href="javascript:;" data-vc-tabs data-vc-container=".vc_tta" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-target-model-id="{{ model_id }}"><span class="vc_tta-title-text">{{ section_title }}</span></a></li>' . '</ul>
      		</div>
      		<div class="vc_tta-panels vc_clearfix {{container-class}}">
      		  {{ content }}
      		</div>
      	</div>
      </div>',
        'default_content'      => '[pix_accordion_tab title="Tab 1"][vc_column_text]I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.[/vc_column_text][/pix_accordion_tab][pix_accordion_tab title="Tab 2"][vc_column_text]I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.[/vc_column_text][/pix_accordion_tab]'
    )
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_pix_accordion extends WPBakeryShortCodesContainer {
    }
}




vc_map(array(
    'name' => esc_html__( 'Pix Accordion Tab', 'pixfort-core' ),
    'base' => 'pix_accordion_tab',
    'class'         => 'pixfort_element',
    'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/accordion-tab.png',
    'description' 	=> __('Add new accordion tab', 'pixfort-core'),
    'is_container' => true,
    "content_element" => true,
    'show_settings_on_create' => false,
    'as_child' => array(
        'only' => array('pix_accordion'),
    ),
    "js_view" => 'VcColumnView',
    'description' => esc_html__( 'Section for Accordions.', 'pixfort-core' ),
    'params' => array(

        array(
            'type' => 'textfield',
            'param_name' => 'title',
            'heading' => esc_html__( 'Title', 'pixfort-core' ),
            'description' => esc_html__( 'Enter section title (Note: you can leave it empty).', 'pixfort-core' ),
            'value'     => 'Accordion Title'
        ),

        array(
            "type" => "checkbox",
            "heading" => __( "Title format", "pixfort-core" ),
            "param_name" => "bold",
            "value" => array("Bold" => "font-weight-bold"),
            'save_always' => true,
            "std" => "font-weight-bold",
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



        array (
            'param_name' 	=> 'title_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Title color', 'pixfort-core'),
            'admin_label'	=> false,
            'group'         => 'Advanced',
            'value' 		=> $colors,
            'std'			=> 'heading-default',
        ),

        array (
            'param_name' 	=> 'title_custom_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Title custom color', 'pixfort-core'),
            'admin_label'	=> false,
            'group'         => 'Advanced',
            "dependency" => array(
                "element" => "title_color",
                "value" => "custom"
            ),
        ),

        array(
            "type" => "dropdown",
            "heading" => __( "Icon style", "pixfort-core" ),
            "param_name" => "media_type",
            "value" => array(
                "None" => "none",
                "Default Icon" => "icon",
                // "Duo tone icon" => "duo_icon",
            ),
            "group"	      => "Advanced",
        ),

        array (
            'type' => 'pixfort_icons_picker',
            'heading' => __( 'Icon', 'pixfort-core' ),
            'param_name' => 'icon',
            "group"	      => "Advanced",
            'settings' => array(
                'emptyIcon' => true, // default true, display an "EMPTY" icon?
                'type' => 'pix-icons',
                'iconsPerPage' => 200, // default 100, how many icons per/page to display
            ),
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
            "group"	      => "Advanced",
        ),



        array (
            'param_name' 	=> 'custom_icon_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Icon Color', 'pixfort-core'),
            'description' 	=> __('This option only work with default icon type.', 'pixfort-core'),
            'admin_label'	=> false,
            "group"	      => "Advanced",
            "dependency" => array(
                "element" => "icon_color",
                "value" => "custom"
            ),
        ),

        array (
            'param_name' 	=> 'bg_color',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Background color', 'pixfort-core'),
            'admin_label'	=> false,
            'value' 		=> $bg_colors,
            'std'			=> 'white',
            "group"	      => "Advanced",
        ),

        array (
            'param_name' 	=> 'custom_bg_color',
            'type' 			=> 'colorpicker',
            'heading' 		=> __('Custom Background Color', 'pixfort-core'),
            'admin_label'	=> false,
            "group"	      => "Advanced",
            "dependency" => array(
                "element" => "bg_color",
                "value" => "custom"
            ),
        ),

        array(
            'param_name' 	=> 'shadow',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Shadow Style', 'pixfort-core'),
            'admin_label'	=> false,
            'group'         => 'Advanced',
            'value'			=> array(
                __('None', 'pixfort-core') => '0',
                __('Small shadow', 'pixfort-core') => '1',
                __('Medium shadow', 'pixfort-core') => '2',
                __('Large shadow', 'pixfort-core') => '3',
            ),
            'std'			=> '1',
        ),

        ...(class_exists('\PixfortCore') && \PixfortCore::instance()->getThemeParam('new_border_options') ? array(array(
            'param_name' 	=> 'rounded_corners',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Rounded corners', 'pixfort-core'),
            'admin_label'	=> false,
            'group'         => 'Advanced',
            'value'			=> array(
                __('No', 'pixfort-core') => 'rounded-0',
                __('Rounded', 'pixfort-core') => 'rounded',
                __('Rounded Large', 'pixfort-core') => 'rounded-lg',
                __('Rounded XL', 'pixfort-core') => 'rounded-xl',
                __('Rounded 2XL', 'pixfort-core') => 'rounded-10',
            ),
            'std'			=> 'rounded-lg',
        )) : array()),


        array (
            'param_name' 	=> 'transition',
            'type' 			=> 'dropdown',
            'heading' 		=> __('Transition', 'pixfort-core'),
            'description' 	=> __('Select the transition of the tab.', 'pixfort-core'),
            'admin_label'	=> false,
            'value'			=> array_flip(array(
                ''			=> 'None',
                'fade'			=> 'Fade',
                'fade-left'			=> 'Fade Left',
                'fade-right'		=> 'Fade Right',
                'fade-up' 		=> 'Fade Up',
                'fade-down' 		=> 'Fade Down',
            )),
        ),

        array(
            'type' => 'el_id',
            'param_name' => 'tab_id',
            'settings' => array(
                'auto_generate' => true,
            ),
            'heading' => esc_html__( 'Section ID', 'pixfort-core' ),
            'description' => sprintf( esc_html__( 'Enter section ID (Note: make sure it is unique and valid according to %sw3c specification%s).', 'pixfort-core' ), '<a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>' ),
            ),

            array(
                "type" => "checkbox",
                "heading" => __( "Open by default", "pixfort-core" ),
                "param_name" => "is_open",
                "value" => array("Yes" => "yes"),
                'save_always' => true,
                "description" => __("Make this tab open by default.", "my-text-domain"),
            ),

            array(
                "type" => "textfield",
                "heading" => __("Extra class name", "my-text-domain"),
                "param_name" => "el_class",
                "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "my-text-domain"),
                'value'       => 'mb-2',
            ),

            array(
                'type' => 'css_editor',
                'heading' => __( 'Css', 'pixfort-core' ),
                'param_name' => 'css',
                'group' => __( 'Design options', 'pixfort-core' ),
            ),
        ),
        "js_view" => 'VcColumnView',
        'default_content' => '[vc_column_text css=".vc_custom_1561415520563{padding: 30px !important;}"]I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.[/vc_column_text]',
    ));



    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_pix_accordion_tab extends WPBakeryShortCodesContainer {
        }
    }
?>
