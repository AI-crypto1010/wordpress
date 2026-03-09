<?php

namespace ImageOptimization\Classes\File_System\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class File_System_Operation_Error extends Exception {
	protected $message = 'File system operation error';
}
