<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Blog
* --------------------------------------------------------------------------- */
class PixBlog {

	public function __construct() {
		include_once('extras/blog-functions.php');
	}

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'blog_style'					=> '',
			'blog_size'						=> 'lg',
			'title'							=> '',
			'count'							=> 5,
			'items_count'					=> 3,
			'category'						=> '',
			'category_multi'				=> '',
			'blog_style_box'				=> false,
			'blog_dark_mode'				=> '',
			'pagination'					=> false,
			'source'						=> '',
			'orderby'						=> 'date',
			'order'							=> 'DESC',
			'offset'						=> 0,
			'bottom_divider_select'			=> '',
			'bottom_moving_divider_color'	=> '',
			'bottom_layers'					=> '3',
			'pix_param_section_1'			=> '',
			'b_1_color'						=> '#fff',
			'b_2_color'						=> 'rgba(255,255,255,0.8)',
			'b_2_animation'					=> 'fade-in-up',
			'b_2_delay'						=> '300',
			'b_3_animation'					=> 'fade-in-up',
			'b_3_delay'						=> '400',
			'b_divider_in_front'			=> 'true',
			'b_flip_h'						=> '',
			'b_custom_height'				=> '50px',
			'animation' 					=> '',
			'delay' 						=> '0',
			'css' 							=> '',
		), $attr));

		$divider_out = '';
		if ($bottom_divider_select && $bottom_divider_select != '' && $bottom_divider_select != '0' && $bottom_divider_select != 'dynamic') {
			$b_divider_opts = array(
				'd_divider_select'			=> $bottom_divider_select,
				'd_layers'					=> $bottom_layers,
				'd_1_is_gradient'			=> '',
				'd_1_color'					=> $b_1_color,
				'd_2_is_gradient'			=> '',
				'd_2_color'					=> $b_2_color,
				'd_2_animation'				=> $b_2_animation,
				'd_2_delay'					=> $b_2_delay,
				'd_3_is_gradient'			=> '',
				'd_3_color'					=> '',
				'd_3_color_2'				=> '',
				'd_3_animation'				=> $b_3_animation,
				'd_3_delay'					=> $b_3_delay,
				'd_high_index'				=> $b_divider_in_front,
				'd_flip_h'					=> $b_flip_h,
			);
		}

		if ($bottom_divider_select && $bottom_divider_select != '' && $bottom_divider_select != '0' && $bottom_divider_select != 'dynamic') {
			$divider_out .= pix_get_divider($bottom_divider_select, '#fff', 'bottom', false, $bottom_moving_divider_color, $b_divider_opts, $b_custom_height);
		}
		if ($bottom_divider_select && $bottom_divider_select == 'dynamic') {
			$b_divider_opts = array(
				'd_divider_select'			=> $bottom_divider_select,
				'd_high_index'				=> $b_divider_in_front,
				'd_flip_h'					=> $b_flip_h,
			);
			$divider_out .= pix_get_divider($bottom_divider_select, '#fff', 'bottom', false, $bottom_moving_divider_color, $b_divider_opts, $b_custom_height);
		}

		$css_class = '';
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
		}

		// Only read paged query var if pagination is enabled
		if ($pagination) {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
		} else {
			$paged = 1;
		}

		$args = array(
			'posts_per_page'		=> intval($count),
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1,
			'orderby'				=> $orderby,
			'order'					=> $order,
			'paged' 				=> $paged
		);
		if($source == 'related'){
			$args=[
				'post__not_in' => [get_the_ID()],
				'category__in' => wp_get_post_categories(get_the_ID()),
				'posts_per_page'=>intval($count),
				'post_status'			=> 'publish',
				'paged' 				=> $paged,
				'ignore_sticky_posts'=> 1
			];
		}

		// Only add offset if it's greater than 0
		if (!empty($offset) && intval($offset) > 0) {
			$args['offset'] = ( intval($paged) - 1 ) * intval($count) + intval($offset);
			// $pagination = false;
		}

		// categories
		if ($category_multi) {
			$args['category_name'] = trim($category_multi);
		} elseif ($category) {
			$args['category_name'] = $category;
		}
		$output = '';
		$query_blog = new WP_Query($args);


		$prevIcon = 'Line/pixfort-icon-arrow-left-2';
		$nextIcon = 'Line/pixfort-icon-arrow-right-2';
		if (is_rtl()) {
			$prevIcon = 'Line/pixfort-icon-arrow-right-2';
			$nextIcon = 'Line/pixfort-icon-arrow-left-2';
		}

		$col = 12 / $items_count;
		$dark_mode_class = '';
		if(!empty($blog_dark_mode)){
			$dark_mode_class = 'pix-invert-colors';
		}
		$output .= '<div class="row ' . $css_class . ' ' . $dark_mode_class . '">';

		while ($query_blog->have_posts()) {
			$output .= '<div class="col-xs-12 col-md-' . $col . ' pix-mb-40">';
			$output .= pix_blog_item($query_blog, $attr, $divider_out);
			$output .= '</div>';
		}
		if ($pagination) {
			$output .=  '<div class="pix-pagination d-sm-flex pix-mt-20 w-100 justify-content-center align-items-center">';
			$output .=  paginate_links(array(
				'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
				'total'        => $query_blog->max_num_pages,
				'current'      => max(1, $paged),
				'format'       => '?paged=%#%',
				'show_all'     => false,
				'type'         => 'plain',
				'end_size'     => 2,
				'mid_size'     => 1,
				'prev_next'    => true,
				'prev_text'    => '<span class="d-sm-flex justify-content-center align-items-center">' . \PixfortCore::instance()->icons->getIcon($prevIcon) . '</span>',
				'next_text'    => '<span class="d-sm-flex justify-content-center align-items-center">' . \PixfortCore::instance()->icons->getIcon($nextIcon) . '</span>',
				'add_args'     => false,
				'add_fragment' => '',
			));
			$output .=  '</div>';
		}
		$output .= '</div>' . "\n";
		wp_reset_postdata();
		return $output;
	}
}
