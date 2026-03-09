<?php

namespace ImageOptimization\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Locale {
	private $original_locale;

	public function set_utf_locale( int $category = LC_CTYPE ) {
		setlocale( $category, 'en_US.UTF-8' );
	}

	public function get_locale( int $category = LC_CTYPE ) {
		return setlocale( $category, 0 );
	}

	public function reset_to_original( int $category = LC_CTYPE ) {
		return setlocale( $category, $this->original_locale );
	}

	public function __construct() {
		$this->original_locale = $this->get_locale();
	}
}
