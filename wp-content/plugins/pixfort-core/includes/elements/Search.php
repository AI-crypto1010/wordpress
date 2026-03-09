<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Search
* --------------------------------------------------------------------------- */
class PixSearch {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'animation' 	=> '',
			'delay' 	=> '0',
			'search_div' 	=> '',
			'max_width' 	=> '',
			'shadow_style' 	=> '1',
			'rounded_corners' 	=> 'rounded-lg',
			'custom_border_radius' => '',
			'css' 	=> '',
		), $attr));

		$classes = array();
		$style_rules = array();

		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
			array_push($classes, $css_class);
		}


		$sanitize_css_value = function ($value) {
			if (!is_scalar($value)) {
				return '';
			}
			$value = trim((string) $value);
			if ($value === '' || preg_match('/[{};]/', $value)) {
				return '';
			}
			return $value;
		};

		
		$max_width = $sanitize_css_value($max_width);
		$custom_border_radius = $sanitize_css_value($custom_border_radius);

		if (!empty($max_width)) {
			$style_rules[] = 'max-width:100%';
			$style_rules[] = 'width:' . $max_width . ' !important';
			array_push($classes, 'd-inline-block');
		} else {
			array_push($classes, 'pix-search-div');
		}
		if ($rounded_corners === 'custom' && !empty($custom_border_radius)) {
			$style_rules[] = '--pix-search-border-radius:' . $custom_border_radius;
		}
		$c_style = '';
		if (!empty($style_rules)) {
			$c_style = 'style="' . esc_attr(implode(';', $style_rules) . ';') . '"';
		}

		$anim_type = '';
		$anim_delay_icon = '';
		if (!empty($animation)) {
			array_push($classes, 'animate-in');
			$anim_type = 'data-anim-type="' . $animation . '"';
			$anim_delay_icon = 'data-anim-delay="' . $delay . '"';
		}



		$link = admin_url('admin-ajax.php?action=pix_ajax_search');
		$search_data = 'data-search-link="' . $link . '"';

		$output  = '';
		if (!empty($search_div)) {
			$output  .= '<div class="pix-search-div ' . $search_div . '">';
		} else {
			array_push($classes, 'w-100');
		}
		$class_names = join(' ', $classes);
		$placeholder = esc_attr__('Search for something', 'pixfort-core');
		$homeUrl = home_url('/');
		if(function_exists('pll_home_url')){
			$homeUrl = pll_home_url();
		}
		// Get current search query if on search results page
		$current_query = '';
		if (is_search()) {
			$current_query = get_search_query();
		}
		$shadowEffectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($shadow_style, '', '');
		$rounded_class = $rounded_corners === 'custom' ? '' : sanitize_html_class($rounded_corners);
		$output  .= '<form class="pix-small-search pix-ajax-search-container position-relative ' . $shadowEffectsClasses . ' ' . $rounded_class . ' ' . $class_names . '" ' . $c_style . ' ' . $anim_type . ' ' . $anim_delay_icon . ' method="get" action="' . esc_url($homeUrl) . '">
                <div class="d-flex">
                    <input type="search" class="form-control pix-ajax-search form-control-lg shadow-0 font-weight-bold text-body-default" name="s" autocomplete="off" placeholder="' . $placeholder . '" aria-label="Search" value="' . esc_attr($current_query) . '" ' . $search_data . '>
                    <button class="btn btn-search btn-white m-0 text-body-default" aria-label="Search" type="submit">' . pixGetFileContents( '/functions/images/search.svg') . '</button>';
					if(function_exists('pll_current_language')){
						$output  .= '<input type="hidden" name="lang" value="'.pll_current_language().'">';
					}
                $output  .= '</div>
            </form>';
		if (!empty($search_div)) {
			$output  .= '</div>';
		}

		return $output;
	}
}
