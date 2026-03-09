<?php
/**
 * Server-side rendering of the `pixfort-core/pix-promo-box` block.
 *
 * @package PixFortCore
 */

/**
 * Renders the `pixfort-core/pix-promo-box` block on the server.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @return string Returns the promo box with the content.
 */
// function render_block_pixfort_core_promo_box($attributes, $content) {
    $bg_img = !empty($attributes['bg_img']) ? $attributes['bg_img'] : 0;
    
    
    
    // Validate that the bg_img is a valid attachment ID if numeric
    if (is_numeric($bg_img)) {
        // Check if the attachment exists in the media library
        $attachment_url = wp_get_attachment_url($bg_img);
        if (!$attachment_url) {
            // Attachment doesn't exist, fallback to empty string
            $bg_img = '';
        }
    }

    // Check for URL fallback for backward compatibility
    if (empty($bg_img) || $bg_img == 0) {
        $bg_img = isset($attributes['bg_img_url']) ? $attributes['bg_img_url'] : '';
    }
    
    $badge = isset($attributes['badge']) ? $attributes['badge'] : '';
    $heading = isset($attributes['heading']) ? $attributes['heading'] : '';
    $link_text = isset($attributes['link_text']) ? $attributes['link_text'] : __('Check it out', 'pixfort-core');
    $link = isset($attributes['link']) ? $attributes['link'] : '#';
    $blank = isset($attributes['blank']) ? $attributes['blank'] : '';
    
    // Pass the image ID directly to the PromoBox element
    $attrs = array(
        'image'  => $bg_img,
        'link_text'  => $link_text,
        'title'  => $heading,
        'link'     => $link,
        'target'     => $blank,
        'badge'     => $badge,
        'rounded_img'  => 'rounded-xl',
        'title_size'        => 'h4',
        'animation'     => 'fade-in',
        'delay'     => '200',
        'overlay_color'     => 'gray-9',
        'height'     => '350px',
        'badge_text_color'     => 'light-opacity-5',
        'badge_bg_color'     => 'dark-opacity-5',
        'custom_css'    => 'padding:5px 10px;margin-right:3px;line-height:12px;',
    );
    $output = \PixFortCore::instance()->elementsManager->renderElement('PromoBox', $attrs);
    echo $output;
    // return $output;
// }