=== Plugin Name ===
Contributors: pixfort
Requires at least: 3.4
Tested up to: 5.2.2
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add "like" functionality to your posts and pages

== Description ==

Add "like" functionality to your posts and pages. Display your most liked posts via widget.

== Installation ==

1. Upload `pixfort-likes` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure the settings via the menu item that appears
1. Place `<?php if( function_exists('get_pixfort_likes') ) echo get_pixfort_likes(); ?>` in your templates
1. Use the `[pixfort_likes]` shortcode in your posts and pages