<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Auto Video
* --------------------------------------------------------------------------- */
class PixTabsHText {

	function render($attr, $content = null) {
        extract(shortcode_atts(array(
            'el_id'    => '',
            'items'    => '',
            'is_fill'    => '',
            'position'    => 'justify-content-center',
            'tabs_style'    => 'pix-pills-1',
            'tabs_content_align'  => '',
            'animation'    => '',
            'delay'    => '0',
            'el_id'    => '',
            'el_class'    => '',
            'tabs_icon_position'         => '',
            'bold'                => '',
            'italic'            => '',
            'secondary_font'    => '',
            'title_color'    => '',
            'title_custom_color'    => '',
            'css'    => '',
        ), $attr));

        $css_class = '';

        $output = '';
        $menu = '';
        $tabs = '';
        $lines_class = '';
        if ($tabs_style == 'pix-pills-lines') {
            $lines_class = 'd-flex';
        }
        $menu .= '<div class="nav ' . $lines_class . ' nav-pills pix_tabs_btns ' . $position . ' ' . $is_fill . ' ' . $tabs_style . ' mb-4" role="tablist" id="v-pills-tab"  aria-orientation="horizontal">';

        if ($tabs_style == 'pix-pills-lines') {
            $menu .= '<div class="nav-item2 d-none d-sm-block flex-fill align-self-center pix-mr-20">';
            $menu .= '<span class="w-100 pix-tabs-line"></span>';
            $menu .= '</div>';
        }


        $tabs .= '<div class="pix_tabs_content">';
        $tabs .= '<div class="tab-content ' . $tabs_content_align . '">';
        $active = 'active';

        foreach ($items as $item) {
            extract(shortcode_atts(array(
                'title'     => '',
                'icon'     => '',
                'content_type'         => '',
                'content'         => '',
                'pix_template_id'            => '',
                'transition'        => '',
                'el_class'            => '',
            ), $item));

            $tab_id = wp_rand(0, 10000000);
            if (!empty($item['_id'])) {
                $tab_id = $el_id . '-' .  $item['_id'];
            }
            // if(!empty($el_id)){
            //     $tab_id = $el_id.'-'.$tab_id;
            // }

            $icon_html = '';
            if (!empty($icon)) {
                if ($tabs_icon_position == 'top') {
                    $icon_html .= \PixfortCore::instance()->icons->getIcon($icon, 24, 'w-100 d-inline-flex align-items-center text-center mt-2');
                } else {
                    $margin2 = is_rtl() ? 'ml-2' : 'mr-2';
                    $icon_html .= \PixfortCore::instance()->icons->getIcon($icon, 24, $margin2);
                }
            }
            $menu .= '<div class="nav-item">';
            if ($tabs_icon_position == 'top') {
                $menu .= '<a class="nav-link pix-tabs-btn text-24 pix-px-25 py-2 my-2 font-weight-bold '.$active.' ' . $bold . ' ' . $italic . ' ' . $secondary_font . '" data-id="' . $tab_id . '" role="tab" id="pix-tab-btn-' . $tab_id . '" data-toggle="pill" href="#pix-tab-' . $tab_id . '"  aria-controls="pix-tab-' . $tab_id . '">' . $icon_html . do_shortcode($title) . '</a>';
            } else {
                $menu .= '<a class="nav-link pix-tabs-btn text-24 pix-px-25 py-2 my-2 d-flex align-items-center justify-content-center font-weight-bold '.$active.' ' . $bold . ' ' . $italic . ' ' . $secondary_font . '" data-id="' . $tab_id . '" role="tab" id="pix-tab-btn-' . $tab_id . '" data-toggle="pill" href="#pix-tab-' . $tab_id . '"  aria-controls="pix-tab-' . $tab_id . '">' . $icon_html . do_shortcode($title) . '</a>';
            }
            $menu .= '</div>';

            $tabs .= '<div class="tab-pane '.$active.' ' . $transition . ' show ' . $el_class . '" role="tabpanel" id="pix-tab-' . $tab_id . '" data-bold="' . $bold . '" data-italic="' . $italic . '" data-secondary="' . $secondary_font . '" data-id="' . $tab_id . '" data-icon="' . $icon . '" data-title="' . $title . '" aria-labelledby="pix-tab-' . $tab_id . '">';
            $active = '';
            if (!empty($content_type) && $content_type === 'template') {
                if (!empty($pix_template_id)) {
                    if (class_exists('\Elementor\Plugin')) {
                        $pix_template_id = apply_filters('wpml_object_id', $pix_template_id, 'page', true);
                        $tabs .= \Elementor\plugin::instance()->frontend->get_builder_content_for_display($pix_template_id);
                    }
                }
            } else {
                $tabs .= do_shortcode($content);
            }
            $tabs .= '</div>';
        }
        if ($tabs_style == 'pix-pills-lines') {
            $menu .= '<div class="nav-item2 d-none d-sm-block pix-tab-line flex-fill align-self-center pix-ml-20">';
            $menu .= '<span class="w-100 pix-tabs-line"></span>';
            $menu .= '</div>';
        }
        $menu .= '</div>';


        $tabs .= '</div>';
        $tabs .= '</div>';

        $anim_type = '';
        $anim_delay = '';
        if (!empty($animation)) {
            $css_class .= ' animate-in';
            $anim_type = 'data-anim-type="' . $animation . '"';
            $anim_delay = 'data-anim-delay="' . $delay . '"';
        }

        // Final output
        $output .= '<div class=" ' . $css_class . '" ' . $anim_type . ' ' . $anim_delay . '>';
        $output .= '<div class="pix_tabs_container pix-waiting" data-icons-pos="' . $tabs_icon_position . '">';
        $output .= $menu;
        $output .= $tabs;
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}

