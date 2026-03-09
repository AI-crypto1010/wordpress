<?php

namespace ImageOptimization\Classes\File_System;

use ImageOptimization\Classes\File_System\Exceptions\File_System_Operation_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once ABSPATH . 'wp-admin/includes/file.php';
WP_Filesystem();

/**
 * A wrapper class under WP_Filesystem that throws clear exceptions in case if something went wrong.
 */
class File_System {
	/**
	 * Writes a string to a file.
	 *
	 * @param string $file Remote path to the file where to write the data.
	 * @param string $contents The data to write.
	 * @param int|false $mode The file permissions as octal number, usually 0644.
	 *
	 * @return true
	 *
	 * @throws File_System_Operation_Error
	 */
	public static function put_contents( string $file, string $contents, $mode = false ): bool {
		global $wp_filesystem;

		$result = $wp_filesystem->put_contents( $file, $contents, $mode );

		if ( ! $result ) {
			throw new File_System_Operation_Error( esc_html( "Error while writing $file" ) );
		}

		return true;
	}

	/**
	 * Deletes a file or directory.
	 *
	 * @param string $file Path to the file or directory.
	 * @param bool $recursive If set to true, deletes files and folders recursively.
	 * @param string|false $type Type of resource. 'f' for file, 'd' for directory.
	 *
	 * @return true
	 *
	 * @throws File_System_Operation_Error
	 */
	public static function delete( string $file, bool $recursive = false, $type = false ): bool {
		global $wp_filesystem;

		$result = $wp_filesystem->delete( $file, $recursive, $type );

		if ( ! $result ) {
			throw new File_System_Operation_Error( esc_html( "Error while deleting $file" ) );
		}

		return true;
	}

	/**
	 * @param string $source Path to the source file.
	 * @param string $destination Path to the destination file.
	 * @param bool $overwrite Whether to overwrite the destination file if it exists.
	 *
	 * @return true
	 *
	 * @throws File_System_Operation_Error
	 */
	public static function move( string $source, string $destination, bool $overwrite = false ): bool {
		global $wp_filesystem;

		$result = $wp_filesystem->move( $source, $destination, $overwrite );

		if ( ! $result ) {
			throw new File_System_Operation_Error( esc_html( "Error while moving $source to $destination" ) );
		}

		return true;
	}

	/**
	 * Copies a file.
	 *
	 * @param string $source Path to the source file.
	 * @param string $destination Path to the destination file.
	 * @param bool $overwrite Whether to overwrite the destination file if it exists.
	 * @param int|false $mode The permissions as octal number, usually 0644 for files, 0755 for dirs.
	 *
	 * @return bool
	 *
	 * @throws File_System_Operation_Error
	 */
	public static function copy( string $source, string $destination, bool $overwrite = false, $mode = false ): bool {
		global $wp_filesystem;

		$result = $wp_filesystem->copy( $source, $destination, $overwrite, $mode );

		if ( ! $result ) {
			throw new File_System_Operation_Error( esc_html( "Error while copying $source to $destination" ) );
		}

		return true;
	}

	/**
	 * Checks if a file or directory exists.
	 *
	 * @param string $path Path to file or directory.
	 *
	 * @return bool Whether $path exists or not.
	 */
	public static function exists( string $path ): bool {
		global $wp_filesystem;

		return $wp_filesystem->exists( $path );
	}

	/**
	 * Gets the file size (in bytes).
	 *
	 * @param ?string $path Path to file.
	 *
	 * @return int Size of the file in bytes on success, false on failure.
	 *
	 * @throws File_System_Operation_Error
	 */
	public static function size( ?string $path ): int {
		global $wp_filesystem;

		if ( is_null( $path ) ) {
			throw new File_System_Operation_Error( 'Null file path provided' );
		}

		$size = $wp_filesystem->size( $path );

		if ( ! $size ) {
			throw new File_System_Operation_Error( esc_html( "Unable to calculate file size for $path" ) );
		}

		return $size;
	}
}
