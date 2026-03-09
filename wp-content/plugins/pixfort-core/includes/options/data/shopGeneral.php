<?php

$pixfortBuilder->addOption(
	'pix-heading-shop-general',
	[
		'type'             => 'heading',
		'label'         => __('Shop', 'pixfort-core'),
		'tab'             => 'shopGeneral',
		'icon'            => 'shop',
		'linkText'            => __('Learn more about shop', 'pixfort-core'),
		'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_create_a_shop_with_woocommerce'),
		'linkIcon'            => 'bookmark'
	]
);
$pixfortBuilder->addOption(
	'shop-layout',
	[
		'type' => 'select',
		'label' => __('Shop Page Layout', 'pixfort-core'),
		'default'  => 'right-sidebar',
		'options' => [
			'right-sidebar'   => __('Right sidebar', 'pixfort-core'),
			'left-sidebar'   => __('Left sidebar', 'pixfort-core'),
			'no-sidebar'   => __('No sidebar', 'pixfort-core'),
		],
		'tab'             => 'shopGeneral',
	]
);
$pixfortBuilder->addOption(
	'shop-item-style',
	[
		'type' => 'radio',
		'label' => __('Shop Item Style', 'pixfort-core'),
		'default' => 'default',
		'tab'             => 'shopGeneral',
		'imageSize'       => '130',
		'width'				=> 130,
		'height'			=> 86,
		'description' => __('Layout for portfolio items list', 'pixfort-core'),
		'options'        => array(
			[
				'name'            => __('Default', 'pixfort-core'),
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/shop/shop-default.svg',
				'value'            => 'default'
			],
			[
				'name'            => __('Default No Padding', 'pixfort-core'),
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/shop/shop-default-no-padding.svg',
				'value'            => 'default-no-padding'
			],
			[
				'name'            => __('Top Image', 'pixfort-core'),
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/shop/shop-top-image.svg',
				'value'            => 'top-img'
			],
			[
				'name'            => __('Top No Padding', 'pixfort-core'),
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/shop/shop-top-image-no-padding.svg',
				'value'            => 'top-img-no-padding'
			],
			[
				'name'            => __('Full Image', 'pixfort-core'),
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/shop/shop-full-image.svg',
				'value'            => 'full-img'
			]
		),
	]
);
$pixfortBuilder->addOption(
	'shop-col-count',
	[
		'type' => 'select',
		'label' => __('Number of Columns in Shop Page', 'pixfort-core'),
		'default'             => '3',
		'options' => [
			'2'        => __('2', 'pixfort-core'),
			'3'        => __('3 (Default)', 'pixfort-core'),
			'4'        => __('4', 'pixfort-core'),
			'5'        => __('5', 'pixfort-core'),
		],
		'tab'             => 'shopGeneral',
	]
);
$pixfortBuilder->addOption(
	'shop-tabs-style',
	[
		'type' => 'select',
		'label' => __('Shop Tabs Style', 'pixfort-core'),
		'default'             => 'pix-pills-1',
		'options' => [
			'pix-pills-1'        => __('Default (Gradient)', 'pixfort-core'),
			'pix-pills-solid'            => __('Solid', 'pixfort-core'),
			'pix-pills-light'            => __('Light', 'pixfort-core'),
			'pix-pills-outline'            => __('Outline', 'pixfort-core'),
			'pix-pills-line'            => __('Line', 'pixfort-core'),
			'pix-pills-round'            => __('Round', 'pixfort-core'),
		],
		'tab'             => 'shopGeneral',
	]
);
$pixfortBuilder->addOption(
	'shop-single-layout',
	[
		'type' => 'select',
		'label' => __('Product Page Layout', 'pixfort-core'),
		'default'             => 'default',
		'options' => [
			'default'        => __('Default (Gallery)', 'pixfort-core'),
			'pix-boxed-2'        => __('Gallery - Boxed description', 'pixfort-core'),
			'layout-2'            => __('Full', 'pixfort-core'),
			'layout-3'            => __('Full - Boxed description', 'pixfort-core'),
		],
		'tab'             => 'shopGeneral',
	]
);
$pixfortBuilder->addOption(
	'shop-single-sidebar',
	[
		'type' => 'checkbox',
		'label' => __('Enable Right Sidebar in Product Page', 'pixfort-core'),
		'options'         => array('1' => 'On', '0' => 'Off'),
		'default'           => '0',
		'tab'             => 'shopGeneral'
	]
);
$pixfortBuilder->addOption(
	'shop-bg-color',
	[
		'type' => 'select',
		'label' => __('Shop Background Color', 'pixfort-core'),
		'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
		'groups' => true,
		'tab'             => 'shopGeneral',
		'default'         => \PixfortCore::instance()->adminCore->getParam('shop_bg_color', 'gray-1'),
	]
);
$pixfortBuilder->addOption(
	'custom-shop-bg-color',
	[
		'type'             => 'color',
		'tab'             => 'shopGeneral',
		'label'         => __('Custom Background Color', 'pixfort-core'),
		'default'         => '#FFFFFF',
		'disableAlpha'         => true,
		'dependency' => [
			'field' => 'shop-bg-color',
			'val' => ['custom']
		]
	]
);
$pixfortBuilder->addOption(
	'sidebar-shop',
	[
		'type' => 'select',
		'label' => __('Shop Sidebar', 'pixfort-core'),
		'options' => $sidebars,
		'default'             => 'sidebar-1',
		'tab'             => 'shopGeneral',
	]
);
$pixfortBuilder->addOption(
	'shop-products-count',
	[
		'type' => 'text',
		'label' => __('Shop Products Count', 'pixfort-core'),
		'description' => __('Default count is 12', 'pixfort-core'),
		'placeholder' => __('For example: 12', 'pixfort-core'),
		'tab'             => 'shopGeneral',
		'default'  => '12',
		// 'hideBorderBottom'   => true
	]
);
$pixfortBuilder->addOption(
	'shop-hide-top-padding',
	[
		'type' => 'checkbox',
		'label' => __('Hide Top Padding', 'pixfort-core'),
		'description' => __('Hide the padding before page content (under the header).', 'pixfort-core'),
		'options'         => array('1' => 'On', '0' => 'Off'),
		'default'           => '0',
		'tab'             => 'shopGeneral',
		'hideBorderBottom'   => true
	]
);