<?php

$pixfortBuilder->addOption(
	'pix-heading-portfolio-intro',
	[
		'type'             => 'heading',
		'label'         => __('Portfolio Intro', 'pixfort-core'),
		'tab'             => 'portfolioIntro',
		'icon'            => 'intro',
		// 'linkText'            => __('Learn more about blog', 'pixfort-core'),
		// 'linkIcon'            => 'bookmark'
	]
);
$pixfortBuilder->addOption(
    'portfolio-with-intro',
    [
        'type' => 'checkbox',
        'label' => __('Enable Portfolio Pages Intro', 'pixfort-core'),
        'description' => __('Add intro section at the beginning of the portfolio.', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '1',
        'tab'             => 'portfolioIntro'
    ]
);
$pixfortBuilder->addOption(
    'portfolio-divider-style',
    [
        'type' => 'radio',
        'label' => __('Portfolio Intro Divider Style', 'pixfort-core'),
        'description' => __('Choose the shape of the intro divider.', 'pixfort-core'),
        'default' => '0',
        'tab'             => 'portfolioIntro',
        'imageSize'       => '130',
        'width'				=> 130,
		'height'			=> 86,
        'options'        => $opts_dividers,
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
        'hideBorderBottom'      => true,
    ]
);
$pixfortBuilder->addOption(
    'pix-portfolio-intro-style-alert',
    [
        'type'             => 'alert',
        'tab'             => 'portfolioIntro',
        'description'     => __('The intro divider color is the same as the portfolio background color set in Portfolio → General → Portfolio Background Color', 'pixfort-core'),
        'hidePaddingBottom' => false,
        'hidePaddingTop' => true,
        'style' => 'clean',
        'icon'  =>  'info',
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'portfolio-divider-height',
    [
        'type' => 'text',
        'label' => __('Custom Divider Height (Optional)', 'pixfort-core'),
        'tab'             => 'portfolioIntro',
        'description' => __('Leave empty to use the default height for each divider.', 'pixfort-core'),
        'placeholder' => __('For example: 400px', 'pixfort-core'),
        'default'  => '',
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
        'showBorderTop'   => true,
    ]
);
$pixfortBuilder->addOption(
    'portfolio-intro-img',
    [
        'type'             => 'media',
        'label'         => __('Portfolio Intro background image', 'pixfort-core'),
        'default'         => '',
        'tab'             => 'portfolioIntro',
        'showBorderTop'   => false,
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
        'removePadding'       => true,
    ]
);
$pixfortBuilder->addOption(
    'portfolio-disable-intro-img-animation',
    [
        'type' => 'checkbox',
        'label' => __('Disable Intro image animation', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'portfolioIntro',
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
    ]
);

// $pixfortBuilder->addOption(
//     'portfolio-intro-light',
//     [
//         'type' => 'checkbox',
//         'label' => __('Enable Light Portfolio Intro Text', 'pixfort-core'),
//         'description' => __('Disable to display dark text in the intro.', 'pixfort-core'),
//         'options'         => array('1' => 'On', '0' => 'Off'),
//         'default'           => '1',
//         'tab'             => 'portfolioIntro',
//         'dependency' => [
//             'field' => 'portfolio-with-intro',
//             'val' => ['1', true]
//         ],
//     ]
// );

$pixfortBuilder->addOption(
    'portfolio-intro-light',
    [
        'type' => 'deleted',
        'label' => __('Enable light Portfolio intro text', 'pixfort-core'),
        'description' => __('Disable to display dark text in the intro.', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '',
        'tab'             => 'portfolioIntro',
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$defaultIntroTitleColor = 'heading-default';
$defaultIntroTitleColorCustom = '#495057';
$defaultIntroBreadcrumbsColor = 'body-default';
$defaultIntroBreadcrumbsColorCustom = '#6c757d';

if (!empty(pix_plugin_get_option('portfolio-intro-light'))) {
    if (pix_plugin_get_option('portfolio-intro-light')==='1') {
        $defaultIntroTitleColor = pix_plugin_get_option('opt-dark-heading-color');
        $defaultIntroTitleColorCustom = pix_plugin_get_option('opt-custom-dark-heading-color');
        $defaultIntroBreadcrumbsColor = pix_plugin_get_option('opt-dark-body-color');
        $defaultIntroBreadcrumbsColorCustom = pix_plugin_get_option('opt-custom-dark-body-color');
    }
}

$pixfortBuilder->addOption(
    'portfolio-intro-title-color',
    [
        'type' => 'select',
        'label' => __('Portfolio Intro title color', 'pixfort-core'),
        'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => false]),
        'groups' => true,
        'default'             => $defaultIntroTitleColor,
        'tab'             => 'portfolioIntro',
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'portfolio-intro-title-color-custom',
    [
        'type'             => 'color',
        'tab'             => 'portfolioIntro',
        'label'         => __('Custom Portfolio Intro title color', 'pixfort-core'),
        'default'         => $defaultIntroTitleColorCustom,
        'disableAlpha'         => true,
        'hideBorderBottom'      => true,
        'dependency' => [
            'field' => 'portfolio-intro-title-color',
            'val' => ['custom']
        ]
    ]
);
$pixfortBuilder->addOption(
    'portfolio-intro-breadcrumbs-color',
    [
        'type' => 'select',
        'label' => __('Portfolio Intro Breadcrumbs color', 'pixfort-core'),
        'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => false]),
        'groups' => true,
        'default'             => $defaultIntroBreadcrumbsColor,
        'tab'             => 'portfolioIntro',
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'portfolio-intro-breadcrumbs-color-custom',
    [
        'type'             => 'color',
        'tab'             => 'portfolioIntro',
        'label'         => __('Custom Portfolio Intro Breadcrumbs color', 'pixfort-core'),
        'default'         => $defaultIntroBreadcrumbsColorCustom,
        'disableAlpha'         => true,
        'hideBorderBottom'      => true,
        'dependency' => [
            'field' => 'portfolio-intro-breadcrumbs-color',
            'val' => ['custom']
        ]
    ]
);


$pixfortBuilder->addOption(
    'portfolio-intro-align',
    [
        'type' => 'select',
        'label' => __('Portfolio Intro Text Align', 'pixfort-core'),
        'default'             => 'text-center',
        'options' => [
            'text-left'   => __('Left', 'pixfort-core'),
            'text-center'   => __('Center', 'pixfort-core'),
            'text-right'   => __('Right', 'pixfort-core')
        ],
        'tab'             => 'portfolioIntro',
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'portfolio-intr-bg-color',
    [
        'type' => 'select',
        'label' => __('Portfolio Intro Overlay Color', 'pixfort-core'),
        // 'options' => array_flip($bg_colors_no_custom),
        'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true, 'defaultValue' => false, 'custom' => false]),
		'groups' => true,
        'default'             => 'primary',
        'tab'             => 'portfolioIntro',
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'portfolio-intro-opacity',
    [
        'type' => 'select',
        'label' => __('Portfolio Intro Overlay Opacity', 'pixfort-core'),
        'default'             => 'pix-opacity-2',
        'tab'             => 'portfolioIntro',
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
        //     'field' => 'portfolio-with-intro',
        //     'val' => ['1', true]
        // ],
        'dependency' => [
            'field' => 'portfolio-intro-img',
            'val' => ['0', false, ''],
            'op'                => '!='
        ]
    ]
);
$pixfortBuilder->addOption(
    'portfolio-disable-title-animation',
    [
        'type' => 'checkbox',
        'label' => __('Disable Portfolio Intro Title Animation', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'portfolioIntro'
    ]
);
$pixfortBuilder->addOption(
    'portfolio-disable-intro-title',
    [
        'type' => 'checkbox',
        'label' => __('Disable Portfolio Intro Title', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'portfolioIntro',
    ]
);
$pixfortBuilder->addOption(
    'portfolio-disable-intro-breadcrumbs',
    [
        'type' => 'checkbox',
        'label' => __('Disable Portfolio Intro Breadcrumbs', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'portfolioIntro',
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'portfolio-disable-intro-parallax',
    [
        'type' => 'checkbox',
        'label' => __('Disable Intro Parallax Effect', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'portfolioIntro',
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'portfolio-intro-top-height',
    [
        'type' => 'text',
        'label' => __('Custom Top padding (Optional)', 'pixfort-core'),
        'tab'             => 'portfolioIntro',
        'description' => __('Leave empty to use the default top padding for the intro.', 'pixfort-core'),
        'placeholder' => __('For example: 200px', 'pixfort-core'),
        'default'  => '',
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'portfolio-intro-bottom-height',
    [
        'type' => 'text',
        'label' => __('Custom Bottom Padding (Optional)', 'pixfort-core'),
        'tab'             => 'portfolioIntro',
        'description' => __('Leave empty to use the default bottom padding for the intro.', 'pixfort-core'),
        'placeholder' => __('For example: 200px', 'pixfort-core'),
        'default'  => '',
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'portfolio-mobile-intro-top-height',
    [
        'type' => 'text',
        'label' => __('Custom Mobile Top Padding (Optional)', 'pixfort-core'),
        'tab'             => 'portfolioIntro',
        'description' => __('Leave empty to use the default bottom padding for the intro.', 'pixfort-core'),
        'placeholder' => __('For example: 200px', 'pixfort-core'),
        'default'  => '',
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'portfolio-mobile-intro-bottom-height',
    [
        'type' => 'text',
        'label' => __('Custom Mobile Bottom Padding (Optional)', 'pixfort-core'),
        'tab'             => 'portfolioIntro',
        'description' => __('Leave empty to use the default bottom padding for the intro.', 'pixfort-core'),
        'placeholder' => __('For example: 200px', 'pixfort-core'),
        'default'  => '',
        'dependency' => [
            'field' => 'portfolio-with-intro',
            'val' => ['1', true]
        ],
        'hideBorderBottom'  => true,
    ]
);
if(\PixfortCore::instance()->getThemeParam('custom_intros')) {
    $pixfortBuilder->addOption(
        'pix-alert-portfolio-intro',
        [
            'type'             => 'alert',
            'tab'             => 'portfolioIntro',
            'description'     => __('If you are looking to create a custom intro section and display it on specific pages, check this article from our knowledge base:', 'pixfort-core'),
            'style' => 'simple',
            'icon'  =>  'info',
            'linkOneText'  =>  __('Learn how to create a custom intro section', 'pixfort-core'),
            'linkOneHref'  =>  \PixfortCore::instance()->adminCore->getParam('docs_create_intro'),
            'linkOneIcon'  =>  'bookmark',
        ]
    );
}