<?php

namespace Elementor\CustomControl;

use \Elementor\Base_Data_Control;

/**
 * Pix Query Search Control.
 *
 * A control for searching and selecting posts, taxonomies, media, and authors with AJAX autocomplete.
 *
 * @since 1.0.0
 */
class Pix_Query_Search_Control extends Base_Data_Control {

    const PixQuerySearch = 'pix_query_search';

	/**
	 * Set control type.
	 */
	public function get_type() {
		return self::PixQuerySearch;
	}

	/**
	 * Set default settings
	 */
	protected function get_default_settings() {
		return [
            'options' => [],
			'multiple' => false,
			'object_type' => 'post', // post, taxonomy, attachment, author
			'query' => [],
			'select2options' => [],
		];
	}

	/**
	 * Get control default value.
	 */
	public function get_default_value() {
		$settings = $this->get_settings();
		if (!empty($settings['multiple'])) {
			return [];
		}
		return '';
	}

	/**
	 * Get value for control.
	 */
	public function get_value($control, $settings) {
		$value = parent::get_value($control, $settings);
		
		// Ensure multiple selection returns array
		if (!empty($control['multiple'])) {
			if (empty($value)) {
				return [];
			}
			if (!is_array($value)) {
				return [$value];
			}
		}
		
		return $value;
	}

    public function enqueue() {
		$search_nonce = wp_create_nonce("pixfort_query_search_nonce");
		$search_ajax_link = admin_url('admin-ajax.php?action=pixfort_query_search&nonce=' . $search_nonce);
        
        wp_enqueue_script(
            'pixfort-query-search-control', 
            PIX_CORE_PLUGIN_URI . 'functions/elementor/includes/js/query-search-control.js', 
            array('jquery'), 
            PIXFORT_PLUGIN_VERSION,
            true
        );
        
        wp_localize_script('pixfort-query-search-control', 'PIX_QUERY_SEARCH_VALUES', array(
			'searchLink' => $search_ajax_link
        ));
	}

	/**
	 * Render control output in the editor.
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<# if ( data.label ) {#>
				<label for="<?php $this->print_control_uid(); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<# } #>
			<div class="elementor-control-input-wrapper elementor-control-unit-5">
				<# 
				var controlValue = data.controlValue;
				var valueAttr = '';
				if ( Array.isArray( controlValue ) ) {
					valueAttr = JSON.stringify( controlValue );
				} else if ( controlValue ) {
					valueAttr = controlValue;
				}
				#>
				<select 
					id="<?php echo esc_attr($control_uid); ?>" 
					class="pixfort-query-search-select2 elementor-select2" 
					type="select2" 
					data-value="{{ valueAttr }}" 
					data-setting="{{ data.name }}"
					data-object-type="{{ data.object_type }}"
					data-multiple="{{ data.multiple ? 'true' : 'false' }}"
					data-query="{{ JSON.stringify( data.query ) }}"
					<# if ( data.multiple ) { #>multiple<# } #>>
				</select>
			</div>
		</div>
		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

}

