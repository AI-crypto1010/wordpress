<?php /* Template Name: Shop Template */

get_header();
$classes = '';
$styles = '';

if (!empty(pix_get_option('shop-bg-color'))) {
    if (pix_get_option('shop-bg-color') == 'custom') {
        $styles = 'style="background:' . pix_get_option('custom-shop-bg-color') . ';"';
    } else {
        $classes = 'bg-' . pix_get_option('shop-bg-color') . ' ';
    }
}

$hide_top_area = false;
if (get_post_meta(get_the_ID(), 'pix-hide-top-area', true)) {
    if (get_post_meta(get_the_ID(), 'pix-hide-top-area', true) === '1') {
        $hide_top_area = true;
    } else {
        if (empty(pix_get_option('shop-with-intro')) || !pix_get_option('pages-with-intro')) {
            $hide_top_area = true;
        }
    }
} else {
    if (empty(pix_get_option('shop-with-intro')) || !pix_get_option('pages-with-intro')) {
        $hide_top_area = true;
    }
}


if (!$hide_top_area) {
    get_template_part('template-parts/intro');
}

if (pix_should_add_top_padding(null, 'shop-hide-top-padding')) {
    $classes .= 'pt-5';
}
?>
<div id="content" class="site-content <?php echo esc_html($classes); ?>" <?php echo esc_html($styles); ?>>
    <div class="container">
        <?php if ($hide_top_area) { ?>
            <div class="pix-main-intro-placeholder"></div>
        <?php } ?>
        <div class="row">
            <div class="col-12">
                <main id="main" class="site-main content-area">
                    <?php
                    while (have_posts()) :
                        the_post();
                        get_template_part('template-parts/content', 'page');
                        // If comments are open or we have at least one comment, load up the comment template.
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;
                    endwhile; // End of the loop.
                    ?>
                </main>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>
