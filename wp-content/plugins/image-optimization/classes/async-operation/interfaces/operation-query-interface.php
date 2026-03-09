<?php

namespace ImageOptimization\Classes\Async_Operation\Interfaces;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

interface Operation_Query_Interface {
	public function get_query(): array;
	public function get_return_type(): string;
}
