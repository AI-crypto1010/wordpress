<?php

$pixfortBuilder->addOption(
    'shop-default-add-cart',
    [
        'type' => 'checkbox',
        'label' => __('Show Default Add to Cart Button', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'shopAdvanced'
    ]
);
$pixfortBuilder->addOption(
    'pix-disable-shop-social',
    [
        'type' => 'checkbox',
        'label' => __('Disable Shop Social Share Buttons', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'shopAdvanced'
    ]
);
$pixfortBuilder->addOption(
    'pix-disable-shop-preview',
    [
        'type' => 'checkbox',
        'label' => __('Disable Shop Preview Popup', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'shopAdvanced'
    ]
);
$pixfortBuilder->addOption(
    'pix-disable-add-cart-icon',
    [
        'type' => 'checkbox',
        'label' => __('Disable Add to Cart Icon Button', 'pixfort-core'),
        'options'         => array('1' => 'On', '0' => 'Off'),
        'default'           => '0',
        'tab'             => 'shopAdvanced',
        'hideBorderBottom'      => true,
    ]
);