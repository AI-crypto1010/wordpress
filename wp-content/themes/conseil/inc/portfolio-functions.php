<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package pixfort theme
 */

if (!function_exists('pixfort_get_portfolio_page')) {
    function pixfort_get_portfolio_page() {
        $count = '9';
        $line_count = '3';
        if (!empty(pix_get_option('portfolio-masonry-count'))) {
            $line_count = pix_get_option('portfolio-masonry-count');
        }
        if (!empty(pix_get_option('portfolio-posts'))) {
            $count = pix_get_option('portfolio-posts');
        }
        $portfolio_style = 'default';
        if (!empty(pix_get_option('portfolio-page-style'))) {
            $portfolio_style = pix_get_option('portfolio-page-style');
        }
        $fullImgs = false;
        if (!empty(pix_get_option('portfolio-display-full'))) {
            if (pix_get_option('portfolio-display-full')) {
                $fullImgs = true;
            }
        }
        if (!empty($_GET["portfolio_style"])) {
            switch ($_GET["portfolio_style"]) {
                case 'mini':
                    $portfolio_style = 'mini';
                    break;
                case 'transparent':
                    $portfolio_style = 'transparent';
                    break;
                case '3d':
                    $portfolio_style = '3d';
                    break;
                case 'default':
                    $portfolio_style = 'default';
                    break;
            }
        }
        if (!empty($_GET["line_count"])) {
            switch ($_GET["line_count"]) {
                case '2':
                    $line_count = '6';
                    break;
                case '3':
                    $line_count = '4';
                    break;
                case '4':
                    $line_count = '3';
                    break;
                case '6':
                    $line_count = '2';
                    break;
            }
        }
        if (!empty($_GET["count"])) {
            if (intval($_GET["count"]) > 0 && intval($_GET["count"]) < 20) {
                $count = intval($_GET["count"]);
            }
        }
        if (class_exists('PixfortCore')) {
            $args = array(
                'portfolio_style'   => $portfolio_style,
                'line_count'         => $line_count,
                'count'             => $count,
                'category'             => '',
                'style'                => 'one',
                'category_multi'    => '',
                'orderby'             => 'date',
                'order'             => 'DESC',
                'filters'             => 0,
                'pagination'        => true,
            );
            if ($portfolio_style == '3d') {
                $args['title_color'] = 'white';
                $args['overlay_color'] = 'gradient-primary';
            }
            if (!empty(pix_get_option('portfolio-orderby'))) {
                $args['orderby'] = pix_get_option('portfolio-orderby');
            }
            if (!empty(pix_get_option('portfolio-order'))) {
                $args['order'] = pix_get_option('portfolio-order');
            }
            if (!empty(pix_get_option('portfolio-isotope'))) {
                $args['filters'] = pix_get_option('portfolio-isotope');
            }
            if ($fullImgs) {
                $args['full_size_img'] = 'yes';
            }
            echo \PixfortCore::instance()->elementsManager->renderElement('Portfolio', $args);
        }
    }
}
