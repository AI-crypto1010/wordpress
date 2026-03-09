<?php

$pixfortBuilder->addOption(
	'pix-heading-shop-intro',
	[
		'type'             => 'heading',
		'label'         => 'Shop Intro',
		'tab'             => 'shopIntro',
		'icon'            => 'intro',
		'linkText'            => __('Learn more about intro section', 'pixfort-core'),
		'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_customize_page_intro_section'),
		'linkIcon'            => 'bookmark'
	]
);
$pixfortBuilder->addOption(
    'shop-with-intro',
    [
        'type' => 'checkbox',
        'label' => __('Enable Shop Intro', 'pixfort-core'),
        'description' => __('Add intro section at the beginning of the Shop.', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '1',
        'tab'             => 'shopIntro',
        'tooltipText'     => __('The Intro Section is the first section in the page after the header, which contains the page title and breadcrumbs.', 'pixfort-core') . '<br/><br/>' . __('For more information ', 'pixfort-core') . '<a target="_blank" href="'.\PixfortCore::instance()->adminCore->getParam('docs_customize_page_intro_section').'" target="_blank" class="text-primary font-semibold">check this article</a>',
        'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/core-options/tooltips/core-options-tooltip-page-intro-section.webp',
    ]
);
$pixfortBuilder->addOption(
    'shop-divider-style',
    [
        'type' => 'radio',
        'label' => __('Shop Divider Style', 'pixfort-core'),
        'default' => '0',
        'tab'             => 'shopIntro',
        'imageSize'       => '130',
        'width'				=> 130,
		'height'			=> 86,
        'options'        => $opts_dividers,
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
        'hideBorderBottom'      => true,
    ]
);
$pixfortBuilder->addOption(
    'pix-shop-intro-style-alert',
    [
        'type'             => 'alert',
        'tab'             => 'shopIntro',
        'description'     => __('The intro divider color is the same as the shop background color set in Shop → General → Shop Background Color', 'pixfort-core'),
        'hidePaddingBottom' => false,
        'hidePaddingTop' => true,
        'style' => 'clean',
        'icon'  =>  'info',
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'shop-divider-height',
    [
        'type' => 'text',
        'label' => __('Custom Divider Height (Optional)', 'pixfort-core'),
        'tab'             => 'shopIntro',
        'description' => __('Leave empty to use the default height for each divider.', 'pixfort-core'),
        'placeholder' => __('For example: 400px', 'pixfort-core'),
        'default'  => '',
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
        'showBorderTop'   => true,
    ]
);
$pixfortBuilder->addOption(
    'shop-intro-img',
    [
        'type'             => 'media',
        'label'         => __('Shop Intro Background Image', 'pixfort-core'),
        'default'         => '',
        'tab'             => 'shopIntro',
        'showBorderTop'   => false,
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
        'removePadding'       => true,
    ]
);
$pixfortBuilder->addOption(
    'shop-disable-intro-img-animation',
    [
        'type' => 'checkbox',
        'label' => __('Disable Intro image animation', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'shopIntro',
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
    ]
);
// $pixfortBuilder->addOption(
//     'shop-intro-light',
//     [
//         'type' => 'checkbox',
//         'label' => __('Enable Light Shop Intro Text', 'pixfort-core'),
//         'description' => __('Disable to display dark text in the intro.', 'pixfort-core'),
//         'options'         => array('1' => 'On', '0' => 'Off'),
//         'default'           => '1',
//         'tab'             => 'shopIntro',
//         'dependency' => [
//             'field' => 'shop-with-intro',
//             'val' => ['1', true]
//         ],
//     ]
// );

$pixfortBuilder->addOption(
    'shop-intro-light',
    [
        'type' => 'deleted',
        'label' => __('Enable light Shop intro text', 'pixfort-core'),
        'description' => __('Disable to display dark text in the intro.', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '',
        'tab'             => 'shopIntro',
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$defaultIntroTitleColor = 'heading-default';
$defaultIntroTitleColorCustom = '#495057';
$defaultIntroBreadcrumbsColor = 'body-default';
$defaultIntroBreadcrumbsColorCustom = '#6c757d';

if (!empty(pix_plugin_get_option('shop-intro-light'))) {
    if (pix_plugin_get_option('shop-intro-light')==='1') {
        $defaultIntroTitleColor = pix_plugin_get_option('opt-dark-heading-color');
        $defaultIntroTitleColorCustom = pix_plugin_get_option('opt-custom-dark-heading-color');
        $defaultIntroBreadcrumbsColor = pix_plugin_get_option('opt-dark-body-color');
        $defaultIntroBreadcrumbsColorCustom = pix_plugin_get_option('opt-custom-dark-body-color');
    }
}

$pixfortBuilder->addOption(
    'shop-intro-title-color',
    [
        'type' => 'select',
        'label' => __('Shop Intro title color', 'pixfort-core'),
        'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => false]),
        'groups' => true,
        'default'             => $defaultIntroTitleColor,
        'tab'             => 'shopIntro',
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'shop-intro-title-color-custom',
    [
        'type'             => 'color',
        'tab'             => 'shopIntro',
        'label'         => __('Custom Shop Intro title color', 'pixfort-core'),
        'default'         => $defaultIntroTitleColorCustom,
        'disableAlpha'         => true,
        'hideBorderBottom'      => true,
        'dependency' => [
            'field' => 'shop-intro-title-color',
            'val' => ['custom']
        ]
    ]
);
$pixfortBuilder->addOption(
    'shop-intro-breadcrumbs-color',
    [
        'type' => 'select',
        'label' => __('Shop Intro Breadcrumbs color', 'pixfort-core'),
        'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => false]),
        'groups' => true,
        'default'             => $defaultIntroBreadcrumbsColor,
        'tab'             => 'shopIntro',
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'shop-intro-breadcrumbs-color-custom',
    [
        'type'             => 'color',
        'tab'             => 'shopIntro',
        'label'         => __('Custom Shop Intro Breadcrumbs color', 'pixfort-core'),
        'default'         => $defaultIntroBreadcrumbsColorCustom,
        'disableAlpha'         => true,
        'hideBorderBottom'      => true,
        'dependency' => [
            'field' => 'shop-intro-breadcrumbs-color',
            'val' => ['custom']
        ]
    ]
);


$pixfortBuilder->addOption(
    'shop-intro-align',
    [
        'type' => 'select',
        'label' => __('Shop Intro Text Align', 'pixfort-core'),
        'default'             => 'text-center',
        'options' => [
            'text-left'   => __('Left', 'pixfort-core'),
            'text-center'   => __('Center', 'pixfort-core'),
            'text-right'   => __('Right', 'pixfort-core')
        ],
        'tab'             => 'shopIntro',
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'shop-intr-bg-color',
    [
        'type' => 'select',
        'label' => __('Shop Intro Overlay Color', 'pixfort-core'),
        // 'options' => array_flip($bg_colors_no_custom),
        'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true, 'defaultValue' => false, 'custom' => false]),
		'groups' => true,
        'default'             => 'primary',
        'tab'             => 'shopIntro',
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'shop-intro-opacity',
    [
        'type' => 'select',
        'label' => __('Shop Intro Overlay Opacity', 'pixfort-core'),
        'default'             => 'pix-opacity-2',
        'tab'             => 'shopIntro',
        'options' => [
            'pix-opacity-10'   => "0%",
                'pix-opacity-9'   => "10%",
                'pix-opacity-8'   => "20%",
                'pix-opacity-7'   => "30%",
                'pix-opacity-6'   => "40%",
                'pix-opacity-5'   => "50%",
                'pix-opacity-4'   => "60%",
                'pix-opacity-3'   => "70%",
                'pix-opacity-2'   => "80%",
                'pix-opacity-1'   => "90%",
                'pix-opacity-0'   => "100%",
        ],
        // 'dependency' => [
        //     'field' => 'shop-with-intro',
        //     'val' => ['1', true]
        // ],
        'dependency' => [
            'field' => 'shop-intro-img',
            'val' => ['0', false, ''],
            'op'                => '!='
        ]
    ]
);
$pixfortBuilder->addOption(
    'shop-disable-title-animation',
    [
        'type' => 'checkbox',
        'label' => __('Disable Title Animation', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'shopIntro'
    ]
);
$pixfortBuilder->addOption(
    'shop-disable-intro-title',
    [
        'type' => 'checkbox',
        'label' => __('Disable Title', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'shopIntro',
    ]
);
$pixfortBuilder->addOption(
    'shop-disable-intro-breadcrumbs',
    [
        'type' => 'checkbox',
        'label' => __('Disable Breadcrumbs', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'shopIntro',
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'shop-disable-intro-parallax',
    [
        'type' => 'checkbox',
        'label' => __('Disable Intro Parallax Effect', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'shopIntro',
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'shop-intro-top-height',
    [
        'type' => 'text',
        'label' => __('Custom Intro Top Padding (Optional)', 'pixfort-core'),
        'tab'             => 'shopIntro',
        'description' => __('Leave empty to use the default top padding for the intro.', 'pixfort-core'),
        'placeholder' => __('For example: 200px', 'pixfort-core'),
        'default'  => '',
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'shop-intro-bottom-height',
    [
        'type' => 'text',
        'label' => __('Custom Intro Bottom Padding (Optional)', 'pixfort-core'),
        'tab'             => 'shopIntro',
        'description' => __('Leave empty to use the default bottom padding for the intro.', 'pixfort-core'),
        'placeholder' => __('For example: 200px', 'pixfort-core'),
        'default'  => '',
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'shop-mobile-intro-top-height',
    [
        'type' => 'text',
        'label' => __('Custom Intro Mobile Top Padding (Optional)', 'pixfort-core'),
        'tab'             => 'shopIntro',
        'description' => __('Leave empty to use the default bottom padding for the intro.', 'pixfort-core'),
        'placeholder' => __('For example: 200px', 'pixfort-core'),
        'default'  => '',
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'shop-mobile-intro-bottom-height',
    [
        'type' => 'text',
        'label' => __('Custom Intro Mobile Bottom Padding (Optional)', 'pixfort-core'),
        'tab'             => 'shopIntro',
        'description' => __('Leave empty to use the default bottom padding for the intro.', 'pixfort-core'),
        'placeholder' => __('For example: 200px', 'pixfort-core'),
        'default'  => '',
        'dependency' => [
            'field' => 'shop-with-intro',
            'val' => ['1', true]
        ],
        'hideBorderBottom'  => true,
    ]
);
if(\PixfortCore::instance()->getThemeParam('custom_intros')) {
    $pixfortBuilder->addOption(
        'pix-alert-shop-intro',
        [
            'type'             => 'alert',
            'tab'             => 'shopIntro',
            'description'     => __('If you are looking to create a custom intro section and display it on specific pages, check this article from our knowledge base:', 'pixfort-core'),
            'style' => 'simple',
            'icon'  =>  'info',
            'linkOneText'  =>  __('Learn how to create a custom intro section', 'pixfort-core'),
            'linkOneHref'  =>  \PixfortCore::instance()->adminCore->getParam('docs_create_intro'),
            'linkOneIcon'  =>  'bookmark',
        ]
    );
}