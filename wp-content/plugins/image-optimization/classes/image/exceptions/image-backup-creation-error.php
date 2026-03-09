<?php

namespace ImageOptimization\Classes\Image\Exceptions;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Image_Backup_Creation_Error extends Exception {
	protected $message = 'Backup creation error';
}
