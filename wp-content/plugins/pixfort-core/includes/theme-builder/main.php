<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Theme builder
 *
 * 
 *
 * @since 1.0.0
 */
class ThemeBuilder {

    public $dynamicManager;

    public $templateType;

    protected $customTemplate = false;

    protected $customTemplateId = false;

    protected $checkedTemplate = false;

    public function __construct() {
        require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/dynamic-manager.php';
        add_action('init',  [$this, 'init']);
        add_action('wp_body_open', [$this, 'loadPageTemplate'], 0, 0);
        
        if (defined('PIX_DEV')) {
            // WooCommerce single product template override
            if (class_exists('WooCommerce')) {
                add_action('woocommerce_before_single_product', [$this, 'check_override_product_template'], 1);
                // WooCommerce archive pages template override
                add_action('woocommerce_before_main_content', [$this, 'check_override_product_archive_template'], 1);
            }
        }
    }
    public function init() {
        $this->dynamicManager = new DynamicManager();
    }
    public function loadPageTemplate() {
        // if(!$this->checkedTemplate && get_post_type() === 'pixfort_template') {
        $templateId = false;
        if($this->customTemplateId) {
            $templateId = $this->customTemplateId;
        }
        if(!$templateId) {
            $customTemplates = \PixfortCore::instance()->areasManager->getLocationTemplates('template');
            // $this->checkedTemplate = true;
            if (!empty($customTemplates[0])) {
                $templateId = $customTemplates[0];
                $this->customTemplateId = $templateId;
            }
        }
        if($templateId) {
            if (get_post_type($templateId) === 'pixfort_template') {
                if (class_exists('\Elementor\Plugin')) {
                    $this->customTemplate = \Elementor\plugin::instance()->frontend->get_builder_content($templateId, true);
                }
                wp_reset_postdata();
            }
        }
    }

    public function getPageTemplate() {
        // Elementor content - allow necessary HTML tags including styles
        // $allowed_html = wp_kses_allowed_html('post');
        // $allowed_html['style'] = array();
        // $allowed_html['script'] = array('type' => true, 'src' => true, 'id' => true);
        // $allowed_html['link'] = array('rel' => true, 'href' => true, 'type' => true);
        // $allowed_html['svg'] = array('class' => true, 'aria-hidden' => true, 'aria-labelledby' => true, 'role' => true, 'xmlns' => true, 'width' => true, 'height' => true, 'viewbox' => true);
        // $allowed_html['path'] = array('d' => true, 'fill' => true);
        // return wp_kses($customTemplateContent, $allowed_html);
        if(!$this->customTemplate) {
            $this->customTemplate = $this->getPageTemplate();
        }
        return $this->customTemplate;
    }

    public function hasPageTemplate() {
        // if(!$this->checkedTemplate) {
        //     $this->loadPageTemplate();
        // }
        $customTemplates = \PixfortCore::instance()->areasManager->getLocationTemplates('template');
        if (!empty($customTemplates[0])) {
            $template = $customTemplates[0];
            $this->customTemplateId = $template;
            return true;
        }
        if ($this->customTemplate) {
            return true;
        }
        return false;
    }

    /**
     * Override WooCommerce single product template with custom template if assigned
     */
    public function check_override_product_template() {

        // Only proceed if we're on a single product page
        if (!is_product() || is_shop()) {
            return;
        }

        // Check if a custom template is assigned for this product
        if ($this->hasPageTemplate()) {
            // Remove all default WooCommerce product content hooks
            remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
            // remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
            
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
            
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
            
            // Add our custom template output - replace the entire product content
            add_action('woocommerce_before_single_product_summary', [$this, 'start_custom_template_buffer'], 1);
            add_action('woocommerce_after_single_product', [$this, 'end_custom_template_buffer'], 999);
        }
    }

    /**
     * Start output buffer and prepare custom template
     */
    public function start_custom_template_buffer() {
        // Start output buffering to capture and discard default WooCommerce output
        ob_start();
    }

    /**
     * End output buffer and output custom template instead
     */
    public function end_custom_template_buffer() {
        // Discard the buffered default WooCommerce content
        ob_end_clean();
        
        // Output the custom template
        echo $this->getPageTemplate();
    }


    /**
     * Override WooCommerce archive template with custom template if assigned
     */
    public function check_override_product_archive_template() {
        // Only proceed if we're on a WooCommerce archive page (shop, product category, product tag)
        if (!is_shop() && !is_product_category() && !is_product_tag()) {
            return;
        }

        // Check if a custom template is assigned for product archives
        if ($this->hasPageTemplate()) {
            // Remove default WooCommerce archive content hooks
            remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
            remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
            
            remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
            remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
            remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
            
            remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
            
            // Archive description
            remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
            remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);
            
            // Add our custom template output - replace the entire shop content
            add_action('woocommerce_before_main_content', [$this, 'start_custom_template_buffer'], 5);
            add_action('woocommerce_after_main_content', [$this, 'end_custom_template_buffer'], 5);
        }
    }
}
