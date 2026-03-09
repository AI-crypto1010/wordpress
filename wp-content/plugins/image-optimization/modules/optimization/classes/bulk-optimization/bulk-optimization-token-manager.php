<?php

namespace ImageOptimization\Modules\Optimization\Classes\Bulk_Optimization;

use ImageOptimization\Classes\Exceptions\Quota_Exceeded_Error;
use ImageOptimization\Classes\Logger;
use ImageOptimization\Classes\Utils;
use ImageOptimization\Modules\Optimization\Classes\Exceptions\Bulk_Token_Obtaining_Error;
use Throwable;

// @codeCoverageIgnoreStart
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
// @codeCoverageIgnoreEnd

final class Bulk_Optimization_Token_Manager {
	private const OBTAIN_TOKEN_ENDPOINT = 'image/bulk-token';

	/**
	 * Sends a request to the BE to obtain bulk optimization token.
	 * It prevents obtaining a token for each and every optimization operation.
	 *
	 * @param int $images_count Total number of images to optimize.
	 * @param int|null $max_batch_size Maximum batch size to try (from previous successful attempt).
	 * @return array
	 *
	 * @throws Quota_Exceeded_Error
	 */
	public static function obtain_token( int $images_count, int $max_batch_size = null ): array {
		$base_sequence = [ $images_count, intval( $images_count / 2 ), 100, 50, 25, 10, 5, 1 ];

		if ( null !== $max_batch_size ) {
			$base_sequence = array_filter( $base_sequence, function( $size ) use ( $max_batch_size ) {
				return $size <= $max_batch_size;
			} );
		}

		$batch_size_sequence = array_unique( $base_sequence, SORT_NUMERIC );

		foreach ( $batch_size_sequence as $batch_size ) {
			if ( $images_count < $batch_size ) {
				continue;
			}

			try {
				$token = self::request_token_for_count( $batch_size );

				return [
					'token' => $token,
					'batch_size' => $batch_size,
				];
			} catch ( Quota_Exceeded_Error | Bulk_Token_Obtaining_Error $te ) {
				Logger::debug( "Quota exceeded for batch size {$batch_size}, trying smaller batch" );
			}
		}

		throw new Quota_Exceeded_Error( esc_html__( 'Images quota exceeded', 'image-optimization' ) );
	}

	/**
	 * Makes the actual API request for a token.
	 *
	 * @param int $count Number of images to request token for.
	 * @return string
	 *
	 * @throws Quota_Exceeded_Error
	 * @throws Bulk_Token_Obtaining_Error
	 */
	private static function request_token_for_count( int $count ): string {
		try {
			$response = Utils::get_api_client()->make_request(
				'POST',
				self::OBTAIN_TOKEN_ENDPOINT,
				[
					'images_count' => $count,
				]
			);

			if ( empty( $response->token ) ) {
				throw new Bulk_Token_Obtaining_Error( 'Token not returned in response' );
			}

			return $response->token;
		} catch ( Quota_Exceeded_Error $qee ) {
			throw $qee;
		} catch ( Throwable $t ) {
			Logger::error( 'Error while sending bulk token request: ' . $t->getMessage() );

			throw new Bulk_Token_Obtaining_Error( esc_html( $t->getMessage() ) );
		}
	}
}
