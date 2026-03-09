<?php

$pixfortBuilder->addOption(
    'pic-custom-css',
    [
        'type' => 'code',
        'label' => __('Custom CSS', 'pixfort-core'),
        'tab'             => 'layoutAdvanced',
        'description'     => __('Add custom CSS to your website.', 'pixfort-core'),
    ]
);
$pixfortBuilder->addOption(
    'pix-custom-js-header',
    [
        'type' => 'code',
        'label' => __('Custom JS (in Header)', 'pixfort-core'),
        'tab'             => 'layoutAdvanced',
        'mode'             => 'javascript',
        'description'     => __('Add custom Javascript code to your website header.', 'pixfort-core'),
    ]
);
$pixfortBuilder->addOption(
    'pix-custom-js-footer',
    [
        'type' => 'code',
        'label' => __('Custom JS (in Footer)', 'pixfort-core'),
        'tab'             => 'layoutAdvanced',
        'mode'             => 'javascript',
        'description'     => __('Add custom Javascript code to your website footer.', 'pixfort-core'),
    ]
);
$pixfortBuilder->addOption(
    'pix-custom-header-includes',
    [
        'type' => 'code',
        'label' => __('Custom Header Tags Include', 'pixfort-core'),
        'tab'             => 'layoutAdvanced',
        'mode'             => 'html',
        'description'     => __('Add custom code to your website header (for example external tags and scripts).', 'pixfort-core'),
    ]
);
$pixfortBuilder->addOption(
    'pix-custom-container-width',
    [
        'type' => 'text',
        'label' => __('Custom Website Width', 'pixfort-core'),
        'tab'             => 'layoutAdvanced',
        'description' => __('Input a custom website content width (with unit) to change the default width (the default is 1140px).', 'pixfort-core'),
    ]
);
$pixfortBuilder->addOption(
    'pix-mobile-breakpoint',
    [
        'type' => 'text',
        'label' => __('Custom Header Breakpoint', 'pixfort-core'),
        'tab'             => 'layoutAdvanced',
        'description' => __('Set a custom screen width (in pixels) to adjust the default breakpoint at which the header switches from the Desktop Header to the Tablet & Mobile Header (the default value is 1024px).', 'pixfort-core'),
        'hideBorderBottom'      => true,
    ]
);
