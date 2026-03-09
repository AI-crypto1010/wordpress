<?php
/**
 * Product loop sale flash
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
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<?php if ( $product->is_on_sale() ) : ?>
<span rel="tag" class="badge pix-sale-badge bg-red-light text-red font-weight-bold pix-mr-5 pix-p-5">
<?php
	if(get_post_meta( get_the_ID(), 'pix_sale_text', true ) && get_post_meta( get_the_ID(), 'pix_sale_text', true )!= ''){
		echo esc_html( get_post_meta( get_the_ID(), 'pix_sale_text', true ) );
	}else{
		echo esc_html__( 'Sale!', 'conseil' );
	}
?>
</span>
<?php endif;

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
