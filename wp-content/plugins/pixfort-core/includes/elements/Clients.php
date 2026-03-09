<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
 * Clients
* --------------------------------------------------------------------------- */
class PixClients {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'in_row'            => 3,
			'in_row_mobile'     => 12,
			'style'             => 'pix-box',
			'clients'           => '',
			'css'               => '',
			'add_hover_effect'  => '',
			'animation'         => 'fade-in-Img',
			'delay'             => '0',
			'delay_items'       => '',
		), $attr));

		$css_class = '';
		$classes = array();
		if (function_exists('vc_shortcode_custom_css_class') && defined('VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		wp_enqueue_style('pixfort-clients-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/clients.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');

		$el_style = '';
		if ($style == 'no-effect') {
			$el_style = $style;
		} elseif ($style == 'pix-box') {
			$style = 'client shadow-hover-lg rounded-xl';
		}
		if (empty($delay)) $delay = 0;

		$add_hover_effect_arr = array(
			""       => "",
			"1"       => "fly-sm",
			"2"       => "fly",
			"3"       => "fly-lg",
			"4"       => "scale-sm",
			"5"       => "scale",
			"6"       => "scale-lg",
			"7"       => "scale-inverse-sm",
			"8"       => "scale-inverse",
			"9"       => "scale-inverse-lg",
		);

		if ($add_hover_effect) {
			array_push($classes, $add_hover_effect_arr[$add_hover_effect]);
		}
		$class_names = join(' ', $classes);

		if (!intval($in_row)) $in_row = 6;

		$elementor = false;
		$clients_arr = array();
		if (is_array($clients)) {
			$clients_arr = $clients;
			$elementor = true;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$clients_arr = vc_param_group_parse_atts($clients);
			}
		}

		$output = '';
		if (!empty($clients_arr)) {


			$delay = (int) $delay;
			$output  .= '<div class="clients row ' . $el_style . ' ' . $css_class . '">';

			if ($in_row != 5) {
				$in_row = (int) 12 / $in_row;
			}

			foreach ($clients_arr as $key => $value) {
				$divRes = $key % $in_row;
				if ($key % $in_row == 0) {
					$output .= '<div class="d-none d-md-block clearfix w-100 col-12"></div>';
				}
				$output .= '<div class="col-md col-' . $in_row_mobile . ' -' . $in_row . ' ' . $class_names . ' text-center d-inline-block2 d-inline-flex ' . $style . '">';

				if (empty($value['title'])) {
					$value['title'] = '';
				}
				$target = '_self';
				if (!empty($value['target'])) {
					$target = '_blank';
				}
				if (!empty($value['link'])) {
					$output .= '<a target="' . $target . '" href="' . $value['link'] . '" class="align-self-center py-3 d-inline-block w-100" title="' . $value['title'] . '">';
				} else {
					$title = '';
					if (!empty($value['title'])) {
						$title = $value['title'];
					}
					$output .= '<div class="py-3 d-inline-block align-self-center w-100" title="' . $title . '">';
				}
				if (!empty($value['image'])) {
					$title = '';
					if (!empty($value['title'])) {
						$title = $value['title'];
					}
					
					$imageOutput = \PixfortCore::instance()->coreFunctions->getDynamicImage($value['image'], 'full', [
						'class' => 'animate-in',
						'alt' => $title,
						'data-anim-type' => $animation,
						'data-anim-delay' => $delay
					], isset($value['image_dark']) ? $value['image_dark'] : null);
					
					if (!empty($imageOutput)) {
						$output .= $imageOutput;
					}
				}
				if (!empty($value['link'])) {
					$output .= '</a>';
				} else {
					$output .= '</div>';
				}
				$output .= '</div>';
				if (!empty($delay_items)) {
					$delay += 200;
				}
			}
			$mod = $in_row - (count($clients_arr) % $in_row);
			if ($mod > 0 && $mod < $in_row) {
				for ($i = 0; $i < $mod; $i++) {
					$output .= '<div class="col-md"></div>';
				}
			}

			$output .= '</div>' . "\n";
		}


		return $output;
	}
}
