<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Text
* --------------------------------------------------------------------------- */
class PixText {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'content_type'  		=> 'simple',
			'content_wysiwyg'  		=> '',
			'size'  				=> '',
			'bold'					=> '',
			'italic'				=> '',
			'secondary_font'		=> '',
			'content_color'			=> '',
			'content_custom_color'	=> '',
			'position'  			=> '',
			'max_width'  			=> '',
			'animation' 			=> '',
			'delay' 				=> '0',
			'remove_pb_padding' 	=> '',
			'element_id' 	=> '',
			'css' 					=> ''
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		$text_classes = pix_get_text_format_classes($bold, $italic, $secondary_font);

		$c_color = '';
		$c_custom_color = '';
		if (!empty($content_color)) {
			if ($content_color != 'custom') {
				$c_color = 'text-' . $content_color;
			} else {
				$c_color = 'el-content_custom_color';
				$c_custom_color = 'style="color:' . $content_custom_color . ';"';
			}
		}

		$output = '<div class="pix-el-text w-100 ' . $position . ' ' . esc_attr($css_class) . '" >';
		if (!empty($max_width)) {
			if (is_numeric($max_width)) $max_width = $max_width . 'px';
			$output .= '<div class="d-inline-block" style="max-width:' . $max_width . ';">';
		}
		if ($content_type === 'advanced') {
			$content_wysiwyg = shortcode_unautop( $content_wysiwyg );
			$content_wysiwyg = do_shortcode( $content_wysiwyg );
			$content_wysiwyg = wptexturize( $content_wysiwyg );
			if ( $GLOBALS['wp_embed'] instanceof \WP_Embed ) {
				$content_wysiwyg = $GLOBALS['wp_embed']->autoembed( $content_wysiwyg );
			}
			if (empty($animation)) {
				$output .= '<p class="' . $remove_pb_padding . ' ' . $position . ' ' . $text_classes . '">' .  do_shortcode($content_wysiwyg)  . '</p>';
			} else {
				$output .= '<p class="' . $remove_pb_padding . ' ' . $position . ' ' . $text_classes . '"><div class="' . $c_color . ' animate-in d-inline-block" data-anim-delay="' . $delay . '" data-anim-type="' . $animation . '">' . do_shortcode($content_wysiwyg) . '</div></p>';
			}
		} else {
			if (empty($animation)) {
				$output .= '<p class="' . $size . ' ' . $remove_pb_padding . ' ' . $c_color . ' ' . $position . ' ' . $text_classes . '" ' . $c_custom_color . '>' .  do_shortcode($content) . '</p>';
			} else {
				$output .= '<p class="' . $size . ' ' . $remove_pb_padding . ' ' . $c_color . ' ' . $position . ' ' . $text_classes . '" ' . $c_custom_color . '><span class="' . $c_color . ' animate-in d-inline-block" data-anim-delay="' . $delay . '" data-anim-type="' . $animation . '">' . do_shortcode($content) . '</span></p>';
			}
		}

		if (!empty($max_width)) {
			$output .= '</div>';
		}
		$output .= '</div>';


		return $output;
	}
}
