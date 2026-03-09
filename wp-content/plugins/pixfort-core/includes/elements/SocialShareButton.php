<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* SocialShareButton
* --------------------------------------------------------------------------- */
class PixSocialShareButton {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'social_type'			=> 'facebook',
			'text'					=> __('Share on Facebook', 'pixfort-core'),
			'icon'					=> 'Solid/pixfort-icon-facebook-1',
			'text_color' 			=> 'body-default',
			'text_custom_color' 	=> '',
			'icon_color' 			=> '',
			'icon_custom_color' 	=> '',
			'position' 				=> 'center',
			'animation' 			=> '',
			'delay' 				=> '0',
			'bg_color' 				=> '',
			'custom_bg_color' 		=> '',
			'style' 				=> '',
			'hover_effect' 			=> '',
			'add_hover_effect' 		=> '',
			// Icon size
			'icon_size' 			=> '24',
			// Layout parameters
			'justify_content' 		=> 'center',
			'gap' 					=> '',
			'button_padding' 		=> '',
			'css' 					=> '',
			'isElementor' 			=> false,
		), $attr));

		$css_class = '';
		$output = '';

		// Handle color
		$color_class = '';
		$color_style = '';
		
		$icon_color_class = '';
		$icon_color_style = '';
		if (!empty($icon_color)) {
			if ($icon_color != 'custom') {
				$icon_color_class = 'text-' . $icon_color;
			} else {
				$icon_color_style = 'color:' . $icon_custom_color . ';';
			}
		}
		

		$anim_class = '';
		$anim_type = '';
		$anim_delay = $delay;
		if (!empty($animation)) {
			$anim_class = 'animate-in';
			$anim_type = 'data-anim-type="' . $animation . '"';
		}

		$el_classes = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);

		$container_style_attr = '';
		$custom_style_attr = '';
		$alignment_class = '';

		// Icon size
		if (function_exists('vc_shortcode_custom_css_class') && defined('VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG') && !$isElementor) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));

			if (!empty($text_color)) {
				if ($text_color != 'custom') {
					$color_class = 'text-' . $text_color;
				} else {
					$color_style = 'color:' . $text_custom_color . ';';
				}
			}
			
			switch ($justify_content) {
				case 'start':
					$alignment_class = 'justify-content-start';
					break;
				case 'end':
					$alignment_class = 'justify-content-end';
					break;
				case 'between':
					$alignment_class = 'justify-content-between';
					break;
				case 'around':
					$alignment_class = 'justify-content-around';
					break;
				case 'center':
				default:
					$alignment_class = 'justify-content-center';
					break;
			}
			
			$icon_size_style = '';
			if (!empty($icon_size) && $icon_size != '24') {
				$icon_size_style = 'font-size: ' . $icon_size . 'px !important; width: ' . $icon_size . 'px !important; height: ' . $icon_size . 'px !important;';
			}

			// Background color styles
			$bg_style = '';
			if (!empty($bg_color)) {
				if ($bg_color != 'custom') {
					$bg_style = 'background: var(--pix-' . $bg_color . ') !important;';
				} else {
					$bg_style = 'background-color: ' . $custom_bg_color . ' !important;';
				}
			}

			// Layout styles
			$layout_styles = array();
			if (!empty($gap)) {
				$layout_styles[] = 'gap: ' . $gap . 'px';
			}
			if (!empty($button_padding)) {
				$layout_styles[] = 'padding: ' . $button_padding . ' !important';
			}

			// Combine all custom styles
			$all_styles = $layout_styles;
			if (!empty($bg_style)) {
				$all_styles[] = $bg_style;
			}
			
			if (!empty($all_styles)) {
				$custom_style_attr = 'style="' . implode('; ', $all_styles) . '"';
			}

			// Container styles for gap and layout
			$container_styles = array();
			if (!empty($gap)) {
				$container_styles[] = 'gap: ' . $gap . 'px';
			}
			
			if (!empty($container_styles)) {
				$container_style_attr = 'style="' . implode('; ', $container_styles) . '"';
			}
		}

		$output .= '<div class="pix_post_social d-flex flex-wrap ' . $css_class . '"' . ($container_style_attr ? ' ' . $container_style_attr : '') . '>';


			// Set share URL and title based on social type
			$share_url = '';
			$share_title = '';
			$css_social_class = 'pix-social-' . $social_type;
			
			switch ($social_type) {
				case 'facebook':
					$share_url = 'http://www.facebook.com/sharer.php?u=' . get_the_permalink() . '&t=' . get_the_title();
					$share_title = esc_attr__('Click to share this post on Facebook', 'pixfort-core');
					break;
				case 'x':
					$share_url = 'http://twitter.com/intent/tweet?text=' . get_the_title() . ' ' . get_the_permalink();
					$share_title = esc_attr__('Click to share this post on X', 'pixfort-core');
					break;
				case 'linkedin':
					$share_url = 'https://www.linkedin.com/sharing/share-offsite/?url=' . get_the_permalink();
					$share_title = esc_attr__('Click to share this post on LinkedIn', 'pixfort-core');
					break;
				case 'pinterest':
					$share_url = 'https://pinterest.com/pin/create/button/?url=' . get_the_permalink() . '&description=' . get_the_title();
					$share_title = esc_attr__('Click to share this post on Pinterest', 'pixfort-core');
					break;
				case 'whatsapp':
					$share_url = 'https://wa.me/?text=' . get_the_title() . ' ' . get_the_permalink();
					$share_title = esc_attr__('Click to share this post on WhatsApp', 'pixfort-core');
					break;
				case 'email':
					$share_url = 'mailto:?subject=' . get_the_title() . '&body=' . get_the_permalink();
					$share_title = esc_attr__('Share via Email', 'pixfort-core');
					break;
				default:
					$share_url = '#';
					$share_title = '';
					break;
			}

			// Animation delay
			$item_delay = '';
			if ($anim_delay) {
				$item_delay = 'data-anim-delay="' . $anim_delay . '"';
				$anim_delay += 100;
			}
			
			$link_style = $color_style;
			if (!empty($link_style)) {
				$link_style = 'style="' . $link_style . '"';
			}

			$output .= '<a class="btn btn-link ' . $css_social_class . ' d-flex w-100 ' . $alignment_class . ' align-items-center font-weight-bold m-0 p-0 ' . $color_class . ' ' . $anim_class . ' ' . $el_classes . '" href="' . esc_url($share_url) . '" target="_blank" title="' . $share_title . '" ' . $link_style . ' ' . $custom_style_attr . ' ' . $anim_type . ' ' . $item_delay . '>';
			
			$padding = '';
			if (!empty($text)) {
				$padding = 'pix-pr-10';
				if (is_rtl()) {
					$padding = 'pix-pl-10';
				}
			}
			if(!empty($icon)) {
				$icon_style = $icon_color_style;
				if (!empty($icon_size_style)) {
					$icon_style .= ($icon_style ? ' ' : '') . $icon_size_style;
				}
				$output .= \PixfortCore::instance()->icons->getIcon($icon, $icon_size, $padding . ' ' . $icon_color_class, $icon_style);
			}
			
			if (!empty($text)) {
				$output .= $text;
			}
			$output .= '</a>';

		$output .= '</div>';

		return $output;
	}
}

