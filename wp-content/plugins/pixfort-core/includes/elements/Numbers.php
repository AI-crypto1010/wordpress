<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Numbers
* --------------------------------------------------------------------------- */
class PixNumbers {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'numbers_style' 	=> 'numbers-inline',
			'text_before' 	=> '',
			'before_bold' 	=> 'font-weight-bold',
			'before_italic' 	=> '',
			'before_secondary_font' 	=> '',
			'before_space_after' 	=> '',
			'number' 	=> '',
			'number_bold' 	=> 'font-weight-bold',
			'number_italic' 	=> '',
			'number_secondary_font' 	=> '',
			'duration' 	=> '3000',
			'text_after' 	=> '',
			'after_bold' 	=> 'font-weight-bold',
			'after_italic' 	=> '',
			'after_secondary_font' 	=> '',
			'after_space_before' 	=> '',
			'content_bold' 	=> 'font-weight-bold',
			'content_italic' 	=> '',
			'content_secondary_font' 	=> '',
			'title_color'		=> 'heading-default',
			'title_custom_color'		=> '',
			'title_size'		=> 'h3',
			'title_custom_size'		=> '',
			'title_display'		=> '',
			'content_color'		=> 'body-default',
			'content_custom_color'		=> '',
			'content_size'		=> 'h6',
			'content_custom_size'		=> '',
			'content_position'		=> 'text-left',
			'animate' 	=> '',
			'delay' 	=> '0',
			'css' 	=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		if (!empty($before_space_after)) {
			$text_before .= ' ';
		}
		if (!empty($after_space_before)) {
			$text_after = ' ' . $text_after;
		}
		$classes = array();
		$t_custom = '';
		if (!empty($title_color)) {
			if ($title_color == 'custom') {
				$t_custom .= 'color:' . $title_custom_color . ' !important;';
			}
		}
		if ($title_color == 'gradient-primary') {
			$title_color = 'gradient-primary text-gradient-primary-initial';
		}
		// $title_tag = $title_size;
		$title_tag = "div";
		if ($title_size == 'custom') {
			// $title_tag = "div";
			if (!empty($title_custom_size)) {
				$t_custom .= "font-size:" . $title_custom_size . ';line-height:1.28;';
			}
		} else {
			array_push($classes, $title_size);
			array_push($classes, 'heading-font');
		}

		$content_classes = [];
		$c_custom = '';
		if (!empty($content_color)) {
			if ($content_color != 'custom') {
				array_push($content_classes, 'text-' . $content_color);
			} else {
				$c_custom = 'color:' . $content_custom_color . ' !important;';
			}
		}
		$content_tag = $content_size;
		if ($content_size == 'custom') {
			$content_tag = "div";
			$c_custom .= "font-size:" . $content_custom_size . ';line-height:1.28;';
		}

		if (!empty($content_bold)) array_push($content_classes, $content_bold);
		if (!empty($content_italic)) array_push($content_classes, $content_italic);
		if (!empty($content_secondary_font)) array_push($content_classes, $content_secondary_font);
		array_push($classes, $title_display);

		$before_classes = pix_get_text_format_classes($before_bold, $before_italic, $before_secondary_font);
		$number_classes = pix_get_text_format_classes($number_bold, $number_italic, $number_secondary_font);
		$after_classes = pix_get_text_format_classes($after_bold, $after_italic, $after_secondary_font);


		$class_names = join(' ', $classes);

		$content_class_names = join(' ', $content_classes);
		$t_custom = 'style="' . $t_custom . '"';
		$c_custom = 'style="' . $c_custom . '"';

		if ($numbers_style == 'numbers-inline') {
			$output = '<div class="media pix_numbers d-flex animate-math ' . $css_class . '">';
		} else {
			$output = '<div class="pix_numbers animate-math ' . $css_class . '">';
		}
		if ($animate) $output .= '<div class="d-flex align-items-center animate-in" data-anim-type="' . $animate . '" data-anim-delay="' . $delay . '">';

		if ($numbers_style == 'numbers-inline') {
			// if (!empty($number)||$number==='0') {
				$output .= '<' . $title_tag . ' class="mr-3 align-self-center ' . $class_names . '">';
				$output .= '<span class="number-title ' . $before_classes . ' text-' . $title_color . '" ' . $t_custom . '>' . $text_before . '</span>';
				$output .= '<span class="number-title number ' . $number_classes . ' text-' . $title_color . '" ' . $t_custom . ' data-duration="' . $duration . '" data-to="' . $number . '">0</span>';
				$output .= '<span class="number-title ' . $after_classes . ' text-' . $title_color . '" ' . $t_custom . '>' . $text_after . '</span>';
				$output .= '</' . $title_tag . '>';
			// }

			if (!empty($content)) {
				$output .= '<div class="media-body align-self-center ' . $content_position . '">';
				$output .= '<' . $content_tag . ' class="number-content mt-0 ' . $content_class_names . '" ' . $c_custom . '>' . do_shortcode($content) . '</' . $content_tag . '>';
				$output .= '</div>';
			}
		} else {
				$output .= '<div>';
				$output .= '<' . $title_tag . ' class="align-self-center ' . $content_position . ' ' . $class_names . '">';
				$output .= '<span class="number-title ' . $before_classes . ' text-' . $title_color . '" ' . $t_custom . '>' . $text_before . '</span>';
				$output .= '<span class="number-title number ' . $number_classes . ' text-' . $title_color . '" ' . $t_custom . ' data-duration="' . $duration . '" data-to="' . $number . '">0</span>';
				$output .= '<span class="number-title ' . $after_classes . ' text-' . $title_color . '" ' . $t_custom . '>' . $text_after . '</span>';
				$output .= '</' . $title_tag . '>';
				$output .= '</div>';
			if (!empty($content)) {
				$output .= '<div class="w-100 ' . $content_position . '">';
				$output .= '<' . $content_tag . ' class="number-content mt-0 ' . $content_class_names . '" ' . $c_custom . '>' . do_shortcode($content) . '</' . $content_tag . '>';
				$output .= '</div>';
			}
		}


		if ($animate) $output .= '</div>';
		$output .= '</div>' . "\n";

		return $output;
	}
}
