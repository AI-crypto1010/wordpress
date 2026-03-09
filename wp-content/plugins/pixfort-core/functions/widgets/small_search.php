<?php

// Creating the widget
class pix_small_search extends WP_Widget {
	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'pix_small_search',
			// Widget name will appear in UI
			__('pixfort Legacy Search', 'pixfort-core'),
			// Widget description
			[
				'description' => __('Small search widget', 'pixfort-core'),
				'show_instance_in_rest' => true
			]
		);
	}

	// Creating widget front-end
	public function widget($args, $instance) {
		$title = apply_filters('widget_title', $instance['title']);

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if (!empty($title)) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$link = admin_url('admin-ajax.php?action=pix_ajax_search');
		$search_data = 'data-search-link="' . $link . '"';
		$homeUrl = home_url('/');
		if(function_exists('pll_home_url')){
			$homeUrl = pll_home_url();
		}
		// This is where you run the code and display the output
		$placeholder = esc_attr__('Search for something', 'pixfort-core');
		// Get current search query if on search results page
		$current_query = '';
		if (is_search()) {
			$current_query = get_search_query();
		}
		echo '<form class="pix-small-search pix-ajax-search-container position-relative shadow-sm rounded-lg pix-small-search" method="get" action="' . esc_url($homeUrl) . '">
                <div class="d-flex">
                    <input type="search" class="form-control pix-ajax-search form-control-lg shadow-0 font-weight-bold text-body-default" name="s" autocomplete="off" placeholder="' . $placeholder . '" aria-label="Search" value="' . esc_attr($current_query) . '" ' . $search_data . '>
                    <button class="btn btn-search btn-white m-0 text-body-default" aria-label="Search" type="submit">' . pixGetFileContents( '/functions/images/search.svg') . '</button>';
		if (function_exists('pll_current_language')) {
			echo '<input type="hidden" name="lang" value="' . esc_attr(pll_current_language()) . '">';
		}
		echo '</div>
            </form>';
		echo $args['after_widget'];
	}

	// Widget Backend
	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('Search', 'pixfort-core');
		}
		// Widget admin form
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
<?php
	}

	// Updating widget replacing old instances with new
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		return $instance;
	}
}

// function pixfort_hide_search_widget( $widget_types ) {
//     $widget_types[] = 'pix_small_search';
//     return $widget_types;
// }
// add_filter( 'widget_types_to_hide_from_legacy_widget_block', 'pixfort_hide_search_widget' );