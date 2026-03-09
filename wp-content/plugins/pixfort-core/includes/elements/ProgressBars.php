<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* ProgressBars
* --------------------------------------------------------------------------- */
class PixProgressBars {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'items'		=> '',
			'bold'		=> 'font-weight-bold',
			'italic'		=> '',
			'secondary_font'		=> '',
			'animation' 	=> '',
			'delay' 	=> '0',
			'css' 		=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		$classes = array();
		if (!empty($bold)) array_push($classes, $bold);
		if (!empty($italic)) array_push($classes, $italic);
		if (!empty($secondary_font)) array_push($classes, $secondary_font);

		$class_names = join(' ', $classes);

		$elementor = false;
		$bars = [];
		if (is_array($items)) {
			$bars = $items;
			$elementor = true;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$bars = vc_param_group_parse_atts($items);
			}
		}
		// $bars = vc_param_group_parse_atts( $items );
		$output = '';
		$output .= '<div class="' . $css_class . '">';
		foreach ($bars as $key => $value) {
			$val = 0;
			if (!empty($value['value'])) {
				if ($value['value'] >= 0 && $value['value'] <= 100) {
					$val = $value['value'];
				}
			}
			$text_style = '';
			if (!empty($value['text_color'])) {
				if ($value['text_color'] == 'custom') {
					$text_style = 'style="color:' . $value['text_custom_color'] . ';"';
				}
			}
			$bar_style = '';
			if (!empty($value['item_color'])) {
				if ($value['item_color'] == 'custom') {
					$bar_style = 'style="background:' . $value['item_custom_color'] . ';"';
				}
			}
			$bg_class = 'bg-dark-opacity-3';
			$bg_style = '';
			if (!empty($value['bg_color'])) {
				$bg_class = 'bg-' . $value['bg_color'];
				if ($value['bg_color'] == 'custom') {
					$bg_style = 'style="background:' . $value['bg_custom_color'] . ';"';
				}
			}
			if (empty($value['text_color'])) {
				$value['text_color'] = '';
			}
			if (empty($value['title'])) {
				$value['title'] = '';
			}
			if (empty($value['item_color'])) {
				$value['item_color'] = 'primary';
			}
			$output .= '<div class="mb-3 pix-progress">';
			$output .= '<div class="d-flex bd-highlight">';
			$output .= '<div class="flex-fill text-left text-' . $value['text_color'] . ' ' . $class_names . '" ' . $text_style . '>' . $value['title'] . '</div>';
			$output .= '<div class="flex-fill pix-progress-counter text-right text-' . $value['text_color'] . ' ' . $class_names . '" ' . $text_style . ' data-counter="' . $val . '">0%</div>';
			$output .= '</div>';
			$output .= '<div class="progress rounded-xl ' . $bg_class . '" ' . $bg_style . '>';
			$output .= '<div class="progress-bar rounded-xl bg-' . $value['item_color'] . '" ' . $bar_style . ' role="progressbar" aria-valuenow="' . $val . '" aria-label="' . $value['title'] . '" aria-valuemin="0" aria-valuemax="100"></div>';
			$output .= '</div>';
			$output .= '</div>';
		}
		$output .= '</div>';


		return $output;
	}
}
