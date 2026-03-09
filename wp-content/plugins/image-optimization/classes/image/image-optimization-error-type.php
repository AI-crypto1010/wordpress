<?php

namespace ImageOptimization\Classes\Image;

use ImageOptimization\Classes\Basic_Enum;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Image_Optimization_Error_Type extends Basic_Enum {
	public const QUOTA_EXCEEDED = 'quota-exceeded';
	public const FILE_ALREADY_EXISTS = 'file-already-exists';
	public const PLUGIN_DEACTIVATION = 'plugin-deactivation';
	public const AUTH_ERROR = 'auth-error';
	public const CONNECTION_ERROR = 'connection-error';
	public const GENERIC = 'generic';
}
