<?php

namespace Elementor;

class Pix_Eor_Auto_Video extends Widget_Base {

	public function __construct($data = [], $args = null) {
		// Link migration code
		$is_external = false;
		if (!empty($data['settings'])) {
			if (!empty($data['settings']['target']) && $data['settings']['target']) {
				$is_external = true;
			}
			if (!empty($data['settings']['link']) && !is_array($data['settings']['link'])) {
				$data['settings']['link'] = [
					'url' => $data['settings']['link'],
					'is_external' => $is_external,
					'nofollow' => false,
				];
			}
			// MP4 Video migration code - migrate from TEXT to MEDIA control
			if (!empty($data['settings']['mp4_video']) && !is_array($data['settings']['mp4_video'])) {
				$data['settings']['mp4_video'] = [
					'url' => $data['settings']['mp4_video'],
					'id' => '',
				];
			}
		}
		parent::__construct($data, $args);

		wp_register_script('pix-auto-video-handle', PIX_CORE_PLUGIN_URI . 'functions/elementor/js/auto-video.js', ['elementor-frontend'], PIXFORT_PLUGIN_VERSION, true);
	}

	public function get_name() {
		return 'pix-auto-video';
	}

	public function get_title() {
		return 'Auto video';
	}

	public function get_icon() {
		return 'eicon-video-camera pixfort-elementor-element pixfort-elementor-auto-video';
	}

	public function get_categories() {
		return ['pixfort'];
	}

	public function get_help_url() {
		return \PixfortCore::instance()->adminCore->getParam('docs_link');
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_title',
			[
				'label' => __('Content', 'pixfort-core'),
			]
		);

		$this->add_control(
			'mp4_video',
			[
				'label' => __('MP4 Video', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_types' => ['video'],
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => __('Loop', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'loop',
			]
		);
		$this->add_control(
			'rounded_img',
			[
				'label' => __('Rounded corners', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded-0',
				'options' => [
					'rounded-0' => __('No', 'pixfort-core'),
					'rounded' => __('Rounded', 'pixfort-core'),
					'rounded-lg' => __('Rounded Large', 'pixfort-core'),
					'rounded-xl' => __('Rounded 5px', 'pixfort-core'),
					'rounded-10' => __('Rounded 10px', 'pixfort-core'),
					'rounded-inherit' => __('Inherit Border Radius', 'pixfort-core'),
				],
			]
		);
		$this->add_control(
			'poster',
			[
				'label' => __('Poster image', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic'     => array(
					'active'  => true
				),
			]
		);

		$this->add_control(
			'width',
			[
				'label' => __('Width (Optional)', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('input the value (with the unit: %, px,.. etc).', 'pixfort-core'),
			]
		);
		$this->add_control(
			'height',
			[
				'label' => __('Height (Optional)', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('input the value (with the unit: %, px,.. etc).', 'pixfort-core'),
			]
		);
		$this->add_control(
			'link',
			[
				'label' => __('Link', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::URL,
				'placeholder' => __('', 'pixfort-core'),
				'dynamic'     => array(
					'active'  => true
				),
			]
		);
		$this->add_control(
			'pix_scroll_parallax',
			[
				'label' => __('Scroll Parallax', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'scroll_parallax',
			]
		);
		$this->add_control(
			'xaxis',
			[
				'label' => __('Vertical Parallax', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'description' => __('Input the Parallax value (without unit), for example: 120', 'pixfort-core'),
				'default'	=> '0'
			]
		);
		$this->add_control(
			'yaxis',
			[
				'label' => __('Horizontal Parallax', 'pixfort-core'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('', 'pixfort-core'),
				'description' => __('Input the Parallax value (without unit), for example: 120', 'pixfort-core'),
				'default'	=> '0'
			]
		);
		$this->add_control(
			'pix_tilt',
			[
				'label' => __('3D Hover', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'pixfort-core'),
				'label_off' => __('No', 'pixfort-core'),
				'return_value' => 'tilt',
			]
		);
		$this->add_control(
			'pix_tilt_size',
			[
				'label' => __('3d hover size', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'tilt',
				'options' => [
					'tilt'			=> 'Default',
					'tilt_big'		=> 'Big',
					'tilt_small' 		=> 'Small',
				],
			]
		);
		$this->add_control(
			'img_div',
			[
				'label' => __('Video inside a container', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' 		=> 'Disabled',
					'text-center' 		=> 'Center align',
					'text-left' 		=> 'Left align',
					'text-right' 		=> 'Right align',
				],
			]
		);

		// $this->add_control(
		// 	'pix_scale_in',
		// 	[
		// 		'label' => __('Video Scale In effect', 'pixfort-core'),
		// 		'type' => Controls_Manager::SELECT,
		// 		'default' => '',
		// 		'options' => [
		// 			'' 		=> 'Disabled',
		// 			'pix-scale-in-sm' 		=> 'Small scale',
		// 			'pix-scale-in' 		=> 'Normal scale',
		// 			'pix-scale-in-lg' 		=> 'Large scale',
		// 		],
		// 	]
		// );

		require_once(PIX_CORE_PLUGIN_DIR . '/functions/elementor/includes/advanced-transforms.php');
		pixGetElementorTransformControls($this, false);

		$this->add_control(
			'animation',
			[
				'label' => __('Animation', 'pixfort-core'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => pix_get_animations(true),
			]
		);
		$this->add_control(
			'delay',
			[
				'label' => __('Animation delay (in miliseconds)', 'pixfort-core'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('0', 'pixfort-core'),
				'placeholder' => __('', 'pixfort-core'),
				'condition' => [
					'animation!' => '',
				],
			]
		);

		$this->end_controls_section();

		pix_get_elementor_effects($this);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if (!empty($settings['link']) && is_array($settings['link'])) {
			if (!empty($settings['link']['is_external'])) {
				$settings['target'] = $settings['link']['is_external'];
			}
			if (!empty($settings['link']['nofollow'])) {
				$settings['nofollow'] = $settings['link']['nofollow'];
			}
			if (!empty($settings['link']['custom_attributes'])) {
				$settings['link_atts'] = $settings['link']['custom_attributes'];
			}
			$settings['link'] = $settings['link']['url'];
		}
		// Extract URL from MEDIA control
		if (!empty($settings['mp4_video']) && is_array($settings['mp4_video'])) {
			// If media ID exists, get the attachment URL from WordPress
			if (!empty($settings['mp4_video']['id'])) {
				$video_url = wp_get_attachment_url($settings['mp4_video']['id']);
				// If video URL not found, fall back to the URL string value
				$settings['mp4_video'] = $video_url ? $video_url : (!empty($settings['mp4_video']['url']) ? $settings['mp4_video']['url'] : '');
			} else {
				// Otherwise use the URL string value (for external URLs or migrated values)
				$settings['mp4_video'] = !empty($settings['mp4_video']['url']) ? $settings['mp4_video']['url'] : '';
			}
		}
		echo \PixfortCore::instance()->elementsManager->renderElement('AutoVideo', $settings);
	}

	public function get_script_depends() {
		if (is_user_logged_in()) return ['pix-global', 'pix-auto-video-handle'];
		return [];
	}
}
