<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Video
* --------------------------------------------------------------------------- */
class PixVideo {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'embed_code'  => '',
			'is_elementor'  => false,
			'decode'  => '1',
			'video_placeholder_type'  => '',
			'image'  => '',
			'placeholder_video'  => '',
			'rounded_img'  => 'rounded-0',
			'aspect' 	=> 'embed-responsive-21by9',
			'popup_aspect' 	=> 'default',
			'pix_scroll_parallax' 	=> '',
			'pix_tilt' 	=> '',
			'pix_tilt_size' 	=> 'tilt',
			'xaxis' 	=> '',
			'yaxis' 	=> '',
			'animation' 	=> '',
			'delay' 	=> '0',
			'style' 		=> '',
			'hover_effect' 		=> '',
			'add_hover_effect' 		=> '',
			'pix_infinite_animation' 		=> '',
			'pix_infinite_speed' 		=> '',
			'text_color' 	=> 'primary',
			'bg_color'		=> 'white',
			'custom_bg_color'		=> '',
			'size'		=> '100',
			'icon_style'		=> 'due',
			'overlay_color'		=> 'black',
			'overlay_custom_color'		=> '',
			'overlay_opacity'		=> 'pix-opacity-8',
			'in_popup'		=> false,
			'extra_classes' 		=> '',
			'css' 		=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		wp_enqueue_style('pixfort-video-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/video.min.css', false, PLUGIN_VERSION, 'all');

		$css_class .= ' ' . $extra_classes;

		$popup_aspect_ratio = $aspect;
		if(!empty($popup_aspect) && $popup_aspect !== 'default') {
			$popup_aspect_ratio = $popup_aspect;
		}
		
		$output = '';
		$imgSrc = '';
		if (!empty($image)) {
			if (is_string($image) && substr($image, 0, 4) === 'http') {
				$imgSrc = $image;
			} elseif (is_array($image) && !empty($image['url'])) {
				// Handle Elementor "insert from URL" case
				$imgSrc = $image['url'];
			} else {
				if (is_array($image) && !empty($image['id'])) {
					if ( is_int( $image['id'] ) ) {
						$image['id'] = apply_filters( 'wpml_object_id', $image['id'], 'attachment', true );
					}
					$img = wp_get_attachment_url($image['id'], 'full');
				} else {
					if (is_numeric($image)) {
						if ( is_int( $image ) ) {
							$image = apply_filters( 'wpml_object_id', $image, 'attachment', true );
						}
						$img = wp_get_attachment_url($image, 'full');
					} else {
						$img = '';
					}
				}
				//  $imgSrc = $img[0];
				$imgSrc = $img;
			}
			// Check if the image source is actually a video file (mp4)
			if (pix_endsWith($imgSrc, 'mp4')) {
				$video_placeholder_type = 'video';
				$placeholder_video = $imgSrc;
			}
		}
		$classes = array();
		$anim_type = '';
		$anim_delay = '';
		array_push($classes, esc_attr($css_class));

		$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
        array_push($classes, $effectsClasses);

		$span_classes = array();
		$icon_classes = array();
		$span_custom_style = '';
		$icon_custom_style = '';
		if (!empty($text_color)) {
			if ($text_color != 'custom') {
				array_push($icon_classes, 'text-' . $text_color);
			} else {
				$icon_custom_style = 'color:' . $text_custom_color . ';';
			}
		}
		$span_custom_style .= 'width:' . $size . 'px;';
		$span_custom_style .= 'height:' . $size . 'px;';
		if ((int)$size) {
			$fize = (int)$size / 2.5;
			$icon_custom_style .= 'height:' . $fize . 'px;';
			$icon_custom_style .= 'width:' . $fize . 'px;';
			$icon_custom_style .= 'font-size:' . $fize . 'px;';
		}
		if (!empty($bg_color)) {
			if ($bg_color != 'custom') {
				array_push($span_classes, 'bg-' . $bg_color);
			} else {
				$span_custom_style .= 'background-color:' . $custom_bg_color . ';';
			}
		}

		$span_custom_style = 'style="' . $span_custom_style . '"';
		$icon_custom_style = 'style="' . $icon_custom_style . '"';
		$span_classes_names = join(' ', $span_classes);
		$icon_classes_names = join(' ', $icon_classes);


		$class_names = join(' ', $classes);

		$jarallax = '';
		if ($pix_scroll_parallax) {
			if (!empty($xaxis) || !empty($yaxis)) {
				$jarallax = 'data-jarallax-element="' . $xaxis . ' ' . $yaxis . '" data-xaxis="' . $xaxis . '" data-yaxis="' . $yaxis . '"';
			}
		}

		if (!empty($pix_infinite_animation)) {
			$output .= '<div class="' . $pix_infinite_animation . ' ' . $pix_infinite_speed . '">';
		}
		if (!empty($animation)) {
			$anim_type = 'data-anim-type="' . $animation . '"';
			$anim_delay = 'data-anim-delay="' . $delay . '"';
			$output .= '<div class="animate-in" ' . $anim_type . ' ' . $anim_delay . '>';
		}
		if (!empty($pix_tilt)) {
			$output .= '<div class="' . $pix_tilt_size . '">';
		}
		if ($decode && $decode == '1') {
			if (!$is_elementor) $embed_code = rawurldecode(base64_decode($embed_code));
		}
		$res = preg_replace("/[\`]/", "", html_entity_decode($embed_code));
		$custom_style = '';
		if ($overlay_color === 'custom') {
			$custom_style .= 'style="--pix-bg-color:' . $overlay_custom_color . ';"';
		}

		if (!empty($image) || !empty($placeholder_video)) {
			$output .= '<div class="pix-video bg-' . $overlay_color . ' ' . $rounded_img . ' ' . $class_names . '" ' . $jarallax . ' ' . $custom_style . '>';
			if (!empty($video_placeholder_type) && $video_placeholder_type === 'video') {
				$output .= '<video class="video-bg ' . $rounded_img . ' ' . $overlay_opacity . '" width="100%" autoPlay muted playsinline loop style="opacity:1;">';
				$output .= '<source src="' . $placeholder_video . '" type="video/mp4" />';
				$output .= '</video>';
			} else {
				$output .= '<img alt="Image" src="' . $imgSrc . '" class="video-bg ' . $overlay_opacity . '" />';
			}
			if ($in_popup) {
				$output .= '<div class="pix-video-popup video-play-btn d-flex align-items-center justify-content-center scale shadow-lg ' . $span_classes_names . '" ' . $span_custom_style . ' data-aspect="' . $popup_aspect_ratio . '" data-content="' . esc_attr($res) . '" >';
				if ($icon_style == 'due') {
					$output .= '<span class="d-flex ' . $icon_classes_names . '" ' . $icon_custom_style . '>';
					$output .= pixGetFileContents( '/functions/images/play_arrow.svg');
					// $output .= \PixfortCore::instance()->icons->getIcon('Duotone/pixfort-icon-play-1', 50, 'm-0 p-0');
					$output .= '</span>';
				} else {
					$output .= '<span class="d-flex ' . $icon_classes_names . '" ' . $icon_custom_style . '>';
					$output .= \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-play-1', 50, 'm-0 p-0');
					$output .= '</span>';
				}
				$output .= '</div>';
			} else {
				$output .= '<div class="video-play-btn video-play-btn-inline d-flex align-items-center justify-content-center scale shadow-lg ' . $span_classes_names . '" ' . $span_custom_style . '>';
				if ($icon_style == 'due') {
					$output .= '<span class="d-flex ' . $icon_classes_names . '" ' . $icon_custom_style . '>';
					$output .= pixGetFileContents( '/functions/images/play_arrow.svg');
					// $output .= \PixfortCore::instance()->icons->getIcon('Duotone/pixfort-icon-play-1', 50, 'm-0 p-0');
					$output .= '</span>';
				} else {
					$output .= '<span class="d-flex ' . $icon_classes_names . '" ' . $icon_custom_style . '>';
					$output .= \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-play-1', 50, 'm-0 p-0');
					$output .= '</span>';
				}
				$output .= '</div>';
			}
			$output .= '<div class="embed-responsive ' . $aspect . '">';
			if (!$in_popup) {
				$output .= $res;
			}

			$output .= '</div>';
			$output .= '</div>';
		} else {
			$res = preg_replace("/\ssrc=/", " data-src=", $res);
			$output .= '<div class="pix-video video-active ' . $rounded_img . ' ' . $class_names . '" ' . $jarallax . '>';
			$output .= '<div class="embed-responsive ' . $aspect . '">';
			$output .= $res;
			$output .= '</div>';
			$output .= '</div>';
		}
		if (!empty($pix_tilt)) {
			$output .= '</div>';
		}
		if (!empty($animation)) {
			$output .= '</div>';
		}
		if (!empty($pix_infinite_animation)) {
			$output .= '</div>';
		}
		return $output;
	}
}

