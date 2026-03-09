<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* PhotoStack
* --------------------------------------------------------------------------- */
class PixPhotoStack {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'images'  => '',
			'pix_scroll_parallax' 	=> '',
			'pix_tilt' 	=> '',
			'pix_tilt_size' 	=> 'tilt',
			'xaxis' 	=> '',
			'yaxis' 	=> '',
			'link' 	=> '',
			'target' 	=> '',
			'animation' 	=> '',
			'delay' 	=> '0',
			'style' 		=> '',
			'hover_effect' 		=> '',
			'add_hover_effect' 		=> '',
			'pix_infinite_animation' 		=> '',
			'pix_infinite_speed' 		=> '',
			'rounded_img' 		=> 'rounded-lg',
			'css' 		=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		wp_enqueue_style('pixfort-photo-stack-style', PIX_CORE_PLUGIN_URI.'includes/assets/css/elements/photo-stack.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');

		$elementor = false;
		if (is_array($images)) {
			$items = $images;
			$elementor = true;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$items = vc_param_group_parse_atts($images);
			}
		}

		$output = '';
		$class_names = '';

		$classes = array();
		$anim_type = '';
		$anim_delay = '';
		array_push($classes, $rounded_img);

	
		$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
        array_push($classes, $effectsClasses);

		if (!empty($align)) {
			array_push($classes, $align);
			array_push($classes, "w-100");
		}
		$inline_style = '';
		if (!empty($width)) {
			$inline_style .= 'max-width:' . $width . ';';
		} else {
			if (!empty($height)) {
				$inline_style .= 'width:auto;';
			}
		}
		if (!empty($height)) {
			$inline_style .= 'max-height:' . $height . ';';
		} else {
			$inline_style .= 'height:auto;';
		}
		array_push($classes, 'd-inline-block');

		$inline_style = 'style="' . $inline_style . '"';
		$class_names = join(' ', $classes);

		$jarallax = '';
		if ($pix_scroll_parallax) {
			$jarallax = 'data-jarallax-element="' . $xaxis . ' ' . $yaxis . '" data-xaxis="' . $xaxis . '" data-yaxis="' . $yaxis . '"';
		}
		$output = '';


		if (!empty($items)) {
			$stack_class = "";
			$delay = (int) $delay;
			if (count($items) == 2) {
				$stack_class = "pix-img-2";
			} elseif (count($items) > 2) {
				$stack_class = "pix-img-n";
			}
			$output .= '<div class="pix-photo-stack position-relative w-100 d-inline-block ' . $stack_class . ' ' . $css_class . '">';
			foreach ($items as $key => $value) {
				$imgSrc = '';
				if (!empty($value['image'])) {
					$imgWidth = '';
					$imgHeight = '';
					$imgSrcset = '';
					if (is_string($value['image']) && substr($value['image'], 0, 4) === "http") {
						$img = $value['image'];
						$imgSrc = $img;
					} else {
						if ($elementor) {
							if ( is_int( $value['image']['id'] ) ) {
								$value['image']['id'] = apply_filters( 'wpml_object_id', $value['image']['id'], 'attachment', true );
							}
							$img = wp_get_attachment_image_src($value['image']['id'], "full");
							$imgSrcset = wp_get_attachment_image_srcset($value['image']['id']);
						} else {
							if ( is_int( $value['image'] ) ) {
								$value['image'] = apply_filters( 'wpml_object_id', $value['image'], 'attachment', true );
							}
							$img = wp_get_attachment_image_src($value['image'], "full");
							$imgSrcset = wp_get_attachment_image_srcset($value['image']);
						}
						if (!empty($img[0])) {
							$imgSrc = $img[0];
						}
					}
					if (!empty($img[1]) && !empty($img[2])) {
						$imgWidth = 'width="' . $img[1] . '"';
						$imgHeight = 'height="' . $img[2] . '"';
					}

					$alt = '';
					if (!empty($value['alt'])) {
						$alt = $value['alt'];
					}
					$output .= '<div class="img-el" >';

					if (!empty($pix_infinite_animation)) {
						$output .= '<div class="w-100 ' . $pix_infinite_animation . ' ' . $pix_infinite_speed . '">';
					}
					if (!empty($animation)) {
						$anim_type = 'data-anim-type="' . $animation . '"';
						$anim_delay = 'data-anim-delay="' . $delay . '"';
						$output .= '<div class="animate-in d-inline-block w-100" ' . $anim_type . ' ' . $anim_delay . '>';
						$delay += 100;
					}
					if (!empty($pix_tilt)) {
						$output .= '<div class="' . $pix_tilt_size . '">';
					}
					$output .= '<img ' . $imgWidth . ' ' . $imgHeight . ' class="' . $class_names . '" srcset="' . $imgSrcset . '" src="' . $imgSrc . '" alt="' . $alt . '" />';
					if (!empty($pix_tilt)) {
						$output .= '</div>';
					}
					if (!empty($animation)) {
						$output .= '</div>';
					}
					if (!empty($pix_infinite_animation)) {
						$output .= '</div>';
					}
					$output .= '</div>';
				}
			}
			$output .= '</div>';
		}
		return $output;
	}
}


