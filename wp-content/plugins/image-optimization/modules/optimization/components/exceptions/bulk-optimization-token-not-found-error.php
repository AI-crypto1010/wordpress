<?php

namespace ImageOptimization\Modules\Optimization\Components\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Bulk_Optimization_Token_Not_Found_Error extends Exception {
	protected $message = 'Bulk optimization token not found';
}
