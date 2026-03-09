<?php


if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
 * Circles
* --------------------------------------------------------------------------- */
class PixCircles {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'circles'				=> '',
			'effect'				=> '',
			'hover_effect'			=> '',
			'btn_text'				=> '',
			'btn_link'				=> '',
			'circles_size'			=> 'pix-sm-circles',
			'circles_align'			=> 'justify-content-start',
			'circles_align_mobile'	=> 'center',
			'animation'				=> 'fade-in-left',
			'delay'					=> '0',
			'c_css' 				=> '',
			'css' 					=> '',
		), $attr));
		$attr['btn_mb'] = 'mb-0';

		$animation_class = '';
		$animation_type = '';
		if (!empty($animation)) {
			$attr['btn_animation'] = $animation;
			$attr['btn_anim_delay'] = intval($delay) + 300;
			$animation_class = 'animate-in';
			$animation_type = 'data-anim-type="' . $animation . '"';
		}

		$circles_arr = array();
		$css_class = '';

		if (is_array($circles)) {
			$circles_arr = $circles;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$circles_arr = vc_param_group_parse_atts($circles);
			}
		}

		$output = '';

		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($c_css, ' '));
		}
		wp_enqueue_style('pixfort-circles-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/circles.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');

		$classes = ' ';
		$classes .= $animation_class . ' ';
		$classes .= \PixfortCore::instance()->coreFunctions->getEffectsClasses($effect, $hover_effect) . ' ';

		$i = intval($delay);
		$circles_html = '';

		$circleMargin = 'pix-mr-5';
		$btnMargin = 'pix-ml-5 ';
		if (is_rtl()) {
			$circleMargin = 'pix-ml-5 ';
			$btnMargin = 'pix-mr-5 ';
		}

		if (!empty($circles_arr)) {
			foreach ($circles_arr as $key => $value) {
				$image_alt = '';
				$imgSrc = '';
				$imgSrcset = '';
				$imgSizes = '';
				if (!empty($value["img"])) {
					if (is_string($value["img"]) && substr($value["img"], 0, 4) === "http") {
						$img = $value["img"];
						$imgSrc = $img;
					} else {
						if (!empty($value["img"]['id'])) {
							if ( is_int( $value["img"]['id'] ) ) {
								$value["img"]['id'] = apply_filters( 'wpml_object_id', $value["img"]['id'], 'attachment', true );
							}
							$img = wp_get_attachment_image_src($value["img"]['id'], "pix-woocommerce-md");
							$imgSrcset = wp_get_attachment_image_srcset($value["img"]['id']);
							$image_alt = get_post_meta($value["img"]['id'], '_wp_attachment_image_alt', TRUE);
							if (!empty($imgSrcset)) {
								$imgSrcset = 'srcset="' . $imgSrcset . '"';
								$imgSizes = 'sizes="' . wp_get_attachment_image_sizes($value["img"]['id'], "full") . '"';
							}

							$imgSrc = '';
							if (is_array($img)) {
								$imgSrc = $img[0];
							}
							if (!$img && $value["img"]['url']) {
								$imgSrc = $value["img"]['url'];
							}
						} else {
							if ( is_int( $value["img"] ) ) {
								$value["img"] = apply_filters( 'wpml_object_id', $value["img"], 'attachment', true );
							}
							$img = wp_get_attachment_image_src($value["img"], "pix-woocommerce-md");
							$imgSrcset = wp_get_attachment_image_srcset($value["img"]);
							if (!empty($imgSrcset)) {
								$imgSrcset = 'srcset="' . $imgSrcset . '"';
								$imgSizes = 'sizes="' . wp_get_attachment_image_sizes($value["img"], "full") . '"';
							}
							if (!empty($img[0])) {
								$imgSrc = $img[0];
							}
							$image_alt = get_post_meta($value["img"], '_wp_attachment_image_alt', TRUE);
						}
					}
				}
				if (empty($value['color'])) $value['color'] = '';

				$color = $value['color'];
				$title = empty($value["title"]) ? 'Circle' : $value["title"];
				$target = '';
				if (!empty($value['target'])) {
					$target = 'target="_blank"';
				}
				$nofollow = '';
				if (!empty($value['nofollow'])) {
					$nofollow = 'rel="nofollow"';
				}
				if (empty($value['link'])) {
					$circles_html .= '<span class="align-middle circle-item ' . $circleMargin . ' ' . $color . $classes . '" ' . $animation_type . ' data-anim-delay="' . $i . '" data-toggle="tooltip" data-html="true" data-placement="bottom" title="' . do_shortcode($title) . '"><img src="' . $imgSrc . '" ' . $imgSrcset . ' ' . $imgSizes . ' width="60" height="60" class="rounded-circle bg-white" alt="' . $image_alt . '" /></span>';
				} else {
					$circles_html .= '<a class="align-middle circle-item ' . $circleMargin . ' ' . $color . $classes . '" ' . $animation_type . ' data-anim-delay="' . $i . '"  href="' . $value["link"] . '" ' . $target . ' ' . $nofollow . ' data-toggle="tooltip" data-html="true" data-placement="bottom" title="' . do_shortcode($title) . '" aria-label="' . $title . '"><img src="' . $imgSrc . '" ' . $imgSrcset . ' ' . $imgSizes . ' width="60" height="60" class="rounded-circle bg-white"  alt="' . $image_alt . '" /></a>';
				}
				$i += 100;
			}
		}

		if (!empty($circles_align_mobile) && $circles_align_mobile !== 'default') {
			$mobile_align = '';
			switch ($circles_align_mobile) {
				case 'left':
					$mobile_align = 'justify-content-start';
					break;
				case 'center':
					$mobile_align = 'justify-content-center';
					break;
				case 'right':
					$mobile_align = 'justify-content-end';
					break;
			}
			$circles_align = $mobile_align . ' ' . str_replace("justify-content-", "justify-content-sm-", $circles_align);
		}

		$output = '<div class="pix-circles-elem d-flex flex-column flex-sm-row w-100 ' . $circles_align . '  ' . esc_attr($css_class) . '">';
		$output .= '<div class="pix-circles ' . $circles_size . ' d-inline-flex align-items-center align-middle ' . $circles_align . '">' . $circles_html . '</div>';
		if (!empty($btn_text)) {
			$output .= '<div class="' . $btnMargin . 'align-items-center align-items-center d-flex pt-md-0 pt-3 ' . $circles_align . '">';
			$output .= \PixfortCore::instance()->elementsManager->renderElement('Button', $attr);
			$output .= '</div>';
		}
		$output .= '</div>';


		return $output;
	}
}
