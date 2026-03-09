<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* TestimonialMasonry
* --------------------------------------------------------------------------- */
class PixTestimonialMasonry {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'items' 		=> '',
			'css' 		=> '',
		), $attr));

		if (is_array($items)) {
			$testimonials = $items;
		} else {
			$testimonials = vc_param_group_parse_atts($items);
		}
		$output = '';
		if (!empty($testimonials)) {
			wp_enqueue_style( 'pixfort-masonry-style', PIX_CORE_PLUGIN_URI.'includes/assets/css/elements/masonry.min.css', false, PIXFORT_PLUGIN_VERSION);
			wp_enqueue_script('pix-flickity-js');
			$output .= '<div class="pix_masonry">';
			$output .= '<div class="grid-sizer"></div>';
			$output .= '<div class="gutter-sizer"></div>';
			foreach ($testimonials as $key => $value) {
				$output .= '<div class="' . $value['grid_size'] . ' pix-mb-20">';
				$output .= \PixfortCore::instance()->elementsManager->renderElement('Testimonial', array_merge($value, $attr) );
				$output .= '</div>';
			}
			$output .= '</div>';
		}
		return $output;
	}
}

