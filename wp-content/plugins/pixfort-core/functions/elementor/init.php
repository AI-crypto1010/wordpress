<?php

class My_Elementor_Widgets {

	protected static $instance = null;

	public static function get_instance() {
		if (! isset(static::$instance)) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	protected function __construct() {

		wp_register_script('pix-global', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/global.js', ['elementor-frontend'], '3.2.22', true);

		require_once('globals.php');
		require_once('widgets/accordion.php');
		require_once('widgets/alert.php');
		require_once('widgets/auto-video.php');
		require_once('widgets/badge.php');
		require_once('widgets/blog-slider.php');
		require_once('widgets/blog.php');
		require_once('widgets/button.php');
		require_once('widgets/breadcrumbs.php');
		require_once('widgets/card-wide.php');
		require_once('widgets/card.php');
		require_once('widgets/chart.php');
		require_once('widgets/circles.php');
		require_once('widgets/clients-carousel.php');
		require_once('widgets/clients.php');
		require_once('widgets/comparison-table.php');

		require_once('widgets/countdown.php');
		require_once('widgets/cta.php');
		require_once('widgets/dividers.php');
		require_once('widgets/event.php');
		require_once('widgets/fancy-mockup.php');
		require_once('widgets/fancybox.php');
		require_once('widgets/faq.php');
		require_once('widgets/feature-list.php');
		require_once('widgets/feature.php');

		require_once('widgets/gallery.php');
		require_once('widgets/heading.php');
		require_once('widgets/horizontal-tabs.php');
		require_once('widgets/highlighted-text.php');
		require_once('widgets/vertical-tabs.php');
		require_once('widgets/icon.php');
		require_once('widgets/img-box.php');
		require_once('widgets/img-carousel.php');
		require_once('widgets/img-slider.php');
		require_once('widgets/img.php');
		require_once('widgets/levels.php');
		
		require_once('widgets/map.php');
		require_once('widgets/marquee.php');
		require_once('widgets/numbers.php');
		require_once('widgets/photo-box.php');
		require_once('widgets/photo-stack.php');
		require_once('widgets/portfolio-slider.php');
		require_once('widgets/portfolio.php');
		require_once('widgets/pricing.php');
		require_once('widgets/products-carousel.php');
		require_once('widgets/progress-bars.php');
		require_once('widgets/promo-box.php');
		require_once('widgets/review.php');
		require_once('widgets/reviews-slider.php');
		require_once('widgets/search.php');
		require_once('widgets/shop-category.php');
		require_once('widgets/slider.php');
		require_once('widgets/sliding-text.php');
		require_once('widgets/social-icons.php');
		require_once('widgets/social-share-button.php');
		require_once('widgets/story.php');
		
		require_once('widgets/team-member-circle.php');
		require_once('widgets/team-member.php');
		require_once('widgets/testimonial-masonry.php');
		require_once('widgets/testimonial.php');
		require_once('widgets/testimonials-slider.php');
		require_once('widgets/text.php');
		require_once('widgets/video-popup.php');
		require_once('widgets/video-slider.php');
		require_once('widgets/video.php');
		if (defined('PIX_DEV')) {
			require_once('widgets/menu.php');
			require_once('widgets/runtime.php');
			require_once('widgets/loop-grid.php');
			require_once('widgets/table-of-contents.php');
		}
		if (\PixfortCore::instance()->getThemeParam('template_elements', false)) {
			require_once('widgets/template-carousel.php');
			require_once('widgets/global-template.php');
		}


		require_once('widgets/3d-box.php');
		require_once('widgets/animated-heading.php');

		// Template widgets (only show for post templates)
		require_once('widgets/templates/post-excerpt.php');
		require_once('widgets/templates/post-content.php');
		// require_once('widgets/templates/featured-image.php');
		require_once('widgets/templates/author-box.php');
		require_once('widgets/templates/post-taxonomies.php');
		require_once('widgets/templates/archive-posts.php');
		require_once('widgets/templates/post-comments.php');
		require_once('widgets/templates/post-navigation.php');
		// require_once('widgets/templates/post-info.php');

		// Product template widgets (only show for product templates)
		require_once('widgets/templates/products/product-images.php');
		require_once('widgets/templates/products/add-to-cart.php');
		// require_once('widgets/templates/products/product-meta.php');
		// require_once('widgets/templates/products/product-stock.php');
		require_once('widgets/templates/products/product-rating.php');
		require_once('widgets/templates/products/product-data-tabs.php');
		require_once('widgets/templates/products/related-products.php');
		require_once('widgets/templates/products/upsells.php');
		require_once('widgets/templates/products/additional-information.php');
		require_once('widgets/templates/products/archive-products.php');

		require_once('includes/pix-section.php');
		$ps = new PixSection();

		add_action('elementor/widgets/register', [$this, 'register_widgets']);
	}

	public function register_widgets() {

		// Template widgets (only show for Theme builder)
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Template_Post_Excerpt());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Template_Post_Content());
		// \Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\Pix_Eor_Template_Featured_Image() );
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Template_Author_Box());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Template_Post_Taxonomies());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Template_Archive_Posts());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Template_Post_Comments());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Template_Post_Navigation());
		// \Elementor\Plugin::instance()->widgets_manager->register( new \Elementor\Pix_Eor_Template_Post_Info() );

		// Product template widgets (only show for product templates)
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Product_Images());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Product_Add_To_Cart());
		// \Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Product_Meta());
		// \Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Product_Stock());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Product_Rating());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Product_Data_Tabs());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Related_Products());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Product_Upsells());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Product_Additional_Information());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Archive_Products());



		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Accordion());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Alert());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Animated_Heading());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Auto_Video());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Badge());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Blog_Slider());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Blog());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Button());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Breadcrumbs());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Card_Wide());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Card());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Chart());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Circles());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Clients_Carousel());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Clients());

		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Comparison_Table());

		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Countdown());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_CTA());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Dividers());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Event());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Fancy_Mockup());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Fancybox());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Faq());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Feature_List());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Feature());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Gallery());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Heading());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Highlighted_Text());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Icon());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Img_Box());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Img_Carousel());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Img_Slider());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Img());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Levels());
		
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Map());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Marquee());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Numbers());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Photo_Box());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Photo_Stack());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Portfolio_Slider());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Portfolio());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Pricing());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Products_Carousel());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Progress_Bars());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Promo_Box());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Review());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Reviews_Slider());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Search());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Shop_Category());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Slider());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Sliding_Text());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Social_Icons());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Social_Share_Button());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Story());
		
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Team_Member_Circle());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Team_Member());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Testimonial_Masonry());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Testimonial());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Testimonials_Slider());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Text());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Video_Popup());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Video_Slider());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Video());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Horizontal_Tabs());
		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Vertical_Tabs());

		\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_3d_Box());
		if (defined('PIX_DEV')) {
			\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Loop_Grid());
			\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Runtime());
			\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Table_Of_Contents());
			\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Menu());
		}
		if (\PixfortCore::instance()->getThemeParam('template_elements', false)) {
			\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Template_Carousel());
			\Elementor\Plugin::instance()->widgets_manager->register(new \Elementor\Pix_Eor_Global_Template());
		}


		



	}
}

function pix_register_new_controls($controls_manager) {

	require_once('includes/img-selector-control.php');
	require_once('includes/icon-selector-control.php');
	require_once('includes/fonticon-selector-control.php');
	require_once('includes/pixfort-icon-selector-control.php');
	require_once('includes/custom-gradient-control.php');
	require_once('includes/template-selector.php');
	require_once('includes/query-search-control.php');

	$controls_manager->register(new \Elementor\CustomControl\ImgSelector_Control());
	$controls_manager->register(new \Elementor\CustomControl\IconSelector_Control());
	$controls_manager->register(new \Elementor\CustomControl\FonticonSelector_Control());
	$controls_manager->register(new \Elementor\CustomControl\PixfortIconSelector_Control());
	$controls_manager->register(new \Elementor\CustomControl\CustomGradient_Control());
	$controls_manager->register(new \Elementor\CustomControl\Pix_Template_Control());
	$controls_manager->register(new \Elementor\CustomControl\Pix_Query_Search_Control());
}
add_action('elementor/controls/register', 'pix_register_new_controls');



add_action('init', 'my_elementor_init');
function my_elementor_init() {
	My_Elementor_Widgets::get_instance();
}

add_action('wp_ajax_pix_get_templates_list', 'pix_get_templates_list');
function pix_get_templates_list() {
	// Verify nonce for security
	$nonce = isset($_REQUEST['nonce']) ? sanitize_text_field($_REQUEST['nonce']) : '';
	if (!wp_verify_nonce($nonce, 'templates_nonce')) {
		wp_die('Unauthorized: Invalid security token', 'Security Error', array('response' => 403));
	}
	
	// Check if user is logged in
	if (!is_user_logged_in()) {
		wp_die('Unauthorized: User not logged in', 'Security Error', array('response' => 401));
	}
	
	// Check user has capability to edit posts (required for Elementor)
	if (!current_user_can('edit_posts')) {
		wp_die('Unauthorized: Insufficient permissions', 'Security Error', array('response' => 403));
	}
	
	$results = [];
	$resultsURLs = [];
	// $results[] = esc_html__('Choose Template', 'pixfort-core');
	
	// Get Elementor library templates
	$posts = get_posts(array(
		'posts_per_page'	=> -1,
		'post_type'	=> 'elementor_library'
	));
	foreach ($posts as $post) {
		$document = \Elementor\plugin::instance()->documents->get($post->ID);
		if ($document) {
			$text = esc_html($post->post_title) . ' (' . $document->get_post_type_title() . ')';
			$results[$post->ID] = $text;
			$resultsURLs[$post->ID] = $document->get_edit_url();
		}
	}
	
	// Get pixfort_template templates with 'template' type
	$pixfort_templates = get_posts(array(
		'posts_per_page'	=> -1,
		'post_type'	=> 'pixfort_template',
		'tax_query' => array(
			array(
				'taxonomy' => 'pixfort_template_type',
				'field' => 'slug',
				'terms' => 'template',
			),
		),
	));
	foreach ($pixfort_templates as $post) {
		$document = \Elementor\plugin::instance()->documents->get($post->ID);
		if ($document) {
			$text = esc_html($post->post_title) . ' (' . __('pixfort Template', 'pixfort-core') . ')';
			$results[$post->ID] = $text;
			$resultsURLs[$post->ID] = $document->get_edit_url();
		}
	}
	
	echo json_encode([
		'results'		=> $results,
		'resultsURLs'	=> $resultsURLs
	]);
	wp_die();
}

// AJAX handler for query search control
add_action('wp_ajax_pixfort_query_search', 'pixfort_query_search_handler');
function pixfort_query_search_handler() {
	// Verify nonce for security
	$nonce = isset($_REQUEST['nonce']) ? sanitize_text_field($_REQUEST['nonce']) : '';
	if (!wp_verify_nonce($nonce, 'pixfort_query_search_nonce')) {
		wp_send_json(['success' => false, 'message' => 'Invalid security token']);
		wp_die();
	}
	
	// Check if user is logged in
	if (!is_user_logged_in() || !current_user_can('edit_posts')) {
		wp_send_json(['success' => false, 'message' => 'Insufficient permissions']);
		wp_die();
	}
	
	$object_type = isset($_POST['object_type']) ? sanitize_text_field($_POST['object_type']) : 'post';
	$search_query = isset($_POST['q']) ? sanitize_text_field($_POST['q']) : '';
	$query_args = isset($_POST['query']) ? $_POST['query'] : [];
	$ids = isset($_POST['ids']) ? array_map('intval', $_POST['ids']) : [];
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$per_page = 20;
	
	$results = [];
	
	switch ($object_type) {
		case 'post':
			$results = pixfort_search_posts($search_query, $query_args, $ids, $page, $per_page);
			break;
		case 'product':
			// Search for WooCommerce products specifically
			$query_args['post_type'] = 'product';
			$results = pixfort_search_posts($search_query, $query_args, $ids, $page, $per_page);
			break;
		case 'taxonomy':
			$results = pixfort_search_taxonomies($search_query, $ids, $page, $per_page);
			break;
		case 'attachment':
			$results = pixfort_search_attachments($search_query, $ids, $page, $per_page);
			break;
		case 'author':
			$results = pixfort_search_authors($search_query, $ids, $page, $per_page);
			break;
	}
	
	wp_send_json($results);
	wp_die();
}

function pixfort_search_posts($search_query = '', $query_args = [], $ids = [], $page = 1, $per_page = 20) {
	$args = [
		'post_type' => isset($query_args['post_type']) ? $query_args['post_type'] : 'any',
		'post_status' => 'publish',
		'posts_per_page' => $per_page,
		'paged' => $page,
		'orderby' => 'title',
		'order' => 'ASC',
	];
	
	// If specific IDs are requested (for loading initial values)
	if (!empty($ids)) {
		$args['post__in'] = $ids;
		$args['posts_per_page'] = -1;
	} elseif (!empty($search_query)) {
		$args['s'] = $search_query;
	}
	
	$query = new \WP_Query($args);
	$results = [];
	
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$post_type_obj = get_post_type_object(get_post_type());
			$post_type_label = $post_type_obj ? $post_type_obj->labels->singular_name : '';
			
			$results[] = [
				'id' => get_the_ID(),
				'text' => get_the_title() . ' (' . $post_type_label . ' #' . get_the_ID() . ')'
			];
		}
		wp_reset_postdata();
	}
	
	return [
		'success' => true,
		'results' => $results,
		'more' => ($query->max_num_pages > $page)
	];
}

function pixfort_search_taxonomies($search_query = '', $ids = [], $page = 1, $per_page = 20) {
	$args = [
		'taxonomy' => get_taxonomies(['public' => true], 'names'),
		'hide_empty' => false,
		'number' => $per_page,
		'offset' => ($page - 1) * $per_page,
		'orderby' => 'name',
		'order' => 'ASC',
	];
	
	// If specific IDs are requested
	if (!empty($ids)) {
		$args['include'] = $ids;
		$args['number'] = 0;
	} elseif (!empty($search_query)) {
		$args['search'] = $search_query;
	}
	
	$terms = get_terms($args);
	$results = [];
	
	if (!is_wp_error($terms) && !empty($terms)) {
		foreach ($terms as $term) {
			$taxonomy_obj = get_taxonomy($term->taxonomy);
			$taxonomy_label = $taxonomy_obj ? $taxonomy_obj->labels->singular_name : $term->taxonomy;
			
			$results[] = [
				'id' => $term->term_id,
				'text' => $term->name . ' (' . $taxonomy_label . ' #' . $term->term_id . ')'
			];
		}
	}
	
	// Check if there are more results
	$total_args = $args;
	unset($total_args['number']);
	unset($total_args['offset']);
	$total_terms = get_terms($total_args);
	$total_count = is_wp_error($total_terms) ? 0 : count($total_terms);
	
	return [
		'success' => true,
		'results' => $results,
		'more' => ($total_count > ($page * $per_page))
	];
}

function pixfort_search_attachments($search_query = '', $ids = [], $page = 1, $per_page = 20) {
	$args = [
		'post_type' => 'attachment',
		'post_status' => 'inherit',
		'posts_per_page' => $per_page,
		'paged' => $page,
		'orderby' => 'title',
		'order' => 'ASC',
	];
	
	// If specific IDs are requested
	if (!empty($ids)) {
		$args['post__in'] = $ids;
		$args['posts_per_page'] = -1;
	} elseif (!empty($search_query)) {
		$args['s'] = $search_query;
	}
	
	$query = new \WP_Query($args);
	$results = [];
	
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$mime_type = get_post_mime_type();
			$file_type = wp_check_filetype(get_attached_file(get_the_ID()));
			
			$results[] = [
				'id' => get_the_ID(),
				'text' => get_the_title() . ' (' . strtoupper($file_type['ext']) . ' #' . get_the_ID() . ')'
			];
		}
		wp_reset_postdata();
	}
	
	return [
		'success' => true,
		'results' => $results,
		'more' => ($query->max_num_pages > $page)
	];
}

function pixfort_search_authors($search_query = '', $ids = [], $page = 1, $per_page = 20) {
	$args = [
		'number' => $per_page,
		'offset' => ($page - 1) * $per_page,
		'orderby' => 'display_name',
		'order' => 'ASC',
	];
	
	// If specific IDs are requested
	if (!empty($ids)) {
		$args['include'] = $ids;
		$args['number'] = 0;
	} elseif (!empty($search_query)) {
		$args['search'] = '*' . $search_query . '*';
		$args['search_columns'] = ['user_login', 'user_nicename', 'display_name'];
	}
	
	$user_query = new \WP_User_Query($args);
	$users = $user_query->get_results();
	$results = [];
	
	if (!empty($users)) {
		foreach ($users as $user) {
			$results[] = [
				'id' => $user->ID,
				'text' => $user->display_name . ' (@' . $user->user_login . ' #' . $user->ID . ')'
			];
		}
	}
	
	// Check if there are more results
	$total_query = new \WP_User_Query(array_merge($args, ['number' => 0, 'offset' => 0, 'count_total' => true]));
	$total_count = $total_query->get_total();
	
	return [
		'success' => true,
		'results' => $results,
		'more' => ($total_count > ($page * $per_page))
	];
}

function pix_add_elementor_widget_categories($elements_manager) {
	$categories = [];
	$elementor_categories = $elements_manager->get_categories();
	if (!empty($elementor_categories['favorites'])) {
		$categories['favorites'] = $elementor_categories['favorites'];
		unset($elementor_categories['favorites']);
	}
	$categories['pixfort-products'] = [
		'title' => __('Product', 'pixfort-core'),
		'icon' => 'fa fa-shopping-cart',
	];
	$categories['pixfort'] = [
		'title' => __('pixfort Elements', 'pixfort-core'),
		'icon' => 'fa fa-plug',
	];
	$categories = array_merge($categories, $elementor_categories);
	$pix_set_categories = function ($categories) {
		$this->categories = $categories;
	};
	$pix_set_categories->call($elements_manager, $categories);
}
add_action('elementor/elements/categories_registered', 'pix_add_elementor_widget_categories', 5);

// Enqueu Styles after Elementor After Enqueue
// pixfort library
add_action('elementor/editor/footer', function () {
	wp_enqueue_script('pixfort-library', PIX_CORE_PLUGIN_URI . 'dist/main/library/main.js', ['jquery'], PIXFORT_PLUGIN_VERSION, true);
	$dynamicColors = false;
	if (\PixfortCore::instance()->styleFunctions && \PixfortCore::instance()->styleFunctions->darkModeEnabled) {
		$dynamicColors = true;
	}
	$main_values = array(
		'ADMIN_LINK' => admin_url('admin-ajax.php'),
		'DYNAMIC_COLORS' => $dynamicColors,
		'AJAX_NONCE' => wp_create_nonce('pixfort_ajax_nonce')
	);
	wp_localize_script('pixfort-library', 'pixfort_library_object', $main_values);
});
add_action('elementor/editor/after_enqueue_scripts', function () {
	wp_enqueue_style(
		'pix-elementor-core-style',
		PIX_CORE_PLUGIN_URI . '/functions/elementor/css/pixfort-elementor-style.css',
		['elementor-editor'],
		PIXFORT_PLUGIN_VERSION
	);
	// pixfort library
	wp_enqueue_style(
		'pixfort-elementor-library',
		PIX_CORE_PLUGIN_URI . 'dist/main/library/main.css',
		['elementor-editor'],
		PIXFORT_PLUGIN_VERSION
	);
});

add_action('elementor/frontend/after_register_scripts', function () {
	if (is_user_logged_in()) {
		wp_register_script('pix-section-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/includes/js/back.min.js', ['jquery'], PIXFORT_PLUGIN_VERSION, true);
		// pixfort library
		// wp_enqueue_script( 'pixfort-library-button', PIX_CORE_PLUGIN_URI.'dist/main/front/main.js', [ 'jquery' ], PIXFORT_PLUGIN_VERSION, true );
		wp_enqueue_script('pix-section-handle');
		$main_values = array(
			'pix_shapes' => pix_get_svg_shapes()
		);
		wp_localize_script('pix-section-handle', 'pixfort_elementor_object', $main_values);
	}
	wp_register_script('pix-global-dividers-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/global-dividers.min.js', ['jquery'], PIXFORT_PLUGIN_VERSION, true);
	// Enqueue 'pix-global-dividers-handle' only when needed
	// wp_enqueue_script( 'pix-global-dividers-handle' );
});


// add_action( 'elementor/init', function() {
// 	$disable_pix_blocks = false;
// 	if(!empty(pix_plugin_get_option('pix-disable-elementor-demo'))){
// 		if(pix_plugin_get_option('pix-disable-elementor-demo')){
// 			$disable_pix_blocks = true;
// 		}
// 	}
// 	if(!$disable_pix_blocks){
// 		include 'includes/source.php';

// 		$callSource = true;
// 		if (defined('PHP_MAJOR_VERSION') && PHP_MAJOR_VERSION < 7){
// 			$callSource = false;
// 			add_action( 'admin_notices', 'pixfort_php_notice' );
// 		}
// 		if($callSource){
// 			$unregister_source = function($id) {
// 				unset( $this->_registered_sources[ $id ] );
// 			};

// 			$unregister_source->call( \Elementor\Plugin::instance()->templates_manager, 'remote');
// 			\Elementor\Plugin::instance()->templates_manager->register_source( 'Elementor\TemplateLibrary\Source_Custom' );
// 		}
// 	}
// }, 15 );


function pixfort_php_notice() {
?>
	<div class="notice pixfort-admin-notice notice-warning is-dismissible">
		<div class="notice-text"><strong><?php echo esc_attr__('Warning: ', 'pixfort-core'); ?></strong><?php echo esc_attr__('The php version on the server is outdated (older than php version 7), elementor templates will not be loaded, please update php on your server.', 'pixfort-core'); ?></div>

		<a href="https://wordpress.org/support/update-php/" target="_blank" class="button button-primary"><?php echo esc_attr__('Learn more about updating PHP', 'pixfort-core'); ?></a>
	</div>
<?php
}

if (function_exists('icl_object_id')) {
	include_once('wpml/translation.php');
}
