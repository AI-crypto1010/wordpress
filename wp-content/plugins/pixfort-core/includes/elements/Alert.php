<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
 * Alert Block [alertblock]
 * --------------------------------------------------------------------------- */
class PixAlert {

	function render($attr, $content = null) {

		extract(shortcode_atts(array(
			'title' 								=> ' ',
			'bold'									=> 'font-weight-bold',
			'alert_inner_typography_font_weight'	=> '',
			'italic'								=> '',
			'secondary_font'						=> '',
			'alert_type_1' 							=> 'success',
			'shadow' 								=> '1',
			'hover_effect' 							=> '',
			'add_hover_effect' 						=> '',
			'rounded_img' 							=> 'rounded',
			'media_type'							=> '',
			'char'									=> '1',
			'pix_duo_icon'							=> '',
			'icon'									=> 'pixicon-question-circle',
			'icon_color'							=> 'primary',
			'custom_icon_color'						=> '',
			'icon_size'								=> '30',
			'image'									=> '',
			'dynamic_image'							=> '',
			'image_size'							=> '',
			'circle'								=> '',
			'animation' 							=> '',
			'link_text'  							=> '',
			'link' 									=> '',
			'link_color' 							=> 'alert-default',
			'text_custom_color' 					=> '',
			'target' 								=> '',
			'delay' 								=> '0',
			'hide_close' 							=> '',
			'css' 									=> '',
		), $attr));

		if (!empty($alert_inner_typography_font_weight)) $bold = '';
		$output  = '';
		$shadow_class = '';

		$classes = array();
		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
			$title = pix_unescape_vc($title);
		}
		wp_enqueue_style('pixfort-alert-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/alert.min.css', false, PIXFORT_PLUGIN_VERSION);
		array_push($classes, $css_class);
		array_push($classes, $rounded_img);

		$link_style = '';
		$link_classes = '';
		if (!empty($link_color)) {
			if ($link_color != 'custom') {
				$link_classes = 'text-' . $link_color;
			} else {
				$link_style .= 'style="color:' . $text_custom_color . ' !important;"';
			}
		}

		if (!empty($bold)) array_push($classes, $bold);
		if (!empty($italic)) array_push($classes, $italic);
		if (!empty($secondary_font)) array_push($classes, $secondary_font);

		if ($shadow === 'true') $shadow = "2";
		

		$anim_attrs = '';
		if (!empty($animation)) {
			array_push($classes, 'animate-in');
			$anim_attrs = 'data-anim-delay="' . $delay . '" data-anim-type="' . $animation . '"';
		}

		$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($shadow, $hover_effect, $add_hover_effect);
		array_push($classes, $effectsClasses);

		$i_color = '';
		$i_custom_color = '';
		if (!empty($icon_color)) {
			if ($icon_color != 'custom') {
				$i_color = 'text-' . $icon_color;
			} else {
				$i_custom_color .= 'color:' . $custom_icon_color . ';';
				if ($media_type == "duo_icon") {
					$customStyle = '#' . $element_id . ' path, ';
					$customStyle .= '#' . $element_id . ' rect, ';
					$customStyle .= '#' . $element_id . ' circle, ';
					$customStyle .= '#' . $element_id . ' polygon { fill: ' . $custom_icon_color . ' !important; }';
					wp_register_style('pix-duo-icons-handle', false);
					wp_enqueue_style('pix-duo-icons-handle');
					wp_add_inline_style('pix-duo-icons-handle', $customStyle);
				}
			}
		}
		$size = 'full';
		$size_style = '';

		if (!empty($image_size)) {
			$size_style = 'width:' . $image_size . ';height:auto;';
		}
		if (!empty($circle)) {
			$image_int_size = (int) filter_var($image_size, FILTER_SANITIZE_NUMBER_INT);
			$size = array($image_int_size, $image_int_size);
			$circle = 'rounded-circle';
		}
		$icon_size_div = $icon_size;
		$imgSrc = false;

	
		if ($image) {
			if (is_string($image) && substr($image, 0, 4) === "http") {
				$img = $image;
				$imgSrc = $img;
			} else {
				if (!empty($image['id'])) {
					if ( is_int( $image['id'] ) ) {
						$image['id'] = apply_filters( 'wpml_object_id', $image['id'], 'attachment', true );
					}
					$img = wp_get_attachment_image_src($image['id'], $size);
				} else {
					if ( is_int( $image ) ) {
						$image = apply_filters( 'wpml_object_id', $image, 'attachment', true );
					}
					$img = wp_get_attachment_image_src($image, $size);
				}
				if(!empty($img[0])) {
					$imgSrc = $img[0];
				}
			}
		}


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

		$target_out = '';
		if (!empty($target)) {
			$target_out = 'target="_blank"';
		}

		$class_names = join(' ', $classes);
		$output = '';

		if (empty($link_text)) {
			if (!empty($link)) {
				$output .= '<a ' . $custom_link_atts . ' href="' . $link . '" ' . $target_out . ' class="alert-link pix-hover-item">';
			}
		}
		$output .= '<div class="alert position-relative d-flex flex-column flex-sm-row justify-content-between align-items-center alert-' . $alert_type_1 . ' ' . $shadow_class . ' ' . $class_names . '" role="alert" ' . $anim_attrs . '>';

		$alertTitleMargin = 'mr-2';
		$alertTitleMarginMedia = 'mr-0 mr-sm-3';
		if (is_rtl()) {
			$alertTitleMargin = 'ml-2';
			$alertTitleMarginMedia = 'ml-0 ml-sm-3';
		}

		/*	Alert Icon	*/
		if (!empty($media_type) && $media_type != "none") {
			$output .= '<div class="pix-alert-icon d-inline-flex align-items-center mb-2 mb-sm-0 order-2">';

			if ($media_type == "icon" || $media_type == "duo_icon") {
				if ($media_type == "duo_icon") {
					$icon = $pix_duo_icon;
				}
				if (str_contains($icon, 'Duotone/')) {
					$icon_size = $icon_size_div;
				}
				$output .= '<div class="d-inline-flex align-items-center position-relative text-center ' . $alertTitleMarginMedia . '" ' . 'style="font-size:' . $icon_size . 'px;">';
				$output .= \PixfortCore::instance()->icons->getIcon($icon, $icon_size, $i_color);
				$output .= '</div>';
			}

			if ($media_type == "image" && $imgSrc) {
				$output .= '<div class="feature_img ' . $alertTitleMarginMedia . ' d-inline-block position-relative" style="' . $size_style . '"><img style="' . $size_style . '" class="pix-fit-cover ' . $circle . '" src="' . $imgSrc . '" alt="' . do_shortcode($title) . '"></div>';
			} else if ($media_type == "char") {
				$output .= '<div class="d-inline-flex justify-content-center align-items-center  ' . $alertTitleMarginMedia . '" ' . ' feature_img" style="width:' . $icon_size_div . 'px;height:' . $icon_size_div . 'px;position:relative;line-height:' . $icon_size_div . 'px;text-align:center;"><span style="display:inline-block;font-size:' . $icon_size . 'px;line-height:' . $icon_size . 'px;' . $i_custom_color . '" class="' . $i_color . ' align-middle">' . $char . '</span></div>';
			}
			$output .= '</div>';
		}

		$output .= '<div class="pix-alert-title ' . $alertTitleMargin . ' flex-grow-1 mb-2 mb-sm-0 order-2">';
		$output .= do_shortcode($title);
		$output .= '</div>';

		if (!empty($link_text)) {
			$output .= '<div class="pix-alert-link mr-0 mr-sm-2 order-2">';
			if (!empty($link)) {
				$output .= '<a ' . $custom_link_atts . ' href="' . $link . '" ' . $target_out . ' class="pix-alert-link pix-hover-item alert-' . $link_classes . '" ' . $link_style . '>';
			}
			$output .= '<span class="d-flex align-items-center"><span class="text-nowrap ' . $link_classes . '">' . do_shortcode($link_text) . '</span>';
			$output .= \PixfortCore::instance()->icons->getIcon('pixicon-angle-right', 20, $link_classes . ' pix-hover-right pix-hover-item text-20');
			$output .= '</span>';
			if (!empty($link)) {
				$output .= '</a>';
			}
			$output .= '</div>';
		}

		if (empty($hide_close)) {
			$output .= '<button type="button" class="close order-1 order-sm-3 text-right text-sm-center" data-dismiss="alert" aria-label="Close">';
			$output .= '<span aria-hidden="true">&times;</span>';
			$output .= '</button>';
		}

		$output .= '</div>';
		if (empty($link_text)) {
			if (!empty($link)) {
				$output .= '</a>';
			}
		}
		return $output;
	}
}
