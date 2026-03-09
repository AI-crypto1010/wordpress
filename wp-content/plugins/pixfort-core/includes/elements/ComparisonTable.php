<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* ComparisonTable
* --------------------------------------------------------------------------- */
class PixComparisonTable {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'items'  => '',
			'table_title'  => '',
			'cols_count'  => '3',
			// Head title
			'bold'  => 'font-weight-bold',
			'italic'  => '',
			'secondary_font'  => '',
			'title_color'  => 'heading-default',
			'title_custom_color'  => '',
			'title_size'  => 'h3',
			'display'  => '',
			'title_custom_size'  => '',

			'cols_bold'  => '',
			'cols_italic'  => '',
			'cols_secondary_font'  => '',
			'cols_titles_size'  => 'h4',
			'cols_titles_custom_size'  => '',
			'head_style'  => '',
			'head_line_color'  => 'dark-opacity-1',
			'head_line_custom_color'  => '',
			'head_bg_color'  => 'white',
			'head_custom_bg_color'  => '',

			// Descriptions
			'descriptions_title_bold'  => 'font-weight-bold',
			'descriptions_title_italic'  => '',
			'descriptions_secondary_font'  => '',
			'descriptions_title_color'  => '',
			'descriptions_title_custom_color'  => '',
			'descriptions_title_size'  => 'h6',
			'descriptions_title_display'  => '',
			'descriptions_title_custom_size'  => '',
			'content_size'  => '',
			'content_bold'  => '',
			'content_italic'  => '',
			'content_secondary_font'  => '',
			'content_color'  => 'body-default',
			'content_custom_color'  => '',
			'columns_bold'  => '',
			'columns_italic'  => '',
			'columns_secondary_font'  => '',
			'columns_size'  => '',

			'style' 		=> '',
			'items_line_color' 		=> 'dark-opacity-1',
			'items_line_custom_color' 		=> '',
			'hover_effect' 		=> '',
			'add_hover_effect' 		=> '',


			// 'icon_color'  => 'primary',
			// 'custom_icon_color'  => '',
			'animation' 	=> '',
			'delay' 	=> '0',


			'col_1_title' 	=> '',
			'col_1_color' 	=> 'heading-default',
			'col_1_custom_color' 	=> '',

			'col_2_title' 	=> '',
			'col_2_color' 	=> 'heading-default',
			'col_2_custom_color' 	=> '',

			'col_3_title' 	=> '',
			'col_3_color' 	=> 'heading-default',
			'col_3_custom_color' 	=> '',

			'element_id'		=> '',
			'css' 		=> '',
		), $attr));

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		$style_arr = array(
			"" 		=> "",
			"1"       => "shadow-sm",
			"2"       => "shadow",
			"3"       => "shadow-lg",
			"4"       => "shadow-inverse-sm",
			"5"       => "shadow-inverse",
			"6"       => "shadow-inverse-lg",
			"7"       => "pix-bottom-line",
		);

		$hover_effect_arr = array(
			""       => "",
			"1"       => "shadow-hover-sm",
			"2"       => "shadow-hover",
			"3"       => "shadow-hover-lg",
			"4"       => "shadow-inverse-hover-sm",
			"5"       => "shadow-inverse-hover",
			"6"       => "shadow-inverse-hover-lg",
		);

		$add_hover_effect_arr = array(
			""       => "",
			"1"       => "fly-sm",
			"2"       => "fly",
			"3"       => "fly-lg",
			"4"       => "scale-sm",
			"5"       => "scale",
			"6"       => "scale-lg",
			"7"       => "scale-inverse-sm",
			"8"       => "scale-inverse",
			"9"       => "scale-inverse-lg",
		);
		$classes = array();
		if ($style) {
			array_push($classes, $style_arr[$style]);
		}
		if ($hover_effect) {
			array_push($classes, $hover_effect_arr[$hover_effect]);
		} else {
			array_push($classes, 'shadow-hover-none');
		}
		if ($add_hover_effect) {
			array_push($classes, $add_hover_effect_arr[$add_hover_effect]);
		}
		$class_names = join(' ', $classes);


		$columns_titles_classes = '';
		$columns_titles_classes .= ' ' . $cols_bold;
		$columns_titles_classes .= ' ' . $cols_italic;
		$columns_titles_classes .= ' ' . $cols_secondary_font;

		$columns_classes = '';
		$columns_classes .= ' ' . $columns_bold;
		$columns_classes .= ' ' . $columns_italic;
		$columns_classes .= ' ' . $columns_size;
		$columns_classes .= ' ' . $columns_secondary_font;


		$head_classes = '';
		if ($head_style != '7') {
			$head_classes .= 'rounded-xl ';
		}
		$head_classes .= $style_arr[$head_style];


		$anim_type = '';
		$anim_delay = '';
		$anim_class = '';
		if (!empty($animation)) {
			$anim_type = 'data-anim-type="' . $animation . '"';
			$anim_delay = 'data-anim-delay="' . $delay . '"';
			$anim_class = 'animate-in';
			$class_names .= ' ' . $anim_class;
			$head_classes .= ' ' . $anim_class;
		}

		$output = '';

		if (empty($element_id)) {
			$element_id = 'pix-comparison-' . rand(1, 200000000);
		} else {
			if (is_numeric($element_id[0])) {
				$element_id = 'el' . $element_id;
			}
		}

		$elementor = false;
		if (is_array($items)) {
			$items_arr = $items;
			$elementor = true;
		} else {
			if (function_exists('vc_param_group_parse_atts')) {
				$items_arr = vc_param_group_parse_atts($items);
			}
		}

		$customStyle = '';

		// Col 1
		$col_1_color_class = '';
		if ($col_1_color == 'custom') {
		} else {
			$col_1_color_class = 'text-' . $col_1_color;
			$contentTitle = str_replace(array("\n", "\r"), '', wp_strip_all_tags($col_1_title));
			$customStyle .= '
				@media screen and (max-width: 767px){
					#' . $element_id . ' .pix_comparison_1_title::before {
					    content: "' . $contentTitle . '";
						font-weight: bold;
						color:  var(--pix-' . $col_1_color . ');
						padding-bottom:5px;
						display:block;
					}
				}
			';
		}

		// Col 2
		$col_2_color_class = '';
		if ($col_2_color == 'custom') {
		} else {
			$col_2_color_class = 'text-' . $col_2_color;
			$contentTitle = str_replace(array("\n", "\r"), '', wp_strip_all_tags($col_2_title));
			$customStyle .= '
				@media screen and (max-width: 767px){
					#' . $element_id . ' .pix_comparison_2_title::before {
					    content: "' . $contentTitle . '";
						font-weight: bold;
						color:  var(--pix-' . $col_2_color . ');
						padding-bottom:5px;
						display:block;
					}
				}
			';
		}
		// Col 3
		$col_3_color_class = '';
		if ($col_3_color == 'custom') {
		} else {
			$col_3_color_class = 'text-' . $col_3_color;
			$contentTitle = str_replace(array("\n", "\r"), '', wp_strip_all_tags($col_3_title));
			$customStyle .= '
				@media screen and (max-width: 767px){
					#' . $element_id . ' .pix_comparison_3_title::before {
					    content: "' . $contentTitle . '";
						font-weight: bold;
						color:  var(--pix-' . $col_3_color . ');
						padding-bottom:5px;
						display:block;
					}
				}
			';
		}
		if (!$elementor) {
			if ($items_line_color == 'custom') {
				$customStyle .= '#' . $element_id . ' .pix-bottom-line { border-color: ' . $items_line_custom_color . ' !important; }';
			} else {
				$customStyle .= '#' . $element_id . ' .pix-bottom-line { border-color: var(--pix-' . $items_line_color . ') !important; }';
			}
			if ($head_line_color == 'custom') {
				$customStyle .= '#' . $element_id . ' .pix-comparison-head.pix-bottom-line { border-color: ' . $head_line_custom_color . ' !important; }';
			} else {
				$customStyle .= '#' . $element_id . ' .pix-comparison-head.pix-bottom-line { border-color: var(--pix-' . $head_line_color . ') !important; }';
			}
		}


		// $css_handel = 'pix-comparison-' . $element_id;
		// wp_register_style($css_handel, false);
		// wp_enqueue_style($css_handel);
		// wp_add_inline_style($css_handel, $customStyle);
		\PixfortCore::instance()->elementsManager::pixAddInlineStyle( $customStyle );
		if (is_user_logged_in() && (defined('DOING_AJAX') && DOING_AJAX)) {
			$output .= '<style>' . $customStyle . '</style>';
		}

		$output .= '<div class="w-100 ' . esc_attr($css_class) . '" >';
		$output .= '<div class="container" id="' . $element_id . '">';

		$heading_opts = array(
			'title'		=> $table_title,
			'bold'		=> $bold,
			'italic'		=> $italic,
			'secondary_font'		=> $secondary_font,
			'title_color'		=> $title_color,
			'title_custom_color'		=> $title_custom_color,
			'title_size'		=> $title_size,
			'display'		=> $display,
			'title_custom_size'		=> $title_custom_size,
			'padding_title'			=> '',
			'h1'		=> '',
			'position'  => 'text-left',
		);
		$heading_out = \PixfortCore::instance()->elementsManager->renderElement('Heading', $heading_opts );

		$descriptions_title_opts = array(
			'bold'		=> $descriptions_title_bold,
			'italic'		=> $descriptions_title_italic,
			'secondary_font'		=> $descriptions_secondary_font,
			'title_color'		=> $descriptions_title_color,
			'title_custom_color'		=> $descriptions_title_custom_color,
			'title_size'		=> $descriptions_title_size,
			'display'		=> $descriptions_title_display,
			'title_custom_size'		=> $descriptions_title_custom_size,
			'padding_title'			=> '',
			'h1'		=> '',
			'position'  => 'text-left',
		);
		$text_opts = array(
			'size'  => $content_size,
			'bold'		=> $content_bold,
			'italic'		=> $content_italic,
			'secondary_font'		=> $content_secondary_font,
			'content_color'		=> $content_color,
			'content_custom_color'		=> $content_custom_color,
			'remove_pb_padding'		=> 'm-0',
		);

		$cols_titles_style = '';
		if ($cols_titles_size == 'custom') {
			$cols_titles_style = 'style="font-size:' . $cols_titles_custom_size . ';"';
		}
		$head_style = '';
		if ($head_bg_color == 'custom') {
			$head_style = 'style="background:' . $icon_custom_bg_color . ';"';
		}

		$custom_tooltip_color = '';
		if (!empty($descriptions_title_color)) {
			if ($descriptions_title_color == 'custom') {
				$custom_tooltip_color = 'color:' . $descriptions_title_custom_color . ';"';
			}
		}


		$cols_count = (int)$cols_count;
		// if($cols_count==0) break;
		// $cols_count--;
		$tableHeadClasses = '';
		if (empty($heading_out)) {
			$tableHeadClasses = 'd-none d-md-block';
		}
		$output .= '<div class="sticky-top pix-sticky-top-adjust ' . $tableHeadClasses . '">';
		$output .= '<div class="row pix-py-20 pix-comparison-head bg-' . $head_bg_color . ' ' . $head_classes . '" ' . $anim_type . ' ' . $anim_delay . ' ' . $head_style . '>';
		$output .= '<div class="col-12 col-md-4 col-lg-6 d-flex align-items-center font-weight-bold text-heading-default"><div class="pix-px-15">' . $heading_out;
		$output .= '</div></div>';
		$output .= '<div class="col justify-content-center d-none d-md-flex align-items-center"><div class="mb-0 ' . $columns_titles_classes . ' ' . $cols_titles_size . ' ' . $col_1_color_class . '" ' . $cols_titles_style . '>' . do_shortcode($col_1_title) . '</div>';
		$output .= '</div>';
		if ($cols_count > 1) {
			$output .= '<div class="col justify-content-center d-none d-md-flex align-items-center"><div class="mb-0 ' . $columns_titles_classes . ' ' . $cols_titles_size . ' ' . $col_2_color_class . '" ' . $cols_titles_style . '>' . do_shortcode($col_2_title) . '</div>';
			$output .= '</div>';
		}
		if ($cols_count > 2) {
			$output .= '<div class="col justify-content-center d-none d-md-flex align-items-center"><div class="mb-0 ' . $columns_titles_classes . ' ' . $cols_titles_size . ' ' . $col_3_color_class . '" ' . $cols_titles_style . '>' . do_shortcode($col_3_title) . '</div>';
			$output .= '</div>';
		}
		$output .= '</div>';

		$output .= '</div>';


		foreach ($items_arr as $key => $value) {

			extract(shortcode_atts(array(
				'title'  => '',
				'text'  => '',
				'title_tooltip'  => '',

				'col_1_text'  => '',
				'col_1_tooltip'  => '',
				'col_1_media_type'  => '',
				'col_1_pix_duo_icon'  => '',
				'col_1_icon'  => '',

				'col_2_text'  => '',
				'col_2_tooltip'  => '',
				'col_2_media_type'  => '',
				'col_2_pix_duo_icon'  => '',
				'col_2_icon'  => '',

				'col_3_text'  => '',
				'col_3_tooltip'  => '',
				'col_3_media_type'  => '',
				'col_3_pix_duo_icon'  => '',
				'col_3_icon'  => '',
			), $value));

			/* RTL */
			$margin2 = 'ml-2';
			$margin10 = 'pix-mr-10';
			if (is_rtl()) {
				$margin2 = 'mr-2';
				$margin10 = 'pix-ml-10';
			}

			$output .= '<div class="row pix-py-20 pix-my-10 ' . $class_names . ' rounded-lg" ' . $anim_type . ' ' . $anim_delay . '>';
			$output .= '<div class="col-12 col-md-4 col-lg-6 mb-2 mb-sm-0 pb-2 pb-md-0">';
			$output .= '<div class="pix-px-15">';
			if (!empty($title)) {
				$output .= '<div class="d-flex align-items-center">';
				$item_title = $descriptions_title_opts;
				$item_title['title'] = $title;
				$title_out = \PixfortCore::instance()->elementsManager->renderElement('Heading', $item_title );
				$output .= $title_out;
				if (!empty($title_tooltip)) {
					$output .= '<span class="' . $descriptions_title_size . ' mb-0 d-inline-flex align-items-center"><span data-toggle="tooltip" data-placement="auto" title="'.$title_tooltip.'" class="d-inline-flex align-middle align-self-center text-'.$descriptions_title_color.' ' . $margin2 . ' mb-0 line-height-0" style="cursor: help;font-size:70%;'.$custom_tooltip_color.'">'.\PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-question-mark-circle-1').'</span></span>';
				}
				$output .= '</div>';
			}
			if (!empty($text)) {
				$text_out = \PixfortCore::instance()->elementsManager->renderElement('Text', $text_opts, $text );
				$output .= do_shortcode($text_out);
			}
			$output .= '</div>';
			$output .= '</div>';

			$tooltip_1_out = '';
			if (!empty($col_1_tooltip)) {
				$tooltip_1_out = 'data-toggle="tooltip" data-placement="bottom" title="' . $col_1_tooltip . '"';
			}
			$output .= '<div class="col mt-2 mt-sm-0 text-center pix_comparison_1_title d-md-flex align-items-center justify-content-center">';
			$output .= '<div class="text-center ' . $columns_classes . ' d-flex align-items-center justify-content-center ' . $col_1_color_class . '" ' . $tooltip_1_out . '>';

			if (!empty($col_1_media_type)&&$col_1_media_type!=='none') {
				if ($col_1_media_type == "duo_icon") {
					$col_1_icon = $col_1_pix_duo_icon;
				}
				if (!empty($col_1_icon)) {
					$output .= '<div class="d-inline-flex align-items-center ' . $margin10 . ' ' . $col_1_color_class . '" style="position:relative;text-align:center;min-height:1.8rem;">';
					$output .= \PixfortCore::instance()->icons->getIcon($col_1_icon);
					$output .= '</div>';
				}
			}
			$output .= do_shortcode($col_1_text);
			$output .= '</div>';
			$output .= '</div>';


			if ($cols_count > 1) {
				$tooltip_2_out = '';
				if (!empty($col_2_tooltip)) {
					$tooltip_2_out = 'data-toggle="tooltip" data-placement="bottom" title="' . $col_2_tooltip . '"';
				}
				$output .= '<div class="col mt-2 mt-sm-0 text-center pix_comparison_2_title d-md-flex align-items-center justify-content-center">';
				$output .= '<div class="text-center ' . $columns_classes . ' d-flex align-items-center justify-content-center ' . $col_2_color_class . '" ' . $tooltip_2_out . '>';
				if (!empty($col_2_media_type)&&$col_2_media_type!=='none') {
					if ($col_2_media_type == "duo_icon") {
						$col_2_icon = $col_2_pix_duo_icon;
					}
					if (!empty($col_2_icon)) {
						$output .= '<div class="d-inline-flex align-items-center ' . $margin10 . ' ' . $col_2_color_class . '" style="position:relative;text-align:center;min-height:1.8rem;">';
						$output .= \PixfortCore::instance()->icons->getIcon($col_2_icon);
						$output .= '</div>';
					}
				}
				$output .= $col_2_text;
				$output .= '</div>';
				$output .= '</div>';
			}

			if ($cols_count > 2) {
				$tooltip_3_out = '';
				if (!empty($col_3_tooltip)) {
					$tooltip_3_out = 'data-toggle="tooltip" data-placement="bottom" title="' . $col_3_tooltip . '"';
				}
				$output .= '<div class="col mt-2 mt-sm-0 text-center pix_comparison_3_title d-md-flex align-items-center justify-content-center">';
				$output .= '<div class="text-center ' . $columns_classes . ' d-flex align-items-center justify-content-center ' . $col_3_color_class . '" ' . $tooltip_3_out . '>';
				if (!empty($col_3_media_type)&&$col_3_media_type!=='none') {
					if ($col_3_media_type == "duo_icon") {
						$col_3_icon = $col_3_pix_duo_icon;
					}
					if (!empty($col_3_icon)) {
						$output .= '<div class="d-inline-flex align-items-center ' . $margin10 . ' ' . $col_3_color_class . '" style="position:relative;text-align:center;min-height:1.8rem;">';
						$output .= \PixfortCore::instance()->icons->getIcon($col_3_icon);
						$output .= '</div>';
					}
				}
				$output .= $col_3_text;
				$output .= '</div>';
				$output .= '</div>';
			}


			$output .= '</div>';
		}




		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
}

