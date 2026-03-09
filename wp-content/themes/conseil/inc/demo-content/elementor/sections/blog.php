<?php



function pix_elementor_templates_blog() {
    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/blog/';

    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'Home Blog', 'categories' => ['blog']],

        ['demo_name' => 'Digital Agency', 'title' => 'Home Blog Carousel', 'categories' => ['blog']],

        ['demo_name' => 'Advisory', 'title' => 'Home Blog Carousel', 'categories' => ['blog']],

        ['demo_name' => 'Vision', 'title' => 'Help Center Blog Carousel', 'categories' => ['blog']],
        ['demo_name' => 'Vision', 'title' => 'Home Blog Carousel', 'categories' => ['blog']],

        ['demo_name' => 'Partners', 'title' => 'Home Blog', 'categories' => ['blog']],

        ['demo_name' => 'Trust', 'title' => 'Home Blog', 'categories' => ['blog']],

        ['demo_name' => 'SaaS', 'title' => 'Help Center Blog Posts Carousel', 'categories' => ['blog']],
        ['demo_name' => 'SaaS', 'title' => 'Home Blog', 'categories' => ['blog']],

    ];

    return pix_generate_templates($templatesList, 'blog', $thumbPath);
}
