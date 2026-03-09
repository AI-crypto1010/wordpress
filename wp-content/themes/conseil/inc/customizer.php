<?php
/**
 * conseil Theme Customizer
 *
 * @package pixfort theme
 */

/**
 * Remove the default Colors section from the WordPress Customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function pixfort_customize_register( $wp_customize ) {
	// Remove the default Colors section
	$wp_customize->remove_section( 'colors' );

	// Remove the default Header Image section
	$wp_customize->remove_section( 'header_image' );

	// Remove the default Background Image section
	$wp_customize->remove_section( 'background_image' );
}
add_action( 'customize_register', 'pixfort_customize_register' );