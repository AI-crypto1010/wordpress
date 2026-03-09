<?php

/**
 * Template part for displaying single portfolio
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pixfort theme
 */


$classes = '';
if (pix_should_add_top_padding(null, 'portfolio-hide-top-padding')) {
    $classes .= 'pt-5';
}
$addContainer = true;
if (class_exists('\Elementor\Plugin')) {
    if (Elementor\Plugin::instance()->documents->get(get_the_ID()) && Elementor\Plugin::instance()->documents->get(get_the_ID())->is_built_with_elementor()) {
        $addContainer = false;
    }
}
?>
<div id="content" class="site-content <?php echo esc_attr($classes); ?>">
    
    <div class="container">
    <div class="row">
        <?php
        $portfolioText = false;
        if (!get_post_meta(get_the_ID(), "pix-post-hide-content", true) || get_post_meta(get_the_ID(), "pix-post-hide-content", true) === "false") {
            $portfolioText = get_post_meta(get_the_ID(), "portfolio-text", true);
        }
        $data = false;
        if (get_post_meta(get_the_ID(), 'pix-highlights', true)) {
            $data = get_post_meta(get_the_ID(), 'pix-highlights', true);
            $data = json_decode(wp_specialchars_decode($data));
            if (!is_array($data) || count($data) == 0) {
                $data = false;
            }
        }
        if (!empty($portfolioText) || $data) {
        ?>
            <div class="col-12 col-md-8 offset-md-2">
                    <main id="main" class="site-main content-area">


                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>




                            <div class="entry-content pix-mb-20">
                                <?php
                                echo do_shortcode($portfolioText);

                                if ($data) {

                                ?>
                                    <div class="d-inline-block shadow pix-base-background w-100 pix-mt-20" style="border-radius:10px;">
                                        <?php


                                        if (get_post_meta(get_the_ID(), 'pix-highlights', true)) {
                                        ?>
                                            <div class="d-md-flex pix-py-20">
                                                <?php


                                                $delay = 400;

                                                foreach ($data as $key => $value) {
                                                ?>
                                                    <div class="flex-md-fill w-100 text-center pix-py-10 animate-in" data-anim-type="fade-in-up" data-anim-delay="<?php echo esc_attr($delay); ?>">
                                                        <?php
                                                        if (!empty($value->title)) {
                                                        ?>
                                                            <div>
                                                                <h6 class="text-heading-default text-20 font-weight-bold"><?php echo esc_html($value->title); ?></h6>
                                                            </div>
                                                        <?php
                                                        }
                                                        if (!empty($value->value)) {
                                                        ?>
                                                            <div class="text-body-default"><?php echo do_shortcode($value->value); ?></div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                <?php
                                                    $delay += 150;
                                                }
                                                ?>
                                            </div>
                                        <?php
                                        }


                                        ?>
                                    </div>
                                
                                <?php
                                }


                                if (!empty(pix_get_option('portfolio-post-info'))) {
                                ?>
                                    <div class="p-3 bg-gray-12 shadow-sm rounded-lg text-body-default font-weight-bold text-xs">
                                        <?php
                                        pixfort_posted_on();
                                        pixfort_posted_by();
                                        ?>
                                    </div>
                                <?php
                                }

                                wp_link_pages(array(
                                    'before' => '<div class="page-links">' . esc_attr__('Pages:', 'conseil'),
                                    'after'  => '</div>',
                                ));
                                ?>
                            </div><!-- .entry-content -->
                        </article>



                    </main>
            </div>
            <div class="col-12 clearfix"></div>
        <?php } ?>
    </div>
    </div>
    <?php if ($addContainer) {
        echo '<div class="container my-0 py-0"><div class="row"><div class="col-12">';
    } 
    the_content();
    if ($addContainer) {
        echo '</div></div></div>';
    } ?>
</div>
