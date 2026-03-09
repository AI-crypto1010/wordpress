<?php

$pixfortBuilder->addOption(
	'pix-heading-portfolio-general',
	[
		'type'             => 'heading',
		'label'         => __('Portfolio', 'pixfort-core'),
		'tab'             => 'portfolioGeneral',
		'icon'            => 'portfolio',
		'linkText'            => __('Learn more about portfolio', 'pixfort-core'),
		'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_how_to_create_portfolio_page'),
		'linkIcon'            => 'bookmark'
	]
);
$pixfortBuilder->addOption(
	'portfolio-posts',
	[
		'type' => 'text',
		'label' => __('Portfolio Items per Page', 'pixfort-core'),
		'tab'             => 'portfolioGeneral',
		'default'  => '8',
	]
);
$pixfortBuilder->addOption(
	'portfolio-page-style',
	[
		'type' => 'radio',
		'label' => __('Portfolio Item Style', 'pixfort-core'),
		'default' => 'default',
		'tab'             => 'portfolioGeneral',
		'imageSize'       => '130',
		'width'				=> 130,
		'height'			=> 86,
		'description' => __('Style for portfolio items list', 'pixfort-core'),
		'options'        => array(
			[
				'name'            => __('Default', 'pixfort-core'),
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/portfolio/portfolio-default.svg',
				'value'            => 'default'
			],
			[
				'name'            => __('Mini', 'pixfort-core'),
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/portfolio/portfolio-mini.svg',
				'value'            => 'mini'
			],
			[
				'name'            => __('Transparent', 'pixfort-core'),
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/portfolio/portfolio-transparent.svg',
				'value'            => 'transparent'
			],
			[
				'name'            => __('3D', 'pixfort-core'),
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/portfolio/portfolio-3d.svg',
				'value'            => '3d'
			]
		),
	]
);
$pixfortBuilder->addOption(
	'portfolio-masonry-count',
	[
		'type' => 'select',
		'label' => __('Masonry Portfolio Count per Line', 'pixfort-core'),
		'tab'             => 'portfolioGeneral',
		'default'   => '4',
		'options' => [
			'6'             => '2',
			'4'             => '3',
			'3'         => '4',
			'2'         => '6',
		]
	]
);
$pixfortBuilder->addOption(
	'portfolio-layout',
	[
		'type' => 'select',
		'label' => __('Portfolio Item Layout', 'pixfort-core'),
		'tab'             => 'portfolioGeneral',
		'default'   => 'default',
		'options' => [
			'default'        => __('Default', 'pixfort-core'),
			'sidebar'        => __('With Sidebar', 'pixfort-core'),
			'sidebar-full'   => __('With Sidebar (Full width)', 'pixfort-core'),
			'box'            => __('Intro box', 'pixfort-core')
		]
	]
);
$pixfortBuilder->addOption(
	'portfolio-order',
	[
		'type' => 'select',
		'label' => __('Portoflio Items Order', 'pixfort-core'),
		'description' => __('Choose items order.', 'pixfort-core'),
		'tab'             => 'portfolioGeneral',
		'default'   => 'DESC',
		'options' => [
			'ASC'   => __('Ascending', 'pixfort-core'),
			'DESC'  => __('Descending', 'pixfort-core')
		]
	]
);
$pixfortBuilder->addOption(
	'portfolio-navigation',
	[
		'type' => 'checkbox',
		'label' => __('Enable Navigation Between Projects', 'pixfort-core'),
		'options'         => array('1' => 'On', '0' => 'Off'),
		'default'           => '1',
		'tab'             => 'portfolioGeneral'
	]
);
$pixfortBuilder->addOption(
	'portfolio-in-same-term',
	[
		'type' => 'checkbox',
		'label' => __('Navigation in Same Category', 'pixfort-core'),
		'description'     => __('Navigation arrows refer to projects in the same category.', 'pixfort-core'),
		'options'         => array('1' => 'On', '0' => 'Off'),
		'default'           => '0',
		'tab'             => 'portfolioGeneral',
		'dependency' => [
			'field' => 'portfolio-navigation',
			'val' => ['1', true]
		],
	]
);
$pixfortBuilder->addOption(
	'portfolio-post-info',
	[
		'type' => 'checkbox',
		'label' => __('Show Date and Author Info', 'pixfort-core'),
		'options'         => array('1' => 'On', '0' => 'Off'),
		'default'           => '0',
		'tab'             => 'portfolioGeneral'
	]
);
$pixfortBuilder->addOption(
	'portfolio-isotope',
	[
		'type' => 'checkbox',
		'label' => __('Enable Filters', 'pixfort-core'),
		'options'         => array('1' => 'On', '0' => 'Off'),
		'default'           => '1',
		'tab'             => 'portfolioGeneral'
	]
);
$pixfortBuilder->addOption(
	'portfolio-display-full',
	[
		'type' => 'checkbox',
		'label' => __('Display Full Size Images', 'pixfort-core'),
		'description' => __('Display the portfolio images in full size without cropping (except 3D style).', 'pixfort-core'),
		'options'         => array('1' => 'On', '0' => 'Off'),
		'default'           => '0',
		'tab'             => 'portfolioGeneral'
	]
);
$pixfortBuilder->addOption(
	'portfolio-slug',
	[
		'type' => 'text',
		'label' => __('Single Item Slug', 'pixfort-core'),
		'description' => __('<b>Important:</b> Do not use characters not allowed in links. <br />Must be different from the Portfolio site title chosen above, eg. "portfolio-item". After change please go to "Settings > Permalinks" and click "Save changes" button.', 'pixfort-core'),
		'tab'             => 'portfolioGeneral',
		'default'  => 'portfolio-item',
	]
);
$pixfortBuilder->addOption(
	'portfolio-bg-color',
	[
		'type' 			=> 'select',
		'label' 		=> __('Portfolio Background Color', 'pixfort-core'),
		'options' 		=> \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
		'groups' 		=> true,
		'tab'           => 'portfolioGeneral',
		'default'       => \PixfortCore::instance()->adminCore->getParam('portfolio_bg_color', 'gray-1'),
	]
);
$pixfortBuilder->addOption(
	'custom-portfolio-bg-color',
	[
		'type'             => 'color',
		'tab'             => 'portfolioGeneral',
		'label'         => __('Portfolio Custom Background Color', 'pixfort-core'),
		'default'         => '#FFFFFF',
		'disableAlpha'         => true,
		'dependency' => [
			'field' => 'portfolio-bg-color',
			'val' => ['custom']
		]
	]
);
$pixfortBuilder->addOption(
	'sidebar-portfolio',
	[
		'type' => 'select',
		'label' => __('Portfolio Sidebar', 'pixfort-core'),
		'options' => $sidebars,
		'default'             => 'sidebar-1',
		'tab'             => 'portfolioGeneral',
	]
);
$pixfortBuilder->addOption(
	'portfolio-orderby',
	[
		'type' => 'select',
		'label' => __('Portfolio Order by', 'pixfort-core'),
		'description' => __('Portfolio Items Order by Column', 'pixfort-core'),
		'tab'             => 'portfolioGeneral',
		'default'   => 'date',
		'options' => [
			'date'          => __('Date', 'pixfort-core'),
			'menu_order'    => __('Menu order', 'pixfort-core'),
			'title'         => __('Title', 'pixfort-core'),
			'rand'          => __('Random', 'pixfort-core'),
		],
		// 'hideBorderBottom'	=> true,
	]
);
$pixfortBuilder->addOption(
	'portfolio-hide-top-padding',
	[
		'type' => 'checkbox',
		'label' => __('Hide Top Padding', 'pixfort-core'),
		'description' => __('Hide the padding before page content (under the header).', 'pixfort-core'),
		'options'         => array('1' => 'On', '0' => 'Off'),
		'default'           => '0',
		'tab'             => 'portfolioGeneral',
		'hideBorderBottom'   => true
	]
);