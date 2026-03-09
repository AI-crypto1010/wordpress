<?php

namespace ImageOptimization\Modules\Optimization\Classes\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Image_Validation_Error extends Exception {
	protected $message = 'Image validation error';
}
