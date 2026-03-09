<?php

if (!function_exists('pix_get_header_options_items_data')) {
    function pix_get_header_options_items_data($enable_dynamic_colors = false) {
        $header_items = array(
            array(
                'name' => 'logo',
                'content' => __('Logo', 'pixfort-core'),
                'category' => 'main',
                'icon' => 'logoMini',
                'val' => array(),
            ),
            array(
                'name' => 'menu',
                'content' => __('Menu', 'pixfort-core'),
                'category' => 'main',
                'icon' => 'barsMenu',
                'val' => array(),
            ),
            array(
                'name' => 'link',
                'content' => __('Link', 'pixfort-core'),
                'category' => 'main',
                'icon' => 'link',
                'val' => array(),
            ),
            array(
                'name' => 'social',
                'content' => __('Social', 'pixfort-core'),
                'category' => 'main',
                'icon' => 'twitter',
                'val' => array(),
            ),
            array(
                'name' => 'search',
                'content' => __('Search', 'pixfort-core'),
                'category' => 'main',
                'icon' => 'zoom',
                'val' => array(),
            ),
            array(
                'name' => 'cart',
                'content' => __('Cart', 'pixfort-core'),
                'category' => 'main',
                'icon' => 'cart',
                'val' => array(),
            ),
            array(
                'name' => 'btn',
                'content' => __('Button', 'pixfort-core'),
                'category' => 'main',
                'icon' => 'btn',
                'val' => array(),
            ),
            array(
                'name' => 'text',
                'content' => __('Text', 'pixfort-core'),
                'category' => 'misc',
                'icon' => 'text',
                'val' => array(),
            ),
            array(
                'name' => 'phone',
                'content' => __('Phone', 'pixfort-core'),
                'category' => 'misc',
                'icon' => 'phone',
                'val' => array(),
            ),
            array(
                'name' => 'address',
                'content' => __('Address', 'pixfort-core'),
                'category' => 'misc',
                'icon' => 'address',
                'val' => array(),
            ),
            array(
                'name' => 'space',
                'content' => __('Space', 'pixfort-core'),
                'category' => 'misc',
                'icon' => 'space',
                'val' => array(),
            ),
            array(
                'name' => 'divider',
                'content' => __('Divider', 'pixfort-core'),
                'category' => 'misc',
                'icon' => 'divider',
                'val' => array(),
            ),
            array(
                'name' => 'language',
                'content' => __('Language', 'pixfort-core'),
                'category' => 'misc',
                'icon' => 'language',
                'val' => array(),
            ),
            array(
                'name' => 'wishlist',
                'content' => __('Wishlist', 'pixfort-core'),
                'category' => 'misc',
                'icon' => 'wishlist',
                'val' => array(),
            ),
        );

        if ($enable_dynamic_colors) {
            $header_items[] = array(
                'name' => 'theme',
                'content' => __('Theme Switcher', 'pixfort-core'),
                'category' => 'misc',
                'icon' => 'theme',
                'val' => array(),
            );
        }

        return $header_items;
    }
}
