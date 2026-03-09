<?php



function pix_elementor_templates_accordion(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/accordion/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'Pricing Accordion FAQ', 'categories' => ['accordion', 'faq']],

        ['demo_name' => 'Advisory', 'title' => 'Pricing Accordion FAQ', 'categories' => ['accordion', 'faq']],

        ['demo_name' => 'Growth', 'title' => 'Home Accordion FAQ', 'categories' => ['accordion', 'faq']],
        ['demo_name' => 'Growth', 'title' => 'Features Accordion FAQ', 'categories' => ['accordion', 'faq']],
        ['demo_name' => 'Growth', 'title' => 'Pricing Accordion FAQ', 'categories' => ['accordion', 'faq']],

        ['demo_name' => 'Vision', 'title' => 'Pricing Accordion FAQ', 'categories' => ['accordion', 'faq']],

        ['demo_name' => 'RTL', 'title' => 'Home Accordion FAQ', 'categories' => ['accordion', 'faq']],
        ['demo_name' => 'RTL', 'title' => 'Features Accordion FAQ', 'categories' => ['accordion', 'faq']],
        ['demo_name' => 'RTL', 'title' => 'Pricing Accordion FAQ', 'categories' => ['accordion', 'faq']],

        ['demo_name' => 'App', 'title' => 'Home FAQ Accordion', 'categories' => ['accordion', 'faq']],

        ['demo_name' => 'SaaS', 'title' => 'Pricing FAQ Accordion', 'categories' => ['accordion', 'faq', 'pricing']],

    ];

    return pix_generate_templates($templatesList, 'accordion', $thumbPath);
}




 ?>
