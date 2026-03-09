<?php

namespace ImageOptimization\Classes\Image;

use ImageOptimization\Classes\Image\Exceptions\Invalid_Image_Exception;
use WP_Post;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Image {
	public const SIZE_FULL = 'full';
	private const SUPPORTED_MIME_TYPES = [ 'image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/avif' ];

	// Used for error messages
	private const SUPPORTED_FORMATS = [ 'jpeg', 'png', 'webp', 'gif', 'avif' ];
	private const MIME_TYPES_CANNOT_BE_OPTIMIZED = [ 'image/avif' ];
	private const FORMATS_CANNOT_BE_OPTIMIZED = [ 'avif' ];

	protected int $image_id;
	protected $attachment_object;

	/**
	 * Returns attachment post id.
	 *
	 * @return int
	 */
	public function get_id(): int {
		return $this->image_id;
	}

	/**
	 * Returns file URL for a specific image size.
	 *
	 * @param string $image_size Image size (e. g. 'full', 'thumbnail', etc)
	 * @return string|null
	 */
	public function get_url( string $image_size ): ?string {
		$image_data = wp_get_attachment_image_src( $this->image_id, $image_size );

		if ( empty( $image_data ) ) {
			return null;
		}

		return $image_data[0];
	}

	/**
	 * Returns absolute file path for a specific image size.
	 *
	 * @param string $image_size Image size (e. g. 'full', 'thumbnail', etc)
	 * @return string|null
	 */
	public function get_file_path( string $image_size ): ?string {
		if ( 'full' === $image_size ) {
			$path = get_attached_file( $this->image_id );
			return $path ?? null;
		}

		$path_data = image_get_intermediate_size( $this->image_id, $image_size );

		if ( empty( $path_data ) ) {
			return null;
		}

		return sprintf(
			'%s/%s',
			wp_get_upload_dir()['basedir'],
			$path_data['path']
		);
	}

	public function file_exists( string $image_size ): bool {
		$path = $this->get_file_path( $image_size );

		if ( ! $path ) {
			return false;
		}

		return file_exists( $path );
	}

	/**
	 * Returns true if an image marked as optimized.
	 *
	 * @return bool
	 */
	public function is_optimized(): bool {
		$meta = new Image_Meta( $this->image_id );

		return $meta->get_status() === Image_Status::OPTIMIZED;
	}

	/**
	 * Returns true if an image can be restored from the backups.
	 *
	 * @return bool
	 */
	public function can_be_restored(): bool {
		$meta = new Image_Meta( $this->image_id );

		return (bool) count( $meta->get_image_backup_paths() );
	}

	/**
	 * Returns image's mime type.
	 *
	 * @return string
	 */
	public function get_mime_type(): string {
		return $this->attachment_object->post_mime_type;
	}

	/**
	 * Returns an original attachment WP_Post object.
	 *
	 * @return WP_Post
	 */
	public function get_attachment_object(): WP_Post {
		return $this->attachment_object;
	}

	/**
	 * Updates WP_Post fields of the attachment.
	 *
	 * @return bool True if the post was updated successfully, false otherwise.
	 */
	public function update_attachment( array $update_query ): bool {
		global $wpdb;

		// Must use $wpdb here as `wp_update_post()` doesn't allow to rewrite guid.
		$result = $wpdb->update(
			$wpdb->posts,
			$update_query,
			[ 'ID' => $this->image_id ]
		);

		if ( 0 !== $result ) {
			$this->attachment_object = get_post( $this->image_id );
			return true;
		}

		return false;
	}

	/**
	 * Returns the list of mime types supported by the plugin.
	 *
	 * @return string[]
	 */
	public static function get_supported_mime_types(): array {
		return self::SUPPORTED_MIME_TYPES;
	}

	/**
	 * Returns the list of formats types supported by the plugin.
	 *
	 * @return string[]
	 */
	public static function get_supported_formats(): array {
		return self::SUPPORTED_FORMATS;
	}

	/**
	 * Returns the list of mime types that are supported by the plugin, but cannot be optimized
	 *
	 * @return string[]
	 */
	public static function get_mime_types_cannot_be_optimized(): array {
		return self::MIME_TYPES_CANNOT_BE_OPTIMIZED;
	}

	/**
	 * Returns the list of formats that are supported by the plugin, but cannot be optimized
	 *
	 * @return string[]
	 */
	public static function get_formats_cannot_be_optimized(): array {
		return self::FORMATS_CANNOT_BE_OPTIMIZED;
	}

	/**
	 * @throws Invalid_Image_Exception
	 */
	public function __construct( int $image_id ) {
		$this->image_id = $image_id;
		$this->attachment_object = get_post( $image_id );

		if ( ! $this->attachment_object ) {
			throw new Invalid_Image_Exception( esc_html( "There is no entity with id '$image_id'" ) );
		}

		if ( ! wp_attachment_is_image( $this->attachment_object ) ) {
			throw new Invalid_Image_Exception( esc_html( "Post '$image_id' is not an image" ) );
		}
	}
}
