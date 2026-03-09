<?php
/**
 * Related Products
 *
 * pixfort version
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     10.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="related products pix-mb-80">

		<div class="d-flex justify-content-center align-items-center pix-my-30">
			<div class="pix-py-20 pix-pr-10 my-0 flex-fill line-height-0 d-flex align-items-center"><div class="pix-line-divider thin bg-dark-opacity-1 d-inline-block w-100"></div></div>
				<h5 class="font-weight-bold text-heading-default"><?php esc_html_e( 'Related Products', 'conseil' ) ?></h5>
			<div class="pix-py-20 pix-pl-10 my-0 flex-fill line-height-0 d-flex align-items-center"><div class="pix-line-divider thin bg-dark-opacity-1 d-inline-block w-100"></div></div>
		</div>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $related_products as $related_product ) : ?>

				<?php
				 	$post_object = get_post( $related_product->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section>

<?php endif;

wp_reset_postdata();
