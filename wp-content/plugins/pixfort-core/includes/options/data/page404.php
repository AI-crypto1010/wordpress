<?php

/*
    *   404 Page
    */
$pixfortBuilder->addOption(
    'pix-heading-404-page',
    [
        'type'             => 'heading',
        'label'         => __('Custom 404 Page', 'pixfort-core'),
        'tab'             => 'page404',
        'icon'            => 'fileWarning',
        'linkText'            => __('Learn about 404 page', 'pixfort-core'),
        'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_create_404_page'),
        'linkIcon'            => 'bookmark'
    ]
);
// What is 404 error?
$pixfortBuilder->addOption(
    'pix-enable-custom-404',
    [
        'type' => 'checkbox',
        'label' => __('Enable Custom 404 Page', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'page404',
        'tooltipText'     => __('A 404 page will show when the requested webpage does not exist. <br/><br/> For detailed information about customizing the back to top button check this article from our knowledge base: ', 'pixfort-core') . '<br/><a target="_blank" href="'.\PixfortCore::instance()->adminCore->getParam('docs_create_404_page').'" target="_blank" class="text-primary font-semibold">'.\PixfortCore::instance()->adminCore->getParam('docs_create_404_page').'</a>',
        'hideBorderBottom'   => true
    ]
);
$pixfortBuilder->addOption(
    'pix-custom-404-page',
    [
        'type' => 'select',
        'label' => __('Custom 404 Page', 'pixfort-core'),
        'tab'             => 'page404',
        'options' => $pages,
        'dependency' => [
            'field' => 'pix-enable-custom-404',
            'val' => [true, 'true', '1']
        ],
        'showBorderTop'   => true,
        'hideBorderBottom'   => true
    ]
);
