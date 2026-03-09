<?php

namespace ImageOptimization\Modules\Oauth\Components;

use ImageOptimization\Modules\Oauth\{
	Classes\Route_Base,
	Components\Exceptions\Auth_Error,
	Classes\Data,
};
use ImageOptimization\Classes\Logger;
use ImageOptimization\Classes\Utils;
use ImageOptimization\Modules\Settings\Module as Settings_Module;

use stdClass;
use Throwable;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Connect
 */
class Connect {
	const API_URL = 'https://my.elementor.com/api/connect/v1';
	const STATUS_CHECK_TRANSIENT = 'image_optimizer_status_check';

	/**
	 * is_connected
	 * @return bool
	 */
	public static function is_connected(): bool {
		return ! empty( Data::get_connect_data()['access_token'] );
	}

	/**
	 * is_activated
	 * @return bool
	 */
	public static function is_activated(): bool {
		return ! empty( Data::get_activation_state() );
	}

	/**
	 * maybe_handle_admin_connect_page
	 * @return bool
	 */
	public static function maybe_handle_admin_connect_page(): bool {
		if ( ! isset( $_GET['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'get_token' ) ) {
			return false;
		}

		$args = [
			'page' => 'elementor-connect',
			'app' => 'library',
			'action' => 'get_token',
			'state' => Data::get_connect_state(),
		];

		foreach ( $args as $key => $value ) {
			if ( ! isset( $_GET[ $key ] ) || $_GET[ $key ] !== $value ) {
				return false;
			}
		}

		if ( ! isset( $_GET['nonce'] ) || ! isset( $_GET['code'] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * handle_elementor_connect_admin
	 */
	public function handle_elementor_connect_admin(): void {
		// validate args
		if ( ! self::maybe_handle_admin_connect_page() ) {
			return;
		}

		// validate nonce
		if ( empty( $_GET['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'get_token' ) ) {
			wp_die( 'Nonce verification failed', 'image-optimization' );
		}

		$token_response = wp_remote_request( self::API_URL . '/get_token', [
			'method' => 'POST',
			'body' => [
				'app' => 'library',
				'grant_type' => 'authorization_code',
				'client_id' => Data::get_client_id(),
				'code' => isset( $_GET['code'] ) ? sanitize_text_field( wp_unslash( $_GET['code'] ) ) : null,
			],
		] );

		if ( is_wp_error( $token_response ) ) {
			wp_die( esc_html( $token_response->get_error_message() ), 'image-optimization' );
		}

		$data = json_decode( wp_remote_retrieve_body( $token_response ), true );
		Data::set_connect_data( $data );

		do_action( Checkpoint::ON_CONNECT );

		// cleanup
		Data::delete_connect_state();

		wp_redirect( add_query_arg( [
			'page' => Settings_Module::SETTING_BASE_SLUG,
			'connected' => 'true',
		], admin_url( 'admin.php' ) ) );
		die();
	}

	/**
	 * Gets required connection data from the service and generates a connect link.
	 *
	 * @return string User connect link
	 *
	 * @throws Auth_Error
	 */
	public static function initialize_connect(): string {
		try {
			$response = wp_remote_request(
				self::API_URL . '/library/get_client_id',
				[
					'method' => 'POST',
					'body' => [
						'local_id' => get_current_user_id(),
						'site_key' => Data::get_site_key(),
						'app' => 'library',
						'home_url' => trailingslashit( home_url() ),
						'source' => 'image-optimizer',
					],
				]
			);
		} catch ( Throwable $t ) {
			Logger::log(
				Logger::LEVEL_ERROR,
				'Error while sending connection initialization request: ' . $t->getMessage()
			);

			throw new Auth_Error( esc_html( $t->getMessage() ) );
		}

		$data = json_decode( wp_remote_retrieve_body( $response ) );

		if ( ! isset( $data->client_id ) || ! isset( $data->auth_secret ) ) {
			Logger::log(
				Logger::LEVEL_ERROR,
				'Invalid response from server: client id or auth secret are undefined'
			);

			throw new Auth_Error( esc_html__( 'Invalid response from server', 'image-optimization' ) );
		}

		Data::set_client_data( $data->client_id, $data->auth_secret );

		return add_query_arg( [
			'utm_source'      => 'image-optimizer-panel',
			'utm_campaign'    => 'image-optimizer',
			'utm_medium'      => 'wp-dash',
			'source'          => 'generic',
			'action'          => 'authorize',
			'response_type'   => 'code',
			'client_id'       => $data->client_id,
			'auth_secret'     => $data->auth_secret,
			'state'           => Data::get_connect_state( true ),
			'redirect_uri'    => rawurlencode( add_query_arg( [
				'page'   => 'elementor-connect',
				'app'    => 'library',
				'action' => 'get_token',
				'nonce'  => wp_create_nonce( 'get_token' ),
			], admin_url( 'admin.php' ) ) ),
			'may_share_data'  => 0,
			'reconnect_nonce' => wp_create_nonce( 'reconnect' ),
		], Route_Base::SITE_URL . 'library' );
	}

	/**
	 * Disconnects a user and removes connection data from the DB.
	 */
	public static function disconnect() {
		do_action( Checkpoint::ON_DISCONNECT );

		try {
			return wp_remote_request( self::API_URL . '/disconnect', [
				'method' => 'POST',
				'body' => [
					'app' => 'library',
					'home_url' => trailingslashit( home_url() ),
					'client_id' => Data::get_client_id(),
					'access_token' => Data::get_access_token(),
				],
			] );
		} catch ( Throwable $t ) {
			Logger::log( Logger::LEVEL_ERROR, 'Error while sending disconnection request: ' . $t->getMessage() );

			throw new Auth_Error( esc_html( $t->getMessage() ) );
		} finally {
			Data::reset();
		}
	}

	/**
	 * Sends an activation request and stores activation data in the DB.
	 *
	 * @param $license_key string License key to activate with.
	 * @return mixed
	 *
	 * @throws Auth_Error
	 */
	public static function activate( string $license_key ) {
		try {
			$response = Utils::get_api_client()->make_request(
				'POST',
				'activation/activate',
				[],
				[ 'key' => $license_key ]
			);
		} catch ( Throwable $t ) {
			Logger::log( Logger::LEVEL_ERROR, 'Error while sending activation request: ' . $t->getMessage() );

			throw new Auth_Error( esc_html( $t->getMessage() ) );
		}

		if ( ! isset( $response->id ) ) {
			Logger::log( Logger::LEVEL_ERROR, 'Invalid response from server' );

			throw new Auth_Error( esc_html__( 'Invalid response from server', 'image-optimization' ) );
		}

		Data::set_activation_state( $license_key );

		do_action( Checkpoint::ON_ACTIVATE, $license_key );

		return $response;
	}

	/**
	 * Deactivate specific license and remove activation data from the DB.
	 *
	 * @param $license_key string License key to deactivate.
	 *
	 * @return mixed
	 *
	 * @throws Auth_Error
	 */
	public static function deactivate( string $license_key ) {

		do_action( Checkpoint::ON_DEACTIVATE, $license_key );

		try {
			$response = Utils::get_api_client()->make_request(
				'POST',
				'activation/deactivate',
				[
					'key' => $license_key,
				]
			);
		} catch ( Throwable $t ) {
			Logger::log( Logger::LEVEL_ERROR, 'Error while sending deactivation request: ' . $t->getMessage() );

			throw new Auth_Error( esc_html( $t->getMessage() ) );
		} finally {
			Data::delete_activation_state();
		}

		if ( ! isset( $response->id ) ) {
			Logger::log( Logger::LEVEL_ERROR, 'Invalid response from server' );

			throw new Auth_Error( esc_html__( 'Invalid response from server', 'image-optimization' ) );
		}

		return $response;
	}

	/**
	 * Fetches and returns a list of available licenses for a specific user.
	 *
	 * @return array Available subscriptions or an empty array
	 *
	 * @throws Auth_Error
	 */
	public static function get_subscriptions(): array {
		try {
			$response = Utils::get_api_client()->make_request(
				'POST',
				'activation/get-subscriptions'
			);
		} catch ( Throwable $t ) {
			Logger::log( Logger::LEVEL_ERROR, 'Error while fetching subscriptions: ' . $t->getMessage() );

			throw new Auth_Error( esc_html( $t->getMessage() ) );
		}

		if ( ! isset( $response->subscriptions ) ) {
			Logger::log( Logger::LEVEL_ERROR, 'Invalid response from server' );

			throw new Auth_Error( esc_html__( 'Invalid response from server', 'image-optimization' ) );
		}

		return $response->subscriptions;
	}

	public static function get_connect_status() {
		if ( ! self::is_connected() ) {
			Logger::log( Logger::LEVEL_INFO, 'Status getting error. Reason: User is not connected' );

			return null;
		}

		$cached_status = get_transient( self::STATUS_CHECK_TRANSIENT );

		if ( $cached_status ) {
			return $cached_status;
		}

		$status = self::check_connect_status();

		set_transient( self::STATUS_CHECK_TRANSIENT, $status, MINUTE_IN_SECONDS * 5 );

		return $status;
	}

	private static function check_connect_status() {
		if ( ! self::is_connected() ) {
			Logger::log( Logger::LEVEL_INFO, 'Status check error. Reason: User is not connected' );

			return null;
		}

		try {
			$response = Utils::get_api_client()->make_request(
				'POST',
				'status/check'
			);
		} catch ( Throwable $t ) {
			Logger::log(
				Logger::LEVEL_ERROR,
				'Status check error. Reason: ' . $t->getMessage()
			);

			return null;
		}

		if ( ! isset( $response->status ) ) {
			Logger::log( Logger::LEVEL_ERROR, 'Invalid response from server' );

			return null;
		}

		return $response;
	}

	public static function update_usage_data( stdClass $new_usage_data ) {
		$connect_status = self::get_connect_status();

		if ( ! isset( $new_usage_data->allowed ) || ! isset( $new_usage_data->used ) ) {
			return;
		}

		if ( 0 === $new_usage_data->allowed - $new_usage_data->used ) {
			$connect_status->status = 'expired';
		}

		$connect_status->quota = $new_usage_data->allowed;
		$connect_status->used_quota = $new_usage_data->used;

		set_transient( self::STATUS_CHECK_TRANSIENT, $connect_status, MINUTE_IN_SECONDS * 5 );
	}

	public function __construct() {
		// handle connect if elementor is active
		add_action( 'load-elementor_page_elementor-connect', [ $this, 'handle_elementor_connect_admin' ], 9 );
		// handle connect if elementor is not active
		add_action( '_admin_menu', [ $this, 'handle_elementor_connect_admin' ] );
	}
}
