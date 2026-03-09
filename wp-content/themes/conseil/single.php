<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package pixfort theme
 */

get_header();

$post_type = get_post_type();
$blog_bg_color = pix_get_option('blog-bg-color');
$pages_bg_color = pix_get_option('pages-bg-color');
$custom_blog_bg_color = pix_get_option('custom-blog-bg-color');
$custom_pages_bg_color = pix_get_option('custom-pages-bg-color');

if ($post_type == 'post') {
	$bg_color = $blog_bg_color;
	$custom_color = $custom_blog_bg_color;
} else {
	$bg_color = $pages_bg_color;
	$custom_color = $custom_pages_bg_color;
}

$classes = '';
$styles = '';
if (!empty($bg_color)) {
	$styles = ($bg_color == 'custom') ? 'background:' . $custom_color . ';' : '';
	$classes = ($bg_color != 'custom') ? 'bg-' . $bg_color . ' ' : '';
}

$add_intro_placeholder = false;
$post_intro = !empty(pix_get_option('post-with-intro')) && pix_get_option('post-with-intro');

if ($post_type == 'post') {
	if (!$post_intro) {
		$add_intro_placeholder = true;
	}
} 
get_template_part('template-parts/intro');


$customTemplate = false;
if (
	class_exists('PixfortCore')
	&& method_exists(\PixfortCore::instance()->themeBuilder, 'hasPageTemplate')
) {
	$customTemplate = \PixfortCore::instance()->themeBuilder->hasPageTemplate();
}
if (!$customTemplate&&pix_should_add_top_padding(null, 'blog-hide-top-padding')) {
	if ($post_type !== 'elementor_library') {
		$classes .= 'pix-pt-20';
	}
}

?>
<div id="content" class="site-content <?php echo esc_html($classes); ?>" style="<?php echo esc_html($styles); ?>">
	<?php
	if ($customTemplate) {
		if (
			class_exists('PixfortCore')
			&& method_exists(\PixfortCore::instance()->themeBuilder, 'getPageTemplate')
		) {
			echo \PixfortCore::instance()->themeBuilder->getPageTemplate();
		}
	} else {
		$containerClass = 'container';
		if ($post_type == 'post' && !empty(pix_get_option('blog-full-width-layout'))) {
			$containerClass = 'container-fluid';
		} else if ($post_type === 'elementor_library') {
			$containerClass = 'container-fluid mx-0 px-0';
		}
	?>
		<div class="<?php echo esc_attr($containerClass); ?>">
			<div class="row">
				<?php
				if ($add_intro_placeholder || post_password_required()) {
				?>
					<div class="pix-main-intro-placeholder"></div>
					<?php
				}
				$blog_layout = 'default';
				if (!empty(pix_get_option('blog-layout'))) {
					$blog_layout = pix_get_option('blog-layout');
				}
				while (have_posts()) :
					the_post();
					if ($post_type == 'post') {
						switch ($blog_layout) {
							case 'left-sidebar':
								get_template_part('template-parts/content', 'post-sidebar');
								break;
							case 'right-sidebar':
								get_template_part('template-parts/content', 'post-sidebar');
								break;
							case 'default-normal':
								get_template_part('template-parts/content', 'post-normal');
								break;
							default:
								get_template_part('template-parts/content', 'post');
						}
					} elseif (get_post_type() == 'search') {
						get_template_part('template-parts/content', 'search');
					} elseif (get_post_type() == 'none') {
						get_template_part('template-parts/content', 'none');
					} else {
					?>
						<div class="col-12">
							<?php
							get_template_part('template-parts/content', 'page');
							?>
						</div>
				<?php
					}
				endwhile;
				?>
			</div>
		</div>
	<?php } ?>
</div>
<?php
get_footer();
