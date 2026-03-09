<?php
/*
Plugin Name: pixfort Likes
Plugin URI: https://www.pixfort.com
Description: Add "like" functionality to your posts and pages
Version: 1.0.6
Author: pixfort
Author URI: https://www.pixfort.com
Text Domain: pixfort-likes
*/

define('PIXFORT_LIKES_URI', plugin_dir_url(__FILE__));
define('PIXFORT_LIKES_DIR', dirname(__FILE__));
define('PIXFORT_LIKES_VERSION', '1.0.6');

class PixFortLikes {

	private $used = false;
	private $icons = array(
		'heart' => array(
			0 => PIXFORT_LIKES_DIR . '/images/heart-icon.svg',
			1 => PIXFORT_LIKES_DIR . '/images/heart-solid-icon.svg'
		),
		'clap' => array(
			0 => PIXFORT_LIKES_DIR . '/images/clap-icon.svg',
			1 => PIXFORT_LIKES_DIR . '/images/clap-pressed.svg'
		),
		'like' => array(
			0 => PIXFORT_LIKES_DIR . '/images/like-icon.svg',
			1 => PIXFORT_LIKES_DIR . '/images/like-pressed.svg'
		),
	);

	function __construct() {
		add_action('init', array(&$this, 'pixfort_likes_textdomain'));
		add_action('admin_init', array(&$this, 'admin_init'));
		add_action('admin_menu', array(&$this, 'admin_menu'), 99);
		add_action('wp_footer', array(&$this, 'enqueue_scripts'));
		add_filter('the_content', array(&$this, 'the_content'));
		add_filter('the_excerpt', array(&$this, 'the_content'));
		add_filter('body_class', array(&$this, 'body_class'));
		add_action('publish_post', array(&$this, 'setup_likes'));
		add_action('wp_ajax_pixfort-likes', array(&$this, 'ajax_callback'));
		add_action('wp_ajax_nopriv_pixfort-likes', array(&$this, 'ajax_callback'));
		add_shortcode('pixfort_likes', array(&$this, 'shortcode'));
	}

	function pixfort_likes_textdomain() {
		// Set filter for plugin's languages directory
		$pixfort_likes_lang_dir = dirname(plugin_basename(__FILE__)) . '/languages/';
		$pixfort_likes_lang_dir = apply_filters('pixfort_likes_languages_directory', $pixfort_likes_lang_dir);

		// Load the translations
		load_plugin_textdomain('pixfort-likes', false, $pixfort_likes_lang_dir);
	}

	function admin_init() {
		register_setting('pixfort-likes', 'pixfort_likes_settings', array(&$this, 'settings_validate'));
		add_settings_section('pixfort-likes', '', array(&$this, 'section_intro'), 'pixfort-likes');

		add_settings_field('like_icon', __('Like icon', 'pixfort-likes'), array(&$this, 'setting_like_icon'), 'pixfort-likes', 'pixfort-likes');
		add_settings_field('ajax_likes', __('AJAX Like Counts', 'pixfort-likes'), array(&$this, 'setting_ajax_likes'), 'pixfort-likes', 'pixfort-likes');
		add_settings_field('instructions', __('Shortcode and Template Tag', 'pixfort-likes'), array(&$this, 'setting_instructions'), 'pixfort-likes', 'pixfort-likes');
	}

	function admin_menu() {
		$page_hook = add_menu_page(
			__('pixfort Likes Settings', 'pixfort-likes'),
			'pixfort Likes',
			'update_core',
			'pixfort-likes',
			array(&$this, 'settings_page'),
			'dashicons-heart'
		);
		add_submenu_page('pixfort-likes', __('Settings', 'pixfort-likes'), __('pixfort Likes Settings', 'pixfort-likes'), 'update_core', 'pixfort-likes', array(&$this, 'settings_page'));
		// pixfortframework link
		add_submenu_page('pixfortframework', 'PixfortLikes', 'PixfortLikes', 'update_core', 'pixfort-likes', array(&$this, 'settings_page'));
	}

	function settings_page() {
?>
		<div class="wrap">
			<div id="icon-themes" class="icon32"></div>
			<h2><?php _e('pixfort Likes Settings', 'pixfort-likes'); ?></h2>
			<?php if (isset($_GET['settings-updated']) && $_GET['settings-updated']) { ?>
				<div id="setting-error-settings_updated" class="updated settings-error">
					<p><strong><?php _e('Settings saved.', 'pixfort-likes'); ?></strong></p>
				</div>
			<?php } ?>
			<form action="options.php" method="post">
				<?php settings_fields('pixfort-likes'); ?>
				<?php do_settings_sections('pixfort-likes'); ?>
				<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes', 'pixfort-likes'); ?>" /></p>
			</form>
		</div>
	<?php
	}

	function section_intro() {
	?>
		<p><?php _e('PixFort Likes allows you to display like icons throughout your site.', 'pixfort-likes'); ?></p>
<?php

	}

	function setting_show_on() {
		$options = get_option('pixfort_likes_settings');
		if (!isset($options['add_to_posts'])) $options['add_to_posts'] = '0';
		if (!isset($options['add_to_pages'])) $options['add_to_pages'] = '0';
		if (!isset($options['add_to_other'])) $options['add_to_other'] = '0';

		echo '<input type="hidden" name="pixfort_likes_settings[add_to_posts]" value="0" />
		<label><input type="checkbox" name="pixfort_likes_settings[add_to_posts]" value="1"' . (($options['add_to_posts']) ? ' checked="checked"' : '') . ' />
		' . __('Posts', 'pixfort-likes') . '</label><br />
		<input type="hidden" name="pixfort_likes_settings[add_to_pages]" value="0" />
		<label><input type="checkbox" name="pixfort_likes_settings[add_to_pages]" value="1"' . (($options['add_to_pages']) ? ' checked="checked"' : '') . ' />
		' . __('Pages', 'pixfort-likes') . '</label><br />
		<input type="hidden" name="pixfort_likes_settings[add_to_other]" value="0" />
		<label><input type="checkbox" name="pixfort_likes_settings[add_to_other]" value="1"' . (($options['add_to_other']) ? ' checked="checked"' : '') . ' />
		' . __('Blog Index Page, Archive Pages, and Search Results', 'pixfort-likes') . '</label><br />';
	}

	function setting_exclude_from() {
		$options = get_option('pixfort_likes_settings');
		if (!isset($options['exclude_from'])) $options['exclude_from'] = '';

		echo '<input type="text" name="pixfort_likes_settings[exclude_from]" class="regular-text" value="' . $options['exclude_from'] . '" />
		<p class="description">' . __('Comma separated list of post/page ID\'s (e.g. 4,7,87)', 'pixfort-likes') . '</p>';
	}

	function setting_disable_css() {
		$options = get_option('pixfort_likes_settings');
		if (!isset($options['disable_css'])) $options['disable_css'] = '0';

		echo '<input type="hidden" name="pixfort_likes_settings[disable_css]" value="0" />
		<label><input type="checkbox" name="pixfort_likes_settings[disable_css]" value="1"' . (($options['disable_css']) ? ' checked="checked"' : '') . ' />' . __('I want to use my own CSS styles', 'pixfort-likes') . '</label>';

		// Shutterbug conflict warning
		$theme_name = '';
		if (function_exists('wp_get_theme')) $theme_name = wp_get_theme();
		else $theme_name = get_current_theme();
		if (strtolower($theme_name) == 'shutterbug') {
			echo '<br /><span class="description" style="color:red">' . __('We recommend you check this option when using the Shutterbug theme to avoid conflicts', 'pixfort-likes') . '</span>';
		}
	}

	function setting_ajax_likes() {
		$options = get_option('pixfort_likes_settings');
		if (!isset($options['ajax_likes'])) $options['ajax_likes'] = '0';

		echo '<input type="hidden" name="pixfort_likes_settings[ajax_likes]" value="0" />
		<label><input type="checkbox" name="pixfort_likes_settings[ajax_likes]" value="1"' . (($options['ajax_likes']) ? ' checked="checked"' : '') . ' />
		' . __('AJAX Like Counts on page load', 'pixfort-likes') . '</label><br />
		<span class="description">' . __('If you are using a cacheing plugin, you may want to dynamically load the like counts via AJAX.', 'pixfort-likes') . '</span>';
	}

	function setting_like_icon() {
		$options = get_option('pixfort_likes_settings');
		if (!isset($options['like_icon'])) $options['like_icon'] = 'heart';

		echo '<div><select name="pixfort_likes_settings[like_icon]" >';
		foreach ($this->icons as $k => $v) {
			echo '<option value="' . $k . '" ' . selected($options['like_icon'], $k, false) . '>' . $k . '</option>';
		}
		echo '</select></div>';
	}

	function setting_zero_postfix() {
		$options = get_option('pixfort_likes_settings');
		if (!isset($options['zero_postfix'])) $options['zero_postfix'] = '';

		echo '<input type="text" name="pixfort_likes_settings[zero_postfix]" class="regular-text" value="' . $options['zero_postfix'] . '" /><br />
		<span class="description">' . __('The text after the count when no one has liked a post/page. Leave blank for no text after the count.', 'pixfort-likes') . '</span>';
	}

	function setting_one_postfix() {
		$options = get_option('pixfort_likes_settings');
		if (!isset($options['one_postfix'])) $options['one_postfix'] = '';

		echo '<input type="text" name="pixfort_likes_settings[one_postfix]" class="regular-text" value="' . $options['one_postfix'] . '" /><br />
		<span class="description">' . __('The text after the count when one person has liked a post/page. Leave blank for no text after the count.', 'pixfort-likes') . '</span>';
	}

	function setting_more_postfix() {
		$options = get_option('pixfort_likes_settings');
		if (!isset($options['more_postfix'])) $options['more_postfix'] = '';

		echo '<input type="text" name="pixfort_likes_settings[more_postfix]" class="regular-text" value="' . $options['more_postfix'] . '" /><br />
		<span class="description">' . __('The text after the count when more than one person has liked a post/page. Leave blank for no text after the count.', 'pixfort-likes') . '</span>';
	}

	function setting_instructions() {
		echo '<p>' . __('To use PixFort Likes in your posts and pages you can use the shortcode:', 'pixfort-likes') . '</p>
		<p><code>[pixfort_likes]</code></p>
		<p>' . __('To use pixfort Likes manually in your theme template use the following PHP code:', 'pixfort-likes') . '</p>
		<p><code>&lt;?php if( function_exists(\'pixfort_likes\') ) pixfort_likes(); ?&gt;</code></p>';
	}

	function settings_validate($input) {
		$input['exclude_from'] = str_replace(' ', '', trim(strip_tags($input['exclude_from'])));

		return $input;
	}

	function enqueue_scripts() {
		$options = get_option('pixfort_likes_settings');
		if (!$options) $options = [];
		if (!isset($options['disable_css'])) $options['disable_css'] = '0';

		if($this->used){
			if (!$options['disable_css']) wp_enqueue_style('pixfort-likes', plugins_url('/styles/pixfort-likes.css', __FILE__));
			if (!$options['disable_css']) wp_enqueue_style('pixfort-likes-odometer', plugins_url('/styles/odometer-theme-default.css', __FILE__));

			wp_enqueue_script('pixfort-likes-digit', plugins_url('/scripts/odometer.min.js', __FILE__), array('jquery'), PIXFORT_LIKES_VERSION, true);
			wp_enqueue_script('pixfort-likes', plugins_url('/scripts/pixfort-likes.js', __FILE__), array('jquery'), PIXFORT_LIKES_VERSION, true);
			wp_enqueue_script('jquery');
	
			wp_localize_script('pixfort-likes', 'pixfort_likes', array('ajaxurl' => admin_url('admin-ajax.php')));
		}
		
	}

	function the_content($content) {
		// Don't show on custom page templates
		if (is_page_template()) return $content;
		// Don't show on Stacked slides
		if (get_post_type() == 'slide') return $content;

		global $wp_current_filter;
		if (in_array('get_the_excerpt', (array) $wp_current_filter)) {
			return $content;
		}

		$options = get_option('pixfort_likes_settings', []);
		if (!isset($options['add_to_posts'])) $options['add_to_posts'] = '0';
		if (!isset($options['add_to_pages'])) $options['add_to_pages'] = '0';
		if (!isset($options['add_to_other'])) $options['add_to_other'] = '0';
		if (!isset($options['exclude_from'])) $options['exclude_from'] = '';

		$ids = explode(',', $options['exclude_from']);
		if (in_array(get_the_ID(), $ids)) return $content;

		if (is_singular('post') && $options['add_to_posts']) $content .= $this->do_likes();
		if (is_page() && !is_front_page() && $options['add_to_pages']) $content .= $this->do_likes();
		if ((is_front_page() || is_home() || is_category() || is_tag() || is_author() || is_date() || is_search()) && $options['add_to_other']) $content .= $this->do_likes();

		return $content;
	}

	function setup_likes($post_id) {
		if (!is_numeric($post_id)) return;

		add_post_meta($post_id, '_pixfort_likes', '0', true);
	}

	function ajax_callback($post_id) {

		$options = get_option('pixfort_likes_settings', []);
		if (!isset($options['add_to_posts'])) $options['add_to_posts'] = '0';
		if (!isset($options['add_to_pages'])) $options['add_to_pages'] = '0';
		if (!isset($options['add_to_other'])) $options['add_to_other'] = '0';
		if (!isset($options['zero_postfix'])) $options['zero_postfix'] = '';
		if (!isset($options['one_postfix'])) $options['one_postfix'] = '';
		if (!isset($options['more_postfix'])) $options['more_postfix'] = '';

		if (isset($_POST['likes_id'])) {
			// Click event. Get and Update Count
			$post_id = str_replace('pixfort-likes-', '', $_POST['likes_id']);
			echo $this->like_this($post_id, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix'], 'update');
		} else {
			// AJAXing data in. Get Count
			$post_id = str_replace('pixfort-likes-', '', $_POST['post_id']);
			echo $this->like_this($post_id, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix'], 'get');
		}

		exit;
	}

	function get_like_html($style, $state, $icon, $count) {
		$output = '';
		if ($style == 1) {
			$output .= '<span class="pixfort-likes-small d-flex align-items-center justify-content-center text-right text-xs text-body-default svg-body-default ' . $state . '">';
			$output .= '<span class="pixfort-likes-icon d-inline-block pix-pr-5">';
			$output .= $this->pix_load_inline_svg($icon);
			$output .= '</span>';
			$output .= '<span class="pixfort-likes-count align-middle font-weight-bold" data-count="' . $count . '">';
			$output .= '-';
			$output .= '</span>';
			$output .= '</span>';
		}

		if ($style == 2) {
			$output .= '<span class="pixfort-likes-small d-inline-block fly-sm text-xs shadow-sm shadow-hover text-body-default pix-px-30 pix-py-20 rounded-lg ' . $state . '">';
			$output .= '<span class="pixfort-likes-icon d-inline-block pix-pr-5">';
			$output .= $this->pix_load_inline_svg($icon);
			$output .= '</span>';
			$output .= '<span class="pixfort-likes-count align-middle font-weight-bold" data-count="' . $count . '">';
			$output .= '-';
			$output .= '</span><span class="pl-2 font-weight-bold">Likes</span>';
			$output .= '</span>';
		}
		$this->used = true;

		return $output;
	}

	function like_this($post_id, $zero_postfix = false, $one_postfix = false, $more_postfix = false, $action = 'get') {
		if (!is_numeric($post_id)) return;
		$zero_postfix = strip_tags($zero_postfix);
		$one_postfix = strip_tags($one_postfix);
		$more_postfix = strip_tags($more_postfix);

		$options = get_option('pixfort_likes_settings', []);
		if (!isset($options['like_icon'])) $options['like_icon'] = 'heart';

		switch ($action) {

			case 'get':
				$likes = get_post_meta($post_id, '_pixfort_likes', true);
				if (!$likes) {
					$likes = 0;
					add_post_meta($post_id, '_pixfort_likes', $likes, true);
				}

				// if ($likes == 0) {
				// 	$postfix = $zero_postfix;
				// } elseif ($likes == 1) {
				// 	$postfix = $one_postfix;
				// } else {
				// 	$postfix = $more_postfix;
				// }

				$state = '';
				$icon = $this->icons[$options['like_icon']][0];
				if (isset($_COOKIE['pixfort_likes_' . $post_id])) {
					$icon = $this->icons[$options['like_icon']][1];
					$state = 'pixfort-likes-liked';
				}
				$output = $this->get_like_html(1, $state, $icon, $likes);
				return $output;

				break;

			case 'update':
				$likes = get_post_meta($post_id, '_pixfort_likes', true);

				if (isset($_COOKIE['pixfort_likes_' . $post_id])) {
					$likes--;
					if ($likes < 0) {
						$likes = 0;
					}
					update_post_meta($post_id, '_pixfort_likes', $likes);
					setcookie('pixfort_likes_' . $post_id, $post_id, time() - 3600, '/');

					// if ($likes == 0) {
					// 	$postfix = $zero_postfix;
					// } elseif ($likes == 1) {
					// 	$postfix = $one_postfix;
					// } else {
					// 	$postfix = $more_postfix;
					// }
					$icon = $this->icons[$options['like_icon']][0];
					$return_arr = array(
						'icon'  => $this->pix_load_inline_svg($icon),
						'count' => $likes,
						'action'  => 'dislike'
					);
					return json_encode($return_arr);
					break;
				} else {
					$likes++;
					update_post_meta($post_id, '_pixfort_likes', $likes);
					setcookie('pixfort_likes_' . $post_id, $post_id, time() * 40, '/');

					// if ($likes == 0) {
					// 	$postfix = $zero_postfix;
					// } elseif ($likes == 1) {
					// 	$postfix = $one_postfix;
					// } else {
					// 	$postfix = $more_postfix;
					// }
					$icon = $this->icons[$options['like_icon']][1];
					$return_arr = array(
						'icon'  => $this->pix_load_inline_svg($icon),
						'count' => $likes,
						'action'  => 'like'
					);
					return json_encode($return_arr);

					break;
				}
		}
	}


	function pix_load_inline_svg($filename) {
		// Check the SVG file exists
		if (file_exists($filename)) {
			// Load and return the contents of the file
			return file_get_contents($filename);
		}
		// Return a blank string if we can't find the file.
		return '';
	}

	function shortcode($atts) {
		extract(shortcode_atts(array(
			'style' => 'default'
		), $atts));

		return $this->do_likes($style);
	}

	function do_likes($style = 'default') {
		global $post;
		
		$options = get_option('pixfort_likes_settings');
		if (!$options) $options = [];
		if (!isset($options['zero_postfix'])) $options['zero_postfix'] = '';
		if (!isset($options['one_postfix'])) $options['one_postfix'] = '';
		if (!isset($options['more_postfix'])) $options['more_postfix'] = '';

		$output = $this->like_this($post->ID, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix']);

		$class = 'pixfort-likes';
		$title = __('Like this', 'pixfort-likes');
		if (isset($_COOKIE['pixfort_likes_' . $post->ID])) {
			$class = 'pixfort-likes active';
			$title = __('You already like this', 'pixfort-likes');
		}
		if ($style == 'box') {
			return '<a href="#" class="position-relative bg-dynamic-background shadow-sm pix-px-15 text-xs rounded-xl pix-blog-badge-box d-flex align-items-center ' . $class . '" id="pixfort-likes-' . $post->ID . '" title="' . $title . '">' . $output . '</a>';
		}
		$this->used = true;
		
		return '<a href="#" class="d-inline-block position-relative text-xs align-items-center ' . $class . '" id="pixfort-likes-' . $post->ID . '" title="' . $title . '">' . $output . '</a>';
	}

	function body_class($classes) {
		$options = get_option('pixfort_likes_settings');
		if (!$options) $options = [];
		if (!is_array($options) || !isset($options['ajax_likes'])) $options['ajax_likes'] = false;

		if ($options['ajax_likes']) {
			$classes[] = 'ajax-pixfort-likes';
		}
		return $classes;
	}
}
global $pix_likes;
$pix_likes = new PixFortLikes();

/**
 * Template Tag
 */
function pixfort_likes() {
	global $pix_likes;
	echo $pix_likes->do_likes();
}

function get_pixfort_likes($style = 'default') {
	global $pix_likes;
	return $pix_likes->do_likes($style);
}


require_once 'widget.php';
