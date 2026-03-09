<?php

namespace ImageOptimization\Modules\Optimization\Classes\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The service responses with the error when the optimized image size >= than the original size.
 */
class Image_Already_Optimized_Error extends Exception {
	protected $message = 'Image already optimized';
}
