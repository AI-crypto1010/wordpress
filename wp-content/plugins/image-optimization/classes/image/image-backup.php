<?php

namespace ImageOptimization\Classes\Image;

use ImageOptimization\Classes\File_System\Exceptions\File_System_Operation_Error;
use ImageOptimization\Classes\File_System\File_System;
use ImageOptimization\Classes\File_Utils;
use ImageOptimization\Classes\Image\Exceptions\Image_Backup_Creation_Error;
use ImageOptimization\Classes\Logger;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * We're saving backup paths in meta even though the backup path could be dynamically generated.
 * The next reasons affected this decision:
 *
 * 1. Possible path conflicts with other plugins and/or custom user logic. We can't guarantee that the image
 * we find using the dynamically created path will be the same image we saved.
 * 2. If a backup doesn't exist, but stored in our meta -- we can be almost sure it's not because of us.
 * Probably, some other plugin removed it or even user manually did it, but it's not our fault. Makes this logic
 * easier to debug.
 * 3. We can change backup file name using `wp_unique_filename()` if needed and easily point a backup path to an
 * image.
 */
class Image_Backup {
	/**
	 * Creates a backup of a file by copying it to a new file with the backup extension.
	 * Also, attaches a newly created backup to image's meta.
	 *
	 * @param int $image_id Attachment id.
	 * @param string $image_size Image size (e.g. 'full', 'thumbnail', etc.).
	 * @param string $image_path Path to an image we plan to back up.
	 *
	 * @return string Backup path if successfully created, false otherwise.
	 *
	 * @throws Image_Backup_Creation_Error
	 */
	public static function create( int $image_id, string $image_size, string $image_path ): string {
		$extension = File_Utils::get_extension( $image_path );
		$backup_path = File_Utils::replace_extension( $image_path, "backup.$extension" );

		try {
			File_System::copy( $image_path, $backup_path, true );
		} catch ( File_System_Operation_Error $e ) {
			Logger::log(
				Logger::LEVEL_ERROR,
				"Error while creating a backup for image {$image_id} and size {$image_size}"
			);

			throw new Image_Backup_Creation_Error(
				esc_html( "Error while creating a backup for image $image_id and size $image_size" )
			);
		}

		$meta = new Image_Meta( $image_id );

		$meta->set_image_backup_path( $image_size, $backup_path );
		$meta->save();

		return $backup_path;
	}

	/**
	 * Looks for registered backups and remove all files found.
	 * Also, wipes removed files from image meta.
	 *
	 * @param int[] $image_ids Array of attachment ids.
	 * @return void
	 */
	public static function remove_many( array $image_ids ): void {
		foreach ( $image_ids as $image_id ) {
			self::remove( $image_id );
		}
	}

	/**
	 * Removes one or all backups for a specific image.
	 * Also, wipes removed files from image meta.
	 *
	 * @param int $image_id Attachment id.
	 * @param string|null $image_size Image size (e.g. 'full', 'thumbnail', etc.). All backups will be removed if no size provided.
	 *
	 * @return bool Returns true if backups were removed successfully, false otherwise.
	 */
	public static function remove( int $image_id, ?string $image_size = null ): bool {
		$meta = new Image_Meta( $image_id );
		$backups = $meta->get_image_backup_paths();

		if ( empty( $backups ) ) {
			return false;
		}

		if ( $image_size ) {
			if ( ! key_exists( $image_size, $backups ) ) {
				return false;
			}

			try {
				File_System::delete( $backups[ $image_size ], false, 'f' );
			} catch ( File_System_Operation_Error $e ) {
				Logger::log(
					Logger::LEVEL_ERROR,
					"Error while removing a backup for image {$image_id} and size {$image_size}"
				);
			}

			$meta->remove_image_backup_path( $image_size );
			$meta->save();

			return true;
		}

		foreach ( $backups as $image_size => $backup_path ) {
			try {
				File_System::delete( $backup_path, false, 'f' );
			} catch ( File_System_Operation_Error $e ) {
				Logger::log( Logger::LEVEL_ERROR, "Error while removing backups {$image_id}" );
			}

			$meta->remove_image_backup_path( $image_size );
		}

		$meta->save();

		return true;
	}
}
