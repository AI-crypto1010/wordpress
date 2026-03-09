<?php

namespace Elementor\CustomControl;

use \Elementor\Base_Data_Control;

/**
 * oixfort Template control.
 *
 * A control for displaying a select field with the ability to choose a template.
 *
 * @since 1.0.0
 */
class Pix_Template_Control extends Base_Data_Control {

    const PixTemplateSelector = 'pix_template_selector';

	/**
	 * Set control type.
	 */
	public function get_type() {
		return self::PixTemplateSelector;
	}



	/**
	 * Set default settings
	 */
	protected function get_default_settings() {

        $results = [];
        
        $results[] = esc_html__( 'Choose Template', 'pixfort-core' );

		$posts = get_posts( array(
			'posts_per_page'	=> -1,
			'post_type'	=> 'elementor_library'
		) );

		foreach ( $posts as $post ) {
			$document = \Elementor\plugin::instance()->documents->get( $post->ID );
			if ( $document ) {
				$text = esc_html( $post->post_title ) . ' (' . $document->get_post_type_title() . ')';
				$results[$post->ID] = $text;
				$resultsURLs[$post->ID] = $document->get_edit_url();
			}
		}

		return [
            // 'options' => $results,
            'options' => [],
			'multiple' => false,
			// Select2 library options
			'select2options' => [],
			// the lockedOptions array can be passed option keys. The passed option keys will be non-deletable.
			'lockedOptions' => [],
		];
	}

	/**
	 * Get currency control default value.
	 *
	 * Retrieve the default value of the currency control. Used to return the
	 * default value while initializing the control.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Currency control default value.
	 */
	public function get_default_value() {
		return '';
	}

    public function enqueue() {
        $resultsURLs = [];
        
        // Get Elementor library templates
        $posts = get_posts( array(
			'posts_per_page'	=> -1,
			'post_type'	=> 'elementor_library'
		) );

		foreach ( $posts as $post ) {
			$document = \Elementor\plugin::instance()->documents->get( $post->ID );
			if ( $document ) {
				$text = esc_html( $post->post_title ) . ' (' . $document->get_post_type_title() . ')';
				$resultsURLs[$post->ID] = $document->get_edit_url();
			}
		}
		
		// Get pixfort_template templates with 'template' type
		$pixfort_templates = get_posts( array(
			'posts_per_page'	=> -1,
			'post_type'	=> 'pixfort_template',
			'tax_query' => array(
				array(
					'taxonomy' => 'pixfort_template_type',
					'field' => 'slug',
					'terms' => 'template',
				),
			),
		) );
		
		foreach ( $pixfort_templates as $post ) {
			$document = \Elementor\plugin::instance()->documents->get( $post->ID );
			if ( $document ) {
				$resultsURLs[$post->ID] = $document->get_edit_url();
			}
		}
		
		$templates_nonce = wp_create_nonce("templates_nonce");
		$templates_ajax_link = admin_url('admin-ajax.php?action=pix_get_templates_list&nonce=' . $templates_nonce);
        wp_enqueue_script('pixfort-elementor-template-selector', PIX_CORE_PLUGIN_URI . 'functions/elementor/includes/js/template-selector.js', array('jquery'), PLUGIN_VERSION, true);
        wp_localize_script( 'pixfort-elementor-template-selector', 'PIX_TEMPLATE_SELECTOR_VALUES', array(
            'resultsURLs' => $resultsURLs,
			'templatesLink'	=> $templates_ajax_link
        ));
	}

	/**
	 * Render currency control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
        // get_edit_url
		?>
		<div class="elementor-control-field">
			<# if ( data.label ) {#>
				<label for="<?php $this->print_control_uid(); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<# } #>
			<div class="elementor-control-input-wrapper elementor-control-unit-5">
			<input class="pix_param_val" id="<?php echo $control_uid; ?>" type="hidden" name="elementor-template-selector-{{ data.name }}-{{ data._cid }}" data-setting="{{ data.name }}">
				<# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
				<select oldid="<?php $this->print_control_uid(); ?>" class="pixfort-elementor-select2 elementor-select2" type="select2" data-value="{{ data.controlValue }}" data-setting="{{ data.name }}">
					<# if ( data.groups ) { #>
						<#
						var value = data.controlValue;
						var defaultSelected = ( ! value || value === '' ) ? 'selected' : '';
						#>
						<option {{ defaultSelected }} value=""><?php echo esc_html__( 'Choose Template', 'pixfort-core' ); ?></option>
						<# _.each( data.groups, function( group, group_key ) {
							var group_label = group.label || '';
							var group_options = group.options || {};
							// Filter out any "Choose Template" options that might be in the data
							var filtered_options = {};
							_.each( group_options, function( option_title, option_value ) {
								if ( option_value !== '' && option_value !== 0 ) {
									filtered_options[option_value] = option_title;
								}
							});
							var hasOptions = ! _.isEmpty( filtered_options );
							#>
							<# if ( hasOptions ) { #>
								<optgroup label="{{{ group_label }}}">
									<# _.each( filtered_options, function( option_title, option_value ) {
										var value = data.controlValue;
										if ( typeof value == 'string' ) {
											var selected = ( option_value === value ) ? 'selected' : '';
										} else if ( null !== value ) {
											var value = _.values( value );
											var selected = ( -1 !== value.indexOf( option_value ) ) ? 'selected' : '';
										}
										#>
									<option {{ selected }} value="{{ option_value }}">{{{ option_title }}}</option>
									<# } ); #>
								</optgroup>
							<# } #>
						<# } ); #>
					<# } else { #>
						<# _.each( data.options, function( option_title, option_value ) {
							var value = data.controlValue;
							if ( typeof value == 'string' ) {
								var selected = ( option_value === value ) ? 'selected' : '';
							} else if ( null !== value ) {
								var value = _.values( value );
								var selected = ( -1 !== value.indexOf( option_value ) ) ? 'selected' : '';
							}
							#>
						<option {{ selected }} value="{{ option_value }}">{{{ option_title }}}</option>
						<# } ); #>
					<# } #>
				</select>
                
			</div>
		</div>
        <div class="elementor-control-field pix-template-edit-area"></div>
        <# if ( data.controlValue && data.controlValue!='' ) { #>
        <div class="elementor-control-field">
            <# _.each( data.urls, function(  url, tID ) {
						var value = data.controlValue;
                        if(tID===value){
						#>
                        <a
                            target="_blank"
                            class="elementor-button elementor-button-default pix-edit-template"
                            href="{{ url }}"
                        >
                            <i class="eicon-pencil"></i> {{{value}}} <?php echo esc_html__( 'Edit Template', 'pixfort-core' ); ?>
                        </a>
            <# }  } ); #>
            
        </div>
        <# } #>
		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

}