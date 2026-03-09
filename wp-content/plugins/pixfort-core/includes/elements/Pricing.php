<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Pricing
* --------------------------------------------------------------------------- */
class PixPricing {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'image'						=> '',
			'title'						=> '',
			'currency' 					=> '',
			'price' 					=> '',
			'period' 					=> '',
			'subtitle' 					=> '',
			'link_title'				=> '',
			'link' 						=> '',
			'featured' 					=> '',
			'features' 					=> '',
			'table_style' 				=> '',
			'style' 					=> '',
			'hover_effect' 				=> '',
			'add_hover_effect' 			=> '',
			'animation' 				=> '',
			'delay' 					=> '0',
			'pricing_padding' 			=> '',
			'rounded_box' 				=> '',
			'badge_css' 				=> '',
			'btn_title_bold' 			=> 'font-weight-bold',
			'btn_italic' 				=> '',
			'btn_secondary_font'		=> '',
            'btn_color'					=> 'primary',
			'btn_remove_padding'		=> '',
			'btn_text_align'			=> '',
            'btn_style' 				=> '',
            'btn_rounded' 				=> '',
            'btn_effect' 				=> '',
            'btn_icon' 					=> '',
			'btn_icon_position' 		=> '',
            'btn_icon_animation' 		=> '',
            'btn_size' 					=> 'md',
            'btn_text' 					=> '',
            'btn_link' 					=> '',
			'btn_target' 				=> false,
			'btn_popup_id' 				=> '',
			'btn_text_color' 			=> '',
            'btn_text_custom_color' 	=> '',
            'btn_hover_effect' 			=> '',
            'btn_add_hover_effect' 		=> '',
			'btn_animation' 			=> '',
			'btn_shadow_class' 			=> '',
			'btn_full' 					=> '',
			'btn_anim_delay' 			=> '0',
			'btn_class' 				=> '',
			'price_bold'				=> 'font-weight-bold',
			'price_italic'				=> '',
			'price_secondary_font'		=> '',
			'price_color'				=> 'heading-default',
			'price_custom_color'		=> '',
			'price_size'				=> 'h2',
			'subtitle_bold'				=> '',
			'subtitle_italic'			=> '',
			'subtitle_secondary_font'	=> '',
			'subtitle_color'			=> 'body-default',
			'subtitle_custom_color'		=> '',
			'subtitle_size'				=> 'text-sm',
			'box_color'					=> 'transparent',
			'box_custom_color'			=> '',
			'pricing_content_align'		=> '',
			'is_elementor' 				=> false,
			'extra_classes' 			=> '',
			'css' 						=> '',
		), $attr));

        $btn_attrs = array(
            'btn_title_bold'			=> $btn_title_bold,
			'btn_italic' 				=> $btn_italic,
			'btn_secondary_font'		=> $btn_secondary_font,
            'btn_color'					=> $btn_color,
            'btn_remove_padding'		=> $btn_remove_padding,
            'btn_text_align'			=> $btn_text_align,
            'btn_style' 				=> $btn_style,
            'btn_rounded' 				=> $btn_rounded,
            'btn_effect' 				=> $btn_effect,
            'btn_icon' 					=> $btn_icon,
			'btn_icon_position' 		=> $btn_icon_position,
            'btn_icon_animation' 		=> $btn_icon_animation,
            'btn_size' 					=> $btn_size,
            'btn_text' 					=> $btn_text,
            'btn_link' 					=> $btn_link,
            'btn_target' 				=> $btn_target,
            'btn_popup_id' 				=> $btn_popup_id,
			'btn_text_color' 			=> $btn_text_color,
            'btn_text_custom_color' 	=> $btn_text_custom_color,
            'btn_hover_effect' 			=> $btn_hover_effect,
            'btn_add_hover_effect' 		=> $btn_add_hover_effect,
			'btn_animation' 			=> $btn_animation,
			'btn_anim_delay' 			=> $btn_anim_delay,
			'btn_shadow_class' 			=> $btn_shadow_class,
			'btn_full' 					=> $btn_full,
			'btn_class' 				=> $btn_class,
        );

		$output = "";

		$badge_attr = $attr;
		$badge_attr['text'] = $title;
		$badge_attr['css'] = '';
		$badge_attr['style'] = '';
		$badge_attr['hover_effect'] = '';
		$badge_attr['add_hover_effect'] = '';
		$badge_attr['extra_classes'] = '';
		$badge_attr['animation'] = '';		

		$box_style = '';
		$css_class = '';
		if(function_exists('vc_shortcode_custom_css_class')){
		    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
			if(!empty($attr['bg_color'])){
				$pattern_val = 'background-color: '.$attr['bg_color'].' !important;';
				$badge_css = str_replace($pattern_val, '', $badge_css);
			}
		}
		$badge_attr['css'] = $badge_css;

		$price_classes = pix_get_text_format_classes($price_bold, $price_italic, $price_secondary_font, $price_color);
		$price_classes .= ' '.$price_size;

		$subtitle_classes = pix_get_text_format_classes($subtitle_bold, $subtitle_italic, $subtitle_secondary_font, $subtitle_color);
		$price_style = '';
		if($price_color=='custom'){
			$price_style = 'style="color:'.$price_custom_color.' !important;"';
		}
		$subtitle_style = '';
		if($subtitle_color=='custom'){
			$subtitle_style = 'style="color:'.$subtitle_custom_color.';"';
		}
		$anim_class = '';
		$anim_type = '';
		$anim_delay = '';
		if(!empty($animation)){
			$anim_type = 'data-anim-type="'.$animation.'"';
			$anim_delay = 'data-anim-delay="'.$delay.'"';
			$anim_class = 'animate-in';
		}

		$box_classes = array();
		array_push($box_classes, 'bg-'.$box_color);
		if(!empty($box_color)&&$box_color=='custom'){
			if(!empty($box_custom_color)){
				$box_style = 'style="background:'.$box_custom_color.';--pix-bg-color: '.$box_custom_color.';"';
			}

		}

		$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
		array_push($box_classes, $effectsClasses);

		$top_box_classes = '';
		if($is_elementor){
			array_push($box_classes, $rounded_box);
		}else{
			$top_box_classes = 'rounded-lg';
		}

		$box_class_names = join( ' ', $box_classes );

		$pricing_features_align = $pricing_content_align;
		if($pricing_features_align === 'text-center'){
			$pricing_features_align .= ' align-items-center justify-content-center text-left';
			$pricing_content_align .= ' align-items-center';
		} elseif ($pricing_features_align === 'text-right'){
			$pricing_features_align .= ' align-items-end justify-content-end';
			$pricing_content_align .= ' align-items-end';
		}
        if($table_style=='top-box') {
			$output .= '<div class="card w-100 pix_pricing '.$extra_classes.' '.$pricing_padding.' '.$pricing_content_align.' '.$anim_class.' '.$css_class.'" '.$anim_type.' '.$anim_delay.'>';
		}else{
			$output .= '<div class="card w-100 pix_pricing '.$extra_classes.' '.$pricing_padding.' '.$pricing_content_align.' '.$anim_class.' '.$box_class_names.' '.$css_class.'" '.$box_style.'  '.$anim_type.' '.$anim_delay.'>';
		}

			if($table_style=='top-box'){
				$output .= '<div class=" '.$box_class_names.' '.$top_box_classes.' pix-p-20 rounded-lg2 pix-mb-20  bg-'.$box_color.'" '.$box_style.'>';
					if(!empty($title)) $output .= \PixfortCore::instance()->elementsManager->renderElement('Badge', $badge_attr );
	            	$output .= '<'.$price_size.' class="pt-3 '.$price_classes.'" '.$price_style.'>';
	                $output .= '<span class="currency">'. do_shortcode($currency) .'</span>';
	                $output .= '<span>'. do_shortcode($price) .'</span>';
	                $output .= '<sub class="text-small">'. do_shortcode($period) .'</sub>';
	                $output .= '</'.$price_size.'>';
	            	if(!empty($subtitle)){ $output .= '<p class="m-0 '.$subtitle_size.' '.$subtitle_classes.'" '.$subtitle_style.'>'. do_shortcode($subtitle).'</p>'; }
			}else{
				if(!empty($title)) $output .= \PixfortCore::instance()->elementsManager->renderElement('Badge', $badge_attr );
            	$output .= '<'.$price_size.' class="pt-3 '.$price_classes.'" '.$price_style.'>';
                $output .= '<span class="currency">'. do_shortcode($currency) .'</span>';
                $output .= '<span>'. do_shortcode($price) .'</span>';
                $output .= '<sub class="text-small">'. do_shortcode($period) .'</sub>';
                $output .= '</'.$price_size.'>';
            	if(!empty($subtitle)){ $output .= '<p class="m-0 '.$subtitle_size.' '.$subtitle_classes.'" '.$subtitle_style.'>'. do_shortcode($subtitle).'</p>'; }
			}

			if($table_style=='top-box'){
				$output .= '</div>';
			}

			if(!empty($features)){
				if($table_style=='top-box'){
					$output .= '<div class="pix-px-20">';
				}else{
					$output .= '<div class="pix-pb-102 pt-4 w-100">';
				}
					$f_attr = $attr;
					$f_attr['css'] = '';
					$f_attr['features_content_align'] = $pricing_features_align;
					$f_attr['animation'] = $pricing_features_align;

					$output .= \PixfortCore::instance()->elementsManager->renderElement('FeatureList', $f_attr );
					
            	$output .= '</div>';
			}

			if(!empty($btn_text)){
            	$output .= '<div class="pix-mt-20">';
					$btn_attrs['btn_extra_classes'] = ' mr-0 ';
                    $output .= \PixfortCore::instance()->elementsManager->renderElement('Button', $btn_attrs );
            	$output .= '</div>';
			}
        $output .= '</div>';
        $output .= "\n";

	    return $output;
	}
}

