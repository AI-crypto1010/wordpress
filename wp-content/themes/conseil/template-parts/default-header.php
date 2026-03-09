<?php


add_action('wp_head', 'pixfort_theme_add_default_styles', 5);
function pixfort_theme_add_default_styles() {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
	echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap">' . "\n";
}

add_action('wp_enqueue_scripts', 'pixfort_theme_enqueue_default_scripts');
function pixfort_theme_enqueue_default_scripts() {
	wp_enqueue_script('pixfort-default-main', get_template_directory_uri() . '/inc/default/main.js', ['jquery'], PIXFORT_THEME_VERSION, true);
}
/**
 * Register block styles.
 */
function pixfort_theme_register_block_styles() {
	register_block_style(
		'core/paragraph',
		array(
			'name'  => 'pixfort-default',
			'label' => esc_attr__('Default', 'conseil'),
		)
	);
}
add_action('init', 'pixfort_theme_register_block_styles');

/**
 * Register block patterns.
 */
function pixfort_theme_register_block_patterns() {
	register_block_pattern(
		'conseil/default-pattern',
		array(
			'title'       => esc_attr__('Default Pattern', 'conseil'),
			'description' => esc_attr__('A simple default pattern.', 'conseil'),
			'content'     => '<!-- wp:paragraph --><p></p><!-- /wp:paragraph -->',
		)
	);
}
add_action('init', 'pixfort_theme_register_block_patterns');


add_action('pixfort_location_header', 'pixDefaultHeader', 10, 2);

if (!function_exists('pixDefaultHeader')) {
    function pixDefaultHeader() {
?>
        <header data-area="header" id="masthead" class="bg-white pixfort-header-area pixfort-area-content pix-header pix-header-desktop d-block pix-header-normal pix-scroll-shadow  header-scroll pix-header-container-area">
            <div class="container">
                <div class="pix-row d-flex justify-content-between">
                    <nav data-col="header" class="pixfort-header-col navbar pix-main-menu navbar-hover-drop navbar-expand-lg navbar-light">
                        <?php echo pix_get_header_logo([]); ?>
                        <?php echo pix_get_header_menu(['disable_mega' => true]); ?>
                    </nav>
                </div>
            </div>
        </header>
    <?php
    renderDefaultMobileHeader([], [], null);
    }
}


/**
 * Header Logo element
 */
if (! function_exists('pix_get_header_logo')) {
    function pix_get_header_logo($opts) {
        extract(shortcode_atts(array(
            'height'         => '',
            'width'         => '',
            'width'         => '',
            'color'         => 'body-default',
            'custom_color'         => '',
            'area'             => '',
            'animation'             => 'slide-in-up',
            'logo_img'             => '',
            'logo_scroll_img'             => '',
            'custom_url'             => '',
            'target'             => '',
        ), $opts));
        $max = '';
        $classes = '';
        $themeDefault = false;
        if (!empty($target)) $target = '_blank';
        
        $classes .= 'text-heading-default';
        $themeDefault = true;
        
        $link = home_url('/');
        if (!empty($custom_url)) {
            $link = $custom_url;
        }
        $custom_logo_url = false;
        $scroll_logo_url = false;
        $logo_class = '';

        $imgWidth = '';
        $imgHeight = '';
        $imgWidthMobile = '';
        $imgHeightMobile = '';

        $custom_logo_img = false;
        $altText = get_bloginfo('name');

        if (pix_get_option('scroll-logo-img') && pix_get_option('scroll-logo-img')['url']) {
            $custom_logo_img_scroll = pix_get_option('scroll-logo-img');
            $scroll_logo_url = $custom_logo_img_scroll['url'];
            $logo_class = 'pix-logo';
            // if(!empty($custom_logo_img_scroll['height'])){
            //     $imgHeightScroll = $custom_logo_img_scroll['height'];
            // }
            // if(!empty($custom_logo_img_scroll['width'])){
            //     $imgWidthScroll = $custom_logo_img_scroll['width'];
            // }
        }
        if (!empty($logo_scroll_img) && $logo_scroll_img != '') {
            $scroll_logo_url = $logo_scroll_img;
            $logo_class = 'pix-logo';
        }
        if (!empty($area) && ($area == 'm_header' || $area == 'm_stack' || $area == 'm_topbar') && pix_get_option('mobile-logo-img') && pix_get_option('mobile-logo-img')['url']) {
            $custom_logo_img_mobile = pix_get_option('mobile-logo-img');
            $custom_logo_url = $custom_logo_img_mobile['url'];
            if (!empty($custom_logo_img_mobile['height'])) {
                $imgHeightMobile = (int) $custom_logo_img_mobile['height'];
            }
            if (!empty($custom_logo_img_mobile['width'])) {
                $imgWidthMobile = (int) $custom_logo_img_mobile['width'];
                if (empty($width) && !empty($height)) {
                    $width = (int) $height * ($imgWidthMobile / $imgHeightMobile);
                }
            }
            if (!empty($custom_logo_img_mobile['alt'])) {
                $altText = $custom_logo_img_mobile['alt'];
            }
        } else {
            if (pix_get_option('logo-img') && pix_get_option('logo-img')['url']) {
                $custom_logo_img = pix_get_option('logo-img');
                $custom_logo_url = $custom_logo_img['url'];
            }
            if (!empty($custom_logo_img['height'])) {
                $imgHeight = (int) $custom_logo_img['height'];
            }
            if (!empty($custom_logo_img['width'])) {
                $imgWidth = (int) $custom_logo_img['width'];
                if (empty($width) && !empty($height)) {
                    $width = (int) $height * ($imgWidth / $imgHeight);
                }
            }
            if (!empty($custom_logo_img['alt'])) {
                $altText = $custom_logo_img['alt'];
            }
        }

        if (!empty($logo_img)) {
            $custom_logo_url = $logo_img;
        }

        if (empty($height)) {
            if (!empty($custom_logo_url)) {
                $max = 'max-width:180px;';
            }
        }
        $animation_class = 'animate-in';
        $animation_div_class = '';
        if ($animation == 'disabled') {
            $animation_class = '';
        } elseif ($animation == 'slide-in-up') {
            $animation_class .= ' slide-in-container';
            $animation_div_class = 'slide-in-container';
        }

    ?>
        <div class="<?php echo esc_attr($animation_div_class); ?> d-flex align-items-center">
            <div class="d-inline-block <?php echo esc_attr($animation_class); ?>" data-anim-type="<?php echo esc_attr($animation); ?>" style="<?php echo esc_attr($max); ?>">
                <?php
                $img_style = '';
                $heightVal = '';
                $widthVal = '';
                if (!empty($height) && $height != '') {
                    if (is_numeric($height)) {
                        $height .= 'px';
                    }
                    $img_style = 'height:' . $height . ';width:auto;';
                    $heightVal = preg_replace("/[^0-9]/", "", $height);
                }
                if (!empty($width) && $width != '') {
                    $widthVal = preg_replace("/[^0-9.]/", "", $width);
                }
                if ($themeDefault) {
                ?>
                    <h3 class="site-title"><strong><a class="navbar-brand pix-header-text font-weight-bold text-24 pix-mr-20 <?php echo esc_attr($classes); ?>" href="<?php echo esc_url($link); ?>" rel="home"><?php echo esc_html($altText); ?></a></strong></h3>
                    <?php
                } else {
                    if (!empty($area) && ($area == 'm_header' || $area == 'm_stack' || $area == 'm_topbar') && (pix_get_option('mobile-logo-img') && pix_get_option('mobile-logo-img')['url'] || !empty($custom_logo_url))) {
                    ?>
                        <a class="navbar-brand" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>" rel="home">
                            <img class="<?php echo esc_attr($logo_class); ?>" src="<?php echo esc_url($custom_logo_url); ?>" alt="<?php echo esc_attr($altText); ?>" height="<?php echo esc_attr($heightVal); ?>" width="<?php echo esc_attr($widthVal); ?>" style="<?php echo esc_attr($img_style); ?>">
                            <?php
                            if ($scroll_logo_url) {
                            ?>
                                <img class="pix-logo-scroll" src="<?php echo esc_url($scroll_logo_url); ?>" alt="<?php bloginfo('name'); ?>" style="<?php echo esc_attr($img_style); ?>">
                            <?php
                            }
                            ?>
                        </a>
                        <?php

                    } else {
                        if ($custom_logo_url && !empty($custom_logo_url)) {

                        ?>
                            <a class="navbar-brand" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>" rel="home">
                                <img class="<?php echo esc_attr($logo_class); ?>" height="<?php echo esc_attr($heightVal); ?>" width="<?php echo esc_attr($widthVal); ?>" src="<?php echo esc_url($custom_logo_url); ?>" alt="<?php echo esc_attr($altText); ?>" style="<?php echo esc_attr($img_style); ?>">
                                <?php
                                if ($scroll_logo_url && $area == 'header') {
                                ?>
                                    <img class="pix-logo-scroll" src="<?php echo esc_url($scroll_logo_url); ?>" alt="<?php bloginfo('name'); ?>" style="<?php echo esc_attr($img_style); ?>">
                                <?php
                                }
                                ?>
                            </a>
                        <?php
                        } else {
                        ?>
                            <h3 class="site-title"><strong><a class="navbar-brand pix-header-text font-weight-bold text-24 pix-mr-20 <?php echo esc_attr($classes); ?>" href="<?php echo esc_url($link); ?>" rel="home"><?php bloginfo('name'); ?></a></strong></h3>
                <?php
                        }
                    }
                }

                ?>
            </div>
        </div>
        <?php
    }
}

/**
 * Header Menu element
 */
if (! function_exists('pix_get_header_menu')) {
    function pix_get_header_menu($opts) {
        extract(shortcode_atts(array(
            'size'         => 'mx-2',
            'color'     => 'black',
            'is_right_float'                     => '',
            'custom_color'                     => '',
            'scroll_color'                     => '',
            'menu'                     => 'menu-1',
            'area'                     => '',
            'menu_style'                     => '',
            'hidden_state'                     => false,
            'drop_bg'                     => 'white',
            'dark_mode'                     => '',
            'nav_line_color'                     => '',
            'nav_scroll_line_color'                     => '',
            'active_line'                     => '',
            'dropdown_angle'                     => '',
            'is_bold'                     => '',
            'nav_id'                     => false,
        ), $opts));
        if ($area != 'header' && $area != 'm_header') {
        ?>
            <nav class="navbar navbar-hover-drop navbar-expand-lg navbar-light p-0">
            <?php
        }
        if (empty($nav_id)) {
            if (defined('PIX_DEMO')) {
                $nav_id = 'pixfort-' . $area . '-' . $menu . '-' . $drop_bg;
            } else {
                $nav_id = rand(10, 1000);
            }
        }


        $desktop_areas = array('topbar', 'header', 'stack');
        $isMobile = false;
        if (!in_array($area, $desktop_areas)) {
            $isMobile = true;
            ?>
                <button class="navbar-toggler hamburger--spin hamburger normal-menu-toggle" type="button" data-toggle="collapse" data-target="#navbarNav-<?php echo esc_attr($nav_id); ?>" aria-controls="navbarNav-<?php echo esc_attr($nav_id); ?>" aria-expanded="false" aria-label="<?php echo esc_attr__('Toggle navigation', 'conseil'); ?>">
                    <span class="hamburger-box">

                        <span class="hamburger-inner bg-<?php echo esc_attr($color); ?>">
                            <span class="hamburger-inner-before bg-<?php echo esc_attr($color); ?>"></span>
                            <span class="hamburger-inner-after bg-<?php echo esc_attr($color); ?>"></span>
                        </span>

                    </span>
                </button>
            <?php
        }
        $menu_classes = '';

        if (!empty($dropdown_angle)) {
            $angleColor = '';
            if (!empty($color)) {
                if ($color == 'custom') {
                    $angleColor = 'color: ' . $custom_color . ';';
                } else {
                    $angleColor = 'color: var(--pix-' . $color . ');';
                }
            }
            $menuDropdownIcon = '#navbarNav-' . $nav_id . ' > ul > li > .pix-nav-link.dropdown-toggle > span:before {
                ' . $angleColor . '
            }';
            if (!empty($scroll_color)) {
                $menuDropdownIcon .= '.is-scroll #navbarNav-' . $nav_id . ' > ul > li > .pix-nav-link.dropdown-toggle > span:before {
                    color: var(--pix-' . $scroll_color . ') !important;
                }';
            }
            $menu_classes .= 'pix-nav-dropdown-angle' . ' ';
            wp_register_style('pix-header-menu-handle', false);
            wp_enqueue_style('pix-header-menu-handle');
            wp_add_inline_style('pix-header-menu-handle', $menuDropdownIcon);
        }




        if (!empty($nav_scroll_line_color)) {
            $menu_classes .= $nav_scroll_line_color . ' ';
        }
        $menu_classes .= $nav_line_color . ' ';
        $menu_classes .= $active_line . ' ';
        if (!empty($is_right_float)) {
            if ($is_right_float === true) {
                $menu_classes .= 'justify-content-end ';
            } else {
                $menu_classes .= 'justify-content-' . $is_right_float . ' ';
            }
        }
        if (!empty($dark_mode)) {
            $menu_classes .= 'pix-is-dark ';
        }
        $opts['isMobile'] = $isMobile;
        require_once(get_template_directory() . '/inc/bootstrap-wp-navwalker.php');
        $items_wrap = '<ul id="%1$s" class="%2$s">%3$s</ul>';
        if (in_array($area, $desktop_areas)) {
            if ($menu_style == 'hidden') {
                if (!empty($hidden_state) && $hidden_state) $hidden_state = 'menu-hidden-state';
                $menuBtn = '<li class="toggle-btn-item"><a class="hamburger--spin hamburger normal-menu-toggle d-flex ' . esc_attr($hidden_state) . '" href="#" data-target="#navbarNav-' . esc_attr($nav_id) . '" aria-label="' . esc_attr__('Toggle navigation', 'conseil') . '">
                    <span class="hamburger-box">
                        <span class="hamburger-inner bg-' . esc_attr($color) . '">
                            <span class="hamburger-inner-before bg-' . esc_attr($color) . '"></span>
                            <span class="hamburger-inner-after bg-' . esc_attr($color) . '"></span>
                        </span>
                    </span>
                </a></li>';
                if ($is_right_float === 'end') {
                    $items_wrap = '<ul id="%1$s" class="%2$s pix-menu-toggle-style">%3$s ' . $menuBtn . '</ul>';
                } else {
                    $items_wrap = '<ul id="%1$s" class="%2$s pix-menu-toggle-style">' . $menuBtn . '%3$s</ul>';
                }
            }
        }
        wp_nav_menu( array(
            'theme_location' => null,
            'depth'          => 5,
            'container_class' => 'collapse navbar-collapse align-self-stretch ' . $menu_classes,
            'container_id'   => 'navbarNav-' . $nav_id,
            'menu_class'     => 'navbar-nav nav-style-megamenu align-self-stretch align-items-center ',
            'fallback_cb'    => '',
            'echo'           => true,
            'menu'           => $menu,
            'items_wrap'     => $items_wrap,
            'walker'         => new wp_bootstrap_navwalker($opts)
        ) );



        if ($area != 'header' && $area != 'm_header') {
            ?>
            </nav>
<?php
        }
    }
}



function renderDefaultMobileHeader($m_header_val, $opts, $post = null) {

    
        extract(shortcode_atts([
            'style'         => '',
            'sticky'        => ''
        ], $opts));
        
        $smarSticky = get_post_field('pix-enable-mobile-sticky', $post);
        if (!empty($smarSticky)) {
            if ($smarSticky == 'enable') {
                $sticky = 'is-sticky';
            } else if ($smarSticky == 'smart') {
                $sticky = 'is-smart-sticky';
            }
        }

        $col_opts = [];
        if (!empty($m_header_val->m_header_1->opts)) {
            foreach ($m_header_val->m_header_1->opts as $i => $v) {
                $col_opts[$v->name] = $v->val;
            }
        }
        extract(shortcode_atts([
            'size' 		=> 'flex-1',
            'align'         => '',
            'custom_classes' 		=> ''
        ], $col_opts));
        $align = pix_align_to_flex($align);
        $align = pix_align_to_flex($align);
        ?>
        <header data-area="m_header" id="mobile_head" class="pixfort-header-area pixfort-area-content pix-header <?php echo esc_attr($sticky); ?> pix-header-mobile d-inline-block pix-header-normal pix-scroll-shadow">
            <div class="container-fluid">
                
                    <nav data-col="m_header_1" class="pixfort-header-col navbar navbar-hover-drop navbar-light <?php echo esc_attr($custom_classes); ?> <?php echo esc_attr($size); ?> <?php echo esc_attr($align); ?>">
                        <?php
                        
                        pix_get_header_logo([]);
                        pix_get_header_menu(['disable_mega' => true, 'area' => 'm_header']);
                        ?>
                    </nav>
            </div>
        </header>
<?php
    
}
