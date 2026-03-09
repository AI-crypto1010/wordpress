<?php

namespace ImageOptimization\Classes\Image\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Image_Restoring_Exception extends Exception {
	protected $message = 'Image cannot be restored';
}
