<?php

/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package pixfort theme
 */

if (!function_exists('pixfort_posted_on')) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function pixfort_posted_on($echo = true) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if (get_the_time('U') !== get_the_modified_time('U')) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}
		$time_string = sprintf(
			$time_string,
			esc_attr(get_the_date(DATE_W3C)),
			esc_html(get_the_date()),
			esc_attr(get_the_modified_date(DATE_W3C)),
			esc_html(get_the_modified_date())
		);
		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x('Posted on %s', 'post date', 'conseil'),
			'<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
		);
		if ($echo) {
			echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
		} else {
			return '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
		}
	}
endif;

if (!function_exists('pixfort_posted_by')) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function pixfort_posted_by() {
?>
		<span class="byline">
			<?php
			sprintf(
				/* translators: %s: post author. */
				esc_html_x('by %s', 'post author', 'conseil'),
				'<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
			);
			?>
		</span>
		<?php
	}
endif;



if (!function_exists('pixfort_post_thumbnail')) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function pixfort_post_thumbnail($size = 'post-thumbnail', $attr = '') {
		if (post_password_required() || is_attachment()) {
			return;
		}
		if( !empty(pix_get_option('pix-disable-post-thumbnail')) ){
			if(pix_get_option('pix-disable-post-thumbnail')){
				return;
			}
		}
		if (is_singular()) :
		?>
			<div class="post-thumbnail">
				<?php
				pix_get_post_simple_thumb();
				?>
			</div><!-- .post-thumbnail -->
		<?php else : ?>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail('post-thumbnail', $attr);
				?>
			</a>
<?php
		endif; // End is_singular().
	}
endif;
