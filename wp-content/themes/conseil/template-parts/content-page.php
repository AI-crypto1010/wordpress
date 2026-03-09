<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pixfort theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('entry-content2'); ?>>


	<?php
	if (post_password_required()) {
	?>
		<div class="pix-main-intro-placeholder"></div>
		<div class="container">
			<?php the_content(); ?>
		</div>
	<?php
	} else {
		the_content();
	}


	wp_link_pages(array(
		'before' => '<div class="page-links">' . esc_attr__('Pages:', 'conseil'),
		'after'  => '</div>',
	));
	?>
</article>