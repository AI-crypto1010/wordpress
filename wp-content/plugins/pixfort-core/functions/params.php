<?php

add_action('vc_before_init', 'pix_vc_params');
if (!function_exists('pix_vc_params')) {
	function pix_vc_params() {

		function pixfort_param_icons_picker( $settings, $value ) {
			require PIX_CORE_PLUGIN_DIR . '/includes/icons/pixfort-icons-list.php';
			$opts_out = '';
			
			$value = \PixfortCore::instance()->icons->verifyIconName($value);                  
			$opts_out .= '<div class="pixfort-icons-selector-wrapper is-light-version">';
			$opts_out .= '<div class="pixfort-icons-filter">';
			$opts_out .= '<a href="#" data-type="line" class="pixfort-icons-filter-tab is-selected">';
					$opts_out .= '<svg class="pixfort-tab-icon" width="24" height="24" viewBox="2 2 20 20"><path fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="var(--pf-icon-stroke-width)" d="M16.7777778,5 L11.3333333,13.5555556 L15.2222222,13.5555556 L15.2222222,19 L20.6666667,10.4444444 L16.7777778,10.4444444 L16.7777778,5 Z M11,7 L5,7 M8,12 L3,12 M11,17 L5,17"></path></svg>';
					$opts_out .= 'Line';
					$opts_out .= '</a>';
					$opts_out .= '<a href="#" data-type="duotone" class="pixfort-icons-filter-tab">';
					$opts_out .= '<svg class="pixfort-tab-icon" width="24" height="24" viewBox="2 2 20 20"><g fill="none" fill-rule="evenodd"><path fill="currentcolor" fill-opacity=".25" d="M11,6 C11.5522847,6 12,6.44771525 12,7 C12,7.55228475 11.5522847,8 11,8 L5,8 C4.44771525,8 4,7.55228475 4,7 C4,6.44771525 4.44771525,6 5,6 L11,6 Z M8,11 C8.55228475,11 9,11.4477153 9,12 C9,12.5522847 8.55228475,13 8,13 L3,13 C2.44771525,13 2,12.5522847 2,12 C2,11.4477153 2.44771525,11 3,11 L8,11 Z M11,16 C11.5522847,16 12,16.4477153 12,17 C12,17.5522847 11.5522847,18 11,18 L5,18 C4.44771525,18 4,17.5522847 4,17 C4,16.4477153 4.44771525,16 5,16 L11,16 Z"></path><path fill="currentcolor" d="M16.1759581,4.43347118 L10.6759581,12.4334712 L10.6170624,12.5297632 C10.2657894,13.1809277 10.7331624,14 11.5,14 L13.999,14 L14,19 C14,19.9713329 15.2451104,20.3723733 15.8120154,19.583636 L21.5620154,11.583636 L21.6235586,11.487482 C21.9917133,10.8363437 21.5259261,10 20.75,10 L17.999,10 L18,5 C18,4.01795609 16.7323143,3.62422582 16.1759581,4.43347118 Z"></path></g></svg>';
					$opts_out .= 'Duotone';
					$opts_out .= '</a>';
					$opts_out .= '<a href="#" data-type="solid" class="pixfort-icons-filter-tab">';
					$opts_out .= '<svg class="pixfort-tab-icon" width="24" height="24" viewBox="2 2 20 20"><g stroke="none" stroke-width="2" fill="none" fill-rule="evenodd"><g  stroke="none" stroke-width="2" fill="none" fill-rule="evenodd"><path d="M18,5 L17.999,10 L20.75,10 C21.5259261,10 21.9917133,10.8363437 21.6235586,11.487482 L21.5620154,11.583636 L15.8120154,19.583636 C15.2451104,20.3723733 14,19.9713329 14,19 L13.999,14 L11.5,14 C10.7331624,14 10.2657894,13.1809277 10.6170624,12.5297632 L10.6759581,12.4334712 L16.1759581,4.43347118 C16.7323143,3.62422582 18,4.01795609 18,5 Z M11,16 C11.5522847,16 12,16.4477153 12,17 C12,17.5522847 11.5522847,18 11,18 L5,18 C4.44771525,18 4,17.5522847 4,17 C4,16.4477153 4.44771525,16 5,16 L11,16 Z M8,11 C8.55228475,11 9,11.4477153 9,12 C9,12.5522847 8.55228475,13 8,13 L3,13 C2.44771525,13 2,12.5522847 2,12 C2,11.4477153 2.44771525,11 3,11 L8,11 Z M11,6 C11.5522847,6 12,6.44771525 12,7 C12,7.55228475 11.5522847,8 11,8 L5,8 C4.44771525,8 4,7.55228475 4,7 C4,6.44771525 4.44771525,6 5,6 L11,6 Z"  fill="currentcolor"></path></g></svg>';
					$opts_out .= 'Solid';
					$opts_out .= '</a>';
					$opts_out .= '</div>';
					$opts_out .= '<input type="text" class="pixfort-selector-search" placeholder="Search..." />';
					$opts_out .= '<div class="pixfort-icons-selector-icons">';
				

					if(!empty($settings['has_empty'])&&$settings['has_empty']){
						$opts_out .= '<span data-id="" data-name="" class="icon-item pixfort-icon type-hidden type-line" width="24" height="24"></span>';
						$opts_out .= '<span data-id="" data-name="" class="icon-item pixfort-icon type-hidden type-duotone" width="24" height="24"></span>';
					}
				
				$opts_out .= '</div>';
				$opts_out .= '</div>';

		 return '<div class="pix_param_block pixfort_icon_picker_container pix_param_icon_out ' . (isset($settings['class']) ? $settings['class'] : '') . '">'.
		 
		 '<div class="pixfort_icon_picker_container_options">'.
			$opts_out.
			'</div>'.
			 '<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value pix_param_val wpb-textinput ' .
			 esc_attr( $settings['param_name'] ) . ' ' .
			 esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" />'
			 .'</div>';
		}

		vc_add_shortcode_param('pixfort_icons_picker', 'pixfort_param_icons_picker', PIX_CORE_PLUGIN_URI .'/functions/js/params/pixfortIcons.js');



		function pix_param_icons_select($settings, $value) {
			require dirname(__FILE__) . '/images/icons_list.php';
			$opts_out = '';
			foreach ($pix_icons_list as $key) {
				$opts_out .= '<div class="pix_param_icon" title="' . $key . '" data-val="' . $key . '"><img src="' . PIX_CORE_PLUGIN_URI . 'functions/images/icons/' . $key . '.svg" /></div>';
			}
			return '<div class="pix_param_block pix_param_icon_out ' . $settings['class'] . '">' .
				'<div style="pading-bottom:5px;"><input type="text" class="pix_param_icons_search" placeholder="Search..." /></div>' .
				'<div class="pix_param_icon_container">' .
				$opts_out .
				'</div>' .
				'<input name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value pix_param_val wpb-textinput ' .
				esc_attr($settings['param_name']) . ' ' .
				esc_attr($settings['type']) . '_field" type="hidden" value="' . esc_attr($value) . '" />'
				. '</div>';
		}

		vc_add_shortcode_param('pix_icons_select', 'pix_param_icons_select', PIX_CORE_PLUGIN_URI . '/functions/js/params/icons.js');


		function pix_param_img_select($settings, $value) {

			$opts_out = '';
			$dividersCount = 26;
			for ($x = 1; $x <= $dividersCount; $x++) {
				$opts_out .= '<div class="pix_param_img" data-val="' . $x . '"><img src="' . PIX_CORE_PLUGIN_URI . 'functions/images/shapes/divider-' . $x . '.png" /></div>';
			}
			return '<div class="pix_param_block ' . $settings['class'] . '">' .
				'<div class="pix_param_img selected" data-val="0"><img src="' . PIX_CORE_PLUGIN_URI . 'functions/images/shapes/none.png" /></div>' .
				'<div class="pix_param_img" data-val="dynamic"><img src="' . PIX_CORE_PLUGIN_URI . 'functions/images/shapes/divider-dynamic.gif" /></div>' .
				$opts_out .

				'<input name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value pix_param_val wpb-textinput ' .
				esc_attr($settings['param_name']) . ' ' .
				esc_attr($settings['type']) . '_field" type="hidden" value="' . esc_attr($value) . '" />'
				. '</div>';
		}

		vc_add_shortcode_param('pix_img_select', 'pix_param_img_select', PIX_CORE_PLUGIN_URI . '/functions/js/params/shapes.js');

		function pix_param_dynamic_image($settings, $value) {
			$empty_label = esc_attr__('No dynamic image selected.', 'pixfort-core');
			$button_label = esc_attr__('Select Dynamic Image', 'pixfort-core');
			$remove_label = esc_attr__('Remove', 'pixfort-core');

			$class = isset($settings['class']) ? $settings['class'] : '';

			return '<div class="pix_param_block pix-dynamic-image-param ' . esc_attr($class) . '">' .
				'<div class="pix-dynamic-image-controls">' .
					'<button type="button" class="button pix-dynamic-image-trigger">' . $button_label . '</button>' .
					'<div class="pix-dynamic-image-selected" data-empty-label="' . $empty_label . '">' .
						'<span class="pix-dynamic-image-label">' . $empty_label . '</span>' .
						'<button type="button" class="button-link pix-dynamic-image-clear">' . $remove_label . '</button>' .
					'</div>' .
				'</div>' .
				'<input name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value pix_param_val wpb-textinput ' .
				esc_attr($settings['param_name']) . ' ' .
				esc_attr($settings['type']) . '_field" type="hidden" value="' . esc_attr($value) . '" />' .
				'</div>';
		}

		vc_add_shortcode_param('pix_dynamic_image', 'pix_param_dynamic_image', PIX_CORE_PLUGIN_URI . '/functions/js/params/dynamic-image.js');



		function pix_param_title($settings, $value) {

			return '<div class="pix_param_block">' .

				esc_attr($settings['param_name']) .

				'<input name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value pix_param_val wpb-textinput ' .
				esc_attr($settings['param_name']) . ' ' .
				esc_attr($settings['type']) . '_field" type="hidden" value="' . esc_attr($value) . '" />'
				. '</div>';
		}

		vc_add_shortcode_param('pix_title', 'pix_param_title');


		function pix_param_globals($settings, $value) {

			return '<div class="pix_param_block">' .
				'<input name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value pix_param_val wpb-textinput ' .
				esc_attr($settings['param_name']) . ' ' .
				esc_attr($settings['type']) . '_field" type="hidden" value="' . esc_attr($value) . '" />'
				. '</div>';
		}

		vc_add_shortcode_param('pix_param_globals', 'pix_param_globals', PIX_CORE_PLUGIN_URI . '/functions/js/params/global.js');


		function pix_param_section($settings, $value) {
			$title = isset($settings['pix_title']) ? $settings['pix_title'] : '';
			return '<div class="pix_param_block">' .
				'<div class="pix_param_section"><hr /><h3><strong>' . $title . '</strong></h3></div>' .

				'<input name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value pix_param_val wpb-textinput ' .
				esc_attr($settings['param_name']) . ' ' .
				esc_attr($settings['type']) . '_field" type="hidden" value="' . esc_attr($value) . '" />'
				. '</div>';
		}

		vc_add_shortcode_param('pix_param_section', 'pix_param_section');

		function pix_param_section_notice($settings, $value) {

			return '<div class="pix_param_block">' .
				'<div class="pix_param_section"><h4>' . $settings['pix_title'] . '</h4></div>' .

				'<input name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value pix_param_val wpb-textinput ' .
				esc_attr($settings['param_name']) . ' ' .
				esc_attr($settings['type']) . '_field" type="hidden" value="' . esc_attr($value) . '" />'
				. '</div>';
		}

		vc_add_shortcode_param('pix_param_section_notice', 'pix_param_section_notice');



		function pix_responsive_css($settings, $value) {
			$props = array('pt', 'pr', 'pb', 'pl', 'mt', 'mr', 'mb', 'ml');

			$opts_out = '<div class="pix_responsive_css_param">';

				$opts_out .= '<div class="pix_responsive_nav">';
					$opts_out .= '<a href="#" class="pix_responsive_nav_item is-active" data-link="#tablet-' . esc_attr($settings['param_name']) . '">' . esc_attr__('Tablet', 'pixfort-core') . '</a>';
					$opts_out .= '<a href="#" class="pix_responsive_nav_item" data-link="#mobile-' . esc_attr($settings['param_name']) . '">' . esc_attr__('Mobile', 'pixfort-core') . '</a>';

				$opts_out .= '</div>';

				$opts_out .= '<div id="mobile-' . esc_attr($settings['param_name']) . '" class="pix_responsive_tab ">';
					$opts_out .= '<div class="pix-responsive-layout-opts">';
						$opts_out .= '<div class="pix_margin_square"><span>' . esc_attr__('Margin', 'pixfort-core') . '</span></div>';
						$opts_out .= '<div class="pix_padding_square"><span>' . esc_attr__('Padding', 'pixfort-core') . '</span></div>';
						foreach ($props as $prop) {
							$opts_out .= '<div class="grid_item pix_res_' . $prop . '"><input type="text" placeholder="-" class="pix_responsive_css_field" name="pix_res_sm_' . $prop . '" /></div>';
						}
					$opts_out .= '</div>';
				$opts_out .= '</div>';

				$opts_out .= '<div id="tablet-' . esc_attr($settings['param_name']) . '" class="pix_responsive_tab show">';
					$opts_out .= '<div class="pix-responsive-layout-opts">';
						$opts_out .= '<div class="pix_margin_square"><span>' . esc_attr__('Margin', 'pixfort-core') . '</span></div>';
						$opts_out .= '<div class="pix_padding_square"><span>' . esc_attr__('Padding', 'pixfort-core') . '</span></div>';
						foreach ($props as $prop) {
							$opts_out .= '<div class="grid_item pix_res_' . $prop . '"><input type="text" placeholder="-" class="pix_responsive_css_field" name="pix_res_md_' . $prop . '" /></div>';
						}
					$opts_out .= '</div>';
				$opts_out .= '</div>';

			$opts_out .= '</div>';

			if (empty($settings['class'])) $settings['class'] = '';
			return '<div class="pix_param_block ' . $settings['class'] . '">' .

				$opts_out .

				'<input name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value pix_res_css_val ' .
				esc_attr($settings['param_name']) . ' ' .
				esc_attr($settings['type']) . '_field" type="hidden" value="' . esc_attr($value) . '" />'
				. '</div>';
		}

		vc_add_shortcode_param('pix_responsive_css', 'pix_responsive_css', PIX_CORE_PLUGIN_URI . '/functions/js/params/responsive.js');
	}



	function pix_gradient_picker($settings, $value) {
		$out = '';
		$out .= '<div class="pix-gradient-picker-container">';
		$out .= '<div class="pix-gradient-picker-el"></div>';
		$out .= ' <div class="inputs">
            <select class="form-control switch-type">
              <option value="">- Select Type -</option>
              <option value="radial">Radial</option>
              <option value="linear">Linear</option>
              <option value="repeating-radial">Repeating Radial</option>
              <option value="repeating-linear">Repeating Linear</option>
            </select>

            <select class="form-control switch-angle">
              <option value="">- Select Direction -</option>
              <option value="top">Top</option>
              <option value="right">Right</option>
              <option value="center">Center</option>
              <option value="bottom">Bottom</option>
              <option value="left">Left</option>
              <option value="45deg">Top Right</option>
              <option value="135deg">Bottom Right</option>
            </select>
          </div>';
		$out .= '<div class="pix-gradient-picker-label">' . esc_attr__('Preview', 'pixfort-core') . ':</div>';
		$out .= '<div class="pix-gradient-picker-preview-container"><div class="pix-gradient-picker-preview"></div></div>';
		$out .= '</div>';
		return '<div class="pix_param_block pix-gradient-picker-block">' . $out .
			'<div class="pix-gradient-picker-label">' . esc_attr__('Gradient CSS output', 'pixfort-core') . ':</div>' .
			'<input name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value pix_param_val wpb-textinput ' .
			esc_attr($settings['param_name']) . ' ' .
			esc_attr($settings['type']) . '_field" type="text" value="' . esc_attr($value) . '" />'
			. '</div>';
	}
	vc_add_shortcode_param('pix_gradient_picker', 'pix_gradient_picker', PIX_CORE_PLUGIN_URI . '/functions/js/params/picker.js');
}
