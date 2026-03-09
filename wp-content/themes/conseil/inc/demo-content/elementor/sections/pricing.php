<?php



function pix_elementor_templates_pricing(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/pricing/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'Pricing Comparison Table', 'categories' => ['pricing', 'miscellaneous']],
        ['demo_name' => 'Consulting', 'title' => 'Pricing Tables', 'categories' => ['pricing']],

        ['demo_name' => 'Digital Agency', 'title' => 'Pricing Comparison Tables', 'categories' => ['pricing', 'miscellaneous']],

        ['demo_name' => 'Advisory', 'title' => 'Pricing Comparison Table', 'categories' => ['pricing', 'miscellaneous']],

        ['demo_name' => 'Growth', 'title' => 'Home Pricing Tables', 'categories' => ['pricing']],
        ['demo_name' => 'Growth', 'title' => 'Pricing Comparison Table', 'categories' => ['pricing', 'miscellaneous']],

        ['demo_name' => 'Vision', 'title' => 'Home Pricing Tables', 'categories' => ['pricing']],
        ['demo_name' => 'Vision', 'title' => 'Pricing Comparison Table', 'categories' => ['pricing', 'miscellaneous']],

        ['demo_name' => 'Partners', 'title' => 'Home Pricing Tables Awards', 'categories' => ['pricing']],
        ['demo_name' => 'Partners', 'title' => 'Pricing Comparison Table', 'categories' => ['pricing', 'miscellaneous']],

        ['demo_name' => 'Prime', 'title' => 'Pricing Clients', 'categories' => ['pricing', 'clients']],

        ['demo_name' => 'RTL', 'title' => 'Home Pricing Tables', 'categories' => ['pricing']],
        ['demo_name' => 'RTL', 'title' => 'Pricing Comparison Table', 'categories' => ['pricing', 'miscellaneous']],

        ['demo_name' => 'App', 'title' => 'Home Pricing Tables', 'categories' => ['pricing']],

        ['demo_name' => 'SaaS', 'title' => 'Pricing Comparison Table', 'categories' => ['pricing', 'miscellaneous', 'content']],

    ];

    return pix_generate_templates($templatesList, 'pricing', $thumbPath);
}




 ?>
