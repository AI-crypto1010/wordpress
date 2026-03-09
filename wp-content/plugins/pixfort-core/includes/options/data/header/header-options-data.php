<?php

if (!function_exists('pix_get_header_options_static_data')) {
    /**
     * Header builder static options data localized to the JS app.
     *
     * @param array  $header_dynamic Dynamic options localized in PIX_HEADER_DATA.
     * @param bool   $enable_dynamic_colors Whether dynamic colors are enabled.
     * @return array
     */
    function pix_get_header_options_static_data($header_dynamic, $enable_dynamic_colors = false) {
        // Keep asset references as keys; JS resolves them to webpack-imported files.
        $header_assets = array(
                'COLUMN_SIZE_NONE' => 'COLUMN_SIZE_NONE',
                'COLUMN_SIZE_GROW' => 'COLUMN_SIZE_GROW',
                'COLUMN_SIZE_SHRINK' => 'COLUMN_SIZE_SHRINK',
                'COLUMN_SIZE_CUSTOM' => 'COLUMN_SIZE_CUSTOM',
                'ELEMENTS_ALIGN_DEFAULT' => 'ELEMENTS_ALIGN_DEFAULT',
                'ELEMENTS_ALIGN_START' => 'ELEMENTS_ALIGN_START',
                'ELEMENTS_ALIGN_CENTER' => 'ELEMENTS_ALIGN_CENTER',
                'ELEMENTS_ALIGN_END' => 'ELEMENTS_ALIGN_END',
                'ELEMENTS_ALIGN_BETWEEN' => 'ELEMENTS_ALIGN_BETWEEN',
                'AREA_SHADOW_NONE' => 'AREA_SHADOW_NONE',
                'AREA_SHADOW_SMALL' => 'AREA_SHADOW_SMALL',
                'AREA_SHADOW_MEDIUM' => 'AREA_SHADOW_MEDIUM',
                'AREA_SHADOW_LARGE' => 'AREA_SHADOW_LARGE'
        );

        require_once __DIR__ . '/areas.php';
        require_once __DIR__ . '/text.php';
        require_once __DIR__ . '/social.php';
        require_once __DIR__ . '/wishlist.php';
        require_once __DIR__ . '/logo.php';
        require_once __DIR__ . '/cart.php';
        require_once __DIR__ . '/search.php';
        require_once __DIR__ . '/phone.php';
        require_once __DIR__ . '/address.php';
        require_once __DIR__ . '/link.php';
        require_once __DIR__ . '/space.php';
        require_once __DIR__ . '/divider.php';
        require_once __DIR__ . '/btn.php';
        require_once __DIR__ . '/menu.php';
        require_once __DIR__ . '/language.php';
        require_once __DIR__ . '/theme.php';
        require_once __DIR__ . '/items.php';

        $header_options = array();
        $header_options = array_merge($header_options, pix_get_header_options_data_areas($header_dynamic, $header_assets, $enable_dynamic_colors));
        $header_options = array_merge($header_options, pix_get_header_options_data_text($header_dynamic, $header_assets, $enable_dynamic_colors));
        $header_options = array_merge($header_options, pix_get_header_options_data_social($header_dynamic, $header_assets, $enable_dynamic_colors));
        $header_options = array_merge($header_options, pix_get_header_options_data_wishlist($header_dynamic, $header_assets, $enable_dynamic_colors));
        $header_options = array_merge($header_options, pix_get_header_options_data_logo($header_dynamic, $header_assets, $enable_dynamic_colors));
        $header_options = array_merge($header_options, pix_get_header_options_data_cart($header_dynamic, $header_assets, $enable_dynamic_colors));
        $header_options = array_merge($header_options, pix_get_header_options_data_search($header_dynamic, $header_assets, $enable_dynamic_colors));
        $header_options = array_merge($header_options, pix_get_header_options_data_phone($header_dynamic, $header_assets, $enable_dynamic_colors));
        $header_options = array_merge($header_options, pix_get_header_options_data_address($header_dynamic, $header_assets, $enable_dynamic_colors));
        $header_options = array_merge($header_options, pix_get_header_options_data_link($header_dynamic, $header_assets, $enable_dynamic_colors));
        $header_options = array_merge($header_options, pix_get_header_options_data_space($header_dynamic, $header_assets, $enable_dynamic_colors));
        $header_options = array_merge($header_options, pix_get_header_options_data_divider($header_dynamic, $header_assets, $enable_dynamic_colors));
        $header_options = array_merge($header_options, pix_get_header_options_data_btn($header_dynamic, $header_assets, $enable_dynamic_colors));
        $header_options = array_merge($header_options, pix_get_header_options_data_menu($header_dynamic, $header_assets, $enable_dynamic_colors));
        $header_options = array_merge($header_options, pix_get_header_options_data_language($header_dynamic, $header_assets, $enable_dynamic_colors));
        $header_options = array_merge($header_options, pix_get_header_options_data_theme($header_dynamic, $header_assets, $enable_dynamic_colors));

        return array(
            'header_options' => $header_options,
            'items' => pix_get_header_options_items_data($enable_dynamic_colors),
        );
    }
}
