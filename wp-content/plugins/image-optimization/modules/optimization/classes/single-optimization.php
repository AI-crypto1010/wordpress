<?php

namespace ImageOptimization\Modules\Optimization\Classes;

use ImageOptimization\Classes\Async_Operation\{
	Async_Operation,
	Async_Operation_Hook,
	Async_Operation_Queue,
	Exceptions\Async_Operation_Exception,
	Queries\Image_Optimization_Operation_Query
};
use ImageOptimization\Classes\Image\{
	Image_Meta,
	Image_Status,
};
use ImageOptimization\Modules\Optimization\Classes\Exceptions\Image_Optimization_Already_In_Progress_Error;
use Throwable;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Single_Optimization {
	/**
	 * @throws Throwable|Async_Operation_Exception
	 */
	public static function optimize_many( array $image_ids, bool $is_reoptimize = false ): void {
		foreach ( $image_ids as $image_id ) {
			try {
				self::schedule_single_optimization( $image_id, $is_reoptimize );
			} catch ( Image_Optimization_Already_In_Progress_Error $ioe ) {
				continue;
			} catch ( Throwable $t ) {
				throw $t;
			}
		}
	}

	/**
	 * @throws Throwable|Async_Operation_Exception|Image_Optimization_Already_In_Progress_Error
	 */
	public static function schedule_single_optimization( int $image_id, bool $is_reoptimize = false ): void {
		if ( self::is_optimization_in_progress( $image_id ) ) {
			throw new Image_Optimization_Already_In_Progress_Error(
				esc_html__( 'Optimization is already in progress', 'image-optimization' )
			);
		}

		$meta = new Image_Meta( $image_id );

		try {
			$meta
				->set_status(
					$is_reoptimize
						? Image_Status::REOPTIMIZING_IN_PROGRESS
						: Image_Status::OPTIMIZATION_IN_PROGRESS
				)
				->save();

			Async_Operation::create(
				$is_reoptimize ? Async_Operation_Hook::REOPTIMIZE_SINGLE : Async_Operation_Hook::OPTIMIZE_SINGLE,
				[ 'attachment_id' => $image_id ],
				Async_Operation_Queue::OPTIMIZE
			);
		} catch ( Throwable $t ) {
			$meta
				->set_status( $is_reoptimize ? Image_Status::REOPTIMIZING_FAILED : Image_Status::OPTIMIZATION_FAILED )
				->save();

			throw $t;
		}
	}

	/**
	 * @throws Async_Operation_Exception
	 */
	private static function is_optimization_in_progress( int $image_id ): bool {
		$query = ( new Image_Optimization_Operation_Query() )
			->set_status( [ Async_Operation::OPERATION_STATUS_PENDING, Async_Operation::OPERATION_STATUS_RUNNING ] )
			->set_image_id( $image_id )
			->return_ids();

		$operations = Async_Operation::get( $query );

		return count( $operations ) > 0;
	}
}
