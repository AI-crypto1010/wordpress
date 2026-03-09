<?php

$pixfortBuilder->addOption(
	'pix-typography-external-fonts',
	[
		'type'             => 'heading',
		'label'         => __('External Fonts', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'icon'            => 'textRotate',
		'linkText'            => __('How external fonts works?', 'pixfort-core'),
        'linkHref'            => \PixfortCore::instance()->adminCore->getParam('docs_external_fonts'),
        'linkIcon'            => 'bookmark'
	]
);
$pixfortBuilder->addOption(
	'opt-external-font-1-url',
	[
		'type' => 'text',
		'label' => __('External Font 1 Link', 'pixfort-core'),
		'description' => __('Add the link of the first external font.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
		'hideBorderBottom'      => true,
		'halfPaddingBottom'      => true,
		'placeholder'	=> 'External Font Link'
	]
);
$pixfortBuilder->addOption(
	'opt-external-font-1-name',
	[
		'type' => 'text',
		'label' => __('External Font 1 Name', 'pixfort-core'),
		'description' => __('Add the name of the first external font.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
		'placeholder'	=> 'Example: Poppins',
		'halfPaddingTop'      => true,
	]
);
$pixfortBuilder->addOption(
	'opt-external-font-2-url',
	[
		'type' => 'text',
		'label' => __('External Font 2 Link', 'pixfort-core'),
		'description' => __('Add the link of the second external font.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
		'hideBorderBottom'      => true,
		'halfPaddingBottom'      => true,
		'placeholder'	=> 'External Font Link'
	]
);
$pixfortBuilder->addOption(
	'opt-external-font-2-name',
	[
		'type' => 'text',
		'label' => __('External Font 2 Name', 'pixfort-core'),
		'description' => __('Add the name of the second external font.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
		'hideBorderBottom'      => true,
		'halfPaddingTop'      => true,
		'placeholder'	=> 'Example: Inter'
	]
);
$pixfortBuilder->addOption(
    'pix-alert-typography-external-fonts',
    [
        'type'             => 'alert',
        'tab'             => 'typographyAdvanced',
        // 'label'             => 'Use',
        'description'     => __('For information about adding external fonts please check this article from our knowledge base:', 'pixfort-core'),
        'hidePaddingTop' => true,
        'hidePaddingBottom' => true,
        'style' => 'simple',
        'icon'  =>  'info',
        'linkOneText'  =>  __('Learn about external fonts', 'pixfort-core'),
        'linkOneHref'  =>  \PixfortCore::instance()->adminCore->getParam('docs_external_fonts'),
        'linkOneIcon'  =>  'bookmark'
    ]
);
/*
*   Font Sizes
*/
$pixfortBuilder->addOption(
	'pix-typography-font-sizes',
	[
		'type'             => 'heading',
		'label'         => __('Theme Font Sizes', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'icon'            => 'textHeight'
	]
);

$pixfortBuilder->addOption(
	'opt-font-size-base',
	[
		'type' => 'text',
		'label' => __('Base Font Size', 'pixfort-core'),
		'description' => __('By default, 1rem assumes the browser\'s default, which is typically 16px.<br />This option will affect all theme font sizes, if you want to change a single element font size do so from element settings in the page builder.<br />', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '1rem',
		'placeholder'	=> 'Example: 1rem',
		'note'	   => 'Note: make sure that this a valid font size value (with the rem unit).',
		// 'note'	   => '<strong>Note: make sure that this a valid font size value (with the rem unit).</strong>'
	]

);
$pixfortBuilder->addOption(
	'opt-font-size-h1',
	[
		'type' => 'text',
		'label'    => __('H1 Font Size', 'pixfort-core'),
		'description'     => __('By default, the H1 font size is 3.75 times of the <strong>base font size of the theme</strong> set in the field above.', 'pixfort-core'),
		'tooltipText' => __('Leave empty to use theme default.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
		'hideBorderBottom'      => true,
		'responsive'      => true,
		'placeholder'	=> 'Example: 3.75rem',
		'note'	   => 'Note: make sure that this a valid font size value (with the rem unit).',
	]
);
$pixfortBuilder->addOption(
	'opt-line-height-h1',
	[
		'type' => 'text',
		'label'    => __('H1 Line Height', 'pixfort-core'),
		'tooltipText' => __('Leave empty to use theme default.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
		'responsive'      => true,
		'description'     => __('By default, the H1 line height is 1.28', 'pixfort-core'),
		'placeholder'	=> 'Example: 1.2',
	]
);
$pixfortBuilder->addOption(
	'opt-font-size-h2',
	[
		'type' => 'text',
		'label'    => __('H2 Font Size', 'pixfort-core'),
		'description'     => __('By default, the H2 font size is 3 times of the <strong>base font size of the theme</strong> set in the field above.', 'pixfort-core'),
		'tooltipText' => __('Leave empty to use theme default.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
		'hideBorderBottom'      => true,
		'responsive'      => true,
		'note'	   => 'Note: make sure that this a valid font size value (with the rem unit).',
		'placeholder'	=> 'Example: 3rem',
	]
);
$pixfortBuilder->addOption(
	'opt-line-height-h2',
	[
		'type' => 'text',
		'label'    => __('H2 Line Height', 'pixfort-core'),
		'tooltipText' => __('Leave empty to use theme default.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
		'responsive'      => true,
		'description'     => __('By default, the H2 line height is 1.28', 'pixfort-core'),
		'placeholder'	=> 'Example: 1.2',
	]
);
$pixfortBuilder->addOption(
	'opt-font-size-h3',
	[
		'type' => 'text',
		'label'    => __('H3 Font Size', 'pixfort-core'),
		'description'     => __('By default, the H3 font size is 2.25 times of the <strong>base font size of the theme</strong> set in the field above.', 'pixfort-core'),
		'tooltipText' => __('Leave empty to use theme default.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
		'hideBorderBottom'      => true,
		'responsive'      => true,
		'note'	   => 'Note: make sure that this a valid font size value (with the rem unit).',
		'placeholder'	=> 'Example: 2.25rem',
	]
);
$pixfortBuilder->addOption(
	'opt-line-height-h3',
	[
		'type' => 'text',
		'label'    => __('H3 Line Height', 'pixfort-core'),
		'tooltipText' => __('Leave empty to use theme default.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
		'responsive'      => true,
		'description'     => __('By default, the H3 line height is 1.28', 'pixfort-core'),
		'placeholder'	=> 'Example: 1.2',
	]
);
$pixfortBuilder->addOption(
	'opt-font-size-h4',
	[
		'type' => 'text',
		'label'    => __('H4 Font Size', 'pixfort-core'),
		'description'     => __('By default, the H4 font size is 1.875 times of the <strong>base font size of the theme</strong> set in the field above.', 'pixfort-core'),
		'tooltipText' => __('Leave empty to use theme default.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
		'hideBorderBottom'      => true,
		'responsive'      => true,
		'note'	   => 'Note: make sure that this a valid font size value (with the rem unit).',
		'placeholder'	=> 'Example: 1.875rem',
	]
);
$pixfortBuilder->addOption(
	'opt-line-height-h4',
	[
		'type' => 'text',
		'label'    => __('H4 Line Height', 'pixfort-core'),
		'tooltipText' => __('Leave empty to use theme default.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
		'responsive'      => true,
		'description'     => __('By default, the H4 line height is 1.28', 'pixfort-core'),
		'placeholder'	=> 'Example: 1.2',
	]
);
$pixfortBuilder->addOption(
	'opt-font-size-h5',
	[
		'type' => 'text',
		'label'    => __('H5 Font Size', 'pixfort-core'),
		'description'     => __('By default, the H5 font size is 1.5 times of the <strong>base font size of the theme</strong> set in the field above.', 'pixfort-core'),
		'tooltipText' => __('Leave empty to use theme default.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
		'hideBorderBottom'      => true,
		'responsive'      => true,
		'note'	   => 'Note: make sure that this a valid font size value (with the rem unit).',
		'placeholder'	=> 'Example: 1.5rem',
	]
);
$pixfortBuilder->addOption(
	'opt-line-height-h5',
	[
		'type' => 'text',
		'label'    => __('H5 Line Height', 'pixfort-core'),
		'description'     => __('By default, the H5 line height is 1.28', 'pixfort-core'),
		'placeholder'	=> 'Example: 1.2',
		'responsive'      => true,
		'tooltipText' => __('Leave empty to use theme default.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
	]
);
$pixfortBuilder->addOption(
	'opt-font-size-h6',
	[
		'type' => 'text',
		'label'    => __('H6 Font Size', 'pixfort-core'),
		'description'     => __('By default, the H1 font size is 1.125 times of the <strong>base font size of the theme</strong> set in the field above.', 'pixfort-core'),
		'tooltipText' => __('Leave empty to use theme default.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
		'hideBorderBottom'      => true,
		'responsive'      => true,
		'note'	   => 'Note: make sure that this a valid font size value (with the rem unit).',
		'placeholder'	=> 'Example: 1.125rem',
	]
);
$pixfortBuilder->addOption(
	'opt-line-height-h6',
	[
		'type' => 'text',
		'label'    => __('H6 Line Height', 'pixfort-core'),
		'description'     => __('By default, the H6 line height is 1.28', 'pixfort-core'),
		'placeholder'	=> 'Example: 1.2',
		'tooltipText' => __('Leave empty to use theme default.', 'pixfort-core'),
		'tab'             => 'typographyAdvanced',
		'default'  => '',
		'responsive'      => true,
		'hideBorderBottom'      => true,
	]
);
