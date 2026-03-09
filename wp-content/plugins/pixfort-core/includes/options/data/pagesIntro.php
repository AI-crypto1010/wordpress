<?php

$pixfortBuilder->addOption(
	'pix-heading-pages-intro',
	[
		'type'             => 'heading',
		'label'         => __('Pages Intro', 'pixfort-core'),
		'tab'             => 'pagesIntro',
		'icon'            => 'intro',
		'linkText'            => __('Learn more about intro section', 'pixfort-core'),
		'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_customize_page_intro_section'),
		'linkIcon'            => 'bookmark'
	]
);
$pixfortBuilder->addOption(
    'pages-with-intro',
    [
        'type' => 'checkbox',
        'label' => __('Enable Pages Default Intro', 'pixfort-core'),
        'description' => __('Add intro section at the beginning of the Pages.', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '1',
        'tab'             => 'pagesIntro',
        'tooltipText'     => __('The Intro Section is the first section in the page after the header, which contains the page title and breadcrumbs.', 'pixfort-core') . '<br/><br/>' . __('For more information ', 'pixfort-core') . '<a target="_blank" href="'.\PixfortCore::instance()->adminCore->getParam('docs_customize_page_intro_section').'" target="_blank" class="text-primary font-semibold">check this article</a>',
        'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/core-options/tooltips/core-options-tooltip-page-intro-section.webp',
    ]
);
$pixfortBuilder->addOption(
    'pages-divider-style',
    [
        'type' => 'radio',
        'label' => __('Pages Divider style', 'pixfort-core'),
        'default' => '0',
        'tab'             => 'pagesIntro',
        'imageSize'       => '130',
        'width'				=> 130,
		'height'			=> 86,
        'options'        => $opts_dividers,
        'dependency' => [
            'field' => 'pages-with-intro',
            'val' => ['1', true]
        ],
        'hideBorderBottom'      => true,
    ]
);
$pixfortBuilder->addOption(
    'pix-pages-intro-style-alert',
    [
        'type'             => 'alert',
        'tab'             => 'pagesIntro',
        'description'     => __('The intro divider color is the same as the pages background color set in Pages → General → Pages Background Color', 'pixfort-core'),
        'hidePaddingBottom' => false,
        'hidePaddingTop' => true,
        'style' => 'clean',
        'icon'  =>  'info',
        'dependency' => [
            'field' => 'pages-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'pages-divider-height',
    [
        'type' => 'text',
        'label' => __('Custom Divider Height (Optional)', 'pixfort-core'),
        'tab'             => 'pagesIntro',
        'description' => __('Leave empty to use the default height for each divider.', 'pixfort-core'),
        'placeholder' => __('For example: 400px', 'pixfort-core'),
        'default'  => '',
        'dependency' => [
            'field' => 'pages-with-intro',
            'val' => ['1', true]
        ],
        'showBorderTop'   => true,
    ]
);
$pixfortBuilder->addOption(
    'pages-intro-img',
    [
        'type'             => 'media',
        'label'         => __('Pages Intro background image', 'pixfort-core'),
        'default'         => '',
        'tab'             => 'pagesIntro',
        'showBorderTop'   => false,
        'dependency' => [
            'field' => 'pages-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'pages-disable-intro-img-animation',
    [
        'type' => 'checkbox',
        'label' => __('Disable Intro image animation', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'pagesIntro',
        'dependency' => [
            'field' => 'pages-with-intro',
            'val' => ['1', true]
        ],
    ]
);


// if(PixfortCore::instance()->getThemeParam('dynamic_colors')) {
    $pixfortBuilder->addOption(
        'pages-intro-light',
        [
            'type' => 'deleted',
            'label' => __('Enable light Pages intro text', 'pixfort-core'),
            'description' => __('Disable to display dark text in the intro.', 'pixfort-core'),
            'options'         => array('1' => 'On', '0' => 'Off'),
            'default'           => '',
            'tab'             => 'pagesIntro',
            'dependency' => [
                'field' => 'pages-with-intro',
                'val' => ['1', true]
            ],
        ]
    );
    $defaultIntroTitleColor = 'heading-default';
    $defaultIntroTitleColorCustom = '#495057';
    $defaultIntroBreadcrumbsColor = 'body-default';
    $defaultIntroBreadcrumbsColorCustom = '#6c757d';
    
    if (!empty(pix_plugin_get_option('pages-intro-light'))) {
        if (pix_plugin_get_option('pages-intro-light')==='1') {
            $defaultIntroTitleColor = pix_plugin_get_option('opt-dark-heading-color');
            $defaultIntroTitleColorCustom = pix_plugin_get_option('opt-custom-dark-heading-color');
            $defaultIntroBreadcrumbsColor = pix_plugin_get_option('opt-dark-body-color');
            $defaultIntroBreadcrumbsColorCustom = pix_plugin_get_option('opt-custom-dark-body-color');
        }
    }

    $pixfortBuilder->addOption(
        'pages-intro-title-color',
        [
            'type' => 'select',
            'label' => __('Pages Intro title color', 'pixfort-core'),
            'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => false]),
            'groups' => true,
            'default'             => $defaultIntroTitleColor,
            'tab'             => 'pagesIntro',
            'dependency' => [
                'field' => 'pages-with-intro',
                'val' => ['1', true]
            ],
        ]
    );
    $pixfortBuilder->addOption(
        'pages-intro-title-color-custom',
        [
            'type'             => 'color',
            'tab'             => 'pagesIntro',
            'label'         => __('Custom Pages Intro title color', 'pixfort-core'),
            'default'         => $defaultIntroTitleColorCustom,
            'disableAlpha'         => true,
            'hideBorderBottom'      => true,
            'dependency' => [
                'field' => 'pages-intro-title-color',
                'val' => ['custom']
            ]
        ]
    );
    $pixfortBuilder->addOption(
        'pages-intro-breadcrumbs-color',
        [
            'type' => 'select',
            'label' => __('Pages Intro Breadcrumbs color', 'pixfort-core'),
            'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultValue' => false]),
            'groups' => true,
            'default'             => $defaultIntroBreadcrumbsColor,
            'tab'             => 'pagesIntro',
            'dependency' => [
                'field' => 'pages-with-intro',
                'val' => ['1', true]
            ],
        ]
    );
    $pixfortBuilder->addOption(
        'pages-intro-breadcrumbs-color-custom',
        [
            'type'             => 'color',
            'tab'             => 'pagesIntro',
            'label'         => __('Custom Pages Intro Breadcrumbs color', 'pixfort-core'),
            'default'         => $defaultIntroBreadcrumbsColorCustom,
            'disableAlpha'         => true,
            'hideBorderBottom'      => true,
            'dependency' => [
                'field' => 'pages-intro-breadcrumbs-color',
                'val' => ['custom']
            ]
        ]
    );

// } else {
//     $pixfortBuilder->addOption(
//         'pages-intro-light',
//         [
//             'type' => 'checkbox',
//             'label' => __('Enable light Pages intro text', 'pixfort-core'),
//             'description' => __('Disable to display dark text in the intro.', 'pixfort-core'),
//             'options'         => array('1' => 'On', '0' => 'Off'),
//             'default'           => '1',
//             'tab'             => 'pagesIntro',
//             'dependency' => [
//                 'field' => 'pages-with-intro',
//                 'val' => ['1', true]
//             ],
//         ]
//     );
// }

$pixfortBuilder->addOption(
    'pages-intro-align',
    [
        'type' => 'select',
        'label' => __('Pages Intro text align', 'pixfort-core'),
        'default'             => 'text-center',
        'options' => [
            'text-left'   => __('Left', 'pixfort-core'),
            'text-center'   => __('Center', 'pixfort-core'),
            'text-right'   => __('Right', 'pixfort-core')
        ],
        'tab'             => 'pagesIntro',
        'dependency' => [
            'field' => 'pages-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'pages-intr-bg-color',
    [
        'type' => 'select',
        'label' => __('Pages Intro overlay color', 'pixfort-core'),
        // 'options' => array_flip($bg_colors_no_custom),
        'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'transparent' => true, 'defaultValue' => false, 'custom' => false]),
		'groups' => true,
        'default'             => 'primary',
        'tab'             => 'pagesIntro',
        'dependency' => [
            'field' => 'pages-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'pages-intro-opacity',
    [
        'type' => 'select',
        'label' => __('Pages Intro overlay opacity', 'pixfort-core'),
        'default'             => 'pix-opacity-2',
        'tab'             => 'pagesIntro',
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
        //     'field' => 'pages-with-intro',
        //     'val' => ['1', true]
        // ],
        'dependency' => [
            'field' => 'pages-intro-img',
            'val' => ['0', false, ''],
            'op'                => '!='
        ]
    ]
);
$pixfortBuilder->addOption(
    'pages-disable-title-animation',
    [
        'type' => 'checkbox',
        'label' => __('Disable Title animation', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'pagesIntro'
    ]
);
$pixfortBuilder->addOption(
    'pages-disable-intro-title',
    [
        'type' => 'checkbox',
        'label' => __('Disable Title', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'pagesIntro',
    ]
);
$pixfortBuilder->addOption(
    'pages-disable-intro-breadcrumbs',
    [
        'type' => 'checkbox',
        'label' => __('Disable Breadcrumbs', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'pagesIntro',
        'dependency' => [
            'field' => 'pages-with-intro',
            'val' => ['1', true]
        ]
    ]
);
$pixfortBuilder->addOption(
    'pages-disable-intro-parallax',
    [
        'type' => 'checkbox',
        'label' => __('Disable Intro Parallax effect', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'pagesIntro',
        'dependency' => [
            'field' => 'pages-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'pages-intro-top-height',
    [
        'type' => 'text',
        'label' => __('Custom top padding (Optional)', 'pixfort-core'),
        'tab'             => 'pagesIntro',
        'description' => __('Leave empty to use the default top padding for the intro.', 'pixfort-core'),
        'placeholder' => __('For example: 200px', 'pixfort-core'),
        'default'  => '',
        'dependency' => [
            'field' => 'pages-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'pages-intro-bottom-height',
    [
        'type' => 'text',
        'label' => __('Custom bottom padding (Optional)', 'pixfort-core'),
        'tab'             => 'pagesIntro',
        'description' => __('Leave empty to use the default bottom padding for the intro.', 'pixfort-core'),
        'placeholder' => __('For example: 200px', 'pixfort-core'),
        'default'  => '',
        'dependency' => [
            'field' => 'pages-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'pages-mobile-intro-top-height',
    [
        'type' => 'text',
        'label' => __('Custom Mobile top padding (Optional)', 'pixfort-core'),
        'tab'             => 'pagesIntro',
        'description' => __('Leave empty to use the default bottom padding for the intro.', 'pixfort-core'),
        'placeholder' => __('For example: 200px', 'pixfort-core'),
        'default'  => '',
        'dependency' => [
            'field' => 'pages-with-intro',
            'val' => ['1', true]
        ],
    ]
);
$pixfortBuilder->addOption(
    'pages-mobile-intro-bottom-height',
    [
        'type' => 'text',
        'label' => __('Custom Mobile bottom padding (Optional)', 'pixfort-core'),
        'tab'             => 'pagesIntro',
        'description' => __('Leave empty to use the default bottom padding for the intro.', 'pixfort-core'),
        'placeholder' => __('For example: 200px', 'pixfort-core'),
        'default'  => '',
        'dependency' => [
            'field' => 'pages-with-intro',
            'val' => ['1', true]
        ],
        'hideBorderBottom'  => true,
    ]
);
if(\PixfortCore::instance()->getThemeParam('custom_intros')) {
    $pixfortBuilder->addOption(
        'pix-alert-pages-intro',
        [
            'type'             => 'alert',
            'tab'             => 'pagesIntro',
            'description'     => __('If you are looking to create a custom intro section and display it on specific pages, check this article from our knowledge base:', 'pixfort-core'),
            'style' => 'simple',
            'icon'  =>  'info',
            'linkOneText'  =>  __('Learn how to create a custom intro section', 'pixfort-core'),
            'linkOneHref'  =>  \PixfortCore::instance()->adminCore->getParam('docs_create_intro'),
            'linkOneIcon'  =>  'bookmark',
        ]
    );
}