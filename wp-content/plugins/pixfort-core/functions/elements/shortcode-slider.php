<?php

$slider_btns = $button_params;
unset($slider_btns[0]);
unset($slider_btns[1]);
unset($slider_btns[2]);
unset($slider_btns[3]);

$popup_posts = get_posts([
	'post_type' => 'pixpopup',
	'post_status' => 'publish',
	'numberposts' => -1
]);

$popups = array();
$popups[''] = "Disabled";
foreach ($popup_posts as $key => $value) {
	$popups[$value->ID] = $value->post_title;
}

// Slider -----------------------------
vc_map(array(
	'base'             	=> 'pix_slider',
	'name'             	=> __('pixfort Slider', 'pixfort-core'),
	'category'         	=> __('pixfort', 'pixfort-core'),
	'weight'           	=> "1000",
	'class'            	=> 'pixfort_element',
	'icon'             	=> PIX_CORE_PLUGIN_URI . 'functions/images/elements/slider.png',
	'description'		=> __('Add clean pixfort slider', 'pixfort-core'),
	'params'         	=> array_merge(
		array(
			array(
				'type' 			=> 'param_group',
				'value' 		=> '',
				'param_name' 	=> 'items',
				'heading'       => __('Images', 'pixfort-core'),
				'params' 		=> array(
					array(
						'param_name'    => 'image',
						'type'          => 'attach_image',
						'heading'       => __('Image', 'pixfort-core'),
						'admin_label'   => false,
					),
					array(
						'param_name'    => 'alt',
						'type'          => 'textfield',
						'heading'       => __('Image alternative text', 'pixfort-core'),
						'admin_label'   => true,
					),
					array(
						'param_name'    => 'title',
						'type'          => 'textfield',
						'heading'       => __('Title', 'pixfort-core'),
						'admin_label'   => true,
					),
					array(
						'param_name'    => 'text',
						'type'          => 'textfield',
						'heading'       => __('Slide text', 'pixfort-core'),
						'admin_label'   => false,
					),
					array(
						'param_name'    => 'btn_text',
						'type'          => 'textfield',
						'heading'       => __('Button Text', 'pixfort-core'),
						'description'   => __('Leave empty to apply the link on the title.', 'pixfort-core'),
						'admin_label'   => true,
					),
					array(
						'param_name'  	=> 'link',
						'type'          => 'textfield',
						'heading'       => __('Link', 'pixfort-core'),
						'admin_label'   => true,
					),
					array(
						"type" 			=> "checkbox",
						"heading" 		=> __("Open in a new tab", "pixfort-core"),
						"param_name" 	=> "target",
						"value" 		=> __("Yes", "pixfort-core"),
						"dependency" 	=> array(
							"element" 		=> "link",
							"not_empty" 	=> true
						),
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> __("Open Popup instead of link", "js_composer"),
						"param_name" 	=> "btn_popup_id",
						"admin_label" 	=> true,
						"value" 		=> array_flip($popups),
					),
				)
			),
			array(
				'param_name'     	=> 'rounded_img',
				'type'             	=> 'dropdown',
				'heading'         	=> __('Rounded corners', 'pixfort-core'),
				'admin_label'    	=> false,
				'value'         	=> array(
					__('No', 'pixfort-core')     			=> 'rounded-0',
					__('Rounded', 'pixfort-core')        	=> 'rounded',
					__('Rounded Large', 'pixfort-core')     => 'rounded-lg',
					__('Rounded 5px', 'pixfort-core')       => 'rounded-xl',
					__('Rounded 10px', 'pixfort-core')      => 'rounded-10',
				)
			),
			array(
				'param_name'     	=> 'align',
				'type'             	=> 'dropdown',
				'heading'         	=> __('Text alignment', 'pixfort-core'),
				'description'     	=> __('Select the position of the text.', 'pixfort-core'),
				'admin_label'    	=> false,
				'value'            	=> array_flip(array(
					'text-left'     	=> __('Start', 'pixfort-core'),
					'text-center'       => __('Center', 'pixfort-core'),
					'text-right'        => __('End', 'pixfort-core'),
				)),
			),
			array(
				'param_name'     	=> 'nav_style',
				'type'             	=> 'dropdown',
				'heading'         	=> __('Navigation style', 'pixfort-core'),
				'description'     	=> __('Select the style of the navigation.', 'pixfort-core'),
				'admin_label'    	=> false,
				'value'            	=> array_flip(array(
					'default'            => __('Default', 'pixfort-core'),
					'circles'            => __('Circles', 'pixfort-core'),
					'disable'            => __('Dsiable', 'pixfort-core'),
				)),
			),
			array(
				'param_name'     => 'nav_align',
				'type'             => 'dropdown',
				'heading'         => __('Circles align', 'pixfort-core'),
				'description'     => __('Select the position of the text.', 'pixfort-core'),
				'admin_label'    => false,
				'value'            => array_flip(array(
					'center'        => 'Center',
					'left'            => 'Left',
					'right'         => 'Right',
				)),
				"dependency" => array(
					"element" => "nav_style",
					"value" => "circles"
				),
			),

			array(
				'param_name'     => 'circles_color',
				'type'             => 'dropdown',
				'heading'         => __('Circles color', 'pixfort-core'),
				'admin_label'    => false,
				// 'group'         => 'Advanced',
				'value'         => $bg_colors,
				'std'            => 'gradient-primary',
				"dependency" => array(
					"element" => "nav_style",
					"value" => "circles"
				),
			),

			// array (
			//     'param_name' 	=> 'width',
			//     'type' 			=> 'textfield',
			//     'heading' 		=> __('Width (Optional)', 'pixfort-core'),
			//     "description" => __( "Please input the value (with the unit: %, px,.. etc).", "pixfort-core"),
			//     'admin_label'	=> false,
			// ),
			// array (
			//     'param_name' 	=> 'height',
			//     'type' 			=> 'textfield',
			//     'heading' 		=> __('Height (Optional)', 'pixfort-core'),
			//     "description" => __( "Please input the value (with the unit: %, px,.. etc).", "pixfort-core"),
			//     'admin_label'	=> false,
			// ),



			// array(
			//       "type" => "checkbox",
			//       "heading" => __( "Animation type", "pixfort-core" ),
			//       "param_name" => "pix_scroll_parallax",
			//       "value" => array_flip(array(
			//         "scroll_parallax"       => "Scroll Parallax",
			//     )),
			//   ),
			//   array(
			//         "type" => "checkbox",
			//         "param_name" => "pix_tilt",
			//         "value" => array_flip(array(
			//           "tilt"       => "3D Hover",
			//       )),
			//     ),
			//   array (
			//       'param_name' 	=> 'xaxis',
			//       'type' 			=> 'textfield',
			//       'heading' 		=> __('Vertical Parallax', 'pixfort-core'),
			//       'admin_label'	=> false,
			//       'std'			=> '0',
			// "dependency" => array(
			//       "element" => "pix_scroll_parallax",
			//       "value" => "scroll_parallax"
			//   ),
			//   ),
			//   array (
			//       'param_name' 	=> 'yaxis',
			//       'type' 			=> 'textfield',
			//       'heading' 		=> __('Horizontal Parallax', 'pixfort-core'),
			//       'admin_label'	=> false,
			//       'std'			=> '0',
			//       "dependency" => array(
			//             "element" => "pix_scroll_parallax",
			//             "value" => "scroll_parallax"
			//         ),
			//   ),
			//   array (
			//       'param_name' 	=> 'pix_tilt_size',
			//       'type' 			=> 'dropdown',
			//       'heading' 		=> __('3d hover size', 'pixfort-core'),
			//       // 'description' 	=> __('Select the position of the image.', 'pixfort-core'),
			//       'admin_label'	=> false,
			//       'value'			=> array_flip(array(
			//           'tilt'			=> 'Default',
			//           'tilt_big'		=> 'Big',
			//           'tilt_small' 		=> 'Small',
			//       )),
			//       "dependency" => array(
			//             "element" => "pix_tilt",
			//             "not_empty" => true
			//         ),
			//   ),




			// Advanced
			array(
				"type" => "checkbox",
				"heading" => __("Title format", "pixfort-core"),
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

			array(
				'param_name'     => 'title_color',
				'type'             => 'dropdown',
				'heading'         => __('Title color', 'pixfort-core'),
				'admin_label'    => false,
				'value'         => $colors,
				'std'            => 'heading-default',
				"group"   => "Advanced",
			),

			array(
				'param_name'     => 'title_custom_color',
				'type'             => 'colorpicker',
				'heading'         => __('Title color', 'pixfort-core'),
				'admin_label'    => false,
				"dependency" => array(
					"element" => "title_color",
					"value" => "custom"
				),
				"group"   => "Advanced",
			),

			array(
				'param_name'     => 'title_size',
				'type'             => 'dropdown',
				'heading'         => __('Title size', 'pixfort-core'),
				'admin_label'    => false,
				'value'         => array(
					__('H1', 'pixfort-core')     => 'h1',
					__('H2', 'pixfort-core')        => 'h2',
					__('H3', 'pixfort-core')        => 'h3',
					__('H4', 'pixfort-core')        => 'h4',
					__('H5', 'pixfort-core')        => 'h5',
					__('H6', 'pixfort-core')        => 'h6',
					__('Custom', 'pixfort-core')        => 'custom',
				),
				'std'   => 'h2',
				"group"   => "Advanced",
			),

			array(
				'param_name'     => 'title_custom_size',
				'type'             => 'textfield',
				'heading'         => __('Title Size', 'pixfort-core'),
				'admin_label'    => false,
				"dependency" => array(
					"element" => "title_size",
					"value" => "custom"
				),
				"group"   => "Advanced",
			),


			array(
				'param_name'     => 'content_color',
				'type'             => 'dropdown',
				'heading'         => __('Content color', 'pixfort-core'),
				'admin_label'    => false,
				'std'           => 'body-default',
				'value'         => $colors,
				"group"   => "Advanced",
			),


			array(
				'param_name'     => 'content_custom_color',
				'type'             => 'colorpicker',
				'heading'         => __('Content custom color', 'pixfort-core'),
				'admin_label'    => false,
				"dependency" => array(
					"element" => "content_color",
					"value" => "custom"
				),
				"group"   => "Advanced",
			),

			array(
				'param_name'     => 'content_size',
				'type'             => 'dropdown',
				'heading'         => __('Size', 'pixfort-core'),
				'description'     => __('Select the size of the text.', 'pixfort-core'),
				'admin_label'    => false,
				'std'         => 'text-24',
				'value'            => array_flip(array(
					'text-xs'        => '12px',
					'text-sm'        => '14px',
					''            => '16px',
					'text-18'         => '18px',
					'text-20'         => '20px',
					'text-24'         => '24px',
				)),
				"group"   => "Advanced",
			),




			array(
				'param_name'     => 'overlay_color',
				'type'             => 'dropdown',
				'heading'         => __('Overlay color', 'pixfort-core'),
				'admin_label'    => false,
				'group'         => 'Advanced',
				'value'         => $colors,
				'std'            => 'black',
			),

			array(
				'param_name'     => 'overlay_custom_color',
				'type'             => 'colorpicker',
				'heading'         => __('Custom overlay color', 'pixfort-core'),
				'admin_label'    => false,
				'group'         => 'Advanced',
				"dependency" => array(
					"element" => "overlay_color",
					"value" => "custom"
				),
			),
			array(
				"type" 			=> "dropdown",
				"heading" 		=> __("Overlay opacity", "pixfort-core"),
				"param_name" 	=> "overlay_opacity",
				'group'         => 'Advanced',
				"std"      		=> 'pix-opacity-7',
				"value" 		=> array_flip(array(
					"pix-opacity-0"             => "100%",
					"pix-opacity-1"             => "90%",
					"pix-opacity-2"             => "80%",
					"pix-opacity-3"             => "70%",
					"pix-opacity-4"             => "60%",
					"pix-opacity-5"             => "50%",
					"pix-opacity-6"             => "40%",
					"pix-opacity-7"             => "30%",
					"pix-opacity-8"             => "20%",
					"pix-opacity-9"             => "10%",
					"pix-opacity-10"            => "Disable",

				)),
			),
			array(
				"type" => "checkbox",
				"heading" => __("Extra top padding", "pixfort-core"),
				"param_name" => "top_placholder",
				'description'     => __('Add extra padding in the top of the slider in case of the transparent header is above the slider.', 'pixfort-core'),
				"value" => array("Yes" => "true"),
				"std" => false,
				"group"   => "Advanced",
			),
			array(
				'param_name'     	=> 'custom_min_height',
				'type'           	=> 'textfield',
				'heading' 			=> __('Custom minimum height', 'pixfort-core'),
				'admin_label'    	=> true,
				'description'     => __('Choose a custom minimum height for the slider. Input the value with unit, for example: 600px, or 100vh (for full screen height).', 'pixfort-core'),
				"group"   			=> "Advanced",
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
				"type" => "checkbox",
				"heading" => __("Autoplay", "pixfort-core"),
				"param_name" => "autoplay",
				"value" => array('Yes' => true),
				'save_always' => true,
			),
			array(
				'param_name'     => 'autoplay_time',
				'type'             => 'textfield',
				'heading'         => __('Autoplay time', 'pixfort-core'),
				'description'         => __('The time between auto slides in milliseconds.', 'pixfort-core'),
				'admin_label'    => false,
				'std'            => '2500',
				"dependency" => array(
					"element" => "autoplay",
					"not_empty" => true
				),
			),


			//  array(
			//     "type" => "dropdown",
			//     "heading" => __( "Infinite Animation type", "pixfort-core" ),
			//     "param_name" => "pix_infinite_animation",
			//     "value" => $infinite_animation,
			//     'admin_label'	=> false,
			// ),
			//  array(
			//     "type" => "dropdown",
			//     "heading" => __( "Infinite Animation Speed", "pixfort-core" ),
			//     "param_name" => "pix_infinite_speed",
			//     "value" => $animation_speeds,
			//     'admin_label'	=> false,
			//     "dependency" => array(
			//           "element" => "pix_infinite_animation",
			//           "not_empty" => true
			//       ),
			// ),


			array(
				'type' => 'css_editor',
				'heading' => __('Css', 'pixfort-core'),
				'param_name' => 'css',
				'group' => __('Design options', 'pixfort-core'),
			),
		),
		pix_add_params_to_group($slider_btns, "button"),
		$effects_params
	)
));
