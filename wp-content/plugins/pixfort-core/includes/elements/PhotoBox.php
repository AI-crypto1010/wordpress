<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* PhotoBox
* --------------------------------------------------------------------------- */
class PixPhotoBox {

    function render($attr, $content = null) {
        extract(shortcode_atts(array(
            'image'  => '',
            'title'  => '',
            'badge'  => '',
            'rounded_img'  => 'rounded-lg',
            'pix_color_effect'  => '',
            'pix_title_effect'  => '',
            'alt'  => '',
            'align'  => 'text-left',
            'width'     => '',
            'height'     => '',
            'pix_scroll_parallax'     => '',
            'pix_tilt'     => '',
            'pix_tilt_size'     => 'tilt',
            'xaxis'     => '',
            'yaxis'     => '',
            'link'     => '',
            'target'     => '',
            'animation'     => '',
            'delay'     => '0',
            'style'         => '',
            'hover_effect'         => '',
            'add_hover_effect'         => '',
            'pix_infinite_animation'         => '',
            'pix_infinite_speed'         => '',
            'height'         => '400px',
            'bold'        => 'font-weight-bold',
            'italic'        => '',
            'secondary_font'        => '',
            'title_color'        => 'heading-default',
            'title_custom_color'        => '',
            'title_size'        => 'h5',
            'title_custom_size'        => '',
            'css'         => '',
        ), $attr));

        $css_class = '';
        if (function_exists('vc_shortcode_custom_css_class')) {
            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
        }

        $output = '';
        $class_names = '';


        $imgSrcset = '';
        $imgSrc = '';
        if (is_string($image) && substr($image, 0, 4) === "http") {
            $img = $image;
            $imgSrc = $img;
        } else {
            if (!empty($image['id'])) {
                if ( is_int( $image['id'] ) ) {
                    $image['id'] = apply_filters( 'wpml_object_id', $image['id'], 'attachment', true );
                }
                $img = wp_get_attachment_image_src($image['id'], "full");
                $imgSrcset = wp_get_attachment_image_srcset($image['id']);
            } else {
                if ( is_int( $image ) ) {
                    $image = apply_filters( 'wpml_object_id', $image, 'attachment', true );
                }
                $img = wp_get_attachment_image_src($image, "full");
                $imgSrcset = wp_get_attachment_image_srcset($image);
            }
            if (!empty($img[0])) {
                $imgSrc = $img[0];
            }
        }
        $classes = [];
        array_push($classes, esc_attr($css_class));

        $effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
		array_push($classes, $effectsClasses);


        if (!empty($align)) {
            array_push($classes, $align);
            array_push($classes, "w-100");
        }
        // $inline_style = '';
        // if (!empty($width)) {
        //     $inline_style .= 'max-width:' . $width . ';';
        // } else {
        //     if (!empty($height)) {
        //         $inline_style .= 'width:auto;';
        //     }
        // }
        // if (!empty($height)) {
        //     $inline_style .= 'max-height:' . $height . ';';
        // } else {
        //     $inline_style .= 'height:auto;';
        // }
        array_push($classes, 'd-inline-flex');



        $title_classes = array();
        if (!empty($bold)) array_push($title_classes, $bold);
        if (!empty($italic)) array_push($title_classes, $italic);
        if (!empty($secondary_font)) array_push($title_classes, $secondary_font);

        $t_tag = 'div';
        $t_custom = '';
        if (!empty($title_size)) {
            if ($title_size == 'custom') {
                $t_custom .= 'font-size:' . $title_custom_size . ';line-height:1.28;';
            } else {
                $t_tag = $title_size;
            }
        }
        if (!empty($title_color)) {
            if ($title_color == 'custom') {
                $t_custom .= 'color:' . $title_custom_color . ' !important;';
            }
        }
        $t_custom = 'style="' . $t_custom . '"';


        // $inline_style = 'style="' . $inline_style . '"';
        $class_names = join(' ', $classes);
        $title_class_names = join(' ', $title_classes);

        $jarallax = '';
        if ($pix_scroll_parallax) {
            if (!empty($xaxis) || !empty($yaxis)) {
                $jarallax = 'data-jarallax-element="' . $xaxis . ' ' . $yaxis . '" data-xaxis="' . $xaxis . '" data-yaxis="' . $yaxis . '"';
            }
        }

        $output = '';



        if (!empty($pix_infinite_animation)) {
            $output .= '<div class="w-100 ' . $pix_infinite_animation . ' ' . $pix_infinite_speed . '">';
        }
        if (!empty($animation)) {
            $anim_type = 'data-anim-type="' . $animation . '"';
            $anim_delay = 'data-anim-delay="' . $delay . '"';
            $output .= '<div class="animate-in d-inline-flex flex-column w-100" ' . $anim_type . ' ' . $anim_delay . '>';
        }
        if (!empty($pix_tilt)) {
            $output .= '<div class="' . $pix_tilt_size . '">';
        }

        $target_out = '';
        if (!empty($target)) {
            $target_out = 'target="_blank"';
        }
        $box_height = '';
        if (!empty($height)) {
            $box_height = 'style="min-height:' . $height . ';"';
        }
        $color_effect = '';
        if (!empty($pix_color_effect)) {
            $color_effect = 'pix-hover-colored';
        }
        $title_effect = '';
        if (!empty($pix_title_effect)) {
            $title_effect = 'pix-fade-in';
        }


        $output .= '<div class="card w-100 h-100 bg-heading-default bg-transparent ' . $class_names . ' pix-hover-item ' . $rounded_img . ' position-relative overflow-hidden text-white" ' . $jarallax . '>';
        $output .= '<img srcset="' . $imgSrcset . '" src="' . $imgSrc . '" class="card-img pix-bg-image h-100 pix-img-scale pix-opacity-10 ' . $rounded_img . ' ' . $color_effect . '" alt="' . $title . '">';
        if (!empty($link)) {
            $output .= '<a href="' . $link . '" ' . $target_out . ' class="d-inline-block w-100 pix-img-overlay pix-p-10 d-flex align-items-end" ' . $box_height . '>';
        } else {
            $output .= '<span class="d-inline-block w-100 pix-img-overlay pix-p-10 d-flex align-items-end" ' . $box_height . '>';
        }

        $output .= '<div class="w-100">';
        if (!empty($title)) {
            $output .= '<div class="card-content-box pix-p-20 ' . $rounded_img . ' w-100 shadow ' . $title_effect . ' bg-dynamic-background d-flex justify-content-between align-items-center">';
            $output .= '<' . $t_tag . ' class="card-title ' . $title_class_names . '  text-' . $title_color . ' m-0 w-100" ' . $t_custom . '>' . $title . '</' . $t_tag . '>';
            $iconName = 'Line/pixfort-icon-arrow-right-2';
            if (is_rtl()) {
                $iconName = 'Line/pixfort-icon-arrow-left-2';
            }
            $output .= '<' . $t_tag . ' class="d-inline-flex align-middle text-' . $title_color . '" ' . $t_custom . '>' . \PixfortCore::instance()->icons->getIcon($iconName) . '</' . $t_tag . '>';
            $output .= '</div>';
        }

        $output .= '</div>';
        if (!empty($link)) {
            $output .= '</a>';
        } else {
            $output .= '</span>';
        }
        $output .= '</div>';


        if (!empty($pix_tilt)) {
            $output .= '</div>';
        }
        if (!empty($animation)) {
            $output .= '</div>';
        }
        if (!empty($pix_infinite_animation)) {
            $output .= '</div>';
        }



        return $output;
    }
}
