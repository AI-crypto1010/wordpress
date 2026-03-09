<?php

/*
    *   Settings
    */
$pixfortBuilder->addOption(
	'pix-heading-settings-logo',
	[
		'type'             => 'heading',
		'label'         => __('Logo', 'pixfort-core'),
		'tab'             => 'settings',
		'icon'            => 'logo',
		'linkText'            => __('Learn about website logo', 'pixfort-core'),
		'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_add_website_logo'),
		'linkIcon'            => 'bookmark'
	]
);
$pixfortBuilder->addOption(
	'logo-img',
	[
		'type'             => 'media',
		'label'         => __('Default Logo', 'pixfort-core'),
		'default'         => '',
		'tab'             => 'settings',
		'dynamic'         => true,
		// 'description'     => __('The main logo of your website on large screen devices.', 'pixfort-core') . '<br>' . __('You can customize the logo width and height from the Header builder.', 'pixfort-core'),
		'description'     => __('Change the main logo of your website on large screen devices.', 'pixfort-core'),
		'tooltipText'   => __('The logo will appear in the website header.', 'pixfort-core') . '<br>' . __('To display the logo image as retina, the uploaded image should have at least double the height of the logo set in the Header builder.', 'pixfort-core'),
		'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/core-options/tooltips/core-options-tooltip-default-logo.png',
		'showBorderTop'   => false
	]
);
$pixfortBuilder->addOption(
	'scroll-logo-img',
	[
		'type'             => 'media',
		'label'         => __('Scroll Logo', 'pixfort-core'),
		'default'         => '',
		'tab'             => 'settings',
		'dynamic'         => true,
		// 'description'     => __('Replaces the default logo when scrolling with the sticky header enabled. Leave empty to display the default logo instead.', 'pixfort-core'),
		'description'     => __('Leave empty to display the default logo instead.', 'pixfort-core'),
		'tooltipText'   => __('Replaces the default logo when scrolling with the sticky header enabled. You can enable the sticky header option from the Header builder.', 'pixfort-core'),
		// 'tooltipText'   => 'To display the logo image as retina we recommend that the uploaded image have at least double the height of the logo set in the Header builder.',
		'showBorderTop'   => false
	]
);
$pixfortBuilder->addOption(
	'mobile-logo-img',
	[
		'type'             => 'media',
		'label'         => __('Tablet & Mobile Logo', 'pixfort-core'),
		'default'         => '',
		'tab'             => 'settings',
		'dynamic'         => true,
		'description'     => __('Leave empty to display the default logo instead.', 'pixfort-core'),
		'tooltipText'   => __('Logo displayed on tablet and mobile devices only. You can customize the width and height of the tablet & mobile logo from the Header builder.', 'pixfort-core'),
		'showBorderTop'   => false,
		'hideBorderBottom'   => true
	]
);
if (function_exists('has_site_icon') && !has_site_icon()) {
	if (!empty(pix_plugin_get_option('favicon-img')) && !empty(pix_plugin_get_option('favicon-img')['url'])) {
		$pixfortBuilder->addOption(
			'favicon-img',
			[
				'type'             => 'media',
				'label'         => __('Custom Favicon', 'pixfort-core'),
				'default'         => '',
				'tab'             => 'settings',
				'description'     => __('This option is deprecated, please make sure to remove the image from here and set the website favicon via the default WordPress option in Settings → General → Site Icon.', 'pixfort-core'),
				// 'description'     => __('Add a small image to be displayed in browser tabs.', 'pixfort-core'),
				'showBorderTop'   => true,
				'hideBorderBottom'   => true
			]
		);
	} else {
		$pixfortBuilder->addOption(
			'favicon-img-alert',
			[
				'type'             => 'alert',
				'tab'             => 'settings',
				'description'     => __('It seems that your site doesn\'t have a Site Icon (Favicon), you can set the Site icon via the default WordPress option in Settings → General → Site Icon.', 'pixfort-core'),
				'hidePaddingBottom' => true,
				'style' => 'clean',
				'icon'  =>  'info',
			]
		);
	}
} else {
	$pixfortBuilder->addOption(
		'favicon-img-alert',
		[
			'type'             => 'alert',
			'tab'             => 'settings',
			'description'     => __('If you are looking to customize the Site Icon (Favicon), you can do so via the default WordPress option in Settings → General → Site Icon.', 'pixfort-core'),
			'hidePaddingBottom' => true,
			'style' => 'clean',
			'icon'  =>  'info',
		]
	);
}
$pixfortBuilder->addOption(
	'pix-heading-settings-miscellaneous',
	[
		'type'             => 'heading',
		'label'         => __('Miscellaneous', 'pixfort-core'),
		'tab'             => 'settings',
		'icon'            => 'bullets'
	]
);
$pixfortBuilder->addOption(
	'pix-body-padding',
	[
		'type' => 'select',
		'label' => __('Page Padding (Experimental Feature)', 'pixfort-core'),
		'description'     => __('This option may disable the css sticky option in some browsers.', 'pixfort-core'),
		'tooltipText'   => __('Add padding around the page on large screen devices. Please note that this effect may slow down the website if the page includes heavy content, if you experince any performance issues in some browsers please disable this option.', 'pixfort-core'),
		'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/core-options/tooltips/core-options-tooltip-page-padding.png',
		'tab'             => 'settings',
		'options' => [
			'none'             => __('None', 'pixfort-core'),
			'pix-p-5'         => __('5px', 'pixfort-core'),
			'pix-p-10'         => __('10px', 'pixfort-core'),
			'pix-p-15'         => __('15px', 'pixfort-core'),
			'pix-p-20'         => __('20px', 'pixfort-core'),
			'pix-p-25'         => __('25px', 'pixfort-core'),
			'pix-p-30'         => __('30px', 'pixfort-core'),
			'pix-p-35'         => __('35px', 'pixfort-core'),
			'pix-p-40'         => __('40px', 'pixfort-core'),
			'pix-p-45'         => __('45px', 'pixfort-core'),
			'pix-p-50'         => __('50px', 'pixfort-core'),
			'pix-px-5'         => __('5px (Horizontal only)', 'pixfort-core'),
			'pix-px-10'         => __('10px (Horizontal only)', 'pixfort-core'),
			'pix-px-20'         => __('20px (Horizontal only)', 'pixfort-core'),
			'pix-px-30'         => __('30px (Horizontal only)', 'pixfort-core'),
			'pix-px-40'         => __('40px (Horizontal only)', 'pixfort-core'),
			'pix-px-50'         => __('50px (Horizontal only)', 'pixfort-core'),
			'pix-px-60'         => __('60px (Horizontal only)', 'pixfort-core'),
			'pix-px-70'         => __('70px (Horizontal only)', 'pixfort-core'),
			'pix-px-80'         => __('80px (Horizontal only)', 'pixfort-core'),
			'pix-px-90'         => __('90px (Horizontal only)', 'pixfort-core'),
			'pix-px-100'         => __('100px (Horizontal only)', 'pixfort-core')
		],
		'default'  => 'none',
	]
);
$pixfortBuilder->addOption(
	'pix-use-clip-path',
	[
		'type' => 'checkbox',
		'label' => __('Enable Clip Path', 'pixfort-core'),
		'description'     => __('This option will enable the css sticky while using the page padding option.', 'pixfort-core'),
		'tooltipText'   => __('Please note that this effect may slow down the website if the page includes heavy content, if you experince any performance issues in some browsers please disable this option.', 'pixfort-core'),
		'options'         => array('1' => 'On', '0' => 'Off'),
		'default'           => '',
		'tab'             => 'settings',
		'dependency'        => [
			'field'             => 'pix-body-padding',
			'val'               => ['', 'none', 'false', false],
			'op'                => '!='
		]
	]
);
$pixfortBuilder->addOption(
	'pix-body-bg-color',
	[
		'type' => 'select',
		'label' => __('Website Background Color', 'pixfort-core'),
		'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
		'groups' => true,
		'tab'             => 'settings',
		'tooltipText'   => __('The background color of the website (under the page background color). The website background color will appear mainly when the page padding option is enabled.', 'pixfort-core'),
		'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/core-options/tooltips/core-options-tooltip-website-bg-color.png',
	]
);
$pixfortBuilder->addOption(
	'custom-body-bg-color',
	[
		'type'             => 'color',
		'tab'             => 'settings',
		'label'         => __('Custom background Color', 'pixfort-core'),
		'default'         => '#FFFFFF',
		'disableAlpha'         => true,
		'dependency' => [
			'field' => 'pix-body-bg-color',
			'val' => ['custom']
		]
	]
);
$pixfortBuilder->addOption(
	'website-preview',
	[
		'type'             => 'media',
		'label'         => __('Website Image Preview', 'pixfort-core'),
		'default'         => '',
		'tab'             => 'settings',
		'removePadding'       => true,
		'tooltipText'   => __('Use a custom image to display when the website is shared on social media.', 'pixfort-core'),
		// 'description'     => __('Use a custom image to display when the website is shared on social media.', 'pixfort-core'),
		'showBorderTop'   => false
	]
);
$pixfortBuilder->addOption(
	'back-to-top',
	[
		'type' => 'select',
		'label' => __('Back to Top Button', 'pixfort-core'),
		'tab'             => 'settings',
		'tooltipText'     => __('A sticky button that appears when scrolling down the page and allows users to scroll back to the top of the page. <br/><br/> For detailed information about customizing the back to top button check this article from our knowledge base: ', 'pixfort-core') . '<br/><a target="_blank" href="'.\PixfortCore::instance()->adminCore->getParam('docs_back_to_top').'" target="_blank" class="text-primary font-semibold">'.\PixfortCore::instance()->adminCore->getParam('docs_back_to_top').'</a>',
		'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/core-options/tooltips/core-options-tooltip-back-to-top.png',
		'options' => [
			"default"        => __('Default (bottom right)', 'pixfort-core'),
			"is-left"        => __('Bottom left', 'pixfort-core'),
			"disable"        => __('Disable', 'pixfort-core')
		],
		'default'  => 'default',
		'hideBorderBottom'   => true
	]
);
