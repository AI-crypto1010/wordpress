<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Templates Carousel
* --------------------------------------------------------------------------- */
class PixTemplatesCarousel {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'items'  => '',
			'animation' 	=> '',
			'delay' 	=> '0',

			'slider_num'  => '3',
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
			'drag_scale'	=> false,
			'css' 		=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		wp_enqueue_style('pixfort-carousel-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/carousel-2.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');

		$elementor = false;
		$slides_arr = array();
		if (is_array($items)) {
			$slides_arr = $items;
			$elementor = true;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$slides_arr = vc_param_group_parse_atts($items);
			}
		}

		$output = '';
		$anim_type = '';
		$anim_delay = '';

		if (!filter_var($autoplay, FILTER_VALIDATE_BOOLEAN)) {
			$autoplay_time = false;
		} else {
			$autoplay_time = (int)$autoplay_time;
		}

		if (is_rtl()) {
			if ($slider_effect == 'pix-circular-left') {
				$slider_effect = 'pix-circular-right';
			} else if ($slider_effect == 'pix-circular-right') {
				$slider_effect = 'pix-circular-left';
			}
		}

		$slider_data = '';
		$pix_id = 'pix-slider-' . substr(md5(json_encode($slides_arr)), 0, 8);
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
			"slider_effect"		=> $slider_effect,
			"pix_id"			=> '#' . $pix_id,
		);
		$slider_data = json_encode($slider_opts);
		$slider_data = 'data-flickity=\'' . $slider_data . '\'';

		$itemsOutputArray = [];

		$oldOutput = '';
		if (!empty($slides_arr)) {
			$oldOutput  .= '<div class="' . $css_class . ' mb-4">';
			$oldOutput  .= '<div id="' . $pix_id . '" class="pix-main-slider pix-templates-carousel ' . $visible_overflow . ' ' . $slider_style . ' ' . $slider_effect . ' ' . $slider_scale . ' ' . $visible_y . ' pix-slider-' . $slider_num . ' pix-slider-dots ' . $dots_style . ' ' . $dots_align . '" ' . $slider_data . '>';
			
			foreach ($slides_arr as $key => $value) {
				$itemOutput = '';
				$pix_template_id = !empty($value['pix_template_id']) ? $value['pix_template_id'] : '';
				$template_id = !empty($pix_template_id) ? intval($pix_template_id) : 0;

				if (!empty($template_id)) {
					$oldOutput .= '<div class="carousel-cell">';
					$oldOutput .= '<div class="slide-inner ' . $cellpadding . '">';
					$oldOutput .= '<div class="pix-slider-effects">';

					if (!empty($animation)) {
						$anim_type = 'data-anim-type="' . $animation . '"';
						$anim_delay = 'data-anim-delay="' . $delay . '"';
						$itemOutput .= '<div class="animate-in d-inline-block w-100" ' . $anim_type . ' ' . $anim_delay . '>';
					}

					$itemOutput .= '<div class="pix-templates-carousel-item">';

					$itemOutput .= do_shortcode('[pixfort_template id="' . esc_attr($template_id) . '"]');
					
					$itemOutput .= '</div>';

					if (!empty($animation)) {
						$itemOutput .= '</div>';
					}

					$oldOutput .= $itemOutput;
					$oldOutput .= '</div>';
					$oldOutput .= '</div>';
					$oldOutput .= '</div>';
				}
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
				$attr['extra_classes'] = 'pix-wpbakery-carousel';
			}
			if ($cellalign === 'right') {
				if (!$righttoleft) {
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
