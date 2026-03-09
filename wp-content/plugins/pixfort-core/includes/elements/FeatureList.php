<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* FeatureList
* --------------------------------------------------------------------------- */
class PixFeatureList {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'features'  => '',
			'content_size'  => '',
			'content_color'  => 'primary',
			'content_custom_color'  => '',
			'icon_color'  => 'primary',
			'custom_icon_color'  => '',
			'flist_bold'			=> 'font-weight-bold',
			'flist_italic'			=> '',
			'flist_secondary_font'			=> '',
			'animation' 	=> '',
			'delay' 	=> '0',
			'features_content_align'		=> '',
			'element_id' 		=> '',
			'css' 		=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		$c_color = '';
		$c_custom_color = '';
		if (!empty($content_color)) {
			if ($content_color != 'custom') {
				$c_color = 'text-' . $content_color;
			} else {
				$c_custom_color = 'style="color:' . $content_custom_color . ';"';
			}
		}
		if (empty($element_id)) {
			$element_id = 'accordion-' . hash('md5', json_encode($features));
			// 	$element_id = 'duo-icon-' . rand(1, 200000000);
		}
		$i_color = '';
		$i_custom_color = '';
		if (!empty($icon_color)) {
			if ($icon_color != 'custom') {
				$i_color = 'text-' . $icon_color;
			} else {
				$i_custom_color .= 'style="color:' . $custom_icon_color . ';"';
				$customStyle = '#' . $element_id . ' path, ';
				$customStyle .= '#' . $element_id . ' rect, ';
				$customStyle .= '#' . $element_id . ' circle, ';
				$customStyle .= '#' . $element_id . ' polygon { fill: ' . $custom_icon_color . ' !important; }';
				wp_register_style('pix-duo-icons-handle', false);
				wp_enqueue_style('pix-duo-icons-handle');
				wp_add_inline_style('pix-duo-icons-handle', $customStyle);
			}
		}

		$anim_type = '';
		$anim_delay = '';
		$anim_class = '';
		if (!empty($animation)) {
			$anim_type = 'data-anim-type="' . $animation . '"';
			$anim_delay = 'data-anim-delay="' . $delay . '"';
			$anim_class = 'animate-in';
		}
		if (is_array($features)) {
			$features_arr = $features;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$features_arr = vc_param_group_parse_atts($features);
			}
		}
		
		$output = '<div id="' . $element_id . '" class="w-100  ' . esc_attr($css_class) . '" >';
		$output .= '<div class="py-2 ' . $anim_class . '" ' . $anim_type . ' ' . $anim_delay . '>';
		if (is_array($features_arr)) {
			foreach ($features_arr as $key => $value) {
				extract(shortcode_atts(array(
					'text' 	=> '',
					'link' 	=> '',
					'target' 	=> '',
				), $value));

				$feature_classes = array();
				array_push($feature_classes, $flist_bold);
				array_push($feature_classes, $flist_italic);
				array_push($feature_classes, $flist_secondary_font);
				$feature_classes_names = join(' ', $feature_classes);

				if (!empty($features_content_align)) {
					switch ($features_content_align) {
						case 'text-left':
							$features_content_align = 'justify-content-start';
							break;
						case 'text-right':
							$features_content_align = 'justify-content-end';
							break;
						case 'text-center':
							$features_content_align = 'justify-content-center';
							break;
					}
				}
				if (!empty($link)) {
					if (is_array($link)) {
						$link['target'] = '_self';
						if ($link['is_external']) {
							$link['target'] = '_blank';
						}
						if ($link['nofollow']) {
							$link['rel'] = 'nofollow';
						}
						$link['title'] = $text;
					} elseif (substr($link, 0, 4) === 'url:') {
						if (function_exists('vc_build_link')) {
							$link = vc_build_link($link);
						}
					}
					if (!is_array($link)) {
						$link = array(
							'url'   => '',
							'target'   => '',
							'title'   => '',
							'rel'   => '',
						);
					}
				}


				$output .= '<div class="pix-feature-list ' . $content_size . ' ' . $features_content_align . ' ' . $feature_classes_names . '   py-2 d-flex align-items-center" ' . $c_custom_color . '>';
				if (!empty($link) && !empty($link['url'])) {
					$output .= '<a class="d-flex align-items-center" href="' . $link['url'] . '" target="' . $link['target'] . '">';
				}
				// $output .= '<div class=" w-100">';
				$margin10 = 'pix-mr-10';
				$margin2 = 'mr-2';
				if (is_rtl()) {
					$margin10 = 'pix-ml-10';
					$margin2 = 'ml-2';
				}
				if(isset($value['icon'])) {
					$icon = $value['icon'];
					if (isset($value['media_type'])&&$value['media_type'] === "duo_icon") {
						$icon = $value['pix_duo_icon'];
					}
					if(!empty($icon)){
						$output .= '<div class="d-inline-flex align-items-center ' . $margin10 . ' ' . $i_color . '" style="font-size:1.2em;position:relative;line-height:1em;text-align:center;">';
						$output .= \PixfortCore::instance()->icons->getIcon($icon);
						$output .= '</div>';
					}						
				}						
				
				
				if (!empty($text)) $output .= '<span class="' . $c_color . '">' . do_shortcode($text) . '</span>';
				if (!empty($link) && !empty($link['url'])) {
					$output .= '</a>';
				}
				$output .= '</div>';
			}
		}
		$output .= '</div>';
		$output .= '</div>';


		return $output;
	}
}

