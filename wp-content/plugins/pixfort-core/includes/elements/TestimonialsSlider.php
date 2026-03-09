<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* TestimonialsSlider
* --------------------------------------------------------------------------- */
class PixTestimonialsSlider {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'title' 	=> '',
			'style' 	=> '',
			'testimonials' 	=> '',
			'img_style' 	=> 'circle_bottom',
			'slider_num'  => '3',
			'slider_num_mobile'  => '1',
			'dots_style' 	=> '',
			'slider_style' 	=> 'pix-style-standard',
			'slider_effect' 	=> 'pix-effect-standard',
			'autoplay' 	=> false,
			'autoplay_time' 	=> '1500',
			'freescroll' 	=> false,
			'prevnextbuttons' 	=> true,
			'adaptiveheight' 	=> false,
			'pagedots' 	=> true,
			'dots_align' 	=> '',
			'cellalign' 	=> 'center',
			'slider_scale' 	=> '',
			'cellpadding' 	=> 'pix-p-10',
			'slider_wrap' 	=> false,
			'righttoleft' 	=> false,
			'visible_y' 	=> '',
			'visible_overflow' 	=> '',
			'animation' 	=> '',
			'delay' 	=> '0',
			'css' 	=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		wp_enqueue_style('pixfort-carousel-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/carousel-2.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		
		$elementor = false;
		$testimonials_arr = [];
		if (is_array($testimonials)) {
			$testimonials_arr = $testimonials;
			$elementor = true;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$testimonials_arr = vc_param_group_parse_atts($testimonials);
			}
		}

		$itemsOutputArray = [];

		$output  = '';
		$oldOutput = '';
		if (!empty($testimonials_arr)) {

			$anim_type = '';
			$anim_delay = '';
			if (!empty($animation)) {
				$anim_type = 'data-anim-type="' . $animation . '"';
				$anim_delay = 'data-anim-delay="' . $delay . '"';
				$css_class .= ' animate-in';
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
				"autoPlay"			=> $autoplay_time,
				"freeScroll"		=> filter_var($freescroll, FILTER_VALIDATE_BOOLEAN),
				"prevNextButtons"	=> filter_var($prevnextbuttons, FILTER_VALIDATE_BOOLEAN),
				"wrapAround"		=> filter_var($slider_wrap, FILTER_VALIDATE_BOOLEAN),
				"pageDots"			=> filter_var($pagedots, FILTER_VALIDATE_BOOLEAN),
				"adaptiveHeight"	=> filter_var($adaptiveheight, FILTER_VALIDATE_BOOLEAN),
				"rightToLeft"		=> filter_var($righttoleft, FILTER_VALIDATE_BOOLEAN),
				"cellAlign" 		=> $cellalign,
				"contain"			=> true,
				"slider_effect"			=> $slider_effect,
				"pix_id"			=>  '#' . $pix_id,
			);
			$slider_data = json_encode($slider_opts);
			$slider_data = 'data-flickity=\'' . $slider_data . '\'';
			if ($visible_overflow == 'pix-overflow-all-visible') $visible_y = '';

			$oldOutput  .= '<div class="' . $css_class . '" ' . $anim_type . ' ' . $anim_delay . '>';
			$oldOutput  .= '<div id="' . $pix_id . '" class="pix-main-slider ' . $visible_overflow . ' ' . $slider_style . ' ' . $slider_effect . ' ' . $slider_scale . ' ' . $visible_y . ' pix-slider-' . $slider_num . ' pix-slider-dots ' . $dots_style . ' ' . $dots_align . '" ' . $slider_data . '>';
			foreach ($testimonials_arr as $key => $value) {
				$itemOutput = '';
				$oldOutput .= '<div class="carousel-cell">';
				$oldOutput .= '<div class="slide-inner ' . $cellpadding . '">';
				$oldOutput .= '<div class="pix-slider-effects">';
				$itemOutput .= '<div class="card">';
				$t_attrs = $attr;
				$t_attrs['css'] = '';
				if (!empty($value['image'])) $t_attrs['image'] = $value['image'];
				if (!empty($value['name'])) $t_attrs['name'] = $value['name'];
				if (!empty($value['title'])) $t_attrs['title'] = $value['title'];
				if (!empty($value['text'])) $t_attrs['text'] = $value['text'];
				if (!empty($value['link'])) $t_attrs['link'] = $value['link'];
				if (!empty($value['target'])) $t_attrs['target'] = $value['target'];
				$itemOutput .= \PixfortCore::instance()->elementsManager->renderElement('Testimonial', $t_attrs );
				$itemOutput .= '</div>';
				$oldOutput .= $itemOutput;
				
				$oldOutput .= '</div>';
				$oldOutput .= '</div>';
				$oldOutput .= '</div>';
				$itemsOutputArray[] = $itemOutput;
			}
			$oldOutput .= '</div>';
			$oldOutput .= '</div>';
		}

		if (defined('PIXFORT_SLIDER_OLD')) {
			wp_enqueue_script('pix-flickity-js');
			$output .= $oldOutput;
		}
		if (defined('PIXFORT_SLIDER_SWIPER')) {
			require_once PIX_CORE_PLUGIN_DIR . '/includes/elements/extras/slider.php';
			if (!$elementor) {
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

		return $output;
	}
}

