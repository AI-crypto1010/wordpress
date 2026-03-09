<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Faq
* --------------------------------------------------------------------------- */
class PixFaq {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'title'					=> '',
			'title_color'			=> 'heading-default',
			'title_custom_color'	=> '',
			'title_bold'			=> '',
			'title_secondary'		=> '',
			'title_size'			=> 'h1',
			'title_custom_size'		=> '',
			'content_bold'			=> '',
			'content_secondary'		=> '',
			'content_size'			=> '',
			'content_color'			=> 'body-default',
			'content_custom_color'	=> '',
			'h1'					=> '',
			'media_type' 			=> 'icon',
			'pix_duo_icon' 			=> '',
			'icon'					=> 'pixicon-question-circle',
			'icon_has_color' 		=> '',
			'icon_color' 			=> 'heading-default',
			'icon_custom_color' 	=> 'heading-default',
			'slogan' 				=> '',
			'style' 				=> '',	// icon, line, arrows
			'position'  			=> 'center',
			'animation' 			=> '',
			'delay' 				=> '0',
			'content_animation' 	=> '',
			'content_delay' 		=> '0',
			'css' 					=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		$t_color = '';
		$t_color = '';
		$t_custom_color = '';
		if (!empty($title_color)) {
			if ($title_color != 'custom') {
				$t_color = 'text-' . $title_color;
			} else {
				$t_custom_color = 'color:' . $title_custom_color . ' !important;';
			}
		}
		if (!empty($title_bold)) {
			$t_color .= ' ' . $title_bold;
		}
		if (!empty($title_secondary)) {
			$t_color .= ' ' . $title_secondary;
		}

		$c_classes = '';
		$c_custom_color = '';
		if (!empty($content_color)) {
			if ($content_color != 'custom') {
				$c_classes = 'text-' . $content_color;
			} else {
				$c_custom_color = 'color:' . $content_custom_color . ' !important;';
			}
		}

		if (!empty($content_bold)) {
			$c_classes .= ' ' . $content_bold;
		}
		if (!empty($content_secondary)) {
			$c_classes .= ' ' . $content_secondary;
		}


		$title_tag = $title_size;
		$t_size_style = '';
		if ($title_size == 'custom') {
			$title_tag = "h1";
			$t_size_style = "font-size:" . $title_custom_size . ';';
		}

		$icon_class = $t_color;
		$icon_style = $t_custom_color;

		if (!empty($icon_color) && !empty($icon_has_color)) {
			if ($icon_color != 'custom') {
				$icon_class = 'text-' . $icon_color . ' svg-' . $icon_color;
			} else {
				$icon_style = 'color:' . $icon_custom_color . ' !important;';
			}
		} else {
			$icon_class = 'text-' . $title_color . ' svg-' . $title_color;
			$icon_style = $t_custom_color;
		}

		$titleClasses = '';
		$contentClasses = '';
		if (!empty($animation)) {
			$titleClasses = 'animate-in';
		}
		if (!empty($content_animation)) {
			$contentClasses = 'animate-in';
		}
		$output = '<div class="pix-faq ' . $position . ' ' . $css_class . '">';
		$output .= '<div><div class="slide-in-container"><' . $title_tag . ' class="d-flex align-items-center mb-3 ' . $titleClasses . '" style="' . $t_custom_color . $t_size_style . '" data-anim-type="' . $animation . '" data-anim-delay="' . $delay . '">';

		$margin10 = is_rtl() ? 'pix-ml-10' : 'pix-mr-10';
		if ($media_type == "duo_icon") {
			$icon = $pix_duo_icon;
		}
		$output .= '<span class="pix-faq-icon d-inline-flex align-items-center '.$margin10.' ' . $icon_class . '" style="' . $icon_style . '">';
		$output .= \PixfortCore::instance()->icons->getIcon($icon);
		$output .= '</span>';
		$output .= '<span class="' . $t_color . '">' . $title . '</span>';
		$output .= '</' . $title_tag . '></div></div>';
		if (!empty($content)) {
			$output .= '<div class="slide-in-container d-inline-block w-100"><div class="' . $c_classes . ' ' . $content_size . ' ' . $contentClasses . '" data-anim-type="' . $content_animation . '" data-anim-delay="' . $content_delay . '" style="' . $c_custom_color . '">' . do_shortcode($content) . '</div></div>';
		}
		$output .= '</div>';

		return $output;
	}
}

