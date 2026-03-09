<?php

namespace ImageOptimization\Modules\Backups\Classes;

use ImageOptimization\Classes\Async_Operation\{
	Async_Operation,
	Async_Operation_Hook,
	Async_Operation_Queue,
};
use ImageOptimization\Classes\Image\{
	Image_Meta,
	Image_Query_Builder,
	Image_Status
};
use Throwable;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Restore_Images {
	private const CHUNK_SIZE = 100;

	/**
	 * Schedules a single restoring operation.
	 *
	 * @param int $image_id
	 * @return void
	 * @throws Throwable
	 * @throws \ImageOptimization\Classes\Async_Operation\Exceptions\Async_Operation_Exception
	 */
	public static function schedule_single_restoring( int $image_id ): void {
		$meta = new Image_Meta( $image_id );

		try {
			$meta
				->set_status( Image_Status::RESTORING_IN_PROGRESS )
				->save();

			Async_Operation::create(
				Async_Operation_Hook::RESTORE_SINGLE_IMAGE,
				[ 'attachment_id' => $image_id ],
				Async_Operation_Queue::RESTORE
			);
		} catch ( Throwable $t ) {
			$meta
				->set_status( Image_Status::RESTORING_FAILED )
				->save();

			throw $t;
		}
	}

	/**
	 * Schedules restoring operations for all valid images with backups created.
	 *
	 * @param array $image_ids
	 *
	 * @return void
	 */
	public static function find_and_schedule_restoring( array $image_ids = [] ): void {
		$query = ( new Image_Query_Builder() )
			->return_images_only_with_backups();

		if ( ! empty( $image_ids ) ) {
			$query->set_image_ids( $image_ids );
		}

		$query = $query->execute();
		$attachment_ids = $query->posts;
		$chunks = array_chunk( $attachment_ids, self::CHUNK_SIZE );

		foreach ( $chunks as $chunk ) {
			try {
				Async_Operation::create(
					Async_Operation_Hook::RESTORE_MANY_IMAGES,
					[ 'attachment_ids' => $chunk ],
					Async_Operation_Queue::RESTORE
				);

				self::mark_chunk_as_in_progress( $chunk );
			} catch ( Throwable $t ) {
				self::fail_restoring_for_chunk( $chunk );
			}
		}
	}

	/**
	 * Updates chunk images optimization status to in-progress.
	 *
	 * @param int[] $chunk
	 * @return void
	 */
	private static function mark_chunk_as_in_progress( array $chunk ) {
		foreach ( $chunk as $image_id ) {
			( new Image_Meta( $image_id ) )
				->set_status( Image_Status::RESTORING_IN_PROGRESS )
				->save();
		}
	}

	/**
	 * Updates chunk images optimization status to failed.
	 *
	 * @param int[] $chunk
	 * @return void
	 */
	private static function fail_restoring_for_chunk( array $chunk ) {
		foreach ( $chunk as $image_id ) {
			( new Image_Meta( $image_id ) )
				->set_status( Image_Status::RESTORING_FAILED )
				->save();
		}
	}
}
