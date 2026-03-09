<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* VideoPopup
* --------------------------------------------------------------------------- */
class PixVideoPopup {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'embed_code'  => '',
			'is_elementor'  => false,
			'image'  => '',
			'rounded_img'  => 'rounded-0',
			'aspect' 	=> 'embed-responsive-21by9',
			'text_color' 	=> 'primary',
			'custom_bg_color'		=> '',
			'bg_color'		=> 'white',
			'custom_bg_color'		=> '',
			'size'		=> '100',
			'icon_style'		=> 'due',
			'animation' 	=> '',
			'delay' 	=> '0',
			'css' 	=> '',
		), $attr));

		$output = '';
		$classes = array();
		$anim_type = '';
		$anim_delay = '';


		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		array_push($classes, $css_class);

		$class_names = join(' ', $classes);

		$span_classes = array();
		$icon_classes = array();
		$span_custom_style = '';
		$icon_custom_style = '';
		if (!empty($text_color)) {
			if ($text_color != 'custom') {
				array_push($icon_classes, 'text-' . $text_color);
			} else {
				$icon_custom_style = 'color:' . $text_custom_color . ';';
			}
		}
		$span_custom_style .= 'width:' . $size . 'px;';
		$span_custom_style .= 'height:' . $size . 'px;';
		if ((int)$size) {
			$fize = (int)$size / 3.3;
			$icon_custom_style .= 'font-size:' . $fize . 'px;';
		}
		if (!empty($bg_color)) {
			if ($text_color != 'custom') {
				array_push($span_classes, 'bg-' . $bg_color);
			} else {
				$span_custom_style = 'color:' . $custom_bg_color . ';';
			}
		}

		$span_custom_style = 'style="' . $span_custom_style . '"';
		$icon_custom_style = 'style="' . $icon_custom_style . '"';
		$span_classes_names = join(' ', $span_classes);
		$icon_classes_names = join(' ', $icon_classes);

		if (!$is_elementor) $embed_code = rawurldecode(base64_decode($embed_code));
		$res = preg_replace("/[\`]/", "", $embed_code);


		if (!empty($animation)) {
			$anim_type = 'data-anim-type="' . $animation . '"';
			$anim_delay = 'data-anim-delay="' . $delay . '"';
			$output .= '<div class="animate-in d-inline-block" ' . $anim_type . ' ' . $anim_delay . '>';
		}
		$output .= '<div class="d-inline-block align-middle ' . $class_names . '">';
		$output .= '<a href="#" class="pix-video-popup d-inline-block" data-aspect="' . $aspect . '" data-content="' . esc_attr($res) . '"  aria-label="Video Popup">';
		$output .= '<span class="rounded-circle d-inline-block2 d-inline-flex align-items-center justify-content-center line-height-0 pix-p-10 scale shadow-lg ' . $span_classes_names . '" ' . $span_custom_style . '>';
		if ($icon_style == 'due') {
			$output .= '<span class="' . $icon_classes_names . '" ' . $icon_custom_style . '>';
			$output .= \PixfortCore::instance()->icons->getIcon('Solid/pixfort-icon-play-2', 50, 'm-0 p-0');
			$output .= '</span>';
		} else {
			$output .= '<span class="' . $icon_classes_names . '" ' . $icon_custom_style . '>';
			$output .= \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-play-1', 50, 'm-0 p-0');
			$output .= '</span>';
		}
		$output .= '</span>';
		$output .= '</a>';
		$output .= '</div>';
		if (!empty($animation)) {
			$output .= '</div>';
		}
		return $output;
	}
}

