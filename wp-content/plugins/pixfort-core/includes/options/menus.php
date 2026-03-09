<?php

class PixfortMenusOptions {

	public $options = array();
	public $type = 'meta';
	public $post = false;
	public $hasTabs = false;
	public $display = true;
	public $config = array();

	function __construct() {
		add_action('admin_enqueue_scripts',  [$this, 'pixfort_enqueue_menus_scripts']);
	}

	function pixfort_enqueue_menus_scripts($hook) {
		// Check if we are on the Menus page
		if ($hook !== 'nav-menus.php') {
			return;
		}


		$pixfortBuilder = new PixfortOptions();
		$pixfortBuilder->initOptions(
			'menus'
		);
		
		$pixfortBuilder->loadOptionsData();
		echo '<div id="fu3obnz"></div>';
		echo '</tbody>';
		echo '</table>';
		echo '</div>';
	}
}
