<?php

namespace ImageOptimization\Modules\Optimization\Classes\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Bulk_Token_Expired_Error extends Exception {
	protected $message = 'Bulk token expired error';
}
