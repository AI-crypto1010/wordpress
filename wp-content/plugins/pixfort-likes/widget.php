<?php


/**
 * Widget to display posts by likes popularity
 */

class PixFortLikes_Widget extends WP_Widget {

	function __construct() {
		parent::__construct('pixfort_likes_widget', 'PixFort Likes', array('description' => __('Displays your most popular posts sorted by most liked', 'pixfortlikes')));
	}

	function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget_title', $instance['title']);
		$desc = $instance['description'];
		$posts = empty($instance['posts']) ? 1 : $instance['posts'];
		$display_count = $instance['display_count'];

		// Output our widget
		echo $before_widget;
		if (!empty($title)) echo $before_title . $title . $after_title;

		if ($desc) echo '<p>' . $desc . '</p>';

		$likes_posts_args = array(
			'numberposts' => $posts,
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'meta_key' => '_pixfort_likes',
			'post_type' => 'post',
			'post_status' => 'publish'
		);
		$likes_posts = get_posts($likes_posts_args);

		echo '<ul class="pixfort-likes-popular-posts">';
		foreach ($likes_posts as $likes_post) {
			$count_output = '';
			if ($display_count) {
				$count = get_post_meta($likes_post->ID, '_pixfort_likes', true);
				$count_output = " <span class='pixfort-likes-count'>($count)</span>";
			}
			echo '<li><a href="' . get_permalink($likes_post->ID) . '">' . get_the_title($likes_post->ID) . '</a>' . $count_output . '</li>';
		}
		echo '</ul>';

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['description'] = strip_tags($new_instance['description'], '<a><b><strong><i><em><span>');
		$instance['posts'] = strip_tags($new_instance['posts']);
		$instance['display_count'] = strip_tags($new_instance['display_count']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args(
			(array) $instance
		);

		$defaults = array(
			'title' => __('Popular Posts', 'pixfortlikes'),
			'description' => '',
			'posts' => 5,
			'display_count' => 1
		);

		$instance = wp_parse_args((array) $instance, $defaults);

		$title = $instance['title'];
		$description = $instance['description'];
		$posts = $instance['posts'];
		$display_count = $instance['display_count'];
?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" type="text" value="<?php echo $description; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e('Posts:'); ?></label>
			<input id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" type="text" value="<?php echo $posts; ?>" size="3" />
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('display_count'); ?>" name="<?php echo $this->get_field_name('display_count'); ?>" type="checkbox" value="1" <?php checked($display_count); ?>>
			<label for="<?php echo $this->get_field_id('display_count'); ?>"><?php _e('Display like counts'); ?></label>
		</p>

<?php
	}
}
