<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Icon
* --------------------------------------------------------------------------- */
class PixIcon {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'media_type'			=> '',
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
			'image_size'	=> '',
			'circle'		=> '',
			'content_align'	=> 'left',
			'link_type'			=> 'link',
			'link'			=> '',
			'icon_popup_id'			=> '',
			'target'		=> '',
			'embed_code'  => '',
			'aspect' 	=> 'embed-responsive-21by9',
			'style' 		=> '',
			'hover_effect' 		=> '',
			'add_hover_effect' 		=> '',
			'animation'		=> '',
			'delay'		=> '0',
			'class'			=> '',
			'el_id'			=> '',
			'css' => '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
			if (!array_key_exists('_element_id', $attr)) {
				if(strpos($icon, '/') === false){
					if($media_type === "duo_icon") {
						if (!empty($pix_duo_icon)) {
							if(!empty($icon_size)&&$icon_size!==''){
								if(!isset($has_icon_bg)||empty($has_icon_bg)||($has_icon_bg!=='yes'&&$has_icon_bg!=='true')){
									$icon_size = (int) $icon_size * 1.8;
								}
								$icon_size = round((int) $icon_size * 0.75);
							}
							if(isset($icon_position) && $icon_position === 'left'){
								if(isset($padding_title) && strpos($padding_title, 'px') !== false){
									$padding_title = (int) $padding_title;
									if($padding_title >=3) $padding_title -= 3;
									$padding_title = $padding_title . 'px';
								}
							}
						}
					}
					if($media_type === "icon"&&!empty($icon)) {
						if(strpos($icon, 'pixicon') !== false){
							if(empty($has_icon_bg) || $has_icon_bg === ''){
								$has_icon_bg = 'yes';
								$icon_bg_color = 'transparent';
							}
						}
						if (strpos($icon, 'pixicon') === false) { 
							if(!empty($icon_size)&&$icon_size!==''){
								if(!isset($has_icon_bg)||empty($has_icon_bg)|| ($has_icon_bg!=='yes'&&$has_icon_bg !== 'true')){
									$icon_size = (int) $icon_size * 1.8;
								}
								$icon_size = round((int) $icon_size * 0.75);
							}
						}
					}
				}
				
			}
		}
		$css_class = esc_attr($css_class);
		if (!empty($class)) {
			$css_class .= ' ' . $class;
		}
		// target
		if ($target) {
			$target = '_blank';
		} else {
			$target = '_self';
		}
		if (empty($el_id)) {
			$el_id = 'duo-icon-' . rand(1, 200000000);
		}
		$i_color = '';
		$i_custom_color = '';
		if (!empty($icon_color)) {
			if ($icon_color != 'custom') {
				$i_color = 'text-' . $icon_color;
			} else {
				$i_custom_color .= 'color:' . $custom_icon_color . ';';
				if ($media_type == "duo_icon") {
					$customStyle = '#' . $el_id . ' path, ';
					$customStyle .= '#' . $el_id . ' rect, ';
					$customStyle .= '#' . $el_id . ' circle, ';
					$customStyle .= '#' . $el_id . ' polygon { fill: ' . $custom_icon_color . ' !important; }';
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
		$classes = array();
		$anim_class = '';
		$anim_type = '';
		$anim_delay_icon = '';
		if (!empty($animation)) {
			array_push($classes, 'animate-in');
			$anim_type = 'data-anim-type="' . $animation . '"';
			$anim_delay_icon = 'data-anim-delay="' . $delay . '"';
		}
		
		$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
        array_push($classes, $effectsClasses);

		$class_names = join(' ', $classes);

		// FIX FOR ICON SIZE
		// $icon_size_div = $icon_size;
		// if (!empty($has_icon_bg)) {
		// 	if ($media_type == "char") {
		// 		$icon_size_div = $icon_size * 2;
		// 	} else {
		// 		$icon_size_div = $icon_size * 1.8;
		// 	}
		// }
		$icon_size = (int) $icon_size;
		$icon_size_div = $icon_size;
		if (!empty($has_icon_bg) ) {
			if ($media_type == "char") {
				$icon_size_div = $icon_size * 2;
			// } elseif(str_contains($icon, 'Duotone/')) {
			// 	$icon_size_div = $icon_size * 2.4;
			} else {
				$icon_size_div = (int) ($icon_size * 1.8);
			}
		} else {
			if($media_type == "char") {
				$icon_size_div = (int) ($icon_size * 1.8);
			// } elseif(str_contains($icon, 'Duotone/')) {
			// 	$icon_size_div = $icon_size * 1.3;
			} else {
				$icon_size_div = $icon_size;
			}
		}

		$classes = '';
		if ($content_align == 'inline') {
			$classes .= 'd-inline-block';
		} else {
			$classes .= 'text-' . $content_align;
		}
		$size = 'large';
		$size_style = '';
		$imgSrc = '';
		if (!empty($circle)) {
			$size = "thumbnail";
			$circle = 'rounded-circle';
		}
		if (!empty($image_size)) {
			$size = $image_size . 'x' . $image_size;
			$size_style = 'width:' . $image_size . ';height:auto;display:inline-block;position:relative;';
		}
		if ($image) {
			if (empty($image_size)) {
				if ( is_int( $image ) ) {
					$image = apply_filters( 'wpml_object_id', $image, 'attachment', true );
				}
				$img = wp_get_attachment_image_src($image, $size);
				if (!empty($img[0])) {
					$imgSrc = $img[0];
				}
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
				if (!empty($img[0])) {
					$imgSrc = $img[0];
				}
			}
		}
		$link_data = '';
		$output = '';
		$link_classes = '';
		if ($link_type == 'popup') {
			if (!empty($icon_popup_id)) {
				$link_classes .= ' pix-popup-link';
				$link = '#';
				if (function_exists('icl_get_languages')) {
					$icon_popup_id = apply_filters('wpml_object_id', $icon_popup_id, 'post', true);
				}
				$link_data = 'data-popup-id="' . $icon_popup_id . '"';
			}
		} elseif ($link_type == 'video' || $link_type == 'embed') {
			$res = preg_replace("/[\`]/", "", $embed_code);
			$link_data = 'data-aspect="' . $aspect . '" data-content="' . htmlspecialchars($res) . '"';
			$link = '#';
			$link_classes .= ' pix-video-popup';
		}


		$output = '';
		if (!empty($link)) {
			$output .= '<a class="' . $classes . ' ' . $link_classes . '" ' . $link_data . ' aria-label="icon" href="' . $link . '" target="' . $target . '">';
		}
		$output .= '<div id="' . $el_id . '" class="pix-icon ' . $classes . ' ' . $css_class . '">';

		if ($media_type == "icon"||$media_type == "duo_icon") {
			if ($media_type == "duo_icon") {
				$icon = $pix_duo_icon;
			}
			
			if (!empty($has_icon_bg)) {
				$output .= '<div class="pix-icon-bg rounded-circle feature_img position-relative d-inline-flex align-items-center justify-content-center ' . $i_bg_color . ' ' . $class_names . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="' . $i_bg_custom_color . ' width:' . $icon_size_div . 'px;height:' . $icon_size_div . 'px;position:relative;line-height:' . $icon_size_div . 'px;text-align:center;"><span style="font-size:' . $icon_size . 'px;line-height:' . $icon_size . 'px;' . $i_custom_color . '" class="' . $i_color . ' d-inline-flex align-middle">' . \PixfortCore::instance()->icons->getIcon($icon, $icon_size) . '</span></div>';
			} else {
				$output .= '<div class="pix-icon-bg feature_img position-relative d-inline-block ' . $class_names . ' ' . $anim_class . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="width:' . $icon_size_div . 'px;height:' . $icon_size_div . 'px;position:relative;line-height:' . $icon_size_div . 'px;text-align:center;"><span style="font-size:' . $icon_size . 'px;line-height:' . $icon_size . 'px;' . $i_custom_color . '" class="' . $i_color . ' d-inline-flex align-middle">'.\PixfortCore::instance()->icons->getIcon($icon, $icon_size).'</span></div>';
			}
		}
		

		if ($media_type == "image") {
			$output .= '<div class="feature_img position-relative ' . $class_names . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="' . $size_style . '"><img style="width:' . $image_size . ';height:' . $image_size . ';" class="pix-fit-cover ' . $circle . '" src="' . $imgSrc . '" alt=""></div>';
		}
		if ($media_type == "char") {
			if (!empty($has_icon_bg)) {
				$output .= '<div class="rounded-circle d-inline-block feature_img position-relative ' . $i_bg_color . ' ' . $class_names . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="' . $i_bg_custom_color . ' width:' . $icon_size_div . 'px;height:' . $icon_size_div . 'px;position:relative;line-height:' . $icon_size_div . 'px;text-align:center;"><span style="display:inline-block;font-size:' . $icon_size . 'px;line-height:' . $icon_size . 'px;' . $i_custom_color . '" class="' . $i_color . ' align-middle">' . $char . '</span></div>';
			} else {
				$output .= '<div class="d-inline-block feature_img position-relative ' . $class_names . '" ' . $anim_type . ' ' . $anim_delay_icon . ' style="width:' . $icon_size_div . 'px;height:' . $icon_size_div . 'px;position:relative;line-height:' . $icon_size_div . 'px;text-align:center;"><span style="display:inline-block;font-size:' . $icon_size . 'px;line-height:' . $icon_size . 'px;' . $i_custom_color . '" class="' . $i_color . ' align-middle">' . $char . '</span></div>';
			}
		}
		
		$output .= '</div>';
		if (!empty($link)) {
			$output .= '</a>';
		}
		return $output;
	}
}

