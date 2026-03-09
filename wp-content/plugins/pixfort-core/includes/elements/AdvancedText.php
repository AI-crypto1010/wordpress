<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
 * Advanced Text [sc_pix_advanced_text] [/sc_pix_advanced_text]
* --------------------------------------------------------------------------- */
class PixAdvancedText {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'position'  			=> '',
			'size'  				=> '',
			'secondary_font'		=> '',
			'content_color'			=> '',
			'content_custom_color'	=> '',
			'max_width'  			=> '',
			'animation' 			=> '',
			'delay' 				=> '0',
			'remove_pb_padding' 	=> '',
			'element_id' 			=> '',
			'css' 					=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		if (empty($element_id)) {
			$element_id = 'advanced-text-' . rand(1, 200000000);
		} else {
			if (is_numeric($element_id[0])) {
				$element_id = 'el' . $element_id;
			}
		}

		$customStyle = '';
		if (!empty($size)) {
			if (is_numeric($size)) {
				$size .= 'px';
			}
			$customStyle .= '#' . $element_id . ' p {font-size:' . $size . ';}';
		}
		if (!empty($secondary_font)) {
			$customStyle .= '#' . $element_id . '.secondary-font p {font-family:var(--pix-heading-font);}';
		}
		if (!empty($remove_pb_padding)) {
			$customStyle .= '#' . $element_id . '.m-0 p {margin-bottom:0;}';
		}
		if (!empty($content_color)) {
			if ($content_color === 'custom') {
				if (!empty($content_custom_color)) {
					$customStyle .= '#' . $element_id . ' p {color:' . $content_custom_color . ';}';
				}
			} else {
				$customStyle .= '#' . $element_id . ' p {color:var(--pix-' . $content_color . ');}';
			}
		}
		if (!empty($customStyle)) {
			$handle = 'pix-advanced-text-' . $element_id;
			wp_register_style($handle, false);
			wp_enqueue_style($handle);
			wp_add_inline_style($handle, $customStyle);
		}

		$output = '<div id="' . $element_id . '" class="pix-el-text ' . $remove_pb_padding . ' ' . $secondary_font . ' w-100 ' . $position . ' ' . esc_attr($css_class) . '" >';
		if (!empty($max_width)) {
			if (is_numeric($max_width)) $max_width = $max_width . 'px';
			$output .= '<div class="d-inline-block" style="max-width:' . $max_width . ';">';
		}
		if (function_exists('wpb_js_remove_wpautop')) {
			if (empty($animation)) {
				$output .= '<p class="' . $position . '">' .  wpb_js_remove_wpautop($content, true) . '</p>';
			} else {
				$output .= '<p class="' . $position . '"><div class="animate-in d-inline-block" data-anim-delay="' . $delay . '" data-anim-type="' . $animation . '">' . wpb_js_remove_wpautop($content, true) . '</div></p>';
			}
		}
		if (!empty($max_width)) {
			$output .= '</div>';
		}
		$output .= '</div>';
		return $output;
	}
}
