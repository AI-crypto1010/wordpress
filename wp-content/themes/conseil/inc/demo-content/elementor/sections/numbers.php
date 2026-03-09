<?php



function pix_elementor_templates_numbers(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/numbers/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'Features Numbers', 'categories' => ['numbers', 'content']],
        ['demo_name' => 'Consulting', 'title' => 'Services Numbers', 'categories' => ['numbers', 'content']],

        ['demo_name' => 'Digital Agency', 'title' => 'Showcase Content Numbers', 'categories' => ['numbers', 'content']],

        ['demo_name' => 'Partners', 'title' => 'About Numbers Features', 'categories' => ['numbers', 'features']],
        ['demo_name' => 'Partners', 'title' => 'Careers Numbers Features CTA', 'categories' => ['numbers', 'features', 'cta']],

    ];

    return pix_generate_templates($templatesList, 'numbers', $thumbPath);
}




 ?>
