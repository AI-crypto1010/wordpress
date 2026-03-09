<?php

namespace ImageOptimization\Modules\Backups\Components;

use ImageOptimization\Classes\Async_Operation\Async_Operation_Hook;
use ImageOptimization\Classes\Image\{
	Image_Meta,
	Image_Restore,
	Image_Status,
};

use ImageOptimization\Classes\Logger;
use Throwable;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Restore_Images {
	/** @async */
	public function restore_image( int $image_id ) {
		try {
			Image_Restore::restore( $image_id );
		} catch ( Throwable $t ) {
			Logger::log( Logger::LEVEL_ERROR, 'Image restoring error: ' . $t->getMessage() );

			( new Image_Meta( $image_id ) )
				->set_status( Image_Status::RESTORING_FAILED )
				->save();

			throw $t;
		}
	}

	/** @async */
	public function restore_many_images( array $attachment_ids ) {
		Image_Restore::restore_many( $attachment_ids );
	}

	public function __construct() {
		add_action( Async_Operation_Hook::RESTORE_SINGLE_IMAGE, [ $this, 'restore_image' ] );
		add_action( Async_Operation_Hook::RESTORE_MANY_IMAGES, [ $this, 'restore_many_images' ] );
	}
}
