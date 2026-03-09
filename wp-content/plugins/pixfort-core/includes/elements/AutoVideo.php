<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Auto Video
* --------------------------------------------------------------------------- */
class PixAutoVideo {

	function render($attr, $content = null) {

		extract(shortcode_atts(array(
			'mp4_video'  				=> '',
			'poster'  					=> '',
			'loop'  					=> '',
			'rounded_img'  				=> 'rounded-0',
			'alt'  						=> '',
			'align'  					=> 'text-left',
			'width' 					=> '',
			'height' 					=> '',
			'pix_scroll_parallax' 		=> '',
			'pix_tilt' 					=> '',
			'pix_tilt_size' 			=> 'tilt',
			'xaxis' 					=> '',
			'yaxis' 					=> '',
			'link' 						=> '',
			'target' 					=> '',
			'animation' 				=> '',
			'delay' 					=> '0',
			'style' 					=> '',
			'hover_effect' 				=> '',
			'add_hover_effect' 			=> '',
			'pix_infinite_animation' 	=> '',
			'pix_infinite_speed' 		=> '',
			'img_div' 					=> '',
			'pix_scale_in' 				=> '',
			'el_class' 					=> '',
			'css' 						=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		$css_class .= ' ' . $el_class;

		$output = '';
		// $width_attr = 'width="100%"';
		$width_attr = '';
		$height_attr = '';
		$inline_style = '';
		if (!empty($mp4_video)) $mp4_video = esc_url($mp4_video);
		if (!empty($width)) {
			if (strpos($width, '%') === false) {
				$width_attr = 'width="' . intval($width) . '"';
			}
			if (strpos($width, 'px') === false && strpos($width, '%') === false) {
				$width = intval($width) . 'px';
			}
			$inline_style .= 'max-width:100%;width:' . esc_attr($width) . ';';
			if (empty($height)) {
				// $height_attr = 'height="auto"';
				$height_attr = '';
			}
		}
		if (!empty($height)) {
			$height_attr = 'height="100%"';
			if (strpos($height, 'px') !== false && strpos($height, '%') === false) {
				$height_attr = 'height="' . intval($height) . '"';
			}
			if (empty($width)) {
				// $width_attr = 'width="auto"';
				$width_attr = '';
			}
		}

		if (!empty($mp4_video)) {
			$poster_tag = '';
			if (!empty($poster)) {
				if (!empty($poster['id'])) {
					$poster = $poster['id'];
				}
				if (is_int($poster)) {
					$poster = apply_filters('wpml_object_id', $poster, 'attachment', true);
				}
				$img = wp_get_attachment_image_src($poster, "full");
				if (!empty($img[0])) {
					$imgSrc = $img[0];
					$poster_tag = 'poster="' . $imgSrc . '"';
				}
			}

			$classes = [];
			$anim_type = '';
			$anim_delay = '';
			array_push($classes, esc_attr($css_class));

			$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
			array_push($classes, $effectsClasses);

			if (!empty($align)) {
				array_push($classes, $align);
			}
			array_push($classes, 'd-inline-block');
			$inline_style = 'style="' . $inline_style . '"';
			$class_names = join(' ', $classes);
			$containerClasses = '';
			if ($rounded_img === 'rounded-inherit') {
				$containerClasses .= 'rounded-inherit';
			}

			$jarallax = '';
			if ($pix_scroll_parallax) {
				if (!empty($xaxis) || !empty($yaxis)) {
					$jarallax = 'data-jarallax-element="' . $xaxis . ' ' . $yaxis . '" data-xaxis="' . $xaxis . '" data-yaxis="' . $yaxis . '" ';
				}
			}

			$transform_data = '';
            if(!empty($pix_scale_in) && $pix_scale_in === 'pix-advanced-transform') {
                $transform_data = \PixfortCore::instance()->styleFunctions->getTransformData($attr);
                if($transform_data) {
                    $transform_data = 'data-pix-transform=\'' . json_encode($transform_data)  . '\'';
                }
			}
			if (!empty($img_div)) {
				$output .= '<div class="pix-img-div ' . $img_div . ' ' . $containerClasses . '" ' . $transform_data . '>';
			} else {
				$output .= '<div class="d-flex w-100 pix-h-auto justify-content-center ' . $pix_scale_in . ' ' . $containerClasses . '" ' . $transform_data . '>';
			}
			if ($link) {
				$ntab = '';
				if (!empty($target)) {
					$ntab = 'target="_blank"';
				}
				if (!empty($pix_infinite_animation)) {
					$output .= '<div  ' . $inline_style . ' class="' . $pix_infinite_animation . ' ' . $pix_infinite_speed . ' ' . $containerClasses . '">';
				}
				if (!empty($animation)) {
					$anim_type = 'data-anim-type="' . $animation . '"';
					$anim_delay = 'data-anim-delay="' . $delay . '"';
					$output .= '<div  ' . $inline_style . ' class="animate-in d-inline-flex ' . $containerClasses . '" ' . $anim_type . ' ' . $anim_delay . '>';
				}
				if (!empty($pix_tilt)) {
					$output .= '<div  ' . $inline_style . ' class="w-100 pix-h-auto ' . $pix_tilt_size . ' ' . $containerClasses . '">';
				}
				$output .= '<a  ' . $inline_style . ' href="' . $link . '" ' . $ntab . ' class="' . $class_names . ' ' . $rounded_img . '" ' . $anim_type . ' ' . $anim_delay . ' ' . $jarallax . ' aria-label="Auto video">';
				$output .= '<video class="pix-video-bg-element d-block ' . $rounded_img . ' bg-video" ' . $width_attr . ' ' . $height_attr . ' preload="metadata" ' . $poster_tag . ' autoplay muted playsinline ' . $loop . '>
							<source src="' . $mp4_video . '" type="video/mp4" />
							</video>';

				$output .= '</a>';
				if (!empty($pix_tilt)) {
					$output .= '</div>';
				}
				if (!empty($animation)) {
					$output .= '</div>';
				}
				if (!empty($pix_infinite_animation)) {
					$output .= '</div>';
				}
			} else {
				if (!empty($pix_infinite_animation)) {
					$output .= '<div  ' . $inline_style . ' class="' . $pix_infinite_animation . ' ' . $pix_infinite_speed . ' ' . $containerClasses . '">';
				}
				if (!empty($animation)) {
					$anim_type = 'data-anim-type="' . $animation . '"';
					$anim_delay = 'data-anim-delay="' . $delay . '"';
					$output .= '<div  ' . $inline_style . ' class="animate-in w-100 pix-h-auto d-inline-flex ' . $containerClasses . '" ' . $anim_type . ' ' . $anim_delay . '>';
				}
				if (!empty($pix_tilt)) {
					$output .= '<div  ' . $inline_style . ' class="d-inline-block w-100 pix-h-auto ' . $pix_tilt_size . ' ' . $containerClasses . '">';
				}

				$output .= '<div  ' . $inline_style . ' class="' . $class_names . ' ' . $rounded_img . '"  ' . $jarallax . '>';

				$output .= '<video class="pix-video-bg-element d-block ' . $rounded_img . ' bg-video" ' . $width_attr . ' ' . $height_attr . ' preload="metadata"  ' . $poster_tag . ' autoplay muted playsinline ' . $loop . '>
							<source src="' . $mp4_video . '" type="video/mp4" />
							Your browser does not support the video tag. 
							</video>';
				$output .= '</div>';
				if (!empty($pix_tilt)) {
					$output .= '</div>';
				}
				if (!empty($animation)) {
					$output .= '</div>';
				}
				if (!empty($pix_infinite_animation)) {
					$output .= '</div>';
				}
			}
			$output .= '</div>';
		} else {
			$output = '<div class="pix-p-20">No Selectd Video!</div>';
		}

		return $output;
	}
}
