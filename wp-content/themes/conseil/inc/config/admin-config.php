<?php

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('pix_theme_extra_params')) {
	function pix_theme_extra_params($params) {
		if (is_user_logged_in()) {
			$docsLinks = [
				'docs_link' 					=> 'https://wordpress.pixfort.com/docs/',
				'changelog_link' 				=> 'https://conseil.pixfort.com/changelog/',
				'support_link' 					=> 'https://hub.pixfort.com/login',
				'docs_create_header'			=> 'https://wordpress.pixfort.com/docs/creating-website-header/',
				'docs_create_footer'			=> 'https://wordpress.pixfort.com/docs/creating-website-footer/',
				'docs_create_popup'				=> 'https://wordpress.pixfort.com/docs/how-to-add-popups/',
				'docs_update_theme'				=> 'https://wordpress.pixfort.com/docs/how-to-update-your-theme/',
				'docs_import_demo_content'		=> 'https://wordpress.pixfort.com/docs/importing-demo-content/',
				'docs_pixfort_templates'		=> 'https://wordpress.pixfort.com/docs/pixfort-templates/',
				'docs_how_to_create_menus'		=> 'https://wordpress.pixfort.com/docs/how-to-create-menus/',
				'docs_how_to_add_dividers'		=> 'https://wordpress.pixfort.com/docs/how-to-add-and-edit-dividers/',
				'docs_how_to_translate_website'	=> 'https://wordpress.pixfort.com/docs/translate-your-website-to-multiple-languages/',
				'docs_create_a_shop_with_woocommerce'		=> 'https://wordpress.pixfort.com/docs/create-a-shop-with-woocommerce/',

				'docs_how_to_create_scroll_links'		=> 'https://wordpress.pixfort.com/docs/create-a-one-page-scroll-menu/',
				'docs_how_to_create_blog_page'		=> 'https://wordpress.pixfort.com/docs/how-to-create-a-blog-page/',
				'docs_how_to_create_portfolio_page'		=> 'https://wordpress.pixfort.com/docs/how-to-create-a-portfolio-item-page/',
				'docs_how_to_speed_up_website'		=> 'https://wordpress.pixfort.com/docs/how-to-speed-up-your-website/',

				'docs_server_configuration'		=> 'https://wordpress.pixfort.com/docs/setting-up-the-recommended-server-configuration/',
				'docs_installing_theme'		=> 'https://wordpress.pixfort.com/docs/installing-conseil-theme/',
				'docs_external_fonts'		=> 'https://wordpress.pixfort.com/docs/how-to-use-external-fonts/',
				'docs_popup_custom_css'		=> 'https://wordpress.pixfort.com/docs/popup-custom-css/',
				'docs_how_to_reset'		=> 'https://wordpress.pixfort.com/docs/how-to-reset-your-wordpress-website/',

				'docs_theme_typography'		=> 'https://wordpress.pixfort.com/docs/theme-typography/',
				'docs_how_to_add_social_icons'		=> 'https://wordpress.pixfort.com/docs/how-to-add-social-icons/',
				'docs_how_to_create_edit_sidebars'		=> 'https://wordpress.pixfort.com/docs/how-to-create-and-edit-sidebars/',
				'docs_customize_page_intro_section'		=> 'https://wordpress.pixfort.com/docs/customize-page-intro-section/',
				'docs_add_website_logo'		=> 'https://wordpress.pixfort.com/docs/how-to-add-or-change-website-logo/',
				'docs_add_cookies'		=> 'https://wordpress.pixfort.com/docs/how-to-add-cookie-consent/',
				'docs_use_https'		=> 'https://wordpress.pixfort.com/docs/correcting-wordpress-site-url-to-use-https-protocol/',
				'docs_create_404_page'		=> 'https://wordpress.pixfort.com/docs/create-a-custom-404-error-page/',
				'docs_customize_search_bar'		=> 'https://wordpress.pixfort.com/docs/customize-website-search-bar/',
				'docs_color_system'		=> 'https://wordpress.pixfort.com/docs/color-system/',
				'docs_back_to_top'		=> 'https://wordpress.pixfort.com/docs/customize-back-to-top-button/',
				'docs_google_maps'		=> 'https://wordpress.pixfort.com/docs/using-advanced-google-maps-styles/',
				'docs_import_elementor_demo'		=> 'https://wordpress.pixfort.com/docs/how-to-import-elementor-demo-content/',
				'docs_troubleshooting_errors'		=> 'https://wordpress.pixfort.com/docs/troubleshooting-error-messages/',
				'docs_plugin_failed_installation'		=> 'https://wordpress.pixfort.com/docs/plugin-failed-installation-or-update/',
				'docs_contact_form_7'		=> 'https://wordpress.pixfort.com/docs/contact-7-forms/',
				'docs_create_page_templates'        => 'https://wordpress.pixfort.com/docs/creating-page-templates-in-theme-builder/',
				'docs_global_templates'        => 'https://wordpress.pixfort.com/docs/global-templates/',
				'docs_create_intro'        => 'https://wordpress.pixfort.com/docs/creating-custom-intro/',
			];

			$colors = [
				'color_primary' => '#0389FF',
				'color_secondary' => '#4ADE80',
				'color_gradient_primary_1' => '#1439BB',
				'color_gradient_primary_middle' => '#4ed199',
				'color_gradient_primary_2' => '#0389FF',
				'color_blue' => '#0389FF',
				'color_green' => '#4ADE80',
				'color_cyan' => '#0DD3FF',
				'color_yellow' => '#FFC220',
				'color_orange' => '#FF9900',
				'color_red' => '#FF6C5F',
				'color_brown' => '#806D5E',
				'color_purple' => '#873EFF',

				'color_gray_1' => '#F4F4F5',
				'color_gray_2' => '#E4E4E7',
				'color_gray_3' => '#D4D4D8',
				'color_gray_4' => '#A1A1AA',
				'color_gray_5' => '#71717A',
				'color_gray_6' => '#52525B',
				'color_gray_7' => '#3F3F46',
				'color_gray_8' => '#27272A',
				'color_gray_9' => '#18181B',


				'blog_bg_color' => 'white',
				'portfolio_bg_color' => 'white',
				'shop_bg_color' => 'white',
			];
			$params = array_merge($params, $docsLinks);
			$params = array_merge($params, $colors);
		}

		$misc = [
			'dynamic_colors' => false,
			'custom_colors' => true,
			'fade_mask' => true,
			'sliding_text_animation' => true,
			'custom_intros' => true,
			'custom_templates' => true,
			'custom_header_width' => false,
			'vertical_marquee' => true,
			'template_elements' => true,
			'icons_stroke_width' => '1.75',
			'invert_colors_css' => false,
			'advanced_transforms' => true,
			'enable_pixfort_template' => true,
			'new_border_options' => true,
		];


		// merge the docs links with the params

		$params = array_merge($params, $misc);
		return $params;
	}
}
