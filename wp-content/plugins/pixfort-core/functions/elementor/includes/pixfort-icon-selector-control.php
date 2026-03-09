<?php

namespace Elementor\CustomControl;

use \Elementor\Base_Data_Control;

class PixfortIconSelector_Control extends Base_Data_Control {

	public $isPixfortIcons = true;

	public function __construct() {
		parent::__construct();

	}

	public function includes() {
	}

	const PixfortIconSelector = 'pixfort_icon_selector';

	/**
	 * Set control type.
	 */
	public function get_type() {
		return self::PixfortIconSelector;
	}

	/**
	 * Enqueue control scripts and styles.
	 */
	public function enqueue() {
		$customIcons = [];
		$customIcons = apply_filters( 'pixfort_custom_font_icons', $customIcons );
		wp_enqueue_script('pixfort-icons-elementor-selector', PIX_CORE_PLUGIN_URI . 'dist/main/elementor/main-icons-selector.js', ['jquery', 'elementor-editor'], PIXFORT_PLUGIN_VERSION, true);
		wp_localize_script('pixfort-icons-elementor-selector', 'pixfort_icons_obj', array(
			'ADMIN_LINK' => add_query_arg(array(
				'action' => 'pix_icons_data',
				'nonce' => wp_create_nonce('pix_icons_data')
			), admin_url('admin-ajax.php')),
			'CUSTOM_ICONS' => $customIcons
		));
	}

	/**
	 * Set default settings
	 */
	protected function get_default_settings() {
		return [
			'value'   => '',
			'label_block' => true,
			'toggle' => true,
			'options' => [],
		];
	}

	/**
	 * control field markup
	 */
	public function content_template() {

		$control_uid = $this->get_control_uid('{{ value }}');
		
		
?>
		<div class="elementor-control-field elementor-due-icons">
			<label class="elementor-control-title">{{{ data.label }}}</label>

			<div class="pixfort-icons-selector-wrapper">
				<div class="pixfort-icons-filter">
					<a href="#" data-type="line" class="pixfort-icons-filter-tab is-selected">
						<?php if (!$this->isPixfortIcons) { ?>
							<i class="pixicon-lightning-2"></i>
							Fonticon
						<?php } else { ?>
							<svg class="pixfort-tab-icon" width="24" height="24" viewBox="2 2 20 20"><path fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="var(--pf-icon-stroke-width)" d="M16.7777778,5 L11.3333333,13.5555556 L15.2222222,13.5555556 L15.2222222,19 L20.6666667,10.4444444 L16.7777778,10.4444444 L16.7777778,5 Z M11,7 L5,7 M8,12 L3,12 M11,17 L5,17"></path></svg>
							Line
						<?php } ?>
					</a>
					<a href="#" data-type="duotone" class="pixfort-icons-filter-tab">

						<svg class="pixfort-tab-icon" width="24" height="24" viewBox="2 2 20 20">
							<g fill="none" fill-rule="evenodd">
								<path fill="currentcolor" fill-opacity=".25" d="M11,6 C11.5522847,6 12,6.44771525 12,7 C12,7.55228475 11.5522847,8 11,8 L5,8 C4.44771525,8 4,7.55228475 4,7 C4,6.44771525 4.44771525,6 5,6 L11,6 Z M8,11 C8.55228475,11 9,11.4477153 9,12 C9,12.5522847 8.55228475,13 8,13 L3,13 C2.44771525,13 2,12.5522847 2,12 C2,11.4477153 2.44771525,11 3,11 L8,11 Z M11,16 C11.5522847,16 12,16.4477153 12,17 C12,17.5522847 11.5522847,18 11,18 L5,18 C4.44771525,18 4,17.5522847 4,17 C4,16.4477153 4.44771525,16 5,16 L11,16 Z"></path>
								<path fill="currentcolor" d="M16.1759581,4.43347118 L10.6759581,12.4334712 L10.6170624,12.5297632 C10.2657894,13.1809277 10.7331624,14 11.5,14 L13.999,14 L14,19 C14,19.9713329 15.2451104,20.3723733 15.8120154,19.583636 L21.5620154,11.583636 L21.6235586,11.487482 C21.9917133,10.8363437 21.5259261,10 20.75,10 L17.999,10 L18,5 C18,4.01795609 16.7323143,3.62422582 16.1759581,4.43347118 Z"></path>
							</g>
						</svg>
						Duotone
					</a>
                    <a href="#" data-type="solid" class="pixfort-icons-filter-tab">

						<svg class="pixfort-tab-icon" width="24" height="24" viewBox="2 2 20 20">
							<g  stroke="none" stroke-width="2" fill="none" fill-rule="evenodd"><path d="M18,5 L17.999,10 L20.75,10 C21.5259261,10 21.9917133,10.8363437 21.6235586,11.487482 L21.5620154,11.583636 L15.8120154,19.583636 C15.2451104,20.3723733 14,19.9713329 14,19 L13.999,14 L11.5,14 C10.7331624,14 10.2657894,13.1809277 10.6170624,12.5297632 L10.6759581,12.4334712 L16.1759581,4.43347118 C16.7323143,3.62422582 18,4.01795609 18,5 Z M11,16 C11.5522847,16 12,16.4477153 12,17 C12,17.5522847 11.5522847,18 11,18 L5,18 C4.44771525,18 4,17.5522847 4,17 C4,16.4477153 4.44771525,16 5,16 L11,16 Z M8,11 C8.55228475,11 9,11.4477153 9,12 C9,12.5522847 8.55228475,13 8,13 L3,13 C2.44771525,13 2,12.5522847 2,12 C2,11.4477153 2.44771525,11 3,11 L8,11 Z M11,6 C11.5522847,6 12,6.44771525 12,7 C12,7.55228475 11.5522847,8 11,8 L5,8 C4.44771525,8 4,7.55228475 4,7 C4,6.44771525 4.44771525,6 5,6 L11,6 Z"  fill="currentcolor"></path></g>
						</svg>
						Solid
					</a>
				</div>
				<input type="text" class="pixfort-selector-search" placeholder="Search..." />
				<div class="pixfort-icons-selector-icons">
					<?php
					if (!$this->isPixfortIcons) {
						foreach ($pixicons as $key) {
					?>
							<i class="icon-item type-hidden type-line <?php echo array_keys($key)[0]; ?>" data-id="<?php echo array_keys($key)[0]; ?>" data-name="<?php echo array_keys($key)[0]; ?>"></i>
						<?php }
						foreach ($due_opts as $icon) { ?>
							<img class="icon-item type-hidden type-duotone" data-id="<?php echo $icon['id']; ?>" data-name="<?php echo $icon['id']; ?>" loading="lazy" height="34" width="34" src="<?php echo $icon['url']; ?>" alt="<?php echo $icon['id']; ?>">
					<?php
						}
					}
					?>
				</div>
			</div>

			<div class="elementor-control-input-wrapper">
				<input type="text" id="<?php echo esc_attr($control_uid); ?>" class="elementor-control-icon-value" data-setting="{{ data.name }}" placeholder="{{ data.placeholder }}" value="{{ value }}" />
			</div>




		</div>
		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
			<# } #>
		<?php
	}
}
