<?php /* Template Name: Blog without sidebar */

get_header();
$classes = '';
$styles = '';

if (get_post_type() === 'portfolio') {
    if (!empty(pix_get_option('portfolio-bg-color'))) {
        if (pix_get_option('portfolio-bg-color') == 'custom') {
            $styles = 'style="background:' . pix_get_option('custom-portfolio-bg-color') . ';"';
        } else {
            $classes = 'bg-' . pix_get_option('portfolio-bg-color') . ' ';
        }
    }
} else {
    if (!empty(pix_get_option('blog-bg-color'))) {
        if (pix_get_option('blog-bg-color') == 'custom') {
            $styles = 'style="background:' . pix_get_option('custom-blog-bg-color') . ';"';
        } else {
            $classes = 'bg-' . pix_get_option('blog-bg-color') . ' ';
        }
    }
}

$hide_top_area = false;
$is_archive = false;
$post_type = get_post_type();
if (get_post_meta(get_the_ID(), 'pix-hide-top-area', true)) {
    if (get_post_meta(get_the_ID(), 'pix-hide-top-area', true) === '1') {
        $hide_top_area = true;
    }
    if (get_post_type() == 'page') {
        if (empty(pix_get_option('post-with-intro')) || !pix_get_option('post-with-intro')) {
            $hide_top_area = true;
        }
    }
} else {
    if(get_post_meta(get_the_ID(), 'pix-hide-top-area', true)===''){
        if (empty(pix_get_option('post-with-intro')) || !pix_get_option('post-with-intro')) {
            $hide_top_area = true;
        }
    }
}
if (is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag() || is_search()) {
    $hide_top_area = false;
    $is_archive = true;
    $classes .= 'pt-5';
    if (get_post_type() == 'portfolio' && !is_archive()) {
        if (empty(pix_get_option('portfolio-with-intro')) || !pix_get_option('portfolio-with-intro')) {
            $hide_top_area = true;
        }
    } else {
        if (empty(pix_get_option('post-with-intro')) || !pix_get_option('post-with-intro')) {
            $hide_top_area = true;
        }
    }
} else {
    if (pix_should_add_top_padding(null, 'blog-hide-top-padding')) {
        $classes .= 'pt-5';
    }
}
get_template_part('template-parts/intro');

?>
<div id="content" class="site-content template-blog-without-sidebar <?php echo esc_html($classes); ?>" <?php echo esc_html($styles); ?>>
    <div class="container">
        <div class="row">
            <?php
            if ($hide_top_area) {
            ?>
                <div class="pix-main-intro-placeholder"></div>
            <?php
            }
            if ($is_archive && $hide_top_area) { ?>
                <div class="col-12 pix-my-20">
                    <?php
                    if (is_search()) {
                    ?>
                        <h5 class="page-title text-heading-default font-weight-bold">
                            <?php
                            printf(esc_attr__('Search Results for: %s', 'conseil'), '<span>' . get_search_query() . '</span>');
                            ?>
                        </h5>
                    <?php
                    } else {
                        if(is_home()){
                            echo '<h5 class="page-title text-heading-default font-weight-bold">';
                            echo single_post_title('', false);
                            echo '</h5>';
                        } else {
                            the_archive_title('<h5 class="page-title text-heading-default font-weight-bold">', '</h5>');
                        }
                        the_archive_description('<div class="archive-description">', '</div>');
                    }
                    ?>
                </div>
            <?php } ?>
            <div class="col-12 pix-mb-20">
                <main id="main" class="site-main content-area">
                    <?php
                    // the_archive_description('<div class="archive-description">', '</div>');
                    pixfort_get_blog_page();
                    if (!$is_archive) {
                        the_content();
                    } else {
                        if (!have_posts()) {
                            get_template_part('template-parts/content', 'none');
                        }
                    }
                    ?>
                </main>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
