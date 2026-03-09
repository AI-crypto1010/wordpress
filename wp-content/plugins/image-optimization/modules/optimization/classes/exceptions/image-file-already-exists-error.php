<?php

namespace ImageOptimization\Modules\Optimization\Classes\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Image_File_Already_Exists_Error extends Exception {
	protected $message = 'Image file with this name already exists';
}
