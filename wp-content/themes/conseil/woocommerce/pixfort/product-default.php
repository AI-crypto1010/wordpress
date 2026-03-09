<?php
/**
* The template for displaying product content within loops
*
* This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
*
* HOWEVER, on occasion WooCommerce will need to update template files and you
* (the theme developer) will need to copy the new files to your theme to
* maintain compatibility. We try to do this as little as possible, but it does
* happen. When this occurs the version of the template file will be bumped and
* the readme will list any important changes.
*
* @see     https://docs.woocommerce.com/document/template-structure/
* @package WooCommerce/Templates
* @version 3.4.0
*/

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
$nonce = wp_create_nonce("product_nonce");

$extra_classes = 'shadow-sm fly shadow-hover-sm rounded-lg';
if(!empty($GLOBALS['item_extra_classes'])){
    $extra_classes = $GLOBALS['item_extra_classes'];
}

?>
<li <?php wc_product_class('', $product); ?>>
	<div class="pix-product-item bg-white <?php echo esc_attr( $extra_classes ); ?> pix-p-20">

		<?php
		// var_dump( $product->is_purchasable() );


		/**
		* Hook: woocommerce_before_shop_loop_item.
		*
		* @hooked woocommerce_template_loop_product_link_open - 10
		*/
		do_action( 'woocommerce_before_shop_loop_item' );
		?>

		<div class="pix-pb-20">

			<div class="d-flex align-items-center">
				<div class="flex-fill">
					<a href="<?php echo get_the_permalink() ?>"  class="secondary-font font-weight-bold text-heading-default p-0 align-self-center"><?php echo do_shortcode( get_the_title() ); ?></a>
				</div>
				<?php do_action( 'pix_product_preview_btn', $post, $nonce, 'default' ); ?>
			</div>
			<div class="pix-item-badges">
			<?php
			action_pixfort_product_cats();
			woocommerce_show_product_loop_sale_flash();
			?>
			</div>
		</div>

		<?php
		$thumbnail_id = apply_filters( 'wpml_object_id', get_post_thumbnail_id( $post->ID ), 'attachment', true );
		$image = wp_get_attachment_image_src( $thumbnail_id, 'pix-woocommerce-md' );
		/**
		* Hook: woocommerce_before_shop_loop_item_title.
		*
		* @hooked woocommerce_show_product_loop_sale_flash - 10
		* @hooked woocommerce_template_loop_product_thumbnail - 10
		*/
		remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
		?>
		<a href="<?php echo get_the_permalink() ?>">
		<div class="position-relative rounded-lg overflow-hidden pix-product-img-hover d-block w-100">
		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
		</div>
		</a>

		<?php
		/**
		* Hook: woocommerce_after_shop_loop_item_title.
		*
		* @hooked woocommerce_template_loop_rating - 5
		* @hooked woocommerce_template_loop_price - 10
		*/
		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
		do_action( 'woocommerce_after_shop_loop_item_title' );
		// do_action( 'woocommerce_template_loop_rating' );
		/**
		* Hook: woocommerce_after_shop_loop_item.
		*
		* @hooked woocommerce_template_loop_product_link_close - 5
		* @hooked woocommerce_template_loop_add_to_cart - 10
		*/
		$disableDefaultAdd = true;
		if(pix_get_option('shop-default-add-cart')){
			$disableDefaultAdd = false;
		}
		if($disableDefaultAdd){
			remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
		}


		do_action( 'woocommerce_after_shop_loop_item' );
		$price_area = '';
		if(wc_review_ratings_enabled()&&$product->get_rating_count()>0){
			$price_area = 'pix-product-price-rating';
		}
		?>
		<div class="d-flex align-items-center pix-pt-20">
			<div class="flex-fill <?php echo esc_attr( $price_area );?>">
				<div class="pix-product-price">
					<?php woocommerce_template_loop_price(); ?>
				</div>
				<div class="pix-product-rating">
					<?php woocommerce_template_loop_rating(); ?>
				</div>
			</div>
			<?php
			if( class_exists( 'YITH_WCWL' ) ){
				?>
				<div class="pix-pl-10 align-self-stretch d-flex">
				<?php
				$wishNonce = wp_create_nonce("add_to_wishlist");
				$like_link = admin_url('admin-ajax.php?nonce='.$wishNonce);
				$status = '';
				$like_classes = 'text-body-default';
				
				global $yith_wcwl;
				if(empty($yith_wcwl->details['user_id'])){
					$yith_wcwl->details['user_id'] = '';
				}
				if($yith_wcwl->is_product_in_wishlist($post->ID)){
					$status = 'remove-item';
					$like_classes = 'text-red';
				}
				?>
				<a href="#" data-wishlist-link="<?php echo esc_url($like_link); ?>" data-id="<?php echo esc_attr( $post->ID); ?>" class="pix-add-to-wishlist <?php echo esc_attr( $status); ?>">
				<?php
					if(pixCheckIconsAvailable()){
						echo '<span class="btn-icon '. esc_attr( $like_classes).' text-18 align-self-center">' . \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-heart-1', 24, 'align-self-center') . '</span>';
					} else {
						?>
						<span class="btn-icon <?php echo esc_attr( $like_classes); ?> text-18 pixicon-heart align-self-center"></span>
						<?php
					} 
				?>
				</a>
				</div>
				<?php
			}
			do_action( 'pix_product_add_to_cart_sm_btn', $post, $product, $nonce );
			?>

		</div>
	</div>
</li>
