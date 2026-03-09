<?php /* Template Name: Portfolio Full width */

get_header();
require get_template_directory() . '/inc/portfolio-functions.php';
$classes = '';
$styles = '';
if (!empty(pix_get_option('portfolio-bg-color'))) {
    if (pix_get_option('portfolio-bg-color') == 'custom') {
        $styles = 'background:' . pix_get_option('custom-portfolio-bg-color') . ';';
    } else {
        $classes = 'bg-' . pix_get_option('portfolio-bg-color') . ' ';
    }
}
get_template_part('template-parts/intro');
if (pix_should_add_top_padding(null, 'portfolio-hide-top-padding')) {
    $classes .= 'pt-5';
}
?>
<div id="content" class="site-content pix-pt-40 <?php echo esc_html($classes); ?>" style="<?php echo esc_html($styles); ?>">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 pix-mb-20">
                <main id="main" class="site-main content-area">
                    <?php
                    pixfort_get_portfolio_page();
                    the_content();
                    ?>
                </main>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
