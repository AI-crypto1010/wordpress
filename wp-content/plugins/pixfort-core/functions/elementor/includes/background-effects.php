<?php

if (!defined('ABSPATH')) exit;

function pix_get_background_effect_presets() {
	return [
		'dot-orbit' => [
			'label' => __('Dot Orbit', 'pixfort-core'),
			'defaults' => [
				'z_index' => -1,
				'speed' => 1.2,
				'color1' => '#6EE7FF',
				'color2' => '#A78BFA',
				'color_back' => '#05070d',
				'size' => 0.26,
				'size_range' => 0.25,
				'spreading' => 0.45,
				'steps' => 2,
			],
		],
		'fluted-glass' => [
			'label' => __('Fluted Glass', 'pixfort-core'),
			'defaults' => [
				'z_index' => -1,
				'image_url' => '',
				'size' => 0.35,
				'distortion' => 0.35,
				'blur' => 0.14,
				'angle' => 35,
				'shadows' => 0.45,
				'highlights' => 0.7,
				'stretch' => 0.25,
				'shift' => 0.05,
				'edges' => 0.55,
				'color_back' => '#0b0d12',
				'color_shadow' => '#000000',
				'color_highlight' => '#ffffff',
				'shape' => 'lines',
				'distortion_shape' => 'prism',
			],
		],
		'heatmap' => [
			'label' => __('Heatmap', 'pixfort-core'),
			'defaults' => [
				'z_index' => -1,
				'image_url' => '',
				'speed' => 1,
				'angle' => 45,
				'noise' => 0.2,
				'contour' => 0.4,
				'inner_glow' => 0.65,
				'outer_glow' => 0.45,
				'color_back' => '#07080e',
				'color1' => '#60A5FA',
				'color2' => '#A855F7',
				'color3' => '#FB7185',
			],
		],
		'liquid-metal' => [
			'label' => __('Liquid Metal', 'pixfort-core'),
			'defaults' => [
				'z_index' => -1,
				'image_url' => '',
				'speed' => 1.1,
				'repetition' => 4,
				'distortion' => 0.45,
				'contour' => 0.55,
				'softness' => 0.45,
				'angle' => 35,
				'shift_red' => 0.08,
				'shift_blue' => -0.08,
				'color_back' => '#02040a',
				'color_tint' => '#7dd3fc',
				'shape' => 'metaballs',
			],
		],
		'mesh-gradient' => [
			'label' => __('Mesh Gradient', 'pixfort-core'),
			'defaults' => [
				'z_index' => -1,
				'speed' => 1,
				'color_count' => 4,
				'color1' => '#e0eaff',
				'color2' => '#241d9a',
				'color3' => '#f75092',
				'color4' => '#9f50d3',
				'distortion' => 0.8,
				'swirl' => 0.1,
				'grain_mixer' => 0,
				'grain_overlay' => 0,
				'scale' => 1,
				'rotation' => 0,
				'offset_x' => 0,
				'offset_y' => 0,
			],
		],
	];
}

function pix_bg_effect_get_color_groups() {
	static $groups = null;
	if ($groups !== null) {
		return $groups;
	}

	$groups = \PixfortCore::instance()->coreFunctions->getColorsArray([
		'gradients' => false,
	]);

	return $groups;
}

function pix_bg_effect_get_color_values() {
	static $values = null;
	if ($values !== null) {
		return $values;
	}

	$values = [];
	$groups = pix_bg_effect_get_color_groups();
	if (is_array($groups)) {
		foreach ($groups as $group) {
			if (empty($group['options']) || !is_array($group['options'])) continue;
			foreach ($group['options'] as $value => $label) {
				$values[] = (string)$value;
			}
		}
	}

	return $values;
}

function pix_bg_effect_extract_numeric_value($value) {
	if (is_array($value) && isset($value['size']) && is_numeric($value['size'])) {
		return (float)$value['size'];
	}
	if (is_numeric($value)) {
		return (float)$value;
	}
	return null;
}

function pix_bg_effect_has_numeric_value($value) {
	return pix_bg_effect_extract_numeric_value($value) !== null;
}

function pix_bg_effect_float($value, $default, $min, $max) {
	$numeric = pix_bg_effect_extract_numeric_value($value);
	if ($numeric === null) {
		return $default;
	}
	$out = (float)$numeric;
	if ($out < $min) return $min;
	if ($out > $max) return $max;
	return $out;
}

function pix_bg_effect_int($value, $default, $min, $max) {
	$numeric = pix_bg_effect_extract_numeric_value($value);
	if ($numeric === null) {
		return $default;
	}
	$out = (int)$numeric;
	if ($out < $min) return $min;
	if ($out > $max) return $max;
	return $out;
}

function pix_bg_effect_color($value, $default) {
	if (!is_string($value)) {
		return $default;
	}

	$value = trim($value);
	if ($value === '') {
		return $default;
	}

	$hex = sanitize_hex_color($value);
	if (!empty($hex)) {
		return $hex;
	}

	if (preg_match('/^rgba?\([^\)]+\)$/i', $value) || preg_match('/^hsla?\([^\)]+\)$/i', $value)) {
		return $value;
	}

	return $default;
}

function pix_bg_effect_parse_color_value($value, $default) {
	if (!is_scalar($value)) {
		return $default;
	}

	$raw = trim((string)$value);
	if ($raw === '') {
		return $default;
	}

	$token = sanitize_key($raw);
	$allowed_values = pix_bg_effect_get_color_values();
	if (!empty($token) && $token !== 'custom' && in_array($token, $allowed_values, true)) {
		return $token;
	}

	return pix_bg_effect_color($raw, $default);
}

function pix_bg_effect_select($value, $allowed, $default) {
	if (in_array($value, $allowed, true)) {
		return $value;
	}
	return $default;
}

function pix_bg_effect_image_url($value) {
	if (is_array($value) && !empty($value['url'])) {
		$url = esc_url_raw($value['url']);
		return !empty($url) ? $url : '';
	}

	if (is_string($value)) {
		$url = esc_url_raw($value);
		return !empty($url) ? $url : '';
	}

	return '';
}

function pix_bg_effect_condition($effects = null) {
	$condition = [
		'pix_background_effect_options_popover' => 'yes',
	];

	if (!empty($effects)) {
		$condition['pix_background_effect'] = $effects;
	}

	return $condition;
}

function pix_bg_effect_add_control($element, $id, $args, $shared_args = []) {
	$element->add_control($id, array_merge($args, $shared_args));
}

function pix_bg_effect_add_slider_control($element, $id, $label, $default, $min, $max, $step, $condition, $shared_args = []) {
	pix_bg_effect_add_control(
		$element,
		$id,
		[
			'label' => $label,
			'type' => \Elementor\Controls_Manager::SLIDER,
			'size_units' => ['px'],
			'range' => [
				'px' => [
					'min' => $min,
					'max' => $max,
					'step' => $step,
				],
			],
			'default' => [
				'unit' => 'px',
				'size' => $default,
			],
			'condition' => $condition,
		],
		$shared_args
	);
}

function pix_bg_effect_add_color_controls($element, $id, $label, $default_custom, $condition, $shared_args = []) {
	pix_bg_effect_add_control(
		$element,
		$id,
		[
			'label' => $label,
			'type' => \Elementor\Controls_Manager::SELECT,
			'groups' => pix_bg_effect_get_color_groups(),
			'default' => '',
			'condition' => $condition,
		],
		$shared_args
	);

	$custom_condition = $condition;
	$custom_condition[$id] = 'custom';

	pix_bg_effect_add_control(
		$element,
		$id . '_custom',
		[
			'label' => sprintf(__('Custom %s', 'pixfort-core'), $label),
			'type' => \Elementor\Controls_Manager::COLOR,
			'default' => $default_custom,
			'condition' => $custom_condition,
		],
		$shared_args
	);
}

function pix_bg_effect_read_color_setting($settings, $id, $default) {
	$raw = '';
	if (isset($settings[$id]) && is_scalar($settings[$id])) {
		$raw = trim((string)$settings[$id]);
	}
	$selected = sanitize_key($raw);

	if ($selected === '' || $selected === 'custom') {
		$custom_value = $settings[$id . '_custom'] ?? '';
		return pix_bg_effect_parse_color_value($custom_value, $default);
	}

	$allowed_values = pix_bg_effect_get_color_values();
	if (in_array($selected, $allowed_values, true)) {
		return $selected;
	}

	// Backward compatibility: older versions stored direct color value in the same field.
	return pix_bg_effect_parse_color_value($raw, $default);
}

function pix_bg_effect_read_image_setting($settings, $common_key, $legacy_keys = [], $default = '') {
	$image_url = pix_bg_effect_image_url($settings[$common_key] ?? '');
	if (!empty($image_url)) {
		return $image_url;
	}

	foreach ($legacy_keys as $legacy_key) {
		$image_url = pix_bg_effect_image_url($settings[$legacy_key] ?? '');
		if (!empty($image_url)) {
			return $image_url;
		}
	}

	return $default;
}

function pixGetElementorBackgroundEffectsControls($element, $hide_in_top = false) {
	$presets = pix_get_background_effect_presets();

	$effect_options = [
		'' => __('None', 'pixfort-core'),
	];
	foreach ($presets as $effect_id => $preset) {
		$effect_options[$effect_id] = $preset['label'];
	}

	$shared_args = [];
	if ($hide_in_top) {
		$shared_args['hide_in_top'] = true;
	}

	pix_bg_effect_add_control(
		$element,
		'pix_background_effect',
		[
			'label' => __('Background Effect', 'pixfort-core'),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => '',
			'options' => $effect_options,
			'frontend_available' => true,
		],
		$shared_args
	);

	pix_bg_effect_add_control(
		$element,
		'pix_background_effect_options_popover',
		[
			'label' => esc_html__('Background Effect Options', 'pixfort-core'),
			'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
			'label_off' => esc_html__('Default', 'pixfort-core'),
			'label_on' => esc_html__('Custom', 'pixfort-core'),
			'return_value' => 'yes',
			'default' => '',
			'condition' => [
				'pix_background_effect!' => '',
			],
		],
		$shared_args
	);

	$element->start_popover();

	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_effect_z_index',
		__('Layer Z-Index', 'pixfort-core'),
		-1,
		-999,
		999,
		1,
		pix_bg_effect_condition(),
		$shared_args
	);

	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_effect_speed',
		__('Speed', 'pixfort-core'),
		1,
		0.1,
		4,
		0.05,
		pix_bg_effect_condition(['dot-orbit', 'heatmap', 'liquid-metal', 'mesh-gradient']),
		$shared_args
	);

	pix_bg_effect_add_control(
		$element,
		'pix_bg_effect_image',
		[
			'label' => __('Image', 'pixfort-core'),
			'type' => \Elementor\Controls_Manager::MEDIA,
			'media_types' => ['image'],
			'condition' => pix_bg_effect_condition(['fluted-glass', 'heatmap', 'liquid-metal']),
		],
		$shared_args
	);

	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_effect_angle',
		__('Angle', 'pixfort-core'),
		45,
		0,
		360,
		1,
		pix_bg_effect_condition(['fluted-glass', 'heatmap', 'liquid-metal']),
		$shared_args
	);

	pix_bg_effect_add_color_controls(
		$element,
		'pix_bg_effect_color_back',
		__('Background Color', 'pixfort-core'),
		'',
		pix_bg_effect_condition(['dot-orbit', 'fluted-glass', 'heatmap', 'liquid-metal']),
		$shared_args
	);

	pix_bg_effect_add_color_controls(
		$element,
		'pix_bg_dot_color_1',
		__('Color 1', 'pixfort-core'),
		'',
		pix_bg_effect_condition('dot-orbit'),
		$shared_args
	);
	pix_bg_effect_add_color_controls(
		$element,
		'pix_bg_dot_color_2',
		__('Color 2', 'pixfort-core'),
		'',
		pix_bg_effect_condition('dot-orbit'),
		$shared_args
	);

	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_dot_size',
		__('Dot Size', 'pixfort-core'),
		$presets['dot-orbit']['defaults']['size'],
		0.05,
		1,
		0.01,
		pix_bg_effect_condition('dot-orbit'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_dot_spreading',
		__('Spreading', 'pixfort-core'),
		$presets['dot-orbit']['defaults']['spreading'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('dot-orbit'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_dot_size_range',
		__('Size Variation', 'pixfort-core'),
		$presets['dot-orbit']['defaults']['size_range'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('dot-orbit'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_dot_steps',
		__('Color Steps', 'pixfort-core'),
		$presets['dot-orbit']['defaults']['steps'],
		1,
		4,
		1,
		pix_bg_effect_condition('dot-orbit'),
		$shared_args
	);

	pix_bg_effect_add_control(
		$element,
		'pix_bg_fluted_shape',
		[
			'label' => __('Line Shape', 'pixfort-core'),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => $presets['fluted-glass']['defaults']['shape'],
			'options' => [
				'lines' => __('Lines', 'pixfort-core'),
				'linesIrregular' => __('Irregular Lines', 'pixfort-core'),
				'wave' => __('Wave', 'pixfort-core'),
				'zigzag' => __('Zigzag', 'pixfort-core'),
				'pattern' => __('Pattern', 'pixfort-core'),
			],
			'condition' => pix_bg_effect_condition('fluted-glass'),
		],
		$shared_args
	);
	pix_bg_effect_add_control(
		$element,
		'pix_bg_fluted_distortion_shape',
		[
			'label' => __('Distortion Shape', 'pixfort-core'),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => $presets['fluted-glass']['defaults']['distortion_shape'],
			'options' => [
				'prism' => __('Prism', 'pixfort-core'),
				'lens' => __('Lens', 'pixfort-core'),
				'contour' => __('Contour', 'pixfort-core'),
				'cascade' => __('Cascade', 'pixfort-core'),
				'flat' => __('Flat', 'pixfort-core'),
			],
			'condition' => pix_bg_effect_condition('fluted-glass'),
		],
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_fluted_size',
		__('Size', 'pixfort-core'),
		$presets['fluted-glass']['defaults']['size'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('fluted-glass'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_fluted_distortion',
		__('Distortion', 'pixfort-core'),
		$presets['fluted-glass']['defaults']['distortion'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('fluted-glass'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_fluted_blur',
		__('Blur', 'pixfort-core'),
		$presets['fluted-glass']['defaults']['blur'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('fluted-glass'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_fluted_highlights',
		__('Highlights', 'pixfort-core'),
		$presets['fluted-glass']['defaults']['highlights'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('fluted-glass'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_fluted_shadows',
		__('Shadows', 'pixfort-core'),
		$presets['fluted-glass']['defaults']['shadows'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('fluted-glass'),
		$shared_args
	);
	pix_bg_effect_add_color_controls(
		$element,
		'pix_bg_fluted_color_shadow',
		__('Shadow Color', 'pixfort-core'),
		'',
		pix_bg_effect_condition('fluted-glass'),
		$shared_args
	);
	pix_bg_effect_add_color_controls(
		$element,
		'pix_bg_fluted_color_highlight',
		__('Highlight Color', 'pixfort-core'),
		'',
		pix_bg_effect_condition('fluted-glass'),
		$shared_args
	);

	pix_bg_effect_add_color_controls(
		$element,
		'pix_bg_heatmap_color_1',
		__('Color 1', 'pixfort-core'),
		'',
		pix_bg_effect_condition('heatmap'),
		$shared_args
	);
	pix_bg_effect_add_color_controls(
		$element,
		'pix_bg_heatmap_color_2',
		__('Color 2', 'pixfort-core'),
		'',
		pix_bg_effect_condition('heatmap'),
		$shared_args
	);
	pix_bg_effect_add_color_controls(
		$element,
		'pix_bg_heatmap_color_3',
		__('Color 3', 'pixfort-core'),
		'',
		pix_bg_effect_condition('heatmap'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_heatmap_contour',
		__('Contour', 'pixfort-core'),
		$presets['heatmap']['defaults']['contour'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('heatmap'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_heatmap_inner_glow',
		__('Inner Glow', 'pixfort-core'),
		$presets['heatmap']['defaults']['inner_glow'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('heatmap'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_heatmap_outer_glow',
		__('Outer Glow', 'pixfort-core'),
		$presets['heatmap']['defaults']['outer_glow'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('heatmap'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_heatmap_noise',
		__('Noise', 'pixfort-core'),
		$presets['heatmap']['defaults']['noise'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('heatmap'),
		$shared_args
	);

	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_mesh_color_count',
		__('Color Count', 'pixfort-core'),
		$presets['mesh-gradient']['defaults']['color_count'],
		1,
		4,
		1,
		pix_bg_effect_condition('mesh-gradient'),
		$shared_args
	);
	pix_bg_effect_add_color_controls(
		$element,
		'pix_bg_mesh_color_1',
		__('Color 1', 'pixfort-core'),
		'',
		pix_bg_effect_condition('mesh-gradient'),
		$shared_args
	);
	pix_bg_effect_add_color_controls(
		$element,
		'pix_bg_mesh_color_2',
		__('Color 2', 'pixfort-core'),
		'',
		pix_bg_effect_condition('mesh-gradient'),
		$shared_args
	);
	pix_bg_effect_add_color_controls(
		$element,
		'pix_bg_mesh_color_3',
		__('Color 3', 'pixfort-core'),
		'',
		pix_bg_effect_condition('mesh-gradient'),
		$shared_args
	);
	pix_bg_effect_add_color_controls(
		$element,
		'pix_bg_mesh_color_4',
		__('Color 4', 'pixfort-core'),
		'',
		pix_bg_effect_condition('mesh-gradient'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_mesh_distortion',
		__('Distortion', 'pixfort-core'),
		$presets['mesh-gradient']['defaults']['distortion'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('mesh-gradient'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_mesh_swirl',
		__('Swirl', 'pixfort-core'),
		$presets['mesh-gradient']['defaults']['swirl'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('mesh-gradient'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_mesh_grain_mixer',
		__('Grain Mixer', 'pixfort-core'),
		$presets['mesh-gradient']['defaults']['grain_mixer'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('mesh-gradient'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_mesh_grain_overlay',
		__('Grain Overlay', 'pixfort-core'),
		$presets['mesh-gradient']['defaults']['grain_overlay'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('mesh-gradient'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_mesh_scale',
		__('Scale', 'pixfort-core'),
		$presets['mesh-gradient']['defaults']['scale'],
		0.1,
		4,
		0.01,
		pix_bg_effect_condition('mesh-gradient'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_mesh_rotation',
		__('Rotation', 'pixfort-core'),
		$presets['mesh-gradient']['defaults']['rotation'],
		-360,
		360,
		1,
		pix_bg_effect_condition('mesh-gradient'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_mesh_offset_x',
		__('Offset X', 'pixfort-core'),
		$presets['mesh-gradient']['defaults']['offset_x'],
		-1,
		1,
		0.01,
		pix_bg_effect_condition('mesh-gradient'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_mesh_offset_y',
		__('Offset Y', 'pixfort-core'),
		$presets['mesh-gradient']['defaults']['offset_y'],
		-1,
		1,
		0.01,
		pix_bg_effect_condition('mesh-gradient'),
		$shared_args
	);

	pix_bg_effect_add_control(
		$element,
		'pix_bg_liquid_shape',
		[
			'label' => __('Shape', 'pixfort-core'),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => $presets['liquid-metal']['defaults']['shape'],
			'options' => [
				'none' => __('None', 'pixfort-core'),
				'circle' => __('Circle', 'pixfort-core'),
				'daisy' => __('Daisy', 'pixfort-core'),
				'diamond' => __('Diamond', 'pixfort-core'),
				'metaballs' => __('Metaballs', 'pixfort-core'),
			],
			'condition' => pix_bg_effect_condition('liquid-metal'),
		],
		$shared_args
	);
	pix_bg_effect_add_color_controls(
		$element,
		'pix_bg_liquid_color_tint',
		__('Tint Color', 'pixfort-core'),
		'',
		pix_bg_effect_condition('liquid-metal'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_liquid_repetition',
		__('Repetition', 'pixfort-core'),
		$presets['liquid-metal']['defaults']['repetition'],
		1,
		10,
		0.1,
		pix_bg_effect_condition('liquid-metal'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_liquid_distortion',
		__('Distortion', 'pixfort-core'),
		$presets['liquid-metal']['defaults']['distortion'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('liquid-metal'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_liquid_contour',
		__('Contour', 'pixfort-core'),
		$presets['liquid-metal']['defaults']['contour'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('liquid-metal'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_liquid_softness',
		__('Softness', 'pixfort-core'),
		$presets['liquid-metal']['defaults']['softness'],
		0,
		1,
		0.01,
		pix_bg_effect_condition('liquid-metal'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_liquid_shift_red',
		__('Shift Red', 'pixfort-core'),
		$presets['liquid-metal']['defaults']['shift_red'],
		-1,
		1,
		0.01,
		pix_bg_effect_condition('liquid-metal'),
		$shared_args
	);
	pix_bg_effect_add_slider_control(
		$element,
		'pix_bg_liquid_shift_blue',
		__('Shift Blue', 'pixfort-core'),
		$presets['liquid-metal']['defaults']['shift_blue'],
		-1,
		1,
		0.01,
		pix_bg_effect_condition('liquid-metal'),
		$shared_args
	);

	$element->end_popover();
}

function pixGetElementorBackgroundEffectData($settings) {
	if (!is_array($settings)) {
		return null;
	}

	$effect = '';
	if (!empty($settings['pix_background_effect'])) {
		$effect = sanitize_key($settings['pix_background_effect']);
	}
	if (empty($effect)) {
		return null;
	}

	$presets = pix_get_background_effect_presets();
	if (empty($presets[$effect])) {
		return null;
	}

	$options = $presets[$effect]['defaults'];
	$use_custom_options = !empty($settings['pix_background_effect_options_popover']) && 'yes' === $settings['pix_background_effect_options_popover'];

	if (!$use_custom_options) {
		return [
			'effect' => $effect,
			'options' => $options,
		];
	}

	$options['z_index'] = pix_bg_effect_float($settings['pix_bg_effect_z_index'] ?? $options['z_index'], $options['z_index'], -999, 999);

	if (array_key_exists('color_back', $options)) {
		$options['color_back'] = pix_bg_effect_read_color_setting($settings, 'pix_bg_effect_color_back', $options['color_back']);

		$legacy_color_back_key = '';
		if ($effect === 'dot-orbit') {
			$legacy_color_back_key = 'pix_bg_dot_color_back';
		} elseif ($effect === 'fluted-glass') {
			$legacy_color_back_key = 'pix_bg_fluted_color_back';
		} elseif ($effect === 'heatmap') {
			$legacy_color_back_key = 'pix_bg_heatmap_color_back';
		} elseif ($effect === 'liquid-metal') {
			$legacy_color_back_key = 'pix_bg_liquid_color_back';
		}

		if ($options['color_back'] === $presets[$effect]['defaults']['color_back'] && !empty($legacy_color_back_key) && isset($settings[$legacy_color_back_key])) {
			$options['color_back'] = pix_bg_effect_parse_color_value($settings[$legacy_color_back_key], $options['color_back']);
		}
	}

	if (in_array($effect, ['dot-orbit', 'heatmap', 'liquid-metal', 'mesh-gradient'], true)) {
		$options['speed'] = pix_bg_effect_float($settings['pix_bg_effect_speed'] ?? $options['speed'], $options['speed'], 0.1, 4);
	}

	if (in_array($effect, ['fluted-glass', 'heatmap', 'liquid-metal'], true)) {
		$image_legacy_key = '';
		$angle_legacy_key = '';
		if ($effect === 'fluted-glass') {
			$image_legacy_key = 'pix_bg_fluted_image';
			$angle_legacy_key = 'pix_bg_fluted_angle';
		} elseif ($effect === 'heatmap') {
			$image_legacy_key = 'pix_bg_heatmap_image';
			$angle_legacy_key = 'pix_bg_heatmap_angle';
		} elseif ($effect === 'liquid-metal') {
			$image_legacy_key = 'pix_bg_liquid_image';
			$angle_legacy_key = 'pix_bg_liquid_angle';
		}

		$options['image_url'] = pix_bg_effect_read_image_setting(
			$settings,
			'pix_bg_effect_image',
			!empty($image_legacy_key) ? [$image_legacy_key] : [],
			$options['image_url']
		);

		$angle_raw = $settings['pix_bg_effect_angle'] ?? null;
		if (!pix_bg_effect_has_numeric_value($angle_raw) && !empty($angle_legacy_key)) {
			$angle_raw = $settings[$angle_legacy_key] ?? $options['angle'];
		}
		$options['angle'] = pix_bg_effect_float($angle_raw, $options['angle'], 0, 360);
	}

	if ($effect === 'dot-orbit') {
		$options['color1'] = pix_bg_effect_read_color_setting($settings, 'pix_bg_dot_color_1', $options['color1']);
		$options['color2'] = pix_bg_effect_read_color_setting($settings, 'pix_bg_dot_color_2', $options['color2']);
		$options['size'] = pix_bg_effect_float($settings['pix_bg_dot_size'] ?? $options['size'], $options['size'], 0.05, 1);
		$options['size_range'] = pix_bg_effect_float($settings['pix_bg_dot_size_range'] ?? $options['size_range'], $options['size_range'], 0, 1);
		$options['spreading'] = pix_bg_effect_float($settings['pix_bg_dot_spreading'] ?? $options['spreading'], $options['spreading'], 0, 1);
		$options['steps'] = pix_bg_effect_int($settings['pix_bg_dot_steps'] ?? $options['steps'], $options['steps'], 1, 4);
	}

	if ($effect === 'fluted-glass') {
		$options['shape'] = pix_bg_effect_select($settings['pix_bg_fluted_shape'] ?? $options['shape'], ['lines', 'linesIrregular', 'wave', 'zigzag', 'pattern'], $options['shape']);
		$options['distortion_shape'] = pix_bg_effect_select($settings['pix_bg_fluted_distortion_shape'] ?? $options['distortion_shape'], ['prism', 'lens', 'contour', 'cascade', 'flat'], $options['distortion_shape']);
		$options['size'] = pix_bg_effect_float($settings['pix_bg_fluted_size'] ?? $options['size'], $options['size'], 0, 1);
		$options['distortion'] = pix_bg_effect_float($settings['pix_bg_fluted_distortion'] ?? $options['distortion'], $options['distortion'], 0, 1);
		$options['blur'] = pix_bg_effect_float($settings['pix_bg_fluted_blur'] ?? $options['blur'], $options['blur'], 0, 1);
		$options['highlights'] = pix_bg_effect_float($settings['pix_bg_fluted_highlights'] ?? $options['highlights'], $options['highlights'], 0, 1);
		$options['shadows'] = pix_bg_effect_float($settings['pix_bg_fluted_shadows'] ?? $options['shadows'], $options['shadows'], 0, 1);
		$options['color_shadow'] = pix_bg_effect_read_color_setting($settings, 'pix_bg_fluted_color_shadow', $options['color_shadow']);
		$options['color_highlight'] = pix_bg_effect_read_color_setting($settings, 'pix_bg_fluted_color_highlight', $options['color_highlight']);
	}

	if ($effect === 'heatmap') {
		$options['color1'] = pix_bg_effect_read_color_setting($settings, 'pix_bg_heatmap_color_1', $options['color1']);
		$options['color2'] = pix_bg_effect_read_color_setting($settings, 'pix_bg_heatmap_color_2', $options['color2']);
		$options['color3'] = pix_bg_effect_read_color_setting($settings, 'pix_bg_heatmap_color_3', $options['color3']);
		$options['contour'] = pix_bg_effect_float($settings['pix_bg_heatmap_contour'] ?? $options['contour'], $options['contour'], 0, 1);
		$options['inner_glow'] = pix_bg_effect_float($settings['pix_bg_heatmap_inner_glow'] ?? $options['inner_glow'], $options['inner_glow'], 0, 1);
		$options['outer_glow'] = pix_bg_effect_float($settings['pix_bg_heatmap_outer_glow'] ?? $options['outer_glow'], $options['outer_glow'], 0, 1);
		$options['noise'] = pix_bg_effect_float($settings['pix_bg_heatmap_noise'] ?? $options['noise'], $options['noise'], 0, 1);
	}

	if ($effect === 'liquid-metal') {
		$options['shape'] = pix_bg_effect_select($settings['pix_bg_liquid_shape'] ?? $options['shape'], ['none', 'circle', 'daisy', 'diamond', 'metaballs'], $options['shape']);
		$options['color_tint'] = pix_bg_effect_read_color_setting($settings, 'pix_bg_liquid_color_tint', $options['color_tint']);
		$options['repetition'] = pix_bg_effect_float($settings['pix_bg_liquid_repetition'] ?? $options['repetition'], $options['repetition'], 1, 10);
		$options['distortion'] = pix_bg_effect_float($settings['pix_bg_liquid_distortion'] ?? $options['distortion'], $options['distortion'], 0, 1);
		$options['contour'] = pix_bg_effect_float($settings['pix_bg_liquid_contour'] ?? $options['contour'], $options['contour'], 0, 1);
		$options['softness'] = pix_bg_effect_float($settings['pix_bg_liquid_softness'] ?? $options['softness'], $options['softness'], 0, 1);
		$options['shift_red'] = pix_bg_effect_float($settings['pix_bg_liquid_shift_red'] ?? $options['shift_red'], $options['shift_red'], -1, 1);
		$options['shift_blue'] = pix_bg_effect_float($settings['pix_bg_liquid_shift_blue'] ?? $options['shift_blue'], $options['shift_blue'], -1, 1);
	}

	if ($effect === 'mesh-gradient') {
		$options['color_count'] = pix_bg_effect_int($settings['pix_bg_mesh_color_count'] ?? $options['color_count'], $options['color_count'], 1, 4);
		$options['color1'] = pix_bg_effect_read_color_setting($settings, 'pix_bg_mesh_color_1', $options['color1']);
		$options['color2'] = pix_bg_effect_read_color_setting($settings, 'pix_bg_mesh_color_2', $options['color2']);
		$options['color3'] = pix_bg_effect_read_color_setting($settings, 'pix_bg_mesh_color_3', $options['color3']);
		$options['color4'] = pix_bg_effect_read_color_setting($settings, 'pix_bg_mesh_color_4', $options['color4']);
		$options['distortion'] = pix_bg_effect_float($settings['pix_bg_mesh_distortion'] ?? $options['distortion'], $options['distortion'], 0, 1);
		$options['swirl'] = pix_bg_effect_float($settings['pix_bg_mesh_swirl'] ?? $options['swirl'], $options['swirl'], 0, 1);
		$options['grain_mixer'] = pix_bg_effect_float($settings['pix_bg_mesh_grain_mixer'] ?? $options['grain_mixer'], $options['grain_mixer'], 0, 1);
		$options['grain_overlay'] = pix_bg_effect_float($settings['pix_bg_mesh_grain_overlay'] ?? $options['grain_overlay'], $options['grain_overlay'], 0, 1);
		$options['scale'] = pix_bg_effect_float($settings['pix_bg_mesh_scale'] ?? $options['scale'], $options['scale'], 0.1, 4);
		$options['rotation'] = pix_bg_effect_float($settings['pix_bg_mesh_rotation'] ?? $options['rotation'], $options['rotation'], -360, 360);
		$options['offset_x'] = pix_bg_effect_float($settings['pix_bg_mesh_offset_x'] ?? $options['offset_x'], $options['offset_x'], -1, 1);
		$options['offset_y'] = pix_bg_effect_float($settings['pix_bg_mesh_offset_y'] ?? $options['offset_y'], $options['offset_y'], -1, 1);
	}

	return [
		'effect' => $effect,
		'options' => $options,
	];
}

function pixApplyElementorBackgroundEffectAttributes($element, $settings) {
	if (!is_object($element) || !method_exists($element, 'add_render_attribute')) {
		return;
	}

	$effect_data = pixGetElementorBackgroundEffectData($settings);
	if (empty($effect_data) || empty($effect_data['effect'])) {
		return;
	}

	$element->add_render_attribute('_wrapper', ['class' => 'pix-background-effects']);
	$element->add_render_attribute('_wrapper', ['data-pix-background-effect' => $effect_data['effect']]);
	$element->add_render_attribute('_wrapper', ['data-pix-background-effect-options' => wp_json_encode($effect_data['options'])]);
}
