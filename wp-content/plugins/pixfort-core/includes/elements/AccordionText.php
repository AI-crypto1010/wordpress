<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Accordion text
* --------------------------------------------------------------------------- */
class PixAccordionText {
    function render($attr, $content = null) {
        extract(shortcode_atts(array(
            'items'         => '',
            'bold'         => '',
            'italic'         => '',
            'secondary_font'         => '',
            'title_color'         => 'heading-default',
            'title_custom_color'         => '',
            'icon_color'         => 'primary',
            'custom_icon_color'         => '',
            'transition'         => '',
            'bg_color'         => 'white',
            'custom_bg_color'         => '',
            'shadow'         => '1',
            'rounded_corners'         => 'rounded-lg',
            'animation'    => '',
            'delay'    => '0',
            'element_id'    => false
        ), $attr));

        $output = '';
        $shadowClass = 'shadow-sm';
        $style_arr = array(
            "0"         => "shadow-none",
            "1"       => "shadow-sm",
            "2"       => "shadow",
            "3"       => "shadow-lg",
        );
        if (!empty($style_arr[$shadow])) {
            $shadowClass = $style_arr[$shadow];
        }
        $title_classes = pix_get_text_format_classes($bold, $italic, $secondary_font);
        $title_classes .= ' text-' . $title_color;
        $title_style = '';
        if (!empty($title_custom_color)) {
            $title_style = 'style="color:' . $title_custom_color . '"';
        }
        $tab_title_style = '';
        if ($bg_color == 'custom' && !empty($custom_bg_color)) {
            $tab_title_style = 'style="background:' . $custom_bg_color . ' !important"';
        }
        if (empty($element_id)) {
            $element_id = 'accordion-' . hash('md5', $content);
        }
        $output .= '<div class="accordion w-100 accordion-card" id="accordion-' . $element_id . '">';
        foreach ($items as $item) {
            extract(shortcode_atts(array(
                'title'     => '',
                'media_type'         => '',
                'pix_duo_icon'     => '',
                'icon'     => '',
                'content_type'         => '',
                'content'         => '',
                'pix_template_id'            => '',
                'is_open'    => '',
                'tab_id'         => '',
                '_id'         => '',
            ), $item));
            $tab_id = "pix-tab-" . $element_id . '-' . $_id;
            if (empty($_id)) $tab_id = "pix-tab-" . wp_rand(0, 10000000);
            $icon_out = '';

            if (!empty($media_type) && $media_type === "duo_icon") {
                $icon = $pix_duo_icon;
            }
            $margin10 = is_rtl() ? 'pix-ml-10' : 'pix-mr-10';
            $icon_out .= '<span class="d-inline-flex align-self-center text-' . $icon_color . ' svg-202 text-20 ' . $margin10 . '">';
            $icon_out .= \PixfortCore::instance()->icons->getIcon($icon);
            $icon_out .= '</span>';


            $show = '';
            if (!empty($is_open)) {
                $show = 'show';
            }

            $output .= '<div class="card">
               <div class="card-header ' . $shadowClass . ' ' . $rounded_corners . ' bg-' . $bg_color . '" id="heading' . $tab_id . '" ' . $tab_title_style . '>
                   <button class="btn btn-link d-flex text-left" type="button" data-toggle="collapse" data-target="#collapse' . $tab_id . '" aria-expanded="true" aria-controls="collapse' . $tab_id . '">' . $icon_out . '<span class="d-inline-flex ' . $title_classes . '" ' . $title_style . '>' . $title . '</span></button>
               </div>

               <div id="collapse' . $tab_id . '" class="collapse ' . $show . '" aria-labelledby="heading' . $tab_id . '">
                 <div class="card-body">';
            if (!empty($content_type) && $content_type === 'template') {
                if (!empty($pix_template_id)) {
                    if (class_exists('\Elementor\Plugin')) {
                        $output .= \Elementor\plugin::instance()->frontend->get_builder_content_for_display($pix_template_id);
                    }
                }
            } else {
                $output .= do_shortcode($content);
            }
            $output .= '</div>
               </div>
             </div>';
        }
        $output .= '</div>';
        return $output;
    }
}
