<?php

namespace ImageOptimization\Classes\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Client_Exception extends Exception {
	protected $message = 'Unknown client error';
}
