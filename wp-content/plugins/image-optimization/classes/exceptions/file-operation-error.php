<?php

namespace ImageOptimization\Classes\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class File_Operation_Error extends Exception {
	protected $message = 'File operation error';
}
