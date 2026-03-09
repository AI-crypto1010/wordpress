<?php

namespace ImageOptimization\Classes\Image\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Invalid_Image_Exception extends Exception {
	protected $message = 'Invalid image';
}
