<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package pixfort theme
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
if ( ! function_exists( 'pixfort_woocommerce_setup' ) ) {
	function pixfort_woocommerce_setup() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
}

add_action( 'after_setup_theme', 'pixfort_woocommerce_setup' );


add_filter ( 'woocommerce_product_thumbnails_columns', 'pix_product_thumbnails_columns', 20, 1 );
function pix_product_thumbnails_columns( $columns ) {
    return 5; // Default is 4
}

function pixfort_show_product_image(){
	get_template_part( 'inc/wc/product' );
}

function pix_woocommerce_tag_cloud_widget() {
    $args = array(
        'number' => 15,
        'taxonomy' => 'product_tag'
    );
    return $args;
}
add_filter( 'woocommerce_product_tag_cloud_widget_args', 'pix_woocommerce_tag_cloud_widget' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function pixfort_woocommerce_scripts() {
	wp_enqueue_style( 'pixfort-woocommerce-style', get_template_directory_uri() . '/css/woocommerce.min.css', false, PIXFORT_THEME_VERSION, 'all' );
	// $font_path   = WC()->plugin_url() . '/assets/fonts/';
	$font_path   = get_template_directory_uri() . '/woocommerce/pixfort/fonts/';
	$inline_font = '@font-face {
			font-family: "pixstar";
			src: url("' . $font_path . 'pixstar.eot");
			src: url("' . $font_path . 'pixstar.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'pixstar.woff") format("woff"),
				url("' . $font_path . 'pixstar.ttf") format("truetype"),
				url("' . $font_path . 'pixstar.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	if(class_exists('PixfortCore')&&method_exists(\PixfortCore::instance()->elementsManager, 'pixAddInlineStyle')){
		\PixfortCore::instance()->elementsManager::pixAddInlineStyle( $inline_font );
	}
}
add_action( 'wp_footer', 'pixfort_woocommerce_scripts' );


/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function pixfort_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';
	if(is_shop() || is_product_category() || is_product_tag() || is_category() || is_archive() ){
		if(!empty(pix_get_option('shop-with-intro'))){
			$classes[] = 'woocommerce-shop-with-intro';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'pixfort_woocommerce_active_body_class' );

/**
 * Enable the mini cart in checkout and cart
 *
 */
add_filter( 'woocommerce_widget_cart_is_hidden', 'custom_disable_mini_cart', 40, 0 );
function custom_disable_mini_cart() {
    return false;
}

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function pixfort_woocommerce_products_per_page() {

	$count = 12;
	if( !empty(pix_get_option('shop-products-count')) ){
		if(pix_get_option('shop-products-count')){
			$count = (int)pix_get_option('shop-products-count');
		}
	}
	return $count;
}
add_filter( 'loop_shop_per_page', 'pixfort_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function pixfort_woocommerce_thumbnail_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'pixfort_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function pixfort_woocommerce_loop_columns() {
	$count = 3;
	if(!empty(pix_get_option('shop-col-count'))){
		$count = pix_get_option('shop-col-count');
	}
	if(!empty($_GET['cols'])){
		if($_GET['cols']<6&&$_GET['cols']>1){
			$count = $_GET['cols'];
		}
	}
	return $count;
}
add_filter( 'loop_shop_columns', 'pixfort_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function pixfort_woocommerce_related_products_args( $args ) {

	$related_cols = 4;
	$related_posts = 4;
	if(!empty(pix_get_option('shop-single-sidebar'))){
		$related_cols = 3;
		$related_posts = 3;
	}
	if(!empty($_GET['show_sidebar'])){
		$related_cols = 3;
		$related_posts = 3;
	}

	$defaults = array(
		'posts_per_page' => $related_posts,
		'columns'        => $related_cols,
	);

	$args = wp_parse_args( $defaults, $args );


	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'pixfort_woocommerce_related_products_args' );

if ( ! function_exists( 'pixfort_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function pixfort_woocommerce_product_columns_wrapper() {
		$columns = pixfort_woocommerce_loop_columns();
		?>
		<div class="columns-<?php echo absint( $columns ); ?>">
		<?php
	}
}

if ( ! function_exists( 'pixfort_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function pixfort_woocommerce_product_columns_wrapper_close() {
		?>
		</div>
		<?php
	}
}

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

if ( ! function_exists( 'pixfort_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function pixfort_woocommerce_wrapper_before() {

		if(is_product()){
			$show_sidebar = false;
			if(!empty(pix_get_option('shop-single-sidebar'))){
				$show_sidebar = true;
			}
			if(!empty($_GET['show_sidebar'])){
				$show_sidebar = true;
			}
			if($show_sidebar){
				?>
				<div class="col-12 col-md-8">
						<main id="main" class="site-main content-area" role="main">
				<?php
			}else{
				remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
				remove_action('woocommerce_sidebar', 'woocommerce_ ', 10);
				?>
				<div class="col-12">
						<main id="main" class="site-main content-area" role="main">
				<?php
			}
		}else{
			$shop_layout = 'right-sidebar';
			if(!empty(pix_get_option('shop-layout'))){
				$shop_layout = pix_get_option('shop-layout');
			}
			if(!empty($_GET['shop_layout'])){
				switch ($_GET['shop_layout']) {
					case 'no-sidebar':
						$shop_layout = 'no-sidebar';
						break;
					case 'left-sidebar':
						$shop_layout = 'left-sidebar';
						break;
					case 'right-sidebar':
						$shop_layout = 'right-sidebar';
						break;
				}
			}

			if($shop_layout=='no-sidebar'){
				remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
				?>
				<div class="col-12">
						<main id="main" class="site-main content-area" role="main">
				<?php
			}else{
				$order = '';
				if($shop_layout=='left-sidebar'){
					$order = 'order-sm-2';
				}
				?>
				<div class="col-12 col-md-8 <?php echo esc_attr( $order ); ?>">
						<main id="main" class="site-main content-area" role="main">
				<?php

			}

		}

	}
}
add_action( 'woocommerce_before_main_content', 'pixfort_woocommerce_wrapper_before' );


if ( is_product() ) {
	remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
	if(!empty(pix_get_option('shop-single-sidebar'))){
	}else{
		remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
	}
}


if ( ! function_exists( 'pixfort_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function pixfort_woocommerce_wrapper_after() {
				?>
				</main><!-- #main -->
		</div>
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'pixfort_woocommerce_wrapper_after' );

if ( ! function_exists( 'pixfort_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function pixfort_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		pixfort_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'pixfort_woocommerce_cart_link_fragment' );



function pix_product_preview_btn_action($post, $nonce, $style='default') {
	$show = true;
	if( !empty(pix_get_option('pix-disable-shop-preview')) ){
		if(pix_get_option('pix-disable-shop-preview')){
			$show = false;
		}
	}
	if($show){
		if($style=='full'){
			?>
			<div class="pix-pl-10 align-self-stretch d-flex">
				<span data-preview-id="<?php echo esc_attr( $post->ID ); ?>" class="text-18 d-inline-block pix-preview-loop-icon pix-product-preview align-self-center text-body-default2 text-light-opacity-7 pb-2"><?php echo pixGetThemeFileContents('/inc/assets/preview.svg') ?></span>
			</div>
			<?php
		}else{
			?>
		 <div class="pix-pl-10 flex-fill text-right align-self-stretch2 d-flex2">
				<span data-preview-id="<?php echo esc_attr( $post->ID ); ?>" class="text-18 d-inline-block pix-preview-loop-icon pix-product-preview align-self-center text-body-default"><?php echo pixGetThemeFileContents('/inc/assets/preview.svg') ?></span>
			</div>
		 <?php
		}
	}
}
add_action( 'pix_product_preview_btn', 'pix_product_preview_btn_action', 10, 3 );


function pix_product_add_to_cart_sm_btn_action($post, $product, $nonce, $icon_class = 'text-body-default') {

	$show = true;
	if( !empty(pix_get_option('pix-disable-add-cart-icon')) ){
		if(pix_get_option('pix-disable-add-cart-icon')){
			$show = false;
		}
	}


	if($show){
	 ?>
	 <div class="pix-pl-10 align-self-stretch d-flex">
		 <?php
		 $thumbnail_id = apply_filters( 'wpml_object_id', get_post_thumbnail_id( $post->ID ), 'attachment', true );
		 $image = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail', true);
		 if($image){$image=$image[0];}

					

		 if ( $product->is_type( 'external' ) ) {
			 $product_url = $product->add_to_cart_url();
			 $button_text = $product->single_add_to_cart_text();
			 ?>
			 <a data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_attr($button_text); ?>" href="<?php echo esc_url($product_url); ?>" class="<?php echo esc_attr( $icon_class ); ?>" data-product_id="<?php echo esc_attr( $post->ID ); ?>" data-name="<?php echo esc_attr( $product->get_name() );?>" data-img="<?php echo esc_attr( $image ); ?>">
			 <?php 
			if(pixCheckIconsAvailable()){
				echo '<span class="btn-icon text-18 '. esc_attr( $icon_class ).' align-self-center">'. \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-bag-1', 24, 'align-self-center').'</span>';
			} else {
				echo '<span class="btn-icon text-18 '. esc_attr( $icon_class ).' pixicon-bag-2 align-self-center"></span>';
			} 
		 	?>
			</a>
			 <?php
		 }elseif($product->is_type( 'variable' )){
			 ?>
			 <a data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_attr__('View product', 'conseil'); ?>" href="<?php echo get_the_permalink(); ?>" class="<?php echo esc_attr( $icon_class ); ?>" data-product_id="<?php echo esc_attr( $post->ID ); ?>" data-name="<?php echo esc_attr( $product->get_name() );?>" data-img="<?php echo esc_attr( $image ); ?>">
			 <?php 
			if(pixCheckIconsAvailable()){
				echo '<span class="btn-icon text-18 '. esc_attr( $icon_class ).' align-self-center">'. \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-bag-1', 24, 'align-self-center').'</span>';
			} else {
				echo '<span class="btn-icon text-18 '. esc_attr( $icon_class ).' pixicon-bag-2 align-self-center"></span>';
			} 
		 	?>
			</a>
			 <?php
		 }elseif( ($product->get_stock_status()=='outofstock') || ($product->get_stock_quantity() && $product->get_stock_quantity()==0) ){
			 ?><span data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_attr__('Out of stock', 'conseil'); ?>" class="<?php echo esc_attr( $icon_class ); ?>"><span class="btn-icon text-18 <?php echo esc_attr( $icon_class ); ?> pixicon-cart-remove align-self-center"></span></span><?php
		 }else{
			 ?><a href="#" class="pix-add-to-cart <?php echo esc_attr( $icon_class ); ?>" data-product_id="<?php echo esc_attr( $post->ID ); ?>" data-name="<?php echo esc_attr( $product->get_name() );?>" data-img="<?php echo esc_attr( $image ); ?>">
			 <?php 
			if(pixCheckIconsAvailable()){
				echo '<span class="btn-icon text-18 '. esc_attr( $icon_class ).' align-self-center">'. \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-bag-1', 24, 'align-self-center').'</span>';
			} else {
				echo '<span class="btn-icon text-18 '. esc_attr( $icon_class ).' pixicon-bag-2 align-self-center"></span>';
			} 
		 	?>
			 </a><?php
		 }
		 ?>
	 </div>
	 <?php
 	}
}
add_action( 'pix_product_add_to_cart_sm_btn', 'pix_product_add_to_cart_sm_btn_action', 10, 4 );


if ( ! function_exists( 'pixfort_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function pixfort_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'conseil' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'conseil' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}


if ( ! function_exists( 'pixfort_woocommerce_cart_count' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function pixfort_woocommerce_cart_count() {
		return WC()->cart->get_cart_contents_count();
	}
}




// pixfort Filters
/**
 * Change the breadcrumb separator
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'pixfort_change_breadcrumb_delimiter' );
function pixfort_change_breadcrumb_delimiter( $defaults ) {
	// $defaults['delimiter'] = '<span><i class="pixicon-angle-right font-weight-bold mx-2" style="position:relative;top:2px;"></i></span>';
	if(pixCheckIconsAvailable()){
		$defaults['delimiter'] .= '<span>'. \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-arrow-right-2', 24, 'position-relative2 mr-1') . '</span>';
	} else {
		$defaults['delimiter'] = '<span><i class="pixicon-angle-right font-weight-bold mx-2" style="position:relative;top:2px;"></i></span>';
	}
	$defaults['wrap_before'] = '<nav aria-label="breadcrumb"><ol class="woocommerce-breadcrumb breadcrumb text-center justify-content-center">';
	$defaults['wrap_after'] = '</ol></nav>';
	// $defaults['before'] = '<li class="breadcrumb-item">';
	// $defaults['after'] = '</li>';
	$defaults['home'] = get_bloginfo( 'name' );
	return $defaults;
}
add_filter( 'woocommerce_template_single_add_to_cart', 'pixfort_woocommerce_template_single_add_to_cart' );
function pixfort_woocommerce_template_single_add_to_cart( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'
	return $defaults;
}


/**
 * Single Product
 */
// define the woocommerce_short_description callback
function filter_woocommerce_short_description( $post_post_excerpt ) {
    // make filter magic happen here...
    return '<div class="text-gray-6 pix-mt-20">'.$post_post_excerpt.'</div>';
};
add_filter( 'woocommerce_short_description', 'filter_woocommerce_short_description', 10, 1 );







/**
 * Sidebar
 */

function action_pixfort_page_intro(){
	if(!empty(pix_get_option('shop-with-intro'))&&pix_get_option('shop-with-intro')){
		get_template_part( 'template-parts/intro' );
	}
}
add_action( 'woocommerce_before_main_content', 'action_pixfort_page_intro', 3 );


remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
function pix_action_pixfort_page_start( ) {
	// global $product;
	if(is_product()){

		$product_layout = pix_get_option('shop-single-layout');
		if(get_post_meta( get_the_id(), 'pix_single_product_layout', true )&&get_post_meta( get_the_id(), 'pix_single_product_layout', true )!=''){
			if(wc_get_product()&&!empty(wc_get_product()->get_id())){
				$product_layout = get_post_meta( wc_get_product()->get_id(), 'pix_single_product_layout', true );
			}
		}
		if($product_layout=='layout-2'||$product_layout=='layout-3'){
			remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			add_action( 'woocommerce_product_thumbnails', 'pixfort_show_product_image', 20 );
			add_action( 'woocommerce_before_single_product_summary', 'pixfort_show_product_image', 10 );
		}else{
			add_theme_support( 'wc-product-gallery-slider' );
		}
	}

	$classes = '';
	$styles = '';
	if(pix_should_add_top_padding(null, 'shop-hide-top-padding')){
			$classes .= 'pt-5';
	}
	if(!empty(pix_get_option('shop-bg-color'))){
	   if(pix_get_option('shop-bg-color')=='custom'){
		   $styles = 'background:'.pix_get_option('custom-shop-bg-color').';';
	   }else{
		   $classes .= ' bg-'.pix_get_option('shop-bg-color'). ' ';
	   }
	}
	?>
	<div id="content" class="site-content <?php echo esc_attr( $classes ); ?>" style="<?php echo esc_attr( $styles ); ?>" >
		<?php if(empty(pix_get_option('shop-with-intro'))||!pix_get_option('shop-with-intro')){
			?><div class="pix-main-intro-placeholder"></div><?php
		} ?>
		<div class="container">
			<div class="row">
	<?php
}
add_action( 'woocommerce_before_main_content', 'pix_action_pixfort_page_start', 4 );

function action_pixfort_page_end( ) {
	?>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'woocommerce_sidebar', 'action_pixfort_page_end', 20 );


add_filter( 'woocommerce_add_to_cart_fragments', 'pix_refresh_mini_cart_count');
function pix_refresh_mini_cart_count($fragments){
    ob_start();
    ?>
	<span class="cart-count woo-cart-count badge-pill bg-primary">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </span>
    <?php
        $fragments['.woo-cart-count'] = ob_get_clean();
    return $fragments;
}

function action_pixfort_product_top_area( ) {
	?>
	<div class="d-flex align-items-center justify-content-between">
		<?php
		woocommerce_template_single_price();
		woocommerce_template_single_rating();
		?>
	</div>
	<div class="pix-py-20 pix-xd-divider-20 my-0 line-height-0"><div class="pix-line-divider thin bg-dark-opacity-1 d-inline-block w-100"></div></div>
	<?php
}
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);

add_action( 'woocommerce_single_product_summary', 'action_pixfort_product_top_area', 3 );


remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
add_action( 'woocommerce_single_product_summary', 'action_pixfort_product_cats', 6 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_loop_sale_flash', 4 );



function action_pixfort_product_cats($bg = 'dark-opacity-05', $text = 'gray-5' ) {
	$post = get_post();
	if(!empty($post)){
		$term_list = wp_get_post_terms($post->ID,'product_cat');
		if($bg=='') $bg = 'dark-opacity-05';
		if( class_exists( 'PixfortCore' ) ){
			foreach ($term_list as $key => $value) {
				echo \PixfortCore::instance()->elementsManager->renderElement('Badge', array(
					'text'					=> $value->name,
					'bg_color'				=> $bg,
					'text_color'			=> $text,
					'text_size'				=> 'custom',
					'bold'  				=> 'font-weight-bold',
					'text_custom_size'		=> '12px',
					'extra_classes'		=> 'wc-single-product-cats',
					'link'					=> get_tag_link($value->term_id)
				));
			}
		}
	}
}
