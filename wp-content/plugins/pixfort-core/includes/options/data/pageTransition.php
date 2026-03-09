<?php

/*
    *   Page Transition
    */
	$pixfortBuilder->addOption(
		'pix-heading-pageTransition',
		[
			'type'             => 'heading',
			'label'         => __('Page Transition', 'pixfort-core'),
			'tab'             => 'pageTransition',
			'icon'            => 'loading',
			// 'linkText'            => __('Learn about website logo', 'pixfort-core'),
			// 'linkHref'            => '#',
			// 'linkIcon'            => 'bookmark'
		]
	);
	$pixfortBuilder->addOption(
		'site-page-transition',
		[
			'type' => 'select',
			'label' => __('Page Transition Style', 'pixfort-core'),
			'description'     => __('The transition style when entering/leaving the page.', 'pixfort-core'),
			'tab'             => 'pageTransition',
			'default'   => 'default',
			'options' => [
				"default"            => __("Default (Slide)", 'pixfort-core'),
				"fade-page-transition"        => __("Fade", 'pixfort-core'),
				"disable-page-transition"        => __("Disable", 'pixfort-core')
			]
		]
	);
	$pixfortBuilder->addOption(
		'site-page-transition-color',
		[
			'type'             => 'color',
			'tab'             => 'pageTransition',
			'label'         => __('Page Transition Background Color', 'pixfort-core'),
			// 'default'         => '#ffffff',
			'default'         => [
				'light' => '#ffffff',
				'dark' => '#000000'
			],
			'dynamic'         => true,
			'disableAlpha'         => true,
			'enableReset'	  => true,
			'dependency' => [
				'field' => 'site-page-transition',
				'val' => ['disable-page-transition'],
				'op'                => '!='
			]
		]
	);
	$pixfortBuilder->addOption(
		'site-disable-loading-bar',
		[
			'type' => 'checkbox',
			'label' => __('Disable Top Loading Bar', 'pixfort-core'),
			'options'         => array('1' => 'On', '0' => 'Off'),
			'default'           => '0',
			'description' => __('Note: The bar color is the website gradient color set in Theme Options → Design System → Colors.', 'pixfort-core'),
			'tab'             => 'pageTransition'
		]
	);
	$pixfortBuilder->addOption(
		'site-disable-loading-icon',
		[
			'type' => 'checkbox',
			'label' => __('Disable Loading Animation', 'pixfort-core'),
			'options'         => array('1' => 'On', '0' => 'Off'),
			'default'           => '0',
			'tab'             => 'pageTransition'
		]
	);
	$pixfortBuilder->addOption(
		'site-loading-style',
		[
			'type' => 'select',
			'label' => __('Loading Animation Style', 'pixfort-core'),
			'tab'             => 'pageTransition',
			'default'   => 'default',
			'hideBorderBottom'   => true,
			'options' => [
				"default"            => __("Default", 'pixfort-core'),
				"style-2"            => __("Bubbles", 'pixfort-core'),
				"style-3"            => __("Moving Bar", 'pixfort-core'),
				"style-4"            => __("Wobble Bar", 'pixfort-core'),
				"style-5"            => __("Circle", 'pixfort-core'),
				"style-6"            => __("Wobble Spinning bar", 'pixfort-core'),
				"style-7"            => __("Spinning bar", 'pixfort-core'),
				"style-8"            => __("Custom Image", 'pixfort-core'),
			],
			'dependency' => [
				'field' => 'site-disable-loading-icon',
				'val' => ['0', false]
			]
		]
	);
	$pixfortBuilder->addOption(
		'site-loading-img',
		[
			'type'             => 'media',
			'label'         => __('Custom Loading Image', 'pixfort-core'),
			'tab'             => 'pageTransition',
			'showBorderTop'   => true,
			'dynamic'         => true,
			'dependency' => [
				'field' => 'site-loading-style',
				'val' => ['style-8']
			]
		]
	);
	$pixfortBuilder->addOption(
		'site-loading-img-width',
		[
			'type' => 'text',
			'label' => __('Custom Loading Image Width', 'pixfort-core'),
			'tab'             => 'pageTransition',
			'description'     => __('Add width with unit.', 'pixfort-core') . '<br>' . __('Leave empty to use the default image size.', 'pixfort-core'),
			'placeholder'     => __('For example: 200px', 'pixfort-core'),
			'dependency' => [
				'field' => 'site-loading-style',
				'val' => ['style-8']
			],
			'hideBorderBottom'   => true
		]
	);
	if(defined('IS_PIXFORT_THEME')){
		if(defined('PIX_DEV')){
			$pixfortBuilder->addOption(
				'enable-view-transition',
				[
					'type' => 'checkbox',
					'label' => __('Enable view transition (Alpha)', 'pixfort-core'),
					'options'         => array('1' => 'On', '0' => 'Off'),
					'default'           => '0',
					'tab'             => 'pageTransition',
					'hideBorderBottom'   => true,
					'showBorderTop'   => true
				]
			);
		}
	}