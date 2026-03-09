<?php

if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;

class PixSection {

	public function __construct() {
		add_action('elementor/frontend/section/before_render', array($this, 'before_render'), 1);
		add_action('elementor/frontend/column/before_render', array($this, 'before_render'), 1);
		add_action('elementor/frontend/container/before_render', array($this, 'before_render'), 1);
		add_action('elementor/frontend/column/before_render', array($this, 'render_dividers'), 1);
		add_action('elementor/frontend/container/before_render', array($this, 'render_dividers'), 1);
		if (version_compare(ELEMENTOR_VERSION, '3.19.0', '<')) {
			if (\Elementor\Plugin::$instance->experiments->is_feature_active('e_dom_optimization')) {
				add_action('elementor/frontend/section/before_render', array($this, 'before_render_divider'), 1);
				add_action('elementor/frontend/section/after_render', array($this, 'after_render_divider'), 1);
			} else {
				add_action('elementor/frontend/section/before_render', array($this, 'render_dividers'), 1);
			}
		} else {
			add_action('elementor/frontend/section/before_render', array($this, 'before_render_divider'), 1);
			add_action('elementor/frontend/section/after_render', array($this, 'after_render_divider'), 1);
		}
		// add_action('elementor/frontend/section/before_render', array($this, 'render_dividers'), 1);

		// Extend Elementor's built-in "Overflow" control to support "clip".
		add_action('elementor/element/section/section_layout/before_section_end', array($this, 'extend_overflow_control'), 999);
		add_action('elementor/element/column/layout/before_section_end', array($this, 'extend_overflow_control'), 999);
		add_action('elementor/element/container/section_layout_container/before_section_end', array($this, 'extend_overflow_control'), 999);
		add_action('elementor/element/container/layout/before_section_end', array($this, 'extend_overflow_control'), 999);
		// Fallback: run after any section ends (Elementor changes section IDs across versions).
		add_action('elementor/element/after_section_end', array($this, 'maybe_extend_overflow_control'), 999, 3);

		add_action('elementor/element/section/section_layout/after_section_end', array($this, 'register_controls'), 1);
		add_action('elementor/element/section/section_layout/after_section_end', array($this, 'register_controls'), 1);
		add_action('elementor/element/container/section_layout_container/after_section_end', array($this, 'register_controls'), 1);
		add_action('elementor/element/column/layout/after_section_end', array($this, 'register_controls'), 1);
		add_action('elementor/element/container/layout/after_section_end', array($this, 'register_controls'), 1);
		
		// Enqueue advanced transform handler script for Elementor editor preview
		add_action('elementor/frontend/after_register_scripts', array($this, 'enqueue_editor_scripts'));
	}

	/**
	 * Enqueue scripts for Elementor editor preview
	 */
	public function enqueue_editor_scripts() {
		// Only load in Elementor editor (preview iframe)
		if (\Elementor\Plugin::$instance->preview->is_preview_mode() || \Elementor\Plugin::$instance->editor->is_edit_mode()) {
			wp_enqueue_script(
				'pix-advanced-transform-handler',
				PIX_CORE_PLUGIN_URI . 'functions/elementor/includes/js/pix-advanced-transform-handler.js',
				array('jquery', 'elementor-frontend'),
				PIXFORT_PLUGIN_VERSION,
				true
			);
		}
	}

	public function maybe_extend_overflow_control($element, $section_id = null, $args = null) {
		if (!is_object($element) || !method_exists($element, 'get_name')) return;
		$name = $element->get_name();
		if ($name !== 'section' && $name !== 'column' && $name !== 'container') return;
		$this->extend_overflow_control($element);
	}

	/**
	 * Add "Clip" option to Elementor's built-in overflow control (when present).
	 *
	 * Elementor's control configuration differs between element types/versions:
	 * - Some use `selectors` like `overflow: {{VALUE}};` (value-only).
	 * - Some use `selectors_dictionary` that maps values to full CSS declarations.
	 */
	public function extend_overflow_control($element) {
		if (!is_object($element)) return;
		if (!method_exists($element, 'get_controls') || !method_exists($element, 'update_control')) return;

		$control_id = 'overflow';
		$controls = $element->get_controls();
		if (empty($controls[$control_id]) || !is_array($controls[$control_id])) return;

		$control = $controls[$control_id];
		$options = (isset($control['options']) && is_array($control['options'])) ? $control['options'] : [];
		if (isset($options['clip'])) return;

		$clip_label = esc_html__('Clip', 'pixfort-core');
		$options['clip'] = $clip_label;

		$update_args = [
			'options' => $options,
		];

		if (isset($control['selectors_dictionary']) && is_array($control['selectors_dictionary'])) {
			$dict = $control['selectors_dictionary'];
			if (!isset($dict['clip'])) {
				$selectors = (isset($control['selectors']) && is_array($control['selectors'])) ? $control['selectors'] : [];
				$dict['clip'] = $this->pix_build_overflow_dict_value($dict, $selectors);
			}
			$update_args['selectors_dictionary'] = $dict;
		}

		$element->update_control($control_id, $update_args);
	}

	private function pix_selectors_expect_overflow_value_only($selectors) {
		if (!is_array($selectors)) return false;
		foreach ($selectors as $css) {
			if (!is_string($css)) continue;
			if (preg_match('/overflow\\s*:\\s*{{VALUE}}/i', $css)) return true;
		}
		return false;
	}

	private function pix_build_overflow_dict_value($dict, $selectors) {
		// If selectors already set `overflow: {{VALUE}}`, dictionary should map to the raw value.
		if ($this->pix_selectors_expect_overflow_value_only($selectors)) {
			return 'clip';
		}

		// Otherwise dictionary likely maps to full CSS declarations.
		$sample = null;
		if (isset($dict['hidden']) && is_string($dict['hidden'])) {
			$sample = $dict['hidden'];
		} elseif (isset($dict['auto']) && is_string($dict['auto'])) {
			$sample = $dict['auto'];
		} else {
			foreach ($dict as $v) {
				if (is_string($v)) {
					$sample = $v;
					break;
				}
			}
		}

		if (is_string($sample) && preg_match('/overflow\\s*:/i', $sample)) {
			// Preserve suffix like `!important` if present.
			$out = preg_replace('/(overflow\\s*:\\s*)([^;!]+)(\\s*!important)?/i', '$1clip$3', $sample, 1);
			if (is_string($out) && $out !== '') {
				return $out;
			}
		}

		return 'overflow: clip;';
	}

	public function register_controls($element) {

		if (! is_object($element)) return;

		$elType = $element->get_title();
		$isColumn = false;
		$hide_in_top = true;
		if ($element->get_name() === 'column') {
			$isColumn = true;
			$hide_in_top = false;
		}
		if ($element->get_name() === 'container') {
			$hide_in_top = false;
		}
		$element->start_controls_section(
			'pix_drop_animation_section',
			[
				'label' => __('<img class="pix-elementor-section-logo" src="' . PIX_CORE_PLUGIN_URI . 'functions/images/pixfort-logo.svg" /> pixfort Options', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_LAYOUT
			]
		);

		if (!$isColumn) {
			$element->add_control(
				'pix_section_name',
				[
					'label' => $elType . ' ' . __('Name', 'pixfort-core'),
					'type' => Controls_Manager::TEXT,
					'placeholder' => __('Enter section name', 'pixfort-core'),
					'default' => '',
					'dynamic'     => array(
						'active'  => true
					),
				]
			);
		}



		$element->add_responsive_control(
			'pix_overlay_color',
			[
				'label' => __('Background Overlay color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'groups' => \PixfortCore::instance()->coreFunctions->getColorsArray(['bg' => true, 'defaultColors' => false, 'lightBasicText' => true, 'defaultValue' => ['' => __('None', 'pixfort-core')], 'advancedValues' => ['custom-gradient' => __('Custom Gradient', 'pixfort-core')] ]),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:not(.elementor-column):before, {{WRAPPER}}.elementor-inner-column:before' => 'border: unset;border-radius: inherit;background: var(--pix-{{VALUE}}) !important; content: \' \';position: absolute;width: 100%;height: 100%;top: 0;left: 0;pointer-events: none;z-index: 0;',
					'{{WRAPPER}} .elementor-background-video-container, {{WRAPPER}} .elementor-background-slideshow' => 'z-index: -1;'
				],
			]
		);

		$element->add_responsive_control(
			'pix_custom_overlay',
			[
				'label' => esc_html__('Custom Gradient', 'pixfort-core'),
				'type' => \Elementor\CustomControl\CustomGradient_Control::CustomGradient,
				'default' => '',
				'class' => '',
				'condition' => [
					'pix_overlay_color' => 'custom-gradient',
				],
				'selectors' => [
					'{{WRAPPER}}:not(.elementor-column):before, {{WRAPPER}}.elementor-inner-column:before' => 'border: unset;border-radius: inherit;background: {{VALUE}} !important; content: \' \';position: absolute;width: 100%;height: 100%;top: 0;left: 0;pointer-events: none;z-index: 0;',
					// '{{WRAPPER}}.elementor-inner-column:before' => 'border: unset;border-radius: inherit;background: {{VALUE}} !important; content: \' \';position: absolute;width: 100%;height: 100%;top: 0;left: 0;pointer-events: none;z-index: 0;',
					'{{WRAPPER}} .elementor-background-video-container, {{WRAPPER}} .elementor-background-slideshow' => 'z-index: -1;'
				],

			]
		);
		$element->add_responsive_control(
			'pix_overlay_opacity',
			[
				'label' => __('Overlay opacity', 'pixfort-core'),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'pix_overlay_color!' => '',
				],
				'selectors' => [
					'{{WRAPPER}}:not(.elementor-column):before' => 'opacity: {{VALUE}} !important;',
					'{{WRAPPER}}.elementor-column .elementor-column-wrap:before' => 'opacity: {{VALUE}} !important;',
				],
				'default' => '',
				'description' => 'The opacity value should be between 0 and 1.',
			]
		);
		$element->add_responsive_control(
			'pix_overlay_over',
			[
				'label' => __('Display overlay over content', 'pixfort-core'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'0' => [
						'title' => __('No', 'pixfort-core'),
						'icon' => 'eicon-close',
					],
					'100' => [
						'title' => __('Yes', 'pixfort-core'),
						'icon' => 'eicon-check',
					]
				],
				'condition' => [
					'pix_overlay_color!' => '',
				],
				'selectors' => [
					'{{WRAPPER}}:not(.elementor-column):before, {{WRAPPER}}.elementor-inner-column:before' => 'z-index: {{VALUE}} !important;transform: translateZ({{VALUE}}px);',
					// '{{WRAPPER}}.elementor-column .elementor-column-wrap:before' => 'z-index: {{VALUE}} !important;',
					// '{{WRAPPER}}.elementor-inner-column:before' => 'z-index: {{VALUE}} !important;',
				],
				'default' => '0',
			]
		);



		if ($isColumn) {

			$element->add_responsive_control(
				'pix_elementor_shadow',
				[
					'label' => __('Shadow Style', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						"" 			=> "Default",
						"none" 				=> "None",
						"shadow-sm"     	=> "Small shadow",
						"shadow"     		=> "Medium shadow",
						"shadow-lg"     	=> "Large shadow",
						"shadow-inverse-sm" => "Inverse Small shadow",
						"shadow-inverse"    => "Inverse Medium shadow",
						"shadow-inverse-lg" => "Inverse Large shadow",
					],
					'selectors_dictionary' => [
						'none' 				=> 'box-shadow: none;',
						'shadow-sm' 		=> 'box-shadow: 0 1px 5px 0 rgba(0,0,0,0.15);',
						'shadow' 			=> 'box-shadow: 0 .125rem .375rem rgba(0,0,0, 0.05), 0 .5rem 1.2rem rgba(0,0,0,0.1);',
						'shadow-lg' 		=> 'box-shadow: 0 .25rem .5rem rgba(0,0,0, .05), 0 1.5rem 2.2rem rgba(0,0,0, .1);',
						"shadow-inverse-sm" => "box-shadow: 0 3px 8px 0 rgba(0,0,0,0.15);",
						"shadow-inverse"    => "box-shadow: 0 .125rem .375rem rgba(0,0,0, .05), 0 .625rem 1.5rem rgba(0,0,0, .15);",
						"shadow-inverse-lg" => "box-shadow: 0 .5rem 1.2rem rgba(0,0,0, .1), 0 2rem 3rem rgba(0,0,0, .15);"
					],
					'selectors' => [
						'{{WRAPPER}} > .elementor-widget-wrap' => '{{VALUE}}'
					],
					'hide_in_top' => $hide_in_top
				]
			);

			$element->add_responsive_control(
				'pix_elementor_shadow_hover',
				[
					'label' => __('Shadow Hover Style', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						"" 							=> "Default",
						"none" 						=> "None",
						"shadow-hover-sm"       	=> "Small hover shadow",
						"shadow-hover"       		=> "Medium hover shadow",
						"shadow-hover-lg"       	=> "Large hover shadow",
						"shadow-inverse-hover-sm"   => "Inverse Small hover shadow",
						"shadow-inverse-hover"      => "Inverse Medium hover shadow",
						"shadow-inverse-hover-lg"   => "Inverse Large hover shadow",
					],
					'selectors_dictionary' => [
						'none' 						=> 'box-shadow: none;',
						'shadow-hover-sm' 			=> 'box-shadow: 0 3px 8px 0 rgba(0,0,0,0.15);',
						'shadow-hover' 				=> 'box-shadow: 0 .125rem .375rem rgba(0,0,0, .05), 0 .625rem 1.5rem rgba(0,0,0, .15);',
						'shadow-hover-lg' 			=> 'box-shadow: 0 .5rem 1.2rem rgba(0,0,0, .1), 0 2rem 3rem rgba(0,0,0, .15);',
						"shadow-inverse-hover-sm" 	=> "box-shadow: 0 1px 5px 0 rgba(0,0,0,0.15);",
						"shadow-inverse-hover"    	=> "box-shadow: 0 .125rem .375rem rgba(0,0,0, 0.05), 0 .5rem 1.2rem rgba(0,0,0,0.1);",
						"shadow-inverse-hover-lg" 	=> "box-shadow: 0 .25rem .5rem rgba(0,0,0, .05), 0 1.5rem 2.2rem rgba(0,0,0, .1);"
					],
					'selectors' => [
						'{{WRAPPER}} > .elementor-widget-wrap' => 'transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);backface-visibility: hidden;',
						'{{WRAPPER}} > .elementor-widget-wrap:hover' => '{{VALUE}}'
					],
				]
			);

			$element->add_responsive_control(
				'pix_elementor_effect_hover',
				[
					'label' => __('Hover Animation', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						"" 					=> "Default",
						"none" 				=> "None",
						"fly-sm"       		=> "Fly Small",
						"fly"    			=> "Fly Medium",
						"fly-lg"       		=> "Fly Large",
						"scale-sm"       	=> "Scale Small",
						"scale"       		=> "Scale Medium",
						"scale-lg"       	=> "Scale Large",
						"scale-inverse-sm"  => "Scale Inverse Small",
						"scale-inverse"     => "Scale Inverse Medium",
						"scale-inverse-lg"  => "Scale Inverse Large",
					],
					'selectors_dictionary' => [
						'none' 				=> 'transform: initial;',
						'fly-sm' 			=> 'transform: translate(0,-3px);',
						'fly' 				=> 'transform: translate(0,-6px);',
						'fly-lg' 			=> 'transform: translate(0,-9px);',
						"scale-sm" 			=> "transform: scale(1.05);",
						"scale"    			=> "transform: scale(1.1);",
						"scale-lg" 			=> "transform: scale(1.15);",
						"scale-inverse-sm" 	=> "transform: scale(0.95);",
						"scale-inverse" 	=> "transform: scale(0.925);",
						"scale-inverse-lg" 	=> "transform: scale(0.9);"
					],
					'selectors' => [
						'{{WRAPPER}} > .elementor-widget-wrap' => 'transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1) !important;',
						'{{WRAPPER}} > .elementor-widget-wrap, {{WRAPPER}} *' => 'backface-visibility: hidden;',
						'{{WRAPPER}} > .elementor-widget-wrap:hover' => '{{VALUE}}'
					],
				]
			);


			$element->add_control(
				'pix_animation',
				[
					'label' => __('Animation', 'pixfort-core'),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => pix_get_animations(true),
					'description' => 'Animation will be applied in the live page (outside Elementor builder)',
				]
			);
			$element->add_control(
				'pix_delay',
				[
					'label' => __('Animation delay (in miliseconds)', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __('0', 'pixfort-core'),
					'placeholder' => __('', 'pixfort-core'),
					'condition' => [
						'pix_animation!' => '',
					],
				]
			);
		} else {

			$element->add_responsive_control(
				'pix_elementor_shadow',
				[
					'label' => __('Shadow Style', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						"" 			=> "Default",
						"none" 				=> "None",
						"shadow-sm"     	=> "Small shadow",
						"shadow"     		=> "Medium shadow",
						"shadow-lg"     	=> "Large shadow",
						"shadow-inverse-sm" => "Inverse Small shadow",
						"shadow-inverse"    => "Inverse Medium shadow",
						"shadow-inverse-lg" => "Inverse Large shadow",
					],
					'selectors_dictionary' => [
						'none' 				=> 'box-shadow: none;',
						'shadow-sm' 		=> 'box-shadow: 0 1px 5px 0 rgba(0,0,0,0.15);',
						'shadow' 			=> 'box-shadow: 0 .125rem .375rem rgba(0,0,0, 0.05), 0 .5rem 1.2rem rgba(0,0,0,0.1);',
						'shadow-lg' 		=> 'box-shadow: 0 .25rem .5rem rgba(0,0,0, .05), 0 1.5rem 2.2rem rgba(0,0,0, .1);',
						"shadow-inverse-sm" => "box-shadow: 0 3px 8px 0 rgba(0,0,0,0.15);",
						"shadow-inverse"    => "box-shadow: 0 .125rem .375rem rgba(0,0,0, .05), 0 .625rem 1.5rem rgba(0,0,0, .15);",
						"shadow-inverse-lg" => "box-shadow: 0 .5rem 1.2rem rgba(0,0,0, .1), 0 2rem 3rem rgba(0,0,0, .15);"
					],
					'selectors' => [
						'{{WRAPPER}}' => '{{VALUE}}'
					],
					'hide_in_top' => $hide_in_top
				]
			);

			$element->add_responsive_control(
				'pix_elementor_shadow_hover',
				[
					'label' => __('Shadow Hover Style', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						"" 							=> "Default",
						"none" 						=> "None",
						"shadow-hover-sm"       	=> "Small hover shadow",
						"shadow-hover"       		=> "Medium hover shadow",
						"shadow-hover-lg"       	=> "Large hover shadow",
						"shadow-inverse-hover-sm"   => "Inverse Small hover shadow",
						"shadow-inverse-hover"      => "Inverse Medium hover shadow",
						"shadow-inverse-hover-lg"   => "Inverse Large hover shadow",
					],
					'selectors_dictionary' => [
						'none' 						=> 'box-shadow: none;',
						'shadow-hover-sm' 			=> 'box-shadow: 0 3px 8px 0 rgba(0,0,0,0.15);',
						'shadow-hover' 				=> 'box-shadow: 0 .125rem .375rem rgba(0,0,0, .05), 0 .625rem 1.5rem rgba(0,0,0, .15);',
						'shadow-hover-lg' 			=> 'box-shadow: 0 .5rem 1.2rem rgba(0,0,0, .1), 0 2rem 3rem rgba(0,0,0, .15);',
						"shadow-inverse-hover-sm" 	=> "box-shadow: 0 1px 5px 0 rgba(0,0,0,0.15);",
						"shadow-inverse-hover"    	=> "box-shadow: 0 .125rem .375rem rgba(0,0,0, 0.05), 0 .5rem 1.2rem rgba(0,0,0,0.1);",
						"shadow-inverse-hover-lg" 	=> "box-shadow: 0 .25rem .5rem rgba(0,0,0, .05), 0 1.5rem 2.2rem rgba(0,0,0, .1);"
					],
					'selectors' => [
						'{{WRAPPER}}' => 'transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);backface-visibility: hidden;',
						'{{WRAPPER}}:hover' => '{{VALUE}}'
					],
					'hide_in_top' => $hide_in_top
				]
			);

			$element->add_responsive_control(
				'pix_elementor_effect_hover',
				[
					'label' => __('Hover Animation', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						"" 					=> "Default",
						"none" 				=> "None",
						"fly-sm"       		=> "Fly Small",
						"fly"    			=> "Fly Medium",
						"fly-lg"       		=> "Fly Large",
						"scale-sm"       	=> "Scale Small",
						"scale"       		=> "Scale Medium",
						"scale-lg"       	=> "Scale Large",
						"scale-inverse-sm"  => "Scale Inverse Small",
						"scale-inverse"     => "Scale Inverse Medium",
						"scale-inverse-lg"  => "Scale Inverse Large",
					],
					'selectors_dictionary' => [
						'none' 				=> 'transform: initial;',
						'fly-sm' 			=> 'transform: translate(0,-3px);',
						'fly' 				=> 'transform: translate(0,-6px);',
						'fly-lg' 			=> 'transform: translate(0,-9px);',
						"scale-sm" 			=> "transform: scale(1.05);",
						"scale"    			=> "transform: scale(1.1);",
						"scale-lg" 			=> "transform: scale(1.15);",
						"scale-inverse-sm" 	=> "transform: scale(0.95);",
						"scale-inverse" 	=> "transform: scale(0.925);",
						"scale-inverse-lg" 	=> "transform: scale(0.9);"
					],
					'selectors' => [
						'{{WRAPPER}}' => 'transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1) !important;',
						'{{WRAPPER}}, {{WRAPPER}} *' => 'backface-visibility: hidden;',
						'{{WRAPPER}}:hover' => '{{VALUE}}transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);'
					],
					'hide_in_top' => $hide_in_top
				]
			);


			$element->add_control(
				'pix_animation',
				[
					'label' => __('Animation', 'pixfort-core'),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => pix_get_animations(true),
					'hide_in_top' => $hide_in_top,
					'description' => 'Animation will be applied in the live page (outside Elementor builder)',
				]
			);
			$element->add_control(
				'pix_delay',
				[
					'label' => __('Animation delay (in miliseconds)', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __('0', 'pixfort-core'),
					'placeholder' => __('', 'pixfort-core'),
					'hide_in_top' => $hide_in_top,
					'condition' => [
						'pix_animation!' => '',
					],
				]
			);

		// $element->add_responsive_control(
		// 	'pix_sticky_top',
		// 	[
		// 		'label' => __('Sticky box on the top', 'pixfort-core'),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'label_on' => __('Yes', 'pixfort-core'),
		// 		'label_off' => __('No', 'pixfort-core'),
		// 		'return_value' => 'true',
		// 		'default' => '',
		// 		'render_type' => 'template',
		// 		// 'devices' => ['desktop', 'tablet', 'mobile'],
		// 		'devices' => ['desktop', 'tablet'],
		// 		'selectors_dictionary' => [
		// 			'true' => 'position: sticky !important;top: 0;z-index: 1020;',
		// 			'' => 'position: static !important;'
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}}' => '{{VALUE}}'
		// 		],
		// 		'hide_in_top' => $hide_in_top,
		// 	]
		// );

			$element->add_control(
				'pix_sticky_top',
				[
					'label' => __('Sticky box on the top', 'pixfort-core'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __('Yes', 'pixfort-core'),
					'label_off' => __('No', 'pixfort-core'),
					'return_value' => 'true',
					'hide_in_top' => $hide_in_top,
				]
			);

			
	
			
			// if(\PixfortCore::instance()->getThemeParam('fade_mask')) {
			if(defined('PIX_DEV') || (defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG !== 'essentials')) {
				$element->add_control(
					'pix_fade_mask',
					[
						'label' => __('Fade mask', 'pixfort-core'),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'separator' => 'before',
					]
				);
				$element->add_responsive_control(
					'pix_fade_mask_sides',
					[
						'label' => __('Mask Sides', 'pixfort-core'),
						'type' => Controls_Manager::SELECT,
						'default' => '0',
						'options' => array(
							"0"       => "Two Sides",
							"1"       => "One Side"
						),
						'condition' => [
							'pix_fade_mask' => 'yes',
						],
						'selectors' => [
							'{{WRAPPER}}' => '--pix-fade-mask-sides: {{VALUE}};',
						],
					]
				);
				$element->add_responsive_control(
					'pix_fade_mask_value',
					[
						'label' => __('Fade value', 'pixfort-core'),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 20,
							'unit' => '%',
						],
						'size_units' => ['px', '%'],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 50,
							],
							'px' => [
								'min' => 0,
								'max' => 400,
								'step' => 1,
							],
						],
						'selectors' => [
							'{{WRAPPER}}' => '-webkit-mask-image: linear-gradient(var(--pix-mask-roation, 90deg),rgba(0,0,0,var(--pix-mask-alpha, 1)) 0,#fff {{SIZE}}{{UNIT}},#fff calc(100% - {{SIZE}}{{UNIT}}),rgba(0,0,0,max(var(--pix-mask-alpha, 1), var(--pix-fade-mask-sides, 0))) 100%);mask-image: linear-gradient(var(--pix-mask-roation, 90deg),rgba(0,0,0,var(--pix-mask-alpha, 1)) 0,#fff {{SIZE}}{{UNIT}},#fff calc(100% - {{SIZE}}{{UNIT}}),rgba(0,0,0,max(var(--pix-mask-alpha, 1), var(--pix-fade-mask-sides, 0))) 100%);',
						],
						'condition' => [
							'pix_fade_mask' => 'yes',
						],
					]
				);
				$element->add_responsive_control(
					'pix_fade_mask_alpha',
					[
						'label' => __('Mask alpha', 'your-text-domain'),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => ['deg'],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 1,
								'step' => 0.05,
							],
						],
						'default' => [
							'unit' => '%',
							'size' => 0,
						],
						'selectors' => [
							'{{WRAPPER}}' => '--pix-mask-alpha: {{SIZE}};',
						],
						'condition' => [
							'pix_fade_mask' => 'yes',
						],
					]
				);
				$element->add_responsive_control(
					'pix_fade_mask_rotation',
					[
						'label' => __('Mask Rotation Degree', 'your-text-domain'),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => ['deg'],
						'range' => [
							'deg' => [
								'min' => 0,
								'max' => 360,
							],
						],
						'default' => [
							'unit' => 'deg',
							'size' => 90,
						],
						'selectors' => [
							'{{WRAPPER}}' => '--pix-mask-roation: {{SIZE}}{{UNIT}};',
						],
						'condition' => [
							'pix_fade_mask' => 'yes',
						],
					]
				);
			}
		}


		$element->end_controls_section();

		$element->start_controls_section(
			'pix_effects_section',
			[
				'label' => __('<img class="pix-elementor-section-logo" src="' . PIX_CORE_PLUGIN_URI . 'functions/images/pixfort-logo.svg" /> Effects', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_LAYOUT
			]
		);
		require_once(PIX_CORE_PLUGIN_DIR . '/functions/elementor/includes/advanced-transforms.php');
		pixGetElementorTransformControls($element, $hide_in_top);
		// if(defined('PIX_DEV')){
		// 	require_once(PIX_CORE_PLUGIN_DIR . '/functions/elementor/includes/background-effects.php');
		// 	if (!$isColumn) {
		// 		pixGetElementorBackgroundEffectsControls($element, $hide_in_top);
		// 	}
		// }

		$element->end_controls_section();




		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'd_gradient',
			[
				'label' => __('Use Gradient', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => '1',
				// 'default' => '',
			]
		);
		$repeater->add_control(
			'd_color_1',
			[
				'label' => __('Layer color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#f8f9fa',
			]
		);
		$repeater->add_control(
			'd_color_2',
			[
				'label' => __('Layer color 2', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#f8f9fa',
				'condition' => [
					'd_gradient' => '1',
				],
			]
		);







		// ===========================================
		// top Dividers
		// ===========================================
		$element->start_controls_section(
			'section_top_dividers',
			[
				'label' => __('<img class="pix-elementor-section-logo" src="' . PIX_CORE_PLUGIN_URI . 'functions/images/pixfort-logo.svg" /> Top Dividers', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_LAYOUT
			]
		);



		$fontiocns_opts = array();
		$fontiocns_opts['0'] = array('title' => 'None', 'url' => PIX_CORE_PLUGIN_URI . 'functions/images/shapes/none.png');
		$fontiocns_opts['dynamic'] = array('title' => 'Dynamic', 'url' => PIX_CORE_PLUGIN_URI . 'functions/images/shapes/divider-dynamic.gif');
		$dividersCount = 26;
		$dividersCount = 26;
		for ($x = 1; $x <= $dividersCount; $x++) {
			$fontiocns_opts[$x] = array('title' => 'Style ' . $x, 'url' => PIX_CORE_PLUGIN_URI . 'functions/images/shapes/divider-' . $x . '.png');
		}

		$element->add_control(
			'top_divider_select',
			[
				'label' => esc_html__('Divider shape', 'pixfort-core'),
				'type' => \Elementor\CustomControl\ImgSelector_Control::ImgSelector,
				'options'	=> $fontiocns_opts,
				'default' => '0',
				'class' => 'pix-top-dividers-select',
			]
		);


		$element->add_control(
			'top_moving_divider_color',
			[
				'label' => __('top Dividers', 'pixfort-core'),
				'type' => Controls_Manager::REPEATER,
				'default'	=> [
					['d_gradient'	=> ''],
					[]
				],
				'fields' => $repeater->get_controls(),
				// 'fields' => [
				//     [
				//         'name' => 'd_gradient',
				//         'label' => __( 'Use Gradient', 'pixfort-core' ),
				//         'type' => \Elementor\Controls_Manager::SWITCHER,
				//         'label_on' => __( 'Yes', 'pixfort-core' ),
				//         'label_off' => __( 'No', 'pixfort-core' ),
				//         'return_value' => '1',
				//         'default' => '',
				//     ],
				//     [
				//         'name' => 'd_color_1',
				//         'label' => __( 'Layer color', 'pixfort-core' ),
				//         'type' => \Elementor\Controls_Manager::COLOR,
				//         'default' => '#f8f9fa',
				//     ],
				//     [
				//         'name' => 'd_color_2',
				//         'label' => __( 'Layer color 2', 'pixfort-core' ),
				//         'type' => \Elementor\Controls_Manager::COLOR,
				//         'default' => '#f8f9fa',
				//         'condition' => [
				//             'd_gradient!' => '',
				//         ],
				//     ]
				//
				//
				//
				// ],
				'condition' => [
					'top_divider_select' => 'dynamic',
				],
			]
		);



		$element->add_control(
			'top_layers',
			[
				'label' => __('The number of Layers', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => array(
					"1"       => "1 Layer",
					"2"       => "2 Layers",
					"3"       => "3 Layers",
				),
				'condition' => [
					'top_divider_select' => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
				],
			]
		);

		$element->add_control(
			't_has_animation',
			[
				'label' => __('Enable animations for layers', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				// 'default' => false,
				'condition' => [
					'top_divider_select' => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
				],
			]
		);


		$element->add_control(
			't_divider_in_front',
			[
				'label' => __('Bring the divider in front of the content', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => false,
				'condition' => [
					'top_divider_select' => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
				],
			]
		);
		$element->add_control(
			't_flip_h',
			[
				'label' => __('Flip the divider', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				// 'default' => false,
				'condition' => [
					'top_divider_select' => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
				],
			]
		);
		$element->add_responsive_control(
			't_custom_height',
			[
				'label' => __('Divider custom height (Optional)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('With unit, e.g: 200px', 'pixfort-core'),
				'selectors_dictionary' => [
					'' => 'auto',
					'0' => 'auto'
				],
				'selectors' => [
					'{{WRAPPER}} .pix-divider.pix-top-divider svg' => 'height: {{VALUE}} !important;',
					'{{WRAPPER}}.pix-divider.pix-top-divider svg' => 'height: {{VALUE}} !important;'
				],
				'condition' => [
					'top_divider_select' => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
				],
			]
		);




		// Top layers tabs
		$element->start_controls_tabs(
			'top_layers_tabs',
			[
				'condition' => [
					'top_divider_select' => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
				],
			]
		);

		$element->start_controls_tab(
			'pix_top_layer_1',
			[
				'label' => esc_html__('Layer 1', 'pixfort-core'),
				'condition' => [
					'top_layers' => array("1", "2", "3")
				],
			]
		);

		$element->add_control(
			't_1_is_gradient',
			[
				'label' => __('Use gradient for the first layer', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				// 'default' => false,
				// 'condition' => [
				// 	'top_layers!' => '',
				// ],
			]
		);
		$element->add_control(
			't_1_color',
			[
				'label' => __('Layer 1 color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				// 'condition' => [
				// 	'icon_color' => 'custom',
				// ],
			]
		);
		$element->add_control(
			't_1_color_2',
			[
				'label' => __('Layer 1 second gradient color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'condition' => [
					't_1_is_gradient' => 'true',
				],
			]
		);
		if(PixfortCore::instance()->getThemeParam('dynamic_colors')) {
			$element->add_control(
				't_1_opacity',
				[
					'label' => esc_html__( 'Opacity', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} > .pix-top-divider .pix-divider-layer-1' => 'opacity: {{SIZE}} !important;'
					],
				]
			);
		}
		$element->add_control(
			't_1_animation',
			[
				'label' => __('Animation', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => pix_get_animations(true),
				'condition' => [
					't_has_animation!' => '',
				],
			]
		);
		$element->add_control(
			't_1_delay',
			[
				'label' => __('Animation delay (in miliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('0', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					't_has_animation!' => '',
					't_1_animation!' => '',
				],
			]
		);

		$element->end_controls_tab();

		$element->start_controls_tab(
			'pix_top_layer_2',
			[
				'label' => esc_html__('Layer 2', 'pixfort-core'),
				'condition' => [
					'top_layers' => array("2", "3")
				],
			]
		);


		$element->add_control(
			't_2_is_gradient',
			[
				'label' => __('Use gradient for the second layer', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				// 'default' => false,
				// 'condition' => [
				// 	'top_layers!' => '',
				// ],
			]
		);
		$element->add_control(
			't_2_color',
			[
				'label' => __('Layer 2 color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.6)',
				// 'condition' => [
				// 	'icon_color' => 'custom',
				// ],
			]
		);
		$element->add_control(
			't_2_color_2',
			[
				'label' => __('Layer 2 second gradient color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'condition' => [
					't_2_is_gradient' => 'true',
				],
			]
		);
		if(PixfortCore::instance()->getThemeParam('dynamic_colors')) {
			$element->add_control(
				't_2_opacity',
				[
					'label' => esc_html__( 'Opacity', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} > .pix-top-divider .pix-divider-layer-2' => 'opacity: {{SIZE}} !important;'
					],
				]
			);
		}
		$element->add_control(
			't_2_animation',
			[
				'label' => __('Animation', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => pix_get_animations(true),
				'condition' => [
					't_has_animation!' => '',
				],
			]
		);
		$element->add_control(
			't_2_delay',
			[
				'label' => __('Animation delay (in miliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('0', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					't_has_animation!' => '',
					't_2_animation!' => '',
				],
			]
		);


		$element->end_controls_tab();


		$element->start_controls_tab(
			'pix_top_layer_3',
			[
				'label' => esc_html__('Layer 3', 'pixfort-core'),
				'condition' => [
					'top_layers' => array("3")
				],
			]
		);


		$element->add_control(
			't_3_is_gradient',
			[
				'label' => __('Use gradient for the third layer', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				// 'default' => false,
			]
		);
		$element->add_control(
			't_3_color',
			[
				'label' => __('Layer 3 color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.3)',
				// 'condition' => [
				// 	'icon_color' => 'custom',
				// ],
			]
		);
		$element->add_control(
			't_3_color_2',
			[
				'label' => __('Layer 3 second gradient color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'condition' => [
					't_3_is_gradient' => 'true',
				],
			]
		);
		if(PixfortCore::instance()->getThemeParam('dynamic_colors')) {
			$element->add_control(
				't_3_opacity',
				[
					'label' => esc_html__( 'Opacity', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} > .pix-top-divider .pix-divider-layer-3' => 'opacity: {{SIZE}} !important;'
					],
				]
			);
		}
		$element->add_control(
			't_3_animation',
			[
				'label' => __('Animation', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => pix_get_animations(true),
				'condition' => [
					't_has_animation!' => '',
				],
			]
		);
		$element->add_control(
			't_3_delay',
			[
				'label' => __('Animation delay (in miliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('0', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					't_has_animation!' => '',
					't_3_animation!' => '',
				],
			]
		);


		$element->end_controls_tab();
		$element->end_controls_tabs();





		$element->end_controls_section();




		$element->start_controls_section(
			'section_bottom_dividers',
			[
				'label' => __('<img class="pix-elementor-section-logo" src="' . PIX_CORE_PLUGIN_URI . 'functions/images/pixfort-logo.svg" /> Bottom Dividers', 'pixfort-core'),
				'tab' => Controls_Manager::TAB_LAYOUT
			]
		);


		// $fontiocns_opts = array();
		// $fontiocns_opts['0'] = array('title' => 'None', 'url' => PIX_CORE_PLUGIN_URI.'functions/images/shapes/none.png' );
		// $fontiocns_opts['dynamic'] = array('title' => 'Dynamic', 'url' => PIX_CORE_PLUGIN_URI.'functions/images/shapes/divider-dynamic.gif' );
		// for ($x = 1; $x <= 26; $x++) {
		// 	$fontiocns_opts[$x] = array('title' => 'Style '.$x, 'url' => PIX_CORE_PLUGIN_URI.'functions/images/shapes/divider-'.$x.'.png' );
		// }

		$element->add_control(
			'bottom_divider_select',
			[
				'label' => esc_html__('Divider shape', 'pixfort-core'),
				'type' => \Elementor\CustomControl\ImgSelector_Control::ImgSelector,
				'options'	=> $fontiocns_opts,
				'default' => '0',
				'class' => 'firas',

			]
		);



		$element->add_control(
			'bottom_moving_divider_color',
			[
				'label' => __('Bottom Dividers', 'pixfort-core'),
				'type' => Controls_Manager::REPEATER,
				'default'	=> [
					['d_gradient'	=> ''],
					[]
				],
				'fields' => $repeater->get_controls(),
				'condition' => [
					'bottom_divider_select' => 'dynamic',
				],
			]
		);



		$element->add_control(
			'bottom_layers',
			[
				'label' => __('The number of Layers', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => array(
					"1"       => "1 Layer",
					"2"       => "2 Layers",
					"3"       => "3 Layers",
				),
				'condition' => [
					'bottom_divider_select' => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
				],
			]
		);

		$element->add_control(
			'b_has_animation',
			[
				'label' => __('Enable animations for layers', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'yes',
				// 'default' => false,
				'condition' => [
					'bottom_divider_select' => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
				],
			]
		);


		$element->add_control(
			'b_divider_in_front',
			[
				'label' => __('Bring the divider in front of the content', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => false,
				'condition' => [
					'bottom_divider_select' => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
				],
			]
		);
		$element->add_control(
			'b_flip_h',
			[
				'label' => __('Flip the divider', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				'default' => false,
				'condition' => [
					'bottom_divider_select' => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
				],
			]
		);

		$element->add_responsive_control(
			'b_custom_height',
			[
				'label' => __('Divider custom height (Optional)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'pixfort-core'),
				'placeholder' => __('With unit, e.g: 200px', 'pixfort-core'),
				'selectors_dictionary' => [
					'' => 'auto',
					'0' => 'auto'
				],
				'selectors' => [
					'{{WRAPPER}} .pix-divider.pix-bottom-divider svg' => 'height: {{VALUE}} !important;max-height: {{VALUE}} !important;',
					'{{WRAPPER}}.pix-divider.pix-bottom-divider svg' => 'height: {{VALUE}} !important;max-height: {{VALUE}} !important;'
				],
				'condition' => [
					'bottom_divider_select' => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
				],
			]
		);




		// Bottom layers tabs
		$element->start_controls_tabs(
			'bottom_layers_tabs',
			[
				'condition' => [
					'bottom_divider_select' => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26")
				],
			]
		);

		$element->start_controls_tab(
			'pix_bottom_layer_1',
			[
				'label' => esc_html__('Layer 1', 'pixfort-core'),
				'condition' => [
					'bottom_layers' => array("1", "2", "3")
				],
			]
		);


		$element->add_control(
			'b_1_is_gradient',
			[
				'label' => __('Use gradient for the first layer', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				// 'default' => false,
				// 'condition' => [
				// 	'bottom_layers!' => '',
				// ],
			]
		);
		$element->add_control(
			'b_1_color',
			[
				'label' => __('Layer 1 color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				// 'condition' => [
				// 	'icon_color' => 'custom',
				// ],
			]
		);
		$element->add_control(
			'b_1_color_2',
			[
				'label' => __('Layer 1 second gradient color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'condition' => [
					'b_1_is_gradient' => 'true',
				],
			]
		);
		if(PixfortCore::instance()->getThemeParam('dynamic_colors')) {
			$element->add_control(
				'b_1_opacity',
				[
					'label' => esc_html__( 'Opacity', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1,
							'step' => 0.01,
						],
					],
					// 'default' => [
					// 	'size' => 1,
					// ],
					'selectors' => [
						'{{WRAPPER}} > .pix-bottom-divider .pix-divider-layer-1' => 'opacity: {{SIZE}} !important;'
					],
				]
			);
		}
		$element->add_control(
			'b_1_animation',
			[
				'label' => __('Animation', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => pix_get_animations(true),
				'condition' => [
					'b_has_animation!' => '',
				],
			]
		);
		$element->add_control(
			'b_1_delay',
			[
				'label' => __('Animation delay (in miliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('0', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					'b_has_animation!' => '',
					'b_1_animation!' => '',
				],
			]
		);


		$element->end_controls_tab();

		$element->start_controls_tab(
			'pix_bottom_layer_2',
			[
				'label' => esc_html__('Layer 2', 'pixfort-core'),
				'condition' => [
					'bottom_layers' => array("2", "3")
				],
			]
		);


		$element->add_control(
			'b_2_is_gradient',
			[
				'label' => __('Use gradient for the second layer', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				// 'default' => false,
				// 'condition' => [
				// 	'bottom_layers!' => '',
				// ],
			]
		);
		$element->add_control(
			'b_2_color',
			[
				'label' => __('Layer 2 color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.6)',
				// 'selectors' => [
				// 	'{{WRAPPER}} > .pix-bottom-divider .pix-divider-layer-2' => 'fill: {{VALUE}} !important;',
				// ],
				// 'condition' => [
				// 	'icon_color' => 'custom',
				// ],
			]
		);
		$element->add_control(
			'b_2_color_2',
			[
				'label' => __('Layer 2 second gradient color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'condition' => [
					'b_2_is_gradient' => 'true',
				],
			]
		);
		if(PixfortCore::instance()->getThemeParam('dynamic_colors')) {
			$element->add_control(
				'b_2_opacity',
				[
					'label' => esc_html__( 'Opacity', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1,
							'step' => 0.01,
						],
					],
					// 'default' => [
					// 	'size' => 1,
					// ],
					'selectors' => [
						'{{WRAPPER}} > .pix-bottom-divider .pix-divider-layer-2' => 'opacity: {{SIZE}} !important;'
					],
				]
			);
		}
		$element->add_control(
			'b_2_animation',
			[
				'label' => __('Animation', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => pix_get_animations(true),
				'condition' => [
					'b_has_animation!' => '',
				],
			]
		);
		$element->add_control(
			'b_2_delay',
			[
				'label' => __('Animation delay (in miliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('0', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					'b_has_animation!' => '',
					'b_2_animation!' => '',
				],
			]
		);


		$element->end_controls_tab();


		$element->start_controls_tab(
			'pix_bottom_layer_3',
			[
				'label' => esc_html__('Layer 3', 'pixfort-core'),
				'condition' => [
					'bottom_layers' => array("3")
				],
			]
		);

		$element->add_control(
			'b_3_is_gradient',
			[
				'label' => __('Use gradient for the third layer', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'true',
				// 'default' => false,
			]
		);
		$element->add_control(
			'b_3_color',
			[
				'label' => __('Layer 3 color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.3)',
				// 'condition' => [
				// 	'icon_color' => 'custom',
				// ],
			]
		);
		$element->add_control(
			'b_3_color_2',
			[
				'label' => __('Layer 3 second gradient color', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'condition' => [
					'b_3_is_gradient' => 'true',
				],
			]
		);
		if(PixfortCore::instance()->getThemeParam('dynamic_colors')) {
			$element->add_control(
				'b_3_opacity',
				[
					'label' => esc_html__( 'Opacity', 'textdomain' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1,
							'step' => 0.01,
						],
					],
					// 'default' => [
					// 	'size' => 1,
					// ],
					'selectors' => [
						'{{WRAPPER}} > .pix-bottom-divider .pix-divider-layer-3' => 'opacity: {{SIZE}} !important;'
					],
				]
			);
		}
		$element->add_control(
			'b_3_animation',
			[
				'label' => __('Animation', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => pix_get_animations(true),
				'condition' => [
					'b_has_animation!' => '',
				],
			]
		);
		$element->add_control(
			'b_3_delay',
			[
				'label' => __('Animation delay (in miliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('0', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					'b_has_animation!' => '',
					'b_3_animation!' => '',
				],
			]
		);

		$element->end_controls_tab();
		$element->end_controls_tabs();
		$element->end_controls_section();
	}

	public function before_render($element) {
		$settings = $element->get_settings();
		if (!empty($settings['pix_elementor_effect_hover']) && $settings['pix_elementor_effect_hover'] !== 'none') {
			$element->add_render_attribute('_wrapper', ['class' => 'pix-base-transition']);
		}
		if (!empty($settings['pix_section_name'])) {
			$element->add_render_attribute('_wrapper', ['data-section-name' => $settings['pix_section_name']]);
		}
		// if (!empty($settings['bottom_divider_select']) || !empty($settings['top_divider_select'])) {
		// 	// echo \PixfortCore::instance()->elementsManager->renderElement('Dividers', $settings );
		// 	$out = \PixfortCore::instance()->elementsManager->renderElement('Dividers', $settings );
		// 	$element->add_render_attribute('_wrapper', ['data-pix-dividers' => $out]);
		// }
		if (!empty($settings['pix_sticky_top']) && $settings['pix_sticky_top']) {
			$element->add_render_attribute('_wrapper', ['class' => 'sticky-top pix-sticky-top-adjust']);
			// $element->add_render_attribute('_wrapper', ['class' => 'pix-sticky-top-adjust']);
		}
		if (!empty($settings['pix_scale_in']) && $settings['pix_scale_in'] !== 'none') {
			$element->add_render_attribute('_wrapper', ['class' => $settings['pix_scale_in']]);
			// Add advanced transform data attributes
			$transform_data = \PixfortCore::instance()->styleFunctions->getTransformData($settings);
			if($transform_data) {
				$element->add_render_attribute('_wrapper', ['data-pix-transform' => json_encode($transform_data)]);
			}

		}
		if (!empty($settings['pix_animation'])) {
			$element->add_render_attribute('_wrapper', ['class' => 'animate-in']);
			$element->add_render_attribute('_wrapper', ['data-anim-type' => $settings['pix_animation']]);
			if (!empty($settings['pix_delay'])) {
				$element->add_render_attribute('_wrapper', ['data-anim-delay' => $settings['pix_delay']]);
			} else {
				$element->add_render_attribute('_wrapper', ['data-anim-delay' => '0']);
			}
		}
		// if(defined('PIX_DEV')){
		// 	require_once(PIX_CORE_PLUGIN_DIR . '/functions/elementor/includes/background-effects.php');
		// 	pixApplyElementorBackgroundEffectAttributes($element, $settings);
		// }
	}

	public function render_dividers($element) {
		$settings = $element->get_settings();
		if (!empty($settings['bottom_divider_select']) || !empty($settings['top_divider_select'])) {
			// echo \PixfortCore::instance()->elementsManager->renderElement('Dividers', $settings );
			$element->add_render_attribute('_wrapper', [
				'data-pix-dividers' => \PixfortCore::instance()->elementsManager->renderElement('Dividers', $settings)
			]);
			wp_enqueue_script('pix-global-dividers-handle');
		}
	}
	public function before_render_divider($element) {
		$settings = $element->get_settings();
		if (!empty($settings['bottom_divider_select']) || !empty($settings['top_divider_select'])) {
			$extra = $this->pix_get_responsive_classes($settings);
			$extra .= 'elementor-element elementor-element-' . $element->get_id();
			if (!empty($settings['stretch_section'])) {
				$extra .= ' pix-stretch-divider';
			}
			$settings['extra_classes'] = $extra;
			$element->add_render_attribute('_wrapper', ['class' => 'pix-elementor-divider']);
			if ($settings['top_divider_select'] === 'dynamic' || $settings['bottom_divider_select'] === 'dynamic') {
				$element->add_render_attribute('_wrapper', [
					'data-pix-dividers' => \PixfortCore::instance()->elementsManager->renderElement('Dividers', $settings)
				]);
				wp_enqueue_script('pix-global-dividers-handle');
			} else {
				$settings['bottom_divider_select'] = false;
				echo \PixfortCore::instance()->elementsManager->renderElement('Dividers', $settings);
			}
		}
	}
	public function after_render_divider($element) {
		$settings = $element->get_settings();
		if (!empty($settings['bottom_divider_select'])) {
			$extra = $this->pix_get_responsive_classes($settings);
			$extra .= 'elementor-element elementor-element-' . $element->get_id();
			if (!empty($settings['stretch_section'])) {
				$extra .= ' pix-stretch-divider';
			}
			$settings['extra_classes'] = $extra;
			$settings['top_divider_select'] = false;
			if ($settings['bottom_divider_select'] !== 'dynamic') {
				echo \PixfortCore::instance()->elementsManager->renderElement('Dividers', $settings);
			} else {
				$element->add_render_attribute('_wrapper', [
					'data-pix-dividers' => \PixfortCore::instance()->elementsManager->renderElement('Dividers', $settings)
				]);
				wp_enqueue_script('pix-global-dividers-handle');
			}
		}
	}

	public function pix_get_responsive_classes($settings) {
		$out = '';
		if (!empty($settings['hide_desktop'])) $out .= ' elementor-hidden-desktop';
		if (!empty($settings['hide_tablet'])) $out .= ' elementor-hidden-tablet';
		if (!empty($settings['hide_mobile'])) $out .= ' elementor-hidden-mobile';
		return $out;
	}
}
