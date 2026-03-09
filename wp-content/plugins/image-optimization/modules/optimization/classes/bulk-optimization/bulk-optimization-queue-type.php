<?php

namespace ImageOptimization\Modules\Optimization\Classes\Bulk_Optimization;

use ImageOptimization\Classes\Basic_Enum;

// @codeCoverageIgnoreStart
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
// @codeCoverageIgnoreEnd

final class Bulk_Optimization_Queue_Type extends Basic_Enum {
	public const OPTIMIZATION = 'optimization';
	public const REOPTIMIZATION = 'reoptimization';
}
