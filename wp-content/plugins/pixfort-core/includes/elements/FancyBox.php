<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* FancyBox
* --------------------------------------------------------------------------- */
class PixFancyBox {

	function render($attr, $content = null) {
        extract(shortcode_atts(array(
            'title'         => '',
            'text'         => '',
            'link'         => '',
            'target'         => '',
            'bg_img'         => '',
            'bg_img_dark'         => '',
            'alt'         => '',
            'position'      => 'bottom',
            'bold'        => 'font-weight-bold',
            'italic'        => '',
            'secondary_font'        => '',
            'title_color'        => '',
            'title_custom_color'        => '',
            'title_size'        => 'h2',
            'title_custom_size'        => '',
            'content_bold'        => '',
            'content_color'        => 'dark-opacity-5',
            'content_custom_color'        => '',
            'content_size'        => '',
            'overlay_color'        => 'light-opacity-8',
            'overlay_custom_color'        => '',
            'enable_blur'        => '',
            'animation'     => '',
            'delay'     => '0',
            'style'         => '',
            'hover_effect'         => '',
            'add_hover_effect'         => '',
            'css'   => ''
        ), $attr));

        $classes = array();
        $css_class = '';
        if (function_exists('vc_shortcode_custom_css_class')) {
            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
        }

        $el_classes = ' ';
        $el_classes .= esc_attr($css_class) . ' ';

        $el_classes .= \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);

        $anim_type = '';
        $anim_delay = '';
        if (!empty($animation)) {
            $anim_type = 'data-anim-type="' . $animation . '"';
            $anim_delay = 'data-anim-delay="' . $delay . '"';
            $el_classes .= ' animate-in';
        }



        $t_custom_color = '';
        if (!empty($title_color)) {
            if ($title_color != 'custom') {
                array_push($classes, 'text-' . $title_color);
            } else {
                $t_custom_color = 'color:' . $title_custom_color . ' !important;';
            }
        }

        if (!empty($bold)) array_push($classes, $bold);
        if (!empty($italic)) array_push($classes, $italic);
        if (!empty($secondary_font)) array_push($classes, $secondary_font);
        array_push($classes, 'mb-0');

        $title_tag = $title_size;
        $t_size_style = '';
        if ($title_size == 'custom') {
            $title_tag = "h2";
            $t_size_style = "font-size:" . $title_custom_size . ';';
        }

        $class_names = join(' ', $classes);
        $linkTarget = '';
        if (!empty($target)) {
            $linkTarget = 'target="_blank"';
        }

        $c_color = '';
        $c_custom_color = '';
        if (!empty($content_color)) {
            if ($content_color != 'custom') {
                $c_color = 'text-' . $content_color;
            } else {
                $c_custom_color = 'color:' . $content_custom_color . ' !important;';
            }
        }

        $output = '';

        $overlay_custom_style = '';
        if (!empty($overlay_color) && $overlay_color == 'custom') {
            $overlay_custom_style = 'style="--pix-bg-color:' . $overlay_custom_color . ';"';
        }


        $output .= '<div class="card mb-3 mb-sm-0 pix-info-card ' . $el_classes . '" ' . $anim_type . ' ' . $anim_delay . '>';
        $output .= '<div class="card-inner">';
        if(!empty($link)) {
            $output .= '<a href="' . $link . '" ' . $linkTarget . '>';
        }
        
        // Use getDynamicImage for the main image
        if ($bg_img) {
            $imageOutput = \PixfortCore::instance()->coreFunctions->getDynamicImage($bg_img, 'large', [
                'class' => 'card-img animating fade-in-Img',
                'alt' => $alt
            ], isset($bg_img_dark) ? $bg_img_dark : null);
            
            if (!empty($imageOutput)) {
                $output .= $imageOutput;
            }
        }
        if ($position == 'top') {
            $output .= '<div class="card-img-overlay p-0 animating fade-in-down">';
        } else {
            $output .= '<div class="card-img-overlay p-0 d-flex flex-column justify-content-end animating fade-in-up">';
        }

        $blurClass = '';
        if (!empty($enable_blur) || $enable_blur == 'yes') {
            $blurClass = 'pix-card-content-bg-blur';
        }
        $output .= '<div class="card-img-overlay-content card-content-box bg-' . $overlay_color . ' pix-p-20 ' . $blurClass . '" ' . $overlay_custom_style . '>';
        $output .= '<h6 class="card-text ' . $content_bold . ' ' . $c_color . ' ' . $content_size . ' animate-in" data-anim-type="fade-in" data-anim-delay="800" style="' . $c_custom_color . '">' . $text . '</h6>';
        $output .= '<' . $title_tag . ' class="' . $class_names . ' animate-in" data-anim-type="fade-in" data-anim-delay="400" style="' . $t_custom_color . $t_size_style . '">' . $title . '</' . $title_tag . '>';
        $output .= '</div>';
        $output .= '</div>';
        if(!empty($link)) {
            $output .= '</a>';
        }
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}
