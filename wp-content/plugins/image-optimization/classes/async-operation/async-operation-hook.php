<?php

namespace ImageOptimization\Classes\Async_Operation;

use ImageOptimization\Classes\Basic_Enum;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Async_Operation_Hook extends Basic_Enum {
	public const OPTIMIZE_SINGLE = 'image-optimization/optimize/single';
	public const OPTIMIZE_ON_UPLOAD = 'image-optimization/optimize/upload';
	public const OPTIMIZE_BULK = 'image-optimization/optimize/bulk';
	public const REOPTIMIZE_SINGLE = 'image-optimization/reoptimize/single';
	public const REOPTIMIZE_BULK = 'image-optimization/reoptimize/bulk';
	public const REMOVE_MANY_BACKUPS = 'image-optimization/backup/remove-many';
	public const RESTORE_SINGLE_IMAGE = 'image-optimization/restore/single';
	public const RESTORE_MANY_IMAGES = 'image-optimization/restore/restore-many';
	public const CALCULATE_OPTIMIZATION_STATS = 'image-optimization/optimization-stats/calculate';
	public const DB_MIGRATION = 'image-optimization/database/migration';
	public const STUCK_OPERATION_CLEANUP = 'image-optimization/cleanup/stuck-operation';
}
