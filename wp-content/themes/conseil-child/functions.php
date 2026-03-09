<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'conseil-parent-style', get_template_directory_uri().'/style.css', [], wp_get_theme( get_template() )->get('Version') );
   wp_enqueue_style('conseil-child-style', get_stylesheet_uri(), [ 'conseil-parent-style' ], wp_get_theme()->get('Version'));
}
