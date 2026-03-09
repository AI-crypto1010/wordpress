<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pixfort theme
 */


if (!empty($_GET["template"])) {
	switch ($_GET["template"]) {
		case 'blog-right-sidebar':
			get_template_part('templates/template-blog-right-sidebar');
			break;
		case 'blog-left-sidebar':
			get_template_part('templates/template-blog-left-sidebar');
			break;
		case 'full-width':
			get_template_part('templates/template-full-width');
			break;
		default:
			break;
	}
}


get_header();

$classes = '';
$styles = '';
$col_classes = 'col-12';

if (!empty(pix_get_option('pages-bg-color'))) {
	if (pix_get_option('pages-bg-color') == 'custom') {
		$styles = 'background:' . pix_get_option('custom-pages-bg-color') . ';';
		$classes = '';
	} else {
		$classes = 'bg-' . pix_get_option('pages-bg-color') . ' ';
	}
}


get_template_part('template-parts/intro');


if (!defined('PIXFORT_PLUGIN_VERSION')) {
	$classes .= ' pix-pb-20 ';
}

if (pix_should_add_top_padding()) {
	$classes .= 'pt-5';
}
$addContainer = true;
if (class_exists('\Elementor\Plugin')) {
	if (Elementor\Plugin::instance()->documents->get(get_the_ID()) && Elementor\Plugin::instance()->documents->get(get_the_ID())->is_built_with_elementor()) {
		$addContainer = false;
	}
}
$customTemplate = false;
if (
	class_exists('PixfortCore')
	&& method_exists(\PixfortCore::instance()->themeBuilder, 'hasPageTemplate')
) {
	$customTemplate = \PixfortCore::instance()->themeBuilder->hasPageTemplate();
}

?><div id="content" class="site-content <?php echo esc_html($classes); ?>" style="<?php echo esc_html($styles); ?>">
	<?php
	if ($customTemplate) {
		if (
			class_exists('PixfortCore')
			&& method_exists(\PixfortCore::instance()->themeBuilder, 'getPageTemplate')
		) {
			echo \PixfortCore::instance()->themeBuilder->getPageTemplate();
		}
	} else {
		if ($addContainer) {
			echo '<div class="container my-0 py-0">';
		}
	?>
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
	<?php if ($addContainer) {
			echo '</div>';
		}
	}
	?>
</div>
<?php
get_footer();
