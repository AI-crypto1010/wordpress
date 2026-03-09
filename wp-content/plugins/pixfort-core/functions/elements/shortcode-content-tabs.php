<?php


$h_tabs_params = array(

    array(
        "type" => "checkbox",
        "heading" => __( "Full width buttons", "pixfort-core" ),
        "param_name" => "is_fill",
        "value" => array("Yes" => "nav-fill")
    ),

    array (
        'param_name' 	=> 'position',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Position', 'pixfort-core'),
        'description' 	=> __('Select the position of the heading.', 'pixfort-core'),
        'admin_label'	=> false,
        'value'			=> array_flip(array(
            'justify-content-center'		=> 'Center',
            'justify-content-start'			=> 'Left',
            'justify-content-end' 		=> 'Right',
        )),
    ),
    array (
        'param_name' 	=> 'tabs_style',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Style', 'pixfort-core'),
        'description' 	=> __('Select the style of the tabs.', 'pixfort-core'),
        'admin_label'	=> false,
        'value'			=> array_flip(array(
            'pix-pills-1'		=> 'Default (Gradient)',
            'pix-pills-solid'			=> 'Solid',
            'pix-pills-light'			=> 'Light',
            'pix-pills-outline'			=> 'Outline',
            'pix-pills-line'			=> 'Line',
            'pix-pills-round'			=> 'Round',
            'pix-pills-lines'			=> 'Lines',
        )),
    ),

    array (
        'param_name' 	=> 'tabs_content_align',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Content align', 'pixfort-core'),
        'admin_label'	=> false,
        'value'			=> array_flip(array(
            ''		=> 'Default (inherit from parent element)',
            'text-left'			=> 'Left',
            'text-center'			=> 'Center',
            'text-right'			=> 'Right',
        )),
    ),

    array (
       "type" => "dropdown",
       "heading" => __("Animation", "js_composer"),
       "param_name" => "animation",
       "admin_label" => true,
       "value" => pix_get_animations(),
       'save_always' => true,
       "description" => __( "Please select the style you wish for the box to display in.", "js_composer"),
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

    array(
        "type" => "textfield",
        "heading" => __("Extra class name", "my-text-domain"),
        "param_name" => "el_class",
        "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "my-text-domain"),
        'value'       => 'mb-2',
    ),

    array(
     "type" => "dropdown",
     "heading" => __("Icons position", "js_composer"),
     "param_name" => "tabs_icon_position",
     "admin_label" => false,
     "value" => array_flip(array(
            ""           => "Before text",
            "top"        => "Top"
        )),
      ),

      array (
        'param_name' 	=> 'tabs_custom_colors',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Custom inactive items text color', 'pixfort-core'),
        'admin_label'	=> false,
        'group' => __( 'Advanced', 'pixfort-core' ),
    ),

    array (
        'param_name' 	=> 'tabs_active_custom_colors',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Custom active item text color', 'pixfort-core'),
        'admin_label'	=> false,
        'group' => __( 'Advanced', 'pixfort-core' ),
    ),
    array (
        'param_name' 	=> 'tabs_active_custom_bg',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Custom active item background color', 'pixfort-core'),
        'admin_label'	=> false,
        'group' => __( 'Advanced', 'pixfort-core' ),
    ),

    array(
        'type' => 'el_id',
        'param_name' => 'element_id',
        'settings' => array(
            'auto_generate' => true,
        ),
        'heading' => esc_html__( 'Element ID', 'pixfort-core' ),
        'group' => __( 'Advanced', 'pixfort-core' ),
        'description' => sprintf( esc_html__( 'Enter a unique ID (Note: make sure it is unique and valid according to %sw3c specification%s).', 'pixfort-core' ), '<a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>' ),
    ),

    array(
        'type' => 'css_editor',
        'heading' => __( 'Css', 'pixfort-core' ),
        'param_name' => 'css',
        'group' => __( 'Design options', 'pixfort-core' ),
    ),
);

$v_tabs_params = array(
    // badge
    array (
        'param_name' 	=> 'badge_text',
        'type' 			=> 'textfield',
        'heading' 		=> __('Badge Text', 'pixfort-core'),
        'admin_label'	=> true,
    ),

    array(
          "type" => "checkbox",
          "heading" => __( "Badge format", "pixfort-core" ),
          "param_name" => "badge_bold",
          "value" => array("Bold" => "font-weight-bold",),
          "dependency" => array(
                "element" => "badge_text",
                "not_empty" => true
            ),
      ),
    array(
          "type" => "checkbox",
          "param_name" => "badge_italic",
          "value" => array("Italic" => "font-italic",),
          "dependency" => array(
                "element" => "badge_text",
                "not_empty" => true
            ),
      ),
    array(
          "type" => "checkbox",
          "param_name" => "badge_secondary_font",
          "value" => array("Secondary font" => "secondary-font",),
          "dependency" => array(
                "element" => "badge_text",
                "not_empty" => true
            ),
      ),

    array (
        'param_name' 	=> 'badge_text_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Badge text color', 'pixfort-core'),
        'admin_label'	=> false,
        'value' 		=> $colors,
        'std'           => 'primary',
        "dependency" => array(
              "element" => "badge_text",
              "not_empty" => true
          ),
    ),

    array (
        'param_name' 	=> 'badge_text_custom_color',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Badge custom text color', 'pixfort-core'),
        'admin_label'	=> false,
        "dependency" => array(
              "element" => "badge_text_color",
              "value" => "custom"
          ),
    ),

    array (
        'param_name' 	=> 'badge_bg_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Badge Background color', 'pixfort-core'),
        'admin_label'	=> false,
        'value' 		=> $bg_colors,
        'std'			=> 'primary-light',
        "dependency" => array(
              "element" => "badge_text",
              "not_empty" => true
          ),
    ),
    array (
        'param_name' 	=> 'badge_custom_bg_color',
        'type' 			=> 'colorpicker',
        'heading' 		=> __('Badge Custom Background Color', 'pixfort-core'),
        'admin_label'	=> false,
        "dependency" => array(
              "element" => "badge_bg_color",
              "value" => "custom"
          ),
    ),

    array (
        'param_name' 	=> 'badge_text_size',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Badge text size', 'pixfort-core'),
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
        'std' => 'h5',
        "dependency" => array(
              "element" => "badge_text",
              "not_empty" => true
          ),
    ),

    array (
        'param_name' 	=> 'badge_text_custom_size',
        'type' 			=> 'textfield',
        'heading' 		=> __('Badge custom text Size', 'pixfort-core'),
        'admin_label'	=> false,
        "dependency" => array(
              "element" => "badge_text_size",
              "value" => "custom"
          ),
    ),

    array(
    'type' => 'css_editor',
    'heading' => __( 'Css', 'pixfort-core' ),
    'param_name' => 'badge_css',
    'group' => __( 'Badge design options', 'pixfort-core' ),
    ),


    // Title
    array (
        'param_name' 	=> 'title',
        'type' 			=> 'textfield',
        'heading' 		=> __('Title', 'pixfort-core'),
        'admin_label'	=> true,
    ),

    array(
          "type" => "checkbox",
          "heading" => __( "Title format", "pixfort-core" ),
          "param_name" => "bold",
          "value" => array("Bold" => "font-weight-bold"),
          "std" => "font-weight-bold"
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
        'value' 		=> $colors,
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
    ),
    array (
        'param_name' 	=> 'padding_title',
        'type' 			=> 'textfield',
        'heading' 		=> __('Padding before title', 'pixfort-core'),
        "std"           => "",
        "description" => __( "Please input the value (with the unit: px,.. etc).", "pixfort-core"),
        'admin_label'	=> false,
    ),




    array (
        'param_name' 	=> 'text_content',
        'type' 			=> 'textarea',
        'heading' 		=> __('Content', 'pixfort-core'),
        'admin_label'	=> true,
        'value' 		=> __('', 'pixfort-core'),
    ),

    array (
        'param_name' 	=> 'content_color',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Content color', 'pixfort-core'),
        'admin_label'	=> false,
        'std'           => 'dark-opacity-5',
        'value' 		=> $colors,
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
    ),

    array (
        'param_name' 	=> 'position',
        'type' 			=> 'dropdown',
        'heading' 		=> __('Position', 'pixfort-core'),
        'description' 	=> __('Select the position of the heading.', 'pixfort-core'),
        'admin_label'	=> false,
        'save_always' => true,
        'value'			=> array_flip(array(
            'text-left'			=> 'Left',
            'text-center'		=> 'Center',
            'text-right' 		=> 'Right',
        )),
    ),
    array (
        'param_name' 	=> 'padding_content',
        'type' 			=> 'textfield',
        'heading' 		=> __('Padding before content', 'pixfort-core'),
        "std"           => "",
        "description" => __( "Please input the value (with the unit: px,.. etc).", "pixfort-core"),
        'admin_label'	=> false,
    ),


    array(
          "type" => "checkbox",
          "heading" => __( "Sticky content", "pixfort-core" ),
          "param_name" => "is_sticky",
          "value" => array("Yes" => "sticky-top")
      ),



      array (
          'param_name' 	=> 'menu_position',
          'type' 			=> 'dropdown',
          'heading' 		=> __('Menu Position', 'pixfort-core'),
          'admin_label'	=> false,
          'value' 		=> array(
              __('Left','pixfort-core') 	=> 'left',
              __('Right','pixfort-core')	    => 'right'
          )
      ),

      array (
          'param_name' 	=> 'tabs_style',
          'type' 			=> 'dropdown',
          'heading' 		=> __('Style', 'pixfort-core'),
          'description' 	=> __('Select the style of the tabs.', 'pixfort-core'),
          'admin_label'	=> false,
          'value'			=> array_flip(array(
              'pix-pills-1'		=> 'Default (Gradient)',
              'pix-pills-solid'			=> 'Solid',
              'pix-pills-light'			=> 'Light',
              'pix-pills-outline'			=> 'Outline',
              'pix-pills-line'			=> 'Line',
              'pix-pills-round'			=> 'Round',
          )),
      ),
      array (
          'param_name' 	=> 'padding_menu',
          'type' 			=> 'textfield',
          'heading' 		=> __('Padding before menu', 'pixfort-core'),
          "std"           => "20px",
          "description" => __( "Please input the value (with the unit: px,.. etc).", "pixfort-core"),
          'admin_label'	=> false,
      ),

      array (
          'param_name' 	=> 'tabs_content_align',
          'type' 			=> 'dropdown',
          'heading' 		=> __('Content align', 'pixfort-core'),
          'admin_label'	=> false,
          'value'			=> array_flip(array(
              ''		=> 'Default (inherit from parent element)',
              'text-left'			=> 'Left',
              'text-center'			=> 'Center',
              'text-right'			=> 'Right',
          )),
      ),

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
),


array(
  "type" => "textfield",
  "heading" => __("Extra class name", "my-text-domain"),
  "param_name" => "el_class",
  "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "my-text-domain"),
  'value'       => 'mb-2',
),


array (
    'param_name' 	=> 'tabs_custom_colors',
    'type' 			=> 'colorpicker',
    'heading' 		=> __('Custom inactive items text color', 'pixfort-core'),
    'admin_label'	=> false,
    'group' => __( 'Advanced', 'pixfort-core' ),
),

array (
    'param_name' 	=> 'tabs_active_custom_colors',
    'type' 			=> 'colorpicker',
    'heading' 		=> __('Custom active item text color', 'pixfort-core'),
    'admin_label'	=> false,
    'group' => __( 'Advanced', 'pixfort-core' ),
),
array (
    'param_name' 	=> 'tabs_active_custom_bg',
    'type' 			=> 'colorpicker',
    'heading' 		=> __('Custom active item background color', 'pixfort-core'),
    'admin_label'	=> false,
    'group' => __( 'Advanced', 'pixfort-core' ),
),

array(
    'type' => 'el_id',
    'param_name' => 'element_id',
    'settings' => array(
        'auto_generate' => true,
    ),
    'heading' => esc_html__( 'Element ID', 'pixfort-core' ),
    'group' => __( 'Advanced', 'pixfort-core' ),
    'description' => sprintf( esc_html__( 'Enter a unique ID (Note: make sure it is unique and valid according to %sw3c specification%s).', 'pixfort-core' ), '<a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>' ),
),


array(
'type' => 'css_editor',
'heading' => __( 'Css', 'pixfort-core' ),
'param_name' => 'css',
'group' => __( 'Element Design options', 'pixfort-core' ),
),



);


vc_map( array(
  "name" => __("Vertical Tabs", "js_composer"),
  "base" => "pix_vertical_tabs",
  "content_element" => true,
  "show_settings_on_create" => false,
  "is_container" => true,
  'category' 		=> __('pixfort', 'pixfort-core'),
  "weight"	=> "1000",
  'class'         => 'pixfort_element',
  'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/tabs-vertical.gif',
  'description' 	=> __('Create custom vertical tabs styles', 'pixfort-core'),

'as_parent' => array(
	'only' => 'pix_content_tab',
),
  "params" => $v_tabs_params,
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
  'default_content'      => '[pix_content_tab title="Tab 1"][vc_column_text]I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.[/vc_column_text][/pix_content_tab][pix_content_tab title="Tab 2"][vc_column_text]I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.[/vc_column_text][/pix_content_tab]'
  )
 );

vc_map( array(
  "name" => __("Horizontal Tabs", "js_composer"),
  "base" => "pix_tabs",
  "content_element" => true,
  "show_settings_on_create" => false,
  'category' 		=> __('pixfort', 'pixfort-core'),
  "weight"	=> "1000",
  'class'         => 'pixfort_element',
  'icon' 			=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/tabs.gif',
  'description' 	=> __('Create custom horizontal tabs styles', 'pixfort-core'),
  "is_container" => true,
'as_parent' => array(
	'only' => 'pix_content_tab',
),
  "params" => $h_tabs_params,
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
  'default_content'      => '[pix_content_tab title="Tab 1"][vc_column_text]I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.[/vc_column_text][/pix_content_tab][pix_content_tab title="Tab 2"][vc_column_text]I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.[/vc_column_text][/pix_content_tab]'
  )
 );

 if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
   class WPBakeryShortCode_pix_tabs extends WPBakeryShortCodesContainer {
   }
 }
 if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
   class WPBakeryShortCode_pix_vertical_tabs extends WPBakeryShortCodesContainer {
   }
 }

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
  class WPBakeryShortCode_content_tabs extends WPBakeryShortCodesContainer {
  }
}



vc_map(array(
	'name' => esc_html__( 'Pix Tab', 'pixfort-core' ),
	'base' => 'pix_content_tab',
	'icon' => 'icon-wpb-ui-tta-section',
	'is_container' => true,
    "content_element" => true,
	'show_settings_on_create' => false,
	'as_child' => array(
		'only' => array('content_tabs', 'pix_tabs'),
	),
    "js_view" => 'VcColumnView',
	'description' => esc_html__( 'Section for Tabs, Tours, Accordions.', 'pixfort-core' ),
	'params' => array(

        array(
    		'type' => 'textfield',
    		'param_name' => 'title',
    		'heading' => esc_html__( 'Title', 'pixfort-core' ),
    		'description' => esc_html__( 'Enter section title (Note: you can leave it empty).', 'pixfort-core' ),
            'value'     => ''
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
            'type' => 'pixfort_icons_picker',
            'heading' => __( 'Icon', 'pixfort-core' ),
            'param_name' => 'icon',
            'settings' => array(
                'emptyIcon' => true, // default true, display an "EMPTY" icon?
                'type' => 'pix-icons',
                'iconsPerPage' => 200, // default 100, how many icons per/page to display
            ),
            'description' => __( 'Select icon from library.', 'pixfort-core' ),
        ),

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
  class WPBakeryShortCode_pix_content_tab extends WPBakeryShortCodesContainer {
  }
}

 ?>
