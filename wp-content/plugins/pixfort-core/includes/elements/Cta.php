<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Cta
* --------------------------------------------------------------------------- */
class PixCta {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'title'						=> '',
			'bold'						=> 'font-weight-bold',
			'italic'					=> '',
			'secondary_font'			=> '',
			'cta_style'					=> 'default',
			'title_color'				=> 'heading-default',
			'title_custom_color'		=> '',
			'title_size'				=> 'h4',
			'title_custom_size'			=> '',
			'content_bold'				=> '',
			'content_italic'			=> '',
			'content_secondary_font'	=> '',
			'content_color'				=> 'body-default',
			'content_custom_color'		=> '',
			'content_size'				=> '',
			'text'						=> '',
			'animation' 				=> '',
			'delay' 					=> '0',
			'color'						=> 'primary',
			'style' 					=> '',
			'hover_effect' 				=> '',
			'add_hover_effect' 			=> '',
			'btn_title_bold' 			=> 'font-weight-bold',
			'btn_italic' 				=> '',
			'btn_secondary_font' 		=> '',
			'btn_color'					=> 'primary',
			'btn_remove_padding'		=> '',
			'btn_text_align'			=> '',
			'btn_style' 				=> '',
			'btn_rounded' 				=> '',
			'btn_effect' 				=> '',
			'btn_icon' 					=> '',
			'btn_icon_position' 		=> '',
			'btn_icon_animation' 		=> '',
			'btn_size' 					=> 'md',
			'btn_text' 					=> '',
			'btn_link' 					=> '',
			'btn_target' 				=> '',
			'btn_popup_id' 				=> '',
			'btn_text_color' 			=> '',
			'btn_text_custom_color' 	=> '',
			'btn_hover_effect' 			=> '',
			'btn_add_hover_effect' 		=> '',
			'btn_animation' 			=> '',
			'btn_shadow_class' 			=> '',
			'btn_full' 					=> '',
			'btn_anim_delay' 			=> '0',
			'btn_extra_classes' 		=> '',
			'css' 						=> '',
		), $attr));

		if (!$content && !empty($text)) {
			$content = $text;
		}
		$btn_attrs = array(
			'btn_title_bold'		=> $btn_title_bold,
			'btn_italic' => $btn_italic,
			'btn_secondary_font' => $btn_secondary_font,
			'btn_color'		=> $btn_color,
			'btn_remove_padding'		=> $btn_remove_padding,
			'btn_text_align'		=> $btn_text_align,
			'btn_style' 		=> $btn_style,
			'btn_rounded' 		=> $btn_rounded,
			'btn_effect' 		=> $btn_effect,
			'btn_icon' 		=> $btn_icon,
			'btn_size' 		=> $btn_size,
			'btn_text' 		=> $btn_text,
			'btn_link' 		=> $btn_link,
			'btn_target' 		=> $btn_target,
			'btn_popup_id' 		=> $btn_popup_id,
			'btn_text_color' 		=> $btn_text_color,
			'btn_text_custom_color' 		=> $btn_text_custom_color,
			'btn_hover_effect' 		=> $btn_hover_effect,
			'btn_add_hover_effect' 		=> $btn_add_hover_effect,
			'btn_animation' 		=> $btn_animation,
			'btn_anim_delay' 		=> $btn_anim_delay,
			'btn_shadow_class' 		=> $btn_shadow_class,
			'btn_sbtn_full' 		=> $btn_full,
			'btn_icon_position' 		=> $btn_icon_position,
			'btn_icon_animation' 		=> $btn_icon_animation,
			'btn_extra_classes' 		=> $btn_extra_classes,
			'btn_mb' 		=> 'mb-0',
		);


		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		$classes = array();
		$title_classes = array();

		array_push($classes, esc_attr($css_class));


		$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
		array_push($classes, $effectsClasses);

		if (!empty($bold)) array_push($title_classes, $bold);
		if (!empty($italic)) array_push($title_classes, $italic);
		if (!empty($secondary_font)) array_push($title_classes, $secondary_font);

		$t_tag = 'h4';
		$t_custom = '';
		if (!empty($title_size)) {
			if ($title_size == 'custom') {
				$t_custom .= 'font-size:' . $title_custom_size . ';line-height:1.28;';
				$t_tag = 'div';
			} else {
				$t_tag = $title_size;
			}
		}
		//  $t_custom_color = '';
		if (!empty($title_color)) {
			if ($title_color != 'custom') {
				array_push($title_classes, 'text-' . $title_color);
			} else {
				$t_custom .= 'color:' . $title_custom_color . ';';
			}
		}
		$t_custom = 'style="' . $t_custom . '"';

		$c_custom_color = '';
		if (!empty($content_color)) {
			if ($content_color == 'custom') {
				$c_custom_color = 'color:' . $content_custom_color . ';';
			}
			$c_custom_color = 'style="' . $c_custom_color . '"';
		}

		$c_classes = '';
		if (!empty($content_bold)) {
			$c_classes .= ' ' . $content_bold;
		}
		if (!empty($content_italic)) {
			$c_classes .= ' ' . $content_italic;
		}
		if (!empty($content_secondary_font)) {
			$c_classes .= ' ' . $content_secondary_font;
		}


		$anim_attrs = '';
		if (!empty($animation)) {
			array_push($classes, 'animate-in');
			$anim_attrs = 'data-anim-delay="' . $delay . '" data-anim-type="' . $animation . '"';
		}

		$class_names = join(' ', $classes);
		$title_class_names = join(' ', $title_classes);

		if (!empty($cta_style) && $cta_style == 'default') {
			$class_names .= ' w-100';
		}

		/* RTL */
		$contentAlign = 'text-md-left';
		$btnAlign = 'text-md-right';
		$mdMargin5 = 'mr-md-5';
		$mdMargin3 = 'mr-md-3';
		if (is_rtl()) {
			$contentAlign = 'text-md-right';
			$btnAlign = 'text-md-left';
			$mdMargin5 = 'ml-md-5';
			$mdMargin3 = 'ml-md-3';
		}

		$output = '<div class="container">';
		$output .= '<div class="row justify-content-center">';
		$output .= '<div class="col bg-white2 rounded-lg2 ' . $class_names . ' m-32 p-42 pix-py-30 col-sm-auto d-md-flex align-items-center text-center ' . $contentAlign . ' justify-content-between2" style="z-index:11;" ' . $anim_attrs . '>';
		$output .= '<div class="' . $mdMargin5 . '">';
		$output .= '<' . $t_tag . ' class="d-block ' . $mdMargin3 . ' mb-md-0 mb-md-0 text-' . $title_color . ' ' . $title_class_names . '" ' . $t_custom . '>';
		$output .= $title;
		$output .= '</' . $t_tag . '>';

		if (!empty($content)) {
			$output .= '<span class="d-block ' . $mdMargin3 . ' mb-md-0 mb-md-0 pix-mt-10 ' . $c_classes . ' ' . $content_size . ' text-' . $content_color . '" ' . $c_custom_color . '>';
			$output .= do_shortcode($content);
			$output .= '</span>';
		}
		$output .= '</div>';

		if (!empty($btn_text)) {
			if (!empty($cta_style) && $cta_style == 'default') $output .= '<div class="flex-fill ' . $btnAlign . ' flex-grow-1" style="min-width:250px;max-width:100%;">';
			$btn_attrs['btn_extra_classes'] = $btn_attrs['btn_extra_classes'] . ' mt-4 mt-md-0 mr-0';
			$output .= \PixfortCore::instance()->elementsManager->renderElement('Button', $btn_attrs);
			if (!empty($cta_style) && $cta_style == 'default') $output .= '</div>';
		}

		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
}
