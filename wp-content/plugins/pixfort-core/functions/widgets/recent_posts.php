<?php
// Creating the widget
class pix_recent_posts extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'pix_recent_posts',
			// Widget name will appear in UI
			__('pixfort Legacy Recent Posts', 'pixfort-core'),
			// Widget description
			[
				'description' => __('Recent post list with images', 'pixfort-core'),
				'show_instance_in_rest' => true
			]
		);
	}

	// Creating widget front-end

	public function widget($args, $instance) {
		$title = apply_filters('widget_title', $instance['title']);
		$count = apply_filters('widget_count', $instance['count']);

		if (empty($count)) $count = 3;
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if (!empty($title))
			echo $args['before_title'] . $title . $args['after_title'];

		// This is where you run the code and display the output
		$show_date = 0;
		$r = new WP_Query(apply_filters(
			'widget_posts_args',
			array(
				'posts_per_page' => $count,
				'no_found_rows' => true,
				'post_status' => 'publish',
				'ignore_sticky_posts' => true
			)
		));
		$imgDivStyle = 'top: 50%; left: 50%; transform: translate(-50%, -50%);z-index:-1;';
		if(is_rtl()) {
			$imgDivStyle = 'top: 50%; right: 50%; transform: translate(50%, -50%);z-index:-1;';
		}
		if ($r->have_posts()) :
?>
			<ul>
				<?php
				while ($r->have_posts()) :
					$r->the_post();
					$thump = get_the_post_thumbnail_url();
					$img_src = '';
					if ($thump && $thump != '') {
						$img_attrs = array(
							'class'    => 'card-img pix-opacity-5 img-fluid pix-fit-cover  pix-img-scale',
							'style'    => 'width:100%;',
							'alt'    => esc_attr(get_the_title() ? get_the_title() : get_the_ID())
						);
						$full_image_url = wp_get_attachment_image(get_post_thumbnail_id(), 'pix-blog-small', false, $img_attrs);
						$img_src = $full_image_url;
					}
				?>
					<li class="position-relative d-inline-block w-100">
						<div class=" w-100 overflow-hidden pix-hover-item shadow shadow-hover fly-sm  d-block pix-mb-10  rounded-xl" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
							<div class="card bg-heading-default">
								<div class="align-self-center pix-opacity-4 pix-hover-opacity-6 position-absolute pix-fit-cover w-100" style="<?php echo $imgDivStyle; ?>">
									<?php
									echo $img_src;
									?>
								</div>
								<div class="pix-p-20 d-flex flex-wrap h-100">
									<div class="d-flex align-items-center justify-content-between w-100">
										<a class=" pix-opacity-7 pix-hover-opacity-10" href="<?php the_permalink() ?>">
											<h6 class="card-title text-gray-1 mb-0 font-weight-bold line-clamp-2 "><?php if (get_the_title()) the_title();
																															else the_ID(); ?></h6>
										</a>
										<div class="d-inline position-relative" style="min-width:40px;">
											<div class="pl-2 d-inline position-relative justify-content-sm-center text-right" style="min-width:40px;">
												<?php if (function_exists('get_pixfort_likes')) {
													echo get_pixfort_likes();
												} ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php if ($show_date) : ?>
							<span class="post-date"><?php echo get_the_date(); ?></span>
						<?php endif; ?>
					</li>
				<?php endwhile; ?>
			</ul>
		<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();
		endif;
		echo $args['after_widget'];
	}
	// Widget Backend
	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('Recent Posts', 'pixfort-core');
		}
		if (isset($instance['count'])) {
			$count = $instance['count'];
		} else {
			$count = 3;
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Posts count:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" />
		</p>
<?php
	}
	// Updating widget replacing old instances with new
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['count'] = (!empty($new_instance['count'])) ? strip_tags($new_instance['count']) : '';
		return $instance;
	}
}
