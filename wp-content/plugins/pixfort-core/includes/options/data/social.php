<?php

$pixfortBuilder->addOption(
    'pix-heading-social',
    [
        'type'             => 'heading',
        'label'         => __('Social Icons', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'icon'            => 'social',
        'linkText'            => __('Learn more about social icons', 'pixfort-core'),
		'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_how_to_add_social_icons'),
		'linkIcon'            => 'bookmark'
    ]
);
$pixfortBuilder->addOption(
    'social-target-blank',
    [
        'type' => 'checkbox',
        'label' => __('Open Social Links in New Tab', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'socialIcons'
    ]
);
// $pixfortBuilder->addOption(
//     'social-icon-test',
//     [
//         'type' => 'icon',
//         'label' => __('pixfort Icon', 'pixfort-core'),
//         'default'           => '',
//         'tab'             => 'socialIcons'
//     ]
// );

$pixfortBuilder->addOption(
    'social-skype',
    [
        'type' => 'text',
        'label' => __('Skype', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'description' => __('Type your Skype username here', 'pixfort-core'),
        'tooltipText' => 'You can use <strong>callto:</strong> or <strong>skype:</strong> prefix',
    ]
);
$pixfortBuilder->addOption(
    'social-facebook',
    [
        'type' => 'text',
        'label' => __('Facebook', 'pixfort-core'),
        'description' => __('Type your Facebook link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-google',
    [
        'type' => 'text',
        'label' => __('Google', 'pixfort-core'),
        'description' => __('Type your Google link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-twitter',
    [
        'type' => 'text',
        'label' => __('X (Previously Twitter)', 'pixfort-core'),
        'description' => __('Type your X link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-vimeo',
    [
        'type' => 'text',
        'label' => __('Vimeo', 'pixfort-core'),
        'description' => __('Type your Vimeo link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-youtube',
    [
        'type' => 'text',
        'label' => __('YouTube', 'pixfort-core'),
        'description' => __('Type your YouTube link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-flickr',
    [
        'type' => 'text',
        'label' => __('Flickr', 'pixfort-core'),
        'description' => __('Type your Flickr link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-linkedin',
    [
        'type' => 'text',
        'label' => __('LinkedIn', 'pixfort-core'),
        'description' => __('Type your LinkedIn link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-pinterest',
    [
        'type' => 'text',
        'label' => __('Pinterest', 'pixfort-core'),
        'description' => __('Type your YouTube link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-dribbble',
    [
        'type' => 'text',
        'label' => __('Dribbble', 'pixfort-core'),
        'description' => __('Type your Dribbble link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-instagram',
    [
        'type' => 'text',
        'label' => __('Instagram', 'pixfort-core'),
        'description' => __('Type your Instagram link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-snapchat',
    [
        'type' => 'text',
        'label' => __('Snapchat', 'pixfort-core'),
        'description' => __('Type your Snapchat link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-telegram',
    [
        'type' => 'text',
        'label' => __('Telegram', 'pixfort-core'),
        'description' => __('Type your Telegram link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-googleplay',
    [
        'type' => 'text',
        'label' => __('Google play', 'pixfort-core'),
        'description' => __('Type your Google play link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-appstore',
    [
        'type' => 'text',
        'label' => __('App store', 'pixfort-core'),
        'description' => __('Type your App store link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-whatsapp',
    [
        'type' => 'text',
        'label' => __('WhatsApp', 'pixfort-core'),
        'description' => __('Type your whatsapp link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-flipboard',
    [
        'type' => 'text',
        'label' => __('Flipboard', 'pixfort-core'),
        'description' => __('Type your flipboard link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-vk',
    [
        'type' => 'text',
        'label' => __('VK', 'pixfort-core'),
        'description' => __('Type your VK link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-discord',
    [
        'type' => 'text',
        'label' => __('Discord', 'pixfort-core'),
        'description' => __('Type your Discord link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-tik-tok',
    [
        'type' => 'text',
        'label' => __('TikTok', 'pixfort-core'),
        'description' => __('Type your TikTok link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-twitch',
    [
        'type' => 'text',
        'label' => __('Twitch', 'pixfort-core'),
        'description' => __('Type your twitch link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-behance',
    [
        'type' => 'text',
        'label' => __('Behance', 'pixfort-core'),
        'description' => __('Type your behance link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-yelp',
    [
        'type' => 'text',
        'label' => __('Yelp', 'pixfort-core'),
        'description' => __('Type your yelp link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-soundcloud',
    [
        'type' => 'text',
        'label' => __('Soundcloud', 'pixfort-core'),
        'description' => __('Type your soundcloud link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'social-tripadvisor',
    [
        'type' => 'text',
        'label' => __('Tripadvisor', 'pixfort-core'),
        'description' => __('Type your tripadvisor link here', 'pixfort-core'),
        'tab'             => 'socialIcons',
        'tooltipText' => 'Icon won\'t show if you leave this field blank',
    ]
);
$pixfortBuilder->addOption(
    'pix-social-alert',
    [
        'type'             => 'alert',
        'tab'             => 'socialIcons',
        'label'     => __('Missing a Social Icon?', 'pixfort-core'),
        'description'     => __('Check the article below from our knwoledge base:', 'pixfort-core'),
        'hidePaddingBottom' => false,
        'style' => 'simple',
        'icon'  =>  'info',
        'linkOneText'  =>  __('Check article', 'pixfort-core'),
        'linkOneHref'  =>  \PixfortCore::instance()->adminCore->getParam('docs_how_to_add_social_icons').'#pix_section_missing_social_icon',
        'linkOneIcon'  =>  'bookmark'
    ]
);