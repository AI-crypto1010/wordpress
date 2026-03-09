<?php

// Creating the widget
class pix_categories extends WP_Widget {
	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'pix_categories',
			// Widget name will appear in UI
			__('pixfort Legacy Categories', 'pixfort-core'),
			// Widget description
			[
				'description' => __('Categories widget', 'pixfort-core'),
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
		echo '<div class="pix_categories_widget">';
		foreach (get_categories() as $key => $value) {
			echo '<a href="' . get_category_link($value) . '" class="d-flex align-items-center w-100 justify-content-center bg-white shadow-sm shadow-hover-sm fly-sm rounded-lg pix-mb-10 pix-p-5 text-center text-sm font-weight-bold text-body-default">';
			echo $value->name;
			echo '</a>';
		}
		echo '</div>';
		echo $args['after_widget'];
	}

	// Widget Backend
	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('Categories', 'pixfort-core');
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
