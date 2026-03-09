<?php

// Register and load the widget
function pix_load_widget() {
    if (!defined('IS_PIXFORT_THEME')) {
        require_once dirname(__FILE__) . '/widgets/recent_posts.php';
        require_once dirname(__FILE__) . '/widgets/small_search.php';
        require_once dirname(__FILE__) . '/widgets/promo_box.php';
        require_once dirname(__FILE__) . '/widgets/categories.php';
        require_once dirname(__FILE__) . '/widgets/social.php';
        register_widget('pix_recent_posts');
        register_widget('pix_small_search');
        register_widget('pix_promo_box');
        register_widget('pix_categories');
        register_widget('pix_social');
    }
}
add_action('widgets_init', 'pix_load_widget');
