<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Story
* --------------------------------------------------------------------------- */
class PixStory {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'image'  => '',
			'alt'  => '',
			'align'  => 'text-left',
			'width' 	=> '',
			'title'  => '',
			'text_size'  => '',
			'bold'		=> '',
			'italic'		=> '',
			'secondary_font'		=> '',
			'content_color'		=> '',
			'content_custom_color'		=> '',
			'position'  => 'text-center',
			'color' 	=> "gradient-primary",
			'outer_custom_color' 	=> "",
			'outer_border' 	=> '',
			'inner_border' 	=> '',
			'pix_scroll_parallax' 	=> '',
			'pix_tilt' 	=> '',
			'pix_tilt_size' 	=> 'tilt',
			'xaxis' 	=> '100',
			'yaxis' 	=> '',
			'link' 	=> '',
			'target' 	=> '',
			'animation' 	=> '',
			'delay' 	=> '0',
			'style' 		=> '',
			'hover_effect' 		=> '',
			'add_hover_effect' 		=> '',
			'pix_infinite_animation' 		=> '',
			'pix_infinite_speed' 		=> '',
			'stories' 		=> '',
			'css' 		=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		wp_enqueue_style('pixfort-carousel-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/carousel-2.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		wp_enqueue_style('pixfort-story-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/story.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
		if (defined('PIXFORT_SLIDER_OLD')) {
			wp_enqueue_script('pix-flickity-js');
		}
		
		$images = [];
		if (is_array($stories)) {
			$images = $stories;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$images = vc_param_group_parse_atts($stories);
			}
		}

		$imgs_arr = array();

		$popup_class = '';
		if (!empty($images)) {
			foreach ($images as $key => $value) {
				if (!empty($value['img'])) {
					$popup_class = 'pix-story-popup';
					$img = '';
					if (is_string($value['img']) && substr($value['img'], 0, 4) === "http") {
						$img = $value['img'];
					} else {
						if (is_array($value['img']) && !empty($value['img']['id'])) {
							if ( is_int( $value['img']['id'] ) ) {
								$value['img']['id'] = apply_filters( 'wpml_object_id', $value['img']['id'], 'attachment', true );
							}
							$img = wp_get_attachment_image_src($value['img']['id'], "full");
						} else {
							if ( is_int( $value['img'] ) ) {
								$value['img'] = apply_filters( 'wpml_object_id', $value['img'], 'attachment', true );
							}
							$img = wp_get_attachment_image_src($value['img'], "full");
						}
						if (!empty($img[0])) {
							$img = $img[0];
						}
					}
					array_push($imgs_arr, $img);
					// $link = '#';
				}
			}
		}
		$output = '';
		if (!empty($image)) {

			$classes = array();
			$anim_type = '';
			$anim_delay = '';

			$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
			array_push($classes, $effectsClasses);

			if (empty($outer_border)) {
				array_push($classes, 'pix-no-bg');
			} else {
				if ($color == 'transparent') {
					array_push($classes, 'pix-no-bg');
				} else {
					array_push($classes, 'bg-' . $color);
				}
			}
			if (!empty($align)) {
				array_push($classes, $align);
			}
			$custom_outer_style = '';
			if (!empty($outer_border)) {
				if ($color == 'custom') {
					$custom_outer_style = 'style="background:' . $outer_custom_color . ';"';
				}
			}

			$inline_style = '';
			if (!empty($width)) {
				$inline_style .= 'width:' . $width . 'px;';
				$inline_style .= 'height:' . $width . 'px;';
			} else {
				$inline_style .= 'width:auto;';
				$inline_style .= 'height:auto;';
			}
			array_push($classes, 'd-inline-block');

			$text_classes = pix_get_text_format_classes($bold, $italic, $secondary_font);
			$c_color = '';
			$c_custom_color = '';
			if (!empty($content_color)) {
				if ($content_color != 'custom') {
					$c_color = 'text-' . $content_color;
				} else {
					$c_custom_color = 'style="color:' . $content_custom_color . ';"';
				}
			}


			$class_names = join(' ', $classes);

			$jarallax = '';
			if ($pix_scroll_parallax) {
				if (!empty($xaxis) || !empty($yaxis)) {
					$jarallax = 'data-jarallax-element="' . $xaxis . ' ' . $yaxis . '" data-xaxis="' . $xaxis . '" data-yaxis="' . $yaxis . '"';
				}
			}

			if ($link || !empty($imgs_arr)) {
				$ntab = '';
				if (!empty($target)) {
					$ntab = 'target="_blank"';
				}
				if (!empty($pix_infinite_animation)) {
					$output .= '<div class="' . $pix_infinite_animation . ' ' . $pix_infinite_speed . '">';
				}
				if (!empty($animation)) {
					$anim_type = 'data-anim-type="' . $animation . '"';
					$anim_delay = 'data-anim-delay="' . $delay . '"';
					$output .= '<div class="animate-in d-inline-block" ' . $anim_type . ' ' . $anim_delay . '>';
				}
				if (!empty($pix_tilt)) {
					$output .= '<div class="' . $pix_tilt_size . ' d-inline-block">';
				}
				$output .= '<a href="' . $link . '" ' . $ntab . ' aria-label="Story" class="' . $popup_class . '" data-stories="' . htmlspecialchars(json_encode($imgs_arr)) . '" ' . $jarallax . '>';
				$output .= '<div class="pix-story d-inline-block ' . $css_class . ' ' . $align . '">';
				$output .= '<div class="story-img pix-bg-attachment-scroll pix-bg-custom  ' . $class_names . '" ' . $custom_outer_style . '>';

				$size_num = 'full';
				$size = $size_num;
				$full_image = '';
				if (is_string($image) && substr($image, 0, 4) === "http") {
					$full_image = '<img class="rounded-circle bg-white pix-fit-cover img-fluid hover-effect ' . $inner_border . '" style="' . $inline_style . '" alt="' . $alt . '" src="' . $image . '"  />';
				} else {
					$attrs = array(
						'class'	=> 'rounded-circle bg-white pix-fit-cover img-fluid hover-effect ' . $inner_border,
						'style'	=> $inline_style,
						'alt'	=> $alt
					);
					if (is_array($image) && !empty($image)) {
						if ( is_int( $image['id'] ) ) {
							$image['id'] = apply_filters( 'wpml_object_id', $image['id'], 'attachment', true );
						}
						$full_image = wp_get_attachment_image($image['id'], $size, false, $attrs);
					} else {
						if ( is_int( $image ) ) {
							$image = apply_filters( 'wpml_object_id', $image, 'attachment', true );
						}
						$full_image = wp_get_attachment_image($image, $size, false, $attrs);
					}
				}

				$output .= $full_image;
				$output .= '</div>';
				if (!empty($title)) $output .= '<div class="pix-px-5 ' . $text_size . ' ' . $c_color . ' ' . $position . ' ' . $text_classes . '" ' . $c_custom_color . '>' .  $title  . '</div>';
				$output .= '</div>';

				$output .= '</a>';

				if (!empty($pix_tilt)) {
					$output .= '</div>';
				}
				if (!empty($animation)) {
					$output .= '</div>';
				}
				if (!empty($pix_infinite_animation)) {
					$output .= '</div>';
				}
			} else {

				if (!empty($animation)) {
					$anim_type = 'data-anim-type="' . $animation . '"';
					$anim_delay = 'data-anim-delay="' . $delay . '"';
					$output .= '<div class="animate-in d-inline-block" ' . $anim_type . ' ' . $anim_delay . '>';
				}
				if (!empty($pix_tilt)) {
					$output .= '<div class="' . $pix_tilt_size . ' d-inline-block">';
				}

				if (!empty($pix_infinite_animation)) {
					$output .= '<div class="' . $pix_infinite_animation . ' ' . $pix_infinite_speed . '">';
				}

				$size_num = (int)$width;
				$size = array($size_num, $size_num);
				$full_image = '';
				if (is_string($image) && substr($image, 0, 4) === "http") {
					$full_image = '<img class="rounded-circle bg-white pix-fit-cover img-fluid hover-effect ' . $inner_border . '" style="' . $inline_style . '" alt="' . $alt . '" src="' . $image . '"  />';
				} else {
					$attrs = array(
						'class'	=> 'rounded-circle bg-white pix-fit-cover img-fluid hover-effect ' . $inner_border,
						'style'	=> $inline_style,
						'alt'	=> $alt
					);
					if (is_array($image) && !empty($image)) {
						if ( is_int( $image['id'] ) ) {
							$image['id'] = apply_filters( 'wpml_object_id', $image['id'], 'attachment', true );
						}
						$full_image = wp_get_attachment_image($image['id'], $size, false, $attrs);
					} else {
						if ( is_int( $image ) ) {
							$image = apply_filters( 'wpml_object_id', $image, 'attachment', true );
						}
						$full_image = wp_get_attachment_image($image, $size, false, $attrs);
					}
				}
				$output .= '<div class="pix-story d-inline-block ' . $align . ' ' . $css_class . '"  ' . $jarallax . '>';
				$output .= '<div class="story-img pix-bg-attachment-scroll pix-bg-custom ' . $class_names . '" ' . $custom_outer_style . '>';
				$output .= $full_image;
				$output .= '</div>';
				if (!empty($title)) $output .= '<div class="pix-px-5 ' . $text_size . ' ' . $c_color . ' ' . $position . ' ' . $text_classes . '" ' . $c_custom_color . '>' .  $title  . '</div>';
				$output .= '</div>';
				if (!empty($pix_infinite_animation)) {
					$output .= '</div>';
				}
				if (!empty($pix_tilt)) {
					$output .= '</div>';
				}
				if (!empty($animation)) {
					$output .= '</div>';
				}
			}
		}

		return $output;
	}
}
