<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* ShopCategory
* --------------------------------------------------------------------------- */
class PixShopCategory {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'image'  => '',
			'cat'  => '',
			'link_text'  => 'Check it out',
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
			'style' 		=> '',
			'hover_effect' 		=> '',
			'add_hover_effect' 		=> '',
			'pix_infinite_animation' 		=> '',
			'pix_infinite_speed' 		=> '',
			'count_bold'		=> 'font-weight-bold',
			'count_italic'		=> '',
			'count_secondary_font'		=> '',
			'count_color'		=> 'white',
			'count_custom_color'		=> '',
			'title_bold'		=> 'font-weight-bold',
			'title_italic'		=> '',
			'title_secondary_font'		=> '',
			'title_color'		=> 'white',
			'title_custom_color'		=> '',
			'link_bold'		=> 'font-weight-bold',
			'link_italic'		=> '',
			'link_secondary_font'		=> '',
			'link_color'		=> 'light-opacity-6',
			'link_custom_color'		=> '',

			'overlay_color'		=> 'heading-default',
			'overlay_custom_color'		=> '',
			'overlay_opacity'		=> 'pix-opacity-4',
			'hover_overlay_opacity'		=> 'pix-hover-opacity-6',
			'extra_classes'		=> '',
			'css' 		=> '',
		), $attr));

		if (!class_exists('WooCommerce')) {
			return 'WooCommerce is not installed or activated!';
		}
		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		$css_class .= ' ' . $extra_classes;

		$output = '';
		$class_names = '';

		$count_classes = pix_get_text_format_classes($count_bold, $count_italic, $count_secondary_font, $count_color);
		$title_classes = pix_get_text_format_classes($title_bold, $title_italic, $title_secondary_font, $title_color);
		$link_classes = pix_get_text_format_classes($link_bold, $link_italic, $link_secondary_font, $link_color);
		$count_style = '';
		if ($count_color == 'custom') {
			$count_style = 'style="color:' . $count_custom_color . ';"';
		}
		$title_style = '';
		if ($title_color == 'custom') {
			$title_style = 'style="color:' . $title_custom_color . ';"';
		}
		$link_style = '';
		if ($link_color == 'custom') {
			$link_style = 'style="color:' . $link_custom_color . ';"';
		}
		$el_style = '';
		if ($overlay_color == 'custom') {
			$el_style = 'style="--pix-bg-color:' . $overlay_custom_color . ';"';
		}

		$imgSrcset = '';
		$imgSrc = '';
		if (is_string($image) && substr($image, 0, 4) === "http") {
			$imgSrc = $image;
		} else {
			if (is_array($image) && !empty($image['id'])) {
				if ( is_int( $image['id'] ) ) {
					$image['id'] = apply_filters( 'wpml_object_id', $image['id'], 'attachment', true );
				}
				$img = wp_get_attachment_image_src($image['id'], "full");
				$imgSrcset = wp_get_attachment_image_srcset($image['id']);
			} else {
				if ( is_int( $image ) ) {
					$image = apply_filters( 'wpml_object_id', $image, 'attachment', true );
				}
				$img = wp_get_attachment_image_src($image, "pix-big");
				$imgSrcset = wp_get_attachment_image_srcset($image);
			}
			if(!empty($img[0])){
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
		if ($pix_scroll_parallax) {
			if (!empty($xaxis) || !empty($yaxis)) {
				$jarallax = 'data-jarallax-element="' . $xaxis . ' ' . $yaxis . '" data-xaxis="' . $xaxis . '" data-yaxis="' . $yaxis . '"';
			}
		}


		$output = '';
		if ($cat) {
			$cat_val = get_term($cat, 'product_cat');
			if (empty($cat_val)) {
				$categories = get_terms(['taxonomy' => 'product_cat']);
				if (!empty($categories)) {
					if ($categories && !empty($categories[0])) {
						$cat_val = get_term($categories[0]->term_id, 'product_cat');
					}
				}
			}
			if (!empty($cat_val)) {
				$card_title = $title;
				if (empty($title)) {
					$card_title = $cat_val->name;
				}

				if (!empty($pix_infinite_animation)) {
					$output .= '<div class="w-100 ' . $pix_infinite_animation . ' ' . $pix_infinite_speed . '">';
				}
				if (!empty($animation)) {
					$anim_type = 'data-anim-type="' . $animation . '"';
					$anim_delay = 'data-anim-delay="' . $delay . '"';
					$output .= '<div class="animate-in d-inline-block w-100" ' . $anim_type . ' ' . $anim_delay . '>';
				}
				if (!empty($pix_tilt)) {
					$output .= '<div class="' . $pix_tilt_size . '">';
				}

				$url = get_term_link($cat_val);
				if (empty($url)) {
					$url = '';
				}
				if (!$url) {
					$url = '';
				}
				if (!empty($link)) {
					$url = $link;
				}


				$items_text = esc_attr__('items', 'pixfort-core');
				if (!empty($cat_val->count) && $cat_val->count == 1) {
					$items_text = esc_attr__('item', 'pixfort-core');
				}

				if (empty($alt)) $alt = $card_title;

				$output .= '<div class="pix-shop-category card w-100 h-100 bg-' . $overlay_color . ' pix-hover-item ' . $rounded_img . ' position-relative overflow-hidden ' . $class_names . '" ' . $el_style . ' ' . $jarallax . '>';
				$output .= '<img srcset="' . $imgSrcset . '" src="' . $imgSrc . '" class="card-img pix-bg-image pix-img-scale ' . $overlay_opacity . ' ' . $rounded_img . ' ' . $hover_overlay_opacity . '" alt="' . $alt . '">';		
				$output .= '<a href="' . $url . '" class="d-inline-block w-100 pix-img-overlay pix-p-20">
				  	<div class="badge bg-dark-opacity-3 ' . $count_classes . '" ' . $count_style . '>' . $cat_val->count . ' ' . $items_text . '</div>
				    <h5 class="card-title ' . $title_classes . ' pix-my-10" ' . $title_style . '>' . $card_title . '</h5>';
				$arrowIcon = 'Line/pixfort-icon-arrow-right-2';
				$hoverEffect = 'pix-hover-right';
				if (is_rtl()) {
					$arrowIcon = 'Line/pixfort-icon-arrow-left-2';
					// $hoverEffect = 'pix-hover-left';
				}
				if (!empty($link_text)) $output .= '<span class="d-flex align-items-center ' . $link_classes . '" ' . $link_style . '><span>' . $link_text . '</span>'. \PixfortCore::instance()->icons->getIcon($arrowIcon, 24, $hoverEffect.' pix-hover-item text-20') .'</span>';
				$output .= '</a>
				</div>';


				if (!empty($pix_tilt)) {
					$output .= '</div>';
				}
				if (!empty($animation)) {
					$output .= '</div>';
				}
				if (!empty($pix_infinite_animation)) {
					$output .= '</div>';
				}
			}
		}
		return $output;
	}
}

