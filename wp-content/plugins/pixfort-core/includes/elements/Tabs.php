<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Tabs
* --------------------------------------------------------------------------- */
class PixTabs {

    function render($attr, $content = null) {
        extract(shortcode_atts(array(
            'is_fill'    => '',
            'position'    => 'justify-content-center',
            'tabs_style'    => 'pix-pills-1',
            'tabs_content_align'  => '',
            'animation'    => '',
            'delay'    => '0',
            'el_class'    => '',
            'tabs_icon_position'         => '',
            'tabs_custom_colors'         => '',
            'tabs_active_custom_colors'         => '',
            'tabs_active_custom_bg'         => '',
            'element_id'         => '',
            'css'    => '',
        ), $attr));

        $css_class = '';
        if (function_exists('vc_shortcode_custom_css_class')) {
            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
        }

        if (empty($element_id)) {
            $element_id = "pix-element-" . wp_rand(0, 10000000);
        } else {
            $element_id = 'pix-el-' . $element_id;
        }
        $customStyle = '';
        if (!empty($tabs_custom_colors)) $customStyle .= '#' . $element_id . ' .nav-item a:not(.active){ color: ' . $tabs_custom_colors . ';}';
        if (!empty($tabs_active_custom_colors)) $customStyle .= '#' . $element_id . ' .nav-item a.active{ color: ' . $tabs_active_custom_colors . ';}';
        if (!empty($tabs_active_custom_bg)) $customStyle .= '#' . $element_id . ' .nav-item a.active{ background: ' . $tabs_active_custom_bg . ';}';
        if (!empty($customStyle)) {
            wp_register_style('pix-tabs-handle', false);
            wp_enqueue_style('pix-tabs-handle');
            wp_add_inline_style('pix-tabs-handle', $customStyle);
        }


        $output = '';

        $pattern = get_shortcode_regex();
        preg_match_all('/\[pix_content_tab(.*?)\](.*?)\[\/pix_content_tab(.*?)\]/s', $content, $sc_matches);

        if (isset($sc_matches[0])) {
            $inner_scs = $sc_matches[0];
        }
        $reg = get_shortcode_regex();
        $attrs = array();
        $i = 0;
        foreach ($inner_scs as $tab) {
            preg_match_all('/pix_content_tab([^\]]+)/i', $tab, $matches4, PREG_OFFSET_CAPTURE);
            $tab_titles2 = array();
            $tab_titles2 = $matches4[1];
            $tabs_nav = array();
            foreach ($tab_titles2 as $pix_sc) {
                $attrs[$i] = shortcode_parse_atts($pix_sc[0]);
            }
            // The content
            preg_match_all('~' . $reg . '~', $tab, $the_inner);
            $attrs[$i]['pix_content'] = $the_inner[5][0];
            $i++;
        }

        $animate_class = '';
        if (!empty($animation)) {
            $animate_class = 'animate-in';
        }

        /* Set first tab as active */
        $pattern = '/\[pix_content_tab /';
        // Replacement string with the active_class attribute added
        $replacement = '[pix_content_tab active_class="active" ';
        // Perform the replacement
        $content = preg_replace($pattern, $replacement, $content, 1);

        $tabs = '';
        $tabs .= '<div class="pix_tabs_content ' . $animate_class . '" data-anim-type="' . $animation . '" data-anim-delay="' . $delay . '">';
        $tabs .= '<div class="tab-content ' . $tabs_content_align . '">';
        $tabs .= do_shortcode($content);
        $tabs .= '</div>';
        $tabs .= '</div>';

        $menu = '';
        $active = 'active';
        $lines_class = '';
        if ($tabs_style == 'pix-pills-lines') {
            $lines_class = 'd-flex';
        }
        $menu .= '<div class="nav ' . $lines_class . ' nav-pills pix_tabs_btns ' . $position . ' ' . $is_fill . ' ' . $tabs_style . ' mb-4 ' . $animate_class . '" data-anim-type="' . $animation . '" role="tablist" data-anim-delay="' . $delay . '" id="v-pills-tab"  aria-orientation="horizontal">';

        if ($tabs_style == 'pix-pills-lines') {
            $menu .= '<div class="nav-item2 d-none d-sm-block flex-fill align-self-center pix-mr-20">';
            $menu .= '<span class="w-100 pix-tabs-line"></span>';
            $menu .= '</div>';
        }
        foreach ($attrs as $key => $item) {
            $title = $item['tab_id'];
            if (!empty($item['title'])) {
                $title = $item['title'];
            }
            $bold = '';
            if (!empty($item['bold'])) {
                $bold = 'font-weight-bold';
            }
            $icon_html = '';
            if (!empty($item['icon'])) {
                if ($tabs_icon_position == 'top') {
                    $icon_html .= \PixfortCore::instance()->icons->getIcon($item['icon'], 24, 'w-100 d-block text-center mt-2');
                } else {
                    $icon_html .= \PixfortCore::instance()->icons->getIcon($item['icon'], 24, 'mr-1 mr-md-2');
                }
            }
            $menu .= '<div class="nav-item">';
            if ($tabs_icon_position == 'top') {
                $menu .= '<a class="nav-link pix-tabs-btn text-24 pix-px-25 py-1 py-md-2 my-2 ' . $active . ' ' . $bold . '" data-id="' . $item['tab_id'] . '" role="tab" id="pix-tab-btn-' . $item['tab_id'] . '" data-toggle="pill" href="#pix-tab-' . $item['tab_id'] . '"  aria-controls="pix-tab-' . $item['tab_id'] . '">' . $icon_html . $title . '</a>';
            } else {
                $menu .= '<a class="nav-link pix-tabs-btn text-24 pix-px-25 py-1 py-md-2 my-2 ' . $active . ' ' . $bold . '" data-id="' . $item['tab_id'] . '" role="tab" id="pix-tab-btn-' . $item['tab_id'] . '" data-toggle="pill" href="#pix-tab-' . $item['tab_id'] . '"  aria-controls="pix-tab-' . $item['tab_id'] . '"><span class="d-inline-flex align-items-center">' . $icon_html . $title . '</span></a>';
            }
            $active = '';

            $menu .= '</div>';
        }
        if ($tabs_style == 'pix-pills-lines') {
            $menu .= '<div class="nav-item2 d-none d-sm-block pix-tab-line flex-fill align-self-center pix-ml-20">';
            $menu .= '<span class="w-100 pix-tabs-line"></span>';
            $menu .= '</div>';
        }
        $menu .= '</div>';

        // Final output
        $output .= '<div id="' . $element_id . '" class=" ' . $css_class . '">';
        $output .= '<div class="pix_tabs_container pix-waiting" data-icons-pos="' . $tabs_icon_position . '">';
        $output .= $menu;
        $output .= $tabs;
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}
