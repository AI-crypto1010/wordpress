<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* TeamMember
* --------------------------------------------------------------------------- */
class PixTeamMember {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'name'  => '',
			'name_bold'		=> 'font-weight-bold',
			'name_italic'		=> '',
			'name_secondary_font'		=> '',
			'name_color'		=> 'white',
			'name_custom_color'		=> '',
			'name_size'		=> 'h4',
			'name_custom_size'		=> '',
			'title'  => '',
			'bold'		=> '',
			'italic'		=> '',
			'secondary_font'		=> '',
			'title_color'		=> 'light-opacity-6',
			'title_custom_color'		=> '',
			'title_size'		=> 'h6',
			'title_custom_size'		=> '',
			'description'  => '',
			'description_color'		=> 'light-opacity-5',
			'description_custom_color'		=> '',
			'description_size'		=> '',
			'items_color' 	=> 'body-default',
			'items_custom_color' 	=> '',
			'overlay_color'		=> 'gradient-primary',
			'overlay_custom_color'		=> '',
			'overlay_opacity'		=> 'pix-opacity-7',
			'image'  => '',
			'image_dark'  => '',
			'items'  => '',
			'rounded_img'  => 'rounded-lg',
			'position'  => 'text-left',
			'animation' 	=> '',
			'style' 		=> '',
			'hover_effect' 		=> '',
			'add_hover_effect' 		=> '',
			'delay' 	=> '0',
			'css' 		=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
	
		$classes = array();
		array_push($classes, esc_attr($css_class));
		array_push($classes, $rounded_img);

		

		$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
        array_push($classes, $effectsClasses);

		if ($overlay_color != 'transparent' && $overlay_opacity != 'pix-opacity-0') {
			array_push($classes, 'hover-bg');
		}
		$class_names = join(' ', $classes);

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
				$name_classes .= ' h4';
				$name_tag = 'div';
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
				$title_classes .= ' h4';
				$title_tag = 'div';
			} else {
				$title_tag = $title_size;
			}
		}
		$title_style = 'style="' . $title_style . '"';

		$custom_style = '';
		if ($overlay_color == 'custom') {
			$custom_style .= 'style="--pix-bg-color:' . $overlay_custom_color . ';"';
		}


		$d_classes = '';
		$d_custom_color = '';
		if (!empty($description_color)) {
			if ($description_color != 'custom') {
				$d_classes = 'text-' . $description_color;
			} else {
				$d_custom_color = 'style="color:' . $description_custom_color . ' !important;"';
			}
		}
		$d_classes .= ' ' . $description_size;

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

		$output = '';
		$output .= '<div class="card pix-hover-item ' . $class_names . ' ' . $position . ' bg-' . $overlay_color . ' d-flex align-items-end pix-team-card big-card " ' . $custom_style . ' >';
		if (!empty($image)) {
			$imageOutput = \PixfortCore::instance()->coreFunctions->getDynamicImage($image, 'full', [
				'class' => 'card-img ' . $rounded_img . ' ' . $overlay_opacity,
			], $image_dark);
			if (!empty($imageOutput)) {
				$output .= $imageOutput;
			}
		} else {
			$output .= '<div class="card-img bg-gray"></div>';
		}
		$output .= '<div class="card-img-overlay d-flex flex-column justify-content-end">';
		$output .= '<' . $name_tag . ' class="pix-member-name card-title mb-0 ' . $name_classes . ' animate-in" ' . $name_style . ' data-anim-type="' . $animation . '" data-anim-delay="' . $delay . '">' . do_shortcode($name) . '</' . $name_tag . '>';
		$delay += 100;
		$output .= '<' . $title_tag . ' class="pix-member-title ' . $title_classes . ' mb-2 animate-in" ' . $title_style . ' data-anim-type="' . $animation . '" data-anim-delay="' . $delay . '">' . do_shortcode($title) . '</' . $title_tag . '>';
		$delay += 100;
		if (!empty($description)) {
			$output .= '<p class="pix-member-desc p-0 animate-in ' . $d_classes . '" ' . $d_custom_color . ' data-anim-type="' . $animation . '" data-anim-delay="' . $delay . '">' . do_shortcode($description) . '</p>';
			$delay += 100;
		}
		$output .= '<div class="font-weight-bold pix-social animate-in" data-anim-type="' . $animation . '" data-anim-delay="700">';
		$output .= \PixfortCore::instance()->elementsManager->renderElement('SocialIcons', $icons_arr);
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
		return $output;
	}
}
