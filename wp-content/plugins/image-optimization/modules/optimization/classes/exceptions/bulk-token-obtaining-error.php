<?php

namespace ImageOptimization\Modules\Optimization\Classes\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Bulk_Token_Obtaining_Error extends Exception {
	protected $message = 'Bulk token obtaining error';
}
