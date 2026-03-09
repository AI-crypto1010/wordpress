<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
 * CardWide
* --------------------------------------------------------------------------- */
class PixCardWide {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'title'                 => '',
			'text'                  => '',
			'image'                 => '',
			'image_dark'            => '',
			'link_text'             => '',
			'layout'                => 'wide_card_rightt',
			'feature_image'         => '',
			'feature_image_dark'    => '',
			'feature_image_width'   => '',
			'style'                 => '',
			'hover_effect'          => '',
			'add_hover_effect'      => '',
			'rounded_img'           => 'rounded-lg',
			'link'                  => '',
			'target'                => '',
			'bold'                  => 'font-weight-bold',
			'italic'                => '',
			'secondary_font'        => '',
			'color'                 => 'heading-default',
			'custom_color'          => '',
			'title_size'            => 'h5',
			'title_custom_size'     => '',
			'text_bold'             => 'font-weight-bold',
			'text_italic'           => '',
			'text_secondary_font'   => '',
			'text_color'            => 'body-default',
			'text_custom_color'     => '',
			'text_size'             => '',
			'animation'             => '',
			'delay'                 => '0',
			'extra_classes'         => '',
			'css'                   => '',
		), $attr));

		$custom_link_atts = '';
		if (!empty($link) && is_array($link)) {
			if (!empty($link['is_external'])) {
				$target = $link['is_external'];
			}
			if (!empty($link['custom_attributes'])) {
				$l_atts = explode(",", $link['custom_attributes']);
				foreach ($l_atts as $key => $value) {
					$l_att = explode("|", $value);
					$custom_link_atts .= $l_att[0] . '="' . $l_att[1] . '" ';
				}
			}
			if (!empty($link['nofollow']) && $link['nofollow']) {
				$custom_link_atts .= 'rel="nofollow"';
			}
			$link = $link['url'];
		}

		$linkTarget = '';
		if (!empty($target)) {
			$linkTarget = 'target="_blank"';
		}

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		$css_class .= ' ' . $extra_classes;
		$classes = ' ';
		$classes .= esc_attr($css_class) . ' ';

		
		$classes .= \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect) . ' ';

		$title_classes = pix_get_text_format_classes($bold, $italic, $secondary_font, $color);
		$text_classes = pix_get_text_format_classes($text_bold, $text_italic, $text_secondary_font, $text_color);

		$text_classes .= ' ' . $text_size;

		$title_style = '';
		$text_style = '';
		if ($color == 'custom') {
			$title_style = 'color:' . $custom_color . ';';
		}
		if ($text_color == 'custom') {
			$text_style = 'style="color:' . $text_custom_color . ';"';
		}

		$title_tag = 'h6';
		if (!empty($title_size)) {
			if ($title_size == 'custom') {
				$title_style .= 'font-size:' . $title_custom_size . ';';
			} else {
				$title_tag = $title_size;
			}
		}
		$title_style = 'style="' . $title_style . '"';

		$title = str_replace("``", "\"", $title);
		$text = str_replace("``", "\"", $text);

		$anim_attrs = '';
		if (!empty($animation)) {
			$classes .= ' animate-in ';
			$anim_attrs = 'data-anim-delay="' . $delay . '" data-anim-type="' . $animation . '"';
		}

		$output = '';


		$out_img = '';
		if (!empty($image)) {
			$imageOutput = \PixfortCore::instance()->coreFunctions->getDynamicImage($image, 'full', [
				'class' => 'card-img rounded-0 pix-fit-cover flex-grow-1 h-100',
				'alt' => $title,
			], isset($image_dark) ? $image_dark : null);
			if (!empty($imageOutput)) {
				$out_img .= '<div class="flex-column col-md-6">';
				$out_img .= $imageOutput;
				$out_img .= '</div>';
			}
		}

		$out_body = '';
		$out_body .= '<div class="card-body d-flex align-content-between flex-wrap col-md-6 p-lg-5 p-md-5 p-4">';
		$out_body .= '<div class="d-flex align-items-start">';
		$out_body .= '<div>';
		if (!empty($feature_image)) {
			$fwidth = 'width:auto;';
			if (!empty($feature_image_width)) {
				$fwidth .= 'max-width:' . $feature_image_width . ';';
			}
			$featureImageOutput = \PixfortCore::instance()->coreFunctions->getDynamicImage($feature_image, 'full', [
				'class' => 'mb-3',
				'alt' => '',
				'style' => $fwidth,
				'decoding' => 'async',
			], isset($feature_image_dark) ? $feature_image_dark : null);
			if (!empty($featureImageOutput)) {
				$out_body .= $featureImageOutput;
			}
		}
		$out_body .= '<' . $title_tag . ' ' . $title_style . ' class="' . $title_classes . ' mb-3">' . do_shortcode($title) . '</' . $title_tag . '>';
		$out_body .= '</div>';
		$out_body .= '</div>';
		$out_body .= '<div class="d-flex align-items-end">';
		$out_body .= '<div>';
		$out_body .= '<p class="' . $text_classes . ' text-left mb-0" ' . $text_style . '>' . do_shortcode($text) . '</p>';
		$out_body .= '</div>';
		$out_body .= '</div>';
		$out_body .= '</div>';

		if (!empty($link)) {
			$output .= '<a ' . $linkTarget . ' ' . $custom_link_atts . ' href="' . $link . '">';
		}
		$output .= '<div class="card ' . $rounded_img . ' overflow-hidden row no-gutters flex-column flex-md-row flex-md-row-reverse ' . $classes . '" ' . $anim_attrs . '>';

		if ($layout == 'wide_card_left') {
			$output .= $out_body;
			$output .= $out_img;
		} else {
			$output .= $out_img;
			$output .= $out_body;
		}

		$output .= '</div>';
		if (!empty($link)) {
			$output .= '</a>';
		}
		return $output;
	}
}
