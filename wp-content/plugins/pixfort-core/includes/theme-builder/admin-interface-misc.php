<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Enqueue admin tabs styles
 */
function pix_enqueue_admin_tabs_styles() {
    global $pagenow;
    if ( ! function_exists( 'get_current_screen' ) ) {
        return false;
    }
    $screen = get_current_screen();
    $code = get_option('envato_purchase_code_27889640');
    $code_2 = get_option('pixfort_purchase_code_1');
    $code_3 = get_option('envato_purchase_code_61457003');
    if (!$code && !$code_2 && !$code_3) {
        wp_enqueue_style('pixfort-admin-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/admin.css', false, PIXFORT_PLUGIN_VERSION, 'all');
    }
    // Check if we're on the edit page or post management page for our custom post types
    if (!$screen || $pagenow != 'edit.php') {
        return;
    }
    
    $screen_post_type = $screen->post_type;
    
    $post_types = array('pixheader', 'pixfooter', 'pixpopup', 'pixintro', 'pixfort_template');
    
    // Only enqueue if we're on one of our custom post types pages
    if (in_array($screen_post_type, $post_types)) {
        wp_enqueue_style(
            'pix-theme-builder-admin',
            plugin_dir_url(__FILE__) . 'admin-interface.css',
            [],
            PIXFORT_PLUGIN_VERSION
        );
    }
}
add_action('admin_enqueue_scripts', 'pix_enqueue_admin_tabs_styles');

/**
 * Add tab navigation between Footers, Popups, and Headers in admin area
 */
function pix_add_admin_tabs() {
    global $pagenow;
    if ( ! function_exists( 'get_current_screen' ) ) {
        return false;
    }
    $screen = get_current_screen();
    $screen_post_type = $screen->post_type;

    $template_type = isset($_GET['pixfort_template_type'])
    ? sanitize_text_field( wp_unslash( $_GET['pixfort_template_type'] ) )
    : '';

    if($screen_post_type==='pixfort_template'&&!empty($template_type)){
        $screen_post_type = 'pixfort_template_'.$template_type;
    }

    // Check if we're on the edit page or post management page for our custom post types
    if (!$screen || $pagenow != 'edit.php') {
        return;
    }
    
    $post_types = array(
        'pixheader' => array(
            'label' => __('Headers', 'pixfort-core'),
            'url' => admin_url('edit.php?post_type=pixheader')
        ),
        'pixfooter' => array(
            'label' => __('Footers', 'pixfort-core'), 
            'url' => admin_url('edit.php?post_type=pixfooter')
        ),
        'pixpopup' => array(
            'label' => __('Popups', 'pixfort-core'),
            'url' => admin_url('edit.php?post_type=pixpopup')
        ),
    );
    
    if(\PixfortCore::instance()->getThemeParam('custom_intros')) {
        $post_types['pixintro'] = array(
            'label' => __('Intros', 'pixfort-core'),
            'url' => admin_url('edit.php?post_type=pixintro')
        );
    }
    if(\PixfortCore::instance()->getThemeParam('custom_templates')) {
        $post_types['pixfort_template_post'] = array(
            'label' => __('Post', 'pixfort-core'),
            'url' => admin_url('edit.php?post_type=pixfort_template&pixfort_template_type=post')
        );
        $post_types['pixfort_template_page'] = array(
            'label' => __('Page', 'pixfort-core'),
            'url' => admin_url('edit.php?post_type=pixfort_template&pixfort_template_type=page')
        );
        $post_types['pixfort_template_archive'] = array(
            'label' => __('Archive', 'pixfort-core'),
            'url' => admin_url('edit.php?post_type=pixfort_template&pixfort_template_type=archive')
        );
        $post_types['pixfort_template_search'] = array(
            'label' => __('Search', 'pixfort-core'),
            'url' => admin_url('edit.php?post_type=pixfort_template&pixfort_template_type=search')
        );
        if (defined('PIX_DEV')) {
            $post_types['pixfort_template_product'] = array(
                'label' => __('Single Product', 'pixfort-core'),
                'url' => admin_url('edit.php?post_type=pixfort_template&pixfort_template_type=product')
            );
            $post_types['pixfort_template_product-archive'] = array(
                'label' => __('Products Archive', 'pixfort-core'),
                'url' => admin_url('edit.php?post_type=pixfort_template&pixfort_template_type=product-archive')
            );
        }
        $post_types['pixfort_template_template'] = array(
            'label' => __('Templates', 'pixfort-core'),
            'url' => admin_url('edit.php?post_type=pixfort_template&pixfort_template_type=template')
        );
    }
    if(\PixfortCore::instance()->getThemeParam('enable_pixfort_template')) {
        $post_types['pixfort_template_template'] = array(
            'label' => __('Templates', 'pixfort-core'),
            'url' => admin_url('edit.php?post_type=pixfort_template&pixfort_template_type=template')
        );
    }
    
    // Only show the tabs if we're on one of our custom post types pages
    if (!array_key_exists($screen_post_type, $post_types)&&$screen_post_type!=='pixfort_template') {
        return;
    }
    
    echo '<div class="pix-admin-tabs">';
    
    // Add descriptive text
    echo '<div class="pix-admin-tabs-description">';
    echo '<p>';
    if(\PixfortCore::instance()->getThemeParam('custom_templates')) {
        echo __('Welcome to the Theme Builder! Here you can manage your website\'s Headers, Footers, Intros, Popups and Page Templates.', 'pixfort-core');
    } else {
        echo __('Welcome to the Theme Builder! Here you can manage your website\'s Headers, Footers and Popups.', 'pixfort-core');
    }
    echo '</p>';
    echo '</div>';
    
    echo '<h2 class="nav-tab-wrapper">';
    
    
    foreach ($post_types as $post_type => $data) {
        $active = ($screen_post_type == $post_type) ? 'nav-tab-active' : '';
        echo '<a href="' . esc_url($data['url']) . '" class="nav-tab ' . esc_attr($active) . '">' . esc_html($data['label']) . '</a>';
    }
    
    echo '</h2>';
    
    // Add tab-specific descriptions
    echo '<div class="pix-admin-tabs-specific">';

    foreach ($post_types as $post_type => $data) {
        $active_class = ($screen_post_type == $post_type) ? 'active' : 'inactive';
        $description = '';
        $doc_link = '';

        switch($post_type) {
            case 'pixheader':
                $description = __('Create and manage your website headers. Headers are the top section of your website that typically contains your logo, menu, and other elements.', 'pixfort-core');
                $doc_link = \PixfortCore::instance()->adminCore->getParam('docs_create_header');
                break;
            case 'pixfooter':
                $description = __('Design and customize your website footers. Footers appear at the bottom of your website and can include logo, links, and copyright information.', 'pixfort-core');
                $doc_link = \PixfortCore::instance()->adminCore->getParam('docs_create_footer');
                break;
            case 'pixintro':
                $description = __('Create and manage your website intros. Intros are sections that can be displayed at the top of the pages below the header.', 'pixfort-core');
                $doc_link = \PixfortCore::instance()->adminCore->getParam('docs_create_intro');
                break;
            case 'pixpopup':
                $description = __('Create engaging popups to capture leads, display announcements, or show important information to your visitors.', 'pixfort-core');
                $doc_link = \PixfortCore::instance()->adminCore->getParam('docs_create_popup');
                break;
            case 'pixfort_template_post':
            case 'pixfort_template_page':
            case 'pixfort_template_archive':
            case 'pixfort_template_search':
            case 'pixfort_template_product':
            case 'pixfort_template_product-archive':
                $description = __('Create and manage your website templates. Templates are custom designed page templates that can be used to override the default page layout.', 'pixfort-core');
                $doc_link = \PixfortCore::instance()->adminCore->getParam('docs_create_page_templates');
                break;
            case 'pixfort_template_template':
                $description = __('Create and manage reusable templates. These templates can be used within other Elementor widgets across your website.', 'pixfort-core');
                $doc_link = \PixfortCore::instance()->adminCore->getParam('docs_global_templates');
                break;
        }
        
        echo '<div class="pix-admin-tab-description ' . esc_attr($active_class) . '">';
        echo '<div class="pix-admin-tab-description-content">';
        echo '<span class="dashicons dashicons-info"></span>';
        echo '<p>' . esc_html($description) . '</p>';
        echo '</div>';
        echo '<a href="' . esc_url($doc_link) . '" target="_blank" class="button button-secondary button-small pix-admin-learn-more">';
        echo '<span class="dashicons dashicons-book"></span>';
        echo __('Learn more about ' . $data['label'], 'pixfort-core');
        echo '</a>';
        echo '</div>';
    }
    echo '</div>';

    $label = __('Template', 'pixfort-core');

    switch($screen_post_type) {
        case 'pixheader':
            $label = __('Header', 'pixfort-core');
            break;
        case 'pixfooter':
            $label = __('Footer', 'pixfort-core');
            break;
        case 'pixintro':
            $label = __('Intro', 'pixfort-core');
            break;
        case 'pixpopup':
            $label = __('Popup', 'pixfort-core');
            break;
        case 'pixfort_template_post':
            $label = __('Post Template', 'pixfort-core');
            break;
        case 'pixfort_template_page':
            $label = __('Page Template', 'pixfort-core');
            break;
        case 'pixfort_template_archive':
            $label = __('Archive Template', 'pixfort-core');
            break;
        case 'pixfort_template_search':
            $label = __('Search Template', 'pixfort-core');
            break;
        case 'pixfort_template_product':
            $label = __('Single Product Template', 'pixfort-core');
            break;
        case 'pixfort_template_product-archive':
            $label = __('Products Archive Template', 'pixfort-core');
            break;
        case 'pixfort_template_template':
            $label = __('Template', 'pixfort-core');
            break;
    }

    // if($screen->post_type==='pixfort_template'){
        $newURL = 'post-new.php?post_type=' . $screen->post_type;
        if($screen->post_type==='pixfort_template'&&!empty($template_type)){
            $newURL .= '&pixfort_template_type=' . $template_type;
        }
        $add_new_url = admin_url($newURL);

        echo '<div class="pix-admin-tabs-add-new">';
        // echo '<h1 class="wp-heading-inline">pixfort Templates</h1>';
        echo '<a href="' . esc_url($add_new_url) . '" class="button button-secondary button-small pix-admin-add-new-btn">';
        echo '<span class="dashicons dashicons-plus-alt2"></span>';
        echo __('Add New ', 'pixfort-core') . $label;
        echo '</a>';
        echo '</div>';
    // }
    
    echo '</div>';
}
add_action('admin_notices', 'pix_add_admin_tabs');


/**
 * Customize admin menu - Remove individual items and create Theme Builder section
 */
function pix_customize_admin_menu() {
    global $submenu;
    
    // Remove individual menu items
    remove_menu_page('edit.php?post_type=pixheader');
    remove_menu_page('edit.php?post_type=pixfooter');
    remove_menu_page('edit.php?post_type=pixintro');
    remove_menu_page('edit.php?post_type=pixpopup');
    remove_menu_page('edit.php?post_type=pixfort_template');
    // Add new Theme Builder menu
    add_menu_page(
        'Theme Builder', 
        'Theme Builder', 
        'edit_posts', 
        'edit.php?post_type=pixheader', 
        null, 
        'dashicons-admin-appearance', 
        1
    );
    
    // Add submenu items
    // add_submenu_page(
    //     'edit.php?post_type=pixheader', 
    //     'Headers', 
    //     'Headers', 
    //     'edit_posts', 
    //     'edit.php?post_type=pixheader'
    // );
    
    add_submenu_page(
        'edit.php?post_type=pixheader', 
        __('Footers', 'pixfort-core'), 
        __('Footers', 'pixfort-core'), 
        'edit_posts', 
        'edit.php?post_type=pixfooter'
    );
    
    add_submenu_page(
        'edit.php?post_type=pixheader', 
        __('Popups', 'pixfort-core'), 
        __('Popups', 'pixfort-core'), 
        'edit_posts', 
        'edit.php?post_type=pixpopup'
    );

    if(\PixfortCore::instance()->getThemeParam('custom_intros')) {
        add_submenu_page(
            'edit.php?post_type=pixheader', 
            __('Intros', 'pixfort-core'), 
            __('Intros', 'pixfort-core'), 
            'edit_posts', 
            'edit.php?post_type=pixintro'
        );
    }
    if(\PixfortCore::instance()->getThemeParam('custom_templates')) {
        add_submenu_page(
            'edit.php?post_type=pixheader', 
            __('Posts', 'pixfort-core'), 
            __('Posts', 'pixfort-core'), 
            'edit_posts', 
            'edit.php?post_type=pixfort_template&pixfort_template_type=post'
        );
        add_submenu_page(
            'edit.php?post_type=pixheader', 
            __('Pages', 'pixfort-core'), 
            __('Pages', 'pixfort-core'), 
            'edit_posts', 
            'edit.php?post_type=pixfort_template&pixfort_template_type=page'
        );
        add_submenu_page(
            'edit.php?post_type=pixheader', 
            __('Archives', 'pixfort-core'), 
            __('Archives', 'pixfort-core'), 
            'edit_posts', 
            'edit.php?post_type=pixfort_template&pixfort_template_type=archive'
        );
        add_submenu_page(
            'edit.php?post_type=pixheader', 
            __('Search', 'pixfort-core'), 
            __('Search', 'pixfort-core'), 
            'edit_posts', 
            'edit.php?post_type=pixfort_template&pixfort_template_type=search'
        );
        
        if (defined('PIX_DEV')) {
            add_submenu_page(
                'edit.php?post_type=pixheader', 
                __('Single Product', 'pixfort-core'), 
                __('Single Product', 'pixfort-core'), 
                'edit_posts', 
                'edit.php?post_type=pixfort_template&pixfort_template_type=product'
            );
            add_submenu_page(
                'edit.php?post_type=pixheader', 
                __('Products Archive', 'pixfort-core'), 
                __('Products Archive', 'pixfort-core'), 
                'edit_posts', 
                'edit.php?post_type=pixfort_template&pixfort_template_type=product-archive'
            );
        }
    }
    if(\PixfortCore::instance()->getThemeParam('enable_pixfort_template')) {
        add_submenu_page(
            'edit.php?post_type=pixheader', 
            __('Templates', 'pixfort-core'), 
            __('Templates', 'pixfort-core'), 
            'edit_posts', 
            'edit.php?post_type=pixfort_template&pixfort_template_type=template'
        );
    }
    
    
    // Remove "Add New" submenu items
    if (isset($submenu['edit.php?post_type=pixheader'])) {
        foreach ($submenu['edit.php?post_type=pixheader'] as $key => $item) {
            // Check if this is an "Add New" item
            if (isset($item[2]) && ($item[2] === 'post-new.php?post_type=pixheader' || 
                                    $item[2] === 'post-new.php?post_type=pixfooter' || 
                                    $item[2] === 'post-new.php?post_type=pixintro' || 
                                    $item[2] === 'post-new.php?post_type=pixpopup' ||
                                    $item[2] === 'post-new.php?post_type=pixfort_template&pixfort_template_type=post' ||
                                    $item[2] === 'post-new.php?post_type=pixfort_template&pixfort_template_type=page' ||
                                    $item[2] === 'post-new.php?post_type=pixfort_template&pixfort_template_type=archive' ||
                                    $item[2] === 'post-new.php?post_type=pixfort_template&pixfort_template_type=search' ||
                                    $item[2] === 'post-new.php?post_type=pixfort_template&pixfort_template_type=product' ||
                                    $item[2] === 'post-new.php?post_type=pixfort_template&pixfort_template_type=product-archive' ||
                                    $item[2] === 'post-new.php?post_type=pixfort_template&pixfort_template_type=template')) {
                unset($submenu['edit.php?post_type=pixheader'][$key]);
            }
        }
    }
    
    // Fix the highlight for current admin page and ensure Theme Builder stays open
    // if ( ! function_exists( 'get_current_screen' ) ) {
    //     return false;
    // }
    // $screen = get_current_screen();
    
    // if (isset($_GET['post_type'])) {
    //     $current_post_type = $_GET['post_type'];
    //     if (in_array($current_post_type, ['pixheader', 'pixfooter', 'pixpopup'])) {
    //         // This ensures the parent menu is highlighted correctly and stays open
    //         $GLOBALS['parent_file'] = 'edit.php?post_type=pixheader';
            
    //         // This ensures the submenu item is highlighted correctly
    //         $GLOBALS['submenu_file'] = 'edit.php?post_type=' . $current_post_type;
    //     }
    // }
    
    // // Also handle post editing and creation screens
    // if ($screen && $screen->base == 'post' && isset($screen->post_type) && 
    //     in_array($screen->post_type, ['pixheader', 'pixfooter', 'pixpopup'])) {
    //     $GLOBALS['parent_file'] = 'edit.php?post_type=pixheader';
    //     $GLOBALS['submenu_file'] = 'edit.php?post_type=' . $screen->post_type;
    // }
}
add_action('admin_menu', 'pix_customize_admin_menu', 999); // Use high priority to ensure it runs after the post types are registered

/**
 * Additional function to handle screen-based menu highlighting and ensure menu stays open
 */
function pix_theme_builder_admin_scripts() {
    if ( ! function_exists( 'get_current_screen' ) ) {
        return false;
    }
    $screen = get_current_screen();

    $screen_post_type = $screen->post_type;

    $template_type = isset($_GET['pixfort_template_type'])
    ? sanitize_text_field( wp_unslash( $_GET['pixfort_template_type'] ) )
    : '';

    // If editing an existing post, get template type from the post's taxonomy
    if($screen_post_type==='pixfort_template' && empty($template_type) && isset($_GET['post'])) {
        $post_id = intval($_GET['post']);
        $terms = get_the_terms($post_id, 'pixfort_template_type');
        if ($terms && !is_wp_error($terms) && !empty($terms[0]) && !empty($terms[0]->slug)) {
            $template_type = $terms[0]->slug;
        }
    }

    if($screen_post_type==='pixfort_template'&&!empty($template_type)){
        $screen_post_type = 'pixfort_template_'.$template_type;
    }
    
    // Only run on our custom post type screens
    if ($screen && in_array($screen->post_type, ['pixheader', 'pixfooter', 'pixintro', 'pixpopup', 'pixfort_template'])) {
        // Define "Add New" button link based on current post type
        $newURL = 'post-new.php?post_type=' . $screen->post_type;
        if($screen->post_type==='pixfort_template'&&!empty($template_type)){
            $newURL .= '&pixfort_template_type=' . $template_type;
        }
        $add_new_url = admin_url($newURL);
        
        // Enqueue the admin interface styles
        wp_enqueue_style(
            'pix-theme-builder-admin',
            plugin_dir_url(__FILE__) . 'admin-interface.css',
            [],
            PIXFORT_PLUGIN_VERSION
        );
        
        // Enqueue the admin interface script
        wp_enqueue_script(
            'pix-theme-builder-admin',
            plugin_dir_url(__FILE__) . 'admin-interface.js',
            ['jquery'],
            PIXFORT_PLUGIN_VERSION,
            true
        );
        
        // Pass data to JavaScript
        wp_localize_script('pix-theme-builder-admin', 'pixThemeBuilderAdmin', array(
            'postType' => $screen->post_type,
            'templateType' => $template_type,
            'addNewUrl' => $add_new_url
        ));
    }
}
add_action('admin_enqueue_scripts', 'pix_theme_builder_admin_scripts', 100);

/**
 * Set the correct parent file for Theme Builder menu items
 * This ensures the menu stays open on all Theme Builder pages
 */
function pix_set_theme_builder_parent_file($parent_file) {
    global $current_screen, $submenu_file;
    
    // Check if we're on one of our custom post types
    if ($current_screen && in_array($current_screen->post_type, ['pixheader', 'pixfooter', 'pixintro', 'pixpopup', 'pixfort_template'])) {
        // Set the submenu file to highlight the correct submenu item
        $submenu_file = 'edit.php?post_type=' . $current_screen->post_type;
        
        // Return the parent file to keep the Theme Builder menu open
        return 'edit.php?post_type=pixheader';
    }
    
    return $parent_file;
}
add_filter('parent_file', 'pix_set_theme_builder_parent_file');

/**
 * Ensure proper submenu highlighting for Theme Builder items
 */
function pix_set_theme_builder_submenu_file($submenu_file, $parent_file) {
    global $current_screen, $pagenow;
    
    // If we're on one of our custom post types and the parent is our Theme Builder
    if ($current_screen && 
        in_array($current_screen->post_type, ['pixheader', 'pixfooter', 'pixintro', 'pixpopup', 'pixfort_template']) && 
        $parent_file === 'edit.php?post_type=pixheader') {
        
        // For pixfort_template, include the template type in the submenu file
        if($current_screen->post_type === 'pixfort_template') {
            $template_type = '';
            
            // Get template type from URL parameter
            if(isset($_GET['pixfort_template_type'])) {
                $template_type = sanitize_text_field( wp_unslash( $_GET['pixfort_template_type'] ) );
            }
            // If editing an existing post, get template type from the post's taxonomy
            elseif($pagenow === 'post.php' && isset($_GET['post'])) {
                $post_id = intval($_GET['post']);
                $terms = get_the_terms($post_id, 'pixfort_template_type');
                if ($terms && !is_wp_error($terms) && !empty($terms[0]) && !empty($terms[0]->slug)) {
                    $template_type = $terms[0]->slug;
                }
            }
            
            // If we have a template type, add it to the submenu file
            if(!empty($template_type)) {
                return 'edit.php?post_type=' . $current_screen->post_type . '&pixfort_template_type=' . $template_type;
            }
        }
        
        // Set the correct submenu file for highlighting
        return 'edit.php?post_type=' . $current_screen->post_type;
    }
    
    return $submenu_file;
}
add_filter('submenu_file', 'pix_set_theme_builder_submenu_file', 10, 2);

/**
 * Add admin pointer to highlight Theme Builder menu item
 * Inform users that Theme Builder now includes Headers, Footers, and Popups
 */
function pix_theme_builder_admin_pointer() {
    // Get current user ID
    $user_id = get_current_user_id();
    
    // Check if the user has already dismissed this pointer
    $dismissed = explode(',', (string) get_user_meta($user_id, 'dismissed_wp_pointers', true));
    
    // Define our pointer ID - use a unique name
    $pointer_id = 'pix_theme_builder_pointer';
    
    // Check if our pointer has been dismissed
    if (in_array($pointer_id, $dismissed)) {
        return;
    }
    
    // Enqueue WordPress pointer scripts and styles
    wp_enqueue_style('wp-pointer');
    wp_enqueue_script('wp-pointer');
    
    // Enqueue the admin interface styles
    wp_enqueue_style(
        'pix-theme-builder-admin',
        plugin_dir_url(__FILE__) . 'admin-interface.css',
        [],
        PIXFORT_PLUGIN_VERSION
    );
    
    // Enqueue the admin interface script
    wp_enqueue_script(
        'pix-theme-builder-admin',
        plugin_dir_url(__FILE__) . 'admin-interface.js',
        ['jquery', 'wp-pointer'],
        PIXFORT_PLUGIN_VERSION,
        true
    );
    
    // Create our pointer content
    $pointer_content = '<h3>' . __('Theme Builder (New)', 'pixfort-core') . '</h3>';
    if(\PixfortCore::instance()->getThemeParam('custom_templates')) {
        $pointer_content .= '<p>' . __('The pixfort Theme Builder includes all your Headers, Footers, Intros, Popups and Page Templates in one convenient location!', 'pixfort-core') . '</p>';
    } else {
        $pointer_content .= '<p>' . __('The pixfort Theme Builder includes all your Headers, Footers and Popups in one convenient location!', 'pixfort-core') . '</p>';
    }
    
    // Pass pointer data to JavaScript
    wp_localize_script('pix-theme-builder-admin', 'pixThemeBuilderPointer', array(
        'enabled' => true,
        'pointerId' => $pointer_id,
        'content' => $pointer_content
    ));
}
add_action('admin_enqueue_scripts', 'pix_theme_builder_admin_pointer');