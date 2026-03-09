<?php

$pixfortBuilder->addOption(
	'pix-heading-pages-general',
	[
		'type'             => 'heading',
		'label'         => __('Pages', 'pixfort-core'),
		'tab'             => 'pagesGeneral',
		'icon'            => 'pages',
		// 'linkText'            => __('Learn more about pages', 'pixfort-core'),
		// 'linkHref'            => '',
		// 'linkIcon'            => 'bookmark'
	]
);
$pixfortBuilder->addOption(
	'pages-bg-color',
	[
		'type' => 'select',
		'label' => __('Page Background Color', 'pixfort-core'),
		'description'         => __('Default background color for website pages.', 'pixfort-core'),
		// 'options' => array_flip($bg_colors),
		'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
		'groups' => true,
		'tab'             => 'pagesGeneral',
		'default'             => 'gray-1',
	]
);
$pixfortBuilder->addOption(
	'custom-pages-bg-color',
	[
		'type'             => 'color',
		'tab'             => 'pagesGeneral',
		'label'         => __('Custom Page Background Color', 'pixfort-core'),
		'default'         => '#FFFFFF',
		'disableAlpha'         => true,
		'dependency' => [
			'field' => 'pages-bg-color',
			'val' => ['custom']
		]
	]
);
$pixfortBuilder->addOption(
	'pages-hide-top-padding',
	[
		'type' => 'checkbox',
		'label' => __('Hide Top Padding', 'pixfort-core'),
		'description' => __('Hide the padding before page content (under the header).', 'pixfort-core'),
		'options'         => array('1' => 'On', '0' => 'Off'),
		'default'           => '0',
		'tab'             => 'pagesGeneral',
	]
);
$pixfortBuilder->addOption(
	'sidebar-page',
	[
		'type' => 'select',
		'label' => __('Page Sidebar', 'pixfort-core'),
		'description'         => __('Sidebars can be managed from Settings → Sidebars tab.', 'pixfort-core'),
		'options' => $sidebars,
		'default'             => 'sidebar-1',
		'tab'             => 'pagesGeneral',
	]
);
$pixfortBuilder->addOption(
	'sidebar-page-sticky',
	[
		'type' => 'select',
		'label' => __('Sticky Page Sidebar', 'pixfort-core'),
		'options' => [
			'sticky-bottom'   => __('Sticky bottom', 'pixfort-core'),
			'sticky-top'   => __('Sticky Top', 'pixfort-core'),
			'sticky-disabled'   => __('Disable Sticky', 'pixfort-core')
		],
		'default'             => 'sticky-bottom',
		'tab'             => 'pagesGeneral',
	]
);
$pixfortBuilder->addOption(
	'pix-enable-page-line-breaks',
	[
		'type' => 'checkbox',
		'label' => __('Enable Default Page Line Breaks', 'pixfort-core'),
		'description' => __('Note: this is an advanced option and depending on your WordPress or server configuration WordPress may add line break tags incorrectly in some areas or in the used External third party plugins.', 'pixfort-core'),
		'options'         => array('1' => 'On', '0' => 'Off'),
		'default'           => '0',
		'tab'             => 'pagesGeneral',
		'hideBorderBottom'   => true
	]
);
