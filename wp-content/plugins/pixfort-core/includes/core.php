<?php

if (!defined('ABSPATH')) {
    exit;
}

class PixfortCore {

    /**
     * Instance.
     *
     * Holds the plugin instance.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     */
    public static $instance = null;

    public static $isEnabled = true;

    public static $popups = array();

    public $headerManager;

    public $elementsManager;

    public $icons;

    /**
     * Areas Manager.
     *
     * The main dynamic areas manager in the plugin
     *
     * @since 1.0.0
     * @access public
     *
     * @var areasManager
     */
    public $areasManager;

    public $areasCache;

    public $wooManager;

    public $themeBuilder;

    public $popupType;

    public $footerType;

    public $introType;

    public $templateType;

    public $optionsBack;

    public $coreFunctions;

    public $styleFunctions = false;

    public $dynamicColors = false;

    public $adminCore;

    function __construct() {
        $this->loader();
    }

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
            self::$instance->init();
        }
        return self::$instance;
    }

    private function loader() {
        require_once PIXFORT_PLUGIN_DIR . 'includes/core-functions.php';
        $this->coreFunctions = new coreFunctions();

        require_once PIXFORT_PLUGIN_DIR . 'includes/wp-functions.php';
        require_once PIXFORT_PLUGIN_DIR . 'includes/header/header-manager.php';
        require_once PIXFORT_PLUGIN_DIR . 'includes/elements-manager.php';
        require_once PIXFORT_PLUGIN_DIR . 'includes/icons/icons.php';
        require_once PIXFORT_PLUGIN_DIR . 'includes/post-types/popup.php';
        require_once PIXFORT_PLUGIN_DIR . 'includes/post-types/footer.php';
        require_once PIXFORT_PLUGIN_DIR . 'includes/post-types/intro.php';
        require_once PIXFORT_PLUGIN_DIR . 'includes/post-types/template.php';
        require_once PIXFORT_PLUGIN_DIR . 'includes/areas-cache.php';
        require_once PIXFORT_PLUGIN_DIR . 'includes/areas-manager.php';
        require_once PIXFORT_PLUGIN_DIR . 'includes/theme-builder/main.php';

        add_action('after_setup_theme',  [$this, 'afterPluginInit'], 13);
        add_action('wp_enqueue_scripts',  [$this, 'enqueueScripts'], 13);
        add_action('wp_footer',  [$this, 'enqueueFooterScripts'], 13);

        add_action('wp_head',  [$this, 'headerExtras'], 10);
        add_action('wp_footer',  [$this, 'footerExtras'], 10);
        add_action('init', [$this, 'initAdmin'], 0);
        add_action('plugins_loaded', [$this, 'excludeAssetsfromExternalPlugins'], 0);
        require_once PIXFORT_PLUGIN_DIR . 'includes/blocks/blocks-index.php';
    }

    public function init() {
        $this->headerManager = new HeaderManager();
        $this->elementsManager = new ElementsManager();
        $this->icons = new PixfortIcons();
        $this->popupType = new PopupType();
        $this->footerType = new FooterType();

        $this->areasCache = new areasCache();
        $this->areasManager = new AreasManager();
    }

    public function afterPluginInit() {
        if ($this->getThemeParam('dynamic_colors')) {
            $this->dynamicColors = true;
        }
        require_once PIXFORT_PLUGIN_DIR . 'includes/style-functions.php';
        $this->styleFunctions = new styleFunctions();
        if (class_exists('WooCommerce')) {
            require_once PIXFORT_PLUGIN_DIR . 'includes/woocommerce-manager.php';
            $this->wooManager = new WooCommerceManager();
        }
        // EditURI link
        remove_action('wp_head', 'rsd_link');
        // windows live writer
        remove_action('wp_head', 'wlwmanifest_link');
        // links for adjacent posts
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
        // WP version
        remove_action('wp_head', 'wp_generator');
        if (\PixfortCore::instance()->getThemeParam('custom_templates') || \PixfortCore::instance()->getThemeParam('custom_intros')) {
            $this->introType = new IntroType();
            $this->themeBuilder = new ThemeBuilder();
        }
        $this->templateType = new TemplateType();
    }

    public function enqueueScripts() {
        wp_register_script('pix-flickity-js', PIX_CORE_PLUGIN_URI . 'functions/elementor/includes/js/flickity.pkgd.min.js', false, PIXFORT_PLUGIN_VERSION, true);
        if (is_rtl()) {
            // Enqueue the RTL CSS file
            wp_enqueue_style(
                'pixfort-rtl-styles',
                PIX_CORE_PLUGIN_URI . 'includes/assets/css/rtl.min.css',
                false,
                PIXFORT_PLUGIN_VERSION,
                'all'
            );
        }
    }

    public function enqueueFooterScripts() {
        wp_enqueue_style(
            'pixfort-main-styles',
            PIX_CORE_PLUGIN_URI . 'includes/assets/css/common/main.min.css',
            false,
            PIXFORT_PLUGIN_VERSION,
            'all'
        );
    }

    public function headerExtras() {
        if(defined('PIX_DEV')){
            // Performance: Add preconnect hints for external resources
            $this->outputPreconnectHints();
        }
        
        // Performance: Add modulepreload hints for critical JS chunks
        $this->outputModulePreloadHints();
        
        if (pix_plugin_get_option('website-preview')) {
            if (pix_plugin_get_option('website-preview')['url']) {
?>
                <meta property="og:image" content="<?php echo esc_url(pix_plugin_get_option('website-preview')['url']); ?>" />
                <meta name="twitter:image" content="<?php echo esc_url(pix_plugin_get_option('website-preview')['url']); ?>" />
<?php
            }
        }
        if (pix_plugin_get_option('pix-custom-header-includes')) {
            echo pix_plugin_get_option('pix-custom-header-includes');
        }
    }
    
    /**
     * Output preconnect hints for faster external resource loading
     * This helps the browser establish early connections to important third-party origins
     */
    private function outputPreconnectHints() {
        $preconnect_origins = [
            'https://fonts.googleapis.com' => false,
            'https://fonts.gstatic.com' => true, // crossorigin needed for fonts
        ];
        
        // Add WordPress assets CDN if different from site
        $assets_origin = defined('WORDPRESS_ASSETS_ORIGIN') ? WORDPRESS_ASSETS_ORIGIN : null;
        if ($assets_origin && strpos($assets_origin, home_url()) === false) {
            $preconnect_origins[$assets_origin] = true;
        }
        
        foreach ($preconnect_origins as $origin => $crossorigin) {
            $crossorigin_attr = $crossorigin ? ' crossorigin' : '';
            echo '<link rel="preconnect" href="' . esc_url($origin) . '"' . $crossorigin_attr . '>' . "\n";
        }
        
        // DNS prefetch for additional origins that may be used
        $dns_prefetch_origins = [
            '//fonts.googleapis.com',
            '//fonts.gstatic.com',
        ];
        
        foreach ($dns_prefetch_origins as $origin) {
            echo '<link rel="dns-prefetch" href="' . esc_attr($origin) . '">' . "\n";
        }
    }
    
    /**
     * Output modulepreload hints for critical JavaScript chunks
     * This tells the browser to fetch, parse, and compile modules before they're needed
     */
    private function outputModulePreloadHints() {
        $manifest_path = PIXFORT_PLUGIN_DIR . 'dist/front/manifest.json';
        
        if (!file_exists($manifest_path)) {
            return;
        }
        
        $manifest = json_decode(file_get_contents($manifest_path), true);
        
        if (!$manifest) {
            return;
        }
        
        // Critical chunks that should be preloaded
        $critical_chunks = [
            'header.js',
            'common.js',
            'animations.js',
            'accordion.js',
        ];
        
        foreach ($critical_chunks as $chunk) {
            if (isset($manifest[$chunk])) {
                $chunk_url = PIX_CORE_PLUGIN_URI . 'dist/front/' . $manifest[$chunk];
                echo '<link rel="modulepreload" href="' . esc_url($chunk_url) . '">' . "\n";
            }
        }
    }

    public function footerExtras() {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return false;
        }
        require_once PIXFORT_PLUGIN_DIR . 'includes/elements/extras/back-to-top.php';
        if (!empty(pix_plugin_get_option('pix-custom-js-footer'))) {
            wp_register_script('pixfort-options-script-footer', false, false, PIXFORT_THEME_VERSION);
            wp_enqueue_script('pixfort-options-script-footer');
            wp_add_inline_script('pixfort-options-script-footer', pix_plugin_get_option('pix-custom-js-footer'));
        }
        if (function_exists('pixfort_footer_extras')) {
            pixfort_footer_extras();
        }
    }

    public function initAdmin() {
        if (function_exists('is_user_logged_in') && is_user_logged_in()) {
            require_once PIXFORT_PLUGIN_DIR . 'includes/admin-core.php';
            $this->adminCore = new PixfortAdminCore();
        }
    }

    public function getThemeParam($param) {
        if (function_exists('pix_theme_params')) {
            $params = pix_theme_params();
            if (isset($params[$param])) {
                return $params[$param];
            }
        }
        return false;
    }

    public function excludeAssetsfromExternalPlugins() {
        // Only proceed if an administrator is logged in.
        if (! is_user_logged_in() || ! current_user_can('manage_options')) {
            return;
        }

        // Only proceed if SiteGround Speed Optimizer is active.
        if (! (class_exists('SG_CachePress') || defined('SG_CACHEPRESS_VERSION'))) {
            return;
        }

        // Your handles once, edit as needed.
        $pixHandles = ['pix-main-pixfort'];

        add_filter('sgo_js_minify_exclude', function ($exclude) use ($pixHandles) {
            $exclude = is_array($exclude) ? $exclude : [];
            return array_values(array_unique(array_merge($exclude, $pixHandles)));
        });

        add_filter('sgo_javascript_combine_exclude', function ($exclude) use ($pixHandles) {
            $exclude = is_array($exclude) ? $exclude : [];
            return array_values(array_unique(array_merge($exclude, $pixHandles)));
        });
    }
}

/**
 * Performance: Ensure all Google Fonts URLs include display=swap
 * This prevents FOIT (Flash of Invisible Text) and improves perceived performance
 */
add_filter('style_loader_src', 'pixfort_optimize_google_fonts_url', 10, 2);
function pixfort_optimize_google_fonts_url($src, $handle) {
    if (strpos($src, 'fonts.googleapis.com') !== false) {
        // Add display=swap if not already present
        if (strpos($src, 'display=') === false) {
            $src = add_query_arg('display', 'swap', $src);
        }
    }
    return $src;
}

PixfortCore::instance();
