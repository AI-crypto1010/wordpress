<?php




function pix_elementor_templates_heading(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/headings/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'Heading', 'categories' => ['headings']],

        ['demo_name' => 'Digital Agency', 'title' => 'Heading', 'categories' => ['headings']],
        ['demo_name' => 'Digital Agency', 'title' => 'Heading Circles CTA', 'categories' => ['headings', 'cta']],

        ['demo_name' => 'Advisory', 'title' => 'Heading CTA Rating', 'categories' => ['headings', 'cta']],
        ['demo_name' => 'Advisory', 'title' => 'Heading CTA', 'categories' => ['headings', 'cta']],
        ['demo_name' => 'Advisory', 'title' => 'Heading Horizontal Circles', 'categories' => ['headings']],
        ['demo_name' => 'Advisory', 'title' => 'Heading Horizontal CTA', 'categories' => ['headings', 'cta']],
        ['demo_name' => 'Advisory', 'title' => 'Heading Horizontal CTA 2', 'categories' => ['headings', 'cta']],
        ['demo_name' => 'Advisory', 'title' => 'Heading Text', 'categories' => ['headings']],

        ['demo_name' => 'Growth', 'title' => 'Heading', 'categories' => ['headings']],

        ['demo_name' => 'Vision', 'title' => 'Heading', 'categories' => ['headings']],

        ['demo_name' => 'Partners', 'title' => 'Heading', 'categories' => ['headings']],
        ['demo_name' => 'Partners', 'title' => 'Heading Center', 'categories' => ['headings']],
        ['demo_name' => 'Partners', 'title' => 'Heading CTA', 'categories' => ['headings', 'cta']],
        ['demo_name' => 'Partners', 'title' => 'Heading Features', 'categories' => ['headings', 'features']],
        ['demo_name' => 'Partners', 'title' => 'Heading Rating CTA', 'categories' => ['headings', 'cta']],

        ['demo_name' => 'RTL', 'title' => 'Heading', 'categories' => ['headings']],

        ['demo_name' => 'App', 'title' => 'Heading', 'categories' => ['headings']],

        ['demo_name' => 'SaaS', 'title' => 'Heading Circles', 'categories' => ['headings']],

    ];

    return pix_generate_templates($templatesList, 'headings', $thumbPath);
}




 ?>
