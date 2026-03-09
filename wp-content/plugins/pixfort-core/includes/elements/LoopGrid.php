<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/* ---------------------------------------------------------------------------
* Loop Grid
* --------------------------------------------------------------------------- */
class PixLoopGrid {

	private $current_template_id = 0;

	function render($attr, $content = null) {
		extract(shortcode_atts(array(
			'template_type'				=> 'post',
			'template_id'				=> '',
			'columns'					=> 3,
			'columns_tablet'			=> 2,
			'columns_mobile'			=> 1,
			'posts_per_page'			=> 8,
			'masonry'					=> '',
			'equal_height'				=> '',
			'alternate_template'		=> '',
			'alternate_template_id'		=> '',
			'alternate_position'		=> 1,
			// Source for posts template type
			'source'					=> 'post',
			// Source for products template type
			'source_product'			=> 'latest',
			// Source for post taxonomy template type
			'source_post_taxonomy'		=> 'category',
			// Source for product taxonomy template type
			'source_product_taxonomy'	=> 'product_cat',
			// Manual selection
			'manual_selection_post_ids'		=> [],
			'manual_selection_product_ids'	=> [],
			// Taxonomy options
			'taxonomy_filter_by'		=> '',
			'taxonomy_term_ids'			=> [],
			'taxonomy_parent_term_id'	=> '',
			'taxonomy_orderby'			=> 'name',
			'taxonomy_order'			=> 'DESC',
			'taxonomy_hide_empty'		=> 'yes',
			// Post/Product query options
			'include_by'				=> [],
			'include_term_ids'			=> '',
			'include_author_ids'		=> '',
			'exclude_by'				=> [],
			'exclude_term_ids'			=> '',
			'exclude_author_ids'		=> '',
			'date_filter'				=> '',
			'date_before'				=> '',
			'date_after'				=> '',
			'orderby'					=> 'date',
			'order'						=> 'DESC',
			'ignore_sticky_posts'		=> 'yes',
			'offset'					=> 0,
			'query_id'					=> '',
			'pagination_type'			=> '',
			'load_more_text'			=> 'Load More',
			'animation'			=> '',
			'animation_delay'		=> '100',
			'nothing_found_message'		=> 'No posts found.',
			'column_gap'				=> ['size' => 22, 'unit' => 'px'],
			'row_gap'					=> ['size' => 20, 'unit' => 'px'],
			'css'						=> '',
		), $attr));

		$output = '';
		
        if(empty($template_id)) {
			// $output = '<div>';
			// $output .= '<h3>' . __('Loop Grid starts with a template', 'pixfort-core') . '</h3>';
			// $output .= '<p>' . __('Choose an existing template or create a new one to use it as the loop template.', 'pixfort-core') . '</p>';
			// $output	.= '</div>';
			return $output;
		};
		// Store template_id for AJAX loading params
		$this->current_template_id = !empty($template_id) ? intval($template_id) : 0;

		// Wrapper classes
		$wrapper_classes = ['pix-loop-grid-wrapper'];

		// Grid classes
		$grid_classes = ['pix-loop-grid'];
		// if ($masonry === 'yes') {
		// 	$grid_classes[] = 'pix-loop-grid-masonry';
		// }
		if ($equal_height === 'yes' && $masonry !== 'yes') {
			$grid_classes[] = 'pix-loop-grid-equal-height';
		}

		$wrapper_class = implode(' ', $wrapper_classes);
		$grid_class = implode(' ', $grid_classes);

		// Generate unique ID for this grid instance
		$grid_id = 'pix-loop-grid-' . substr(md5(json_encode($attr) . time()), 0, 8);

		// Start output
		$output .= '<div id="' . esc_attr($grid_id) . '" class="' . esc_attr($wrapper_class) . '">';

		// Initialize variables for pagination
		$query = null;
		$pagination_data = null;
		$args = [];

		// Check if this is a taxonomy template type
		if (in_array($template_type, ['post_taxonomy', 'product_taxonomy'])) {
			// Render taxonomy loop
			$taxonomy_result = $this->render_taxonomy_loop($attr, $grid_class, $template_id, $animation, $animation_delay, $nothing_found_message);
			$output .= $taxonomy_result['output'];
			$pagination_data = $taxonomy_result['pagination_data'];

			// Prepare args for AJAX pagination (taxonomy-specific)
			$args = [
				'template_type' => $template_type,
				'taxonomy' => $template_type === 'product_taxonomy' ?
					(!empty($attr['source_product_taxonomy']) ? $attr['source_product_taxonomy'] : 'product_cat') :
					(!empty($attr['source_post_taxonomy']) ? $attr['source_post_taxonomy'] : 'category'),
				'posts_per_page' => !empty($attr['posts_per_page']) ? intval($attr['posts_per_page']) : 8,
				'taxonomy_hide_empty' => !empty($attr['taxonomy_hide_empty']) ? $attr['taxonomy_hide_empty'] : '',
				'taxonomy_orderby' => !empty($attr['taxonomy_orderby']) ? $attr['taxonomy_orderby'] : 'name',
				'taxonomy_order' => !empty($attr['taxonomy_order']) ? $attr['taxonomy_order'] : 'DESC',
			];

			// Add filter settings for AJAX
			if (!empty($attr['taxonomy_filter_by'])) {
				$args['taxonomy_filter_by'] = $attr['taxonomy_filter_by'];
				if ($attr['taxonomy_filter_by'] === 'manual' && !empty($attr['taxonomy_term_ids'])) {
					$args['taxonomy_term_ids'] = $attr['taxonomy_term_ids'];
				}
				if ($attr['taxonomy_filter_by'] === 'by_parent' && !empty($attr['taxonomy_parent_term_id'])) {
					$args['taxonomy_parent_term_id'] = $attr['taxonomy_parent_term_id'];
				}
			}
		} else {
			// Render post/product loop
			// Build query args
			$args = $this->build_query_args($attr);

			// Allow filtering of query args via query_id
			if (!empty($query_id)) {
				$args = apply_filters('pixfort/loop_grid/query/' . $query_id, $args);
			}

			// Apply global filter
			$args = apply_filters('pixfort/loop_grid/query', $args, $attr);

			// Create query
			$query = new WP_Query($args);

			if ($query->have_posts()) {
				$output .= '<div class="' . esc_attr($grid_class) . '">';

				$item_index = 0;
				while ($query->have_posts()) {
					$query->the_post();
					$item_index++;

					// Determine which template to use
					$current_template_id = $template_id;
					if ($alternate_template === 'yes' && !empty($alternate_template_id)) {
						if ($item_index == intval($alternate_position)) {
							$current_template_id = $alternate_template_id;
						}
					}

					// Build animation attributes
					$item_anim_attrs = '';
					$item_classes = ['pix-loop-grid-item'];
					if (!empty($animation)) {
						$item_classes[] = 'animate-in';
						$item_delay = intval($animation_delay) * $item_index;
						$item_anim_attrs = ' data-anim-type="' . esc_attr($animation) . '" data-anim-delay="' . esc_attr($item_delay) . '"';
					}

					// Render the template
					$item_output = $this->render_template($current_template_id, get_the_ID());

					$output .= '<div class="' . implode(' ', $item_classes) . '"' . $item_anim_attrs . '>';
					$output .= $item_output;
					$output .= '</div>';
				}

				$output .= '</div>';
			} else {
				
				// No posts found
				$output .= '<div class="pix-loop-grid-nothing-found">';
				$output .= do_shortcode($nothing_found_message);
				$output .= '</div>';
			}

			wp_reset_postdata();
		}

		// Pagination
		if (!empty($pagination_type)) {
			$output .= $this->render_pagination($attr, $query, $pagination_type, $load_more_text, $grid_id, $args, $pagination_data);
		}

		$output .= '</div>';

		// Enqueue styles
        wp_enqueue_style('pix-loop-grid', PIXFORT_PLUGIN_URL . 'includes/assets/css/elements/loop-grid.min.css', false, PIXFORT_PLUGIN_VERSION);

		return $output;
	}

	/**
	 * Render taxonomy loop for post_taxonomy and product_taxonomy template types
	 */
	private function render_taxonomy_loop($attr, $grid_class, $template_id, $animation, $animation_delay, $nothing_found_message) {
		$output = '';
		$template_type = !empty($attr['template_type']) ? $attr['template_type'] : 'post_taxonomy';

		// Determine taxonomy source
		$taxonomy = '';
		if ($template_type === 'product_taxonomy') {
			$taxonomy = !empty($attr['source_product_taxonomy']) ? $attr['source_product_taxonomy'] : 'product_cat';
		} else {
			$taxonomy = !empty($attr['source_post_taxonomy']) ? $attr['source_post_taxonomy'] : 'category';
		}

		// Build term query args
		$term_args = [
			'taxonomy' => $taxonomy,
			'hide_empty' => (!empty($attr['taxonomy_hide_empty']) && $attr['taxonomy_hide_empty'] === 'yes'),
			'orderby' => !empty($attr['taxonomy_orderby']) ? $attr['taxonomy_orderby'] : 'name',
			'order' => !empty($attr['taxonomy_order']) ? $attr['taxonomy_order'] : 'DESC',
			'number' => !empty($attr['posts_per_page']) ? intval($attr['posts_per_page']) : 8,
		];

		// Filter by manual selection
		if (!empty($attr['taxonomy_filter_by']) && $attr['taxonomy_filter_by'] === 'manual') {
			if (!empty($attr['taxonomy_term_ids'])) {
				$term_ids = is_array($attr['taxonomy_term_ids']) ? $attr['taxonomy_term_ids'] : explode(',', $attr['taxonomy_term_ids']);
				$term_args['include'] = array_map('intval', $term_ids);
			}
		}

		// Filter by parent
		if (!empty($attr['taxonomy_filter_by']) && $attr['taxonomy_filter_by'] === 'by_parent') {
			if (!empty($attr['taxonomy_parent_term_id'])) {
				$term_args['parent'] = intval($attr['taxonomy_parent_term_id']);
			} else {
				$term_args['parent'] = 0; // Top-level terms only
			}
		}

		// Handle pagination for taxonomy terms
		$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
		$posts_per_page = !empty($attr['posts_per_page']) ? intval($attr['posts_per_page']) : 8;

		// Calculate offset for pagination (skip items from previous pages)
		if ($paged > 1) {
			$term_args['offset'] = ($paged - 1) * $posts_per_page;
		}

		// Allow filtering of term args
		if (!empty($attr['query_id'])) {
			$term_args = apply_filters('pixfort/loop_grid/term_query/' . $attr['query_id'], $term_args);
		}
		$term_args = apply_filters('pixfort/loop_grid/term_query', $term_args, $attr);

		// Calculate pagination info
		$pagination_data = null;
		if (!empty($attr['pagination_type'])) {
			// Get total count without limit or offset for pagination calculation
			$count_args = $term_args;
			$count_args['number'] = 0; // Remove limit to get total count
			$count_args['offset'] = 0; // Remove offset to count all terms
			$count_args['fields'] = 'count'; // Only count, don't fetch terms
			$total_terms = get_terms($count_args);

			if (!is_wp_error($total_terms)) {
				$max_num_pages = ceil($total_terms / $posts_per_page);
				$pagination_data = [
					'max_num_pages' => $max_num_pages,
					'found_terms' => $total_terms,
					'terms_per_page' => $posts_per_page
				];
			}
		}

		// Get terms
		$terms = get_terms($term_args);

		if (!empty($terms) && !is_wp_error($terms)) {
			$output .= '<div class="' . esc_attr($grid_class) . '">';

			$item_index = 0;
			foreach ($terms as $term) {
				$item_index++;

				// Build animation attributes
				$item_anim_attrs = '';
				$item_classes = ['pix-loop-grid-item'];
				if (!empty($animation)) {
					$item_classes[] = 'animate-in';
					$item_delay = intval($animation_delay) * $item_index;
					$item_anim_attrs = ' data-anim-type="' . esc_attr($animation) . '" data-anim-delay="' . esc_attr($item_delay) . '"';
				}

				// Render the template for term
				$item_output = $this->render_term_template($template_id, $term);

				$output .= '<div class="' . implode(' ', $item_classes) . '"' . $item_anim_attrs . '>';
				$output .= $item_output;
				$output .= '</div>';
			}

			$output .= '</div>';
		} else {
			// No terms found
			$output .= '<div class="pix-loop-grid-nothing-found">';
			$output .= do_shortcode($nothing_found_message);
			$output .= '</div>';
		}

		return [
			'output' => $output,
			'pagination_data' => $pagination_data
		];
	}

	/**
	 * Render template for a term
	 */
	private function render_term_template($template_id, $term) {
		if (empty($template_id)) {
			return '';
		}

		// Set up the query context for this term - simple approach
		global $wp_query;
		$wp_query->loop_term = $term;

		// Render the Elementor template
		$output = '';
		if (class_exists('\Elementor\Plugin')) {
			$template_id = apply_filters('wpml_object_id', intval($template_id), 'elementor_library', true);
			$output = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($template_id, true);
		}

		// Clear the loop term
		$wp_query->loop_term = null;

		return $output;
	}

	/**
	 * Build query arguments
	 */
	private function build_query_args($attr) {
		$template_type = !empty($attr['template_type']) ? $attr['template_type'] : 'post';
		$posts_per_page = !empty($attr['posts_per_page']) ? intval($attr['posts_per_page']) : 8;
		$orderby = !empty($attr['orderby']) ? $attr['orderby'] : 'date';
		$order = !empty($attr['order']) ? $attr['order'] : 'DESC';

		// Handle product template type
		if ($template_type === 'product') {
			return $this->build_product_query_args($attr, $posts_per_page, $orderby, $order);
		}

		// Handle post template type
		$source = !empty($attr['source']) ? $attr['source'] : 'post';

		// Handle special source types
		if ($source === 'current_query') {
			return $this->build_current_query_args($attr, $posts_per_page);
		}

		if ($source === 'manual_selection') {
			return $this->build_manual_selection_args($attr, $posts_per_page, $orderby, $order);
		}

		if ($source === 'related') {
			return $this->build_related_posts_args($attr, $posts_per_page, $orderby, $order);
		}

		$args = [
			'post_type' => $source,
			'posts_per_page' => $posts_per_page,
			'post_status' => 'publish',
			'orderby' => $orderby,
			'order' => $order,
		];

		// Ignore sticky posts
		if (!empty($attr['ignore_sticky_posts']) && $attr['ignore_sticky_posts'] === 'yes') {
			$args['ignore_sticky_posts'] = true;
		}

		// Offset
		if (!empty($attr['offset']) && intval($attr['offset']) > 0) {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
			$args['offset'] = (intval($paged) - 1) * intval($attr['posts_per_page']) + intval($attr['offset']);
		}

		// Paged
		$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
		$args['paged'] = $paged;

		// Include terms
		if (!empty($attr['include_by']) && is_array($attr['include_by']) && in_array('terms', $attr['include_by'])) {
			if (!empty($attr['include_term_ids'])) {
				$term_ids = is_array($attr['include_term_ids']) ? $attr['include_term_ids'] : explode(',', $attr['include_term_ids']);
				if (!empty($term_ids)) {
					$tax_query = [];
					foreach ($term_ids as $term_id) {
						$term = get_term(intval($term_id));
						if ($term && !is_wp_error($term)) {
							$tax_query[] = [
								'taxonomy' => $term->taxonomy,
								'field' => 'term_id',
								'terms' => intval($term_id),
							];
						}
					}
					if (!empty($tax_query)) {
						$tax_query['relation'] = 'OR';
						$args['tax_query'] = $tax_query;
					}
				}
			}
		}

		// Include authors
		if (!empty($attr['include_by']) && is_array($attr['include_by']) && in_array('authors', $attr['include_by'])) {
			if (!empty($attr['include_author_ids'])) {
				$author_ids = is_array($attr['include_author_ids']) ? $attr['include_author_ids'] : explode(',', $attr['include_author_ids']);
				$args['author__in'] = array_map('intval', $author_ids);
			}
		}

		// Exclude current post
		if (!empty($attr['exclude_by']) && is_array($attr['exclude_by']) && in_array('current_post', $attr['exclude_by'])) {
			$args['post__not_in'] = [get_the_ID()];
		}

		// Exclude terms
		if (!empty($attr['exclude_by']) && is_array($attr['exclude_by']) && in_array('terms', $attr['exclude_by'])) {
			if (!empty($attr['exclude_term_ids'])) {
				$term_ids = is_array($attr['exclude_term_ids']) ? $attr['exclude_term_ids'] : explode(',', $attr['exclude_term_ids']);
				if (!empty($term_ids)) {
					$tax_query = isset($args['tax_query']) ? $args['tax_query'] : [];
					foreach ($term_ids as $term_id) {
						$term = get_term(intval($term_id));
						if ($term && !is_wp_error($term)) {
							$tax_query[] = [
								'taxonomy' => $term->taxonomy,
								'field' => 'term_id',
								'terms' => intval($term_id),
								'operator' => 'NOT IN',
							];
						}
					}
					if (!empty($tax_query)) {
						if (!isset($tax_query['relation'])) {
							$tax_query['relation'] = 'AND';
						}
						$args['tax_query'] = $tax_query;
					}
				}
			}
		}

		// Exclude authors
		if (!empty($attr['exclude_by']) && is_array($attr['exclude_by']) && in_array('authors', $attr['exclude_by'])) {
			if (!empty($attr['exclude_author_ids'])) {
				$author_ids = is_array($attr['exclude_author_ids']) ? $attr['exclude_author_ids'] : explode(',', $attr['exclude_author_ids']);
				$args['author__not_in'] = array_map('intval', $author_ids);
			}
		}

		// Date filter
		if (!empty($attr['date_filter'])) {
			$date_query = [];
			$now = current_time('timestamp');

			switch ($attr['date_filter']) {
				case 'past_day':
					$date_query['after'] = date('Y-m-d H:i:s', strtotime('-1 day', $now));
					break;
				case 'past_week':
					$date_query['after'] = date('Y-m-d H:i:s', strtotime('-1 week', $now));
					break;
				case 'past_month':
					$date_query['after'] = date('Y-m-d H:i:s', strtotime('-1 month', $now));
					break;
				case 'past_quarter':
					$date_query['after'] = date('Y-m-d H:i:s', strtotime('-3 months', $now));
					break;
				case 'past_year':
					$date_query['after'] = date('Y-m-d H:i:s', strtotime('-1 year', $now));
					break;
				case 'custom':
					if (!empty($attr['date_before'])) {
						$date_query['before'] = $attr['date_before'];
					}
					if (!empty($attr['date_after'])) {
						$date_query['after'] = $attr['date_after'];
					}
					break;
			}

			if (!empty($date_query)) {
				$date_query['inclusive'] = true;
				$args['date_query'] = [$date_query];
			}
		}

		return $args;
	}

	/**
	 * Build product query arguments
	 */
	private function build_product_query_args($attr, $posts_per_page, $orderby, $order) {
		$source = !empty($attr['source_product']) ? $attr['source_product'] : 'latest';

		$args = [
			'post_type' => 'product',
			'posts_per_page' => $posts_per_page,
			'post_status' => 'publish',
			'orderby' => $orderby,
			'order' => $order,
		];

		// Paged
		$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
		$args['paged'] = $paged;

		switch ($source) {
			case 'current_query':
				global $wp_query;
				if (!empty($wp_query->query_vars)) {
					$args = array_merge($args, $wp_query->query_vars);
					$args['posts_per_page'] = $posts_per_page;
				}
				break;

			case 'latest':
				// Default ordering by date
				$args['orderby'] = 'date';
				$args['order'] = 'DESC';
				break;

			case 'sale':
				$product_ids_on_sale = wc_get_product_ids_on_sale();
				if (!empty($product_ids_on_sale)) {
					$args['post__in'] = $product_ids_on_sale;
				} else {
					$args['post__in'] = [0]; // No products on sale
				}
				break;

			case 'featured':
				$args['tax_query'] = [
					[
						'taxonomy' => 'product_visibility',
						'field' => 'name',
						'terms' => 'featured',
						'operator' => 'IN',
					],
				];
				break;

			case 'manual_selection':
				if (!empty($attr['manual_selection_product_ids'])) {
					$product_ids = is_array($attr['manual_selection_product_ids']) 
						? $attr['manual_selection_product_ids'] 
						: explode(',', $attr['manual_selection_product_ids']);
					$args['post__in'] = array_map('intval', $product_ids);
					$args['orderby'] = 'post__in';
				} else {
					$args['post__in'] = [0]; // No products selected
				}
				break;

			case 'related':
				global $product;
				if (is_product() && $product instanceof \WC_Product) {
					$related_ids = wc_get_related_products($product->get_id(), $posts_per_page);
					if (!empty($related_ids)) {
						$args['post__in'] = $related_ids;
					} else {
						$args['post__in'] = [0];
					}
				} else {
					$args['post__in'] = [0];
				}
				break;

			case 'upsells':
				global $product;
				if (is_product() && $product instanceof \WC_Product) {
					$upsell_ids = $product->get_upsell_ids();
					if (!empty($upsell_ids)) {
						$args['post__in'] = $upsell_ids;
					} else {
						$args['post__in'] = [0];
					}
				} else {
					$args['post__in'] = [0];
				}
				break;

			case 'cross_sells':
				if (is_cart()) {
					$cross_sell_ids = WC()->cart->get_cross_sells();
					if (!empty($cross_sell_ids)) {
						$args['post__in'] = $cross_sell_ids;
					} else {
						$args['post__in'] = [0];
					}
				} else {
					global $product;
					if ($product instanceof \WC_Product) {
						$cross_sell_ids = $product->get_cross_sell_ids();
						if (!empty($cross_sell_ids)) {
							$args['post__in'] = $cross_sell_ids;
						} else {
							$args['post__in'] = [0];
						}
					} else {
						$args['post__in'] = [0];
					}
				}
				break;
		}

		// Exclude out of stock if WooCommerce setting is enabled
		if ('yes' === get_option('woocommerce_hide_out_of_stock_items')) {
			$args['meta_query'][] = [
				'key' => '_stock_status',
				'value' => 'instock',
				'compare' => '=',
			];
		}

		return $args;
	}

	/**
	 * Build current query arguments
	 */
	private function build_current_query_args($attr, $posts_per_page) {
		global $wp_query;
		
		$args = [
			'post_type' => 'post',
			'posts_per_page' => $posts_per_page,
			'post_status' => 'publish',
		];

		if (!empty($wp_query->query_vars)) {
			$args = array_merge($args, $wp_query->query_vars);
			$args['posts_per_page'] = $posts_per_page;
		}

		return $args;
	}

	/**
	 * Build manual selection query arguments
	 */
	private function build_manual_selection_args($attr, $posts_per_page, $orderby, $order) {
		$args = [
			'post_type' => 'any',
			'posts_per_page' => $posts_per_page,
			'post_status' => 'publish',
		];

		if (!empty($attr['manual_selection_post_ids'])) {
			$post_ids = is_array($attr['manual_selection_post_ids']) 
				? $attr['manual_selection_post_ids'] 
				: explode(',', $attr['manual_selection_post_ids']);
			$args['post__in'] = array_map('intval', $post_ids);
			$args['orderby'] = 'post__in';
		} else {
			$args['post__in'] = [0]; // No posts selected
		}

		return $args;
	}

	/**
	 * Build related posts query arguments
	 */
	private function build_related_posts_args($attr, $posts_per_page, $orderby, $order) {
		$current_post_id = get_the_ID();
		$current_post = get_post($current_post_id);

		$args = [
			'post_type' => $current_post ? $current_post->post_type : 'post',
			'posts_per_page' => $posts_per_page,
			'post_status' => 'publish',
			'orderby' => $orderby,
			'order' => $order,
			'post__not_in' => [$current_post_id],
		];

		// Get related by categories/tags
		if ($current_post) {
			$categories = wp_get_post_categories($current_post_id, ['fields' => 'ids']);
			$tags = wp_get_post_tags($current_post_id, ['fields' => 'ids']);

			$tax_query = ['relation' => 'OR'];
			
			if (!empty($categories)) {
				$tax_query[] = [
					'taxonomy' => 'category',
					'field' => 'term_id',
					'terms' => $categories,
				];
			}
			
			if (!empty($tags)) {
				$tax_query[] = [
					'taxonomy' => 'post_tag',
					'field' => 'term_id',
					'terms' => $tags,
				];
			}

			if (count($tax_query) > 1) {
				$args['tax_query'] = $tax_query;
			}
		}

		return $args;
	}

	/**
	 * Render an Elementor template
	 */
	private function render_template($template_id, $post_id) {
		if (empty($template_id)) {
			return '';
		}

		// Store the current post
		global $post;
		$original_post = $post;

		// Set up the post for the template
		$post = get_post($post_id);
		setup_postdata($post);

		// Render the Elementor template
		$output = '';
		if (class_exists('\Elementor\Plugin')) {
			$template_id = apply_filters('wpml_object_id', intval($template_id), 'elementor_library', true);
			$output = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($template_id, true);
		}

		// Restore the original post
		$post = $original_post;
		if ($original_post) {
			setup_postdata($original_post);
		}

		return $output;
	}

	/**
	 * Render pagination
	 */
	private function render_pagination($attr, $query, $pagination_type, $load_more_text, $grid_id, $args, $pagination_data = null) {
		$output = '';

		$prevIcon = 'Line/pixfort-icon-arrow-left-2';
		$nextIcon = 'Line/pixfort-icon-arrow-right-2';
		if (is_rtl()) {
			$prevIcon = 'Line/pixfort-icon-arrow-right-2';
			$nextIcon = 'Line/pixfort-icon-arrow-left-2';
		}

		$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);

		// Determine max pages based on query type
		$max_num_pages = 1;
		if ($pagination_data) {
			// Taxonomy pagination
			$max_num_pages = $pagination_data['max_num_pages'];
		} elseif ($query && isset($query->max_num_pages)) {
			// Post/product pagination
			$max_num_pages = $query->max_num_pages;
		}

		switch ($pagination_type) {
			case 'numbers':
				$output .= '<div class="pix-loop-grid-pagination pix-pagination d-flex pix-mt-20 w-100 justify-content-center align-items-center">';
				$output .= paginate_links([
					'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
					'total' => $max_num_pages,
					'current' => max(1, $paged),
					'format' => '?paged=%#%',
					'show_all' => false,
					'type' => 'plain',
					'end_size' => 2,
					'mid_size' => 1,
					'prev_next' => false,
					'add_args' => false,
					'add_fragment' => '',
				]);
				$output .= '</div>';
				break;

			case 'prev_next':
				$output .= '<div class="pix-loop-grid-pagination pix-pagination d-flex pix-mt-20 w-100 justify-content-center align-items-center">';
				$output .= paginate_links([
					'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
					'total' => $max_num_pages,
					'current' => max(1, $paged),
					'format' => '?paged=%#%',
					'show_all' => false,
					'type' => 'plain',
					'end_size' => 0,
					'mid_size' => 0,
					'prev_next' => true,
					'prev_text' => '<span class="d-sm-flex justify-content-center align-items-center">' . \PixfortCore::instance()->icons->getIcon($prevIcon) . '</span>',
					'next_text' => '<span class="d-sm-flex justify-content-center align-items-center">' . \PixfortCore::instance()->icons->getIcon($nextIcon) . '</span>',
					'add_args' => false,
					'add_fragment' => '',
				]);
				$output .= '</div>';
				break;

			case 'numbers_and_prev_next':
				$output .= '<div class="pix-loop-grid-pagination pix-pagination d-flex pix-mt-20 w-100 justify-content-center align-items-center">';
				$output .= paginate_links([
					'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
					'total' => $max_num_pages,
					'current' => max(1, $paged),
					'format' => '?paged=%#%',
					'show_all' => false,
					'type' => 'plain',
					'end_size' => 2,
					'mid_size' => 1,
					'prev_next' => true,
					'prev_text' => '<span class="d-sm-flex justify-content-center align-items-center">' . \PixfortCore::instance()->icons->getIcon($prevIcon) . '</span>',
					'next_text' => '<span class="d-sm-flex justify-content-center align-items-center">' . \PixfortCore::instance()->icons->getIcon($nextIcon) . '</span>',
					'add_args' => false,
					'add_fragment' => '',
				]);
				$output .= '</div>';
				break;

			case 'load_more':
				if ($paged < $max_num_pages) {
					// Add template_id and animation settings to args for AJAX loading
					$ajax_args = $args;
					$ajax_args['_template_id'] = isset($this->current_template_id) ? $this->current_template_id : 0;
					$ajax_args['_animation'] = !empty($attr['animation']) ? $attr['animation'] : '';
					$ajax_args['_animation_delay'] = !empty($attr['animation_delay']) ? $attr['animation_delay'] : '100';
					$output .= '<div class="pix-loop-grid-pagination pix-loop-grid-load-more-wrapper d-flex pix-mt-20 w-100 justify-content-center align-items-center">';
					
					$output .= '<div class="pix-loop-grid-load-more" data-grid-id="' . esc_attr($grid_id) . '" data-page="' . esc_attr($paged) . '" data-max-pages="' . esc_attr($max_num_pages) . '" data-query="' . esc_attr(json_encode($ajax_args)) . '">';
					// $output .= '<button class="pix-loop-grid-load-more btn btn-primary" data-grid-id="' . esc_attr($grid_id) . '" data-page="' . esc_attr($paged) . '" data-max-pages="' . esc_attr($max_num_pages) . '" data-query="' . esc_attr(json_encode($ajax_args)) . '">';
					// $output .= esc_html($load_more_text);
					// $output .= '</button>';
					$attr['btn_text'] = $load_more_text;
					$attr['btn_link'] = '#';
					$attr['is_elementor'] = true;
					$attr['btn_spinner'] = true;
					$output .= \PixfortCore::instance()->elementsManager->renderElement('Button', $attr);
					// $output .= '<span class="spinner"></span>';
					$output .= '</div>';

					$output .= '</div>';
				}
				break;

			case 'infinite_scroll':
				if ($paged < $max_num_pages) {
					// Add template_id and animation settings to args for AJAX loading
					$ajax_args = $args;
					$ajax_args['_template_id'] = isset($this->current_template_id) ? $this->current_template_id : 0;
					$ajax_args['_animation'] = !empty($attr['animation']) ? $attr['animation'] : '';
					$ajax_args['_animation_delay'] = !empty($attr['animation_delay']) ? $attr['animation_delay'] : '100';
					$output .= '<div class="pix-loop-grid-pagination pix-loop-grid-infinite-scroll" data-grid-id="' . esc_attr($grid_id) . '" data-page="' . esc_attr($paged) . '" data-max-pages="' . esc_attr($max_num_pages) . '" data-query="' . esc_attr(json_encode($ajax_args)) . '">';
					$output .= '<div class="pix-loop-grid-loading" style="display: none;">';
					$output .= '<span class="spinner"></span>';
					$output .= '</div>';
					$output .= '</div>';
				}
				break;
		}

		return $output;
	}
}
