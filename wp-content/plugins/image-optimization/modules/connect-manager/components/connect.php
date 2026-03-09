<?php
namespace ImageOptimization\Modules\ConnectManager\Components;

use ImageOptimization\Modules\Connect\{
	Module as Connect_Module,
};

use ImageOptimization\Modules\Settings\Classes\Settings;
use ImageOptimization\Classes\Logger;
use ImageOptimization\Classes\Utils;
use ImageOptimization\Classes\Client\Client;
use Throwable;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // exit if accessed directly
}

class Connect implements Connect_Interface {
	const STATUS_CHECK_TRANSIENT = 'image_optimizer_status_check';
	const STATUS_CHECK_ERROR_TRANSIENT = 'image_optimizer_status_check_error';
	const ERROR_CACHE_DURATION = MINUTE_IN_SECONDS * 5;

	public function is_connected(): bool {
		return Connect_Module::is_connected();
	}

	public function is_activated(): bool {
		return Connect_Module::is_connected();
	}

	public function is_valid_home_url(): bool {
		return Connect_Module::get_connect()->utils()->is_valid_home_url();
	}

	public function get_connect_status() {
		if ( ! $this->is_connected() ) {
			Logger::log( Logger::LEVEL_INFO, 'Status check error. Reason: User is not connected' );
			return null;
		}

		$cached_status = get_transient( self::STATUS_CHECK_TRANSIENT );

		if ( $cached_status ) {
			return $cached_status;
		}

		$cached_error = get_transient( self::STATUS_CHECK_ERROR_TRANSIENT );

		if ( $cached_error ) {
			Logger::debug( 'Status check skipped due to recent error: ' . $cached_error );
			return null;
		}

		try {
			$response = Utils::get_api_client()->make_request(
				'POST',
				'status/check'
			);
		} catch ( Throwable $t ) {
			$error_message = $t->getMessage();

			Logger::error( 'Status check error. Reason: ' . $error_message );

			set_transient( self::STATUS_CHECK_ERROR_TRANSIENT, $error_message, self::ERROR_CACHE_DURATION );

			return null;
		}

		if ( ! isset( $response->status ) ) {
			$error_message = 'Invalid response from server';

			Logger::error( $error_message );

			set_transient( self::STATUS_CHECK_ERROR_TRANSIENT, $error_message, self::ERROR_CACHE_DURATION );

			return null;
		}

		if ( ! empty( $response->site_url ) && Connect_Module::get_connect()->data()->get_home_url() !== $response->site_url ) {
			Connect_Module::get_connect()->data()->set_home_url( $response->site_url );
		}

		Settings::set( Settings::SUBSCRIPTION_ID, $response->subscription_id );

		// Append subscription info to response
		$subscription_info = Client::get_subscription_info();
		if ( $subscription_info ) {
			$response->subscription_info = $subscription_info;
		}

		set_transient( self::STATUS_CHECK_TRANSIENT, $response, MINUTE_IN_SECONDS * 5 );

		return $response;
	}

	public function get_connect_data( bool $force = false ): array {
		$data = get_transient( self::STATUS_CHECK_TRANSIENT );

		$user = [];

		// Return empty array if transient does not exist or is expired.
		if ( ! $data ) {
			return $user;
		}

		// Return if user property does not exist in the data object.
		if ( ! property_exists( $data, 'user' ) ) {
			return $user;
		}

		if ( $data->user->email ) {
			$user = [
				'user' => [
					'email' => $data->user->email,
				],
			];
		}

		return $user;
	}

	public function update_usage_data( $new_usage_data ): void {
		$connect_status = $this->get_connect_status();

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

	public function get_activation_state(): string {
		/**
		 * Returning true because the license key is
		 * not used for deactivation in connect.
		 */
		return true;
	}

	public function get_access_token() {
		return Connect_Module::get_connect()->data()->get_access_token();
	}

	public function get_client_id(): string {
		return Connect_Module::get_connect()->data()->get_client_id();
	}

	public function get_client_secret(): string {
		return Connect_Module::get_connect()->data()->get_client_secret();
	}

	public function images_left(): int {
		$plan_data = $this->get_connect_status();

		if ( empty( $plan_data ) ) {
			return 0;
		}

		$quota = $plan_data->quota;
		$used_quota = $plan_data->used_quota;

		return max( $quota - $used_quota, 0 );
	}

	public function user_is_subscription_owner(): bool {
		return Connect_Module::get_connect()->data()->user_is_subscription_owner();
	}

	// Nonces.
	public function connect_init_nonce(): string {
		return 'wp_rest';
	}

	public function disconnect_nonce(): string {
		return 'wp_rest';
	}

	public function deactivate_nonce(): string {
		return 'wp_rest';
	}

	public function get_subscriptions_nonce(): string {
		return 'wp_rest';
	}

	public function activate_nonce(): string {
		return 'wp_rest';
	}

	public function version_nonce(): string {
		return 'wp_rest';
	}

	public function get_is_connect_on_fly(): bool {
		return true;
	}

	public function refresh_token(): void {
		Connect_Module::get_connect()->service()->renew_access_token();
	}

	public function clear_error_cache(): void {
		delete_transient( self::STATUS_CHECK_ERROR_TRANSIENT );
	}
}
