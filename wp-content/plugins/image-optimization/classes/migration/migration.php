<?php

namespace ImageOptimization\Classes\Migration;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

abstract class Migration {
	abstract public static function run(): bool;
	abstract public static function get_name(): string;
}
