<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!function_exists('pix_portfolio_style_3d')) {
    function pix_portfolio_style_3d($query = false, $is_col = false, $attr = array()) {
        extract(shortcode_atts(array(
            'line_count'         => '4',
            'rounded_img'         => 'rounded-lg',
            'overlay_color'        => 'black',
            'custom_overlay_color'        => '',
            'title_color'        => 'heading-default',
            'title_custom_color'        => '',
            'customCats'         => ''
        ), $attr));
        $output = '';
        if ($query && $query->have_posts()) {
            $query->the_post();

            $item_class = array();
            // $item_text_class = array();
            // $categories = '';
            //
            if (is_array($customCats) && array_key_exists(get_post_type(), $customCats)) {
                $terms = get_the_terms(get_the_ID(), $customCats[get_post_type()]);
            } else {
                $terms = get_the_terms(get_the_ID(), 'category');
            }
            if (is_array($terms)) {
                foreach ($terms as $term) {
                    $item_class[] = 'category-' . $term->slug;
                    // 		$item_text_class[] = $term->slug;
                    // 		$categories .= '<a href="'. site_url() .'/?portfolio-types='. $term->slug .'">'. $term->name .'</a>, ';
                }
                // 	$categories = substr( $categories , 0, -2 );
            }
            $item_class[] = get_post_meta(get_the_ID(), 'pix-post-size', true);
            $item_class[] = ' col-md-6 col-lg-' . $line_count;
            $item_class = implode(' ', $item_class);
            // 	$item_text_class = implode(' ', $item_text_class);

            if ($is_col) $output .= '<div class="col-12 pb-4 grid-item ' . $item_class . '" data-category="transition">';
            $args = array(
                'title'         => get_the_title(),
                // 'text' 		=> get_the_excerpt(),
                'bg_img'         => get_post_thumbnail_id(get_the_ID()),
                // 'title_color'		=> 'white',
                'title_color'        => $title_color,
                'title_custom_color'        => $title_custom_color,
                'content_color'        => 'light-opacity-8',
                'rounded_img'        => $rounded_img,
                'overlay_color'        => $overlay_color,
                'custom_overlay_color'        => $custom_overlay_color,
                'content_classes'        => 'pix-px-20 pix-py-40',
                'content_align'         => 'center',
                'title_size'        => 'h3',
                'title_size'        => 'h3',
                'item_link'        => true,
                'btn_link'        => get_permalink(),
            );
            $output .= \PixfortCore::instance()->elementsManager->renderElement('3dbox', $args);

            if ($is_col) $output .= '</div>';
        }
        return $output;
    }
}


if (!function_exists('pix_portfolio_style_transparent')) {
    function pix_portfolio_style_transparent($query = false, $is_col = false, $attr = array()) {
        $output = '';
        extract(shortcode_atts(array(
            'line_count'         => '4',
            'rounded_img'         => 'rounded-lg',
            'title_color'        => 'heading-default',
            'title_custom_color'        => '',
            'full_size_img'         => '',
            'customCats'         => ''
        ), $attr));

        if ($query && $query->have_posts()) {
            $query->the_post();

            $item_class = array();
            $item_text_class = array();
            $categories = '';
            $cats_str = '';
            if (is_array($customCats) && array_key_exists(get_post_type(), $customCats)) {
                $terms = get_the_terms(get_the_ID(), $customCats[get_post_type()]);
            } else {
                $terms = get_the_terms(get_the_ID(), 'category');
            }
            if (is_array($terms)) {
                foreach ($terms as $term) {
                    $item_class[] = 'category-' . $term->slug;
                    $item_text_class[] = $term->slug;
                    $categories .= '<a href="' . get_term_link($term, get_post_type()) . '">' . $term->name . '</a>, ';
                    $badge_attrs = array(
                        'text'    => $term->name,
                        'text_size'    => 'custom',
                        'text_custom_size'        => '14px',
                        'bold'  => 'font-weight-bold',
                        'custom_css'    => 'padding:5px 10px;line-height:14px;'
                    );
                    $cats_str .= '<a href="' . get_term_link($term, get_post_type()) . '">';
                    $cats_str .= \PixfortCore::instance()->elementsManager->renderElement('Badge', $badge_attrs);
                    $cats_str .= '</a>';
                }
                $categories = substr($categories, 0, -2);
            }
            $item_class[] = get_post_meta(get_the_ID(), 'pix-post-size', true);
            $item_class[] = ' col-md-6 col-lg-' . $line_count;
            $item_class = implode(' ', $item_class);
            $item_text_class = implode(' ', $item_text_class);

            $t_custom_color = '';
            if (!empty($title_color)) {
                if ($title_color == 'custom') {
                    $t_custom_color = 'style="color:' . $title_custom_color . ';"';
                }
            }

            if ($is_col) $output .= '<div class="col-12 pb-4 grid-item ' . $item_class . '" data-category="transition">';
            $output .= '<div class="card w-100">';

            $attrs = array(
                'class'    => 'card-img img-fluid rounded-lg card-img-top overflow-hidden shadow-sm ' . $rounded_img,
                'loading' => 'lazy',
                'alt'    => get_the_title()
            );

            $imgSize = 'full';
            if (empty($full_size_img)) {
                $attrs['style']    = 'height:225px !important;width:100%;object-fit: cover;';
                $imgSize = 'pix-portfolio-small';
            }

            $full_image_url = wp_get_attachment_image(get_post_thumbnail_id(), $full_size_img, false, $attrs);
            $img_src = $full_image_url;

            $output .= '<a href="' . get_permalink() . '">';
            $output .= $img_src;
            $output .= '</a>';
            $output .= '<div class="d-flex">';
            $output .= '<div class="align-self-center card-content-box">';
            $output .= '<a class="text-' . $title_color . '" ' . $t_custom_color . ' href="' . get_permalink() . '">';
            $output .= '<h6 class="card-title text-' . $title_color . ' mb-2 mt-3 secondary-font"><strong>' . get_the_title() . '</strong></h6>';
            $output .= '</a>';
            $output .= '</div>';
            $output .= '</div>';


            $output .= '<div class="card-footer text-right d-flex align-items-end2 px-0 py-1 w-100 bg-transparent" style="line-height:0;">';
            $output .= '<div class="flex-fill text-left pix-badges-list">';
            $output .= $cats_str;
            $output .= '</div>';
            if (function_exists('get_pixfort_likes')) {
                $output .= '<div class="flex-fill justify-content-end d-flex align-items-center text-right">';
                $output .= get_pixfort_likes();
                $output .= '</div>';
            }
            $output .= '</div>';


            $output .= '</div>';
            if ($is_col) $output .= '</div>';
        }
        return $output;
    }
}

if (!function_exists('pix_portfolio_style_mini')) {
    function pix_portfolio_style_mini($query = false, $is_col = false, $attr = array()) {
        $output = '';
        extract(shortcode_atts(array(
            'line_count'         => '4',
            'rounded_img'         => 'rounded-lg',
            'full_size_img'         => '',
            'customCats'         => ''
        ), $attr));

        if ($query && $query->have_posts()) {
            $query->the_post();

            $item_class = array();
            $item_text_class = array();
            $categories = '';

            if (is_array($customCats) && array_key_exists(get_post_type(), $customCats)) {
                $terms = get_the_terms(get_the_ID(), $customCats[get_post_type()]);
            } else {
                $terms = get_the_terms(get_the_ID(), 'category');
            }
            if (is_array($terms)) {

                $cats_str = '';
                foreach ($terms as $term) {
                    $item_class[] = 'category-' . $term->slug;
                    $item_text_class[] = $term->slug;
                    $categories .= '<a href="' . site_url() . '/?portfolio-types=' . $term->slug . '">' . $term->name . '</a>, ';

                    $badge_attrs = array(
                        'text'    => $term->name,
                        'text_size'    => 'custom',
                        'text_custom_size'        => '14px',
                        'bold'  => 'font-weight-bold',
                        'custom_css'    => 'padding:5px 10px;line-height:14px;'
                    );
                    $cats_str .= '<a href="' . site_url() . '/?portfolio-types=' . $term->slug . '">';
                    $cats_str .= \PixfortCore::instance()->elementsManager->renderElement('Badge', $badge_attrs);
                    $cats_str .= '</a>';
                }
                $categories = substr($categories, 0, -2);
            }
            $item_class[] = get_post_meta(get_the_ID(), 'pix-post-size', true);
            $item_class[] = ' col-md-6 col-lg-' . $line_count;
            $item_class = implode(' ', $item_class);
            $item_text_class = implode(' ', $item_text_class);


            $attrs = array(
                'class'    => 'card-img-top img-fluid',
                'loading' => 'lazy',
                'alt'    => get_the_title()
            );
            $imgSize = 'full';
            if (empty($full_size_img)) {
                $attrs['style']    = 'height:225px !important;width:100%;object-fit: cover;';
                $imgSize = 'pix-portfolio-small';
            }

            $full_image_url = wp_get_attachment_image(get_post_thumbnail_id(), $full_size_img, false, $attrs);
            $img_src = $full_image_url;
            if ($is_col) $output .= '<div class="col-12 pb-4 grid-item ' . $item_class . '" data-category="transition">';
            $output .= '<a href="' . get_permalink() . '" class=" fly-sm">';
            $output .= '<div class="card pix-base-background ' . $rounded_img . ' overflow-hidden fly-sm shadow shadow-hover pix-mb-302 animate-in" data-anim-type="fade-in" data-anim-delay="200">';
            $output .= $img_src;
            $output .= '<div class="card-body">';
            $output .= '<div class="d-flex justify-content-between align-items-center">';
            $output .= '<h6 class="card-title mb-0 text-heading-default"><strong>' . get_the_title() . '</strong></h6>';
            $arrowIcon = is_rtl() ? 'Line/pixfort-icon-arrow-left-2' : 'Line/pixfort-icon-arrow-right-2';
            $output .= \PixfortCore::instance()->icons->getIcon($arrowIcon, 24, 'text-heading-default');
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</a>';

            if ($is_col) $output .= '</div>';
        }
        return $output;
    }
}

if (!function_exists('pix_portfolio_style_default')) {
    function pix_portfolio_style_default($query = false, $is_col = false, $attr = array()) {
        extract(shortcode_atts(array(
            'line_count'         => '4',
            'rounded_img'         => 'rounded-lg',
            'full_size_img'         => '',
            'customCats'         => ''
        ), $attr));
        $output = '';

        if ($query && $query->have_posts()) {
            $query->the_post();
            $item_class = array();
            $item_text_class = array();
            $categories = '';
            $cats_str = '';

            if (is_array($customCats) && array_key_exists(get_post_type(), $customCats)) {
                $terms = get_the_terms(get_the_ID(), $customCats[get_post_type()]);
            } elseif (get_post_type()==='portfolio') {
                $terms = get_the_terms(get_the_ID(), 'portfolio-types');
            } else {
                $terms = get_the_terms(get_the_ID(), 'category');
            }

            
            if (is_array($terms)) {
                foreach ($terms as $term) {
                    $item_class[] = 'category-' . $term->slug;
                    $item_text_class[] = $term->slug;
                    $categories .= '<a href="' . get_term_link($term, get_post_type()) . '">' . $term->name . '</a>, ';
                    $badge_attrs = array(
                        'text'    => $term->name,
                        'text_size'    => 'custom',
                        'text_custom_size'        => '14px',
                        'bold'  => 'font-weight-bold',
                        'custom_css'    => 'padding:5px 10px;line-height:14px;'
                    );
                    $cats_str .= '<a class="d-inline-block" href="' . get_term_link($term, get_post_type()) . '">';
                    $cats_str .= \PixfortCore::instance()->elementsManager->renderElement('Badge', $badge_attrs);
                    $cats_str .= '</a>';
                }
                $categories = substr($categories, 0, -2);
            }
            $item_class[] = get_post_meta(get_the_ID(), 'pix-post-size', true);
            $item_class[] = ' col-md-6 col-lg-' . $line_count;

            $item_class = implode(' ', $item_class);
            $item_text_class = implode(' ', $item_text_class);

            if ($is_col) $output .= '<div class="col-12 pb-4 grid-item ' . $item_class . '" data-category="transition">';
            $output .= '<div class="card pix-base-background ' . $rounded_img . ' overflow-hidden fly-sm shadow w-100 animate-in" data-anim-type="fade-in" data-anim-delay="200">';
            $attrs = array(
                'class'    => 'card-img img-fluid card-img-top rounded-0',
                // 'style'	=> 'height:225px !important;width:100%;object-fit: cover;',
                'loading' => 'lazy',
                'alt'    => get_the_title()
            );
            $imgSize = 'full';
            if (empty($full_size_img)) {
                $attrs['style']    = 'height:225px !important;width:100%;object-fit: cover;';
                $imgSize = 'pix-portfolio-small';
            }

            $full_image_url = wp_get_attachment_image(get_post_thumbnail_id(), $imgSize, false, $attrs);
            $output .= '<a href="' . get_permalink() . '">';
            // $img_src = $full_image_url;
            $output .= $full_image_url;
            $output .= '</a>';
            $output .= '<div class="pix-p-20">';
            $output .= '<div class="d-flex">';
            $output .= '<div class="align-self-center card-content-box">';
            $output .= '<a class="text-heading-default" href="' . get_permalink() . '">';
            $output .= '<h6 class="card-title mb-1 secondary-font"><strong>' . get_the_title() . '</strong></h6>';
            $output .= '</a>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '<div class="card-footer text-right d-flex align-items-end2 px-0 py-1 w-100 bg-transparent" style="line-height:0;">';
            $output .= '<div class="flex-fill text-left pix-badges-list">';
            $output .= $cats_str;
            $output .= '</div>';
            if (function_exists('get_pixfort_likes')) {
                $output .= '<div class="flex-fill justify-content-end d-flex align-items-center text-right">';
                $output .= get_pixfort_likes();
                $output .= '</div>';
            }
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            if ($is_col) $output .= '</div>';
        }
        return $output;
    }
}
