<?php

namespace ImageOptimization\Modules\Deactivation;

use ImageOptimization\Classes\Logger;
use ImageOptimization\Classes\Module_Base;
use ImageOptimization\Classes\Utils;
use ImageOptimization\Classes\Client\Client;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Module
 */
class Module extends Module_Base {

	const SERVICE_ENDPOINT = 'feedback/deactivation';

	/**
	 * Get module name.
	 * Retrieve the module name.
	 *
	 * @access public
	 * @return string Module name.
	 */
	public function get_name(): string {
		return 'deactivation';
	}

	/**
	 * Check if we should show the deactivation feedback modal
	 *
	 * @return bool
	 */
	private function should_show_feedback(): bool {
		global $pagenow;

		return 'plugins.php' === $pagenow && Utils::user_is_admin();
	}

	/**
	 * Enqueue deactivation feedback assets
	 */
	public function enqueue_deactivation_assets(): void {
		if ( ! $this->should_show_feedback() ) {
			return;
		}

		// Enqueue thickbox for modal
		add_thickbox();

		wp_enqueue_script(
			'deactivation-io',
			$this->get_js_assets_url( 'deactivation' ),
			[],
			IMAGE_OPTIMIZATION_VERSION,
			true
		);

		wp_enqueue_style(
			'deactivation-io',
			$this->get_css_assets_url( 'style-deactivation' ),
			[],
			IMAGE_OPTIMIZATION_VERSION,
		);

		wp_localize_script(
			'deactivation-io',
			'imageOptimizationDeactivationFeedback',
			[
				'nonce' => wp_create_nonce( 'image_optimization_deactivation_feedback' ),
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			]
		);
	}

	/**
	 * Add deactivation feedback modal HTML to footer
	 */
	public function add_deactivation_modal(): void {
		if ( ! $this->should_show_feedback() ) {
			return;
		}
		?>
		<div id="image-optimization-deactivation-modal" class="image-optimization-deactivation-modal">
			<div class="image-optimization-deactivation-content">
				<h4>
					<?php esc_html_e( 'If you have a moment, please share why you are deactivating Image Optimizer:', 'image-optimization' ); ?>
				</h4>

				<div class="image-optimization-feedback-options">
					<div class="image-optimization-feedback-option">
						<label for="io_reason_no_longer_needed">
							<input type="radio" name="image_optimization_deactivation_reason" value="no_longer_needed" id="io_reason_no_longer_needed">
							<?php esc_html_e( 'I no longer need this plugin', 'image-optimization' ); ?>
						</label>
					</div>

					<div class="image-optimization-feedback-option">
						<label for="io_reason_too_expensive">
							<input type="radio" name="image_optimization_deactivation_reason" value="too_expensive" id="io_reason_too_expensive">
							<?php esc_html_e( 'It\'s too expensive', 'image-optimization' ); ?>
						</label>
					</div>

					<div class="image-optimization-feedback-option">
						<label for="io_reason_no_results">
							<input type="radio" name="image_optimization_deactivation_reason" value="no_results" id="io_reason_no_results">
							<?php esc_html_e( 'The plugin didn\'t provide the results I was hoping for', 'image-optimization' ); ?>
						</label>
					</div>

					<div class="image-optimization-feedback-option">
						<label for="io_reason_unclear">
							<input type="radio" name="image_optimization_deactivation_reason" value="unclear_how_to_use" id="io_reason_unclear">
							<?php esc_html_e( 'I wasn\'t sure how to use the plugin', 'image-optimization' ); ?>
						</label>
						<div class="image-optimization-feedback-text-field" id="io_text_field_unclear">
							<label for="io_unclear_details"><?php esc_html_e( 'Optional: Was anything unclear or confusing?', 'image-optimization' ); ?></label>
							<textarea id="io_unclear_details" name="io_unclear_details" rows="3" placeholder="<?php esc_attr_e( 'Please share details...', 'image-optimization' ); ?>"></textarea>
						</div>
					</div>

					<div class="image-optimization-feedback-option">
						<label for="io_reason_technical">
							<input type="radio" name="image_optimization_deactivation_reason" value="technical_issues" id="io_reason_technical">
							<?php esc_html_e( 'I had technical issues or conflicts with my site', 'image-optimization' ); ?>
						</label>
					</div>

					<div class="image-optimization-feedback-option">
						<label for="io_reason_switched">
							<input type="radio" name="image_optimization_deactivation_reason" value="switched_solution" id="io_reason_switched">
							<?php esc_html_e( 'I switched to a different solution', 'image-optimization' ); ?>
						</label>
						<div class="image-optimization-feedback-text-field" id="io_text_field_switched">
							<label for="io_switched_details"><?php esc_html_e( 'Optional: Please share which solution:', 'image-optimization' ); ?></label>
							<input type="text" id="io_switched_details" name="io_switched_details" placeholder="<?php esc_attr_e( 'Solution name...', 'image-optimization' ); ?>">
						</div>
					</div>

					<div class="image-optimization-feedback-option">
						<label for="io_reason_other">
							<input type="radio" name="image_optimization_deactivation_reason" value="other" id="io_reason_other">
							<?php esc_html_e( 'Other', 'image-optimization' ); ?>
						</label>
						<div class="image-optimization-feedback-text-field" id="io_text_field_other">
							<label for="io_other_details"><?php esc_html_e( 'Optional: Please share the reason:', 'image-optimization' ); ?></label>
							<textarea id="io_other_details" name="io_other_details" rows="3" placeholder="<?php esc_attr_e( 'Please explain...', 'image-optimization' ); ?>"></textarea>
						</div>
					</div>
				</div>

				<div class="image-optimization-deactivation-buttons">
					<button type="button" id="image-optimization-skip-deactivate" class="image-optimization-btn">
						<?php esc_html_e( 'Skip & Deactivate', 'image-optimization' ); ?>
					</button>
					<button type="button" id="image-optimization-submit-deactivate" class="image-optimization-btn image-optimization-btn-primary">
						<?php esc_html_e( 'Submit & Deactivate', 'image-optimization' ); ?>
					</button>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Handle AJAX feedback submission
	 */
	public function handle_deactivation_feedback(): void {
		// Verify nonce
		$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ?? '' ) );

		if ( ! wp_verify_nonce( $nonce, 'image_optimization_deactivation_feedback' ) ) {
			wp_send_json_error( esc_html__( 'Security check failed', 'image-optimization' ) );
			return;
		}

		// Check user capabilities
		if ( ! Utils::user_is_admin() ) {
			wp_send_json_error( esc_html__( 'Insufficient permissions', 'image-optimization' ) );
			return;
		}

		$reason = sanitize_text_field( wp_unslash( $_POST['reason'] ?? '' ) );
		$additional_data = '';

		// Safely handle additional_data if it exists
		if ( isset( $_POST['additional_data'] ) ) {
			$additional_data = sanitize_textarea_field( wp_unslash( $_POST['additional_data'] ) );
		}

		if ( empty( $reason ) ) {
			wp_send_json_success( [ 'message' => 'No reason provided' ] );
			return;
		}

		// Send feedback to external service
		$feedback_sent = $this->send_feedback_to_service( $reason, $additional_data );

		if ( $feedback_sent ) {
			wp_send_json_success( [ 'message' => 'Feedback sent successfully' ] );
		} else {
			// Still return success to not block deactivation, but log the error
			Logger::log( Logger::LEVEL_ERROR, 'Failed to send deactivation feedback to service' );
			wp_send_json_success( [ 'message' => 'Feedback logged locally' ] );
		}
	}

	/**
	 * Send feedback to external service
	 *
	 * @param string $reason The deactivation reason
	 * @param string $additional_data Additional feedback data from text fields
	 * @return bool Whether the feedback was sent successfully
	 */
	private function send_feedback_to_service( string $reason, string $additional_data = '' ): bool {
		$feedback_data = $this->prepare_feedback_data( $reason, $additional_data );

		$response = Client::get_instance()->make_request(
			'POST',
			self::SERVICE_ENDPOINT,
			$feedback_data
		);

		if ( empty( $response ) || is_wp_error( $response ) ) {
			$error_message = is_wp_error( $response ) ? $response->get_error_message() : 'Unknown error';
			Logger::log( Logger::LEVEL_ERROR, 'Failed to post feedback: ' . $error_message );
			return false;
		}

		return true;
	}

	/**
	 * Prepare feedback data for the service
	 *
	 * @param string $reason The deactivation reason
	 * @param string $additional_data Additional feedback data from text fields
	 * @return array Formatted feedback data
	 */
	private function prepare_feedback_data( string $reason, string $additional_data = '' ): array {
		$data = [
			'app'         => 'image-optimizer',
			'app_version' => IMAGE_OPTIMIZATION_VERSION,
			'selected_answer'         => $reason,
			'site_url'       => home_url(),
			'wp_version'     => get_bloginfo( 'version' ),
			'php_version'    => PHP_VERSION,
			'timestamp'      => current_time( 'mysql' ),
			'user_agent'     => sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ?? '' ) ),
			'locale'         => get_locale(),
		];

		// Add additional data if provided
		if ( ! empty( $additional_data ) ) {
			$data['feedback_text'] = $additional_data;
		}

		return $data;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_deactivation_assets' ] );
		add_action( 'admin_footer', [ $this, 'add_deactivation_modal' ] );
		add_action( 'wp_ajax_image_optimization_deactivation_feedback', [ $this, 'handle_deactivation_feedback' ] );
	}
}
