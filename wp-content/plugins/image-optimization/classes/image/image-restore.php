<?php

namespace ImageOptimization\Classes\Image;

use ImageOptimization\Classes\File_System\{
	Exceptions\File_System_Operation_Error,
	File_System,
};
use ImageOptimization\Classes\File_Utils;
use ImageOptimization\Classes\Image\Exceptions\{
	Image_Restoring_Exception,
	Invalid_Image_Exception,
};
use ImageOptimization\Classes\Logger;
use Throwable;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Image_Restore {
	public static function restore_many( array $image_ids, bool $keep_image_meta = false ): void {
		foreach ( $image_ids as $image_id ) {
			try {
				self::restore( $image_id, $keep_image_meta );
			} catch ( Throwable $t ) {
				Logger::log( Logger::LEVEL_ERROR, 'Bulk images restoring error: ' . $t->getMessage() );

				( new Image_Meta( $image_id ) )
				->set_status( Image_Status::RESTORING_FAILED )
				->save();

				continue;
			}
		}
	}

	/**
	 * @throws Invalid_Image_Exception|Image_Restoring_Exception|File_System_Operation_Error
	 */
	public static function restore( int $image_id, bool $keep_image_meta = false ): void {
		$image = new Image( $image_id );

		if ( ! $image->can_be_restored() ) {
			throw new Image_Restoring_Exception( esc_html( "Image $image_id cannot be restored" ) );
		}

		$meta = new Image_Meta( $image_id );
		$wp_meta = new WP_Image_Meta( $image_id );

		foreach ( $meta->get_optimized_sizes() as $image_size ) {
			$backup_path = $meta->get_image_backup_path( $image_size );
			$current_path = $image->get_file_path( $image_size );

			if ( $backup_path && $current_path ) {
				$original_path = self::get_path_from_backup_path( $backup_path );

				if ( $original_path === $backup_path ) {
					File_System::delete( $current_path, false, 'f' );

					self::update_posts( $current_path, $original_path );
				} else {
					File_System::move( $backup_path, $original_path, $original_path === $current_path );

					if ( $original_path !== $current_path ) {
						File_System::delete( $current_path, false, 'f' );

						self::update_posts( $current_path, $original_path );
					}
				}

				$file_size = $meta->get_original_file_size( $image_size ) ?? File_System::size( $original_path );

				$wp_meta
					->set_file_path( $image_size, $original_path )
					->set_mime_type( $image_size, $meta->get_original_mime_type( $image_size ) )
					->set_width( $image_size, $meta->get_original_width( $image_size ) )
					->set_height( $image_size, $meta->get_original_height( $image_size ) )
					->set_file_size( $image_size, $file_size );

				if ( Image::SIZE_FULL === $image_size ) {
					self::update_image_post(
						$image,
						$original_path,
						$meta->get_original_mime_type( Image::SIZE_FULL )
					);
				}
			}
		}

		$wp_meta->save();

		if ( $keep_image_meta ) {
			$meta
				->clear_optimized_sizes()
				->clear_backups()
				->clear_original_data()
				->save();

			return;
		}

		$meta->delete();
	}

	private static function get_path_from_backup_path( string $backup_path ): string {
		$extension = File_Utils::get_extension( $backup_path );
		return str_replace( ".backup.$extension", ".$extension", $backup_path );
	}

	private static function update_image_post( Image $image, string $image_path, string $mime_type ): void {
		$post_update_query = [
			'post_modified' => current_time( 'mysql' ),
			'post_modified_gmt' => current_time( 'mysql', true ),
			'post_mime_type' => $mime_type,
			'guid' => File_Utils::get_url_from_path( $image_path ),
		];

		$image->update_attachment( $post_update_query );

		update_attached_file( $image->get_id(), $image_path );
	}

	/**
	 * If we change an image extension, we should walk through the wp_posts table and update all the
	 * hardcoded image links to prevent 404s.
	 *
	 * @param string $old_path Previous image path
	 * @param string $new_path Current image path
	 *
	 * @return void
	 */
	private static function update_posts( string $old_path, string $new_path ) {
		Image_DB_Update::update_posts_table_urls(
			File_Utils::get_url_from_path( $old_path ),
			File_Utils::get_url_from_path( $new_path )
		);
	}
}
