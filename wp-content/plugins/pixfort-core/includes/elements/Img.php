<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Img
* --------------------------------------------------------------------------- */
class PixImg {

    function render($attr, $content = null) {
        extract(shortcode_atts(array(
            'image'  => '',
            'image_dark'  => '',
            'rounded_img'  => 'rounded-0',
            'alt'  => '',
            'align'  => 'text-left',
            'width'     => '',
            'height'     => '',
            'pix_scroll_parallax'     => '',
            'pix_tilt'     => false,
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
            'img_div'         => '',
            'pix_scale_in'         => '',
            'el_class'         => '',
            'element_id'         => '',
            'css'         => '',
            'responsive_css'         => '',
        ), $attr));

        $css_class = '';
        if (function_exists('vc_shortcode_custom_css_class')) {
            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
        }
        $css_class .= ' ' . pix_responsive_css_class($responsive_css) . ' ';
        
        $output = '';
        if (!empty($image)) {
            if (empty($alt)) {
                $alt = __('Image link', 'pixfort-core');
            }
            if (empty($element_id)) {
                $element_id = 'img-' . hash('md5', json_encode($attr));
            }
            $classes = array();
            $anim_type = '';
            $anim_delay = '';
            array_push($classes, esc_attr($css_class));

            $effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
            array_push($classes, $effectsClasses);

            if (!empty($align)) {
                array_push($classes, $align);
                // array_push($classes, "w-100");
            }
            $inline_style = '';
            $div_inline_style = '';
            // $div_size_class = '';
            $main_width = 'w-100';
            if (!empty($width)) {
                if (pix_endsWith($width, '%')) {
                    $div_inline_style = 'style="width:' . $width . ';"';
                    $inline_style .= 'width:' . $width . ';';
                    // $div_size_class = 'w-100';
                } else {
                    $inline_style .= 'width:' . $width . ';';
                    $main_width = '';
                }
            } else {
                if (!empty($height)) {
                    $inline_style .= 'width:auto;';
                }
            }
            if (!empty($height)) {
                $inline_style .= 'max-height:' . $height . ';';
            } else {
                $inline_style .= 'height:auto;';
            }
            array_push($classes, 'd-inline-block');
            array_push($classes, $el_class);


            // $inline_style = 'style="' . $inline_style . '"';
            $customStyle = '#'.$element_id. ' img {'.$inline_style.'}';
            \PixfortCore::instance()->elementsManager::pixAddInlineStyle( $customStyle );
            if (is_user_logged_in() || (defined('DOING_AJAX') && DOING_AJAX)) {
                $output .= '<style>' . $customStyle . '</style>';
            }

            $class_names = join(' ', $classes);

            

            $jarallax = '';
            if ($pix_scroll_parallax) {
                if (!empty($xaxis) || !empty($yaxis)) {
                    $jarallax = 'data-jarallax-element="' . $xaxis . ' ' . $yaxis . '" data-xaxis="' . $xaxis . '" data-yaxis="' . $yaxis . '"';
                }
            }

            $transform_data = '';
            if(!empty($pix_scale_in) && $pix_scale_in === 'pix-advanced-transform') {
                $transform_data = \PixfortCore::instance()->styleFunctions->getTransformData($attr);
                if($transform_data) {
                    $transform_data = 'data-pix-transform=\'' . json_encode($transform_data)  . '\'';
                }
			}

            if (!empty($img_div)) {
                $output .= '<div id="'.$element_id.'" class="pix-img-element pix-img-div ' . $pix_scale_in . ' ' . $img_div . ' ' . $transform_data . '">';
            } else {
                $output .= '<div id="'.$element_id.'" class="pix-img-element d-inline-block ' . $pix_scale_in . '" ' . $div_inline_style . ' ' . $transform_data . '>';
            }


            // Refactoring the code
        
            if (!empty($pix_infinite_animation)) {
                $output .= '<div class="' . $pix_infinite_animation . ' ' . $pix_infinite_speed . '">';
            }
            if (!empty($animation)) {
                $anim_type = 'data-anim-type="' . $animation . '"';
                $anim_delay = 'data-anim-delay="' . $delay . '"';
                $output .= '<div class="animate-in d-inline-block" ' . $anim_type . ' ' . $anim_delay . '>';
            }
            if (!empty($pix_tilt) && $pix_tilt) {
                $output .= '<div class="' . $pix_tilt_size . '">';
            }

            if($link) {
                $newTab = '';
                if (!empty($target)) {
                    $newTab = 'target="_blank"';
                }
                $output .= '<a href="' . $link . '" ' . $newTab . ' class="pix-img-el ' . $class_names . ' ' . $rounded_img . '" ' . $jarallax . ' aria-label="' . $alt . '">';
            } else {
                $output .= '<div class="pix-img-el ' . $class_names . ' ' . $main_width . ' ' . $rounded_img . '"  ' . $jarallax . '>';
            }

            $output .= \PixfortCore::instance()->coreFunctions->getDynamicImage($image, 'full', [
                'alt' => $alt,
                'class' => 'pix-img-elem ' . $rounded_img
            ], $image_dark);

            if($link) {
                $output .= '</a>';
            } else {
                $output .= '</div>';
            }

            if (!empty($pix_tilt) && $pix_tilt) {
                $output .= '</div>';
            }
            if (!empty($animation)) {
                $output .= '</div>';
            }
            if (!empty($pix_infinite_animation)) {
                $output .= '</div>';
            }


            $output .= '</div>';
        }




        


        return $output;
    }
}


