<?php

function pixfort_demo_misc() {
    $data = array();
    $elementor = false;
    if (class_exists('\Elementor\Plugin')) {
        $elementor = true;
    }

	$import_url = 'https://import.pixfort.com/conseil/';
    $import_image_url = 'https://wordpress.assets.pixfort.com/conseil/thumbnails/misc/';

    if ($elementor) {
        $demo = array(
            'import_file_name'              => 'Portfolio Items Elementor',
            'categories'                    => array('Miscellaneous'),
            'import_file_url'               => $import_url . 'demo-content/portfolio-items-elementor.xml',
            'import_preview_image_url'      => $import_image_url.'portfolio-items.webp',
            'import_notice'                 => esc_html__('6 Portfolio items will be imported with associated images, you can change portfolio layout from theme options. Note: Make sure that Elementor plugin is installed and activated before import!', 'conseil'),
        );
        array_push($data, $demo);
    }

    $demo = array(
        'import_file_name'              => 'WooCommerce Products',
        'categories'                    => array('Miscellaneous'),
        'import_file_url'               => $import_url . 'demo-content/ecommerce-products.xml',
        'import_preview_image_url'      => $import_image_url.'shop-12-products.webp',
        'import_notice'                 => esc_html__('12 WooCommerce products will be imported with associated images. Please note that woocommerce should be installed and activated.', 'conseil'),
    );
    array_push($data, $demo);

    $demo = array(
        'import_file_name'              => 'Default 5 Posts',
        'categories'                    => array('Miscellaneous'),
        'import_file_url'               => $import_url . 'demo-content/blog-5-posts.xml',
        'import_preview_image_url'      => $import_image_url.'blog-5-posts.webp',
        'import_notice'                 => esc_html__('5 Default posts will be imported with associated images.', 'conseil'),
    );
    array_push($data, $demo);

    $demo = array(
        'import_file_name'              => 'Blog widgets',
        'categories'                    => array('Miscellaneous'),
        'local_import_file'             => trailingslashit(get_template_directory()) . 'inc/demo-content/widgets/blog-widgets-media.xml',
        'local_import_widget_file'      => trailingslashit(get_template_directory()) . 'inc/demo-content/widgets/blog-widgets.wie',
        'import_preview_image_url'      => $import_image_url.'blog-widgets.webp',
        'import_notice'                 => esc_html__('Default blog widgets will be imported.', 'conseil'),
    );
    array_push($data, $demo);

    $demo = array(
        'import_file_name'              => 'Shop widgets',
        'categories'                    => array('Miscellaneous'),
        'local_import_file'             => trailingslashit(get_template_directory()) . 'inc/demo-content/widgets/shop-widgets-media.xml',
        'local_import_widget_file'      => trailingslashit(get_template_directory()) . 'inc/demo-content/widgets/shop-widgets.wie',
        'import_preview_image_url'      => $import_image_url.'shop-widgets.webp',
        'import_notice'                 => esc_html__('Default shop widgets will be imported.', 'conseil'),
    );
    array_push($data, $demo);

    $demo = array(
        'import_file_name'              => 'Advisory Menu',
        'categories'                    => array('Miscellaneous'),
        'import_file_url'               => $import_url . 'demo-content/advisory-menu.xml',
        'import_preview_image_url'      => $import_image_url.'advisory-menu.webp',
        'import_notice'                 => esc_html__('Advisory Demo Menu', 'conseil'),
        'preview_url'                   => 'https://conseil.pixfort.com/advisory/',
    );
    array_push($data, $demo);

    $demo = array(
        'import_file_name'              => 'Consulting Menu',
        'categories'                    => array('Miscellaneous'),
        'import_file_url'               => $import_url . 'demo-content/consulting-menu.xml',
        'import_preview_image_url'      => $import_image_url.'consulting-menu.webp',
        'import_notice'                 => esc_html__('Consulting Demo Menu', 'conseil'),
        'preview_url'                   => 'https://conseil.pixfort.com/consulting/',
    );
    array_push($data, $demo);

    $demo = array(
        'import_file_name'              => 'Vision Menu',
        'categories'                    => array('Miscellaneous'),
        'import_file_url'               => $import_url . 'demo-content/vision-menu.xml',
        'import_preview_image_url'      => $import_image_url.'vision-menu.webp',
        'import_notice'                 => esc_html__('Vision Demo Menu', 'conseil'),
        'preview_url'                   => 'https://conseil.pixfort.com/vision/',
    );
    array_push($data, $demo);

    return $data;
}
