<?php

namespace Elementor;

class Pix_Eor_Template_Featured_Image extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-template-featured-image';
	}

	public function get_title() {
		return 'Featured Image';
	}

	public function get_icon() {
		return 'eicon-featured-image pixfort-elementor-element pixfort-elementor-featured-image';
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
			'image_size',
			[
				'label' => __('Image Size', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'full',
				'options' => $this->get_image_sizes(),
			]
		);

		$this->add_control(
			'link_to',
			[
				'label' => __('Link', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => __('None', 'pixfort-core'),
					'post' => __('Post URL', 'pixfort-core'),
					'media' => __('Media File', 'pixfort-core'),
					'custom' => __('Custom URL', 'pixfort-core'),
				],
			]
		);

		$this->add_control(
			'custom_url',
			[
				'label' => __('Custom URL', 'pixfort-core'),
				'type' => Controls_Manager::URL,
				'placeholder' => __('https://your-link.com', 'pixfort-core'),
				'condition' => [
					'link_to' => 'custom',
				],
			]
		);

		$this->add_control(
			'open_lightbox',
			[
				'label' => __('Lightbox', 'pixfort-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'link_to' => 'media',
				],
			]
		);

		$this->add_control(
			'fallback_image',
			[
				'label' => __('Fallback Image', 'pixfort-core'),
				'type' => Controls_Manager::MEDIA,
				'description' => __('This image will be shown if the post has no featured image.', 'pixfort-core'),
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

		$this->add_responsive_control(
			'width',
			[
				'label' => __('Width', 'pixfort-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'vw'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pix-featured-image img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'max_width',
			[
				'label' => __('Max Width', 'pixfort-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'vw'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pix-featured-image img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => __('Height', 'pixfort-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'vh'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pix-featured-image img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'object_fit',
			[
				'label' => __('Object Fit', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __('Default', 'pixfort-core'),
					'fill' => __('Fill', 'pixfort-core'),
					'cover' => __('Cover', 'pixfort-core'),
					'contain' => __('Contain', 'pixfort-core'),
					'scale-down' => __('Scale Down', 'pixfort-core'),
					'none' => __('None', 'pixfort-core'),
				],
				'selectors' => [
					'{{WRAPPER}} .pix-featured-image img' => 'object-fit: {{VALUE}};',
				],
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

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .pix-featured-image img',
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label' => __('Border Radius', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-featured-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .pix-featured-image img',
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label' => __('Margin', 'pixfort-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .pix-featured-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Get available image sizes
	 */
	private function get_image_sizes() {
		$image_sizes = get_intermediate_image_sizes();
		$image_sizes[] = 'full';

		$options = array();
		foreach ($image_sizes as $size) {
			$options[$size] = ucwords(str_replace(['_', '-'], ' ', $size));
		}

		return $options;
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$image_id = '';
		$image_url = '';

		if (Plugin::$instance->editor->is_edit_mode()) {
			// In editor mode, try to get a placeholder or fallback image
			if (!empty($settings['fallback_image']['id'])) {
				$image_id = $settings['fallback_image']['id'];
			} else {
				// Use a placeholder image URL
				$image_url = 'https://via.placeholder.com/800x600/cccccc/999999?text=Featured+Image+Placeholder';
			}
		} else {
			// Get actual featured image
			$post = get_post();
			if ($post && has_post_thumbnail($post->ID)) {
				$image_id = get_post_thumbnail_id($post->ID);
			} elseif (!empty($settings['fallback_image']['id'])) {
				$image_id = $settings['fallback_image']['id'];
			} else {
				return; // No image to show
			}
		}

		// Get image HTML
		$image_html = '';
		if ($image_id) {
			$image_html = wp_get_attachment_image($image_id, $settings['image_size'], false, ['class' => 'pix-featured-image-img']);
		} elseif ($image_url) {
			$image_html = '<img src="' . esc_url($image_url) . '" alt="' . esc_attr__('Featured Image Placeholder', 'pixfort-core') . '" class="pix-featured-image-img">';
		}

		if (empty($image_html)) {
			return;
		}

		// Prepare link attributes
		$link_attrs = '';
		$has_link = false;

		if ($settings['link_to'] === 'post') {
			$link_attrs = 'href="' . esc_url(get_permalink()) . '"';
			$has_link = true;
		} elseif ($settings['link_to'] === 'media' && $image_id) {
			$media_url = wp_get_attachment_image_url($image_id, 'full');
			$link_attrs = 'href="' . esc_url($media_url) . '"';
			if ($settings['open_lightbox'] === 'yes') {
				$link_attrs .= ' data-elementor-open-lightbox="yes"';
			}
			$has_link = true;
		} elseif ($settings['link_to'] === 'custom' && !empty($settings['custom_url']['url'])) {
			$link_attrs = 'href="' . esc_url($settings['custom_url']['url']) . '"';
			if ($settings['custom_url']['is_external']) {
				$link_attrs .= ' target="_blank"';
			}
			if ($settings['custom_url']['nofollow']) {
				$link_attrs .= ' rel="nofollow"';
			}
			$has_link = true;
		}

		// Render the image
		echo '<div class="pix-featured-image">';
		if ($has_link) {
			echo "<a {$link_attrs}>{$image_html}</a>";
		} else {
			echo $image_html;
		}
		echo '</div>';
	}
}
