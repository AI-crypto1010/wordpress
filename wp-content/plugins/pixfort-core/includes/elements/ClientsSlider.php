<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* ClientsSlider
* --------------------------------------------------------------------------- */
class PixClientsSlider {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'title' 			=> '',
			'style' 			=> 'pix-box',
			'clients' 			=> '',
			'slider_num' 		=> 4,
			'css' 				=> '',
			'add_hover_effect' 	=> '',
			'animation' 		=> 'fade-in-Img',
			'delay' 			=> '0',
			'slider_num'  		=> '3',
			'slider_num_mobile'  => '1',
			'dots_style' 		=> '',
			'slider_style' 		=> 'pix-style-standard',
			'slider_effect' 	=> 'pix-effect-standard',
			'autoplay' 			=> false,
			'autoplay_time' 	=> '1500',
			'freescroll' 		=> false,
			'prevnextbuttons' 	=> true,
			'adaptiveheight' 	=> false,
			'pagedots' 			=> true,
			'dots_align' 		=> '',
			'cellalign' 		=> 'center',
			'slider_scale' 		=> '',
			'cellpadding' 		=> 'pix-p-10',
			'slider_wrap' 		=> false,
			'righttoleft' 		=> false,
			'visible_y' 		=> '',
			'visible_overflow' 	=> '',
			'delay_items' 		=> '',
		), $attr));

		$css_class = '';
		$classes = array();
		if (function_exists('vc_shortcode_custom_css_class') && defined('VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		wp_enqueue_style('pixfort-clients-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/clients.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		wp_enqueue_style('pixfort-carousel-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/carousel-2.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		
		$el_style = '';
		if ($style == 'no-effect') {
			$el_style = 'no-effect';
		}

		if ($style == 'pix-box') {
			$style = 'client shadow-hover-lg rounded-xl';
		}

		$add_hover_effect_arr = array(
			""       => "",
			"1"       => "fly-sm",
			"2"       => "fly",
			"3"       => "fly-lg",
			"4"       => "scale-sm",
			"5"       => "scale",
			"6"       => "scale-lg",
			"7"       => "scale-inverse-sm",
			"8"       => "scale-inverse",
			"9"       => "scale-inverse-lg",
		);

		if ($add_hover_effect) {
			array_push($classes, $add_hover_effect_arr[$add_hover_effect]);
		}
		$class_names = join(' ', $classes);

		if ($style == 'pix-box') {
			$style = 'client shadow-hover-lg rounded-xl';
		}

		$elementor = false;
		$clients_arr = array();
		if (is_array($clients)) {
			$clients_arr = $clients;
			$elementor = true;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$clients_arr = vc_param_group_parse_atts($clients);
			}
		}

		$delay = (int) $delay;
		$output  = '';

		$itemsOutputArray = [];

		if (!empty($clients_arr)) {

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

			$cellClasses = '';
			if (!$adaptiveheight) {
				$cellClasses = 'd-flex align-items-center min-100';
			}
			$oldOutput = '';
			$oldOutput  .= '<div class="' . $css_class . '">';
			$oldOutput  .= '<div id="' . $pix_id . '" class="pix-main-slider clients ' . $el_style . ' ' . $visible_overflow . ' ' . $slider_style . ' ' . $slider_effect . ' ' . $slider_scale . ' ' . $visible_y . ' pix-slider-' . $slider_num . ' pix-slider-dots ' . $dots_style . ' ' . $dots_align . '" ' . $slider_data . '>';
			foreach ($clients_arr as $key => $value) {
				$itemOutput = '';
				if (empty($value['title'])) {
					$value['title'] = '';
				}
				$oldOutput .= '<div class="carousel-cell ' . $cellClasses . '">';
				$oldOutput .= '<div class="slide-inner ' . $cellpadding . '">';
				$oldOutput .= '<div class="pix-slider-effects">';
				$itemOutput .= '<div class="text-center client">';
				$target = '_self';
				if (!empty($value['target'])) {
					$target = '_blank';
				}
				if (!empty($value['link'])) {
					$itemOutput .= '<a class="' . $class_names . ' d-block pix-p-20  ' . $style . '" target="' . $target . '" href="' . $value['link'] . '" title="' . $value['title'] . '">';
				} else {
					$itemOutput .= '<div class="' . $class_names . ' d-block pix-p-20 ' . $style . '" title="' . $value['title'] . '">';
				}

				if (!empty($value['image'])) {
					$title = '';
					if (!empty($value['title'])) $title = $value['title'];
					
					$itemOutput .= '<span class="d-block">';
					$imageOutput = \PixfortCore::instance()->coreFunctions->getDynamicImage($value['image'], 'full', [
						'class' => 'scale-with-grid animate-in',
						'alt' => $title,
						'data-anim-type' => $animation,
						'data-anim-delay' => $delay
					], isset($value['image_dark']) ? $value['image_dark'] : null);
					
					if (!empty($imageOutput)) {
						$itemOutput .= $imageOutput;
					}
					$itemOutput .= '</span>';
				}
				if (!empty($value['link'])) {
					$itemOutput .= '</a>';
				} else {
					$itemOutput .= '</div>';
				}
				$itemOutput .= '</div>';
				if (!empty($delay_items)) {
					$delay += 200;
				}
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
