<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Gallery
* --------------------------------------------------------------------------- */
class PixGallery {

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'items' 		        => '',
			'full_size_img' 		=> false,
			'pix_columns' 		    => 'pix-3-columns',
			'pix_style' 		    => '',
			'rounded_img' 		    => 'rounded-lg',
            'pix_tilt' 	            => '',
			'pix_tilt_size' 	    => 'tilt',
            'style' 		        => '',
            'hover_effect' 		    => '',
            'add_hover_effect' 		=> '',
            'bold'		            => 'font-weight-bold',
			'italic'		        => '',
			'secondary_font'		=> '',
            'title_color'		    => 'heading-default',
			'title_custom_color'	=> '',
			'title_size'		    => 'h6',
			'title_custom_size'		=> '',
			'gallery_id'		    => 'gallery',
			'css' 		            => '',
		), $attr));

        $classes = array();
		if(function_exists('vc_shortcode_custom_css_class')){
		    $css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
		}
        wp_enqueue_style( 'pix-lightbox-css' );
        $output = '';
        
        array_push($classes, esc_attr( $css ));

        if(!empty($pix_tilt)){
            array_push($classes, $pix_tilt_size);
            $add_hover_effect = '';
        } 

        $effectsClasses = \PixfortCore::instance()->coreFunctions->getEffectsClasses($style, $hover_effect, $add_hover_effect);
		array_push($classes, $effectsClasses);
        
        $elementor = false;
		$items_arr = array();
		if(is_array($items)){
			$items_arr = $items;
			$elementor = true;
		}else{
			if(function_exists('vc_param_group_parse_atts')){
				$items_arr = vc_param_group_parse_atts( $items );
			}
		}

        $items_classes = 'pix-mb-20 ';
        if($pix_style=='gutter-0'){
            $items_classes = '';
        }
        array_push($classes, $rounded_img);
        

        $cardClasses = join( ' ', $classes );

        $title_classes = array();
        if(!empty($bold)) array_push($title_classes, $bold );
        if(!empty($italic)) array_push($title_classes, $italic );
        if(!empty($secondary_font)) array_push($title_classes, $secondary_font );

        $t_custom = '';
        if(!empty($title_size)){
            if($title_size=='custom'){
                $t_custom .= 'font-size:'.$title_custom_size.';';
            }else{
                array_push($title_classes, $title_size );
            }
        }
        $t_custom_color = '';
        if(!empty($title_color)){
           if($title_color=='custom'){
               $t_custom .= 'color:'.$title_custom_color.' !important;';
           }
        }
        $t_custom = 'style="'.$t_custom.'"';
        $title_class_names = join( ' ', $title_classes );

        if(!empty($items_arr)){
            wp_enqueue_style( 'pixfort-masonry-style', PIX_CORE_PLUGIN_URI.'includes/assets/css/elements/masonry.min.css', false, PIXFORT_PLUGIN_VERSION);
            wp_enqueue_script('pix-flickity-js');
            $output .= '<div class="pix-lightbox">';
                    $output .= '<div class="pix_masonry '.$pix_style.' '.$pix_columns.'" style="width:100%">';
                        $output .= '<div class="grid-sizer"></div>';
                        $output .= '<div class="gutter-sizer"></div>';
                    foreach ($items_arr as $key => $value) {
                        extract(shortcode_atts(array(
                			'image' 		    => '',
                			'title' 		    => '',
                			'desc' 		        => '',
                            'enable_link' 	    => '',
                            'link' 	            => '',
                			'target' 	        => '',
                            'gallery_height' 	=> '',
                			'grid_size' 		=> 'grid-item',
                            'pix_color_effect'  => '',
                			'pix_title_effect'  => '',
                		), $value));
                        if(!empty($image)){
                            $img_classes = '';
                            if(empty($full_size_img) || $full_size_img=='no'){
                                $img_classes = 'pix-gallery-item '. $gallery_height;
                            }
        					// $imgSrcset = '';
        					// $imgSizes = '';
        					$imgSrc = '';
                            $imgWidth = '';
                            $imgHeight = '';
        					if(is_string($image)&&substr( $image, 0, 4 ) === "http"){
        						$imgSrc = $image;
        					}else{
        						if($elementor){
                                    if ( is_int( $image['id'] ) ) {
                                        $image['id'] = apply_filters( 'wpml_object_id', $image['id'], 'attachment', true );
                                    }
        							$img = wp_get_attachment_image_src($image['id'], "full");
        						}else{
                                    if ( is_int( $image ) ) {
                                        $image = apply_filters( 'wpml_object_id', $image, 'attachment', true );
                                    }
        							$img = wp_get_attachment_image_src($image, "full");
        						}
                                if(!empty($img[0])){
                                    $imgSrc = $img[0];
                                    if(!empty($img[1]) && !empty($img[2])){
                                        $imgWidth = 'width="'.$img[1].'"';
                                        $imgHeight = 'height="'.$img[2].'"';
                                    }
                                }
        					}
                            $color_effect = '';
                            if(!empty($pix_color_effect)){
                                $color_effect = 'pix-hover-colored';
                            }
                            $title_effect = '';
                            if(!empty($pix_title_effect)){
                                $title_effect = 'pix-fade-in';
                            }
                            $output .='<div class=" '.$grid_size.' '.$items_classes.'">';
							if(is_array($link)){
								if($link['is_external']){
									$link['target'] = '_blank';
								}
								if($link['nofollow']){
									$link['rel'] = 'nofollow';
								}
								$link['title'] = $title;
							}elseif(substr( $link, 0, 4 ) === 'url:'){
								if( function_exists( 'vc_build_link' ) ){
									$link = vc_build_link($link);
								}
							}
							if(!is_array($link)){
								$link = array(
						            'url'   => '',
						            'target'   => '',
						            'title'   => '',
						            'rel'   => '',
						        );
							}
	                            if(!empty($enable_link)){
									if(empty($link['target'])) $link['target'] = '';
	                                $output .='<a class="card pix-hover-item '.$cardClasses.'" href="'.$link['url'].'" target="'.$link['target'].'" title="'.$link['title'].'" rel="'.$link['rel'].'">';
								}else{
									$output .='<a class="card pix-lightbox pix-lightbox-item pix-hover-item '.$cardClasses.'" data-fancybox="'.$gallery_id.'" data-caption="'.$desc.'" href="'.$imgSrc.'">';
								}
                                    $output .= '<img class="card-img '.$color_effect.' '.$rounded_img.' '.$img_classes.'" src="'.$imgSrc.'" '.$imgWidth.' '.$imgHeight.' alt="'.$desc.'" />';
                                    $output .= '<div class="card-img-overlay d-flex align-items-end pix-p-10">';
                                    if(!empty($title)){
                                        $output .= '<div class="card-content-box pix-p-20 '.$rounded_img.' w-100 shadow '.$title_effect.' bg-dynamic-background d-flex justify-content-between align-items-center">';
                                            $output .= '<div class="card-title '.$title_class_names.'  text-'.$title_color.' m-0 w-100" '.$t_custom.'>'.$title.'</div>';
											if(!empty($enable_link)){
	                                            $output .= '<div class="m-0 '.$title_class_names.'  text-'.$title_color.'">'.pixGetFileContents('/includes/assets/images/open_in_new.svg').'</div>';
											}else{
												$output .= '<div class="m-0 '.$title_class_names.'  text-'.$title_color.'">'.pixGetFileContents('/includes/assets/images/fullscreen.svg').'</div>';
											}
                                        $output .= '</div>';
                                    }
                                    $output .= '</div>';
                		        $output .= '</a>';
                		    $output .= '</div>';
                        }
                    }
            		$output .= '</div>';
            $output .= '</div>';
        }
		return $output;
	}
}

