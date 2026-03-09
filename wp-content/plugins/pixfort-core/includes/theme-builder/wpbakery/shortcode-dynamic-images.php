<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Pixfort_WPBakery_Dynamic_Images')) {
	class Pixfort_WPBakery_Dynamic_Images {
		private static $dynamic_wpb_image_shortcodes = array(
			'alertblock',
			'fancy_box',
			'heading',
			'pix_3d_box',
			'pix_auto_video',
			'pix_card',
			'pix_card_wide',
			'pix_content_stack',
			'pix_fancy_mockup',
			'pix_feature',
			'pix_highlight_box',
			'pix_highlighted_text',
			'pix_icon',
			'pix_img',
			'pix_img_box',
			'pix_map',
			'pix_photo_box',
			'pix_promo_box',
			'pix_review',
			'pix_shop_category',
			'pix_story',
			'pix_team_member',
			'pix_team_member_circle',
			'pix_testimonial',
			'pix_video',
		);

		private static function is_wpbakery_available() {
			return class_exists('Vc_Manager') || defined('WPB_VC_VERSION') || function_exists('vc_map');
		}

		public static function init() {
			if (!self::is_wpbakery_available()) {
				return;
			}
			add_filter('pre_do_shortcode_tag', [__CLASS__, 'apply_dynamic_shortcode_images'], 9, 4);
		}

		private static function resolve_dynamic_wpb_image_attributes($attributes = array()) {
			if (empty($attributes) || !is_array($attributes)) {
				return $attributes;
			}
			if (!\PixfortCore::instance()->getThemeParam('dynamic_wpb_images') || !class_exists('Pixfort_Dynamic_Shortcode')) {
				return $attributes;
			}

			$supported_params = array('image', 'bg_img', 'poster', 'feature_image', 'marker');
			$resolved = $attributes;

			foreach ($attributes as $key => $value) {
				if (strpos($key, 'dynamic_') !== 0 || empty($value)) {
					continue;
				}
				$image_param = substr($key, 8);
				if (empty($image_param) || !in_array($image_param, $supported_params, true)) {
					continue;
				}
				$dynamic_src = Pixfort_Dynamic_Shortcode::instance()->render_dynamic_image($value);
				if (!empty($dynamic_src)) {
					$resolved[$image_param] = $dynamic_src;
				}
			}

			return $resolved;
		}

		public static function apply_dynamic_shortcode_images($output, $tag, $attr, $m) {
			if (false !== $output || empty($attr) || !is_array($attr)) {
				return $output;
			}
			if (!in_array($tag, self::$dynamic_wpb_image_shortcodes, true)) {
				return $output;
			}

			$resolved_attr = self::resolve_dynamic_wpb_image_attributes($attr);
			if ($resolved_attr === $attr) {
				return $output;
			}

			global $shortcode_tags;
			if (empty($shortcode_tags[$tag]) || !is_callable($shortcode_tags[$tag])) {
				return $output;
			}

			$content = isset($m[5]) ? $m[5] : null;
			$shortcode_output = call_user_func($shortcode_tags[$tag], $resolved_attr, $content, $tag);
			$shortcode_output = $m[1] . $shortcode_output . $m[6];

			return apply_filters('do_shortcode_tag', $shortcode_output, $tag, $resolved_attr, $m);
		}
	}

	Pixfort_WPBakery_Dynamic_Images::init();
}

