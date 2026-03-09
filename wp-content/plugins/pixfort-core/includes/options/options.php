<?php


function pixGetDashboardData () {
	$data = [];
	// $data['test'] = '12';
	$data['ajax_url'] = admin_url('admin-ajax.php');

	/*
	* User name
	*/
	$data['username'] = false;
	$user = wp_get_current_user();
	if ( $user->ID != 0 ) {
		// User is logged in
		$data['username'] = esc_html( $user->display_name );
	}
	/*
	* Plugins
	*/
	if(class_exists('PixFort_Plugins_Setup')){
		$pluginsInstance = PixFort_Plugins_Setup::get_instance();
    	$plugins = $pluginsInstance->_get_plugins_data(true);
		$data['plugins_data'] = $plugins;
		$data['tgm_data'] = [
			'tgm_plugin_nonce' => [
				'update'  => wp_create_nonce('tgmpa-update'),
				'install' => wp_create_nonce('tgmpa-install'),
			],
			'tgm_bulk_url'     => admin_url('themes.php?page=tgmpa-install-plugins'),
			'ajaxurl'          => admin_url('admin-ajax.php'),
			'wpnonce'          => wp_create_nonce('envato_setup_nonce'),
		];
	}

	/*
	* Server status
	*/
	include_once('server-status.php');
	$data['server_status'] = pixServerStatus();
	
	/*
	* Links
	*/
	$data['site_link'] = site_url();
	$data['headers_link'] = admin_url('edit.php?post_type=pixheader');
	$data['footers_link'] = admin_url('edit.php?post_type=pixfooter');
	$data['popups_link'] = admin_url('edit.php?post_type=pixpopup');

	$data['docs_link'] = \PixfortCore::instance()->adminCore->getParam('docs_link');
	$data['changelog_link'] = \PixfortCore::instance()->adminCore->getParam('changelog_link');
	$data['support_link'] = \PixfortCore::instance()->adminCore->getParam('support_link');

	$data['docs_create_header'] = \PixfortCore::instance()->adminCore->getParam('docs_create_header');
	$data['docs_create_footer'] = \PixfortCore::instance()->adminCore->getParam('docs_create_footer');
	$data['docs_create_popup'] = \PixfortCore::instance()->adminCore->getParam('docs_create_popup');
	$data['docs_import_demo_content'] = \PixfortCore::instance()->adminCore->getParam('docs_import_demo_content');
	$data['docs_update_theme'] = \PixfortCore::instance()->adminCore->getParam('docs_update_theme');
	
	/*
	* Security nonce for AJAX requests
	*/
	$data['ajax_nonce'] = wp_create_nonce('pixfort_ajax_nonce');
	$data['docs_pixfort_templates'] = \PixfortCore::instance()->adminCore->getParam('docs_pixfort_templates');
	$data['docs_how_to_create_menus'] = \PixfortCore::instance()->adminCore->getParam('docs_how_to_create_menus');
	$data['docs_how_to_add_dividers'] = \PixfortCore::instance()->adminCore->getParam('docs_how_to_add_dividers');
	$data['docs_how_to_translate_website'] = \PixfortCore::instance()->adminCore->getParam('docs_how_to_translate_website');
	$data['docs_create_a_shop_with_woocommerce'] = \PixfortCore::instance()->adminCore->getParam('docs_create_a_shop_with_woocommerce');

	$data['docs_how_to_create_scroll_links'] = \PixfortCore::instance()->adminCore->getParam('docs_how_to_create_scroll_links');
	$data['docs_how_to_create_blog_page'] = \PixfortCore::instance()->adminCore->getParam('docs_how_to_create_blog_page');
	$data['docs_how_to_create_portfolio_page'] = \PixfortCore::instance()->adminCore->getParam('docs_how_to_create_portfolio_page');
	$data['docs_how_to_speed_up_website'] = \PixfortCore::instance()->adminCore->getParam('docs_how_to_speed_up_website');
	$data['docs_how_to_translate_website'] = \PixfortCore::instance()->adminCore->getParam('docs_how_to_translate_website');
	
	$data['docs_server_configuration'] = \PixfortCore::instance()->adminCore->getParam('docs_server_configuration');
	$data['docs_installing_theme'] = \PixfortCore::instance()->adminCore->getParam('docs_installing_theme');
	$data['docs_how_to_reset'] = \PixfortCore::instance()->adminCore->getParam('docs_how_to_reset');
	$data['docs_plugin_failed_installation'] = \PixfortCore::instance()->adminCore->getParam('docs_plugin_failed_installation');
	$data['docs_troubleshooting_errors'] = \PixfortCore::instance()->adminCore->getParam('docs_troubleshooting_errors');
	$data['docs_contact_form_7'] = \PixfortCore::instance()->adminCore->getParam('docs_contact_form_7');

	/*
	* Activation data
	*/

	if (defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG) {
		$key = false;
		switch (PIXFORT_THEME_SLUG) {
			case 'essentials':
				$key = get_option('envato_purchase_code_27889640');
				break;
			case 'acquire':
				$key = get_option('envato_purchase_code_27889640');
				break;
			case 'inspiron':
				$key = get_option('envato_purchase_code_27889640');
				break;
			case 'conseil':
				$key = get_option('envato_purchase_code_61457003');
				break;
			case 'pixfort':
				$key = get_option('pixfort_purchase_code_1');
				break;
			default:
				break;
		}	
		if ($key) {
			$data['purchase_code'] = $key;
		}
	}
	

	return $data;
}

function pixDisplayOptions($print = true) {
	$colors = array(
		__("Primary", 'pixfort-core')               => "primary",
		__("Primary Gradient", 'pixfort-core')      => "gradient-primary",
		__("Secondary", 'pixfort-core')             => "secondary",
		__("Primary Gradient", 'pixfort-core')      => "gradient-primary",
		__("White", 'pixfort-core')                 => "white",
		__("Black", 'pixfort-core')                 => "black",
		__("Green", 'pixfort-core')                 => "green",
		__("Blue", 'pixfort-core')                  => "blue",
		__("Red", 'pixfort-core')                   => "red",
		__("Yellow", 'pixfort-core')                => "yellow",
		__("Brown", 'pixfort-core')                 => "brown",
		__("Purple", 'pixfort-core')                => "purple",
		__("Orange", 'pixfort-core')                => "orange",
		__("Cyan", 'pixfort-core')                  => "cyan",
		__("Gray 1", 'pixfort-core')                => "gray-1",
		__("Gray 2", 'pixfort-core')                => "gray-2",
		__("Gray 3", 'pixfort-core')                => "gray-3",
		__("Gray 4", 'pixfort-core')                => "gray-4",
		__("Gray 5", 'pixfort-core')                => "gray-5",
		__("Gray 6", 'pixfort-core')                => "gray-6",
		__("Gray 7", 'pixfort-core')                => "gray-7",
		__("Gray 8", 'pixfort-core')                => "gray-8",
		__("Gray 9", 'pixfort-core')                => "gray-9",
		__("Dark opacity 1", 'pixfort-core')        => "dark-opacity-1",
		__("Dark opacity 2", 'pixfort-core')        => "dark-opacity-2",
		__("Dark opacity 3", 'pixfort-core')        => "dark-opacity-3",
		__("Dark opacity 4", 'pixfort-core')        => "dark-opacity-4",
		__("Dark opacity 5", 'pixfort-core')        => "dark-opacity-5",
		__("Dark opacity 6", 'pixfort-core')        => "dark-opacity-6",
		__("Dark opacity 7", 'pixfort-core')        => "dark-opacity-7",
		__("Dark opacity 8", 'pixfort-core')        => "dark-opacity-8",
		__("Dark opacity 9", 'pixfort-core')        => "dark-opacity-9",
		__("Light opacity 1", 'pixfort-core')       => "light-opacity-1",
		__("Light opacity 2", 'pixfort-core')       => "light-opacity-2",
		__("Light opacity 3", 'pixfort-core')       => "light-opacity-3",
		__("Light opacity 4", 'pixfort-core')       => "light-opacity-4",
		__("Light opacity 5", 'pixfort-core')       => "light-opacity-5",
		__("Light opacity 6", 'pixfort-core')       => "light-opacity-6",
		__("Light opacity 7", 'pixfort-core')       => "light-opacity-7",
		__("Light opacity 8", 'pixfort-core')       => "light-opacity-8",
		__("Light opacity 9", 'pixfort-core')       => "light-opacity-9",
		__("Custom", 'pixfort-core')                => "custom"
	);
	$bg_colors_no_custom = array(
		__("Transparent", 'pixfort-core')            => "transparent",
		__("Primary", 'pixfort-core')                => "primary",
		__("Primary Light", 'pixfort-core')            => "primary-light",
		__("Primary Gradient", 'pixfort-core')        => "gradient-primary",
		__("Primary Gradient Light", 'pixfort-core')        => "gradient-primary-light",
		__("Secondary", 'pixfort-core')                => "secondary",
		__("Secondary Light", 'pixfort-core')        => "secondary-light",
		__("White", 'pixfort-core')                    => "white",
		__("Black", 'pixfort-core')                    => "black",
		__("Green", 'pixfort-core')                    => "green",
		__("Green Light", 'pixfort-core')            => "green-light",
		__("Blue", 'pixfort-core')                    => "blue",
		__("Blue Light", 'pixfort-core')            => "blue-light",
		__("Red", 'pixfort-core')                    => "red",
		__("Red Light", 'pixfort-core')                => "red-light",
		__("Yellow", 'pixfort-core')                => "yellow",
		__("Yellow Light", 'pixfort-core')            => "yellow-light",
		__("Brown", 'pixfort-core')                    => "brown",
		__("Brown Light", 'pixfort-core')            => "brown-light",
		__("Purple", 'pixfort-core')                => "purple",
		__("Purple Light", 'pixfort-core')            => "purple-light",
		__("Orange", 'pixfort-core')                => "orange",
		__("Orange Light", 'pixfort-core')            => "orange-light",
		__("Cyan", 'pixfort-core')                    => "cyan",
		__("Cyan Light", 'pixfort-core')            => "cyan-light",
		__("Gray 1", 'pixfort-core')                => "gray-1",
		__("Gray 2", 'pixfort-core')                => "gray-2",
		__("Gray 3", 'pixfort-core')                => "gray-3",
		__("Gray 4", 'pixfort-core')                => "gray-4",
		__("Gray 5", 'pixfort-core')                => "gray-5",
		__("Gray 6", 'pixfort-core')                => "gray-6",
		__("Gray 7", 'pixfort-core')                => "gray-7",
		__("Gray 8", 'pixfort-core')                => "gray-8",
		__("Gray 9", 'pixfort-core')                => "gray-9",
		__("Dark opacity 1", 'pixfort-core')        => "dark-opacity-1",
		__("Dark opacity 2", 'pixfort-core')        => "dark-opacity-2",
		__("Dark opacity 3", 'pixfort-core')        => "dark-opacity-3",
		__("Dark opacity 4", 'pixfort-core')        => "dark-opacity-4",
		__("Dark opacity 5", 'pixfort-core')        => "dark-opacity-5",
		__("Dark opacity 6", 'pixfort-core')        => "dark-opacity-6",
		__("Dark opacity 7", 'pixfort-core')        => "dark-opacity-7",
		__("Dark opacity 8", 'pixfort-core')        => "dark-opacity-8",
		__("Dark opacity 9", 'pixfort-core')        => "dark-opacity-9",
		__("Light opacity 1", 'pixfort-core')        => "light-opacity-1",
		__("Light opacity 2", 'pixfort-core')        => "light-opacity-2",
		__("Light opacity 3", 'pixfort-core')        => "light-opacity-3",
		__("Light opacity 4", 'pixfort-core')        => "light-opacity-4",
		__("Light opacity 5", 'pixfort-core')        => "light-opacity-5",
		__("Light opacity 6", 'pixfort-core')        => "light-opacity-6",
		__("Light opacity 7", 'pixfort-core')        => "light-opacity-7",
		__("Light opacity 8", 'pixfort-core')        => "light-opacity-8",
		__("Light opacity 9", 'pixfort-core')        => "light-opacity-9"
	);

	// $main_colors = array(
	// 	__("Primary", 'pixfort-core')               => "primary",
	// 	__("Secondary", 'pixfort-core')             => "secondary",
	// 	__("White", 'pixfort-core')                 => "white",
	// 	__("Black", 'pixfort-core')                 => "black",
	// 	__("Green", 'pixfort-core')                 => "green",
	// 	__("Blue", 'pixfort-core')                  => "blue",
	// 	__("Red", 'pixfort-core')                   => "red",
	// 	__("Yellow", 'pixfort-core')                => "yellow",
	// 	__("Brown", 'pixfort-core')                 => "brown",
	// 	__("Purple", 'pixfort-core')                => "purple",
	// 	__("Orange", 'pixfort-core')                => "orange",
	// 	__("Cyan", 'pixfort-core')                  => "cyan",
	// 	__("Gray 1", 'pixfort-core')                => "gray-1",
	// 	__("Gray 2", 'pixfort-core')                => "gray-2",
	// 	__("Gray 3", 'pixfort-core')                => "gray-3",
	// 	__("Gray 4", 'pixfort-core')                => "gray-4",
	// 	__("Gray 5", 'pixfort-core')                => "gray-5",
	// 	__("Gray 6", 'pixfort-core')                => "gray-6",
	// 	__("Gray 7", 'pixfort-core')                => "gray-7",
	// 	__("Gray 8", 'pixfort-core')                => "gray-8",
	// 	__("Gray 9", 'pixfort-core')                => "gray-9",
	// 	__("Dark opacity 1", 'pixfort-core')        => "dark-opacity-1",
	// 	__("Dark opacity 2", 'pixfort-core')        => "dark-opacity-2",
	// 	__("Dark opacity 3", 'pixfort-core')        => "dark-opacity-3",
	// 	__("Dark opacity 4", 'pixfort-core')        => "dark-opacity-4",
	// 	__("Dark opacity 5", 'pixfort-core')        => "dark-opacity-5",
	// 	__("Dark opacity 6", 'pixfort-core')        => "dark-opacity-6",
	// 	__("Dark opacity 7", 'pixfort-core')        => "dark-opacity-7",
	// 	__("Dark opacity 8", 'pixfort-core')        => "dark-opacity-8",
	// 	__("Dark opacity 9", 'pixfort-core')        => "dark-opacity-9",
	// 	__("Light opacity 1", 'pixfort-core')       => "light-opacity-1",
	// 	__("Light opacity 2", 'pixfort-core')       => "light-opacity-2",
	// 	__("Light opacity 3", 'pixfort-core')       => "light-opacity-3",
	// 	__("Light opacity 4", 'pixfort-core')       => "light-opacity-4",
	// 	__("Light opacity 5", 'pixfort-core')       => "light-opacity-5",
	// 	__("Light opacity 6", 'pixfort-core')       => "light-opacity-6",
	// 	__("Light opacity 7", 'pixfort-core')       => "light-opacity-7",
	// 	__("Light opacity 8", 'pixfort-core')       => "light-opacity-8",
	// 	__("Light opacity 9", 'pixfort-core')       => "light-opacity-9",
	// 	__("Custom", 'pixfort-core')                => "custom"
	// );

	$popup_posts = get_posts([
		'post_type' => 'pixpopup',
		'post_status' => array('publish', 'private'),
		'numberposts' => -1
	]);
	$popups = array();
	$popups[''] = "Disabled";
	foreach ($popup_posts as $key => $value) {
		if (empty($value->post_title)) {
			$popups[$value->ID] = __('No name', 'pixfort-core');
		} else {
			$popups[$value->ID] = $value->post_title;
		}
	}

	$pages_posts = get_posts([
		'post_type' => 'page',
		'post_status' => array('publish', 'private'),
		'numberposts' => -1
	]);

	$pages = array();
	$pages[''] = "Disabled";
	foreach ($pages_posts as $key => $value) {
		if (empty($value->post_title)) {
			$pages[$value->ID] = __('No name', 'pixfort-core');
		} else {
			$pages[$value->ID] = $value->post_title;
		}
	}

	$header_posts = get_posts([
		'post_type' => 'pixheader',
		'post_status' => array('publish', 'private'),
		'numberposts' => -1
	]);
	$headers = array();
	foreach ($header_posts as $key => $value) {
		if (empty($value->post_title)) {
			$headers[$value->ID] = __('No name', 'pixfort-core');
		} else {
			$headers[$value->ID] = $value->post_title;
		}
	}
	$website_header = pix_plugin_get_option('pix-header');
	if ($website_header && $website_header === 'default') {
		$headers['default'] = "Default";
	} 
	$headers['disable'] = "Disable";

	$footer_posts = get_posts([
		'post_type' => 'pixfooter',
		'post_status' => array('publish', 'private'),
		'numberposts' => -1
	]);
	$footers = array();
	foreach ($footer_posts as $key => $value) {
		if (empty($value->post_title)) {
			$footers[$value->ID] = __('No name', 'pixfort-core');
		} else {
			$footers[$value->ID] = $value->post_title;
		}
	}
	$website_footer = pix_plugin_get_option('pix-footer');
	if ($website_footer && $website_footer === '') {
		$footers[''] = "Disable";
	} else {
		$footers['disable'] = "Disable";
	}

	$bg_colors = $bg_colors_no_custom;
	$bg_colors['Custom'] = "custom";

	$sidebars = array();
	$sidebars['sidebar-1'] = 'Main Sidebar';
	if (!empty(pix_plugin_get_option('pix_sidebars'))) {
		foreach (pix_plugin_get_option('pix_sidebars') as $key => $value) {
			$sidebars['sidebar-' . str_replace(' ', '', $value)] = $value;
		}
	}

	$pixfortBuilder = new PixfortOptions();

	$pixfortDashboardLink = admin_url('admin.php?page=pixfort-theme-dashboard');
	$pixfortDemoImportLink = false;
	if (class_exists('PIX_OCDI')) {
		$pixfortDemoImportLink = admin_url('admin.php?page=pixfort-options#/demo-import');
	}
	$previewSiteLink = site_url();

	$active = false;
	$code = get_option('envato_purchase_code_27889640');
	if (defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG) {
		switch (PIXFORT_THEME_SLUG) {
			case 'essentials':
				$code = get_option('envato_purchase_code_27889640');
				break;
			case 'acquire':
				$code = get_option('envato_purchase_code_27889640');
				break;
			case 'conseil':
				$code = get_option('envato_purchase_code_61457003');
				break;
			case 'pixfort':
				$code = get_option('pixfort_purchase_code_1');
				break;
			default:
				break;
		}	
	}
	if ($code) {
		$active = true;
	}

	if (!$print) {
		$pixfortBuilder->setDisplay( false );
	}

	$version = PIXFORT_PLUGIN_VERSION;
	if(defined('PIXFORT_THEME_VERSION')){
		$version = PIXFORT_THEME_VERSION;
	}
	
	$pixfortBuilder->initOptions(
		'core-options',
		false,
		true,
		[
			'tabs'  => [
				'generalSettings'    => [
					'title'     => __('Settings', 'pixfort-core'),
					'icon'      => 'general',
					'tabs'     => [
						'settings'    => ['title'    => __('General', 'pixfort-core'), 'icon' => 'general'],
						'sidebars'    => ['title'    => __('Sidebars', 'pixfort-core'), 'icon' => 'general'],
						'apiKeys'    => ['title'    => __('API Keys', 'pixfort-core'), 'icon' => 'general'],
						'cookies'    => ['title'    => __('Cookie Consent', 'pixfort-core'), 'icon' => 'general'],
						'pageTransition'    => ['title'    => __('Page Transition', 'pixfort-core'), 'icon' => 'general'],
						'page404'    => ['title'    => __('404 Page', 'pixfort-core'), 'icon' => 'general'],
						'elementor'    => ['title'    => __('Elementor', 'pixfort-core'), 'icon' => 'general'],
						'advanced'    => ['title'    => __('Advanced', 'pixfort-core'), 'icon' => 'advanced'],
					]
				],
				'layout'    => [
					'title'     => __('Layout', 'pixfort-core'),
					'icon'      => 'layout',
					'tabs'     => [
						'header'    => ['title'    => __('Header', 'pixfort-core'), 'icon' => 'triggers'],
						'footer'    => ['title'    => __('Footer', 'pixfort-core'), 'icon' => 'triggers'],
						'banner'    => ['title'    => __('Banner', 'pixfort-core'), 'icon' => 'triggers'],
						'search'    => ['title'    => __('Search', 'pixfort-core'), 'icon' => 'triggers'],
						'socialIcons'    => ['title'    => __('Social Icons', 'pixfort-core'), 'icon' => 'triggers'],
						// 'colors'    => ['title'    => __('Colors', 'pixfort-core'), 'icon' => 'triggers'],
						'layoutAdvanced'    => ['title'    => __('Advanced', 'pixfort-core'), 'icon' => 'design'],
					]
				],
				'design'    => [
					'title'     => __('Design System', 'pixfort-core'),
					'icon'      => 'design',
					'tabs'     => [
						'colors'    => ['title'    => __('Colors', 'pixfort-core'), 'icon' => 'triggers'],
						'buttons'    => ['title'    => __('Buttons', 'pixfort-core'), 'icon' => 'triggers'],
						'icons'    => ['title'    => __('Icons', 'pixfort-core'), 'icon' => 'triggers'],
					]
				],
				'typography'    => [
					'title'     => __('Typography', 'pixfort-core'),
					'icon'      => 'typography',
					'tabs'     => [
						'typographyGeneral'    => ['title'    => __('General', 'pixfort-core')],
						'typographyAdvanced'    => ['title'    => __('Advanced', 'pixfort-core')],
						// 'icons'    => ['title'    => __('Icons', 'pixfort-core')],
					]
				],
				'blog'    => [
					'title'     => __('Blog', 'pixfort-core'),
					'icon'      => 'blog',
					'tabs'     => [
						'blogGeneral'    => ['title'    => __('General', 'pixfort-core')],
						'blogIntro'    => ['title'    => __('Intro', 'pixfort-core')],
						'blogAdvanced'    => ['title'    => __('Advanced', 'pixfort-core')],
					]
				],
				'portfolio'    => [
					'title'     => __('Portfolio', 'pixfort-core'),
					'icon'      => 'portfolio',
					'tabs'     => [
						'portfolioGeneral'    => ['title'    => __('General', 'pixfort-core')],
						'portfolioIntro'    => ['title'    => __('Intro', 'pixfort-core')],
					]
				],
				'pages'    => [
					'title'     => __('Pages', 'pixfort-core'),
					'icon'      => 'pages',
					'tabs'     => [
						'pagesGeneral'    => ['title'    => __('General', 'pixfort-core')],
						'pagesIntro'    => ['title'    => __('Intro', 'pixfort-core')],
					]
				],
				
				'shop'    => [
					'title'     => __('Shop', 'pixfort-core'),
					'icon'      => 'shop',
					'tabs'     => [
						'shopGeneral'    => ['title'    => __('General', 'pixfort-core')],
						'shopIntro'    => ['title'    => __('Intro', 'pixfort-core')],
						'shopAdvanced'    => ['title'    => __('Advanced', 'pixfort-core')],
					]
				],
				'importExport'    => [
					'title'     => __('Import / Export', 'pixfort-core'),
					'icon'      => 'importExport',
					'tabs'     => [
						'importExportGeneral'    => ['title'    => __('General', 'pixfort-core')],
					]
				],

			],
			'version' => $version,
			'active' => $active,
			'pixfortDashboardLink' => $pixfortDashboardLink,
			'pixfortDemoImportLink' => $pixfortDemoImportLink,
			'previewSiteLink' => $previewSiteLink,
			'helpLink' => \PixfortCore::instance()->adminCore->getParam('docs_link'),
			'DemoImportLink' => \PixfortCore::instance()->adminCore->getParam('docs_link'),
			'dashboard_data' => pixGetDashboardData()
		]
	);

	$opts_dividers = [];
	array_push(
		$opts_dividers,
		[
			'image'   => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/dividers/none.svg',
			'value'            => '0'
		]
	);
	$dividersCount = 26;
	for ($x = 1; $x <= $dividersCount; $x++) {
		array_push(
			$opts_dividers,
			[
				'image'   => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/dividers/divider-' . $x . '.svg',
				'value'            => (string) $x
			]
		);
	}







	/*
    *   Header
    */
	$pixfortBuilder->addOption(
		'pix-heading-header',
		[
			'type'             => 'heading',
			'label'         => __('Header', 'pixfort-core'),
			'tab'             => 'header',
			'icon'            => 'header',
			'linkText'            => __('Learn about website header', 'pixfort-core'),
			'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_create_header'),
			'linkIcon'            => 'bookmark'
		]
	);
	$pixfortBuilder->addOption(
		'pix-header',
		[
			'type' => 'select',
			'label' => __('Website Header', 'pixfort-core'),
			'description' => __('The default header displayed on all website pages.', 'pixfort-core'),
			'tooltipText'   => __('The headers in your website can be customized using the Header Builder (WordPress Admin Panel → Theme Builder → Headers).', 'pixfort-core'),
			'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/core-options/tooltips/core-options-tooltip-website-header.webp',
			'tab'             => 'header',
			'default'   => 'default',
			'options' => $headers,
			'showBorderTop'   => false,
			'hideBorderBottom'   => false
		]
	);
	$pixfortBuilder->addOption(
		'pix-alert-header',
		[
			'type'             => 'alert',
			'tab'             => 'header',
			// 'label'             => 'Use',
			'description'     => __('For detailed information about setting up the header check this article from our knowledge base:', 'pixfort-core'),
			// 'hidePaddingTop' => true,
			// 'hidePaddingBottom' => true,
			'style' => 'simple',
			'icon'  =>  'info',
			'linkOneText'  =>  __('Learn more about Headers', 'pixfort-core'),
			'linkOneHref'  =>  \PixfortCore::instance()->adminCore->getParam('docs_create_header'),
			'linkOneIcon'  =>  'bookmark'
		]
	);
	/*
    *   Footer
    */
	$pixfortBuilder->addOption(
		'pix-heading-footer',
		[
			'type'             => 'heading',
			'label'         => __('Footer', 'pixfort-core'),
			'tab'             => 'footer',
			'icon'            => 'footer',
			'linkText'  =>  __('Learn about website footer', 'pixfort-core'),
			'linkHref'  =>  \PixfortCore::instance()->adminCore->getParam('docs_create_footer'),
			'linkIcon'  =>  'bookmark'
		]
	);
	$pixfortBuilder->addOption(
		'pix-footer',
		[
			'type' => 'select',
			'label' => __('Website Footer', 'pixfort-core'),
			'description' => __('The default footer displayed on all website pages.', 'pixfort-core'),
			'tooltipText'   => __('The footers in your website can be customized using the Footer Builder (WordPress Admin Panel → Theme Builder → Footers).', 'pixfort-core'),
			'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/core-options/tooltips/core-options-tooltip-website-footer.webp',
			'tab'             => 'footer',
			'default'   => 'default',
			'showBorderTop'   => false,
			'options' => $footers
		]
	);
	$pixfortBuilder->addOption(
		'pix-sticky-footer',
		[
			'type' => 'checkbox',
			'label' => __('Enable Desktop Sticky Footer', 'pixfort-core'),
			'options'         => array('1' => 'On', '0' => 'Off'),
			'default'           => '0',
			'tab'             => 'footer',
			'tooltipText'   => __('Sticky Footer option fixes the footer to the bottom of the viewport. As you scroll down the page, the page content moves over the footer until it\'s fully revealed', 'pixfort-core'),
		]
	);
	$pixfortBuilder->addOption(
		'sticky-footer-bg-color',
		[
			'type' => 'select',
			'label' => __('Sticky Footer Fade Color', 'pixfort-core'),
			'tab'             => 'footer',
			'tooltipText'   => __('Sticky Footer Fade Color refers to an overlay color that gradually disappears as the sticky footer appears on the page.', 'pixfort-core'),
			'default'   => 'gradient-primary',
			// 'options' => array_flip($bg_colors),
			'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
			'groups' => true,
			'hideBorderBottom'   => false,
			'dependency' => [
				'field' => 'pix-sticky-footer',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'custom-sticky-footer-bg-color',
		[
			'type'             => 'color',
			'tab'             => 'footer',
			'label'         => __('Custom Sticky Footer Fade Color', 'pixfort-core'),
			'default'         => '#ffffff',
			'disableAlpha'         => true,
			'enableReset'	  => true,
			'dependency' => [
				'field' => 'sticky-footer-bg-color',
				'val' => ['custom']
			],
			'showBorderTop'   => false,
			'hideBorderBottom'   => false
		]
	);
	$pixfortBuilder->addOption(
		'pix-alert-footer',
		[
			'type'             => 'alert',
			'tab'             => 'footer',
			// 'label'             => 'Use',
			'description'     => __('For detailed information about setting up the footer check this article from our knowledge base:', 'pixfort-core'),
			// 'hidePaddingTop' => true,
			// 'hidePaddingBottom' => true,
			'style' => 'simple',
			'icon'  =>  'info',
			'linkOneText'  =>  __('Learn more about Footers', 'pixfort-core'),
			'linkOneHref'  =>  \PixfortCore::instance()->adminCore->getParam('docs_create_footer'),
			'linkOneIcon'  =>  'bookmark'
		]
	);
	/*
    *   Banner
    */
	$pixfortBuilder->addOption(
		'pix-heading-banner',
		[
			'type'             => 'heading',
			'label'         => __('Banner', 'pixfort-core'),
			'tab'             => 'banner',
			'icon'            => 'megaphone'
		]
	);
	$pixfortBuilder->addOption(
		'show-banner',
		[
			'type' => 'checkbox',
			'label' => __('Show Banner', 'pixfort-core'),
			'description' => __('Enable this option to display a banner at the very top of your website.', 'pixfort-core'),
			'tooltipText'   => __('A banner at the very top of your website, above the header area, useful for announcements, promotions, or important notices.', 'pixfort-core'),
			'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/core-options/tooltips/core-options-tooltip-website-banner.webp',
			'options'         => array('1' => 'On', '0' => 'Off'),
			'default'           => '0',
			'tab'             => 'banner',
			'hideBorderBottom'   => true
		]
	);
	$pixfortBuilder->addOption(
		'banner-id',
		[
			'type' => 'text',
			'label' => __('Banner ID', 'pixfort-core'),
			'tab'             => 'banner',
			'description' => __('Changing the ID will reset the closed state for all users (all users will start to see the banner again).', 'pixfort-core'),
			'default'  => 'Banner-1',
			'dependency' => [
				'field' => 'show-banner',
				'val' => ['1', true]
			],
			'showBorderTop'   => true
		]
	);
	$pixfortBuilder->addOption(
		'banner-text',
		[
			'type' => 'text',
			'label' => __('Banner Text', 'pixfort-core'),
			'tab'             => 'banner',
			'dependency' => [
				'field' => 'show-banner',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'banner-bg',
		[
			'type' => 'select',
			'label' => __('Banner Background Color', 'pixfort-core'),
			// 'options' => array_flip($bg_colors),
			'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
			'groups' => true,
			'tab'             => 'banner',
			'dependency' => [
				'field' => 'show-banner',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'custom-banner-bg',
		[
			'type'             => 'color',
			'tab'             => 'banner',
			'label'         => __('Custom Banner Color', 'pixfort-core'),
			'default'         => '#FFFFFF',
			'disableAlpha'         => true,
			'dependency' => [
				'field' => 'banner-bg',
				'val' => ['custom']
			]
		]
	);
	$pixfortBuilder->addOption(
		'banner-bg-img',
		[
			'type'             => 'media',
			'label'         => __('Banner Background Image', 'pixfort-core'),
			'default'         => '',
			'tab'             => 'banner',
			'dependency' => [
				'field' => 'show-banner',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'bold-banner-text',
		[
			'type' => 'checkbox',
			'label' => __('Bold Banner Text', 'pixfort-core'),
			'options'         => array('1' => 'On', '0' => 'Off'),
			'default'           => '1',
			'tab'             => 'banner',
			'dependency' => [
				'field' => 'show-banner',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'secondary-banner-text',
		[
			'type' => 'checkbox',
			'label' => __('Use Secondary Font for Banner Text', 'pixfort-core'),
			'options'         => array('1' => 'On', '0' => 'Off'),
			'default'           => '0',
			'tab'             => 'banner',
			'dependency' => [
				'field' => 'show-banner',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'banner-text-color',
		[
			'type' => 'select',
			'label' => __('Text Color', 'pixfort-core'),
			'description' => __('Pick the text color.', 'pixfort-core'),
			'tab'             => 'banner',
			'default'   => 'gray-9',
			// 'options' => array_flip($colors),
			'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(),
            'groups' => true,
			'dependency' => [
				'field' => 'show-banner',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'banner-custom-text-color',
		[
			'type'             => 'color',
			'tab'             => 'banner',
			'label'         => __('Custom Banner Text Color', 'pixfort-core'),
			'default'         => '#212529',
			'disableAlpha'         => true,
			'dependency' => [
				'field' => 'banner-text-color',
				'val' => ['custom']
			]
		]
	);
	$pixfortBuilder->addOption(
		'show-banner-btn',
		[
			'type' => 'checkbox',
			'label' => __('Show Banner Button', 'pixfort-core'),
			'options'         => array('1' => 'On', '0' => 'Off'),
			'default'           => '0',
			'tab'             => 'banner',
			'dependency' => [
				'field' => 'show-banner',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'banner-btn-text',
		[
			'type' => 'text',
			'label' => __('Banner Button Text', 'pixfort-core'),
			'tab'             => 'banner',
			'default'  => 'Check it Now',
			'dependency' => [
				'field' => 'show-banner-btn',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'banner-btn-link',
		[
			'type' => 'text',
			'label' => __('Banner Link', 'pixfort-core'),
			'tab'             => 'banner',
			'default'             => '#',
			'dependency' => [
				'field' => 'show-banner-btn',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'show-banner-target',
		[
			'type' => 'checkbox',
			'label' => __('Open Banner Link in a New Tab', 'pixfort-core'),
			'options'         => array('1' => 'On', '0' => 'Off'),
			'default'           => '1',
			'tab'             => 'banner',
			'dependency' => [
				'field' => 'show-banner-btn',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'banner-btn-style',
		[
			'type' => 'select',
			'label' => __('Banner Button Style', 'pixfort-core'),
			'description' => __('Pick the text color.', 'pixfort-core'),
			'tab'             => 'banner',
			'default'   => '',
			'options' => [
				""            => __("Default", 'pixfort-core'),
				"flat"        => __("Flat", 'pixfort-core'),
				"line"        => __("Line", 'pixfort-core'),
				"outline"     => __("Outline", 'pixfort-core'),
				"underline"     => __("Underline", 'pixfort-core'),
				"blink"     => __("Blink", 'pixfort-core')
			],
			'dependency' => [
				'field' => 'show-banner-btn',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'banner-btn-color',
		[
			'type' => 'select',
			'label' => __('Banner Button Color', 'pixfort-core'),
			'description' => __('Pick the text color.', 'pixfort-core'),
			'tab'             => 'banner',
			'default'   => 'primary',
			'options' => [
				'primary'         => __('Primary', 'pixfort-core'),
				'primary-light'         => __('Primary Light', 'pixfort-core'),
				'secondary'        => __('Secondary', 'pixfort-core'),
				'light'         => __('Light', 'pixfort-core'),
				'dark'             => __('Dark', 'pixfort-core'),
				'black'         => __('Black', 'pixfort-core'),
				'link'             => __('Link', 'pixfort-core'),
				'white'         => __('White', 'pixfort-core'),
				'blue'             => __('Blue', 'pixfort-core'),
				'red'             => __('Red', 'pixfort-core'),
				'cyan'             => __('Cyan', 'pixfort-core'),
				'orange'             => __('Orange', 'pixfort-core'),
				'green'             => __('Green', 'pixfort-core'),
				'purple'             => __('Purple', 'pixfort-core'),
				'brown'             => __('Brown', 'pixfort-core'),
				'yellow'             => __('Yellow', 'pixfort-core'),
				'bg-gradient-primary'             => __('Primary gradient', 'pixfort-core'),
				"gray-1" => __('Gray 1', 'pixfort-core'),
				"gray-2" => __('Gray 2', 'pixfort-core'),
				"gray-3" => __('Gray 3', 'pixfort-core'),
				"gray-4" => __('Gray 4', 'pixfort-core'),
				"gray-5" => __('Gray 5', 'pixfort-core'),
				"gray-6" => __('Gray 6', 'pixfort-core'),
				"gray-7" => __('Gray 7', 'pixfort-core'),
				"gray-8" => __('Gray 8', 'pixfort-core'),
				"gray-9" => __('Gray 9', 'pixfort-core'),
				"bg-dark-opacity-1" => __('Dark opacity 1', 'pixfort-core'),
				"bg-dark-opacity-2" => __('Dark opacity 2', 'pixfort-core'),
				"bg-dark-opacity-3" => __('Dark opacity 3', 'pixfort-core'),
				"bg-dark-opacity-4" => __('Dark opacity 4', 'pixfort-core'),
				"bg-dark-opacity-5" => __('Dark opacity 5', 'pixfort-core'),
				"bg-dark-opacity-6" => __('Dark opacity 6', 'pixfort-core'),
				"bg-dark-opacity-7" => __('Dark opacity 7', 'pixfort-core'),
				"bg-dark-opacity-8" => __('Dark opacity 8', 'pixfort-core'),
				"bg-dark-opacity-9" => __('Dark opacity 9', 'pixfort-core'),
				"bg-light-opacity-1" => __('Light opacity 1', 'pixfort-core'),
				"bg-light-opacity-2" => __('Light opacity 2', 'pixfort-core'),
				"bg-light-opacity-3" => __('Light opacity 3', 'pixfort-core'),
				"bg-light-opacity-4" => __('Light opacity 4', 'pixfort-core'),
				"bg-light-opacity-5" => __('Light opacity 5', 'pixfort-core'),
				"bg-light-opacity-6" => __('Light opacity 6', 'pixfort-core'),
				"bg-light-opacity-7" => __('Light opacity 7', 'pixfort-core'),
				"bg-light-opacity-8" => __('Light opacity 8', 'pixfort-core'),
				"bg-light-opacity-9" => __('Light opacity 9', 'pixfort-core')
			],
			'dependency' => [
				'field' => 'show-banner-btn',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'banner-btn-text-color',
		[
			'type' => 'select',
			'label' => __('Banner Button Text Color', 'pixfort-core'),
			'description' => __('Pick the button text color.', 'pixfort-core'),
			'tab'             => 'banner',
			'default'   => '',
			'options' => array_flip($colors),
			'dependency' => [
				'field' => 'show-banner-btn',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'banner-btn-custom-text-color',
		[
			'type'             => 'color',
			'tab'             => 'banner',
			'label'         => __('Custom Banner Button Text Color', 'pixfort-core'),
			'default'         => '#212529',
			'disableAlpha'         => true,
			'dependency' => [
				'field' => 'banner-btn-text-color',
				'val' => ['custom']
			]
		]
	);
	$pixfortBuilder->addOption(
		'show-banner-countdown',
		[
			'type' => 'checkbox',
			'label' => __('Show Countdown in Banner', 'pixfort-core'),
			'options'         => array('1' => 'On', '0' => 'Off'),
			'default'           => '0',
			'tab'             => 'banner',
			'dependency' => [
				'field' => 'show-banner',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'banner-date',
		[
			'type' => 'text',
			'label' => 'Banner Countdown Date',
			'tab'             => 'banner',
			'description' => __('Example: 2024/12/30 12:00', 'pixfort-core'),
			'default'             => '2024/10/10 00:48',
			'dependency' => [
				'field' => 'show-banner-countdown',
				'val' => ['1', true]
			],
		]
	);
	$pixfortBuilder->addOption(
		'banner-padding',
		[
			'type' => 'select',
			'label' => __('Banner Padding', 'pixfort-core'),
			'tab'             => 'banner',
			'default'   => '',
			'options' => [
				""            => __('Default', 'pixfort-core'),
				"pix-py-5"        => __('5px', 'pixfort-core'),
				"pix-py-10"        => __('10px', 'pixfort-core'),
				"pix-py-20"        => __('20px', 'pixfort-core'),
			],
			'hideBorderBottom'      => true,
			'dependency' => [
				'field' => 'show-banner',
				'val' => ['1', true]
			],
		]
	);
	/*
    *   Import / Export
    */
	$pixfortBuilder->addOption(
		'import',
		[
			'type' => 'import',
			'label' => __('Import Options', 'pixfort-core'),
			'tab'             => 'importExportGeneral',
			'hideBorderBottom'      => false,
		]
	);
	$pixfortBuilder->addOption(
		'export',
		[
			'type' => 'export',
			'label' => __('Export Options', 'pixfort-core'),
			'description' => __('Here you can copy/download your current saved Theme Options settings.', 'pixfort-core'),
			// 'description' => __('Here you can copy/download your current saved Theme Options settings. Keep this safe as you can use it as a backup should anything go wrong, or you can use it to restore your settings on this site (or any other site).', 'pixfort-core'),
			'tab'             => 'importExportGeneral',
			'hideBorderBottom'      => true,
		]
	);

	$pixfortBuilder->addOption(
		'pix-export-alert',
		[
			'type'             => 'alert',
			'tab'             => 'importExportGeneral',
			// 'label'     => __('Missing a Social Icon?', 'pixfort-core'),
			'description'     => __('Keep your export options file safe as you can use it as a backup in case anything goes wrong, or you can use it to restore your settings on this site (or any other site).', 'pixfort-core'),
			'hidePaddingBottom' => false,
			'hidePaddingTop' => true,
			'style' => 'clean',
			'icon'  =>  'info',
			// 'linkOneText'  =>  __('Check article', 'pixfort-core'),
			// 'linkOneHref'  =>  \PixfortCore::instance()->adminCore->getParam('docs_how_to_add_social_icons') . '#pix_section_missing_social_icon',
			// 'linkOneIcon'  =>  'bookmark'
		]
	);

	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/settings.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/sidebars.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/apiKeys.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/cookies.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/pageTransition.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/page404.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/elementor.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/advanced.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/social.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/search.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/colors.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/buttons.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/layoutAdvanced.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/blogGeneral.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/blogIntro.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/blogAdvanced.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/portfolioGeneral.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/portfolioIntro.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/pagesGeneral.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/pagesIntro.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/typographyGeneral.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/typographyAdvanced.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/icons.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/shopGeneral.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/shopIntro.php';
	require_once PIXFORT_PLUGIN_DIR . 'includes/options/data/shopAdvanced.php';


	$pixfortBuilder->fillData();
	if ($print) {
		$pixfortBuilder->loadOptionsData();
		$theme_option_notice = get_option('pixfort_theme_options_notice');
		if ($theme_option_notice) {
?>
			<div class="notice pixfort-admin-notice notice-warning is-dismissible2">
				<div class="notice-text"><?php echo esc_attr__('There was an error while saving the theme options (Styling will not be applied until fixing the issue), please check the following error meesage:', 'pixfort-core'); ?></div>
				<div class="pix-theme-options-err-msg">
					<pre><?php echo esc_attr($theme_option_notice); ?></pre>
				</div>
			</div>
<?php
		}

		if(is_user_logged_in() && current_user_can('manage_options')) {
			// Handle secure POST updates for license/purchase info
			if ('POST' === $_SERVER['REQUEST_METHOD'] && !empty($_POST['pixfort_license_update'])) {
				$nonce = isset($_POST['pixfort_license_nonce']) ? $_POST['pixfort_license_nonce'] : '';
				if (!wp_verify_nonce($nonce, 'pixfort_license_update_action')) {
					echo '<div class="notice notice-error"><p>' . esc_html__('Security check failed. Please try again.', 'pixfort-core') . '</p></div>';
				} else {
					$envato_code = isset($_POST['envato_purchase_code']) ? sanitize_text_field($_POST['envato_purchase_code']) : '';
					$pixfort_purchase_code = isset($_POST['pixfort_purchase_code']) ? sanitize_text_field($_POST['pixfort_purchase_code']) : '';
					$pixfort_key = isset($_POST['pixfort_key']) ? sanitize_text_field($_POST['pixfort_key']) : '';
					update_option('envato_purchase_code_27889640', $envato_code);
					update_option('pixfort_purchase_code_1', $pixfort_purchase_code);
					update_option('envato_purchase_code_61457003', $envato_code);
					update_option('pixfort_key', $pixfort_key);
					echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('License details updated successfully.', 'pixfort-core') . '</p></div>';
				}
			}
			if (!empty($_GET['pixfort_dis'])) {
				if ($_GET['pixfort_dis'] == 12) {
					update_option('envato_purchase_code_27889640', '');
					update_option('pixfort_purchase_code_1', '');
					update_option('envato_purchase_code_61457003', '');
					update_option('pixfort_key', '');
					update_option('pixfort_dashboard_wizard', '');
				}
				if ($_GET['pixfort_dis'] == 13) {
					update_option('pix_license_update_fail', '');
				}
			}
			if (!empty($_GET['pixinfo'])) {
				
				$envato_purchase_code = esc_attr(get_option('envato_purchase_code_27889640'));
				if (defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG) {
					if(PIXFORT_THEME_SLUG == 'conseil') {
						$envato_purchase_code = esc_attr(get_option('envato_purchase_code_61457003'));
					}
				}
				$pixfort_purchase_code = esc_attr(get_option('pixfort_purchase_code_1'));
				$pixfort_key = esc_attr(get_option('pixfort_key'));
				echo '<div class="bg-white rounded-lg shadow-sm mr-4 mt-4 xl:py-6 p-4 md:py-5 md:px-6 xl:px-8 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">';
				echo '<div><strong>License status:</strong> ' . esc_attr(get_option('pixfort_license_status')) . '</div>';
				echo '<strong>Purchase code:</strong><div>' . $envato_purchase_code . '</div>';
				echo '<div><strong>pixfort key:</strong> ' . $pixfort_key . '</div>';
				echo '<div><strong>pixfort site URL:</strong> ' . esc_attr(get_option('pixfort_site_theme_url')) . '</div>';
				echo '<div><strong>Main license key:</strong> ' . esc_attr(get_option('pixfort_license_key')) . '</div>';
				echo '<div><strong>pixfort purchase key:</strong> ' . $pixfort_purchase_code . '</div>';
				
				// Convert timestamp to readable date format
				$created_at = esc_attr(get_option('pixfort_key_created_at'));
				$created_at_display = !empty($created_at) ? date('F j, Y g:i a', intval($created_at)/1000) : '';
				echo '<div><strong>' . esc_html__('Activation URL:', 'pixfort-core') . '</strong> ' . esc_html( (string) get_option('pixfort_key_url') ) . '</div>';
				echo '<div><strong>' . esc_html__('Activation date:', 'pixfort-core') . '</strong> ' . esc_html($created_at_display) . ' <small>(' . esc_html( (string) $created_at ) . ')</small></div>';
				
				// Convert timestamp to readable date format
				$expires_at = esc_attr(get_option('pixfort_key_expires_at'));
				$expires_at_display = !empty($expires_at) ? date('F j, Y g:i a', intval($expires_at)/1000) : '';
				echo '<div><strong>' . esc_html__('Expiration date:', 'pixfort-core') . '</strong> ' . esc_html($expires_at_display) . ' <small>(' . esc_html( (string) $expires_at ) . ')</small></div>';
				
				echo '<div><strong>' . esc_html__('License update:', 'pixfort-core') . '</strong> ' . esc_html( (string) get_option('pix_license_update_fail') ) . '</div>';
				echo '<div><strong>' . esc_html__('Site type:', 'pixfort-core') . '</strong> ' . esc_html( (string) get_option('pixfort_site_type') ) . '</div>';
				
				echo '<strong>site_url:</strong> ' . esc_html( site_url() );
				echo '<br>';
				echo '<a href="'. site_url() .'/wp-admin/admin.php?page=pixfort-options&pixfort_dis=12">Deactivate</a> ';
				// Secure form for updating license details
				echo '<hr class="my-4">';
				echo '<h3 class="text-lg font-semibold mb-2">' . esc_html__('Update License Details', 'pixfort-core') . '</h3>';
				echo '<form method="post" action="' . esc_url( admin_url('admin.php?page=pixfort-options&pixinfo=1') ) . '">';
				echo '<input type="hidden" name="pixfort_license_update" value="1">';
				wp_nonce_field('pixfort_license_update_action', 'pixfort_license_nonce');
				echo '<p><label><strong>' . esc_html__('Envato purchase code', 'pixfort-core') . '</strong><br><input type="text" name="envato_purchase_code" value="' . $envato_purchase_code . '" class="regular-text" autocomplete="off" /></label></p>';
				echo '<p><label><strong>' . esc_html__('pixfort purchase key', 'pixfort-core') . '</strong><br><input type="text" name="pixfort_purchase_code" value="' . $pixfort_purchase_code . '" class="regular-text" autocomplete="off" /></label></p>';
				echo '<p><label><strong>' . esc_html__('pixfort key', 'pixfort-core') . '</strong><br><input type="text" name="pixfort_key" value="' . $pixfort_key . '" class="regular-text" autocomplete="off" /></label></p>';
				echo '<p><button type="submit" class="button button-primary">' . esc_html__('Save', 'pixfort-core') . '</button></p>';
				echo '</form>';
				echo '</div>';
			}
		}

		echo '<div id="fu3obnz"></div>';
	} else {
		return $pixfortBuilder;
	}
}
