<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
 * Heading
* --------------------------------------------------------------------------- */
class PixAnimatedHeading {

	function render($attr, $content = null) {

		extract(shortcode_atts(array(
			'title'					=> '',
			'text_after'			=> '',
			'words'					=> '',
			'slogan' 				=> '',
			'title_bold' 			=> 'font-weight-bold',
			'title_italic' 			=> '',
			'title_secondary_font' 	=> '',
			'space_after' 			=> '',
			'br_after' 				=> '',
			'size'  				=> 'h1',
			'display'  				=> '',
			'title_color'			=> 'heading-default',
			'title_custom_color'	=> '',
			'slogan_bold' 			=> 'font-weight-bold',
			'slogan_italic' 		=> '',
			'slogan_secondary_font' => '',
			'slogan_color'			=> 'primary',
			'slogan_custom_color'	=> '',
			'style' 				=> 'slide-inverse',
			'position'  			=> 'center',
			'animation' 			=> '',
			'delay' 				=> '0',
			'css' 					=> '',
		), $attr));

		/* Variables */
		$css_class = '';
		$h_words = array();
		$output = '';
		$slogan_style = '';
		$t_color = '';
		$t_custom_color = '';

		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
			wp_enqueue_style('pixfort-animated-heading-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/animated-heading.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
			$title = pix_unescape_vc($title);
			$text_after = pix_unescape_vc($text_after);
			$slogan = pix_unescape_vc($slogan);
		}

		if (is_array($words)) {
			$h_words = $words;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$h_words = vc_param_group_parse_atts($words);
			}
		}

		$slogan_classes = pix_get_text_format_classes($slogan_bold, $slogan_italic, $slogan_secondary_font, $slogan_color);
		if ($slogan_color == 'custom') {
			$slogan_style = 'style="color:' . $slogan_custom_color . ' !important;"';
		}

		if (!empty($title_color)) {
			if ($title_color != 'custom') {
				$t_color = 'text-' . $title_color;
			} else {
				$t_custom_color = 'color:' . $title_custom_color . ' !important;';
			}
		}

		$i = 0;
		$words_html = '';
		if ($h_words) {
			foreach ($h_words as $key => $value) {
				$w_color = '';
				$w_custom_color = '';
				if (!empty($value['has_color'])) {
					if (!empty($value['word_color'])) {
						if ($value['word_color'] != 'custom') {
							$w_color = 'text-' . $value['word_color'];
						} else {
							$w_custom_color = 'style="color:' . $value['word_custom_color'] . ';"';
						}
					}
				}
				if (function_exists('vc_shortcode_custom_css_class')) {
					$value['word'] = pix_unescape_vc($value['word']);
				}
				if ($i == 0) {
					$words_html .= '<span class="is-visible ' . $w_color . '" ' . $w_custom_color . '>' . do_shortcode($value["word"]) . '</span> ';
				} else {
					$words_html .= '<span class="' . $w_color . '" ' . $w_custom_color . '>' . do_shortcode($value["word"]) . '</span> ';
				}
				$i++;
			}
		}
		$bar_color = '';
		$bar_custom_color = '';
		if ($style == 'loading-bar') {
			if (!empty($title_color)) {
				if ($title_color != 'custom') {
					$bar_color = 'bg-' . $title_color;
				} else {
					$bar_custom_color = 'style="background:' . $title_custom_color . ';"';
				}
			}
			$words_html .= '<span class="pix-bar ' . $bar_color . '" ' . $bar_custom_color . '></span>';
		}
		$space_out = '';
		if (!empty($space_after)) {
			$space_out = ' ';
		}
		$br_out = '';
		if (!empty($br_after)) {
			$br_out = '<br />';
		}
		if (!pix_endsWith($title, ' ')) $title .= ' ';
		$output = '<div class="text-' . $position . ' ' . $css_class . '">';
		if (!empty($slogan)) {
			$output .= '<div class="slide-in-container w-100 pix-slogan-text"><h6 data-anim-type="slide-in-up" class=" ' . $slogan_classes . ' animate-in" ' . $slogan_style . '>' . do_shortcode($slogan) . '</h6></div>';
		}
		if (!empty($animation)) {
			$output .= '<div><' . $size . ' class="pix-headline my-3 ' . $display . ' ' . $style . ' ' . $t_color . ' ' . $title_bold . ' ' . $title_italic . ' ' . $title_secondary_font . ' animate-in" style="' . $t_custom_color . '" data-anim-type="' . $animation . '" data-anim-delay="' . $delay . '" >';
		} else {
			$output .= '<div><' . $size . ' class="pix-headline my-3 ' . $display . ' ' . $style . ' ' . $t_color . ' ' . $title_bold . ' ' . $title_italic . ' ' . $title_secondary_font . '" style="' . $t_custom_color . '">';
		}
		$last = '';
		if (empty($text_after)) {
			$last = 'is-last';
		}
		$output .= '<span>' . do_shortcode($title) . '</span>';
		$output .= '<span class="pix-words-wrapper ' . $last . '">' . $words_html . '</span>';
		if (empty($last)) $output .= '<span>' . $space_out . $br_out . do_shortcode($text_after) . '</span>';
		$output .= '</' . $size . '></div>';
		$output .= '</div>';
		return $output;
	}
}
