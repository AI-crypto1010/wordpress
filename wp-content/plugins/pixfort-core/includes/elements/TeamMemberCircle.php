<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* TeamMemberCircle
* --------------------------------------------------------------------------- */
class PixTeamMemberCircle {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'name'  => '',
			'name_bold'		=> 'font-weight-bold',
			'name_italic'		=> '',
			'name_secondary_font'		=> '',
			'name_color'		=> '',
			'name_custom_color'		=> '',
			'name_size'		=> 'h4',
			'name_custom_size'		=> '',
			'title'  => '',
			'bold'		=> '',
			'italic'		=> '',
			'secondary_font'		=> '',
			'title_color'		=> '',
			'title_custom_color'		=> '',
			'title_size'		=> 'h6',
			'title_custom_size'		=> '',
			'description'  => '',
			'description_color'		=> 'light-opacity-5',
			'description_custom_color'		=> '',
			'description_size'		=> '',
			'image'  => '',
			'items'  => '',
			'items_color' 	=> 'body-default',
			'items_custom_color' 	=> '',
			'position'  => 'text-center',
			'color' 	=> "gradient-primary",
			'outer_custom_color' 	=> '',
			'outer_border' 	=> '',
			'inner_border' 	=> '',
			'animation' 	=> '',
			'delay' 	=> '0',
			'css' 		=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
			$description = pix_unescape_vc($description);
		}

		$name_classes = $name_bold . ' ' . $name_italic . ' ' . $name_secondary_font;
		$name_style = '';
		if (!empty($name_color)) {
			if ($name_color == 'custom') {
				$name_style .= 'color:' . $name_custom_color . ' !important;';
			} else {
				$name_classes .= ' text-' . $name_color;
			}
		}
		$name_tag = 'h4';
		if (!empty($name_size)) {
			if ($name_size == 'custom') {
				$name_style .= 'font-size:' . $name_custom_size . ';';
			} else {
				$name_tag = $name_size;
			}
		}
		$name_style = 'style="' . $name_style . '"';

		$title_classes = $bold . ' ' . $italic . ' ' . $secondary_font;
		$title_style = '';
		if (!empty($title_color)) {
			if ($title_color == 'custom') {
				$title_style .= 'color:' . $title_custom_color . ' !important;';
			} else {
				$title_classes .= ' text-' . $title_color;
			}
		}
		$title_tag = 'h4';
		if (!empty($title_size)) {
			if ($title_size == 'custom') {
				$title_style .= 'font-size:' . $title_custom_size . ';';
			} else {
				$title_tag = $title_size;
			}
		}
		$title_style = 'style="' . $title_style . '"';

		$d_classes = '';
		$d_custom_color = '';
		if (!empty($description_color)) {
			if ($description_color != 'custom') {
				$d_classes = 'text-' . $description_color;
			} else {
				$d_custom_color = 'style="color:' . $description_custom_color . ';"';
			}
		}
		$d_classes .= ' ' . $description_size;

		$img_arr = array(
			'image'		=> $image,
			'alt'		=> $name,
			'align'		=> 'center',
			'width'		=> '160',
			'animation'		=> $animation,
			'delay'		=> $delay,
			'color'		=> $color,
			'outer_custom_color'		=> $outer_custom_color,
			'outer_border'		=> $outer_border,
			'inner_border'		=> $inner_border,
		);
		$delay = (int)$delay;
		$icons_delay = $delay + 400;
		$icons_arr = array(
			'items'		=> $items,
			'item_size'		=> 'text-24',
			'items_color'		=> $items_color,
			'items_custom_color' => $items_custom_color,
			'items_style'		=> 'fly-sm',
			'animation' 	=> $animation,
			'delay' 	=> $icons_delay,
		);

		$anim_class = '';
		if (!empty($animation)) {
			$anim_class = 'animate-in';
		}

		$output = '';
		$output .= '<div class="' . esc_attr($css_class) . ' ' . $position . ' ' . $anim_class . '" style="position:relative" data-anim-type="' . $animation . '" data-anim-delay="' . $delay . '">';
		$output .= '<div class="card-body ' . $position . '">';
		$output .= '<div class="mb-2" >';
		$output .= \PixfortCore::instance()->elementsManager->renderElement('Story', $img_arr);
		$output .= '</div>';
		$output .= '<div class="' . $position . '">';
		$output .= '<' . $name_tag . ' class="pix-member-name card-title mb-3 ' . $name_classes . ' ' . $anim_class . '" ' . $name_style . ' data-anim-type="' . $animation . '" data-anim-delay="' . $delay . '">' . do_shortcode($name) . '</' . $name_tag . '>';
		$delay += 100;
		$output .= '<' . $title_tag . ' class="pix-member-title mb-3 ' . $title_classes . ' ' . $anim_class . '" ' . $title_style . ' data-anim-type="' . $animation . '" data-anim-delay="' . $delay . '"><strong>' . do_shortcode($title) . '</strong></' . $title_tag . '>';
		$delay += 100;
		if (!empty($description)) $output .= '<p class="pix-member-desc p-0 ' . $anim_class . ' ' . $d_classes . '" ' . $d_custom_color . ' data-anim-type="' . $animation . '" data-anim-delay="' . $delay . '">' . do_shortcode($description) . '</p>';
		$output .= \PixfortCore::instance()->elementsManager->renderElement('SocialIcons', $icons_arr);
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';


		return $output;
	}
}
