<?php

namespace ImageOptimization\Modules\Optimization\Classes\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Image_Optimization_Already_In_Progress_Error extends Exception {
	protected $message = 'Image optimization already in progress error';
}
