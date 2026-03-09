<?php

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Registers all custom blocks for the theme.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function pixfort_core_register_blocks() {
    // Register simple blocks with default settings
    register_block_type(__DIR__ . '/search');
    register_block_type(__DIR__ . '/recent-posts');
    register_block_type(__DIR__ . '/promo-box');
    register_block_type(__DIR__ . '/categories');
    // Register the Social Links block
    register_block_type(__DIR__ . '/social', [
        'attributes' => [
            'title' => [
                'type' => 'string',
                'default' => 'Follow Us'
            ],
            'social' => [
                'type' => 'object',
                'default' => (object) []
            ]
        ]
    ]);
}
add_action('init', 'pixfort_core_register_blocks');

