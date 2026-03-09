<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* FancyMockup
* --------------------------------------------------------------------------- */
class PixFancyMockup {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'image'  => '',
			'image_dark'  => '',
			'rounded_img'  => 'rounded-0',
			'alt'  => '',
			'align'  => 'text-left',
			'width' 	=> '',
			'height' 	=> '',
			'pix_scroll_parallax' 	=> '',
			'pix_tilt' 	=> '',
			'pix_tilt_size' 	=> 'tilt',
			'xaxis' 	=> '',
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
			'css' 		=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}
		wp_enqueue_style('pixfort-fancy-mockup-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/fancy-mockup.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');

		$output = '';
		if (!empty($image)) {
			$imgWidth = '';
			$imgHeight = '';
			$classes = [];

			array_push($classes, esc_attr($css_class));
			$effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
			array_push($classes, $effectsClasses);

			if (!empty($align)) {
				array_push($classes, $align);
				array_push($classes, "w-100");
			}
			$inline_style = '';
			if (!empty($width)) {
				$inline_style .= 'max-width:' . $width . ';';
			} else {
				if (!empty($height)) {
					$inline_style .= 'width:auto;';
				}
			}
			if (!empty($height)) {
				$inline_style .= 'max-height:' . $height . ';';
			} else {
				$inline_style .= 'height:auto;';
			}
			array_push($classes, 'd-inline-block');


			$inline_style = 'style="' . $inline_style . '"';
			$class_names = join(' ', $classes);

			$output = '';
			if (!empty($link)) {
				$ntab = '';
				if (!empty($target)) {
					$ntab = 'target="_blank"';
				}
				$output .= '<a href="' . $link . '" ' . $ntab . ' title="' . $alt . '">';
			}
			$output .= '<div class="pix-fancy-mockup" ' . $inline_style . '>';
			$output .= '<div class="pix-fancy-content">';

			$imageOutput = \PixfortCore::instance()->coreFunctions->getDynamicImage($image, 'full', [
				'alt' => $alt
			], $image_dark);
			if (!empty($imageOutput)) {
				$output .= $imageOutput;
			}
			$imageData = \PixfortCore::instance()->coreFunctions->getImageSrc($image);
			if(!empty($imageData['width'])){
				$imgWidth = 'width="' . $imageData['width'] . '"';
			}
			if(!empty($imageData['height'])){
				$imgHeight = 'height="' . $imageData['height'] . '"';
			}

			$output .= '</div>
                    <img class="pix-fancy-device-img" ' . $imgWidth . ' ' . $imgHeight . ' src="' . PIX_CORE_PLUGIN_URI . 'functions/images/ipad.png" alt="' . $alt . '">';

			$output .= '</div>';
			if (!empty($link)) {
				$output .= '</a>';
			}
		}

		return $output;
	}
}
