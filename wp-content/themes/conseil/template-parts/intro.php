<?php


/**
 * Template part for displaying page intro
 *
 * @package pixfort theme
 */

$hide_top_area = false;
$post_type = get_post_type();
$pagePostTypes = ['page'];
$pagePostTypes = apply_filters('pixfort_page_options_post_types', $pagePostTypes);
$customIntro = false;

if (class_exists('PixfortCore')) {
	$customIntros = \PixfortCore::instance()->areasManager->getLocationTemplates('intro');
	if (!empty($customIntros[0])) {
		$customIntro = $customIntros[0];
	}
}

// Check if the current page is NOT a blog template
$isBlogTemplate = false;
$blogTemplates = array(
    'templates/template-blog-full-width.php',
    'templates/template-blog-with-offset.php',
    'templates/template-blog-without-sidebar.php',
    'templates/template-blog-left-sidebar.php',
    'templates/template-blog-right-sidebar.php',
    'templates/template-blog-default.php'
);

foreach ($blogTemplates as $template) {
    if (is_page_template($template)) {
        $isBlogTemplate = true;
        break;
    }
}


global $woocommerce;
$page_id = get_queried_object_id();
if ($page_id === 0 && $woocommerce && is_shop()) {
    $page_id = wc_get_page_id('shop');
}


if (get_post_meta($page_id, 'pix-hide-top-area', true)) {
    if (get_post_meta($page_id, 'pix-hide-top-area', true) === '1') {
        $hide_top_area = true;
    }
}
if(!$customIntro){
    if (!$isBlogTemplate && in_array(get_post_type(), $pagePostTypes)) {
        if(get_post_meta($page_id, 'pix-hide-top-area', true)!=='0'){
            if (empty(pix_get_option('pages-with-intro')) || !pix_get_option('pages-with-intro')) {
                $hide_top_area = true;
            }
        }
    } else if (empty(pix_get_option('post-with-intro')) || !pix_get_option('post-with-intro')) {
        $hide_top_area = true;
    }
}
if(get_post_meta( $page_id, 'pix-sections-stack', true )&&get_post_meta( $page_id, 'pix-sections-stack', true )!=='false'){
    $hide_top_area = true;
}


$is_woo_page = false;
if ($woocommerce && is_shop() || $woocommerce && is_product_category() || $woocommerce && is_product_tag() || $woocommerce && is_product()) {
    $is_woo_page = true;
}
if (!$is_woo_page) {
    if (is_archive() || is_author() || is_category() || is_home() || is_tag() || is_search()) {
        $hide_top_area = false;
        if(!$customIntro){
            if (empty(pix_get_option('post-with-intro')) || !pix_get_option('post-with-intro')) {
                $hide_top_area = true;
            }
        }
    }
}
if (get_post_type() === 'elementor_library') {
    $hide_top_area = true;
}


if (!$hide_top_area) {
if ($customIntro) {

    // Elementor
    if (get_post_status($customIntro)) {
        if (get_post_type($customIntro) === 'pixintro') {
            if (class_exists('\Elementor\Plugin')) {
                echo \Elementor\plugin::instance()->frontend->get_builder_content($customIntro, true);
            }
        }
    }
    wp_reset_postdata();
} else {


if (!$hide_top_area) {

    $divider_style = false;
    $divider_height = false;
    $is_class_color = false;
    $d_color = '#fff';

    $text_class = 'text-heading-default';
    $intro_dark = '';
    $intro_align = 'text-center';
    $intro_bred_align = 'justify-content-center';
    $intro_bg = 'bg-gray-2';
    $intro_style = '';
    $intro_opacity = 'pix-opacity-5';
    $disableTitle = false;
    $customTopPadding = false;
    $customBottomPadding = false;
    $title_sliding = 'pix-sliding-headline3';
    $intro_parallax = 'data-jarallax';
    $intro_parallax_class = 'jarallax';
    $show_breadcrumbs = true;
    $customStyle = '';
    $disabledImageAnimation = false;
    $introImageClass = '';

    if (function_exists('is_woocommerce_activated')) {
        global $woocommerce;
    }

    $type_prefix = 'blog';
    $is_shop_post = false;

    if (
        get_post_type() == 'portfolio' || is_page_template('templates/template-portfolio-full-width.php')
        || is_page_template('templates/template-portfolio-default.php')
    ) {
        $type_prefix = 'portfolio';
    } elseif (
        get_post_type() == 'product'
        || is_page_template('templates/template-shop.php')
    ) {
        $type_prefix = 'shop';
        if (class_exists('WooCommerce')) {
            $is_shop_post = true;
        }
    } elseif (
        get_post_type() == 'post'
        || $isBlogTemplate
        || is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag() || is_search()
    ) {
        $type_prefix = 'blog';
    } elseif (in_array(get_post_type(), $pagePostTypes) || is_404()) {
        $type_prefix = 'pages';
        if (class_exists('WooCommerce')) {
            if (is_cart()||is_checkout()) {
                $type_prefix = 'shop';
                $is_shop_post = true;
            }
        }
    }



    if (!empty(pix_get_option($type_prefix . '-divider-style'))) $divider_style = pix_get_option($type_prefix . '-divider-style');
    if (!empty(pix_get_option($type_prefix . '-divider-height'))) $divider_height = (int) pix_get_option($type_prefix . '-divider-height');
    if (!empty(pix_get_option($type_prefix . '-intro-light'))) $intro_dark = 'pix-invert-colors';
    if (!empty(pix_get_option($type_prefix . '-intro-align'))) {
        $intro_align = pix_get_option($type_prefix . '-intro-align');
        if ($intro_align == 'text-left') $intro_bred_align = 'justify-content-start';
        if ($intro_align == 'text-right') $intro_bred_align = 'justify-content-end';
    }
    if (!empty(pix_get_option($type_prefix . '-intr-bg-color'))) {
        $intro_bg = 'bg-' . pix_get_option($type_prefix . '-intr-bg-color');
    }
    if (!empty(pix_get_option($type_prefix . '-intro-opacity'))) {
        $intro_opacity = pix_get_option($type_prefix . '-intro-opacity');
    }
    if (!empty(pix_get_option($type_prefix . '-bg-color'))) {
        if (pix_get_option($type_prefix . '-bg-color') == 'custom') {
            $d_color = pix_get_option('custom-' . $type_prefix . '-bg-color');
            $is_class_color = false;
        } else {
            $d_color = 'bg-' . pix_get_option($type_prefix . '-bg-color');
            $is_class_color = true;
        }
    }


    // Intro custom options
    if (!empty(pix_get_option($type_prefix . '-intro-top-height'))) {
        $customTopPadding = (int) pix_get_option($type_prefix . '-intro-top-height');
    }
    if (!empty(pix_get_option($type_prefix . '-intro-bottom-height'))) {
        $customBottomPadding = (int) pix_get_option($type_prefix . '-intro-bottom-height');
    }

    if (!empty(pix_get_option($type_prefix . '-disable-title-animation'))) {
        if (pix_get_option($type_prefix . '-disable-title-animation')) {
            $title_sliding = '';
        }
    }
    if (!empty(pix_get_option($type_prefix . '-disable-intro-parallax'))) {
        if (pix_get_option($type_prefix . '-disable-intro-parallax')) {
            $intro_parallax = '';
            $intro_parallax_class = '';
        }
    }
    if (!empty(pix_get_option($type_prefix . '-disable-intro-title'))) {
        if (pix_get_option($type_prefix . '-disable-intro-title')) {
            $disableTitle = true;
        }
    }
    if (!empty(pix_get_option($type_prefix . '-disable-intro-breadcrumbs'))) {
        if (pix_get_option($type_prefix . '-disable-intro-breadcrumbs')) {
            $show_breadcrumbs = false;
        }
    }

    if (!empty(pix_get_option($type_prefix . '-disable-intro-img-animation'))) {
        if (pix_get_option($type_prefix . '-disable-intro-img-animation')) {
            $disabledImageAnimation = true;
            $introImageClass = 'animated';
        }
    }

    /*
    * Intro title and breadcrumbs color
    */
    $introTitleColor = 'heading-default';
    $introTitleColorCustom = '';
    $introBreadcrumbsColor = 'body-default';
    $introBreadcrumbsColorCustom = '';

    if (!empty(pix_get_option($type_prefix . '-intro-title-color'))) {
        $introTitleColor = pix_get_option($type_prefix . '-intro-title-color');
        $text_class = 'pix-intro-title text-'.$introTitleColor;
        if($introTitleColor == 'custom'){
            if (!empty(pix_get_option($type_prefix . '-intro-title-color-custom'))) $introTitleColorCustom = pix_get_option($type_prefix . '-intro-title-color-custom');
            if(empty($title_sliding)){
                $customStyle .= '.pix-intro-title { color: ' . $introTitleColorCustom . ' !important; }';
            }
        }
        $intro_dark = '';
    }
    if (!empty(pix_get_option($type_prefix . '-intro-breadcrumbs-color'))) {
        $introBreadcrumbsColor = pix_get_option($type_prefix . '-intro-breadcrumbs-color');
        if($introBreadcrumbsColor == 'custom'){
            if (!empty(pix_get_option($type_prefix . '-intro-breadcrumbs-color-custom'))) {
                $introBreadcrumbsColor = 'custom pix-intro-breadcrumbs';
                $introBreadcrumbsColorCustom = pix_get_option($type_prefix . '-intro-breadcrumbs-color-custom');
                $customStyle .= '.pix-intro-breadcrumbs { color: ' . $introBreadcrumbsColorCustom . ' !important; }';
            }
        }
        $intro_dark = '';
    }
    /*
    * End Intro Colors
    */



    // Default size for each divider 
    $dividers_default_size = array(
        100, 250, 250, 150, 100, 200, 100,
        150, 250, 200, 150, 150, 140, 130,
        150, 130, 300, 300, 300, 300, 300,
        150, 250, 300, 400, 400, 300
    );

    if (!$divider_height) {
        $divider_height = $dividers_default_size[$divider_style];
    }

    // Padding amplification factor for each divider
    $dividers_padding_size = array(
        0.2, 0, 0, 0.4, 0.8, 0.2, 0.8,
        0.4, 0.1, 0.1, 0.4, 0.4, 0.8, 0.8,
        0.2, 0.2, 0.1, 0, 0, 0, 0,
        0.3, 0.3, 0.2, 0, 0, 0
    );

    // Get extra padding depending on each divider
    $extra_padding = 0;
    if($divider_style){
        $extra_padding = $divider_height * $dividers_padding_size[$divider_style];
    }
    

    // Top divider padding
    if ($customTopPadding !== false) {
        $intro_padding_top = $customTopPadding;
    } else {
        if ($divider_style === '24') {
            $intro_padding_top = 120;
        } elseif ($divider_style === '26') {
            $intro_padding_top = 80;
        } else {
            $intro_padding_top = $divider_height * 0.5 + $extra_padding;
        }
    }

    // Bottom divider padding
    if ($customBottomPadding !== false) {
        $intro_padding_bottom = $customBottomPadding;
    } else {
        if (!$divider_style) {
            $intro_padding_bottom = $divider_height * 0.35 + $extra_padding;
        } else {
            if ($divider_style === '24') {
                $intro_padding_bottom = 180;
            } elseif ($divider_style === '26') {
                $intro_padding_bottom = 290;
            } else {
                $intro_padding_bottom = $divider_height * 0.6 + $extra_padding;
            }
        }
    }


    // Padding CSS
    $container_style = 'padding-top:' . $intro_padding_top . 'px;padding-bottom:' . $intro_padding_bottom . 'px;';


    $customStyle .= '.pix-intro-container { ' . $container_style . ' }';

    if (!empty(pix_get_option($type_prefix . '-mobile-intro-top-height'))) {
        $customMobileTopPadding = (int) pix_get_option($type_prefix . '-mobile-intro-top-height');
        $customStyle .= '@media (max-width: 991px) { .pix-main-intro .pix-intro-container { padding-top:' . $customMobileTopPadding . 'px !important; }}';
    }
    if (!empty(pix_get_option($type_prefix . '-mobile-intro-bottom-height'))) {
        $customMobileBottomPadding = (int) pix_get_option($type_prefix . '-mobile-intro-bottom-height');
        $customStyle .= '@media (max-width: 991px) { .pix-main-intro .pix-intro-container { padding-bottom:' . $customMobileBottomPadding . 'px !important; }}';
    }

    // wp_register_style('pix-intro-area-handle', false);
    // wp_enqueue_style('pix-intro-area-handle');
    // wp_add_inline_style('pix-intro-area-handle', $customStyle);
    echo '<style>' . $customStyle . '</style>';

?>


    <div class="pix-main-intro pix-intro-1 <?php echo esc_attr($intro_bg); ?>">
        <div class="pix-intro-img <?php echo esc_attr($intro_parallax_class); ?> <?php echo esc_attr($introImageClass); ?>" <?php echo esc_attr($intro_parallax); ?> data-speed="0.5">
            <?php
            $get_default = true;
            if (is_category() || (class_exists('WooCommerce') && is_product_category())) {
                $term_id = get_queried_object()->term_id;

                $customIntroImg = get_term_meta($term_id, 'category_intro_img', true);
                if ($customIntroImg) {
                    $customIntroImg = apply_filters( 'wpml_object_id', $customIntroImg, 'attachment', true );
                    echo wp_get_attachment_image($customIntroImg, 'full', false, array('class' => 'jarallax-img ' . $intro_opacity, 'alt' => ''));
                    $get_default = false;
                }
            }
            if ($get_default) {
                if (is_tax('portfolio-types')) {
                    if (!empty(pix_get_option($type_prefix . '-intro-img'))) {
                        echo wp_get_attachment_image(pix_get_option($type_prefix . '-intro-img')['id'], 'full', false, array('class' => 'jarallax-img ' . $intro_opacity, 'alt' => ''));
                    }
                } else {
                    $imageValue = get_post_meta($page_id, 'pix-custom-intro-bg', true);
                    $imageID = false;
                    if($imageValue && function_exists('pixGetImageID')){
                        $imageArray = pixGetImageID($imageValue);
                        if(!empty($imageArray['light'])){
                            $imageID = $imageArray['light'];
                        }
                    }
                    if($imageID){
                        $imageID = apply_filters( 'wpml_object_id', $imageID, 'attachment', true );
                        echo wp_get_attachment_image($imageID, 'full', false, array('class' => 'jarallax-img ' . $intro_opacity, 'alt' => ''));
                    } else {
                        if (!empty(pix_get_option($type_prefix . '-intro-img'))) {
                            $imageID = pix_get_option($type_prefix . '-intro-img')['id'];
                            $imageID = apply_filters( 'wpml_object_id', $imageID, 'attachment', true );
                            echo wp_get_attachment_image($imageID, 'full', false, array('class' => 'jarallax-img ' . $intro_opacity, 'alt' => ''));
                        }
                    }
                }
            }

            ?>
        </div>

        <div class="container pix-intro-container position-relative <?php echo esc_attr($intro_dark); ?>">
            <div class="pix-main-intro-placeholder"></div>

            <div class="row d-flex h-100 justify-content-center">


                <div class="col-xs-12 col-lg-12">
                    <div class="<?php echo esc_attr($intro_align); ?> my-2 intro-content-div">
                        <?php
                        $is_shop = false;
                        $is_product = false;
                        if (class_exists('WooCommerce')) {
                            $is_shop = is_shop() || is_product_category() || (get_post_type() == 'product');
                            if (get_post_type() == 'product' && !is_shop()) {
                                $is_product = true;
                            }
                        }


                        if ((!is_404() && !is_search() && !is_archive() && !is_author()) || $is_shop) {
                            if (!$disableTitle) {
                                $introTitleText = '';
                                if ($is_shop_post || $is_shop) {
                                    if ( ($is_product && !is_archive()) || is_cart()||is_checkout()) {
                                        $introTitleText = get_the_title();
                                    } else {
                                        $introTitleText = woocommerce_page_title(false);
                                    }
                                } else {
                                    $introTitleText = single_post_title('', false);
                                }
                                if (!empty($title_sliding) && class_exists('PixfortCore')) {
                                    echo \PixfortCore::instance()->elementsManager->renderElement('SlidingText', [
                                        'position'  => 'inherit',
                                        'size'  => 'h1',
                                        'secondary_font'  => 'secondary-font',
                                        'el_class'  => $text_class . ' h3 font-weight-bold',
                                        'text_color' => $introTitleColor,
                                        'text_custom_color' => $introTitleColorCustom,
                                        'el_id'  => 'pix-intro-sliding-text',
                                        'remove_mb'  => true
                                    ],  $introTitleText);
                                } else {
                        ?>
                                    <h1 class="<?php echo esc_attr($title_sliding); ?> h3  <?php echo esc_attr($text_class); ?> font-weight-bold" data-class="<?php echo esc_attr($text_class); ?>"><?php echo esc_html($introTitleText); ?></h1>
                            <?php
                                }
                            }
                            ?>
                            <div class="intro-breadcrumbs">
                                <?php
                                if ($show_breadcrumbs) {
                                    if(function_exists('pixfortGetBreadcrumbs') ) {
                                        pixfortGetBreadcrumbs( $intro_bred_align, $introBreadcrumbsColor, 'default');
                                    } 
                                }
                                ?>
                            </div>
                            <?php
                        } elseif (is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) {
                            if (!empty($title_sliding) && class_exists('PixfortCore')) {
                                echo \PixfortCore::instance()->elementsManager->renderElement('SlidingText', [
                                    'position'  => 'inherit',
                                    'size'  => 'h1',
                                    'secondary_font'  => 'secondary-font',
                                    'el_class'  => $text_class . ' h3 font-weight-bold',
                                    'text_color' => $introTitleColor,
                                    'text_custom_color' => $introTitleColorCustom,
                                    'el_id'  => 'pix-intro-sliding-text',
                                    'remove_mb'  => true
                                ],  get_the_archive_title());
                            } else {
                                the_archive_title('<h1 class="' . esc_attr($title_sliding) . ' h3 ' . esc_attr($text_class) . ' font-weight-bold" data-class="' . esc_attr($text_class) . '">', '</h1>');
                            }
                            if ($show_breadcrumbs) {
                                if(function_exists('pixfortGetBreadcrumbs') ) {
                                    echo '<div class="intro-breadcrumbs">';
                                    pixfortGetBreadcrumbs( $intro_bred_align, $introBreadcrumbsColor, 'default');
                                    echo '</div>';
                                } 
                            }
                        } elseif (is_search()) {
                            if (!empty($title_sliding) && class_exists('PixfortCore')) {
                                echo \PixfortCore::instance()->elementsManager->renderElement('SlidingText', [
                                    'position'  => 'inherit',
                                    'size'  => 'h1',
                                    'secondary_font'  => 'secondary-font',
                                    'el_class'  => $text_class . ' h3 font-weight-bold',
                                    'text_color' => $introTitleColor,
                                    'text_custom_color' => $introTitleColorCustom,
                                    'el_id'  => 'pix-intro-sliding-text',
                                    'remove_mb'  => true
                                ],  sprintf(esc_attr__('Search Results for: %s', 'conseil'), '<span>' . get_search_query() . '</span>'));
                            } else {
                            ?>
                                <h1 class="<?php echo esc_attr($title_sliding); ?> h3 <?php echo esc_attr($text_class); ?> font-weight-bold" data-class="<?php echo esc_attr($text_class); ?>">
                                    <?php
                                    printf(esc_attr__('Search Results for: %s', 'conseil'), '<span>' . get_search_query() . '</span>');
                                    ?>
                                </h1>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>


            </div>
        </div>
        <div class="">
            <?php

            if (!empty($divider_style)) {
                if (function_exists('pix_get_divider')) {
                    $b_divider_opts = array(
                        'd_divider_select'        => $divider_style,
                        'd_layers'                => '3',
                        'd_1_is_gradient'            => '',
                        'd_1_color'                    => $d_color,
                        // 'd_2_color'					=> $d_color,
                        'is_class_color'            => $is_class_color,
                        'd_2_is_gradient'            => '',
                        'd_2_animation'                => 'fade-in-up',
                        'd_2_delay'                    => '500',
                        'd_3_is_gradient'            => '',
                        'd_3_color_2'                => '',
                        'd_3_animation'                => 'fade-in-up',
                        'd_3_delay'                    => '700',
                        'd_high_index'                => '',
                        'd_flip_h'                    => '',
                        'extra_classes'                    => '',
                    );

                    if ($divider_height && !in_array($divider_style, array('25', '26'))) {
                        if ($divider_style === '24') {
                            $divider_style = '24-alt';
                        }
                        echo pix_get_divider($divider_style, '#fff', 'bottom', false, '#fff', $b_divider_opts, $divider_height);
                    } else {
                        echo pix_get_divider($divider_style, '#fff', 'bottom', false, '#fff', $b_divider_opts);
                    }
                }
            }
            ?>
        </div>
    </div>



<?php

}
}
}
