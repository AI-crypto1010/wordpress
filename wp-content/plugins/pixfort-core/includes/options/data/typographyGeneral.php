<?php

$pixfortBuilder->addOption(
    'pix-heading-typography-general',
    [
        'type'             => 'heading',
        'label'         => __('Typography', 'pixfort-core'),
        'tab'             => 'typographyGeneral',
        'icon'            => 'typography',
        'linkText'            => __('How theme typography works?', 'pixfort-core'),
        'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_theme_typography'),
        'linkIcon'            => 'bookmark'
    ]
);
$pixfortBuilder->addOption(
    'opt-primary-font',
    [
        'type' => 'typography',
        'label' => __('Body Font', 'pixfort-core'),
        'description' => __('Primary font for body texts and paragraphs.', 'pixfort-core'),
        'tab'             => 'typographyGeneral',
        'default'     => array(
            'font-family' => 'Manrope',
            'google'      => true
        ),
        'hideBorderBottom'      => true,
        'note'      => __('The font family for body texts and paragraphs.', 'pixfort-core'),
        // 'hidePaddingBottom'      => true,
    ]
);
$pixfortBuilder->addOption(
    'opt-primary-font-spacing',
    [
        'type' => 'text',
        'label' => __('Body Font Spacing', 'pixfort-core'),
        // 'description' => __('Spacing between font letters (for example: -0.01em).', 'pixfort-core'),
        'tab'             => 'typographyGeneral',
        'default'  => '-0.01em',
        'hideBorderBottom'      => true,
        'placeholder'   => 'Example: -0.01em',
        'note'  => 'Spacing between font letters',
    ]
);
$pixfortBuilder->addOption(
    'opt-body-color',
    [
        'type' => 'select',
        'label' => __('Body Color', 'pixfort-core'),
        // 'options' => array_flip($main_colors),
        'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultColors' => false, 'gradients' => false]),
        'groups' => true,
        'tab'             => 'typographyGeneral',
        'description'     => __('Default body text color for light backgrounds.', 'pixfort-core'),
        'tooltipText'     => __('Light font colors (Body Color and Heading Color) : are the base font colors for Body and Heading fonts used by default across your website, and it\'s mainly used for text with light background.', 'pixfort-core') . '<br/><br/>' . __('For more information ', 'pixfort-core') . '<a target="_blank" href="'.\PixfortCore::instance()->adminCore->getParam('docs_theme_typography').'" target="_blank" class="text-primary font-semibold">check this article</a>',
        'default'  => 'gray-5',
        'hideBorderBottom'      => true,
    ]
);
$pixfortBuilder->addOption(
    'opt-custom-body-color',
    [
        'type'             => 'color',
        'tab'             => 'typographyGeneral',
        'label'         => __('Custom Body Color', 'pixfort-core'),
        'default'         => '#212529',
        'disableAlpha'         => true,
        'hideBorderBottom'      => true,
        'dependency' => [
            'field' => 'opt-body-color',
            'val' => ['custom']
        ]
    ]
);
if(defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG !== 'conseil') {
    $pixfortBuilder->addOption(
        'opt-dark-body-color',
        [
            'type' => 'select',
            'label' => __('Dark Body Color', 'pixfort-core'),
            // 'options' => array_flip($main_colors),
            'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultColors' => false, 'gradients' => false]),
            'groups' => true,
            'tab'             => 'typographyGeneral',
            'description'     => __('Body text color for dark backgrounds.', 'pixfort-core'),
            'tooltipText'     => __('Dark font colors (Dark Body Color and Dark Heading Color): are special colors used for text with dark background, the option to use dark colors is only available in specific places in the theme, especially for parts that can\'t be controlled via the page builder (like the intro section, pixfort Widgets, etc.).', 'pixfort-core') . '<br/><br/>' . __('For more information ', 'pixfort-core') . '<a target="_blank" href="'.\PixfortCore::instance()->adminCore->getParam('docs_theme_typography').'" target="_blank" class="text-primary font-semibold">check this article</a>',
            'default'  => 'light-opacity-7',
            'hideBorderBottom'      => true,
        ]
    );
    $pixfortBuilder->addOption(
        'opt-custom-dark-body-color',
        [
            'type'             => 'color',
            'tab'             => 'typographyGeneral',
            'label'         => __('Custom Dark Body Color', 'pixfort-core'),
            'default'         => '#eee',
            'disableAlpha'         => true,
            'hideBorderBottom'      => true,
            'dependency' => [
                'field' => 'opt-dark-body-color',
                'val' => ['custom']
            ]
        ]
    );
}
$pixfortBuilder->addOption(
    'opt-regular-font-weight',
    [
        'type' => 'text',
        'label' => __('Default Font Weight', 'pixfort-core'),
        'description' => __('Default regular font weight is 400.', 'pixfort-core'),
        'tooltipText'     => __('Please make sure that your font has the selected font weight. For example, if you choose "500" your font must have this font weight, otherwise, the font will not show correctly.', 'pixfort-core'),
        'tab'             => 'typographyGeneral',
        'default'  => '',
        'placeholder'   => 'Example: 400',
        'hideBorderBottom'      => true,
    ]
);
$pixfortBuilder->addOption(
    'opt-bold-font-weight',
    [
        'type' => 'text',
        'label' => __('Default Bold Font Weight', 'pixfort-core'),
        'description' => __('Default bold font weight is 700.', 'pixfort-core'),
        'tooltipText'     => __('Please make sure that your font has the selected font weight. For example, if you choose "800" your font must have this font weight, otherwise, the font will not show correctly.', 'pixfort-core'),
        'tab'             => 'typographyGeneral',
        'default'  => '',
        'placeholder'   => 'Example: 700',
    ]
);
/*
*   Heading Font
*/
$pixfortBuilder->addOption(
    'opt-secondary-font',
    [
        'type' => 'typography',
        'label' => __('Heading Font', 'pixfort-core'),
        'description' => __('Secondary font for headings.', 'pixfort-core'),
        'tab'             => 'typographyGeneral',
        'default'     => array(
            'font-family' => 'Manrope',
            'google'      => true
        ),
        'hideBorderBottom'      => true,
        // 'hidePaddingBottom'      => true,
        'note'      => __('The font family for headings (H1, H2, H3, H4, H5, H6).', 'pixfort-core'),
    ]
);
$pixfortBuilder->addOption(
    'opt-secondary-font-spacing',
    [
        'type' => 'text',
        'label' => __('Heading Font Spacing', 'pixfort-core'),
        // 'description' => __('Spacing between font letters (for example: -0.01em).', 'pixfort-core'),
        'tab'             => 'typographyGeneral',
        'default'  => '-0.01em',
        'hideBorderBottom'      => true,
        'placeholder'   => 'Example: -0.01em',
        'note'  => 'Spacing between font letters',
    ]
);
$pixfortBuilder->addOption(
    'opt-heading-color',
    [
        'type' => 'select',
        'label' => __('Heading Color', 'pixfort-core'),
        // 'options' => array_flip($main_colors),
        'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultColors' => false, 'gradients' => false]),
        'groups' => true,
        'tab'             => 'typographyGeneral',
        'description'     => __('Heading text color for light backgrounds.', 'pixfort-core'),
        'tooltipText'     => __('Light font colors (Body Color and Heading Color) : are the base font colors for Body and Heading fonts used by default across your website, and it\'s mainly used for text with light background.', 'pixfort-core') . '<br/><br/>' . __('For more information ', 'pixfort-core') . '<a target="_blank" href="'.\PixfortCore::instance()->adminCore->getParam('docs_theme_typography').'" target="_blank" class="text-primary font-semibold">check this article</a>',
        'default'  => 'gray-7',
        'hideBorderBottom'      => true,
    ]
);
$pixfortBuilder->addOption(
    'opt-custom-heading-color',
    [
        'type'             => 'color',
        'tab'             => 'typographyGeneral',
        'label'         => __('Custom Heading Color', 'pixfort-core'),
        'default'         => '#495057',
        'disableAlpha'         => true,
        'hideBorderBottom'      => true,
        'dependency' => [
            'field' => 'opt-heading-color',
            'val' => ['custom']
        ]
    ]
);
if(defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG !== 'conseil') {
    $pixfortBuilder->addOption(
        'opt-dark-heading-color',
        [
            'type' => 'select',
            'label' => __('Dark Heading Color', 'pixfort-core'),
            // 'options' => array_flip($main_colors),
            'options' => \PixfortCore::instance()->coreFunctions->getColorsArray(['defaultColors' => false, 'gradients' => false]),
            'groups' => true,
            'tab'             => 'typographyGeneral',
            'description'     => __('Heading text color for dark backgrounds.', 'pixfort-core'),
            'tooltipText'     => __('Dark font colors (Dark Body Color and Dark Heading Color): are special colors used for text with dark background, the option to use dark colors is only available in specific places in the theme, especially for parts that can\'t be controlled via the page builder (like the intro section, pixfort Widgets, etc.)', 'pixfort-core') . '<br/><br/>' . __('For more information ', 'pixfort-core') . '<a target="_blank" href="'.\PixfortCore::instance()->adminCore->getParam('docs_theme_typography').'" target="_blank" class="text-primary font-semibold">check this article</a>',
            'default'  => 'white',
            'hideBorderBottom'      => true,
        ]
    );
    $pixfortBuilder->addOption(
        'opt-custom-dark-heading-color',
        [
            'type'             => 'color',
            'tab'             => 'typographyGeneral',
            'label'         => __('Custom Dark Heading Color', 'pixfort-core'),
            'default'         => '#fff',
            'disableAlpha'         => true,
            'dependency' => [
                'field' => 'opt-dark-heading-color',
                'val' => ['custom']
            ]
        ]
    );
}
$pixfortBuilder->addOption(
    'opt-heading-font-weight',
    [
        'type' => 'text',
        'label' => __('Heading Font Weight', 'pixfort-core'),
        'description' => __('Leave empty to use the default font weight.', 'pixfort-core'),
        'tooltipText'     => __('Please make sure that your font has the selected font weight. For example, if you choose "500" your font must have this font weight, otherwise, the font will not show correctly.', 'pixfort-core'),
        'tab'             => 'typographyGeneral',
        'default'  => '',
        'placeholder'   => 'Example: 400',
        'hideBorderBottom'      => true,
    ]
);
$pixfortBuilder->addOption(
    'opt-heading-bold-font-weight',
    [
        'type' => 'text',
        'label' => __('Heading Bold Font Weight', 'pixfort-core'),
        'description' => __('Leave empty to use the default bold font weight.', 'pixfort-core'),
        'tooltipText'     => __('Please make sure that your font has the selected font weight. For example, if you choose "800" your font must have this font weight, otherwise, the font will not show correctly.', 'pixfort-core'),
        'tab'             => 'typographyGeneral',
        'default'  => '',
        'placeholder'   => 'Example: 700',
        'hideBorderBottom'  => true,
    ]
);
$pixfortBuilder->addOption(
    'pix-alert-typography',
    [
        'type'             => 'alert',
        'tab'             => 'typographyGeneral',
        // 'label'             => 'Use',
        'description'     => __('For information about the theme typography please check this article from our knowledge base:', 'pixfort-core'),
        // 'hidePaddingTop' => true,
        // 'hidePaddingBottom' => true,
        'style' => 'simple',
        // 'icon'  =>  'info',
        'linkOneText'  =>  __('Learn about Theme Typography', 'pixfort-core'),
        'linkOneHref'  =>  \PixfortCore::instance()->adminCore->getParam('docs_theme_typography'),
        'linkOneIcon'  =>  'bookmark'
    ]
);
