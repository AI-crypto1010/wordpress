<?php

namespace ImageOptimization\Modules\Optimization\Components;

use ImageOptimization\Modules\Backups\Classes\Restore_Images;
use ImageOptimization\Modules\Optimization\Classes\Single_Optimization as Single_Optimization_Controller;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Admin_Bulk_Actions {
	public function add_bulk_actions( array $bulk_actions ): array {
		$bulk_actions['image-optimization-optimize'] = esc_html__( 'Optimize', 'image-optimization' );
		$bulk_actions['image-optimization-restore'] = esc_html__( 'Restore original', 'image-optimization' );

		return $bulk_actions;
	}

	public function handle_bulk_actions( $redirect_url, $action, $post_ids ): string {
		if ( 'image-optimization-optimize' === $action ) {
			Single_Optimization_Controller::optimize_many( $post_ids );
		}

		if ( 'image-optimization-restore' === $action ) {
			Restore_Images::find_and_schedule_restoring( $post_ids );
		}

		return $redirect_url;
	}

	public function __construct() {
		add_filter( 'bulk_actions-upload', [ $this, 'add_bulk_actions' ] );
		add_filter( 'handle_bulk_actions-upload', [ $this, 'handle_bulk_actions' ], 10, 3 );
	}
}
