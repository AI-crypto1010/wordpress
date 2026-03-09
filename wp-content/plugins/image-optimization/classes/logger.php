<?php

namespace ImageOptimization\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Logger {
	public const LEVEL_ERROR = 'error';
	public const LEVEL_WARN = 'warn';
	public const LEVEL_INFO = 'info';
	public const LEVEL_DEBUG = 'debug';

	public const LOG_LEVEL_PRIORITY = [
		'debug' => 1,
		'info' => 2,
		'warn' => 3,
		'error' => 4,
	];

	/**
	 * @param string $log_level
	 * @param $message
	 *
	 * @deprecated Use Logger::{error|warn|info|debug} instead.
	 * @return void
	 */
	public static function log( string $log_level, $message ): void {
		if (
			defined( 'IMAGE_OPTIMIZATION_MINIMUM_LOG_LEVEL' ) &&
			self::LOG_LEVEL_PRIORITY[ $log_level ] < (int) IMAGE_OPTIMIZATION_MINIMUM_LOG_LEVEL
		) {
			return;
		}

		$backtrace = debug_backtrace(); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_debug_backtrace

		$class = $backtrace[2]['class'] ?? null;
		$type = $backtrace[2]['type'] ?? null;
		$function = $backtrace[2]['function'];

		if ( $class ) {
			$message = '[Image Optimizer]: ' . $log_level . ' in ' . "$class$type$function()" . ': ' . $message;
		} else {
			$message = '[Image Optimizer]: ' . $log_level . ' in ' . "$function()" . ': ' . $message;
		}

		error_log( $message ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
	}

	public static function debug( $message ): void {
		self::log( self::LEVEL_DEBUG, $message );
	}

	public static function info( $message ): void {
		self::log( self::LEVEL_INFO, $message );
	}

	public static function warn( $message ): void {
		self::log( self::LEVEL_WARN, $message );
	}

	public static function error( $message ): void {
		self::log( self::LEVEL_ERROR, $message );
	}
}
