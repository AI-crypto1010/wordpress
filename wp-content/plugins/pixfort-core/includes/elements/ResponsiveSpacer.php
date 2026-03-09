<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Responsive spacer 
* --------------------------------------------------------------------------- */
class PixResponsiveSpacer {

    function render($attr, $content = null) {

        extract(shortcode_atts(array(
            'height'  => '',
            'height_tablet'  => '',
            'height_mobile'  => '',
            'element_id'  => '',
            'el_class'  => '',
            'css'         => '',
        ), $attr));
        $css_class = 'w-100 d-block ';
        if (function_exists('vc_shortcode_custom_css_class')) {
            $css_class .= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
        }
        if (empty($element_id)) {
            $element_id = 'spacer-' . rand(1, 200000000);
        } else {
            if (is_numeric($element_id[0])) {
                $element_id = 'el' . $element_id;
            }
        }
        $style = '';
        if (!empty($height)) {
            $style .= '#' . $element_id . ' { height: ' . $height . ' !important; } ';
        }
        if (!empty($height_tablet)) {
            $style .= '@media (max-width: 920px) {';
            $style .= '#' . $element_id . ' { height: ' . $height_tablet . ' !important; }';
            $style .= '}';
        }
        if (!empty($height_mobile)) {
            $style .= '@media (max-width: 576px) {';
            $style .= '#' . $element_id . ' { height: ' . $height_mobile . ' !important; }';
            $style .= '}';
        }
        wp_register_style('pix-spacer-handle', false);
        wp_enqueue_style('pix-spacer-handle');
        wp_add_inline_style('pix-spacer-handle', $style);
        $output = '<div id="' . $element_id . '" class="' . $css_class . '"></div>';

        return $output;
    }
}
