<?php

namespace ImageOptimization\Modules\Backups\Components;

use ImageOptimization\Classes\Async_Operation\Async_Operation_Hook;
use ImageOptimization\Classes\Image\Image_Backup;
use WP_Post;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Handle_Backups_Removing {
	public function remove_backups_on_attachment_removing( int $attachment_id, WP_Post $attachment_post ) {
		if ( ! wp_attachment_is_image( $attachment_post ) ) {
			return;
		}

		Image_Backup::remove( $attachment_id );
	}

	/** @async */
	public function remove_many_backups( array $attachment_ids ) {
		Image_Backup::remove_many( $attachment_ids );
	}

	public function __construct() {
		add_action( 'delete_attachment', [ $this, 'remove_backups_on_attachment_removing' ], 10, 2 );
		add_action( Async_Operation_Hook::REMOVE_MANY_BACKUPS, [ $this, 'remove_many_backups' ] );
	}
}
