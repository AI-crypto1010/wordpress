<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Dynamic Manager.
 *
 * 
 *
 * @since 1.0.0
 */
class DynamicManager{

    public function __construct() {
		
        add_action( 'elementor/dynamic_tags/register', [$this, 'register_new_dynamic_tags'] );
        add_action( 'init', [$this, 'register_dynamic_shortcodes'], 20 );
        
	}

    private function has_valid_purchase_code() {
        $code = get_option('envato_purchase_code_27889640');
        $code_2 = get_option('pixfort_purchase_code_1');
        $code_3 = get_option('envato_purchase_code_61457003');

        return (bool) ($code || $code_2 || $code_3);
    }

    private function is_wpbakery_available() {
        return class_exists('Vc_Manager') || defined('WPB_VC_VERSION') || function_exists('vc_map');
    }

    public function register_dynamic_shortcodes() {
        
        if (!$this->is_wpbakery_available()) {
            return;
        }

        if (!$this->has_valid_purchase_code()) {
            return;
        }

        require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/shortcodes/helpers.php';
        require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/shortcodes/pix-dynamic.php';
        require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/wpbakery/shortcode-ui.php';

        if ( class_exists( 'ACF' ) ) {
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/acf/dynamic-value-provider.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/shortcodes/acf.php';
        }
    }

    function register_new_dynamic_tags( $dynamic_tags_manager ) {
        if (!$this->has_valid_purchase_code()) {
            return;
        }
        /*
        * Register pixfort dynamic groups
        */
        $dynamic_tags_manager->register_group( 'pixfort-actions', array( 'title' => esc_html__( 'pixfort Actions', 'pixfort-core' ) ) );
        $dynamic_tags_manager->register_group( 'pixfort-post', array( 'title' => esc_html__( 'Post', 'pixfort-core' ) ) );
        $dynamic_tags_manager->register_group( 'pixfort-site', array( 'title' => esc_html__( 'Site', 'pixfort-core' ) ) );
        $dynamic_tags_manager->register_group( 'pixfort-archive', array( 'title' => esc_html__( 'Archive', 'pixfort-core' ) ) );
        $dynamic_tags_manager->register_group( 'pixfort-author', array( 'title' => esc_html__( 'Author', 'pixfort-core' ) ) );
        
        if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
            $dynamic_tags_manager->register_group( 'acf', array( 'title' => esc_html__( 'ACF', 'pixfort-code' ) ) );
        }

        /*
        * Custom tags
        */
        // require_once PIXFORT_PLUGIN_DIR . 'includes/dynamic/tags/class-my-custom-dynamic-tag.php';
        // $dynamic_tags_manager->register( new Elementor_Test_Tag() );
        
        /*
        * Global tags
        */
        if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
            // Post related tags
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/post-title.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/post-url.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/post-featured-image.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/post-excerpt.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/post-date.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/comments-number.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/comments-url.php';
            
            // Site related tags
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/page-title.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/site-title.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/site-url.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/site-tagline.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/internal-url.php';
            // require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/current-date-time.php';
            
            // Archive related tags
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/archive-description.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/archive-meta.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/archive-title.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/archive-url.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/pixfort/pixfort-category-image.php';
            
            // Author related tags
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/author-info.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/author-meta.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/author-name.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/author-profile-picture.php';
            require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/author-url.php';
            
            // ACF integration - Only load if ACF plugin is active
            if ( class_exists( 'ACF' ) ) {
                require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/acf/dynamic-value-provider.php';
                require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/acf/module.php';
                require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/acf/tags/acf-text.php';
                require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/acf/tags/acf-image.php';
                require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/acf/tags/acf-url.php';
                require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/acf/tags/acf-gallery.php';
                require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/acf/tags/acf-file.php';
                require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/acf/tags/acf-number.php';
                require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/acf/tags/acf-color.php';
                require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/tags/acf/tags/acf-date-time.php';
                
                // Initialize ACF module
                new ACF_Module();
            }
            
            // Register post tags
            $dynamic_tags_manager->register( new Post_Title() );
            $dynamic_tags_manager->register( new Post_URL() );
            $dynamic_tags_manager->register( new Post_Featured_Image() );
            $dynamic_tags_manager->register( new Post_Excerpt() );
            $dynamic_tags_manager->register( new Post_Date() );
            $dynamic_tags_manager->register( new Comments_Number() );
            $dynamic_tags_manager->register( new Comments_URL() );
            
            // Register site tags
            $dynamic_tags_manager->register( new Page_Title() );
            $dynamic_tags_manager->register( new Site_Title() );
            $dynamic_tags_manager->register( new Site_URL() );
            $dynamic_tags_manager->register( new Site_Tagline() );
            $dynamic_tags_manager->register( new Internal_URL() );
            // $dynamic_tags_manager->register( new Current_Date_Time() );
            
            // Register archive tags
            $dynamic_tags_manager->register( new Archive_Description() );
            $dynamic_tags_manager->register( new Archive_Meta() );
            $dynamic_tags_manager->register( new Archive_Title() );
            $dynamic_tags_manager->register( new Archive_URL() );
            $dynamic_tags_manager->register( new Pixfort_Category_Image() );
            
            // Register author tags
            $dynamic_tags_manager->register( new Author_Info() );
            $dynamic_tags_manager->register( new Author_Meta() );
            $dynamic_tags_manager->register( new Author_Name() );
            $dynamic_tags_manager->register( new Author_Profile_Picture() );
            $dynamic_tags_manager->register( new Author_URL() );
            
            // Register ACF tags - Only if ACF plugin is active
            if ( class_exists( 'ACF' ) ) {
                $dynamic_tags_manager->register( new ACF_Text() );
                $dynamic_tags_manager->register( new ACF_Image() );
                $dynamic_tags_manager->register( new ACF_URL() );
                $dynamic_tags_manager->register( new ACF_Gallery() );
                $dynamic_tags_manager->register( new ACF_File() );
                $dynamic_tags_manager->register( new ACF_Number() );
                $dynamic_tags_manager->register( new ACF_Color() );
                $dynamic_tags_manager->register( new ACF_Date_Time() );
            }
        }
    
    }

}
