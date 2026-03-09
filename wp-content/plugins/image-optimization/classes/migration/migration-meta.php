<?php

namespace ImageOptimization\Classes\Migration;

use DateTime;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Migration_Meta {
	public const IMAGE_OPTIMIZER_MIGRATION_KEY = 'image_optimizer_migrations';
	private const INITIAL_META_VALUE = [
		'last_run' => null,
		'last_wp_version_run' => null,
		'migrations_passed' => [],
	];
	private array $migration_meta;

	public function get_last_run(): ?string {
		return $this->migration_meta['last_run'];
	}

	public function set_last_run( DateTime $date ): Migration_Meta {
		$this->migration_meta['last_run'] = $date;

		return $this;
	}

	public function get_last_wp_version(): string {
		return $this->migration_meta['last_wp_version_run'];
	}

	public function set_last_wp_version( ?string $version ): Migration_Meta {
		if ( ! $version ) {
			$this->migration_meta['last_wp_version_run'] = get_bloginfo( 'version' );

			return $this;
		}

		$this->migration_meta['last_wp_version_run'] = $version;

		return $this;
	}

	public function get_migrations_passed(): array {
		return $this->migration_meta['migrations_passed'];
	}

	public function add_migration_passed( string $migration ): Migration_Meta {
		$this->migration_meta['migrations_passed'][] = $migration;

		return $this;
	}

	public function delete(): bool {
		return delete_option( self::IMAGE_OPTIMIZER_MIGRATION_KEY );
	}

	public function save(): Migration_Meta {
		update_option( self::IMAGE_OPTIMIZER_MIGRATION_KEY, $this->migration_meta, false );

		$this->query_meta();

		return $this;
	}

	private function query_meta(): void {
		$meta = get_option( self::IMAGE_OPTIMIZER_MIGRATION_KEY, [] );
		$this->migration_meta = $meta ? array_replace_recursive( self::INITIAL_META_VALUE, $meta ) : self::INITIAL_META_VALUE;
	}

	public function __construct() {
		$this->query_meta();
	}
}
