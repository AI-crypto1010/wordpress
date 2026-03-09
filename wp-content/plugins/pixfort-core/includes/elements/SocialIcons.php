<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* SocialIcons
* --------------------------------------------------------------------------- */
class PixSocialIcons {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'items'		=> '',
			'item_size'		=> '',
			'item_custom_size'		=> '',
			'items_color' 	=> 'body-default',
			'items_custom_color' 	=> '',
			'items_style' 	=> '',
			'position' 	=> '',
			'item_padding' 	=> 'px-2',
			'item_custom_padding' 	=> '',
			'animation' 	=> '',
			'delay' 	=> '0',
			'css' 		=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		$icons = array();
		if (is_array($items)) {
			$icons = $items;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$icons = vc_param_group_parse_atts($items);
			}
		}
		$output = '';
		$classes = array();

		$i_color = '';
		$i_custom_style = '';
		if (!empty($items_color)) {
			if ($items_color != 'custom') {
				$i_color = 'text-' . $items_color;
				array_push($classes, 'text-' . $items_color);
			} else {
				$i_custom_style .= 'color:' . $items_custom_color . ';';
			}
		}
		$i_size = '';
		$i_custom_size = '';
		if (!empty($item_size)) {
			if ($item_size != 'custom') {
				$i_size = $item_size;
			} else {
				$i_custom_size .= 'font-size:' . $item_custom_size . ';';
			}
		}

		$i_custom_size = 'style="' . $i_custom_size . '"';

		array_push($classes, $position);
		array_push($classes, 'pix-social-icons');
		array_push($classes, 'font-weight-bold');
		array_push($classes, 'd-inline-block w-100');
		array_push($classes, $css_class);

		$icon_padding = '';
		$icon_custom_padding = '';
		if (!empty($item_padding)) {
			if ($item_padding != 'none' && $item_padding != 'custom') {
				$icon_padding = $item_padding;
			} elseif ($item_padding == 'custom') {
				$icon_custom_padding .= 'padding-left:' . $item_custom_padding . ';';
				$icon_custom_padding .= 'padding-right:' . $item_custom_padding . ';';
			}
		}

		$class_names = join(' ', $classes);

		$output .= '<div class="' . $class_names . '" ' . $i_custom_size . '>';

		$anim_class = '';
		$anim_type = '';
		$anim_delay = $delay;
		if (!empty($animation)) {
			$anim_class = 'animate-in';
			$anim_type = 'data-anim-type="' . $animation . '"';
		}

		$has_icons = false;
		if ($icons) {
			foreach ($icons as $key => $value) {
				$w_color = '';
				$w_custom_style = '';
				$areaLabel = '';
				if (!empty($value['aria_label'])) {
					$areaLabel = $value['aria_label'];
				}
				if (!empty($value['has_color'])) {
					if (!empty($value['item_color'])) {
						if ($value['item_color'] != 'custom') {
							$w_color = 'text-' . $value['item_color'];
						} else {
							$w_custom_style .= 'color:' . $value['item_custom_color'] . ';';
						}
					}
				} else {
					$w_color = $i_color;
					$w_custom_style .= $i_custom_style;
				}
				$w_custom_style .= $icon_custom_padding;
				$icon_delay = '';
				if ($anim_delay) {
					$icon_delay = 'data-anim-delay="' . $anim_delay . '"';
					$anim_delay += 100;
				}
				$w_custom_style = 'style="' . $w_custom_style . '"';
				$linkTarget = '';
				if (!empty($value['target'])) {
					$linkTarget = 'target="_blank"';
				}
				if (!empty($value['icon'])) {
					$has_icons = true;
					if (!empty($value['item_link'])) {
						if (empty($areaLabel)) $areaLabel = $value['icon'];
						$output .= '<a ' . $linkTarget . ' href="' . $value['item_link'] . '" aria-label="' . $areaLabel . '" class="' . $w_color . ' ' . $anim_class . ' d-inline-block ' . $items_style . ' ' . $i_size . ' ' . $icon_padding . '" ' . $anim_type . ' ' . $icon_delay . '>';
					} else {
						$output .= '<span class="' . $w_color . ' ' . $anim_class . ' d-inline-block ' . $items_style . ' ' . $i_size . ' ' . $icon_padding . '" ' . $anim_type . ' ' . $icon_delay . '>';
					}
					$output .= \PixfortCore::instance()->icons->getIcon($value["icon"], 24, '', $w_custom_style);
					if (!empty($value['item_link'])) {
						$output .= '</a>';
					} else {
						$output .= '</span>';
					}
				}
			}
		}

		$output .= '</div>';
		if (!$has_icons) {
			return false;
		}
		return $output;
	}
}
