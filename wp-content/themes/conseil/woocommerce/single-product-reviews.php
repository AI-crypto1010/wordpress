<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews">
	<div id="comments">
		<!-- <h3 class="woocommerce-Reviews-title text-gray-7 mb-2"><strong><?php
			if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) ) {
				/* translators: 1: reviews count 2: product name */
				printf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'conseil' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
			} else {
				_e( 'Reviews', 'conseil' );
			}
		?></strong></h3> -->

		<?php if ( have_comments() ) : ?>

			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews bg-transparent text-center w-100 text-body-default"><?php echo esc_html__( 'There are no reviews yet.', 'conseil' ); ?></p>

		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
					$commenter = wp_get_current_commenter();
					$req = get_option( 'require_name_email' );


					$comment_form = array(
						'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'conseil' ) : sprintf( esc_attr__( 'Be the first to review &ldquo;%s&rdquo;', 'conseil' ), get_the_title() ),
						'title_reply_to'       => esc_attr__( 'Leave a Reply to %s', 'conseil' ),
						'title_reply_before'   => '<h5 id="reply-title" class="comment-reply-title pix-mb-10 font-weight-bold text-heading-default text-center">',
						'title_reply_after'    => '</h5>',
						'comment_notes_after'  => '',
						'fields'               => array(
							'author' => '<p class="comment-form-author  d-block w-100 pix-mb-20">' .
										'<input class="form-control font-weight-bold shadow-sm" id="author" placeholder="' . esc_html__( 'Name *', 'conseil' ) . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required /></p>',
							'email'  => '<p class="comment-form-email d-block w-100 pix-mb-20">' .
										'<input class="form-control font-weight-bold shadow-sm" id="email" placeholder="' . esc_html__( 'Email *', 'conseil' ) . '" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" required /></p>',
						),
						'label_submit'  => esc_attr__( 'Submit', 'conseil' ),
						'logged_in_as'  => '',
						'comment_field' => '',
						'comment_notes_before' => '<p class="comment-notes w-100 text-center pix-mb-40 text-body-default">' .
					    esc_attr__( 'Your email address will not be published.', 'conseil' ) .
					    '</p>',

					);

					if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
						$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'conseil' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
					}
					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$comment_form['comment_field'] = '<div class="comment-form-rating align-items-center justify-content-between w-100 pix-py-10 pix-px-20  bg-white rounded-lg shadow-sm d-flex"><label class="m-0 font-weight-bold text-body-default text-sm" for="rating">' . esc_html__( 'Your rating', 'conseil' ) . '</label><select name="rating" id="rating" required>
							<option value="">' . esc_html__( 'Rate&hellip;', 'conseil' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'conseil' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'conseil' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'conseil' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'conseil' ) . '</option>
							<option value="1">' . esc_html__( 'Very poor', 'conseil' ) . '</option>
						</select></div>';
					}

					$comment_form['comment_field'] .= '<p class="comment-form-comment  pix-my-20 d-block w-100"><textarea class="form-control font-weight-bold shadow-sm" placeholder="'.esc_html__( 'Write your review', 'conseil' ) . '" id="comment" name="comment" cols="45" rows="8" required></textarea></p>';
					$comment_form['class_submit'] = 'btn btn-primary btn-block bg-primary text-white btn-lg pix-py-20 shadow-hover-sm shadow-sm';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php echo esc_html__( 'Only logged in customers who have purchased this product may leave a review.', 'conseil' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>
</div>
