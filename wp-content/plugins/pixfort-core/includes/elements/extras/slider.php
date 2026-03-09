<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!function_exists('pixfort_slider_get_wpb_navigation_styling_data')) {
	function pixfort_slider_get_wpb_navigation_styling_data($settings = []) {
		$result = [
			'slider_scope_class' => '',
		];

		if (!defined('WPB_VC_VERSION')) {
			return $result;
		}

		$settings = wp_parse_args($settings, [
			'swiper_data' => '',
			'navigation_spacing' => '',
			'navigation_spacing_mobile' => '',
			'navigation_color' => '',
			'custom_navigation_color' => '',
			'navigation_bg_color' => '',
			'custom_navigation_bg_color' => '',
			'navigation_border_color' => '',
			'custom_navigation_border_color' => '',
			'navigation_size' => '',
			'navigation_icon_size' => '',
			'navigation_border_size' => '',
			'navigation_border_radius' => '',
		]);

		$sanitize_css_value = function ($value) {
			if (!is_scalar($value)) {
				return '';
			}
			$value = trim((string) $value);
			if ($value === '') {
				return '';
			}
			if (preg_match('/[{};]/', $value)) {
				return '';
			}
			return $value;
		};

		$normalize_css_length = function ($value, $default_unit = 'px', $allow_negative = false, $allow_percent = false) use ($sanitize_css_value) {
			$value = $sanitize_css_value($value);
			if ($value === '') {
				return '';
			}
			$sign = $allow_negative ? '-?' : '';
			if (preg_match('/^' . $sign . '\d+(\.\d+)?$/', $value)) {
				return $value . $default_unit;
			}
			$units = $allow_percent ? '(px|%|em|rem|vw|vh)' : '(px|em|rem|vw|vh)';
			if (preg_match('/^' . $sign . '\d+(\.\d+)?' . $units . '$/', $value)) {
				return $value;
			}
			return '';
		};

		$sanitize_css_color = function ($value) use ($sanitize_css_value) {
			$value = $sanitize_css_value($value);
			if ($value === '') {
				return '';
			}
			if (function_exists('sanitize_hex_color')) {
				$hex = sanitize_hex_color($value);
				if (!empty($hex)) {
					return $hex;
				}
			}
			if (preg_match('/^(rgba?|hsla?)\([0-9\.,%\s]+\)$/i', $value)) {
				return $value;
			}
			if (preg_match('/^var\(--[a-z0-9\-_]+\)$/i', $value)) {
				return $value;
			}
			return '';
		};

		$sanitize_color_slug = function ($value) {
			if (!is_scalar($value)) {
				return '';
			}
			$value = sanitize_key((string) $value);
			return $value ? $value : '';
		};

		$navigation_spacing_desktop_value = $normalize_css_length($settings['navigation_spacing'], 'px', true, true);
		$navigation_spacing_mobile_value = $normalize_css_length($settings['navigation_spacing_mobile'], 'px', true, true);
		$navigation_size_value = $normalize_css_length($settings['navigation_size'], 'px');
		$navigation_icon_size_value = $normalize_css_length($settings['navigation_icon_size'], 'px');
		$navigation_border_size_value = $normalize_css_length($settings['navigation_border_size'], 'px');
		$navigation_border_radius_value = $normalize_css_length($settings['navigation_border_radius'], 'px', false, true);

		$navigation_color_value = '';
		$navigation_bg_color_value = '';
		$navigation_border_color_value = '';

		$custom_navigation_color_value = $sanitize_css_color($settings['custom_navigation_color']);
		$custom_navigation_bg_color_value = $sanitize_css_color($settings['custom_navigation_bg_color']);
		$custom_navigation_border_color_value = $sanitize_css_color($settings['custom_navigation_border_color']);

		if (!empty($custom_navigation_color_value)) {
			$navigation_color_value = $custom_navigation_color_value;
		} else {
			$navigation_color_slug = $sanitize_color_slug($settings['navigation_color']);
			if (!empty($navigation_color_slug) && $navigation_color_slug !== 'custom') {
				$navigation_color_value = 'var(--pix-' . $navigation_color_slug . ')';
			}
		}

		if (!empty($custom_navigation_bg_color_value)) {
			$navigation_bg_color_value = $custom_navigation_bg_color_value;
		} else {
			$navigation_bg_color_slug = $sanitize_color_slug($settings['navigation_bg_color']);
			if (!empty($navigation_bg_color_slug) && $navigation_bg_color_slug !== 'custom') {
				$navigation_bg_color_value = 'var(--pix-' . $navigation_bg_color_slug . ')';
			}
		}

		if (!empty($custom_navigation_border_color_value)) {
			$navigation_border_color_value = $custom_navigation_border_color_value;
		} else {
			$navigation_border_color_slug = $sanitize_color_slug($settings['navigation_border_color']);
			if (!empty($navigation_border_color_slug) && $navigation_border_color_slug !== 'custom') {
				$navigation_border_color_value = 'var(--pix-' . $navigation_border_color_slug . ')';
			}
		}

		$navigation_css_vars = [];
		if (!empty($navigation_spacing_desktop_value)) {
			$navigation_css_vars[] = '--pix-slider-nav-spacing:' . $navigation_spacing_desktop_value;
		}
		if (!empty($navigation_color_value)) {
			$navigation_css_vars[] = '--pix-slider-nav-color:' . $navigation_color_value . ' !important';
		}
		if (!empty($navigation_bg_color_value)) {
			$navigation_css_vars[] = '--pix-slider-nav-bg-color:' . $navigation_bg_color_value . ' !important';
		}
		if (!empty($navigation_border_color_value)) {
			$navigation_css_vars[] = '--pix-slider-nav-border-color:' . $navigation_border_color_value . ' !important';
		}
		if (!empty($navigation_size_value)) {
			$navigation_css_vars[] = '--pix-slider-nav-size:' . $navigation_size_value;
		}
		if (!empty($navigation_icon_size_value)) {
			$navigation_css_vars[] = '--pix-slider-nav-svg-size:' . $navigation_icon_size_value;
		}
		if (!empty($navigation_border_size_value)) {
			$navigation_css_vars[] = '--pix-slider-nav-border-size:' . $navigation_border_size_value;
		}
		if (!empty($navigation_border_radius_value)) {
			$navigation_css_vars[] = '--pix-slider-nav-border-radius:' . $navigation_border_radius_value;
		}

		if (!empty($navigation_css_vars) || !empty($navigation_spacing_mobile_value)) {
			$navigation_css_hash = implode(';', $navigation_css_vars) . '|' . $navigation_spacing_mobile_value . '|' . $settings['swiper_data'];
			$result['slider_scope_class'] = 'pixfort-swiper-' . substr(md5($navigation_css_hash), 0, 10);
			$navigation_css = '';
			if (!empty($navigation_css_vars)) {
				$navigation_css .= '.' . $result['slider_scope_class'] . ' .pixfort-button-prev,.' . $result['slider_scope_class'] . ' .pixfort-button-next{' . implode(';', $navigation_css_vars) . ';}';
			}
			if (!empty($navigation_spacing_mobile_value)) {
				$navigation_css .= '@media (max-width: 767px){.' . $result['slider_scope_class'] . ' .pixfort-button-prev,.' . $result['slider_scope_class'] . ' .pixfort-button-next{--pix-slider-nav-spacing:' . $navigation_spacing_mobile_value . ';}}';
			}
			if (!empty($navigation_css)) {
				\PixfortCore::instance()->elementsManager::pixAddInlineStyle($navigation_css);
			}
		}

		return $result;
	}
}

if (!function_exists('pixfort_slider')) {
	function pixfort_slider($attr, $content = null) {
		extract(shortcode_atts(array(
			'items'  => '',

			'slider_num'  => '3',
			'slider_num_tablet'  => '',
			'slider_num_mobile'  => '1',
			'dots_style'     => '',
			'slider_style'     => 'pix-style-standard',
			'slider_effect'     => 'pix-effect-standard',
			'drag_scale'     => false,
			'autoplay'     => false,
			'reverseDirection'     => false,
			'autoplay_time'     => '1500',
			'freescroll'     => false,
			'prevnextbuttons'     => false,
			'adaptiveheight'     => false,
			'pagedots'     => true,
			'dots_align'     => '',
			'cellalign'     => 'center',
			'slider_scale'     => '',
			'cellpadding'     => '',
			'slider_wrap'     => false,
			'righttoleft'     => false,
			'visible_overflow' => '',
			'css' => '',
			'is_thumbnails' => false,
			'has_thumbnails' => false,
			'speed' => false,
			'centerInsufficientSlides' => false,
			'spaceBetween' => false,
			'spaceBetween_tablet' => false,
			'spaceBetween_mobile' => false,
			'enable_wpb_navigation_styling' => false,
			'navigation_spacing' => '',
			'navigation_spacing_mobile' => '',
			'navigation_color' => '',
			'custom_navigation_color' => '',
			'navigation_bg_color' => '',
			'custom_navigation_bg_color' => '',
			'navigation_border_color' => '',
			'custom_navigation_border_color' => '',
			'navigation_size' => '',
			'navigation_icon_size' => '',
			'navigation_border_size' => '',
			'navigation_border_radius' => '',
			'navigation_shadow_style'         => '',
            'navigation_hover_effect'         => '',
            // 'navigation_add_hover_effect'         => '',
			'extra_classes' => '',
		), $attr));


		$output = '';
		$main_classes = [];
		if ($extra_classes) {
			$main_classes = explode(' ', $extra_classes);
		}
		$main_classes[] = $dots_style;

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		$slider_scale = $slider_scale === 'pix-slider-scale' ? true : false;

		$centeredSlides = false;
		if ($cellalign == 'center') {
			$centeredSlides = true;
		}

		$duplicatedItems = false;
		if (!is_array($items)) {
			return '';
		}
		$itemsCount = count($items);
		// Duplicate items if loop is enabled, centered, and item count is close to slider_num
		if (filter_var($slider_wrap, FILTER_VALIDATE_BOOLEAN) && $centeredSlides && !empty($items)) {
			$difference = $itemsCount - (int)$slider_num;

			// If difference is positive and less than 3, duplicate the items
			if ($difference > 0 && $difference < 4) {
				$items = array_merge($items, $items);
				$duplicatedItems = true;
				$itemsCount = count($items);
			}
		} else if (filter_var($slider_wrap, FILTER_VALIDATE_BOOLEAN) && $itemsCount < 4 ) {
			$items = array_merge($items, $items);
			$duplicatedItems = true;
			$itemsCount = count($items);
		}

		$swiper_opts = [
			'loop' => filter_var($slider_wrap, FILTER_VALIDATE_BOOLEAN),
			'is_thumbnails' => filter_var($is_thumbnails, FILTER_VALIDATE_BOOLEAN),
			'has_thumbnails' => filter_var($has_thumbnails, FILTER_VALIDATE_BOOLEAN),
			'slidesPerView' => $slider_num,
			'slidesPerGroup' => 1,
			'autoHeight' => filter_var($adaptiveheight, FILTER_VALIDATE_BOOLEAN),
			'centeredSlides' => $centeredSlides,
			'duplicatedItems' => $duplicatedItems,
			'itemsCount' => $itemsCount,
			'autoplay' => $autoplay && $autoplay_time ? array(
				'delay' => $autoplay_time,
				'disableOnInteraction' => false,
				'pauseOnMouseEnter' => true,
				'reverseDirection' => filter_var($reverseDirection, FILTER_VALIDATE_BOOLEAN)
			) : false,
			'pagination' => array(
				'enabled' => filter_var($pagedots, FILTER_VALIDATE_BOOLEAN),
				'clickable' => true,
				'dynamicBullets' => false
			),
			'navigation' => array(
				'enabled' => filter_var($prevnextbuttons, FILTER_VALIDATE_BOOLEAN)
			),
			'freeMode' => filter_var($freescroll, FILTER_VALIDATE_BOOLEAN),
			'edgeTransitionParams' => [
				'transitionZone' => 1.0,
				'slider_style' => $slider_style,
				'slider_effect' => $slider_effect,
				'slider_inactive_scale' => filter_var($slider_scale, FILTER_VALIDATE_BOOLEAN),
				'dragScale' => filter_var($drag_scale, FILTER_VALIDATE_BOOLEAN),
			]
		];

		$breakpoints = [];


		if ($spaceBetween) {
			$swiper_opts['spaceBetween'] = (int)$spaceBetween;
		}


		// Responsive values
		if ($slider_num_tablet || $slider_num_mobile) {
			$swiper_opts['slidesPerView'] = $slider_num_mobile ? $slider_num_mobile : 1;
			$breakpoints['767']['slidesPerView'] = $slider_num_tablet ? $slider_num_tablet : $slider_num;
			$breakpoints['1024']['slidesPerView'] = $slider_num;
		}
		if ($spaceBetween_tablet || $spaceBetween_mobile) {
			$swiper_opts['spaceBetween'] = $spaceBetween_mobile ? $spaceBetween_mobile : ($spaceBetween_tablet ? $spaceBetween_tablet : $spaceBetween);
			$breakpoints['767']['spaceBetween'] = $spaceBetween_tablet ? $spaceBetween_tablet : $spaceBetween;
			$breakpoints['1024']['spaceBetween'] = (int)$spaceBetween;
		}
		if (!empty($breakpoints)) {
			$swiper_opts['breakpoints'] = $breakpoints;
		}

		if (!filter_var($slider_wrap, FILTER_VALIDATE_BOOLEAN) && $centeredSlides) {
			$offset = ((int)$slider_num - 1) / 2;
			$swiper_opts['initialSlide'] = $offset;
		}

		if ($speed) {
			$swiper_opts['speed'] = $speed;
		}
		if ($centerInsufficientSlides) {
			$swiper_opts['centerInsufficientSlides'] = true;
		}


		$swiper_data = json_encode($swiper_opts);
		$swiper_data_attr = 'data-swiper=\'' . $swiper_data . '\'';
		$rtl_attr = filter_var($righttoleft, FILTER_VALIDATE_BOOLEAN) ? 'dir="rtl"' : '';


		$swiperClasses = '';
		if (filter_var($is_thumbnails, FILTER_VALIDATE_BOOLEAN)) {
			$swiperClasses = 'pix-slider-thumbnails';
		} else if (filter_var($has_thumbnails, FILTER_VALIDATE_BOOLEAN)) {
			$swiperClasses = 'pix-slider-has-thumbnails';
		}

	$main_classes = join(' ', $main_classes);
	$slider_scope_class = '';

	if (defined('WPB_VC_VERSION') && filter_var($enable_wpb_navigation_styling, FILTER_VALIDATE_BOOLEAN)) {
		if ($dots_style === 'light-dots' && empty($navigation_color) && empty($custom_navigation_color)) {
			$navigation_color = 'light-opacity-3';
		}
		$navigation_styling_data = pixfort_slider_get_wpb_navigation_styling_data([
			'swiper_data' => $swiper_data,
			'navigation_spacing' => $navigation_spacing,
			'navigation_spacing_mobile' => $navigation_spacing_mobile,
			'navigation_color' => $navigation_color,
			'custom_navigation_color' => $custom_navigation_color,
			'navigation_bg_color' => $navigation_bg_color,
			'custom_navigation_bg_color' => $custom_navigation_bg_color,
			'navigation_border_color' => $navigation_border_color,
			'custom_navigation_border_color' => $custom_navigation_border_color,
			'navigation_size' => $navigation_size,
			'navigation_icon_size' => $navigation_icon_size,
			'navigation_border_size' => $navigation_border_size,
			'navigation_border_radius' => $navigation_border_radius,
		]);
		$slider_scope_class = !empty($navigation_styling_data['slider_scope_class']) ? $navigation_styling_data['slider_scope_class'] : '';
	}

	// Add data attributes for pre-initialization layout
	$slides_per_view_attrs = '';
	$slides_per_view_attrs .= 'data-slides-desktop="' . esc_attr($slider_num) . '" ';
	$slides_per_view_attrs .= 'data-slides-tablet="' . esc_attr($slider_num_tablet ? $slider_num_tablet : $slider_num) . '" ';
	$slides_per_view_attrs .= 'data-slides-mobile="' . esc_attr($slider_num_mobile ? $slider_num_mobile : 1) . '" ';

	$output .= '<div class="pixfort-swiper position-relative ' . $slider_scope_class . ' ' . $main_classes . ' ' . $css_class . '">';
	$output .= '<div class="position-relative">';
	$output .= '<div class="swiper ' . $swiperClasses . ' ' . $slider_style . ' ' . $slider_effect . ' ' . $visible_overflow . '" ' . $swiper_data_attr . ' ' . $rtl_attr . ' ' . $slides_per_view_attrs . '>';
	$output .= '<div class="swiper-wrapper">';
		if (is_array($items)) {
			foreach ($items as $index => $item) {
				$output .= '<div class="swiper-slide" data-pixfort-slide-index="' . $index . '">';
				$output .= '<div class="pixfort-slide-inner ' . $cellpadding . '">' . $item . '</div>';
				$output .= '</div>';
			}
		}
		$output .= '</div>';

		$output .= '</div>';
		// Add navigation buttons
		if (filter_var($prevnextbuttons, FILTER_VALIDATE_BOOLEAN)) {
			$navigationEffectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($navigation_shadow_style, $navigation_hover_effect, '');
			$output .= '<div class="pixfort-button-prev '. $navigationEffectsClasses.'"><svg width="26" height="26" class="pixfort-slider-navigation-icon" viewBox="0 0 100 100"><path d="M83.7718595,45.4606514 L31.388145,45.4606514 L54.2737785,23.1973134 C56.1027533,21.4180712 56.1027533,18.4982892 54.2737785,16.719047 C52.4448037,14.9398048 49.4903059,14.9398048 47.6613311,16.719047 L16.7563465,46.7836776 C14.9273717,48.5629198 14.9273717,51.4370802 16.7563465,53.2163224 L47.6613311,83.280953 C49.4903059,85.0601952 52.4448037,85.0601952 54.2737785,83.280953 C56.1027533,81.5017108 56.1027533,78.6275504 54.2737785,76.8483082 L31.388145,54.5849702 L83.7718595,54.5849702 C86.3511829,54.5849702 88.4615385,52.5319985 88.4615385,50.0228108 C88.4615385,47.5136231 86.3511829,45.4606514 83.7718595,45.4606514 Z" class="arrow"></path></svg></div>';
			$output .= '<div class="pixfort-button-next '. $navigationEffectsClasses.'"><svg width="26" height="26" class="pixfort-slider-navigation-icon" viewBox="0 0 100 100"><path d="M83.7718595,45.4606514 L31.388145,45.4606514 L54.2737785,23.1973134 C56.1027533,21.4180712 56.1027533,18.4982892 54.2737785,16.719047 C52.4448037,14.9398048 49.4903059,14.9398048 47.6613311,16.719047 L16.7563465,46.7836776 C14.9273717,48.5629198 14.9273717,51.4370802 16.7563465,53.2163224 L47.6613311,83.280953 C49.4903059,85.0601952 52.4448037,85.0601952 54.2737785,83.280953 C56.1027533,81.5017108 56.1027533,78.6275504 54.2737785,76.8483082 L31.388145,54.5849702 L83.7718595,54.5849702 C86.3511829,54.5849702 88.4615385,52.5319985 88.4615385,50.0228108 C88.4615385,47.5136231 86.3511829,45.4606514 83.7718595,45.4606514 Z" class="arrow" transform="translate(100, 100) rotate(180) "></path></svg></div>';
		}

		$output .= '</div>';


		// Add pagination with alignment
		if (filter_var($pagedots, FILTER_VALIDATE_BOOLEAN)) {
			$pagination_class = '';
			if (!empty($dots_align)) {
				$pagination_class = ' pix-dots-' . $dots_align;
			}
			$output .= '<div class="pixfort-slider-pagination-container' . $pagination_class . '"><div class="pixfort-slider-pagination"></div></div>';
		}

		$output .= '</div>';

		wp_enqueue_style('pixfort-slider-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/slider.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');

		return $output;
	}
}
