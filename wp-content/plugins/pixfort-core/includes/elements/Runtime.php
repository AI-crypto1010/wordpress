<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Runtime
* --------------------------------------------------------------------------- */
class PixRuntime {

    function render($attr, $content = null) {
        extract(shortcode_atts(array(
            'runtime_file'     => '',
            'runtime_file_url'     => '',
            'runtime_state'     => '',
            'link'     => '',
            'aria_label'     => '',
            'width'     => '500',
            'height'     => '500'
        ), $attr));

        $output = '';
        $width = filter_var($width, FILTER_SANITIZE_NUMBER_INT);
        $height = filter_var($height, FILTER_SANITIZE_NUMBER_INT);

        if(!empty($link)&&!empty($link['url'])){
            $target = '';
            if(!empty($link['is_external'])) $target = 'target="_blank"';
            $output .= '<a href="'.$link['url'].'" '.$target.' aria-label="'.$aria_label.'">';
        }
        if (!empty($runtime_file) && !empty($runtime_file['url'])) {
            $output .= '<canvas class="pix-runtime-canvas" data-runtime-state="' . $runtime_state . '" width="' . $width . '" height="' . $height . '" data-runtime-url="' . $runtime_file['url'] . '"></canvas>';
        } else {
            if (!empty($runtime_file_url)) {
                $output .= '<canvas class="pix-runtime-canvas" data-runtime-state="' . $runtime_state . '" width="' . $width . '" height="' . $height . '" data-runtime-url="' . $runtime_file_url . '"></canvas>';
            }
        }
        if(!empty($link)&&!empty($link['url'])){
            $output .= '</a>';
        }
        return $output;
    }
}
