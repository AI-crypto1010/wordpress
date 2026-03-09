<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Slider
* --------------------------------------------------------------------------- */
class PixSlider {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'items'  					=> '',
			'rounded_img'  				=> 'rounded-0',
			'align'  					=> 'text-left',
			'nav_style'  				=> 'default',
			'nav_align'  				=> 'center',
			'circles_color'  			=> 'gradient-primary',
			'bold'						=> 'font-weight-bold',
			'italic'					=> '',
			'secondary_font'			=> '',
			'title_color'				=> 'heading-default',
			'title_custom_color'		=> '',
			'title_size'				=> 'h2',
			'title_custom_size'			=> '',
			'content_color'				=> 'body-default',
			'content_custom_color'		=> '',
			'content_size'				=> 'text-24',
			'overlay_color'				=> 'black',
			'overlay_custom_color'		=> '',
			'overlay_opacity'			=> 'pix-opacity-7',
			'slider_num'  				=> '1',
			'dots_style' 				=> '',
			'slider_style' 				=> 'pix-style-standard',
			'autoplay' 					=> false,
			'autoplay_time' 			=> '2500',
			'freescroll' 				=> false,
			'prevnextbuttons' 			=> false,
			'adaptiveheight' 			=> false,
			'animation' 				=> '',
			'delay' 					=> '0',
			'style' 					=> '',
			'hover_effect' 				=> '',
			'add_hover_effect' 			=> '',
			'pix_infinite_animation' 	=> '',
			'pix_infinite_speed' 		=> '',
			'top_placholder' 			=> '',
			'custom_min_height' 			=> '',
			'css' 						=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		wp_enqueue_style('pixfort-carousel-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/carousel-2.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		

		$elementor = false;
		$slides_arr = [];
		if (is_array($items)) {
			$slides_arr = $items;
			$elementor = true;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$slides_arr = vc_param_group_parse_atts($items);
			}
		}

		$slider_header_placeholder = '';
		if (!empty($top_placholder)) {
			$slider_header_placeholder = '<div class="pix-main-intro-placeholder"></div>';
		}

		$output = '';
		$classes = [];
		$anim_type = '';
		$anim_delay = '';

		array_push($classes, esc_attr($css_class));

		$effect_class_names = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);

		$t_classes = array();
		// $t_custom_color = '';
		if (!empty($title_color)) {
			if ($title_color != 'custom') {
				array_push($t_classes, 'text-' . $title_color);
			}
		}

		if (!empty($bold)) array_push($t_classes, $bold);
		if (!empty($italic)) array_push($t_classes, $italic);
		if (!empty($secondary_font)) array_push($t_classes, $secondary_font);
		array_push($t_classes, 'mb-0');

		$t_class_names = join(' ', $t_classes);


		$c_color = '';
		$c_custom_color = '';
		if (!empty($content_color)) {
			if ($content_color != 'custom') {
				$c_color = 'text-' . $content_color;
			} else {
				$c_custom_color = 'color:' . $content_custom_color . ';';
			}
		}

		$inline_style = '';
		$anim_type = '';
		$anim_delay = '';
		if (!empty($animation)) {
			$anim_type = 'data-anim-type="' . $animation . '"';
			$anim_delay = 'data-anim-delay="' . $delay . '"';
			array_push($classes, 'animate-in');
		}

		$inline_style = 'style="' . $inline_style . '"';
		$class_names = join(' ', $classes);
		

		$el_style = '';
		if ($overlay_color == 'custom') {
			$el_style = 'style="--pix-bg-color:' . $overlay_custom_color . ';"';
		}

		$nav_class = 'bg-black';
		$out_class = $rounded_img;
		$top_class = '';
		if ($nav_style == 'circles') {
			$nav_class = 'pix-style-2';
			$top_class = $rounded_img . ' overflow-hidden ' . $effect_class_names;
			if ($circles_color == 'transparent') {
				$circles_color .= ' p-0';
			}
		} else {
			$nav_class = 'bg-' . $overlay_color;
			$out_class = $effect_class_names . ' ' . $rounded_img . ' overflow-hidden';
		}

		$navigation = '';

		$columns_align_size = 'col-md-8 offset-md-2';
		if ($align == 'text-left') {
			$columns_align_size = 'col-md-8';
		} elseif ($align == 'text-right') {
			$columns_align_size = 'col-md-8 offset-md-4';
		}
		if (!empty($slides_arr)) {

			if (!filter_var($autoplay, FILTER_VALIDATE_BOOLEAN)) {
				$autoplay_time = false;
			} else {
				$autoplay_time = (int)$autoplay_time;
			}
			$slider_data = '';
			$pix_id = 'pix-slider-' . substr(md5(json_encode($slides_arr)), 0, 8);
			$slider_opts = array(
				"autoPlay"			=> $autoplay_time,
				"wrapAround"			=> true,
				// "freeScroll"		=> filter_var($freescroll, FILTER_VALIDATE_BOOLEAN),
				// "prevNextButtons"	=> filter_var($prevnextbuttons, FILTER_VALIDATE_BOOLEAN),
				// "prevNextButtons"	=> false,
				// "wrapAround"		=> filter_var($slider_wrap, FILTER_VALIDATE_BOOLEAN),
				// "pageDots"			=> false,
				// "adaptiveHeight"	=> filter_var($adaptiveheight, FILTER_VALIDATE_BOOLEAN),
				// "rightToLeft"		=> filter_var($righttoleft, FILTER_VALIDATE_BOOLEAN),
				// "cellAlign" 		=> $cellalign,
				// "contain"			=> true,
				// "imagesLoaded"			=> true,
				// "pix_id"			=>  '#'.$pix_id,
			);
			$slider_data = json_encode($slider_opts);
			$slider_data = 'data-flickity=\'' . $slider_data . '\'';

		$rowClasses = 'pix-py-200';
		if (!empty($custom_min_height)) {
			$rowClasses = 'd-flex align-items-center';
			if (!$elementor) {
				$style = '#' . $pix_id . ' .slider-content-row { min-height: ' . $custom_min_height . ' !important; }';
				$handle = 'el-' . $pix_id;
				wp_register_style($handle, false);
				wp_enqueue_style($handle);
				wp_add_inline_style($handle, $style);
			}
		}

		$itemsOutputArray = [];
		$itemsOutputArrayNav = [];
		$oldOutput = '';
		$oldOutput .= '<div class="pix-slider-div ' . $class_names . ' ' . $out_class . '" ' . $anim_type . ' ' . $anim_delay . ' >';
		$oldOutput .= '<div id="' . $pix_id . '" class="pix-slider ' . $top_class . ' bg-' . $overlay_color . ' pix-slider-full no-dots" ' . $el_style . ' ' . $slider_data . '>';

		$c_delay = 400;
		foreach ($slides_arr as $key => $value) {

			$itemOutput = '';
				if (!empty($value['image'])) {

					$imgSrcset = '';
					$img_sm = '';
					$imgSrc = '';
					if (is_string($value['image']) && substr($value['image'], 0, 4) === "http") {
						$imgSrc = $value['image'];
						$img_sm = $value['image'];
					} else {
						if (is_array($value['image']) && !empty($value['image']['id'])) {
							if ( is_int( $value['image']['id'] ) ) {
								$value['image']['id'] = apply_filters( 'wpml_object_id', $value['image']['id'], 'attachment', true );
							}
							$img = wp_get_attachment_image_src($value['image']['id'], "full");
							$imgSrcset = wp_get_attachment_image_srcset($value['image']['id']);
							$img_sm = wp_get_attachment_image_src($value['image']['id'], "full");
						} else {
							if ( is_int( $value['image'] ) ) {
								$value['image'] = apply_filters( 'wpml_object_id', $value['image'], 'attachment', true );
							}
							$img = wp_get_attachment_image_src($value['image'], "full");
							$imgSrcset = wp_get_attachment_image_srcset($value['image']);
							$img_sm = wp_get_attachment_image_src($value['image'], "full");
						}
						if (is_array($img) && !empty($img[0])) {
							$imgSrc = $img[0];
						}
						if (is_array($img_sm) && !empty($img_sm[0])) {
							$img_sm = $img_sm[0];
						}
					}

					
					$itemOutput .= '<div class="pix-intro-1 d-inline-block w-100" >
						                <div class="pix-intro-img w-100" data-speed="0.4" ><img class="' . $overlay_opacity . ' pix-fit-cover w-100" src="' . $imgSrc . '" data-srcset="' . $imgSrcset . '" alt="" /></div>
						                <div class="container">
						                    <div class="slider-content-row  row-eq-height align-items-center ' . $rowClasses . '" >
													
						                        <div class="col-12 ' . $columns_align_size . ' pix-py-50 pix-px-40 d-md-flex">
														
						                            <div class="w-100 ' . $align . '">';
					$itemOutput .= $slider_header_placeholder;
					if (!empty($value['link']) && empty($value['btn_text'])) {
						$target = '';
						if (!empty($value['target'])) $target = 'target="_blank"';
						$itemOutput .= '<a href="' . $value['link'] . '" ' . $target . '>';
					}
					if (!empty($value['title'])) {
						$itemOutput .= \PixfortCore::instance()->elementsManager->renderElement('SlidingText', [
							'position'  => 'inherit',
							'size'  => $title_size,
							'secondary_font'  => 'secondary-font',
							'el_class'  => $t_class_names,
							'el_id'  => 'pix-intro-sliding-text',
							'text_color'  => $title_color,
							'text_custom_color'  => $title_custom_color,
							'custom_font_size'  => $title_custom_size,
							'delay'  => "400",
							'remove_mb'  => true
						],  do_shortcode($value['title']));
					}
					if (!empty($value['text'])) {
						$itemOutput .= '<p class="' . $content_size . ' pix-mt-10 ' . $c_color . ' ' . $content_size . ' animate-in" data-anim-type="fade-in" data-anim-delay="700" style="' . $c_custom_color . '">';
						$itemOutput .= do_shortcode($value['text']);
						$itemOutput .= '</p>';
					}
					if (!empty($value['btn_text'])) {
						$attr['btn_text'] = $value['btn_text'];
						if (!empty($value['link'])) $attr['btn_link'] = $value['link'];
						if (!empty($value['btn_popup_id'])) {
							$attr['btn_popup_id'] = $value['btn_popup_id'];
						} else {
							$attr['btn_popup_id'] = false;
						}
						$attr['css'] = '';
						if (!empty($value['target'])) $attr['btn_target'] = $value['target'];
						$itemOutput .= '<div class="pix-pt-10">' . \PixfortCore::instance()->elementsManager->renderElement('Button', $attr) . '</div>';
					}
					if (!empty($value['link']) && empty($value['btn_text'])) {
						$itemOutput .= '</a>';
					}
					$itemOutput .= '</div>
						                        </div>
						                    </div>
						                </div>
						            </div>';

				$oldOutput .= '<div class="carousel-cell p-0">';
				$oldOutput .= $itemOutput;
				$oldOutput .= '</div>';

				$itemsOutputArray[] = $itemOutput;
					




					if ($nav_style !== 'disable') {
						$itemOutputNav = '';
						if ($nav_style == 'circles') {
							$navigation .= '<div class="carousel-cell">';
							$navigation .= '<div class="dot-img-container bg-' . $circles_color . ' shadow-lg shadow-hover-lg fly-sm  animate-in"  data-anim-type="fade-in-right" data-anim-delay="' . $c_delay . '">
									<div class="dot-img-container-inner">
									<img class="img-fluid" src="' . $img_sm . '" alt="" />
									</div>
									</div>';
									// $navigation .= $itemOutputNav;
								$navigation .= '</div>';
							$c_delay += 100;

							$itemOutputNav .= '<div class="pixfort-slider-circle-thumb bg-' . $circles_color . ' shadow-lg shadow-hover-lg fly-sm animate-in" data-anim-type="fade-in-up" data-anim-delay="' . $c_delay . '">
									<div class="circle-thumb-inner"><img class="img-fluid" src="' . $img_sm . '" alt="" /></div>
									</div>';
							$itemsOutputArrayNav[] = $itemOutputNav;
						} else {
							$navigation .= '<div class="carousel-cell">';
							$navigation .= '<div class="dot-img-container">
									<div class="dot-img-container-inner">';
							$itemOutputNav .= '<img class="img-fluid" src="' . $img_sm . '" alt="" />';
							$navigation .= '</div>
									</div>';
							$navigation .= $itemOutputNav;
							$navigation .= '</div>';
							$itemsOutputArrayNav[] = $itemOutputNav;
						}
					}
				}
			}
			$oldOutput .= '</div>';
			if ($nav_style !== 'disable') {
				if ($nav_style == 'circles') {
					$oldOutput .= '<div class="container"><div class="row"><div class="col-12 px-0">';
				}
				$oldOutput .= '<div class="pix-slider-nav-full ' . $nav_class . ' animate-in" data-anim-type="fade-in" data-anim-delay="200" data-nav-align="' . $nav_align . '" data-slider="#' . $pix_id . '" ' . $el_style . '>';
				$oldOutput .= $navigation;
				$oldOutput .= '</div>';
				if ($nav_style == 'circles') {
					$oldOutput .= '</div>';
					$oldOutput .= '</div>';
					$oldOutput .= '</div>';
				}
			}

		$oldOutput .= '</div>';
	}

	if (defined('PIXFORT_SLIDER_OLD')) {
		wp_enqueue_script('pix-flickity-js');
		$output .= $oldOutput;
	}
	if (defined('PIXFORT_SLIDER_SWIPER')) {
		require_once PIX_CORE_PLUGIN_DIR . '/includes/elements/extras/slider.php';
		$attr['slider_num'] = 1;
		$attr['items'] = $itemsOutputArray;
		$attr['pagedots'] = false;
		$attr['has_thumbnails'] = true;
		$attr['speed'] = 300;
		$attr['adaptiveheight'] = true;

		$navAttr['slider_num'] = 3;
		$navAttr['is_thumbnails'] = true;
		$navAttr['cellalign'] = 'left';
		$navAttr['items'] = $itemsOutputArrayNav;
		$navAttr['pagedots'] = false;
		$navAttr['speed'] = 300;

		$navClass = '';
		$mainClasses = '';
		if ($nav_style !== 'disable') {
			if ($nav_style == 'circles') {
				$navClass = 'thumbs-circles';
				$navAttr['slider_num'] = 'auto';
				$navAttr['slider_num_mobile'] = 'auto';
				$navAttr['centerInsufficientSlides'] = true;
				$navAttr['spaceBetween'] = 10;
				$navAttr['extra_classes'] = 'pixfort-swiper-thumbs';
				$attr['extra_classes'] = ' bg-' . $overlay_color . ' ' . $rounded_img . ' overflow-hidden ' . $effect_class_names;
			} else {
				$navClass = 'thumbs-basic';
				$mainClasses = $effect_class_names;
			}
		}
		$mainClasses .= ' bg-' . $overlay_color . ' overflow-hidden ' . $rounded_img . ' ';

		if (!empty($animation)) {
			$mainClasses .= ' animate-in';
		}

		$output .= '<div class="pixfort-slider-element '.$mainClasses.' '.$navClass.'" ' . $el_style . ' ' . $anim_type . ' ' . $anim_delay . '>';
		$output .= pixfort_slider($attr, $content);
		$output .= pixfort_slider($navAttr, $content);
		$output .= '</div>';
	}




	return $output;
}
}
