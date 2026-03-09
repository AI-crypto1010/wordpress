<?php

if (!function_exists('pix_get_wpb_global_template_options')) {
	function pix_get_wpb_global_template_options() {
		$options = array(
			esc_html__('Choose Template', 'pixfort-core') => '',
		);

		$pixfort_templates = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'pixfort_template',
			'tax_query' => array(
				array(
					'taxonomy' => 'pixfort_template_type',
					'field' => 'slug',
					'terms' => 'template',
				),
			),
			'orderby' => 'title',
			'order' => 'ASC',
		));

		foreach ($pixfort_templates as $template_post) {
			$title = !empty($template_post->post_title) ? $template_post->post_title : __('Untitled', 'pixfort-core');
			$label = sprintf(
				'%1$s (%2$s #%3$d)',
				esc_html($title),
				esc_html__('pixfort Template', 'pixfort-core'),
				(int) $template_post->ID
			);
			$options[$label] = (string) $template_post->ID;
		}

		$elementor_templates = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'elementor_library',
			'orderby' => 'title',
			'order' => 'ASC',
		));

		foreach ($elementor_templates as $template_post) {
			$title = !empty($template_post->post_title) ? $template_post->post_title : __('Untitled', 'pixfort-core');
			$type_label = esc_html__('Elementor Template', 'pixfort-core');

			if (class_exists('\Elementor\Plugin')) {
				$document = \Elementor\Plugin::instance()->documents->get($template_post->ID);
				if ($document && method_exists($document, 'get_post_type_title')) {
					$type_label = $document->get_post_type_title();
				}
			}

			$label = sprintf(
				'%1$s (%2$s #%3$d)',
				esc_html($title),
				esc_html($type_label),
				(int) $template_post->ID
			);
			$options[$label] = (string) $template_post->ID;
		}

		return $options;
	}
}

$global_template_options = pix_get_wpb_global_template_options();

vc_map(array(
	'base' => 'pix_global_template',
	'name' => __('Global Template', 'pixfort-core'),
	'category' => __('pixfort', 'pixfort-core'),
	'class' => 'pixfort_element',
	'weight' => '1000',
	'icon' => PIX_CORE_PLUGIN_URI . 'functions/images/elements/global-template.webp',
	'description' => __('Display a global template from your library', 'pixfort-core'),
	'params' => array(
		array(
			'param_name' => 'template_id',
			'type' => 'dropdown',
			'heading' => __('Choose a template', 'pixfort-core'),
			'admin_label' => true,
			'value' => $global_template_options,
		),
		array(
			'type' => 'css_editor',
			'heading' => __('Css', 'pixfort-core'),
			'param_name' => 'css',
			'group' => __('Design options', 'pixfort-core'),
		),
	),
));

