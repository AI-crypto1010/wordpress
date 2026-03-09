<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package pixfort theme
 */


$post_type = get_post_type();
$blog_bg_color = pix_get_option('blog-bg-color');
$pages_bg_color = pix_get_option('pages-bg-color');
$custom_blog_bg_color = pix_get_option('custom-blog-bg-color');
$custom_pages_bg_color = pix_get_option('custom-pages-bg-color');
$customTemplate = false;

get_header();

if ($post_type == 'post') {
	$bg_color = $blog_bg_color;
	$custom_color = $custom_blog_bg_color;
} else {
	$bg_color = $pages_bg_color;
	$custom_color = $custom_pages_bg_color;
}

$classes = '';
if (!empty($bg_color)) {
	$styles = ($bg_color == 'custom') ? 'background:' . $custom_color . ';' : '';
	$classes = ($bg_color != 'custom') ? 'bg-' . $bg_color . ' ' : '';
}

$add_intro_placeholder = false;
$post_intro = !empty(pix_get_option('post-with-intro')) && pix_get_option('post-with-intro');




?>
<div id="content" class="site-content <?php echo esc_html($classes); ?>" style="<?php echo esc_html($styles); ?>">
	<?php
	if ($add_intro_placeholder || post_password_required()) {
	?>
		<div class="pix-main-intro-placeholder"></div>
	<?php
	}
	the_post();
	the_content();
	?>
</div>
<?php
get_footer();
