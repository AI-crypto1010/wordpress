<?php

/**
 * Server-side rendering of the Social Links block.
 */

/**
 * Renders the Social Links Block.
 *
 * @param array $attributes The block attributes.
 * @return string The block HTML.
 */
if (!function_exists('pixfort_core_render_social_links_block')) {
    function pixfort_core_render_social_links_block($attributes) {
        $social = isset($attributes['social']) ? $attributes['social'] : [];

        // Define available social networks with their icons and titles
        $available_social = [
            'facebook' => [
                'icon' => 'Solid/pixfort-icon-facebook-1',
                'title' => __('Facebook', 'pixfort-core')
            ],
            'twitter' => [
                'icon' => 'Solid/pixfort-icon-x-1',
                'title' => __('X', 'pixfort-core')
            ],
            'youtube' => [
                'icon' => 'Solid/pixfort-icon-youtube-1',
                'title' => __('YouTube', 'pixfort-core')
            ],
            'linkedin' => [
                'icon' => 'Solid/pixfort-icon-linkedin-2',
                'title' => __('LinkedIn', 'pixfort-core')
            ],
            'instagram' => [
                'icon' => 'Solid/pixfort-icon-instagram-1',
                'title' => __('Instagram', 'pixfort-core')
            ],
            'dribbble' => [
                'icon' => 'Solid/pixfort-icon-dribbble-1',
                'title' => __('Dribbble', 'pixfort-core')
            ],
            'snapchat' => [
                'icon' => 'Solid/pixfort-icon-snapchat-1',
                'title' => __('Snapchat', 'pixfort-core')
            ],
            'telegram' => [
                'icon' => 'Solid/pixfort-icon-telegram-1',
                'title' => __('Telegram', 'pixfort-core')
            ],
            'whatsapp' => [
                'icon' => 'Solid/pixfort-icon-whatsapp-1',
                'title' => __('WhatsApp', 'pixfort-core')
            ],
            'flipboard' => [
                'icon' => 'Solid/pixfort-icon-flipboard-1',
                'title' => __('Flipboard', 'pixfort-core')
            ],
            'vk' => [
                'icon' => 'Solid/pixfort-icon-vk-1',
                'title' => __('VK', 'pixfort-core')
            ],
            'behance' => [
                'icon' => 'Solid/pixfort-icon-behance-1',
                'title' => __('Behance', 'pixfort-core')
            ]
        ];

        $output = '<div class="pix-social_widget pix-py-10">';

        // Render each social link that has a value
        foreach ($available_social as $network => $value) {
            if (!empty($social[$network])) {
                $output .= '<a href="' . esc_url($social[$network]) . '" class="d-inline-block pix-base-background pix-mr-10 mb-2 shadow-sm fly-sm shadow-hover-sm text-body-default" title="' . esc_attr($value['title']) . '">';
                $output .= '<span class="d-flex h-100 align-items-center justify-content-center">';
                $output .= \PixfortCore::instance()->icons->getIcon($value['icon'], 24, '', '', true);
                $output .= '</span>';
                $output .= '</a>';
            }
        }

        $output .= '</div>';

        return $output;
    }
}
echo pixfort_core_render_social_links_block($attributes);
