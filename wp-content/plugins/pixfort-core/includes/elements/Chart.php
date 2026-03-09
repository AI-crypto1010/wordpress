<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
 * Chart
* --------------------------------------------------------------------------- */
class PixChart {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'percent' 				=> '50',
			'text' 					=> '',
			'p_bold'				=> 'font-weight-bold',
			'p_italic'				=> '',
			'p_secondary_font'		=> '',
			'p_color'				=> 'heading-default',
			'p_custom_color'		=> '',
			'p_size'				=> 'h4',
			'p_custom_size'			=> '',
			'bold'					=> 'font-weight-bold',
			'italic'				=> '',
			'secondary_font'		=> '',
			'title_color'			=> 'heading-default',
			'title_custom_color'	=> '',
			'title_size'			=> 'h5',
			'title_custom_size'		=> '',
			'content_color'			=> 'body-default',
			'content_custom_color'	=> '',
			'content_size'			=> '',
			'color1'	 			=> '',
			'color2'	 			=> '',
			'color3'	 			=> '',
			'track_color'	 		=> '',
			'title' 				=> '',
			'items' 				=> '',
			'animate' 				=> '',
			'animation' 			=> '',
			'delay' 				=> '0',
			'chart_css' 			=> '',
			'content_align' 		=> '',
		), $attr));

		$css_class = '';
		$gradiant = false;
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($chart_css, ' '));
		}
		wp_enqueue_style('pixfort-chart-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/chart.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');

		
		if(isset($attr['__globals__']) && !empty($attr['__globals__']['color1'])) {
			$color1 = '--pix-chart-color-1';
		} elseif (empty($color1)) {
			$color1 = '#59a3fc';
		}

		if(isset($attr['__globals__']) && !empty($attr['__globals__']['color2'])) {
			$color2 = '--pix-chart-color-2';
			$gradiant = true;
		} 
		if(empty($color3)) {
			if(isset($attr['__globals__']) && !empty($attr['__globals__']['color3'])) {
				$color3 = '--pix-chart-color-3';
			}
		} 

		if(empty($track_color)) {
			if(isset($attr['__globals__']) && !empty($attr['__globals__']['track_color'])) {
				$track_color = '--pix-chart-track-color';
			}
		}
		
		if (!empty($color2)) {
			$gradiant = true;
		}
		
		if ($color1 == "#") $color1 = '';
		if ($color2 == "#") $color2 = '';
		if ($color3 == "#") $color3 = '';

		$classes = array();
		$p_classes = array();
		$t_custom = '';
		$p_custom = '';
		if (!empty($p_color)) {
			if ($p_color != 'custom') {
				array_push($p_classes, 'text-' . $p_color);
			} else {
				$p_custom .= 'color:' . $p_custom_color . ';';
			}
		}
		if (!empty($p_bold)) array_push($p_classes, $p_bold);
		if (!empty($p_italic)) array_push($p_classes, $p_italic);
		if (!empty($p_secondary_font)) array_push($p_classes, $p_secondary_font);


		if (!empty($title_color)) {
			if ($title_color != 'custom') {
				array_push($classes, 'text-' . $title_color);
			} else {
				$t_custom .= 'color:' . $title_custom_color . ';';
			}
		}
		if (!empty($bold)) array_push($classes, $bold);
		if (!empty($italic)) array_push($classes, $italic);
		if (!empty($secondary_font)) array_push($classes, $secondary_font);

		$content_classes = array();
		$c_custom = '';
		if (!empty($content_color)) {
			if ($content_color != 'custom') {
				array_push($content_classes, 'text-' . $content_color);
			} else {
				$c_custom = 'color:' . $content_custom_color . ';';
			}
		}
		if (!empty($padding_content)) {
			$c_custom = 'padding-top:' . $padding_content . ';';
		}
		$c_custom = 'style="' . $c_custom . '"';

		// $title_tag = $title_size;
		$title_tag = "div";
		if ($title_size == 'custom') {
			// $title_tag = "h5";
			$t_custom .= "font-size:" . $title_custom_size . ';';
		} else {
			array_push($classes, $title_size);
			array_push($classes, 'heading-font');
		}

		// $p_tag = $p_size;
		$p_tag = "div";
		if ($p_size == 'custom') {
			// $p_tag = "h5";
			$p_custom .= "font-size:" . $p_custom_size . ';';
		} else {
			array_push($p_classes, $p_size);
			array_push($p_classes, 'heading-font');
		}

		$anim_type = '';
		$anim_delay = '';
		$anim = '';
		if (!empty($animation)) {
			array_push($classes, 'animate-in');
			array_push($content_classes, 'animate-in');
			array_push($p_classes, 'animate-in');
			$anim_type = 'data-anim-type="' . $animation . '"';
			$anim_delay = 'data-anim-delay="' . $delay . '"';
		}


		$class_names = join(' ', $classes);
		$p_class_names = join(' ', $p_classes);
		$content_class_names = join(' ', $content_classes);
		$t_custom = 'style="' . $t_custom . '"';
		$p_custom = 'style="' . $p_custom . '"';

		$divAlign = '';
		$chartAlign = '';
		if (!empty($content_align)) {
			if ($content_align == 'left') {
				$divAlign = 'text-left';
				$chartAlign = 'text-center mx-0';
			}
			if ($content_align == 'right') {
				$divAlign = 'text-right';
				$chartAlign = 'text-center mx-0';
			}
		}

		$output = '<div class="chart_box ' . $divAlign . ' ' . $css_class . '">';
		if ($animate) $output .= '<div class="animate" data-anim-type="' . $animate . '">';
		if ($gradiant) {
			$output .= '<div class="chart ' . $chartAlign . '" data-percent="' . intval($percent) . '" data-track="' . $track_color . '" data-gradient-1="' .  $color1 . '" data-gradient-2="' .  $color2 . '" data-gradient-3="' .  $color3 . '">';
		} else {
			$output .= '<div class="chart ' . $chartAlign . '" data-percent="' . intval($percent) . '" data-track="' . $track_color . '" data-barColor="' .  $color1 . '">';
		}
		$output .= '<div class="num"><' . $p_tag . ' class="' . $p_class_names . '" ' . $anim_type . ' ' . $anim_delay . '><span class="number ' . $p_class_names . '">' . $percent . '</span>%</' . $p_tag . '></div>';

		$output .= '</div>';
		$output .= '<' . $title_tag . ' class="chart_title pix-pt-5 ' . $class_names . '" ' . $t_custom . ' ' . $anim_type . ' ' . $anim_delay . '>' . $title . '</' . $title_tag . '>';
		$output .= '<p class="' . $content_class_names . ' ' . $content_size . '" ' . $anim_type . ' ' . $anim_delay . ' ' . $c_custom . '>' . $text . '</p>';

		if ($animate) $output .= '</div>';
		$output .= '</div>' . "\n";

		return $output;
	}
}
