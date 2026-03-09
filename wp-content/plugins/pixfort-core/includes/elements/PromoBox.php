<?php


if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
 * PromoBox
* --------------------------------------------------------------------------- */
class PixPromoBox {

	function render($attr, $content = null) {

		extract(shortcode_atts(array(
			'image'  => '',
			'link_text'  => 'Check it out',
			'title'  => '',
			'badge'  => '',
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
			'style' 		=> '',
			'hover_effect' 		=> '',
			'add_hover_effect' 		=> '',
			'pix_infinite_animation' 		=> '',
			'pix_infinite_speed' 		=> '',
			'height' 		=> '300px',
			'bold'		=> 'font-weight-bold',
			'italic'		=> '',
			'secondary_font'		=> '',
			'color'		=> 'white',
			'custom_color'		=> '',
			'title_size'		=> 'h5',
			'title_custom_size'		=> '',
			'link_bold'		=> 'font-weight-bold',
			'link_italic'		=> '',
			'link_secondary_font'		=> '',
			'link_color'		=> 'light-opacity-6',
			'link_custom_color'		=> '',
			'link_size'		=> '',
			'overlay_color'		=> 'heading-default',
			'overlay_custom_color'		=> '',
			'overlay_opacity'		=> 'pix-opacity-4',
			'hover_overlay_opacity'		=> 'pix-hover-opacity-6',
			'badge_text_color'		=> 'primary',
			'badge_text_custom_color'		=> '',
			'badge_text_size'		=> 'custom',
			'badge_text_custom_size'		=> '12px',
			'badge_bold'  => 'font-weight-bold',
			'badge_italic'  => '',
			'badge_secondary_font'  => '',
			'badge_bg_color'		=> 'white',
			'badge_custom_bg_color'		=> '',
			'custom_css'	=> 'padding:5px 10px;margin-right:3px;',
			'extra_classes' 		=> '',
			'css' 		=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		$css_class .= ' ' . $extra_classes;

		$title_classes = pix_get_text_format_classes($bold, $italic, $secondary_font, $color);
		$link_classes = pix_get_text_format_classes($link_bold, $link_italic, $link_secondary_font, $link_color);

		$link_classes .= ' ' . $link_size;

		$title_style = '';
		$link_style = '';
		$el_style = '';
		if ($color == 'custom') {
			$title_style = 'color:' . $custom_color . ' !important;';
		}
		if ($link_color == 'custom') {
			$link_style = 'style="color:' . $link_custom_color . ' !important;"';
		}
		$title_tag = 'span';
		if (!empty($title_size)) {
			if ($title_size == 'custom') {
				if (!empty($title_custom_size)) {
					$title_style .= 'font-size:' . $title_custom_size . ';';
				}
			} else {
				$title_tag = $title_size;
			}
		}
		$title_style = 'style="' . $title_style . '"';
		if ($overlay_color == 'custom') {
			$el_style = 'style="--pix-bg-color:' . $overlay_custom_color . ';"';
		}

		if(!empty($badge_text_custom_size)) {
			$custom_css = '';
		}

		$badge_attrs = array(
			'text'	=> $badge,
			'text_color'		=> $badge_text_color,
			'text_custom_color'		=> $badge_text_custom_color,
			'text_size'		=> $badge_text_size,
			'text_custom_size'		=> $badge_text_custom_size,
			'bold'  => $badge_bold,
			'italic'  => $badge_italic,
			'secondary_font'  => $badge_secondary_font,
			'bg_color'		=> $badge_bg_color,
			'custom_bg_color'		=> $badge_custom_bg_color,
			'custom_css'		=> $custom_css,
		);

		$badge_out = \PixfortCore::instance()->elementsManager->renderElement('Badge', $badge_attrs);

		$output = '';
		$class_names = '';

		$imgSrc = false;
		if (is_string($image) && substr($image, 0, 4) === "http") {
			$imgSrc = $image;
		} else {
			if (!empty($image['id'])) {
				if ( is_int( $image['id'] ) ) {
					$image['id'] = apply_filters( 'wpml_object_id', $image['id'], 'attachment', true );
				}
				$img = wp_get_attachment_image_src($image['id'], "full");
			} else {
				if ( is_int( $image ) ) {
					$image = apply_filters( 'wpml_object_id', $image, 'attachment', true );
				}
				$img = wp_get_attachment_image_src($image, "full");
			}
			if (!empty($img[0])) {
				$imgSrc = $img[0];
			}
		}
		$classes = array();
		$anim_type = '';
		$anim_delay = '';
		array_push($classes, esc_attr($css_class));

	
		$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
        array_push($classes, $effectsClasses);

		if (!empty($align)) {
			array_push($classes, $align);
			array_push($classes, "w-100");
			if ($align == 'text-center') {
				$link_classes .= ' justify-content-center';
			}
			if ($align == 'text-right') {
				$link_classes .= ' justify-content-end';
			}
		}
		// $inline_style = '';
		// if (!empty($width)) {
		// 	$inline_style .= 'max-width:' . $width . ';';
		// } else {
		// 	if (!empty($height)) {
		// 		$inline_style .= 'width:auto;';
		// 	}
		// }
		// if (!empty($height)) {
		// 	$inline_style .= 'max-height:' . $height . ';';
		// } else {
		// 	$inline_style .= 'height:auto;';
		// }
		array_push($classes, 'd-block');



		// $inline_style = 'style="' . $inline_style . '"';
		$class_names = join(' ', $classes);

		$jarallax = '';
		if ($pix_scroll_parallax) {
			if (!empty($xaxis) || !empty($yaxis)) {
				$jarallax = 'data-jarallax-element="' . $xaxis . ' ' . $yaxis . '" data-xaxis="' . $xaxis . '" data-yaxis="' . $yaxis . '"';
			}
		}

		$output = '';

		if (!empty($pix_infinite_animation)) {
			$output .= '<div class="w-100 ' . $pix_infinite_animation . ' ' . $pix_infinite_speed . '">';
		}
		if (!empty($animation)) {
			$anim_type = 'data-anim-type="' . $animation . '"';
			$anim_delay = 'data-anim-delay="' . $delay . '"';
			$output .= '<div class="animate-in w-100" ' . $anim_type . ' ' . $anim_delay . '>';
		}
		if (!empty($pix_tilt)) {
			$output .= '<div class="' . $pix_tilt_size . '">';
		}

		$target_out = '';
		if (!empty($target)) {
			$target_out = 'target="_blank"';
		}
		$box_height = '';
		if (!empty($height)) {
			$box_height = 'style="min-height:' . $height . ';"';
		}

		$output .= '<div class="pix-promo-box card w-100 bg-' . $overlay_color . '  pix-hover-item ' . $rounded_img . ' position-relative overflow-hidden text-white ' . $class_names . '" ' . $el_style . ' ' . $jarallax . '>';
		if (!empty($imgSrc)) {
			$output .= '<img src="' . $imgSrc . '" class="card-img pix-bg-image pix-img-scale h-100 ' . $rounded_img . ' ' . $overlay_opacity . ' ' . $hover_overlay_opacity . '" alt="' . $title . '">';
		}
		if (!empty($link)) {
			$output .= '<a href="' . $link . '" ' . $target_out . ' class="d-inline-block w-100 pix-img-overlay pix-p-20 d-flex align-items-end" ' . $box_height . '>';
		} else {
			$output .= '<div class="d-inline-block w-100 pix-img-overlay pix-p-20 d-flex align-items-end" ' . $box_height . '>';
		}
		$output .= '<div class="w-100">';
		if (!empty($badge)) {
			$output .= '<div class="">' . $badge_out . '</div>';
		}
		if (!empty($title)) {
			$output .= '<' . $title_tag . ' class="card-title ' . $title_classes . ' pix-my-10" ' . $title_style . '>' . $title . '</' . $title_tag . '>';
		}
		if (!empty($link_text)) {
			$iconName = 'Line/pixfort-icon-arrow-right-2';
			$iconClasses = 'pix-hover-right pix-hover-item pix-ml-5';
			if (is_rtl()) {
				$iconName = 'Line/pixfort-icon-arrow-left-2';
				// $iconClasses = 'pix-hover-left pix-hover-item pix-mr-5';
				$iconClasses = 'pix-hover-right pix-hover-item pix-mr-5';
			}
			$output .= '<span class="pix-promo-box-link d-flex align-items-center ' . $link_classes . '" ' . $link_style . '><span>' . $link_text . '</span>' . \PixfortCore::instance()->icons->getIcon($iconName, 24, $iconClasses) . '</span>';
		}
		$output .= '</div>';
		if (!empty($link)) {
			$output .= '</a>';
		} else {
			$output .= '</div>';
		}
		$output .= '</div>';

		if (!empty($pix_tilt)) {
			$output .= '</div>';
		}
		if (!empty($animation)) {
			$output .= '</div>';
		}
		if (!empty($pix_infinite_animation)) {
			$output .= '</div>';
		}

		return $output;
	}
}
