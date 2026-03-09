<?php

$pixfortBuilder->addOption(
	'pix-heading-blog-general',
	[
		'type'             => 'heading',
		'label'         => __('Blog', 'pixfort-core'),
		'tab'             => 'blogGeneral',
		'icon'            => 'blog',
		'linkText'            => __('Learn more about blog', 'pixfort-core'),
		'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_how_to_create_blog_page'),
		'linkIcon'            => 'bookmark'
	]
);
$pixfortBuilder->addOption(
	'blog-posts',
	[
		'type' => 'text',
		'label' => __('Posts per Blog Page', 'pixfort-core'),
		'tab'             => 'blogGeneral',
		'default'  => '8',
	]
);
$pixfortBuilder->addOption(
	'blog-page-layout',
	[
		'type' => 'radio',
		'label' => __('Blog Posts Layout', 'pixfort-core'),
		'default' => 'default',
		'tab'             => 'blogGeneral',
		'imageSize'       => '130',
		'description' => __('Layout for blog posts', 'pixfort-core'),
		'width'				=> 130,
		'height'			=> 86,
		'options'        => array(
			[
				'name'            	=> 'Default',
				'image'            	=> PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/default-blog-page.svg',
				'value'            	=> 'default'
			],
			[
				'name'            => 'Normal Grid',
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/grid-blog-page.svg',
				'value'            => 'grid'
			],
			[
				'name'            => 'Masonry grid',
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/masonry-blog-page.svg',
				'value'            => 'masonry'
			]
		),
	]
);
$pixfortBuilder->addOption(
	'blog-grid-count',
	[
		'type' => 'select',
		'label' => __('Grid Post Count per Line', 'pixfort-core'),
		'tab'             => 'blogGeneral',
		'default'   => '4',
		'options' => [
			'6'             => '2',
			'4'             => '3',
			'3'         => '4',
		],
		'dependency' => [
			'field' => 'blog-page-layout',
			'val' => ['grid']
		],
	]
);
$pixfortBuilder->addOption(
	'blog-masonry-count',
	[
		'type' => 'select',
		'label' => __('Masonry Post Count per Line', 'pixfort-core'),
		'tab'             => 'blogGeneral',
		'default'   => '3',
		'options' => [
			'2'             => '2',
			'3'             => '3',
			'4'         => '4',
			'5'         => '5',
		],
		'hideBorderBottom'      => false,
		'dependency' => [
			'field' => 'blog-page-layout',
			'val' => ['masonry']
		],
	]
);
$sidebarStartImg = PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/sidebar-left.svg';
$sidebarEndImg = PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/sidebar-right.svg';
if(is_rtl()){
	$sidebarStartImg = PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/sidebar-right.svg';
	$sidebarEndImg = PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/sidebar-left.svg';
}
$pixfortBuilder->addOption(
	'blog-page-template',
	[
		'type' => 'radio',
		'label' => __('Blog Layout', 'pixfort-core'),
		'default' => 'right-sidebar',
		'tab'             => 'blogGeneral',
		'imageSize'       => '130',
		'width'				=> 130,
		'height'			=> 86,
		'description' => __('Layout for blog, archive, search, author,..etc pages.', 'pixfort-core'),
		'options'        => array(
			[
				'name'            => 'With Offset',
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/default-layout.svg',
				'value'            => 'with-offset'
			],
			[
				'name'            => 'Normal Width',
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/default-layout-normal.svg',
				'value'            => 'full-width'
			],
			[
				'name'            => 'Full Page Width',
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/default-layout-full.svg',
				'value'            => 'full-page-width'
			],
			[
				'name'            => 'Sidebar End',
				'image'            => $sidebarEndImg,
				'value'            => 'right-sidebar'
			],
			[
				'name'            => 'Sidebar Left',
				'image'            => $sidebarStartImg,
				'value'            => 'left-sidebar'
			]
		),
	]
);

$styleImageStart = PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/style-left-image.svg';
$styleImageEnd = PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/style-right-image.svg';
if(is_rtl()){
	$styleImageStart = PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/style-right-image.svg';
	$styleImageEnd = PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/style-left-image.svg';
}
$pixfortBuilder->addOption(
	'blog-style',
	[
		'type' => 'radio',
		'label' => __('Blog Posts Style', 'pixfort-core'),
		'default' => 'default',
		'tab'             => 'blogGeneral',
		'imageSize'       => '130',
		'width'				=> 130,
		'height'			=> 86,
		'options'        => array(
			[
				'name'            => 'Default',
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/style-default.svg',
				'value'            => 'default'
			],
			[
				'name'            => 'With padding',
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/style-with-padding.svg',
				'value'            => 'with-padding'
			],
			[
				'name'            => 'Image Start',
				'image'            => $styleImageStart,
				'value'            => 'left-img'
			],
			[
				'name'            => 'Image End',
				'image'            => $styleImageEnd,
				'value'            => 'right-img'
			],
			[
				'name'            => 'Full Image',
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/style-full-image.svg',
				'value'            => 'full-img'
			]
		),
	]
);

$blogLayoutSidebarStartImg = PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/sidebar-left.svg';
$blogLayoutSidebarEndImg = PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/sidebar-right.svg';
if(is_rtl()){
	$blogLayoutSidebarStartImg = PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/sidebar-right.svg';
	$blogLayoutSidebarEndImg = PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/sidebar-left.svg';
}
$pixfortBuilder->addOption(
	'blog-layout',
	[
		'type' => 'radio',
		'label' => __('Post Layout', 'pixfort-core'),
		'default' => 'default',
		'tab'             => 'blogGeneral',
		'imageSize'       => '130',
		'width'				=> 130,
		'height'			=> 86,
		'description' => __('Layout for post pages.', 'pixfort-core'),
		'options'        => array(
			[
				'name'            => __('Default', 'pixfort-core'),
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/default-layout.svg',
				'value'            => 'default'
			],
			[
				'name'            => __('Normal width', 'pixfort-core'),
				'image'            => PIX_CORE_PLUGIN_URI . 'includes/assets/core-options/thumbnails/blog/default-layout-normal.svg',
				'value'            => 'default-normal'
			],
			[
				'name'            => __('Sidebar End', 'pixfort-core'),
				'image'            => $blogLayoutSidebarEndImg,
				'value'            => 'right-sidebar'
			],
			[
				'name'            => __('Sidebar Start', 'pixfort-core'),
				'image'            => $blogLayoutSidebarStartImg,
				'value'            => 'left-sidebar'
			]
		),
	]
);
$pixfortBuilder->addOption(
	'blog-full-width-layout',
	[
		'type' => 'checkbox',
		'label' => __('Post Full Width Layout', 'pixfort-core'),
		'options'         => array('1' => 'On', '0' => 'Off'),
		'default'           => '0',
		'tab'             => 'blogGeneral'
	]
);
$pixfortBuilder->addOption(
	'blog-style-box',
	[
		'type' => 'checkbox',
		'label' => __('Add Box Style', 'pixfort-core'),
		'description' => __('Add white box for each post.', 'pixfort-core'),
		'options'         => array('1' => 'On', '0' => 'Off'),
		'default'           => '1',
		'tab'             => 'blogGeneral',
		'dependency' => [
			'field' => 'blog-style',
			'val' => ['full-img'],
			'op'                => '!='
		],
	]
);
$pixfortBuilder->addOption(
	'blog-bg-color',
	[
		'type' => 'select',
		'label' => __('Blog Background Color', 'pixfort-core'),
		'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true]),
		'groups' => true,
		'default'         => \PixfortCore::instance()->adminCore->getParam('blog_bg_color', 'gray-1'),
		'tab'             => 'blogGeneral',
	]
);
$pixfortBuilder->addOption(
	'custom-blog-bg-color',
	[
		'type'             => 'color',
		'tab'             => 'blogGeneral',
		'label'         => __('Blog Custom Background Color', 'pixfort-core'),
		'default'         => '#FFFFFF',
		'disableAlpha'         => true,
		'dependency' => [
			'field' => 'blog-bg-color',
			'val' => ['custom']
		]
	]
);
$pixfortBuilder->addOption(
	'sidebar-blog',
	[
		'type' => 'select',
		'label' => __('Blog Sidebar', 'pixfort-core'),
		'options' => $sidebars,
		'default'             => 'sidebar-1',
		'tab'             => 'blogGeneral',
	]
);
$pixfortBuilder->addOption(
	'blog-box-rounded',
	[
		'type' => 'select',
		'label' => __('Post Rounded Corners', 'pixfort-core'),
		'default'             => 'rounded-lg',
		'options' => [
			'rounded-0'    => __('No', 'pixfort-core'),
			'rounded'      => __('Rounded', 'pixfort-core'),
			'rounded-lg'   => __('Rounded Large', 'pixfort-core'),
			'rounded-xl'   => __('Rounded 5px', 'pixfort-core'),
			'rounded-10'   => __('Rounded 10px', 'pixfort-core')
		],
		'tab'             => 'blogGeneral',
	]
);
$pixfortBuilder->addOption(
	'blog-box-style',
	[
		'type' => 'select',
		'label' => __('Post Shadow Style', 'pixfort-core'),
		'default'             => '1',
		'options' => [
			""        => __('Default', 'pixfort-core'),
			"1"       => __('Small shadow', 'pixfort-core'),
			"2"       => __('Medium shadow', 'pixfort-core'),
			"3"       => __('Large shadow', 'pixfort-core'),
			"4"       => __('Inverse Small shadow', 'pixfort-core'),
			"5"       => __('Inverse Medium shadow', 'pixfort-core'),
			"6"       => __('Inverse Large shadow', 'pixfort-core'),
		],
		'tab'             => 'blogGeneral',
	]
);
$pixfortBuilder->addOption(
	'blog-box-hover-effect',
	[
		'type' => 'select',
		'label' => __('Post Shadow Hover Style', 'pixfort-core'),
		'default'             => '1',
		'options' => [
			""       => __('None', 'pixfort-core'),
			"1"       => __('Small hover shadow', 'pixfort-core'),
			"2"       => __('Medium hover shadow', 'pixfort-core'),
			"3"       => __('Large hover shadow', 'pixfort-core'),
			"4"       => __('Inverse Small hover shadow', 'pixfort-core'),
			"5"       => __('Inverse Medium hover shadow', 'pixfort-core'),
			"6"       => __('Inverse Large hover shadow', 'pixfort-core'),
		],
		'tab'             => 'blogGeneral',
	]
);
$pixfortBuilder->addOption(
	'blog-box-add-hover-effect',
	[
		'type' => 'select',
		'label' => __('Post Hover Animation', 'pixfort-core'),
		'default'             => '1',
		'options' => [
			""       => __('None', 'pixfort-core'),
			"1"       => __('Fly Small', 'pixfort-core'),
			"2"       => __('Fly Medium', 'pixfort-core'),
			"3"       => __('Fly Large', 'pixfort-core'),
			"4"       => __('Scale Small', 'pixfort-core'),
			"5"       => __('Scale Medium', 'pixfort-core'),
			"6"       => __('Scale Large', 'pixfort-core'),
			"7"       => __('Scale Inverse Small', 'pixfort-core'),
			"8"       => __('Scale Inverse Medium', 'pixfort-core'),
			"9"       => __('Scale Inverse Large', 'pixfort-core'),
		],
		'tab'             => 'blogGeneral',
		// 'hideBorderBottom'  => true,
	]
);
$pixfortBuilder->addOption(
	'blog-hide-top-padding',
	[
		'type' => 'checkbox',
		'label' => __('Hide Top Padding', 'pixfort-core'),
		'description' => __('Hide the padding before page content (under the header).', 'pixfort-core'),
		'options'         => array('1' => 'On', '0' => 'Off'),
		'default'           => '0',
		'tab'             => 'blogGeneral',
		'hideBorderBottom'   => true
	]
);