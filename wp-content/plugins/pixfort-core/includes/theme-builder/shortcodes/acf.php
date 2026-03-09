<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('ACF')) {
	return;
}

if (!function_exists('pixfort_acf_dynamic_value_provider')) {
	function pixfort_acf_dynamic_value_provider() {
		static $provider;

		if (!$provider) {
			$provider = new ACF_Dynamic_Value_Provider();
		}

		return $provider;
	}
}

if (!function_exists('pixfort_acf_get_field_data')) {
	function pixfort_acf_get_field_data($key) {
		if (empty($key)) {
			return [];
		}

		return pixfort_acf_dynamic_value_provider()->get_value($key);
	}
}

if (!function_exists('pixfort_acf_get_queried_object_meta')) {
	function pixfort_acf_get_queried_object_meta($meta_key) {
		$value = '';
		if (is_singular()) {
			$value = get_post_meta(get_the_ID(), $meta_key, true);
		} elseif (is_tax() || is_category() || is_tag()) {
			$value = get_term_meta(get_queried_object_id(), $meta_key, true);
		}

		return $value;
	}
}

if (!function_exists('pixfort_dynamic_acf_text_shortcode')) {
	function pixfort_dynamic_acf_text_shortcode($atts = []) {
		$atts = shortcode_atts(
			[
				'key' => '',
			],
			$atts
		);

		$field_data = pixfort_acf_get_field_data($atts['key']);
		if (empty($field_data) || !is_array($field_data) || count($field_data) < 2) {
			return '';
		}

		list($field, $meta_key) = $field_data;

		if ($field && !empty($field['type'])) {
			$value = $field['value'];

			switch ($field['type']) {
				case 'radio':
					if (isset($field['choices'][$value])) {
						$value = $field['choices'][$value];
					}
					break;
				case 'select':
					$values = (array) $value;
					foreach ($values as $key => $item) {
						if (isset($field['choices'][$item])) {
							$values[$key] = $field['choices'][$item];
						}
					}
					$value = implode(', ', $values);
					break;
				case 'checkbox':
					$value = (array) $value;
					$values = [];
					foreach ($value as $item) {
						if (isset($field['choices'][$item])) {
							$values[] = $field['choices'][$item];
						} else {
							$values[] = $item;
						}
					}
					$value = implode(', ', $values);
					break;
				case 'oembed':
					$value = pixfort_acf_get_queried_object_meta($meta_key);
					break;
				case 'google_map':
					$meta = pixfort_acf_get_queried_object_meta($meta_key);
					$value = isset($meta['address']) ? $meta['address'] : '';
					break;
				case 'true_false':
					$value = (string) $value;
					break;
			}
		} else {
			$value = get_field($meta_key);
		}

		if (!is_string($value)) {
			$type = gettype($value);
			wp_trigger_error('acf-text', "ACF Text Field value must be string, but is type of: $type", E_USER_WARNING);
			return '';
		}

		return wp_kses_post($value);
	}
}

if (!function_exists('pixfort_dynamic_acf_image_shortcode')) {
	function pixfort_dynamic_acf_image_shortcode($atts = []) {
		$atts = shortcode_atts(
			[
				'key' => '',
				'fallback' => '',
				'fallback_id' => '',
				'fallback_url' => '',
			],
			$atts
		);

		$image_data = [
			'id' => null,
			'url' => '',
		];

		$field_data = pixfort_acf_get_field_data($atts['key']);
		if (empty($field_data) || !is_array($field_data) || count($field_data) < 2) {
			return '';
		}

		list($field, $meta_key) = $field_data;

		if ($field && is_array($field)) {
			$field['return_format'] = isset($field['save_format']) ? $field['save_format'] : $field['return_format'];

			switch ($field['return_format']) {
				case 'object':
				case 'array':
					$value = $field['value'];
					break;
				case 'url':
					$value = [
						'id' => 0,
						'url' => $field['value'],
					];
					break;
				case 'id':
					$src = wp_get_attachment_image_src($field['value'], $field['preview_size']);
					$value = [
						'id' => $field['value'],
						'url' => $src[0],
					];
					break;
			}
		}

		if (!isset($value)) {
			$value = get_field($meta_key);
		}

		if (empty($value)) {
			$fallback_url = pixfort_dynamic_get_fallback_url(
				$atts['fallback_id'],
				$atts['fallback_url'] ? $atts['fallback_url'] : $atts['fallback']
			);

			return $fallback_url ? esc_url($fallback_url) : '';
		}

		if (!empty($value) && is_array($value)) {
			$image_data['id'] = $value['id'];
			$image_data['url'] = $value['url'];
		}

		return !empty($image_data['url']) ? esc_url($image_data['url']) : '';
	}
}

if (!function_exists('pixfort_dynamic_acf_url_shortcode')) {
	function pixfort_dynamic_acf_url_shortcode($atts = []) {
		$atts = shortcode_atts(
			[
				'key' => '',
				'fallback' => '',
			],
			$atts
		);

		$field_data = pixfort_acf_get_field_data($atts['key']);
		if (empty($field_data) || !is_array($field_data) || count($field_data) < 2) {
			return '';
		}

		list($field, $meta_key) = $field_data;

		if ($field) {
			$value = $field['value'];

			if (is_array($value) && isset($value[0])) {
				$value = $value[0];
			}

			if ($value) {
				if (!isset($field['return_format'])) {
					$field['return_format'] = isset($field['save_format']) ? $field['save_format'] : '';
				}

				switch ($field['type']) {
					case 'email':
						if ($value) {
							$value = 'mailto:' . $value;
						}
						break;
					case 'image':
					case 'file':
						switch ($field['return_format']) {
							case 'array':
							case 'object':
								$value = $value['url'];
								break;
							case 'id':
								if ('image' === $field['type']) {
									$src = wp_get_attachment_image_src($value, 'full');
									$value = $src[0];
								} else {
									$value = wp_get_attachment_url($value);
								}
								break;
						}
						break;
					case 'post_object':
					case 'relationship':
						$value = get_permalink($value);
						break;
					case 'taxonomy':
						$value = get_term_link($value, $field['taxonomy']);
						if (is_wp_error($value)) {
							$value = '';
						}
						break;
				}
			}
		} else {
			$value = get_field($meta_key);
		}

		if (empty($value) && !empty($atts['fallback'])) {
			$value = $atts['fallback'];
		}

		return wp_kses_post($value);
	}
}

if (!function_exists('pixfort_dynamic_acf_gallery_shortcode')) {
	function pixfort_dynamic_acf_gallery_shortcode($atts = []) {
		$atts = shortcode_atts(
			[
				'key' => '',
			],
			$atts
		);

		$field_data = pixfort_acf_get_field_data($atts['key']);
		if (empty($field_data) || !is_array($field_data) || count($field_data) < 2) {
			return '';
		}

		list($field, $meta_key) = $field_data;

		if ($field) {
			$value = $field['value'];
		} else {
			$value = get_field($meta_key);
		}

		$ids = [];
		if (is_array($value) && !empty($value)) {
			foreach ($value as $image) {
				if (isset($image['ID'])) {
					$ids[] = $image['ID'];
				}
			}
		}

		return !empty($ids) ? implode(',', $ids) : '';
	}
}

if (!function_exists('pixfort_dynamic_acf_file_shortcode')) {
	function pixfort_dynamic_acf_file_shortcode($atts = []) {
		return pixfort_dynamic_acf_image_shortcode($atts);
	}
}

if (!function_exists('pixfort_dynamic_acf_number_shortcode')) {
	function pixfort_dynamic_acf_number_shortcode($atts = []) {
		$atts = shortcode_atts(
			[
				'key' => '',
			],
			$atts
		);

		$field_data = pixfort_acf_get_field_data($atts['key']);
		if (empty($field_data) || !is_array($field_data) || count($field_data) < 2) {
			return '';
		}

		list($field, $meta_key) = $field_data;

		if ($field && !empty($field['type'])) {
			$value = $field['value'];
		} else {
			$value = get_field($meta_key);
		}

		return wp_kses_post($value);
	}
}

if (!function_exists('pixfort_dynamic_acf_color_shortcode')) {
	function pixfort_dynamic_acf_color_shortcode($atts = []) {
		$atts = shortcode_atts(
			[
				'key' => '',
				'fallback' => '',
			],
			$atts
		);

		$field_data = pixfort_acf_get_field_data($atts['key']);
		if (empty($field_data) || !is_array($field_data) || count($field_data) < 2) {
			return '';
		}

		list($field, $meta_key) = $field_data;

		if ($field) {
			$value = $field['value'];
		} else {
			$value = get_field($meta_key);
		}

		if (empty($value) && !empty($atts['fallback'])) {
			$value = $atts['fallback'];
		}

		return $value;
	}
}

if (!function_exists('pixfort_dynamic_acf_date_time_shortcode')) {
	function pixfort_dynamic_acf_date_time_shortcode($atts = []) {
		$atts = shortcode_atts(
			[
				'key' => '',
				'fallback' => '',
			],
			$atts
		);

		$field_data = pixfort_acf_get_field_data($atts['key']);
		if (empty($field_data) || !is_array($field_data) || count($field_data) < 1) {
			return '';
		}

		$field = $field_data[0];
		$value = '';

		if ($field) {
			$date_time = DateTime::createFromFormat($field['return_format'], $field['value']);
			$value = $date_time instanceof DateTime ? $date_time->format('Y-m-d H:i:s') : '';
		}

		if (empty($value) && !empty($atts['fallback'])) {
			$value = $atts['fallback'];
		}

		return wp_kses_post($value);
	}
}
