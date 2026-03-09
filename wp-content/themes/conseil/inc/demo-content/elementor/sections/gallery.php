<?php



function pix_elementor_templates_gallery(){
    $thumbPath = 'https://wordpress.assets.pixfort.com/conseil/library/sections/gallery/';
    
    $templatesList = [

        ['demo_name' => 'Consulting', 'title' => 'Case Studies Gallery', 'categories' => ['gallery', 'content']],

        ['demo_name' => 'Digital Agency', 'title' => 'Showcase Gallery', 'categories' => ['gallery']],

    ];

    return pix_generate_templates($templatesList, 'gallery', $thumbPath);
}




 ?>
