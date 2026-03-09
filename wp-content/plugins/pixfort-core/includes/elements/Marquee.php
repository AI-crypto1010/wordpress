<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Marquee
* --------------------------------------------------------------------------- */
class PixMarquee {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'items'  => '',
			'content_color'		=> '',
			'content_custom_color'		=> '',
			'content_size'		=> 'h1',
			'display'		=> '',
			'content_custom_size'		=> '',
			'reversed'		=> false,
			'pause_on_hover'		=> false,
			'pix_gray_effect'		=> false,
			'pix_colored_hover'		=> false,
			'speed'		=> '',
			'items_padding'		=> false,
			'element_id'		=> '',
			'css' 		=> '',
			// New motion library options
			'scroll_direction_change'		=> false,
			// 'load_animation'		=> false,
			'vertical_direction'		=> false,
			'vertical_height'		=> '',
			'smooth_velocity'		=> false,
			'base_velocity'		=> '100',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		wp_enqueue_style('pixfort-marquee-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/marquee.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');

		$c_color = '';
		$c_custom_color = '';
		if (!empty($content_color)) {
			if ($content_color != 'custom') {
				$c_color = 'text-' . $content_color;
			} else {
				$c_color = 'el-content_custom_color';
				$c_custom_color = 'color:' . $content_custom_color . ';';
			}
		}
		if (empty($element_id)) {
			$element_id = 'marquee-' . rand(1, 200000000);
		} else {
			if (is_numeric($element_id[0])) {
				$element_id = 'el' . $element_id;
			}
		}

		$content_tag = $content_size;
		$c_size_style = '';
		$c_height_style = '';
		if ($content_size == 'custom') {
			$content_tag = "div";
		}
		if (!empty($content_custom_size)) {
			$c_size_style = "font-size:" . $content_custom_size . ';';
			$c_height_style = "height:" . $content_custom_size . ';';
			$c_color .= ' pix-custom-text-size';
		}


		$texts = false;
		if (is_array($items)) {
			$texts = $items;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$texts = vc_param_group_parse_atts($items);
			}
		}
		$innerClasses = '';
		if (!empty($reversed)) {
			$innerClasses .= ' pix-reversed';
		}
		$mainClasses = '';
		if (!empty($pause_on_hover)) {
			$mainClasses .= ' pix-pause-hover';
		}
		if (!empty($pix_gray_effect)) {
			$mainClasses .= ' pix-gray-effect';
			if (!empty($pix_colored_hover)) {
				$mainClasses .= ' pix-colored-hover';
			}
		}
		if (!empty($vertical_direction)) {
			$mainClasses .= ' pix-vertical';
		}
		$customStyle = '';
		if (!empty($vertical_direction) && !empty($vertical_height)) {
			$customStyle .= '#' . $element_id . ' .pix-marquee { height: ' . $vertical_height . '; }';
		}
		if (!empty($speed)) {
			$customStyle .= '#' . $element_id . ' .pix-marquee { --marquee-speed: ' . $speed . 's;}';
			$customStyle .= '#' . $element_id . ' .marquee__inner:not(.pix-js-loaded) { animation-duration: ' . $speed . 's;}';
		}
		if (!empty($items_padding) && $items_padding !== '') {
			// $customStyle .= '#' . $element_id . ' .pix-marquee-item { padding: 0 ' . $items_padding . ';}';
			$customStyle .= '#' . $element_id . ' .pix-marquee { --marquee-item-padding: ' . $items_padding . ';}';
		}
		if (!empty($customStyle)) {
			\PixfortCore::instance()->elementsManager::pixAddInlineStyle( $customStyle );
		}

		$output = '';
		$itemsInlineStyle = '';
		if ($texts) {
			// Prepare data attributes for motion library
			$dataAttributes = '';
			if (!empty($scroll_direction_change)) {
				$dataAttributes .= ' data-scroll-direction-change="true"';
			}
			// if (!empty($load_animation)) {
			// 	$dataAttributes .= ' data-load-animation="true"';
			// }
			if (!empty($vertical_direction)) {
				$dataAttributes .= ' data-vertical="true"';
			}
			if (!empty($smooth_velocity)) {
				$dataAttributes .= ' data-smooth-velocity="true"';
			}
			if (!empty($base_velocity)) {
				$dataAttributes .= ' data-base-velocity="' . esc_attr($base_velocity) . '"';
			}
			// Legacy WPBakery speed support (Elementor now uses CSS variables)
			if (!empty($speed)) {
				$dataAttributes .= ' data-speed="' . esc_attr($speed) . '"';
			}
			
			$output = '<div id="' . $element_id . '" class="pix-marquee-element d-flex ' . esc_attr($css_class) . '" >';
			$output .= '<div class="pix-marquee ' . $mainClasses . ' "' . $dataAttributes . '><div class="marquee__inner ' . $innerClasses . '" aria-hidden="true">';
			foreach ($texts as $key => $value) {
				
				extract(shortcode_atts(array(
					'item_type'		=> '',
					'text'		=> '',
					'text_image'		=> '',
					'bold'		=> '',
					'italic'		=> '',
					'heading_font'		=> '',
					'icon'		=> '',
					'pix_duo_icon'		=> '',
					'image'		=> '',
					'image_dark'		=> '',
					'image_size'		=> '',
					'rounded_img'		=> '',
					'style'		=> '',
					'hover_effect'		=> '',
					'add_hover_effect'		=> '',
					'link'			=> '',
					'target'		=> '',
					'pix_template_id'	=> '',
				), $value));

				$repeaterClass = '';
				if (!empty($value['_id'])) {
					$repeaterClass = ' elementor-repeater-item-' . $value['_id'];
				}

				if (!empty($link) && is_array($link)) {
					if (!empty($link['is_external'])) {
						$target = $link['is_external'];
					}
					$link = $link['url'];
				}
				if (!empty($target)) {
					$target = 'target="_blank"';
				} else {
					$target = '';
				}
				if (!empty($link)) {
					$output .= '<a href="' . $link . '" ' . $target . '>';
				}
					if (!empty($item_type) && $item_type === "duo_icon") {
						$icon = $pix_duo_icon;
					}
					if (!empty($icon)) {
						$output .= '<' . $content_tag . ' class="pix-marquee-item d-flex justify-content-center ' . $c_color . ' '. $display .'" style="' . $c_custom_color . $c_size_style . $c_height_style . '">';
						$output .= \PixfortCore::instance()->icons->getIcon($icon);
						$output .= '</' . $content_tag . '>';
					}
			

				if ($item_type == "image") {
					if (!empty($image)) {

						
						$classes = [];
					
						$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
        				array_push($classes, $effectsClasses);

						// $imgSrc = '';
						// $imgWidth = '';
						// $imgHeight = '';
						// $size_style = '';
						// $size = 'full';
						if (!empty($image_size)) {
							$image_size = (int) filter_var($image_size, FILTER_SANITIZE_NUMBER_INT);
							array_push($classes, 'd-inline-block position-relative');
							$customItemStyle = '';
							if (!empty($rounded_img) && $rounded_img === 'rounded-circle') {
								// $size_style = 'width:' . $image_size . 'px;height:' . $image_size . 'px;';
								$customItemStyle = '.'.$element_id.'-'.$key.' img { width:' . $image_size . 'px;height:' . $image_size . 'px; }';
							} else {
								// $size_style = 'width:' . $image_size . 'px;height:auto;';
								$customItemStyle = '.'.$element_id.'-'.$key.' img { width:' . $image_size . 'px;height:auto; }';
							}
							\PixfortCore::instance()->elementsManager::pixAddInlineStyle( $customItemStyle );
							$itemsInlineStyle .= $customItemStyle;
						}
						// if (!empty($rounded_img) && $rounded_img === 'rounded-circle') {
						// 	// $size = "thumbnail";
						// 	// if (!empty($image_size)) {
						// 	// 	$size = array($image_size, $image_size);
						// 	// }
						// }
						// if (is_string($image) && substr($image, 0, 4) === "http") {
						// 	$img = $image;
						// 	$imgSrc = $img;
						// } else {
						// 	if (!empty($image['id'])) {
						// 		$img = wp_get_attachment_image_src($image['id'], $size);
						// 	} else {
						// 		$img = wp_get_attachment_image_src($image, $size);
						// 	}
						// 	if (!empty($img[0])) $imgSrc = $img[0];
						// 	if (!empty($img[1]) && !empty($img[2])) {
						// 		$imgWidth = 'width="' . $img[1] . '"';
						// 		$imgHeight = 'height="' . $img[2] . '"';
						// 	}
						// }
						array_push($classes, $rounded_img);
						$class_names = join(' ', $classes);
						$output .= '<' . $content_tag . ' class="pix-marquee-item ' . $element_id.'-'.$key . ' '. $repeaterClass . ' '.  $c_color . '">';
						// $output .= '<img class="pix-fit-cover ' . $class_names . '" src="' . $imgSrc . '" ' . $imgWidth . ' ' . $imgHeight . ' style="' . $size_style . '" alt="">';
						$imageOutput = \PixfortCore::instance()->coreFunctions->getDynamicImage($image, 'full', [
							'class' => 'pix-fit-cover ' . $class_names,
							// 'style' => $size_style
						], $image_dark);
						if (!empty($imageOutput)) {
							$output .= $imageOutput;
						}
						$output .= '</' . $content_tag . '>';
					}
				} elseif ($item_type === 'text') {
					$classes = array();
					$imgSrc = '';
					$text_image_style = '';
					if (!empty($text_image)) {
						if (is_string($text_image) && substr($text_image, 0, 4) === "http") {
							$img = $text_image;
							$imgSrc = $img;
							array_push($classes, 'text-gradient-primary');
						} else {
							if (is_array($text_image)) {
								if (!empty($text_image['id'])) {
									$img = wp_get_attachment_image_src($text_image['id'], "full");
									array_push($classes, 'text-gradient-primary');
									if (!empty($img[0])) $imgSrc = $img[0];
								}
							} else {
								$img = wp_get_attachment_image_src($text_image, "full");
								array_push($classes, 'text-gradient-primary');
								if (!empty($img[0])) $imgSrc = $img[0];
							}
						}
						if (!empty($imgSrc)) {
							$text_image_style = 'background-image:url(\'' . $imgSrc . '\') !important;';
							array_push($classes, 'pix-text-image');
						}
					}
					if (!empty($bold)) array_push($classes, $bold);
					if (!empty($italic)) array_push($classes, $italic);
					if (!empty($display)) array_push($classes, $display);
					if (!empty($heading_font)) {
						array_push($classes, $heading_font);
					} else {
						// array_push($classes, 'body-font');
					}
					$class_names = join(' ', $classes);
					$output .= '<' . $content_tag . ' class="pix-marquee-item ' . $c_color . ' ' . $class_names . '" style="' . $text_image_style . $c_custom_color . $c_size_style . '">' . do_shortcode($text)  . '</' . $content_tag . '>';
				} elseif ($item_type === 'template' && defined('PIX_DEV')) {
					// Template item type - render Elementor template
					if (!empty($pix_template_id) && class_exists('\Elementor\Plugin')) {
						$template_id = apply_filters('wpml_object_id', $pix_template_id, 'page', true);
						$template_content = \Elementor\plugin::instance()->frontend->get_builder_content_for_display($template_id);
						if (!empty($template_content)) {
							$output .= '<div class="pix-marquee-item pix-marquee-template-item ' . $repeaterClass . '">';
							$output .= $template_content;
							$output .= '</div>';
						}
					}
				}
				if (!empty($link)) {
					$output .= '</a>';
				}
			}
			if (is_user_logged_in() || (defined('DOING_AJAX') && constant('DOING_AJAX'))) {
				$output .= '<style>' . $itemsInlineStyle . '</style>';
			}
			$output .= '</div></div>';
			$output .= '</div>';
		}
		return $output;
	}
}
