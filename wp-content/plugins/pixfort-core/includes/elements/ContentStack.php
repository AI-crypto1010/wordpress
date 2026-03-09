<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* ContentStack
* --------------------------------------------------------------------------- */
class PixContentStack {

	function render($attr, $content = null) {
       extract(shortcode_atts(array(
           'image' 		=> '',
           'content_pos' 		=> 'pix-left-content',
           'content_padding' 		=> 'pix-p-40',
           'style' 		=> '',
           'hover_effect' 		=> '',
           'add_hover_effect' 		=> '',
           'img_style' 		=> '',
           'img_hover_effect' 		=> '',
           'img_add_hover_effect' 		=> '',
           'text_color' 		=> '',
           'rounded_box' 		=> '',
           'pix_bg_gradient_hover' 		=> '',
           'pix_particles_check' => '',
           'pix_particles' => '',
           'particles_top_index' => '',
           'animation'		=> '',
           'delay'		=> '0',
           'css' => '',
           'el_css' => '',
           'overflow' 		=> '',
           'el_class' 		=> 'mb-2',
       ), $attr));


       $css_class = '';
if(function_exists('vc_shortcode_custom_css_class')){
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
}
       $el_css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $el_css, ' ' ) );

       wp_enqueue_style('pixfort-content-stack-style', PIX_CORE_PLUGIN_URI . 'includes/assets/css/elements/content-stack.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');

       $style_arr = array(
          "" => "",
          "1"       => "shadow-sm",
          "2"       => "shadow",
          "3"       => "shadow-lg",
          "4"       => "shadow-inverse-sm",
          "5"       => "shadow-inverse",
          "6"       => "shadow-inverse-lg",
        );

        $hover_effect_arr = array(
           ""       => "",
           "1"       => "shadow-hover-sm",
           "2"       => "shadow-hover",
           "3"       => "shadow-hover-lg",
           "4"       => "shadow-inverse-hover-sm",
           "5"       => "shadow-inverse-hover",
           "6"       => "shadow-inverse-hover-lg",
        );

        $add_hover_effect_arr = array(
           ""       => "",
           "1"       => "fly-sm",
           "2"       => "fly",
           "3"       => "fly-lg",
           "4"       => "scale-sm",
           "5"       => "scale",
           "6"       => "scale-lg",
           "7"       => "scale-inverse-sm",
           "8"       => "scale-inverse",
           "9"       => "scale-inverse-lg",
        );


       $classes = ' ';

       $classes .= esc_attr( $css_class ) . ' ';
       $classes .= $text_color . ' ';
       $classes .= $rounded_box . ' ';

       if($style){ $classes .= $style_arr[$style]. ' '; }
       if($hover_effect){ $classes .= $hover_effect_arr[$hover_effect]. ' '; }
       if($add_hover_effect){ $classes .= $add_hover_effect_arr[$add_hover_effect]. ' '; }
       if($pix_bg_gradient_hover){ $classes .= 'pix-hover-item pix-dark-hover '; }

       $img_classes = ' ';
       if($img_style){ $img_classes .= $style_arr[$img_style]. ' '; }
       if($img_hover_effect){ $img_classes .= $hover_effect_arr[$img_hover_effect]. ' '; }
       if($img_add_hover_effect){ $img_classes .= $add_hover_effect_arr[$img_add_hover_effect]. ' '; }

       $anim_type = '';
       $anim_delay = '';
       $anim_c_delay = '';
       if(!empty($animation)){
           // $classes .= 'animate-in ';
           $anim_type = 'data-anim-type="'.$animation.'"';
           $anim_delay = 'data-anim-delay="'.$delay.'"';
           $delay+=100;
           $anim_c_delay = 'data-anim-delay="'.$delay.'"';
       }

       $particles_out = '';
       if(!empty($pix_particles_check)){
           $particles = [];
           if(function_exists('vc_param_group_parse_atts')){
               	$particles = vc_param_group_parse_atts( $pix_particles );
            }

       	foreach ($particles as $key => $value) {
            $hideClass = '';
       		if( !empty($value['hide']) ) {
                $hideClass = 'd-none d-lg-block';
            }
       		if( !empty($value['image']) ) {
       			$w_style = '';
       			if( !empty($value['img_width']) ) {
       				$w_style .= 'width:'.$value['img_width'].';height:auto;';
       			}
                $imgSrcset = '';
    			if(is_string($value['image'])&&substr( $value['image'], 0, 4 ) === "http"){
    				$img = $value['image'];
    				$imgSrc = $img;
    			}else{
                    if(is_array($value['image'])&&!empty($value['image']['id'])){
                        if ( is_int( $value['image']['id'] ) ) {
                            $value['image']['id'] = apply_filters( 'wpml_object_id', $value['image']['id'], 'attachment', true );
                        }
                        $img = wp_get_attachment_image_src($value['image']['id'], "full");
                        $imgSrcset = wp_get_attachment_image_srcset($value['image']['id']);
                    }else{
                        if ( is_int( $value['image'] ) ) {
                            $value['image'] = apply_filters( 'wpml_object_id', $value['image'], 'attachment', true );
                        }
                        $img = wp_get_attachment_image_src($value['image'], "full");
                        $imgSrcset = wp_get_attachment_image_srcset($value['image']);
                    }
           			$imgSrc = $img[0];
                }

       			$w_style .= $value['v_position'].': '.$value['vertical'].';'.$value['h_position'].': '.$value['horizontal'].'; ';
       			$w_style = 'style="'.$w_style.'"';



       			if(!empty($value['pix_particles_type_2'])){
       				$particles_out .= '<div data-depth="'.$value['depth'].'" data-relative-input="true" class="pix-scene-particle '.$hideClass.'">';
       			}else{
       				$particles_out .= '<div class="pix-scene-particle '.$hideClass.'">';
       			}
       				if(!empty($value['animation'])){
       					$particles_out .= '<div class="animate-in" data-anim-type="'.$value['animation'].'" data-anim-delay="'.$value['delay'].'">';
       				}else{
       					$particles_out .= '<div class="">';
       				}


       					$particles_out .= '<div class="">';
       						$extra_classes = '';
       						if(!empty($value['pix_infinite_animation'])){
       							$extra_classes .= $value['pix_infinite_animation'] .' '. $value['pix_infinite_speed'];
       						}
                            $speed = '';
       						if(!empty($value['pix_particles_type_3'])){
       							$extra_classes .=  ' pix-rotate-scroll ';
                                if(!empty($value['pix_inverse_rotation'])){
                                    $speed = 'data-speed="-'.$value['rotation_speed'].'"';
                                }else{
                                    if(!empty($value['rotation_speed'])){
                                        $speed = 'data-speed="'.$value['rotation_speed'].'"';
                                    }
                                }
       						}
       						if(!empty($value['pix_particles_type'])){
       							$particles_out .= '<img '.$w_style.' src="'.$imgSrc.'" srcset="'.$imgSrcset.'" loading="lazy" alt="Particle element" data-jarallax-element="'.$value['xaxis'] .' '. $value['yaxis'].'" data-xaxis="'.$value['xaxis'].'" data-yaxis="'.$value['yaxis'].'" class="img-fluid pix-scene-elm '.$extra_classes.'" '.$speed.'>';
       						}else{
       							$particles_out .= '<img '.$w_style.' src="'.$imgSrc.'" srcset="'.$imgSrcset.'" loading="lazy" alt="Particle element" class="img-fluid pix-scene-elm '.$extra_classes.'" '.$speed.'>';
       						}
       					$particles_out .= '</div>';

       				$particles_out .= '</div>';

       			$particles_out .= '</div>';

       		}

       	}
       }


       $output = '<div class="pix-content-box card '. $classes .' w-100 '.$overflow.' '.$el_class.'" '.$anim_type.' '.$anim_delay.' style="position:relative !important;">';
            if($pix_bg_gradient_hover){
                $output .= '<div class="pix-hover-gradient-primary w-100 h-100 position-absolute d-inline-block" style="z-index:0;top:0;left:0;"></div>';
            }
            if(!empty($particles)){
                $output .= '<div class="scene scene-over">';
                     $output .= $particles_out;
                $output .= '</div>';
            }

           $c_index = 'style="z-index:30;position:relative;"';
           if(!empty($particles_top_index)){
               $c_index = 'style="z-index:0;"';
           }
           $output .= '<div '.$c_index.'>';
           $output .= do_shortcode($content);
           $output .= '</div>';
       $output .= '</div>'."\n";


       $output = '<div class="pix-content-stack '.$el_css_class.' '.$content_pos.'  '.$el_class.'">';
              $output .= '<div class="img-el rounded-lg animate-in '.$img_classes.'" '.$anim_type.' '.$anim_delay.'>';
                if(!empty($image)){

                    $imgSrcset = '';
                    $image_alt = '';
        			if(is_string($image)&&substr($image, 0, 4 ) === "http"){
        				$img = $image;
        				$imgSrc = $img;
        			}else{
                        if(is_array($image)&&!empty($image['id'])){
                            $image_ID = $image['id'];
                        }else{
                            $image_ID = $image;
                        }
                        $img = wp_get_attachment_image_src($image_ID, "full");
                        $imgSrcset = wp_get_attachment_image_srcset($image_ID);
                        $image_alt = get_post_meta($image_ID, '_wp_attachment_image_alt', TRUE);
               			$imgSrc = $img[0];
                    }
                    $output .= '<img srcset="'.$imgSrcset.'" src="'.$imgSrc.'" class="rounded-lg img-fluid " alt="'.$image_alt.'" >';
                }

                $output .= '</div>';
              $output .= '<div class="content-el animate-in" '.$anim_type.' '.$anim_c_delay.'>';
                $output .= '<div class="content-el-inner bg-white2 '. $classes .' '.$overflow.' rounded-lg '.$content_padding.'">';
                if($pix_bg_gradient_hover){
                    $output .= '<div class="pix-hover-gradient-primary w-100 h-100 rounded-lg position-absolute d-inline-block" style="z-index:0;top:0;left:0;"></div>';
                }
                if(!empty($particles)){
                    $output .= '<div class="scene scene-over">';
                         $output .= $particles_out;
                    $output .= '</div>';
                }
                $c_index = 'style="z-index:30;position:relative;"';
                if(!empty($particles_top_index)){
                    $c_index = 'style="z-index:0;"';
                }
                $output .= '<div '.$c_index.'>';
                $output .= do_shortcode($content);
                $output .= '</div>';
                  $output .= '</div>';
                $output .= '</div>';
          $output .= '</div>'."\n";


       return $output;
   }
}


