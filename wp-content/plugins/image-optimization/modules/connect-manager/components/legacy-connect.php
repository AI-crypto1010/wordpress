<?php
namespace ImageOptimization\Modules\ConnectManager\Components;

use ImageOptimization\Modules\Oauth\{
	Components\Connect,
	Classes\Data,
	Rest\Activate,
	Rest\Connect_Init,
	Rest\Deactivate,
	Rest\Disconnect,
	Rest\Get_Subscriptions,
	Rest\Version,
};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // exit if accessed directly
}

class Legacy_Connect implements Connect_Interface {

	public function is_connected(): bool {
		return Connect::is_connected();
	}

	public function is_activated(): bool {
		return Connect::is_activated();
	}

	public function is_valid_home_url(): bool {
		return true;
	}

	public function get_connect_status() {
		return Connect::get_connect_status();
	}

	public function get_connect_data( bool $force = false ): array {
		return Data::get_connect_data( $force );
	}

	public function update_usage_data( $new_usage_data ): void {
		Connect::update_usage_data( $new_usage_data );
	}

	public function get_activation_state(): string {
		return Data::get_activation_state();
	}

	public function get_access_token() {
		return Data::get_access_token();
	}

	public function get_client_id(): string {
		return Data::get_client_id();
	}

	public function get_client_secret(): string {
		return Data::get_client_secret();
	}

	public function images_left(): int {
		return Data::images_left();
	}

	public function user_is_subscription_owner(): bool {
		return Data::user_is_subscription_owner();
	}

	// Legacy Nonces.

	public function connect_init_nonce(): string {
		return Connect_Init::NONCE_NAME;
	}

	public function disconnect_nonce(): string {
		return Disconnect::NONCE_NAME;
	}

	public function deactivate_nonce(): string {
		return Deactivate::NONCE_NAME;
	}

	public function get_subscriptions_nonce(): string {
		return Get_Subscriptions::NONCE_NAME;
	}

	public function activate_nonce(): string {
		return Activate::NONCE_NAME;
	}

	public function version_nonce(): string {
		return Version::NONCE_NAME;
	}

	public function get_is_connect_on_fly(): bool {
		return false;
	}

	// Placeholder function for legacy connect.
	public function refresh_token(): void {
	}
}
