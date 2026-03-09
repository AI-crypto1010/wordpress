<?php

require_once get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'pixfort_register_required_plugins');

/**
 * Register the required plugins for this theme.
 */
function pixfort_register_required_plugins() {
	$plugins = array(

		array(
			'name'               => 'pixfort core',
			'slug'               => 'pixfort-core',
			'source'             => get_template_directory() . '/inc/tgm/plugins/pixfort-core.zip',
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => PIXFORT_CORE_PLUGIN_VERSION,
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
			'pix_recommended'        => true,
			'pix_dashboard'        => true,
		),
		array(
			'name' => 'Contact Form 7',
			'slug' => 'contact-form-7',
			'required' => false,
			'pix_dashboard'        => true,
			'pix_recommended'        => true,
		),
		array(
			'name' => 'WooCommerce',
			'slug' => 'woocommerce',
			'required' => false,
			'pix_dashboard'        => true,
			'pix_recommended'        => false,
		),
		array(
			'name'               => 'PixFort Likes',
			'slug'               => 'pixfort-likes',
			'source'             => get_template_directory() . '/inc/tgm/plugins/pixfort-likes.zip',
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '1.0.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
			'pix_recommended'        => true,
			'pix_dashboard'        => true,
		),
		array(
			'name' => 'Elementor',
			'slug' => 'elementor',
			'required' => false,
			'pix_dashboard'        => true,
		)
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'conseil',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa($plugins, $config);
}
