<?php

namespace ImageOptimization\Modules\Oauth\Components\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Auth_Error extends Exception {
	protected $message = 'Auth error';
}
