<?php

namespace Elementor;

class Pix_Eor_Template_Post_Content extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-template-post-content';
	}

	public function get_title() {
		return 'Post Content';
	}

	public function get_icon() {
		return 'eicon-post-content pixfort-elementor-element pixfort-elementor-post-content';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function show_in_panel() {
		// Only show this widget when editing a pixfort_template with post type
		return $this->is_post_template_context();
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	/**
	 * Check if we're in the context of editing a pixfort_template with "post" taxonomy
	 */
	private function is_post_template_context() {
		// Check if we're in Elementor editor
		if (!\Elementor\Plugin::$instance->editor->is_edit_mode()) {
			return false;
		}

		// Get current post ID from Elementor
		$post_id = \Elementor\Plugin::$instance->editor->get_post_id();

		if (!$post_id) {
			return false;
		}

		// Check if post type is pixfort_template
		if (get_post_type($post_id) !== 'pixfort_template') {
			return false;
		}

		// Check if template type is "post", "page", "product", or "template"
		$terms = get_the_terms($post_id, 'pixfort_template_type');
		if ($terms && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				if ($term->slug === 'post' || $term->slug === 'page' || $term->slug === 'product' || $term->slug === 'template') {
					return true;
				}
			}
		}

		return false;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __('Content', 'pixfort-core'),
			]
		);

		$this->add_control(
			'show_page_break',
			[
				'label' => __('Show Page Break', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
				'description' => __('Show the page break (<!--more-->) pagination links.', 'pixfort-core'),
			]
		);

		$this->add_control(
			'strip_shortcodes',
			[
				'label' => __('Strip Shortcodes', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
				'description' => __('Remove shortcodes from the content.', 'pixfort-core'),
			]
		);

		$this->end_controls_section();

		// Style section
		$this->start_controls_section(
			'section_style',
			[
				'label' => __('Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __('Text Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-post-content, {{WRAPPER}} .pix-post-content p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .pix-post-content',
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => __('Alignment', 'pixfort-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'pixfort-core'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'pixfort-core'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'pixfort-core'),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __('Justified', 'pixfort-core'),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label' => __('Margin', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-post-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Links Style section
		$this->start_controls_section(
			'section_links_style',
			[
				'label' => __('Links Style', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'links_color',
			[
				'label' => __('Links Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-post-content a' => 'color: {{VALUE}};',
				],
			]
		);

		// $this->add_control(
		// 	'links_hover_color',
		// 	[
		// 		'label' => __('Links Hover Color', 'pixfort-core'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .pix-post-content a:hover' => 'color: {{VALUE}};',
		// 		],
		// 	]
		// );

		$this->end_controls_section();
	}



	protected function render() {
		global $post;

		$settings = $this->get_settings_for_display();

		// Get current post
		$current_post = get_post();
		if (!$current_post) {
			return;
		}

		// Check if current post is a pixfort_template
		$is_template = get_post_type($current_post->ID) === 'pixfort_template';

		if ($is_template) {
			// If we're viewing a pixfort_template, get content from a real post to avoid recursion
			$demo_post = $this->get_demo_post();

			if ($demo_post) {
				// Store original post
				$original_post = $post;

				// Set up post data for the demo post so all WordPress functions work
				$post = $demo_post;
				setup_postdata($post);

				echo '<div class="pix-post-content">';

				// Strip shortcodes if enabled
				if ($settings['strip_shortcodes'] === 'yes') {
					// Get content and strip shortcodes
					$content = get_the_content();
					$content = strip_shortcodes($content);
					// Apply content filters
					$content = apply_filters('the_content', $content);
					echo $content;
				} else {
					// Use the_content() to render everything properly
					if ($settings['show_page_break'] === 'yes') {
						if (class_exists('\Elementor\Plugin') && !empty($post->ID)) {
							$output = \Elementor\plugin::instance()->frontend->get_builder_content($post->ID, true);
							if(empty($output)) {
								$output = apply_filters('the_content', get_the_content());
							}
							echo $output;

						}
					} else {
						// Get content without page break links
						$content = get_the_content();
						if (class_exists('\Elementor\Plugin') && !empty($post->ID)) {
							$content = \Elementor\plugin::instance()->frontend->get_builder_content($post->ID, true);
						}
						$content = preg_replace('/<p><span id="more-\d+"><\/span><\/p>/', '', $content);
						if(empty($content)) {
							$content = apply_filters('the_content', get_the_content());
						}
						echo $content;
					}
				}

				echo '</div>';

				// Restore original post data
				$post = $original_post;
				wp_reset_postdata();
			} else {
				// No posts available, show message
				echo '<div class="pix-post-content">';
				echo '<p>' . __('No posts found on the site to display. Create a post to see how the content will be rendered.', 'pixfort-core') . '</p>';
				echo '</div>';
			}
		} else if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
			// In editor mode for non-template posts, show placeholder content
			echo '<div class="pix-post-content">';
			echo '<p>' . __('This is a placeholder for the post content. The actual post content will be displayed here when viewing a real post. You can style this content using the widget settings.', 'pixfort-core') . '</p>';
			echo '<p>' . __('Sample paragraph with <a href="#">a link</a> to demonstrate link styling options.', 'pixfort-core') . '</p>';
			echo '<h3>' . __('Sample Heading', 'pixfort-core') . '</h3>';
			echo '<p>' . __('Additional sample content to show how the post content will be displayed with your current styling settings.', 'pixfort-core') . '</p>';
			echo '</div>';
		} else {
			// Get actual post content for non-template posts
			echo '<div class="pix-post-content">';

			// Strip shortcodes if enabled
			if ($settings['strip_shortcodes'] === 'yes') {
				$content = get_the_content();
				$content = strip_shortcodes($content);
				$content = apply_filters('the_content', $content);
				echo $content;
			} else {
				// Use the_content() to render everything properly
				if ($settings['show_page_break'] === 'yes') {
					the_content();
				} else {
					// Get content without page break links
					$content = get_the_content();
					$content = apply_filters('the_content', $content);
					$content = preg_replace('/<p><span id="more-\d+"><\/span><\/p>/', '', $content);
					echo $content;
				}
			}

			echo '</div>';
		}
	}

	/**
	 * Get a demo post to display when editing a pixfort_template
	 * 
	 * @return WP_Post|null
	 */
	private function get_demo_post() {
		
		$isProductTemplate = false;
		$current_post = get_post();
		$post_id = $current_post->ID;

		if (!$post_id) {
			return false;
		}
		// Check if template type is "post"
		$terms = get_the_terms($post_id, 'pixfort_template_type');
		if ($terms && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				if ($term->slug === 'product') {
					$isProductTemplate = true;
				}
			}
		}

		if ($isProductTemplate) {
			$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'posts_per_page' => 1,
				'orderby' => 'date',
				'order' => 'DESC',
			);
		} else {
			// Get a published post to use as demo content
			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => 1,
				'orderby' => 'date',
				'order' => 'DESC',
			);
		}

		$posts = get_posts($args);
		if(!empty($posts) && $isProductTemplate) {
			return get_post($posts[0]->ID);
		}
		return !empty($posts) ? $posts[0] : null;
	}
}
