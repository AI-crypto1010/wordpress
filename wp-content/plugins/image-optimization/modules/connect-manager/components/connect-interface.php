<?php
namespace ImageOptimization\Modules\ConnectManager\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // exit if accessed directly
}

interface Connect_Interface {

	// Connect.
	public function is_connected(): bool;

	public function is_activated(): bool;

	public function is_valid_home_url(): bool;

	public function get_connect_status();

	public function get_connect_data( bool $force = false ): array;

	public function update_usage_data( $new_usage_data ): void;

	public function get_activation_state(): string;

	public function get_access_token();

	public function get_client_id(): string;

	public function get_client_secret(): string;

	public function images_left(): int;

	public function user_is_subscription_owner(): bool;

	// Nonces.

	public function connect_init_nonce(): string;

	public function disconnect_nonce(): string;

	public function deactivate_nonce(): string;

	public function get_subscriptions_nonce(): string;

	public function activate_nonce(): string;

	public function version_nonce(): string;

	public function get_is_connect_on_fly(): bool;

	public function refresh_token(): void;
}
