<?php

namespace ImageOptimization\Modules\Optimization\Classes\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Image_Optimization_Error extends Exception {
	protected $message = 'Image optimization error';
}
