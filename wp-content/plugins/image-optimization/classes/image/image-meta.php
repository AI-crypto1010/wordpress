<?php

namespace ImageOptimization\Classes\Image;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Image_Meta {
	public const IMAGE_OPTIMIZER_METADATA_KEY = 'image_optimizer_metadata';
	private const INITIAL_META_VALUE = [
		'status' => Image_Status::NOT_OPTIMIZED,
		'error_type' => null,
		'compression_level' => null,
		'retry_count' => null,
		'sizes_optimized' => [],
		'backups' => [],
		'original_data' => [
			'sizes' => [],
		],
	];

	private int $image_id;
	private array $image_meta;

	public function get_status(): string {
		return $this->image_meta['status'];
	}

	public function set_status( string $status ): Image_Meta {
		$this->image_meta['status'] = $status;

		return $this;
	}

	public function get_error_type(): ?string {
		return $this->image_meta['error_type'];
	}

	public function set_error_type( ?string $type ): Image_Meta {
		$this->image_meta['error_type'] = $type;

		return $this;
	}

	public function get_compression_level(): ?string {
		return $this->image_meta['compression_level'];
	}

	public function set_compression_level( string $compression_level ): Image_Meta {
		$this->image_meta['compression_level'] = $compression_level;

		return $this;
	}

	public function get_retry_count(): ?int {
		return $this->image_meta['retry_count'];
	}

	public function set_retry_count( ?int $retry_count ): Image_Meta {
		$this->image_meta['retry_count'] = $retry_count;

		return $this;
	}

	public function get_optimized_sizes(): array {
		return $this->image_meta['sizes_optimized'];
	}

	public function add_optimized_size( string $optimized_size ): Image_Meta {
		if ( ! in_array( $optimized_size, $this->image_meta['sizes_optimized'], true ) ) {
			$this->image_meta['sizes_optimized'][] = $optimized_size;
		}

		return $this;
	}

	public function clear_optimized_sizes(): Image_Meta {
		$this->image_meta['sizes_optimized'] = [];

		return $this;
	}

	public function set_optimized_size( array $optimized_size ): Image_Meta {
		$this->image_meta['sizes_optimized'] = $optimized_size;

		return $this;
	}

	public function clear_backups(): Image_Meta {
		$this->image_meta['backups'] = [];

		return $this;
	}

	public function get_image_backup_paths(): array {
		return $this->image_meta['backups'];
	}

	public function get_image_backup_path( string $image_size ): ?string {
		return $this->image_meta['backups'][ $image_size ] ?? null;
	}

	public function set_image_backup_path( string $image_size, string $backup_path ): Image_Meta {
		$this->image_meta['backups'][ $image_size ] = $backup_path;

		return $this;
	}

	public function remove_image_backup_path( string $image_size ): Image_Meta {
		unset( $this->image_meta['backups'][ $image_size ] );

		return $this;
	}

	public function get_original_file_size( string $image_size ): ?int {
		if ( ! isset( $this->image_meta['original_data']['sizes'][ $image_size ]['filesize'] ) ) {
			return null;
		}

		return $this->image_meta['original_data']['sizes'][ $image_size ]['filesize'];
	}

	public function get_original_mime_type( string $image_size ): ?string {
		if ( ! isset( $this->image_meta['original_data']['sizes'][ $image_size ] ) ) {
			return null;
		}

		return $this->image_meta['original_data']['sizes'][ $image_size ]['mime-type'];
	}

	public function get_original_width( string $image_size ): ?string {
		if ( ! isset( $this->image_meta['original_data']['sizes'][ $image_size ] ) ) {
			return null;
		}

		return $this->image_meta['original_data']['sizes'][ $image_size ]['width'];
	}

	public function get_original_height( string $image_size ): ?string {
		if ( ! isset( $this->image_meta['original_data']['sizes'][ $image_size ] ) ) {
			return null;
		}

		return $this->image_meta['original_data']['sizes'][ $image_size ]['height'];
	}

	public function add_original_data( string $size, array $data ): Image_Meta {
		$this->image_meta['original_data']['sizes'][ $size ] = $data;

		return $this;
	}

	public function clear_original_data(): Image_Meta {
		$this->image_meta['original_data'] = [ 'sizes' => [] ];

		return $this;
	}

	public function delete(): bool {
		return delete_post_meta( $this->image_id, self::IMAGE_OPTIMIZER_METADATA_KEY );
	}

	public function save(): Image_Meta {
		update_post_meta( $this->image_id, self::IMAGE_OPTIMIZER_METADATA_KEY, $this->image_meta );

		$this->query_meta();

		return $this;
	}

	private function query_meta(): void {
		$meta = get_post_meta( $this->image_id, self::IMAGE_OPTIMIZER_METADATA_KEY, true );
		$this->image_meta = $meta ? array_replace_recursive( self::INITIAL_META_VALUE, $meta ) : self::INITIAL_META_VALUE;
	}

	public function __construct( int $image_id ) {
		$this->image_id = $image_id;

		$this->query_meta();
	}
}
