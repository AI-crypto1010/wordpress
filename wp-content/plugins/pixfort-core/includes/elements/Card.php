<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Card
* --------------------------------------------------------------------------- */
class PixCard {

    function render($attr, $content = null) {
        extract(shortcode_atts(array(
            'title'                 => '',
            'text'                  => '',
            'image'                 => '',
            'image_dark'            => '',
            'link_text'             => '',
            'link'                  => '',
            'target'                => '',
            'layout'                => 'small',
            'feature_image'         => '',
            'style'                 => '',
            'hover_effect'          => '',
            'add_hover_effect'      => '',
            'animation'             => '',
            'delay'                 => '0',
            'css'                   => '',
            'bold'                  => 'font-weight-bold',
            'italic'                => '',
            'secondary_font'        => '',
            'color'                 => 'heading-default',
            'custom_color'          => '',
            'title_size'            => 'h6',
            'title_custom_size'     => '',
            'text_bold'             => '',
            'text_italic'           => '',
            'text_secondary_font'   => '',
            'text_color'            => 'body-default',
            'text_custom_color'     => '',
            'text_size'             => '',
            'link_bold'             => 'font-weight-bold',
            'link_italic'           => '',
            'link_secondary_font'   => '',
            'link_color'            => 'heading-default',
            'link_custom_color'     => '',
            'link_size'             => '',
            'rounded_img'           => 'rounded-lg',
            'explicit_width_height' => '',
            'extra_classes'         => '',
            'nofollow'              => '',
            'link_atts'             => '',
        ), $attr));

        $css_class = '';
        if (function_exists('vc_shortcode_custom_css_class')) {
            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
            $title = pix_unescape_vc($title);
            $text = pix_unescape_vc($text);
            $link_text = pix_unescape_vc($link_text);
        }

        $custom_link_atts = '';
        if (!empty($link_atts)) {
            $l_atts = explode(",", $link_atts);
            foreach ($l_atts as $key => $value) {
                $l_att = explode("|", $value);
                $custom_link_atts .= $l_att[0] . '="' . $l_att[1] . '" ';
            }
        }
        if (!empty($nofollow) && $nofollow) {
            $custom_link_atts .= 'rel="nofollow"';
        }


        $css_class .= ' ' . $extra_classes;
        $classes = ' ';
        $classes .= esc_attr($css_class) . ' ';
        $classes .= esc_attr($rounded_img) . ' ';
        $classes .= ' overflow-hidden ';

        $title_classes = pix_get_text_format_classes($bold, $italic, $secondary_font, $color);
        $icon_classes = pix_get_text_format_classes($bold, $italic, false, $color);
        $text_classes = pix_get_text_format_classes($text_bold, $text_italic, $text_secondary_font, $text_color);
        $link_classes = pix_get_text_format_classes($link_bold, $link_italic, $link_secondary_font, $link_color);

        $text_classes .= ' ' . $text_size;
        $link_classes .= ' ' . $link_size;

        $title_style = '';
        $text_style = '';
        $link_style = '';

        $linkTarget = '';
        if (!empty($target)) {
            $linkTarget = 'target="_blank"';
        }
        if ($color == 'custom') {
            $title_style = 'color:' . $custom_color . ';';
        }
        if ($text_color == 'custom') {
            $text_style = 'style="color:' . $text_custom_color . ';"';
        }
        if ($link_color == 'custom') {
            $link_style = 'style="color:' . $link_custom_color . ';"';
        }
        $title_tag = 'div';
        if (!empty($title_size)) {
            if ($title_size == 'custom') {
                $title_style .= 'font-size:' . $title_custom_size . ';';
            } else {
                // $title_tag = $title_size;
                $title_classes .= ' ' . $title_size . ' heading-font';
            }
        }
        $title_style = 'style="' . $title_style . '"';

        $classes .= \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);

        $anim_attrs = '';
        if (!empty($animation)) {
            $classes .= ' animate-in ';
            $anim_attrs = 'data-anim-delay="' . $delay . '" data-anim-type="' . $animation . '"';
        }

        $output = '';
        // Define the icon based on text direction
        $icon_direction = is_rtl() ? 'left-2' : 'right-2';
        $icon_name = 'Line/pixfort-icon-arrow-' . $icon_direction;

        if ($layout == 'small') {
            $output .= '<a ' . $linkTarget . ' ' . $custom_link_atts . ' href="' . $link . '" class=" fly">';
            $output .= '<div class="card ' . $classes . '" ' . $anim_attrs . '>';
            if (!empty($image)) {
                $imageOutput = \PixfortCore::instance()->coreFunctions->getDynamicImage($image, 'full', [
                    'class' => 'w-100',
                    'alt' => $title,
                ], isset($image_dark) ? $image_dark : null);
                if (!empty($imageOutput)) {
                    // if (empty($explicit_width_height)) {
                    //     $imageOutput = preg_replace('/\s(?:width|height)="[^"]*"/', '', $imageOutput);
                    // }
                    $output .= $imageOutput;
                }
            }
            $output .= '<div class="pix-card-content bg-white">';
            $output .= '<div class="card-body">';
            $output .= '<div class="d-flex justify-content-between align-items-center ' . $title_classes . '">';
            $output .= '<' . $title_tag . ' ' . $title_style . ' class="card-title mb-0 ' . $title_classes . '">' . do_shortcode($title)  . '</' . $title_tag . '>';
            $output .= '<' . $title_tag . ' ' . $title_style . ' class="' . $icon_classes . '">';
            $output .= \PixfortCore::instance()->icons->getIcon($icon_name);
            $output .= '</' . $title_tag . '>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</a>';
        }

        if ($layout == 'big_padding') {
            $output .= '<div class="pix-content-box pix-card-element pix-card-content bg-white p-4 rounded-xl ' . $classes . '" ' . $anim_attrs . '>';
            if (!empty($image)) {
                $imageOutput = \PixfortCore::instance()->coreFunctions->getDynamicImage($image, 'full', [
                    'class' => 'img-fluid ' . $rounded_img,
                    'alt' => $title,
                ], isset($image_dark) ? $image_dark : null);
                // if (!empty($imageOutput) && empty($explicit_width_height)) {
                //     $imageOutput = preg_replace('/\s(?:width|height)="[^"]*"/', '', $imageOutput);
                // }
                if (!empty($link)) {
                    $output .= '<a ' . $linkTarget . ' ' . $custom_link_atts . ' href="' . $link . '">';
                }
                if (!empty($imageOutput)) {
                    $output .= $imageOutput;
                }

                if (!empty($link)) {
                    $output .= '</a>';
                }
            }
            $output .= '<div class="py-3">';
            $output .= '<' . $title_tag . ' ' . $title_style . ' class="card-title ' . $title_classes . '">' . do_shortcode($title)  . '</' . $title_tag . '>';
            $output .= '<p class="card-text ' . $text_classes . '" ' . $text_style . '>' . do_shortcode($text) . '</p>';
            $output .= '</div>';
            $output .= '<div class="card-footer text-right">';
            $output .= '<a ' . $linkTarget . ' ' . $custom_link_atts . ' href="' . $link . '" ' . $link_style . ' class="pix-card-link d-flex align-items-center justify-content-end ' . $link_classes . '"><span class="d-inline-block">' . do_shortcode($link_text) . '</span> ' . \PixfortCore::instance()->icons->getIcon($icon_name, 24, 'ml-1') . '</a>';
            $output .= '</div>';
            $output .= '</div>';
        }
        if ($layout == 'big') {
            $output .= '<div class="card pix-content-box pix-card-element bg-white2 rounded-xl ' . $classes . '" ' . $anim_attrs . '>';
            if (!empty($image)) {
                $imageOutput = \PixfortCore::instance()->coreFunctions->getDynamicImage($image, 'full', [
                    'class' => 'w-100',
                    'alt' => $title,
                ], isset($image_dark) ? $image_dark : null);
                // if (!empty($imageOutput) && empty($explicit_width_height)) {
                //     $imageOutput = preg_replace('/\s(?:width|height)="[^"]*"/', '', $imageOutput);
                // }
                if (!empty($link)) {
                    $output .= '<a ' . $linkTarget . ' ' . $custom_link_atts . ' href="' . $link . '">';
                }
                if (!empty($imageOutput)) {
                    $output .= $imageOutput;
                }
                if (!empty($link)) {
                    $output .= '</a>';
                }
            }
            $output .= '<div class="pix-card-content bg-white">';
            $output .= '<div class="card-body py-3">';
            $output .= '<' . $title_tag . ' ' . $title_style . ' class="card-title ' . $title_classes . '">' . do_shortcode($title) . '</' . $title_tag . '>';
            $output .= '<p class="card-text ' . $text_classes . '" ' . $text_style . '>' . do_shortcode($text) . '</p>';
            $output .= '</div>';
            $output .= '<div class="card-footer text-right">';
            $output .= '<a ' . $linkTarget . ' ' . $custom_link_atts . ' href="' . $link . '" ' . $link_style . ' class="pix-card-link d-flex align-items-center justify-content-end ' . $link_classes . '"><span class="d-inline-block">' . do_shortcode($link_text) . '</span>' . \PixfortCore::instance()->icons->getIcon($icon_name, 24, 'ml-1') . '</a>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
        }

        return $output;
    }
}
