<?php

namespace Elementor;

class Pix_Eor_Template_Post_Info extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-template-post-info';
	}

	public function get_title() {
		return 'Post Info';
	}

	public function get_icon() {
		return 'eicon-post-info pixfort-elementor-element pixfort-elementor-post-info';
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

		// Check if template type is "post"
		$terms = get_the_terms($post_id, 'pixfort_template_type');
		if ($terms && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				if ($term->slug === 'post') {
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
			'show_date',
			[
				'label' => __('Show Date', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'date_format',
			[
				'label' => __('Date Format', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __('Default', 'pixfort-core'),
					'F j, Y' => __('March 6, 2023', 'pixfort-core'),
					'Y-m-d' => __('2023-03-06', 'pixfort-core'),
					'M j, Y' => __('Mar 6, 2023', 'pixfort-core'),
					'j F Y' => __('6 March 2023', 'pixfort-core'),
					'custom' => __('Custom', 'pixfort-core'),
				],
				'condition' => [
					'show_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'custom_date_format',
			[
				'label' => __('Custom Date Format', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => 'F j, Y',
				'description' => __('Enter date format (e.g., "F j, Y" for "March 6, 2023")', 'pixfort-core'),
				'condition' => [
					'show_date' => 'yes',
					'date_format' => 'custom',
				],
			]
		);

		$this->add_control(
			'show_author',
			[
				'label' => __('Show Author', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'link_author',
			[
				'label' => __('Link Author to Archive', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'show_author' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_categories',
			[
				'label' => __('Show Categories', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'max_categories',
			[
				'label' => __('Max Categories', 'pixfort-core'),
				'type' => Controls_Manager::NUMBER,
				'default' => 3,
				'min' => 1,
				'max' => 10,
				'description' => __('Maximum number of categories to display.', 'pixfort-core'),
				'condition' => [
					'show_categories' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_tags',
			[
				'label' => __('Show Tags', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'max_tags',
			[
				'label' => __('Max Tags', 'pixfort-core'),
				'type' => Controls_Manager::NUMBER,
				'default' => 5,
				'min' => 1,
				'max' => 20,
				'description' => __('Maximum number of tags to display.', 'pixfort-core'),
				'condition' => [
					'show_tags' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_comments_count',
			[
				'label' => __('Show Comments Count', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'show_reading_time',
			[
				'label' => __('Show Reading Time', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'separator',
			[
				'label' => __('Separator', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'default' => ' • ',
				'description' => __('Separator between post info items.', 'pixfort-core'),
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => __('Layout', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'inline',
				'options' => [
					'inline' => __('Inline', 'pixfort-core'),
					'list' => __('List', 'pixfort-core'),
				],
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
					'{{WRAPPER}} .pix-post-info' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .pix-post-info',
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
					'{{WRAPPER}} .pix-post-info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Links Style section
		$this->start_controls_section(
			'section_links_style',
			[
				'label' => __('Links', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'links_color',
			[
				'label' => __('Links Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-post-info a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'links_hover_color',
			[
				'label' => __('Links Hover Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-post-info a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Categories Style section
		$this->start_controls_section(
			'section_categories_style',
			[
				'label' => __('Categories', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_categories' => 'yes',
				],
			]
		);

		$this->add_control(
			'categories_color',
			[
				'label' => __('Categories Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-post-categories a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'categories_background',
			[
				'label' => __('Categories Background', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-post-categories a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'categories_padding',
			[
				'label' => __('Categories Padding', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .pix-post-categories a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'categories_border_radius',
			[
				'label' => __('Categories Border Radius', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-post-categories a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Tags Style section
		$this->start_controls_section(
			'section_tags_style',
			[
				'label' => __('Tags', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_tags' => 'yes',
				],
			]
		);

		$this->add_control(
			'tags_color',
			[
				'label' => __('Tags Color', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-post-tags a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tags_background',
			[
				'label' => __('Tags Background', 'pixfort-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pix-post-tags a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'tags_padding',
			[
				'label' => __('Tags Padding', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .pix-post-tags a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tags_border_radius',
			[
				'label' => __('Tags Border Radius', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-post-tags a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if (Plugin::$instance->editor->is_edit_mode()) {
			// In editor mode, show placeholder post info
			$this->render_placeholder_info($settings);
		} else {
			// Get actual post info
			$this->render_actual_info($settings);
		}
	}

	private function render_placeholder_info($settings) {
		$layout_class = 'pix-post-info-' . $settings['layout'];
		$info_items = [];

		if ($settings['show_date'] === 'yes') {
			$info_items[] = '<span class="pix-post-date">' . __('March 15, 2024', 'pixfort-core') . '</span>';
		}

		if ($settings['show_author'] === 'yes') {
			$author_text = __('John Doe', 'pixfort-core');
			if ($settings['link_author'] === 'yes') {
				$author_text = '<a href="#">' . $author_text . '</a>';
			}
			$info_items[] = '<span class="pix-post-author">' . $author_text . '</span>';
		}

		if ($settings['show_categories'] === 'yes') {
			$info_items[] = '<span class="pix-post-categories"><a href="#">' . __('Technology', 'pixfort-core') . '</a>, <a href="#">' . __('Web Design', 'pixfort-core') . '</a></span>';
		}

		if ($settings['show_tags'] === 'yes') {
			$info_items[] = '<span class="pix-post-tags"><a href="#">' . __('WordPress', 'pixfort-core') . '</a>, <a href="#">' . __('Tutorial', 'pixfort-core') . '</a></span>';
		}

		if ($settings['show_comments_count'] === 'yes') {
			$info_items[] = '<span class="pix-post-comments">' . __('5 Comments', 'pixfort-core') . '</span>';
		}

		if ($settings['show_reading_time'] === 'yes') {
			$info_items[] = '<span class="pix-post-reading-time">' . __('3 min read', 'pixfort-core') . '</span>';
		}

		if (!empty($info_items)) {
			echo '<div class="pix-post-info ' . esc_attr($layout_class) . '">';

			if ($settings['layout'] === 'list') {
				echo '<ul>';
				foreach ($info_items as $item) {
					echo '<li>' . $item . '</li>';
				}
				echo '</ul>';
			} else {
				echo implode($settings['separator'], $info_items);
			}

			echo '</div>';
		}
	}

	private function render_actual_info($settings) {
		$post = get_post();
		if (!$post) {
			return;
		}

		$layout_class = 'pix-post-info-' . $settings['layout'];
		$info_items = [];

		// Date
		if ($settings['show_date'] === 'yes') {
			$date_format = $settings['date_format'];
			if ($date_format === 'default') {
				$date_format = get_option('date_format');
			} elseif ($date_format === 'custom') {
				$date_format = $settings['custom_date_format'];
			}
			$info_items[] = '<span class="pix-post-date">' . get_the_date($date_format, $post) . '</span>';
		}

		// Author
		if ($settings['show_author'] === 'yes') {
			$author_name = get_the_author_meta('display_name', $post->post_author);
			if ($settings['link_author'] === 'yes') {
				$author_name = '<a href="' . esc_url(get_author_posts_url($post->post_author)) . '">' . esc_html($author_name) . '</a>';
			} else {
				$author_name = esc_html($author_name);
			}
			$info_items[] = '<span class="pix-post-author">' . $author_name . '</span>';
		}

		// Categories
		if ($settings['show_categories'] === 'yes') {
			$categories = get_the_category($post->ID);
			if (!empty($categories)) {
				$category_links = [];
				$max_categories = $settings['max_categories'];
				$count = 0;

				foreach ($categories as $category) {
					if ($count >= $max_categories) break;
					$category_links[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
					$count++;
				}

				if (!empty($category_links)) {
					$info_items[] = '<span class="pix-post-categories">' . implode(', ', $category_links) . '</span>';
				}
			}
		}

		// Tags
		if ($settings['show_tags'] === 'yes') {
			$tags = get_the_tags($post->ID);
			if (!empty($tags)) {
				$tag_links = [];
				$max_tags = $settings['max_tags'];
				$count = 0;

				foreach ($tags as $tag) {
					if ($count >= $max_tags) break;
					$tag_links[] = '<a href="' . esc_url(get_tag_link($tag->term_id)) . '">' . esc_html($tag->name) . '</a>';
					$count++;
				}

				if (!empty($tag_links)) {
					$info_items[] = '<span class="pix-post-tags">' . implode(', ', $tag_links) . '</span>';
				}
			}
		}

		// Comments count
		if ($settings['show_comments_count'] === 'yes') {
			$comments_count = get_comments_number($post->ID);
			$comments_text = sprintf(_n('%d Comment', '%d Comments', $comments_count, 'pixfort-core'), $comments_count);
			$info_items[] = '<span class="pix-post-comments">' . $comments_text . '</span>';
		}

		// Reading time
		if ($settings['show_reading_time'] === 'yes') {
			$word_count = str_word_count(strip_tags($post->post_content));
			$reading_time = ceil($word_count / 200); // Assuming 200 words per minute
			$reading_text = sprintf(_n('%d min read', '%d min read', $reading_time, 'pixfort-core'), $reading_time);
			$info_items[] = '<span class="pix-post-reading-time">' . $reading_text . '</span>';
		}

		if (!empty($info_items)) {
			echo '<div class="pix-post-info ' . esc_attr($layout_class) . '">';

			if ($settings['layout'] === 'list') {
				echo '<ul>';
				foreach ($info_items as $item) {
					echo '<li>' . $item . '</li>';
				}
				echo '</ul>';
			} else {
				echo implode($settings['separator'], $info_items);
			}

			echo '</div>';
		}
	}
}
