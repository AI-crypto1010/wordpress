<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Button
* --------------------------------------------------------------------------- */
class PixButton {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'btn_title_bold' 				=> 'font-weight-bold',
			'btn_italic' 					=> '',
			'btn_secondary_font' 			=> '',
			'btn_color'						=> 'primary',
			'btn_remove_padding'			=> '',
			'btn_text_align'				=> '',
			'btn_style' 					=> '',
			'btn_rounded' 					=> '',
			'btn_effect' 					=> '',
			'btn_icon' 						=> '',
			'btn_icon_position' 			=> '',
			'btn_icon_animation' 			=> '',
			'btn_size' 						=> 'md',
			'btn_text' 						=> 'Click here',
			'btn_link' 						=> '',
			'btn_target' 					=> false,
			'btn_popup_id' 					=> '',
			'btn_text_color' 				=> '',
			'btn_text_custom_color' 		=> '',
			'btn_hover_effect' 				=> '',
			'btn_add_hover_effect' 			=> '',
			'btn_shadow_class' 				=> '',
			'btn_full' 						=> '',
			'btn_div' 						=> '',
			'btn_animation' 				=> '',
			'btn_anim_delay' 				=> '0',
			'btn_mb' 						=> 'mb-2',
			'is_elementor' 					=> false,
			'btn_extra_classes' 			=> '',
			'btn_id' 						=> '',
			'btn_class' 					=> '',
			'btn_spinner' 					=> false,
			'css' 							=> '',
		), $attr));


		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		$css_class .= ' ' . $btn_extra_classes;
		if ($btn_remove_padding == 'p-0') $btn_remove_padding = 'no-padding';
		if ($is_elementor) {
			$btn_mb = 'm-0';
		}

		$classes = ' ';
		$classes .= $css_class . ' ';
		$btn_inline_style = '';
		$inner_class = '';
		$icon_inner_class = '';

		$classes .= \PixfortCore::instance()->coreFunctions->getEffectsClasses($btn_effect, $btn_hover_effect, $btn_add_hover_effect) . ' ';

		if ($btn_text_color) {
			if ($btn_text_color != 'custom') {

				if ($btn_style == 'underline') {
					$inner_class .= ' text-' . $btn_text_color;
				}
				if (strpos($btn_text_color, 'gradient') === 0) {
					$inner_class .= ' text-' . $btn_text_color;
					$icon_inner_class = 'text-' . $btn_text_color;
				} else {
					$classes .= 'text-' . $btn_text_color . ' ';
				}
			} else {
				$btn_inline_style = 'style="color:' . $btn_text_custom_color  . ';"';
			}
		}


		if ($btn_style == 'line') {
			$classes .= 'btn-line-' . $btn_color;
		} elseif ($btn_style == 'outline') {
			$classes .= 'btn-outline-' . $btn_color;
		} elseif ($btn_style == 'underline') {
			if (strpos($btn_color, 'dark-') === 0 || strpos($btn_color, 'light-') === 0) {
				$classes .= ' btn-underline-primary ';
			} else {
				$classes .= 'btn-underline-' . $btn_color;
			}
		} elseif ($btn_style == 'blink') {
			$classes .= 'btn-blink-' . $btn_color;
		} elseif ($btn_style == 'link') {
			$classes .= 'btn-link text-' . $btn_color;
		} else {
			if (strpos($btn_color, 'dark-') === 0 || strpos($btn_color, 'light-') === 0) {
				$classes .= ' bg-' . $btn_color;
				$classes .= ' btn-gray-5 btn-custom-bg ';
			} else {
				$classes .= 'btn-' . $btn_color;
			}
		}
		if ($btn_style == 'flat') {
			$classes .= ' btn-flat';
		}
		if (!empty($btn_full)) {
			$classes .= ' d-flex w-100 ';
			if ($btn_text_align === 'text-left') {
				$classes .= ' justify-content-start ';
			} elseif ($btn_text_align === 'text-right') {
				$classes .= ' justify-content-end ';
			} else {
				$classes .= ' justify-content-center ';
			}
		} else {
			$classes .= ' d-inline-flex';
		}
		$classes .= ' align-items-center';

		$target_out = '';
		if ($btn_target) {
			$target_out = 'target="_blank" rel="noopener"';
		}
		$icon_classes = '';
		if (!empty($btn_icon_animation)) {
			$classes .= ' pix-hover-item ';
			$icon_classes = '';
			$icon_classes = ' pix-hover-left';
			if (!empty($btn_icon_position)) {
				if ($btn_icon_position == 'after') {
					$icon_classes = ' pix-hover-right';
				}
			}
		}

		$classes .= ' ' . $btn_remove_padding;
		$classes .= ' ' . $btn_text_align;
		$classes .= ' ' . $btn_italic;
		$classes .= ' ' . $btn_secondary_font;
		$classes .= ' ' . $btn_rounded;

		$anim_type = '';
		$anim_delay = '';
		if (!empty($btn_animation)) {
			$classes .= ' animate-in';
			$anim_type = 'data-anim-type="' . $btn_animation . '"';
			$anim_delay = 'data-anim-delay="' . $btn_anim_delay . '"';
		}

		$popup_data = '';
		$output = '';

		if (!empty($btn_popup_id)) {
			$classes .= ' pix-popup-link';
			$nonce = wp_create_nonce("popup_nonce");
			if (function_exists('icl_get_languages')) {
				$btn_popup_id = apply_filters('wpml_object_id', $btn_popup_id, 'post', true);
			}
			$popup_data = 'data-popup-id="' . $btn_popup_id . '"';
			get_the_content();
		}
		if (!empty($btn_div)) {
			$classes .= ' pix-btn-div';
			$output .= '<div class="d-block w-100 ' . $btn_div . '">';
		}
		$el_id = '';
		if (!empty($btn_id)) {
			$btn_id = 'id="' . $btn_id . '"';
		}
		$btn_text = pix_unescape_vc($btn_text);
		$btn_link = pix_unescape_vc($btn_link);

		$btn_icon_output = '';
		if (!empty($btn_icon)) {
			$iconPositionClasses = '';
			if (is_rtl()) {
				$iconPositionClasses = 'ml-2';
				if (!empty($btn_icon_position)) {
					$iconPositionClasses = 'mr-2';
				}
			} else {
				$iconPositionClasses = 'mr-2';
				if (!empty($btn_icon_position)) {
					$iconPositionClasses = 'ml-2';
				}
			}
			$btn_icon_output = \PixfortCore::instance()->icons->getIcon($btn_icon, 24, $btn_title_bold . ' ' . $icon_classes . ' ' . $icon_inner_class . ' ' . $iconPositionClasses);
		}

		if (!empty($btn_link)) {
			$output .= '<a ' . $btn_id . ' href="' . do_shortcode($btn_link) . '" class="btn ' . $btn_mb . ' ' . $btn_class . ' ' . $classes . ' btn-' . $btn_size . '" ' . $target_out . ' ' . $btn_inline_style . ' ' . $anim_type . ' ' . $anim_delay . ' ' . $popup_data . '>';
		} else {
			$output .= '<span ' . $btn_id . ' class="btn ' . $btn_mb . ' ' . $btn_class . ' ' . $classes . ' btn-' . $btn_size . '" ' . $target_out . ' ' . $btn_inline_style . ' ' . $anim_type . ' ' . $anim_delay . ' ' . $popup_data . '>';
		}

		if (!empty($btn_icon) && empty($btn_icon_position)) {
			$output .= $btn_icon_output;
		}
		$output .= '<span class="' . $btn_title_bold . ' ' . $inner_class . '" ' . $btn_inline_style . '>' . do_shortcode($btn_text) . '</span>';
		if (!empty($btn_icon) && !empty($btn_icon_position)) {
			$output .= $btn_icon_output;
		}
		if (!empty($btn_spinner)) {
			$output .= '<span class="spinner-wrapper"><span class="spinner"></span></span>';
		}
		if (!empty($btn_link)) {
			$output .= '</a>';
		} else {
			$output .= '</span>';
		}

		if (!empty($btn_div)) {
			$output .= '</div>';
		}

		return $output;
	}
}
