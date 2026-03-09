<?php

namespace ImageOptimization\Classes\Image;

use ImageOptimization\Classes\File_Utils;
use ImageOptimization\Classes\Image\Exceptions\Invalid_Image_Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class WP_Image_Meta
 *
 * This class is used to manage the metadata of an image in WordPress.
 */
class WP_Image_Meta {
	private int $image_id;
	private array $image_meta;
	private Image $image;

	/**
	 * Get the size data of the image.
	 *
	 * @param string $image_size The size of the image.
	 * @return array|null The size data of the image or null if the size does not exist.
	 */
	public function get_size_data( string $image_size ): ?array {
		if ( Image::SIZE_FULL === $image_size ) {
			$output = [];

			$output['file'] = $this->image_meta['file'];
			$output['filesize'] = $this->image_meta['filesize'];
			$output['width'] = $this->image_meta['width'];
			$output['height'] = $this->image_meta['height'];
			$output['mime-type'] = $this->image->get_attachment_object()->post_mime_type;

			return $output;
		}

		if ( ! isset( $this->image_meta['sizes'][ $image_size ] ) ) {
			return null;
		}

		return $this->image_meta['sizes'][ $image_size ];
	}

	/**
	 * Get the keys of the image sizes.
	 *
	 * @return array The keys of the image sizes.
	 */
	public function get_size_keys(): array {
		return [ Image::SIZE_FULL, ...array_keys( $this->image_meta['sizes'] ) ];
	}

	/**
	 * Returns keys of sizes that have the same dimensions as the one provided.
	 *
	 * @param string $image_size The size of the image.
	 *
	 * @return array
	 */
	public function get_size_duplicates( string $image_size ): array {
		$duplicates = [];

		$width = $this->get_width( $image_size );
		$height = $this->get_height( $image_size );

		foreach ( $this->image_meta['sizes'] as $size_key => $size_data ) {
			if ( $size_data['width'] === $width && $size_data['height'] === $height && $image_size !== $size_key ) {
				$duplicates[] = $size_key;
			}
		}

		return array_unique( $duplicates );
	}

	/**
	 * Get the file size of the image.
	 *
	 * @param string $image_size The size of the image.
	 * @return int|null The file size of the image or null if the size does not exist.
	 */
	public function get_file_size( string $image_size ): ?int {
		if ( Image::SIZE_FULL === $image_size ) {
			return $this->image_meta['filesize'] ?? null;
		}

		if ( ! isset( $this->image_meta['sizes'][ $image_size ]['filesize'] ) ) {
			return null;
		}

		return $this->image_meta['sizes'][ $image_size ]['filesize'];
	}

	/**
	 * Set the file size of the image.
	 *
	 * @param string $image_size The size of the image.
	 * @param int $file_size The file size to set.
	 * @return WP_Image_Meta The current instance.
	 */
	public function set_file_size( string $image_size, int $file_size ): WP_Image_Meta {
		if ( Image::SIZE_FULL === $image_size ) {
			$this->image_meta['filesize'] = $file_size;
			return $this;
		}

		$this->maybe_add_new_size( $image_size );

		$this->image_meta['sizes'][ $image_size ]['filesize'] = $file_size;

		return $this;
	}

	/**
	 * Set the file path of the image.
	 *
	 * @param string $image_size The size of the image.
	 * @param string $full_path The full path to set.
	 * @return WP_Image_Meta The current instance.
	 */
	public function set_file_path( string $image_size, string $full_path ): WP_Image_Meta {
		if ( Image::SIZE_FULL === $image_size ) {
			$this->image_meta['file'] = File_Utils::get_relative_upload_path( $full_path );
			return $this;
		}

		$this->maybe_add_new_size( $image_size );

		$this->image_meta['sizes'][ $image_size ]['file'] = File_Utils::get_basename( $full_path );

		return $this;
	}

	/**
	 * Get the width of the image.
	 *
	 * @param string $image_size The size of the image.
	 *
	 * @return int|null
	 */
	public function get_width( string $image_size ): ?int {
		if ( Image::SIZE_FULL === $image_size ) {
			return $this->image_meta['width'];
		}

		if ( ! isset( $this->image_meta['sizes'][ $image_size ]['width'] ) ) {
			return null;
		}

		return $this->image_meta['sizes'][ $image_size ]['width'];
	}

	/**
	 * Set the width of the image.
	 *
	 * @param string $image_size The size of the image.
	 * @param int $width The width to set.
	 * @return WP_Image_Meta The current instance.
	 */
	public function set_width( string $image_size, int $width ): WP_Image_Meta {
		if ( Image::SIZE_FULL === $image_size ) {
			$this->image_meta['width'] = $width;
			return $this;
		}

		$this->maybe_add_new_size( $image_size );

		$this->image_meta['sizes'][ $image_size ]['width'] = $width;

		return $this;
	}

	/**
	 * Get the height of the image.
	 *
	 * @param string $image_size The size of the image.
	 *
	 * @return int|null
	 */
	public function get_height( string $image_size ): ?int {
		if ( Image::SIZE_FULL === $image_size ) {
			return $this->image_meta['height'];
		}

		if ( ! isset( $this->image_meta['sizes'][ $image_size ]['height'] ) ) {
			return null;
		}

		return $this->image_meta['sizes'][ $image_size ]['height'];
	}

	/**
	 * Set the height of the image.
	 *
	 * @param string $image_size The size of the image.
	 * @param int $height The height to set.
	 * @return WP_Image_Meta The current instance.
	 */
	public function set_height( string $image_size, int $height ): WP_Image_Meta {
		if ( Image::SIZE_FULL === $image_size ) {
			$this->image_meta['height'] = $height;
			return $this;
		}

		$this->maybe_add_new_size( $image_size );

		$this->image_meta['sizes'][ $image_size ]['height'] = $height;

		return $this;
	}

	/**
	 * Set the mime type of the image.
	 *
	 * @param string $image_size The size of the image.
	 * @param string $mime_type The mime type to set.
	 * @return WP_Image_Meta The current instance.
	 */
	public function set_mime_type( string $image_size, string $mime_type ): WP_Image_Meta {
		if ( Image::SIZE_FULL === $image_size ) {
			// WP doesn't store it in meta for the original image
			return $this;
		}

		$this->maybe_add_new_size( $image_size );

		$this->image_meta['sizes'][ $image_size ]['mime-type'] = $mime_type;

		return $this;
	}

	/**
	 * Add a new size to the image if it does not exist.
	 *
	 * @param string $image_size The size of the image.
	 */
	private function maybe_add_new_size( $image_size ): void {
		if ( ! isset( $this->image_meta['sizes'][ $image_size ] ) ) {
			$this->image_meta['sizes'][ $image_size ] = [];
		}
	}

	/**
	 * Save the image metadata.
	 *
	 * @return WP_Image_Meta The current instance.
	 */
	public function save(): WP_Image_Meta {
		wp_update_attachment_metadata( $this->image_id, $this->image_meta );

		return $this;
	}

	/**
	 * Query the image metadata.
	 *
	 * @throws Invalid_Image_Exception
	 */
	private function query_meta(): void {
		$meta = wp_get_attachment_metadata( $this->image_id );

		if ( ! $meta ) {
			throw new Invalid_Image_Exception( 'Invalid WP image meta' );
		}

		// Handle unsupported formats that WP doesn't create thumbnails for
		if ( ! isset( $meta['sizes'] ) ) {
			$meta['sizes'] = [];
		}

		$this->image_meta = $meta;
	}

	/**
	 * WP_Image_Meta constructor.
	 *
	 * @param int $image_id The ID of the image.
	 * @param Image|null $image The image object.
	 * @throws Invalid_Image_Exception If the image metadata is invalid.
	 */
	public function __construct( int $image_id, ?Image $image = null ) {
		$this->image_id = $image_id;
		$this->image = $image ?? new Image( $image_id );

		$this->query_meta();
	}
}
