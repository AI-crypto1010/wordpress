<?php

/*
				*   Cookies consent
				*/
$pixfortBuilder->addOption(
    'pix-heading-cookies',
    [
        'type'             => 'heading',
        'label'         => __('Cookie Consent Banner', 'pixfort-core'),
        'tab'             => 'cookies',
        'icon'            => 'cookie',
        'linkText'            => __('Learn about cookie conset', 'pixfort-core'),
        'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_add_cookies'),
        'linkIcon'            => 'bookmark'
    ]
);
$pixfortBuilder->addOption(
    'pix-enable-cookies',
    [
        'type' => 'checkbox',
        'label' => __('Enable Cookie Banner', 'pixfort-core'),
        'description'     => __('Add Cookie consent bar at the bottom of the page.', 'pixfort-core'),
        'tooltipText'     => __('A cookie banner is a notification that appears on a website to inform visitors about the use of cookies for tracking or personalization purposes and to obtain their consent.', 'pixfort-core'),
        'tooltipImage'   => PIX_CORE_PLUGIN_URI . '/includes/assets/core-options/tooltips/core-options-tooltip-cookies-banner.webp',
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'cookies',
        'hideBorderBottom'      => true
    ]
);
$pixfortBuilder->addOption(
    'pix-cookies-id',
    [
        'type' => 'text',
        'label' => __('Cookie ID', 'pixfort-core'),
        'tab'             => 'cookies',
        'description' => __('Changing the ID will reset the closed state for all users (all users will start to see the banner again).', 'pixfort-core'),
        'default'     => 'Cookies-1',
        'placeholder'       => 'E.g. "Cookies-1"',
        'showBorderTop'      => true,
        'dependency' => [
            'field' => 'pix-enable-cookies',
            'val'               => ['', 'false', false],
            'op'                => '!='
        ]
    ]
);
$pixfortBuilder->addOption(
    'pix-cookies-text',
    [
        'type' => 'text',
        'label' => __('Cookie Banner Text', 'pixfort-core'),
        'placeholder'       => 'Enter banner text',
        'tab'             => 'cookies',
        'default'     => 'By using this website, you agree to our',
        'dependency' => [
            'field' => 'pix-enable-cookies',
            'val'               => ['', 'false', false],
            'op'                => '!='
        ]
    ]
);
$pixfortBuilder->addOption(
    'pix-cookies-btn',
    [
        'type' => 'text',
        'label' => __('Cookie Banner Button Text', 'pixfort-core'),
        'tab'             => 'cookies',
        'default'     => 'cookie policy',
        'placeholder'       => 'E.g. "cookie policy"',
        'dependency' => [
            'field' => 'pix-enable-cookies',
            'val'               => ['', 'false', false],
            'op'                => '!='
        ]
    ]
);
$pixfortBuilder->addOption(
    'pix-cookies-page',
    [
        'type' => 'select',
        'label' => __('Cookie Policy Page', 'pixfort-core'),
        'tab'             => 'cookies',
        'description'     => 'Choose a page for the cookies banner button (optional).',
        'options' => $pages,
        'dependency' => [
            'field' => 'pix-enable-cookies',
            'val'               => ['', 'false', false],
            'op'                => '!='
        ]
    ]
);
$pixfortBuilder->addOption(
    'pix-cookies-url',
    [
        'type' => 'text',
        'label' => __('Cookie Policy URL', 'pixfort-core'),
        'tab'             => 'cookies',
        'description'     => 'Choose a link for the cookies banner button (optional).',
        'placeholder'       => 'E.g. "https://example.com/policy"',
        'dependency' => [
            'field' => 'pix-enable-cookies',
            'val'               => ['', 'false', false],
            'op'                => '!='
        ]
    ]
);
$pixfortBuilder->addOption(
    'pix-cookies-target',
    [
        'type' => 'checkbox',
        'label' => __('Open Cookie Link in a New Tab', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '1',
        'tab'             => 'cookies',
        'description'     => 'When enabled, the cookies link will open in a new tab.',
        'dependency' => [
            'field' => 'pix-cookies-url',
            'val'               => ['', 'false', false],
            'op'                => '!='
        ]
    ]
);
$pixfortBuilder->addOption(
    'pix-cookies-popup',
    [
        'type' => 'select',
        'label' => __('Cookie Policy Popup', 'pixfort-core'),
        'tab'             => 'cookies',
        'description' => __('Show a popup instead of redirecting the user to a page or a link.', 'pixfort-core'),
        'options' => $popups,
        'dependency' => [
            'field' => 'pix-enable-cookies',
            'val'               => ['', 'false', false],
            'op'                => '!='
        ]
    ]
);
$pixfortBuilder->addOption(
    'cookie-img',
    [
        'type'             => 'media',
        'label'         => __('Cookie Banner Image', 'pixfort-core'),
        'default'         => '',
        'tab'             => 'cookies',
        'description'     => __('Leave empty to display the deafult cookie image.', 'pixfort-core'),
        'tooltipText'   => 'Image will be displayed at 30 pixels size.',
        'showBorderTop'   => false,
        'hideBorderBottom'   => true,
        'dependency' => [
            'field' => 'pix-enable-cookies',
            'val'               => ['', 'false', false],
            'op'                => '!='
        ]
    ]
);
