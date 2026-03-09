<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (!class_exists('ACF_Date_Time')) {
	class ACF_Date_Time extends \Elementor\Core\DynamicTags\Data_Tag {

		/**
		 * @var ACF_Dynamic_Value_Provider|mixed
		 */
		private $dynamic_value_provider;

		public function get_name() {
			return 'acf-date-time';
		}

		public function get_title() {
			return esc_html__( 'ACF', 'pixfort-code' ) . ' ' . esc_html__( 'Date Time Field', 'pixfort-code' );
		}

		public function get_group() {
			return ACF_Module::ACF_GROUP;
		}

		public function get_categories() {
			return [
				\Elementor\Modules\DynamicTags\Module::DATETIME_CATEGORY,
			];
		}

	/**
	 * @param array $options
	 *
	 * @return string - date time in format Y-m-d H:i:s
	 */
	public function get_value( array $options = [] ) {
		$field_settings = $this->dynamic_value_provider->get_value(
			$this->get_settings( 'key' )
		);

		if ( empty( $field_settings ) || ! is_array( $field_settings ) || ! isset( $field_settings[0] ) ) {
			return '';
		}

		$field = $field_settings[0];
		$value = '';

		if ( $field ) {
			$date_time = \DateTime::createFromFormat( $field['return_format'], $field['value'] );

			$value = $date_time instanceof \DateTime
				? $date_time->format( 'Y-m-d H:i:s' )
				: '';
		}

		if ( empty( $value ) && $this->get_settings( 'fallback' ) ) {
			$value = $this->get_settings( 'fallback' );
		}

		return wp_kses_post( $value );
	}

	public function get_panel_template_setting_key() {
		return 'key';
	}

	protected function register_controls() {
		ACF_Module::add_key_control( $this );

		$this->add_control(
			'fallback',
			[
				'type' => \Elementor\Controls_Manager::DATE_TIME,
				'label' => esc_html__( 'Fallback', 'pixfort-code' ),
			]
		);
	}

	public function get_supported_fields() {
		return [
			'date_time_picker',
		];
	}

	public function __construct( array $data = [], $dynamic_value_provider = null ) {
		parent::__construct( $data );

		$this->dynamic_value_provider = $dynamic_value_provider ?? new ACF_Dynamic_Value_Provider();
	}
	}
}
