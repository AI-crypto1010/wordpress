<?php

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class PixAccordionTab {

    function render($attr, $content = null) {
        /* ---------------------------------------------------------------------------
        * Accordion tab [pix_accordion_tab][/pix_accordion_tab]
        * --------------------------------------------------------------------------- */
        extract(shortcode_atts(array(
            'title'             => 'Accordion Title',
            'bold'                 => '',
            'italic'             => '',
            'secondary_font'     => '',
            'title_color'         => 'heading-default',
            'title_custom_color' => '',
            'media_type'         => '',
            'icon'                 => '',
            'icon_color'         => 'primary',
            'custom_icon_color' => '',
            'pix_duo_icon'         => '',
            'bg_color'             => 'white',
            'custom_bg_color'     => '',
            'shadow'             => '1',
            'rounded_corners'     => 'rounded-lg',
            'transition'         => '',
            'el_class'             => '',
            'tab_id'             => '',
            'is_open'             => '',
            'css'               => '',
        ), $attr));

        $css_class = '';
        if (function_exists('vc_shortcode_custom_css_class')) {
            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
        }
        $output = '';
        $icon_out = '';
        if (!empty($media_type)) {
            if (!empty($media_type) && $media_type === "duo_icon") {
                $icon = $pix_duo_icon;
            }
            $icon_style = '';
            if (!empty($custom_icon_color)) {
                $icon_style = 'style="color:' . $custom_icon_color . ';"';
            }
            $icon_out = '<span class="d-inline-block text-' . $icon_color . ' svg-20 pix-mr-10" ' . $icon_style . '>';
            $icon_out .= \PixfortCore::instance()->icons->getIcon($icon);
            $icon_out .= '</span>';
        }
        $title_classes = pix_get_text_format_classes($bold, $italic, $secondary_font);
        $title_classes .= ' text-' . $title_color;
        $title_style = '';
        if (!empty($title_custom_color)) {
            $title_style = 'style="color:' . $title_custom_color . '"';
        }
        $tab_title_style = '';
        if ($bg_color == 'custom' && !empty($custom_bg_color)) {
            $tab_title_style = 'style="background:' . $custom_bg_color . '"';
        }

        $shadowClass = 'shadow-sm';
        $shadow_map = array(
            '0' => 'shadow-none',
            '1' => 'shadow-sm',
            '2' => 'shadow',
            '3' => 'shadow-lg',
        );
        if (isset($shadow_map[$shadow])) {
            $shadowClass = $shadow_map[$shadow];
        }

        $roundedClass = 'rounded-lg';
        $rounded_map = array(
            'rounded-0',
            'rounded',
            'rounded-lg',
            'rounded-xl',
            'rounded-10',
        );
        if (in_array($rounded_corners, $rounded_map, true)) {
            $roundedClass = $rounded_corners;
        }

        $show = '';
        if (!empty($is_open)) {
            $show = 'show';
        }
        $output .= '<div class="card ' . $el_class . '">
   <div class="card-header bg-' . $bg_color . ' pix-mb-10 ' . $shadowClass . ' ' . $roundedClass . '" id="heading' . $tab_id . '">
       <button class="btn btn-link text-left ' . $roundedClass . ' bg-' . $bg_color . '" type="button" data-toggle="collapse" data-target="#collapse' . $tab_id . '" aria-expanded="true" aria-controls="collapse' . $tab_id . '" ' . $tab_title_style . '>' . $icon_out . '<span class="' . $title_classes . '" ' . $title_style . '>' . $title . '</span></button>
   </div>
   <div id="collapse' . $tab_id . '" class="collapse ' . $show . ' ' . $css_class . '" aria-labelledby="heading' . $tab_id . '">
     <div class="card-body">
         ' . do_shortcode($content) . '
     </div>
   </div>
 </div>';

        return $output;
    }
}
