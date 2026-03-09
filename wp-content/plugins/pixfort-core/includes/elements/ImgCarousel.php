<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* ImgCarousel
* --------------------------------------------------------------------------- */
class PixImgCarousel {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'items'  => '',
			'rounded_img'  => 'rounded-0',
			'align'  => 'text-left',
			'pix_scroll_parallax' 	=> '',
			'pix_tilt' 	=> '',
			'pix_tilt_size' 	=> 'tilt',
			'xaxis' 	=> '',
			'yaxis' 	=> '',
			'animation' 	=> '',
			'delay' 	=> '0',
			'style' 		=> '',
			'hover_effect' 		=> '',
			'add_hover_effect' 		=> '',
			'pix_infinite_animation' 		=> '',
			'pix_infinite_speed' 		=> '',

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
		$classes = [];
		$anim_type = '';
		$anim_delay = '';

		$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
		array_push($classes, $effectsClasses);

		if (!empty($align)) {
			array_push($classes, $align);
			array_push($classes, "w-100");
		}
		$inline_style = '';
		array_push($classes, 'd-inline-block');


		$inline_style = 'style="' . $inline_style . '"';
		$class_names = join(' ', $classes);

		$jarallax = '';
		if ($pix_scroll_parallax) {
			if (!empty($xaxis) || !empty($yaxis)) {
				$jarallax = 'data-jarallax-element="' . $xaxis . ' ' . $yaxis . '" data-xaxis="' . $xaxis . '" data-yaxis="' . $yaxis . '"';
			}
		}

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
			"slider_effect"			=> $slider_effect,
			"pix_id"			=>  '#' . $pix_id,
		);
		$slider_data = json_encode($slider_opts);
		$slider_data = 'data-flickity=\'' . $slider_data . '\'';

		$itemsOutputArray = [];

		$oldOutput = '';
		if (!empty($slides_arr)) {
			$oldOutput  .= '<div class="' . $css_class . ' mb-4">';
			$oldOutput  .= '<div id="' . $pix_id . '" class="pix-main-slider ' . $visible_overflow . ' ' . $slider_style . ' ' . $slider_effect . ' ' . $slider_scale . ' ' . $visible_y . ' pix-slider-' . $slider_num . ' pix-slider-dots ' . $dots_style . ' ' . $dots_align . '" ' . $slider_data . '>';
			foreach ($slides_arr as $key => $value) {
				$itemOutput = '';

				if (!empty($value['image'])) {
					$imgSrcset = '';
					$imgSizes = '';
					$imgSrc = '';
					$imgWidth = '';
					$imgHeight = '';
					if (is_string($value['image']) && substr($value['image'], 0, 4) === "http") {
						$imgSrc = $value['image'];
					} else {
						$imageID = false;
						if ($elementor) {
							$imageID = $value['image']['id'];
						} else {
							$imageID = $value['image'];
						}
						if (function_exists('icl_get_languages')) {
							if (is_int($imageID)) {
								$imageID = apply_filters('wpml_object_id', $imageID, 'attachment', true);
							}
						}
						$img = wp_get_attachment_image_src($imageID, "full");
						$imgSrcset = wp_get_attachment_image_srcset($imageID);
						$imgSizes = wp_get_attachment_image_sizes($imageID, "full");
						if (!empty($img[0])) {
							if (!empty($img[1]) && !empty($img[2])) {
								$imgWidth = 'width="' . $img[1] . '"';
								$imgHeight = 'height="' . $img[2] . '"';
							}
							$imgSrc = $img[0];
						}
					}

					$oldOutput .= '<div class="carousel-cell">';
					$oldOutput .= '<div class="slide-inner ' . $cellpadding . '">';
					$oldOutput .= '<div class="pix-slider-effects">';
					if (empty($value['alt'])) $value['alt'] = '';
					if (!empty($value['link'])) {
						$ntab = '';
						if (!empty($value['target'])) {
							$ntab = 'target="_blank"';
						}
						if (!empty($pix_infinite_animation)) {
							$itemOutput .= '<div class="' . $pix_infinite_animation . ' ' . $pix_infinite_speed . '">';
						}
						if (!empty($animation)) {
							$anim_type = 'data-anim-type="' . $animation . '"';
							$anim_delay = 'data-anim-delay="' . $delay . '"';
							$itemOutput .= '<div class="animate-in d-inline-block" ' . $anim_type . ' ' . $anim_delay . '>';
						}
						if (!empty($pix_tilt)) {
							$itemOutput .= '<div class="' . $pix_tilt_size . '">';
						}
						$itemOutput .= '<a href="' . $value['link'] . '" ' . $ntab . ' class="' . $class_names . ' ' . $rounded_img . '" ' . $jarallax . '>';
						$itemOutput .= '<img class="card-img ' . $rounded_img . ' h-100" ' . $imgWidth . ' ' . $imgHeight . ' sizes="' . $imgSizes . '" srcset="' . $imgSrcset . '" src="' . $imgSrc . '" alt="' . $value['alt'] . '" ' . $inline_style . '/>';
						$itemOutput .= '</a>';
						if (!empty($pix_tilt)) {
							$itemOutput .= '</div>';
						}
						if (!empty($animation)) {
							$itemOutput .= '</div>';
						}
						if (!empty($pix_infinite_animation)) {
							$itemOutput .= '</div>';
						}
					} else {
						if (!empty($pix_infinite_animation)) {
							$itemOutput .= '<div class="' . $pix_infinite_animation . ' ' . $pix_infinite_speed . '">';
						}
						if (!empty($animation)) {
							$anim_type = 'data-anim-type="' . $animation . '"';
							$anim_delay = 'data-anim-delay="' . $delay . '"';
							$itemOutput .= '<div class="animate-in d-inline-block w-100" ' . $anim_type . ' ' . $anim_delay . '>';
						}
						if (!empty($pix_tilt)) {
							$itemOutput .= '<div class="' . $pix_tilt_size . '">';
						}

						$itemOutput .= '<div class="' . $class_names . ' ' . $rounded_img . '"  ' . $jarallax . '>';
						$itemOutput .= '<img class="card-img ' . $rounded_img . ' h-100" ' . $imgWidth . ' ' . $imgHeight . ' srcset="' . $imgSrcset . '" sizes="' . $imgSizes . '" src="' . $imgSrc . '" alt="' . $value['alt'] . '" ' . $inline_style . '/>';
						$itemOutput .= '</div>';

						if (!empty($pix_tilt)) {
							$itemOutput .= '</div>';
						}
						if (!empty($animation)) {
							$itemOutput .= '</div>';
						}
						if (!empty($pix_infinite_animation)) {
							$itemOutput .= '</div>';
						}
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
