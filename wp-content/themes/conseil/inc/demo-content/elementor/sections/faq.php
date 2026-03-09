<?php



function pix_elementor_templates_faq(){
    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/faq/';
    
    $templatesList = [

        ['demo_name' => 'Digital Agency', 'title' => 'Pricing FAQ', 'categories' => ['faq']],

    ];

    return pix_generate_templates($templatesList, 'faq', $thumbPath);
}




 ?>
