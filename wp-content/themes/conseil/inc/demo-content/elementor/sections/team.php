<?php



function pix_elementor_templates_team(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/team/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'About Team Members', 'categories' => ['team']],

        ['demo_name' => 'Digital Agency', 'title' => 'About Team Members', 'categories' => ['team']],

        ['demo_name' => 'Advisory', 'title' => 'About Team Members', 'categories' => ['team']],

        ['demo_name' => 'Growth', 'title' => 'About Team Members', 'categories' => ['team']],

        ['demo_name' => 'Partners', 'title' => 'About Team Members', 'categories' => ['team']],

        ['demo_name' => 'RTL', 'title' => 'About Team Members', 'categories' => ['team']],

    ];

    return pix_generate_templates($templatesList, 'team', $thumbPath);
}




 ?>
