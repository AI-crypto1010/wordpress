<?php
/**
 * Single Product Rating
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
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

if ( $rating_count > 0 ) : ?>
	<div class="woocommerce-product-rating d-inline-block mb-0 align-self-center">
		<div class="w-100 text-center d-flex justify-content-end"><?php echo wc_get_rating_html( $average, $rating_count ); ?></div>
		<div class="clearfix"></div>
		<?php if ( comments_open() ) : ?>
			<div class="d-block">
			<a href="#reviews" class="woocommerce-review-link text-sm text-body-default font-weight-bold" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $review_count, 'conseil' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>)</a>
			</div>
		<?php endif ?>
	</div>

<?php endif; ?>
