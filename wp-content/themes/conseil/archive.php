<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pixfort theme
 */
$customTemplate = false;
if (class_exists('PixfortCore') 
	&& method_exists(\PixfortCore::instance()->themeBuilder, 'hasPageTemplate')) {
	$customTemplate = \PixfortCore::instance()->themeBuilder->hasPageTemplate();
}

if ($customTemplate) {
	if (class_exists('PixfortCore') 
		&& method_exists(\PixfortCore::instance()->themeBuilder, 'getPageTemplate')) {
		get_header();
		$classes = '';
		$styles = '';
		$hide_top_area = false;
		$is_archive = false;
		$post_type = get_post_type();
		if (!empty(pix_get_option('blog-bg-color'))) {
			if (pix_get_option('blog-bg-color') == 'custom') {
				$styles = 'style="background:' . pix_get_option('custom-blog-bg-color') . ';"';
			} else {
				$classes = 'bg-' . pix_get_option('blog-bg-color') . ' ';
			}
		}
		if (empty(pix_get_option('post-with-intro')) || !pix_get_option('post-with-intro')) {
            $hide_top_area = true;
        }
		if (empty(pix_get_option('post-with-intro')) || !pix_get_option('post-with-intro')) {
            $hide_top_area = true;
        }
		if (!$hide_top_area) {
			get_template_part('template-parts/intro');
		}
		?>
		<div id="content" class="site-content template-blog-full-width <?php echo esc_html($classes); ?>" style="<?php echo esc_html($styles); ?>">
			<?php
		echo \PixfortCore::instance()->themeBuilder->getPageTemplate();
		?>
		</div>
		<?php
		get_footer();

	}
} else { 
	$blog_template = 'right-sidebar';
	if (!empty(pix_get_option('blog-page-template'))) {
		$blog_template = pix_get_option('blog-page-template');
	}

	switch ($blog_template) {
		case 'left-sidebar':
			get_template_part('templates/template-blog-left-sidebar');
			break;
		case 'full-width':
			get_template_part('templates/template-blog-without-sidebar');
			break;
		case 'full-page-width':
			get_template_part('templates/template-blog-full-width');
			break;
		case 'with-offset':
			get_template_part('templates/template-blog-with-offset');
			break;
		default:
			get_template_part('templates/template-blog-right-sidebar');
	}
}