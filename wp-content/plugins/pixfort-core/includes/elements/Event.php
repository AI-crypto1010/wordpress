<?php


if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Event
* --------------------------------------------------------------------------- */
class PixEvent {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'features'  => '',
			'content_size'  => '',
			'content_color'  => 'body-default',
			'content_custom_color'  => '',
			'icon_color'  => 'primary',
			'custom_icon_color'  => '',
			'animation' 	=> '',
			'delay' 	=> '0',
			'css' 		=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		$c_color = '';
		$output = '';
		$c_custom_color = '';
		if (!empty($content_color)) {
			if ($content_color != 'custom') {
				$c_color = 'text-' . $content_color;
			} else {
				$c_custom_color = 'style="color:' . $content_custom_color . ';"';
			}
		}

		$element_id = "pix-event-" . wp_rand(0, 10000000);
		$i_color = '';
		$i_custom_color = '';
		if (!empty($icon_color)) {
			if ($icon_color != 'custom') {
				$i_color = 'text-' . $icon_color;
			} else {
				$i_custom_color .= 'style="color:' . $custom_icon_color . ';"';
				$icon_css = '#' . $element_id . ' svg path { fill: ' . $custom_icon_color . '; }';
				$output .= '<style type="text/css">';
				$output .= esc_attr($icon_css);
				$output .= '</style>';
			}
		} else {
			$i_color = $c_color;
		}

		$anim_type = '';
		$anim_delay = '';
		$anim_class = '';
		$delay = (int) $delay;

		if (!empty($animation)) {
			$anim_type = 'data-anim-type="' . $animation . '"';
			$anim_delay = 'data-anim-delay="' . $delay . '"';
			$anim_class = 'animate-in';
		}
		$elementor = false;
		if (is_array($features)) {
			$features_arr = $features;
			$elementor = true;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$features_arr = vc_param_group_parse_atts($features);
			}
		}

		$output .= '<div class="w-100 ' . esc_attr($css_class) . '" >';
		$output .= '<div class="" id="' . $element_id . '">';

		$output .= '<table class="table pix-event-table mb-0 font-weight-bold ' . $content_size . ' " ' . $c_custom_color . '>
					  <tbody>';

		foreach ($features_arr as $key => $value) {
			$time = empty($value['time']) ? '' : $value['time'];
			$title = empty($value['title']) ? '' : $value['title'];
			$text = empty($value['text']) ? '' : $value['text'];
			$output .= '<tr class="' . $anim_class . '" ' . $anim_type . ' ' . $anim_delay . '>';
			$output .= '<th scope="row" class="' . $i_color . ' text-18">' . \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-clock-1') . '</th>';
			$output .= '<td class="text-left ' . $c_color . '">' . $time . '</td>';
			$output .= '<td class="' . $c_color . '">' . $title . '</td>';
			$output .= '<td class="text-right ' . $c_color . '">' . $text . '</td>';
			$output .= '</tr>';
			$delay += 100;
			$anim_delay = 'data-anim-delay="' . $delay . '"';
		}

		$output .= '
						  </tbody>
						</table>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
}
