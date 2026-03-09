<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Pix_Menu_Widget_Walker')) {
	class Pix_Menu_Widget_Walker extends Walker_Nav_Menu {
		private $layout = 'vertical';
		private $open_current_submenus = true;
		private $submenu_parent_item_id = 0;
		private $submenu_should_be_open = false;
		private $menu_item_options_cache = [];

		public function __construct($layout = 'vertical', $open_current_submenus = true) {
			$this->layout = $layout === 'horizontal' ? 'horizontal' : 'vertical';
			$this->open_current_submenus = (bool) $open_current_submenus;
		}

		private function sanitize_classes($classes) {
			$clean = [];
			foreach ((array) $classes as $class) {
				if (!is_string($class) || $class === '') {
					continue;
				}
				$clean[] = sanitize_html_class($class);
			}
			return array_values(array_unique($clean));
		}

		private function item_is_current($classes) {
			$current_classes = [
				'current-menu-item',
				'current-menu-ancestor',
				'current-menu-parent',
				'current_page_parent',
				'current_page_ancestor',
			];

			foreach ($current_classes as $current_class) {
				if (in_array($current_class, $classes, true)) {
					return true;
				}
			}

			return false;
		}

		private function get_submenu_id($item_id) {
			return 'pix-menu-submenu-' . absint($item_id);
		}

		private function get_menu_item_advanced_options($item_id) {
			$item_id = absint($item_id);
			if (isset($this->menu_item_options_cache[$item_id])) {
				return $this->menu_item_options_cache[$item_id];
			}

			$raw_options = get_post_meta($item_id, 'menu-item-pix_menu_opts', true);
			if (empty($raw_options) || !is_string($raw_options)) {
				$this->menu_item_options_cache[$item_id] = [];
				return [];
			}

			$decoded_advanced_options = html_entity_decode($raw_options, ENT_QUOTES);
			$options_data = json_decode(wp_specialchars_decode($decoded_advanced_options));
			if (!is_array($options_data)) {
				$this->menu_item_options_cache[$item_id] = [];
				return [];
			}

			$output = [];
			foreach ($options_data as $item_option) {
				if (
					is_object($item_option)
					&& isset($item_option->name)
					&& isset($item_option->val)
					&& is_string($item_option->name)
				) {
					$output[$item_option->name] = $item_option->val;
				}
			}

			$this->menu_item_options_cache[$item_id] = $output;
			return $output;
		}

		private function get_menu_item_icon_value($item_id) {
			$advanced_options = $this->get_menu_item_advanced_options($item_id);
			if (empty($advanced_options['menu_item_icon'])) {
				return '';
			}

			return is_string($advanced_options['menu_item_icon'])
				? trim($advanced_options['menu_item_icon'])
				: '';
		}

		private function get_menu_item_style_value($item_id) {
			$advanced_options = $this->get_menu_item_advanced_options($item_id);
			if (empty($advanced_options['menu_item_style']) || !is_string($advanced_options['menu_item_style'])) {
				return '';
			}

			return trim($advanced_options['menu_item_style']);
		}

		private function is_truthy_option($value) {
			if (is_bool($value)) {
				return $value;
			}
			if (is_numeric($value)) {
				return (int) $value === 1;
			}
			if (!is_string($value)) {
				return false;
			}

			return in_array(strtolower(trim($value)), ['1', 'true', 'yes', 'on'], true);
		}

		private function get_menu_item_box_options($item_id) {
			$advanced_options = $this->get_menu_item_advanced_options($item_id);

			return [
				'pix_is_image_item' => !empty($advanced_options['pix_is_image_item']) ? $this->is_truthy_option($advanced_options['pix_is_image_item']) : false,
				'pix_box_title' => isset($advanced_options['pix_box_title']) ? (string) $advanced_options['pix_box_title'] : '',
				'pix_box_text' => isset($advanced_options['pix_box_text']) ? (string) $advanced_options['pix_box_text'] : '',
				'pix_bg_image' => isset($advanced_options['pix_bg_image']) ? $advanced_options['pix_bg_image'] : '',
				'pix_box_style' => isset($advanced_options['pix_box_style']) ? (string) $advanced_options['pix_box_style'] : 'default',
				'pix_is_full_height' => !empty($advanced_options['pix_is_full_height']) ? $this->is_truthy_option($advanced_options['pix_is_full_height']) : false,
				'pix_is_box_dark' => !empty($advanced_options['pix_is_box_dark']) ? $this->is_truthy_option($advanced_options['pix_is_box_dark']) : false,
				'pix_box_title_color' => isset($advanced_options['pix_box_title_color']) ? (string) $advanced_options['pix_box_title_color'] : 'heading-default',
				'pix_box_text_color' => isset($advanced_options['pix_box_text_color']) ? (string) $advanced_options['pix_box_text_color'] : 'body-default',
				'pix_box_button_color' => isset($advanced_options['pix_box_button_color']) ? (string) $advanced_options['pix_box_button_color'] : 'heading-default',
			];
		}

		private function build_text_color_class($value, $fallback = 'body-default') {
			$resolved = trim((string) $value);
			if ($resolved === '') {
				$resolved = $fallback;
			}

			if (strpos($resolved, 'text-') !== 0) {
				$resolved = 'text-' . $resolved;
			}

			return sanitize_html_class($resolved);
		}

		private function get_box_image_output($background_option, $item_inner_classes = '') {
			$resolved_background = '';
			if (function_exists('pixGetImageID')) {
				$image_ids = pixGetImageID($background_option);
				if (is_array($image_ids) && !empty($image_ids['light'])) {
					$resolved_background = $image_ids['light'];
				}
			}

			if (empty($resolved_background)) {
				$resolved_background = $this->extract_background_media_source($background_option);
			}

			if (empty($resolved_background)) {
				return '';
			}

			$img_classes = trim('pix-bg-image d-inline-block w-100 pix-img-scale pix-opacity-10 ' . $item_inner_classes);
			$image_html = '';

			if (is_numeric($resolved_background)) {
				$image_html = wp_get_attachment_image((int) $resolved_background, 'full', false, [
					'class' => $img_classes,
					'alt' => esc_attr__('Menu banner', 'pixfort-core'),
				]);
				if (!empty($image_html)) {
					return $image_html;
				}
			}

			if (is_string($resolved_background)) {
				$image_url = trim($resolved_background);
				if ($image_url !== '') {
					return '<img src="' . esc_url($image_url) . '" class="' . esc_attr($img_classes) . '" alt="' . esc_attr__('Menu banner', 'pixfort-core') . '" />';
				}
			}

			return '';
		}

		private function extract_background_media_source($value) {
			if (empty($value)) {
				return '';
			}

			if (is_numeric($value)) {
				return $value;
			}

			if (is_string($value)) {
				$trimmed = trim($value);
				if ($trimmed === '') {
					return '';
				}

				$decoded = json_decode($trimmed, true);
				if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
					return $this->extract_background_media_source($decoded);
				}

				return $trimmed;
			}

			if (is_array($value)) {
				if (isset($value['light'])) {
					return $this->extract_background_media_source($value['light']);
				}
				if (!empty($value['id'])) {
					return $value['id'];
				}
				if (!empty($value['url'])) {
					return $value['url'];
				}
				return '';
			}

			if (is_object($value)) {
				if (isset($value->light)) {
					return $this->extract_background_media_source($value->light);
				}
				if (!empty($value->id)) {
					return $value->id;
				}
				if (!empty($value->url)) {
					return $value->url;
				}
				return '';
			}

			return '';
		}

		private function get_default_dark_color($option_key, $fallback) {
			if (function_exists('pix_plugin_get_option')) {
				$option = pix_plugin_get_option($option_key);
				if (!empty($option) && is_string($option)) {
					return $option;
				}
			}
			return $fallback;
		}

		private function get_box_link_icon_output() {
			$is_rtl = function_exists('is_rtl') && is_rtl();
			$box_button_icon = $is_rtl ? 'Line/pixfort-icon-arrow-left-2' : 'Line/pixfort-icon-arrow-right-2';
			$margin_class = $is_rtl ? 'mr-1' : 'ml-1';
			$icon_classes = trim($margin_class . ' d-flex align-self-center font-weight-bold pix-hover-right');

			if (
				class_exists('\PixfortCore')
				&& \PixfortCore::instance()->icons
				&& method_exists(\PixfortCore::instance()->icons, 'getIcon')
			) {
				return \PixfortCore::instance()->icons->getIcon($box_button_icon, 24, $icon_classes, 'style="line-height:16px;"');
			}

			return '<span class="' . esc_attr($icon_classes) . '" aria-hidden="true">' . ($is_rtl ? '&larr;' : '&rarr;') . '</span>';
		}

		private function get_submenu_toggle_icon_output() {
			if (
				class_exists('\PixfortCore')
				&& \PixfortCore::instance()->icons
				&& method_exists(\PixfortCore::instance()->icons, 'getIcon')
			) {
				return \PixfortCore::instance()->icons->getIcon(
					'Line/pixfort-icon-arrow-bottom-2',
					24,
					'pix-menu-submenu-icon',
					'aria-hidden="true"',
					true
				);
			}

			return '<span class="pix-menu-submenu-icon" aria-hidden="true">&#9662;</span>';
		}

		private function render_box_menu_item($item, $box_options, $has_children, $should_open_submenu, $box_button_text = '') {
			$box_title = $box_options['pix_box_title'];
			$box_text = $box_options['pix_box_text'];
			$box_style = trim((string) $box_options['pix_box_style']);
			$box_is_full_height = !empty($box_options['pix_is_full_height']);
			$box_is_dark = !empty($box_options['pix_is_box_dark']);
			$box_title_color = $this->build_text_color_class($box_options['pix_box_title_color'], 'heading-default');
			$box_text_color = $this->build_text_color_class($box_options['pix_box_text_color'], 'body-default');
			$box_button_color = $this->build_text_color_class($box_options['pix_box_button_color'], 'heading-default');
			$box_button_text = trim((string) $box_button_text);

			if ($box_is_dark) {
				$legacy_dark_heading = $this->get_default_dark_color('opt-dark-heading-color', 'heading-default');
				$legacy_dark_body = $this->get_default_dark_color('opt-dark-body-color', 'body-default');
				$box_title_color = $this->build_text_color_class($legacy_dark_heading, 'heading-default');
				$box_text_color = $this->build_text_color_class($legacy_dark_body, 'body-default');
				$box_button_color = $this->build_text_color_class($legacy_dark_heading, 'heading-default');
			}

			$item_inner_classes = '';
			$style_classes = '';
			if ($box_style === 'padding') {
				$style_classes = 'overflow-hidden pix-p-20 rounded-lg';
				$item_inner_classes = 'rounded-lg';
			} elseif ($box_style === 'padding-no-top') {
				$style_classes = 'overflow-hidden pix-px-20 pix-pb-20 rounded-lg';
				$item_inner_classes = 'rounded-lg';
			}
			if ($box_is_full_height) {
				$style_classes .= ' pix-menu-full-height';
			}

			$box_img = $this->get_box_image_output($box_options['pix_bg_image'], $item_inner_classes);
			$box_link = !empty($item->url) && trim((string) $item->url) !== '#';
			$box_target = !empty($item->target) ? $item->target : '_self';

			$item_output = '<div class="d-block position-relative w-100 pix-menu-box ' . esc_attr(trim($style_classes)) . '">';
			$item_output .= '<div class="item-inner pix-menu-box-inner d-flex align-items-end w-100 h-100 position-relative overflow-hidden ' . esc_attr($item_inner_classes) . '" style="-webkit-transform: translateZ(0);transform: translateZ(0);">';

			if (!empty($box_img)) {
				$item_output .= $box_img;
			}

			if ($box_link) {
				$item_output .= '<a target="' . esc_attr($box_target) . '" href="' . esc_url($item->url) . '" class="pix-img-overlay pix-box-container d-md-flex align-items-center w-100 justify-content-center pix-p-20">';
			} else {
				$item_output .= '<span class="menu-item-no-link pix-img-overlay pix-box-container d-md-flex align-items-center w-100 justify-content-center pix-p-20">';
			}

			if (!empty($box_title)) {
				$item_output .= '<div class="h6 heading-font ' . esc_attr($box_title_color) . ' font-weight-bold pix-box-title">' . do_shortcode($box_title) . '</div>';
			}
			if (!empty($box_text)) {
				$item_output .= '<span class="pix-box-text ' . esc_attr($box_text_color) . ' text-sm">' . do_shortcode($box_text) . '</span>';
			}
			if ($box_button_text !== '') {
				$item_output .= '<span class="pix-box-link ' . esc_attr($box_button_color) . ' btn btn-sm p-0 font-weight-bold pix-py-5 pix-hover-item d-flex align-items-center align-self-stretch text-left">';
				$item_output .= '<span class="pix-box-link-label">' . do_shortcode($box_button_text) . '</span>';
				$item_output .= $this->get_box_link_icon_output();
				$item_output .= '</span>';
			}

			$item_output .= $box_link ? '</a>' : '</span>';
			$item_output .= '</div></div>';

			if ($has_children && $this->layout === 'vertical') {
				$submenu_id = $this->get_submenu_id($item->ID);
				$toggle_state = $should_open_submenu ? 'true' : 'false';

				$item_output .= '<button type="button" class="pix-menu-submenu-toggle pix-menu-submenu-toggle-box" aria-expanded="' . esc_attr($toggle_state) . '" aria-controls="' . esc_attr($submenu_id) . '">';
				$item_output .= '<span class="screen-reader-text">' . esc_html__('Toggle submenu', 'pixfort-core') . '</span>';
				$item_output .= $this->get_submenu_toggle_icon_output();
				$item_output .= '</button>';
			}

			return $item_output;
		}

		private function get_menu_item_icon_output($item_id, $depth = 0) {
			$menu_item_icon = $this->get_menu_item_icon_value($item_id);
			if (empty($menu_item_icon)) {
				return '';
			}

			// $margin_class = $this->get_margin_class((int) $depth === 0 ? 5 : 10);
			// $menu_item_icon_classes = $margin_class . ' pix-menu-item-icon';
			$menu_item_icon_classes = ' pix-menu-item-icon';

			if (
				class_exists('\PixfortCore')
				&& \PixfortCore::instance()->icons
				&& method_exists(\PixfortCore::instance()->icons, 'getIcon')
			) {
				return \PixfortCore::instance()->icons->getIcon($menu_item_icon, 24, $menu_item_icon_classes);
			}

			return '<i class="' . esc_attr($menu_item_icon_classes . ' ' . $menu_item_icon) . '" aria-hidden="true"></i>';
		}

		// private function get_margin_class($size = 10) {
		// 	$size = ((int) $size === 5) ? 5 : 10;
		// 	$margin_prefix = 'pix-mr-';

		// 	if (
		// 		defined('PIXFORT_THEME_SLUG')
		// 		&& function_exists('pix_plugin_get_option')
		// 		&& pix_plugin_get_option('site_rtl')
		// 	) {
		// 		$margin_prefix = 'pix-ml-';
		// 	}

		// 	return $margin_prefix . $size;
		// }

		public function start_lvl(&$output, $depth = 0, $args = null) {
			$indent = str_repeat("\t", $depth);
			$submenu_id = '';

			if (!empty($this->submenu_parent_item_id)) {
				$submenu_id = ' id="' . esc_attr($this->get_submenu_id($this->submenu_parent_item_id)) . '"';
			}

			$classes = $this->sanitize_classes([
				'sub-menu',
				'pix-menu-submenu',
				'pix-menu-submenu-level-' . ((int) $depth + 1),
			]);
			$class_names = implode(' ', $classes);

			$hidden = '';
			if ($this->layout === 'vertical' && !$this->submenu_should_be_open) {
				$hidden = ' hidden';
			}

			$output .= "\n$indent<ul{$submenu_id} class=\"" . esc_attr($class_names) . "\"{$hidden}>\n";
		}

		public function end_lvl(&$output, $depth = 0, $args = null) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
		}

		public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
			$indent = $depth ? str_repeat("\t", $depth) : '';
			$classes = empty($item->classes) ? [] : (array) $item->classes;
			$has_children = in_array('menu-item-has-children', $classes, true);
			$is_current = $this->item_is_current($classes);
			$item_url = !empty($item->url) ? trim((string) $item->url) : '';
			$menu_item_style = $this->get_menu_item_style_value($item->ID);
			$box_options = $this->get_menu_item_box_options($item->ID);
			$is_image_item = !empty($box_options['pix_is_image_item']);
			$is_heading_item = $menu_item_style === 'pix-item-heading';
			$is_hash_parent_toggle = $this->layout === 'vertical' && $has_children && $item_url === '#';
			$should_open_submenu = $has_children && $this->open_current_submenus && $is_current;

			$classes[] = 'pix-menu-item';
			$classes[] = 'pix-menu-depth-' . (int) $depth;
			if ($has_children) {
				$classes[] = 'pix-menu-item-has-children';
			}
			if ($should_open_submenu) {
				$classes[] = 'is-open';
			}
			if ($is_heading_item) {
				$classes[] = 'pix-menu-item-style-heading';
			}
			if ($is_image_item) {
				$classes[] = 'pix-menu-item-style-image';
			}
			$classes = $this->sanitize_classes($classes);
			$class_names = implode(' ', $classes);

			$output .= $indent . '<li class="' . esc_attr($class_names) . '">';

			$atts = [];
			$atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
			$atts['target'] = !empty($item->target) ? $item->target : '';
			$atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
			$atts['href'] = !empty($item->url) ? $item->url : '';
			$atts['class'] = 'pix-menu-link';

			$attributes = '';
			foreach ($atts as $attr => $value) {
				if (empty($value)) {
					continue;
				}
				$value = $attr === 'href' ? esc_url($value) : esc_attr($value);
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}

			$title = apply_filters('the_title', $item->title, $item->ID);
			$title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

			$menu_item_icon_out = $this->get_menu_item_icon_output($item->ID, $depth);

			$item_output = '<div class="pix-menu-item-row">';
			if ($is_image_item) {
				$item_output .= $this->render_box_menu_item($item, $box_options, $has_children, $should_open_submenu, $title);
			} elseif ($is_heading_item) {
				$item_output .= '<div class="pix-menu-link pix-menu-text pix-menu-link-label-only">';
				$item_output .= isset($args->link_before) ? $args->link_before : '';
				$item_output .= $menu_item_icon_out . '<span class="pix-menu-link-label">' . do_shortcode($title) . '</span>';
				$item_output .= isset($args->link_after) ? $args->link_after : '';
				$item_output .= '</div>';

				if ($has_children && $this->layout === 'vertical') {
					$submenu_id = $this->get_submenu_id($item->ID);
					$toggle_state = $should_open_submenu ? 'true' : 'false';

					$item_output .= '<button type="button" class="pix-menu-submenu-toggle" aria-expanded="' . esc_attr($toggle_state) . '" aria-controls="' . esc_attr($submenu_id) . '">';
					$item_output .= '<span class="screen-reader-text">' . esc_html__('Toggle submenu', 'pixfort-core') . '</span>';
					$item_output .= $this->get_submenu_toggle_icon_output();
					$item_output .= '</button>';
				}
			} elseif ($is_hash_parent_toggle) {
				$submenu_id = $this->get_submenu_id($item->ID);
				$toggle_state = $should_open_submenu ? 'true' : 'false';

				$item_output .= '<button type="button" class="pix-menu-link pix-menu-submenu-toggle pix-menu-link-toggle" aria-expanded="' . esc_attr($toggle_state) . '" aria-controls="' . esc_attr($submenu_id) . '">';
				$item_output .= isset($args->link_before) ? $args->link_before : '';
				$item_output .= $menu_item_icon_out . '<span class="pix-menu-link-label">' . do_shortcode($title) . '</span>';
				$item_output .= $this->get_submenu_toggle_icon_output();
				$item_output .= isset($args->link_after) ? $args->link_after : '';
				$item_output .= '</button>';
			} else {
				$item_output .= '<a' . $attributes . '>';
				$item_output .= isset($args->link_before) ? $args->link_before : '';
				$item_output .= $menu_item_icon_out . '<span class="pix-menu-link-label">' . do_shortcode($title) . '</span>';
				$item_output .= isset($args->link_after) ? $args->link_after : '';
				$item_output .= '</a>';

				if ($has_children && $this->layout === 'vertical') {
					$submenu_id = $this->get_submenu_id($item->ID);
					$toggle_state = $should_open_submenu ? 'true' : 'false';

					$item_output .= '<button type="button" class="pix-menu-submenu-toggle" aria-expanded="' . esc_attr($toggle_state) . '" aria-controls="' . esc_attr($submenu_id) . '">';
					$item_output .= '<span class="screen-reader-text">' . esc_html__('Toggle submenu', 'pixfort-core') . '</span>';
					$item_output .= $this->get_submenu_toggle_icon_output();
					$item_output .= '</button>';
				}
			}

			$item_output .= '</div>';
			$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

			$this->submenu_parent_item_id = (int) $item->ID;
			$this->submenu_should_be_open = $should_open_submenu;
		}

		public function end_el(&$output, $item, $depth = 0, $args = null) {
			$output .= "</li>\n";
			$this->submenu_parent_item_id = 0;
			$this->submenu_should_be_open = false;
		}
	}
}
