<?php

// Creating the widget
class pix_social extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'pix_social',
			// Widget name will appear in UI
			__('pixfort Legacy Social Links', 'pixfort-core'),
			// Widget description
			[
				'description' => __('Social Links widget', 'pixfort-core'),
				'show_instance_in_rest' => true
			]
		);
	}

	// Creating widget front-end
	public function widget($args, $instance) {
		$title = apply_filters('widget_title', $instance['title']);
		$social = [
			'facebook' => [
				'icon' => 'Solid/pixfort-icon-facebook-1',
				'title' => 'Facebook'
			],
			'twitter' => [
				'icon' => 'Solid/pixfort-icon-x-1',
				'title' => 'X'
			],
			'youtube' => [
				'icon' => 'Solid/pixfort-icon-youtube-1',
				'title' => 'YouTube'
			],
			'linkedin' => [
				'icon' => 'Solid/pixfort-icon-linkedin-2',
				'title' => 'LinkedIn'
			],
			'instagram' => [
				'icon' => 'Solid/pixfort-icon-instagram-1',
				'title' => 'Instagram'
			],
			'dribbble' => [
				'icon' => 'Solid/pixfort-icon-dribbble-1',
				'title' => 'Dribbble'
			],
			'snapchat' => [
				'icon' => 'Solid/pixfort-icon-snapchat-1',
				'title' => 'Snapchat'
			],
			'telegram' => [
				'icon' => 'Solid/pixfort-icon-telegram-1',
				'title' => 'Telegram'
			],
			'whatsapp' => [
				'icon' => 'Solid/pixfort-icon-whatsapp-1',
				'title' => 'WhatsApp'
			],
			'flipboard' => [
				'icon' => 'Solid/pixfort-icon-flipboard-1',
				'title' => 'Flipboard'
			],
			'vk' => [
				'icon' => 'Solid/pixfort-icon-vk-1',
				'title' => 'VK'
			],
			'behance' => [
				'icon' => 'Solid/pixfort-icon-behance-1',
				'title' => 'Behance'
			]
		];

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if (!empty($title)) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div class="pix-social_widget pix-py-10">';


		foreach ($social as $social => $value) {
			if (!empty($instance[$social]) && apply_filters('widget_title', $instance[$social])) {
				echo '<a href="' . apply_filters('widget_title', $instance[$social]) . '" class="d-inline-block pix-base-background pix-mr-10 mb-2 shadow-sm fly-sm shadow-hover-sm text-body-default" title="' . $value['title'] . '"><span class="d-flex h-100 align-items-center justify-content-center">';
				echo \PixfortCore::instance()->icons->getIcon($value['icon'], 24, '', '', true);
				echo '</a>';
			}
		}
		echo '</div>';






		echo $args['after_widget'];
	}

	// Widget Backend
	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('Social Links', 'pixfort-core');
		}
		$facebook = '';
		$instagram = '';
		$twitter = '';
		$dribbble = '';
		$linkedin = '';
		$snapchat = '';
		$telegram = '';
		$whatsapp = '';
		$flipboard = '';
		$vk = '';
		$behance = '';
		$youtube = '';
		if (isset($instance['facebook'])) {
			$facebook = $instance['facebook'];
		}
		if (isset($instance['instagram'])) {
			$instagram = $instance['instagram'];
		}
		if (isset($instance['twitter'])) {
			$twitter = $instance['twitter'];
		}
		if (isset($instance['dribbble'])) {
			$dribbble = $instance['dribbble'];
		}
		if (isset($instance['linkedin'])) {
			$linkedin = $instance['linkedin'];
		}
		if (isset($instance['snapchat'])) {
			$snapchat = $instance['snapchat'];
		}
		if (isset($instance['telegram'])) {
			$telegram = $instance['telegram'];
		}
		if (isset($instance['whatsapp'])) {
			$whatsapp = $instance['whatsapp'];
		}
		if (isset($instance['flipboard'])) {
			$flipboard = $instance['flipboard'];
		}
		if (isset($instance['vk'])) {
			$vk = $instance['vk'];
		}
		if (isset($instance['behance'])) {
			$behance = $instance['behance'];
		}
		if (isset($instance['youtube'])) {
			$youtube = $instance['youtube'];
		}


		// Widget admin form
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_attr($facebook); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" type="text" value="<?php echo esc_attr($instagram); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('X (Previously Twitter):'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo esc_attr($twitter); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo esc_attr($linkedin); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('dribbble'); ?>"><?php _e('Dribbble:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('dribbble'); ?>" name="<?php echo $this->get_field_name('dribbble'); ?>" type="text" value="<?php echo esc_attr($dribbble); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('snapchat'); ?>"><?php _e('Snapchat:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('snapchat'); ?>" name="<?php echo $this->get_field_name('snapchat'); ?>" type="text" value="<?php echo esc_attr($snapchat); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('telegram'); ?>"><?php _e('Telegram:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('telegram'); ?>" name="<?php echo $this->get_field_name('telegram'); ?>" type="text" value="<?php echo esc_attr($telegram); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('whatsapp'); ?>"><?php _e('Whatsapp:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('whatsapp'); ?>" name="<?php echo $this->get_field_name('whatsapp'); ?>" type="text" value="<?php echo esc_attr($whatsapp); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('flipboard'); ?>"><?php _e('Flipboard:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('flipboard'); ?>" name="<?php echo $this->get_field_name('flipboard'); ?>" type="text" value="<?php echo esc_attr($flipboard); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('vk'); ?>"><?php _e('VK:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('vk'); ?>" name="<?php echo $this->get_field_name('vk'); ?>" type="text" value="<?php echo esc_attr($vk); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('behance'); ?>"><?php _e('Behance:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('behance'); ?>" name="<?php echo $this->get_field_name('behance'); ?>" type="text" value="<?php echo esc_attr($behance); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('YouTube:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="text" value="<?php echo esc_attr($youtube); ?>" />
		</p>
<?php
	}

	// Updating widget replacing old instances with new
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['facebook'] = (!empty($new_instance['facebook'])) ? strip_tags($new_instance['facebook']) : '';
		$instance['instagram'] = (!empty($new_instance['instagram'])) ? strip_tags($new_instance['instagram']) : '';
		$instance['twitter'] = (!empty($new_instance['twitter'])) ? strip_tags($new_instance['twitter']) : '';
		$instance['linkedin'] = (!empty($new_instance['linkedin'])) ? strip_tags($new_instance['linkedin']) : '';
		$instance['dribbble'] = (!empty($new_instance['dribbble'])) ? strip_tags($new_instance['dribbble']) : '';
		$instance['snapchat'] = (!empty($new_instance['snapchat'])) ? strip_tags($new_instance['snapchat']) : '';
		$instance['telegram'] = (!empty($new_instance['telegram'])) ? strip_tags($new_instance['telegram']) : '';
		$instance['whatsapp'] = (!empty($new_instance['whatsapp'])) ? strip_tags($new_instance['whatsapp']) : '';
		$instance['flipboard'] = (!empty($new_instance['flipboard'])) ? strip_tags($new_instance['flipboard']) : '';
		$instance['vk'] = (!empty($new_instance['vk'])) ? strip_tags($new_instance['vk']) : '';
		$instance['behance'] = (!empty($new_instance['behance'])) ? strip_tags($new_instance['behance']) : '';
		$instance['youtube'] = (!empty($new_instance['youtube'])) ? strip_tags($new_instance['youtube']) : '';
		return $instance;
	}
}
