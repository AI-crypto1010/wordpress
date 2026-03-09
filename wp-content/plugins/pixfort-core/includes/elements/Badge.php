<?php


if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
 * Badge
* --------------------------------------------------------------------------- */
class PixBadge {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'text'					=> '',
			'text_color'			=> 'primary',
			'text_custom_color'		=> '',
			'text_size'				=> 'h6',
			'text_custom_size'		=> '',
			'bold'  				=> '',
			'italic'  				=> '',
			'secondary_font'  		=> '',
			'rounded' 				=> '',
			'bg_color'				=> 'primary-light',
			'custom_bg_color'		=> '',
			'style' 				=> '',
			'hover_effect' 			=> '',
			'add_hover_effect' 		=> '',
			'animation' 			=> '',
			'delay' 				=> '0',
			'link' 					=> '',
			'target' 				=> '',
			'element_div' 			=> '',
			'css' 					=> '',
			'extra_classes' 		=> '',
			'custom_css' 			=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
			$css_class .= ' ' . apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($custom_css, ' '));
		}
		$css_class .= ' ' . $extra_classes;
		$text = pix_unescape_vc($text);

		$classes = array();
		$span_classes = array();
		// if ($bold != 'font-weight-bold') $bold = 'font-weight-normal';
		if (!empty($bold)) array_push($classes, $bold);
		if (!empty($italic)) array_push($classes, $italic);
		if (!empty($secondary_font)) array_push($classes, $secondary_font);
		if (!empty($rounded)) array_push($classes, $rounded);


		$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
		array_push($classes, $effectsClasses);

		$span_custom_style = '';

		if (!empty($text_color)) {
			if ($text_color != 'custom') {
				array_push($span_classes, 'text-' . $text_color);
				if (str_contains($text_color, 'gradient')) {
					array_push($span_classes, 'pix-bg-attachment-scroll text-bg-img');
				}
			} else {
				$span_custom_style = 'color:' . $text_custom_color . ';';
			}
		}

		$t_custom_style = '';
		if ($text_size == 'custom' && !empty($text_custom_size)) {
			$t_custom_style = "font-size:" . $text_custom_size . ';';
		}

		if (!empty($bg_color)) {
			if ($bg_color != 'custom') {
				array_push($classes, 'bg-' . $bg_color);
				if (str_contains($bg_color, 'gradient')) {
					array_push($classes, 'pix-bg-attachment-scroll text-bg-img');
				}
			} else {
				$t_custom_style .= 'background:' . $custom_bg_color . ';';
			}
		}

		$anim_type = '';
		$anim_delay = '';
		$anim = '';
		if (!empty($animation)) {
			$anim = 'animate-in';
			$anim_type = 'data-anim-type="' . $animation . '"';
			$anim_delay = 'data-anim-delay="' . $delay . '"';
		}

		$class_names = join(' ', $classes);
		$span_class_names = join(' ', $span_classes);

		$output = '';

		if (!empty($element_div)) {
			$output .= '<div class="pix-element-div w-100 ' . $element_div . '">';
		}
		if (empty($target)) $target = '_self';
		if (!empty($link)) {
			$output .= '<a href="' . $link . '" target="' . $target . '">';
		}

		$margin1 = '';
		if (defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG == 'essentials') {
			// Deprecated
			$margin1 = is_rtl() ? 'ml-1' : 'mr-1';
		}
		$output .= '<span class="pix-badge-element ' . $text_size . ' d-inline-flex ' . $margin1 . ' ' . $anim . '" ' . $anim_type . ' ' . $anim_delay . '>';
		$output .= '<span class="badge ' . $class_names . ' ' . $css_class . '" style="' . $t_custom_style . ' ' . $custom_css . '">';
		$output .= '<span class="' . $span_class_names . '" style="' . $span_custom_style . '">';
		$output .= do_shortcode($text);
		$output .= '</span>';
		$output .= '</span>';
		$output .= '</span>';
		if (!empty($link)) {
			$output .= '</a>';
		}
		if (!empty($element_div)) {
			$output .= '</div>';
		}

		return $output;
	}
}
