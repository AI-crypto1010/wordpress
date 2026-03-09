<?php

namespace Elementor;

class Pix_Eor_Global_Template extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	public function get_name() {
		return 'pix-global-template';
	}

	public function get_title() {
		return 'Global Template';
	}

	public function get_icon() {
		return 'eicon-document-file pixfort-elementor-element pixfort-elementor-global-template';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	/**
	 * Get available templates grouped by type
	 */
	private function get_templates_groups() {
		$results = [];
		$pixfortResults = [];
		$elementorResults = [];

		// Get all Elementor templates
		$elementor_posts = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'elementor_library'
		));

		foreach ($elementor_posts as $post) {
			$document = \Elementor\Plugin::instance()->documents->get($post->ID);
			if ($document) {
				$text = esc_html($post->post_title) . ' (' . $document->get_post_type_title() . ')';
				$elementorResults[$post->ID] = $text;
			}
		}
		
		// Get pixfort_template templates with 'template' type
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
		));
		
		foreach ($pixfort_templates as $post) {
			$text = esc_html($post->post_title) . ' (' . __('pixfort Template', 'pixfort-core') . ')';
			$pixfortResults[$post->ID] = $text;
		}

		$results['pixfort_templates'] = [
			'label' => __('pixfort Templates', 'pixfort-core'),
			'options' => $pixfortResults
		];
		$results['elementor_templates'] = [
			'label' => __('Elementor Templates', 'pixfort-core'),
			'options' => $elementorResults
		];

		return $results;
	}

	protected function register_controls() {

		// Template Section
		$this->start_controls_section(
			'section_template',
			[
				'label' => __('Template', 'pixfort-core'),
			]
		);

		$this->add_control(
			'template_id',
			[
				'label' => __('Choose a template', 'pixfort-core'),
				'type' => \Elementor\CustomControl\Pix_Template_Control::PixTemplateSelector,
				'groups' => $this->get_templates_groups(),
				'default' => '',
				'description' => __('Select a pixfort or Elementor template to display', 'pixfort-core'),
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		echo \PixfortCore::instance()->elementsManager->renderElement('GlobalTemplate', $settings);
	}

	public function get_script_depends() {
		return [];
	}
}
