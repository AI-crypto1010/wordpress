<?php




function pix_elementor_templates_tabs(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/tabs/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'About Tabs Numbers', 'categories' => ['tabs', 'numbers', 'content']],
        ['demo_name' => 'Consulting', 'title' => 'Home Tabs', 'categories' => ['tabs', 'content', 'features']],

        ['demo_name' => 'Growth', 'title' => 'Careers Tabs CTA', 'categories' => ['tabs', 'cta', 'content']],
        ['demo_name' => 'Growth', 'title' => 'Home Tabs', 'categories' => ['tabs', 'content', 'features']],
        ['demo_name' => 'Growth', 'title' => 'Services Tabs CTA', 'categories' => ['tabs', 'cta', 'content']],

        ['demo_name' => 'Partners', 'title' => 'About Content Tabs Awards', 'categories' => ['tabs', 'content', 'miscellaneous']],
        ['demo_name' => 'Partners', 'title' => 'Home Tabs Content', 'categories' => ['tabs', 'content']],

        ['demo_name' => 'Prime', 'title' => 'Tabs', 'categories' => ['tabs', 'content']],

        ['demo_name' => 'Trust', 'title' => 'Home Tabs Numbers Features', 'categories' => ['tabs', 'numbers', 'features']],

        ['demo_name' => 'RTL', 'title' => 'Home Tabs', 'categories' => ['tabs', 'content', 'features']],
        ['demo_name' => 'RTL', 'title' => 'Careers Tabs CTA', 'categories' => ['tabs', 'cta', 'content']],
        ['demo_name' => 'RTL', 'title' => 'Services Tabs CTA', 'categories' => ['tabs', 'cta', 'content']],

    ];

    return pix_generate_templates($templatesList, 'tabs', $thumbPath);
}




 ?>
