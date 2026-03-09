<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pixfort theme
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h5 class="comments-title text-heading-default text-center font-weight-bold my-3">
			<?php
			$pix_comment_count = get_comments_number();
			if ( '1' === $pix_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_attr__( '1 Comment', 'conseil' )
				);
			} else {
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s Comments', '%1$s Comments', $pix_comment_count, 'comments title', 'conseil' ) ),
					number_format_i18n( $pix_comment_count )
				);
			}
			?>
		</h5><!-- .comments-title -->

		<?php the_comments_navigation(); ?>
		
		<div class="comment-list">
			<?php
			$args = array(
				'style'             => 'div',
				'callback'          => 'pixfort_comment_template',
				'type'              => 'all',
				'reply_text'        => esc_attr__( 'Reply', 'conseil' ),
				'avatar_size'		=> 80
			);
			wp_list_comments($args);
			?>
		</div>

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'conseil' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form();
	?>

</div><!-- #comments -->
