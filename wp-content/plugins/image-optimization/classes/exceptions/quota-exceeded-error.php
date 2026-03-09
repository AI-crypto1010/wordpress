<?php

namespace ImageOptimization\Classes\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Quota_Exceeded_Error extends Exception {
	protected $message = 'Quota exceeded';
}
