<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* HighlightBox
* --------------------------------------------------------------------------- */
class PixHighlightBox {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'image' 	=> '',
			'layout' 	=> 'wide_card_right',
			'style' 		=> '',
			'pix_infinite_animation' 		=> '',
			'pix_infinite_speed' 		=> 'pix-duration-fast',
			'hover_effect' 		=> '',
			'add_hover_effect' 		=> '',
			'rounded_img' 	=> '',
			'animation' 	=> '',
			'delay' 	=> '0',
			'content_area_css' 		=> '',
			'css' 		=> '',
		), $attr));


		$css_class = '';
		$content_css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
			$content_css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($content_area_css, ' '));
		}

		$classes = ' ';
		$classes .= esc_attr($css_class) . ' ';

		$classes .= \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect) . ' ';

		$anim_attrs = '';
		if (!empty($animation)) {
			$classes .= ' animate-in ';
			$anim_attrs = 'data-anim-delay="' . $delay . '" data-anim-type="' . $animation . '"';
		}


		$output = '';
		if ($layout == 'wide_card_left' || $layout == 'wide_card_right') {

			$output = '<div class="card ' . $rounded_img . ' overflow-hidden row no-gutters flex-column flex-md-row flex-md-row-reverse ' . $classes . '" ' . $anim_attrs . '>';
			$out_img = '';
			if (!empty($image)) {
				$imgSrcset = '';
				$imgSrc = '';
				$image_alt = '';
				if (is_string($image) && substr($image, 0, 4) === "http") {
					$img = $image;
					$imgSrc = $img;
				} else {
					if (!empty($image['id'])) {
						if ( is_int( $image['id'] ) ) {
							$image['id'] = apply_filters( 'wpml_object_id', $image['id'], 'attachment', true );
						}
						$img = wp_get_attachment_image_src($image['id'], "full");
						$imgSrcset = wp_get_attachment_image_srcset($image['id']);
					} else {
						if ( is_int( $image ) ) {
							$image = apply_filters( 'wpml_object_id', $image, 'attachment', true );
						}
						$img = wp_get_attachment_image_src($image, "full");
						$imgSrcset = wp_get_attachment_image_srcset($image);
						$image_alt = get_post_meta($image, '_wp_attachment_image_alt', TRUE);
					}
					if (!empty($img[0])) $imgSrc = $img[0];
				}
				$out_img .= '<div class="flex-column d-inline-flex position-relative col-md-6">';
				if (empty($pix_infinite_animation) || $pix_infinite_animation == '') {
					$out_img .= '<img class="card-img pix-fit-cover rounded-0 flex-grow-1 h-100" srcset="' . $imgSrcset . '" src="' . $imgSrc . '" alt="'.$image_alt.'" />';
				} else {
					$out_img .= '<div class="' . $pix_infinite_animation . ' ' . $pix_infinite_speed . ' w-100 h-100" style="background-image:url(' . $imgSrc . ');">';
					$out_img .= '<img style="opacity:0;" class="card-img pix-fit-cover rounded-0 flex-grow-1 h-100" srcset="' . $imgSrcset . '" src="' . $imgSrc . '" alt="'.$image_alt.'" />';
					$out_img .= '</div>';
				}

				$out_img .= '</div>';
			}

			$out_body = '';
			$out_body .= '<div class="card-body d-flex2 align-content-between flex-wrap col-md-6 p-lg-5 p-md-5 p-4 ' . $content_css_class . '">';
			$out_body .= do_shortcode($content);
			$out_body .= '</div>';

			if ($layout == 'wide_card_left') {
				$output .= $out_body;
				$output .= $out_img;
			} else {
				$output .= $out_img;
				$output .= $out_body;
			}

			$output .= '</div>' . "\n";
		}
		return $output;
	}
}
