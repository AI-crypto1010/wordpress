<?php

namespace ImageOptimization\Modules\Oauth\Classes;

use ImageOptimization\Modules\Oauth\Components\Connect;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Data
 */
class Data {
	const CONNECT_CLIENT_DATA_OPTION_NAME = 'image_optimizer_client_data';
	const CONNECT_DATA_OPTION_NAME = 'image_optimizer_connect_data';
	const OPTION_CONNECT_SITE_KEY = 'image_optimizer_site_key';
	const OPTION_CONNECT_STATE = 'image_optimizer_connect_state';
	const OPTION_ACTIVATION_STATE = 'image_optimizer_activation_state';
	const OPTION_OWNER_USER_ID = 'image_optimizer_owner_user_id';

	/**
	 * set_client_data
	 * @param $client_id
	 * @param $auth_secret
	 */
	public static function set_client_data( $client_id, $auth_secret ) {
		update_option( self::CONNECT_CLIENT_DATA_OPTION_NAME, [
			'client_id' => $client_id,
			'auth_secret' => $auth_secret,
		], false );
	}

	/**
	 * get_client_data
	 * @return array
	 */
	public static function get_client_data(): array {
		return get_option( self::CONNECT_CLIENT_DATA_OPTION_NAME, [
			'client_id' => '',
			'auth_secret' => '',
		] );
	}

	/**
	 * get_client_id
	 * @return string
	 */
	public static function get_client_id(): string {
		return self::get_client_data()['client_id'] ?? '';
	}

	/**
	 * get_client_secret
	 * @return string
	 */
	public static function get_client_secret(): string {
		return self::get_client_data()['auth_secret'] ?? '';
	}

	/**
	 * get_connect_data
	 *
	 * @param bool $force
	 *
	 * @return array|null
	 */
	public static function get_connect_data( bool $force = false ): array {
		static $connect_data = null;
		if ( null === $connect_data || $force ) {
			$connect_data = array_merge(
				[
					'access_token'        => '',
					'access_token_secret' => '',
					'last_update'         => 0,
					'token_type'          => 'bearer',
					'user'                => [],
					'version'             => 1,
				],
				get_option( self::CONNECT_DATA_OPTION_NAME, [] )
			);
		}
		return $connect_data;
	}

	/**
	 * set_connect_data
	 *
	 * @param array $data
	 */
	public static function set_connect_data( array $data = [] ): bool {
		$data['last_update'] = time();
		$data['version'] = 1;

		update_option( self::OPTION_OWNER_USER_ID, get_current_user_id() );
		return update_option( self::CONNECT_DATA_OPTION_NAME, $data );
	}

	/**
	 * get_access_token
	 * @return false|mixed
	 */
	public static function get_access_token() {
		return self::get_connect_data()['access_token'] ?? false;
	}

	/**
	 * get_connect_state
	 *
	 * @param bool $force
	 *
	 * @return false|mixed|null|string
	 */
	public static function get_connect_state( bool $force = false ) {
		$state = get_option( static::OPTION_CONNECT_STATE );
		if ( ! $state || $force ) {
			$state = wp_generate_password( 12, false );
			update_option( static::OPTION_CONNECT_STATE, $state, false );
		}
		return $state;
	}

	/**
	 * get_site_key
	 * @return false|mixed|string|null
	 */
	public static function get_site_key() {
		$site_key = get_option( static::OPTION_CONNECT_SITE_KEY );

		if ( ! $site_key ) {
			$site_key = md5( uniqid( wp_generate_password() ) );
			update_option( static::OPTION_CONNECT_SITE_KEY, $site_key, false );
		}

		return $site_key;
	}

	/**
	 * delete_connect_state
	 */
	public static function delete_connect_state(): bool {
		return delete_option( static::OPTION_CONNECT_STATE );
	}

	public static function get_activation_state(): string {
		return get_option( self::OPTION_ACTIVATION_STATE, '' );
	}

	public static function set_activation_state( $state ): bool {
		return update_option( self::OPTION_ACTIVATION_STATE, $state );
	}

	public static function delete_activation_state(): bool {
		return delete_option( self::OPTION_ACTIVATION_STATE );
	}

	/**
	 * reset connect data
	 */
	public static function reset(): void {
		self::delete_connect_state();
		self::delete_activation_state();

		delete_option( self::OPTION_OWNER_USER_ID );
		delete_option( static::CONNECT_DATA_OPTION_NAME );
		delete_option( self::CONNECT_CLIENT_DATA_OPTION_NAME );
		delete_transient( Connect::STATUS_CHECK_TRANSIENT );
	}

	public static function images_left(): int {
		$plan_data = Connect::get_connect_status();

		if ( empty( $plan_data ) ) {
			return 0;
		}

		$quota = $plan_data->quota;
		$used_quota = $plan_data->used_quota;

		return max( $quota - $used_quota, 0 );
	}

	public static function user_is_subscription_owner(): bool {
		$owner_id = (int) get_option( self::OPTION_OWNER_USER_ID );

		return get_current_user_id() === $owner_id;
	}
}
