<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Portfolio
* --------------------------------------------------------------------------- */
class PixPortfolio {

	public function __construct() {
		include_once('extras/portfolio-functions.php');
	}
	
	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'portfolio_style'   => '',
			'line_count' 		=> '4',
			'count' 			=> '6',
			'category' 			=> '',
			'style'				=> 'one',
			'category_multi'	=> '',
			'orderby' 			=> 'date',
			'order' 			=> 'DESC',
			'filters' 			=> 0,
			'filters_align' 			=> 'center',
			'rounded_img' 			=> 'rounded-lg',
			'pagination'		=> '',
			'post_type'		=> 'portfolio',
			'css'		=> '',
		), $attr));

		if(!is_array($attr)) { $attr = []; }
		if(!is_array($post_type)) {
			$post_type = str_replace(' ', '', $post_type);
			$post_type = explode(',', $post_type);
		}
		
		$css_class = '';
		if(function_exists('vc_shortcode_custom_css_class')){
		    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
		}
		wp_enqueue_script('pix-flickity-js');
		// $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
		$paged = 1;
		if(is_front_page()) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		}else {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}
		
		$args = array(
			'post_type' 			=> $post_type,
			'posts_per_page' 		=> $count,
			'paged' 				=> $paged,
			'orderby' 				=> $orderby,
			'order' 				=> $order,
			'ignore_sticky_posts' 	=> 1,
		);
		$customCats = array(
			'portfolio'	=> 'portfolio-types',
			'product'	=> 'product_cat',
		);
		$customCats = apply_filters( 'pixfort/custom_types/categories', $customCats );
		$taxonomies = array();
		foreach ($post_type as $value) {
			if(!empty($customCats[$value])){
					array_push($taxonomies, $customCats[$value]);
			}else{
				array_push($taxonomies, 'category');
			}
		}
		if(!$attr) $attr = [];
		$attr['customCats'] = $customCats;
		$attr['taxonomies'] = $taxonomies;
		if( !empty($category) ){
			$category = trim( $category );
			$category = str_replace(' ', '', $category);
			$category_arr = explode(',', $category);
			
			$tax_query = [];
			if(count($taxonomies)>1){
				$tax_query['relation'] = 'OR';
			}
			foreach ($taxonomies as $key => $value) {
				array_push($tax_query, [
					'taxonomy' => $value,
					'field' => 'slug',
					'terms' => $category_arr
				]);
			}
			$args['tax_query'] = $tax_query;
			// $args['tax_query'] = array(
			// 			    array(
			// 			    'taxonomy' => 'portfolio-types',
			// 			    'field' => 'slug',
			// 			    'terms' => $category_arr
			// 			     )
			// 			 );
		}
		$query_portfolio = new WP_Query( $args );
		$output = '';
		$output = '<div class="'.$css_class.'">';
			$output .= pix_content_portfolio($query_portfolio, $attr);
		$output .= '</div>';

		return $output;
	}
}












function pix_content_portfolio( $query = false, $attr = false  ){
	$output = '';
	if( ! $query ) {
		global $wp_query;
		$query = $wp_query;
	}
	extract(shortcode_atts(array(
			'line_count' 		=> '4',
			'count' 			=> '9',
			'category' 			=> '',
			'style'				=> 'one',
			'category_multi'	=> '',
			'orderby' 			=> 'date',
			'order' 			=> 'DESC',
			'filters' 			=> 0,
			'filters_align' 			=> 'center',
			'filter_light' 			=> '',
			'rounded_img' 			=> 'rounded-lg',
			'pagination'		=> '',
			'portfolio_style'   => '',
			'taxonomies'   => '',
		), $attr));

	$isotope_class = 'portfolio_grid';
    $output .= '<div class="pix-portfolio">';
		if($filters){
			$output .= pix_portfolio_nav($filters_align, $filter_light, $category, $taxonomies);
		}
    	if ( $query->have_posts() ){
            $output .= '<div class=" '.$isotope_class.'" style="width:100%">';
    		    while ( $query->have_posts() ){
					switch ($portfolio_style) {
					    case 'mini':
					        $output .= pix_portfolio_style_mini($query, true, $attr);
					        break;
					    case 'transparent':
					        $output .= pix_portfolio_style_transparent($query,true, $attr);
					        break;
					    case '3d':
					        $output .= pix_portfolio_style_3d($query, true,$attr);
					        break;
					    default:
					        $output .= pix_portfolio_style_default($query, true,$attr);
					}
    			}
    		$output .= '</div>';
    		if($pagination){ $output .= pix_pagination( $query ); }
    	}
    $output .= '</div>';
	wp_reset_postdata();

	return $output;
};







function pix_portfolio_nav($filters_align, $filter_light, $category, $taxonomies){
	$category_arr = false;
	if( !empty($category) ){
		$category = trim( $category );
		$category = str_replace(' ', '', $category);
		$category_arr = explode(',', $category);
	}
	$all = esc_attr__('All', 'pixfort-core');
	$output = '<div class="col-12 pix-pb-50 text-'.$filters_align.' '.$filter_light.' pix-portfolio-nav">';
		$output .= '<a href="#" data-category="*" class="portfolio_filter is-checked btn btn-link"><strong>'.$all.'</strong></a>';
		$termArgs = array();
		$termArgs = apply_filters( 'pixfort_custom_portfolio_nav_args', $termArgs );
		foreach ($taxonomies as $value) {
			if( $portfolio_categories = get_terms($value, $termArgs) ){
				foreach( $portfolio_categories as $category ){
					if($category_arr){
						if(in_array($category->slug, $category_arr)){
							$output .= '<a href="#" data-category=".category-'. $category->slug .'" class="portfolio_filter btn btn-link"><strong>'. $category->name .'</strong></a>';
						}
					}else{
						$output .= '<a href="#" data-category=".category-'. $category->slug .'" class="portfolio_filter btn btn-link"><strong>'. $category->name .'</strong></a>';
					}
	
				}
			}	
		}
		
	$output .= '</div>';
	return $output;
}


function pix_pagination($the_query){
	$paged = 1;
	if(is_front_page()) {
		$paged = (get_query_var('page')) ? get_query_var('page') : 1;
	}else {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	}

	$prevIcon = 'Line/pixfort-icon-arrow-left-2';
	$nextIcon = 'Line/pixfort-icon-arrow-right-2';
	if (is_rtl()) {
		$prevIcon = 'Line/pixfort-icon-arrow-right-2';
		$nextIcon = 'Line/pixfort-icon-arrow-left-2';
	}
	$output = '';
	 $output .= '<div class="pix-pagination d-sm-flex justify-content-center align-items-center">';
        $output .= paginate_links( array(
           'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
           'total'        => $the_query->max_num_pages,
           'current'      => $paged,
           'format'       => '?paged=%#%',
           'show_all'     => false,
           'type'         => 'plain',
           'end_size'     => 2,
           'mid_size'     => 1,
           'prev_next'    => true,
           'prev_text'    => '<span class="d-sm-flex justify-content-center align-items-center">'.\PixfortCore::instance()->icons->getIcon($prevIcon).'</span>',
           'next_text'    => '<span class="d-sm-flex justify-content-center align-items-center">'.\PixfortCore::instance()->icons->getIcon($nextIcon).'</span>',
           'add_args'     => false,
           'add_fragment' => '',
       ) );
   $output .= '</div>';

   $output .= '<div class="pix-mb-40">';
    $output .= get_the_posts_navigation();
    $output .= '</div>';
	return $output;
}



