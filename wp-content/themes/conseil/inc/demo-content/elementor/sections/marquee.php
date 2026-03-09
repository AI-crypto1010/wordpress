<?php


function pix_elementor_templates_marquee(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/marquee/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'About Clients Marquee', 'categories' => ['marquee', 'clients']],
        ['demo_name' => 'Consulting', 'title' => 'Case Studies Clients Marquee', 'categories' => ['marquee', 'clients']],
        ['demo_name' => 'Consulting', 'title' => 'Features Clients Marquee', 'categories' => ['marquee', 'clients']],

        ['demo_name' => 'Digital Agency', 'title' => 'Home Marquee CTA', 'categories' => ['marquee', 'cta']],

        ['demo_name' => 'Advisory', 'title' => 'Careers Marquee', 'categories' => ['marquee', 'content']],

        ['demo_name' => 'Growth', 'title' => 'Careers Marquee', 'categories' => ['marquee', 'content']],

        ['demo_name' => 'Partners', 'title' => 'About Marquee Features', 'categories' => ['marquee', 'features']],
        ['demo_name' => 'Partners', 'title' => 'Services Marquee Features', 'categories' => ['marquee', 'features']],

        ['demo_name' => 'Prime', 'title' => 'Marquee', 'categories' => ['marquee']],

        ['demo_name' => 'RTL', 'title' => 'Careers Marquee', 'categories' => ['marquee', 'content']],

        ['demo_name' => 'SaaS', 'title' => 'Home Marquee', 'categories' => ['marquee', 'content']],
        ['demo_name' => 'SaaS', 'title' => 'Product Marquee', 'categories' => ['marquee', 'content']],

    ];

    return pix_generate_templates($templatesList, 'marquee', $thumbPath);
}

 ?>
