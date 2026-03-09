<?php

namespace ImageOptimization\Classes\Client;

use Exception;
use ImageOptimization\Classes\Exceptions\Quota_Exceeded_Error;
use ImageOptimization\Modules\Connect\Classes\Exceptions\Connection_Error;
use ImageOptimization\Modules\Optimization\Classes\Exceptions\Bulk_Token_Expired_Error;
use ImageOptimization\Modules\Optimization\Classes\Exceptions\Image_Already_Optimized_Error;
use Throwable;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Client_Response {
	private array $known_errors;
	/**
	 * @var mixed
	 */
	private $response;

	/**
	 * @throws Throwable|Quota_Exceeded_Error|Bulk_Token_Expired_Error|Image_Already_Optimized_Error|Connection_Error
	 */
	public function handle() {
		if ( ! is_wp_error( $this->response ) ) {
			return $this->response;
		}

		$message = $this->response->get_error_message();

		if ( isset( $this->known_errors[ $message ] ) ) {
			throw $this->known_errors[ $message ];
		}

		throw new Exception( esc_html( $message ) );
	}

	public function __construct( $response ) {
		$this->known_errors = [
			'user reached limit' => new Quota_Exceeded_Error( esc_html__( 'Plan quota reached', 'image-optimization' ) ),
			'Bulk token expired' => new Bulk_Token_Expired_Error( esc_html__( 'Bulk token expired', 'image-optimization' ) ),
			'bulk request reached limit' => new Bulk_Token_Expired_Error( esc_html__( 'Bulk token expired', 'image-optimization' ) ),
			'Image already optimized' => new Image_Already_Optimized_Error( esc_html__( 'Image already optimized', 'image-optimization' ) ),
			'Token Auth Guard Request Failed!: Invalid Token' => new Connection_Error( esc_html__( 'Connection error', 'image-optimization' ) ),
		];

		$this->response = $response;
	}
}
