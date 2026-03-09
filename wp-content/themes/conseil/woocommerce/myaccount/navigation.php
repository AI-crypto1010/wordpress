<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="woocommerce-MyAccount-navigation bg-white rounded-lg pix-p-20 pix-mb-20 sticky-top pix-sticky-top-adjust" aria-label="<?php esc_attr_e( 'Account pages', 'conseil' ); ?>">
	<ul class="m-0 p-0">
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="text-heading-default <?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a class="btn btn-white btn-block text-heading-default font-weight-bold" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
