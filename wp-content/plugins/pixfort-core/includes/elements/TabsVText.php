<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* TabsVText
* --------------------------------------------------------------------------- */
class PixTabsVText {

    function render($attr, $content = null) {
        extract(shortcode_atts(array(
            'el_id'    => '',
            'items'    => '',
            'badge_text'         => '',
            'badge_bold'         => 'font-weight-normal',
            'badge_italic'         => '',
            'badge_secondary_font'         => '',
            'badge_text_color'         => 'primary',
            'badge_text_custom_color'         => '',
            'badge_bg_color'         => 'primary-light',
            'badge_custom_bg_color'         => '',
            'badge_text_size'         => 'h5',
            'badge_text_custom_size'         => '',
            'badge_css'         => '',
            'title'        => '',
            'bold'        => 'font-weight-bold',
            'italic'        => '',
            'secondary_font'        => '',
            'title_color'        => '',
            'title_custom_color'        => '',
            'title_size'        => 'h1',
            'title_custom_size'        => '',
            'text_content'        => '',
            'content_color'        => 'primary',
            'content_custom_color'        => '',
            'content_size'        => '',
            'h1'        => '',
            'icon'         => '',
            'slogan'     => '',
            'style'     => '',    // icon, line, arrows
            'position'  => 'text-left',
            'padding_title'            => '',
            'padding_content'        => '',
            'padding_menu'        => '20px',
            'is_sticky'  => '',
            'menu_position'  => 'left',
            'tabs_style'  => 'pix-pills-1',
            'tabs_content_align'  => '',
            'style'         => '',
            'hover_effect'         => '',
            'add_hover_effect'         => '',
            'text_color'         => '',
            'rounded_box'         => '',
            'pix_particles_check' => '',
            'pix_particles' => '',
            'particles_top_index' => '',
            'animation'        => '',
            'delay'        => '0',
            'css' => '',
            'overflow'         => '',
            'el_class'         => '',
            'tabs_title'        => '',
            'tabs_bold'        => '',
            'tabs_italic'        => '',
            'tabs_secondary_font'        => '',
            'is_fill'    => '',
            'position'    => 'justify-content-center',
            'tabs_style'    => 'pix-pills-1',
            'tabs_content_align'  => '',
            'menu_position'  => '',
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
        $badge_attr = array(
            'text'        => $badge_text,
            'bold'  => $badge_bold,
            'italic'  => $badge_italic,
            'secondary_font'  => $badge_secondary_font,
            'text_color'        => $badge_text_color,
            'text_custom_color'        => $badge_text_custom_color,
            'text_size'        => $badge_text_size,
            'text_custom_size'        => $badge_text_custom_size,
            'css'        => $badge_css,
            'bg_color'        => $badge_bg_color,
            'custom_bg_color'        => $badge_custom_bg_color,
            'animation'     => '',
            'delay'     => '0',
        );
        $heading_attr = array_merge(
            $attr,
            array(
                'content'        => $text_content,
            )
        );

        $menu = '';
        $tabs = '';
        $menu .= '<div class="col-12 col-md-4 d-inline-block">';
        $menu .= '<div class="' . $is_sticky . '" style="top:110px;">';
        if (!empty($badge_text)) {
            $menu .= '<div class="' . $position . '">';
            $menu .= \PixfortCore::instance()->elementsManager->renderElement('Badge', $badge_attr);
            $menu .= '</div>';
        }
        $menu .= \PixfortCore::instance()->elementsManager->renderElement('Heading', $heading_attr, $text_content);

        $padding = '';
        if (!empty($padding_menu)) {
            $padding = 'style="padding-top:' . $padding_menu . ';"';
        }
        $menu .= '<div class="nav pix_tabs_btns ' . $position . ' flex-column nav-pills ' . $tabs_style . '" role="tablist" id="v-pills-tab"  aria-orientation="vertical" ' . $padding . '>';


        if ($tabs_style == 'pix-pills-lines') {
            $menu .= '<div class="d-none d-sm-block flex-fill align-self-center pix-mr-20">';
            $menu .= '<span class="w-100 pix-tabs-line"></span>';
            $menu .= '</div>';
        }

        $tabs .= '<div class="col-12 col-md-8 d-inline-block">';
        $tabs .= '<div class="pix_tabs_content">';
        $tabs .= '<div class="tab-content ' . $tabs_content_align . '">';

        $active = 'active';

        foreach ($items as $item) {
            extract(shortcode_atts(array(
                'title'             => '',
                'icon'              => '',
                'content_type'      => '',
                'content'           => '',
                'transition'        => '',
                'pix_template_id'   => '',
                'el_class'          => '',
            ), $item));

            $tab_id = 'tab';
            if (!empty($item['_id'])) {
                $tab_id = $el_id . '-' .  $item['_id'];
            } else {
                $tab_id = wp_rand(0, 10000000);
            }
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
                $menu .= '<a class="nav-link pix-tabs-btn text-24 pix-px-25 py-2 my-2 ' . $active . ' ' . $tabs_bold . ' ' . $tabs_italic . ' ' . $tabs_secondary_font . '" data-id="' . $tab_id . '" role="tab" id="pix-tab-btn-' . $tab_id . '" data-toggle="pill" href="#pix-tab-' . $tab_id . '"  aria-controls="pix-tab-' . $tab_id . '">' . $icon_html . do_shortcode($title) . '</a>';
            } else {
                $menu .= '<a class="nav-link pix-tabs-btn text-24 pix-px-25 d-flex align-items-center py-2 my-2 ' . $active . ' ' . $tabs_bold . ' ' . $tabs_italic . ' ' . $tabs_secondary_font . '" data-id="' . $tab_id . '" role="tab" id="pix-tab-btn-' . $tab_id . '" data-toggle="pill" href="#pix-tab-' . $tab_id . '"  aria-controls="pix-tab-' . $tab_id . '">' . $icon_html . do_shortcode($title) . '</a>';
            }
            $menu .= '</div>';

            $tabs .= '<div class="tab-pane ' . $active . ' ' . $transition . ' show ' . $el_class . '" role="tabpanel" id="pix-tab-' . $tab_id . '" data-bold="' . $bold . '" data-italic="' . $italic . '" data-secondary="' . $secondary_font . '" data-id="' . $tab_id . '" data-icon="' . $icon . '" data-title="' . $title . '" aria-labelledby="pix-tab-' . $tab_id . '">';
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
        $menu .= '</div>';
        $menu .= '</div>';
        $menu .= '</div>';


        $tabs .= '</div>';
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
        $output .= '<div class="' . $css_class . '" ' . $anim_type . ' ' . $anim_delay . '>';
        $output .= '<div class="row pix-waiting pix_tabs_container">';
        if ($menu_position == 'left') {
            $output .= $menu;
            $output .= $tabs;
        } else {
            $output .= $tabs;
            $output .= $menu;
        }
        $output .= '</div>';
        $output .= '</div>';


        return $output;
    }
}
