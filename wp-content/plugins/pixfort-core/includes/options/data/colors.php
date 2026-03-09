<?php


$pixfortBuilder->addOption(
	'pix-heading-colors',
	[
		'type'             => 'heading',
		'label'         => __('Main Colors', 'pixfort-core'),
		'tab'             => 'colors',
		'icon'            => 'colorPalette',
		'linkText'            => __('Learn more about color system', 'pixfort-core'),
		'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_color_system'),
		'linkIcon'            => 'bookmark'
	]
);

$pixfortBuilder->addOption(
	'opt-primary-color',
	[
		'type'             => 'color',
		'label' => __('Primary Color', 'pixfort-core'),
		'description' => __('The main color used widely across your site that represents your brand.', 'pixfort-core'),
		'tab'             => 'colors',
		'default'  => \PixfortCore::instance()->adminCore->getParam('color_primary', '#7d8dff'),
		'disableAlpha'         => true,
	]
);
$pixfortBuilder->addOption(
	'opt-secondary-color',
	[
		'type' => 'color',
		'label' => __('Secondary Color', 'pixfort-core'),
		'description' => __('A complementary color for secondary features and background accents.', 'pixfort-core'),
		'tab'             => 'colors',
		'default'  => \PixfortCore::instance()->adminCore->getParam('color_secondary', '#ff4f81'),
		'disableAlpha'         => true,
	]
);
$pixfortBuilder->addOption(
	'opt-link-color',
	[
		'type' => 'color',
		'label' => __('Link Color', 'pixfort-core'),
		'description' => __('Defines the color for hyperlink text in website.', 'pixfort-core'),
		'tab'             => 'colors',
		'default'  => \PixfortCore::instance()->adminCore->getParam('color_link', [
			'light' => '#333333',
			'dark' => '#eeeeee',
		]),
		'dynamic' => true,
		'disableAlpha'         => true,
		'hideBorderBottom'  => true
	]
);
/*
*   Primary Gradient color
*/
$pixfortBuilder->addOption(
	'pix-heading-colors-primary-gradient',
	[
		'type'             => 'heading',
		'label'         => __('Primary Gradient Color', 'pixfort-core'),
		'tab'             => 'colors',
		'icon'            => 'vector',
		'hidePaddingTop' => true,
	]
);
$pixfortBuilder->addOption(
	'opt-primary-gradient-switch',
	[
		'type' => 'checkbox',
		'label' => __('Use 3 Gradient Color Stops', 'pixfort-core'),
		'options'         => array('1' => 'On', '0' => 'Off'),
		'default'           => '0',
		'tab'             => 'colors'
	]
);
$pixfortBuilder->addOption(
	'opt-color-gradient-primary-1',
	[
		'type' => 'color',
		'label' => __('Starting Gradient Color (Left)', 'pixfort-core'),
		// 'description' => __('Pick the link color for the theme.', 'pixfort-core'),
		'tab'             => 'colors',
		'default'         => \PixfortCore::instance()->adminCore->getParam('color_gradient_primary_1', '#7d8dff'),
		'disableAlpha'         => true,
	]
);
$pixfortBuilder->addOption(
	'opt-color-gradient-primary-middle',
	[
		'type' => 'color',
		'label' => __('Middle Gradient Color', 'pixfort-core'),
		// 'description' => __('Pick the link color for the theme.', 'pixfort-core'),
		'tab'             => 'colors',
		'default'         => \PixfortCore::instance()->adminCore->getParam('color_gradient_primary_middle', '#4ed199'),
		'disableAlpha'         => true,
		'dependency' => [
			'field' => 'opt-primary-gradient-switch',
			'val' => ['1', true],
		]
	]
);
$pixfortBuilder->addOption(
	'opt-color-gradient-primary-2',
	[
		'type' => 'color',
		'label' => __('Ending Gradient Color (Right)', 'pixfort-core'),
		// 'description' => __('Pick the link color for the theme.', 'pixfort-core'),
		'tab'             => 'colors',
		'default'         => \PixfortCore::instance()->adminCore->getParam('color_gradient_primary_2', '#ff4f81'),
		'disableAlpha'         => true,
	]
);
$pixfortBuilder->addOption(
	'opt-primary-gradient-dir',
	[
		'type' => 'select',
		'label' => __('Gradient Direction', 'pixfort-core'),
		'tab'             => 'colors',
		'default'   => 'to right',
		'hideBorderBottom'  => true,
		'options' => [
			"to right"            => __('Left to right', 'pixfort-core'),
			"to top"        => __('Bottom to top', 'pixfort-core'),
			"to top right"        => __('Bottom left to top right', 'pixfort-core'),
			"to bottom right"        => __('Top left to bottom right', 'pixfort-core'),
		]
	]
);
if (!defined('IS_PIXFORT_THEME')) {
	$pixfortBuilder->addOption(
		'disable-fixed-gradient',
		[
			'type' => 'checkbox',
			'label' => __('Disable Fixed Gradients', 'pixfort-core'),
			// 'description' => __('Fixed gradient colors slow down the website in some browsers, please disable the fixed gradient if it\' affecting website performance.', 'pixfort-core'),
			'tooltipText'   => __('Fixed gradient colors slow down the website in some browsers, please disable the fixed gradient if it\'s affecting website performance.', 'pixfort-core'),
			'options'         => array('1' => 'On', '0' => 'Off'),
			'default'           => '0',
			'tab'             => 'colors',
			'hideBorderBottom'  => true
		]
	);
}


if(PixfortCore::instance()->dynamicColors) {
	$pixfortBuilder->addOption(
		'pix-heading-colors-options',
		[
			'type'             => 'heading',
			'label'         => __('Dark Mode', 'pixfort-core'),
			'tab'             => 'colors',
			'icon'            => 'darkMode',
			'linkText'            => __('Learn more about dark mode', 'pixfort-core'),
			'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_dark_mode'),
			'linkIcon'            => 'bookmark'
		]
	);
	$pixfortBuilder->addOption(
		'pix-enable-dynamic-colors',
		[
			'type' => 'checkbox',
			'label' => __('Enable Dark Mode', 'pixfort-core'),
			'options'         => array('1' => 'On', '0' => 'Off'),
			'default'           => '0',
			'tab'             => 'colors',
			'hideBorderBottom' => true,
		]
	);
	$pixfortBuilder->addOption(
		'pix-default-theme-mode',
		[
			'type' => 'select',
			'label' => __('Default Theme Mode', 'pixfort-core'),
			'tab'             => 'colors',
			'default'   => 'light',
			'hideBorderBottom'  => true,
			'showBorderTop' => true,
			'options' => [
				"light"            => __('Light', 'pixfort-core'),
				"dark"        => __('Dark', 'pixfort-core'),
				"system"        => __('System', 'pixfort-core'),
			],
			'dependency' => [
				'field' => 'pix-enable-dynamic-colors',
				'val' => ['1', true],
			]
		]
	);
	$pixfortBuilder->addOption(
		'pix-alert-dark-mode',
		[
			'type'             => 'alert',
			'tab'             => 'colors',
			'description'     => __('For detailed information about setting up dark mode, check this article from the documentation:', 'pixfort-core'),
			'hidePaddingTop' => true,
			// 'hidePaddingBottom' => true,
			'style' => 'simple',
			'icon'  =>  'info',
			'linkOneText'  =>  __('Learn more about dark mode', 'pixfort-core'),
			'linkOneHref'  =>  \PixfortCore::instance()->adminCore->getParam('docs_dark_mode'),
			'linkOneIcon'  =>  'bookmark',
			'dependency' => [
				'field' => 'pix-enable-dynamic-colors',
				'val' => ['1', true],
			]
		]
	);
}

if(PixfortCore::instance()->getThemeParam('dynamic_colors')) {
	/*
	*   Dynamic Colors
	*/
	$pixfortBuilder->addOption(
		'pix-heading-colors-dynamic-colors',
		[
			'type'             => 'heading',
			'label'         => __('Dynamic Colors', 'pixfort-core'),
			'tab'             => 'colors',
			'icon'            => 'dynamicColors',
			'linkText'            => __('Learn more about dynamic colors', 'pixfort-core'),
			'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_color_system'),
			'linkIcon'            => 'bookmark'
		]
	);
	$pixfortBuilder->addOption(
		'pix-dynamic-heading',
		[
			'type' => 'color',
			'label' => __('Dynamic Heading', 'pixfort-core'),
			'description' => __('Pick the dynamic heading color for the theme.', 'pixfort-core'),
			'tab'             => 'colors',
			'default'         => \PixfortCore::instance()->adminCore->getParam('color_dynamic_heading', [
				'light' => '#000000',
				'dark' => '#FFFFFF',
			]),
			'disableAlpha'         => false,
			'hideBorderBottom'  => false,
			'enableReset'	  => true,
			'dynamic' => true,
		]
	);
	$pixfortBuilder->addOption(
		'pix-dynamic-background',
		[
			'type' => 'color',
			'label' => __('Dynamic Background', 'pixfort-core'),
			'description' => __('Pick the dynamic background color for the theme.', 'pixfort-core'),
			'tab'             => 'colors',
			'default'         => \PixfortCore::instance()->adminCore->getParam('color_dynamic_background', [
				'light' => '#FFFFFF',
				'dark' => '#000000',
			]),
			'disableAlpha'         => false,
			'hideBorderBottom'  => false,
			'enableReset'	  => true,
			'dynamic' => true,
		]
	);
	$pixfortBuilder->addOption(
		'pix-dynamic-gray-50',
		[
			'type' => 'color',
			'label' => __('Dynamic Gray 50', 'pixfort-core'),
			'description' => __('Pick the dynamic gray 50 color for the theme.', 'pixfort-core'),
			'tab'             => 'colors',
			'default'         => \PixfortCore::instance()->adminCore->getParam('color_dynamic_gray_50', [
				'light' => '#FAFAFA',
				'dark' => '#09090B',
			]),
			'disableAlpha'         => false,
			'hideBorderBottom'  => false,
			'enableReset'	  => true,
			'dynamic' => true,
		]
	);
	$pixfortBuilder->addOption(
		'pix-dynamic-gray-100',
		[
			'type' => 'color',
			'label' => __('Dynamic Gray 100', 'pixfort-core'),
			'description' => __('Pick the dynamic gray 100 color for the theme.', 'pixfort-core'),
			'tab'             => 'colors',
			'default'         => \PixfortCore::instance()->adminCore->getParam('color_dynamic_gray_100', [
				'light' => '#F4F4F5',
				'dark' => '#18181B',
			]),
			'disableAlpha'         => false,
			'hideBorderBottom'  => false,
			'enableReset'	  => true,
			'dynamic' => true,
		]
	);
	$pixfortBuilder->addOption(
		'pix-dynamic-gray-200',
		[
			'type' => 'color',
			'label' => __('Dynamic Gray 200', 'pixfort-core'),
			'description' => __('Pick the dynamic gray 200 color for the theme.', 'pixfort-core'),
			'tab'             => 'colors',
			'default'         => \PixfortCore::instance()->adminCore->getParam('color_dynamic_gray_200', [
				'light' => '#E4E4E7',
				'dark' => '#27272A',
			]),
			'disableAlpha'         => false,
			'hideBorderBottom'  => false,
			'enableReset'	  => true,
			'dynamic' => true,
		]
	);
	$pixfortBuilder->addOption(
		'pix-dynamic-gray-300',
		[
			'type' => 'color',
			'label' => __('Dynamic Gray 300', 'pixfort-core'),
			'description' => __('Pick the dynamic gray 300 color for the theme.', 'pixfort-core'),
			'tab'             => 'colors',
			'default'         => \PixfortCore::instance()->adminCore->getParam('color_dynamic_gray_300', [
				'light' => '#D4D4D8',
				'dark' => '#3F3F46',
			]),
			'disableAlpha'         => false,
			'hideBorderBottom'  => false,
			'enableReset'	  => true,
			'dynamic' => true,
		]
	);
	
	$pixfortBuilder->addOption(
		'pix-dynamic-gray-400',
		[
			'type' => 'color',
			'label' => __('Dynamic Gray 400', 'pixfort-core'),
			'description' => __('Pick the dynamic gray 400 color for the theme.', 'pixfort-core'),
			'tab'             => 'colors',
			'default'         => \PixfortCore::instance()->adminCore->getParam('color_dynamic_gray_400', [
				'light' => '#A1A1AA',
				'dark' => '#52525B',
			]),
			'disableAlpha'         => false,
			'hideBorderBottom'  => false,
			'enableReset'	  => true,
			'dynamic' => true,
		]
	);
	$pixfortBuilder->addOption(
		'pix-dynamic-gray-500',
		[
			'type' => 'color',
			'label' => __('Dynamic Gray 500', 'pixfort-core'),
			'description' => __('Pick the dynamic gray 500 color for the theme.', 'pixfort-core'),
			'tab'             => 'colors',
			'default'         => \PixfortCore::instance()->adminCore->getParam('color_dynamic_gray_500', [
				'light' => '#71717A',
				'dark' => '#71717A',
			]),
			'disableAlpha'         => false,
			'hideBorderBottom'  => false,
			'enableReset'	  => true,
			'dynamic' => true,
		]
	);
	
	
	
	
	$pixfortBuilder->addOption(
		'pix-dynamic-gray-600',
		[
			'type' => 'color',
			'label' => __('Dynamic Gray 600', 'pixfort-core'),
			'description' => __('Pick the dynamic gray 600 color for the theme.', 'pixfort-core'),
			'tab'             => 'colors',
			'default'         => \PixfortCore::instance()->adminCore->getParam('color_dynamic_gray_600', [
				'light' => '#52525B',
				'dark' => '#A1A1AA',
			]),
			'disableAlpha'         => false,
			'hideBorderBottom'  => false,
			'enableReset'	  => true,
			'dynamic' => true,
		]
	);
	$pixfortBuilder->addOption(
		'pix-dynamic-gray-700',
		[
			'type' => 'color',
			'label' => __('Dynamic Gray 700', 'pixfort-core'),
			'description' => __('Pick the dynamic gray 700 color for the theme.', 'pixfort-core'),
			'tab'             => 'colors',
			'default'         => \PixfortCore::instance()->adminCore->getParam('color_dynamic_gray_700', [
				'light' => '#3F3F46',
				'dark' => '#D4D4D8',
			]),
			'disableAlpha'         => false,
			'hideBorderBottom'  => false,
			'enableReset'	  => true,
			'dynamic' => true,
		]
	);
	$pixfortBuilder->addOption(
		'pix-dynamic-gray-800',
		[
			'type' => 'color',
			'label' => __('Dynamic Gray 800', 'pixfort-core'),
			'description' => __('Pick the dynamic gray 800 color for the theme.', 'pixfort-core'),
			'tab'             => 'colors',
			'default'         => \PixfortCore::instance()->adminCore->getParam('color_dynamic_gray_800', [
				'light' => '#27272A',
				'dark' => '#E4E4E7',
			]),
			'disableAlpha'         => false,
			'hideBorderBottom'  => false,
			'enableReset'	  => true,
			'dynamic' => true,
		]
	);
	$pixfortBuilder->addOption(
		'pix-dynamic-gray-900',
		[
			'type' => 'color',
			'label' => __('Dynamic Gray 900', 'pixfort-core'),
			'description' => __('Pick the dynamic gray 900 color for the theme.', 'pixfort-core'),
			'tab'             => 'colors',
			'default'         => \PixfortCore::instance()->adminCore->getParam('color_dynamic_gray_900', [
				'light' => '#18181B',
				'dark' => '#F4F4F5',
			]),
			'disableAlpha'         => false,
			'hideBorderBottom'  => false,
			'enableReset'	  => true,
			'dynamic' => true,
		]
	);
	$pixfortBuilder->addOption(
		'pix-dynamic-gray-950',
		[
			'type' => 'color',
			'label' => __('Dynamic Gray 950', 'pixfort-core'),
			'description' => __('Pick the dynamic gray 950 color for the theme.', 'pixfort-core'),
			'tab'             => 'colors',
			'default'         => \PixfortCore::instance()->adminCore->getParam('color_dynamic_gray_950', [
				'light' => '#09090B',
				'dark' => '#FAFAFA',
			]),
			'disableAlpha'         => false,
			'hideBorderBottom'  => false,
			'enableReset'	  => true,
			'dynamic' => true,
		]
	);


	$pixfortBuilder->addOption(
		'pix-dynamic-blur',
		[
			'type' => 'color',
			'label' => __('Dynamic Blur', 'pixfort-core'),
			'description' => __('Pick the dynamic blur color for the theme.', 'pixfort-core'),
			'tab'             => 'colors',
			'default'         => \PixfortCore::instance()->adminCore->getParam('color_dynamic_blur', [
				'light' => 'rgba(255, 255, 255, 0.5)',
				'dark' => 'rgba(0, 0, 0, 0.5)',
			]),
			'disableAlpha'         => false,
			'hideBorderBottom'  => true,
			'enableReset'	  => true,
			'dynamic' => true,
		]
	);

}
	/*
	*   Basic colors
	*/
$pixfortBuilder->addOption(
	'pix-heading-colors-main-colors',
	[
		'type'             => 'heading',
		'label'         => __('Basic Colors', 'pixfort-core'),
		'tab'             => 'colors',
		'icon'            => 'colors'
	]
);
$pixfortBuilder->addOption(
	'opt-color-blue',
	[
		'type' => 'color',
		'label' => __('Blue Color', 'pixfort-core'),
		'description' => __('Pick the blue color for the theme.', 'pixfort-core'),
		'tab'             => 'colors',
		'default'  => \PixfortCore::instance()->adminCore->getParam('color_blue', '#1274e7'),
		'disableAlpha'         => true,
		'enableReset'	  => true,
	]
);

$pixfortBuilder->addOption(
	'opt-color-green',
	[
		'type' => 'color',
		'label' => __('Green Color', 'pixfort-core'),
		'description' => __('Pick the green color for the theme.', 'pixfort-core'),
		'tab'             => 'colors',
		'default'         => \PixfortCore::instance()->adminCore->getParam('color_green', '#4ed199'),
		'disableAlpha'         => true,
		'enableReset'	  => true,
	]
);

$pixfortBuilder->addOption(
	'opt-color-cyan',
	[
		'type' => 'color',
		'label' => __('Cyan Color', 'pixfort-core'),
		'description' => __('Pick the cyan color for the theme.', 'pixfort-core'),
		'tab'             => 'colors',
		'default'         => \PixfortCore::instance()->adminCore->getParam('color_cyan', '#0dd3ff'),
		'disableAlpha'         => true,
		'enableReset'	  => true,
	]
);

$pixfortBuilder->addOption(
	'opt-color-yellow',
	[
		'type' => 'color',
		'label' => __('Yellow Color', 'pixfort-core'),
		'description' => __('Pick the yellow color for the theme.', 'pixfort-core'),
		'tab'             => 'colors',
		'default'         => \PixfortCore::instance()->adminCore->getParam('color_yellow', '#ffc168'),
		'disableAlpha'         => true,
		'enableReset'	  => true,
	]
);

$pixfortBuilder->addOption(
	'opt-color-orange',
	[
		'type' => 'color',
		'label' => __('Orange Color', 'pixfort-core'),
		'description' => __('Pick the orange color for the theme.', 'pixfort-core'),
		'tab'             => 'colors',
		'default'         => \PixfortCore::instance()->adminCore->getParam('color_orange', '#ff9900'),
		'disableAlpha'         => true,
		'enableReset'	  => true,
	]
);

$pixfortBuilder->addOption(
	'opt-color-red',
	[
		'type' => 'color',
		'label' => __('Red Color', 'pixfort-core'),
		'description' => __('Pick the red color for the theme.', 'pixfort-core'),
		'tab'             => 'colors',
		'default'         => \PixfortCore::instance()->adminCore->getParam('color_red', '#ff6c5f'),
		'disableAlpha'         => true,
		'enableReset'	  => true,
	]
);

$pixfortBuilder->addOption(
	'opt-color-brown',
	[
		'type' => 'color',
		'label' => __('Brown Color', 'pixfort-core'),
		'description' => __('Pick the brown color for the theme.', 'pixfort-core'),
		'tab'             => 'colors',
		'default'         => \PixfortCore::instance()->adminCore->getParam('color_brown', '#b4a996'),
		'disableAlpha'         => true,
		'enableReset'	  => true,
	]
);

$pixfortBuilder->addOption(
	'opt-color-purple',
	[
		'type' => 'color',
		'label' => __('Purple Color', 'pixfort-core'),
		'description' => __('Pick the purple color for the theme.', 'pixfort-core'),
		'tab'             => 'colors',
		'default'         => \PixfortCore::instance()->adminCore->getParam('color_purple', '#4b19f7'),
		'disableAlpha'         => true,
		'hideBorderBottom'  => true,
		'enableReset'	  => true,
	]
);
if(PixfortCore::instance()->getThemeParam('custom_colors', false)) {
	/*
	*   Custom Colors
	*/
	$pixfortBuilder->addOption(
		'pix-heading-colors-custom-colors',
		[
			'type'             => 'heading',
			'label'         => __('Custom Colors', 'pixfort-core'),
			'tab'             => 'colors',
			'icon'            => 'colorPicker',
			// 'linkText'            => __('Learn more about custom colors', 'pixfort-core'),
			'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_color_system'),
			'linkIcon'            => 'bookmark'
		]
	);
	$pixfortBuilder->addOption(
		'pix-custom-colors-items',
		[
			'type' => 'color-repeater',
			'label' => __('Custom Colors', 'pixfort-core'),
			'tab'             => 'colors',
			'dynamic' => true,
			'disableAlpha'         => false,
			'hideBorderBottom'  => true,
		]
	);

	
	
}