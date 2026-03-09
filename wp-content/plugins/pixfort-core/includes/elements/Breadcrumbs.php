<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Breadcrumbs
* --------------------------------------------------------------------------- */
class PixBreadcrumbs {

    function render($attr, $content = null) {
        extract(shortcode_atts(array(
            'align'         => 'justify-content-start',
            'text_color'    => 'body-default',
            'text_custom_color' => '',
            'animation' => '',
            'css'             => '',
        ), $attr));
        

        $output = '';

        $output .= pixfortGetBreadcrumbs($align, $text_color, $animation);

        // $link_classes = 'text-body-default';
        // $active_link_classes = 'text-body-default';
        // global $post;
        // global $woocommerce;
        // $homeURL = esc_url(home_url('/'));
        // $homeTitle = esc_attr__('Home', 'pixfort-core');
        // if ($woocommerce && (is_product() || is_product_category())) {
        //     $shopPage = wc_get_page_id('shop');
        //     $homeTitle = get_the_title($shopPage);
        //     $homeURL = get_permalink($shopPage);
        // }

        // $delay = 500;
        // if (!is_front_page()) {
        //     // Start the breadcrumb with a link to your homepage
        //     $output .= '<nav class="text-center" aria-label="breadcrumb">';
        //     $output .= '<ol class="breadcrumb px-0 ' . $align . '">';
        //     $output .= '<li class="breadcrumb-item animate-in" data-anim-type="fade-in-left" data-anim-delay="' . $delay . '"><a class="' . $link_classes . '" href="' . $homeURL . '">' . do_shortcode($homeTitle) . '</a></li>';

        //     // Check if the current page is a category, an archive or a single page. If so show the category or archive name.
        //     if (is_category() || is_single()) {
        //         $customCats = array(
        //             'portfolio'    => 'portfolio-types'
        //         );
        //         $customCats = apply_filters('pixfort/custom_types/categories', $customCats);
        //         if (array_key_exists(get_post_type(), $customCats)) {
        //             $portfolio_category = get_the_terms($post->ID, $customCats[get_post_type()]);
        //             if (!empty($portfolio_category)) $portfolio_category = $portfolio_category[0];
        //             $portfolio_parents = array();
        //             while ($portfolio_category) {
        //                 array_push($portfolio_parents, $portfolio_category);
        //                 if (!empty($portfolio_category->parent)) {
        //                     $portfolio_category = $portfolio_category->parent;
        //                     $portfolio_category = get_term($portfolio_category, $customCats[get_post_type()]);
        //                 } else {
        //                     $portfolio_category = false;
        //                 }
        //             }
        //             $portfolio_parents = array_reverse($portfolio_parents);
        //             foreach ($portfolio_parents as $key => $parent_cat) {
        //                 $delay += 50;

        //                 $output .= '<li class="breadcrumb-item animate-in" data-anim-type="fade-in-left" data-anim-delay="' . $delay . '">';
        //                 $output .= '<span><i class="pixicon-angle-right ' . $link_classes . ' font-weight-bold mr-2" style="position:relative;top:2px;"></i></span>';
        //                 $output .= '<a class="' . $link_classes . '" href="' . get_term_link($parent_cat) . '">' . $parent_cat->name . '</a>';
        //                 $output .= '</li>';
        //             }
        //         } else {
        //             if (get_the_category()) {
        //                 $cat  = get_the_category()[0];
        //                 $parents = array();
        //                 while ($cat) {
        //                     array_push($parents, $cat);
        //                     if (!empty($cat->parent)) {
        //                         $cat = $cat->parent;
        //                         $cat = get_category($cat);
        //                     } else {
        //                         $cat = false;
        //                     }
        //                 }
        //                 $parents = array_reverse($parents);
        //                 foreach ($parents as $key => $parent_cat) {
        //                     $delay += 50;

        //                     $output .= '<li class="breadcrumb-item animate-in" data-anim-type="fade-in-left" data-anim-delay="' . $delay . '">';
        //                     $output .= '<span><i class="pixicon-angle-right ' . $link_classes . ' font-weight-bold mr-2" style="position:relative;top:2px;"></i></span>';
        //                     $output .= '<a class="' . $link_classes . '" href="' . get_category_link($parent_cat) . '">' . $parent_cat->cat_name . '</a>';
        //                     $output .= '</li>';
        //                 }
        //             }
        //         }
        //     }

        //     // If the current page is a single post, show its title with the separator
        //     if ($woocommerce && (is_shop())) {
        //         $output .= '<li class="breadcrumb-item ' . $active_link_classes . ' active animate-in" data-anim-type="fade-in-left" data-anim-delay="600" aria-current="page">';
        //         $output .= '<span><i class="pixicon-angle-right font-weight-bold mr-2" style="position:relative;top:2px;"></i></span>';
        //         $output .= esc_attr(woocommerce_page_title(false));
        //         $output .= '</li>';
        //     }
        //     if ($woocommerce && (is_product() || is_product_category())) {
        //         $product_cat = get_the_terms($post->ID, 'product_cat');
        //         if (!empty($product_cat)) $product_cat = $product_cat[0];
        //         $product_parents = array();
        //         while ($product_cat) {
        //             array_push($product_parents, $product_cat);
        //             if (!empty($product_cat->parent)) {
        //                 $product_cat = $product_cat->parent;
        //                 $product_cat = get_term($product_cat, 'product_cat');
        //             } else {
        //                 $product_cat = false;
        //             }
        //         }
        //         $product_parents = array_reverse($product_parents);
        //         foreach ($product_parents as $key => $parent_cat) {
        //             $delay += 100;

        //             $output .= '<li class="breadcrumb-item animate-in" data-anim-type="fade-in-left" data-anim-delay="' . $delay . '">';
        //             $output .= '<span><i class="pixicon-angle-right ' . $link_classes . ' font-weight-bold mr-2" style="position:relative;top:2px;"></i></span>';
        //             $output .= '<a class="' . $link_classes . '" href="' . get_term_link($parent_cat) . '">' . $parent_cat->name . '</a>';
        //             $output .= '</li>';
        //         }
        //     }


        //     if (is_single() && !is_attachment()) {

        //         $delay += 50;

        //         $output .= '<li class="breadcrumb-item ' . $active_link_classes . ' active animate-in" data-anim-type="fade-in-left" data-anim-delay="' . $delay . '" aria-current="page">';
        //         $output .= '<span><i class="pixicon-angle-right font-weight-bold mr-2" style="position:relative;top:2px;"></i></span>';
        //         $output .= get_the_title();
        //         $output .= '</li>';
        //     } elseif (is_page() && !$post->post_parent) {
        //         $delay += 50;

        //         $output .= '<li class="breadcrumb-item ' . $active_link_classes . ' active animate-in" data-anim-type="fade-in-left" data-anim-delay="' . $delay . '" aria-current="page">';
        //         $output .= '<span><i class="pixicon-angle-right font-weight-bold mr-2" style="position:relative;top:2px;"></i></span>';
        //         $output .= get_the_title();
        //         $output .= '</li>';
        //     } elseif (is_page() && $post->post_parent) {
        //         $parent_id  = $post->post_parent;
        //         $parents = array();
        //         while ($parent_id) {
        //             $page = get_page($parent_id);
        //             array_push($parents, $page->ID);
        //             $parent_id  = $page->post_parent;
        //         }
        //         $parents = array_reverse($parents);
        //         foreach ($parents as $key => $parent_el) {
        //             $delay += 50;

        //             $output .= '<li class="breadcrumb-item ' . $link_classes . ' animate-in" data-anim-type="fade-in-left" data-anim-delay="' . $delay . '" aria-current="page">';
        //             $output .= '<a class="' . $link_classes . '" href="' . get_permalink($parent_el) . '">';
        //             $output .= '<span><i class="pixicon-angle-right ' . $link_classes . ' font-weight-bold mr-2" style="position:relative;top:2px;"></i></span>';
        //             $output .= get_the_title($parent_el);
        //             $output .= '</a>';
        //             $output .= '</li>';
        //         }
        //         $delay += 50;

        //         $output .= '<li class="breadcrumb-item ' . $active_link_classes . ' active animate-in" data-anim-type="fade-in-left" data-anim-delay="' . $delay . '" aria-current="page">';
        //         $output .= '<span><i class="pixicon-angle-right font-weight-bold mr-2" style="position:relative;top:2px;"></i></span>';
        //         $output .= get_the_title();
        //         $output .= '</li>';
        //     }
        //     $output .= '</ol>';
        //     $output .= '</nav>';
        // }

        return $output;
    }
}

// add_shortcode('pix_breadcrumbs', 'sc_pix_breadcrumbs');
