<?php

namespace ImageOptimization\Classes\Async_Operation\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Async_Operation_Exception extends Exception {
	protected $message = 'Async operation library is not loaded';
}
