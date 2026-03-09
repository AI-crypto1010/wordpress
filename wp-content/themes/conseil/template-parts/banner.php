<?php

if(pix_get_option('banner-bg')){
    if(pix_get_option('banner-bg')=='custom'){
        $banner_style = '.pix-banner { --pix-bg-color:'. pix_get_option('custom-banner-bg') . ';}';
        wp_register_style('pix-site-banner', false);
        wp_enqueue_style('pix-site-banner');
        wp_add_inline_style('pix-site-banner', $banner_style);
    }
}


$opts = array();
extract(shortcode_atts(array(
    'background' 		=> pix_get_option('banner-bg'),
    'text_color' 		=> pix_get_option('banner-text-color'),
    'btn_style' 		=> pix_get_option('banner-btn-style'),
    'btn_color' 		=> pix_get_option('banner-btn-color'),
    'btn_text_color' 		=> pix_get_option('banner-btn-text-color'),
    'btn_text_custom_color' 		=> pix_get_option('banner-btn-custom-text-color'),
    'show_countdown' 		=> pix_get_option('show-banner-countdown'),
    'banner_date' 		=> pix_get_option('banner-date'),
    'banner_padding' 		=> pix_get_option('banner-padding'),
    'style' 		    => '',
    'banner_text' 		    => pix_get_option('banner-text'),
), $opts));
$text_bold = '';
if(pix_get_option('bold-banner-text')){
    $text_bold = 'font-weight-bold';
}
$text_secondary = '';
if(pix_get_option('secondary-banner-text')){
    $text_secondary = 'secondary-font';
}

$nonce = wp_create_nonce("close_banner");
$close_link = admin_url('admin-ajax.php?action=pix_close_banner&nonce='.$nonce);

$btn_padding = 'pix-ml-20';

?>

<div class="pix-banner pix-intro-1 w-100 bg-<?php echo esc_attr( $background ); ?> d-block text-white" >
    <?php if(!empty(pix_get_option('banner-bg-img')['url'])){ ?>
        <div class="pix-intro-img" >
            <img class="pix-opacity-9 animated" src="<?php echo esc_url( pix_get_option('banner-bg-img')['url'] ); ?>" alt="Banner" />
        </div>
    <?php } ?>

    <a class="pix-banner-close" title="<?php echo esc_attr__('Close', 'conseil'); ?>" href="<?php echo esc_url( $close_link ); ?>">
        <?php 
			if(pixCheckIconsAvailable()){
				 echo \PixfortCore::instance()->icons->getIcon('Line/pixfort-icon-cross-circle-1', 22, 'text-'. esc_attr( $text_color )); 
			}
        ?>
    </a>

    <div class="container <?php echo esc_attr( $banner_padding ); ?>">
        <div class="row">

            <div class="col-12 text-center column py-3 py-md-2 px-5">
                <div class="pix-banner-content d-md-flex align-items-center w-100 justify-content-center">
                    <span class="pix-banner-text text-<?php echo esc_attr( $text_color. ' '.$text_secondary.' '. $text_bold ); ?>"><?php
                    if(function_exists( 'icl_register_string' )){
                        echo apply_filters( 'wpml_translate_single_string', $banner_text, 'Theme', 'pixfort-banner-text' );
                    }else{
                        echo pix_pll__( $banner_text );
                    }

                    ?></span>
                    <?php
                    if(!empty($show_countdown)){
                        ?>
                        <div class="pix-banner-countdown pix-countdown pix-px-20 text-center " data-date="<?php echo esc_attr( $banner_date ); ?>">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="pix-px-5 text-<?php echo esc_attr( $text_color ); ?>">
                                    <div class="font-weight-bold text-20"><span class="pix-count-days">0</span></div>
                                    <div class="font-weight-bold text-xs"><?php echo esc_html__('Days', 'conseil'); ?></div>
                                </div>
                                <div class="pix-px-5 text-<?php echo esc_attr( $text_color ); ?>">
                                    <div class="font-weight-bold text-20"><span class="pix-count-hours">0</span></div>
                                    <div class="font-weight-bold text-xs"><?php echo esc_html__('Hours', 'conseil'); ?></div>
                                </div>
                                <div class="pix-px-5 text-<?php echo esc_attr( $text_color ); ?>">
                                    <div class="font-weight-bold text-20"><span class="pix-count-min">0</span></div>
                                    <div class="font-weight-bold text-xs"><?php echo esc_html__('Minutes', 'conseil'); ?></div>
                                </div>
                                <div class="pix-px-5 text-<?php echo esc_attr( $text_color ); ?>">
                                    <div class="font-weight-bold text-20"><span class="pix-count-sec">0</span></div>
                                    <div class="font-weight-bold text-xs"><?php echo esc_html__('Seconds', 'conseil'); ?></div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $btn_padding = '';
                    }


                    $target = '';
                    $classes = ' ';
                    if($btn_text_color){
                        if($btn_text_color!='custom'){
                            $classes .= 'text-'. $btn_text_color . ' ';
                        }else{
                            $btn_inline_style= 'style="color:'. $btn_text_custom_color  .';"';
                        }
                    }
                    if($btn_style=='line'){
                        $classes .= 'btn-line-'.$btn_color;
                    }elseif ($btn_style=='outline') {
                        $classes .= 'btn-outline-'.$btn_color;
                    }elseif ($btn_style=='underline') {
                        $classes .= 'btn-underline-'.$btn_color;
                    }elseif ($btn_style=='blink') {
                        $classes .= 'btn-blink-'.$btn_color;
                    }else{
                        if (strpos($btn_color, 'bg-') === 0) {
                            $classes .= ' '.$btn_color;
                            $classes .= ' btn-primary btn-custom-bg ';
                        }else{
                            $classes .= 'btn-'.$btn_color;
                        }

                    }
                    if($btn_style=='flat'){
                        $classes .= ' btn-flat';
                    }
                    if(pix_get_option('show-banner-target')){
                        $target = '_blank';
                    }
                    if(pix_get_option('show-banner-btn')){
                        $btnLink = esc_url( pix_get_option('banner-btn-link') );
                        if(function_exists( 'icl_register_string' )){
                            $btnLink = apply_filters( 'wpml_translate_single_string', pix_get_option('banner-btn-lunk'), 'Theme', 'pixfort-banner-btn-link' );
                        }else{
                            $btnLink = pix_pll__( pix_get_option('banner-btn-link') );
                        }
                        ?>
                        <div class="pix-banner-btn">
                            <a href="<?php echo esc_url( $btnLink ); ?>" target="<?php echo esc_attr( $target ); ?>" class="btn <?php echo esc_attr( $classes ); ?> font-weight-bold <?php echo esc_attr( $btn_padding ); ?> pix-px-10 pix-py-5">
                                <span><?php
                                if(function_exists( 'icl_register_string' )){
                                    echo apply_filters( 'wpml_translate_single_string', pix_get_option('banner-btn-text'), 'Theme', 'pixfort-banner-btn-text' );
                                }else{
                                    echo pix_pll__( pix_get_option('banner-btn-text') );
                                }
                                ?></span>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

        </div>


        <?php if($style=="border-bottom"): ?>
            <div class="bg-<?php echo esc_html( $line_color ); ?>" style="width:100%;height:1px;"></div>
        <?php endif; ?>
    </div>
    <?php if($style=="border-bottom-wide"): ?>
        <div class="bg-<?php echo esc_html( $line_color ); ?>" style="width:100%;height:1px;"></div>
    <?php endif; ?>
</div>
