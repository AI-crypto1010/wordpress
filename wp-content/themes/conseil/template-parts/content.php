<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pixfort theme
 */


$attrs = array(
	'blog_layout'		=> 'default'
);
$blog_type = 'default';
if (!empty(pix_get_option('blog-page-layout'))) {
	$attrs['blog_type'] = pix_get_option('blog-page-layout');
}
if (!empty(pix_get_option('blog-style'))) {
	$attrs['blog_layout'] = pix_get_option('blog-style');
}
if (!empty(pix_get_option('blog-style-box'))) {
	$attrs['blog_style_box'] = pix_get_option('blog-style-box');
}
if (!empty(pix_get_option('blog-box-rounded'))) {
	$attrs['rounded_img'] = pix_get_option('blog-box-rounded');
}
if (!empty(pix_get_option('blog-box-style'))) {
	$attrs['style'] = pix_get_option('blog-box-style');
}
if (!empty(pix_get_option('blog-box-hover-effect'))) {
	$attrs['hover_effect'] = pix_get_option('blog-box-hover-effect');
}
if (!empty(pix_get_option('blog-box-add-hover-effect'))) {
	$attrs['add_hover_effect'] = pix_get_option('blog-box-add-hover-effect');
}

echo pixfort_get_post_excerpt_template($attrs);
