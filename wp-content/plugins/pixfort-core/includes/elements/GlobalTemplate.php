<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Global Template
* --------------------------------------------------------------------------- */
class PixGlobalTemplate {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'template_id' 		=> '',
			'is_elementor' 		=> false,
			'css' 				=> '',
		), $attr));

		$template_id = absint($template_id);
		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		// Check if we're in Elementor edit mode
		$is_edit_mode = class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode();

		// Check if template_id is provided
		if (empty($template_id)) {
			if ($is_edit_mode) {
				return '<div class="elementor-alert elementor-alert-warning">' . __('Please select a template to display.', 'pixfort-core') . '</div>';
			}
			return '';
		}

		// Get the post to check its post type
		$template_post = get_post($template_id);
		
		if (!$template_post) {
			if ($is_edit_mode) {
				return '<div class="elementor-alert elementor-alert-danger">' . __('Selected template not found.', 'pixfort-core') . '</div>';
			}
			return '';
		}

		$output = '';

		// Render based on post type.
		// We use the shared pixfort_template shortcode to support both Elementor and WPBakery templates.
		if ($template_post->post_type === 'pixfort_template' || $template_post->post_type === 'elementor_library') {
			$output = do_shortcode('[pixfort_template id="' . esc_attr($template_id) . '"]');
			if (empty($output) && class_exists('\Elementor\Plugin')) {
				$output = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($template_id);
			}
		} else {
			if ($is_edit_mode) {
				return '<div class="elementor-alert elementor-alert-warning">' . __('Invalid template type.', 'pixfort-core') . '</div>';
			}
		}

		if (!empty($css_class) && !empty($output)) {
			$output = '<div class="' . esc_attr(trim($css_class)) . '">' . $output . '</div>';
		}

		return $output;
	}
}
