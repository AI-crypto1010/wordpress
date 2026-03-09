<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Map
* --------------------------------------------------------------------------- */
class PixMap {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'address'			=> '',
			'latitude'			=> '48.892506',
			'longitude' 		=> '2.236413',
			'map_zoom' 			=> '14',
			'map_style' 		=> 'silver',
			'custom_color' 		=> '#1274E7',
			'saturation' 		=> '-20',
			'brightness' 		=> '5',
			'marker' 			=> '',
			'style' 			=> '',
			'hover_effect' 		=> '',
			'add_hover_effect' 	=> '',
			'animation' 		=> '',
			'delay' 			=> '0',
			'map_height' 		=> '',
			'extra_classes' 	=> '',
			'css' 				=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		wp_enqueue_style('pixfort-map-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/map.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');

		$classes = [];
		
		$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
		array_push($classes, $effectsClasses);

		$class_names = join(' ', $classes);

		$imgSrc = PIX_CORE_PLUGIN_URI . 'functions/images/map/pix-icon-location.svg';
		if (!empty($marker)) {
			if (is_string($marker) && substr($marker, 0, 4) === "http") {
				$imgSrc = $marker;
			} else {
				if (!empty($marker['id'])) {
					if ( is_int( $marker['id'] ) ) {
						$marker['id'] = apply_filters( 'wpml_object_id', $marker['id'], 'attachment', true );
					}
					$img = wp_get_attachment_image_src($marker['id'], "full");
					if (!empty($img[0])) {
						$imgSrc = $img[0];
					}
					if (!$img && $marker['url']) {
						$imgSrc = $marker['url'];
					}
				} else {
					if ( is_int( $marker ) ) {
						$marker = apply_filters( 'wpml_object_id', $marker, 'attachment', true );
					}
					$img = wp_get_attachment_image_src($marker, "full");
					if (!empty($img[0])) {
						$imgSrc = $img[0];
					}
				}
			}
		}

		$anim_attrs = '';
		if (!empty($animation)) {
			$css_class = $css_class . ' animate-in';
			$anim_attrs = 'data-anim-delay="' . $delay . '" data-anim-type="' . $animation . '"';
		}


		$output = '';
		if (!empty(pix_plugin_get_option('google-api-key'))) {
			$output .= '<div class="overflow-hidden pix-map-out mb-2 mb-sm-0 ' . $extra_classes . ' ' . $map_height . ' ' . $class_names . ' ' . $css_class . '" ' . $anim_attrs . '>';
			$output .= '<section class="pix-google-map w-100" data-style="' . $map_style . '" data-color="' . $custom_color . '" data-saturation="' . $saturation . '" data-brightness="' . $brightness . '" data-latitude="' . $latitude . '" data-longitude="' . $longitude . '" data-map-zoom="' . $map_zoom . '" data-marker="' . $imgSrc . '">';
			$output .= '<div class="google-container"></div>';
			$output .= '<div class="pix-zoom-in bg-white shadow rounded text-dark-opacity-8 text-18 d-flex align-items-center justify-content-center">' . \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-plus-circle-1') . '</div>';
			$output .= '<div class="pix-zoom-out bg-white mt-1 shadow rounded text-dark-opacity-8 text-18 d-flex align-items-center justify-content-center">' . \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-minus-circle-1') . '</div>';
			if (!empty($address)) {
				$output .= '<address class="bg-white rounded-lg text-body-default font-weight-bold shadow-inverse">' . $address . '</address>';
			}
			$output .= '</section>';
			$output .= '</div>';
		} else {
			$output .= '<div class="overflow-hidden pix-map-out mb-2 mb-sm-0 ' . $extra_classes . ' ' . $map_height . ' ' . $class_names . ' ' . $css_class . '" ' . $anim_attrs . '>';
			$output .= '<section class="pix-google-map w-100" data-style="' . $map_style . '" data-color="' . $custom_color . '" data-saturation="' . $saturation . '" data-brightness="' . $brightness . '" data-latitude="' . $latitude . '" data-longitude="' . $longitude . '" data-map-zoom="' . $map_zoom . '" data-marker="' . $imgSrc . '">';
			$output .= '<div class="google-container"></div>';
			$output .= '<div class="pix-zoom-in bg-white shadow rounded text-dark-opacity-8 text-18 d-flex align-items-center justify-content-center">' . \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-plus-circle-1') . '</div>';
			$output .= '<div class="pix-zoom-out bg-white mt-1 shadow rounded text-dark-opacity-8 text-18 d-flex align-items-center justify-content-center">' . \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-minus-circle-1') . '</div>';
			$output .= '<address class="bg-white rounded-lg text-body-default font-weight-bold shadow-inverse">Google Maps API key is not configured in theme options!</address>';
			$output .= '</section>';
			$output .= '</div>';
		}

		return $output;
	}
}
