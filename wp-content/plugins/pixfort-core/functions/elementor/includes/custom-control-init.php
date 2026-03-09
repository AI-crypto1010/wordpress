<?php
namespace ElementorControls;
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Elementor_Custom_Controls {

	public function includes() {
		require_once('img-selector-control.php');
		require_once('icon-selector-control.php');
		require_once('fonticon-selector-control.php');
	}

	public function register_controls() {
		$this->includes();
		$controls_manager = \Elementor\Plugin::$instance->controls_manager;
		$controls_manager->register_control(\Elementor\CustomControl\ImgSelector_Control::ImgSelector, new \Elementor\CustomControl\ImgSelector_Control());
		$controls_manager->register_control(\Elementor\CustomControl\IconSelector_Control::IconSelector, new \Elementor\CustomControl\IconSelector_Control());
		$controls_manager->register_control(\Elementor\CustomControl\FonticonSelector_Control::FonticonSelector, new \Elementor\CustomControl\FonticonSelector_Control());
	}

	public function __construct() {
		add_action('elementor/controls/controls_registered', [$this, 'register_controls']);
	}

}
new Elementor_Custom_Controls();
