<?php
/**
 * Single Product tabs
 *
 * Author: PixFort
 *
 * pixfort version
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 9.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

$tabs_style= 'pix-pills-1';
if(!empty(pix_get_option('shop-tabs-style'))){
	$tabs_style = pix_get_option('shop-tabs-style');
}
$lines_class = 'd-flex';

if ( ! empty( $product_tabs ) ) : ?>
	<div class="clearfix"></div>
	<div class="woocommerce-tabs wc-tabs-wrapper d-inline-block pix-mt-50 w-100">

	    <ul class="nav nav-pills justify-content-center pix_tabs_btns <?php echo esc_html( $lines_class ); ?> nav-fill2 <?php echo esc_html( $tabs_style ); ?> pix-mb-50 mt-5" id="pills-tab" role="tablist">
			<li class="flex-fill"><div class="pix-py-20 pix-pr-20 my-0 line-height-0"><div class="pix-line-divider thin bg-dark-opacity-1 d-inline-block w-100"></div></div></li>
			<?php
			$i = 0;
			foreach ( $product_tabs as $key => $tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab nav-item" id="pills-title-<?php echo esc_attr( $key ); ?>">
					<a class="nav-link woo-tab-link px-4 pix-tabs-btn font-weight-bold2 <?php if($i == 0) echo "active"; ?>" role="tab" data-toggle="pill" aria-controls="pills-<?php echo esc_attr( $key ); ?>" aria-selected="false" href="#pills-<?php echo esc_attr( $key ); ?>"><strong><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></strong></a>
				</li>
			<?php
			$i++;
			endforeach;
			?>
			<li class="flex-fill"><div class="pix-py-20 pix-pl-20 my-0 line-height-0"><div class="pix-line-divider thin bg-dark-opacity-1 d-inline-block w-100"></div></div></li>
	    </ul>
		<div class="tab-content mb-5">
			<?php
			$i = 0;
			foreach ( $product_tabs as $key => $tab ) : ?>
				<div id="pills-<?php echo esc_attr( $key ); ?>" class="tab-pane w-100 fade <?php if($i == 0) echo "show active"; ?> " id="pills-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="pills-title-<?php echo esc_attr( $key ); ?>">
					<?php if ( isset( $tab['callback'] ) ) { call_user_func( $tab['callback'], $key, $tab ); } ?>
				</div>
			<?php
			$i++;
			endforeach; ?>
		</div>

	</div>
	<div class="clearfix"></div>

<?php endif; ?>
