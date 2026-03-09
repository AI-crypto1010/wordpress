<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* HighlightedText
* --------------------------------------------------------------------------- */
class PixHighlightedText {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'items' 		=> '',
			'title_color'		=> 'heading-default',
			'title_custom_color'		=> '',
			'title_size'		=> 'h1',
			'display'		=> '',
			'title_custom_size'		=> '',
			'position'  => 'text-center',
			'animation' 	=> '',
			'delay' 	=> '0',
			'heading_id' 	=> '',
			'max_width' 	=> '',
			'disable_resp_img'				=> false,
			'css' 		=> '',
		), $attr));
		$css_class = '';
		$classes = array();
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		$texts = array();
		if (is_array($items)) {
			$texts = $items;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$texts = vc_param_group_parse_atts($items);
			}
		}
		$output = '';
		if ($texts) {

			$t_color = '';
			$t_custom_color = '';
			if (!empty($title_color)) {
				$t_color = 'text-' . $title_color;
				if ($title_color === 'custom') {
					$t_custom_color .= 'color:' . $title_custom_color . ' !important;';
				}
			}

			if (!empty($display)) array_push($classes, $display);

			$title_tag = $title_size;
			$t_size_style = '';
			if ($title_size == 'custom') {
				$title_tag = "div";
				$t_size_style = "font-size:" . $title_custom_size . ';';
			}
			if (!empty($animation)) {
				array_push($classes, 'animate-in');
			}
			$class_names = join(' ', $classes);

			if (empty($heading_id)) {
				$heading_id = 'highlighted-text-' . rand(1, 200000000);
			} else {
				if (is_numeric($heading_id[0])) {
					$heading_id = 'el' . $heading_id;
				}
			}



			$output .= '<div id="' . $heading_id . '" class="pix-highlighted-element ' . $position . ' ' . $css_class . '">';
			if (!empty($max_width)) {
				$custom_style = 'style="max-width:' . $max_width . ';"';
				$output .= '<div class="d-inline-block" ' . $custom_style . '>';
			}
			$output .= '<' . $title_tag . ' class="pix-highlighted-items ' . $class_names . '" style="' . $t_size_style . '" data-anim-type="' . $animation . '" data-anim-delay="' . $delay . '">';
			foreach ($texts as $key => $value) {
				extract(shortcode_atts(array(
					'is_highlighted'		=> '',
					'text'					=> '',
					'bold'					=> '',
					'italic'				=> '',
					'heading_font'			=> 'body-font',
					'has_color'			=> false,
					'item_color'			=> '',
					'item_custom_color'			=> '',
					'item_custom_gradient_color'			=> '',
					// 'highlighted_color_type'		=> 'simple',
					'highlight_color'		=> '',
					// 'highlight_gradient'		=> '',
					'custom_height'			=> '',
					'image'		=> '',
					'image_size'		=> '',
					'image_dark'		=> '',
					'rounded_img'		=> '',
					'style'		=> '',
					'hover_effect'		=> '',
					'add_hover_effect'		=> '',
					'item_animation'		=> '',
					'item_delay'		=> '',
					'new_line'				=> '',
				), $value));

				$classes = 'pix-highlight-item font-weight-normal ';
				if (!empty($bold)) {
					$classes .= ' ' . $bold;
				}
				if (!empty($heading_font)) {
					$classes .= ' ' . $heading_font;
				} else {
					$classes .= ' body-font';
				}
				if (!empty($italic)) {
					$classes .= ' ' . $italic;
				}
				$item_id = $heading_id . '-' . $key;
				$bgClasses = '';
				$repeaterClass = '';
				if (!empty($value['_id'])) {
					// $classes .= ' elementor-repeater-item-' . $value['_id'];
					$repeaterClass = ' elementor-repeater-item-' . $value['_id'];
					$bgClasses .= ' ' . $repeaterClass;
				}
				$anim_type = '';
            	$anim_delay = '';
				if(!empty($item_animation)){
					$anim_type = 'data-anim-type="'.$item_animation.'"';
					$anim_delay = 'data-anim-delay="'.$item_delay.'"';
					$classes .= ' animate-in';
				}
				
				$customStyle = '';
				$item_color_class = $t_color;
				if(!empty($has_color)){
					if(!empty($item_color)){
						if($item_color=='custom-gradient'){
							$item_color_class = 'text-gradient-primary text-custom-gradient';
							$customStyle .= '.' . $item_id . ' .text-custom-gradient, .' . $item_id . '.text-custom-gradient { background-image:' . $item_custom_gradient_color . ' !important; }';
						}elseif ($item_color=='custom'){
							$item_color_class = 'el-title_custom_color';
							$customStyle .= '.' . $item_id . ' { color:' . $item_custom_color . '; }';
						}else{
							$item_color_class = 'text-'.$item_color;
						}
					}
				}

				if (!empty($is_highlighted)) {
					if ($is_highlighted == 'image') {
						if (!empty($image)) {
							$imageClasses = array();

							$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
							array_push($imageClasses, $effectsClasses);

							array_push($imageClasses, $repeaterClass);

							$size = 'full';
							if (!empty($rounded_img) && $rounded_img === 'rounded-circle') {
								$size = "thumbnail";
							}
							if(!empty($image_size)&&is_array($image_size)){
								$image_size = $image_size['size'];
							}
							if (!empty($image_size)) {
								
								$image_size = (int) filter_var($image_size, FILTER_SANITIZE_NUMBER_INT);
								$image_height = 'auto';
								if (!empty($rounded_img) && $rounded_img === 'rounded-circle') {
									$size = array($image_size, $image_size);
									$image_height = $image_size.'px';
								}
								array_push($imageClasses, $item_id);
								$customStyle .= '.' . $item_id . ' img { width:' . $image_size . 'px;height:'.$image_height.';display:inline-block;position:relative; }';
								if(empty($disable_resp_img)||!$disable_resp_img){
									$mobileImgSize = $image_size * 0.6;
									$tabletImgSize = $image_size * 0.8;
									$customStyle .= '@media (min-width:576px) and (max-width:920px) { .' . $item_id . ' img { width:' . $tabletImgSize . 'px;height: auto; }}';
									$customStyle .= '@media only screen and (max-width:576px) { .' . $item_id . ' img { width:' . $mobileImgSize . 'px;height: auto; }}';
								}
								\PixfortCore::instance()->elementsManager::pixAddInlineStyle( $customStyle );
							}
							
							if(!empty($item_animation)){
								array_push($imageClasses, 'animate-in');
							}
							array_push($imageClasses, $rounded_img);
							$image_class_names = join(' ', $imageClasses);

							$output .= '<span class="d-inline-flex mx-2 ' . $image_class_names . '" '.$anim_type.' '.$anim_delay.' style="vertical-align: middle;line-height:1;">';
							$output .= \PixfortCore::instance()->coreFunctions->getDynamicImage($image, $size, [
								'alt' => '',
								'class' => 'pix-fit-cover ' . $rounded_img . ' ' . $class_names
							], $image_dark);
							$output .= '</span>';
						}
					} else {

						
						// $css_color = '';
						
						// if (!empty($highlighted_color_type)&&$highlighted_color_type=='gradient') {
						// 	if (!empty($highlight_gradient)) {
						// 		$customStyle .= '.' . $item_id . ' { background-image: ' . $highlight_gradient.' !important; }';
						// 	}
						// }else{
							if (!empty($highlight_color)) {
								if (!empty($value['__globals__'])) {
									if (!empty($value['__globals__']['highlight_color'])) {
										$highlight_color = str_replace('globals/colors?id=', "", $value['__globals__']['highlight_color']);
										$highlight_color = 'var(--e-global-color-' . $highlight_color . ')';
									}
								}
								if ($highlight_color != '#ffd900') {
									 $customStyle .= '.' . $item_id . '.pix-highlight-bg { background-image: linear-gradient(' . $highlight_color . ', ' . $highlight_color . ') !important; }';
									
								}
							}	
						// }
						
						if (!empty($custom_height)) {
							$customStyle .= '.' . $item_id . '.pix-highlight-bg { background-size: 0% ' . $custom_height . '%; }';
							$customStyle .= '.' . $item_id . '.animated.pix-highlight-bg, .' . $item_id . '.highlight-grow.pix-highlight-bg { background-size: 100% ' . $custom_height . '% !important; }';
						}
						if (!empty($customStyle)) {
							$bgClasses .= ' ' . $item_id;
							\PixfortCore::instance()->elementsManager::pixAddInlineStyle( $customStyle );
						}
						if (empty($anim_type)||preg_match('/\[(\w+)[^\]]*\]/', $text)) {
							$output .= '<span id="'.$item_id.'" class="pix-highlight-bg '.$bgClasses.' animate-in" data-anim-type="highlight-grow" data-anim-delay="200"><span '.$anim_type.' '. $anim_delay .' class="pix-highlighted-text ' . $classes . ' '.$item_color_class.'">' . do_shortcode($text) . '</span></span>';
						} else {
							$itemsString = do_shortcode($text);
							$itemsArray = explode(" ", $itemsString);
							if (!empty($itemsArray)) {
								$output .= '<span id="'.$item_id.'" class="pix-highlight-bg '.$bgClasses.' animate-in" data-anim-type="highlight-grow" data-anim-delay="200">';
								foreach ($itemsArray as $key => $itemValue) {
									if($key < count($itemsArray)-1 && count($itemsArray) > 1){
										$itemValue = $itemValue . '&nbsp;';
									}
									$output .= '<span '.$anim_type.' '. $anim_delay .' class="pix-highlighted-text d-inline-block ' . $classes . ' '.$item_color_class.'">' . do_shortcode($itemValue). '</span>';
								}
								$output .= '</span>';
							}
						}
						
					}
				} else {
					if (!empty($customStyle)) {
						$classes .= ' ' . $item_id;
						// wp_register_style('pix-highlighted-text-handle', false);
						// wp_enqueue_style('pix-highlighted-text-handle');
						// wp_add_inline_style('pix-highlighted-text-handle', $customStyle);
						\PixfortCore::instance()->elementsManager::pixAddInlineStyle( $customStyle );
					}
					if (empty($anim_type)||preg_match('/\[(\w+)[^\]]*\]/', $text)) {
						$output .= '<span id="' . $item_id . '"  class="'.$repeaterClass.'"><span '.$anim_type.' '. $anim_delay .' class="pix-highlighted-text  ' . $classes . ' '.$item_color_class.'">' . do_shortcode($text) . '</span></span>';
					} else {
						$itemsString = do_shortcode($text);
						$itemsArray = explode(" ", $itemsString);
						// $itemsArray = preg_split('/[\s-]+/', $itemsString);

						if (!empty($itemsArray)) {
							$output .= '<span id="' . $item_id . '"  class="'.$repeaterClass.'">';
							foreach ($itemsArray as $key => $itemValue) {
								if($key < count($itemsArray)-1 && count($itemsArray) > 1){
									$itemValue = $itemValue . '&nbsp;';
								}
								$output .= '<span '.$anim_type.' '. $anim_delay .' class="pix-highlighted-text d-inline-block  ' . $classes . ' '.$item_color_class.'">' . $itemValue . '</span>';
							}
							$output .= '</span>';
						}
					}
					
				}
				if (!empty($new_line)) {
					$output .= '<br />';
				}
			}
			$output .= '</' . $title_tag . '>';
			if (!empty($max_width)) {
				$output .= '</div>';
			}
			$output .= '</div>';
		}

		return $output;
	}
}


