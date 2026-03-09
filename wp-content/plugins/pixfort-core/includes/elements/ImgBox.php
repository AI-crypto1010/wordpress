<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* ImgBox
* --------------------------------------------------------------------------- */
class PixImgBox {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'image'  => '',
			'image_dark'  => '',
			'title'  => '',
			'rounded_img'  => 'rounded-lg',
			'alt'  => '',
			'align'  => 'text-left',
			'width' 	=> '',
			'height' 	=> '',
			'pix_scroll_parallax' 	=> '',
			'pix_tilt' 	=> '',
			'pix_tilt_size' 	=> 'tilt',
			'xaxis' 	=> '',
			'yaxis' 	=> '',
			'link' 	=> '',
			'target' 	=> '',
			'animation' 	=> '',
			'delay' 	=> '0',
			'extra_classes' 	=> '',
			'style' 		=> '',
			'hover_effect' 		=> '',
			'add_hover_effect' 		=> '',
			'pix_infinite_animation' 		=> '',
			'pix_infinite_speed' 		=> '',
			'bold'		=> 'font-weight-bold',
			'italic'		=> '',
			'secondary_font'		=> '',
			'color'		=> 'white',
			'custom_color'		=> '',
			'title_size'		=> 'h4',
			'title_custom_size'		=> '',
			'text_bold'		=> '',
			'text_italic'		=> '',
			'text_secondary_font'		=> '',
			'text_color'		=> 'light-opacity-6',
			'text_custom_color'		=> '',
			'text'		=> '',
			'content_size'		=> '',
			'overlay_color'		=> 'black',
			'overlay_custom_color'		=> '',
			'overlay_opacity'		=> 'pix-hover-opacity-7',
			'css' 		=> '',
			'nofollow'        => '',
			'link_atts'        => '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class') && defined('VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		if (!$content && !empty($text)) {
			$content = $text;
		}

		$custom_link_atts = '';
		if (!empty($link_atts)) {
			$l_atts = explode(",", $link_atts);
			foreach ($l_atts as $key => $value) {
				$l_att = explode("|", $value);
				$custom_link_atts .= $l_att[0] . '="' . $l_att[1] . '" ';
			}
		}
		if (!empty($nofollow) && $nofollow) {
			$custom_link_atts .= 'rel="nofollow"';
		}

		$title_classes = pix_get_text_format_classes($bold, $italic, $secondary_font, $color);
		$text_classes = pix_get_text_format_classes($text_bold, $text_italic, $text_secondary_font, $text_color);
		$text_classes .= ' ' . $content_size;

		$title_style = '';
		$text_style = '';
		$el_style = '';
		if ($color == 'custom') {
			$title_style = 'color:' . $custom_color . ';';
		}
		if ($text_color == 'custom') {
			$text_style = 'style="color:' . $text_custom_color . ';"';
		}
		if ($overlay_color == 'custom') {
			$el_style = 'style="--pix-bg-color:' . $overlay_custom_color . ';"';
		}
		$output = '';
		$classes = [];
		$anim_type = '';
		$anim_delay = '';

		if (!empty($image)) {
			
			// array_push($classes, esc_attr( $css_class ));
			array_push($classes, esc_attr($extra_classes));

			$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
        	array_push($classes, $effectsClasses);

			if (!empty($align)) {
				array_push($classes, $align);
				array_push($classes, "w-100");
			}
			$inline_style = '';
			if (!empty($width)) {
				$inline_style .= 'max-width:' . $width . ';';
			} else {
				if (!empty($height)) {
					$inline_style .= 'width:auto;';
				}
			}
			if (!empty($height)) {
				$inline_style .= 'max-height:' . $height . ';';
			} else {
				$inline_style .= 'height:auto;';
			}
			array_push($classes, 'd-inline-block');



			$inline_style = 'style="' . $inline_style . '"';
			$class_names = join(' ', $classes);

			$jarallax = '';

			if (!empty($animation)) {
				$anim_type = 'data-anim-type="' . $animation . '"';
				$anim_delay = 'data-anim-delay="' . $delay . '"';
				array_push($classes, 'animate-in');
			}


		}


		$title_tag = $title_size;
		if ($title_size == 'custom') {
			$title_tag = "h4";
			$title_style .= "font-size:" . $title_custom_size . ';';
		}
		$title_style = 'style="' . $title_style . '"';

		$class_names = '';
		if (is_array($classes)) {
			$class_names = join(' ', $classes);
		}

		$output = '';

		if (!empty($pix_scroll_parallax)) {
			if (!empty($xaxis) || !empty($yaxis)) {
				$xaxis = (int)$xaxis;
				$yaxis = (int)$yaxis;
				$jarallax = 'data-jarallax-element="' . $xaxis . ' ' . $yaxis . '" data-xaxis="' . $xaxis . '" data-yaxis="' . $yaxis . '" ';
				$output .= '<div ' . $jarallax . '>';
			}
		}

		if (!empty($pix_tilt)) {
			$output .= '<div class="position-relative ' . $pix_tilt_size . '">';
		}

		if (!empty($link)) {
			$ntab = '';
			if (!empty($target)) {
				$ntab = 'target="_blank"';
			}
			$output .= '<a href="' . $link . '" ' . $custom_link_atts . ' class="d-block" ' . $ntab . '>';
		}

		$output .= '<div class="item-inner pix-img-box ' . $class_names . ' ' . $css_class . ' w-100 h-1002 bg-' . $overlay_color . ' shadow2 pix-hover-item mb-32  ' . $rounded_img . ' position-relative overflow-hidden" ' . $el_style . ' ' . $anim_type . ' ' . $anim_delay . '>';

		// Use getDynamicImage for the background image
		$imageOutput = \PixfortCore::instance()->coreFunctions->getDynamicImage($image, 'full', [
			'class' => 'pix-bg-image pix-img-scale ' . $overlay_opacity,
			'alt' => !empty($alt) ? $alt : ''
		], isset($image_dark) ? $image_dark : null);
		
		if (!empty($imageOutput)) {
			$output .= $imageOutput;
		}

		$output .= '<div class="pix-img-overlay pix-p-30 w-100">
		<div class="slide-in-container d-inline-block "><' . $title_tag . ' class="' . $title_classes . ' pix-slide-up" ' . $title_style . '>' . $title . '</' . $title_tag . '></div>
		<div class="slide-in-container d-inline-block w-100"><p class="' . $text_classes . ' mb-0 pix-fade-in" ' . $text_style . '>' . $content . '</p></div>
		</div>
		</div>';
		if (!empty($link)) {
			$output .= '</a>';
		}
		if (!empty($pix_tilt)) {
			$output .= '</div>';
		}
		if (!empty($pix_scroll_parallax)) {
			if (!empty($xaxis) || !empty($yaxis)) {
				$output .= '</div>';
			}
		}
		return $output;
	}
}

