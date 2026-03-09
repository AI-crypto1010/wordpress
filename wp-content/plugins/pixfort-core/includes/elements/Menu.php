<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Menu
* --------------------------------------------------------------------------- */
require_once __DIR__ . '/extras/menu-widget-navwalker.php';

class PixMenu {

	private function is_elementor_editor() {
		return class_exists('\Elementor\Plugin')
			&& isset(\Elementor\Plugin::$instance->editor)
			&& method_exists(\Elementor\Plugin::$instance->editor, 'is_edit_mode')
			&& \Elementor\Plugin::$instance->editor->is_edit_mode();
	}

	private function get_menu_object($menu_setting) {
		if (empty($menu_setting)) {
			return null;
		}

		if (is_numeric($menu_setting)) {
			return wp_get_nav_menu_object((int) $menu_setting);
		}

		return wp_get_nav_menu_object(sanitize_text_field((string) $menu_setting));
	}

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'menu' => '',
			'menu_layout' => 'vertical',
			'menu_style' => 'default',
			'submenu_open_current' => 'yes',
			'el_class' => '',
			'css' => '',
		), $attr));

		$layout = $menu_layout === 'horizontal' ? 'horizontal' : 'vertical';
		$open_current_submenus = $submenu_open_current === 'yes';

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		$menu_object = $this->get_menu_object($menu);
		if (empty($menu_object) || is_wp_error($menu_object)) {
			if ($this->is_elementor_editor()) {
				return '<div class="pix-menu-widget-empty text-body-default small">' . esc_html__('Please choose a WordPress menu from the widget settings.', 'pixfort-core') . '</div>';
			}
			return '';
		}

		wp_enqueue_style(
			'pixfort-menu-style',
			PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/menu.min.css',
			false,
			PIXFORT_PLUGIN_VERSION,
			'all'
		);

		$wrapper_classes = [
			'pix-menu-element',
			'pix-menu-widget',
			'pix-menu-layout-' . $layout,
		];
		if (!empty($el_class)) {
			$wrapper_classes[] = $el_class;
		}
		if (!empty($css_class)) {
			$wrapper_classes[] = $css_class;
		}
		if ($menu_style === 'line') {
			$wrapper_classes[] = 'pix-menu-line-style';
		}

		$menu_id = !empty($attr['_id']) && is_string($attr['_id'])
			? 'pix-menu-' . sanitize_html_class($attr['_id'])
			: 'pix-menu-' . substr(md5(wp_json_encode($attr) . wp_rand()), 0, 12);

		$output = '<div class="' . esc_attr(implode(' ', array_filter($wrapper_classes))) . '" data-pix-menu-layout="' . esc_attr($layout) . '">';

		if ($layout === 'horizontal') {
			// TODO: Implement horizontal menu layout rendering.
			$output .= '<div class="pix-menu-widget-placeholder text-body-default small">' . esc_html__('Horizontal menu layout will be implemented soon.', 'pixfort-core') . '</div>';
		} else {
			$menu_html = wp_nav_menu([
				'menu' => $menu_object,
				'echo' => false,
				'depth' => 0,
				'fallback_cb' => '__return_empty_string',
				'container' => 'nav',
				'container_class' => 'pix-menu-nav',
				'container_aria_label' => __('Navigation menu', 'pixfort-core'),
				'menu_id' => $menu_id,
				'menu_class' => 'pix-menu-list list-unstyled m-0',
				'walker' => new Pix_Menu_Widget_Walker('vertical', $open_current_submenus),
			]);

			if (!empty($menu_html)) {
				$output .= $menu_html;
			} elseif ($this->is_elementor_editor()) {
				$output .= '<div class="pix-menu-widget-empty text-body-default small">' . esc_html__('The selected menu has no items yet.', 'pixfort-core') . '</div>';
			}
		}

		$output .= '</div>';

		return $output;
	}
}
