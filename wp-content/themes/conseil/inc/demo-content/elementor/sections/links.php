<?php



function pix_elementor_templates_links(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/links/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'Contact Social Links', 'categories' => ['links', 'contact']],

        ['demo_name' => 'Digital Agency', 'title' => 'Coming Soon Social Links', 'categories' => ['links']],
        ['demo_name' => 'Digital Agency', 'title' => 'Contact Social Links', 'categories' => ['links', 'contact']],

        ['demo_name' => 'Advisory', 'title' => 'Coming Soon Social Links', 'categories' => ['links', 'miscellaneous']],

        ['demo_name' => 'Growth', 'title' => 'Coming Soon Social Links Marquee Vertical', 'categories' => ['links', 'marquee']],

        ['demo_name' => 'Vision', 'title' => 'Help Center Content Articles Links', 'categories' => ['links']],
        ['demo_name' => 'Vision', 'title' => 'Quick Links', 'categories' => ['links']],

        ['demo_name' => 'Trust', 'title' => 'Contact Social Links', 'categories' => ['links', 'contact']],

        ['demo_name' => 'RTL', 'title' => 'Coming Soon Social Links Marquee Vertical', 'categories' => ['links', 'marquee']],

        ['demo_name' => 'SaaS', 'title' => 'Links Boxes', 'categories' => ['links', 'miscellaneous']],
        ['demo_name' => 'SaaS', 'title' => 'Help Center Links', 'categories' => ['links', 'miscellaneous']],

    ];

    return pix_generate_templates($templatesList, 'links', $thumbPath);
}




 ?>
