<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* BlogSlider
* --------------------------------------------------------------------------- */
class PixBlogSlider {

	public function __construct() {
		include_once('extras/blog-functions.php');
	}

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'title'							=> '',
			'count'							=> 5,
			'category'						=> '',
			'category_multi'				=> '',
			'blog_style'					=> '',
			'blog_size'						=> 'lg',
			'more'							=> '',
			'blog_slider_overflow'			=> true,
			'blog_style_box'				=> false,
			'blog_dark_mode'				=> '',
			'css'							=> '',
			'orderby'						=> 'date',
			'order'							=> 'DESC',
			'offset'						=> 0,
			'source'						=> '',

			'bottom_divider_select'			=> '',
			'bottom_moving_divider_color'	=> '',
			'bottom_layers'					=> '3',
			'pix_param_section_1'			=> '',
			// 'b_1_is_gradient'			=> '',
			'b_1_color'						=> '#fff',
			// 'b_1_color_2'				=> '',
			// 'b_1_animation'				=> 'fade-in-up',
			// 'b_1_delay'					=> '200',
			// 'b_2_is_gradient'			=> '',
			'b_2_color'						=> 'rgba(255,255,255,0.8)',
			// 'b_2_color_2'				=> '',
			'b_2_animation'					=> 'fade-in-up',
			'b_2_delay'						=> '300',
			// 'b_3_is_gradient'			=> '',
			// 'b_3_color'					=> '',
			// 'b_3_color_2'				=> '',
			'b_3_animation'					=> 'fade-in-up',
			'b_3_delay'						=> '400',
			'b_divider_in_front'			=> 'true',
			'b_flip_h'						=> '',

			'slider_num'  					=> '3',
			'slider_num_mobile'  			=> '1',
			'dots_style' 					=> '',
			'slider_style' 					=> 'pix-style-standard',
			'slider_effect' 				=> 'pix-effect-standard',
			'autoplay' 						=> false,
			'autoplay_time' 				=> '1500',
			'freescroll' 					=> false,
			'prevnextbuttons' 				=> true,
			'adaptiveheight' 				=> false,
			'pagedots' 						=> true,
			'dots_align' 					=> '',
			'cellalign' 					=> 'center',
			'slider_scale' 					=> '',
			'cellpadding' 					=> 'pix-p-10',
			'slider_wrap' 					=> false,
			'righttoleft' 					=> false,
			'visible_y' 					=> '',
			'visible_overflow' 				=> '',
			'b_custom_height' 				=> '50px',
			'is_elementor' 					=> false,
			), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		wp_enqueue_style('pixfort-carousel-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/carousel-2.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		
		$divider_out = '';
		if ($bottom_divider_select && $bottom_divider_select != '' && $bottom_divider_select != '0' && $bottom_divider_select != 'dynamic') {
			$b_divider_opts = array(
				'd_divider_select'			=> $bottom_divider_select,
				'd_layers'					=> $bottom_layers,
				'd_1_is_gradient'			=> '',
				'd_1_color'					=> $b_1_color,
				'd_2_is_gradient'			=> '',
				'd_2_color'					=> $b_2_color,
				'd_2_animation'				=> $b_2_animation,
				'd_2_delay'					=> $b_2_delay,
				'd_3_is_gradient'			=> '',
				'd_3_color'					=> '',
				'd_3_color_2'				=> '',
				'd_3_animation'				=> $b_3_animation,
				'd_3_delay'					=> $b_3_delay,
				'd_high_index'				=> $b_divider_in_front,
				'd_flip_h'					=> $b_flip_h,
			);
		}

		if ($bottom_divider_select && $bottom_divider_select != '' && $bottom_divider_select != '0' && $bottom_divider_select != 'dynamic') {
			$divider_out .= pix_get_divider($bottom_divider_select, '#fff', 'bottom', false, $bottom_moving_divider_color, $b_divider_opts, $b_custom_height);
		}
		if ($bottom_divider_select && $bottom_divider_select == 'dynamic') {
			$b_divider_opts = array(
				'd_divider_select'			=> $bottom_divider_select,
				'd_high_index'				=> $b_divider_in_front,
				'd_flip_h'					=> $b_flip_h,
			);
			$divider_out .= pix_get_divider($bottom_divider_select, '#fff', 'bottom', false, $bottom_moving_divider_color, $b_divider_opts, $b_custom_height);
		}

		$args = array(
			'posts_per_page'		=> intval($count),
			'no_found_rows'			=> 1,
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1,
			'orderby'				=> $orderby,
			'order'				=> $order
		);
		if($source == 'related'){
			$args=[
				'post__not_in' => [get_the_ID()],
				'category__in' => wp_get_post_categories(get_the_ID()),
				'posts_per_page'=>intval($count),
				'post_status'			=> 'publish',
				'ignore_sticky_posts'=> 1
			];
		}

		// Only add offset if it's greater than 0
		if (!empty($offset) && intval($offset) > 0) {
			$args['offset'] = intval($offset);
		}

		// categories
		if ($category_multi) {
			$args['category_name'] = trim($category_multi);
		} elseif (!empty($category) && $category != '') {
			$args['category_name'] = $category;
		}

		$output = '';
		$query_blog = new WP_Query($args);

		// $itemsOutputArray = [];

		$blog_overflow = '';
		if (!empty($blog_slider_overflow) && $blog_slider_overflow) {
			$blog_overflow = 'pix-blog-overflow-visible';
		}

		if (!filter_var($autoplay, FILTER_VALIDATE_BOOLEAN)) {
			$autoplay_time = false;
		} else {
			$autoplay_time = (int)$autoplay_time;
		}
		if(is_rtl()){
			if($slider_effect == 'pix-circular-left'){
				$slider_effect = 'pix-circular-right';
			}else if($slider_effect == 'pix-circular-right'){
				$slider_effect = 'pix-circular-left';
			}
		}
		$slider_data = '';
		$pix_id = "pix-slider-" . rand(1, 200000000);
		$slider_opts = array(
			"autoPlay"				=> $autoplay_time,
			"freeScroll"			=> filter_var($freescroll, FILTER_VALIDATE_BOOLEAN),
			"prevNextButtons"		=> filter_var($prevnextbuttons, FILTER_VALIDATE_BOOLEAN),
			"wrapAround"			=> filter_var($slider_wrap, FILTER_VALIDATE_BOOLEAN),
			"pageDots"				=> filter_var($pagedots, FILTER_VALIDATE_BOOLEAN),
			"adaptiveHeight"		=> filter_var($adaptiveheight, FILTER_VALIDATE_BOOLEAN),
			"rightToLeft"			=> filter_var($righttoleft, FILTER_VALIDATE_BOOLEAN),
			"cellAlign" 			=> $cellalign,
			"contain"				=> true,
			"slider_effect"			=> $slider_effect,
			"arrowShape"			=> 'M83.7718595,45.4606514 L31.388145,45.4606514 L54.2737785,23.1973134 C56.1027533,21.4180712 56.1027533,18.4982892 54.2737785,16.719047 C52.4448037,14.9398048 49.4903059,14.9398048 47.6613311,16.719047 L16.7563465,46.7836776 C14.9273717,48.5629198 14.9273717,51.4370802 16.7563465,53.2163224 L47.6613311,83.280953 C49.4903059,85.0601952 52.4448037,85.0601952 54.2737785,83.280953 C56.1027533,81.5017108 56.1027533,78.6275504 54.2737785,76.8483082 L31.388145,54.5849702 L83.7718595,54.5849702 C86.3511829,54.5849702 88.4615385,52.5319985 88.4615385,50.0228108 C88.4615385,47.5136231 86.3511829,45.4606514 83.7718595,45.4606514 Z',
			"pix_id"				=>  '#' . $pix_id,
		);
		$slider_data = json_encode($slider_opts);
		$slider_data = 'data-flickity=\'' . $slider_data . '\'';
		if ($visible_overflow == 'pix-overflow-all-visible') $visible_y = '';

		$dark_mode_class = '';
		if(!empty($blog_dark_mode)){
			$dark_mode_class = 'pix-invert-colors';
		}

		$itemsOutputArray = [];

		$oldOutput  = '';
		$oldOutput  .= '<div class="' . $css_class . ' ' . $dark_mode_class . '">';
		$oldOutput  .= '<div id="' . $pix_id . '" class="pix-main-slider ' . $visible_overflow . ' ' . $slider_style . ' ' . $slider_effect . ' ' . $slider_scale . ' ' . $visible_y . ' pix-slider-' . $slider_num . ' pix-slider-dots ' . $dots_style . ' ' . $dots_align . '" ' . $slider_data . '>';
		while ($query_blog->have_posts()) {
			$itemOutput = '';
			$oldOutput .= '<div class="carousel-cell">';
			$oldOutput .= '<div class="slide-inner ' . $cellpadding . '">';
			$oldOutput .= '<div class="pix-slider-effects">';
			$itemOutput .= pix_blog_item($query_blog, $attr, $divider_out);
			$oldOutput .= $itemOutput;
			$oldOutput .= '</div>';
			$oldOutput .= '</div>';
			$oldOutput .= '</div>';
			$itemsOutputArray[] = $itemOutput;
		}
		wp_reset_postdata();
		$oldOutput .= '</div>';
		$oldOutput .= '</div>' . "\n";

		if (defined('PIXFORT_SLIDER_OLD')) {
			wp_enqueue_script('pix-flickity-js');
			$output .= $oldOutput;
		}
		if (defined('PIXFORT_SLIDER_SWIPER')) {
			require_once PIX_CORE_PLUGIN_DIR . '/includes/elements/extras/slider.php';
			if (!filter_var($is_elementor, FILTER_VALIDATE_BOOLEAN)) {
				$attr['enable_wpb_navigation_styling'] = true;
			}
			if($cellalign === 'right'){
				if(!$righttoleft){
					$attr['reverseDirection'] = true;
					$first = $itemsOutputArray[0];
					$rest  = array_slice($itemsOutputArray, 1);
					$restR = array_reverse($rest);
					$itemsOutputArray = array_merge([$first], $restR);
				} 
				$attr['righttoleft'] = true;
			}
			$attr['items'] = $itemsOutputArray;
			$output .= pixfort_slider($attr, $content);
		}

		wp_reset_postdata();

		return $output;
	}
}
