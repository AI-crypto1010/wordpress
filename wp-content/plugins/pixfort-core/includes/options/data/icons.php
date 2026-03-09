<?php


$pixfortBuilder->addOption(
	'pix-icons-heading',
	[
		'type'             => 'heading',
		'label'         => __('Icons Library', 'pixfort-core'),
		'tab'             => 'icons',
		'icon'            => 'shapes'
	]
);
// $pixfortBuilder->addOption(
//     'pix-disable-pixfort-icons',
//     [
//         'type' => 'checkbox',
//         'label' => __('Disable pixfort icons (not recommended)', 'pixfort-core'),
//         'description' => __('Disable pixfort icons and use the old font icons.<br>pixfort icons are loaded dynamically to improve performance (only the used icons will be loaded into the page instead of loading all font icons file in the old font icons).', 'pixfort-core'),
//         'options'         => array('1' => 'On', '0' => 'Off'),
//         'default'           => '0',
//         'tooltipText' => __('Make sure to backup your site before disabling pixfort icons and reverting to the old icons.', 'pixfort-core'),
//         'tab'             => 'icons',
// 		'hideBorderBottom'      => true,
//     ]
// );
$pixfortBuilder->addOption(
    'pixfort-icons-stroke-width',
    [
        'type' => 'range',
        'label' => __('Stroke Width', 'pixfort-core'),
        'description' => __('The option defines the stroke width for the Line icons type.', 'pixfort-core'),
        // 'responsive' => true,
        // 'showBorderTop'      => true,
        'hideBorderBottom'  => true,
        'tooltipText'   => __('Value based on the size of the icon viewBox (24px).', 'pixfort-core'),
        'tab'             => 'icons',
        'step'             => '0.1',
        'min'             => '0.5',
        'max'             => '2',
        'default'             => \PixfortCore::instance()->adminCore->getParam('icons_stroke_width', '1.5'),
        // 'dependency' => [
        //     'field' => 'pix-disable-pixfort-icons',
        //     'val' => [false, '0']
        // ],
    ]
);
// $pixfortBuilder->addOption(
//     'pix-icons-alert',
//     [
//         'type'             => 'alert',
//         'tab'             => 'icons',
//         'label'     => __('Important Note', 'pixfort-core'),
//         'description'     => __('Please be aware that using the old font icons may negatively impact your website\'s performance. These icons are deprecated and will be removed in future updates. However, in case there is an important necessity to disable the new pixfort icons on your site.</br>Please ensure not to switch between the old/new icons multiple times, doing so may break the icons on your site (note that since the new icons library is much larger, the icons used in new content on the site may disappear when disabling the new icons if there is no equivalent in the old icons). It\'s highly recommended to backup your site before switching the icons.', 'pixfort-core'),
//         'hidePaddingBottom' => false,
//         'hidePaddingTop' => true,
//         'style' => 'clean',
//         'icon'  =>  'info',
//         'linkOneText'  =>  __('Read the knowledge base article', 'pixfort-core'),
// 		'linkOneHref'  =>  '#',
// 		'linkOneIcon'  =>  'bookmark',
// 		'dependency' => [
//             'field' => 'pix-disable-pixfort-icons',
//             'val' => [true, 'true', '1']
//         ],
//     ]
// );

// $pixfortBuilder->addOption(
// 	'opt-ions-library',
// 	[
// 		'type' => 'select',
// 		'label' => __('Font Icons Library', 'pixfort-core'),
// 		'description'     => __('For performance optimization you can reduce the number of font icons in the website.', 'pixfort-core'),
// 		'tooltipText' => __('If you reduced the icons number some icons used in your website may dissapear if they are from a bigger library.', 'pixfort-core'),
// 		'default'             => 'main',
// 		'options' => [
// 			'main'   => __('Main Library (All icons ~1750)', 'pixfort-core'),
// 			'light'   => __('Light Library (~300 icons)', 'pixfort-core'),
// 			'basic'   => __('Only basic icons (~100 icons)', 'pixfort-core'),
// 		],
// 		'tab'             => 'icons',
// 		'hideBorderBottom'      => true,
// 		'showBorderTop'      => true,
// 		'dependency' => [
//             'field' => 'pix-disable-pixfort-icons',
//             'val' => [true, 'true', '1']
//         ],
// 	]
// );
