<?php



function pix_elementor_templates_footers(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/footers/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'Footer', 'categories' => ['footers']],

        ['demo_name' => 'Digital Agency', 'title' => 'Footer', 'categories' => ['footers']],

        ['demo_name' => 'Advisory', 'title' => 'Footer', 'categories' => ['footers']],

        ['demo_name' => 'Growth', 'title' => 'Footer', 'categories' => ['footers']],

        ['demo_name' => 'Vision', 'title' => 'Footer', 'categories' => ['footers']],

        ['demo_name' => 'Partners', 'title' => 'Footer', 'categories' => ['footers']],

        ['demo_name' => 'Prime', 'title' => 'Footer', 'categories' => ['footers']],

        ['demo_name' => 'Trust', 'title' => 'Footer', 'categories' => ['footers']],

        ['demo_name' => 'RTL', 'title' => 'Footer', 'categories' => ['footers']],

        ['demo_name' => 'App', 'title' => 'Footer Marquee Links', 'categories' => ['footers', 'marquee', 'links']],

        ['demo_name' => 'SaaS', 'title' => 'Footer', 'categories' => ['footers']],

    ];

    return pix_generate_templates($templatesList, 'footers', $thumbPath);
}




 ?>
