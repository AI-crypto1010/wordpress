<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}


/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
if (!function_exists('render_pix_small_search_block')) {
	function render_pix_small_search_block($attributes) {
		$link = admin_url('admin-ajax.php?action=pix_ajax_search');
		$search_data = 'data-search-link="' . $link . '"';

		// This is where you run the code and display the output
		$placeholder = esc_attr__('Search for something', 'pixfort-core');
		// Get current search query if on search results page
		$current_query = '';
		if (is_search()) {
			$current_query = get_search_query();
		}
		ob_start();
?>
		<div <?php echo get_block_wrapper_attributes(); ?>>
			<form class="pix-small-search pix-ajax-search-container position-relative shadow-sm rounded-lg pix-small-search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
				<div class="d-flex">
					<input type="search" class="form-control pix-ajax-search form-control-lg shadow-0 font-weight-bold text-body-default" name="s" autocomplete="off" placeholder="<?php echo esc_attr($placeholder); ?>" aria-label="Search" value="<?php echo esc_attr($current_query); ?>" <?php echo $search_data; ?> />
					<button class="btn btn-search btn-white m-0 text-body-default" aria-label="Search" type="submit"><?php echo pixGetFileContents( '/functions/images/search.svg'); ?></button>
					<?php
					if (function_exists('pll_current_language')) {
					?>
						<input type="hidden" name="lang" value="<?php echo esc_attr(pll_current_language()); ?>">
					<?php
					}
					?>
				</div>
			</form>
		</div>
<?php
		return ob_get_clean();
	}
}
echo render_pix_small_search_block($attributes);
