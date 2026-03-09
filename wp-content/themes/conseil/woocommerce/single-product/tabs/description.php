<?php
/**
 * Description tab
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
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', esc_attr__( 'Description', 'conseil' ) ) );

?>

<?php if ( $heading ) : ?>
  <h2 class="mb-2 h4"><strong><?php echo esc_html( $heading ); ?></strong></h2>
<?php endif; ?>

<?php the_content(); ?>
