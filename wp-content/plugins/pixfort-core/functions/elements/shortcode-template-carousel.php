<?php

if (!function_exists('pix_get_wpb_template_carousel_options')) {
	function pix_get_wpb_template_carousel_options() {
		$options = array(
			esc_html__('Choose Template', 'pixfort-core') => '',
		);

		$pixfort_templates = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'pixfort_template',
			'tax_query' => array(
				array(
					'taxonomy' => 'pixfort_template_type',
					'field' => 'slug',
					'terms' => 'template',
				),
			),
			'orderby' => 'title',
			'order' => 'ASC',
		));

		foreach ($pixfort_templates as $template_post) {
			$options[$template_post->post_title . ' (#' . $template_post->ID . ')'] = (string) $template_post->ID;
		}

		return $options;
	}
}

$template_carousel_options = pix_get_wpb_template_carousel_options();

vc_map(array(
	'base' => 'pix_template_carousel',
	'name' => __('Template Carousel', 'pixfort-core'),
	'category' => __('pixfort', 'pixfort-core'),
	'weight' => '1000',
	'class' => 'pixfort_element',
	'icon' => PIX_CORE_PLUGIN_URI . 'functions/images/elements/template-carousel.webp',
	'description' => __('Create custom template carousel', 'pixfort-core'),
	'params' => array_merge(
		array(
			array(
				'type' => 'param_group',
				'value' => '',
				'param_name' => 'items',
				'heading' => __('Carousel Items', 'pixfort-core'),
				'params' => array(
					array(
						'param_name' => 'item_title',
						'type' => 'textfield',
						'heading' => __('Item Title (for reference)', 'pixfort-core'),
						'admin_label' => true,
						'value' => __('Slide', 'pixfort-core'),
					),
					array(
						'param_name' => 'pix_template_id',
						'type' => 'dropdown',
						'heading' => __('Choose Template', 'pixfort-core'),
						'admin_label' => true,
						'value' => $template_carousel_options,
					),
				),
			),
			array(
				'param_name' => 'animation',
				'type' => 'dropdown',
				'heading' => __('Animation', 'pixfort-core'),
				'description' => __('Select the animation of the heading.', 'pixfort-core'),
				'admin_label' => false,
				'value' => pix_get_animations(),
			),
			array(
				'param_name' => 'delay',
				'type' => 'textfield',
				'heading' => __('Animation delay (in miliseconds)', 'pixfort-core'),
				'admin_label' => true,
				'dependency' => array(
					'element' => 'animation',
					'not_empty' => true,
				),
			),
			array(
				'param_name' => 'slider_num',
				'type' => 'dropdown',
				'heading' => __('Slides per page', 'pixfort-core'),
				'admin_label' => false,
				'value' => array(
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
					'6' => 6,
				),
				'std' => 3,
				'group' => __('Advanced', 'pixfort-core'),
			),
		),
		defined('PIXFORT_SLIDER_SWIPER') ? array(
			array(
				'param_name' => 'slider_num_tablet',
				'type' => 'dropdown',
				'heading' => __('Slides per page (Tablet)', 'pixfort-core'),
				'admin_label' => false,
				'value' => array(
					'' => __('Default', 'pixfort-core'),
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
					'6' => 6,
				),
				'std' => '',
				'group' => __('Advanced', 'pixfort-core'),
			),
			array(
				'param_name' => 'slider_num_mobile',
				'type' => 'dropdown',
				'heading' => __('Slides per page (Mobile)', 'pixfort-core'),
				'admin_label' => false,
				'value' => array(
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
					'6' => 6,
				),
				'std' => 1,
				'group' => __('Advanced', 'pixfort-core'),
			),
			// array(
			// 	'param_name' => 'spaceBetween',
			// 	'type' => 'textfield',
			// 	'heading' => __('Gap between items (Desktop)', 'pixfort-core'),
			// 	'description' => __('Set gap in px (for example: 10).', 'pixfort-core'),
			// 	'admin_label' => false,
			// 	'group' => __('Advanced', 'pixfort-core'),
			// ),
			// array(
			// 	'param_name' => 'spaceBetween_mobile',
			// 	'type' => 'textfield',
			// 	'heading' => __('Gap between items (Mobile)', 'pixfort-core'),
			// 	'description' => __('Optional mobile gap in px (for example: 5).', 'pixfort-core'),
			// 	'admin_label' => false,
			// 	'group' => __('Advanced', 'pixfort-core'),
			// ),
			// array(
			// 	'param_name' => 'spaceBetween_tablet',
			// 	'type' => 'textfield',
			// 	'heading' => __('Gap between items (Tablet)', 'pixfort-core'),
			// 	'description' => __('Optional tablet gap in px (for example: 8).', 'pixfort-core'),
			// 	'admin_label' => false,
			// 	'group' => __('Advanced', 'pixfort-core'),
			// ),
		) : array(),
		array(
			array(
				'param_name' => 'slider_style',
				'type' => 'dropdown',
				'heading' => __('Slides style', 'pixfort-core'),
				'admin_label' => false,
				'std' => 'pix-style-standard',
				'value' => array(
					__('Standard', 'pixfort-core') => 'pix-style-standard',
					__('One active item', 'pixfort-core') => 'pix-one-active',
					__('Faded items', 'pixfort-core') => 'pix-opacity-slider',
				),
				'group' => __('Advanced', 'pixfort-core'),
			),
			array(
				'param_name' => 'slider_effect',
				'type' => 'dropdown',
				'heading' => __('Slides effect', 'pixfort-core'),
				'admin_label' => false,
				'std' => 'pix-effect-standard',
				'value' => array(
					__('Standard', 'pixfort-core') => 'pix-effect-standard',
					__('Circular effect', 'pixfort-core') => 'pix-circular-slider',
					__('Circular Start Only', 'pixfort-core') => 'pix-circular-left',
					__('Circular End Only', 'pixfort-core') => 'pix-circular-right',
					__('Fade out', 'pixfort-core') => 'pix-fade-out-effect',
				),
				'group' => __('Advanced', 'pixfort-core'),
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Drag Scale Animation', 'pixfort-core'),
				'param_name' => 'drag_scale',
				'value' => array('Yes' => 'true'),
				'save_always' => true,
				'std' => false,
				'group' => __('Advanced', 'pixfort-core'),
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Show navigation buttons', 'pixfort-core'),
				'param_name' => 'prevnextbuttons',
				'value' => array('Yes' => true),
				'save_always' => true,
				'std' => true,
				'group' => __('Advanced', 'pixfort-core'),
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Dots', 'pixfort-core'),
				'param_name' => 'pagedots',
				'value' => array('Yes' => true),
				'std' => true,
				'save_always' => true,
				'group' => __('Advanced', 'pixfort-core'),
			),
			array(
				'param_name' => 'dots_style',
				'type' => 'dropdown',
				'heading' => __('Dots style', 'pixfort-core'),
				'admin_label' => false,
				'group' => __('Advanced', 'pixfort-core'),
				'value' => array_flip(array(
					'' => 'Default',
					'light-dots' => 'Light',
				)),
				'dependency' => array(
					'element' => 'pagedots',
					'not_empty' => true,
				),
			),
			array(
				'param_name' => 'dots_align',
				'type' => 'dropdown',
				'heading' => __('Dots align', 'pixfort-core'),
				'admin_label' => false,
				'group' => __('Advanced', 'pixfort-core'),
				'value' => array_flip(array(
					'' => 'Center',
					'pix-dots-left' => 'Left',
					'pix-dots-right' => 'Right',
				)),
				'dependency' => array(
					'element' => 'pagedots',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Free Scroll', 'pixfort-core'),
				'param_name' => 'freescroll',
				'value' => array('Yes' => true),
				'save_always' => true,
				'group' => __('Advanced', 'pixfort-core'),
			),
			array(
				'param_name' => 'cellalign',
				'type' => 'dropdown',
				'heading' => __('Main cell Align', 'pixfort-core'),
				'admin_label' => false,
				'group' => 'Advanced',
				'std' => 'left',
				'value' => array_flip(array(
					'center' => 'Center',
					'left' => 'Start',
					'right' => 'End',
				)),
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Scale main item', 'pixfort-core'),
				'param_name' => 'slider_scale',
				'value' => array('Yes' => 'pix-slider-scale'),
				'save_always' => true,
				'group' => __('Advanced', 'pixfort-core'),
			),
			array(
				'param_name' => 'cellpadding',
				'type' => 'dropdown',
				'heading' => __('Cells padding', 'pixfort-core'),
				'admin_label' => false,
				'group' => 'Advanced',
				'std' => 'pix-p-10',
				'value' => array_flip(array(
					'p-0' => '0px',
					'pix-p-5' => '5px',
					'pix-p-10' => '10px',
					'pix-p-15' => '15px',
					'pix-p-20' => '20px',
					'pix-p-25' => '25px',
					'pix-p-30' => '30px',
					'pix-p-35' => '35px',
					'pix-p-40' => '40px',
					'pix-p-45' => '45px',
					'pix-p-50' => '50px',
				)),
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Autoplay', 'pixfort-core'),
				'param_name' => 'autoplay',
				'value' => array('Yes' => true),
				'save_always' => true,
				'group' => __('Advanced', 'pixfort-core'),
			),
			array(
				'param_name' => 'autoplay_time',
				'type' => 'textfield',
				'heading' => __('Autoplay time', 'pixfort-core'),
				'description' => __('The time between auto slides in milliseconds.', 'pixfort-core'),
				'admin_label' => false,
				'std' => '1500',
				'group' => 'Advanced',
				'dependency' => array(
					'element' => 'autoplay',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Adaptive height', 'pixfort-core'),
				'param_name' => 'adaptiveheight',
				'value' => true,
				'save_always' => true,
				'std' => true,
				'group' => __('Advanced', 'pixfort-core'),
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Right to Left', 'pixfort-core'),
				'param_name' => 'righttoleft',
				'value' => true,
				'save_always' => true,
				'group' => __('Advanced', 'pixfort-core'),
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Wrap slides', 'pixfort-core'),
				'param_name' => 'slider_wrap',
				'value' => true,
				'std' => true,
				'save_always' => true,
				'group' => __('Advanced', 'pixfort-core'),
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Increase vertical view', 'pixfort-core'),
				'param_name' => 'visible_y',
				'value' => array('Yes' => 'pix-overflow-y-visible'),
				'save_always' => true,
				'group' => __('Advanced', 'pixfort-core'),
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Visible overflow', 'pixfort-core'),
				'description' => __('Slides outside the slider view box will be visible.', 'pixfort-core'),
				'param_name' => 'visible_overflow',
				'value' => array('Yes' => 'pix-overflow-all-visible'),
				'save_always' => true,
				'group' => __('Advanced', 'pixfort-core'),
			),
			array(
				'type' => 'css_editor',
				'heading' => __('Css', 'pixfort-core'),
				'param_name' => 'css',
				'group' => __('Design options', 'pixfort-core'),
			),
		),
		pix_get_wpb_carousel_navigation_params($colors, $colors_with_transparent)
	),
));

?>
