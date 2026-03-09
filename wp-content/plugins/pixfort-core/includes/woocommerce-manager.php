<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * WooCommerce Manager.
 *
 * 
 *
 * @since 1.0.0
 */
class WooCommerceManager {

    public $sidebarState = false;

    public function __construct() {
        add_action('woocommerce_blocks_checkout_enqueue_data', [$this, 'checkoutEnqueue']);
        add_action('woocommerce_blocks_cart_enqueue_data', [$this, 'cartEnqueue']);
        add_action('wp_footer', [$this, 'wooEnqueue']);

        // Add action to enqueue block-specific styles
        add_action('wp_footer', [$this, 'blockSpecificAssets']);
        // Add hook to detect sidebar (both WordPress core and Elementor/dynamic_sidebar calls)
        add_action('get_sidebar', [$this, 'sidebarDetected']);
        add_action('dynamic_sidebar_before', [$this, 'sidebarDetected']);
        add_action('admin_enqueue_scripts', [$this, 'adminEnqueue']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_yith_styles']);

        add_action('wp_ajax_pix_product_preview', [$this, 'pixProductPreview']);
        add_action('wp_ajax_nopriv_pix_product_preview', [$this, 'pixProductPreview']);

        add_action('wp_ajax_pix_product_add', [$this, 'pixProductAdd']);
        add_action('wp_ajax_nopriv_pix_product_add', [$this, 'pixProductAdd']);
    }

    public function wooEnqueue() {
        wp_enqueue_style('pix-woo-blocks', PIX_CORE_PLUGIN_URI . 'includes/woocommerce/css/woo.min.css', [], PIXFORT_PLUGIN_VERSION, 'all');
        wp_enqueue_style('pix-woo-2', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/woocommerce.min.css', false, PLUGIN_VERSION, 'all');
    }

    public function enqueue_yith_styles() {
        if (function_exists('yith_wcwl_is_wishlist_page') && (yith_wcwl_is_wishlist_page() || is_product())) {
            wp_enqueue_style('pix-yith-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/yith.min.css', [], PIXFORT_PLUGIN_VERSION, 'all');
        }
    }

    public function enableSidebar() {
        $this->sidebarState = true;
    }

    public function checkoutEnqueue() {
    }

    public function cartEnqueue() {
    }

    /**
     * Enqueue admin-specific assets.
     */
    public function adminEnqueue() {
        wp_enqueue_style(
            'pix-admin-woo-blocks',
            PIX_CORE_PLUGIN_URI . 'includes/woocommerce/css/admin-woo-blocks.min.css',
            [],
            PIXFORT_PLUGIN_VERSION,
            'all'
        );
    }

    /**
     * Enqueue block-specific assets when blocks are being used
     */
    public function blockSpecificAssets() {
        // Don't load in admin
        if (is_admin()) {
            return;
        }

        $should_load_css = false;

        // Check if block exists anywhere (including widgets)
        if (has_block('woocommerce/product-categories')) {
            $should_load_css = true;
        } elseif ($this->sidebar_loaded) {
            // Sidebar was loaded via get_sidebar() or dynamic_sidebar()
            $should_load_css = true;
        }

        // Load CSS if conditions are met
        if ($should_load_css) {
            wp_enqueue_style(
                'pixfort-woo-blocks',
                PIX_CORE_PLUGIN_URI . 'includes/woocommerce/css/woo-blocks.min.css',
                [],
                PIXFORT_PLUGIN_VERSION,
                'all'
            );
        }
    }

    // Flag to track if a sidebar was loaded
    private $sidebar_loaded = false;

    /**
     * Set flag when a sidebar is loaded
     */
    public function sidebarDetected() {
        $this->sidebar_loaded = true;
    }

    /**
     * AJAX function for products.
     */
    function pixProductPreview() {

        if (!wp_verify_nonce($_REQUEST['nonce'], "product_nonce")) {
            wp_send_json_error("Verification error, please try again!");
            return;
        }
        if (empty($_REQUEST['id'])) {
            wp_send_json_error("Error: Product ID is missing!");
            return;
        }
        $id = (int)$_REQUEST['id'];
        if (class_exists('WooCommerce')) {
            $product = wc_get_product($id);
            if (!$product) {
                wp_send_json_error("Error: Invalid product ID.");
                return;
            }
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
            $hasImage = true;
            $mainCol = 'col-sm-6';
            if (empty($image[0])) {
                $hasImage = false;
                $mainCol = '';
            }

            // Start output buffering to capture the HTML
            ob_start();
?>
            <div class="container">
                <div class="row">
                    <?php if ($hasImage) { ?>
                        <div class="col-12 col-sm-6 pix-popup-img p-0">
                            <img src="<?php echo esc_url($image[0]); ?>" class="w-100">
                        </div>
                    <?php } ?>

                    <div class="col-12 <?php echo esc_attr($mainCol); ?> woocommerce pix-py-20 text-left">
                        <?php
                        setup_postdata($id);
                        echo wc_get_template_html('single-product/rating.php');

                        ?>
                        <a href="<?php echo esc_url(get_permalink($id)); ?>">
                            <h4 class="text-heading-default font-weight-bold pix-mb-5"><?php echo esc_html($product->get_name()); ?></h4>
                        </a>
                        <?php
                        $term_list = wp_get_post_terms($id, 'product_cat');
                        if (count($term_list) > 0) {
                        ?>
                            <div class="pix-mb-20">
                                <?php
                                foreach ($term_list as $key => $value) {
                                    $cat_id = (int)$value->term_id;
                                    $cat_link = get_term_link($cat_id, 'product_cat');
                                ?>
                                    <a href="<?php echo esc_url($cat_link); ?>" rel="tag" class="badge bg-gray-1 text-body-default pix-mr-5 pix-p-5"><?php echo esc_html($value->name); ?></a>
                                <?php
                                }
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                        <p class="text-body-default pix-popup-product-desc"><?php echo  do_shortcode($product->get_short_description()); ?></p>
                        <?php
                        woocommerce_template_single_add_to_cart();
                        // echo wc_get_template_html( 'single-product/add-to-cart/simple.php' );
                        ?>
                    </div>
                </div>
            </div>
<?php

            // Get the buffered content and clean the buffer
            $html_content = ob_get_clean();

            // Send JSON success response with the HTML content
            wp_send_json_success($html_content);
        } else {
            wp_send_json_error("WooCommerce is not available!");
        }
        wp_die();
    }

    function pixProductAdd() {
        if (!wp_verify_nonce($_REQUEST['nonce'], "product_add_nonce")) {
            wp_send_json_error("Verification error, please try again!");
        }
        if (empty($_REQUEST['id'])) {
            exit('Error: Product ID is missing!');
        }
        if (class_exists('WooCommerce')) {
            $id = (int)$_REQUEST['id'];
            // echo WC()->cart->add_to_cart( $id );
            wp_send_json_success(WC()->cart->add_to_cart($id));
        }
        // echo 'OK';
        wp_die();
    }
}
