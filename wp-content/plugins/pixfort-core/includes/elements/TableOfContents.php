<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Table of Contents
* --------------------------------------------------------------------------- */
class PixTableOfContents {

	private function sanitize_tag_list($tags) {
		$allowed = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];

		if (!is_array($tags)) {
			if (is_string($tags) && !empty($tags)) {
				$tags = explode(',', $tags);
			} else {
				$tags = [];
			}
		}

		$tags = array_map('trim', $tags);
		$tags = array_map('strtolower', $tags);
		$tags = array_values(array_unique(array_intersect($tags, $allowed)));

		return $tags;
	}


	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'title' => __('In this page', 'pixfort-core'),
			'html_tag' => 'h4',
			'show_title_icon' => 'yes',
			'title_icon' => 'Line/pixfort-icon-menu-2',
			'include_mode' => 'include',
			'include_tags' => ['h2', 'h3', 'h4', 'h5', 'h6'],
			'exclude_selectors' => '',
			'container' => '',
			'marker_view' => 'line',
			'no_headings_message' => __('No headings were found on this page.', 'pixfort-core'),
			'hierarchical_view' => 'yes',
			'collapse_subitems' => '',
			'css' => '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		$title = !empty($title) ? $title : __('In this page', 'pixfort-core');
		$no_headings_message = !empty($no_headings_message) ? $no_headings_message : __('No headings were found on this page.', 'pixfort-core');

		$allowed_title_tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span'];
		$title_tag = strtolower(trim($html_tag));
		if (!in_array($title_tag, $allowed_title_tags, true)) {
			$title_tag = 'h4';
		}

		$marker_view_class = 'pix-toc-list-' . $marker_view;
		$marker_view = $marker_view === 'numbers' ? 'numbers' : 'bullets';
		$include_mode = $include_mode === 'exclude' ? 'exclude' : 'include';
		$selected_include_tags = $this->sanitize_tag_list($include_tags);
		$exclude_selectors_clean = is_string($exclude_selectors) ? trim($exclude_selectors) : '';
		$container_selector = is_string($container) ? trim($container) : '';
		$show_icon = $show_title_icon === 'yes';
		$toc_id = '';
		if (!empty($attr['_id']) && is_string($attr['_id'])) {
			$toc_id = 'pix-toc-' . sanitize_html_class($attr['_id']);
		}
		if (empty($toc_id)) {
			$toc_id = 'pix-toc-' . substr(md5(wp_json_encode($attr) . wp_rand()), 0, 12);
		}

		// Handle icon
		$header_icon = '';
		if ($show_icon) {
			// Get icon value (pixfort icon selector returns a string)
			$icon_value = !empty($title_icon) ? $title_icon : 'Line/pixfort-icon-menu-2';

			// Get the icon using PixfortCore
			if (\PixfortCore::instance()->icons && method_exists(\PixfortCore::instance()->icons, 'getIcon')) {
				$header_icon = \PixfortCore::instance()->icons->getIcon($icon_value, 24, 'pix-toc-header-icon', 'aria-hidden="true"');
			}

			// Fallback to hamburger menu entity if icon retrieval fails
			if (empty($header_icon)) {
				$header_icon = '<span class="pix-toc-header-icon" aria-hidden="true">&#9776;</span>';
			}
		}

		$output = '';
		$output .= '<div id="' . esc_attr($toc_id) . '" class="pix-toc-element ' . esc_attr($css_class) . '"';
		$output .= ' data-include-mode="' . esc_attr($include_mode) . '"';
		if ($include_mode === 'include') {
			$output .= ' data-include-tags="' . esc_attr(implode(',', $selected_include_tags)) . '"';
		} else {
			$output .= ' data-exclude-selectors="' . esc_attr($exclude_selectors_clean) . '"';
		}
		$output .= ' data-container-selector="' . esc_attr($container_selector) . '"';
		$output .= ' data-marker-view="' . esc_attr($marker_view) . '"';
		$output .= ' data-hierarchical-view="' . esc_attr($hierarchical_view === 'yes' ? 'yes' : 'no') . '"';
		$output .= ' data-collapse-subitems="' . esc_attr($collapse_subitems === 'yes' ? 'yes' : 'no') . '">';

		if (!empty($title)) {
			$output .= '<' . $title_tag . ' class="pix-toc-title d-flex align-items-center mb-3">';
			if ($show_icon && !empty($header_icon)) {
				$output .= $header_icon;
			}
			$output .= do_shortcode($title);
			$output .= '</' . $title_tag . '>';
		}

		$output .= '<nav class="pix-toc-nav ' . esc_attr($marker_view_class) . '" aria-label="' . esc_attr__('Table of contents', 'pixfort-core') . '"></nav>';
		$output .= '<div class="pix-toc-empty">' . do_shortcode($no_headings_message) . '</div>';
		$output .= '</div>';

		wp_enqueue_style('pix-table-of-contents', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/table-of-contents.min.css', [], PIXFORT_PLUGIN_VERSION, 'all');

		return $output;
	}
}
