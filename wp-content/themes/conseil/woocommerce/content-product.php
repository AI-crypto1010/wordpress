<?php
/**
 * The template for displaying product content within loops
 *
 * pixfort version
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$item_style = pix_get_option('shop-item-style');

if(!empty($_GET["shop_style"])){
    switch ($_GET["shop_style"]) {
        case 'default':
            $item_style = 'default';
            break;
        case 'default-no-padding':
            $item_style = 'default-no-padding';
            break;
        case 'top-img':
            $item_style = 'top-img';
            break;
        case 'top-img-no-padding':
            $item_style = 'top-img-no-padding';
            break;
        case 'full-img':
            $item_style = 'full-img';
            break;
    }
}

if(!empty($GLOBALS['item_style'])){
    if($GLOBALS['item_style']!='theme'){
        $item_style = $GLOBALS['item_style'];
    }
}

if($item_style=='default-no-padding'){
    get_template_part( 'woocommerce/pixfort/product-default-no-padding' );
}elseif($item_style=='top-img'){
    get_template_part( 'woocommerce/pixfort/product-top-img' );
}elseif($item_style=='top-img-no-padding'){
    get_template_part( 'woocommerce/pixfort/product-top-img-no-padding' );
}elseif($item_style=='full-img'){
    get_template_part( 'woocommerce/pixfort/product-full-img' );
}else{
    get_template_part( 'woocommerce/pixfort/product-default' );
}
