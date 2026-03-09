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
        <?php if (get_post_meta(get_the_ID(), 'pix-highlights', true)) {
            $data = get_post_meta(get_the_ID(), 'pix-highlights', true);
            $data = json_decode(wp_specialchars_decode($data));
            $introBox = false;
            $introStyle = '';
            if (is_array($data) && count($data) > 0) {
                $introBox = true;
                if (!empty(pix_get_option('portfolio-divider-style'))) {
                    $introStyle = 'margin-top:-160px;';
                }
            }
        ?>

            <div class="row" style="<?php echo esc_attr($introStyle); ?>">

                <?php if ($introBox) { ?>
                    <div class="col-12 col-md-8 offset-md-2">

                        <div class="d-inline-block shadow pix-base-background w-100" style="border-radius:10px;">
                            <div class="d-md-flex pix-py-20">
                                <?php

                                $delay = 400;
                                foreach ($data as $key => $value) {
                                ?>
                                    <div class="flex-md-fill w-100 text-center pix-py-10 animate-in" data-anim-type="fade-in-up" data-anim-delay="<?php echo esc_attr($delay); ?>">
                                        <?php
                                        if (!empty($value->title)) {
                                        ?>
                                            <div class="">
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
                        </div>
                        
                    </div>
                <?php } ?>
                <div class="col-12 col-md-8 offset-md-2">
                    <div class="pix-py-25 pix-px-10">
                        <?php
                        if (!get_post_meta(get_the_ID(), "pix-post-hide-content", true) || get_post_meta(get_the_ID(), "pix-post-hide-content", true) === "false") {
                            echo get_post_meta(get_the_ID(), "portfolio-text", true);
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
                        ?>
                    </div>
                </div>
            </div>

        <?php

        }
        ?>

    </div>
    <?php if ($addContainer) {
        echo '<div class="container my-0 py-0">';
    } ?>
    <div class="row">
        <div class="col-12">
            <main id="main" class="site-main content-area sticky-top" style="top:100px;">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="entry-content">
                        <?php
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_attr__('Pages:', 'conseil'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </article>

            </main><!-- #main -->
        </div>
        <div class="col-12">
            <div class="sticky-top" style="top:100px;">
                <?php
                the_content();
                ?>
            </div>
        </div>
    </div>
    <?php if ($addContainer) {
        echo '</div>';
    } ?>
</div>
