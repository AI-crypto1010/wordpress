<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pixfort theme
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h4 class="page-title text-heading-default font-weight-bold"><?php esc_html_e( 'Nothing Found', 'conseil' ); ?></h4>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) {

			printf(
				'<p class="texy-body-defaul">' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'conseil' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		} elseif ( is_search() ) {
			?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'conseil' ); ?></p>
			<?php
			if(class_exists('PixfortCore')){
				echo \PixfortCore::instance()->elementsManager->renderElement('Search');
			}

		} else {
			?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'conseil' ); ?></p>
			<?php
			if(class_exists('PixfortCore')){
				echo \PixfortCore::instance()->elementsManager->renderElement('Search');
			}

		}
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
