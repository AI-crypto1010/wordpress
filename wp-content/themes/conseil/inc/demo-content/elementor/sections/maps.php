<?php

function pix_elementor_templates_maps(){

    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/maps/';
    
    $templatesList = [

        ['demo_name' => 'Digital Agency', 'title' => 'Contact Address Map', 'categories' => ['maps', 'contact']],

    ];

    return pix_generate_templates($templatesList, 'maps', $thumbPath);
}




 ?>
