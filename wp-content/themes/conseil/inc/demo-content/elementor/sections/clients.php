<?php



function pix_elementor_templates_clients(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/clients/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'Home Clients', 'categories' => ['clients']],

        ['demo_name' => 'Digital Agency', 'title' => 'Home Clients', 'categories' => ['clients']],

        ['demo_name' => 'Growth', 'title' => 'Home Clients', 'categories' => ['clients']],
        ['demo_name' => 'Growth', 'title' => 'Features Clients', 'categories' => ['clients']],
        ['demo_name' => 'Growth', 'title' => 'Reviews Clients', 'categories' => ['clients']],

        ['demo_name' => 'Prime', 'title' => 'Clients Numbers Rating', 'categories' => ['clients', 'numbers']],

        ['demo_name' => 'RTL', 'title' => 'Home Clients', 'categories' => ['clients']],
        ['demo_name' => 'RTL', 'title' => 'Features Clients', 'categories' => ['clients']],
        ['demo_name' => 'RTL', 'title' => 'Reviews Clients', 'categories' => ['clients']],

        ['demo_name' => 'App', 'title' => 'Home Content Rating Circles Clients', 'categories' => ['clients', 'reviews']],

    ];

    return pix_generate_templates($templatesList, 'clients', $thumbPath);
}




 ?>
