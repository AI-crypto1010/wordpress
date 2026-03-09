<?php

namespace Elementor;

class Pix_Eor_Template_Post_Comments extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-template-post-comments';
	}

	public function get_title() {
		return 'Post Comments';
	}

	public function get_icon() {
		return 'eicon-comments pixfort-elementor-element pixfort-elementor-post-comments';
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
		if (!Plugin::$instance->editor->is_edit_mode()) {
			return false;
		}

		// Get current post ID from Elementor
		$post_id = Plugin::$instance->editor->get_post_id();

		if (!$post_id) {
			return false;
		}

		// Check if post type is pixfort_template
		if (get_post_type($post_id) !== 'pixfort_template') {
			return false;
		}

		// Check if template type is "post", "page", or "template"
		$terms = get_the_terms($post_id, 'pixfort_template_type');
		if ($terms && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				if ($term->slug === 'post' || $term->slug === 'page' || $term->slug === 'template') {
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
			'custom_panel_alert',
			[
				'type' => \Elementor\Controls_Manager::ALERT,
				'alert_type' => 'info',
				// 'heading' => esc_html__( 'Custom Alert', 'textdomain' ),
				'content' => esc_html__('Comments will display depending on the default WordPress settings in WordPress admin panel → Settings → Discussion.', 'pixfort-core'),
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		if (Plugin::$instance->editor->is_edit_mode()) {
			// In editor mode, show placeholder comments
			$this->render_placeholder_comments();
		} else {
			// Get actual post comments
			$this->render_actual_comments();
		}
	}

	private function render_placeholder_comments() {
		// Get a post with comments for preview
		$posts_with_comments = get_posts(array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'numberposts' => 1,
			'meta_query' => array(
				array(
					'key' => 'comment_count',
					'value' => '0',
					'compare' => '>'
				)
			)
		));

		// If no posts with comments found, try a different approach
		if (empty($posts_with_comments)) {
			$posts_with_comments = get_posts(array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'numberposts' => 5
			));

			// Find the first post that has comments
			foreach ($posts_with_comments as $test_post) {
				if (get_comments_number($test_post->ID) > 0) {
					$posts_with_comments = array($test_post);
					break;
				}
			}
		}

		if (!empty($posts_with_comments)) {
			$preview_post = $posts_with_comments[0];

			// Temporarily set this post as the current post for rendering
			global $post;
			$original_post = $post;
			$post = $preview_post;
			setup_postdata($post);

			// Render actual comments but with editor-specific comment form
			$this->render_actual_comments();

			// Restore original post
			$post = $original_post;
			wp_reset_postdata();
		}
	}

	private function render_actual_comments() {
		comments_template();
	}
}
