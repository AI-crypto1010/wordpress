<?php /* Template Name: Blog (Theme options Default) */

$blog_template = 'right-sidebar';
if (!empty(pix_get_option('blog-page-template'))) {
	$blog_template = pix_get_option('blog-page-template');
}

switch ($blog_template) {
	case 'left-sidebar':
		get_template_part('templates/template-blog-left-sidebar');
		break;
	case 'full-width':
		get_template_part('templates/template-blog-without-sidebar');
		break;
	case 'full-page-width':
		get_template_part('templates/template-blog-full-width');
		break;
	case 'with-offset':
		get_template_part('templates/template-blog-with-offset');
		break;
	default:
		get_template_part('templates/template-blog-right-sidebar');
}
