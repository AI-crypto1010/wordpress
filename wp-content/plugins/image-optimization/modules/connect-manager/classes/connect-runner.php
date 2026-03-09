<?php
namespace ImageOptimization\Modules\ConnectManager\Classes;

use ImageOptimization\Modules\ConnectManager\Components\Connect_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // exit if accessed directly
}

class Connect_Runner {
	public $connect;

	public function __construct( Connect_Interface $connect ) {
		$this->connect = $connect;
	}

	public function is_connected() {
		return $this->connect->is_connected();
	}

	public function is_activated(): bool {
		return $this->connect->is_activated();
	}

	public function is_valid_home_url(): bool {
		return $this->connect->is_valid_home_url();
	}

	public function get_connect_status() {
		return $this->connect->get_connect_status();
	}

	public function get_connect_data( bool $force = false ): array {
		return $this->connect->get_connect_data( $force );
	}

	public function update_usage_data( $new_usage_data ): void {
		$this->connect->update_usage_data( $new_usage_data );
	}

	public function get_activation_state(): string {
		return $this->connect->get_activation_state();
	}

	public function get_access_token() {
		return $this->connect->get_access_token();
	}

	public function get_client_id(): string {
		return $this->connect->get_client_id();
	}

	public function get_client_secret(): string {
		return $this->connect->get_client_secret();
	}

	public function images_left(): int {
		return $this->connect->images_left();
	}

	public function user_is_subscription_owner(): bool {
		return $this->connect->user_is_subscription_owner();
	}

	// Legacy Nonces.

	public function connect_init_nonce(): string {
		return $this->connect->connect_init_nonce();
	}

	public function disconnect_nonce(): string {
		return $this->connect->disconnect_nonce();
	}

	public function deactivate_nonce(): string {
		return $this->connect->deactivate_nonce();
	}

	public function get_subscriptions_nonce(): string {
		return $this->connect->get_subscriptions_nonce();
	}

	public function activate_nonce(): string {
		return $this->connect->activate_nonce();
	}

	public function version_nonce(): string {
		return $this->connect->version_nonce();
	}

	public function get_is_connect_on_fly(): bool {
		return $this->connect->get_is_connect_on_fly();
	}

	public function refresh_token(): void {
		$this->connect->refresh_token();
	}
}
