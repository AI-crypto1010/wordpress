<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* SlidingText
* --------------------------------------------------------------------------- */
class PixSlidingText {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'position'  						=> 'left',
			'size'  							=> 'h1',
			'custom_font_size'  				=> '',
			'bold'  							=> 'font-weight-bold',
			'italic'  							=> '',
			'secondary_font'  					=> 'body-font',
			'text_color'  						=> 'heading-default',
			'text_custom_color'  				=> '',
			'display'  							=> '',
			'max_width'  						=> '',
			'remove_mb'  						=> false,
			'css'  								=> '',
			'el_id'  							=> '',
			'el_class' 							=> '',
			'delay'  							=> '0',
			'words_delay'  						=> 150,
			'pix_animation_duration'  			=> false,
			'sliding_letters'  					=> false,
			'letters_delay'  					=> false,
			'bar_inner_typography_font_family'  => false,
			'wpb_pix_translate_y'  				=> '',
			'wpb_pix_translate_x'  				=> '',
			'wpb_pix_blur'  					=> '',
			'wpb_pix_overflow'  				=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		if (!$bar_inner_typography_font_family) {
			if ($secondary_font != 'secondary-font') {
				$secondary_font = 'body-font';
			}
		}

		$classes = array();
		if (!empty($bold)) array_push($classes, $bold);
		if (!empty($italic)) array_push($classes, $italic);
		if (!empty($secondary_font)) array_push($classes, $secondary_font);
		if (!empty($display)) array_push($classes, $display);
		if (!empty($el_class)) array_push($classes, $el_class);

		if (empty($el_id)) {
			$el_id = 'sliding-text-' . hash('md5', $content);
		} else {
			if (is_numeric($el_id[0])) {
				$el_id = 'el' . $el_id;
			}
		}

		$wpb_wrapper_vars = '';
		$is_wpbakery_active = class_exists('Vc_Manager') || defined('WPB_VC_VERSION') || function_exists('vc_map');
		if ($is_wpbakery_active) {
			$sanitize_css_value = static function ($value) {
				$value = trim((string) $value);
				return str_replace(array(';', '{', '}'), '', $value);
			};
			$wpb_vars = array();
			if ($wpb_pix_translate_y !== '') {
				$translate_y = $sanitize_css_value($wpb_pix_translate_y);
				if ($translate_y !== '') {
					$wpb_vars[] = '--pix-translate-y:' . $translate_y . ';';
				}
			}
			if ($wpb_pix_translate_x !== '') {
				$translate_x = $sanitize_css_value($wpb_pix_translate_x);
				if ($translate_x !== '') {
					$wpb_vars[] = '--pix-translate-x:' . $translate_x . ';';
				}
			}
			if ($wpb_pix_blur !== '') {
				$blur = $sanitize_css_value($wpb_pix_blur);
				if ($blur !== '') {
					$wpb_vars[] = '--pix-sliding-blur:' . $blur . ';';
				}
			}
			if ($wpb_pix_overflow !== '') {
				$overflow = $sanitize_css_value($wpb_pix_overflow);
				if (in_array($overflow, array('hidden', 'visible'), true)) {
					$wpb_vars[] = '--pix-sliding-overflow:' . $overflow . ';';
				}
			}
			if (!empty($wpb_vars)) {
				$wpb_wrapper_vars = implode('', $wpb_vars);
			}
		}

		if (!empty($custom_font_size)) {
			$customStyle = '#' . $el_id . ' .pix-sliding-headline-2 { font-size: ' . $custom_font_size . ' !important; }';
			wp_register_style('pix-sliding-text-handle', false);
			wp_enqueue_style('pix-sliding-text-handle');
			wp_add_inline_style('pix-sliding-text-handle', $customStyle);
		}

		$is_gradient_color = false;
		$t_color = $secondary_font . ' ';
		$t_custom_color = '';
		if (!empty($text_color)) {
			if ($text_color != 'custom') {
				$t_color .= 'text-' . $text_color;
			} else {
				$t_custom_color = 'color:' . $text_custom_color . ';';
			}
		}
		$custom_style = '';

		$class_names = join(' ', $classes);

		$pix_mb = '';
		if (!$remove_mb) {
			$pix_mb = 'mb-3';
		}


		$content = pix_specialchars_decode($content);
		$items = explode(" ", $content);
		if (!empty($items)) {
			$transitionFunction = '';
			if (!empty($pix_animation_duration)) {
				$transitionFunction = 'transition-duration: ' . $pix_animation_duration . 'ms;';
			}
			$wpb_wrapper_style_attr = '';
			if (!empty($wpb_wrapper_vars)) {
				$wpb_wrapper_style_attr = ' style="' . esc_attr($wpb_wrapper_vars) . '"';
			}
			$output = '<div id="' . $el_id . '" class="' . $pix_mb . ' text-' . $position . ' ' . $css_class . '"' . $wpb_wrapper_style_attr . '>';
			if (!empty($max_width)) {
				$custom_style = 'style="max-width:' . $max_width . ';"';
				$output .= '<div class="d-inline-block" ' . $custom_style . '>';
			}
			$delay = (int) $delay;
			$output .= '<' . $size . ' class="mb-32 pix-sliding-headline-2 animate-in ' . $class_names . ' " data-anim-type="pix-sliding-text" data-class="' . $t_color . '" style="' . $t_custom_color . '">';
			$letters_delay_value = (int) $letters_delay;
			$words_delay = (int) $words_delay;
			foreach ($items as $key => $value) {
				if($value === 'pix_new_line'){
					$output .= '<br />';
				} else {
					if ($sliding_letters) {
						$letters = preg_split('//u', $value, -1, PREG_SPLIT_NO_EMPTY);
						$innerDelay = $delay;
						$output .= '<span class="slide-in-container">';
						if ($letters_delay === false || $letters_delay === '') {
							if (count($letters)) $letters_delay_value = $words_delay / count($letters);
						}
						foreach ($letters as $k => $v) {
							$output .= '<span class="pix-sliding-item pix-sliding-letter ' . $t_color . '" style="transition-delay: ' . $innerDelay . 'ms;' . $transitionFunction . '">' .  $v . '</span>';
							$innerDelay += $letters_delay_value;
						}
						$output .= '</span> ';
					} else {
						$output .= '<span class="slide-in-container ">';
						if ($is_gradient_color) {
							$output .= '<span class="pix-sliding-item-placeholder" style="opacity: 0; display: inline-block; pointer-events: none; visibility: hidden; padding: 10px 0; margin: -10px 0; overflow: hidden;">' . do_shortcode($value) . '</span> ';
						}
						$output .= '<span class="pix-sliding-item ' . $t_color . '" style="transition-delay: ' . $delay . 'ms;' . $transitionFunction . '">' . do_shortcode($value) . '&#32;</span></span> ';
					}
				}
				
				$delay += (int) $words_delay;
			}
			$output .= '</' . $size . '>';
			if (!empty($max_width)) {
				$output .= '</div>';
			}
			$output .= '</div>';
		}
		return $output;
	}
}
