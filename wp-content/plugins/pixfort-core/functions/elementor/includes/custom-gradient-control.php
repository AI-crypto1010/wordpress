<?php

namespace Elementor\CustomControl;

use \Elementor\Base_Data_Control;

class CustomGradient_Control extends Base_Data_Control {


    public function includes() {
    }

    const CustomGradient = 'pix_gradient_selector';

    /**
     * Set control type.
     */
    public function get_type() {
        return self::CustomGradient;
    }

    /**
     * Enqueue control scripts and styles.
     */
    public function enqueue() {

        wp_enqueue_script('spectrum-picker', PIX_CORE_PLUGIN_URI . 'functions/js/params/spectrum.min.js', ['jquery'], PIXFORT_PLUGIN_VERSION, true);
        wp_enqueue_script('pixfort-gradien-picker', PIX_CORE_PLUGIN_URI . 'functions/js/params/grapick.min.js', ['jquery'], PIXFORT_PLUGIN_VERSION, true);
        wp_enqueue_style('spectrum-picker', PIX_CORE_PLUGIN_URI . '/functions/js/params/spectrum.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');
        wp_enqueue_style('pix-gradient-picker', PIX_CORE_PLUGIN_URI . '/functions/js/params/grapick.min.css', false, PIXFORT_PLUGIN_VERSION, 'all');

        wp_enqueue_script('pixfort-elementor-gradient-selector', PIX_CORE_PLUGIN_URI . 'functions/elementor/includes/js/gradient.js', ['jquery', 'elementor-editor'], PIXFORT_PLUGIN_VERSION, true);
    }

    /**
     * Set default settings
     */
    protected function get_default_settings() {
        return [
            'label_block' => true,
            'toggle' => true,
            'options' => [],
            'render_type' => 'ui',
        ];
    }

    /**
     * control field markup
     */
    public function content_template() {


        $control_uid = $this->get_control_uid();
?>
        <div class="elementor-control-content">
        <div class="elementor-control-field elementor-gradient-control-field {{ data.class }}">
            <div class="pix-gradient-label">
                <label class="elementor-control-title">{{{ data.label }}}</label>
            </div>
            <div class="elementor-control-pix-gradient-wrapper">
                <div>
                    <div class="pix-gradient-picker-container">
                        <div class="pix-gradient-picker-el"></div>
                        <div class="inputs">
                            <select class="form-control switch-type">
                                <option value="">- Select Type -</option>
                                <option value="radial">Radial</option>
                                <option value="linear">Linear</option>
                                <option value="repeating-radial">Repeating Radial</option>
                                <option value="repeating-linear">Repeating Linear</option>
                            </select>

                            <select class="form-control switch-angle">
                                <option value="">- Select Direction -</option>
                                <option value="top">Top</option>
                                <option value="right">Right</option>
                                <option value="center">Center</option>
                                <option value="bottom">Bottom</option>
                                <option value="left">Left</option>
                                <option value="45deg">Top Right</option>
                                <option value="135deg">Bottom Right</option>
                            </select>
                        </div>
                        <div class="pix-gradient-picker-label"><?php echo esc_attr__('Preview', 'pixfort-core'); ?>:</div>
                        <div class="pix-gradient-picker-preview-container">
                            <div class="pix-gradient-picker-preview"></div>
                        </div>
                    </div>
                    <div class="pix-gradient-picker-label pix-label-margin"><?php echo esc_attr__('Gradient CSS output', 'pixfort-core'); ?>:</div>
                    <input class="pix_param_val" id="<?php echo $control_uid; ?>" type="text" name="elementor-gradient-selector-{{ data.name }}-{{ data._cid }}" data-setting="{{ data.name }}">
                </div>
            </div>
        </div>
        </div>
        <# if ( data.description ) { #>
            <div class="elementor-control-field-description">{{{ data.description }}}</div>
            <# } #>
        <?php
    }
}
