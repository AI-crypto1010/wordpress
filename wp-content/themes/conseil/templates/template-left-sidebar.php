<?php /* Template Name: Sidebar Start Template */

get_header();
$classes = '';
$styles = '';
if (get_post_type() == 'post') {
    if (!empty(pix_get_option('blog-bg-color'))) {
        if (pix_get_option('blog-bg-color') == 'custom') {
            $styles = 'style="background:' . pix_get_option('custom-blog-bg-color') . ';"';
        } else {
            $classes = 'bg-' . pix_get_option('blog-bg-color') . ' ';
        }
    }
} else {
    if (!empty(pix_get_option('pages-bg-color'))) {
        if (pix_get_option('pages-bg-color') == 'custom') {
            $styles = 'style="background:' . pix_get_option('custom-pages-bg-color') . ';"';
        } else {
            $classes = 'bg-' . pix_get_option('pages-bg-color') . ' ';
        }
    }
}
get_template_part('template-parts/intro');
if (pix_should_add_top_padding()) {
    $classes .= 'pt-5';
}
?>
<div id="content" class="site-content <?php echo esc_html($classes); ?>" <?php echo esc_html($styles); ?>>
    <div class="container">
        <div class="row">
            <?php get_sidebar(); ?>
            <div class="col-12 col-md-8">
                <main id="main" class="site-main content-area">
                    <?php
                    if (post_password_required()) {
                        ?>
                        <div class="pix-main-intro-placeholder"></div>
                        <?php
                    }
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
