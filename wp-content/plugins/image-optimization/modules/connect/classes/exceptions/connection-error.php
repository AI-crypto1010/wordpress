<?php

namespace ImageOptimization\Modules\Connect\Classes\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Connection_Error extends Exception {
	protected $message = 'Connection error';
}
