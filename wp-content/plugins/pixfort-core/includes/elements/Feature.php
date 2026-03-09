<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
 * Pix Feature 
* --------------------------------------------------------------------------- */
class PixFeature {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'title'					=> '',
			'title_bold'			=> '',
			'title_italic'			=> '',
			'title_secondary'			=> '',
			'title_color'			=> 'heading-default',
			'title_custom_color'	=> '',
			'title_size'			=> 'h5',
			'title_custom_size'		=> '',
			'title_html_tag'			=> '',
			'content_color'			=> 'text-gray',
			'content_custom_color'	=> '',
			'content_size'			=> '',
			'content_bold'			=> '',
			'content_italic'		=> '',
			'content_secondary_font'		=> '',
			'media_type'			=> '',
			'padding_title'			=> '20px',
			'padding_content'		=> '20px',
			'char'			=> '1',
			'pix_duo_icon'			=> '',
			'icon'			=> 'pixicon-question-circle',
			'icon_color'	=> 'primary',
			'custom_icon_color'	=> '',
			'has_icon_bg'	=> '',
			'icon_bg_color'	=> 'primary-light',
			'icon_custom_bg_color'	=> '',
			'icon_size'		=> '30',
			'image'			=> '',
			'dynamic_image'	=> '',
			'image_size'	=> '',
			'circle'		=> '',
			'icon_position'	=> 'top',
			'content_align'	=> 'left',
			'justify'		=> '',
			'link'			=> '',
			'target'		=> '',
			'animation'		=> '',
			'delay'		=> '',
			'class'			=> '',
			'element_id'			=> '',
			'css' => '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
			// check if $attr array doesn't includes "_element_id" key
			if (!array_key_exists('_element_id', $attr)) {
					if (strpos($icon, '/') === false) {
						if ($media_type === "duo_icon") {
							if (!empty($pix_duo_icon)) {
								if (!empty($icon_size) && $icon_size !== '') {
									if (!isset($has_icon_bg) || empty($has_icon_bg) || ($has_icon_bg !== 'yes' && $has_icon_bg !== 'true')) {
										$icon_size = (int) $icon_size * 1.8;
									}
									$icon_size = round((int) $icon_size * 0.85);
								}
								if (isset($icon_position) && $icon_position === 'left') {
									if (isset($padding_title) && strpos($padding_title, 'px') !== false) {
										$padding_title = (int) $padding_title;
										if ($padding_title >= 3) $padding_title -= 3;
										$padding_title = $padding_title . 'px';
									}
								}
							}
						}
						if ($media_type === "icon" && !empty($icon) && strpos($icon, 'pixicon') === false) {
							if (!empty($icon_size) && $icon_size !== '') {
								if (!isset($has_icon_bg) || empty($has_icon_bg) || ($has_icon_bg !== 'yes' && $has_icon_bg !== 'true')) {
									$icon_size = (int) $icon_size * 1.8;
								}
								$icon_size = round((int) $icon_size * 0.85);
							}
						}
					}

			}
		}

		$css_class = esc_attr($css_class);
		$title = pix_unescape_vc($title);
		// target
		if ($target) {
			$target = 'target="_blank"';
		} else {
			$target = '';
		}

		if (empty($element_id)) {
			$element_id = 'duo-icon-' . rand(1, 200000000);
		} else {
			// $element_id = 'pix-feature-'.$element_id;
			// if $element_id doesn't start with a character, add 'pix-feature-' to the beginning of the string
			if (!preg_match('/^[a-zA-Z]/', $element_id)) {
				$element_id = 'pix-feature-' . $element_id;
			}
		}

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

		$i_bg_color = '';
		$i_bg_custom_color = '';
		if (!empty($icon_bg_color)) {
			if ($icon_bg_color != 'custom') {
				$i_bg_color = 'bg-' . $icon_bg_color;
			} else {
				$i_bg_custom_color .= 'background:' . $icon_custom_bg_color . ';';
			}
		}


		$anim_class = '';
		$anim_type = '';
		$anim_delay_icon = '';
		$anim_delay_title = '';
		$anim_delay_content = '';
		if (!empty($animation)) {
			$anim_class = 'animate-in';
			$anim_type = 'data-anim-type="' . $animation . '"';
			$anim_delay_icon = 'data-anim-delay="' . $delay . '"';
			$t_delay = (int) $delay + 100;
			$anim_delay_title = 'data-anim-delay="' . $t_delay . '"';
			$c_delay = $t_delay + 100;
			$anim_delay_content = 'data-anim-delay="' . $c_delay . '"';
		}

		$icon_size = (int) $icon_size;
		$icon_size_div = $icon_size;
		if (!empty($has_icon_bg)) {
			if ($media_type == "char") {
				$icon_size_div = $icon_size * 2;
			} else {
				$icon_size_div = $icon_size * 1.8;
			}
		} else {
			if ($media_type == "char") {
				$icon_size_div = $icon_size * 1.8;
			}
		}




		$classes = '';
		$classes .= 'text-' . $content_align;
		if (!empty($justify)) {
			$justify = 'text-justify';
		}

		$size = 'large';
		$size_style = '';
		if (!empty($circle)) {
			$size = "thumbnail";
			$circle = 'rounded-circle';
		}
		if (!empty($image_size)) {
			$size = $image_size . 'x' . $image_size;
			$size_style = 'width:' . $image_size . ';height:auto;display:inline-block;position:relative;';
		}
		$imgSrc = '';
		$dynamic_img_src = '';
		// if(\PixfortCore::instance()->getThemeParam('dynamic_wpb_images')){
		// 	if (!empty($dynamic_image) && class_exists('Pixfort_Dynamic_Shortcode')) {
		// 		$dynamic_img_src = Pixfort_Dynamic_Shortcode::instance()->render_dynamic_image($dynamic_image);

		// 		if (is_string($dynamic_img_src)) {
		// 			$dynamic_img_src = trim($dynamic_img_src);
		// 		} else {
		// 			$dynamic_img_src = '';
		// 		}
		// 		$dynamic_img_src = esc_url($dynamic_img_src);
		// 	}
		// }

		// if (!empty($dynamic_img_src)) {
		// 	$imgSrc = $dynamic_img_src;
		// } else {
			$imageData = \PixfortCore::instance()->coreFunctions->getImageSrc($image);
			if (!empty($imageData['url'])) {
				$imgSrc = $imageData['url'];
			}
		// }

		$title_style = '';
		if (!empty($padding_title)) {
			$title_style .= 'padding-top:' . $padding_title . ';';
		}

		$t_color = '';
		if (!empty($title_color)) {
			if ($title_color != 'custom') {
				$t_color = 'text-' . $title_color;
			} else {
				$title_style .= 'color:' . $title_custom_color . ' !important;';
			}
		}
		$title_classes = '';
		$title_tag = $title_size;
		if (!empty($title_html_tag) && $title_html_tag !== 'default') {
			$title_tag = $title_html_tag;
			$title_classes .= $title_size;
		} else {
			if ($title_size == 'custom') {
				$title_tag = "div";
			}
		}
		if ($title_size == 'custom') {
			$title_style .= "font-size:" . $title_custom_size . ';';
		}

		$title_style = 'style="' . $title_style . '"';

		$c_color = '';
		$c_custom_style = '';
		if (!empty($content_color)) {
			if ($content_color != 'custom') {
				$c_color = 'text-' . $content_color;
			} else {
				$c_custom_style .= 'color:' . $content_custom_color . ';';
			}
		}
		if (!empty($padding_content)) {
			$c_custom_style .= 'padding-top:' . $padding_content . ';';
		}
		$c_custom_style = 'style="' . $c_custom_style . '"';



		$output = '';
		if (!empty($link)) {
			$output .= '<a href="' . $link . '" ' . $target . '>';
		}

		// RTL
		$margin3 = 'mr-3';
		if (is_rtl()) {
			$margin3 = 'ml-3';
		}


		if ($icon_position == "left") {
			$output .= '<div id="' . $element_id . '" class="pix-feature-el media ' . $css_class . '">';

			if ($media_type == "icon" || $media_type == "duo_icon") {
				if ($media_type == "duo_icon") {
					$icon = $pix_duo_icon;
				}
				if (!empty($icon)) {

					if (!empty($has_icon_bg)) {
						$output .= '<div class="rounded-circle pix-feature-icon-outer ' . $margin3 . ' d-inline-flex align-items-center justify-content-center line-height-0 mw-100 ' . $i_bg_color . ' ' . $anim_class . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="' . $i_bg_custom_color . ' width:' . $icon_size_div . 'px;aspect-ratio:1/1 !important;position:relative;text-align:center;">';
						$output .= '<div class="pix-feature-icon d-inline-flex ' . $i_color . '" style="font-size:' . $icon_size . 'px;width:' . $icon_size . 'px;height:' . $icon_size . 'px;' . $i_custom_color . 'font-size:' . $icon_size . 'px;">';
						$output .= \PixfortCore::instance()->icons->getIcon($icon);
						$output .= '</div>';
						$output .= '</div>';
					} else {
						$output .= '<div class="pix-feature-icon pix-feature-icon-outer ' . $margin3 . ' mw-100 d-flex ' . $i_color . ' ' . $anim_class . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="font-size:' . $icon_size . 'px;width:' . $icon_size_div . 'px;aspect-ratio:1/1 !important;position:relative;line-height:' . $icon_size_div . 'px;' . $i_custom_color . 'text-align:center;">';
						$output .= \PixfortCore::instance()->icons->getIcon($icon);
						$output .= '</div>';
					}
				}
			}
			

			if ($media_type == "image") {
				$output .= '<div class="feature_img position-relative pix-feature-icon-outer ' . $margin3 . ' ' . $anim_class . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="' . $size_style . '"><img style="width:' . $image_size . ';height:' . $image_size . ';" class="pix-fit-cover ' . $circle . '" src="' . $imgSrc . '" alt="' . esc_attr(do_shortcode($title)) . '"></div>';
			} else if ($media_type == "char") {
				if (!empty($has_icon_bg)) {
					$output .= '<div class="rounded-circle d-inline-flex align-items-center justify-content-center pix-feature-icon-outer ' . $margin3 . ' feature_img position-relative ' . $i_bg_color . ' ' . $anim_class . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="' . $i_bg_custom_color . ' width:' . $icon_size_div . 'px;height:auto !important;aspect-ratio:1/1 !important;position:relative;line-height:' . $icon_size_div . 'px;text-align:center;"><span style="display:inline-block;font-size:' . $icon_size . 'px;line-height:' . $icon_size . 'px;' . $i_custom_color . '" class="pix-feature-icon ' . $i_color . ' align-middle">' . $char . '</span></div>';
				} else {
					if($icon_size === 1) {
						$output .= '<div class="pix-feature-icon d-inline-block pix-feature-icon-outer ' . $margin3 . ' feature_img position-relative ' . $anim_class . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="width:' . $icon_size_div . 'px;height:auto !important;aspect-ratio:1/1 !important;position:relative;line-height:' . $icon_size_div . 'px;text-align:center;"><span style="display:inline-block;' . $i_custom_color . '" class="' . $i_color . ' align-middle">' . $char . '</span></div>';
					} else {
						$output .= '<div class="pix-feature-icon d-inline-block pix-feature-icon-outer ' . $margin3 . ' feature_img position-relative ' . $anim_class . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="width:' . $icon_size_div . 'px;height:auto !important;aspect-ratio:1/1 !important;position:relative;line-height:' . $icon_size_div . 'px;text-align:center;"><span style="display:inline-block;font-size:' . $icon_size . 'px;line-height:' . $icon_size . 'px;' . $i_custom_color . '" class="' . $i_color . ' align-middle">' . $char . '</span></div>';
					}
				}
			}
			$output .= '<div class="media-body ' . $classes . '">';
			$output .= '<' . $title_tag . ' class="pix-feature-title ' . $title_classes . ' ' . $title_bold . ' ' . $title_italic . ' ' . $title_secondary . ' ' . $t_color . ' ' . $anim_class . ' " ' . $title_style . ' ' . $anim_type . ' ' . $anim_delay_title . '>' . do_shortcode($title) . '</' . $title_tag . '>';
			$output .= '<div class="pix-feature-content ' . $c_color . ' ' . $content_size . ' ' . $content_italic . ' ' . $content_secondary_font . ' ' . $content_bold . ' ' . $justify . ' ' . $anim_class . '" ' . $c_custom_style . ' ' . $anim_type . ' ' . $anim_delay_content . '>' . do_shortcode($content) . '</div>';
			$output .= '</div>';
			$output .= '</div>';
		} else {
			$output .= '<div id="' . $element_id . '" class="pix-feature-el ' . $classes . ' ' . $css_class . '">';
			if ($media_type == "icon" || $media_type == "duo_icon") {
				if ($media_type == "duo_icon") {
					$icon = $pix_duo_icon;
				}
				if (!empty($icon)) {
					if (!empty($has_icon_bg)) {
						$output .= '<div class="pix-feature-bg rounded-circle d-inline-flex align-items-center justify-content-center line-height-0 mw-100 ' . $i_bg_color . ' ' . $anim_class . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="' . $i_bg_custom_color . ' width:' . $icon_size_div . 'px;aspect-ratio:1/1 !important;position:relative;text-align:center;">';
						$output .= '<div class="pix-feature-icon ' . $i_color . '" style="display:inline-flex;width:' . $icon_size . 'px;height:' . $icon_size . 'px;' . $i_custom_color . 'font-size:' . $icon_size . 'px;">';
						$output .= \PixfortCore::instance()->icons->getIcon($icon);
						$output .= '</div>';
						$output .= '</div>';
					} else {
						$output .= '<div class="pix-feature-icon d-inline-block mw-100 ' . $i_color . ' ' . $anim_class . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="aspect-ratio:1/1 !important;position:relative;text-align:center;font-size:' . $icon_size . 'px;' . $i_custom_color . 'line-height:' . $icon_size . 'px;">';
						$output .= \PixfortCore::instance()->icons->getIcon($icon);
						$output .= '</div>';
					}
				}
			}
			


			if ($media_type == "image") {
				$output .= '<div class="feature_img position-relative ' . $anim_class . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="' . $size_style . '"><img style="width:' . $image_size . ';height:' . $image_size . ';" class="pix-fit-contain  ' . $circle . '" src="' . $imgSrc . '" alt="' . esc_attr(do_shortcode($title)) . '"></div>';
			}
			if ($media_type == "char") {
				if (!empty($has_icon_bg)) {
					$output .= '<div class="pix-feature-bg rounded-circle d-inline-flex align-items-center justify-content-center feature_img position-relative ' . $i_bg_color . ' ' . $anim_class . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="' . $i_bg_custom_color . ' width:' . $icon_size_div . 'px;height:auto !important;aspect-ratio:1/1 !important;position:relative;line-height:' . $icon_size_div . 'px;text-align:center;"><span style="display:inline-block;font-size:' . $icon_size . 'px;line-height:' . $icon_size . 'px;' . $i_custom_color . '" class="pix-feature-icon ' . $i_color . ' align-middle">' . $char . '</span></div>';
				} else {
					if($icon_size === 1) {
						$output .= '<div class="pix-feature-icon d-inline-block ' . $anim_class . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="width:' . $icon_size_div . 'px;height:auto !important;aspect-ratio:1/1 !important;position:relative;line-height:' . $icon_size_div . 'px;text-align:center;"><span style="display:inline-block;' . $i_custom_color . '" class="' . $i_color . ' align-middle">' . $char . '</span></div>';
					} else {
						$output .= '<div class="pix-feature-icon d-inline-block ' . $anim_class . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="width:' . $icon_size_div . 'px;height:auto !important;aspect-ratio:1/1 !important;position:relative;line-height:' . $icon_size_div . 'px;text-align:center;"><span style="display:inline-block;font-size:' . $icon_size . 'px;line-height:' . $icon_size . 'px;' . $i_custom_color . '" class="' . $i_color . ' align-middle">' . $char . '</span></div>';
					}
				}
			}
			$output .= '<' . $title_tag . ' class="pix-feature-title ' . $title_classes . ' ' . $title_bold . ' ' . $title_italic . ' ' . $title_secondary . ' ' . $t_color . ' ' . $anim_class . '" ' . $title_style . ' ' . $anim_type . ' ' . $anim_delay_title . '>' . do_shortcode($title) . '</' . $title_tag . '>';
			$output .= '<div class="pix-feature-content ' . $c_color . ' ' . $content_size . ' ' . $content_italic . ' ' . $content_secondary_font . ' ' . $content_bold . ' ' . $justify . ' ' . $anim_class . '" ' . $c_custom_style . ' ' . $anim_type . ' ' . $anim_delay_content . '>' . do_shortcode($content) . '</div>';
			$output .= '</div>';
		}

		if (!empty($link)) {
			$output .= '</a>';
		}


		return $output;
	}
}
